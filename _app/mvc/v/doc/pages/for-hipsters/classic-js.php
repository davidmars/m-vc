<?php
$vv=new VV_doc_page($_vars);
?>


<p>
    Here we will describe how to insert .js files in your views.<br />
    There are two places you can include .js files in a HTML document: 
    you can either include them in the &lt;head&gt; of your HTML page or 
    include them right before the &lt;/body&gt; tag.<br />
    This framework lets you choose where you want to include your files, 
    however we recommend that you include them before the &lt;/body&gt; tag for the following reasons:<br />
</p>
<ul>
    <li>There’s no need to check if the DOM is loaded, since by having the scripts at the end, you know for sure it is.</li>
    <li>A JavaScript script file has to be loaded completely before a web browser even begins to render the rest of your page. 
        If you include your file in the &lt;head&gt; of the page, the rendering of the page will be delayed until the script is loaded. This problem is avoided
        if you include your file at the bottom of the page.
    </li>
</ul>
<p>
    All your javascript files must be stored in the "pub/app" directory.<br />
</p>



<div class="">
    <h4 class="section">Add your JavaScript in the &lt;head&gt;</h4>
    <p>
        You will need to use two functions: one that will record all the files you need and the other to display all the &lt;script&gt; tags in your HTML.<br/>
    </p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<head>
    <?=JS::addToHeader("pub/app/script.js")?>
</head>')?>
    </pre>
    <p>
        The function <code>JS::addToHeader("url")</code> has <b>one parameter</b>.<br />
        It is <b>the path</b> of the file you want to include.<br/>
        This function alone will not include any tag in your HTML. It just creates a list of files you want to include.
    </p>
    <p>
        You can add as many files as you want with this function. It will store every file url in a list to be displayed later.
    </p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<head>
    <?=JS::addToHeader("pub/app/script.js")?>
    <?=JS::addToHeader("pub/app/script2.js")?>
    <?=JS::addToHeader("pub/app/script3.js")?>
</head>')?>
    </pre>    
</div>


<div class="">
    <h4 class="section">Display the HTML &lt;script&gt; tags</h4>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?=JS::includeHeaderFiles(compress)?>')?>
    </pre>
    <p>
        The function <code>JS::includeHeaderFiles(compress)</code> has <b>one parameter</b>: <em>compress</em> that is either <em>true</em> or <em>false</em><br />
        By default compress is set to <em>true</em>. It will compress all your .js files and combine them into one script faster to load.<br />
        With the compress parameter set to <em>false</em>, this function create a &lt;script&gt; tag for each file you put in the list.
    </p>
        <pre class="prettyprint linenums lang-php">
<?=htmlentities('<head>
    <?=JS::addToHeader("pub/app/script.js")?>
    <?=JS::addToHeader("pub/app/script2.js")?>
    <?=JS::addToHeader("pub/app/script3.js")?>
    <?=JS::includeHeaderFiles(false)?>
</head>
<!-- will generate -->
<head>
   <script src="/example/pub/app/script.js"></script>
   <script src="/example/pub/app/script2.js"></script>
   <script src="/example/pub/app/script3.js"></script>
</head>')?>
    </pre>
    <p>
        With the compress parameter set to <em>true</em> (or not specified), this function will compress and minify files (remove comments, suppress empty new lines and useless white spaces...) and will combine all your script into one file. It will creates only one &lt;script&gt; tag calling the resulting file.
    </p>
        <pre class="prettyprint linenums lang-php">
<?=htmlentities('<head>
    <?=JS::addToHeader("pub/app/script.js")?>
    <?=JS::addToHeader("pub/app/script2.js")?>
    <?=JS::addToHeader("pub/app/script3.js")?>
    <?=JS::includeHeaderFiles()?>
</head>
<!-- will generate -->
<head>
   <script src="/media/cache/js/scriptxxxxxxxxxx.js"></script>
</head>')?>
    </pre>
    <div class="alert alert-info">
        <h4>Important</h4> 
        Note that once you called the <code>JS::includeHeaderFiles()</code> function in a page, it empties the list of files!
    </div>
</div>



<div class="">
    <h4 class="section">Add your JavaScript before the &lt;/body&gt; tag</h4>
    <p>
        You will need to use two functions: one that will record all the files you need and the other to display all the &lt;script&gt; tags in your HTML.<br/>
    </p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('   <?=JS::addAfterBody("pub/app/script.js")?>
</body>')?>
    </pre>
    <p>
        The function <code>JS::addAfterBody("url")</code> has <b>one parameter</b>.<br />
        It is <b>the path</b> of the file you want to include.<br/>
        This function alone will not include any tag in your HTML. It just creates a list of files you want to include.
    </p>
    <p>
        You can add as many files as you want with this function. It will store every file url in a list to be displayed later.
    </p>
    <pre class="prettyprint linenums lang-php">
    <?=htmlentities('<?=JS::addAfterBody("pub/app/script.js")?>
    <?=JS::addAfterBody("pub/app/script2.js")?>
    <?=JS::addAfterBody("pub/app/script3.js")?>
</body>')?>
    </pre>    
</div>


<div class="">
    <h4 class="section">Display the HTML &lt;script&gt; tags</h4>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?=JS::includeAfterBodyFiles()?>')?>
    </pre>
    <p>
        The function <code>JS::includeAfterBodyFiles(compress)</code> has <b>one parameter</b>: <em>compress</em> that is either <em>true</em> or <em>false</em><br />
        By default compress is set to <em>true</em>. It will compress all your .js files and combine them into one script faster to load.<br />
        With the compress parameter set to <em>false</em>, this function creates a &lt;script&gt; tag for each file you put in the list.
    </p>
        <pre class="prettyprint linenums lang-php">
    <?=htmlentities('<?=JS::addAfterBody("pub/app/script.js")?>
    <?=JS::addAfterBody("pub/app/script2.js")?>
    <?=JS::addAfterBody("pub/app/script3.js")?>
    <?=JS::includeAfterBodyFiles(false)?>
</body>
<!-- will generate -->
   <script src="/example/pub/app/script.js"></script>
   <script src="/example/pub/app/script2.js"></script>
   <script src="/example/pub/app/script3.js"></script>
</body>')?>
    </pre>
    <p>
        With the compress parameter set to <em>true</em> (or not specified), this function will compress and minify files (remove comments, suppress empty new lines and useless white spaces...) and will combine all your script into one file. It will create only one &lt;script&gt; tag calling the resulting file.
    </p>
    
    <pre class="prettyprint linenums lang-php">
    <?=htmlentities('<?=JS::addAfterBody("pub/app/script.js")?>
    <?=JS::addAfterBody("pub/app/script2.js")?>
    <?=JS::addAfterBody("pub/app/script3.js")?>
    <?=JS::includeAfterBodyFiles()?>
</body>
<!-- will generate -->
   <script src="/media/cache/js/scriptyyyyyyyyy.js"></script>
</body>')?>
    </pre>
    
    <div class="alert alert-info">
        <h4>Important</h4> 
        Note that once you called the <code>JS::includeAfterBodyFiles()</code> function in a page, it empties the list of files!
    </div>
</div>
