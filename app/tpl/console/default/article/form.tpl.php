<?php
function custom_list_form($arr_customRows, $article_customs = array(), $lang = '') {
    if (!empty($arr_customRows)) {
        foreach ($arr_customRows as $key=>$value) {
            if (isset($value['custom_childs']) && !empty($value['custom_childs'])) { ?>
                <div class="custom_group custom_group_<?php echo $value['custom_cate_id']; ?>">
                    <h5>
                        <span class="badge badge-secondary"><?php echo $value['custom_name']; ?></span>
                    </h5>
                </div>
                <?php custom_list_form($value['custom_childs'], $article_customs, $lang);
            } else { ?>
                <div class="custom_group custom_group_<?php echo $value['custom_cate_id']; ?> form-group">
                    <label><?php echo $value['custom_name']; ?></label>

                    <?php switch ($value['custom_type']) {
                        case 'radio':
                            foreach ($value['custom_opt'][$value['custom_type']] as $key_option=>$value_option) { ?>
                                <div class="form-check">
                                    <label for="article_customs_<?php echo $value['custom_id']; ?>_<?php echo $key_option ; ?>" class="form-check-label">
                                        <input type="radio" id="article_customs_<?php echo $value['custom_id']; ?>_<?php echo $key_option ; ?>" name="article_customs[<?php echo $value['custom_id']; ?>]" value="<?php echo $value_option ; ?>" data-validate="article_customs_<?php echo $value['custom_id']; ?>" <?php if (isset($article_customs['custom_' . $value['custom_id']]) && $article_customs['custom_' . $value['custom_id']] == $value_option) { ?> checked<?php } ?> class="form-check-input">
                                        <?php echo $value_option ; ?>
                                    </label>
                                </div>
                            <?php }
                        break;

                        case 'select': ?>
                            <select id="article_customs_<?php echo $value['custom_id']; ?>" name="article_customs[<?php echo $value['custom_id']; ?>]" class="form-control">
                                <option value=""><?php echo $lang->get('Please select'); ?></option>
                                <?php foreach ($value['custom_opt'][$value['custom_type']] as $key_option=>$value_option) { ?>
                                    <option
                                    <?php if (isset($article_customs['custom_' . $value['custom_id']]) && $article_customs['custom_' . $value['custom_id']] == $value_option) { ?>
                                         selected
                                    <?php } ?>
                                     value="<?php echo $value_option ; ?>">
                                        <?php echo $value_option ; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        <?php break;

                        case 'textarea': ?>
                            <textarea id="article_customs_<?php echo $value['custom_id']; ?>" name="article_customs[<?php echo $value['custom_id']; ?>]" class="form-control bg-textarea-md">
                                <?php if (isset($article_customs['custom_' . $value['custom_id']])) {
                                    echo $article_customs['custom_' . $value['custom_id']];
                                } ?>
                            </textarea>
                        <?php break;

                        default: ?>
                            <input type="text" id="article_customs_<?php echo $value['custom_id']; ?>" name="article_customs[<?php echo $value['custom_id']; ?>]" value="<?php if (isset($article_customs['custom_' . $value['custom_id']])) { echo $article_customs['custom_' . $value['custom_id']];} ?>" class="form-control">
                        <?php break;
                    } ?>

                    <small class="form-text" id="msg_article_custom_<?php echo $value['custom_id']; ?>"></small>
                </div>
            <?php }
        }
    }
}

if ($articleRow['article_id'] > 0) {
    $title_sub    = $lang->get('Edit');
    $str_sub      = 'index';
} else {
    $title_sub    = $lang->get('Add');
    $str_sub      = 'form';
}

$cfg = array(
    'title'             => $lang->get('Article management', 'console.common') . ' &raquo; ' . $title_sub,
    'menu_active'       => 'article',
    'sub_active'        => $str_sub,
    'baigoValidate'     => 'true',
    'baigoSubmit'       => 'true',
    'baigoTag'          => 'true',
    'datetimepicker'    => 'true',
    'tinymce'           => 'true',
    'upload'            => 'true',
    'tooltip'           => 'true',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>article/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <form name="article_form" id="article_form" action="<?php echo $route_console; ?>article/submit/">
        <input type="hidden" name="__token__" value="<?php echo $token; ?>">
        <input type="hidden" name="article_id" id="article_id" value="<?php echo $articleRow['article_id']; ?>">

        <div class="row">
            <div class="col-xl-9">
                <div class="form-group">
                    <input type="text" name="article_title" id="article_title" value="<?php echo $articleRow['article_title']; ?>" class="form-control form-control-lg" placeholder="<?php echo $lang->get('Title'); ?>">
                    <small class="form-text" id="msg_article_title"></small>
                </div>

                <div class="form-group">
                    <label><?php echo $lang->get('Content'); ?></label>
                    <div class="mb-2">
                        <div class="btn-group btn-group-sm">
                            <a class="btn btn-outline-success" data-toggle="modal" href="#article_modal" data-id="<?php echo $articleRow['article_id']; ?>" data-act="attach">
                                <span class="fas fa-photo-video"></span>
                                <?php echo $lang->get('Add media'); ?>
                            </a>
                            <a class="btn btn-outline-secondary" data-toggle="modal" href="#article_modal" data-act="album">
                                <span class="fas fa-images"></span>
                                <?php echo $lang->get('Add album'); ?>
                            </a>
                            <?php if ($articleRow['article_id'] > 0) { ?>
                                <a href="<?php echo $route_console; ?>article/attach/id/<?php echo $articleRow['article_id']; ?>/" class="btn btn-outline-secondary">
                                    <?php echo $lang->get('Cover management'); ?>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                    <textarea name="article_content" id="article_content" class="form-control tinymce"><?php echo $articleRow['article_content']; ?></textarea>
                </div>

                <div class="bg-validate-box"></div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <?php echo $lang->get('Save'); ?>
                    </button>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="card bg-light">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs_base"><?php echo $lang->get('Base'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs_more"><?php echo $lang->get('More'); ?></a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs_base">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item">
                                    <?php if ($articleRow['article_id'] > 0) { ?>
                                        <div class="form-group">
                                            <?php echo $lang->get('ID'); ?>: <?php echo $articleRow['article_id']; ?>
                                        </div>
                                    <?php } ?>

                                    <div class="form-group">
                                        <label><?php echo $lang->get('Belong to category'); ?> <span class="text-danger">*</span></label>
                                        <select name="article_cate_id" id="article_cate_id" class="form-control">
                                            <option value=""><?php echo $lang->get('Please select'); ?></option>
                                            <?php $check_id = $articleRow['article_cate_id'];
                                            include($cfg['pathInclude'] . 'cate_list_option' . GK_EXT_TPL); ?>
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

                                    <div class="form-group">
                                        <label><?php echo $lang->get('Mark'); ?></label>
                                        <select name="article_mark_id" class="form-control">
                                            <option value=""><?php echo $lang->get('None'); ?></option>
                                            <?php foreach ($markRows as $key=>$value) { ?>
                                                <option <?php if ($value['mark_id'] == $articleRow['article_mark_id']) { ?>selected<?php } ?> value="<?php echo $value['mark_id']; ?>"><?php echo $value['mark_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <a class="list-group-item list-group-item-action bg-light d-flex justify-content-between align-items-center" data-toggle="collapse" href="#bg-form-time">
                                    <span>
                                        <?php echo $lang->get('Time'); ?>
                                    </span>
                                    <small class="fas fa-chevron-down" id="bg-caret-time"></small>
                                </a>

                                <div id="bg-form-time" data-key="time" class="list-group-item collapse">
                                    <div class="form-group">
                                        <label><?php echo $lang->get('Display time'); ?></label>
                                        <input type="text" name="article_time_show_format" id="article_time_show_format" value="<?php echo $articleRow['article_time_show_format']['date_time']; ?>" class="form-control input_date">
                                        <small class="form-text" id="msg_article_time_show_format"></small>
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

                                    <small class="form-text">
                                        <?php $_arr_langReplace = array(
                                            'date_time' => date($config['var_extra']['base']['site_date'] . ' ' . $config['var_extra']['base']['site_time_short']),
                                        );
                                        echo $lang->get('Format: {:date_time}', '', $_arr_langReplace); ?>
                                    </small>
                                </div>

                                <a class="list-group-item list-group-item-action bg-light d-flex justify-content-between align-items-center" data-toggle="collapse" href="#bg-form-tag">
                                    <span>
                                        <?php echo $lang->get('Tag'); ?>
                                    </span>
                                    <small class="fas fa-chevron-down" id="bg-caret-tag"></small>
                                </a>

                                <div id="bg-form-tag" data-key="tag" class="list-group-item collapse">
                                    <input type="text" name="article_tag" id="article_tag" class="form-control" placeholder="<?php echo $lang->get('Tags'); ?>">
                                    <small class="form-text" id="msg_article_tag">
                                        <?php $_arr_langReplace = array(
                                            'tag_count'   => $config['var_extra']['visit']['count_tag'],
                                        );
                                        echo $lang->get('Up to {:tag_count} tags', '', $_arr_langReplace); ?>
                                    </small>
                                </div>

                                <a class="list-group-item list-group-item-action bg-light d-flex justify-content-between align-items-center" data-toggle="collapse" href="#bg-form-excerpt">
                                    <span>
                                        <?php echo $lang->get('Excerpt'); ?>
                                    </span>
                                    <small class="fas fa-chevron-down" id="bg-caret-excerpt"></small>
                                </a>

                                <div id="bg-form-excerpt" data-key="excerpt" class="list-group-item collapse">
                                    <div class="form-group">
                                        <select class="form-control" name="article_excerpt_type" id="article_excerpt_type">
                                            <?php foreach ($config['console']['excerpt'] as $key=>$value) { ?>
                                                <option <?php if ($articleRow['article_excerpt_type'] == $key) { ?>selected<?php } ?> value="<?php echo $key; ?>">
                                                    <?php echo $lang->get($value); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div id="group_article_excerpt" class="collapse <?php if ($articleRow['article_excerpt_type'] == 'manual') { ?>show<?php } ?>">
                                        <div class="form-group">
                                            <textarea name="article_excerpt" id="article_excerpt" class="form-control bg-textarea-sm"><?php echo $articleRow['article_excerpt']; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <a class="list-group-item list-group-item-action d-flex bg-light justify-content-between align-items-center" data-toggle="collapse" href="#bg-form-source">
                                    <span>
                                        <?php echo $lang->get('Source'); ?>
                                    </span>
                                    <small class="fas fa-chevron-down" id="bg-caret-source"></small>
                                </a>

                                <div id="bg-form-source" data-key="source" class="list-group-item collapse">
                                    <div class="form-group">
                                        <label><?php echo $lang->get('Source'); ?></label>
                                        <input type="text" name="article_source" id="article_source" value="<?php echo $articleRow['article_source']; ?>" class="form-control">
                                        <small class="form-text" id="msg_article_source"></small>
                                    </div>

                                    <div class="form-group">
                                        <label><?php echo $lang->get('Author'); ?></label>
                                        <input type="text" name="article_author" id="article_author" value="<?php echo $articleRow['article_author']; ?>" class="form-control">
                                        <small class="form-text" id="msg_article_author"></small>
                                    </div>

                                    <div class="form-group">
                                        <label><?php echo $lang->get('Source URL'); ?></label>
                                        <textarea type="text" name="article_source_url" id="article_source_url" class="form-control bg-textarea-sm"><?php echo $articleRow['article_source_url']; ?></textarea>
                                        <small class="form-text" id="msg_article_source"></small>
                                    </div>

                                    <div class="form-group">
                                        <label><?php echo $lang->get('Common source'); ?></label>
                                        <select id="article_source_often" class="form-control">
                                            <option value=""><?php echo $lang->get('Please select'); ?></option>
                                            <?php foreach ($sourceRows as $key=>$value) { ?>
                                                <option value="<?php echo $value['source_id']; ?>"><?php echo $value['source_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="tabs_more">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" <?php if ($articleRow['cate_ids_check'] > 0) { ?>checked<?php } ?> id="cate_ids_check" name="cate_ids_check" value="1" class="custom-control-input">
                                        <label for="cate_ids_check" class="custom-control-label">
                                            <?php echo $lang->get('Attached to categories'); ?>
                                        </label>
                                    </div>

                                    <div id="group_cate_ids" class="collapse <?php if ($articleRow['cate_ids_check'] > 0) { ?>show<?php } ?>">
                                        <table class="bg-table">
                                            <tbody>
                                                <?php $cate_ids = $articleRow['article_cate_ids'];
                                                $form_name = 'article';
                                                include($cfg['pathInclude'] . 'cate_list_checkbox' . GK_EXT_TPL); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <a class="list-group-item list-group-item-action bg-light d-flex justify-content-between align-items-center" data-toggle="collapse" href="#bg-form-spec">
                                    <span>
                                        <?php echo $lang->get('Special topic'); ?>
                                    </span>
                                    <small class="fas fa-chevron-down" id="bg-caret-spec"></small>
                                </a>

                                <div id="bg-form-spec" data-key="spec" class="list-group-item collapse">
                                    <div id="spec_list">
                                        <?php foreach ($specRows as $key=>$value) { ?>
                                            <div class="input-group mb-2" id="spec_item_<?php echo $value['spec_id']; ?>">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text border-success">
                                                        <input type="hidden" name="article_spec_ids[]" value="<?php echo $value['spec_id']; ?>">
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

                                <a class="list-group-item list-group-item-action bg-light d-flex justify-content-between align-items-center" data-toggle="collapse" href="#bg-form-custom">
                                    <span>
                                        <?php echo $lang->get('Custom fields'); ?>
                                    </span>
                                    <small class="fas fa-chevron-down" id="bg-caret-custom"></small>
                                </a>

                                <div id="bg-form-custom" data-key="custom" class="list-group-item collapse">
                                    <div id="custom_list">
                                        <?php custom_list_form($customRows, $articleRow['article_customs'], $lang); ?>
                                    </div>
                                </div>

                                <a class="list-group-item list-group-item-action d-flex bg-light justify-content-between align-items-center" data-toggle="collapse" href="#bg-form-link">
                                    <span>
                                        <?php echo $lang->get('Jump to'); ?>
                                    </span>
                                    <small class="fas fa-chevron-down" id="bg-caret-link"></small>
                                </a>

                                <div id="bg-form-link" data-key="link" class="list-group-item collapse <?php if (!empty($articleRow['article_link'])) { ?>show list-group-item-warning<?php } ?>">
                                    <textarea type="text" name="article_link" id="article_link" class="form-control bg-textarea-sm"><?php echo $articleRow['article_link']; ?></textarea>
                                    <small class="form-text" id="msg_article_link"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $lang->get('Save'); ?>
                        </button>
                    </div>
                </div>

                <?php if (!empty($articleRow['article_link'])) { ?>
                    <div class="alert alert-warning mt-3">
                        <span class="fas fa-exclamation-triangle">
                        <?php echo $lang->get('Warning! This article is a hyperlink'); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </form>

    <div class="modal fade" id="article_modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content"></div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL); ?>

    <script type="text/javascript">
    var sourceJson = <?php echo $sourceJson; ?>;

    var opts_validate_form = {
        rules: {
            article_cate_id: {
                require: true
            },
            article_title: {
                length: '1,300'
            },
            article_excerpt: {
                max: 900
            },
            article_status: {
                require: true
            },
            article_box: {
                require: true
            },
            article_link: {
                max: 900
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
            article_excerpt: '<?php echo $lang->get('Excerpt'); ?>',
            article_status: '<?php echo $lang->get('Status'); ?>',
            article_box: '<?php echo $lang->get('Position'); ?>',
            article_link: '<?php echo $lang->get('Jump to'); ?>',
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

    function customProcess(cate_id) {
        $('.custom_group').hide();
        $('.custom_group_0').show();
        $('.custom_group_' + cate_id).show();
    }

    function excerptProcess(excerpt_type) {
        if (excerpt_type == 'manual') {
            $('#group_article_excerpt').collapse('show');
        } else {
            $('#group_article_excerpt').collapse('hide');
        }
    }

    function cateIdsProcess(is_checked) {
        if (is_checked) {
            $('#group_cate_ids').collapse('show');
        } else {
            $('#group_cate_ids').collapse('hide');
        }
    }

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

    function specAdd(spec_id, spec_name) {
        if ($('#spec_item_' + spec_id).length < 1) {
            var _spec_list_html = '<div class="input-group mb-2" id="spec_item_' + spec_id + '">' +
                '<div class="input-group-prepend">' +
                    '<div class="input-group-text border-success">' +
                        '<input type="hidden" name="article_spec_ids[]" value="' + spec_id + '">' +
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

    $(document).ready(function(){
        $('#article_excerpt_type').change(function(){
            var _excerpt_type = $(this).val();
            excerptProcess(_excerpt_type);
        });

        customProcess('<?php echo $articleRow['article_cate_id']; ?>');
        $('#article_cate_id').change(function(){
            var _cate_id = $(this).val();
            customProcess(_cate_id);
        });

        $('#article_modal').on('shown.bs.modal',function(event) {
    		var _obj_button   = $(event.relatedTarget);
    		var _act          = _obj_button.data('act');

    		switch (_act) {
        		case 'album':
            		var _url  = '<?php echo $route_console; ?>album/choose/view/modal/';
        		break;

        		default:
            		var _id   = _obj_button.data('id');
            		var _url  = '<?php echo $route_console; ?>attach/choose/article/' + _id + '/view/modal/';
        		break;
    		}

            $('#article_modal .modal-content').load(_url);
    	}).on('hidden.bs.modal', function(){
        	$('#article_modal .modal-content').empty();
    	});

        var obj_validate_form   = $('#article_form').baigoValidate(opts_validate_form);
        var obj_submit_form     = $('#article_form').baigoSubmit(opts_submit_form);

        $('#article_form').submit(function(){
            if (obj_validate_form.verify()) {
                tinyMCE.triggerSave();
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

        $('#article_source_often').change(function(){
            var _source_id = $(this).val();
            $('#article_source').val(sourceJson[_source_id].source_name);
            $('#article_source_url').val(sourceJson[_source_id].source_url);
            $('#article_author').val(sourceJson[_source_id].source_author);
        });

        var _obj_tag = $('#article_tag').baigoTag({
            maxTags: <?php echo $config['var_extra']['visit']['count_tag']; ?>,
            remote: {
                url: '<?php echo $route_console; ?>tag/typeahead/key/%KEY/',
                wildcard: '%KEY'
            }
        });

        _obj_tag.add(<?php echo $articleRow['article_tags_json']; ?>);

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
    });
    </script>
<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);