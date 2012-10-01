var ShicTween={
    startSequencesFromDom:function(jq){
        var sequences=jq.find(ShicTween.CTRL.SEQUENCE);
        var f;
        for(var i=0;i<sequences.length;i++){
            f=$(sequences[i]);
            if(!f.attr("data-shictween-sequence-init")){
                new ShicTween.Sequence(f);
            }
        }
    }
}

ShicTween.CTRL={
    SEQUENCE:"[data-shictween-sequence]"
}
/**
 * display childrens in an opacity sequence.
 */
ShicTween.Sequence=function(jq){
    var jq=$(jq);
    var tl;
    var childs=jq.children();
    var init=function(){
        if(jq.attr("data-shictween-sequence-init")){
            return;
        }else{
            jq.attr("data-shictween-sequence-init","true");
            create();
        }
    }
    
    var create=function(){
        
        tl = new TimelineMax({repeat:-1});
        var c;
        for (i=0;i<childs.length;i++){
            c=$(childs[i]);
            c.data("originalDisplay",c.css("display"));
            c.css("display","none")
        }
        for (var i=0;i<childs.length;i++){
            c=$(childs[i]);
            tl.to(c, 1, {css:{
                    opacity:1,
                    display:c.data("originalDisplay")
            }});
            tl.to(c, 0.0001, {css:{
                    opacity:0,
                    display:"none"
            }});
        }
        tl.call(function(){
            if(!JQ.isInDom(jq)){
                tl.clear();
            }
        });
        tl.call(function(){/*console.log("i'm running "+childs)*/});
        
    }
    if(childs.length>1){
        init();
    }
    return {
        /**
         * TimelineMax
         */
        timeline:tl,
        jq:jq
    }
    
    
}



