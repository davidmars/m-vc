PostSelector={
    dom:$(ModalsManager.CTRL.MODAL_POSTS),
    browseComponent : new ModelBrowser($(ModalsManager.CTRL.MODAL_POSTS)),
    contentRefreshed : false,
    open:function(){        
        PostSelector.dom.modal("show");
        if(PostSelector.contentRefreshed == false){
            PostSelector.contentRefreshed = true;
            PostSelector.refreshContent();
        }
    },    
    close:function(){
        PostSelector.dom.modal("hide");
    },
    onSelectModel:function(model){
        
    },
    init:function(){
       //select photo
       //au click d'une selection on enregistre le lien pour les refresh (le load ajax se fait via un AttrControler)
       $( ModalsManager.CTRL.MODAL_POSTS +' a[is-ajax-link="true"][ajax-target]').live("click",function(e){
            var el=$(this);
            PostSelector.lastUrlContent=el.attr("href");
            e.preventDefault();
        }); 
    },
    /**
     * rafraichit le menu et le contenu
     */
    refresh:function(){
       PostSelector.refreshContent();  
       PostSelector.refreshMenu();
    },
    /**
     * rafraichit le menu
     */
    refreshMenu:function(){
        PostSelector.browseComponent.refreshClassification( );   
    },
    /**
     * rafraichit le contenu
     */
    refreshContent:function(){
        PostSelector.browseComponent.refresh( );   
    }
}

JQ.bo.on("click", ModalsManager.CTRL.MODAL_POSTS + " ["+ Model.CTRL.DATA_MODEL_TYPE + "='Post'] a[href='"+ModelBrowser.CTRL.MODEL_SELECTOR+"']",function(e){
    e.preventDefault();
    var photo=Model.getParent($(this));
    PostSelector.onSelectModel(photo); 
})   