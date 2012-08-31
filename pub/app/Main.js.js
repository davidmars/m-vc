/*
 *
 * Start
 *
 */


var Main={
    /**
     * let's start the stuff
     */
    boot:function(){
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
    afterAjax:function(){

    }



}

Main.boot();




