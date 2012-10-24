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

        this.setLoading=function(){
            //target.addClass("isLoading");
            TweenLite.to(
                target,
                1,
                {css:{
                    rotation:"45",
                    backgroundColor:"#FFFF00"
                }, ease:Power2.easeOut,
                    onComplete:function(){
                        me.events.dispatchEvent("onStateLoading");
                    }
                }
            );
        }



        this.setNormal=function(){
            TweenLite.to(
                target,
                1,
                {css:{
                    rotation:"0",
                    backgroundColor:"#FF00FF"
                }, ease:Power2.easeOut,
                    onComplete:function(){
                        me.events.dispatchEvent("onStateNormal");
                    }
                }
            );
        }

    }
}

Press.init = function() {
    Nav.init();
}

Press.initAfterAjax = function() {

}

Press.init();
