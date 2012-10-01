var ModalPhotoRectangle={
    jq:$("#ModalPhotoRectangle"),
    ajaxTarget:$("#ModalPhotoRectangle-content"),
    image:null,
    realImage:null,
    zoomable:null,
    zoom:100,
    model:null,
    mainModel:null,
    container:null,
    previewContainer:null,
    area:null,
    progressBar:null,
    zoomLevel:null,
    smallPreview:null,
    zoomOut:null,
    zoomIn:null,
    myInterval:null,
    /**
     * open the window and load the stuff
     */
    open:function(PhotoRectangleModel,mainModel){
        ModalPhotoRectangle.jq.modal("show");
        $("#progressBar").css("display", "block");        
        //$("#zoomLevel").text("100%");
        ModalPhotoRectangle.jq.css("z-index",ModalsManager.getNextDepth());
        ModalPhotoRectangle.load(PhotoRectangleModel,mainModel);
    },
    /**
     * hide the window
     */
    close:function(){   
        Crop.setZoom(100);
        ModalPhotoRectangle.jq.modal("hide");
        Crop.destroy();
    },
    /**
     * load the good photo rectangle and the good config rectangles
     */
    load:function(PhotoRectangleModel,mainModel){
        
        //ModalPhotoRectangle.ajaxTarget.css("visibility","hidden");
        
        ModalPhotoRectangle.ajaxTarget.empty();
        ModalPhotoRectangle.model=PhotoRectangleModel;
        Api.getTemplate(
            PhotoRectangleModel.id(), 
            PhotoRectangleModel.type(), 
            "v2/modals/photo-rectangle/content", 
            {
                parentModelType:mainModel.type(),
                field:PhotoRectangleModel.jq.data("field")
                }, 
            function(json){
                ModalPhotoRectangle.zoom=100;            
                ModalPhotoRectangle.ajaxTarget.html(json.template);
                ModalPhotoRectangle.image=$("#crop-me-baby");
                ModalPhotoRectangle.realImage=$("#crop-preview");            
                ModalPhotoRectangle.container=$("#crop-container");
                ModalPhotoRectangle.previewContainer=$("#crop-preview-container");
                ModalPhotoRectangle.area=$("#crop-area");
                ModalPhotoRectangle.progressBar=$("#progressBar");
                ModalPhotoRectangle.zoomLevel=$("#zoomLevel");
                ModalPhotoRectangle.smallPreview=$("#test-crop");
                ModalPhotoRectangle.zoomOut=$("#zoomOut");
                ModalPhotoRectangle.zoomIn=$("#zoomIn");      
            

                ModalPhotoRectangle.zoomOut.mousedown(function() {
                    ModalPhotoRectangle.zoomBy(-5);
                    ModalPhotoRectangle.myInterval=setInterval(function(){
                        ModalPhotoRectangle.zoomBy(-5);
                    },50);
                });
                ModalPhotoRectangle.zoomOut.mouseup(function() {

                    clearInterval(ModalPhotoRectangle.myInterval);
                });
             
                ModalPhotoRectangle.zoomIn.mousedown(function() {
                    ModalPhotoRectangle.zoomBy(5);
                    ModalPhotoRectangle.myInterval=setInterval(function(){
                        ModalPhotoRectangle.zoomBy(5);
                    },50);
                });
                ModalPhotoRectangle.zoomIn.mouseup(function() {

                    clearInterval(ModalPhotoRectangle.myInterval);
                });
            
                //quand la photo est chargée           
                ModalPhotoRectangle.realImage.load(function(){
                    $("#progressBar").css("display", "none");
                    //ModalPhotoRectangle.ajaxTarget.css("visibility","visible");
                    Crop.init(               
                        ModalPhotoRectangle.image,
                        ModalPhotoRectangle.realImage
                        );
                })
            
            })
    },
    /**
     * called by the user when validate the job
     */
    onSave:function(x,y,width,height){},
    _save:function(){
        ModalPhotoRectangle.close();
        ModalPhotoRectangle.onSave(Crop.values.x,Crop.values.y,Crop.values.w,Crop.values.h,Crop.ratioW,Crop.ratioH);
    },
    /**
     * performs a zoom in or zoom out depending if z is positive or negative.
     * @param z Number the zoom increment to apply to the current zoom value (eg -5 or 5)
     */
    zoomBy:function(z){
        //console.log("zoomBy with z = " + z);
        if(ModalPhotoRectangle.zoom<=10 && z<0){
            return;
        }                   
        
        ModalPhotoRectangle.zoom+=z;
        Crop.setZoom(ModalPhotoRectangle.zoom)
    }
}
ModalPhotoRectangle.CTRL={
    /**
     * Save the current rectangle config
     **/
    SAVE:"a[href='#ModalPhotoRectangle.save']",
    ZOOM_IN:"a[href='#ModalPhotoRectangle.zoomIn']",
    ZOOM_OUT:"a[href='#ModalPhotoRectangle.zoomOut']",
    SET_RECTANGLE:"[data-set-rectangle]"
}

