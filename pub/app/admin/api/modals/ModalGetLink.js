ModalGetLink={
    dom:$(ModalsManager.CTRL.MODAL_GET_LINK),
    urlField:$(ModalsManager.CTRL.MODAL_GET_LINK+" "+"input[type='text']"),
    ajaxReceiver:$(ModalsManager.CTRL.MODAL_GET_LINK+" "+"[data-ajax-receiver='true']"),
    open:function(){
	ModalGetLink.reset();
        ModalGetLink.dom.modal("show");
        ModalGetLink.dom.css("z-index",ModalsManager.getNextDepth());
    },    
    close:function(){
        ModalGetLink.dom.modal("hide");
    },
    reset:function(){
	ModalGetLink.ajaxReceiver.removeClass("loading-box");
	ModalGetLink.ajaxReceiver.html("");
	//ModalGetLink.urlField.val();
    },
    /**
     * fired when a model or an external link is selected
     * @param result an object wich type can be model | external | action
     * @param externalLink String Something like http://an-external-domain.com/lorem/ipsum
     * @param _blank Bool true if the link should be opened in a _blank window
     */
    onComplete:function(result){
        
    },
    result:null,
    search:function(url){
	ModalGetLink.reset();
	ModalGetLink.ajaxReceiver.addClass("loading-box");
	ModalGetLink.ajaxReceiver.html("");
	$.ajax({
	    url:Config.rootUrl+"/v2/service/whatIsThisUrl",
            dataType: 'json',
	    data:{
		"search":url
	    },
	    success:function(data){
		//console.log(data)
		
		if(data.template){
		  ModalGetLink.ajaxReceiver.html(data.template)
		  ModalGetLink.ajaxReceiver.removeClass("loading-box");
		}
		ModalGetLink.result=data.datas;
	    }
	});
    }
    
    
}

ModalGetLink.dom.on("click", "a[href='"+ModelBrowser.CTRL.MODEL_SELECTOR+"']",function(e){
    e.preventDefault();
    //var photo=Model.getParent($(this));
    ModalGetLink.onComplete(ModalGetLink.result); 
    ModalGetLink.close();
})
ModalGetLink.dom.on("click","a[href='#ModalGetLink.search']",function(e){
    e.preventDefault();
    //console.log(ModalGetLink.urlField);
    //console.log(ModalGetLink.urlField.val());
    ModalGetLink.search(ModalGetLink.urlField.val());
})

ModalGetLink.dom.on("change","input",function(e){
    //console.log("user input")
    ModalGetLink.search(ModalGetLink.urlField.val());
})

