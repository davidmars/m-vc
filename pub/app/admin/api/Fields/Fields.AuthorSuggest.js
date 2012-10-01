Fields.AuthorSuggest=function(jq){    
    var me = this;
    this.jq = $(jq);
    this.field = this.jq.closest(".author");   
    this.serviceUrl = this.jq.attr(Model.CTRL.SERVICE_URL);
    this.jq.autocomplete({
        source: function( request, response ) {
            $.getJSON( this.serviceUrl, {
                term: request.term,
                searchType : me.jq.attr(Fields.AuthorSuggest.CTRL.SEARCH_TYPE)
            }, response)
        },
        minLength: 2,
        select: function( event, ui ) { 
            event.preventDefault();
            return me.authorSelect( event, ui );
        },
        focus: function( event, ui ) { 
            event.preventDefault();
            $(event.target).val(ui.item.label); 
        },
        open: function(){
            $(this).autocomplete('widget').css('z-index', 10000);
            return false;
        }
    });  
    
    this.authorSelect=function(event, ui){
        var authorId = ui.item.value;
        //var authorName = ui.item.label;
        var hField = me.jq.closest(".author").find(Fields.AuthorSuggest.CTRL.AUTHOR_HIDDEN_FIELD + " input:hidden ");
        hField.val(authorId);
        Model.getParent(me.jq).needToBeRecorded(true);
    }
    
        /**
     * inject the received template in the tag list
     */
    this.onReceiveTemplate=function(json){
        if( json.success == true && json.id ) {            
            //me.tagList.append(json.template);
            me.jq.val("");
            Model.getParent(me.jq).needToBeRecorded(true);
        }
    }
    
    this.create=function(){
        if( me.jq.val() != "") {
            Api.call("new","Author", {
                "root[name]" : me.jq.val(),
                theme:"extranet"
            }, me.onReceiveTemplate)
        }        
    }
    
    /**
     * create on click button
     */
    this.field.find("button[type=submit]").on("click",function(e){
        e.preventDefault();
        me.create();
    })
}

Fields.AuthorSuggest.CTRL={
    IS_AUTHOR_SUGGEST:"[data-is-author-suggest='true']",
    AUTHOR_HIDDEN_FIELD:"[data-field='root[author]']",
    /*
    * Search type for category and tag
    */
    SEARCH_TYPE:"data-search-type" 
}

//tags suggest field
JQ.bo.on("focus",Fields.AuthorSuggest.CTRL.IS_AUTHOR_SUGGEST,function(e){
    e.preventDefault();
    e.stopPropagation();
    var $this=$(this);
    
    if($this.attr("data-focus-suggest-init") != "true"){
        new Fields.AuthorSuggest(e.target)
        $this.attr("data-focus-suggest-init",true);
    }    
})