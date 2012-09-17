<?php
$vv = new VV_doc_page($_vars);
?>

<p>
    We will describe here how to simply create templates and how to include a page or a template in an other one.
</p>
<div class="">
    <h3 class="section">Hello World: first template</h3>
    <p>First we will create a new file in the 'v' directory named 'simple-template'. Write the following code in it:</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<h1>Hello world</h1>')?>
    </pre>
    <p>You can write all html you want in a template.</p>
</div>

<div class="">
    <h3 class="section">Include a page in your current template: function render()</h3>
    <p>Create a new file in the 'v' directory named 'list-item'. Write the following code in it:</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<li>toto 1</li>
<li>toto 2</li>')?>
    </pre>
    <p>We want to include this item list in our template 'simple-template'.</p>
    <p>To do so, go back to the 'simple-template' file and add the following code:</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<ul>
    <?=$this->render("doc/samples/list-item")?>
</ul>')?>
    </pre>
    <p>The function <code>render()</code> has <b>one</b> parameter. It is the route of the document you want to include.<br />
    This function will insert the content of the file defined by the route, right where you called the function.</p>
</div>

<div class="">
    <h3 class="section">Include your current page: function inside()</h3>
    <p>we want to include our template 'simple-template' inside a new page called 'mytemplate'.</p>
    <p>To do so, add the following code on top of your 'simple-template' page:</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?=$this->inside("doc/samples/mytemplate")?>')?>
    </pre>
    <p>Now create a new file in the 'v' directory named 'mytemplate'. Write the following code in it:<:p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<div style="1px solid red">
    <?=$_content?>
    <!-- $_content will be replace by the content of the page that called the function inside() -->
</div>')?>
    </pre>
    <p>The function <code>inside()</code> has <b>one</b> parameter. It is the route of the document you want to include your content in.<br />
    This function will insert the content of the current file in the file defined by the route, right where you put the $_content variable.</p>
</div>
<?=$this->htmlHeader->author?>