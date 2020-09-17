<?php if ($callRow['call_id'] > 0) {
    $title_sub    = $lang->get('Edit');
    $str_sub      = 'index';
} else {
    $title_sub    = $lang->get('Add');
    $str_sub      = 'form';
}

$cfg = array(
    'title'             => $lang->get('Call', 'console.common') . ' &raquo; ' . $title_sub,
    'menu_active'       => 'call',
    'sub_active'        => $str_sub,
    'baigoValidate'    => 'true',
    'baigoSubmit'       => 'true',
    'baigoCheckall'     => 'true',
    'typeahead'         => 'true',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>call/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <form name="call_form" id="call_form" action="<?php echo $route_console; ?>call/submit/">
        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
        <input type="hidden" name="call_id" id="call_id" value="<?php echo $callRow['call_id']; ?>">

        <div class="row">
            <div class="col-xl-9">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $lang->get('Name'); ?> <span class="text-danger">*</span></label>
                            <input type="text" name="call_name" id="call_name" value="<?php echo $callRow['call_name']; ?>" class="form-control">
                            <small class="form-text" id="msg_call_name"></small>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane active" id="call_article">
                                <div class="alert alert-success">
                                    <span class="fas fa-filter"></span>
                                    <?php echo $lang->get('Filter'); ?>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $lang->get('Category'); ?></label>
                                    <div class="form-check">
                                        <label for="call_cate_ids_0"  class="form-check-label">
                                            <input type="checkbox" id="call_cate_ids_0" data-parent="first" class="form-check-input">
                                            <?php echo $lang->get('All categories'); ?>
                                        </label>
                                    </div>
                                    <table class="bg-table">
                                        <tbody>
                                            <?php $cate_ids = $callRow['call_cate_ids'];
                                            $form_name = 'call';
                                            include($cfg['pathInclude'] . 'cate_list_checkbox' . GK_EXT_TPL); ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $lang->get('Special topic'); ?></label>
                                    <div id="spec_list">
                                        <?php foreach ($specRows as $key=>$value) { ?>
                                            <div class="input-group mb-2" id="spec_item_<?php echo $value['spec_id']; ?>">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text border-success">
                                                        <input type="hidden" name="call_spec_ids[]" value="<?php echo $value['spec_id']; ?>">
                                                        <span class="fas fa-check-circle text-primary"></span>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control border-success bg-transparent" readonly value="<?php echo $value['spec_name']; ?>">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-success spec_del" data-id="<?php echo $value['spec_id']; ?>">
                                                        <span class="fas fa-trash-alt"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <input type="text" id="spec_key" name="spec_key" placeholder="<?php echo $lang->get('Keyword'); ?>" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label><?php echo $lang->get('With pictures'); ?></label>
                                    <select id="call_attach" name="call_attach" class="form-control">
                                        <?php foreach ($attach as $key=>$value) { ?>
                                            <option <?php if ($callRow['call_attach'] == $value) { ?>selected<?php } ?> value="<?php echo $value; ?>">
                                                <?php echo $lang->get($value); ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $lang->get('Mark'); ?></label>
                                    <?php foreach ($markRows as $key=>$value) { ?>
                                        <div class="form-check">
                                            <label for="call_mark_ids_<?php echo $value['mark_id']; ?>"  class="form-check-label">
                                                <input type="checkbox" <?php if (in_array($value['mark_id'], $callRow['call_mark_ids'])) { ?>checked<?php } ?> value="<?php echo $value['mark_id']; ?>" name="call_mark_ids[]" id="call_mark_ids_<?php echo $value['mark_id']; ?>" class="form-check-input">
                                                <?php echo $value['mark_name']; ?>
                                            </label>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="tab-pane" id="call_cate">
                                <div class="alert alert-success">
                                    <span class="fas fa-filter"></span>
                                    <?php echo $lang->get('Filter'); ?>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $lang->get('Category'); ?></label>
                                    <div class="form-check">
                                        <label for="call_cate_id_0" class="form-check-label">
                                            <input type="radio" <?php if ($callRow['call_cate_id'] == 0) { ?>checked<?php } ?> value="0" name="call_cate_id" id="call_cate_id_0" class="form-check-input">
                                            <?php echo $lang->get('All categories'); ?>
                                        </label>
                                    </div>
                                    <table class="bg-table">
                                        <tbody>
                                            <?php $cate_id = $callRow['call_cate_id'];
                                            $cate_excepts = $callRow['call_cate_excepts'];
                                            //$lang = $callRow['call_cate_excepts'];
                                            $form_name = 'call';
                                            include($cfg['pathInclude'] . 'cate_list_radio' . GK_EXT_TPL); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
                        <?php if ($callRow['call_id'] > 0) { ?>
                            <div class="form-group">
                                <label><?php echo $lang->get('ID'); ?></label>
                                <input type="text" value="<?php echo $callRow['call_id']; ?>" class="form-control-plaintext" readonly>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label><?php echo $lang->get('Status'); ?> <span class="text-danger">*</span></label>
                            <?php foreach ($status as $key=>$value) { ?>
                                <div class="form-check">
                                    <input type="radio" name="call_status" id="call_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($callRow['call_status'] == $value) { ?>checked<?php } ?> class="form-check-input">
                                    <label for="call_status_<?php echo $value; ?>" class="form-check-label">
                                        <?php echo $lang->get($value); ?>
                                    </label>
                                </div>
                            <?php } ?>
                            <small class="form-text" id="msg_call_status"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Type'); ?> <span class="text-danger">*</span></label>
                            <select id="call_type" name="call_type" class="form-control">
                                <option value=""><?php echo $lang->get('Please select'); ?></option>
                                <?php foreach ($type as $key=>$value) { ?>
                                    <option <?php if ($callRow['call_type'] == $value) { ?>selected<?php } ?> value="<?php echo $value; ?>">
                                        <?php echo $lang->get($value); ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <small class="form-text" id="msg_call_type"></small>
                        </div>

                        <?php if ($gen_open === true) { ?>
                            <div class="form-group">
                                <label><?php echo $lang->get('Type of generate file'); ?> <span class="text-danger">*</span></label>
                                <select name="call_file" id="call_file" class="form-control">
                                    <option value=""><?php echo $lang->get('Please select'); ?></option>
                                    <?php foreach ($file as $key=>$value) { ?>
                                        <option <?php if ($callRow['call_file'] == $value) { ?>selected<?php } ?> value="<?php echo $value; ?>">
                                            <?php echo $value; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <small class="form-text" id="msg_call_file"></small>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('Template'); ?> <span class="text-danger">*</span></label>
                                <select name="call_tpl" id="call_tpl" class="form-control">
                                    <option value=""><?php echo $lang->get('Please select'); ?></option>
                                    <?php foreach ($tplRows as $key=>$value) {
                                        if ($value['type'] == 'file') { ?>
                                            <option <?php if ($callRow['call_tpl'] == $value['name_s']) { ?>selected<?php } ?> value="<?php echo $value['name_s']; ?>">
                                                <?php echo $value['name_s']; ?>
                                            </option>
                                        <?php }
                                    } ?>
                                </select>
                                <small class="form-text" id="msg_call_tpl"></small>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label><?php echo $lang->get('Amount of display'); ?> <span class="text-danger">*</span></label>

                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <?php echo $lang->get('Top'); ?>
                                    </div>
                                </div>
                                <input type="text" name="call_amount[top]" id="call_amount_top" value="<?php echo $callRow['call_amount']['top']; ?>" class="form-control">
                            </div>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <?php echo $lang->get('Except top'); ?>
                                    </div>
                                </div>
                                <input type="text" name="call_amount[except]" id="call_amount_except" value="<?php echo $callRow['call_amount']['except']; ?>" class="form-control">
                            </div>

                            <small class="form-text" id="msg_call_amount_top"></small>
                            <small class="form-text" id="msg_call_amount_except"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Date condition'); ?> <span class="text-danger">*</span></label>

                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <?php echo $lang->get('Within days'); ?>
                                    </div>
                                </div>
                                <input type="text" name="call_period" id="call_period" value="<?php echo $callRow['call_period']; ?>" class="form-control">
                            </div>

                            <small class="form-text" id="msg_call_period">
                                <?php echo $lang->get('<kbd>0</kbd> is unlimited'); ?>
                            </small>
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
            call_name: {
                length: '1,300'
            },
            call_type: {
                require: true
            },
            call_status: {
                require: true
            },
            <?php if ($gen_open === true) { ?>
                call_file: {
                    require: true
                },
                call_tpl: {
                    require: true
                },
            <?php } ?>
            call_amount_top: {
                require: true,
                format: 'int'
            },
            call_amount_except: {
                require: true,
                format: 'int'
            }
        },
        attr_names: {
            call_name: '<?php echo $lang->get('Name'); ?>',
            call_type: '<?php echo $lang->get('Type'); ?>',
            call_status: '<?php echo $lang->get('Status'); ?>',
            call_file: '<?php echo $lang->get('Type of generate file'); ?>',
            call_tpl: '<?php echo $lang->get('Template'); ?>',
            call_amount_top: '<?php echo $lang->get('Top'); ?>',
            call_amount_except: '<?php echo $lang->get('Except top'); ?>'
        },
        selector_types: {
            call_amount_top: 'id',
            call_amount_except: 'id'
        },
        type_msg: {
            require: '<?php echo $lang->get('{:attr} require'); ?>',
            length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>'
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

    function specAdd(spec_id, spec_name) {
        if ($('#spec_item_' + spec_id).length < 1) {
            var _spec_list_html = '<div class="input-group mb-2" id="spec_item_' + spec_id + '">' +
                '<div class="input-group-prepend">' +
                    '<div class="input-group-text border-success">' +
                        '<input type="hidden" name="call_spec_ids[]" value="' + spec_id + '">' +
                        '<span class="fas fa-check-circle text-primary"></span>' +
                    '</div>' +
                '</div>' +
                '<input type="text" class="form-control border-success bg-transparent" readonly value="' + spec_name + '">' +
                '<div class="input-group-append">' +
                    '<button type="button" class="btn btn-success spec_del" data-id="' + spec_id + '">' +
                        '<span class="fas fa-trash-alt"></span>' +
                    '</button>' +
                '</div>' +
            '</div>';

            $('#spec_list').append(_spec_list_html);
        }
    }

    function specDel(id) {
        $('#spec_item_' + id).remove();
    }

    function callType(call_type) {
        switch (call_type) {
            case 'cate':
                $('#call_article').hide();
                $('#call_cate').show();
            break;

            case 'link':
            case 'spec':
            case 'tag_list':
            case 'tag_rank':
                $('#call_article').hide();
                $('#call_cate').hide();
            break;

            default:
                $('#call_article').show();
                $('#call_cate').hide();
            break;
        }
    }

    $(document).ready(function(){
        callType('<?php echo $callRow['call_type']; ?>');
        var obj_validate_form  = $('#call_form').baigoValidate(opts_validate_form);
        var obj_submit_form     = $('#call_form').baigoSubmit(opts_submit_form);

        $('#call_form').submit(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });

        $('#call_form').baigoCheckall();

        var specsData = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '<?php echo $route_console; ?>spec/typeahead/key/%KEY/',
                wildcard: '%KEY'
            }
        });

        specsData.initialize();

        var _obj_spec = $('#spec_key').typeahead(
            {
                highlight: true
            },
            {
                source: specsData.ttAdapter(),
                display: 'spec_name'
            }
        );

        _obj_spec.bind('typeahead:select', function(ev, suggestion) {
            specAdd(suggestion.spec_id, suggestion.spec_name);
            $('#spec_key').typeahead('val', '');
        });

        $('#spec_list').on('click', '.spec_del', function(){
            var _id  = $(this).data('id');
            specDel(_id);
        });

        $('#call_type').change(function(){
            var _call_type = $(this).val();
            callType(_call_type);
        });
    });
    </script>
<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);