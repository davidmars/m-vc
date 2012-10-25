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
    console.log("fb init");
    FB.init({
        status : true, // check login status
        cookie : true, // enable cookies to allow the server to access the session
        xfbml  : true  // parse XFBML
    });
}