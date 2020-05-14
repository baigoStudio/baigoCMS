<?php $cfg = array(
    'title'          => $lang->get('Gathering', 'console.common') . ' &raquo; ' . $lang->get('Gathering site', 'console.common'),
    'menu_active'    => 'gather',
    'sub_active'     => 'gsite',
    'help'           => 'step_content#page_content',
    'baigoValidate' => 'true',
    'baigoSubmit'    => 'true',
    'prism'          => 'true',
    'pathInclude'    => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL);
include($cfg['pathInclude'] . 'gsite_head' . GK_EXT_TPL); ?>

    <form name="gsite_form" id="gsite_form" action="<?php echo $route_console; ?>gsite_step/page-content-submit/">
        <input type="hidden" name="__token__" value="<?php echo $token; ?>">
        <input type="hidden" name="gsite_id" id="gsite_id" value="<?php echo $gsiteRow['gsite_id']; ?>">

        <div class="row">
            <div class="col-xl-9">
                <div class="card mb-3">
                    <div class="card-header"><?php echo $lang->get('Paging content settings'); ?></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $lang->get('Selector'); ?> <span class="text-danger">*</span></label>
                            <input type="text" name="gsite_page_content_selector" id="gsite_page_content_selector" value="<?php echo $gsiteRow['gsite_page_content_selector']; ?>" class="form-control">
                            <small class="form-text" id="msg_gsite_page_content_selector"><?php echo $lang->get('Please use the jQuery selector'); ?></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Gathering attribute'); ?></label>
                            <div class="input-group">
                                <input type="text" name="gsite_page_content_attr" id="gsite_page_content_attr" value="<?php echo $gsiteRow['gsite_page_content_attr']; ?>" class="form-control">
                                <select class="custom-select attr_often">
                                    <option value=""><?php echo $lang->get('Common attribute'); ?></option>
                                    <?php foreach ($attrOften as $_key=>$_value) { ?>
                                        <option <?php if ($gsiteRow['gsite_page_content_attr'] == $_key) { ?>selected<?php } ?> value="<?php echo $_key; ?>">
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
                            <small class="form-text" id="msg_gsite_page_content_attr"><?php echo $lang->get('Default is html'); ?></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Filter'); ?></label>
                            <div class="input-group">
                                <input type="text" name="gsite_page_content_filter" id="gsite_page_content_filter" value="<?php echo $gsiteRow['gsite_page_content_filter']; ?>" class="form-control">
                                <span class="input-group-append">
                                    <a href="#help_modal" class="btn btn-warning" data-toggle="modal" data-act="filter">
                                        <span class="fas fa-question-circle"></span>
                                    </a>
                                </span>
                            </div>
                            <small class="form-text" id="msg_gsite_page_content_filter"><?php echo $lang->get('Filter out unwanted elements, and multiple values separated by <kbd>,</kbd>'); ?></small>
                        </div>

                        <label><?php echo $lang->get('Replace'); ?></label>

                        <div id="page_content_replace">
                            <?php $key_replace = 0;
                            foreach ($gsiteRow['gsite_page_content_replace'] as $key_replace=>$value_replace) { ?>
                                <div id="page_content_replace_group_<?php echo $key_replace; ?>" class="form-row" data-count="<?php echo $key_replace; ?>">
                                    <div class="form-group col-lg-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><?php echo $lang->get('Search'); ?></span>
                                            </div>
                                            <input type="text" name="gsite_page_content_replace[<?php echo $key_replace; ?>][search]" id="gsite_page_content_replace_<?php echo $key_replace; ?>_search" value="<?php echo $value_replace['search']; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><?php echo $lang->get('Replace'); ?></span>
                                            </div>
                                            <input type="text" name="gsite_page_content_replace[<?php echo $key_replace; ?>][replace]" id="gsite_page_content_replace_<?php echo $key_replace; ?>_replace" value="<?php echo $value_replace['replace']; ?>" class="form-control">
                                            <span class="input-group-append">
                                                <button type="button" data-count="<?php echo $key_replace; ?>" class="btn btn-info replace_del">
                                                    <span class="fas fa-trash-alt"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="form-group">
                            <button type="button" class="btn btn-info" id="page_content_replace_add">
                                <span class="fas fa-plus"></span>
                            </button>
                        </div>

                        <small class="form-text"><?php echo $lang->get('If "Replace" is empty, system will remove the character, the usage is similar to the search and replace of Word, WPS'); ?></small>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><?php echo $lang->get('Save'); ?></button>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header"><?php echo $lang->get('Preview'); ?></div>
                    <div id="gsite_preview">
                        <div class="loading p-3">
                            <h4 class="text-info">
                                <span class="spinner-grow"></span>
                                Loading...
                            </h4>
                        </div>
                    </div>
                </div>

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
            </div>

            <?php include($cfg['pathInclude'] . 'gsite_side' . GK_EXT_TPL); ?>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'gsite_foot' . GK_EXT_TPL);
include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL); ?>

    <script type="text/javascript">
    var opts_validate_form = {
        rules: {
            gsite_page_content_selector: {
                length: '1,100'
            },
            gsite_page_content_attr: {
                max: 100
            },
            gsite_page_content_filter: {
                max: 100
            }
        },
        attr_names: {
            gsite_page_content_selector: '<?php echo $lang->get('Selector'); ?>',
            gsite_page_content_attr: '<?php echo $lang->get('Gathering attribute'); ?>',
            gsite_page_content_filter: '<?php echo $lang->get('Filter'); ?>'
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
    };

    function replaceAdd() {
        var count = $('#page_content_replace > div:last').data('count');
        if (typeof count == 'undefined' || isNaN(count)) {
            count = 0;
        } else {
            ++count;
        }

        $('#page_content_replace').append('<div id="page_content_replace_group_' + count + '" class="form-row" data-count="' + count + '">' +
            '<div class="form-group col-lg-6">' +
                '<div class="input-group">' +
                    '<div class="input-group-prepend">' +
                        '<span class="input-group-text"><?php echo $lang->get('Search'); ?></span>' +
                    '</div>' +
                    '<input type="text" name="gsite_page_content_replace[' + count + '][search]" id="gsite_page_content_replace_' + count + '" class="form-control">' +
                '</div>' +
            '</div>' +
            '<div class="form-group col-lg-6">' +
                '<div class="input-group">' +
                    '<div class="input-group-prepend">' +
                        '<span class="input-group-text"><?php echo $lang->get('Replace'); ?></span>' +
                    '</div>' +
                    '<input type="text" name="gsite_page_content_replace[' + count + '][replace]" id="gsite_page_content_replace_' + count + '" class="form-control">' +
                    '<span class="input-group-append">' +
                        '<button type="button" data-count="' + count + '" class="btn btn-info replace_del">' +
                            '<span class="fas fa-trash-alt"></span>' +
                        '</button>' +
                    '</span>' +
                '</div>' +
            '</div>' +
        '</div>');
    }

    function replaceDel(count) {
        $('#page_content_replace_group_' + count).remove();
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
            $('#gsite_page_content_attr').val(_attr_val);

        });

        $('#page_content_replace_add').click(function(){
            replaceAdd();
        });

        $('#page_content_replace').on('click', '.replace_del', function(){
            var _count = $(this).data('count');
            replaceDel(_count);
        });

        $('#gsite_preview').html('<div class="embed-responsive embed-responsive-21by9"><iframe class="embed-responsive-item" scrolling="auto" src="<?php echo $route_console; ?>gsite_preview/page-content/id/<?php echo $gsiteRow['gsite_id']; ?>/"></iframe></div>');

        $('#gsite_source').html('<div class="embed-responsive embed-responsive-21by9"><iframe class="embed-responsive-item" scrolling="auto" src="<?php echo $route_console; ?>gsite_source/page-content/id/<?php echo $gsiteRow['gsite_id']; ?>/"></iframe></div>');
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);