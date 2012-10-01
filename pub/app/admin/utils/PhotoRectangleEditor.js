
PhotoRectangleEditor={
    dom:$("#modal-photo-rectangle-editor"),
    isInit:false,
    /**
     * UI de selection du crop 
     */
    jcrop_api:null,
    /**
     * objet dom de l'image de preview chargée
     */
    image:null,
    content:null,
    /**
     * objet dom associé à la photo
     */ 
    modelPhoto:null,
    /**
     * objet dom associé au rectangle
     */
    modelRectangle:null,
    
    possibleRectangles:null,
    /**
     * ouvre la fenêtre avec la photo et les rectangles souhaités
     * @param modelPhoto Element dom de la photo
     * @param modelRectangle Element dom du rectangle associé à la photo
     * @param possibleRectangles
     */
    open:function(modelPhoto, modelRectangle){
	
	//console.log("PhotoRectangleEditor.open");
	//console.log(modelPhoto);
	//console.log(modelRectangle);
	
	PhotoRectangleEditor.modelPhoto=modelPhoto;
	PhotoRectangleEditor.modelRectangle=modelRectangle;
	
        if(!PhotoRectangleEditor.isInit){
           PhotoRectangleEditor.init(); 
        }
        PhotoRectangleEditor.dom.modal("show");
        //PhotoRectangleEditor.loadPhoto(modelPhoto)
        PhotoRectangleEditor.load()
        
    },
    /**
     * ferme la fenêtre
     */
    close:function(){
        PhotoRectangleEditor.dom.modal("hide");
    },
    /**
     * initialise deux trois conneries sur la fenêtre
     */
    init:function(){
       PhotoRectangleEditor.content=PhotoRectangleEditor.dom.find("[data-ajax-target='true']"); 
    },
    /**
     * charge le contenu de la fenêtre
     */
    load:function(){
       var ici=PhotoRectangleEditor;
       var datas={
           photoId:ModelEdit.id(ici.modelPhoto),
           possiblesRectangles:ModelEdit.getDomValue(ici.modelPhoto, "possiblesRectangles")
       }
       //console.log(datas);
       ici.content.html("");
        $.ajax({
        type: "POST",
        url: Config.rootUrl+"/edit/modal-photo-rectangle/content",
        data: datas
        }).done(function( msg ) {
            ici.content.html(msg)
            ici.image=ici.dom.find(".image-container img");
            /**
            * recherche la meilleure config de rectangle
            */
            var selectBestConfig=function(){
                var found=false;
                var defaultConfig=null;
                var currentRatio=ModelEdit.getDomValue(ici.modelRectangle, "root[definedWidth]")/ModelEdit.getDomValue(ici.modelRectangle, "root[definedHeight]");
                var configs=PhotoRectangleEditor.dom.find('[data-shic-action="PhotoRectangleEditor.selectRectangle"]');
                $.each(configs, function(i,el){
                    var ratio=$(el).data("ratioWidth")/$(el).data("ratioHeight");
                    if(!defaultConfig){
                        defaultConfig=$(el);
                    }
                    if(Math.abs(ratio-currentRatio)<0.01){
                        ici.selectRectangle($(el),ici.modelRectangle);
                        found=true;
                        return false;
                    }
                });
                //sélectionne le premier si rien n'a été trouvé
                if(!found){
                    ici.selectRectangle(defaultConfig); 
                }
            }

            ici.image.on("load",function(){
                //selectione le rectangle approprié dans la liste
                selectBestConfig();
            })
            
            });
    },
    /**
     * décharge la photo et désinitialise le jcrop
     */
    unload:function(){
        if(PhotoRectangleEditor.jcrop_api){
            PhotoRectangleEditor.jcrop_api.destroy();
        }
       PhotoRectangleEditor.content.empty(); 
    },
    /**
     * renvoie les données du rectangle en valeurs relatives (de 0 à 1)
     */
    getRelativeCoords:function(){
	var c=PhotoRectangleEditor.jcrop_api.tellSelect();
        var rect={};
        var img=PhotoRectangleEditor.image; 
       
        //valeurs relatives entre 0 et 1
        rect.x=Utils.rapport( c.x, $(img).width(), 1, 0, 0);
        rect.y=Utils.rapport( c.y, $(img).height(), 1, 0, 0);
        rect.w=Utils.rapport( c.w, $(img).width(), 1, 0, 0);
        rect.h=Utils.rapport( c.h, $(img).height(), 1, 0, 0);
        
	return rect;
    },
     /**
     * selectionne une config de rectangle
     */
    selectRectangle:function(domRectConfig,rectangle){

	
        PhotoRectangleEditor.currentRect=domRectConfig;
	PhotoRectangleEditor.dom.find('[data-shic-action="PhotoRectangleEditor.selectRectangle"]').removeClass("active");
	domRectConfig.addClass("active");
        
        //prépare les valeurs de paramétrage de l'outil de recadrage
        var img=PhotoRectangleEditor.image;      
        if(rectangle){
            //si un rectangle est défini, on part des valeurs relatives de celui-ci.
            var w=ModelEdit.getDomValue(rectangle, "relative[relativeWidth]");
            var h=ModelEdit.getDomValue(rectangle, "relative[relativeHeight]");
            var x=ModelEdit.getDomValue(rectangle, "relative[relativeX]");
            var y=ModelEdit.getDomValue(rectangle, "relative[relativeY]");
            w=w*img.width();
            x=x*img.width();
            h=h*img.height();
            y=y*img.height();
            
        }else{
            //si aucun rectangle n'est défini...
            var w=domRectConfig.data("ratioWidth");
            var h=domRectConfig.data("ratioHeight");
            
            //définit w et h pour que ça rentre
            var maxOut=Math.min($(img).width()-20, $(img).height()-20);
            var maxIn=Math.max(w,h);
            w=Utils.rapport(w, maxIn, maxOut, 0, 0);
            h=Utils.rapport(h, maxIn, maxOut, 0, 0);
            //centre le tout
            var x=Math.floor($(img).width()/2-w/2);
            var y=Math.floor($(img).height()/2-h/2);
        }
        
        
	PhotoRectangleEditor.initCrop(w,h,x,y);
    },
    /**
     * initialise le crop. Les valeurs w, h, x et y sont exprimées en pixel et sont relatives à la photo chargée dans l'interface
     */
    initCrop:function(w,h,x,y){
        
        if(PhotoRectangleEditor.jcrop_api){
            PhotoRectangleEditor.jcrop_api.destroy();
        }
	var img=PhotoRectangleEditor.image;
        var rect={
            x:x,
            y:y,
            width:w,
            height:h
        }

        var options={
            bgColor: '#000',
            bgOpacity:0.3,
            setSelect:   [ rect.x, rect.y, Number(rect.x)+Number(rect.width), Number(rect.y)+Number(rect.height) ],
            aspectRatio: rect.width / rect.height,
            onChange: PhotoRectangleEditor.saveCoords,
            onSelect: PhotoRectangleEditor.saveCoords
        }

        PhotoRectangleEditor.image.Jcrop(options,function(){
            PhotoRectangleEditor.jcrop_api = this;
        });
    },
    /**
     * à définir de l'extérieur
     */
    onSelect:function(modelPhoto,modelRectangle){},
    /**
     * lance onSelect
     */
    returnRectangle:function(){

	var ici=PhotoRectangleEditor;
	var c=ici.getRelativeCoords();
	var currentRect=ici.currentRect;

	ModelEdit.setDomValue(ici.modelRectangle, "root[definedWidth]", currentRect.data("ratioWidth"));
	ModelEdit.setDomValue(ici.modelRectangle, "root[definedHeight]", currentRect.data("ratioHeight"));
	ModelEdit.setDomValue(ici.modelRectangle, "root[name]", currentRect.data("ratioName"));
	ModelEdit.setDomValue(ici.modelRectangle, "relative[relativeX]", c.x);
	ModelEdit.setDomValue(ici.modelRectangle, "relative[relativeY]", c.y);
	ModelEdit.setDomValue(ici.modelRectangle, "relative[relativeWidth]", c.w);
	ModelEdit.setDomValue(ici.modelRectangle, "relative[relativeHeight]", c.h);

	ici.onSelect(
	    ici.modelPhoto,
	    ici.modelRectangle	
	);
    },

    /**
     * Centre la selection sans changer sa taille
     */
    center:function(horizontal,vertical){
	var coords=PhotoRectangleEditor.jcrop_api.tellSelect();
	var img=PhotoRectangleEditor.image;
	var imW=$(img).width();
	var imH=$(img).height();
	var newCoords=[]; 
	if(horizontal){
	   newCoords[0] = imW/2-coords.w/2;
	   newCoords[2] = imW/2+coords.w/2; 
	}else{
	   newCoords[0] = coords.x;
	   newCoords[2] = coords.x2; 
	}
	if(vertical){
	   newCoords[1] = imH/2-coords.h/2;
	   newCoords[3] = imH/2+coords.h/2;  
	}else{
	   newCoords[1] = coords.y;
	   newCoords[3] = coords.y2;
	}
	PhotoRectangleEditor.jcrop_api.animateTo(newCoords);
    }
    
    
}



//selection d'un preset
$("body").on('click','[data-shic-action="PhotoRectangleEditor.selectRectangle"]',function(e){
    var t=$(this);
   PhotoRectangleEditor.selectRectangle(t) 
})

//boutons de centrage
$("body").on('click','[href="#PhotoRectangleEditor.center"]',function(e){
    e.preventDefault();
    PhotoRectangleEditor.center($(this).data("horizontaly"), $(this).data("verticaly"));
})

//boutons de validation
$("body").on('click','[href="#PhotoRectangleEditor.returnRectangle"]',function(e){
    e.preventDefault();
    PhotoRectangleEditor.returnRectangle();
})
