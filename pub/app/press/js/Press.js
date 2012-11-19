/**
 * Created with JetBrains PhpStorm.
 * User: francoisrai
 * Date: 24/10/12
 * Time: 15:47
 * To change this template use File | Settings | File Templates.
 */
var Press = {
    /**
     * An object to performs loading transition between two pages. Loading are performed in two steps.
     * @param target
     * @constructor
     */
    Loading:function(target) {

        target = $(target);
        this.events=new EventDispatcher();
        var me = this;
        var inside = $("<div/>");
        inside.addClass("loading-box-inside");
        inside.addClass("marged");

        /**
         * Show the loading, when the transition is done, it will run the "onStateLoading" event
         */
        this.setLoading=function(){
            TweenMax.to(window, 1, {scrollTo:{y:0}, ease:Power2.easeOut});
            target.addClass("loading-box");
            target.append(inside);
            TweenLite.fromTo(
                inside,
                0.5,
                {css:{opacity:0}},
                {css:{opacity:"1"},
                    ease:Linear.easeNone,
                    onComplete:function(){
                            me.events.dispatchEvent("onStateLoading");
                    }
                }
            );

        }


        /**
         * Ends the loading
         */
        this.setNormal=function(){
            target.append(inside);

            TweenLite.to(
                inside,
                0.5,
                {
                    css:{opacity:0},
                    ease:Linear.easeNone,
                    onComplete:function(){
                        target.removeClass("loading-box");
                        inside.remove();
                    }
                }
            );
        }

    }
}

Press.init = function() {
    $(window).on("resize",function(){
        Press.onResize();
    })
    Nav.init();
    Press.initAfterAjax();
}

Press.initAfterAjax = function() {
    Nav.autoLoads();
    Share.init();
    Press.Slider.init();

    /* It's resolved youtube modal problem for IE8 */
    Press.setEmbedAttr();

    Press.setMetaData();
}
Press.onResize=function(){
    Press.Slider.resize();
}

Press.setActiveTab=function(tab){
    $("[data-main-tab]").removeClass("active");
    $("[data-main-tab='"+tab+"']").addClass("active");
}

Press.setMetaData=function(){
    //console.log("set the meta");

    var title = $("title");
    var metaTitle = Dom.body.find("[data-meta-title]").first();
    var metaText = metaTitle.text();
    title.text(metaText);
}

Press.setEmbedAttr=function(){
    $('iframe').each(function() {
        var url = $(this).attr("src");
        var char = "?";
        if(url.indexOf("?") != -1)
            var char = "&";

        $(this).attr("src",url+char+"wmode=transparent");
    });
}

var PopInLoader={
    main:$("#popinloader"),
    content:$("#popincontent"),
    open:function(url){
        PopInLoader.main.addClass("active");
        $.ajax({
            type: "POST",
            url:  url,
            data: {},
            success:
                function (ajaxReturn){
                    var newDom=$(ajaxReturn);
                    PopInLoader.content.append(newDom);
                    Form.init();
                }
        });
    },
    close:function(){
        PopInLoader.content.empty();
        PopInLoader.main.removeClass("active");
    }


}

Dom.body.on("click","[data-popinloder]",function(e){
    e.preventDefault();
    el=$(this);
    url=el.attr("data-popinloder");

    // for other pop in come from club
    if (url == "") {
        popName = el.attr('data-is-popin');
        popin = $("#" + popName);
        url = popin.attr("link");
    }

    if(url=="close"){
        PopInLoader.close();
    }else{
        PopInLoader.open(url);
    }


})

