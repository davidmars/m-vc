ModelBrowser = function(selectorDom){
    var me = this;
    this.selectorDom = selectorDom;
    this.dataModelTemplate =  this.selectorDom.attr( Model.CTRL.TEMPLATE );
    this.dataModelType = this.selectorDom.attr( Model.CTRL.DATA_MODEL_TYPE );
    this.pageIndex = 1;
    this.dataSelection = "all";
    this.dataSelectionArgument = null;
    this.orderBy = "created";
    this.orderByDirection = "desc";    
    this.sortable = false;   
    this.refresh = function () {
        this.refreshClassification();
        this.refreshContent();
    }
   
    this.selector = function() {
        var selec;
        switch(this.dataModelType) {
            case "Photo":
                selec = PhotoSelector;
                break;
            case "Video":
                selec = VideoSelector;
                break;
            case "Post":
                selec = PostSelector;
                break;
            case "Category":
                selec = CategorySelector;
                break;
        }
        
        return selec;
    }
   
    this.refreshClassification = function () {
        var classification = me.selector().dom.find( ModelBrowser.CTRL.CLASSIFICATION_TARGET )
        classification.css("opacity","0.2");
       
        $.ajax({
            type: "POST",
            url: classification.attr( Model.CTRL.TEMPLATE )
        }).done(function( stuff ) {
            var classificationStuff = $(stuff).filter( ModelBrowser.CTRL.CLASSIFICATION_TARGET );
            var classification = me.selectorDom.find( ModelBrowser.CTRL.CLASSIFICATION_TARGET )
            classification.html(classificationStuff);            
            
            var s = classification.find("["+ ModelBrowser.CTRL.DATA_SELECTION +"='"+ me.dataSelection +"']["+ ModelBrowser.CTRL.DATA_SELECTION_ARGUMENT +"='"+ me.dataSelectionArgument +"']");
            s.closest(".modal-left").find(".active").removeClass("active");
            s.parent().addClass("active");
            
            classification.css("opacity","1");
        });
    }
    
    this.refreshContent = function( ) {
        var datas = {
            pageIndex : this.pageIndex,
            dataSelection : this.dataSelection,
            dataSelectionArgument : this.dataSelectionArgument,
            orderBy : this.orderBy,
            orderByDirection : this.orderByDirection            
        }

        var list = me.selector().dom.find( ModelBrowser.CTRL.LIST_TARGET);     
        list.css("opacity","0.2");
        
        $.ajax({
            type: "POST",
            url: this.dataModelTemplate,
            data: datas
        }).done(function( stuff ) {
            var paginatorStuff = $(stuff).filter( ModelBrowser.CTRL.PAGINATOR_TARGET );            
            me.selectorDom.find( ModelBrowser.CTRL.PAGINATOR_TARGET ).html(paginatorStuff);
            
            var listStuff = $(stuff).filter( ModelBrowser.CTRL.LIST_TARGET );
            var list = me.selectorDom.find( ModelBrowser.CTRL.LIST_TARGET);

            list.empty();
            list.scrollTop(0);
            list.html(listStuff);
            list.css("opacity","1");            
            
            var listContent = list.find(ModelBrowser.CTRL.DATA_MODELS_LIST_SORTABLE);
            
            if(me.sortable == true) {
                
                listContent.addClass("list-sortable");
                
                if( me.dataSelection == "category" ) {
                    list.attr( Model.CTRL.DATA_UPDATE_URL, "Tag/" + me.dataSelectionArgument);
                    list.attr( Model.CTRL.DATA_MODEL_ID, me.dataSelectionArgument);
                    list.attr( Model.CTRL.DATA_MODEL_TYPE, "Tag");                    
                    
                    listContent.attr( Model.CTRL.DATA_CHILDS_TYPES, me.dataModelType)
                    listContent.attr( Model.CTRL.DATA_FIELD_TYPE, me.dataModelType + "s")
                    listContent.attr( Model.CTRL.DATA_FIELD, "root[categoryPosts]");
                    //listContent.attr( Model.CTRL.DATA_FIELD, "root[posts]");
                }
            } else { 
                list.removeAttr( Model.CTRL.DATA_UPDATE_URL);
                list.removeAttr( Model.CTRL.DATA_MODEL_ID );
                list.removeAttr( Model.CTRL.DATA_MODEL_TYPE);
                listContent.removeAttr( Model.CTRL.DATA_CHILDS_TYPES )
                listContent.removeAttr( Model.CTRLDATA_FIELD_TYPE)
                listContent.removeAttr( Model.CTRL.DATA_FIELD );                    
                listContent.removeClass("list-sortable");
            }
            
            Application.initAfterAjax();
        });
    }
    
    this.setSortable = function( elem ) {
        var dataSortable = elem.attr( ModelBrowser.CTRL.DATA_SORTABLE );
        if( dataSortable == "true") {
            me.sortable = true;
        } else {
            me.sortable = false;
        }
    }
   
    me.selectorDom.on("click", ModelBrowser.CTRL.SET_SELECTION,function(e){       
        e.preventDefault();
        var elem = $(this);
        var dataSelection = elem.attr( ModelBrowser.CTRL.DATA_SELECTION );
        var dataSelectionArg = elem.attr( ModelBrowser.CTRL.DATA_SELECTION_ARGUMENT );

        elem.closest(".modal-left").find(".active").removeClass("active");
        elem.parent().addClass("active");
                
        var browser = me.selector().browseComponent;
        browser.dataSelectionArgument = dataSelectionArg;
        browser.dataSelection = dataSelection;
        browser.pageIndex = 1;
        browser.setSortable(elem);
        browser.refreshContent( );
    })

    me.selectorDom.on("click", ModelBrowser.CTRL.SET_INDEX,function(e){
        e.preventDefault();
        var elem = $(this);
        var dataIndex = elem.attr( ModelBrowser.CTRL.DATA_INDEX );
        var browser = me.selector().browseComponent;
        browser.pageIndex = parseInt(dataIndex);
        browser.setSortable(elem);
        browser.refreshContent( ); 
    })

    me.selectorDom.on("click", ModelBrowser.CTRL.SET_PAGINATOR_NEXT_PRE,function(e){
        e.preventDefault();
        var elem = $(this);
        var dataIndex = elem.attr( ModelBrowser.CTRL.DATA_INDEX );
        var browser = me.selector().browseComponent;
        browser.pageIndex += parseInt(dataIndex);
        browser.setSortable(elem);
        browser.refreshContent( ); 
    })

    me.selectorDom.on("click", ModelBrowser.CTRL.SET_ORDERBY,function(e){
        e.preventDefault();
        var elem = $(this);
        elem.closest(".dropdown-menu").find(".active").removeClass("active");
        elem.parent().addClass("active");
        var orderBy = elem.attr( ModelBrowser.CTRL.DATA_ORDER_BY );
        var browser = me.selector().browseComponent;
        browser.orderBy = orderBy; 
        browser.refreshContent( ); 
    })

    me.selectorDom.on("click",ModelBrowser.CTRL.SET_ORDER_DIRECTION,function(e){
        e.preventDefault();
        var elem = $(this);
        elem.closest(".dropdown-menu").find(".active").removeClass("active");
        elem.parent().addClass("active");
        var orderByDirection = elem.attr( ModelBrowser.CTRL.DATA_ORDER_BY_DIRECTION );
        var browser = me.selector().browseComponent;
        browser.orderByDirection = orderByDirection; 
        browser.refreshContent( ); 
    })
    
    var listViewType = Cookie.getCookie(me.dataModelType + "|ListView");
    if(listViewType != "undefined") {
        ListView.setView( me.selectorDom.find("[data-list='"+listViewType+"']"),listViewType);
    }
    
    if( me.dataModelType == "Post" ) {
        me.selectorDom.find(ModelBrowser.CTRL.SET_ORDERBY + "["+ ModelBrowser.CTRL.DATA_ORDER_BY +"='expirationDate']").closest("li").remove();
    } else {
        me.selectorDom.find(ModelBrowser.CTRL.SET_ORDERBY + "["+ ModelBrowser.CTRL.DATA_ORDER_BY +"='published']").closest("li").remove();
    }
}

