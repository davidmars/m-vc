<?php
$vv=new VV_doc_page($_vars);
?>
<p>
    We will describe through step by examples how to do common stuffs with images.<br/><br/>

</p>
<div class="">
    First, here is our native image without any manipulations.<br/>
    It's a transparent png (the photoshop like background is in css).<br/>
    Original size is 800 x 520px<br/></br>
    <pre class="prettyprint linenums lang-php">
    <?=htmlentities('
<img class="toshop" src="<?=GiveMe::url("pub/app/fmk/img/logo.png")?>"/>
    ')?>
    </pre>
    <img class="toshop" src="<?=GiveMe::url("pub/app/fmk/img/logo.png")?>"/>
</div>

<div class="">
    <h4>Basic resize to 200px by 200px </h4>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities(
'<img class="toshop" src="<?=GiveMe::imageSized("pub/app/fmk/img/logo.png", 200,200)?>"/>'
)?>
    </pre>
    <p class="floating">
        <img class="toshop" src="<?=GiveMe::imageSized("pub/app/fmk/img/logo.png",200,200)?>"/>
        The image is now 200px by 200px. It's no more a png but a jpeg and has a black background.
    </p>
</div>

<div class="">
    <h4>I'need a green background! </h4>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities(
'<img class="toshop" src="<?=GiveMe::imageSized("pub/app/fmk/img/logo.png",200,200,"00ff00")?>"/>'
)?>
    </pre>
    <p class="floating">
        <img class="toshop" src="<?=GiveMe::imageSized("pub/app/fmk/img/logo.png",200,200,"00ff00")?>"/>
        So the 3rd attribute is a color. Note that there is no # before the hexadeciaml code...right?
    </p>
</div>

<div class="">
    <h4>No, finaly I prefer the transparent png </h4>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities(
'<img class="toshop" 
    src="<?=GiveMe::imageSized("pub/app/fmk/img/logo.png",200,200,"transparent","png")?>"/>'
)?>
    </pre>
    <p class="floating">
        <img class="toshop" src="<?=GiveMe::imageSized("pub/app/fmk/img/logo.png",200,200,"transparent","png")?>"/>
        So the 3rd attribute is a color...but the keyword <em>transparent</em> works too. The 4th parameter is the mime type.
        By default the function generates jpegs but if you writte <em>png</em> it will output guess what...a png!
    </p>
</div>





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
<?

?>
<div class="alert alert-block alert-success">
    <h4>Want to know how does it works?</h4>

    <h5>
        Images are in cache!
    </h5>
    <p>
        Because playing with images is hard for your server, the images are processed once time.<br/>
        All the processed images files are located in the folder <em> pub/media/cache/img</em>.<br/>
    </p>

    <h5>
        Processed images lifecycle.
    </h5>    
    <p>

        A call to <code>GiveMe::imageSomething(...)</code> will only returns the url of the image, but the serious job will not be done.<br/>
        The URL you'll get in fact is a route with its own controller, methods etc... 
        So when a browser go to this url there is two possibilities:<br/><br/>
        
        <b>First time:</b> The url is not a file, so the .htacces, index.php etc... lead us to the controler, 
        it parses the url, 
        process the image, 
        return it to the browser like a "View"
        ...and it writtes the file in pub/media/cache/img/route-controler.<br/></br>
        
        <b>Second time :</b> The url is a file cause before it was wrotten, so the file will be returned to the browser normaly without any php processing.<br/>
    </p>

</div>
