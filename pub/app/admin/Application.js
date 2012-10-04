var Application={
    currentModel : null,
    initTimes:0,
    blogId:0,
    langId : 1,
    History : null, // Note: We are using a capital H instead of a lower h,
    currentState : null,
    /**
     * to call one time when the full html page loads
     */
    init:function(){
        if(++Application.initTimes>1){
            var sentence="Application.init() : mmm it's not a good idea to do it.";
            alert(sentence);
        //console.log(sentence);
        }
        Fields.initControlers();
        Application.initHistory();
        Application.initAfterAjax();
             
    },
    /**
     * to call after ajax loads...try to keep it minimal please!
     */
    initAfterAjax:function(jq){
        if(!jq){
            jq=JQ.bo;
        }
        //console.log("-------------------initAfterAjax-------------------")
        jq.find("a[rel=popover]").popover();
        jq.find("a[rel=popover-bottom]").popover( {
            placement: "bottom"
        } );       
        jq.find("[rel=tooltip]").tooltip();       
        jq.find("[rel=tooltip-bottom]").tooltip( {
            placement: "bottom"
        } );       
        Fields.Text.autoHeightTextareas();
        
        

            
       
       
        FileUploader.init();
    },
    /**
     * to call, just before a dom replacement
     */
    initBeforeAjax:function(){
        Application.removeAllToolTip(); //cause they can stay active and they will not be removable after 
    },
    
    removeAllToolTip : function() {
        $(".tooltip").remove(); 
    },
    /**
     * URL handling
     */
    initHistory:function(){
	
        Application.History = window.History;
        // Check Location
        if ( document.location.protocol === 'file:' ) {
            alert('The HTML5 History API (and thus History.js) do not work on files, please upload it to a server.');
        }

        // Establish Variables
        Application.currentState = History.getState();

        // Bind to State Change
        History.Adapter.bind(window,'statechange',function(){ // Note: We are using statechange instead of popstate		
            // Log the State
            Application.currentState = History.getState(); // Note: We are using History.getState() instead of event.state
            //console.log("statechange "+Application.currentState.title+"----->"+Application.currentState.data.url);
            Application.onChangeUrl(Application.currentState)
        /*History.log('statechange:', State.data, State.title, State.url);*/
        });
    },
    loading : function (state) {        
        var el=$(Application.CTRL.LOADING_MAIN);        
        if( state == true ) {
            el.addClass("active");
        } else {
            el.removeClass("active"); 
        }
    },
    loadingProgress:function(current,total){
        var el=$("#application-loading-progress")
        if(current<total){
            el.css("display","block");
            el.find(".bar").css("width",Utils.rapport(current, total, 100, 0, 0)+"%")
        }else{
            el.css("display","none");    
        }
        
    },
    setLanguage : function( langId ) {
        Application.langId = langId;
        Cookie.createCookie("extranet_langue", langId, 10);
	
    },
    refresh : function () {
        Application.onChangeUrl(Application.currentState);
    },
    postSaveOnSuccess : function ( json,me ) {
        Api.processMessage(json, Application.currentModel);
    },
    gotoUrl:function(url,ajaxTarget ){
        //console.log("gotoUrl "+url);        
        Application.allModalsVisible(false);
        Application.removeAllToolTip();
	
        if(Application._confirmBeforeAjax){
            if(!confirm(Application._beforeAjaxPrompt)){
                return;
            }else{
                Application._confirmBeforeAjax=false; //reset the confirm to not ask again to the user on the onChangeUrl function
            }
        }
        
        History.pushState({
            url:url,
            ajaxTarget:ajaxTarget
        }, url, url);
    },
    onChangeUrl:function(state){        
        //console.log( state)        
        var ajaxTarget = state.data.ajaxTarget;
        if(Application._confirmBeforeAjax){
            if(!confirm(Application._beforeAjaxPrompt)){
                Application.loading(false);
                return;
            }else{
                Application._confirmBeforeAjax=false; //reset the confirm to not ask again to the user on the onChangeUrl function
            }
        }
        //console.log("onChangeUrl "+state.url);
        
        var ajaxReceiver = JQ.bo.find("[data-ajax-receiver='"+ajaxTarget+"']");
        if( ajaxReceiver.length > 0 ) {
            Application.loadingElement(ajaxReceiver, true);
        } else {
            Application.loading(true);
        }
        setTimeout(function(){
            $.ajax({   
                type: "POST",
                url: state.url,
                cache:false,
                success:function(stuff){
                    try{
                        var obj = jQuery.parseJSON(stuff);
                        if( Application.checkLogin(obj) == false) {
                            return false;
                        }
                    }
                    catch(e)
                    {
                    }                    
                    
                    Application.loading(false);
           
                    var targetInAjax = $(stuff).find("[data-ajax-receiver='"+ajaxTarget+"']");
           
                    if( ajaxReceiver.length > 0 && targetInAjax.length > 0) {
                        ajaxReceiver.html(targetInAjax.html());
                        Application.loadingElement(ajaxReceiver, false);
                    } else {
                        JQ.root.empty();
                        JQ.root.scrollTop(0);
                        JQ.root.html(stuff);
                    }
                
                    var pageJsonData = jQuery.parseJSON( JQ.root.find( Application.CTRL.Page_JSON ).html());
                    if( pageJsonData ) {
                        document.title = pageJsonData.title;                
                        $('meta[name=keywords]').attr('content', pageJsonData.keywords);
                        $('meta[name=description]').attr('content', pageJsonData.description);
                    } 
	   
                    Application.initAfterAjax();
                }
            });
        },500);
    //console.log("delayed refreshh")
    },
    
    _beforeExitUploads:0,
    _beforeExitChange:false,
    /**
     * set the "thereIs" argument to true if you want to prompt the user before leaving the page.
     */ 
    thereIsSomethingToSave:function(thereIs){
        Application._beforeExitChange=thereIs;
        Application._updateBeforeExit();
    },
    /**
     * to call when adding an upload, it will prompt the user if he wants to leave the project.
     */
    addBeforeExitUpload:function(){
        Application._beforeExitUploads++;
        Application._updateBeforeExit();
    },
    /**
     * to call when an upload is complete, it will not prompt the user if when he will leave the project...if there is no more uploads.
     */
    removeBeforeExitUpload:function(){
        Application._beforeExitUploads--;
        if(Application._beforeExitUploads<0){
            Application._beforeExitUploads=0;
        }
        Application._updateBeforeExit();
    },
    /**
     * DO NOT CALL IT outside the application class. Use thereIsSomethingToSave() or addBeforeExitUpload() or removeBeforeExitUpload()
     */
    _updateBeforeExit:function(){
        Application._beforeExitPrompt="Mmmmmm...\n\n";
        Application._beforeAjaxPrompt="Mmmmmm...\n\n";
        Application._confirmBeforeExit=false;
        Application._confirmBeforeAjax=false;

        if(Application._beforeExitChange){
            Application._beforeExitPrompt+="Some modifications are not saved. \n\n" 
            Application._beforeAjaxPrompt+="Some modifications are not saved. \n\n"
            Application._confirmBeforeExit=true;
            Application._confirmBeforeAjax=true;
        }
        if(Application._beforeExitUploads>0){
            Application._beforeExitPrompt+="There is currently "+ Application._beforeExitUploads+" uploads. \n\n";
            Application._confirmBeforeExit=true;
        }
        //Application._beforeExitPrompt+="Are you sure you want to leave this page? " 
        Application._beforeAjaxPrompt+="Are you sure you want to leave this page? " 
	
        //set or no the confirm dialog when the user will leave the page.
        if(Application._confirmBeforeExit){
            window.onbeforeunload = function() {
                return Application._beforeExitPrompt
            }	
        }else{
            window.onbeforeunload=null;
        }
    },
    /**
     * do not set this variable outside this class
     */
    _confirmBeforeAjax:false,
    /**
     * do not set this variable outside this class
     */
    _confirmBeforeExit:false,
    /**
     * do not set this variable outside this class
     */
    _beforeExitPrompt:"Before exit document message if not saved or uploads in progress",
    /**
     * do not set this variable outside this class
     */
    _beforeAjaxPrompt:"Before exit page on ajax message if not saved",    
    
    allModalsVisible : function ( visible ) {
        visible =  ( visible == true ) ? "show" : "hide";        
        $(ModalsManager.CTRL.MODAL_POSTS).modal(visible); 
        $(ModalsManager.CTRL.MODAL_CATEGORIES).modal(visible); 
        $(ModalsManager.CTRL.MODAL_VIDEOS).modal(visible); 
    },
    
    updateNav : function () {
        var navContent = JQ.bo.find(Application.CTRL.NAV_CONTENT);
        var url = navContent.attr(Model.CTRL.TEMPLATE);
        $.ajax({   
            type: "GET",
            url: url,
            dataType: 'html',
            success: function(content) {
                navContent.html()
                navContent.html(content)
              
            }
        });        
    },
    checkLogin : function (ajax) {
        if( ajax.success == false && ajax.isLogged == false ) {
            if( ajax.redirect ) {
                document.location = ajax.redirect;
            } else {
                document.location = Config.dashboardUrl;
            }
            return false;
        }
    }
}

