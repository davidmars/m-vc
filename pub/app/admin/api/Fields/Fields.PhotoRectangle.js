Fields.PhotoRectangle={}

/**
 * launch photo chooser window and update de field after it.
 */
Fields.PhotoRectangle.changePhoto=function(photoRectangleModel){
    PhotoSelector.init();
    PhotoSelector.open();     
    var photoRectangleModel=photoRectangleModel;
    PhotoSelector.onSelectModel=function(photoModel){
	PhotoSelector.close();
        //set a new model
	photoRectangleModel.jq.attr( Model.CTRL.DATA_MODEL_ID ,"new");
	photoRectangleModel.setFieldValue("root[x]","0");
	photoRectangleModel.setFieldValue("root[y]","0");
	photoRectangleModel.setFieldValue("root[width]","1");
	photoRectangleModel.setFieldValue("root[height]","1");
        photoRectangleModel.setFieldValue("root[originalWidth]","1");
	photoRectangleModel.setFieldValue("root[originalHeight]","1");            
        
        Model.getParent(photoRectangleModel.jq).needToBeRecorded(true);
        //set the new photo
        photoRectangleModel.setFieldValue("root[photo]",photoModel.id());
	photoRectangleModel.save(function(json){
            
            Api.processMessage(json, photoRectangleModel);
            
            Fields.PhotoRectangle.crop(photoRectangleModel,Model.getParent(photoRectangleModel.jq));    
        });
        
        
        
        
        
        
    }
}
/**
 * launch photo cropper window and update de field after it.
 */
Fields.PhotoRectangle.crop=function(photoRectangleModel,mainModel){
    ModalPhotoRectangle.open(photoRectangleModel,mainModel);
    ModalPhotoRectangle.onSave=function(x,y,width,height,originalWidth,originalHeight){
        //console.log("on apply");
        //console.log(x,y,width,height,originalWidth,originalHeight);
	//set a new model
	photoRectangleModel.jq.attr(Model.CTRL.DATA_MODEL_ID,"new");
	photoRectangleModel.setFieldValue("root[x]",x);
	photoRectangleModel.setFieldValue("root[y]",y);
	photoRectangleModel.setFieldValue("root[width]",width);
	photoRectangleModel.setFieldValue("root[height]",height);   
	photoRectangleModel.setFieldValue("root[originalWidth]",originalWidth);
	photoRectangleModel.setFieldValue("root[originalHeight]",originalHeight);           
	
	photoRectangleModel.save();
        Model.getParent(photoRectangleModel.jq).needToBeRecorded(true);
        
        FileUploader.close();
        
    }
}

Fields.PhotoRectangle.CTRL={
    /**
     * button to change the picture...in fact it will launch the photos' modal window, and after picking one it will create a new PhotoRectangle 
     */
    ChangePhoto:    "a[href='#Fields.PhotoRectangle.changePhoto']",
    /**
     * button to change the crop properties
     */
    Crop:           "a[href='#Fields.PhotoRectangle.crop']"
}

JQ.bo.on("click",Fields.PhotoRectangle.CTRL.ChangePhoto,function(e){
    e.preventDefault();
    var photoRectangleModel=Model.getParent($(this));
    Fields.PhotoRectangle.changePhoto(photoRectangleModel)
})
JQ.bo.on("click",Fields.PhotoRectangle.CTRL.Crop,function(e){
    e.preventDefault();
    var photoRectangleModel=Model.getParent($(this));
    var mainModel=Model.getParent(photoRectangleModel.jq);
    Fields.PhotoRectangle.crop(photoRectangleModel,mainModel)
})