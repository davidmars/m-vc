/**
 * Created with JetBrains PhpStorm.
 * User: francoisrai
 * Date: 25/10/12
 * Time: 17:01
 * To change this template use File | Settings | File Templates.
 */
var Share = {

}

Share.init = function() {
    console.log("share init");


    // FB
    FB.init({
        status : true, // check login status
        cookie : true, // enable cookies to allow the server to access the session
        xfbml  : true  // parse XFBML
    });

    // TWITTER
    var twitterWidgets = document.createElement('script');
    twitterWidgets.type = 'text/javascript';
    twitterWidgets.async = true;
    twitterWidgets.src = 'http://platform.twitter.com/widgets.js';
    document.getElementsByTagName('head')[0].appendChild(twitterWidgets);

    // GOOGLE
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
}