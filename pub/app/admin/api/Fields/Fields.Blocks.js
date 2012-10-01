Fields.Blocks=function(jq){
    var me = this;
    this.jq=$(jq);
    /**
     * return an object containning the blocks values
     */
    this.getValue=function(){
        var r=[];
        var blocks=me.getBlocks();
        
        if(blocks){
        for (var i=0;i<blocks.length;i++){
            r.push(blocks[i].getValue())
        }
        }
        return r;
    }
    /**
     * return an array conaining the blocks objects
     */
    this.getBlocks=function(){
        var r=[];
        var chil=me.jq.find(Fields.Blocks.CTRL.BLOCK);
        for(var i=0;i<chil.length;i++){
            r.push(new Fields.Block(chil[i]));
        }
        return r;
    }
    this.toggleGrid=function(){
        
        var status=$(me.jq.find(Fields.Blocks.CTRL.TOGGLE_GRID)[0]);
        if(status.hasClass("active")){
            status.removeClass("active")
        }else{
            status.addClass("active")
        }
        
        if( status.hasClass("active")){
            me.jq.removeClass("hide-grid");
        }else{
            me.jq.addClass("hide-grid");
        }
    }
    /**
     * add a block @modelType after @blockBefore
     */
    this.addBlock=function(modelType,blockBefore){
        
        var blockBefore=blockBefore;
        
        if(blockBefore==null || blockBefore.jq==null || blockBefore.jq.length<1){
            blockBefore=new Fields.Block($(me.jq.find("[data-blocks-here='true']")[0]));
        }
        
        //console.log("addBlock "+modelType);
        
        var trad = Application.langId;

        
        switch (modelType){
            
            
            case "PhotoRectangle":
            PhotoSelector.open();
            PhotoSelector.onSelectModel=function(model){
                PhotoSelector.close();
                Api.call(
                    "new",
                    "PhotoRectangle",
                    {
                        template:"v2/fields/blocks/newBlock",
                        root:{
                            photo:model.id(),
                            x:0,
                            y:0,
                            width:1,
                            height:1
                        }
                    },
                    function(j){
                        $(j.template).insertAfter(blockBefore.jq);
                        blockBefore.markAsChanged();
                    }
                )   
            }
            break;
            
            
            case "SlideShow":
                
                ModalSlideShow.open("new");
                
                ModalSlideShow.onSave=function(slideShowId){
                Api.getTemplate(slideShowId, "SlideShow", "v2/fields/blocks/newBlock", {}, function(j){
                        //console.log("on save")
                        $(j.template).insertAfter(blockBefore.jq);
                        blockBefore.markAsChanged();
                })
                
            }
                
                /*
                *  this content it will be the new sldieshow later without ajax request and data insertion 
                *  @author : francois
                */
                
                /*
                // create a new slide show, with a unique id
                var uniqueID = _.uniqueId('slideShow_');                             
                ModalSlideShow.open(uniqueID);
                
                // save 
                ModalSlideShow.onSave=function(slideShowId){                           
                    
                    if( $("#" + slideShowId).length > 0 ) {                        
                        $("#" + slideShowId).html( ModalSlideShow.ajaxTarget.html() );
                    } else{                        
                                                
                        var slide = $("<div/>", {
                            id:slideShowId,
                            "class":"span8 block block-SlideShow relative",
                            "data-is-block":true,
                            "data-is-slideShow":true
                        })
                                                                          
                        // the block type 
                        var blockType = $("<div/>", {
                            "data-model-type":"SlideShow",
                            "data-field-type":"SlideShow",
                            "data-model-id":slideShowId
                        })
                                                                       
                        // insertion html
                        
                        ModalSlideShow.ajaxTarget.find(".data-block-menu").clone().appendTo(slide);
                        ModalSlideShow.ajaxTarget.find(".slideshow-edit-button").clone().appendTo(blockType);                        
                        ModalSlideShow.ajaxTarget.find(".slides_container").clone().appendTo(blockType)
                        
                        blockType.find(".slides_container").find(".block-menu").addClass("hidden");
                        blockType.find(".slideshow-edit-button").removeClass("hidden");                        
                        blockType.appendTo(slide);                        
                        
                        slide.find(".data-block-menu").removeClass("hidden");
                        slide.insertAfter(blockBefore.jq);
                               
                        // start the slideshow       
                        slide.slides({
                            paginationClass: 'pagination_slides',
                            effect: 'fade',
                            play: 5000,
                            bigTarget: true
                          });     
                        }                                        
                    }
                    */

            break;

            
            
            case "Embed":
            EmbedCreator.open();
            EmbedCreator.onSelect=function(embedCode){
                EmbedCreator.close();
                Api.call(
                    "new",
                    "Embed",
                    {
                        template:"v2/fields/blocks/newBlock",
                        root:{
                            code:embedCode.htmlCode
                        }
                    },
                    function(j){
                        $(j.template).insertAfter(blockBefore.jq);
                        blockBefore.markAsChanged();
                    }
                )   
            }
            break;
            
           
            case "Text":
                var trads = {};
                trads[Application.langId] =  {content:"Type your text here...."};
                Api.call(
                    "new",
                    "Text",
                    {
                        template:"v2/fields/blocks/newBlock",
                        root:{
                            "subType":"richText",
			    "trads" : trads
			    
                        }
                    },
                    function(j){
                        $(j.template).insertAfter(blockBefore.jq);
                        blockBefore.markAsChanged();
                    }
                )   

            break;
            
            
            
            case "Title":
                var trads = {};
                trads[Application.langId] =  {content:"My title..."};
                Api.call(
                    "new",
                    "Text",
                    {
                        template:"v2/fields/blocks/newBlock",
                        root:{
                            subType:"title",
			    "trads" : trads
                        }
                    },
                    function(j){
                        $(j.template).insertAfter(blockBefore.jq);
                        blockBefore.markAsChanged();
                    }
                )   

            break;
            
            
            
            case "LineBreak":
                Api.call(
                    "new",
                    "Text",
                    {
                        template:"v2/fields/blocks/newBlock",
                        root:{
                            subType:"lineBreak"
                        }
                    },
                    function(j){
                        $(j.template).insertAfter(blockBefore.jq);
                        blockBefore.markAsChanged();
                    }
                )   

            break;
            
            
            
            case "Video":
            VideoSelector.open();
            VideoSelector.onSelectModel=function(model){
                VideoSelector.close();
                Api.call(
                    model.id(),
                    "Video",
                    {
                        template:"v2/fields/blocks/newBlock"
                    },
                    function(j){
                        $(j.template).insertAfter(blockBefore.jq);
                        blockBefore.markAsChanged();
                    }
                )   
            }
            break;
            
            
            default:
            alert("can't create a "+modelType);    
        }

    }
    
    
    
}

