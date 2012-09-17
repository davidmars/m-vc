<?php
$vv = new VV_doc_page($_vars);
?>

<div class="">
    <h3>What's a controller ?</h3>
    <p>A controller is a PHP class with a specific name so that it can be associated with an URI.<br />
        One of many purposes of the controller is to load the template that should be displayed.
        In this framework, all controller should be name like this: "c_name.php".<br />
        All class you create should extend the Controller class and all class should be named like this: NameController 
        (starts with a capitalized letter,is named like the file, but without the "c_" and with the word "controller" right after).
    </p>
    <p>All controller files should be stored in the _app/mvc/c folder. Inside that folder, you can create as many subfolders as you want to organize your files.</p>
</div>
<div class="">
    <h3>Your first controller</h3>
    <p>We will start by creating a controller that will only load a template.<br />
        Create a file in the controllers folder that we will name 'c_mycontroller.php' and write the following code in it.</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<?php
class MycontrollerController extends Controller {
    public function index()
    {
        $view=new View("new-template");
        return $view;
    }  	
}
?>')?>
    </pre>
    <p>We just created a method called 'index()' in the controller. This method creates a view from the 'new-template' file and returns it.</p>
    <p>
        Since the file 'new-template' doesn't exist yet, let's create it. In the '/v/' directory, create a new file named 'new-template.php' and put the following code in it:
    </p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('<html>
<head>
    <title>My New Template</title>
</head>
<body>
    <div>
        <h1>Hello you!</h1>
    </div>
</body>
</html>')?>
    </pre>
    <p>To execute that index() method, we just go to the following URL: <br />
    http://www.your-domain.com/root-directory-here/mycontroller/index/
    </p>
    <p>
        Here is what you should get:<br />
        <img style="border:1px dotted;" src="<?=GiveMe::url("pub/app/doc/img/ex6.PNG")?>"/>
    </p>
    <p>
        Note that all controller methods can be called in the URL by using the path : /controllerName/methodName/<br />
        If no methodName is specified, it will call the index() method.
    </p>
</div>

<div class="">
    <h3>Let's add a second method</h3>
    <p>Let's add the following code just before the last "}" of our controller file.</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('public function write()
{
    echo "This is my method write() speaking!";
    $view=new View("new-template");
    return $view;
}')?>
    </pre>
    <p>
        We execute that method by going to the following URL:<br />
        http://www.your-domain.com/root-directory-here/mycontroller/write/
    </p>
     <p>
        Here is what you should get:<br />
        <img style="border:1px dotted;" src="<?=GiveMe::url("pub/app/doc/img/ex7.PNG")?>"/>
    </p>
</div>

<div class="">
    <h3>Let's send a parameter to a method</h3>
    <p>We will create a new method called "read". Let's add the following code just before the last "}" of our controller file.</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('public function read($parameter1=null, $parameter2=null)
{
    echo "This is my method read() speaking!<br />";
    echo "my first parameter is: ".$parameter1;
    echo "<br />my second parameter is: ".$parameter2;
    $view=new View("new-template");
    return $view;
}')?>
    </pre>
    <p>
        We execute that method by going to the following URL:<br />
        http://www.your-domain.com/root-directory-here/mycontroller/read/foo/bar
    </p>
     <p>
        Here is what you should get:<br />
        <img style="border:1px dotted;" src="<?=GiveMe::url("pub/app/doc/img/ex8.PNG")?>"/>
    </p>
    <p>
        Here we put two parameters in the URL and they were sent to the read() method.<br />
        By default, everything you will put in the URL after the name controllerName/methodName 
        will be considered as a parameter for the method.
    </p>
</div>
