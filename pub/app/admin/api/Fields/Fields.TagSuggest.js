Fields.TagSuggest=function(jq){    
    var me = this;
    this.jq = $(jq);
    this.field = this.jq.parents("[" + Model.CTRL.DATA_FIELD_TYPE + "='Tags']");
    this.serviceUrl = this.jq.attr(Model.CTRL.SERVICE_URL);
    this.tagList = $(this.field.find(".tag-list"));    

    this.jq.autocomplete({
        source: this.serviceUrl,
        minLength: 2,
        select: function( event, ui ) { 
            event.preventDefault();
            return me.tagSelect( event, ui );
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
    
    this.tagSelect=function(event, ui){
        var tagId = ui.item.value;
        var tagName = ui.item.label;
        if(!me.exists(tagId)){
            $(event.target).val(tagName);
            Api.getTemplate(tagId, "Tag", Fields.TagSuggest.CTRL.TAG_LABEL,{}, me.onReceiveTemplate)
        }
    }
    /**
     * inject the received template in the tag list
     */
    this.onReceiveTemplate=function(json){        
        if( json.success == true && json.template ) {            
            me.tagList.append(json.template);
            me.jq.val("");
            Model.getParent(me.jq).needToBeRecorded(true);
        }
    }
    /**
     * returns true if the tag already exists
     */
    this.exists=function(tagId){     
        if(me.tagList.find("["+Model.CTRL.DATA_MODEL_ID+"='"+tagId+"']").length>0){
            return true;
        }
        
        return false;
    }
    
    this.create=function(){
        if( me.jq.val() != "") {
            Api.call("new","Tag", {
                "root[name]" : me.jq.val(), 
                "root[blogs][modelId]" : Application.blogId, 
                "template" : Fields.TagSuggest.CTRL.TAG_LABEL,
                theme:"extranet"
            }, me.onReceiveTemplate)
        }        
    }
    /**
     * enter key will lauch create
     */
    this.jq.bind('keydown', 'return', me.create);
    /**
     * create on click button
     */
    this.field.find("button[type=submit]").on("click",function(e){
        e.preventDefault();
        me.create();
    })
}

Fields.TagSuggest.CTRL={
    /**
     * this markup mark the fields (input text) as a fields to suggest tags
     */
    IS_TAG_SUGGEST:"[data-is-tag-suggest='true']",
    IS_TAG_SEARCH:"[data-is-tag-search='true']" ,
    IS_TAG_SEARCH_LIST:"[data-is-tag-search-list='true']",
    /*
    * Search type for category and tag
    */
    SEARCH_TYPE:"data-search-type" ,
    TAG_LABEL:"v2/fields/tag/tagLabel",
    FOCUS_SUGGEST:"data-focus-suggest-init" 
}

//tags suggest field
JQ.bo.on("focus",Fields.TagSuggest.CTRL.IS_TAG_SUGGEST,function(e){
    e.preventDefault();
    e.stopPropagation();
    var $this=$(this);
    
    if($this.attr( Fields.TagSuggest.CTRL.FOCUS_SUGGEST ) != "true"){
        new Fields.TagSuggest(e.target)
        $this.attr( Fields.TagSuggest.CTRL.FOCUS_SUGGEST ,true);
    }    
})

JQ.bo.on("keyup",Fields.TagSuggest.CTRL.IS_TAG_SEARCH,function(e){
    e.preventDefault();
    e.stopPropagation();
    var $this=$(this);
    
    if( $this.val().length < 2){
    //return;
    }
    
    $this.attr(Model.CTRL.SERVICE_URL);
    
    $.ajax({   
        type: "GET",
        url: $this.attr(Model.CTRL.SERVICE_URL),
        data: {
            term : $this.val(), 
            searchType : $this.attr(Fields.TagSuggest.CTRL.SEARCH_TYPE)
        },
        dataType: 'json',
        success: function(json) {
            var searchList = JQ.bo.find(Fields.TagSuggest.CTRL.IS_TAG_SEARCH_LIST);
            searchList.html("");
            if(json) {                
                var list = "";
                $.each(json, function(i,f){
                    list += "<li><a href='/v2/tag/"+f.value+"' data-ajax-target='item-content'><i class='icon-tag'></i> "+f.label+"</a></li>";
                })                
                searchList.html(list);
            }              
        }
    });
})