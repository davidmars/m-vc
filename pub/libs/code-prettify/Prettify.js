/**
 *
 */
var Prettify={
    /**
    * render beautifull programming code.
    * here we use two libs :
    * vkbeautify will indent the code first https://github.com/vkiryukhin/vkBeautify.
    * google prettify will finsh the job http://code.google.com/p/google-code-prettify
    * @exemple in php use htmlentities the use a pre tag (bootstrap) prettyprint is for google.
    * <code><br/>
    * &lt;pre class=&quot;prettyprint lang-json linenums&quot;&gt;<br/>
    *   &lt;?=  htmlentities($video-&gt;geoPlace-&gt;feedContent)?&gt;<br/>
    * &lt;/pre&gt;<br/>
    * </code>
    */
    doTheJob:function(jq){
        var jq=$(jq);
        var nodes=jq.find(".prettyprint");
        var node;
        for(var i=0;i<nodes.length;i++){
            node=$(nodes[i]);
            if(!node.attr("data-prettyfied")){
                node.attr("data-prettyfied","true");
                var text=node.text();
                
                if(node.hasClass("lang-json")){
                    text=vkbeautify.json(text);    
                }else if(node.hasClass("lang-xml")){
                    text=vkbeautify.xml(text);    
                }
                
                node.text(text);
                 //from google-code-prettify 
            }
        }
        prettyPrint();
    }
}
