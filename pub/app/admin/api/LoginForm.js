var LoginForm=function(jq){
    var me=this;
    var jq=this.jq=$(jq);

    this.inputEmail=jq.find(LoginForm.CTRL.FIELD_EMAIL);
    this.inputPassword=jq.find(LoginForm.CTRL.FIELD_PASSWORD);
    this.button=jq.find("[data-loading-text]");
    this.messages=jq.find(LoginForm.CTRL.MESSAGES_CONTAINER);
    this.redirectUrl=jq.attr("data-login-redirect");

    this.login=function(){
        console.log("wait....");
        jq.addClass("soft-loading");
        me.button.button('loading');
        var call=new Api.Login(me.inputEmail.val(),me.inputPassword.val());
        call.events.addEventListener("COMPLETE",onResponse);
    }
    var onResponse=function(json){
        console.log(json);
        me.button.button('reset');
        jq.removeClass("soft-loading");
        Api.displayMessages(json,me.messages);
        var j=new Api.JsonReturn(json);
        //if success en redirect do the redirection with a little delay
        if(j.success && me.redirectUrl){
            setTimeout(function(){
                document.location=me.redirectUrl;
            },2000);
        }
    }

}
LoginForm.getParent=function(jq){
    return new LoginForm(jq.closest(LoginForm.CTRL.MAIN));
}


LoginForm.CTRL={
    MAIN:"form[data-login-box='true']",
    FIELD_EMAIL:"input[data-login-email]",
    FIELD_PASSWORD:"input[data-login-password]",
    MESSAGES_CONTAINER:"[data-messages-container='true']"
}

JQ.bo.on("submit",LoginForm.CTRL.MAIN,function(e){
    e.preventDefault();
    console.log("test");
    f=LoginForm.getParent($(this));
    f.login();

    //Api.call(null,)
})