/**
* return the relative parent Fields.Blocks object
*/
Fields.Blocks.getFieldBlocks=function(el){
    return new Fields.Blocks(el.closest(Fields.Blocks.CTRL.FIELD_BLOCKS));
}

/**
 * the max value for spans. This is very close of the front side application, it depends on the graphic design of the project.
 */
Fields.Blocks.maxSpan=8;

/**
 * returns the parent Block item of domEl
 * @param domEl a jQuery dom object that should be a child of an element marked with data-is-block="true"
 */
Fields.Blocks.getBlock=function(domEl){
    var jq=domEl.closest(Fields.Blocks.CTRL.BLOCK)
    if(jq.length>0){
       return new Fields.Block(jq); 
    }else{
       //console.log("can't find block parent of...");
       //console.log(domEl);
       return null;
    }
    
}

/**
 * A Block is an element inside a Blocks field.
 */
Fields.Block=function(jq){
    
    var me = this;
    
    this.jq=$(jq);
    
    /**
     * return an object for the block, it contains the model values, but also attr like span and offset.
     * This object is used to record the blocks in the block list.
     */
    this.getValue=function(){
        var model=new Model(me.jq.find("[data-model-id]"));
        var obj=model.getMainData();
        obj.attr={};
        obj.attr.span=me.getSpan();
        obj.attr.offset=me.getOffset();
        obj.attr.classVisible=me.getClassVisible();
        return obj;
    }
    
    /**
     * return the model relative to the Blocks field.
     */
    this.getMainModel=function(){
        return Model.getParent(me.jq); 
    }
    
    var markAsChanged=this.markAsChanged=function(){
        me.getMainModel().needToBeRecorded(true); 
    }
    
    
    /**
     * so...it removes the block from dom
     */
    this.removeDom = function ( ) {
        me.jq.hide( 1000,function(){
            markAsChanged();
            me.jq.remove(); //remove at the end cause some DOM methods can't work'
	})
    }
    /**
     * move a block after the next block or before the previous block
     * @param where String can be before or after
     */
    this.move=function(where){
        if(where=="before"){
            me.jq.after(me.jq.prev()); 
        }else{
            me.jq.before(me.jq.next());
        }
        me.jq.fadeOut(0);
        me.jq.fadeIn(1000);
        markAsChanged();
    }
    /**
     * define the witdh in columns of the block
     * @param span Int from 1 to 12
     */
    this.setSpan=function(span){
    
        /* particularity for the slideshow  */
        
        if (me.jq.find("[data-model-type='SlideShow']")) {
            //console.log("setspan");
            //console.log(me.jq.find(".left .row").html());
            
            for(var i=0;i<12;i++){
            me.jq.find(".row").children().removeClass("span"+i)
            }
            me.jq.find(".row").children().addClass("span"+span);
        }
            
        
        for(var i=0;i<12;i++){
            me.jq.removeClass("span"+i)
        }
        me.jq.addClass("span"+span);
        me.updateSpanAndOffsetMenus();
        markAsChanged();
    }
    /**
     * define a visible class for the block
     * @param className String visible | invisible
     */
    this.setClassVisible=function(className){
        me.jq.removeClass("visible");
        me.jq.removeClass("invisible");
        me.jq.addClass(className);
        markAsChanged();
    }
    /**
     * define the left margin witdh (called offset) in columns of the block
     * @param offset Int from 1 to 12
     */
    this.setOffset=function(offset){
        for(var i=0;i<12;i++){
            me.jq.removeClass("offset"+i);
        }
        me.jq.addClass("offset"+offset);
        me.updateSpanAndOffsetMenus();
        markAsChanged();
    }
    /**
     * Update the graphic view of the offsets and spans menu. 
     * Mark as active the corresponding buttons, mark as disabled the impossibles entries and can also correct wrong offset values in some cases.
     */
    this.updateSpanAndOffsetMenus=function(){
        
        var span=me.getSpan();
        var offset=me.getOffset();
        
        if(span+offset>Fields.Blocks.maxSpan){
            offset=Fields.Blocks.maxSpan-span;
            me.setOffset(offset);
            return;
        }
        
        //unselect all in the menu and then select the good offset button as active
        me.jq.find(Fields.Blocks.CTRL.SET_SPAN).parent().removeClass("active");
        me.jq.find(Fields.Blocks.CTRL.SET_SPAN+"[data-span='"+span+"']").parent().addClass("active");
        
        //unselect all in the menu and then select the good offset button as active
        me.jq.find(Fields.Blocks.CTRL.SET_OFFSET).parent().removeClass("active");
        me.jq.find(Fields.Blocks.CTRL.SET_OFFSET).parent().removeClass("disabled");
        me.jq.find(Fields.Blocks.CTRL.SET_OFFSET+"[data-offset='"+offset+"']").parent().addClass("active");
        //mark as disabled the impossibles offset entries.
        for(var i=0;i<13;i++){
            if(span+i>Fields.Blocks.maxSpan){
                me.jq.find(Fields.Blocks.CTRL.SET_OFFSET+"[data-offset='"+i+"']").parent().addClass("disabled");
            }
        }
        
        
        
    }
    /**
     * returns the span value or null if undefined
     */
    this.getSpan=function(){
        for(var i=0;i<13;i++){
            if(me.jq.hasClass("span"+i)){
                return i;
            }
        }
        return null;
    }
    /**
     * returns the offset value or 0 if undefined
     */
    this.getOffset=function(){
        for(var i=0;i<13;i++){
            if(me.jq.hasClass("offset"+i)){
                return i;
            }
        }
        return 0;
    }
    /**
     * returns the class invisible
     */
    this.getClassVisible=function(){
        
        if(me.jq.hasClass("invisible")){
            return "invisible";
        }else if(me.jq.hasClass("visible")){
            return "visible";
        }else{
            return null;
        }
    }

}




