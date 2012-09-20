<?php
$vv = new VV_doc_page($_vars);
?>

<p>
    A template is simply a webpage, even sometimes a partial webpage (like a header, sidebar, footer...).<br />
    In an MVC architecture, Templates are called Views.<br />
    Views are HTML pages, with sometimes a bit of PHP inside. This means that you can write all HTML you want in a view.<br />
    We will describe here how to simply create views and how to include a page or a view in an other one.
</p>

<div class="">
    <h3 class="section">Include a page in your current view: function render()</h3>
    <p>
        Consider the following file called 'myview.php':
    </p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<h1>Hello World</h1>
<ul>
    <?=$this->render("doc/samples/list-item")?>
</ul>')?>
    </pre>
    <p>
        Now consider the following file called 'list-item.php':
    </p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<li>item 1</li>
<li>item 2</li>')?>
    </pre>
    <p>Calling 'myview' will generate the following code:</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<h1>Hello world</h1>
<ul>     
    <li>item 1</li>
    <li>item 2</li>
</ul>')?>
    </pre>
    <p>The function <code>render()</code> has <b>two</b> parameter. The <b>first one </b> is required: it is the path of the view you want to include.<br />
    This function will insert the content of the file defined by the path, right where you called the function.</p>
</div>

<div class="">
    <h3 class="section">Create a layout: function inside()</h3>
    <p>Let's consider a new page called 'layout.php' with the following code:</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<!doctype html>
<html>
    <head>
        <title>My layout</title>
    </head>
    <body>
        <?=$_content?>
        <!-- $_content will be replaced by the content of the page that called the function inside() -->
    </body>
</html>')?>
    </pre>
    <p>Now we add this line of code on top of the 'myview.php' page:</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?=$this->inside("doc/samples/layout")?>')?>
    </pre>
    <p>Calling 'myview' will generate the following code:</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<!doctype html>
<html>
    <head>
        <title>My layout</title>
    </head>
    <body>
        <h1>Hello world</h1>
        <ul>     
            <li>item 1</li>
            <li>item 2</li>
        </ul>
    </body>
</html>')?>
    </pre>
    <p>
        As you can see in the source code, the code of the view 'myview' has been added inside the code of 'layout'.
    </p>
    <p>The function <code>inside()</code> has <b>two</b> parameters.  
        The <b>first one </b> is required: it is the path of the document you want to insert your content in.<br />
    This function will insert the content of the current file in the file defined by the path, right where you put the $_content variable.
    </p>
    <p>
        Note that for this to work, you need to display the 'myview' view, since it is the one that calls the function inside().<br />
        In this case, if you try to display directly the 'layout' view, it will only display its own content, but not the content of the 'myview'.
    </p>
</div>