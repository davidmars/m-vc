<?php
$vv=new VV_doc_page($_vars);
?>


<p>
    This frameworks comes with a few libraries, like jQuery or Twitter Bootstrap.<br />
    You can add other libraries if you wish.
</p>
<div>
    <h3 class="section">Add a library to the framework</h3>
    <p>
        The directory that stores libraries is /pub/libs/.<br />
        Note that folders are organized by project names and not by file types.
        This is designed to easily update those libraries.<br />
        To add a new library we recommend that you create a new folder in the /pub/libs/ directory, and put all the files there.<br />
        Some libraries use both CSS and JavaScript files. We will see there how to include them in your HTML page.
    </p>
</div>

<div>
    <h3 class="section">Select the files you want to use</h3>
        <h4>Create PHP file</h4>
        <p>
            The framework system has been configured so that every PHP file found in the /pub/ folder will be executed every time an URL is called.<br />
            So we will create a new PHP file in the /pub/your-library/ directory that will list all the files we want to include.
        </p>
         <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?php
    //This file will define which files will be included in your html pages')?>
         </pre>
        <h4>Add CSS files</h4>
        <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?php
    //This file will define which files will be included in your html pages
    CSS::addToHeader("pub/libs/lib-style.css");')?>
        </pre>
        <p>
            The function <code>CSS::addToHeader("url")</code> has <b>one parameter</b>.<br />
            It is <b>the path</b> of the file you want to include.<br/>
            This function alone will not include any tag in your HTML. It just creates a list of files you want to include.
        </p>
        <p>
            You can add as many files as you want with this function. It will store every file url in a list to be displayed later.
        </p> 

        <h4>Add JavaScript files</h4>
        <p>
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
        <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?php
    //This file will define which files will be included in your html pages
    JS::addToHeader("pub/libs/lib-script.js");')?>
    </pre>
    <p>
        The function <code>JS::addToHeader("url")</code> has <b>one parameter</b>.<br />
        It is <b>the path</b> of the file you want to include.<br/>
        This function alone will not include any tag in your HTML. It just creates a list of files you want to include in the &lt;head&gt; of the page.
    </p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?php
    //This file will define which files will be included in your html pages
    JS::addAfterBody("pub/libs/lib-script2.js");')?>
    </pre>
    <p>
        The function <code>JS::addAfterBody("url")</code> has <b>one parameter</b>.<br />
        It is <b>the path</b> of the file you want to include.<br/>
        This function alone will not include any tag in your HTML. It just creates a list of files you want to include before the &lt;/body&gt; tag.
    </p>
    <p>
        You can add as many files as you want with these functions. They will store every file url in a list to be displayed later.
    </p>
   
</div>

<div>
    <h3 class="section">Include the files in your HTML page</h3>
    <p>
        You created a list of files to be included either in the &lt;head&gt; of the page (CSS/JS) or  before the &lt;/body&gt; tag (JS).<br />
        Now you will need three more functions to actually include the &lt;script&gt; and  &lt;link&gt; tags in your HTML page.<br />
    </p>
    <p>
        Let's consider the following PHP file:
    </p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?php
    //This file will define which files will be included in your html pages
    CSS::addToHeader("pub/libs/lib-style.css");
    JS::addToHeader("pub/libs/lib-script.js");
    JS::addAfterBody("pub/libs/lib-script2.js");
    JS::addAfterBody("pub/libs/lib-script3.js");')?>
    </pre>
    <p>
        Now let's write the following view:
    </p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<!doctype html>
<html>
    <head>
    <?=CSS::includeHeaderFiles()?>
    <?=JS::includeHeaderFiles()?>
    </head>
    <body>
    <!-- my content -->
    <?=JS::includeAfterBodyFiles()?>
    </body>
</html>')?>
    </pre>
    <p>
        This will render the following source code:
    </p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<!doctype html>
<html>
    <head>
    <link rel="stylesheet" href="/pub/libs/lib-style.css">
    <script src="/pub/libs/lib-script.js"></script>
    </head>
    <body>
    <!-- my content -->
    <script src="/pub/libs/lib-script2.js"></script>
    <script src="/pub/libs/lib-script3.js"></script>
    </body>
</html>')?>
    </pre>
    <p>
        The functions <code>CSS::includeHeaderFiles()</code>, <code>JS::includeHeaderFiles()</code> and <code>JS::includeBeforeBody()</code>, 
        have <b>no parameter</b>.<br />
        They create &lt;script&gt; or &lt;link&gt; tags for each file you put in the list, where you want to put them. 
        The files indicated in the PHP file will be included on every page where you called the include functions from.
    </p>
</div>

<div class="alert alert-info">
    <h4>Important</h4> 
    Note that the system will read <b>ALL</b> PHP files it will find in the /pub/ folder. If you don't want one of the files to be read anymore, you should delete it.
</div>
