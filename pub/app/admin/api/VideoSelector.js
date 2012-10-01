VideoSelector = {
    dom : $( ModalsManager.CTRL.MODAL_VIDEOS ),
    browseComponent : new ModelBrowser( $(ModalsManager.CTRL.MODAL_VIDEOS) ),
    contentRefreshed : false,
    open:function(){
        VideoSelector.dom.modal("show");
        VideoSelector.dom.css("z-index",ModalsManager.getNextDepth());
        if(VideoSelector.contentRefreshed == false){
            VideoSelector.contentRefreshed = true;
            VideoSelector.refreshContent();
        }
    },    
    close:function(){
        VideoSelector.dom.modal("hide");
    },
    onSelectModel:function(model){
        
    },
    init:function(){
       //select 
       //au click d'une selection on enregistre le lien pour les refresh (le load ajax se fait via un AttrControler)
       $(ModalsManager.CTRL.MODAL_VIDEOS + ' a[is-ajax-link="true"][ajax-target]').live("click",function(e){
            var el=$(this);
            VideoSelector.lastUrlContent=el.attr("href");
            e.preventDefault();
        }); 
    },
    /**
     * rafraichit le menu et le contenu
     */
    refresh:function(){
       VideoSelector.refreshContent();  
       VideoSelector.refreshMenu();
    },
    /**
     * rafraichit le menu
     */
    refreshMenu:function(){
        VideoSelector.browseComponent.refreshClassification( );   
    },
    /**
     * rafraichit le contenu
     */
    refreshContent:function(){
        VideoSelector.browseComponent.refresh( ); 
    }
}

JQ.bo.on("click", ModalsManager.CTRL.MODAL_VIDEOS + " ["+ Model.CTRL.DATA_MODEL_TYPE + "='Video'] a[href='"+ModelBrowser.CTRL.MODEL_SELECTOR+"']",function(e){
    e.preventDefault();
    //console.log("select video...click");
    var video=Model.getParent($(this));
    VideoSelector.onSelectModel(video); 
})