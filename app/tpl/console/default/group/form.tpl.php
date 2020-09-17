<?php if ($groupRow['group_id'] > 0) {
    $title_sub    = $lang->get('Edit');
    $str_sub      = 'index';
} else {
    $title_sub    = $lang->get('Add');
    $str_sub      = 'form';
}

$cfg = array(
    'title'             => $lang->get('Group', 'console.common') . ' &raquo; ' . $title_sub,
    'menu_active'       => 'group',
    'sub_active'        => $str_sub,
    'baigoValidate'    => 'true',
    'baigoSubmit'       => 'true',
    'baigoCheckall'     => 'true',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>group/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <form name="group_form" id="group_form" action="<?php echo $route_console; ?>group/submit/">
        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
        <input type="hidden" name="group_id" id="group_id" value="<?php echo $groupRow['group_id']; ?>">

        <div class="row">
            <div class="col-xl-9">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $lang->get('Name'); ?> <span class="text-danger">*</span></label>
                            <input type="text" name="group_name" id="group_name" value="<?php echo $groupRow['group_name']; ?>" class="form-control">
                            <small class="form-text" id="msg_group_name"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Permission'); ?> <span class="text-danger">*</span></label>
                            <?php include($cfg['pathInclude'] . 'allow_list' . GK_EXT_TPL); ?>
                            <small class="form-text" id="msg_group_allow"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Note'); ?></label>
                            <input type="text" name="group_note" id="group_note" value="<?php echo $groupRow['group_note']; ?>" class="form-control">
                            <small class="form-text" id="msg_group_note"></small>
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
                        <?php if ($groupRow['group_id'] > 0) { ?>
                            <div class="form-group">
                                <label><?php echo $lang->get('ID'); ?></label>
                                <input type="text" value="<?php echo $groupRow['group_id']; ?>" class="form-control-plaintext" readonly>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label><?php echo $lang->get('Status'); ?> <span class="text-danger">*</span></label>
                            <?php foreach ($status as $key=>$value) { ?>
                                <div class="form-check">
                                    <input type="radio" name="group_status" id="group_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($groupRow['group_status'] == $value) { ?>checked<?php } ?> class="form-check-input">
                                    <label for="group_status_<?php echo $value; ?>" class="form-check-label">
                                        <?php echo $lang->get($value); ?>
                                    </label>
                                </div>
                            <?php } ?>
                            <small class="form-text" id="msg_group_status"></small>
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
            group_name: {
                length: '1,30'
            },
            group_note: {
                max: 30
            },
            group_status: {
                require: true
            }
        },
        attr_names: {
            group_name: '<?php echo $lang->get('Name'); ?>',
            group_note: '<?php echo $lang->get('Note'); ?>',
            group_status: '<?php echo $lang->get('Status'); ?>'
        },
        selector_types: {
            group_allow: 'validate'
        },
        type_msg: {
            require: '<?php echo $lang->get('{:attr} require'); ?>',
            max: '<?php echo $lang->get('Max size of {:attr} must be {:rule}'); ?>',
            length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>'
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
        var obj_validate_form   = $('#group_form').baigoValidate(opts_validate_form);
        var obj_submit_form     = $('#group_form').baigoSubmit(opts_submit_form);

        $('#group_form').submit(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
        $('#group_form').baigoCheckall();
    });
    </script>
<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);