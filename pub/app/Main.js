/*
 *
 * Start
 *
 */


var Main={
    
    /**
     * the jq body element
     */
    body:$("body"),
    /**
     * let's start the stuff
     */
    boot:function(){
        console.log("boot js")
        //boot one time, no more
        if(Main.bootDone){
            console.log("Main.boot twice!");
            return;
        }
        Main.bootDone=true;

        /**
         *
         *
         * here do what you have to do on html page load
         *
         * 
         */

        //and...
        Main.afterAjax();

    },
    /**
     * to call after a dom change to init some things
     */
    afterAjax:function(jq){
        if(!jq){
            jq=Main.body;
        }
        var jq=$(jq);
        
        $("[rel='tooltip']").tooltip();
        
    }



}

Main.boot();




