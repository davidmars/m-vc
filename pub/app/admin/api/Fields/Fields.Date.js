/**
 * a field that works with jqery ui date picker
 */
Fields.Date=function(jq){
    
    var jq=this.jq=$(jq);
    var input=jq.find("input");
    
    this.never=function(domInsideField){
       input.val(Fields.Date.CONSTANTS.NEVER);
    }
}
Fields.Date.CONSTANTS={
    /**
     * the input value for a "Never" date
     */
    NEVER:"Never!",
    /**
     * the never date value...yes it is in 2038 year only -> see php doc for dark side reasons 19/01/2038 à 03:14:07 http://fr.php.net/strtotime
     */
    NEVER_DATE_VALUE:"2038-01-01",
    /**
     * the input value for a undefined date (less than year 2000)
     */
    UNDEFINED:"Please set a date"
}


Fields.Date.CTRL={
    NEVER:"a[href='#Fields.Date.never']",
    INPUT:"[data-field-type='Date'] input.date-picker"
}



JQ.bo.on("click",Fields.Date.CTRL.NEVER,function(e){
    e.preventDefault();
    var fieldDate=new Fields.Date(Fields.getParent($(this)));
    //console.log("-----validate")
    //console.log(fieldDate.jq)
    fieldDate.never();
    Fields.validate(fieldDate.jq);
})

JQ.bo.on("change",Fields.Date.CTRL.INPUT,function(){
    var fieldDate=new Fields.Date(Fields.getParent($(this)));
    Fields.validate(fieldDate.jq); 
})
JQ.bo.on("mousedown",Fields.Date.CTRL.INPUT,function(){
    //http://www.kelvinluck.com/assets/jquery/datePicker/v2/demo/documentation.html
    if(!$(this).hasClass("hasDatepicker")){
       $(this).datePicker({clickInput:true,startDate:'01/01/1970'})
	$(this).dpDisplay();
	$(this).addClass("hasDatepicker")
    }
})