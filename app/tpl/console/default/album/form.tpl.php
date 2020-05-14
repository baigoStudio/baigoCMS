<?php if ($albumRow['album_id'] > 0) {
    $title_sub    = $lang->get('Edit');
} else {
    $title_sub    = $lang->get('Add');
}

$cfg = array(
    'title'             => $lang->get('Albums', 'console.common') . ' &raquo; ' . $title_sub,
    'menu_active'       => 'attach',
    'sub_active'        => 'album',
    'baigoValidate'     => 'true',
    'baigoSubmit'       => 'true',
    'baigoCheckall'     => 'true',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>album/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <form name="album_form" id="album_form" action="<?php echo $route_console; ?>album/submit/">
        <input type="hidden" name="__token__" value="<?php echo $token; ?>">
        <input type="hidden" name="album_id" id="album_id" value="<?php echo $albumRow['album_id']; ?>">

        <div class="row">
            <div class="col-xl-9">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $lang->get('Name'); ?> <span class="text-danger">*</span></label>
                            <input type="text" name="album_name" id="album_name" value="<?php echo $albumRow['album_name']; ?>" class="form-control">
                            <small class="form-text" id="msg_album_name"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Intro'); ?></label>
                            <textarea type="text" name="album_content" id="album_content" class="form-control bg-textarea-md"><?php echo $albumRow['album_content']; ?></textarea>
                            <small class="form-text" id="msg_album_content"></small>
                        </div>

                        <div class="bg-validate-box"></div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $lang->get('Save'); ?>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="card bg-light">
                    <div class="card-body">
                        <?php if ($albumRow['album_id'] > 0) { ?>
                            <div class="form-group">
                                <label><?php echo $lang->get('ID'); ?></label>
                                <input type="text" value="<?php echo $albumRow['album_id']; ?>" class="form-control-plaintext" readonly>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label><?php echo $lang->get('Status'); ?> <span class="text-danger">*</span></label>
                            <?php foreach ($status as $key=>$value) { ?>
                                <div class="form-check">
                                    <input type="radio" name="album_status" id="album_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($albumRow['album_status'] == $value) { ?>checked<?php } ?> class="form-check-input">
                                    <label for="album_status_<?php echo $value; ?>" class="form-check-label">
                                        <?php echo $lang->get($value); ?>
                                    </label>
                                </div>
                            <?php } ?>
                            <small class="form-text" id="msg_album_status"></small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $lang->get('Save'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL); ?>

    <script type="text/javascript">
    var opts_validate_form = {
        rules: {
            album_name: {
                length: '1,30'
            },
            album_content: {
                max: 30
            },
            album_status: {
                require: true
            }
        },
        attr_names: {
            album_name: '<?php echo $lang->get('Name'); ?>',
            album_content: '<?php echo $lang->get('Note'); ?>',
            album_status: '<?php echo $lang->get('Status'); ?>'
        },
        type_msg: {
            require: '<?php echo $lang->get('{:attr} require'); ?>',
            max: '<?php echo $lang->get('Max size of {:attr} must be {:rule}'); ?>',
            length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>',
            checkbox: '<?php echo $lang->get('Choose at least one {:attr}'); ?>'
        },
        msg: {
            loading: '<?php echo $lang->get('Loading'); ?>'
        },
        box: {
            msg: '<?php echo $lang->get('Input error'); ?>'
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

    $(document).ready(function(){
        var obj_validate_form  = $('#album_form').baigoValidate(opts_validate_form);
        var obj_submit_form     = $('#album_form').baigoSubmit(opts_submit_form);

        $('#album_form').submit(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
        $('#album_form').baigoCheckall();
    });
    </script>
<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);