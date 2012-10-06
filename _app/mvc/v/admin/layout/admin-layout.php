<?
/* @var $this View */
?>
<?$this->inside("doc/layout/html5bp")?>

<div class="pov-admin">
    <?=$this->insideContent?>
</div>

<div class="loading-full" data-admin-loading="main"></div>


<script>
    Config.apiUrl="/admin/api"
    Config.rootUrl="<?=Site::$root?>";
</script> 