Application.loadingElement = function (element, state) {
    if( state == true ) {
        element.css("opacity","0.2");
    } else {
        element.css("opacity","1");
    }
}


/*---------------------------------- CTRL -------------------------------*/

Application.CTRL={
    
    LOADING_MAIN:"[data-admin-loading='main']",
    /**
     * will performs a main page change in ajax via History url
     */
    AJAX_LINK:"a[data-is-ajax='true']:not([data-is-ajax='false']), [data-is-ajax='true'] a:not([data-is-ajax='false'])",
    /**
     * will performs a picture slection in the file system and an upload
     */
    PHOTO_RECTANGLE_UPLOAD:"data-photo-rectangle-upload",
    
    VIDEO_TRADS_UPLOAD:"data-video-trads-upload",
    SUBTITLE_TRADS_UPLOAD:"data-subtitle-trads-upload",
    /**
     *
     */
    LIST_VIEW_CONTAINER:".list-view-container",
    LIST_VIEW_SET_LIST:"a[href='#ListView.list']",
    LIST_VIEW_SET_LARGE:"a[href='#ListView.large']",
    LIST_VIEW_SET_SMALL:"a[href='#ListView.small']",
    
    //MODAL_POSTS : "#modal-posts",
    //MODAL_VIDEOS : "#modal-videos",
    DATE_PICKER : ".date-picker",
    /**
     * set a language for extranet
     */
    SET_LANGUAGE : "a[href='#Application.setLanguage']",
    
    NAV_CONTENT : "#nav-content",
    
    /**
     * set an actiovation for alol input radio
     */
    ACTIVATION_SET : "a[href='#Actiovation.set']",
    /*
     * Json data container in the page html 
     */
    Page_JSON:"#page_json",
    
    /*
     * Sortable items class name
     */
    SORTABLE_LIST : ".list-sortable",
    
    /**
     * click conformation dialog
     */
    LINK_CONFIRM : "data-link-confirm"
}

