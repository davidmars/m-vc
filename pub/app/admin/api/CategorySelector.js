CategorySelector={
    dom:$(ModalsManager.CTRL.MODAL_CATEGORIES),
    browseComponent : new ModelBrowser($(ModalsManager.CTRL.MODAL_CATEGORIES)),
    contentRefreshed : false,
    open:function(){
        CategorySelector.dom.modal("show");
        if(CategorySelector.contentRefreshed == false){
            CategorySelector.contentRefreshed = true;
            CategorySelector.refreshContent();
        }
    },    
    close:function(){
        CategorySelector.dom.modal("hide");
    },
    onSelectModel:function(model){
        
    },
    init:function(){
       //select photo
       //au click d'une selection on enregistre le lien pour les refresh (le load ajax se fait via un AttrControler)
       $(ModalsManager.CTRL.MODAL_CATEGORIES + ' a[is-ajax-link="true"][ajax-target]').live("click",function(e){
            var el=$(this);
            CategorySelector.lastUrlContent=el.attr("href");
            e.preventDefault();
        }); 
    },
    /**
     * rafraichit le menu et le contenu
     */
    refresh:function(){
       CategorySelector.refreshContent();  
       CategorySelector.refreshMenu();
    },
    /**
     * rafraichit le menu
     */
    refreshMenu:function(){
        CategorySelector.browseComponent.refreshClassification( );   
    },
    /**
     * rafraichit le contenu
     */
    refreshContent:function(){
        CategorySelector.browseComponent.refresh( );   
    }
}

JQ.bo.on("click", ModalsManager.CTRL.MODAL_CATEGORIES + " ["+ Model.CTRL.DATA_MODEL_TYPE + "='Category'] a[href='"+ModelBrowser.CTRL.MODEL_SELECTOR+"']",function(e){
    e.preventDefault();
    var photo=Model.getParent($(this));
    CategorySelector.onSelectModel(photo); 
})   