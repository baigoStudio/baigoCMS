<?php
function custom_list_option($arr_customRows, $check_id, $disabled_id) {
    if (!empty($arr_customRows)) {
        foreach ($arr_customRows as $_key=>$_value) { ?>
            <option <?php if ($check_id == $_value['custom_id']) { ?>selected<?php } ?> <?php if ($disabled_id == $_value['custom_id']) { ?>disabled<?php } ?> value="<?php echo $_value['custom_id']; ?>">
                <?php if ($_value['custom_level'] > 1) {
                    for ($_iii = 1; $_iii < $_value['custom_level']; ++$_iii) { ?>
                        &nbsp;&nbsp;
                    <?php }
                }
                echo $_value['custom_name']; ?>
            </option>

            <?php if (isset($_value['custom_childs'])) {
                custom_list_option($_value['custom_childs'], $check_id, $disabled_id);
            }
        }
    }
}

if (isset($customRows)) {
    $_arr_customRows = $customRows;
} else if (!isset($_arr_customRows)) {
    $_arr_customRows = array();
}

if (!isset($check_id)) {
    $check_id = -1;
}

if (!isset($disabled_id)) {
    $disabled_id = 0;
}

if ($customRow['custom_id'] > 0) {
    $title_sub    = $lang->get('Edit');
} else {
    $title_sub    = $lang->get('Add');
}

