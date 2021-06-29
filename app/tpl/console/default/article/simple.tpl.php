    <form name="article_form" id="article_form" action="<?php echo $route_console; ?>article/simple-submit/">
        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
        <input type="hidden" name="article_id" id="article_id" value="<?php echo $articleRow['article_id']; ?>">

        <div class="modal-header">
            <div class="modal-title"><?php echo $lang->get('Article management', 'console.common'), ' &raquo; ', $lang->get('Quick edit'); ?></div>
            <button type="button" class="close" data-dismiss="modal">
                <span>&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <?php echo $lang->get('ID'); ?>: <?php echo $articleRow['article_id']; ?>
            </div>

            <div class="form-group">
                <label><?php echo $lang->get('Title'); ?></label>
                <input type="text" name="article_title" id="article_title" value="<?php echo $articleRow['article_title']; ?>" class="form-control" placeholder="<?php echo $lang->get('Title'); ?>">
                <small class="form-text" id="msg_article_title"></small>
            </div>

            <div class="form-group">
                <label><?php echo $lang->get('Belong to category'); ?> <span class="text-danger">*</span></label>
                <select name="article_cate_id" id="article_cate_id" class="form-control">
                    <option value=""><?php echo $lang->get('Please select'); ?></option>
                    <?php $check_id = $articleRow['article_cate_id'];
                    include($path_tpl . 'include' . DS . 'cate_list_option' . GK_EXT_TPL); ?>
                </select>
                <small class="form-text" id="msg_article_cate_id"></small>
            </div>

            <div class="form-group">
                <label><?php echo $lang->get('Status'); ?> <span class="text-danger">*</span></label>
                <div>
                    <?php foreach ($status as $key=>$value) { ?>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="article_status" id="article_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($articleRow['article_status'] == $value) { ?>checked<?php } ?> class="form-check-input">
                            <label for="article_status_<?php echo $value; ?>" class="form-check-label">
                                <?php echo $lang->get($value); ?>
                            </label>
                        </div>
                    <?php } ?>
                </div>
                <small class="form-text" id="msg_article_status"></small>
            </div>

            <div class="form-group">
                <label><?php echo $lang->get('Position'); ?> <span class="text-danger">*</span></label>
                <div>
                    <?php foreach ($box as $key=>$value) { ?>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="article_box" id="article_box_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($articleRow['article_box'] == $value) { ?>checked<?php } ?> class="form-check-input">
                            <label for="article_box_<?php echo $value; ?>" class="form-check-label">
                                <?php echo $lang->get($value); ?>
                            </label>
                        </div>
                    <?php } ?>
                </div>
                <small class="form-text" id="msg_article_box"></small>
            </div>

            <?php if ($gen_open === true) { ?>
                <div class="form-group">
                    <label><?php echo $lang->get('Status'); ?> <span class="text-danger">*</span></label>
                    <div>
                        <?php foreach ($status_gen as $key=>$value) { ?>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="article_is_gen" id="article_is_gen_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($articleRow['article_is_gen'] == $value) { ?>checked<?php } ?> class="form-check-input">
                                <label for="article_is_gen_<?php echo $value; ?>" class="form-check-label">
                                    <?php echo $lang->get($value); ?>
                                </label>
                            </div>
                        <?php } ?>
                    </div>
                    <small class="form-text" id="msg_article_is_gen"></small>
                </div>
            <?php } ?>

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" <?php if ($articleRow['article_top'] > 0) { ?>checked<?php } ?> id="article_top" name="article_top" value="1" class="custom-control-input">
                    <label for="article_top" class="custom-control-label">
                        <?php echo $lang->get('Sticky'); ?>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label><?php echo $lang->get('Mark'); ?></label>
                <select name="article_mark_id" class="form-control">
                    <option value=""><?php echo $lang->get('None'); ?></option>
                    <?php foreach ($markRows as $key=>$value) { ?>
                        <option <?php if ($value['mark_id'] == $articleRow['article_mark_id']) { ?>selected<?php } ?> value="<?php echo $value['mark_id']; ?>"><?php echo $value['mark_name']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label><?php echo $lang->get('Display time'); ?></label>
                <input type="text" name="article_time_show_format" id="article_time_show_format" value="<?php echo $articleRow['article_time_show_format']['date_time']; ?>" class="form-control input_date">
                <small class="form-text" id="msg_article_time_show_format">
                    <?php $_arr_langReplace = array(
                        'date_time' => date($config['var_extra']['base']['site_date'] . ' ' . $config['var_extra']['base']['site_time_short']),
                    );
                    echo $lang->get('Format: {:date_time}', '', $_arr_langReplace); ?>
                </small>
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch mb-2">
                    <input type="checkbox" <?php if ($articleRow['article_is_time_pub'] > 0) { ?>checked<?php } ?> name="article_is_time_pub" id="article_is_time_pub" value="1" class="custom-control-input">
                    <label for="article_is_time_pub" class="custom-control-label">
                        <?php echo $lang->get('Scheduled publish'); ?>
                    </label>
                </div>
                <div id="time_pub_input" class="collapse <?php if ($articleRow['article_is_time_pub'] > 0) { ?>show<?php } ?>">
                    <input type="text" name="article_time_pub_format" id="article_time_pub_format" value="<?php echo $articleRow['article_time_pub_format']['date_time']; ?>" class="form-control input_date">
                    <small class="form-text" id="msg_article_time_pub_format"></small>
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch mb-2">
                    <input type="checkbox" <?php if ($articleRow['article_is_time_hide'] > 0) { ?>checked<?php } ?> id="article_is_time_hide" name="article_is_time_hide" value="1" class="custom-control-input">
                    <label for="article_is_time_hide" class="custom-control-label">
                        <?php echo $lang->get('Scheduled offline'); ?>
                    </label>
                </div>
                <div id="time_hide_input" class="collapse <?php if ($articleRow['article_is_time_hide'] > 0) { ?>show<?php } ?>">
                    <input type="text" name="article_time_hide_format" id="article_time_hide_format" value="<?php echo $articleRow['article_time_hide_format']['date_time']; ?>" class="form-control input_date">
                    <small class="form-text" id="msg_article_time_hide_format"></small>
                </div>
            </div>

            <div class="bg-validate-box"></div>
        </div>
        <div class="modal-footer<?php if ($gen_open === true) { ?> d-flex justify-content-between<?php } ?>">
            <?php if ($gen_open === true) { ?>
                <a href="#gen_modal" data-url="<?php echo $route_gen; ?>article/single/id/<?php echo $articleRow['article_id']; ?>/view/iframe/" data-toggle="modal" class="btn btn-outline-primary btn-sm">
                    <span class="fas fa-sync-alt"></span>
                    <?php echo $lang->get('Generate'); ?>
                </a>
            <?php } ?>
            <div>
                <button type="submit" class="btn btn-primary btn-sm">
                    <?php echo $lang->get('Save'); ?>
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
                    <?php echo $lang->get('Close', 'console.common'); ?>
                </button>
            </div>
        </div>
    </form>

    <script type="text/javascript">
    var opts_validate_form = {
        rules: {
            article_cate_id: {
                require: true
            },
            article_title: {
                length: '1,300'
            },
            article_status: {
                require: true
            },
            article_box: {
                require: true
            },
            article_time_show_format: {
                format: 'date_time'
            },
            article_time_pub_format: {
                format: 'date_time'
            },
            article_time_hide_format: {
                format: 'date_time'
            }
        },
        attr_names: {
            article_cate_id: '<?php echo $lang->get('Belong to category'); ?>',
            article_title: '<?php echo $lang->get('Title'); ?>',
            article_status: '<?php echo $lang->get('Status'); ?>',
            article_box: '<?php echo $lang->get('Position'); ?>',
            article_time_show_format: '<?php echo $lang->get('Display time'); ?>',
            article_time_pub_format: '<?php echo $lang->get('Scheduled publish'); ?>',
            article_time_hide_format: '<?php echo $lang->get('Scheduled offline'); ?>'
        },
        type_msg: {
            require: '<?php echo $lang->get('{:attr} require'); ?>',
            max: '<?php echo $lang->get('Max size of {:attr} must be {:rule}'); ?>',
            length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>'
        },
        format_msg: {
            date_time: '<?php echo $lang->get('{:attr} not a valid datetime'); ?>'
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

    function timePub(is_checked) {
        if (is_checked) {
            $('#time_pub_input').collapse('show');
        } else {
            $('#time_pub_input').collapse('hide');
        }
    }

    function timeHide(is_checked) {
        if (is_checked) {
            $('#time_hide_input').collapse('show');
        } else {
            $('#time_hide_input').collapse('hide');
        }
    }

    $(document).ready(function(){
        var obj_validate_form   = $('#article_form').baigoValidate(opts_validate_form);
        var obj_submit_form     = $('#article_form').baigoSubmit(opts_submit_form);

        $('#article_form').submit(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });

        $('.input_date').datetimepicker(opts_datetimepicker);

        $('#article_is_time_pub').click(function(){
            var _is_checked = $(this).prop('checked');
            timePub(_is_checked);
        });

        $('#article_is_time_hide').click(function(){
            var _is_checked = $(this).prop('checked');
            timeHide(_is_checked);
        });

        $('#cate_ids_check').click(function(){
            var _is_checked = $(this).prop('checked');
            cateIdsProcess(_is_checked);
        });
    });
    </script>
