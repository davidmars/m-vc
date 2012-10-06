var Api={
    call:function(id,type,datas,onComplete){ 
        console.log("api call");
        datas.theme = "extranet";        
        //var url = ( id != "" && id) ? type + "/" + id : "";
        setTimeout(function(){
            $.ajax({   
                type: "POST",
                url: Config.rootUrl + Config.apiUrl+"/record/" + type + "/" + id,
                data: datas,
                dataType: 'json',
                success:
                function (ajaxReturn){
                    console.log("api call success");
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
    upload:function(oFile,progress,complete,onError){
        // create XMLHttpRequest object, adding few event listeners, and POSTing our data
        var oXHR = new XMLHttpRequest(); 
        var vFD = new FormData();
        
        vFD.append("TheFile",oFile);
        
        oXHR.upload.addEventListener('progress', 
            function(e){
                progress(e.loaded,e.total);
            }, 
            false, false);
            
        oXHR.addEventListener('load', 
            function(e){
                complete(e.target.responseText);
            }, 
            false
        );
            
        oXHR.addEventListener('error', onError, false);
        //oXHR.addEventListener('abort', uploadAbort, false);
        oXHR.open('POST', Config.rootUrl + Config.apiUrl+"/upload");
        oXHR.send(vFD);
        return oXHR;
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
        console.log("processMessage");
        console.log(model);
        console.log(json);
        
        Application.loading(false);
        console.log("1");
        var i;
        if(json.errors && json.errors.length>0){
            for(i=0;i<json.errors.length;i++){
                alert(json.errors[i]);
            }
            model.isLoading(false);
            return;
        }
	console.log("a");

        if(ModalsManager && ModalsManager.activeModel) {
            ModalsManager.activeModel.refresh();
            ModalsManager.activeModel = null;
        }
        console.log("b");
        // if model has attribute DATA_CLOSE_MODAL_AFTER_SAVE == true close this model modal box
        if(model.jq.attr(Model.CTRL.DATA_CLOSE_MODAL_AFTER_SAVE) == "true" ) {
            model.jq.modal("hide");
        }        
         console.log("c");       
        //refresh template
        if(model.avoidRefresh()){
            console.log("We have a template....but avoidRefresh");
        //do nothing on the model 
        }else{
            if( json.success == true && json.template) {
                console.log("We have a template....");
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