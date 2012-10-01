var ModalsManager={
    zIndex:2000,
    getNextDepth:function(){
        return ModalsManager.zIndex++;
    },
    
    openEditModal : function (id, modelType, modelTemplate, onSuccess) {
        Api.getTemplate(id, modelType, modelTemplate, {}, function(ajax){
            var modalDom=$(ajax.template);
            JQ.bo.append(modalDom);
            modalDom.css("z-index", ModalsManager.getNextDepth());        
            modalDom.modal("show");
            Application.initAfterAjax();
            
            if( onSuccess ){
                onSuccess(modalDom);
            }            
        })
    }
}

ModalsManager.activeModel = null;

ModalsManager.CTRL = {
    MODAL_PHOTOS : "#modal-photos",
    MODAL_CATEGORIES : "#modal-categories",
    MODAL_VIDEOS : "#modal-videos",
    MODAL_POSTS : "#modal-posts",    
    MODAL_UPLOAD : "#modal-upload",
    MODAL_GET_LINK:"#modal-get-link"
}