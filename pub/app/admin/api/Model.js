var Model=function(jq){
    /**
     * Model
     */
    var me=this;
    /**
     * the jq dom object of the block
     */
    this.jq=$(jq);
    
    /**
     * the model id
     */
    this.id=function(){
        return me.jq.attr( Model.CTRL.DATA_MODEL_ID );
    }
    /**
     * the model class type
     */
    this.type=function(){
        return me.jq.attr( Model.CTRL.DATA_MODEL_TYPE );
    }
    /**
     * the model template
     */
    this.template=function(){
        return me.jq.attr(Model.CTRL.TEMPLATE);
    }
    /**
     *
     * @return {string} the url of the controller to use to access this model template.
     */
    this.refreshController=function(){
        return me.jq.attr("data-model-refresh-controller");
    }
    /**
     * Help you to know if the refresh actions sould manage an url adress change or not.
     * @return {Boolean} do we need to change the browser url address after refresh?
     */
    this.refreshControllerChangeBrowserUrl=function(){
        console.log("-----------------"+me.jq.attr("data-model-refresh-controller-not-an-url"));
        if(me.jq.attr("data-model-refresh-controller-not-an-url")=="true"){
            return false;
        }else{
            return true;
        }
    }
    /**
     *
     * @return {jquery} the jquery dom element where to load the model
     */
    this.refreshTarget=function(){
        var selector=me.jq.attr("data-model-refresh-target-selector");
        if(!selector){
            return null;
        }
        var target=$(selector);
        if(target.length==1){
            return target;
        }else{
            return null;
        }
    }
    
    /**
     * to define that the model has changed and it needs to be recorded. If the model has a  data-live-save="true" markup, it will be recorded
     */
    this.needToBeRecorded=function(needToBe){	
        //console.log("needToBeRecorded")
        Application.thereIsSomethingToSave(needToBe);   
        
        //if( needToBe == true ) {
        me.jq.attr(Model.CTRL.DATA_NEED_TO_RECORD, needToBe);
        //}
        //console.log("needToBeRecorded");
        if(needToBe){
            //console.log("needToBeRecorded");
            //console.log(me.isAnAssoc());
            if(me.isAnAssoc()){
                //console.log("needToBeRecorded-->assoc is ");
                //console.log(Model.getParent(me.jq));
                Model.getParent(me.jq).needToBeRecorded(true); 
            } 
            
            if (me.isInsideModal() == true){
                //console.log("isInsideModel - yes");
                //console.log(me.isInsideModal());                
                var selector = ModelBrowser.getSelector (me.jq);
                if(selector){
                    setTimeout(selector.refreshMenu,800);
                }
            }
            Utils.blink(me.jq.find(Model.CTRL.SAVE), true, 200);
            if(me.isLiveSave()){
                setTimeout(me.save,500); //to give time to call function to do the job
            }
        }else{
            Utils.blink(me.jq.find(Model.CTRL.SAVE), false, 200);
        }
    }
    /**
     * return true if the model has to be saved on updates
     */
    this.isLiveSave=function(){
        return me.jq.attr(Model.CTRL.LIVE_SAVE);
    }
    this.avoidRefresh=function(){
        return me.jq.attr(Model.CTRL.AVOID_REFRESH);
    }
    /*
     * Ajax Call url to the Api
     */
    this.url = function(){
        return Config.rootUrl + Config.apiUrl + me.type() + "/" + me.id();
    } 
    /**
     * return true if the model.jq exists in the dom
     */
    this.isInDom=function(){
        return(me.jq.parents("body").length>0);
        
    }
    
    /**
     * records the model (and submodels if there is in a Blocks field).
     * @param onComplete:Function the function to call after save. if not set, it will lauch the Api.processMessage function.
     */
    this.save=function(onComplete){
        
        //mandatory fields first
        if(!me.validateFields()){
            alert("Please correct the errors before saving");
            return; 
        }
        
        me.isLoading(true);

        var doTheSave=function(){
            var datas=me.getFieldsData();
            if(datas=="error"){
                me.isLoading(false);
            }
            
            if(!onComplete){
                onComplete=me.onSave;  
            }
            //if this model is also a field we will need to set the variable name of the field	
            datas.context = me.getContext(); 
            //console.log("datas")
            //console.log(datas)
            Api.save(me, datas, onComplete);
            
            if( me.isAnAssoc() == false ) {
                me.afterSave();
            }
        }
        if(me.hasMultipleSave()){
            //console.log("multiple saves")
            me.saveSubmodels(doTheSave); 
        } else {
            //console.log("save alone")
            doTheSave();  
        }
    }
    
    this.duplicateData = function(onComplete){        
        //mandatory fields first
        if(!me.validateFields()){
            alert("Please correct the errors before saving");
            return; 
        }
        
        me.isLoading(true);

        var datas=me.getDuplicateFieldsData();
        if(datas=="error"){
            me.isLoading(false);
        }
        //console.log(datas);	
        if(!onComplete){
            onComplete=me.onSave;  
        }
        //if this model is also a field we will need to set the variable name of the field	
        datas.context = me.getContext();   
            
        datas["modelAction"] = "duplicateData";
        datas["langue"] = Application.langId;
        Api.save(me, datas, onComplete);
    }
    
    /**
     * just refresh the template by calling the api
     */
    this.refresh=function(){
        console.log("in refresh");
        me.isLoading(true);
        Api.getTemplate(me.id(), me.type(), me.template(), me.getContext(), function(j){
            Api.processMessage(j,me)
        })
    }
    
    /**
     * save the models inside this model
     */
    this.saveSubmodels=function(onComplete){
        var onComplete=onComplete;        
        var subModels=me.jq.find("["+Model.CTRL.DATA_FIELD_TYPE+"='Blocks'] [data-model-type]");
        var m;
        var count=0;
        var total=subModels.length;
        
        if( subModels.length > 0) {
            for(var i=0;i<subModels.length;i++){
                m=new Model(subModels[i]);
                                
                var doOnComplete=function(){                    
                    count++;
                    Application.loadingProgress(count, total)
                    
                    if(count>=total){
                        onComplete();
                    }                    
                }
                
                //control sub model if it needs to be record then save
                if( m.jq.attr(Model.CTRL.DATA_NEED_TO_RECORD) == "true" ) {
                    m.save(doOnComplete);
                } else {
                    doOnComplete();
                }
                
            }
        } else {
            onComplete();
        }
    }
    /**
     * return true if before saving we have to save models inside this model.
     */
    this.hasMultipleSave=function(){
        if(me.jq.find("["+Model.CTRL.DATA_FIELD_TYPE+"='Blocks']").length>0){
            return true;
        }else{
            return false;
        }
    }
    /**
     * return context object. It is extra variables to give to the Api. context means $context in php side.
     */
    this.getContext = function () {
        var context={};
        if(me.isAField()){            
            context.dataField=me.jq.attr( Model.CTRL.DATA_FIELD );
        }
        
        var dataIsJson = me.jq.find("[data-json-name='context']");
        if( dataIsJson.length > 0 ) {
            var contextJson = dataIsJson.html();

            var json = jQuery.parseJSON(contextJson);
            $.each(json, function(key, value) {
                context[key] = value;
            });
        }
        return context;
    },
    /**
     * return true if the model is also a field
     */
    this.isAField=function(){
        return me.jq.attr( Model.CTRL.DATA_FIELD )
    }
    /**
     * set a value in the dom for the field defined by variable
     */
    this.setFieldValue=function(variable,value){
        var fieldDom=this.jq.find("["+Model.CTRL.DATA_FIELD+"='"+variable+"']");
       
        if(fieldDom.length>0){
            Fields.setValue(fieldDom,value);
        }else{
            var msg="error cannot find "+variable+" field";
            alert(msg);
            console(msg);
        }
    }
    /**
     * get a value in the dom for the field defined by variable
     */
    this.getFieldValue=function(variable){
	
        var fieldDom=this.jq.find("["+Model.CTRL.DATA_FIELD+"='"+variable+"']");
       
        if(fieldDom.length>0){
            return Fields.getValue(fieldDom);
        }else{
            var msg="error cannot find "+variable+" field";
            alert(msg);
            console(msg);
            return null;
        }
    }
    /**
     * Default save
     */
    this.onSave=function(json){
        Api.processMessage(json, me)
    }
    /**
     * show or hide a loading
     */
    this.isLoading = function (isLoading) {
        Application.loading(isLoading);
    /*var el=$("#application-loading");
        if (isLoading ) {
            //me.jq.css("opacity","0.2");
            el.css("display","block");
        } else {
            //me.jq.css("opacity","1");
            el.css("display","none");  
        }*/
    }
    /**
     * delete the model via the Api
     */
    this.deleteModel = function (){
        console.log("delete model");
        var req = new Api.Delete(me.type(), me.id());
        me.removeDOM();
        Utils.blink(me.jq, true, 1000);
        req.events.addEventListener("COMPLETE", function(json) {
            //console.log("delete model complete");
            me.refreshByController(me.jq);
        });

    }
    
    this.afterDelete = function ( ) {
        switch( me.type() ) {
            case "Photo":
                PhotoSelector.refresh();
                break;
            case "Video":
                VideoSelector.refresh();
                break;
            case "Post":
                Application.gotoUrl( Config.dashboardUrl )
                break;
            case "Tag":
                Application.gotoUrl( Config.dashboardUrl )
                break;                
        }
        
        //Application.updateNav();
        
        if( me.jq.hasClass("modal") == true ) {
            me.jq.modal("hide");
        }
    }
    
    this.afterSave = function ( ) {
        //Application.updateNav();
        
        if( me.jq.attr(Model.CTRL.DATA_NEED_TO_RECORD) == "true" ) {
            me.jq.removeAttr(Model.CTRL.DATA_NEED_TO_RECORD);
        }    
    }
    
    /**
     * so...it removes the model from dom
     */
    this.removeDOM = function ( ) {
        me.jq.hide( 1000,function(){
	  
            if(me.isAnAssoc()){
                Model.getParent(me.jq).needToBeRecorded(true); 
            }
            me.jq.remove(); //remove at the en cause some DOM methods can't work'
        })
    }
    
    /**
     * It works only on DOM and reload empty Template 
     */
    this.removeDatas = function () {
        Api.getTemplate(
            "", 
            me.type(), 
            me.template(), 
            me.getContext(),
            function(json){
                Api.processMessage(json, me);
                me.needToBeRecorded(true);
            });
    }
    /**
     * returns true if the model is a child model of an association (Tag for example)
     */
    this.isAnAssoc=function(){
        var dady=Model.getParent(me.jq);
        if(dady && dady.jq.length && dady.jq.hasClass("list-view-container") == false ){
            return true;
        }else{
            return false;
        }
    /*
        if(me.jq.parents("[data-field][data-childs-types='"+me.type()+"']").length>0){ //typed association
            return true
        }
        if(me.jq.parents(Fields.Blocks.CTRL.FIELD_BLOCKS).length>0){ //blocks association so it can be all kind of model
            return true
        }
        return false;*/
    }
    
    this.isInsideModal = function () {
        return ( me.jq.parents(".modal").length > 0 ) ? true : false;
    }
    
    /**
     * returns an object like that {"modelId":me.id(),"modelType":me.type()}
     */
    this.getMainData=function(){
        return {
            "modelId":me.id(),
            "modelType":me.type()
        }
    }
    /**
     * returns an object containing the model datas from DOM
     */
    this.getFieldsData=function(){
        //console.log("Model.getFieldsData")
        //récupère la valeur des champs dans le modèle
        var fields=me.jq.find("["+Model.CTRL.DATA_FIELD+"]"); //attention mettre un contôlr sur le modèle parent
        var datas={}
        datas.id=me.id();
        datas.type=me.type();
        $.each(fields, function(i,f){
            var field=$(f);
            if(Model.getParent(field).id()==me.id() && Model.getParent(field).type()==me.type()){ // check if this field is not child of an other model
                datas[field.attr( Model.CTRL.DATA_FIELD )]=Fields.getValue(field);
            }
        })
        return datas;
    }
    
    this.getDuplicateFieldsData=function(){
        //console.log("Model.getFieldsData")
        //récupère la valeur des champs dans le modèle
        var fields=me.jq.find("["+ Model.CTRL.DATA_FIELD_DUPLICATE +"]"); //attention mettre un contôlr sur le modèle parent
        var datas={}
        datas.id=me.id();
        datas.type=me.type();
        $.each(fields, function(i,f){
            var field=$(f);
            //console.log(field.attr("data-field"));
            if(Model.getParent(field).id()==me.id() && Model.getParent(field).type()==me.type()){ // check if this field is not child of an other model
                datas[field.attr( Model.CTRL.DATA_FIELD_DUPLICATE )]=Fields.getValue(field);
            //console.log("Field="+field.attr("data-field"))
            }
        })
        return datas;
    }
    
    /**
     * test (mandatory test only for the moment) each fields in the model retunr true if they are valid
     */
    this.validateFields=function(){
        var isValid=true;
        var fields=me.jq.find("["+Model.CTRL.DATA_FIELD+"]");
        $.each(fields, function(i,f){
            var field=$(f);
            if(!Fields.validate(field)){
                isValid=false;
            }
        })
        return isValid;
    }

    this.refreshByController=function(jq){
        var jq=$(jq)
        var urlController;

        var refreshedModel;
        if(jq.attr("data-redirect-controller-after-action")){
            refreshedModel=me;
            urlController=jq.attr("data-redirect-controller-after-action");
            console.log("a");
        }else if(me.refreshController()){
            urlController=me.refreshController();
            refreshedModel=me;
            console.log("b");
            console.log(refreshedModel.type());
            console.log("bbbbb "+refreshedModel.refreshControllerChangeBrowserUrl());
        }else{
            var somewhereElse=jq.closest("[data-model-refresh-controller]");
            refreshedModel=new Model(somewhereElse);
            urlController=refreshedModel.refreshController();
            console.log("c");
        }
        if(!urlController){
            alert("no url controller found for the refresh");
        }else{
            //alert(urlController);
        }
        if(urlController){
            Utils.blink(refreshedModel.jq,true,500);


            Api.getView(urlController,{},refreshedModel.refreshControllerChangeBrowserUrl(),function(response){
                me.needToBeRecorded(false);
                refreshedModel.needToBeRecorded(false);
                if(refreshedModel.refreshTarget()){
                    refreshedModel.refreshTarget().empty()
                    refreshedModel.refreshTarget().append(response);
                }else{
                    refreshedModel.jq.replaceWith(response);
                }
            })
        }
    }


}