Fields.Blocks.CTRL={
    /**
     * the attributte for a field blocks
     */
    FIELD_BLOCKS:"[data-field-type='Blocks']",
    /**
     * the attribute for a child block in the blocks field
     */
    BLOCK:"[data-is-block='true']",
     /**
     * move a block before or after an other block in the list, the values of data-move attribute can be "after or "before"
     */
    MOVE:"a[href='#Block.move'][data-move]",
     /**
     * remove dom button
     */
    REMOVE_DOM:"a[href='#Block.removeDOM']",
    /**
     * action to set the block's span value. Works with data-span attribute wich is a integer. 
     */
    SET_SPAN:"a[href='#Block.setSpan']",
    /**
     * action to set the block's offset value. Works with data-offset attribute wich is a integer. 
     */
    SET_OFFSET:"a[href='#Block.setOffset']",
    /**
     * action to set the block's offset value. Works with data-offset attribute wich is a integer. 
     */
    SET_CLASS_VISIBLE:"a[href='#Block.setClassVisible']",
    /**
     * add a block after. Works with data-block-type attribute wich is the model type block to create.
     * depending the block type, this action will launch diferents ui. 
     */
    ADD_BLOCK:"a[href='#Blocks.addBlock']",
    /**
     * show or hide the grid
     */
    TOGGLE_GRID:"a[href='#Blocks.toggleGrid']"
    
}
/**
 * hide or show the edition tools.
 */
