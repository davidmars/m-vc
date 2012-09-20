<?php
$vv=new VV_doc_page($_vars);
?>
<p>
    We will describe through step by step examples how to do common stuff with images.<br/><br/>
</p>
<div class="">
    First, here is our native image without any manipulations.<br/>
    It's a transparent png (the photoshop like background is in css).<br/>
    Original size is 800 x 520px<br/></br>
    <pre class="prettyprint linenums lang-php">
    <?=htmlentities('
<img class="toshop" src="<?=GiveMe::url("pub/app/fmk/img/logo.png")?>"/>
    ')?>
    </pre>
    <img class="toshop" src="<?=GiveMe::url("pub/app/fmk/img/logo.png")?>"/>
</div>
<p>
    To manipulate images we will use the function <code>GiveMe::imageSized()</code>.<br />
    This function has <b>five parameters:</b><br/>
</p>
    <ol>
        <li>url of the original image (required)</li>
        <li>final width in pixels or 'auto' (required)</li>
        <li>final height in pixels or 'auto' (required)</li>
        <li>background color (optional, black if not specified)</li>
        <li>MIME type (optional, jpg if not specified)</li>
    </ol>
<p>
    This function will return the url of the resized image.
</p>
<div class="alert alert-info">
    <h4>Important</h4> 
    Note that the <code>GiveMe::imageSized()</code> function <b>will crop the image</b> vertically or horizontally 
    if the width/height ratio of the original image doesn't match the dimensions you want for the new image. 
    
</div>


<div class="">
    <h4>Basic resize to 200px by 200px </h4>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities(
'<img class="toshop" src="<?=GiveMe::imageSized("pub/app/fmk/img/logo.png", 200,200)?>"/>'
)?>
    </pre>
    <p class="floating">
        <img class="toshop" src="<?=GiveMe::imageSized("pub/app/fmk/img/logo.png",200,200)?>"/>
        The image is now 200px by 200px. It's no more a png but a jpeg and has a black background.
    </p>
</div>

<div class="">
    <h4>I need a green background! </h4>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities(
'<img class="toshop" src="<?=GiveMe::imageSized("pub/app/fmk/img/logo.png",200,200,"00ff00")?>"/>'
)?>
    </pre>
    <p class="floating">
        <img class="toshop" src="<?=GiveMe::imageSized("pub/app/fmk/img/logo.png",200,200,"00ff00")?>"/>
        So the 3rd attribute is a color. Note that there is no # before the hexadecimal code... right?
    </p>
</div>

<div class="">
    <h4>No, finally I prefer the transparent png </h4>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities(
'<img class="toshop" 
  src="<?=GiveMe::imageSized("pub/app/fmk/img/logo.png",200,200,"transparent","png")?>"/>'
)?>
    </pre>
    <p class="floating">
        <img class="toshop" src="<?=GiveMe::imageSized("pub/app/fmk/img/logo.png",200,200,"transparent","png")?>"/>
        So the 3rd attribute is a color... but the keyword <em>transparent</em> works too. The 4th parameter is the mime type.
        By default the function generates jpegs but if you write <em>png</em> it will output guess what... a png!
    </p>
</div>

<div class="">
    <h4>Play with ratios: get a landscape format</h4>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities(
'<img class="toshop" 
  src="<?=GiveMe::imageSized("pub/app/fmk/img/logo.png",400,100,"transparent","png")?>"/>'
)?>
    </pre>
    <p class="floating">
        <img class="toshop" src="<?=GiveMe::imageSized("pub/app/fmk/img/logo.png",400,100,"transparent","png")?>"/>
        All you have to do to get a landscape format is to choose a <em>width</em> bigger than the <em>height</em>. <br />
        In this case, your image will fit horizontally but the top and bottom of the image may be cropped.
    </p>
</div>
    
<div class="">
    <h4>Play with ratios, part II: get a portrait format</h4>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities(
'<img class="toshop" 
  src="<?=GiveMe::imageSized("pub/app/fmk/img/logo.png",200,300,"transparent","png")?>"/>'
)?>
    </pre>
    <p class="floating">
        <img class="toshop" src="<?=GiveMe::imageSized("pub/app/fmk/img/logo.png",200,300,"transparent","png")?>"/>
        All you have to do to get a landscape format is to choose a <em>height</em> bigger than the <em>width</em>. <br />
        In this case, your image will fit vertically but the sides of the image may be cropped.
    </p>
</div>   

<div class="">
    <h4>Resize images without cropping</h4>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities(
'<img class="toshop" 
  src="<?=GiveMe::imageSizedWithoutCrop("pub/app/fmk/img/logo.png",200,200,"cdcdcd","jpg")?>"/>'
)?>
    </pre>
    <p class="floating">
        <img class="toshop" src="<?=GiveMe::imageSizedWithoutCrop("pub/app/fmk/img/logo.png",200,200,"cdcdcd","jpg")?>"/>
        The function <code>GiveMe::imageSizedWithoutCrop()</code> has the same <b>five</b> parameters than the function<code>GiveMe::imageSized()</code>.<br /><br />
        The only difference between the two is that <code>GiveMe::imageSizedWithoutCrop()</code> 
        won't crop your image if the ratio of the dimensions you asked for doesn't match the ratio of the original image:
        the whole image will be resized to fit in the dimensions you specified.
    </p>    
</div>   

<div class="">
    <h4>Comparison of both functions</h4>
    <p>
        See how the two functions are resizing the same image with the same <em>width</em> and <em>height</em> specified:
    </p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities(
'<img class="toshop" 
  src="<?=GiveMe::imageSizedWithoutCrop("pub/app/fmk/img/logo.png",100,300,"transparent","png")?>"/>
<!-- Vs -->
<img class="toshop" 
  src="<?=GiveMe::imageSized("pub/app/fmk/img/logo.png",100,300,"transparent","png")?>"/>'
)?>
    </pre>
    <p class="floating">
        <img class="toshop" src="<?=GiveMe::imageSizedWithoutCrop("pub/app/fmk/img/logo.png",100,300,"transparent","png")?>"/>
        <img class="toshop" src="<?=GiveMe::imageSized("pub/app/fmk/img/logo.png",100,300,"transparent","png")?>"/>
    </p>
    
    <pre class="prettyprint linenums lang-php">
<?=htmlentities(
'<img class="toshop" 
  src="<?=GiveMe::imageSizedWithoutCrop("pub/app/fmk/img/logo.png",300,100,"transparent","png")?>"/>
<!-- Vs -->
<img class="toshop" 
  src="<?=GiveMe::imageSized("pub/app/fmk/img/logo.png",300,100,"transparent","png")?>"/>'
)?>
    </pre>
    <p class="floating">
        <img class="toshop" src="<?=GiveMe::imageSizedWithoutCrop("pub/app/fmk/img/logo.png",300,100,"transparent","png")?>"/>
        <img class="toshop" src="<?=GiveMe::imageSized("pub/app/fmk/img/logo.png",300,100,"transparent","png")?>"/>
    </p>    
</div>

<div class="">
    <h4>Resizing with an 'auto' value</h4>
    <p>
        Sometimes  you will need to fit an image in a specified width but you won't know the corresponding height.<br />
        With both functions, you can set a specific width and set the height to 'auto'. 
        This will automatically calculate the height of the picture so that the original proportions are preserved.
    </p>
    <pre class="prettyprint linenums lang-php">
<?=htmlentities(
'<img class="toshop" 
  src="<?=GiveMe::imageSizedWithoutCrop("pub/app/fmk/img/logo.png",100,auto,"transparent","png")?>"/>
<!-- Vs -->
<img class="toshop" 
  src="<?=GiveMe::imageSized("pub/app/fmk/img/logo.png",100,auto,"transparent","png")?>"/>'
)?>
    </pre>
    <p class="floating">
        <img class="toshop" src="<?=GiveMe::imageSizedWithoutCrop("pub/app/fmk/img/logo.png",100,auto,"transparent","png")?>"/>
        <img class="toshop" src="<?=GiveMe::imageSized("pub/app/fmk/img/logo.png",100,auto,"transparent","png")?>"/>
    </p>
    
    <pre class="prettyprint linenums lang-php">
<?=htmlentities(
'<img class="toshop" 
  src="<?=GiveMe::imageSizedWithoutCrop("pub/app/fmk/img/logo.png",auto,100,"transparent","png")?>"/>
<!-- Vs -->
<img class="toshop" 
  src="<?=GiveMe::imageSized("pub/app/fmk/img/logo.png",auto,100,"transparent","png")?>"/>'
)?>
    </pre>
    <p class="floating">
        <img class="toshop" src="<?=GiveMe::imageSizedWithoutCrop("pub/app/fmk/img/logo.png",auto,100,"transparent","png")?>"/>
        <img class="toshop" src="<?=GiveMe::imageSized("pub/app/fmk/img/logo.png",auto,100,"transparent","png")?>"/>
    </p>
    <p>
        Note that when you use the auto value, then both functions return the same result.
    </p>
    
</div>

<div class="alert alert-block alert-success">
    <h4>Want to know how it works?</h4>

    <h5>
        Images are in cache!
    </h5>
    <p>
        Because playing with images is hard for your server, the images are processed only once.<br/>
        All the processed image files are located in the folder <em> pub/media/cache/img</em>.<br/>
    </p>

    <h5>
        Processed images lifecycle.
    </h5>    
    <p>

        A call to <code>GiveMe::imageSomething(...)</code> will only return the url of the image, but the serious job will not be done.<br/>
        The URL you'll get in fact is a route with its own controller, methods etc... 
        So when a browser go to this url there are two possibilities:<br/><br/>
        
        <b>First time:</b> The url is not a file yet, so the .htaccess, index.php etc... lead us to the controller, 
        that parses the url, 
        processes the image, 
        returns it to the browser like a "View"
        ... and it saves the file in pub/media/cache/img/route-controller.<br/></br>
        
        <b>Second time:</b> The url is already a file that was created before, so the file will be returned to the browser normally without any php processing.<br/>
    </p>

</div>
