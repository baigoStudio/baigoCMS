<?php $cfg = array(
    'title'          => $lang->get('Gathering', 'console.common') . ' &raquo; ' . $lang->get('Gathering site', 'console.common'),
    'menu_active'    => 'gather',
    'sub_active'     => 'gsite',
    'help'           => 'gsite_list#form',
    'baigoSubmit'    => 'true',
    'pathInclude'    => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>gsite/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <form name="gsite_form" id="gsite_form" action="<?php echo $route_console; ?>gsite/duplicate/">
        <input type="hidden" name="__token__" value="<?php echo $token; ?>">
        <input type="hidden" name="gsite_id" id="gsite_id" value="<?php echo $gsiteRow['gsite_id']; ?>">

        <div class="row">
            <div class="col-xl-9">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $lang->get('Name'); ?></label>
                            <div class="form-text"><?php echo $gsiteRow['gsite_name']; ?></div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('URL'); ?></label>
                            <div class="form-text"><?php echo $gsiteRow['gsite_url']; ?></div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Charset'); ?> <span class="text-danger">*</span></label>
                            <div class="form-text"><?php echo $gsiteRow['gsite_charset']; ?></div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Note'); ?></label>
                            <div class="form-text"><?php echo $gsiteRow['gsite_note']; ?></div>
                        </div>

                        <div class="bg-validate-box"></div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <?php echo $lang->get('Duplicate'); ?>
                            </button>

                            <a href="<?php echo $route_console; ?>gsite/form/id/<?php echo $gsiteRow['gsite_id']; ?>/">
                                <span class="fas fa-edit"></span>
                                <?php echo $lang->get('Edit'); ?>
                            </a>
                        </div>
                    </div>
                </div>

                <?php if ($gsiteRow['gsite_id'] > 0) { ?>
                    <div class="card my-3">
                        <div class="card-header"><?php echo $lang->get('Source code'); ?></div>
                        <div id="gsite_source">
                            <div class="loading p-3">
                                <h4 class="text-info">
                                    <span class="spinner-grow"></span>
                                    Loading...
                                </h4>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <?php include($cfg['pathInclude'] . 'gsite_side' . GK_EXT_TPL); ?>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL); ?>

    <script type="text/javascript">
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

    $(document).ready(function(){
        var obj_submit_form   = $('#gsite_form').baigoSubmit(opts_submit_form);
        $('#gsite_form').submit(function(){
            obj_submit_form.formSubmit();
        });

        $('#gsite_source').html('<div class="embed-responsive embed-responsive-21by9"><iframe class="embed-responsive-item" scrolling="auto" src="<?php echo $route_console; ?>gsite_source/form/id/<?php echo $gsiteRow['gsite_id']; ?>/"></iframe></div>');
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);