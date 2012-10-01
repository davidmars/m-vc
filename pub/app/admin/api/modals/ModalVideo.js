var ModalVideo=function(videoId, params){
    var me=this;
    me.onLoad = function(modalDom) {        
        if( params ) {
            if(params.CloseAfterSave == true) {
                modalDom.attr(Model.CTRL.DATA_CLOSE_MODAL_AFTER_SAVE,"true");
            }
        }
    }
    
    ModalsManager.openEditModal(videoId, "Video", ModalVideo.CTRL.TEMPLATE_MODAL, me.onLoad)
}

ModalVideo.CTRL={
    EDIT:"a[href='#ModalVideo.edit']"+",[data-open-on-select='true'] [data-model-type='Video'] [href='#ModelSelector.select']",
    TEMPLATE_MODAL : ""
}

JQ.bo.on("click",ModalVideo.CTRL.EDIT,function(e){
    e.preventDefault();
    var elem = $(this);
    var targetLang = elem.attr("data-target-language")
    if(targetLang){
        Application.setLanguage(targetLang);
    }
    var modelId;
    var modelType;
    if( elem.attr( Model.CTRL.DATA_MODEL_ID ) && elem.attr( Model.CTRL.DATA_MODEL_TYPE ) ) {
        modelId = elem.attr( Model.CTRL.DATA_MODEL_ID );
        modelType = elem.attr( Model.CTRL.DATA_MODEL_TYPE );

    } else {
        var model = Model.getParent(elem);
        modelId = model.id();
        modelType = model.type();
    }
    
    if( typeof(modelId) == "undefined") {
        modelId = "";
    }
    //new ModalVideo(modelId, {"CloseAfterSave" : true});
    new ModalVideo(modelId);
})