$cfg = array(
    'title'             => $lang->get('Custom fields', 'console.common') . ' &raquo; ' . $title_sub,
    'menu_active'       => 'article',
    'sub_active'        => 'custom',
    'baigoValidate'     => 'true',
    'baigoSubmit'       => 'true',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>custom/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <form name="custom_form" id="custom_form" action="<?php echo $route_console; ?>custom/submit/">
        <input type="hidden" name="__token__" value="<?php echo $token; ?>">
        <input type="hidden" name="custom_id" id="custom_id" value="<?php echo $customRow['custom_id']; ?>">

        <div class="row">
            <div class="col-xl-9">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $lang->get('Name'); ?> <span class="text-danger">*</span></label>
                            <input value="<?php echo $customRow['custom_name']; ?>" name="custom_name" id="custom_name" class="form-control">
                            <small class="form-text" id="msg_custom_name"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Size'); ?> <span class="text-danger">*</span></label>
                            <input type="text" name="custom_size" id="custom_size" value="<?php echo $customRow['custom_size']; ?>" class="form-control">
                            <small class="form-text" id="msg_custom_size"><?php echo $lang->get('The unit is a character, and one Chinese occupies 3 characters.'); ?></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Parent field'); ?> <span class="text-danger">*</span></label>
                            <select name="custom_parent_id" id="custom_parent_id" class="form-control">
                                <option value=""><?php echo $lang->get('Please select'); ?></option>
                                <option <?php if ($customRow['custom_parent_id'] == 0) { ?>selected<?php } ?> value="0"><?php echo $lang->get('As a primary field'); ?></option>
                                <?php custom_list_option($_arr_customRows, $customRow['custom_parent_id'], $customRow['custom_id']); ?>
                            </select>
                            <small class="form-text" id="msg_custom_parent_id"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Type'); ?> <span class="text-danger">*</span></label>
                            <select name="custom_type" id="custom_type" class="form-control">
                                <option value=""><?php echo $lang->get('Please select'); ?></option>
                                <?php foreach ($type as $key=>$value) { ?>
                                    <option <?php if ($customRow['custom_type'] == $value) { ?>selected<?php } ?> value="<?php echo $value; ?>">
                                        <?php echo $lang->get($value); ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <small class="form-text" id="msg_custom_type"></small>
                        </div>

                        <div class="form-group">
                            <?php foreach ($type as $key_type=>$value_type) {
                                if ($value_type == 'radio' || $value_type == 'select') { ?>
                                    <div id="group_<?php echo $value_type; ?>" class="group_opt">
                                        <div id="group_<?php echo $value_type; ?>_option">
                                            <?php if (isset($customRow['custom_opt'][$value_type])) {
                                                foreach ($customRow['custom_opt'][$value_type] as $key_opt=>$value_opt) { ?>
                                                    <div class="input-group mb-2" id="group_<?php echo $value_type; ?>_<?php echo $key_opt; ?>" data-count="<?php echo $key_opt; ?>">
                                                        <span class="input-group-prepend"><span class="input-group-text"><?php echo $lang->get('Option'); ?></span></span>
                                                        <input type="text" name="custom_opt[<?php echo $value_type; ?>][<?php echo $key_opt; ?>]" class="form-control" value="<?php echo $value_opt; ?>">
                                                        <span class="input-group-append">
                                                            <button type="button" class="btn btn-info option_del" data-count="<?php echo $key_opt; ?>" data-type="<?php echo $value_type; ?>">
                                                                <span class="fas fa-trash-alt"></span>
                                                            </button>
                                                        </span>
                                                    </div>
                                                <?php }
                                            } ?>
                                        </div>

                                        <button type="button" class="btn btn-success option_add" data-type="<?php echo $value_type; ?>">
                                            <span class="fas fa-plus"></span>
                                        </button>
                                    </div>
                                <?php }
                            } ?>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Format'); ?> <span class="text-danger">*</span></label>
                            <select name="custom_format" id="custom_format" class="form-control">
                                <option value=""><?php echo $lang->get('Please select'); ?></option>
                                <?php foreach ($format as $key=>$value) { ?>
                                    <option <?php if ($customRow['custom_format'] == $value) { ?>selected<?php } ?> value="<?php echo $value; ?>">
                                        <?php echo $lang->get($value); ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <small class="form-text" id="msg_custom_format"></small>
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
                        <?php if ($customRow['custom_id'] > 0) { ?>
                            <div class="form-group">
                                <label><?php echo $lang->get('ID'); ?></label>
                                <input type="text" value="<?php echo $customRow['custom_id']; ?>" class="form-control-plaintext" readonly>
                            </div>
                        <?php }

                        if ($customRow['custom_parent_id'] < 1) { ?>
                            <div class="form-group">
                                <label><?php echo $lang->get('Belong to category'); ?> <span class="text-danger">*</span></label>
                                <select name="custom_cate_id" id="custom_cate_id" class="form-control">
                                    <option value=""><?php echo $lang->get('Please select'); ?></option>
                                    <option <?php if ($customRow['custom_cate_id'] == 0) { ?>selected<?php } ?> value="0"><?php echo $lang->get('All categories'); ?></option>
                                    <?php $check_id = $customRow['custom_cate_id'];
                                    include($cfg['pathInclude'] . 'cate_list_option' . GK_EXT_TPL); ?>
                                </select>
                                <small class="form-text" id="msg_custom_cate_id"></small>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label><?php echo $lang->get('Status'); ?> <span class="text-danger">*</span></label>
                            <?php foreach ($status as $key=>$value) { ?>
                                <div class="form-check">
                                    <input type="radio" name="custom_status" id="custom_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($customRow['custom_status'] == $value) { ?>checked<?php } ?> class="form-check-input">
                                    <label for="custom_status_<?php echo $value; ?>" class="form-check-label">
                                        <?php echo $lang->get($value); ?>
                                    </label>
                                </div>
                            <?php } ?>
                            <small class="form-text" id="msg_custom_status"></small>
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
    var opts_validate_modal = {
        rules: {
            custom_name: {
                length: '1,90'
            },
            custom_type: {
                require: true
            },
            custom_status: {
                require: true
            },
            custom_parent_id: {
                require: true
            },
            <?php if ($customRow['custom_parent_id'] < 1) { ?>
                custom_cate_id: {
                    require: true
                },
            <?php } ?>
            custom_format: {
                require: true
            },
            custom_size: {
                require: true,
                format: 'int'
            }
        },
        attr_names: {
            custom_name: '<?php echo $lang->get('Name'); ?>',
            custom_type: '<?php echo $lang->get('Type'); ?>',
            custom_status: '<?php echo $lang->get('Status'); ?>',
            custom_parent_id: '<?php echo $lang->get('Parent field'); ?>',
            custom_cate_id: '<?php echo $lang->get('Category'); ?>',
            custom_format: '<?php echo $lang->get('Format'); ?>',
            custom_size: '<?php echo $lang->get('Size'); ?>'
        },
        type_msg: {
            length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>',
            require: '<?php echo $lang->get('{:attr} require'); ?>'
        },
        format_msg: {
            'int': '<?php echo $lang->get('{:attr} must be integer'); ?>'
        },
        msg: {
            loading: '<?php echo $lang->get('Loading'); ?>'
        },
        box: {
            msg: '<?php echo $lang->get('Input error'); ?>'
        }
    };

    var opts_submit_modal = {
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

    function optionDel(count, type) {
        $('#group_' + type + '_' + count).remove();
    }

    function optionAdd(type) {
        var count = $('#group_' + type + '_option > div:last').data('count');
        if (typeof count == 'undefined' || isNaN(count)) {
            count = 0;
        } else {
            ++count;
        }

        $('#group_' + type + '_option').append('<div class="input-group mb-2" id="group_' + type + '_' + count + '" data-count="' + count + '">' +
            '<span class="input-group-prepend"><span class="input-group-text"><?php echo $lang->get('Option'); ?></span></span>' +
            '<input type="text" name="custom_opt[' + type + '][' + count + ']" class="form-control">' +
            '<span class="input-group-append">' +
                '<button type="button" class="btn btn-info option_del" data-count="' + count + '" data-type="' + type + '">' +
                    '<span class="fas fa-trash-alt"></span>' +
                '</button>' +
            '</span>' +
        '</div>');
    }

    function customType(custom_type) {
        $('.group_opt').hide();
        $('#group_' + custom_type).show();
    }

    $(document).ready(function(){
        customType('<?php echo $customRow['custom_type']; ?>');
        var obj_validate_modal  = $('#custom_form').baigoValidate(opts_validate_modal);
        var obj_submit_modal     = $('#custom_form').baigoSubmit(opts_submit_modal);

        $('#custom_form').submit(function(){
            if (obj_validate_modal.verify()) {
                obj_submit_modal.formSubmit();
            }
        });

        $('#custom_type').change(function(){
            var _this_val = $(this).val();
            if (typeof _this_val != 'undefined') {
                customType(_this_val);
            }
        });

        $('.option_add').click(function(){
            var _type = $(this).data('type');
            optionAdd(_type);
        });

        $('.group_opt').on('click', '.option_del', function(){
            var _count  = $(this).data('count');
            var _type   = $(this).data('type');
            optionDel(_count, _type);
        });
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);