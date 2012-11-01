/**
 * Created with JetBrains PhpStorm.
 * User: francoisrai
 * Date: 24/10/12
 * Time: 15:47
 * To change this template use File | Settings | File Templates.
 */
var Press = {

    Loading:function(target) {

        target = $(target);
        this.events=new EventDispatcher();
        var me = this;
        var inside = $("<div/>");
        inside.addClass("loading-box-inside");
        //inside.addClass("padded");

        this.setLoading=function(){
            console.log(target);
            target.addClass("loading-box");
            //target.addClass("span8");
            target.append(inside);

            TweenLite.to(
                target,
                1,
                {
                    css:{
                        height:"400px"
                    },
                    ease:Linear.easeNone,
                    onComplete:function(){
                        me.events.dispatchEvent("onStateLoading");
                    }
                }
            );
        }



        this.setNormal=function(){
            target.removeClass("loading-box");
            target.removeClass("posts");

            TweenLite.to(
                target,
                1,
                {
                    css:{
                        height:"auto"
                    },
                    ease:Linear.easeNone,
                    onComplete:function(){
                        inside.remove();
                    }
                }
            );
        }

    }
}

Press.init = function() {
    Nav.init();
    Press.initAfterAjax();
}

Press.initAfterAjax = function() {
    Nav.autoLoads();
    Share.init();
}

Press.init();


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
    if(url=="close"){
        PopInLoader.close();
    }else{
        PopInLoader.open(url);
    }


})

