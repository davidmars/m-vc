<?php
$vv = new VV_doc_page($_vars);
?>

<p>
    A template is simply a webpage, even sometimes a partial webpage (like a header, sidebar, footer...).<br />
    In an MVC architecture, Templates are called Views.<br />
    All views should be stored in the _app/mvc/v folder. Inside that folder, you can create as many subfolders as you want to organize your files.<br />
    Every webpage is created from at least one view. Views can be easily included in other views if you need to.<br/>
    You will see later what a controller really does. But keep in mind that every URL calls a controller that will define which view(s) to load.
</p>
<p>
    In order to practice with the following examples, you will need to put all your views in the folder '/v/doc/samples/'.<br />
    To display your view, you will use the following URL : <br />
    <u>http://www.your-domain.com/root-directory-here/doc/example/index/hello-world</u><br />
    Note that you must not put the php extension in the url.
</p>


<div class="">
    <h3 class="section">Hello World: first view</h3>
    <p>First we will create a new file in the '/v/doc/samples/' directory named 'hello-world.php'. Write the following code in it:</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<h1>Hello world</h1>
<p>This is my first template</p>')?>
    </pre>
    <p>
        Go to: <u>http://www.your-domain.com/root-directory-here/doc/example/index/hello-world</u><br />
        This will display:<br />
        <img style="border:1px dotted;" src="<?=GiveMe::url("pub/app/doc/img/ex1.PNG")?>"/>
    </p>
    <p>You can write all html you want in a view.</p>
</div>


<div class="">
    <h3 class="section">Include a page in your current view: function render()</h3>
    <p>We want to include an item list in our view 'hello-world'.</p>
    <p>To do so, go to the 'hello-world' file and add the following code:</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<ul>
    <?=$this->render("doc/samples/list-item")?>
</ul>')?>
    </pre>
    <p>Then create a new file named 'list-item.php'. Write the following code in it:</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<li>item 1</li>
<li>item 2</li>')?>
    </pre>
    <p>This will display:<br />   
        <img style="border:1px dotted;" src="<?=GiveMe::url("pub/app/doc/img/ex2.PNG")?>"/>
    </p>
    <p>The function <code>render()</code> has <b>two</b> parameter. The <b>first one </b> is required: it is the path of the view you want to include.<br />
    This function will insert the content of the file defined by the path, right where you called the function.</p>
</div>


<div class="">
    <h3 class="section">Create a layout: function inside()</h3>
    <p>We want to insert our view 'hello-world' inside a new view called 'layout'.</p>
    <p>To do so, add the following code on top of your 'hello-world' page:</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?=$this->inside("doc/samples/layout")?>')?>
    </pre>
    <p>Now create a new file named 'layout.php'. Write the following code in it:</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<html>
<head>
    <title>My View</title>
</head>
<body>
    <div style="border:1px solid red;">
        <?=$_content?>
<!-- $_content will be replaced by the content of the page that called the function inside() -->
    </div>
</body>
</html>')?>
    </pre>
    <p>This will display:<br />   
        <img style="border:1px dotted;" src="<?=GiveMe::url("pub/app/doc/img/ex3.PNG")?>"/>
    </p>
    <p>
        As you can see in the source code, the code of the view 'hello-world' has been added inside the code of 'layout'.
    </p>
    <p>The function <code>inside()</code> has <b>two</b> parameters.  The <b>first one </b> is required: it is the path of the document you want to insert your content in.<br />
    This function will insert the content of the current file in the file defined by the path, right where you put the $_content variable.
    </p>
    <p>
        Note that for this to work, you need to display the 'hello-world' view, since it is the one that calls the function inside().<br />
        In this case, if you try to display directly the 'layout' view, it will only display its own content, but not the content of the 'hello-world'.
    </p>
</div>


<div class="">
    <h3 class="section">Use variables and basic PHP codes in a view</h3>
    <p>
        Note that the following codes are written in PHP language and therefore can be used, not just in this framework, but in any php file as well.
    </p>
       <h4>Need to repeat something? Use the FOR loop</h4>
        <p>This loop will let your repeat some piece of code as many times as you want.<br />
        In your 'list-item' view, replace the content by the following code:</p>
        <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?for($i=0;$i<3;$i++):?> <!--sets the start and end of the loop-->
    <li>item</li><!--code to be repeated-->
<?endfor?>')?>
        </pre>
        <p>This will display:<br />   
            <img style="border:1px dotted;" src="<?=GiveMe::url("pub/app/doc/img/ex9.PNG")?>"/>
        </p>
        <p>Let's explain the first line of the code:</p>
        <ul>
            <li>$i=0 // $i is a variable that is created and starts at 0.</li>
            <li>$i<3 // is a condition evaluated at each loop iteration. The loop will go on as long as the condition is true.</li>
            <li>$i++ // tells the loop to increment $i at every loop iteration (same as $i+1)</li>
        </ul>
        <p>So basically, the loop will execute the code with $i=0, then with $i=1, 
            then with $i=2 and then will stop because $i=3 and the condition $i<3 isn't true anymore.
        This code will be executed 3 times.</p>
        <p><span class="label">NOTE</span> $i is a variable that exists only in the loop. It can be displayed but only in the loop.<p>
        <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?for($i=0;$i<3;$i++):?>
    <li>item <?=$i?></li>
<?endfor?>')?>
        </pre>
         <p>This will display:<br />   
            <img style="border:1px dotted;" src="<?=GiveMe::url("pub/app/doc/img/ex10.PNG")?>"/>
        </p>
        <div class="alert alert-info">
            <h4>Important</h4> 
            Make sure that the condition you use in the loop <b>isn't always true</b> or else the loop will never end, therefore crashing the system.<br>
            For the same reason, never write the condition with just <code>$i=3</code>, always use <code>$i<3</code>.
        </div>
        
        
        <h4>Add condition with IF...ELSE</h4>
        <p>Sometimes you may need to change the display of a line or two of your view, depending on a condition.</p>
        <p>You can use PHP IF...ELSE statement to execute some code only if a specified condition is true.</p>
        <p>Let's go back to our 'hello-world' file and add the following code at the end:</p>
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
        <p>This will check if the variable $this->viewVariables->title exists.<br />
            If it does, it will display "The variable does exist! it is:" and the value of the variable.<br />
            If it doesn't exist, it will display "sorry, the variable doesn't exist.".<br />
        </p>
        <p>This will display:<br />   
            <img style="border:1px dotted;" src="<?=GiveMe::url("pub/app/doc/img/ex4.PNG")?>"/>
        </p>
        
        
        <h4>Use an array of values with the FOREACH loop</h4>
        <p>
            Sometimes the variables available in the view are arrays of values.
            In this case you will need to execute the same code for each value in the array. 
            To do so, we will use the FOREACH loop.
        </p>
        <p>
            Go to your 'list-item' file and replace its content by the following code:
        </p>
        <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?$fruits=array("apple","banana","cherry");?>
<!-- this creates a variable $fruits that is an array of values -->
    <?foreach ($fruits as $item):?>
    <!-- for each item in this array we execute the following code -->
        <li><?=$item?></li>
    <?endforeach?>')?>
        </pre>
        <p>This will display:<br />   
            <img style="border:1px dotted;" src="<?=GiveMe::url("pub/app/doc/img/ex5.PNG")?>"/>
        </p>
</div>
