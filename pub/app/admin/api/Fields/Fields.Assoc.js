Fields.Assoc={
    move:function(where,model){
        if(where=="before"){
            model.jq.insertBefore(model.jq.prev())
        }else{
            model.jq.insertAfter(model.jq.next())
        }
        model.jq.fadeOut();
        model.jq.fadeIn(500);
    }
 
}
Fields.Assoc.CTRL={
    MOVE:"[href='#Assoc.move']",
    MOVE_ATTR_ARGUMENT:"data-move"
}
JQ.bo.on("click",Fields.Assoc.CTRL.MOVE,function(e){
    e.preventDefault();
    var m=Model.getParent($(this));
    var moveWhere=$(this).attr(Fields.Assoc.CTRL.MOVE_ATTR_ARGUMENT)
    Fields.Assoc.move(moveWhere,m);
    
})