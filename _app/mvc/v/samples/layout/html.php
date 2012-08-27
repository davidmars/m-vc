<?
    $vv=new LayoutVariables($_vars);
?>
<!doctype html>
<html class="no-js" lang="en">
    
    <head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	    <title></title>
	    <meta name="description" content="">
	    <meta name="author" content="">

	    <meta name="viewport" content="width=device-width">

	    <?/*=<script src="assets/lib/modernizr-2.5.3-respond-1.1.0.min.js"></script>*/?>
    </head>
    
    <body>

	<h3>I'm mvc/v/samples/layout/html.php</h3>

	<p>
	    I have a stupid title : <em><?=$vv->pageTitle?></em>
	</p>
	<div style="border: 1px dotted #000; padding: 20px;">
	    <?/*
	     * 
	     * 
	     * 
	     * the folowing is interesting....
	     * 
	     * 
	     */?>
	    
	    <?=$_content?>
	    
	</div>

    </body>
    
</html>
