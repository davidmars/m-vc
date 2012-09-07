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
    The first one is an url, it can be a relative or absolute url, it can be a file, or a route.
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
        "home/index/toto",
        "home/index/titi",
        "home/index/toto/titi",
        "i-am/not-a/valid-page",
        "pub/app/fmk/img/logo.png",
        "app/fmk/img/logo.png",
        "pub/app/fmk/img/i-not-a-real-file.png",
        "http://www.google.com",
        "https://www.google.com",
        "http://i-am-not-a-real-website-url", //will display it normaly cause it's an absolute url.
        );
    ?>


<?foreach($urls as $url):?>
<pre class="prettyprint lang-php linenums">
<?=htmlentities('<a href="<?=GiveMe::url("'.$url.'")?>">My Link</a>
//will generate...
<a href="'.GiveMe::url($url).'">My Link</a>')?>
</pre>

<?endforeach?>




    <?foreach($urls as $url):?>
        <?$convertedUrl=GiveMe::url($url,true)?>
        <li>The url <b><?=$url?></b> will be converted to : <a href="<?=$convertedUrl?>"><?=$convertedUrl?></a></li>
    <?endforeach?>
