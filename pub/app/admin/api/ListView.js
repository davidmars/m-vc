var ListView ={
    setView:function(button,classToApply){
        var container=button.closest(ListView.CTRL.LIST_VIEW_CONTAINER);
        container.removeClass("list-view-container-large");
        container.removeClass("list-view-container-small");
        container.removeClass("list-view-container-list");
        container.addClass(classToApply);
        container.find(ListView.CTRL.LIST_VIEW_SET).removeClass("active");
        button.addClass("active");
        Cookie.createCookie(container.attr( Model.CTRL.DATA_MODEL_TYPE ) + "|ListView", classToApply)
    }
}

ListView.CTRL={
    LIST_VIEW_CONTAINER:".list-view-container",
    LIST_VIEW_SET:"a[href='#ListView']"
}

JQ.bo.on("click",ListView.CTRL.LIST_VIEW_SET,function(e){
    var elem = $(this);
    e.preventDefault();
    e.stopPropagation();
    ListView.setView(elem, elem.attr("data-list"));
})