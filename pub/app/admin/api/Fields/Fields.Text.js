Fields.Text=function(){}

/**
 * performs auto height on all mirror text areas marked 
 */
Fields.Text.autoHeightTextareas=function(){
    var containers=$(Fields.Text.CTRL.TEXT_AREA_AUTO_HEIGHT);
    for(var i=0;i<containers.length;i++){
        Fields.Text.autoHeightTextareasMirror($(containers[i]));
    }    
}
/**
 * performs an auto height for a couple of text areas
 */
Fields.Text.autoHeightTextareasMirror=function(el){
    var txts=el.find("textarea");
    var bigger=0;
    for(var i=0;i<txts.length;i++){
        Fields.Text.autoHeightTextarea(txts[i]);
        bigger=Math.max(bigger, $(txts[i]).attr("rows"))
    }
    txts.attr("rows",bigger);
}
/**
 * performs an auto height for ONE textarea
 */
Fields.Text.autoHeightTextarea=function(textareaDom){
    var jq=$(textareaDom);
    jq.css("overflow","hidden");
    
    for(var i=0;i<jq.length;i++){
        //gives the good size to the target field
        var el=$(jq[i]);
        //el.scrollTop(0);
        var j=3;
        el.attr("rows",3);
        
        while(el.innerHeight() < el[0].scrollHeight){
            el.attr("rows",j++);
        }
        
    }
    el.attr("rows",j++);
}

Fields.Text.cleanUp=function(domEl,removeTags){
    domEl.find("script,noscript,style").remove();
    domEl.attr("style","");
    domEl.attr("class","");
    var childs=domEl.find("*:not(br)");

    if(childs.length>0 && removeTags){
        //replace all tags by <br> works but...
        var text =domEl.html();
        text = text.replace("<br>", 'thisisanewline');
        text = text.replace("<br/>", 'thisisanewline');
        text = text.replace(/<[^>]*>/g, 'thisisanewline');
        text = text.replace(/thisisanewline/g, "<br>");
        domEl.html(text);
        return;
    }
    for(var i=0;i<childs.length;i++){
        Fields.Text.cleanUp($(childs[i]));
    }

    
}

Fields.Text.CTRL={
    /*
     * all input with no html etc.
     */
    POOR_TEXT:"[data-field-type='Text'] textarea, [data-field-type='Text'] input[type='text']",
    /**
     * a selector to put on container of a couple of text areas auto height
     */
    TEXT_AREA_AUTO_HEIGHT:"[data-auto-height-textareas='true']",
    
    RICH_TEXT:"[data-field-type='Text'] [contenteditable='true'],[contenteditable='true'][data-field]",
    /*
     *  Open text edit modal box
     */
    EDIT:"a[href='#Fields.Text.edit']"
}


/**
* a selector for text area fields, input type text fields and content editable texts
*/
Fields.Text.CTRL.ALL_KINDS =  Fields.Text.CTRL.POOR_TEXT  + ", " + Fields.Text.CTRL.RICH_TEXT;

/**
 * on change --> need to be saved
 */
JQ.bo.on("keyup paste change",Fields.Text.CTRL.POOR_TEXT,function(e) {
    var closestDataField = $(this).closest("[data-field]");
    //clean up dirty html code
    /*if($(this).attr("contenteditable")=="true"){
        Fields.Text.cleanUp($(this));
    }*/



    Fields.validate(closestDataField);
    
    //on change handler
    var mainModel=Model.getParent($(this));
    mainModel.needToBeRecorded(true);
})

JQ.bo.on("keyup paste change",Fields.Text.CTRL.RICH_TEXT,function(e) {
    if($(this).attr("data-remove-format")=="true"){
        Fields.Text.cleanUp($(this),true);
    }
    var mainModel=Model.getParent($(this));
    mainModel.needToBeRecorded(true);
})

JQ.bo.on("paste",Fields.Text.CTRL.ALL_KINDS,function(e) {
    if($(this).attr("contenteditable")=="true"){
        Fields.Text.cleanUp($(this));
    }
})

JQ.bo.on("focus",Fields.Text.CTRL.RICH_TEXT,function(e) {
    //console.log("focus");
    Fields.initRichText($(this));
    Model.getParent($(this)).needToBeRecorded(true);
})

JQ.bo.on("blur",Fields.Text.CTRL.RICH_TEXT,function(e) {
    //console.log("focus");
    RichText.hideEditor();
})

JQ.bo.on("focusout",Fields.Text.CTRL.ALL_KINDS,function(e) {
    //console.log("focusout");
    $(this).unbind('keydown');
})

/**
 * textarea autosize + mirror
 */
JQ.bo.on("keyup paste keydown",Fields.Text.CTRL.TEXT_AREA_AUTO_HEIGHT+" textarea",function(e){
    var container=$(this).closest(Fields.Text.CTRL.TEXT_AREA_AUTO_HEIGHT);
    Fields.Text.autoHeightTextareasMirror(container);    
})

JQ.bo.on("click",Fields.Text.CTRL.EDIT,function(e){
    e.preventDefault();    
    var model = Model.getParent($(this));
    var modelId = model.id();
    var modelType = model.type();
    ModalsManager.activeModel = model; 
    ModalsManager.openEditModal(modelId, modelType, model.jq.attr(Model.CTRL.TEMPLATE_MODAL));
})

