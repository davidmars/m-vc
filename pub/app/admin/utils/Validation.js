
var Validation = function( form ){
        var me=this;
        
        this.errorsDetails=[];
        
	var country = 0;
        
        var outsideInputs=[];
        
        /**
         * in validate the field with the id = name_field
         */
	var invalidateField=function(name, field ){
	    //alert( "#" + name + "_" + field );
	    var inp = form.getElement( "#" + name + "_" + field );
            if(!inp){
                inp = $( name + "_" + field ); //search for en element with this id in the full dom cause sometime the field can be outside of the form...
                if(inp){
                    outsideInputs.push(inp)
                }
            }
	    var p;
	    if( inp && ( p = inp.getParent(".js_check") ) ){
		p.addClass("invalid");
	    }
	}
        /**
         * returns true if the input field is valid. othewise returns false and do the errors stuff (hilight, messages etc...)
         */
	var validateInput = function( input ){
		var p = Validation.getInputContainer( input );
		var errors = [];

		if( !p 
		|| !p.attr('class')
		|| ( p.css('display') == "none" ) ) {
				return true;
		}
                
		p.removeClass("invalid");
		
		if( p.hasClass("per-country") 
		&& !form.hasClass("country-" + country ) )	{
				return true;
		}

		var inpId = input.attr('id');

		if( (ci = inpId.indexOf("Confirmation"))

			&& (ciId = inpId.substr(0,ci)) ){

			//console.log("confirm : " +ciId);
			if( otherInp = form.getElement("#" + ciId ) ){
				if( otherInp.val() != input.val() ){
					errors.push("valid-confirmation");
					if( otherP = otherInp.getParent(".js_check") ){
						otherP.addClass("invalid");
						otherP.addClass("invalid-confirmation");
					}
				}
			}
		}

		$(p.attr('class').split(" ")).each( function( index, cl ){
			if( cl.indexOf("invalid") == 0 ){
				p.removeClass(cl);
			}
			switch( cl ){
                                /*
								// this has moved to whole Payment validation (see validateCreditCardForm)
                                case "valid-credit-card": 
                                    if( !Validation.isValidCreditCard( input.get("value") )){
                                            error = true;
                                            errors.push(cl);
                                    }
                                    break;*/

                               case "valid-number":
                                    if( !Validation.regexp.number.test( input.val() ) ){
                                            error = true;
                                            errors.push(cl);
                                    }
                                    break;
				case "valid-phone":
					if( !Validation.regexp.phone.test( input.val() ) ){
						error = true;
						errors.push(cl);
					}
					break;

				case "valid-zipcode":
					if( !Validation.regexp.zipcode.test( input.val() ) ){
						error = true;
						errors.push(cl);	
					}
					break;

				case "valid-notempty":
					if( input.val() == "" ){
						error = true;
						errors.push(cl);
					}
					break;
				case "valid-password":
					if( input.val().length<6 ){
						error = true;
						errors.push(cl);
					}
					break;

				case "valid-notzero":                                    
					if( input.val() <= 0 ){
						error = true;
						errors.push(cl);
					}
					break;

				case "valid-checked":

					if( input.get("type") == "radio" ){
						n = input.get("name");
						if( form.find("input[name='" + n +"']:checked").length == 0 ){
							error = true;
							errors.push(cl);
						}

					}else{
						if( !input.getProperty("checked") ){
							error = true;
							errors.push(cl);
						}
					}
					break;

				case "valid-email":
					if( !Validation.regexp.email.test( input.val() ) ){
						error = true;
						errors.push(cl);
					}
					break;

				case "valid-date":

					d = {};

					["day","month","year"].each( function( i ){
						elem = p.getElement("."+i+" select, ."+i+" input");
						if( elem ){
							d[i] = elem.get("value");
						}
					} );

					if( d.day < 1 || d.day > 31 || d.month < 1 || d.month > 12 ){
						error = true;
						errors.push(cl);
					}

					//d = new Date( year.get("value"), month.get("value") , year.get("value") );
					
					break;




			}
		});
                
                
                //console.log("init error deatails");
                var eDetail=""
		if( errors.length > 0 ){
                        
			p.addClass("invalid");
			$(errors).each( function(e){
			    
				var msg = p.find(".in"+e+".error-message");
				var message = "";
				if( msg ){
				    message = msg.html();
				}
				
				p.addClass("in" + e ); // like "in" + "valid-date"
                                eDetail={
				    fieldContainer:p,
				    errorType:e,
				    message: message
				};
                                me.errorsDetails.push(eDetail);
                                //console.log(eDetail)
			});
                        //console.log(me)
			return false;
		}else{
			return true;
		}				
	}
        /**
         * performs the validate action
         */
	var validate = function(){
            
            me.errorsDetails=[];
            var valid = true;

            for(var i=0;i<outsideInputs.length;i++){
                valid=validateInput(outsideInputs[i])
            }

            form.find("input, select, textarea").each( function( key, inp ){
                valid = validateInput($(inp)) && valid;
            });

            if( form.hasClass("js_paymentForm") ){
                    var validPayment = Validation.validateCreditCardForm( form );
                    if( valid == true && validPayment == true ) {
                        valid = true;
                    } else {
                        valid = false;
                    }
            }
            
            return valid;
	}
	/**
         * on country change will shows/hides the relave fields to ech country
         */
	var onCountry = function(e){
		country = e.target.get('value');
		form.get('class').split(" ").each( function(cl){
			if( cl.indexOf("country-") == 0 ){
				form.removeClass(cl);
			}
		});
		form.addClass("country-" + country );
	}
        /**
         * on form submit stop the submit event if the form is not valid
         */
	var onSubmit = function(e){
		if( !validate() ){
                    //form.getElements(".js_message").addClass("error" ).removeClass("hidden" );
                        me.onError();
			//e.stop();
			e.stopPropagation();
			e.preventDefault();
		}else{
		    me.onSend(e,form);
		    
		}
	}

	//form.addEvent("submit" , onSubmit );
        Dom.addBehavior(form, form, "submit", onSubmit);

        
	form.find(".js_country").each( function(index, p){
		p.find("select").each( function( index, inp ){
			//inp.addEvent("change" , onCountry);	
                        Dom.addBehavior(inp, inp, "change", onCountry);
		} );
		
	});
	
	
	this.invalidateField = invalidateField;
	this.onSend = function(){};
	this.onError = function(){};

};

