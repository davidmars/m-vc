<?
/* @var $this View */
$vv=new LayoutVariables($_vars);
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?=$vv->htmlHeader->title?></title>
	<meta name="description" content="<?=$vv->htmlHeader->description?>">
	<meta name="author" content="<?=$vv->htmlHeader->author?>">
	<meta name="keywords" content="<?=$vv->htmlHeader->keywords?>">

	<meta name="viewport" content="width=device-width">
        
        
        <?/*
          fonts loaded before...then used in less
          <link rel="stylesheet" href="assets/project/fonts.css">
         */?>

        <?=CSS::includeHeaderFiles(false)?>
        <?=JS::includeHeaderFiles(false)?>

</head>
<body class="fmk-doc" data-spy="scroll" data-target=".sections-menu">
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->



<?=$this->insideContent?>

<?/*
 * 
 * 
 * js scripts here...
 * 
 * 
 */?>
<?=JS::includeAfterBodyFiles(false,false)?>

<script>
	var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
	(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
	g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
	s.parentNode.insertBefore(g,s)}(document,'script'));
</script>

</body>
</html>
