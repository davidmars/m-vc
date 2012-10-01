var Dom = (function() {
    
    return {
        addBehavior: function(dom, element, event, fn) {
            var eventRelay = "";
            if( event == "relay" ) {
                eventRelay = "click:relay";
            } else if( event.indexOf("relay") != -1 ) {
                eventRelay = event;
            }
            
            if( eventRelay != "" ) {
                /*dom.addEvent( eventRelay + "("+ element +")" , function( e, element ) {
                    fn( e, element);
                });*/
                
                dom.bind('eventRelay', function() {
                  fn( e, element);
                });

            } else {
                element = Dom.find( element );
                //Core.log( element )
                if( element != null) {
                    element.bind(event, function(e) {
                        fn( e, element);
                    });
                }
                
            }
	},
        find: function(element) {
            var elementType = typeof element;
            if ( elementType === "string" ) {
                if (element == '<body>') {
                    return body;
                }
                return $$(element);
            } else if (elementType === "object") {
                return element;
            };
            
            return null;
        },
        createElement: function(element, attributes) {
            element = new Element( element, attributes );
            return element;
        },
        setText: function(element, text) {
            return element.set("html", text);
        },
        addClass: function(element, class_name) {
            element.addClass( class_name );
        },

        removeClass: function(element, class_name) {
            element.removeClass(class_name);
        },
        doc : document,
        win : window,
        body : $(document.body)        
     }      
}());