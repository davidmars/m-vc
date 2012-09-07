<?php
$vv=new VV_doc_page($_vars);
?>
<p>
    When you write templates, you need to use urls for this kind of stuffs... 
</p>

<pre class="prettyprint linenums lang-php">
<?=htmlentities('<a href="i-am-an-url">This link is very interresting</a>
<!--or...-->
<img src="i-am-an-url.jpg" alt="it is a wonderfull image"/>')?>
</pre>



<p>
    It's not easy to manage this urls in a url rewrited project 
    and it's no more easier to move all urls in your templates when you decide to move your project from a place to another one.
</p>

<p>
    Also you will always prefer to display search engine optimized urls than routes.<br/>
    To manage it, <b>always</b> use this function :
</p>

<pre class="prettyprint lang-php linenums">
    GiveMe::url("your-url");
</pre>

<p>
    The function GiveMe::url has two parameters:<br>
    The first one is an url, it can be a relative or absolute url, it can be a file, or a route.<br/>
    The Second one define if you want to display an absolute or a relative url.<br/>
</p>
    
<div class="alert alert-info">
    <h4>Important</h4> 
    We recommend you to <b>never use optimized urls here</b> but routes only.<br>
    A good reason (not the only one) for it is that optimized urls can be translated, so they could not match according your current language.
    
</div>
    
<p>
    Here is a list of samples code using <code>GiveMe::url</code> function and the result in html. 
</p>    

    <?
    $urls=array(
        array("url"=>"home/index/toto","comment"=>"Transform route to optimized url"),
        array("url"=>"i-am/not-a/valid-page","comment"=>"Prevent error when the route is not valid"),
        array("url"=>"pub/app/fmk/img/logo.png","comment"=>"File exists, so it works"),
        array("url"=>"app/fmk/img/logo.png","comment"=>"File exists in the pub folder so it works too"),
        array("url"=>"pub/app/fmk/img/i-am-not-a-real-file.png","comment"=>"File doesn't exists so we manage the error"),
        array("url"=>"http://www.google.com","comment"=>"<span class='label'>Note</span> Http links will be always displayed..."),
        array("url"=>"http://i-am-not-a-real-website-url","comment"=>"...even if the target is not a valid website")
        );
    ?>


<?foreach($urls as $url):?>
<h5><?=$url["comment"]?></h5> 
<pre class="prettyprint lang-php linenums">
<?=htmlentities(
'<a href="<?=GiveMe::url("'.$url["url"].'")?>">My Link</a>
//will generate...
<a href="'.GiveMe::url($url["url"]).'">My Link</a>

//absolute
<a href="<?=GiveMe::url("'.$url["url"].'",true)?>">My Link</a>
//will generate...
<a href="'.GiveMe::url($url["url"],true).'">My Link</a>'
)?>
</pre>

<?endforeach?>
