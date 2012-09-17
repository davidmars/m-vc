<?php
$vv = new VV_doc_page($_vars);
?>

<p>
    A template is simply a webpage, even sometimes a partial webpage (like a header, sidebar, footer...).<br />
    Templates can be easily included in other templates if you need to.<br/>
    All templates should be stored in the _app/mvc/v folder. Inside that folder, you can create as many subfolders as you want to organize your files.
    Every webpage is created from a template.<br />
    Every template is loaded by a controller. You will see later what the controller really does.
</p>
<p>
    In order to practice with the following examples, you will need to put all your templates in the folder '/v/doc/samples/'.<br />
    To display your template, you will use the following URL : <br />
    <u>http://www.your-domain.com/root-directory-here/doc/example/index/your-template-name</u><br />
    Note that you don't need to put the php extension in the url.
</p>
<div class="">
    <h3 class="section">Hello World: first template</h3>
    <p>First we will create a new file in the '/v/doc/samples/' directory named 'simple-template'. Write the following code in it:</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<h1>Hello world</h1>
<p>This is my first template</p>')?>
    </pre>
    <p>This will display:<br />
        <img style="border:1px dotted;" src="<?=GiveMe::url("pub/app/doc/img/ex1.PNG")?>"/>
    </p>
    <p>You can write all html you want in a template.</p>
</div>

<div class="">
    <h3 class="section">Include a page in your current template: function render()</h3>
    <p>Create a new file named 'list-item'. Write the following code in it:</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<li>item 1</li>
<li>item 2</li>')?>
    </pre>
    <p>We want to include this item list in our template 'simple-template'.</p>
    <p>To do so, go back to the 'simple-template' file and add the following code:</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<ul>
    <?=$this->render("doc/samples/list-item")?>
</ul>')?>
    </pre>
   
    <p>This will display:<br />   
        <img style="border:1px dotted;" src="<?=GiveMe::url("pub/app/doc/img/ex2.PNG")?>"/>
    </p>
    <p>The function <code>render()</code> has <b>one</b> parameter. It is the path of the document you want to include.<br />
    This function will insert the content of the file defined by the path, right where you called the function.</p>
</div>

<div class="">
    <h3 class="section">Include your current page: function inside()</h3>
    <p>We want to insert our template 'simple-template' inside a new page called 'mytemplate'.</p>
    <p>To do so, add the following code on top of your 'simple-template' page:</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?=$this->inside("doc/samples/mytemplate")?>')?>
    </pre>
    <p>Now create a new file named 'mytemplate'. Write the following code in it:</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<html>
<head>
    <title>My Template</title>
</head>
<body>
    <div style="border:1px solid red;">
        <?=$_content?>
        <!-- $_content will be replace by the content of the page that called the function inside() -->
    </div>
</body>
</html>')?>
    </pre>
    <p>This will display:<br />   
        <img style="border:1px dotted;" src="<?=GiveMe::url("pub/app/doc/img/ex3.PNG")?>"/>
    </p>
    <p>
        As you can see in the source code, the code of the template 'simple-template' has been added inside the code of 'mytemplate'.
    </p>
    <p>The function <code>inside()</code> has <b>one</b> parameter. It is the path of the document you want to insert your content in.<br />
    This function will insert the content of the current file in the file defined by the path, right where you put the $_content variable.
    </p>
    <p>
        Note that for this to work, you need to display the 'simple-template' template, since it is the one that calls the function inside().<br />
        In this case, if you try to display directly the 'mytemplate' template, it will only display its own content, but not the content of the 'simple-template'.
    </p>
</div>

<div class="">
    <h3 class="section">Using variables and basic PHP codes in a template</h3>
    <p>Sometimes you may need to change the display of a line or two of your template, depending on a condition.</p>
    <p>You can use PHP IF...ELSE statement to execute some code only if a specified condition is true.</p>
    <p>Let's go back to our 'simple-template' file and add the following code at the end:</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?if($this->viewVariables->title):?>
<!--checks if the variable $this->viewVariables->title exists-->
    <p>The variable does exist! it is: "<?=$this->viewVariables->title?>"</p>
    <!--line to display if it does exist-->
<?else:?>
    <p>sorry, the variable doesn\'t exist.</p>
    <!--line to display if it doesn\'t exist-->
<?endif?>')?>
    </pre>
     <p>This will check if the variable $this->viewVariables->title exists. 
         If it does, it will display "The variable does exist! it is:" and the value of the variable. 
         If it doesn't exist, it will display "sorry, the variable doesn't exist."
     </p>
     <p>This will display:<br />   
        <img style="border:1px dotted;" src="<?=GiveMe::url("pub/app/doc/img/ex4.PNG")?>"/>
    </p>
    <p>
        Sometimes the variables available in the template are arrays of values.
        In this case you will need to execute the same code for each value in the array. 
        To do so, we will use the FOREACH loop.
    </p>
    <p>
        Go to your 'list-item' file and replace its content by the following code:
    </p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?$data=array("item1","item2","item3");?>
<!-- this creates a variable $data that is an array of values -->
    <?foreach ($data as $item):?>
    <!-- for each item in this array we execute the following code -->
        <li><?=$item?></li>
    <?endforeach?>')?>
    </pre>
    <p>This will display:<br />   
        <img style="border:1px dotted;" src="<?=GiveMe::url("pub/app/doc/img/ex5.PNG")?>"/>
    </p>
</div>
