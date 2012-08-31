<?
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

	<?=Less::getIncludeTag("assets/lib/bootstrap/less/bootstrap")?>
	<?=Less::getIncludeTag("assets/lib/bootstrap/less/responsive")?>
	<link rel="stylesheet" href="assets/project/fonts.css">
	<?=Less::getIncludeTag("assets/project/project")?>
	<?/*
	<link rel="stylesheet" href="assets/lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/project/fonts.css">
	<link rel="stylesheet" href="assets/project/style.css">
	*/?>
	<script src="assets/lib/modernizr-2.5.3-respond-1.1.0.min.js"></script>
</head>
<body>
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->

<?=$this->render("layout/header")?>

<?=$_content?>

<?=$this->render("layout/fixed-footer")?>
<?=$this->render("layout/fixed-bookmarks")?>
<?=$this->render("layout/fixed-header")?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="assets/lib/jquery-1.7.2.min.js"><\/script>')</script>

<script src="assets/lib/bootstrap/js/bootstrap.min.js"></script>

<script src="assets/project/FixElement.js"></script>
<script src="assets/project/Scroll.js"></script>
<script src="assets/project/script.js"></script>
<script>
	var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
	(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
	g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
	s.parentNode.insertBefore(g,s)}(document,'script'));
</script>

</body>
</html>
