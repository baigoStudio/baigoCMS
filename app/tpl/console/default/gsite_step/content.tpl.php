<?php $cfg = array(
    'title'          => $lang->get('Gathering', 'console.common') . ' &raquo; ' . $lang->get('Gathering site', 'console.common'),
    'menu_active'    => 'gather',
    'sub_active'     => 'gsite',
    'help'           => 'step_content',
    'baigoValidate'  => 'true',
    'baigoSubmit'    => 'true',
    'prism'          => 'true',
    'pathInclude'    => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL);
include($cfg['pathInclude'] . 'gsite_head' . GK_EXT_TPL); ?>

    <form name="gsite_form" id="gsite_form" action="<?php echo $route_console; ?>gsite-step/content-submit/">
        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
        <input type="hidden" name="gsite_id" id="gsite_id" value="<?php echo $gsiteRow['gsite_id']; ?>">

        <div class="row">
            <div class="col-xl-9">
                <div class="card mb-3">
                    <div class="card-header"><?php echo $lang->get('Content settings'); ?></div>
                    <div id="bg-step-content">
                        <div class="list-group list-group-flush">
                            <?php foreach ($configContent as $key=>$value) { ?>
                                <a class="list-group-item list-group-item-action d-flex bg-light justify-content-between align-items-center" data-toggle="collapse" href="#bg-form-<?php echo $key; ?>">
                                    <span><?php echo $lang->get($value['title']); ?></span>
                                    <small class="fas fa-chevron-down" id="bg-caret-<?php echo $key; ?>"></small>
                                </a>
                                <div id="bg-form-<?php echo $key; ?>" data-key="<?php echo $key; ?>" class="list-group-item collapse<?php if (isset($value['show'])) { ?> show<?php } ?>" data-parent="#bg-step-content">
                                    <div class="form-group">
                                        <label>
                                            <?php echo $lang->get('Selector'); ?>
                                            <?php if (isset($value['require'])) { ?><span class="text-danger">*</span><?php } ?>
                                        </label>
                                        <input type="text" name="gsite_<?php echo $key; ?>_selector" id="gsite_<?php echo $key; ?>_selector" value="<?php echo $gsiteRow['gsite_' . $key . '_selector']; ?>" class="form-control">
                                        <small class="form-text" id="msg_gsite_<?php echo $key; ?>_selector"><?php echo $lang->get('Please use the jQuery selector'); ?></small>
                                    </div>

                                    <div class="form-group">
                                        <label><?php echo $lang->get('Gathering attribute'); ?></label>
                                        <div class="input-group">
                                            <input type="text" name="gsite_<?php echo $key; ?>_attr" id="gsite_<?php echo $key; ?>_attr" value="<?php echo $gsiteRow['gsite_' . $key . '_attr']; ?>" class="form-control">
                                            <select class="custom-select attr_often" data-type="<?php echo $key; ?>">
                                                <option value=""><?php echo $lang->get('Common attribute'); ?></option>
                                                <?php foreach ($attrOften as $_key=>$_value) { ?>
                                                    <option <?php if ($gsiteRow['gsite_' . $key . '_attr'] == $_key) { ?>selected<?php } ?> value="<?php echo $_key; ?>">
                                                        <?php echo $_key; ?>
                                                        -
                                                        <?php echo $lang->get($_value); ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <span class="input-group-append">
                                                <a href="#help_modal" class="btn btn-warning" data-toggle="modal" data-act="attr_qlist">
                                                    <span class="fas fa-question-circle"></span>
                                                </a>
                                            </span>
                                        </div>
                                        <small class="form-text" id="msg_gsite_<?php echo $key; ?>_attr"><?php echo $lang->get('Default is html'); ?></small>
                                    </div>

                                    <div class="form-group">
                                        <label><?php echo $lang->get('Filter'); ?></label>
                                        <div class="input-group">
                                            <input type="text" name="gsite_<?php echo $key; ?>_filter" id="gsite_<?php echo $key; ?>_filter" value="<?php echo $gsiteRow['gsite_' . $key . '_filter']; ?>" class="form-control">
                                            <span class="input-group-append">
                                                <a href="#help_modal" class="btn btn-warning" data-toggle="modal" data-act="filter">
                                                    <span class="fas fa-question-circle"></span>
                                                </a>
                                            </span>
                                        </div>
                                        <small class="form-text" id="msg_gsite_<?php echo $key; ?>_filter"><?php echo $lang->get('Filter out unwanted elements, and multiple values separated by <kbd>,</kbd>'); ?></small>
                                    </div>

                                    <label><?php echo $lang->get('Replace'); ?></label>

                                    <div id="<?php echo $key; ?>_replace" class="replace_box">
                                        <?php foreach ($gsiteRow['gsite_' . $key . '_replace'] as $key_replace=>$value_replace) { ?>
                                            <div id="<?php echo $key; ?>_replace_group_<?php echo $key_replace; ?>" class="form-row" data-count="<?php echo $key_replace; ?>">
                                                <div class="form-group col-lg-6">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><?php echo $lang->get('Search'); ?></span>
                                                        </div>
                                                        <input type="text" name="gsite_<?php echo $key; ?>_replace[<?php echo $key_replace; ?>][search]" id="gsite_<?php echo $key; ?>_replace_<?php echo $key_replace; ?>_search" value="<?php echo $value_replace['search']; ?>" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><?php echo $lang->get('Replace'); ?></span>
                                                        </div>
                                                        <input type="text" name="gsite_<?php echo $key; ?>_replace[<?php echo $key_replace; ?>][replace]" id="gsite_<?php echo $key; ?>_replace_<?php echo $key_replace; ?>_replace" value="<?php echo $value_replace['replace']; ?>" class="form-control">
                                                        <span class="input-group-append">
                                                            <button type="button" data-count="<?php echo $key_replace; ?>" data-type="<?php echo $key; ?>" class="btn btn-info replace_del">
                                                                <span class="fas fa-trash-alt"></span>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <div class="form-group">
                                        <button type="button" data-type="<?php echo $key; ?>" class="btn btn-info replace_add">
                                            <span class="fas fa-plus"></span>
                                        </button>
                                    </div>

                                    <small class="form-text"><?php echo $lang->get('If "Replace" is empty, system will remove the character, the usage is similar to the search and replace of Word, WPS'); ?></small>
                                </div>
                            <?php } ?>

                            <a class="list-group-item list-group-item-action d-flex bg-light justify-content-between align-items-center" data-toggle="collapse" href="#bg-form-filter-content">
                                <span><?php echo $lang->get('Filter content'); ?></span>
                                <small class="fas fa-chevron-down" id="bg-caret-filter-content"></small>
                            </a>
                            <div id="bg-form-filter-content" data-key="filter-content" class="list-group-item collapse" data-parent="#bg-step-content">
                                <p><?php echo $lang->get('The following parameters are only for the content, all HTML attributes will be removed by default'); ?></p>

                                <div class="form-group">
                                    <label><?php echo $lang->get('Retained tags'); ?></label>
                                    <div class="input-group">
                                        <input type="text" name="gsite_keep_tag" id="gsite_keep_tag" value="<?php echo $gsiteRow['gsite_keep_tag']; ?>" class="form-control">
                                        <span class="input-group-append">
                                            <a href="#keep_tag_modal" class="btn btn-warning" data-toggle="modal">
                                                <span class="fas fa-question-circle"></span>
                                            </a>
                                        </span>
                                    </div>
                                    <small class="form-text" id="msg_gsite_keep_tag">
                                        <?php echo $lang->get('All tags in the content will be removed, except the default retained tags. Please enter other tags to be retained here. Multiple tags should be separated by <kbd>,</kbd>'); ?>
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $lang->get('Attribute of image source'); ?></label>
                                    <input type="text" name="gsite_img_src" id="gsite_img_src" value="<?php echo $gsiteRow['gsite_img_src']; ?>" class="form-control">
                                    <small class="form-text" id="msg_gsite_img_src"><?php echo $lang->get('Default is <code>src</code>'); ?></small>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $lang->get('Filter image'); ?></label>
                                    <input type="text" name="gsite_img_filter" id="gsite_img_filter" value="<?php echo $gsiteRow['gsite_img_filter']; ?>" class="form-control">
                                    <small class="form-text" id="msg_gsite_img_filter"><?php echo $lang->get('Filter out images with these keywords in the path. Separate multiple keywords with <kbd>,</kbd>'); ?></small>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $lang->get('Retained attributes'); ?></label>
                                    <input type="text" name="gsite_attr_allow" id="gsite_attr_allow" value="<?php echo $gsiteRow['gsite_attr_allow']; ?>" class="form-control">
                                    <small class="form-text" id="msg_gsite_attr_allow">
                                        <?php echo $lang->get('These attributes will be retained, and multiple attributes should be separated by <kbd>,</kbd>'); ?>
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $lang->get('Ignore tags'); ?></label>
                                    <input type="text" name="gsite_ignore_tag" id="gsite_ignore_tag" value="<?php echo $gsiteRow['gsite_ignore_tag']; ?>" class="form-control">
                                    <small class="form-text" id="msg_gsite_ignore_tag">
                                        <?php echo $lang->get('All attributes of these tags will be retained, and multiple tags should be separated by <kbd>,</kbd>'); ?>
                                    </small>
                                </div>

                                <label>
                                    <?php echo $lang->get('Exception'); ?>
                                    <a href="#keep_attr_modal" data-toggle="modal">
                                        <span class="fas fa-question-circle"></span>
                                    </a>
                                </label>

                                <div id="attr_except">
                                    <?php foreach ($gsiteRow['gsite_attr_except'] as $key_attr_except=>$value_attr_except) { ?>
                                        <div id="attr_except_group_<?php echo $key_attr_except; ?>" class="form-row" data-count="<?php echo $key_attr_except; ?>">
                                            <div class="form-group col-md-4">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><?php echo $lang->get('Tag'); ?></span>
                                                    </div>
                                                    <input type="text" name="gsite_attr_except[<?php echo $key_attr_except; ?>][tag]" id="gsite_attr_except_<?php echo $key_attr_except; ?>_tag" value="<?php echo $value_attr_except['tag']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><?php echo $lang->get('Attributes'); ?></span>
                                                    </div>
                                                    <input type="text" name="gsite_attr_except[<?php echo $key_attr_except; ?>][attr]" id="gsite_attr_except_<?php echo $key_attr_except; ?>_attr" value="<?php echo $value_attr_except['attr']; ?>" class="form-control">
                                                    <span class="input-group-append">
                                                        <button type="button" data-count="<?php echo $key_attr_except; ?>" class="btn btn-info except_del">
                                                            <span class="fas fa-trash-alt"></span>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>

                                <div class="form-group">
                                    <button type="button" id="attr_except_add" class="btn btn-info">
                                        <span class="fas fa-plus"></span>
                                    </button>
                                </div>

                                <small class="form-text">
                                    <?php echo $lang->get('The specific attributes of these tags will be retained, and multiple attributes under the same tag should be separated by <kbd>,</kbd>'); ?>
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="bg-validate-box"></div>

                        <button type="submit" class="btn btn-primary"><?php echo $lang->get('Save'); ?></button>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header py-2"><?php echo $lang->get('Preview'); ?></div>
                    <div id="gsite_preview">
                        <div class="loading p-3">
                            <h4 class="text-info">
                                <span class="spinner-grow"></span>
                                Loading...
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
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
            </div>

            <?php include($cfg['pathInclude'] . 'gsite_side' . GK_EXT_TPL); ?>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'gsite_foot' . GK_EXT_TPL);
include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL); ?>

    <script type="text/javascript">
    var opts_validate_form = {
        rules: {
            <?php foreach ($configContent as $key=>$value) {
                if (isset($value['require'])) {
                    $str_rule = '1';
                } else {
                    $str_rule = '0';
                } ?>
                gsite_<?php echo $key; ?>_selector: {
                    length: '<?php echo $str_rule; ?>,100'
                },
                gsite_<?php echo $key; ?>_attr: {
                    max: 100
                },
                gsite_<?php echo $key; ?>_filter: {
                    max: 100
                },
            <?php } ?>
            gsite_keep_tag: {
                max: 300
            },
            gsite_img_filter: {
                max: 100
            },
            gsite_attr_allow: {
                max: 100
            },
            gsite_ignore_tag: {
                max: 300
            }
        },
        attr_names: {
            <?php foreach ($configContent as $key=>$value) { ?>
                gsite_<?php echo $key; ?>_selector: '<?php echo $lang->get('Selector'); ?>',
                gsite_<?php echo $key; ?>_attr: '<?php echo $lang->get('Gathering attribute'); ?>',
                gsite_<?php echo $key; ?>_filter: '<?php echo $lang->get('Filter'); ?>',
            <?php } ?>
            gsite_keep_tag: '<?php echo $lang->get('Retained tags'); ?>',
            gsite_img_filter: '<?php echo $lang->get('Filter image'); ?>',
            gsite_attr_allow: '<?php echo $lang->get('Retained attributes'); ?>',
            gsite_ignore_tag: '<?php echo $lang->get('Ignore tags'); ?>'
        },
        type_msg: {
            length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>',
            max: '<?php echo $lang->get('Max size of {:attr} must be {:rule}'); ?>'
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

    function replaceAdd(type) {
        var count = $('#' + type + '_replace > div:last').data('count');
        if (typeof count == 'undefined' || isNaN(count)) {
            count = 0;
        } else {
            ++count;
        }

        $('#' + type + '_replace').append('<div id="' + type + '_replace_group_' + count + '" class="form-row" data-count="' + count + '">' +
            '<div class="form-group col-lg-6">' +
                '<div class="input-group">' +
                    '<div class="input-group-prepend">' +
                        '<span class="input-group-text"><?php echo $lang->get('Search'); ?></span>' +
                    '</div>' +
                    '<input type="text" name="gsite_' + type + '_replace[' + count + '][search]" id="gsite_' + type + '_replace_' + count + '_search" class="form-control">' +
                '</div>' +
            '</div>' +
            '<div class="form-group col-lg-6">' +
                '<div class="input-group">' +
                    '<div class="input-group-prepend">' +
                        '<span class="input-group-text"><?php echo $lang->get('Replace'); ?></span>' +
                    '</div>' +
                    '<input type="text" name="gsite_' + type + '_replace[' + count + '][replace]" id="gsite_' + type + '_replace_' + count + '_replace" class="form-control">' +
                    '<span class="input-group-append">' +
                        '<button type="button" data-count="' + count + '" data-type="' + type + '" class="btn btn-info replace_del">' +
                            '<span class="fas fa-trash-alt"></span>' +
                        '</button>' +
                    '</span>' +
                '</div>' +
            '</div>' +
        '</div>');
    }

    function exceptAdd() {
        var count = $('#attr_except > div:last').data('count');
        if (typeof count == 'undefined' || isNaN(count)) {
            count = 0;
        } else {
            ++count;
        }

        $('#attr_except').append('<div id="attr_except_group_' + count + '" class="form-row" data-count="' + count + '">' +
            '<div class="form-group col-md-4">' +
                '<div class="input-group">' +
                    '<div class="input-group-prepend">' +
                        '<span class="input-group-text"><?php echo $lang->get('Tag'); ?></span>' +
                    '</div>' +
                    '<input type="text" name="gsite_attr_except[' + count + '][tag]" id="gsite_attr_except_' + count + '_tag" class="form-control">' +
                '</div>' +
            '</div>' +
            '<div class="form-group col-md-8">' +
                '<div class="input-group">' +
                    '<div class="input-group-prepend">' +
                        '<span class="input-group-text"><?php echo $lang->get('Attributes'); ?></span>' +
                    '</div>' +
                    '<input type="text" name="gsite_attr_except[' + count + '][attr]" id="gsite_attr_except_' + count + '_attr" class="form-control">' +
                    '<span class="input-group-append">' +
                        '<button type="button" data-count="' + count + '" class="btn btn-info except_del">' +
                            '<span class="fas fa-trash-alt"></span>' +
                        '</button>' +
                    '</span>' +
                '</div>' +
            '</div>' +
        '</div>');
    }


    function replaceDel(count, replace) {
        $('#' + replace + '_replace_group_' + count).remove();
    }

    function exceptDel(count) {
        $('#attr_except_group_' + count).remove();
    }

    $(document).ready(function(){
        var obj_validate_form = $('#gsite_form').baigoValidate(opts_validate_form);
        var obj_submit_form   = $('#gsite_form').baigoSubmit(opts_submit_form);
        $('#gsite_form').submit(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });

        $('.attr_often').change(function(){
            var _attr_val   = $(this).val();
            var _attr_type  = $(this).data('type');
            $('#gsite_' + _attr_type + '_attr').val(_attr_val);

        });

        $('.replace_add').click(function(){
            var _type = $(this).data('type');
            replaceAdd(_type);
        });

        $('.replace_box').on('click', '.replace_del', function(){
            var _count = $(this).data('count');
            var _type = $(this).data('type');
            replaceDel(_count, _type);
        });

        $('#attr_except_add').click(function(){
            exceptAdd();
        });

        $('#attr_except').on('click', '.except_del', function(){
            var _count = $(this).data('count');
            exceptDel(_count);
        });

        $('#gsite_preview').html('<div class="embed-responsive embed-responsive-21by9"><iframe class="embed-responsive-item" scrolling="auto" src="<?php echo $route_console; ?>gsite-preview/content/id/<?php echo $gsiteRow['gsite_id']; ?>/"></iframe></div>');

        $('#gsite_source').html('<div class="embed-responsive embed-responsive-21by9"><iframe class="embed-responsive-item" scrolling="auto" src="<?php echo $route_console; ?>gsite-source/content/id/<?php echo $gsiteRow['gsite_id']; ?>/"></iframe></div>');
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);