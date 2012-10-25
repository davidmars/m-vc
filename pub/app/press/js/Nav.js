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

    init: function() {
        Nav.initHistory();
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

Nav.CTRL =  {
    AJAX_LINK : "[data-nav-is-ajax]",
    AJAX_TARGET : "data-nav-is-ajax-target",
    AJAX_RECEIVER : "[data-nav-ajax-receiver]"
}

Dom.body.on("click", Nav.CTRL.AJAX_LINK, function(ev) {
    ev.preventDefault();
    var target = $(this).attr(Nav.CTRL.AJAX_TARGET);
    //console.log(target);
    Nav.goToUrl($(this).attr("href"), target);
})