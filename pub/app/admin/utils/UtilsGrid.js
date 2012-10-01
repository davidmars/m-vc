var UtilsGrid={
    /**
     * Va donner à l'élément el une hauteur qui sera au minimum égale à sa hauteur normale et qui est un multiple de multiple.
     */
    setHeigthMultipleOf:function(el,multiple){
        var h=0;
        el.css("height","");
        var realHeight=el.height();
        var newH=Math.ceil(realHeight/multiple)*multiple;
        newH=newH-Utils.numberCss(el.css("margin-top"));
        newH=newH-Utils.numberCss(el.css("margin-bottom"));
        el.css("height",newH);
    }
}