ModelBrowser.getSelector = function( element ) {
    //console.log("in getSelector")
    var modal = element.parents(".modal");
    var dataModelType = modal.attr( Model.CTRL.DATA_MODEL_TYPE );
    return ModelBrowser.getSelectorByDataModelType (dataModelType);
}

ModelBrowser.getSelectorByDataModelType = function( dataModelType ) {
    var selector;
    switch(dataModelType) {
        case "Photo":
            selector = PhotoSelector;
            break;
        case "Video":
            selector = VideoSelector;
            break;
        case "Post":
            selector = PostSelector;
            break;
        case "Category":
            selector = CategorySelector;
            break;
    }

    return selector;
}

ModelBrowser.openModal = function ( elem ) {    
    var ModelType = elem.attr( Model.CTRL.DATA_FIELD );
    var selector = ModelBrowser.getSelectorByDataModelType(ModelType);    
    
    switch ( ModelType ) {
        case "Video":
            VideoSelector.onSelectModel=function(model){  
                new ModalVideo(model.id(), {"CloseAfterSave" : true});
            }
            break;
        case "Post":
            break;
        case "Category":
            break;
        case "Photo":
            PhotoSelector.onSelectModel = function(model){
                new ModalPhoto(model.id(), {"CloseAfterSave" : true});
            }
            break;
    }
    
    selector.browseComponent.setSortable(elem);
    
    var dataSelection = elem.attr( ModelBrowser.CTRL.DATA_SELECTION );
    var dataSelectionArg = elem.attr( ModelBrowser.CTRL.DATA_SELECTION_ARGUMENT );
    if( dataSelection ) {
        var browser = selector.browseComponent;
        browser.dataSelectionArgument = dataSelectionArg;
        browser.dataSelection = dataSelection;
        browser.pageIndex = 1;
        if(selector.contentRefreshed == true){
            browser.refreshClassification();
        }
    }
    
    selector.open();    
}

