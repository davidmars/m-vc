/**
 * This is the main Fields object. There is statics methods common to all fields. For specifics fields please have a look to the Fields.SubClasses...
 */
var Fields={ 
    
    /**
     * returns the parent data-field dom element
     */
    getParent:function(jq){
        return(jq.closest("["+ Model.CTRL.DATA_FIELD+"]"))
    },
    
    validate:function(jq){
        var isValid=true;
        if(jq.attr("data-field-mandatory")=="true"){
            jq.find(".control-group").removeClass("error"); //reset field state
            if(!Fields.getValue(jq) || Fields.getValue(jq)=="" || Fields.getValue(jq)==null || Fields.getValue(jq)== 0){
                jq.find(".control-group").addClass("error"); //field error display
                isValid=false;
            }
            
        }

        if(jq.attr("data-validate-special-char") == "true") {
            var val=String(Fields.getValue(jq));
            var newValue = Fields.replaceSpecialVarchar(val);
            if(val!=newValue){
                var inp=jq.find("textarea,input")[0]
                var caret=inp.selectionStart;
                Fields.setValue(jq, newValue);
                inp.setSelectionRange(caret,caret);
            }
        }
        
        return isValid;
    },
    /* delete special var chars*/
    replaceSpecialVarchar: function (val1){
        var reg=/[àäâéèêëïîöôùüûç]/g;
        reg=/[^a-zA-Z0-9 _\-]/g;
        var val = val1.replace(reg,'');
        return val;
    },
    
    /**
     * returns an array of models like that : [{modelId:45,modelType:Tag},{modelId:51,modelType:Tag}].
     * In fact this function is used in associations.
     */
    getModelsValues : function ( list ) {
        if( list.length > 0 ) {
            var arr = [];
            $.each(list, function(i,f){
                arr.push(new Model(f).getMainData());
            })
            return arr;
        } else {
            return null;
        }
    },
    getModelsRadioValues : function ( list ) {
        if( list.length > 0 ) {
            var arr = [];
            $.each(list, function(i,f){                
                var dataModelId = $(f).attr( Model.CTRL.DATA_MODEL_ID );                
                var childsTypes = $(f).attr( Model.CTRL.DATA_CHILDS_TYPES);
                var status =  $(f).closest("["+Model.CTRL.DATA_FIELD+"]").find("[name='"+ childsTypes +"']:radio:checked").val() ;
                arr.push({
                    "modelId":dataModelId,
                    "status":status
                });
            })
            return arr;
        } else {
            return null;
        }
    },
    /**
     * sets a value for the field...only undefined type fields works for the moment 
     */
    setValue:function(jq,value){
        if(jq.attr( Model.CTRL.DATA_FIELD_VALUE ) !== undefined ){
            jq.attr( Model.CTRL.DATA_FIELD_VALUE,value);
        }else if(jq.attr(Model.CTRL.DATA_FIELD_TYPE)=="Text"){
            jq.find("input[type='text'],textarea").val(value)
        }else{
            alert("Field setValue error this kind of field is not yet writable !");
        }
    },
    /**
     * return a value for a field according to its type
     */
    getValue:function(jq){
        var fieldType = jq.attr( Model.CTRL.DATA_FIELD_TYPE );
        
        //udefined types
        if(jq.attr(Model.CTRL.DATA_FIELD_VALUE) !== undefined ){
            return jq.attr(Model.CTRL.DATA_FIELD_VALUE);
        }
        
        switch ( fieldType ) {    
            case "SlideShow":
                //console.log("slideShow");
            break;

            case "PhotoRectangle":
                return jq.attr( Model.CTRL.DATA_MODEL_ID );            

            case "Tags":
                return Fields.getModelsValues( jq.find("["+ Model.CTRL.DATA_MODEL_TYPE + "='Tag']") );
                break;                

            case "Posts":
                return Fields.getModelsValues( jq.find("["+ Model.CTRL.DATA_MODEL_TYPE + "='Post']") );
                break;                

            case "Domains":
                
                return Fields.getModelsRadioValues( jq.find("["+ Model.CTRL.DATA_MODEL_TYPE + "='Domain']") );
                
                var dataChildsTypes = jq.attr( Model.CTRL.DATA_CHILDS_TYPES ); // Domain                
                var dataChilds = jq.find("[data-field-type='"+ dataChildsTypes +"']") ;                
                
                var arr = [];
                $.each(dataChilds, function(i,f){
                    var childsTypes = $(f).attr("data-childs-types");
                    //console.log($(f))
                    //console.log(childsTypes)
                    var status =  jq.find("[name="+ childsTypes +"]:radio:checked").val() ;
                    var dataModelId = jq.attr("data-model-id");
                    
                    arr.push({
                        "modelId":dataModelId,
                        "status":status
                    });
                })
                
                return arr;
                /*
                var dataModelId = jq.attr("data-model-id");
                var dataChildsTypes = jq.attr("data-childs-types");
                
                var status =  jq.find("[name="+ dataChildsTypes +":radio:checked]").val() ;
                
                return {
                    "modelId":dataModelId,
                    "status":status
                    }*/
                break;                
              
            case "Assoc":
            case "Models":
                //console.log("field ASSSSSOC");
                var selecteur="["+ Model.CTRL.DATA_MODEL_TYPE + "='"+jq.attr(Model.CTRL.DATA_CHILDS_TYPES)+"']"
                //console.log(selecteur);
                //console.log(jq);
                //console.log(jq.find(selecteur));
                return Fields.getModelsValues( jq.find("["+ Model.CTRL.DATA_MODEL_TYPE + "='"+jq.attr(Model.CTRL.DATA_CHILDS_TYPES)+"']") );
                break;                

            case "PhotoRectangle":
	        case "ModelSelect":
            case "SelectBox":
	        case "BoolField":
		        return $(jq.find("select")[0]).val();
		        break;
                                          
            case "PageUrls":
                var arr = [];
                var pageUrl = jq.find("["+ Model.CTRL.DATA_MODEL_TYPE + "='PageUrl']");
                $.each(pageUrl, function(i,f){
                    arr.push($.trim($(f).text()))
                })                
                return arr;
                break;

            case "Blocks":
                var fieldBlock=new Fields.Blocks(jq);
                return fieldBlock.getValue();
                break; 
		
            case "TextHtml":
                return jq.html();
                break;


            case "File":
            case "Text":
            case "FileField":
                var value = jq.find("textarea, input[type='text']").val();
                if(!value){
                    value=jq.find("[contenteditable='true']").html()
                }
                if (jq.attr("data-prefix") !== undefined){
                    return jq.attr("data-prefix") + "." + value;
                }
                    
                return value;
                break;
            case "HiddenField":
                return jq.find("input[type='hidden']").val();
                break;
            case "Date":
                var val=jq.find("input[type='text']").val();
                if(val==Fields.Date.CONSTANTS.NEVER){
                    return Fields.Date.CONSTANTS.NEVER_DATE_VALUE;
                }else if(val==Fields.Date.CONSTANTS.UNDEFINED){
                    return null;
                }else{
                    return val;
                }
                break;
        }
        
        switch ( jq.data("type") ) {
            case "radio":
                //alert("to do radio fields");
                return;
                break;
            case "checkbox":
                //alert("to do checkbox fields");
                return;
                break;                
        }
        
        //text or text area
        return jq.val();
    },
    /**
     * initialize the fields events
     */
    initControlers:function(){
	
        //console.log("initControllers ");
        


        JQ.bo.on("change",Fields.CTRL.SELECT_OPTION,function(e){
            e.preventDefault();
            var field=Fields.getParent($(this));
            Fields.validate(field);
        })
    },
    
    
    addPrefix:function(valeur, prefix) {
        
    }
}
Fields.CTRL={
    SET_VALUE:"a[href='#Fields.setValue']",
    SELECT_OPTION:"[data-select-value]"
}

JQ.bo.on("click",Fields.CTRL.SET_VALUE,function(e){
    e.preventDefault();
    var elem = $(this);
    var field=Fields.getParent(elem);
    Fields.setValue(field, elem.attr("data-value"));
    Model.getParent(elem).needToBeRecorded(true);
    
})

/*--------------to move----------------------*/




/*--------------to move----------------------*/


