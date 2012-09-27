<?php
$vv=new VV_doc_page($_vars);
?>

<p>
    LESS is a dynamic stylesheet language. It extends CSS with dynamic behaviour such as variables, mixins, operations and functions.<br/>
    This framework features LESS CSS autocompilation.<br/>
    If you don't know about the LESS language, <a href="<?=GiveMe::url("http://lesscss.org/")?>" target="_blank">please check the official doc</a>.
</p>
<p>
    Assuming you created a LESS file. You will need to compile the LESS file and then include the resulting file in the &lt;head&gt; tag.<br />
    The following function will do both:
</p>
<pre class="prettyprint linenums lang-php">
<?=htmlentities('<head>
    <?=Less::getIncludeTag("less-file-url",$array-of-variables)?>
</head>')?>
</pre>
<p>
    The function <code>Less::getIncludeTag(URL,VAR)</code> has <b>two</b> parameters:
</p>
<ul>
    <li>URL: the path to your LESS file, without the extension - (required)</li>
    <li>VAR: a PHP array that contains variables and their values to be used in the LESS file  - (optional)</li>
</ul>
<p>
    All .less files must be placed in the "pub/app" directory.
</p>
<p>
    Your variables can be either set within your .less file or set by the PHP array you send in the <code>Less::getIncludeTag(URL,VAR)</code> function.
</p>
<p>
    If you send them in the function, the code should look like that:<br/>
    "name of the variable"=>"value",
</p>
<pre class="prettyprint linenums lang-php">
<?=htmlentities('<?=Less::getIncludeTag("pub/app/file", array(
    "main-color"=>"red",
    "secondary-color"=>"blue",
    "main-width"=>"1000px"
))?>
<!-- this will generate a html code like -->
<link type="text/css" rel="stylesheet" 
    href="/example/pub/media/cache/less-css/pub/app/file-xxxxxxx.css"/>')?>
</pre>
<br /><br /><br />