JQ.bo.on("click",ModalPhotoRectangle.CTRL.ZOOM_IN,function(e){
    e.preventDefault();
    ModalPhotoRectangle.zoomBy(5);
})
JQ.bo.on("click",ModalPhotoRectangle.CTRL.SAVE,function(e){
    e.preventDefault();
    ModalPhotoRectangle._save(5);
})
JQ.bo.on("click",ModalPhotoRectangle.CTRL.ZOOM_OUT,function(e){
    e.preventDefault();
    ModalPhotoRectangle.zoomBy(-5);
})
ModalPhotoRectangle.jq.on("click",ModalPhotoRectangle.CTRL.SET_RECTANGLE,function(e){
    e.preventDefault();
    var btn=$(this);
    Crop.setRectangle(btn.data("rectWidth"),btn.data("rectHeight"));
})


var Crop={
    /**
     * This object contains x,y,w,h,originalW,originalH coordinates of the rectangle in 0 to 1 range. This is the values like they are recorded in the database. 
     */
    values:{},
    /**
     * the background image (transparent) used by jcrop.
     */
    img:null,
    /**
     * the real image from the Photo model (not the one that refers to jcrop)
     */
    realImg:null,
    /**
     * well, the jcrop api :)
     */
    jcrop_api:null,
    /**
     * real image width in pixels
     */
    realImgW:null,
    /**
     * real image height in pixels
     */    
    realImgH:null,
    /**
     * real image left coordinate in pixels
     */
    realImgX:null,
    /**
     * real image to coordinate in pixels
     */
    realImgY:null,
    /**
     * preview container width in pixels
     */
    previewContainerW:null,
    /**
     * preview container height in pixels
     */
    previewContainerH:null,    
    /**
     * preview container to coordinate in pixels
     */
    previewContainerX:null,
    /**
     * preview container to coordinate in pixels
     */
    previewContainerY:null,
    /**
     * background width in pixels
     */    
    imgW:null,
    /**
     * background height in pixels
     */
    imgH:null, 
    /**
     * save initial ratio
     */
    initRatio:null, 
    /**
     * save initial ratio W
     */
    ratioW:null, 
    /**
     * save initial ratio H
     */
    ratioH:null, 
    /*
     * saved values for auto set rectangle
     */        
    saveValues:{},
        
    
    destroy:function(){
        Crop.realImg = null;
        Crop.img = null;
        Crop.imgH=null;
        Crop.imgW=null;

        Crop.realImg=null;
        Crop.realImgH=null;
        Crop.realImgW=null;
        Crop.realImgX=null;
        Crop.realImgY=null;
        
        Crop.previewContainerW=null;
        Crop.previewContainerH=null;
        Crop.previewContainerX=null;
        Crop.previewContainerY=null;        
              
        
        if(Crop.jcrop_api){
            Crop.jcrop_api.destroy();
        }  
    },
        
    init:function(img,realImg){
        Crop.destroy();
        
        Crop.img=img;
        Crop.realImg=realImg;

        
        Crop.updateDimensions();        
       
        Crop.values.w=ModalPhotoRectangle.model.getFieldValue("root[width]");
        Crop.values.h=ModalPhotoRectangle.model.getFieldValue("root[height]");
        Crop.values.x=ModalPhotoRectangle.model.getFieldValue("root[x]");
        Crop.values.y=ModalPhotoRectangle.model.getFieldValue("root[y]");
        Crop.values.originalWidth=ModalPhotoRectangle.model.getFieldValue("root[originalWidth]");
        Crop.values.originalHeight=ModalPhotoRectangle.model.getFieldValue("root[originalHeight]");
        
        Crop.saveValues.w = Crop.values.w;
        Crop.saveValues.h = Crop.values.h;
        Crop.saveValues.x = Crop.values.x;
        Crop.saveValues.y = Crop.values.y;
        Crop.saveValues.originalWidth = Crop.values.originalWidth;
        Crop.saveValues.originalHeight = Crop.values.originalHeight;
        
        Crop.ratioW = parseInt(Crop.values.originalWidth);
        Crop.ratioH = parseInt(Crop.values.originalHeight);
            
        var rect=Crop.getValuesInPx();          
               
        var options={
            bgColor: '#00ff0000',
            bgOpacity:1,
            setSelect:   [ rect.x, rect.y, rect.x2,rect.y2 ],
            aspectRatio: rect.w / rect.h,
            onChange: Crop.onChange,
            onSelect: Crop.onSelect,
            onRelease: Crop.onRelease
        }
                
                           
        Crop.img.Jcrop(options,function(){
            Crop.jcrop_api = this;
            Crop.initRatio = rect.w / rect.h;
            Crop.initZoom();
            Crop.centerImage();	     
            
            //if it's first time 
            /*
             * w:1, h:1, x:0, y:0, originalWidth:1, originalHeight:1
             */
            if ((Crop.saveValues.x == 0) && (Crop.saveValues.y == 0) &&
                (Crop.saveValues.w == 1) && (Crop.saveValues.h == 1) &&
                (Crop.saveValues.originalHeight == 1) && (Crop.saveValues.originalWidth == 1)) {
                Crop.setRectangle(16, 9);                
            }
        });         
  
    },
    /**
     * init the scale and the zoom for big background
     * readapt the zoom to show the best view of the picture at the init
     */
    initZoom:function(){
        //console.log("initZoom");
        var c = ModalPhotoRectangle.container;

        var imgWidth = Crop.realImgW;
        var imgHeight = Crop.realImgH;
        var containerWidth = c.width();
        var containerHeight = c.height();
  
        if (imgWidth > containerWidth || imgHeight > containerHeight) {
            var ratioWidth = imgWidth / containerWidth;
            var ratioHeight = imgHeight / containerHeight;
            
            if (ratioWidth > ratioHeight)               
                ModalPhotoRectangle.zoomBy(-5 * ratioWidth);
            else
                ModalPhotoRectangle.zoomBy(-5 * ratioHeight);
        } 

        c.scrollTop ((c[0].scrollHeight / 2) - (c.height() / 2));
        c.scrollLeft((c[0].scrollWidth / 2) - (c.width() / 2));       
    },
    /* 
     * set the zoom to z 
     */ 
    setZoom:function(z){
        //console.log("setZoom");
        ModalPhotoRectangle.zoom=(z);                    

        ModalPhotoRectangle.zoomLevel.text(String(z) + "%");

        //css stuff        
        ModalPhotoRectangle.previewContainer.css("width",String(ModalPhotoRectangle.zoom)+"%");
        ModalPhotoRectangle.previewContainer.css("height",String(ModalPhotoRectangle.zoom)+"%");
        //re-center the image
        Crop.centerImage();
        //re apply the values on the new UI size
        Crop.applyValues();
    },
    /**
     * apply a config ratio
     */
    setRectangle:function(w,h){
        //console.log("setRectangle "+w+"-"+h);        
        Crop.jcrop_api.destroy();
        Crop.centerImage();
        var options={
            bgColor: '#00ff0000',
            bgOpacity:1,
            setSelect:   [ Crop.realImgX, Crop.realImgY,Crop.realImgX+Crop.realImgW/2 ],
            aspectRatio: w / h,
            onChange: Crop.onChange,
            onSelect: Crop.onSelect,
            onRelease: Crop.onRelease
        }
        Crop.img.Jcrop(options,function(){
            Crop.jcrop_api = this;
            Crop.initRatio = w / h;
            Crop.ratioW = w;
            Crop.ratioH = h;
            //console.log("Crop re ready");
            Crop.updateValues();
            Crop.fitToNoBorder();
        });
    },
    /*
     * show a dynamic preview of the croop
     */
    showPreview: function (coords){        
        /* the width and the height of current crop rectangle selection */ 
        var cropRectWidth = coords.w;
        var cropRectHeight = coords.h;
        
        var divW = Crop.ratioW;
        var divH = Crop.ratioH;
        
        switch(divW) {
            case 16:
                divW = 200;
                break;
            case 9:
                divW = 120;
                break;
            case 4:
                divW = 200;
                break;      
            case 3:
                divW = 150;
                break;
            case 1:
                divW = 200;
                break;
        }
        
        switch(divH) {
            case 16:
                divH = 200;
                break;
            case 9:
                divH = 120;
                break;
            case 4:
                divH = 200;
                break;      
            case 3:
                divH = 150;
                break;
            case 1:
                divH = 200;
                break;
        }        
                
        ModalPhotoRectangle.smallPreview.css("width", String(divW) + "px");
        ModalPhotoRectangle.smallPreview.css("height", String(divH) + "px");
        
        var rx = divW / cropRectWidth;
        var ry = divH / cropRectHeight;
                         
               
        var nw = Math.round(rx * (Crop.realImgW));
        var nh = Math.round(ry * (Crop.realImgH));
                
        var ml = Math.round(rx * (Crop.realImgX - coords.x));
        var mt = Math.round(ry * (Crop.realImgY -  coords.y));
                
        $('#crop-mini-preview').css({
            width: nw + 'px',
            height: nh + 'px',
            marginLeft: ml + 'px',
            marginTop: mt  + 'px'
        });
    },
    /**
     * called when user interacts with the module
     */
    onChange:function(c){
        //console.log("onChange");
        Crop.updateValues();   
        
        Crop.checkWidth();
        Crop.showPreview(c);
    },
    /**
     * called when user interacts with the module
     */
    onSelect:function(c){
    //console.log("onSelect");
    },
    /**
     * called when user interacts with the module
     */
    onRelease:function(c){
    //console.log("onRelease");
    },
    /**
     * update Crop.values object (0 to 1 values). There is no effect on the UI.
     * This values are values like it is in the database.
     */
    updateValues:function(){
        //console.log("updateValues");
        if(!Crop.jcrop_api){
            return; 
        }
        var c=Crop.jcrop_api.tellSelect()
        //real image's coords
        var maxW=Crop.realImgW;
        var maxH=Crop.realImgH;
        var minX=Crop.realImgX;
        var maxX=minX+maxW;
        var minY=Crop.realImgY;
        var maxY=minY+maxH;
        
        //calculates x,y,w,h ( 0 to 1 values) 
        var w=Utils.rapport(c.w, maxW, 1, 0, 0);
        var h=Utils.rapport(c.h, maxH, 1, 0, 0);
        var x=Utils.rapport(c.x, maxX, 1, minX, 0);
        var y=Utils.rapport(c.y, maxY, 1, minY, 0);                
        
        Crop.values={
            x:x,
            y:y,
            w:w,
            h:h
        }  
    },
    /**
     * convert Crop.values in pixel values for jcrop and returns the object.
     */
    getValuesInPx:function(){
        //console.log("getValuesInPx");
        var c={};

        c.x=Utils.rapport(Crop.values.x, 1,Crop.imgW/2+Crop.realImgW/2, 0, Crop.imgW/2-Crop.realImgW/2);
        c.y=Utils.rapport(Crop.values.y, 1,Crop.imgH/2+Crop.realImgH/2, 0, Crop.imgH/2-Crop.realImgH/2);
        c.x2=c.x+Utils.rapport(Crop.values.w, 1,Crop.realImgW, 0, 0);
        c.y2=c.y+Utils.rapport(Crop.values.h, 1,Crop.realImgH, 0, 0);
        c.w=c.x2-c.x;
        c.h=c.y2-c.y;
        
        
        //console.log(c);
        
        return c;
    },   
    /**
     * Use Crop.values to change the rectangle UI
     */
    applyValues:function(){
        //console.log("applyValues");
        if(!Crop.jcrop_api){
            return; 
        }         
        
        var c=Crop.getValuesInPx(); 

        Crop.jcrop_api.setSelect([c.x,c.y,c.x2,c.y2]);
    },
    /**
     * Update the Crop.imgW, Crop.realImgX, etc... values refering to the dom.
     * Theses values are in pixel and will depend on the zoom, image size etc, so we have to call this function after each change on the tool dom.
     */
    updateDimensions:function(){
        //console.log("updateDimensions");
        Crop.imgW=Crop.img.width();
        Crop.imgH=Crop.img.height();
        
        Crop.realImgW=Crop.realImg.width();
        Crop.realImgH=Crop.realImg.height(); 

        Crop.realImgX=Crop.imgW/2-Crop.realImgW/2;
        Crop.realImgY=Crop.imgH/2-Crop.realImgH/2;
        
        Crop.previewContainerW = ModalPhotoRectangle.previewContainer.width();
        Crop.previewContainerH = ModalPhotoRectangle.previewContainer.height();
        
        Crop.previewContainerX = Crop.imgW/2-Crop.previewContainerW/2;
        Crop.previewContainerY = Crop.imgW/2-Crop.previewContainerH/2;
    },   
    /**
     * check the width of the croping for warning
     */
    checkWidth:function(){        
        var rect = Crop.getValuesInPx();
        
        var limitWidth = (960 * ModalPhotoRectangle.zoom) / 100;
        //console.log(limitWidth);
        
        if (rect.w < limitWidth)
            $("#warningSize").css("display", "block");
        else
            $("#warningSize").css("display", "none");
    },    
    /**
     * Center the real image in the background img...caution: here we are dealing with the latout not the selection.
     */
    centerImage:function(){  
        //console.log("centerImage");
        Crop.updateDimensions();
        
        ModalPhotoRectangle.previewContainer.css("left",Crop.realImgX); 
        ModalPhotoRectangle.previewContainer.css("top",Crop.realImgY);         
    },
    /**
     * Center the real image in the background img...caution: here we are dealing with the latout not the selection.
     */
    centerOnPicture:function(){  
        //console.log("centerOnPicture");
        var coords = Crop.jcrop_api.tellSelect(); 
        coords = Resizer.center(coords);
           
        Crop.jcrop_api.animateTo([coords.x,coords.y,coords.x2,coords.y2]);
        Crop.updateValues();        
    },
    /**
     * center the selection in the x axis image
     */
    centerHorizontal:function(){        
        //console.log("centerHorizontal");
        var coords=Crop.jcrop_api.tellSelect();
        var newCoords=[]; 
        var widthSelect = (coords.x2 - coords.x);

        newCoords[0] = Crop.realImgX + (Crop.realImgW / 2) - (widthSelect / 2);
        newCoords[1] = coords.y;
        newCoords[2] = Crop.realImgX + (Crop.realImgW / 2) + (widthSelect / 2);
        newCoords[3] = coords.y2;
        Crop.jcrop_api.animateTo(newCoords);          
    },
    /**
     * center the selection in the y axis image
     */
    centerVertical:function(){
        //console.log("centerVertical");
        var coords=Crop.jcrop_api.tellSelect();
        var newCoords=[]; 
        var heightSelect = (coords.y2 - coords.y);
        
        newCoords[0] = coords.x;
        newCoords[1] = Crop.realImgY + (Crop.realImgH / 2) - (heightSelect / 2);       
        newCoords[2] = coords.x2;
        newCoords[3] = Crop.realImgY + (Crop.realImgH / 2) + (heightSelect / 2);
        Crop.jcrop_api.animateTo(newCoords); 
    },
    /**
     * the selection will have the same width as the image
     */
    fitToWidth:function(){      
        //console.log("fitToWidth");    

        var coords = Crop.jcrop_api.tellSelect(); 
        coords = Resizer.fitToWidth(coords);
           
        Crop.jcrop_api.animateTo([coords.x,coords.y,coords.x2,coords.y2]);
        Crop.updateValues();
        
    },
    /**
     * the selection will have the same height as the image
     */
    fitToHeight:function(){       
        //console.log("fitToHeight");
                     
        var coords = Crop.jcrop_api.tellSelect(); 
        coords = Resizer.fitToHeight(coords);
           
        Crop.jcrop_api.animateTo([coords.x,coords.y,coords.x2,coords.y2]);
        Crop.updateValues();
    },   
    /**
     * the selection will show the entire image. depending ratios of the selection and of the image, the selection will have the same width or height
     */  
    fitToShowAll:function(){
        //console.log("fitToShowAll"); 
               
        var coords = Crop.jcrop_api.tellSelect(); 
        var widthSelect = coords.x2 - coords.x;
        var heightSelect = (coords.y2 - coords.y);
                
        // if rect width > rect height, rect is landscape 
        if (widthSelect >= heightSelect) {                
            coords = Resizer.fitToWidth(coords);
            coords = Resizer.fitToHeight(coords);
        }
        // if rect width < rect height, rect is portrait
        else {
            coords = Resizer.fitToHeight(coords);
            coords = Resizer.fitToWidth(coords);
        }
        
        coords = Resizer.center(coords);
        Crop.jcrop_api.animateTo([coords.x,coords.y,coords.x2,coords.y2]);
        Crop.updateValues();

    },
    /**
     * the selection will be small than the image, it will not be blank zones. depending ratios of the selection and of the image, the selection will have the same width or height
     */
    fitToNoBorder:function(){
        //console.log("fitToNoBorder");
        
        var coords = Crop.jcrop_api.tellSelect(); 
        var widthSelect = coords.x2 - coords.x;
        var heightSelect = (coords.y2 - coords.y);     
                 
        /* if rect width > rect height, rect is landscape */ 
        if (widthSelect >= heightSelect) {
            coords = Resizer.fitToWidth(coords);
        }
        /* if rect width < rect height, rect is landscape */ 
        else {
            coords = Resizer.fitToHeight(coords);
        }
        
        coords = Resizer.center(coords);
        Crop.jcrop_api.animateTo([coords.x,coords.y,coords.x2,coords.y2]);
        Crop.updateValues();
    } 
}


