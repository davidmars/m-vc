var ModalPhoto=function(photoId, params){
    var me=this;
    me.onLoad = function(modalDom) {        
        if( params ) {
            if(params.CloseAfterSave == true) {
                modalDom.attr(Model.CTRL.DATA_CLOSE_MODAL_AFTER_SAVE,"true");
            }
        }
    }
    
    //console.log("new ModalPhoto --> photo id = "+photoId);    
    ModalsManager.openEditModal(photoId, "Photo", ModalPhoto.CTRL.TEMPLATE_MODAL, me.onLoad);    
}

ModalPhoto.CTRL={
    /**
     * liens d'édition d'une photo
     */
    EDIT:"a[href='#ModalPhoto.edit']"+",[data-open-on-select='true'] [data-model-type='Photo'] [href='#ModelSelector.select']",
    /**
     * ce template n'a rien à faire ici !
     */
    TEMPLATE_MODAL : ""

}

JQ.bo.on("click",ModalPhoto.CTRL.EDIT,function(e){
    e.preventDefault();
    var elem = $(this);
    var modelId;
    //var modelType;
    if( elem.attr( Model.CTRL.DATA_MODEL_ID ) && elem.attr( Model.CTRL.DATA_MODEL_TYPE ) ) {        
        modelId = elem.attr( Model.CTRL.DATA_MODEL_ID );
        //modelType = $(this).attr( Model.CTRL.DATA_MODEL_TYPE );        
    } else {
        var model = Model.getParent(elem);
        modelId = model.id();
        //modelType = model.type();
    }
    
    //console.log(modelId)
    //new ModalPhoto(modelId, {"CloseAfterSave" : true});
    new ModalPhoto(modelId);
})