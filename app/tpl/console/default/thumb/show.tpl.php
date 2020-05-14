<?php $cfg = array(
    'title'         => $lang->get('Attachment', 'console.common') . ' &raquo; ' . $lang->get('Thumbnails', 'console.common'),
    'menu_active'   => 'attach',
    'sub_active'    => 'thumb',
    'baigoDialog'   => 'true',
    'baigoClear'    => 'true',
    'pathInclude'   => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>thumb/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <div class="row">
        <div class="col-xl-9">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="alert alert-warning">
                        <span class="fas fa-exclamation-triangle"></span>
                        <?php echo $lang->get('Warning! This operation will take a long time!'); ?>
                    </div>

                    <form name="thumb_regen" id="thumb_regen" action="<?php echo $route_console; ?>attach/regen/">
                        <input type="hidden" name="__token__" value="<?php echo $token; ?>">
                        <input type="hidden" name="thumb_id" value="<?php echo $thumbRow['thumb_id']; ?>">

                        <div class="form-group">
                            <label><?php echo $lang->get('Attachment ID range'); ?></label>
                            <div class="input-group">
                                <input type="text" name="min_id" id="min_id" value="0" class="form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text border-right-0"><?php echo $lang->get('To'); ?></span>
                                </div>
                                <input type="text" name="max_id" id="max_id" value="0" class="form-control">
                            </div>
                            <small class="form-text"><?php echo $lang->get('<kbd>0</kbd> is unlimited'); ?></small>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-warning">
                                <span class="fas fa-sync-alt"></span>
                                <?php echo $lang->get('Regenerate thumbnails'); ?>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-right">
                    <a href="<?php echo $route_console; ?>thumb/form/id/<?php echo $thumbRow['thumb_id']; ?>/">
                        <span class="fas fa-edit"></span>
                        <?php echo $lang->get('Edit'); ?>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="form-group">
                        <label><?php echo $lang->get('ID'); ?></label>
                        <div class="form-text"><?php echo $thumbRow['thumb_id']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Maximum width'); ?></label>
                        <div class="form-text"><?php echo $thumbRow['thumb_width']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Maximum height'); ?></label>
                        <div class="form-text"><?php echo $thumbRow['thumb_height']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Type'); ?></label>
                        <div class="form-text"><?php echo $lang->get($thumbRow['thumb_type']); ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Quality'); ?></label>
                        <div class="form-text"><?php echo $thumbRow['thumb_quality']; ?></div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="<?php echo $route_console; ?>thumb/form/id/<?php echo $thumbRow['thumb_id']; ?>/">
                        <span class="fas fa-edit"></span>
                        <?php echo $lang->get('Edit'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL); ?>
    <script type="text/javascript">
    var opts_dialog = {
        btn_text: {
            cancel: '<?php echo $lang->get('Cancel'); ?>',
            confirm: '<?php echo $lang->get('Confirm'); ?>'
        }
    };

    var opts_regen = {
        msg: {
            loading: '<?php echo $lang->get('x070409'); ?>',
            complete: '<?php echo $lang->get('y070409'); ?>'
        }
    };

    $(document).ready(function(){
        var obj_dialog  = $.baigoDialog(opts_dialog);
        var obj_regen   = $('#thumb_regen').baigoClear(opts_regen);

        $('#thumb_regen').submit(function(){
            obj_dialog.confirm('<?php echo $lang->get('Warning! This operation will take a long time!'); ?>', function(confirm_result){
                if (confirm_result) {
                    obj_regen.clearSubmit();
                }
            });
        });
    });
    </script>
<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);