/** 
 * This object is to calcul the final coords for Crop tools and do just one animation 
 */
var Resizer = {
    /**
     * get the ratio of our current Crop rectangle
     */
    getRatio : function(coords){
        return Math.abs( coords.x - coords.x2 ) / Math.abs( coords.y - coords.y2 );
    },
    /**
     * get the center of the Crop rectangle
     */
    getCenter : function(coords){
        return {
            x : Math.min( coords.x , coords.x2 ) + Math.abs(coords.x2 - coords.x) / 2,
            y : Math.min( coords.y , coords.y2 ) + Math.abs(coords.y2 - coords.y) / 2
        };
    },
    /**
     * get the width and height of our Crop rectangle
     */
    getSize : function(coords){
        return {
            w : Math.abs( coords.x - coords.x2 ),
            h : Math.abs( coords.y - coords.y2 )
        }
    },
    /**
     * get coords of the Crop rectangle by the center and the size
     */
    getCoords : function( center , size ){
        return {
            x : center.x - size.w / 2,
            x2 : center.x + size.w / 2,
            y : center.y - size.h / 2,
            y2 : center.y + size.h  / 2
        };
    },
    /**
     * resizeCoords for the given coords and the chooseen tools
     */
    resizeCoords : function( coords , fun ){
        var size = Resizer.getSize(coords);
        var center = Resizer.getCenter(coords);

        var result = fun( center, size );

        return Resizer.getCoords( result.center , result.size );

    },
    /**
     * calculate the new coords to set the CropRectangle width to the picture width
     */
    fitToWidth : function( coords ){             
        return Resizer.resizeCoords( 
            coords , 
            function(center, size){

                var width = Crop.realImgW;
        
                var r = width / size.w;

                size.w = r * size.w;
                size.h = r * size.h;

                return {
                    size : size,
                    center : center
                };

            }
            );
    },
    /**
     * calculate the new coords to set the CropRectangle height to the picture height
     */
    fitToHeight : function( coords ){
        return Resizer.resizeCoords( 
            coords , 
            function(center, size){

                var height = Crop.realImgH;

                var r = height / size.h;

                size.w = r * size.w;
                size.h = r * size.h;

                return {
                    size : size,
                    center : center
                };

            }
            );
    },
    /**
     * calculate the new coords to move the CropRectangle on the center of the picture
     */
    center: function(coords) {
        var size = Resizer.getSize(coords);
        var center = Resizer.getCenter(coords);
        var height = Crop.realImgH;
        
        center.x = ModalPhotoRectangle.area.width() / 2;
        center.y = ModalPhotoRectangle.area.height() / 2;
        
        coords = Resizer.getCoords(center,size);
        
        return coords;        
    } 
   
}

/*
 * 
 */