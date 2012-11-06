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
        inside.addClass("marged");

        this.setLoading=function(){

            TweenMax.to(window, 1, {scrollTo:{y:0}, ease:Power2.easeOut});

            //console.log(target);
            target.addClass("loading-box");
            //target.addClass("span8");
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
    Nav.init();
    Press.initAfterAjax();
}

Press.initAfterAjax = function() {
    Nav.autoLoads();
    Share.init();
}

Press.setActiveTab=function(tab){
    $("[data-main-tab]").removeClass("active");
    $("[data-main-tab='"+tab+"']").addClass("active");
}

Press.init();

//------------------slider-----------------------
Press.Slider=function(jq){
    var me=this;
    var jq=$(jq);

    var moved=jq.find(".move")
    var pagination=jq.find(".pagination")
    var prevBtn=jq.find(".prev")
    var nextBtn=jq.find(".next")
    /**
     *
     * @return {number} The unity for ech movement
     */
    this.moveByValue=function(){
        var el=$(jq.find(".span2 .marged .marged")[1]);
        //one element size * number of elements for each box -4 because the border :\
        console.log("el.width()="+Utils.numberCss(el.css("width")))
        return Utils.numberCss(el.css("width"))*4;
    }
    this.getPos=function(){
       return Utils.numberCss(moved.css("margin-left"));
    }
    this.roundPos=function(){
        var pos=Math.round(me.getPos()/me.moveByValue());
        //console.log(me.getPos());
        //console.log(me.moveByValue());
        console.log("-----");
        console.log(pos);
    }
    this.prev=function(){
        TweenMax.to(moved,0.5,
            {css:{
                "margin-left":me.getPos()+me.moveByValue()
                },
                onComplete:function(){
                    me.roundPos()
                }
            });
    }
    this.next=function(){
        TweenMax.to(moved,0.5,
            {
                css:{
                "margin-left":me.getPos()-me.moveByValue()
                },
                onComplete:function(){
                    me.roundPos()
                }
            }
        );
    }

}
/**
 *
 * @param el
 * @return {Press.Slider}
 */
Press.Slider.getParent=function(el){
    var dom=$(el).closest("[data-slider='true']");
    return new Press.Slider(dom);
}

Dom.body.on("click","[href='#Press.Slider.prev()']",function(e){
    e.preventDefault();
    var slider=Press.Slider.getParent($(this));
    slider.prev();
})
Dom.body.on("click","[href='#Press.Slider.next()']",function(e){
    e.preventDefault();
    var slider=Press.Slider.getParent($(this));
    slider.next();
})



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