ModelBrowser.refreshModal = function ( ModelType ) {
    var selector = ModelBrowser.getSelectorByDataModelType(ModelType);
    if(selector) {
        selector.refresh();
    }
    /*switch ( ModelType ) {
        case "Video":
            VideoSelector.refresh();
            break;
        case "Post":
            PostSelector.refresh();
            break;
        case "Category":
            CategorySelector.refresh();
            break;
        case "Photo":
            PhotoSelector.refresh();
            break;
    }*/
}

ModelBrowser.CTRL={
    /**
     * 
     */
    SET_SELECTION:"a[href='#ModelBrowser.setSelection']",
    /*
     * Set Page Index for Pager
     */
    SET_INDEX:"a[href='#ModelBrowser.setIndex']",
    SET_ORDERBY:"a[href='#ModelBrowser.setOrderBy']",
    SET_ORDER_DIRECTION:"a[href='#ModelBrowser.setOrderDirection']",
    SET_PAGINATOR_NEXT_PRE : "a[href='#ModelBrowser.setIndexNextPre']",    
    PAGINATOR_TARGET : "[data-model-browser='models-paginator']",    
    LIST_TARGET : "[data-model-browser='models-list']",
    CLASSIFICATION_TARGET : "[data-model-browser='models-classification']",    
    MODEL_BROWSE_OPEN : "a[href='#ModelBrowser.openModal']",
    
    /*
     * using for page index
     */
    DATA_INDEX : "data-index",
    
    /*
     * Select order by
     */
    DATA_ORDER_BY : "data-order-by",
    
    /*
     * Select order by direction desc/asc
     */
    DATA_ORDER_BY_DIRECTION : "data-order-direction",
    /*
     * Select by data selection like all/unused etc.
     */
    DATA_SELECTION : "data-selection",
    /*
     * Select by data selection argument for selection like for data-selection="expiration" 7 (in 7 days)
     */
    DATA_SELECTION_ARGUMENT : "data-selection-argument",
    DATA_SORTABLE : "data-sortable",
    DATA_MODELS_LIST_SORTABLE : "[data-sortable='true']",
    
    MODEL_SELECTOR : "#ModelSelector.select"
}

JQ.bo.on("click", ModelBrowser.CTRL.MODEL_BROWSE_OPEN ,function(e){
    e.preventDefault();
    e.stopPropagation();
    ModelBrowser.openModal($(this));
})

JQ.bo.on('hidden',".modal", function (e) {
    if($(e.target).attr("data-remove-after-hide") == "true" ) {
        $(e.target).remove();
        Application.removeAllToolTip();
    }
    
    /*
     * Clean active model( from modal box )
     */
    if($(e.target).attr("data-remove-active-model-after-hide") == "true" ) {
        ModalsManager.activeModel = null;
    }
})

JQ.bo.on('hide',".modal", function (e) {    
    if( $(e.target).attr( Model.CTRL.DATA_NEED_TO_RECORD ) == "true" && $(e.target).hasClass( "list-view-container" ) == false ) {
        if(!confirm(Application._beforeAjaxPrompt)){
            return false;
        } 
    }
/*
    if(Application._confirmBeforeAjax){
        if(!confirm(Application._beforeAjaxPrompt)){
            return false;
        }else{
            Application._confirmBeforeAjax=false; //reset the confirm to not ask again to the user on the onChangeUrl function
        }
    }*/
})