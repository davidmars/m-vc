var Api={
    call:function(id,type,datas,onComplete){ 
        datas.theme = "extranet";        
        //var url = ( id != "" && id) ? type + "/" + id : "";
        setTimeout(function(){
            $.ajax({   
                type: "POST",
                url: Config.rootUrl + Config.apiUrl + type + "/" + id,
                data: datas,
                dataType: 'json',
                success:
                function (ajaxReturn){
                    Application.checkLogin(ajaxReturn);
                    Application.updateNav();
                    if(typeof onComplete == 'function') {
                        onComplete (ajaxReturn);
                    }
                }                    
            });
        },500);
    //console.log('refresh')
    },
    save:function(model,datas,onComplete){
        datas.template = model.template();
        
        if(model.jq.attr(Model.CTRL.ACTION_URL) && model.id() != "new") {
            datas.actions = "extranet";
            datas.action = model.jq.attr(Model.CTRL.ACTION_URL);
        }

        Api.call(model.id(), model.type(), datas, onComplete);
    },
    deleteModel:function(model,onSave){        
        Api.call(model.id(), model.type(), {
            "root[modelAction]" : "delete", 
            "template": "v2", 
            "handler" : "ExtranetHandler"
        }, onSave);
    },
    updateOrder : function (m, onComplete) {
        var datas={};
        //console.log("updateOrder");
        
        m.save();
        
    /*datas = Fields.getModelsValues( m.jq.find("[data-model-type]") )
        console.log(datas)
        console.log(m.getFieldsData())
    
    
        //var data = $(this).sortable("serialize");        
        
        $.ajax({   
            type: "POST",
            //url: Config.rootUrl + Config.apiUrl + m.jq.attr( Model.CTRL.DATA_UPDATE_URL ),
            url: Config.rootUrl + Config.apiUrl ,
            data: datas,
            success:onComplete
        });*/
    },
    processMessage:function(json,model) {
        //console.log("processMessage")
        Application.loading(false);
        var i;
        if(json.errors){
            for(i=0;i<json.errors.length;i++){
                alert(json.errors[i]);
            }
            model.isLoading(false);
            return;
        }
	
        if(json.logs){
            for(i=0;i<json.logs.length;i++){
                //console.log(json.logs[i]);
                }
        }
        
        if(ModalsManager.activeModel) {
            ModalsManager.activeModel.refresh();
            ModalsManager.activeModel = null;
        }
        
        // if model has attribute DATA_CLOSE_MODAL_AFTER_SAVE == true close this model modal box
        if(model.jq.attr(Model.CTRL.DATA_CLOSE_MODAL_AFTER_SAVE) == "true" ) {
            model.jq.modal("hide");
        }        
                
        //refresh template
        if(model.avoidRefresh()){
        //do nothing on the model 
        }else{
            if( json.success == true && json.template) {
                var newDom = new $(json.template);
                var redirectUrl = newDom.attr( Model.CTRL.DATA_REDIRECT_URL );                
                if( redirectUrl && newDom.attr( Model.CTRL.DATA_MODEL_ID ) != model.id() && model.id() == "new" ) {
                    // reset need to be recorded for redirection
                    model.needToBeRecorded(false);
                    Application.gotoUrl(redirectUrl);
                }
                
                ModelBrowser.refreshModal( model.type() );                
                
                Application.initBeforeAjax();
                // in modal box we lost modal object because of that update only content
                if( model.type() == "Photo" || model.type() == "Video" ) {
                    model.jq.html("");
                    model.jq.html(newDom.html());
                    if(  model.id() == "new" ) {
                        model.jq.attr(Model.CTRL.DATA_MODEL_ID, newDom.attr( Model.CTRL.DATA_MODEL_ID) ); 
                    }                    
                    model.jq.append(newDom.filter('script'));                    
                } else {
                    //reset some stuffff....                
                    model.jq.replaceWith(newDom);
                    model.jq=newDom; //jq in the model is different now, it can be an other id for exemple.
                //console.log("refresh"); 
                }                
                
                Application.initAfterAjax(model.jq);                
            }
        }
        model.isLoading(false);
        model.needToBeRecorded(false);
    },
    /**
     * use the php Api to return a template
     * @param id:String id of the model
     * @param type:String type of the model
     * @param template:String the path to the template
     * @param context:Object list of variables and values to render the template
     * @param onComplete:Function the function to call Api returns
     */
    getTemplate:function(id,type,template,context,onComplete){
        Api.call(id,type,{
            template:template,
            context:context
        },onComplete
        )
    }    
}