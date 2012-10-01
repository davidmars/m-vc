var JQ = {
    bo : $("body"),
    win : $(window),
    root:$("#root"),
    isInDom:function(jq){
        return($(jq).parents("body").length>0);
    }
}