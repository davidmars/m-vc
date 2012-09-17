<?
/**
 * this is defined in the controller 
 */
$vv=new VV_fmk_page($_vars);
?>
<!doctype html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?=$vv->htmlHeader->title?></title>
	<meta name="description" content="<?=$vv->htmlHeader->description?>">
	<meta name="author" content="<?=$vv->htmlHeader->author?>">
	<meta name="keywords" content="<?=$vv->htmlHeader->keywords?>">

	<meta name="viewport" content="width=device-width">


        <?=CSS::addToHeader("pub/libs/bootstrap/css/bootstrap.min.css")?>
        <?=CSS::addToHeader("pub/app/lolo.css")?>
        <?=CSS::includeHeaderFiles()?>
        <?=JS::addAfterBody("pub/app/lolo.js")?>
        <?=JS::includeHeaderFiles()?>
        
        <script src="<?=Site::url(Site::$publicFolder."/libs/modernizr-2.5.3-respond-1.1.0.min.js")?>"></script>
</head>
<body style="margin-bottom: 40px;margin-top: 40px;">
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->

<div class="row">
    <div class="span9">
        <h1><?=$vv->title?></h1>
    </div>
</div>
<div class="row">
  <div class="span3">
    <p class="off">
        lorem ipsum il parait qu'il faut mettre.<br />
        lorem ipsum il parait qu'il faut mettre.<br />
    </p>
  </div>
  <div class="span6">
    <table class="table">
        <tr class="success">
            <td>1</td>
            <td>TB - Monthly</td>
            <td>01/04/2012</td>
            <td>Approved</td>
        </tr>
        <tr class="error">
            <td>1</td>
            <td>TB - Monthly</td>
            <td>01/04/2012</td>
            <td>Approved</td>
        </tr>
    </table>
  </div>
</div>
<div class="row">
    <div class="span7">
        lorem ipsum il parait qu'il faut mettre.  lorem ipsum il parait qu'il faut mettre.  lorem ipsum il parait qu'il faut mettre.  lorem ipsum il parait qu'il faut mettre. 
            lorem ipsum il parait qu'il faut mettre.  lorem ipsum il parait qu'il faut mettre.  lorem ipsum il parait qu'il faut mettre. 
            lorem ipsum il parait qu'il faut mettre.  lorem ipsum il parait qu'il faut mettre.  lorem ipsum il parait qu'il faut mettre. 
    </div>
    <div class="span2">
        <p class="">titi tutut</p>
    </div>
</div>

<?/*
 * 
 * 
 * lib scripts here...
 * 
 * 
 */?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="<?=Site::$root."/".Site::$publicFolder."/libs/bootstrap/js/bootstrap.js"?>"></script>

<?/*
 * 
 * 
 * app scripts here...
 * 
 * 
 */
?>
<?=JS::includeAfterBodyFiles();?>
<script src="<?=Site::$root."/".Site::$publicFolder."/app/Main.js"?>"></script>


<script>
	var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
	(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
	g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
	s.parentNode.insertBefore(g,s)}(document,'script'));
</script>

</body>
</html>