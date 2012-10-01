var Cookie={
    datas:{init:"initial value of init"},
    set:function(name,value,days) {
            if (days) {
                    var date = new Date();
                    date.setTime(date.getTime()+(days*24*60*60*1000));
                    var expires = "; expires="+date.toGMTString();
            }
            else var expires = "";
            Cookie.boot();
            Cookie.datas[name]=value;
            document.cookie = "genericDatas"+"="+JSON.stringify(Cookie.datas)+expires+"; path=/";
    },

    get:function (name) {
            Cookie.boot();
            return Cookie.datas[name];
    },
    boot:function(){
        var nameEQ = "genericDatas" + "=";
        var ca = document.cookie.split(';');
        var cook="";
        for(var i=0;i < ca.length;i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1,c.length);
                if (c.indexOf(nameEQ) == 0){
                    cook=c.substring(nameEQ.length,c.length);
                    Cookie.datas=JSON.parse(cook);
                }
        }
    },
    createCookie : function(name,value,days) {
                if (days) {
                        var date = new Date();
                        date.setTime(date.getTime()+(days*24*60*60*1000));
                        var expires = "; expires="+date.toGMTString();
                }
                else var expires = "";
                
                var path = "/";                
                var s = document.location.host.split('.')  ;
                //var domain = s.slice(-2).join('.');
                var domain = "";
                var secure ="";
                document.cookie = name + "=" + escape (value) +
                ((expires) ? "; expires=" + expires : "") +
                ((path) ? "; path=" + path : "") +
                ((domain) ? "; domain=" + domain : "") +
                ((secure) ? "; secure" : "");
        },
        
        getCookie : function (c_name)
        {
        var i,x,y,ARRcookies=document.cookie.split(";");
        for (i=0;i<ARRcookies.length;i++)
        {
          x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
          y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
          x=x.replace(/^\s+|\s+$/g,"");
          if (x==c_name)
            {
            return unescape(y);
            }
          }
        }
}
