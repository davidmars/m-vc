/**
 * a field that works with jqery ui date picker
 */
Fields.File=function(jq){
    var jq=this.jq=$(jq);
    var me=this;
    this.textField=$(this.jq.find("input[type='text']")[0]);
    
    this.onProgress=function(loaded,total){

        //if (e.lengthComputable) {
            var perc=Math.floor(Utils.rapport(loaded, total, 100, 0, 0));
            me.textField.attr("placeholder",String(perc)+"%");
        //} else {
             //me.textField.attr("placeholder","unable to compute");
        //}

    }
    this.onComplete=function(response){
        me.textField.val(response);
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
    var oFile = e.currentTarget.files[0];
    var fieldFile=new Fields.File(Fields.getParent($(this)));
    var request=Api.upload(oFile,fieldFile.onProgress,fieldFile.onComplete,fieldFile.onError);
    
    
    fieldFile.textField.attr("placeholder","uploading");
    fieldFile.textField.val("");
    //request.upload.addEventListener('progress', fieldFile.onProgress, false);
    // set inner timer
    //oTimer = setInterval(doInnerUpdates, 300);
    
    //var fieldDate=new Fields.Date(Fields.getParent($(this)));
    //Fields.validate(fieldDate.jq); 
})
