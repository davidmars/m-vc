var UserAgent={
    /*isIpad:function(){
	if($("body").hasClass("browser_iPad")){
	    return true;
	}
    },*/
    isMobile:function(){
	if($("body").hasClass("browser_mobile")){
	    return true;
	}
    },
    webkit : function () {
        return $.browser.webkit;
    },
    isIE : function () {
        return $.browser.msie != null ? true : false;
    },
    isMozilla : function () {
        return $.browser.mozilla != null ? true : false;
    },
    isChrome : function () {
        return $.browser.chrome != null ? true : false;
    },
    isSafari : function () {
        return $.browser.safari != null ? true : false;
    },
    isOpera : function () {
        return $.browser.opera != null ? true : false;
    },
    isIphone : function (){
        return (
            (navigator.platform.indexOf("iPhone") != -1) ||
            (navigator.platform.indexOf("iPod") != -1)
        );
    },
    isIpad : function (){
        return navigator.userAgent.match(/iPad/i) != null;
    }
}