Model.CTRL={
    /**
     * save button inside the model
     */
    SAVE:"a[href='#Model.save']",
    DUPLICATE_DATA:"a[href='#Model.duplicateData']",
    /**
     * delete button inside the model
     */
    DELETE:"a[href='#Model.delete']",
    /**
     * set a language and refresh the model
     */
    SET_LANGUAGE:"a[href='#Model.setLanguage']",
    /**
     * remove dom button
     */
    REMOVE_DOM:"a[href='#Model.removeDOM']",
    /**
     * show the preview page
     */ 
    PREVIEW:"a[href='#Model.preview']",
    /**
     * if this attributes is set to true the model will automaticly save itself on changes
     */
    LIVE_SAVE:"data-live-save",
    /**
     * if this attributes is set to true the model will not be refreshed on changes
     */
    AVOID_REFRESH:"data-avoid-refresh",
    /**
     * the path to the template of the model
     */
    TEMPLATE:"data-model-template",
    ACTION_URL:"data-model-action",
    /**
     * the path to the ajax service
     */
    SERVICE_URL:"data-service-url",
    /**
     * the path to the ajax service
     */
    TEMPLATE_MODAL:"data-model-modal-template",
    /**
     * remove assoc button
     */
    REMOVE_DATAS:"a[href='#Model.removeDatas']",
    /*
     * Model Id attribute 
     */    
    DATA_MODEL_ID : "data-model-id",
    /*
     * Model Type attribute 
     */
    DATA_MODEL_TYPE : "data-model-type",
    /*
     * 
     */
    DATA_UPDATE_URL : "data-update-url",    
    DATA_FIELD : "data-field",
    DATA_FIELD_VALUE : "data-field-value",
    DATA_CHILDS_TYPES : "data-childs-types",
    DATA_FIELD_TYPE : "data-field-type",
    DATA_UPDATE_URL : "data-update-url",
    DATA_NEED_TO_RECORD : "data-need-to-record",
    DATA_REDIRECT_URL : "data-redirect-url",
    DATA_FIELD_DUPLICATE : "data-field-duplicate",
    
    /*
     * close modal box when save
     */
    DATA_CLOSE_MODAL_AFTER_SAVE : "data-close-modal-after-save"
}