Fields.initRichText = function(elem) {
    //console.log("initRichText");
    RichText.current=elem;
    RichText.showEditor();
    
    /*
    $.ctrl = function(key, callback, args) {
        //elem.unbind('keydown');
        elem.keydown(function(e) {
            if(!args) args=[]; // IE barks when args is null 
            if(e.keyCode == key.charCodeAt(0) && e.ctrlKey) {
                e.preventDefault(); 
                callback.apply(this, args);
                return false;
            }
        });        
    };
    */
    /*
    $.ctrl('B', function(s) {
        Fields.Text.bold();
    }, ["Control B pressed"]);

    $.ctrl('I', function(s) {
        Fields.Text.italic();
    }, ["Control I pressed"]);

    $.ctrl('U', function(s) {
        Fields.Text.underline();
    }, ["Control U pressed"]);

    $.ctrl('L', function(s) {
        Fields.Text.unlink();
    }, ["Control L pressed"]);
    */
}


RichText={
    /**
     * the current jquery dom contenteditable field
     */
    current:null
}
RichText.CTRL={
    BOLD:"a[href='#RichText.bold']",
    ITALIC:"a[href='#RichText.italic']",
    UNLINK:"a[href='#RichText.unlink']",
    LINK:"a[href='#RichText.link']",
    CLEAN:"a[href='#RichText.clean']"
}

JQ.bo.on("click",RichText.CTRL.BOLD,function(e) {
    e.preventDefault();
    RichText.bold();
    
})
JQ.bo.on("click",RichText.CTRL.ITALIC,function(e) {
    e.preventDefault();
    RichText.italic();
    
})
JQ.bo.on("click",RichText.CTRL.LINK,function(e) {
    e.preventDefault();
    RichText.link();  
})
JQ.bo.on("click",RichText.CTRL.UNLINK,function(e) {
    e.preventDefault();
    RichText.unlink();  
})
JQ.bo.on("click",RichText.CTRL.CLEAN,function(e) {
    e.preventDefault();
    RichText.clean();  
})

RichText.bold=function(){
   document.execCommand('bold',null,false);
   //FrontEdit.saveField(FieldEdit.RichText.current.jq);
   RichText.showEditor();
}
RichText.italic=function(){
   document.execCommand('italic',null,false);
   //FrontEdit.saveField(FieldEdit.RichText.current.jq);
   RichText.showEditor();
}
RichText.link=function(){
    
	document.execCommand("unlink", null, null);
	document.execCommand("createlink", null, "###");
	var node=JQ.bo.find("[href='###']")
	
	ModalGetLink.open();
	ModalGetLink.onComplete=function(result){

	    node.removeAttr("style");
	    node.removeAttr("class");
	    node.attr("href",result.type);
	    var url;
	    var target="_blank";
	    switch(result.type){
		case "model":
		    target=null;
		    url="model/"+result.modelType+"/"+result.modelId;
		    break;
		case "action":
		    target=null;
		    url="action/"+result.action;
		    break;
		default:
		    url=result.url;
		    break;
	    }
	    node.attr("target",target);
	    node.attr("href",url);
	    RichText.showEditor(); 
	}
	

    
}
RichText.unlink=function(){
	document.execCommand("hilitecolor", null, "#ff0"); //add a color to be able to retrieve the element
	var node=JQ.bo.find("[style='background-color: rgb(255, 255, 0);']");
	node.attr("style","");
	node.attr("class","");
	document.execCommand("unlink", null, null);
}
RichText.clean=function(){
	//RichText.current.html(RichText.current.text());
	
	RichText.unlink();
        //remove format
	document.execCommand("removeFormat", null, null);
	document.execCommand("hilitecolor", null, "#ff0");
        
        //jquery clean up
	var node=RichText.current.find("[style='background-color: rgb(255, 255, 0);']");
	for(var i=0;i<node.length;i++){
	    if(!$(node[i]).parent().attr("contenteditable")!="true"){
              $(node[i]).parent().attr("class","");  
            }
	}
        node.attr("class","");
        node.find("*").attr("class","");

         
	var text="";
	for(var i=0;i<node.length;i++){
	    text+=$(node[i]).html()+"<br/>";
	}
        //console.log(text)
        
	document.execCommand("insertHTML", null, "<span>"+text+"</span>"); 
        node.remove();
        
        //FieldEdit.RichText.removeEmptys();
	
	/*
	document.execCommand("hilitecolor", null, "#ff0"); //add a color to be able to retrieve the element
	var node=JQ.bo.find("[style='background-color: rgb(255, 255, 0);']");
	node.attr("style","");
	node.attr("class","");
	document.execCommand("unlink", null, null);
	*/
}


RichText.showEditor=function(){
    clearTimeout(RichText.showHideTimer);
    $(".rich-text-menu").addClass("active");
}
RichText.hideEditor=function(){
    RichText.showHideTimer=setTimeout(function(){
	$(".rich-text-menu").removeClass("active");
    },500);
}

