/**
 * Created with JetBrains PhpStorm.
 * User: francoisrai
 * Date: 24/10/12
 * Time: 15:50
 * To change this template use File | Settings | File Templates.
 */
var Nav = {
    History : null,
    currentState : null,
    goToUrl : function(url, target) {
        // change url
        Nav.History.pushState({
            url:url,
            target:target
        }, url, url);

    },
    /**
     * flag, if set to true the url can change, but no ajax will be performed
     */
    disableLoadOnStateChange:false,
    /**
     * initialize the stuff
     */
    init: function() {
        Nav.initHistory();
        try{
        if(Api){
            Api.events.addEventListener("onChange", Nav.onApiChange);
        }}catch(e){}
    },
    /**
     * Launched when the API (admin) do something in dom. When it happen maybe the url should change (cause it's not managed in the api).
     * @param {Api.EventOnChange} apiEvent
     */
    onApiChange:function(apiEvent){
        if(apiEvent.controllerUrl){
            //if the api Event provide an url it means that we used an url to display stuff in dom.
            //so we will change the url (in the browser bar) but we will prevent the ajax call cause the api did it before.
            Nav.disableLoadOnStateChange=true;
            Nav.goToUrl(apiEvent.controllerUrl,null,true);
            Nav.disableLoadOnStateChange=false;

        }
        //in all cases, we need to re-init the dom objects
        Press.initAfterAjax();
    }
}

/**
 * URL handling
 */
Nav.initHistory = function(){

    Nav.History = window.History;
    // Check Location
    if ( document.location.protocol === 'file:' ) {
        alert('The HTML5 History API (and thus History.js) do not work on files, please upload it to a server.');
    }

    // Establish Variables
    Nav.currentState = History.getState();

    // Bind to State Change
    History.Adapter.bind(window,'statechange',function(){ // Note: We are using statechange instead of popstate
        if(Nav.disableLoadOnStateChange){
            console.log("url changed but no ajax loading where performed");
            return;
        }
        // Log the State
        Nav.currentState = History.getState(); // Note: We are using History.getState() instead of event.state
        //console.log("statechange "+Application.currentState.title+"----->"+Application.currentState.data.url);

        var target = Nav.currentState.data.target;

        target = $("[data-nav-ajax-receiver='" + target + "']");

        if (target.length <= 0) {
            target = Dom.main;
        }

        //console.log(target);

        var loader = new Nav.Loader(Nav.currentState.url, target);
        var loading = new Press.Loading(target);

        loading.events.addEventListener("onStateLoading", function() {
            loader.start();
        });

        loader.events.addEventListener("loaded", function() {
            loading.setNormal();
            Press.initAfterAjax();
        })

        loading.setLoading();

        /*History.log('statechange:', State.data, State.title, State.url);*/
    });
}

Nav.Loader = function(url, target) {
    this.events = new EventDispatcher();
    var me = this;

    this.start=function(){
        //me.events.dispatchEvent("startLoading");
        $.ajax({
            type: "POST",
            url: url,
            data: {},
            success:
                function (response){
                    target.html(response);
                    me.events.dispatchEvent("loaded");
                }
        });
    }
}

Nav.autoLoads = function() {
    var all =  $("[" + Nav.CTRL.AJAX_AUTOLOAD + "]");

    var elem;

    for(var i = 0; i < all.size(); i++) {
        elem = $(all[i]);

        Nav.navAutoLoadOne(elem);
    }
}

Nav.navAutoLoadOne = function(elem) {
    var loader;
    var url;

    url = elem.attr(Nav.CTRL.AJAX_AUTOLOAD);
    loader = new Nav.Loader(url, elem);
    loader.start();

    elem.attr(Nav.CTRL.AJAX_AUTOLOAD + "Loaded", url);
    //elem.removeAttr(Nav.CTRL.AJAX_AUTOLOAD);

    var loading = new Press.Loading(elem);

    loading.setLoading();

    loader.events.addEventListener("loaded", function() {
        loading.setNormal();
    });
}

Nav.CTRL =  {
    AJAX_LINK : "[data-nav-is-ajax]",
    AJAX_TARGET : "data-nav-is-ajax-target",
    AJAX_RECEIVER : "[data-nav-ajax-receiver]",
    AJAX_AUTOLOAD : "data-nav-ajax-autoload",
    ITEM_NAV : "[data-is-item-nav]"
}

Dom.body.on("click", Nav.CTRL.AJAX_LINK, function(ev) {
    ev.preventDefault();
    var elem=$(this);
    if(!elem.attr("href")){
        elem=$(elem.find("a")[0]);
    }
    var target = elem.attr(Nav.CTRL.AJAX_TARGET);
    //console.log(target);
    Nav.goToUrl(elem.attr("href"), target);
})

Dom.body.on("click", Nav.CTRL.ITEM_NAV, function(ev) {
    ev.preventDefault();
    $(".navBarComponent").find(".item-nav").each(function(){
        $(this).removeClass("active");
    });

    $(this).closest("div.item-nav").addClass("active");
})

