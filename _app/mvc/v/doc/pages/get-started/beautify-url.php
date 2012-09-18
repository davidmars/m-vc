<p>
   As we saw in the 'First Controller' section, there is a connection between the URL and the controller's method beeing called:<br />
   all controller methods can be called in the URL by using the path : /className/methodName/<br />
   For instance, the following URL:  example.com/home/index/id/ will send the parameter id to the method 'index()' declared in the class 'HomeController'.
</p>
<p>
    However, for obvious reasons, you may want to change your URL to something more 'readable' for the visitors. Like the following examples:
</p>
<p>
    example.com/product/1/<br />
    example.com/product/2/<br />
    example.com/product/3/<br />
    example.com/product/4/
</p>
<p>
    In these examples, the url would call the method called '1' (or 2, 3...) in the 'product' class.<br />
    This wouldn't make any sense since the number here would be the ID of a product.<br />
    So we will tell the system to redirect these URL's to the right class and method.
</p>
<div class="">
    <h3>route.php file</h3>
    <p>Redirection rules are set in the _app/config/routes.php file. It only contains an array called $routes.<br />
    This array follows this model:<br />
    "Regular expression of an URL" =>"Internal route to the controller",</p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('UrlControler::$routes=array( 
    
    //documentation
    "documentation"=>"doc/doc/index/overview",
    "documentation/"=>"doc/doc/index/overview",
    "documentation/class/(:any)"=>"doc/doc/classDefinition/$1",
    "documentation/(:any)"=>"doc/doc/index/$1",

    //home
    "page/(:any)/(:any)"=>"home/index/$1/$2",
    "page/(:any)"=>"home/index/$1",

    ""=>"home/index",
    "(.*)"=>"err404/index/$1"
);')?>
    </pre>
    <p>
        In the example we want the URL example.com/product/1 to send 1 as a parameter 
        to a method called 'getProduct()' (for instance) and this method belongs to the 'products' class.<br />
        So the route we really want to call would be example.com/products/getProduct/1
    </p>
    <p>
        To do so, all we have to do is add the following line in the $routes array:
    </p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('"product/(:any)"=>"products/getProduct/$1",')?>
    </pre>
    <p>
        This line basically says: if you find the word 'product' in the URL, followed by anything (:any), 
        call the products/getProduct method and send the 'anything' ($1) as a parameter.
    </p>
</div>

<div class="">
    <h3>Using jokers</h3>
    <p>To help you construct a regular expression, you have two jokers at your disposal:</p>
    <ul>
        <li>(:any) will represent any characters</li>
        <li>(:num) will represent any numbers</li>
    </ul>
    <p>
        Therefore the following pattern <code>product/(:any)</code> will be matched if product/
        is followed by any characters while <code>product/(:num)</code> will only be matched if product/ is followed by a number.<br />
        The characters represented by (:any) and (:num) can be passed along to the internal route using $1 or $2...
        (the number being the number of the parameter in the original URL.
    </p>
        <pre class="prettyprint linenums lang-php">
<?=htmlentities('"product/(:any)/(:num)"=>"products/search/$1/$2",
/* in this case $1 has the value of what matched (:any)
and $2 has the value of what matched (:num) */')?>
    </pre>
    <p>
        Note that the redirections will occure in their order of appearence in the $routes array. For instance, you want to set a rule that states:
    </p>
    <ul>
        <li>if product/ is followed by a number it should redirect to products/getProduct/number</li>
        <li>if product/ is followed by anything BUT numbers it should redirect to products/search/anything</li>
    </ul>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('"product/(:any)"=>"products/search/$1",
"product/(:num)"=>"products/getProduct/$1",')?>
    </pre>
    <p>
        In this case, wether you write a number or something else, it will always redirect to "products/search/$1" because numbers are characters!<br />
        So if you want a special treatement for numbers, the line should be added <b>before</b> the line using (:any). Like so:
    </p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('"product/(:num)"=>"products/getProduct/$1",
"product/(:any)"=>"products/search/$1",')?>
    </pre>
</div>

