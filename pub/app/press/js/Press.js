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

        this.setLoading=function(){
            console.log(target);
            target.addClass("loading-box posts");
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
