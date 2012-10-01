/* 
 * Common Class for file upload
 * version 1.0 use 
 *      jQuery File Upload Plugin 5.11.3
 *      /js/lib/fileupload
 */

var FileUploader = {
    dom:$( ModalsManager.CTRL.MODAL_UPLOAD ),
    fileupload : null,
    fileCount : 0,    
    fileFinishCount : 0,    
    instantiated : false,
    /**
     * ouvre la fenêtre
     */
    open:function(){
        Application.removeAllToolTip();
        FileUploader.dom.modal("show");
        FileUploader.dom.css("z-index", ModalsManager.getNextDepth());
    },
    /**
     * ferme la fenêtre
     */
    close:function(){
        FileUploader.dom.modal("hide");
    },
    init : function() {
        //console.log("FileUploader init");
        
        var selector=$("body");
	    
        selector.fileupload('destroy');
	    
        selector.fileupload({
            url : "/v2/service/upload"
        });
	    
        selector.fileupload().unbind('fileuploadprogress' );
        selector.fileupload().unbind('fileuploadprogressall' );
        selector.fileupload().unbind('fileuploadsubmit' );
        selector.fileupload().unbind('fileuploaddone' );
        selector.fileupload().unbind('fileuploadadd' );
        selector.fileupload().unbind('fileuploadfailed' );
            
        var uploadObject={
            'fileuploadprogress' : FileUploader.onProgress,
            'fileuploadprogressall' : FileUploader.onProgressAll,
            'fileuploadsubmit' : FileUploader.onFileUploadSubmit,
            /*'fileuploaddrop' : AdminFileUploader.onFileDrop, */  
            'fileuploaddone' : FileUploader.onFileUploaded,   
            /*'fileuploaddragover' :AdminFileUploader.onDragOver,*/
            'fileuploadadd' :FileUploader.onFileAdd,
            'fileuploadalways' :FileUploader.onAlways,
            'fileuploaddestroy' :FileUploader.onDestroy,
            'fileuploadfailed' :FileUploader.onFailed
        } 
		
        FileUploader.fileupload = selector.fileupload().bind(uploadObject);
	
        selector.fileupload(
            'option',
            'redirect',
            window.location.href.replace(
                /\/[^\/]*$/,
                '/cors/result.html?%s'
                )
            );
        // preview width
        selector.fileupload(
            'option',
            'previewMaxWidth',
            '160'
            );
        // preview height
        selector.fileupload(
            'option',
            'previewMaxHeight',
            '160'
            );
                
            
            
    /*selector.bind('fileuploadsubmit', function (e, data) {
                // The example input, doesn't have to be part of the upload form:
               
                data.formData = {uploadType: 'test'}
                
            });*/
    },
    onAlways : function (e, data) {
        // data.result
        // data.textStatus;
        // data.jqXHR;
        //console.log("onAlways")
        //console.log(data);
        
        if( data.textStatus == "abort" ) {
            $(FileUploader.CTRL.UPLOAD_PROGRESS_BAR).css("width","0%");
        }
    },
    onDestroy : function (e, data) {
        // data.result
        // data.textStatus;
        // data.jqXHR;
        //console.log("onDestroy")
        //console.log(data);
    },
    onFailed : function (e, data) {
        //console.log("onFailed")
        //console.log(e);     
        //console.log(data);     
        //console.log(data.errorThrown);     
        if( data.errorThrown == "abort" ) {
            --FileUploader.fileCount;        
            $(FileUploader.CTRL.UPLOAD_PROGRESS_INFO_FILE_COUNT_TOTAL).html(FileUploader.fileCount);
        }
    },
    /**
     * Callback for global upload progress events.
     */
    onProgressAll : function (e, data) {
        // data.result
        // data.textStatus;
        // data.jqXHR;
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $(FileUploader.CTRL.UPLOAD_PROGRESS_BAR).css("width",progress+"%");
    },
    /**
     *
     */
    onFileUploaded:function(e, data){
        //console.log("onFileUpload")
        //console.log(e);
        //console.log(data);
        
        ++FileUploader.fileFinishCount;        
        $(FileUploader.CTRL.UPLOAD_PROGRESS_INFO_FILE_COUNT_FINISH).html(FileUploader.fileFinishCount);
        //is there a special handler for this file?
        var specialHandler=FileUploader.getSpecialHandler(data.files[0]);
        if(specialHandler){
            specialHandler.onFileUploaded(e,data);
        }
	
        Application.removeBeforeExitUpload();
    },
    onProgress : function (e, data) {
        //is there a special handler for this file?
        var specialHandler=FileUploader.getSpecialHandler(data.files[0]);
        if(specialHandler){
            specialHandler.onProgress(e,data);
        }
    },
    onFileUploadSubmit : function (e, data) {

        Application.addBeforeExitUpload();
        /*var specialHandler=FileUploader.getSpecialHandler(data.files[0]);
	if(specialHandler){
            specialHandler.onFileUploadSubmit(e,data);
        } else {*/
        //console.log("default dataModelType")
        var inputFile = $(data.fileInput);
        inputFile=$("#"+inputFile.attr("id"));
            
        if( inputFile.attr("data-upload-type") ) {
            data.formData = {
                dataModelType: inputFile.attr("data-upload-type")
            };
        } else {
            var model=Model.getParent(inputFile);
            data.formData = {
                dataModelType: model.type(),
                dataModelId: model.id()
            };
        }
            
            
    //}
    },
    onFileAdd : function (e, data) {
        //console.log("onFileAdd");
        $(FileUploader.CTRL.UPLOAD_PROGRESS_BAR).css("width","0%");
        ++FileUploader.fileCount;
        
        $(FileUploader.CTRL.UPLOAD_PROGRESS_INFO_FILE_COUNT_TOTAL).html(FileUploader.fileCount);
        
        var inputFile = $(data.fileInput);
        inputFile=$("#"+inputFile.attr("id")); //cause the initial input object is NOT IN DOM! 

        if(inputFile.attr(Application.CTRL.PHOTO_RECTANGLE_UPLOAD) == "true"){
            FileUploader.open();
            var photoRectangleModel=Model.getParent(inputFile);
            var mainModel=Model.getParent(photoRectangleModel.jq);
            FileUploader.fromPhotoRectangleField(mainModel, photoRectangleModel,data.files[0])
        } /*else if( inputFile.attr(Application.CTRL.VIDEO_TRADS_UPLOAD) == "true" || inputFile.attr(Application.CTRL.SUBTITLE_TRADS_UPLOAD) == "true" ) {            
            FileUploader.open();
            var fileModel=Model.getParent(inputFile);
	    var mainModel=Model.getParent(fileModel.jq);            
            FileUploader.fromAllUpload(mainModel, fileModel, data.files[0] );
        }*/
        else {            
            FileUploader.open();
            var fileModel=Model.getParent(inputFile);
            var mainModel=Model.getParent(fileModel.jq);            
            FileUploader.fromAllUpload(mainModel, fileModel, data.files[0] );
        }
    },
    /**
     * an object that contains specials handlers for some uploads
     * the keys come from getIdForFile
     */
    specialHandlers:{},
    /**
     * add a special handler
     */
    setSpecialHandler:function(file,handler){
        FileUploader.specialHandlers[FileUploader.getIdForFile(file)] = handler;
    },
    /**
     * returns a special handler or null
     */
    getSpecialHandler:function(file){
        return FileUploader.specialHandlers[FileUploader.getIdForFile(file)]
    },
    /**
     * returns an id key from file object used as key in currentUploads
     */
    getIdForFile:function(file){
        return file.name+"-"+file.size; 
    },
    fromAllUpload : function ( mainModel, fileModel, file){
        //console.log("------fromAllUpload--------")
        //console.log(fileModel);
        //console.log(mainModel);        
        var fileModel = fileModel;
        var modelId = fileModel.id();
        var modelType = fileModel.type();
        var field = fileModel.jq.data("field");        
        
        var loadingBar=fileModel.jq.find(".upload-progress")
        if(!loadingBar.length>0){
            loadingBar=$("<div class='upload-progress'></div>") ;
            loadingBar.css("position","absolute");
            loadingBar.css("left","0");
            loadingBar.css("height","5px");
            loadingBar.css("width","100%");
            loadingBar.css("background-color","#0f0");
            fileModel.jq.find(".thumbnail").css("position","relative")
            fileModel.jq.find(".thumbnail").append(loadingBar);
        }

        var specialHandler={};
                
        specialHandler.onProgress=function(e,data){
        //loadingBar.css("width",Utils.rapport(data.loaded,data.total,100,0,0)+"%"); 
        }
        specialHandler.onFileUploaded=function(e,data){	    
            loadingBar.remove();
            
            var json=data.result[0];
            if(mainModel.isInDom()){ //we are already on the page
                //refresh template of the field only (save will be done by the user clicking button) 
                
                if(json.photoRectangle) {                    
                    var recDom = mainModel.jq.find("[data-field-type='PhotoRectangle']");
                    if( recDom ) {
                        var photoRectangleModel = new Model( recDom );
                        Api.getTemplate(
                            json.photoRectangle.id, 
                            "PhotoRectangle", 
                            photoRectangleModel.template(), 
                            photoRectangleModel.getContext(),
                            function(json){
                                Api.processMessage(json, photoRectangleModel);
                                photoRectangleModel.needToBeRecorded(true);			
                            }); 
                    }
                    
                }
                
                Api.getTemplate(
                    json.id, 
                    modelType, 
                    fileModel.template(), 
                    fileModel.getContext(), 
                    function(json){
                        Api.processMessage(json, fileModel);
                        //FileUploader.init();
                        fileModel.needToBeRecorded(true);
                    });

            }else{
                if( json.type == "Photo" ) {
                    new ModalPhoto(json.id);
                } else {
                    if(confirm("The picture "+json.name+" has been uploaded, do you want to set it as "+field+" for "+modelType+" "+modelId+"?")){
                    //api save directly
                    // carefully to update small picture
                    }else{
                    //nothing the photo rectangle will have no reason to exists but the picture will be in the photo bank
                    }   
                }
            }

        }
        FileUploader.setSpecialHandler(file, specialHandler);
    },
    /**
     *
     */
    fromPhotoRectangleField:function(mainModel,photoRectangleModel,file){
	
        /*
	var uploadInProgress=function(){
	    if(confirm("A picture is currently uploading are you sur you want to leave the page?")){
		return true;
	    }else{
		return false;
	    }
	}
	mainModel.addEventListener("leavePage",uploadInProgress)
	*/
	
        var photoRectangleModel=photoRectangleModel;
        var mainModel=mainModel;
        var modelId=mainModel.id();
        var modelType=mainModel.type();
        //something like "root[mainPicture]"
        var field=photoRectangleModel.jq.data("field");
        
        //create a loading bar in the field
        var loadingBar=photoRectangleModel.jq.find(".upload-progress")
        if(!loadingBar.length>0){
            loadingBar=$("<div class='upload-progress'></div>") ;
            loadingBar.css("position","absolute");
            loadingBar.css("left","0");
            loadingBar.css("height","5px");
            loadingBar.css("width","100%");
            loadingBar.css("background-color","#0f0");
            photoRectangleModel.jq.find(".thumbnail").css("position","relative")
            photoRectangleModel.jq.find(".thumbnail").append(loadingBar);
        }

	
        //set file selection to picture mime type
        //disable multiple file select
        //start the upload directly
        //
        //on upload complete...
	
        var specialHandler={}
        
        specialHandler.onProgress=function(e,data){
            loadingBar.css("width",Utils.rapport(data.loaded,data.total,100,0,0)+"%"); 
        }
        specialHandler.onFileUploaded=function(e,data){
            //console.log("fromPhotoRectangleField - onFileUploaded");
            loadingBar.remove();
            
            //console.log("refresh "+modelId+"/"+modelType+"/"+field);
            //console.log(mainModel.jq.parents("body"));
	    
            //mainModel.removeEventListener("leavePage",uploadInProgress);
            var json=data.result[0];
            if(mainModel.isInDom()){ //we are already on the page
                //refresh template of the field only (save will be done by the user clicking button) 
                //photoRectangleModel.
                /*Api.call(
		    json.photoRectangle.id,"PhotoRectangle",
		    {
		    context:{dataField:field},
		    template:photoRectangleModel.template(),
		    theme:"extranet"
		    },
		    function(json){
			Api.processMessage(json, photoRectangleModel);
			//FileUploader.init();
		    }
		)*/
                Api.getTemplate(
                    json.photoRectangle.id, 
                    "PhotoRectangle", 
                    photoRectangleModel.template(), 
                    photoRectangleModel.getContext(),
                    function(json){
                        Api.processMessage(json, photoRectangleModel);
                        
                        Fields.PhotoRectangle.crop(photoRectangleModel,Model.getParent(photoRectangleModel.jq));  
                        photoRectangleModel.needToBeRecorded(true);			
                    });

            }else{
                if(confirm("The picture "+json.name+" has been uploaded, do you want to set it as "+field+" for "+modelType+" "+modelId+"?")){
                //api save directly
                // carefully to update small picture
                }else{
                //nothing the photo rectangle will have no reason to exists but the picture will be in the photo bank
                }    
            }

        }
        FileUploader.setSpecialHandler(file, specialHandler);
	
    },
    loadingProgress:function(current, total){
        var el=$("#application-loading-progress")
        if(current<total){
            el.css("display","block");
            el.find(".bar").css("width",Utils.rapport(current, total, 100, 0, 0)+"%")
        }else{
            el.css("display","none");    
        }
        
    }
}

FileUploader.CTRL = {
    UPLOAD_PROGRESS : "#modal-upload-progress",
    UPLOAD_PROGRESS_INFO : "#modal-upload-progress .info",
    UPLOAD_PROGRESS_BAR : "#modal-upload-progress .progress .bar",
    UPLOAD_PROGRESS_INFO_FILE_COUNT_TOTAL : "#modal-upload-progress .info .file-count-total",
    UPLOAD_PROGRESS_INFO_FILE_COUNT_FINISH : "#modal-upload-progress .info .file-count-finish",
    UPLOAD_PROGRESS_OPEN_MODAL : "a[href='#FileUploader.open']"
}

JQ.bo.on("click",FileUploader.CTRL.UPLOAD_PROGRESS_OPEN_MODAL,function(e){
    e.preventDefault();
    FileUploader.open();
})