JQ.bo.on("click",Fields.Blocks.CTRL.TOGGLE_GRID,function(e){
     e.preventDefault();
     var blocks=Fields.Blocks.getFieldBlocks($(this));
     blocks.toggleGrid();
 })
/**
 * by clicking on the dropdownmenu (spans and offsets controls), select the good entries.
 */
JQ.bo.on("click",Fields.Blocks.CTRL.BLOCK+" .dropdown-toggle",function(e){
     var block=Fields.Blocks.getBlock($(this));
     block.updateSpanAndOffsetMenus();

 })

/**
 * move a block before an after
 */
JQ.bo.on("click",Fields.Blocks.CTRL.MOVE,function(e){
     e.preventDefault();
     var where=$(this).attr("data-move");
     var block=Fields.Blocks.getBlock($(this));
     block.move(where);

 })
 /**
  * remove a block
  */
 JQ.bo.on("click",Fields.Blocks.CTRL.REMOVE_DOM,function(e){
    e.preventDefault();
    var b=Fields.Blocks.getBlock($(this));
    b.removeDom();   
})
/**
 * set a block span value
 */
 JQ.bo.on("click",Fields.Blocks.CTRL.SET_SPAN,function(e){
    e.preventDefault();
    var b=Fields.Blocks.getBlock($(this));
    b.setSpan($(this).attr("data-span"));  
})
/**
 * set a block offset value
 */
 JQ.bo.on("click",Fields.Blocks.CTRL.SET_OFFSET,function(e){
    e.preventDefault();
    var b=Fields.Blocks.getBlock($(this));
    b.setOffset($(this).attr("data-offset"));  
})
/**
 * set a class visible or invisible to the block
 */
 JQ.bo.on("click",Fields.Blocks.CTRL.SET_CLASS_VISIBLE,function(e){
    e.preventDefault();
    var b=Fields.Blocks.getBlock($(this));
    b.setClassVisible($(this).attr("data-argument"));  
})
/**
 * add a block after the current model
 */
 JQ.bo.on("click",Fields.Blocks.CTRL.ADD_BLOCK,function(e){
    e.preventDefault();
    var block=Fields.Blocks.getBlock($(this));
    var blockType=$(this).attr("data-block-type");
    var dady=Fields.Blocks.getFieldBlocks($(this));
    dady.addBlock(blockType,block);
})

