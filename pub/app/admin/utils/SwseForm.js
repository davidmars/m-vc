/**
 * Permet de gérer un formulaire posté en ajax avec validation via Validation (classe de vérification des forms javascript) puis validation en fonction des données SWSE.
 * @param form l'objet dom du formulaire
 * @param url l'url où sera posté le formulaire
 * @param messageField l'objet dom
 * @param loadin l'objet dom de l'élément de loading qui sera affiché ou pas
 */
var SwseForm=function(form,url,messageField,loading) {
    var me=this;
    
    this.canceled = false;

    /**
     * messages par défaut
     */
    this.message_fieldError = Translations.translate["MyAccount.ErrorMessageFillMandatoryFields"];
    this.message_loading = Translations.translate["MyAccount.LoadingMessageDefault"];
    this.message_success = Translations.translate["MyAccount.ConfirmMessageDefault"];
    
    
    /**
     * objet de validation des champs en javascript
     */
    var validForm = null;
    var form = form;
    var url = url;
    var messageField = messageField;
    var loading = loading;
    var multipleChoicesPopIn;

    if(!loading){
        alert("SwseForm loading pb");
    }
    if(!messageField){
        alert("SwseForm messageField pb");
    }
    if(!url){
        alert("SwseForm url pb");
    }
    if(!form){
        alert("SwseForm form pb");
    }
    var showLoading=function(){
        loading.show();
    }
    var hideLoading=function(){
         loading.hide();
    }
    var setMessage=function(text,goodOrBad){
        //Core.log("set message");
        //Core.log(text);
        //messageField.getElement(".js_text").set("html",text);
        messageField.find(".js_text").html(text);
        messageField.removeClass("hidden");
        messageField.removeClass("success");
        messageField.removeClass("error");

        if(goodOrBad=="good"){
            messageField.addClass("success");
        }else{
            messageField.addClass("error");
        }
    }
    
    /**
     * envoi du formulaire
     */
    var send=function(){
        me.canceled = false;
        me.onSend(form);        
	//after the onSend event it is possible to cancel the sending action from outside
        if( me.canceled ) {
            return;
        }
        
        showLoading();
        var req =  AjaxRequest.init();            
        req.onSuccess =  function(json){
	    onReceive(json);
        };
	req.onFailure=function(){
	    UserMessage.alert(Translations.translate["message.error"]);
	    hideLoading();
	}
	req.onException=function(){
	   UserMessage.alert(Translations.translate["message.error"]);
	   hideLoading();
	}
        
        req.send({
            url : url,
            data : form.toQueryString()
        });
    }
    /**
     * quand on recoit le form ajax
     */
    var onReceive=function(json){
        //if( json.redirect == null){
            hideLoading();
        //}

        me.onReceive(); //callback        
        
	if(json.statsTag){
	    Stats.action(json.statsTag);
	}
	if(json.statsTag2){
	    Stats.action(json.statsTag2);
	}
	
        if(json.success==true){
            onReceiveSuccess(json);
        }else{
            onReceiveError(json);
        }
    }
    /**
     * quand le retour ajax comporte une erreur
     */
    var onReceiveError=function(json){

	if(json.redirect){
            showLoading();
            document.location=json.redirect;
        }

        if(json.message){
                if(
                    (
                    json.all &&
                    json.all.validationApiReturn &&
                    json.all.validationApiReturn.faultstring &&
                    json.all.validationApiReturn.detail.ValidationException)
                    ||
                    (
                    json.errorFields &&
                    json.errorFields.length>0
                    )
                
                ){
                    //errors detected on specific fields
                    var errorFields;
                    if(json.errorFields){
                      errorFields=json.errorFields;  
                    }else{
                      errorFields=json.all.validationApiReturn.detail.ValidationException.messages;  
                    }
                    
                    if(typeof(errorFields)!="array" && typeof(errorFields)!="object"){
                        errorFields=[errorFields];
                    }
                    for(var i=0;i<errorFields.length;i++){
                        var field = errorFields[i];
                        validForm.invalidateField( json.form, field );
                        //alert("error on field "+json.form+"/"+field);
                    }
		    if(json.fieldsMessage){
			setMessage(json.fieldsMessage, "bad");
		    }
                    //setMessage("action message<br/>"+json.message,"bad");
                    setMessage( json.message,"bad" );
                    
		}else if(json.all.multipleChoices){
		    //user needs to confirm something via an html popin
		    //
		    //AddressBook.addressMatches = response.addressMatches;
		    //AddressBook.addressMatchesHtml = response.addressMatchesHtml;
		    //multipleChoicesPopIn = Popin.loadPage( "/ebiza/myAccount/elements/addressMatches/", 660, 470 );
		    var winContent=new Element("div");
		    winContent.set("html",json.all.multipleChoices);
		    multipleChoicesPopIn=UserMessage.showDomElement(winContent);
		    UserMessage.onSelectItemCancel=function(domObject){
			UserMessage.alert("We need to use a valid address. Please, try to fill the address form again.");
		    }
		    UserMessage.onSelectItem=function(domObject){
			var jsonString=domObject.getElement(".json");
			var object = JSON.decode(jsonString.get('text'));

			//alert(jsonString);
			//console.log(object);
			fillForm(json.form+"_",object);
			send();
			//domObject.json
			//fill form whith json
			//send form again
		    }
		    
		    
		    
                } else if(json.redirectForLogOut){
                    showLoading();
                    document.location=json.redirectForLogOut;
                    setMessage( json.message, "bad" );
                } else{
                    //un autre message...
                     //setMessage("this is the action message<br/> "+json.message,"bad");
                     setMessage( json.message, "bad" );
                }
        }else{
            //erreur mais pas plus d'infos
            setMessage("Unknow error","bad");
        }
	

	
	//fire error event callback
        me.onError( json );

    }
    /**
     * fill the form with an object of data
     */
    var fillForm=function(form_prefix,data){
	for(var v in data){
	    //console.log("field" +v);
	    //console.log("field value " +data[v]);
	    if($(form_prefix+v) && data[v]){ //if field exists and data is not null
		//console.log("field "+v+" exists");
		$(form_prefix+v).set("value",data[v]);
	    }
	}
	//
    }
    
    var onReceiveSuccess=function(json){
        //setMessage("this is the action message<br/> "+json.message,"good");
        setMessage( json.message, "good");
        if(json.redirect){
            showLoading();
            document.location=json.redirect;
        }else if(json.from){
            showLoading();
            document.location=json.from;
        }
        me.onSuccess( json );
    }
    
     /**
     * checks if there is a var SWSEform_return json object referenced. If it is it will be proceced like an ajax call
     * Note that the form tag need an attribute data-SwseFormName that match with the json data SWSEform_return.form
     */
    var checkForInitialDatas = function(){
        //alert("is there datas?");
        //is there datas?... and are this datas provided form this form? 
        
	    
            if(SWSEform_return && SWSEform_return["form"]==form.get("data-SwseFormName")){
                //alert("yes");
                onReceive(SWSEform_return);
            }else{
                //alert("no");
            }
        try{}catch(e){
            
        }
        
    }
    /**
     * guess what it is 
     */
    var init=function(){
        //console.log(form)
        validForm=new Validation(form);
        validForm.onError=function(){
            //Core.log("valid form error "+form.get("id"))
            var m="";
            
            //Core.log("validForm.errorsDetails "+validForm.errorsDetails)
            for(var i=0;i<validForm.errorsDetails.length;i++){
                
                if(validForm.errorsDetails[i].message){
                    //Core.log("----"+validForm.errorsDetails[i].message)
                    m+=validForm.errorsDetails[i].message+"<br/>";
                }
            }
            
            
            
            
            //if(m!=""){
               //setMessage(m,"bad");
            //}else{
            //console.log(form);
            //console.log(validForm.errorsDetails);
            /*if(m!=""){
              setMessage(m + me.message_fieldError,"bad");  
            }else{
              setMessage(m + messageField.getElement(".js_text").get("html")+me.message_fieldError,"bad");  
            }*/
            //setMessage(m + messageField.getElement(".js_text").get("html")+me.message_fieldError,"bad"); 
            
            // check if there is only one error and this error has a message show only this message + " NOT WITH message_fieldError ""
            if( validForm.errorsDetails.length == 1 && validForm.errorsDetails[0].message) {
                
            } else {
                m += me.message_fieldError;
            }
            setMessage(m,"bad");  
             
            //}
	}
        
        validForm.onSend=function(e,form){
            //console.log("validadion js ok --> send");
            e.stopPropagation();
            //new Event(e).stop();
            send();
            if( !me.canceled ) {
                setMessage(me.message_loading,"good");
            }
	    
	    
	}
        //checks for initial datas (in php look at SWSEform::displayInView())
        setTimeout(function(){checkForInitialDatas();},1);
    }
    /**
     * quand le formulaire est envoyé
     */
    this.onSend = function(){}
    /**
     * quand le formulaire est reçu
     */
    this.onReceive = function(){}
    /**
     * quand il y a une erreur
     */
    this.onError = function(){}
    /**
     * quand le formulaire est enregistré avec succès
     */
    this.onSuccess = function(){}    
    /**
     * Show loading for Form
     */
    this.showLoading = function(){ showLoading(); }
    /**
     * définit un message
     */
    this.setMessage = function(txt,goodOrBad){
        setMessage(txt,goodOrBad);
    }
    
    init();
}

