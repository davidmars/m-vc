Fields.Video={
    updateSubtitle:function(subtitleModel){
	alert("reloads ONLY the flash with the new subtitle file");
    }
}

Fields.Video.CTRL={
    /**
     * Change video in blocks
     */
    CHANGE_VIDEO:    "a[href='#Fields.Video.changeVideo']"
    
}

/**
 * launch photo chooser window and update de field after it.
 */
Fields.Video.changeVideo=function(videoModel){
    VideoSelector.init();
    VideoSelector.open();     
    var videoModel = videoModel;
    VideoSelector.onSelectModel=function(newVideoModel){
	VideoSelector.close();        
        Model.getParent(videoModel.jq).needToBeRecorded(true);        
        videoModel.jq.attr( Model.CTRL.DATA_MODEL_ID, newVideoModel.id());
        videoModel.save();
    }
}

JQ.bo.on("click",Fields.Video.CTRL.CHANGE_VIDEO,function(e){
    e.preventDefault();
    var videoModel=Model.getParent($(this));
    var mainModel=Model.getParent(videoModel.jq);
    Fields.Video.changeVideo(videoModel,mainModel)
})