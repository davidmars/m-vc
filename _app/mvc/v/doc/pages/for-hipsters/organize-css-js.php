<p>
    It's up to you to use or not the following tips. If you love to put 
    <code><?=htmlentities("<script> & <style>")?></code> tags in several templates, in ajax pages 
    and everywhere your crazy brain will lead your code, just go away, it's not for you.     
</p>
<p>
Okay, your synapses works right and you love simplicity, you will love it. 
Yes we will speak about CSS and Javascript in the same place. 
Why? In theory isn't it a good practice to separate it?<br/>
In theory yes, in practice it will be always different and I'm sure you know it.<br/>
Just an example if you use <a href="http://twitter.github.com/bootstrap/">Twitter Bootstrap</a>, you will need a css and a javascript 
files that will follow the same logic and functionnlities in your mind. It will be the same for jQuery UI, and for a lot of pluggins in fact. 
Finaly it will be the same for your own applications, you will always have your own css and js files.
</p>
<p>
    Our pupose for css and javascript integration in HTML pages follow the HTML5 Boilerplate logic:
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<head>
    <!--the css files...-->
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/my-project.css">

    <!--js scripts that are necessary to display the page-->
    <script src="js/libs/modernizr.js"></script>
</head>

<body>

    <h1>Your page content<h1>
    <p>some stuff etc...</p>

    <!--the js files, loaded after the page display for performance reasons-->
    <script src="js/jquery.js"></script>
    <script src="js/some-stuff-plugins.js"></script>
    <script src="js/my-project.js"></script>

</body>'
        )?>
    </pre>   
</p>

<p>
    As you can see our integration goal is classic. The way to integrate it will be different.<br>
    At least, in Point Of View your html page will be something like that:
        <pre class="prettyprint linenums lang-php">
<?=htmlentities('<head>
    <!--the css files...-->
    <?=CSS::includeHeaderFiles()?>

    <!--js scripts that are necessary to display the page-->
    <?=JS::includeHeaderFiles()?>

</head>

<body>

    <h1>Your page content<h1>
    <p>some stuff etc...</p>

    <!--the js files, loaded after the page display for performance reasons-->
    <?=JS::includeAfterBodyFiles()?>

</body>'
        )?>
    </pre>

Yes it is very similar, we just streamline the integration. 
You guess that <code><?=htmlentities('<?=CSS::includeHeaderFiles()?>')?></code> will display a list of style sheets include tags 
and you guess that <code><?=htmlentities('<?=JS::includeHeaderFiles()?>')?></code> will display a list of javascript include tags, etc...

</p>

<h3>
    Manage your js/css/less files from your controller.
</h3>
<p>
    POV give you the ability (or advise you in fact) to set your CSS and JS files in only one place, the best place for it is the Controller.
    Each controller will display different html ressources. 
    Sometime this html ressources will use the same js and css in all the project, 
    sometime, you'll have exceptions. No problem, this html exceptions are managed in the controller, right? 
    So lets manage the css and js exceptions in the same place. But no more words, lets practice.<br/><br/>
    This is a common css an js set in a controller:
    
<pre class="prettyprint linenums lang-php">
<?=htmlentities('<?php
    
public function setJsAndCss(){
    //----common stuffs----

    //modernizer
    JS::addToHeader("pub/libs/modernizr-2.5.3-respond-1.1.0.min.js");

    //jquery
    JS::addAfterBody("pub/libs/jquery-1.7.2.js");

    //bootstrap js (css will be included via Less compilation later)
    JS::addAfterBody("pub/libs/bootstrap/js/bootstrap.js");

    //----code prettify----

    //vkbeautify (to manage code formating like indentation in xmls)
    JS::addAfterBody("pub/libs/code-prettify/vkbeautify.0.98.01.beta.js");

    //google code prettify
    JS::addAfterBody("pub/libs/code-prettify/google-code-prettify/prettify.js");
    CSS::addToHeader("pub/libs/code-prettify/google-code-prettify/prettify.css");

    //little class that manage both prettify librairies
    JS::addAfterBody("pub/libs/code-prettify/Prettify.js");

    //----less css----

    $lessVariables=array(
        "phpAppFolder"=>"\'".Site::url("pub")."\'"
    );
    //get the compiled less file
    $lessFile=Less::getCss("pub/app/Main.less",$lessVariables);
    //add the less-css file to header section
    CSS::addToHeader($lessFile);


    //----main app js file

    JS::addAfterBody("pub/app/Main.js");
}
')?>
    </pre>     
    Following this exemple, in your controller functions you will have to call <code>$this->setJsAndCss();</code> to use this javascript and css set.
    If you need a different set, just create an other function and call it instead of the first one.<br/> <br/> 
    
     If you're a good nerd, after a little bit of practice, you will probably put your common Css and Javascript settings in static functions 
    and/or you will override <code>Controller->run();</code> function if you use all the time the same setting. 
    You will be probably right to do it and you will preserve your code from repeating always the same calls. If you understand it, do it, if you don't, no problem, keep your code like that, it's ok.
</p>

<div class="alert alert-success">
    <h5>That's great! Why?</h5>
    <ul>
        <li>Because you can easily add, remove or update stuff.<br/><br/></li>
        <li>Because you can organize your code by functionnality, not by language (css vs js)<br/><br/></li>
        <li>Because it is finished to separate and copy paste css and js file when you integrate a pluggin. 
            Now you will be able to keep pluggins file structure exactly the same as they was in your downloaded files. 
            Updating pluggins is now just a copy paste.<br/><br/></li>
        <li>Because you can combine and compress js and css file easily!</li>
    </ul>
</div>

<h3>Combine and compress js and css</h3>
<p>
    It's easy. The function <code>JS::includeAfterBodyFiles</code> accepts two parameters.<br/>
    The first one if set to <b>true</b> will combine all your <i>"Javascript After Body files"</i> in one file.<br/>
    The second one if set to <b>true</b> will compress all your <i>"Javascript After Body files"</i>.<br/>
</p>
<p>
    It will be exactly the same for :
    <code>JS::includeHeaderFiles($combine,$compress);</code>, 
    <code>CSS::includeHeaderFiles($combine,$compress);</code> and  
    <code>CSS::includeAfterBodyFiles($combine,$compress);</code>.<br/><br/>
    That's all.
</p>

<div class="alert alert-info">
    <h5>When to use, when to not use?</h5>
    Combined or compressed files are hard to debug, so you will probably combine and compress when you will plublish your project. 
    You will not while you are working on it. 
</div>

