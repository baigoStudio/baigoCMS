<?php if ($mimeRow['mime_id'] > 0) {
    $title_sub    = $lang->get('Edit');
    $str_sub      = 'index';
} else {
    $title_sub    = $lang->get('Add');
    $str_sub      = 'form';
}

$cfg = array(
    'title'             => $lang->get('MIME', 'console.common') . ' &raquo; ' . $title_sub,
    'menu_active'       => 'attach',
    'sub_active'        => 'mime',
    'baigoValidate'    => 'true',
    'baigoSubmit'       => 'true',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>mime/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <form name="mime_form" id="mime_form" autocomplete="off" action="<?php echo $route_console; ?>mime/submit/">
        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
        <input type="hidden" name="mime_id" id="mime_id" value="<?php echo $mimeRow['mime_id']; ?>">

        <div class="row">
            <div class="col-xl-9">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $lang->get('Extension name'); ?> <span class="text-danger">*</span></label>
                            <input value="<?php echo $mimeRow['mime_ext']; ?>" name="mime_ext" id="mime_ext" class="form-control">
                            <small class="form-text" id="msg_mime_ext"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('MIME content'); ?> <span class="text-danger">*</span></label>
                            <div id="mime_list">
                                <?php foreach ($mimeRow['mime_content'] as $key=>$value) { ?>
                                    <div class="input-group mb-2" id="mime_group_<?php echo $key; ?>" data-count="<?php echo $key; ?>">
                                        <input type="text" name="mime_content[]" id="mime_content_<?php echo $key; ?>" value="<?php echo $value; ?>" data-validate="mime_content" class="form-control">
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-info mime_del" data-count="<?php echo $key; ?>" class="btn btn-info mime_del">
                                                <span class="fas fa-trash-alt"></span>
                                            </button>
                                        </span>
                                    </div>
                                <?php } ?>
                            </div>

                            <button type="button" class="btn btn-info mime_add">
                                <span class="fas fa-plus"></span>
                            </button>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Note'); ?></label>
                            <input value="<?php echo $mimeRow['mime_note']; ?>" name="mime_note" id="mime_note" class="form-control">
                            <small class="form-text" id="msg_mime_note"></small>
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
                        <?php if ($mimeRow['mime_id'] > 0) { ?>
                            <div class="form-group">
                                <label><?php echo $lang->get('ID'); ?></label>
                                <input type="text" value="<?php echo $mimeRow['mime_id']; ?>" class="form-control-plaintext" readonly>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label form="mime_often"><?php echo $lang->get('Common MIME'); ?></label>
                            <select id="mime_often" class="form-control">
                                <option value=""><?php echo $lang->get('Please select'); ?></option>
                                <?php foreach ($mimeOften as $key_often=>$value_often) { ?>
                                    <option value="<?php echo $key_often; ?>">
                                        <?php echo $lang->get($value_often['note']), ' - ', $key_often; ?>
                                    </option>
                                <?php } ?>
                            </select>
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
    var mime_often  = <?php echo $mimeOftenJson; ?>;

    var opts_validate_form = {
        rules: {
            mime_ext: {
                length: '1,30',
                ajax: {
                    url: '<?php echo $route_console; ?>mime/check/',
                    attach: {
                        selectors: ['#mime_id'],
                        keys: ['mime_id']
                    }
                }
            },
            mime_note: {
                max: 300
            },
            mime_content: {
                require: true
            }
        },
        attr_names: {
            mime_ext: '<?php echo $lang->get('Extension name'); ?>',
            mime_note: '<?php echo $lang->get('Note'); ?>',
            mime_content: '<?php echo $lang->get('MIME content'); ?>'
        },
        selector_types: {
            mime_content: 'validate'
        },
        type_msg: {
            require: '<?php echo $lang->get('{:attr} require'); ?>',
            max: '<?php echo $lang->get('Max size of {:attr} must be {:rule}'); ?>',
            length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>'
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


    function mimeDel(_mime_id) {
        $('#mime_group_' + _mime_id).remove();
    }

    function mimeAdd(value) {
        var count = $('#mime_list > div:last').data('count');
        if (typeof count == 'undefined' || isNaN(count)) {
            count = 0;
        } else {
            ++count;
        }

        $('#mime_list').append('<div class="input-group mb-2" id="mime_group_' + count + '" data-count="' + count + '">' +
            '<input type="text" name="mime_content[]" id="mime_content_' + count + '" data-validate="mime_content" class="form-control" value="' + value + '">' +
            '<span class="input-group-append">' +
                '<button type="button" class="btn btn-info mime_del" data-count="' + count + '">' +
                    '<span class="fas fa-trash-alt"></span>' +
                '</button>' +
            '</span>' +
        '</div>');
    }

    $(document).ready(function(){
        var obj_validate_form  = $('#mime_form').baigoValidate(opts_validate_form);
        var obj_submit_form     = $('#mime_form').baigoSubmit(opts_submit_form);

        $('#mime_form').submit(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });

        $('#mime_often').change(function(){
            var _this_ext   = $(this).val();
            var _this_note  = '';
            var _str_form   = '';
            if (typeof _this_ext != 'undefined') {
                if (typeof mime_often[_this_ext].note != 'undefined') {
                    _this_note  = mime_often[_this_ext].note;
                }
                $('#mime_ext').val(_this_ext);
                $('#mime_note').val(_this_note);
                $('#mime_list').empty();
                $.each(mime_often[_this_ext].content, function(_key, _value){
                    mimeAdd(_value);
                });
            }
        });

        $('.mime_add').click(function(){
            _str_form = mimeAdd('');
        });

        $('#mime_list').on('click', '.mime_del', function(){
            var _count  = $(this).data('count');
            mimeDel(_count);
        });
    });
    </script>
<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);