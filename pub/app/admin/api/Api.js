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
                    if(typeof(onComplete) == 'function') {
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


        if(ModalsManager && ModalsManager.activeModel) {
            ModalsManager.activeModel.refresh();
            ModalsManager.activeModel = null;
        }

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
    },
    /**
     *
     * @param controller The controller to use to load the view
     * @param onComplete The callback function to perform when the view is loaded.
     * @param datas object to send with the request
     */
    getView:function(controller,datas,onComplete){
        $.ajax({
            type: "POST",
            url:  controller,
            data: datas,
            /*dataType: 'json',*/
            success:
                function (ajaxReturn){
                    if(typeof(onComplete) == 'function') {
                        onComplete(ajaxReturn);
                    }
                }
        });
    }


}
/**
 *
 * @param json a json object return given by the Api
 * @return {Api.JsonReturn}
 * @constructor
 */
Api.JsonReturn=function(json){
    if(json.isYetAnObject){
        return json;
    }
    this.isYetAnObject=true;
    this.success=false;
    this.messages=new Array();
    this.errors=new Array();
    this.redirect="";

    this.success=json.success;
    this.messages=json.messages;
    this.errors=json.errors;
    this.redirect=json.redirect;

}
/**
 *
 * @param json a json object that match with a
 * @param messageContainer
 * @constructor
 */
Api.displayMessages=function(json,messageContainer){
    var me=this;
    var ret=new Api.JsonReturn(json);
    var container=$(messageContainer);
    container.find("*").slideUp(500,function(){$(this).remove()});
    /**
     * return a jquery bootstrap alert component.
     * @param messageType Can be "error" or "success"
     * @param message
     * @return {*|jQuery|HTMLElement}
     */
    var getDisplay=function(messageType,message){
        var type="";
        if(messageType=="error"){
            type="alert-error";
        }else{
            type="alert-success";
        }
        var html="<div class='alert "+type+"'>";
        html+="<button type='button' class='close' data-dismiss='alert'>×</button>";
        html+=message;
        html+="</div>";
        return $(html);
    }

    var i=0;

    for(i=0;i<ret.messages.length;i++){
    container.append(
        getDisplay("success",ret.messages[i])
    );
    }
    for(i=0;i<ret.errors.length;i++){
    container.append(
        getDisplay("error",ret.errors[i])
    );
    }
    container.find("*").slideUp(0);
    container.find("*").slideDown();

}
/**
 *
 * @param newModelType The type of the model to create
 * @param containerModelType The type of the model that will receive the new model
 * @param containerModelId The id of the model that will receive the new model
 * @param containerFieldName  The field name of the model that will receive the new model
 * @constructor
 */
Api.NewChildIn=function(newModelType,containerModelType,containerModelId,containerFieldName){
    var me=this;
    this.events=new EventDispatcher();
    $.ajax({
        type: "POST",
        url: Config.rootUrl +"/admin/api/addNewChild/"+newModelType+"/"+containerModelType+"/"+containerModelId+"/"+containerFieldName,
        data: {},
        dataType: 'json',
        success:
            function (ajaxReturn){
                console.log("Api.Login call success");
                me.events.dispatchEvent("COMPLETE",function(ajaxReturn){
                    console.log(ajaxReturn);
                });
            }
    });
}

/**
 *
 * @param modelType
 * @param modelId
 * @constructor
 */
Api.Delete=function(modelType,modelId){
    var me=this;
    this.events=new EventDispatcher();
    $.ajax({
        type: "POST",
        url: Config.rootUrl +"/admin/api/delete",
        data: {type:modelType,
               id:modelId },
        dataType: 'json',
        success:
            function (ajaxReturn){
                console.log("Api.Login call success");
                me.events.dispatchEvent("COMPLETE", ajaxReturn);
            }
    });
}

/**
 * The Api.Login object send login request, then dispatch events.COMPLETE event.
 * @param email The email used for login.
 * @param password The password used for login.
 * @constructor
 */
Api.Login=function(email,password){
    var me=this;
    this.events=new EventDispatcher();
    $.ajax({
        type: "POST",
        url: Config.rootUrl +"/admin/api/login",
        data: {
            email:email,
            password:password
        },
        dataType: 'json',
        success:
            function (ajaxReturn){
                console.log("Api.Login call success");
                me.events.dispatchEvent("COMPLETE",ajaxReturn);
            }
    });
}
/**
 *
 * @constructor
 */
Api.Logout=function(){
    var me=this;
    this.events=new EventDispatcher();
    $.ajax({
        type: "POST",
        url: Config.rootUrl +"/admin/api/logout",
        data: {},
        dataType: 'json',
        success:
            function (ajaxReturn){
                console.log("Api.Logout call finished");
                me.events.dispatchEvent("COMPLETE",ajaxReturn);
            }
    });
}

JQ.bo.on("click","a[href='#Api.logout()']",function(e){
    e.preventDefault();
    var req=new Api.Logout();
    req.events.addEventListener("COMPLETE",function(){
        document.location=Config.rootUrl+"/admin/admin_model/login";
    })
})



/**
 * An api upload object call the upload service.
 * Its goal is to upload a file to the server and return a field template.
 * So you have to set right parameters.
 * @param modelType String the type of the model where the field is.
 * @param fieldName String the name of the field to associate the uploaded file.
 * @param template String the template path to display.
 * @param oFile File The file to upload, it's an HTML5 File object...oki doki?
 */
Api.Upload=function(modelType,fieldName,template,oFile){
        var me=this;
        /**
         * dispatched when 
         */
        this.onProgress=function(loaded,total){};
        this.onComplete=function(response){};
        this.onError=function(response){};
        
        // create XMLHttpRequest object, adding few event listeners, and POSTing our data
        var oXHR = new XMLHttpRequest(); 
        var vFD = new FormData();
        
        vFD.append("modelType",modelType);
        vFD.append("fieldName",fieldName);
        vFD.append("template",template);
        vFD.append("TheFile",oFile);

        
        oXHR.upload.addEventListener('progress', 
            function(e){
                me.onProgress(e.loaded,e.total);
            }, 
            false, false);
            
        oXHR.addEventListener('load', 
            function(e){
                me.onComplete(e.target.responseText);
            }, 
            false
        );
        oXHR.addEventListener('error', 
            function(e){
                me.onError(e);
            }, 
            false
        );
            
        //oXHR.addEventListener('abort', uploadAbort, false);
        
        oXHR.open('POST', Config.rootUrl + Config.apiUrl+"/upload");
        oXHR.send(vFD);
        
        //return this;
    }