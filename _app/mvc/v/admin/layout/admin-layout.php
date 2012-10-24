<?
/* @var $this View */
?>
<?$this->inside("doc/layout/html5bp")?>

<div class="pov-admin">
    <?=$this->insideContent?>
</div>

<?//The main loading ?>
<div class="loading-full" data-admin-loading="main"></div>

<?//A modal template that will be cloned each time we need a modal?>
<div data-modals-manager-template="true">
    <div class='modal hide' >
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h3 data-title="true">The title</h3>
        </div>
        <div class='modal-body loading-soft'>
            ...
        </div>
        <div class='modal-footer'>
            <a href='#' data-dismiss='modal' class='btn'>Close</a>
            <a href='#' data-modal-btn-validate="true" class='btn btn-primary'>Save changes</a>
        </div>
    </div>
</div>

<script>
    Config.apiUrl="/admin/api"
    Config.rootUrl="<?=Site::$root?>";
</script> 