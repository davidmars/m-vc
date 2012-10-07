/**
 * a field that works with jqery ui date picker
 */
Fields.File=function(jq){
    var jq=this.jq=$(jq);
    var me=this;
    this.textField=$(this.jq.find("input[type='text']")[0]);
    this.model=Model.getParent(jq);
    this.modelType=this.model.type();
    this.fieldName=jq.attr("data-field");
    this.template=jq.attr("data-template");
    this.progress=jq.find(".progress");
    this.progressBar=jq.find(".progress .bar");
    this.upload=function(file){
        me.model.needToBeRecorded(true);
        var request=new Api.Upload(me.modelType,me.fieldName,me.template,file,me.onComplete,me.onError);
        request.onProgress=me.onProgress;
        request.onComplete=me.onComplete;
        request.onError=me.onError;
        me.textField.attr("placeholder","uploading");
        me.textField.val(""); 
        me.progress.addClass("active");
    }
    
    this.onProgress=function(loaded,total){
            
        //if (e.lengthComputable) {
            var perc=Math.floor(Utils.rapport(loaded, total, 100, 0, 0));
            me.textField.attr("placeholder",String(perc)+"%");
            me.progressBar.css("width",String(perc)+"%");
        //} else {
             //me.textField.attr("placeholder","unable to compute");
        //}

    }
    this.onComplete=function(response){
        //me.textField.val(response);
        var json=jQuery.parseJSON(response);
        if(json.template){
            me.jq.replaceWith(json.template);
        }
    }
    this.onError=function(response){
        alert(response);;
        console.log(response);
    }
    
}



Fields.File.CTRL={
    BTN_PICK_FILE:"a[href='#Fields.File.pick']",
    BTN_UPLOAD_FILE:"[data-field-type='File'] input[type='file']"

}



JQ.bo.on("click",Fields.File.CTRL.BTN_PICK_FILE,function(e){
    e.preventDefault();
    var fieldFile=new Fields.File(Fields.getParent($(this)));
    
})

JQ.bo.on("change",Fields.File.CTRL.BTN_UPLOAD_FILE,function(e){
    //alert(e);
    //console.log(e.currentTarget);
    
    var fieldFile=new Fields.File(Fields.getParent($(this)));
    var oFile = e.currentTarget.files[0];
    fieldFile.upload(oFile);
})
