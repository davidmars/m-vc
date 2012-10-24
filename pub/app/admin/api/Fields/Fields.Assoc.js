Fields.Assoc=function(jq){
    var me=this;
    this.jq=$(jq);

    var domList=this.jq.find('[data-assoc-children-container="true"]');
    /**
     * name of the childs models
     * @type {String}
     */
    this.childsTypes=this.jq.attr("data-childs-types");
    /**
     * Open a model selector pop in and inject the selected model by the user in the list
     */
    this.addItem=function(){
        ModalsManager.openModelPicker(me.childsTypes,function(model){
            Api.getView(
                "admin/api/modelTemplate/"+model.type()+"/"+model.id(),
                {template:"admin/models/tr-sortable"},
                function(html){
                    var el=$(html);
                    domList.prepend(el);
                })
        });
    }
}
/**
 * Find the parent Fields.Assoc element and returns the related javascript object.
 * @param jq jQuery
 * @return {Fields.Assoc}
 */
Fields.Assoc.getParent=function(jq){
    var domField=$(jq).closest('[data-field-type="Assoc"]');
    return new Fields.Assoc(domField);
}
/**
 * move the model before or after an other model
 * @param where can be "before" or "after"
 * @param model the model to move.
 */
Fields.Assoc.move=function(where,model){
    if(where=="before"){
        model.jq.insertBefore(model.jq.prev())
    }else{
        model.jq.insertAfter(model.jq.next())
    }
    model.jq.fadeOut();
    model.jq.fadeIn(500);
}
 

Fields.Assoc.CTRL={
    MOVE:"[href='#Fields.Assoc.move']",
    MOVE_ATTR_ARGUMENT:"data-move",
    ADD_ITEM:"[href='#Fields.Assoc.addItem']"
}
JQ.bo.on("click",Fields.Assoc.CTRL.MOVE,function(e){
    e.preventDefault();
    var m=Model.getParent($(this));
    var moveWhere=$(this).attr(Fields.Assoc.CTRL.MOVE_ATTR_ARGUMENT)
    Fields.Assoc.move(moveWhere,m);
    
})
JQ.bo.on("click",Fields.Assoc.CTRL.ADD_ITEM,function(e){
    e.preventDefault();
    var assoc=Fields.Assoc.getParent($(this));
    assoc.addItem();
})