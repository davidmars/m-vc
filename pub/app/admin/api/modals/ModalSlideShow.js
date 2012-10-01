var ModalSlideShow={
    jq:$("#modal-slide-show"),
    ajaxTarget:$("#ModalSlideShow-content"),
    listItems:$("#ModalSlideShow-list-items"),
    model:null,
    mainModel:null,
    container:null,
    previewContainer:null,
    /**
     * open the window and load the stuff
     */
    open:function(slideShowId){               
        ModalSlideShow.jq.modal("show");
        ModalSlideShow.load(slideShowId);
    },
    /**
     * hide the window
     */
    close:function(){
        ModalSlideShow.jq.modal("hide");
    },
    /**
     * load the good slide show
     */
    load:function(slideShowId){	
        Api.getTemplate(
            slideShowId, 
            "SlideShow", 
            "v2/modals/slide-show/content", 
            {
                contextVar1:"nothing"
            }, 
            function(json){
                ModalSlideShow.ajaxTarget.html(json.template);              
                ModalSlideShow.listItems=$("#ModalSlideShow-list-items")
            }
            )
        
        /*
        *  this content it will be the new sldieshow later without ajax request and data insertion 
        *  @author : francois
        */             
        
        /*
        // get the html of the given id                 
        var content = $("#" + slideShowId).find(".slides_container");

        // change the id of the current edit slide show model
        ModalSlideShow.jq.find("[data-model-type='SlideShow']").attr("data-model-id", slideShowId);        
        ModalSlideShow.jq.find("a[href='#Fields.SlideShow.edit']").attr("data-slide-show-id", slideShowId);

        // clean elements of the slideshow
        ModalSlideShow.listItems.html("")

        // if they already exist elements
        if (content.length > 0) {

            content.find(".slides_control").children().clone().appendTo(ModalSlideShow.listItems);

            ModalSlideShow.listItems.find(".item").removeAttr("style");
            ModalSlideShow.listItems.find(".block-menu").removeClass("hidden");

        }
        */
            
    },
    /**
     * called by the user when validate the job
     */
    onSave:function(slideShowId){},
    _save:function(){        
        ModalSlideShow.close();
        var model=new Model(ModalSlideShow.jq.find("[data-model-type='SlideShow']"));

        //console.log("_save")
        //console.log(model.jq);
        model.save(
            function(){
                //console.log("onSave")
                ModalSlideShow.onSave(model.id());
                model.isLoading(false);
            }
        )        
        
        /*
         *  this content it will be the new sldieshow later without ajax request and data insertion 
         *  @author : francois
         */     
         
        /*
        ModalSlideShow.onSave(model.id());        
        ModalSlideShow.close();
        */
    }
 
}

ModalSlideShow.CTRL={
    /**
     * Save the current slide show
     **/
    SAVE:"a[href='#ModalSlideShow.save']",
    ADD_PHOTO_RECTANGLE:"a[href='#ModalSlideShow.addPhotoRectangle']"
}

ModalSlideShow.jq.on("click",ModalSlideShow.CTRL.SAVE,function(e){
    e.preventDefault();
    ModalSlideShow._save();
})

ModalSlideShow.jq.on("click",ModalSlideShow.CTRL.ADD_PHOTO_RECTANGLE,function(e){
    e.preventDefault();
    PhotoSelector.open();
    PhotoSelector.onSelectModel=function(model){
        PhotoSelector.close();
        Api.call(
            "new",
            "PhotoRectangle",
            {
                template:"v2/modals/slide-show/menu-item",
                root:{
                    photo:model.id(),
                    x:0,
                    y:0,
                    width:1,
                    height:1
                }
            },
            function(j){
                ModalSlideShow.listItems.append($(j.template));
            }
            )   
    }
})