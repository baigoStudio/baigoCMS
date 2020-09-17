<?php $cfg = array(
    'title'          => $lang->get('Gathering', 'console.common') . ' &raquo; ' . $lang->get('Gathering site', 'console.common'),
    'menu_active'    => 'gather',
    'sub_active'     => 'gsite',
    'help'           => 'gsite_list#form',
    'baigoValidate' => 'true',
    'baigoSubmit'    => 'true',
    'pathInclude'    => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL);
include($cfg['pathInclude'] . 'gsite_head' . GK_EXT_TPL); ?>

    <form name="gsite_form" id="gsite_form" action="<?php echo $route_console; ?>gsite/submit/">
        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
        <input type="hidden" name="gsite_id" id="gsite_id" value="<?php echo $gsiteRow['gsite_id']; ?>">

        <div class="row">
            <div class="col-xl-9">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $lang->get('Name'); ?> <span class="text-danger">*</span></label>
                            <input type="text" name="gsite_name" id="gsite_name" value="<?php echo $gsiteRow['gsite_name']; ?>" class="form-control">
                            <small class="form-text" id="msg_gsite_name"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('URL'); ?> <span class="text-danger">*</span></label>
                            <input type="text" name="gsite_url" id="gsite_url" value="<?php echo $gsiteRow['gsite_url']; ?>" class="form-control" placeholder="http://">
                            <small class="form-text" id="msg_gsite_url"><?php echo $lang->get('Start with <code>http://</code> or <code>https://</code>'); ?></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Charset'); ?> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="gsite_charset" id="gsite_charset" value="<?php echo $gsiteRow['gsite_charset']; ?>" class="form-control" placeholder="UTF-8">
                                <select id="charset_opt" class="custom-select">
                                    <option value=""><?php echo $lang->get('Common charset'); ?></option>
                                    <?php foreach ($charsetRows as $key=>$value) { ?>
                                        <optgroup label="<?php echo $lang->get($value['title'], 'console.charset'); ?>">
                                            <?php foreach ($value['lists'] as $key_sub=>$value_sub) { ?>
                                                <option value="<?php echo $key_sub; ?>">
                                                    <?php echo $lang->get($key_sub), ' - ', $lang->get($value_sub['title'], 'console.charset'); ?>
                                                </option>
                                            <?php } ?>
                                        </optgroup>
                                    <?php } ?>
                                </select>
                                <span class="input-group-append">
                                    <a href="#help_modal_lg" class="btn btn-warning" data-toggle="modal" data-act="charset">
                                        <span class="fas fa-question-circle"></span>
                                    </a>
                                </span>
                            </div>
                            <small class="form-text" id="msg_gsite_charset"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Note'); ?></label>
                            <input type="text" name="gsite_note" id="gsite_note" value="<?php echo $gsiteRow['gsite_note']; ?>" class="form-control">
                            <small class="form-text" id="msg_gsite_note"></small>
                        </div>

                        <div class="bg-validate-box"></div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><?php echo $lang->get('Save'); ?></button>
                    </div>
                </div>

                <?php if ($gsiteRow['gsite_id'] > 0) { ?>
                    <div class="card my-3">
                        <div class="card-header py-2"><?php echo $lang->get('Source code'); ?></div>
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

<?php include($cfg['pathInclude'] . 'gsite_foot' . GK_EXT_TPL);
include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL); ?>

    <script type="text/javascript">
    var opts_validate_form = {
        rules: {
            gsite_name: {
                length: '1,300'
            },
            gsite_url: {
                length: '1,900',
                format: 'url'
            },
            gsite_charset: {
                length: '1,100'
            },
            gsite_note: {
                max: 30
            },
            gsite_status: {
                require: true
            },
            gsite_cate_id: {
                require: true
            }
        },
        attr_names: {
            gsite_name: '<?php echo $lang->get('Name'); ?>',
            gsite_url: '<?php echo $lang->get('URL'); ?>',
            gsite_charset: '<?php echo $lang->get('Charset'); ?>',
            gsite_note: '<?php echo $lang->get('Note'); ?>',
            gsite_status: '<?php echo $lang->get('Status'); ?>',
            gsite_cate_id: '<?php echo $lang->get('Belong to category'); ?>'
        },
        type_msg: {
            require: '<?php echo $lang->get('{:attr} require'); ?>',
            length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>',
            max: '<?php echo $lang->get('Max size of {:attr} must be {:rule}'); ?>'
        },
        format_msg: {
            url: '<?php echo $lang->get('{:attr} not a valid url'); ?>'
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
        $('#charset_opt').change(function(){
            var _charset_val = $(this).val();
            $('#gsite_charset').val(_charset_val);
        });
        var obj_validate_form = $('#gsite_form').baigoValidate(opts_validate_form);
        var obj_submit_form   = $('#gsite_form').baigoSubmit(opts_submit_form);
        $('#gsite_form').submit(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
        $('#gsite_source').html('<div class="embed-responsive embed-responsive-21by9"><iframe class="embed-responsive-item" scrolling="auto" src="<?php echo $route_console; ?>gsite-source/form/id/<?php echo $gsiteRow['gsite_id']; ?>/"></iframe></div>');
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);