var refreshTemplate=function(controller){

}

JQ.bo.on("click","a[href='#Model.addNewChild()']",function(e){
    e.preventDefault();
    var elem = $(this)
    var m = Model.getParent( elem );
    var newModelType=elem.attr("data-new-type");
    var fieldTarget=elem.attr("data-new-field-target");
    console.log("we will create a new "+newModelType+" in "+m.type()+" "+m.id()+" in the field: "+fieldTarget);
    var apiCall=new Api.NewChildIn(newModelType, m.type(), m.id(),fieldTarget);

    apiCall.events.addEventListener("COMPLETE",function(){
        m.refreshByController(elem);
    })
})
JQ.bo.on("click","a[href='#Model.previousPosition()'],a[href='#Model.nextPosition()'],",function(e){
    e.preventDefault();
    var elem = $(this);
    var m = Model.getParent( elem );
    var modelContainer= Model.getParent(m.jq);

    //$modelId,$modelType,$containerModelType,$containerModelId,$containerFieldName

    var where;
    if(elem.attr("href")=="#Model.previousPosition()"){
        where="before";
    }else{
        where="after";
    }
    var containerModelType=elem.attr("data-model-target-type");
    var containerModelId=elem.attr("data-model-target-id");
    var containerFieldName=elem.attr("data-model-target-field");

    console.log("we will move "+ m.type()+"/"+ m.id()+" "+where+" in the field: "+containerModelType+"/"+containerModelId+"->"+containerFieldName);

    var apiCall=new Api.AssociationMove(where, m.id(), m.type(), containerModelType,containerModelId,containerFieldName);
    apiCall.events.addEventListener("COMPLETE",function(){
        console.log("------api event after move----------");
        m.refreshByController(elem);
    })
});

