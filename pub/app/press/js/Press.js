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
            Loader.show();

            TweenLite.to(
                target,
                1,
                {
                    css:{opacity:"0"},
                    y:0,
                    //alpha:0,
                    ease:Linear.easeNone,
                    onComplete:function(){
                        me.events.dispatchEvent("onStateLoading");
                    }
                }
            );
        }



        this.setNormal=function(){

            Loader.hide();

            TweenLite.to(
                target,
                1,
                {
                    css:{opacity:"1"},
                    //alpha:0,
                    ease:Linear.easeNone
                }
            );
        }

    }
}

var Loader =  {
    cl:null,

    init:function(){

        this.cl = new CanvasLoader('canvasloader-container');

        this.cl.setDiameter(20); // default is 40
        this.cl.setDensity(20); // default is 40
        this.cl.setRange(1); // default is 1.3
        this.cl.setSpeed(1); // default is 2
        this.cl.setFPS(20); // default is 24

    },

    show:function() {
        this.cl.show();
    },

    hide:function(){
        this.cl.hide();
    }
}

Press.init = function() {
    Nav.init();
    Loader.init();
}

Press.initAfterAjax = function() {

}

Press.init();
