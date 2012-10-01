PhotoSelector={
    dom:$(ModalsManager.CTRL.MODAL_PHOTOS),
    browseComponent : new ModelBrowser($(ModalsManager.CTRL.MODAL_PHOTOS)),
    contentRefreshed : false,
    open:function(){
        PhotoSelector.dom.modal("show");
        PhotoSelector.dom.css("z-index",ModalsManager.getNextDepth());
        if(PhotoSelector.contentRefreshed == false){
            PhotoSelector.contentRefreshed = true;
            PhotoSelector.refreshContent();
        }
    },    
    close:function(){
        PhotoSelector.dom.modal("hide");
    },
    onSelectModel:function(model){
        
    },
    init:function(){
       //select photo
       //au click d'une selection on enregistre le lien pour les refresh (le load ajax se fait via un AttrControler)
       $(ModalsManager.CTRL.MODAL_PHOTOS + ' a[is-ajax-link="true"][ajax-target]').live("click",function(e){
            var el=$(this);
            PhotoSelector.lastUrlContent=el.attr("href");
            e.preventDefault();
        }); 
    },
    /**
     * rafraichit le menu et le contenu
     */
    refresh:function(){
       PhotoSelector.refreshContent();  
       PhotoSelector.refreshMenu();
    },
    /**
     * rafraichit le menu
     */
    refreshMenu:function(){
        PhotoSelector.browseComponent.refreshClassification( );   
    },
    /**
     * rafraichit le contenu
     */
    refreshContent:function(){
        PhotoSelector.browseComponent.refresh( ); 
    }
}

JQ.bo.on("click", ModalsManager.CTRL.MODAL_PHOTOS + " ["+ Model.CTRL.DATA_MODEL_TYPE + "='Photo'] a[href='"+ModelBrowser.CTRL.MODEL_SELECTOR+"']",function(e){
    e.preventDefault();
    var photo=Model.getParent($(this));
    PhotoSelector.onSelectModel(photo); 
})

/*------------------------------*/