JQ.bo.on("click",Model.CTRL.SAVE,function(e){
    e.preventDefault();
    var elem = $(this)
    var m = Model.getParent( elem );

    m.save(function(){
            m.refreshByController(elem);
    })

})

JQ.bo.on("click",Model.CTRL.DELETE,function(e){
    e.preventDefault();
    var deleteButton = $(this);
    if (confirm("Are you want to delete this element ?")) {
        var m=Model.getParent(deleteButton);
        m.deleteModel();
    }
})

JQ.bo.on("click",Model.CTRL.SET_LANGUAGE,function(e){
    e.preventDefault();
    var elem = $(this)
    //alert("Model.CTRL.SET_LANGUAGE");
    Application.setLanguage( new Model(elem).id() );
    var m=Model.getParent(elem);
    m.refresh();
})

JQ.bo.on("click",Model.CTRL.REMOVE_DOM,function(e){
    e.preventDefault();
    var m=Model.getParent($(this));
    m.removeDOM();   
})
JQ.bo.on("click",Model.CTRL.REMOVE_DATAS,function(e){
    e.preventDefault();    
    var m=Model.getParent($(this));
    m.removeDatas();   
})



/**
 * returns a parent Model object relative to the jqery object passed as argument
 * @return Model The model object.
 */
Model.getParent=function(el){
    var m; 
    m=$(el.closest('['+ Model.CTRL.DATA_MODEL_TYPE +']'));
    
    if(m.attr( Model.CTRL.DATA_MODEL_ID ) == el.attr( Model.CTRL.DATA_MODEL_ID ) && m.attr( Model.CTRL.TEMPLATE ) == el.attr( Model.CTRL.TEMPLATE )){ 
        m=$(el.parent().closest('['+ Model.CTRL.DATA_MODEL_TYPE +']'));
    }
    
    
    return new Model(m);
}