JQ.bo.on("click", Application.CTRL.ACTIVATION_SET, function(e){
    e.preventDefault();
    var elem = $(this);
    var typeActiovation = elem.attr("data-value");
    $(this).closest("tr").find("[data-value='"+typeActiovation+"']").attr('checked', true);
    
    var mainModel=Model.getParent( elem );
    mainModel.needToBeRecorded(true);
})

$("[data-radio-need-to-record='true']:radio").change(function() {
    var mainModel=Model.getParent($(this));
    mainModel.needToBeRecorded(true)
});

JQ.bo.on("click", Application.CTRL.SET_LANGUAGE, function(e){
    e.preventDefault();
    var elem = $(this);
    Application.setLanguage( new Model(elem).id() );
    if($(this).closest(".modal").length>0){
        //console.log("modal");
        Model.getParent(elem).refresh();
    }else{
        //console.log("main");
        Application.refresh();
    }
    
})

JQ.bo.on("click","a[href='#upload-file']",function(e){
    e.preventDefault();
    e.stopPropagation();
    FileUploader.init();
    FileUploader.open();    
})

JQ.bo.on("click","a[href='#edit-model']",function(e){
    e.preventDefault();
    e.stopPropagation();
    PhotoSelector.init();
    PhotoSelector.open();    
})

JQ.bo.on("click",Application.CTRL.AJAX_LINK,function(e){
    console.log("ajax link");
    e.preventDefault();
    e.stopPropagation();
    var elem = $(this);
    var ajaxTarget = elem.attr("data-ajax-target");
    if( ajaxTarget ) {
        //JQ.bo.find("[data-ajax-target='"+$(this).attr("data-ajax-target")+"']").parent().removeClass("active");        
        JQ.bo.find(".active").removeClass("active");        
        JQ.bo.find("[href='" + elem.attr("href")+"']").parent().addClass("active");
    }
    var targetLang = elem.attr("data-target-language")
    if(targetLang){
        Application.setLanguage(targetLang);
    }
    
    Application.gotoUrl(elem.attr("href"), ajaxTarget);
})




/*---------------start----------------------*/
Application.init();