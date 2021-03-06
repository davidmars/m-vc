<?php
$vv=new VV_doc_page($_vars);
?>


<p>
    Here we will describe how to insert .css files in your views.<br />
    You will need to use two functions: one that will record all the files you need and the other to display all the &lt;script&gt; tags in your HTML.<br/>
    All your css files must be stored in the "pub/app" directory.<br />
    Since all css files should be included in the &lt;head&gt; of your HTML page, you will call these functions from there.
</p>
<div class="">
    <h4 class="section">Add a css file to the list of files to be included</h4>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<head>
    <?=CSS::addToHeader("pub/app/style.css")?>
</head>')?>
    </pre>
    <p>
        The function <code>CSS::addToHeader("url")</code> has <b>one parameter</b>.<br />
        It is <b>the path</b> of the file you want to include.<br/>
        This function alone will not include any tag in your HTML. It just creates a list of files you want to include.
    </p>
    <p>
        You can add as many files as you want with this function. It will store every file url in a list to be displayed later.
    </p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<head>
    <?=CSS::addToHeader("pub/app/style.css")?>
    <?=CSS::addToHeader("pub/app/style2.css")?>
    <?=CSS::addToHeader("pub/app/style3.css")?>
</head>')?>
    </pre>    
</div>


<div class="">
    <h4 class="section">Display the HTML &lt;link&gt; tags</h4>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?=CSS::includeHeaderFiles()?>')?>
    </pre>
    <p>
        The function <code>CSS::includeHeaderFiles(compress)</code> has <b>one parameter</b>: <em>compress</em> that is either <em>true</em> or <em>false</em><br />
        By default compress is set to <em>true</em>. It will compress all your .js files and combine them into one script faster to load, then create a &lt;link&gt; tag calling the resulting file.<br />
        With the compress parameter set to <em>false</em>, this function creates a &lt;link&gt; tag for each file you put in the list.
    </p>
    
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<head>
    <?=CSS::addToHeader("pub/app/style.css")?>
    <?=CSS::addToHeader("pub/app/style2.css")?>
    <?=CSS::addToHeader("pub/app/style3.css")?>
    <?=CSS::includeHeaderFiles(false)?>
</head>
<!-- will generate -->
<head>
    <link rel="stylesheet" href="/example/pub/app/style.css">
    <link rel="stylesheet" href="/example/pub/app/style2.css">
    <link rel="stylesheet" href="/example/pub/app/style3.css">
</head>')?>
    </pre>
    
    <p>
        With the compress parameter set to <em>true</em> (or not specified), this function will compress and minify files (remove comments, suppress empty new lines and useless white spaces...) and will combine all your script into one file. It will create only one &lt;link&gt; tag calling the resulting file.
    </p>
    
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<head>
    <?=CSS::addToHeader("pub/app/style.css")?>
    <?=CSS::addToHeader("pub/app/style2.css")?>
    <?=CSS::addToHeader("pub/app/style3.css")?>
    <?=CSS::includeHeaderFiles()?>
</head>
<!-- will generate -->
<head>
    <link rel="stylesheet" href="/media/cache/css/stylexxxxxxxxxx.css">
</head>')?>
    </pre>
    
    <div class="alert alert-info">
        <h4>Important</h4> 
        Note that once you called the <code>CSS::includeHeaderFiles()</code> function in a page, it empties the list of files!
    </div>
</div>
