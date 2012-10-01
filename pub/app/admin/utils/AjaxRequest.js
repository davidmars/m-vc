var AjaxRequest = ( function() {  
    
    var self,
        link = "cancel",
        method = "post",      
        req = null;
        
    return {
        init: function( args ) {
            self = this;            
            if( args != null ) {
               if( args.link != null ){
                    link = args.link;
                }

                if( args.method != null ){
                    method = args.method;
                }             
            }

            /*var req = $.ajax({
              type: method,
              processData: false
            })*/
            
            var req = $.ajaxSetup({
               global: false,
               type: method

             });
            
            return req;
        }
     }      
}());