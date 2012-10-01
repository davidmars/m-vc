var EmbedCreator={
    dom:$("#modal-embed"),
    /**
     * ben c'est true si on est passé par init
     */
    isInit:false,
    /**
     * objet DOM de prévisualisation du embed
     */
    preview:null,
    /**
     * champ de saisie de l'embed
     */
    codeInput:null,
    /**
     * code html d'origine du prévisualiseur vide
     */
    emptyPreview:"",
    /**
     * bouton de selection
     */
    btnSelect:null,
    /**
     * ouvrir la fenêtre
     */
    
    open:function(){
	if(!EmbedCreator.isInit){
	    EmbedCreator.init();
	}
	EmbedCreator.reset();
        EmbedCreator.dom.modal("show");
    },
    /**
     * fermer la fenêtre (et la réinitialiser par la même occasion)
     */
    close:function(){
        EmbedCreator.dom.modal("hide");
	EmbedCreator.reset();
    },
    /**
     * fonction à définir depuis la fonction appelante pour récupérer le modèle embed
     */
    onSelect:function(embedDatas){
        
    },
    /**
     * réinitialise la fenêtre comme au début
     */
    reset:function(){
	EmbedCreator.preview.html(EmbedCreator.emptyPreview);
	EmbedCreator.btnSelect.attr("disabled");
	EmbedCreator.btnSelect.addClass("disabled");
    },
    /**
     * initilaise le bordel
     */
    init:function(){
	
	EmbedCreator.codeInput=EmbedCreator.dom.find("[embed-code]");
	EmbedCreator.preview=EmbedCreator.dom.find("[embed-preview]");
	EmbedCreator.btnSelect=EmbedCreator.dom.find("[href='#select']");
	EmbedCreator.emptyPreview=EmbedCreator.preview.html();
	
	EmbedCreator.codeInput.on("change keyup paste",function(){
	  EmbedCreator.preview.html($(this).val());
	  EmbedCreator.formatEmbed();
	  EmbedCreator.btnSelect.removeAttr("disabled");
	  EmbedCreator.btnSelect.removeClass("disabled");
	})
	
	EmbedCreator.btnSelect.on("click",function(e){
	    e.preventDefault();
	    EmbedCreator.onSelect({
		htmlCode:String(EmbedCreator.preview.html())
	    })
	})
	
	EmbedCreator.isInit=true;
    }
    ,
    formatEmbed:function(){
	var codeEmbed=EmbedCreator.preview.find("iframe,object,embed");
	$(codeEmbed).attr('width','100%');
	$(codeEmbed).attr('height','100%');
	$(codeEmbed).attr('wmode','opaque');
	var ifr_source=$(codeEmbed).attr('src');
	var wmode = "wmode=opaque&autohide=1";
	if(ifr_source){
	    if(ifr_source.indexOf('?') != -1) {
		var getQString = ifr_source.split('?');
		var oldString = getQString[1];
		var newString = getQString[0];
		$(codeEmbed).attr('src',newString+'?'+wmode+'&'+oldString);

	    }else{
		$(codeEmbed).attr('src',ifr_source+'?'+wmode);
	    }
	    var src=$(codeEmbed).attr('src');
	    src=src.replace(wmode+"&"+wmode,wmode);
	    $(codeEmbed).attr('src',src);
	}
	EmbedCreator.preview.html("");
	EmbedCreator.preview.append($(codeEmbed)[0]);
    }
}