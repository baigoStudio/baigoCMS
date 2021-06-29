<?php $cfg = array(
    'title'         => $lang->get('System settings', 'console.common') . ' &raquo; ' . $lang->get('Database settings', 'console.common'),
    'menu_active'   => 'opt',
    'sub_active'    => 'dbconfig',
    'baigoValidate' => 'true',
    'baigoSubmit'   => 'true',
    'baigoClear'    => 'true',
    'baigoDialog'   => 'true',
    'pathInclude'   => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <div class="row">
        <div class="col-md-3">
            <div class="alert alert-warning">
                <h5><?php echo $lang->get('Clean up data'); ?></h5>
                <span class="fas fa-exclamation-triangle"></span>
                <?php echo $lang->get('Warning! This operation will take a long time!'); ?>
            </div>

            <ul class="list-group mb-3">
                <li class="list-group-item">
                    <form name="form_article" id="form_article" class="form_clear" action="<?php echo $route_console; ?>article/clear/">
                        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
                        <div class="mb-2"><?php echo $lang->get('Unaffiliated articles'); ?></div>
                        <button type="submit" class="btn btn-warning" id="btn_article">
                            <span class="fas fa-trash-alt"></span>
                            <?php echo $lang->get('Clean up'); ?>
                        </button>
                    </form>
                </li>

                <li class="list-group-item">
                    <form name="form_cate" id="form_cate" class="form_clear" action="<?php echo $route_console; ?>cate_belong/clear/">
                        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
                        <div class="mb-2"><?php echo $lang->get('Data of belong to category'); ?></div>
                        <button type="submit" class="btn btn-warning" id="btn_cate">
                            <span class="fas fa-trash-alt"></span>
                            <?php echo $lang->get('Clean up'); ?>
                        </button>
                    </form>
                </li>

                <li class="list-group-item">
                    <form name="form_spec" id="form_spec" class="form_clear" action="<?php echo $route_console; ?>spec_belong/clear/">
                        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
                        <div class="mb-2"><?php echo $lang->get('Data of belong to special topic'); ?></div>
                        <button type="submit" class="btn btn-warning" id="btn_spec">
                            <span class="fas fa-trash-alt"></span>
                            <?php echo $lang->get('Clean up'); ?>
                        </button>
                    </form>
                </li>

                <li class="list-group-item">
                    <form name="form_tag" id="form_tag" class="form_clear" action="<?php echo $route_console; ?>tag_belong/clear/">
                        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
                        <div class="mb-2"><?php echo $lang->get('Data of belong to tag'); ?></div>
                        <button type="submit" class="btn btn-warning" id="btn_tag">
                            <span class="fas fa-trash-alt"></span>
                            <?php echo $lang->get('Clean up'); ?>
                        </button>
                    </form>
                </li>

                <li class="list-group-item">
                    <form name="form_album" id="form_album" class="form_clear" action="<?php echo $route_console; ?>album_belong/clear/">
                        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
                        <div class="mb-2"><?php echo $lang->get('Data of belong to album'); ?></div>
                        <button type="submit" class="btn btn-warning" id="btn_album">
                            <span class="fas fa-trash-alt"></span>
                            <?php echo $lang->get('Clean up'); ?>
                        </button>
                    </form>
                </li>

                <li class="list-group-item">
                    <form name="form_content" id="form_content" class="form_clear" action="<?php echo $route_console; ?>article_content/clear/">
                        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
                        <div class="mb-2"><?php echo $lang->get('Data of article content'); ?></div>
                        <button type="submit" class="btn btn-warning" id="btn_content">
                            <span class="fas fa-trash-alt"></span>
                            <?php echo $lang->get('Clean up'); ?>
                        </button>
                    </form>
                </li>

                <li class="list-group-item">
                    <form name="form_custom" id="form_custom" class="form_clear" action="<?php echo $route_console; ?>article_custom/clear/">
                        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
                        <div class="mb-2"><?php echo $lang->get('Data of custom fields'); ?></div>
                        <button type="submit" class="btn btn-warning" id="btn_custom">
                            <span class="fas fa-trash-alt"></span>
                            <?php echo $lang->get('Clean up'); ?>
                        </button>
                    </form>
                </li>

                <li class="list-group-item">
                    <h5><?php echo $lang->get('Upgrade data'); ?></h5>
                    <div class="alert alert-warning">
                        <?php echo $lang->get('Warning! Please backup the data before upgrading.'); ?>
                    </div>
                    <a href="#upgrade_modal" class="btn btn-primary" data-toggle="modal">
                        <span class="fas fa-database"></span>
                        <?php echo $lang->get('Upgrade'); ?>
                    </a>
                </li>
            </ul>
        </div>

        <div class="col-md-9">
            <form name="opt_form" id="opt_form" action="<?php echo $route_console; ?>opt/dbconfig-submit/">
                <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">

                <div class="card">
                    <div class="card-body">
                        <?php include($cfg['pathInclude'] . 'dbconfig' . GK_EXT_TPL); ?>

                        <div class="bg-validate-box"></div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $lang->get('Save'); ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="upgrade_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <?php echo $lang->get('Warning! Please backup the data before upgrading.'); ?>
                    </div>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="upgrade_content">
                </div>
                <div class="modal-footer" id="upgrade_foot">
                    <button type="button" class="btn btn-primary btn-sm" id="upgrade_confirm">
                        <?php echo $lang->get('Confirm upgrade'); ?>
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
                        <?php echo $lang->get('Close', 'console.common'); ?>
                    </button>
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

    var opts_submit_form = {
        modal: {
            btn_text: {
                close: '<?php echo $lang->get('Close'); ?>',
                ok: '<?php echo $lang->get('OK'); ?>'
            }
        },
        msg_text: {
            submitting: '<?php echo $lang->get('Saving'); ?>'
        }
    };

    var opts_clear = {
        msg: {
            loading: '<?php echo $lang->get('Submitting'); ?>',
            complete: '<?php echo $lang->get('Complete'); ?>'
        }
    };

    $(document).ready(function(){
        $('#upgrade_foot').on('click', '#upgrade_confirm', function(){
            $('#upgrade_modal #upgrade_content').load('<?php echo $route_console; ?>opt/data-upgrade/view/modal/');
    	});

        $('#upgrade_modal').on('hidden.bs.modal', function(){
        	$('#upgrade_modal #upgrade_content').empty();
    	});

        var obj_validate_form   = $('#opt_form').baigoValidate(opts_validate_form);
        var obj_submit_form     = $('#opt_form').baigoSubmit(opts_submit_form);

        $('#opt_form').submit(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });

        var obj_dialog = $.baigoDialog(opts_dialog);

        var obj_clear_article  = $('#form_article').baigoClear(opts_clear);

        $('#form_article').submit(function(){
            obj_dialog.confirm('<?php echo $lang->get('Warning! This operation will take a long time!'); ?>', function(confirm_result){
                if (confirm_result) {
                    obj_clear_article.clearSubmit();
                }
            });
        });

        var obj_clear_cate  = $('#form_cate').baigoClear(opts_clear);

        $('#form_cate').submit(function(){
            obj_dialog.confirm('<?php echo $lang->get('Warning! This operation will take a long time!'); ?>', function(confirm_result){
                if (confirm_result) {
                    obj_clear_cate.clearSubmit();
                }
            });
        });

        var obj_clear_spec  = $('#form_spec').baigoClear(opts_clear);

        $('#form_spec').submit(function(){
            obj_dialog.confirm('<?php echo $lang->get('Warning! This operation will take a long time!'); ?>', function(confirm_result){
                if (confirm_result) {
                    obj_clear_spec.clearSubmit();
                }
            });
        });

        var obj_clear_tag  = $('#form_tag').baigoClear(opts_clear);

        $('#form_tag').submit(function(){
            obj_dialog.confirm('<?php echo $lang->get('Warning! This operation will take a long time!'); ?>', function(confirm_result){
                if (confirm_result) {
                    obj_clear_tag.clearSubmit();
                }
            });
        });

        var obj_clear_album  = $('#form_album').baigoClear(opts_clear);

        $('#form_album').submit(function(){
            obj_dialog.confirm('<?php echo $lang->get('Warning! This operation will take a long time!'); ?>', function(confirm_result){
                if (confirm_result) {
                    obj_clear_album.clearSubmit();
                }
            });
        });

        var obj_clear_content  = $('#form_content').baigoClear(opts_clear);

        $('#form_content').submit(function(){
            obj_dialog.confirm('<?php echo $lang->get('Warning! This operation will take a long time!'); ?>', function(confirm_result){
                if (confirm_result) {
                    obj_clear_content.clearSubmit();
                }
            });
        });

        var obj_clear_custom  = $('#form_custom').baigoClear(opts_clear);

        $('#form_custom').submit(function(){
            obj_dialog.confirm('<?php echo $lang->get('Warning! This operation will take a long time!'); ?>', function(confirm_result){
                if (confirm_result) {
                    obj_clear_custom.clearSubmit();
                }
            });
        });
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);
