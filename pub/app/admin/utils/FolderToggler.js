//toogle 
$("body").on("click","[data-folder-toggler]",function(e){
    e.preventDefault();
    var ft=new FolderToggler($(this).closest("li"));
    ft.toggle();
})

//remove files service
$("body").on("click","[data-folder-content] [data-action-remove]",function(e){
    e.preventDefault();
    var ft=new FolderToggler($(this).closest("li"));
    ft.remove();
})

//search files service
$("body").on("submit","[data-tree-files] form",function(e){
    e.preventDefault();
    e.stopPropagation();
    var ft=new TreeFiles($(this).closest("[data-tree-files]"));
    ft.search($($(this).find("[data-search-service]")[0]).val());
})


var TreeFiles=function(jq){
    var me=this;
    this.jq=$(jq);
    
    this.search=function(query){
        me.jq.addClass("blink-loading");
        //me.jq.fadeOut();
        $.ajax({   
            type: "POST",
            data:{q:query},
            url: "/v2/admin-tools/cache/search",
            success:
            function (ajaxReturn){
                me.jq.removeClass("blink-loading");
                console.log(ajaxReturn);
            }                    
        });  
    }

    
}


/**
 * manage a folder tree browsing via ajax templates and the ability to remove files and folders.
 */
var FolderToggler=function(jq){
    var me=this;
    this.jq=$(jq);
    this.content=$(this.jq.find("[data-folder-content]")[0]);
    this.toggler=$(this.jq.find("[data-folder-toggler]")[0]);
    this.removeBtn=$(this.jq.find("[data-action-remove]")[0]);
    
    /**
     * performs an ajax call to remove the file or folder 
     */
    this.remove=function(){
            me.jq.addClass("blink-loading");
            //me.jq.fadeOut();
	    $.ajax({   
		type: "POST",
		data:{f:me.removeBtn.attr("data-action-remove")},
                url: "/v2/admin-tools/cache/remove",
		success:
		function (ajaxReturn){
		   me.jq.replaceWith(ajaxReturn) ;
		}                    
	    });
	    
    }
    /**
     * Returns if the folder is opened or closed.
     * WARNING The return is a String "true" or "false".
     */
    this.getState=function(){
	return $(me.jq.find("[data-folder-open]")[0]).attr("data-folder-open");
    }
    
    
    /**
     * open or close the folder
     * @param String state can be a string (not a boolean) "true" or "false"
     */
    this.setState=function(state){
        //set state in attribute
	$(me.jq.find("[data-folder-open]")[0]).attr("data-folder-open",state);
        
        
	if(state=="true"){
	    open();
            me.jq.addClass("blink-loading");
	    $.ajax({   
                type: "POST",
		data:{f:me.content.attr("data-folder-content")},
                url: "/v2/admin-tools/cache/browseFolder",
                success:
                function (ajaxReturn){
                   me.jq.replaceWith(ajaxReturn) ;
                }                    
		});
	}else{
	    close();
	}
    }
    

    /**
     * close the folder, only affect the display
     */
    var close=function(){
        me.content.empty();
	me.toggler.removeClass("icon-folder-open");
	me.toggler.addClass("icon-folder-close")
	me.content.css("display","none");
    }
    /**
     * open the folder, only affect the display
     */
    var open=function(){
        me.content.empty();
	me.toggler.removeClass("icon-folder-close");
	me.toggler.addClass("icon-folder-open");
	me.content.css("display","block");
    }
    /**
     * open or close a folder
     */
    this.toggle=function(){
	var state=me.getState();
	if(state=="false"){
	   me.setState("true");
	}else{
	   me.setState("false");
	}
    }
}


