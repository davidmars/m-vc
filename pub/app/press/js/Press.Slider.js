/**
 * A slider object used in the media section.
 * This object assume a lot of html/ajax/php logic, so it will be usable only on the havana club pressroom project
 * @param jq
 * @constructor
 */
Press.Slider=function(jq){
    var me=this;
    var jq=$(jq);

    var moved=jq.find(".move")
    var pagination=jq.find(".pagination")
    var prevBtn=jq.find(".prev")
    var nextBtn=jq.find(".next")
    /**
     *
     * @return {number} The unity for each movement
     */
    this.moveByValue=function(){
        var el=$(jq.find(".span2 .marged .marged")[1]);
        //one element size * number of elements for each box
        return Utils.numberCss(el.css("width"))*4;
    }
    /**
     *
     * @return {Number} Return the current position in pixel
     */
    this.getPos=function(){
        return Utils.numberCss(moved.css("margin-left"));
    }
    /**
     *
     * @return {number} the number of pages
     */
    var totalPages=function(){
        var total=jq.find("[href='#Press.Slider.toPage()']").length;
        return total;
    }
    /**
     *
     * @return {Number} the current page index (the first is 0)
     */
    var getCurrentPage=function(){
        var total=totalPages();
        var currentPage=Math.ceil(Utils.rapport(me.getPos(),-total*me.moveByValue(),total,0,0));
        return currentPage;
    }
    /**
     * put the slider to a rouded value to be sure that the elements fit the grid.
     */
    var roundPos=function(){
        var pos=Math.round(me.getPos()/me.moveByValue())*me.moveByValue();
        moved.css("margin-left",pos);
        getCurrentPage();
    }
    var enableAll=function(){
        enableBtn(pagination.find("a"));
    }
    var disableBtn=function(jq){
        jq.css("opacity",0.2);
    }
    var enableBtn=function(jq){
        jq.css("opacity",1);
    }
    var setActiveBtn=function(jq,active){
        if(active){
            jq.addClass("active");
            jq.css("color","#000");
        }else{
            jq.removeClass("active");
            jq.css("color","");
        }
        jq.css("opacity",1);
    }
    var updateNav=this.updateNav=function(){
        enableAll();
        setActiveBtn(jq.find("[data-page]"),false);
        if(me.getPos()>=0){
            disableBtn(prevBtn);
        }
        if(getCurrentPage()>=totalPages()-1){
            disableBtn(nextBtn);
        }
        setActiveBtn(jq.find("[data-page='"+getCurrentPage()+"']"),true);
    }


    /**
     * move the slider to the specified value.
     * @param pos
     */
    var moveTo=function(pos){
        TweenMax.to(moved,0.5,
            {css:{
                "margin-left":pos
            },
                onComplete:function(){
                    roundPos()
                    updateNav();
                }
            });
    }
    /**
     * move right
     */
    this.prev=function(){
        var pos=me.getPos()+me.moveByValue();
        moveTo(pos);
    }
    /**
     * move left
     */
    this.next=function(){
        var pos=me.getPos()-me.moveByValue();
        moveTo(pos);
    }
    /**
     * Move to a position according a pagination index.
     * @param page {int}
     */
    this.toPage=function(page){
        var pos=-me.moveByValue()*page;
        moveTo(pos);
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
/**
 * initialize nav for all sliders in the dom
 */
Press.Slider.init=function(){
    var all=$("[data-slider='true']");
    var sl;
    for(var i=0;i<all.length;i++){
        sl=new Press.Slider(all[i]);
        sl.updateNav();
    }
}
/**
 * give correct position to all sliders
 */
Press.Slider.resize=function(){
    var all=$("[data-slider='true']");
    var sl;
    for(var i=0;i<all.length;i++){
        sl=new Press.Slider(all[i]);
        sl.toPage(0);
    }
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
Dom.body.on("click","[href='#Press.Slider.toPage()']",function(e){
    e.preventDefault();
    page=$(this).attr("data-page");
    var slider=Press.Slider.getParent($(this));
    slider.toPage(page);
})