/**
 * Jeux de 3 selects à faire passer en params qui coordonneront les jours en fonction du mois et de l'année choisis.
 */
var DateFieldSet=function(d,m,y,defaultDayLabel){
    var d=d;
    var m=m;
    var y=y;
    
    var init=function(){
	d.addEvent("change",function(){onChangeDay()});
	m.addEvent("change",function(){onChangeMonth()});
	y.addEvent("change",function(){onChangeYear()});
	updateDaysList();
    }
    
    var onChangeDay=function(){
	
    }
    var onChangeMonth=function(){
	updateDaysList();
    }
    var onChangeYear=function(){
	updateDaysList();
    }
    
    var updateDaysList=function(){
	var currentDay=d.get('value');
	var days=31;
	if(m.get("value")!="0" && y.get("value")!="0"){
	    days=daysInMonth(m.get("value")-1,y.get("value"));
	}
	d.empty();
	var opt;
	
	for(var i=0;i<=days;i++){
	   opt=new Element("<option></option>")
	   opt.set("value",i);
	   if(i==currentDay){
	     opt.set("selected","selected")  
	   }
	   d.grab(opt);
	   opt.set("html",i);
	   if(i==0){
	     opt.set("html",defaultDayLabel);  
	   }
	}
	
    }
    var daysInMonth=function(iMonth, iYear)
    {
	return 32 - new Date(iYear, iMonth, 32).getDate();
    }
    init();
}