Validation.regexp = {
    email : new RegExp("^([a-zA-Z0-9_-])+([+.]?[a-zA-Z0-9_-]{1,})*@([a-zA-Z0-9-_]{2,}[.])+[a-zA-Z]{2,3}$"),
    phone : new RegExp("^[0-9 \(\)\-+]*$"),
    zipcode : new RegExp("^[0-9 a-zA-Z\-]+$"),
    number : new RegExp("^[-+]?[0-9]+$"),
    creditCards : {
        VISA: /^4[0-9]{12}(?:[0-9]{3})?$/,                          
        MAST: /^5[1-5][0-9]{14}$/,
        DC: /^6(?:011|5[0-9]{2})[0-9]{12}$/,
        AMEX: /^3[47][0-9]{13}$/,
        DINE: /^3(?:0[0-5]|[68][0-9])[0-9]{11}$/,
        JCB: /^(?:2131|1800|35\d{3})\d{11}$/,
        Maestro: /^((67\d{2})|(4\d{3})|(5[1-5]\d{2})|(6011))-?\d{4}-?\d{4}-?\d{4}|3[4,7]\d{13}$/
    }
}

Validation.validateCreditCardForm = function( form ){
	
	var valid = true;

	var number = form.getElement("input[name='creditCard[cardNumber]']");
	
	if( !Validation.validLuhn( number.get('value') ) ){
		Validation.addInvalid( number );
		//console.log("invalid luhn");
		valid = false;
	}

	var secureCode = form.getElement("input[name='creditCard[secureCode]']");
	
	var type = null;
	
	form.find("input[name='creditCard[cardType]']").each( function(inp){
		if( inp.get('checked') ){
			type = inp;
		}
	} );

	if( !Validation.regexp.number.test( secureCode.get('value') ) ){
		Validation.addInvalid( secureCode );
		//console.log("invalid number");
		valid = false;
	}

	//console.log("Card type : " +type.get('value'));
	//console.log("secure Code length : "+secureCode.get('value').length);
	switch( type.get('value') ){
		case "AMEX" :
			if( secureCode.get('value').length != 4 ){
				//console.log("invalid secure number (AMEX)");
				Validation.addInvalid( type );
				valid = false;		
			}
			break;
		default : 
			if( secureCode.get('value').length != 3 ){
				//console.log("invalid secure number");
				Validation.addInvalid( type );
				valid = false;		
			}
	}
	
	if( !Validation.regexp.creditCards[type.get('value')].test( number.get('value') ) ){
		//console.log("invalid number (using card type)");
		
		Validation.addInvalid( number );
		valid = false;
	} 
	return valid;

}

/*Validation.getCreditCardType = function ( number ){ 
    if( Validation.isValidCreditCard( number ) ) {
        //loop through the object this.options.CARDS
        for(var card in Validation.cardRegexp) {
            //if one of them then return the card
            if(Validation.cardRegexp[card].test(number)) {
               return card; 
            }
        }
        //return unknown card
        return "Unknown Type";
     //otherwise the card isn't valid
     } else {
       return "The card is not valid!";
     }
}*/

Validation.validLuhn /*= Validation.isValidCreditCard*/ = function ( number ){
    if(!number) {
        return false;
    }
    
    var sum = 0, alt = false, i = number.length - 1, num;
    if(number.length < 13 || number.length > 19) {
        return false;  
    }
    
    while(i>=0) {
        //get the next digit 
        num = parseInt(number.charAt(i),10);
        //if it`s not a valid number then abort 
        if(isNaN(num)) {
            return false;  
        }

        //if it`s an alternate number then double 
        if(alt) {
            num *= 2;
            if(num > 9) {
              num = (num%10) + 1; 
            }//endif
        }//end if

        //flip the alternate bit
        alt = !alt;
        //add to the rest of the sum
        sum += num;
        //go to the next digit
        i--;
    
    }//end while 

    return (sum%10 == 0);
}

Validation.getInputContainer = function ( input ){
    return $(input).closest(".js_check");
}

Validation.addInvalid = function ( input ){
    var p = Validation.getInputContainer( input );
    p.addClass("invalid");  
}
Validation.addValid = function ( input ){
    var p = Validation.getInputContainer( input );
    p.removeClass("invalid");  
}