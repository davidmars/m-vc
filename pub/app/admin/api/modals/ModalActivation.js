var ModalActivation=function(id, type){
    var me=this;
    //ModalsManager.openEditModal(id, type, ModalActivation.CTRL.TEMPLATE_MODAL);
    ModalsManager.openEditModal(id, type, "v2/modals/modal-activation");
}

ModalActivation.CTRL={
    EDIT:"a[href='#Model.openActivation']",
    TEMPLATE_MODAL : ""
}

JQ.bo.on("click",ModalActivation.CTRL.EDIT,function(e){
    e.preventDefault();
    var elem = $(this);    
    var modelId;
    var modelType;
    if( elem.attr( Model.CTRL.DATA_MODEL_ID ) && elem.attr( Model.CTRL.DATA_MODEL_TYPE ) ) {        
        modelId = elem.attr( Model.CTRL.DATA_MODEL_ID );
        modelType = elem.attr( Model.CTRL.DATA_MODEL_TYPE );        
    } else {
        var model = Model.getParent(elem);
        modelId = model.id();
        modelType = model.type();
        ModalsManager.activeModel = model;
    }
    
    new ModalActivation(modelId, modelType);    
})