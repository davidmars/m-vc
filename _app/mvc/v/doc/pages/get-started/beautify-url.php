<p>
   As we saw in the 'First Controller' section, there is a connection between the URL and the controller's method beeing called. 
   All controller methods can be called in the URL by using the path :<br />
   example.com/<span class="alert-error">controllerName</span>/<span class="alert-info">methodName</span>/<span class="alert-success">param1/param2/paramN</span><br />
</p>
<p>
   For instance, the following URL:<br />
   example.com/<span class="alert-error">home</span>/<span class="alert-info">index</span>/<span class="alert-success">id</span>/<br />
   will send the parameter <span class="alert-success">id</span> to the method <span class="alert-info">'index()'</span> declared in the controller <span class="alert-error">'HomeController'</span>.
</p>
<p>
    However, for obvious reasons, you may want to change your URL to something more 'readable' for the visitors and more interesting SEO-wise. Like the following examples:
</p>
<p>
    example.com/product/1/<br />
    example.com/product/2/<br />
    example.com/product/3/<br />
    example.com/product/4/
</p>
<p>
    In these examples, the url would call the method called '1' (or 2, 3...) in the 'product' controller.<br />
    This wouldn't make any sense since the number here is more likely to be the ID of a product.<br />
    So we will tell the system to redirect these URL's to the right controller and method with the right parameters.
</p>
<div class="">
    <h3 class="section">route.php file</h3>
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
        So the route we really want to call would be:
        <br />example.com/<span class="alert-error">products</span>/<span class="alert-info">getProduct</span>/<span class="alert-success">1</span>
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
    <h3 class="section">Using jokers</h3>
    <p>To help you construct a regular expression, you have two jokers at your disposal:</p>
    <ul>
        <li>(:any) will represent any characters</li>
        <li>(:num) will represent any numbers</li>
    </ul>
    <p>
        Therefore the following pattern <code>product/(:any)</code> will be matched if product/
        is followed by any characters while <code>product/(:num)</code> will only be matched if product/ is followed by a number.<br />
        The characters represented by (:any) and (:num) can be passed along to the internal route using $1 or $2... $n.
        $1 is the parameter that matched the first pattern between (), $2 is the parameter that matched the second pattern between ()...
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

<div class="">
    <h3 class="section">To go further...</h3>
    <p>
        Using regular expressions in the route.php file will let you manage precisely which URL will be redirected to which controller.<br />
        It can also let you select which parameter you want to pass along.
    </p>
    <p>Consider the following URL:<br />
        <code>example.com/car/volkswagen/black/polo</code><br /><br />
        This kind of URL is very well formated for SEO purposes.
        But we also need this URL to send the parameter 'polo' to a method 'search()' in the Products controller.<br/>
        We need to replace this URL by the following:<br />
        example.com/<span class="alert-error">products</span>/<span class="alert-info">search</span>/<span class="alert-success">polo</span>/<br />
    </p>
    <p>
        To do so we will add the following line to the $routes array:
    </p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities('"car/[[:alnum:]/]*/(.*)"=>"products/search/$1",')?>
    </pre>
    <p>
        In this example, a redirection will occure if the URL starts with "car/", followed by an unlimited number of alpha-numeric characters, seperated by a "/".<br/>
        The URL will be redirected to<br />
        example.com/<span class="alert-error">products</span>/<span class="alert-info">search</span>/<span class="alert-success">$1</span>
        <br /> with $1 beeing the last parameter that was sent in the URL (here 'polo').
    </p>
</div>