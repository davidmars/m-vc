var ModalsManager={
    zIndex:2000,
    getNextDepth:function(){
        return ModalsManager.zIndex++;
    },
    /**
     * display the modal and put it over everything
     */
    overAll:function(modalDom){
        //create the backdrop if there is no
        if(!modalDom.data("backdrop")){
            var b=$("<div class='modal-backdrop'/>");
            modalDom.data("backdrop",b);
        }
        //append elements
        JQ.bo.append(modalDom.data("backdrop"));
        modalDom.css("display","block");
        JQ.bo.append(modalDom);
        //zindexes
        modalDom.data("backdrop").css("z-index",ModalsManager.getNextDepth());
        modalDom.css("z-index",ModalsManager.getNextDepth());

    },
    openEditModal : function (id, modelType, modelTemplate, onSuccess) {
        Api.getTemplate(id, modelType, modelTemplate, {}, function(ajax){
            var modalDom=$(ajax.template);
            JQ.bo.append(modalDom.jq);
            modalDom.css("z-index", ModalsManager.getNextDepth());        
            modalDom.modal("show");
            Application.initAfterAjax();
            
            if( onSuccess ){
                onSuccess(modalDom);
            }            
        })
    },
    /**
     * Loads and open a list of models in a modal
     * @param modelName The model type to load
     * @param onSelected The callback function to perform on selecting a model
     */
    openModelPicker :function(modelName,onSelected){

        var modal=new ModalsManager.Modal("Please select a "+modelName);
        JQ.bo.append(modal.jq);
        modal.show();
        modal.removeAfterClose();

        //select a model in the list
        modal.jq.on("click","[data-model-btn-select]",function(e){

            e.preventDefault();
            var model=Model.getParent($(this));
            onSelected(model);
            modal.close();
        })

        //loads the list
        Api.getView("admin/admin_model/listModels/"+modelName,
            null,
            function(ajaxReturn){
                console.log("now we can inject in the modal");
                modal.setContent(ajaxReturn);
                modal.content.find("[data-model-id='new']").remove();
            }
        );

    },
    /**
     * Modal Objects are modals you can manage with some shortcuts.
     * @param modalTitle {string} The title to give to the modal
     * @constructor
     */
    Modal:function(modalTitle){
        var me=this;
        var html=JQ.bo.find("[data-modals-manager-template]").html();
        this.jq=$(html);
        this.content=me.jq.find(".modal-body");

        /**
         * set the title of the modal
         */
        this.setTitle=function(title){
            me.jq.find("[data-title]").text(title);
        }
        /**
         * inject content inside the modal
         * @param html
         */
        this.setContent=function(html){
            me.content.html(html);
            me.content.removeClass("loading-soft");
        }
        /**
         * show the modal
         */
        this.show=function(){
            ModalsManager.overAll(me.jq);
        }
        /**
         * close the modal
         */
        this.close=function(){
            ModalsManager.close(me.jq);
        }
        /**
         * if this function is called, the modal will be removed from dom after closing.
         */
        this.removeAfterClose=function(){
            me.jq.attr("data-remove-after-hide","true");
        }



        this.setTitle(modalTitle);
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


/*----------------------closing modals-------------------------*/

/**
 * Close the specified modal
 * @param modal
 * @return {*}
 */
ModalsManager.close=function(modal){
    if(!modal){
        return;
    }
    modal=$(modal);
    if(modal.length<=0){
        return;
    }
    //prevent closing not recorded models
    if( modal.attr( Model.CTRL.DATA_NEED_TO_RECORD ) == "true"
        && $(modal).hasClass( "list-view-container" ) == false ) {
        if(!confirm(Application._beforeAjaxPrompt)){
            return false;
        }
    }



    //okay, let's hide'
    modal.css("display","none");
    if(modal.data("backdrop")){
        modal.data("backdrop").remove();
    }

    //if needed remove the modal from dom
    if(modal.attr("data-remove-after-hide") == "true"){
        modal.remove();
        modal=null;
        Application.removeAllToolTip();
    }
}

JQ.bo.on("click","[data-dismiss='modal']",function(e){
    e.preventDefault();
    //e.stopPropagation();
    var m=$(this).closest(".modal");
    ModalsManager.close(m);

})