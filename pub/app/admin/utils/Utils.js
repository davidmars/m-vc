var Utils={
    /**
     * ouvre une url
     * @param url à ouvrir
     * @param target si égual à blank ouvrira dans une nouvelle fenetre
     */
    getUrl:function(url,target){

        if(target){
            if(!Utils.windows){
                Utils.windows={};
            }
            if(Utils.windows[target] && !Utils.windows[target].closed){
                Utils.windows[target].close();
            }
            Utils.windows[target]=window.open( url,target );
            
        }else{
            window.open(url);
        }
        
        
    },
    /**
     * renvoie la valeur de paramName trouvée dans l'url en paramètre GET
     * @param paramName le nom du paramètre GET de l'url en cours dont on souhaite récupérer la valeur.
     */
    getUrlParam:function(paramName){
          var name = paramName.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
          var regexS = "[\\?&]"+name+"=([^&#]*)";
          var regex = new RegExp( regexS );
          var results = regex.exec( window.location.href );
          if( results == null ){
            return "";
          }else{
            return results[1];
          }
    },
    rapport:function(valeur,maxentree, maxsortie, minentree, minsortie) {
        var produitentree = (valeur-minentree)/(maxentree-minentree);
        var valeursortie = ((maxsortie-minsortie)*produitentree)+minsortie;
        return valeursortie;
    },
    showAllInrect:function(w,h,maxW,maxH){
        //console.log("showAllInrect");
        //console.log(w,h,maxW,maxH);
        var rw=Utils.rapport(w, w, maxW, 0, 0);
        var rh=Utils.rapport(h, w, maxW, 0, 0);

        if(rh>maxH){
            rh=Utils.rapport(h, h, maxH, 0, 0);
            rw=Utils.rapport(w, h, maxH, 0, 0); 
        }
        return {w:rw,h:rh,x:Math.floor(maxW/2-rw/2),y:Math.floor(maxH/2-rh/2)};
    },
    /**
     * chiffre incrémenté par Utils.getUid();
     */
    uid:0,
    /**
     * renvoie un id unique
     */
    getUid:function(){
       Utils.uid++;
       return "utilsUid"+String(Utils.uid)
    },
    /**
     * renvoie une chaine representant l'objet (un print_r en php)
     * @param obj l'obet à tracer
     * @param htmlOutput si défini sur true renverra un output html
     */
    print:function(obj,htmlOutput){
        var r="";
        var value=null;
        var variable=null;
        return JSON.stringify(obj);
    },
    /**
     * Function to convert hex format to a rgb color. call the function: rgb( "rgb(0, 70, 255)" ); returns: #0046ff
     */
    rgbCss2hexCss:function (rgb) {
        if(!rgb){
            return "none";
        }
     var hexDigits = ["0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f"];
     rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
     if(!rgb){
       return "none";
     }
     var hex=function(x) {
      return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
     }
     return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
    },
    /**
     * prend le premier lien dans domObj et l'applique comme lien à domObj
     */
    hrefIse:function(domObj,onClick){
        var link=$(domObj).find("a").attr("href");
        $(domObj).addClass("btn");
        $(domObj).click(function(){
            document.location=link;
            //$(domObj).find("a").onclick();
        })
    },
    
    numberCss:function(cssValue){
        cssValue=String(cssValue).replace("px","");
        cssValue=String(cssValue).replace("%","");
        cssValue=String(cssValue).replace(" ","");
        cssValue=Number(cssValue);
        return cssValue;
    },
    arrayRand:function(ar){
	
	return ar[Math.floor(Math.random()*(ar.length))];
    },
    inArray:function(array,value){
      for(var i=0;i<array.length;i++){
          if(array[i]==value){
              return true;
          }
      }  
      return false;
    },
    /**
     * charge le fichier file dans le tag image
     */
    loadImgFile:function(domImg,file){
        domImg.src = window.URL.createObjectURL(file);  
	domImg.onload = function(e) {
	    window.URL.revokeObjectURL(this.src);  
	}
    },
    /**
     * renvoie un objet dom canvas de l'image resizée fournie par file
     */
    getCanvasImage:function(w,h,file){
        var w=w;
        var h=h;

        var canvas=$("<canvas width='"+w+"px'  height='"+h+"px'></canvas>");
        canvas.css("width",w+"px");
	canvas.css("height",h+"px");

        var ctx = canvas[0].getContext("2d");
        var destX = 0;
        var destY = 0;
        var destWidth = w;
        var destHeight = h;
        /*
        ctx.fillStyle = "Red";
        ctx.fillRect(3,3,w,h);
        ctx.lineTo(30,30);
        */
        var domImg=new Image();
        domImg.onload = function(){
            window.URL.revokeObjectURL(this.src); 
            var origW=this.width;
            var origH=this.height;
            //alert("onload "+origW+"/"+origH);
            var fact=w/origW;
            var newW=w;
            var newH=origH*fact;
            //alert(newW+"//"+newH);
            if(newH>h){
               fact=h/origH;
               newH=h;
               newW=origW*fact;
            }
            //copie l'image la recentre et la redimensionne
            ctx.drawImage(domImg, 0, 0, origW, origH, w/2-newW/2, h/2-newH/2, newW, newH);
        };
        domImg.src = window.URL.createObjectURL(file);
        return canvas;
        //imageObj.src = "darth-vader.jpg";  
    },
    /**
     * fait clignotter el si flag==true, sinon arrête de la faire clignotter
     */
    blink:function(el,flag,ms){
        var els=$(el);
        var flag=flag;
        
        if(ms){
            var ms = ms;
        }else{
            var ms = 100;
        }
        
        
        
        var fade=function(dom,show){
            if(show){
                $(dom).animate({"opacity":1},$(dom).data("Utils_blink_ms"),function(){
                    if($(this).data("Utils_blink")){
                        fade($(this),false);
                    }
                })
            }else{
                $(dom).animate({"opacity":0.2},$(dom).data("Utils_blink_ms"),function(){
                    fade($(this),true);
                }) 
            }
        }
        
        for(var i=0;i<els.length;i++){
            if(flag){
                if(!$(els[i]).data("Utils_blink")){
                    $(els[i]).data("Utils_blink", true);
                    $(els[i]).data("Utils_blink_ms", ms);
                    fade($(el[i]),false);
                }
            }else{
                $(els[i]).data("Utils_blink", false);
                fade($(els[i]),true);
            }
        }
        
    }


}










//html5 file loader
window.URL = window.URL || window.webkitURL; 




/**
 * positionne le curseur  dans un input
 */
$.fn.setCursorPosition = function(position){
    if(this.lengh == 0) return this;
    return $(this).setSelection(position, position);
}
/**
 * positionne la selection dans un intpu
 */
$.fn.setSelection = function(selectionStart, selectionEnd) {
    if(this.lengh == 0) return this;
    input = this[0];

    if (input.createTextRange) {
        var range = input.createTextRange();
        range.collapse(true);
        range.moveEnd('character', selectionEnd);
        range.moveStart('character', selectionStart);
        range.select();
    } else if (input.setSelectionRange) {
        input.focus();
        input.setSelectionRange(selectionStart, selectionEnd);
    }

    return this;
}
/**
 * positionne le curseur à la fin dans un input
 */
$.fn.focusEnd = function(){
    if(this.val()){
      this.setCursorPosition(this.val().length);  
    }
    
}
