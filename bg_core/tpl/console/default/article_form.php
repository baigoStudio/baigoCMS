<?php function custom_list_form($arr_customRows, $article_customs = array(), $lang = array()) {
    if (!fn_isEmpty($arr_customRows)) {
        foreach ($arr_customRows as $key=>$value) {
            if (isset($value['custom_childs']) && !fn_isEmpty($value['custom_childs'])) { ?>
                <div class="custom_group custom_group_<?php echo $value['custom_cate_id'] ; ?> col-md-12">
                    <h5>
                        <span class="badge badge-secondary"><?php echo $value['custom_name'] ; ?></span>
                    </h5>
                </div>
                <?php custom_list_form($value['custom_childs'], $article_customs, $lang);

            } else { ?>
                <div class="custom_group custom_group_<?php echo $value['custom_cate_id'] ; ?> form-group col-md-6">
                    <label><?php echo $value['custom_name'] ; ?></label>

                    <?php switch ($value['custom_type']) {
                        case 'radio':
                            foreach ($value['custom_opt'] as $key_option=>$value_option) { ?>
                                <div class="form-check">
                                    <label for="article_customs_<?php echo $value['custom_id'] ; ?>_<?php echo $key_option ; ?>" class="form-check-label">
                                        <input type="radio" id="article_customs_<?php echo $value['custom_id'] ; ?>_<?php echo $key_option ; ?>" name="article_customs[<?php echo $value['custom_id'] ; ?>]" value="<?php echo $value_option ; ?>" data-validate="article_customs_<?php echo $value['custom_id'] ; ?>" <?php if (isset($article_customs['custom_' . $value['custom_id']]) && $article_customs['custom_' . $value['custom_id']] == $value_option) { ?> checked<?php } ?> class="form-check-input">
                                        <?php echo $value_option ; ?>
                                    </label>
                                </div>
                            <?php }
                        break;

                        case 'select': ?>
                            <select id="article_customs_<?php echo $value['custom_id'] ; ?>" name="article_customs[<?php echo $value['custom_id'] ; ?>]" data-validate class="form-control">
                                <option value=""><?php echo $lang['option']['pleaseSelect']; ?></option>
                                <?php foreach ($value['custom_opt'] as $key_option=>$value_option) { ?>
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
                            <textarea id="article_customs_<?php echo $value['custom_id'] ; ?>" name="article_customs[<?php echo $value['custom_id'] ; ?>]" data-validate class="form-control bg-textarea-md">
                                <?php if (isset($article_customs['custom_' . $value['custom_id']])) {
                                    echo $article_customs['custom_' . $value['custom_id']];
                                } ?>
                            </textarea>
                        <?php break;

                        default: ?>
                            <input type="text" id="article_customs_<?php echo $value['custom_id'] ; ?>" name="article_customs[<?php echo $value['custom_id'] ; ?>]" value="<?php if (isset($article_customs['custom_' . $value['custom_id']])) { echo $article_customs['custom_' . $value['custom_id']];} ?>" data-validate class="form-control">
                        <?php break;
                    } ?>

                    <small class="form-text" id="msg_article_custom_<?php echo $value['custom_id'] ; ?>"></small>
                </div>
            <?php }
        }
    }
}


function custom_validataJson($arr_customRows, $rcode = array()) {
    foreach ($arr_customRows as $key=>$value) {
        if (isset($value['custom_childs']) && !fn_isEmpty($value['custom_childs'])) {
            custom_validataJson($value['custom_childs'], $rcode);
        } else { ?>
            article_customs_<?php echo $value['custom_id']; ?>: {
                len: {
                    min: <?php echo $value['custom_require']; ?>,
                    max: 300
                },
                validate: {
                    type: "<?php echo $value['custom_type']; ?>",
                    <?php if ($value['custom_type'] != "radio" && $value['custom_type'] != "select") { ?>
                        format: "<?php echo $value['custom_format']; ?>"
                    <?php } ?>
                },
                msg: {
                    selector: "#msg_article_custom_<?php echo $value['custom_id']; ?>",
                    <?php if ($value['custom_type'] != "radio" && $value['custom_type'] != "select") { ?>
                        too_short: "<?php echo $rcode['x120216'] . $value['custom_name']; ?>"
                    <?php } else { ?>
                        too_few: "<?php echo $rcode['x120218'] . $value['custom_name']; ?>"
                    <?php }
                    if ($value['custom_type'] != "radio" && $value['custom_type'] != "select") { ?>
                        , too_long: "<?php echo $value['custom_name'] . $rcode['x120217']; ?>"
                    <?php } ?>

                }
            },
        <?php }
    }
}


if ($this->tplData['articleRow']['article_id'] < 1) {
    if ($this->tplData['gather_id'] > 0) {
        $title_sub  = $this->lang['mod']['page']['editGather'];
    } else {
        $title_sub  = $this->lang['mod']['page']['add'];
    }
    $sub_active = 'form';
} else {
    $title_sub  = $this->lang['mod']['page']['edit'];
    $sub_active = 'list';
}

$cfg = array(
    'title'          => $this->lang['consoleMod']['article']['main']['title'] . ' &raquo; ' . $title_sub,
    'menu_active'    => 'article',
    'sub_active'     => $sub_active,
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'tinymce'        => 'true',
    'datepicker'     => 'true',
    'tagmanager'     => 'true',
    'upload'         => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . 'index.php?m=article',
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=article&a=list" class="nav-link">
                <span class="oi oi-chevron-left"></span>
                <?php echo $this->lang['common']['href']['back']; ?>
            </a>
        </li>
        <li>
            <a href="<?php echo BG_URL_HELP; ?>index.php?m=console&a=article#form" class="nav-link" target="_blank">
                <span class="badge badge-pill badge-primary">
                    <span class="oi oi-question-mark"></span>
                </span>
                <?php echo $this->lang['mod']['href']['help']; ?>
            </a>
        </li>
    </ul>

    <form name="article_form" id="article_form">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="a" value="submit">
        <input type="hidden" name="article_id" value="<?php echo $this->tplData['articleRow']['article_id']; ?>">
        <input type="hidden" name="gather_id" value="<?php echo $this->tplData['gather_id']; ?>">

        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['title']; ?> <span class="text-danger">*</span></label>
                            <input type="text" name="article_title" id="article_title" value="<?php echo $this->tplData['articleRow']['article_title']; ?>" data-validate class="form-control">
                            <small class="form-text" id="msg_article_title"></small>
                        </div>

                        <div class="form-group">
                            <div class="btn-group">
                                <a href="#article_modal" class="btn btn-success" data-toggle="modal" data-act="attach" data-id="<?php echo $this->tplData['articleRow']['article_id']; ?>">
                                    <span class="oi oi-image"></span>
                                    <?php echo $this->lang['mod']['href']['uploadList']; ?>
                                </a>
                                <?php if ($this->tplData['articleRow']['article_id'] > 0) { ?>
                                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=attach&a=article&article_id=<?php echo $this->tplData['articleRow']['article_id']; ?>" class="btn btn-outline-secondary">
                                        <?php echo $this->lang['mod']['href']['attachArticle']; ?>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['content']; ?></label>
                            <textarea name="article_content" id="article_content" class="tinymce bg-textarea-lg"><?php echo $this->tplData['articleRow']['article_content']; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['excerptType']; ?></label>
                            <div>
                                <?php foreach ($this->opt['base']['list']['BG_SITE_EXCERPT_TYPE']['option'] as $key=>$value) { ?>
                                    <div class="form-check form-check-inline">
                                        <label for="article_excerpt_type_<?php echo $key; ?>" class="form-check-label">
                                            <input type="radio" name="article_excerpt_type" id="article_excerpt_type_<?php echo $key; ?>" <?php if ($this->tplData['articleRow']['article_excerpt_type'] == $key) { ?>checked<?php } ?> value="<?php echo $key; ?>" class="article_excerpt_type" class="form-check-input">
                                            <?php if (isset($this->lang['opt']['base']['list']['BG_SITE_EXCERPT_TYPE']['option'][$key])) {
                                                echo $this->lang['opt']['base']['list']['BG_SITE_EXCERPT_TYPE']['option'][$key];
                                            } else {
                                                echo $value;
                                            } ?>
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div id="group_article_excerpt">
                            <label><?php echo $this->lang['mod']['label']['excerpt']; ?></label>
                            <div class="form-group">
                                <textarea name="article_excerpt" id="article_excerpt" class="tinymce bg-textarea-md"><?php echo $this->tplData['articleRow']['article_excerpt']; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['tag']; ?></label>
                            <div class="tm-input-group form-inline">
                                <input type="text" name="article_tag" id="article_tag" data-validate class="form-control tm-input tm-input-success">
                                <button type="button" class="btn btn-info tm-btn" id="tag_add"><span class="oi oi-plus"></span></button>
                            </div>
                            <small class="form-text" id="msg_article_tag"></small>
                        </div>

                        <div class="form-row">
                            <div class="col-md-8">
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label><?php echo $this->lang['mod']['label']['source']; ?></label>
                                        <input type="text" name="article_source" id="article_source" data-validate value="<?php echo $this->tplData['articleRow']['article_source']; ?>" class="form-control">
                                        <small class="form-text" id="msg_article_source"></small>
                                    </div>
                                    <div class="form-group col">
                                        <label><?php echo $this->lang['mod']['label']['author']; ?></label>
                                        <input type="text" name="article_author" id="article_author" data-validate value="<?php echo $this->tplData['articleRow']['article_author']; ?>" class="form-control">
                                        <small class="form-text" id="msg_article_author"></small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $this->lang['mod']['label']['sourceUrl']; ?></label>
                                    <input type="text" name="article_source_url" id="article_source_url" data-validate value="<?php echo $this->tplData['articleRow']['article_source_url']; ?>" class="form-control">
                                    <small class="form-text" id="msg_article_source"></small>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label><?php echo $this->lang['mod']['label']['sourceOften']; ?></label>
                                <select id="article_source_often" class="form-control">
                                    <option value=""><?php echo $this->lang['mod']['option']['pleaseSelect']; ?></option>
                                    <?php foreach ($this->tplData['sourceRows'] as $key=>$value) { ?>
                                        <option value="<?php echo $value['source_id']; ?>"><?php echo $value['source_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div <?php if (!fn_isEmpty($this->tplData['articleRow']['article_link'])) { ?>class="text-warning"<?php } ?>>
                                <label><?php echo $this->lang['mod']['label']['link']; ?></label>
                                <input type="text" name="article_link" id="article_link" value="<?php echo $this->tplData['articleRow']['article_link']; ?>" data-validate class="form-control">
                                <small class="form-text" id="msg_article_link"></small>
                                <small class="form-text"><?php echo $this->lang['mod']['label']['linkNote']; ?></small>
                            </div>
                        </div>

                        <div class="form-row">
                            <?php if (isset($this->tplData['articleRow']['article_customs'])) {
                                custom_list_form($this->tplData['customRows'], $this->tplData['articleRow']['article_customs'], $this->lang['mod']);
                            } ?>
                        </div>

                        <div class="bg-submit-box"></div>
                        <div class="bg-validator-box mt-3"></div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['save']; ?></button>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body">
                        <?php if ($this->tplData['articleRow']['article_id'] > 0) { ?>
                            <div class="form-group">
                                <label><?php echo $this->lang['mod']['label']['id']; ?></label>
                                <div class="form-text"><?php echo $this->tplData['articleRow']['article_id']; ?></div>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['belongCate']; ?> <span class="text-danger">*</span></label>
                            <select name="article_cate_id" id="article_cate_id" data-validate class="form-control">
                                <option value=""><?php echo $this->lang['mod']['option']['pleaseSelect']; ?></option>
                                <?php cate_list_opt($this->tplData['cateRows'], $this->tplData['articleRow']['article_cate_id'], true); ?>
                            </select>
                            <small class="form-text" id="msg_article_cate_id"></small>
                        </div>

                        <div class="form-check">
                            <label for="cate_ids_checkbox" class="form-check-label">
                                <input type="checkbox" <?php if (!fn_isEmpty($this->tplData['articleRow']['cate_ids'])) { ?>checked<?php } ?> id="cate_ids_checkbox" name="cate_ids_checkbox" value="1" class="form-check-input">
                                <?php echo $this->lang['mod']['label']['attachCate']; ?>
                            </label>
                        </div>

                        <div class="form-group bg-overflow-scroll">
                            <div id="cate_ids_input">
                                <table class="bg-table-empty">
                                    <tbody>
                                        <?php cate_list_checkbox($this->tplData['cateRows'], $this->tplData['articleRow']['cate_ids'], "article"); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['status']; ?> <span class="text-danger">*</span></label>
                            <?php foreach ($this->tplData['status'] as $key=>$value) { ?>
                                <div class="form-check">
                                    <label for="article_status_<?php echo $value; ?>" class="form-check-label">
                                        <input type="radio" name="article_status" id="article_status_<?php echo $value; ?>" <?php if ($this->tplData['articleRow']['article_status'] == $value) { ?>checked<?php } ?> value="<?php echo $value; ?>" data-validate="article_status" class="form-check-input">
                                        <?php if (isset($this->lang['mod']['status'][$value])) {
                                            echo $this->lang['mod']['status'][$value];
                                        } else {
                                            echo $value;
                                        } ?>
                                    </label>
                                </div>
                            <?php } ?>
                            <small class="form-text" id="msg_article_status"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['box']; ?> <span class="text-danger">*</span></label>
                            <?php foreach ($this->tplData['boxs'] as $key=>$value) { ?>
                                <div class="form-check">
                                    <label for="article_box_<?php echo $value; ?>" class="form-check-label">
                                        <input type="radio" name="article_box" id="article_box_<?php echo $value; ?>" <?php if ($this->tplData['articleRow']['article_box'] == $value) { ?>checked<?php } ?> value="<?php echo $value; ?>" data-validate="article_box" class="form-check-input">
                                        <?php echo $this->lang['mod']['box'][$value]; ?>
                                    </label>
                                </div>
                            <?php } ?>
                            <small class="form-text" id="msg_article_box"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['mark']; ?></label>
                            <select name="article_mark_id" class="form-control">
                                <option value=""><?php echo $this->lang['mod']['option']['noMark']; ?></option>
                                <?php foreach ($this->tplData['markRows'] as $key=>$value) { ?>
                                    <option <?php if ($value['mark_id'] == $this->tplData['articleRow']['article_mark_id']) { ?>selected<?php } ?> value="<?php echo $value['mark_id']; ?>"><?php echo $value['mark_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['timeShow']; ?></label>
                            <input type="text" name="article_time_show" id="article_time_show" value="<?php echo date("Y-m-d H:i", $this->tplData['articleRow']['article_time_show']); ?>" data-validate class="form-control input_date">
                            <small class="form-text"><?php echo $this->lang['mod']['label']['timeNote']; ?></small>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <label for="article_is_time_pub" class="form-check-label">
                                    <input type="checkbox" <?php if ($this->tplData['articleRow']['article_is_time_pub'] > 0) { ?>checked<?php } ?> name="article_is_time_pub" id="article_is_time_pub" value="1" class="form-check-input">
                                    <?php echo $this->lang['mod']['label']['timePub']; ?>
                                </label>
                            </div>
                        </div>

                        <div id="time_pub_input">
                            <div class="form-group">
                                <input type="text" name="article_time_pub" id="article_time_pub" value="<?php echo date("Y-m-d H:i", $this->tplData['articleRow']['article_time_pub']); ?>" data-validate class="form-control input_date">
                                <small class="form-text" id="msg_article_time_pub"></small>
                                <small class="form-text"><?php echo $this->lang['mod']['label']['timeNote']; ?></small>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <label for="article_is_time_hide" class="form-check-label">
                                    <input type="checkbox" <?php if ($this->tplData['articleRow']['article_is_time_hide'] > 0) { ?>checked<?php } ?> id="article_is_time_hide" name="article_is_time_hide" value="1" class="form-check-input">
                                    <?php echo $this->lang['mod']['label']['timeHide']; ?>
                                </label>
                            </div>
                        </div>

                        <div id="time_hide_input">
                            <div class="form-group">
                                <input type="text" name="article_time_hide" id="article_time_hide" value="<?php echo date("Y-m-d H:i", $this->tplData['articleRow']['article_time_hide']); ?>" data-validate class="form-control input_date">
                                <small class="form-text" id="msg_article_time_hide"></small>
                                <small class="form-text"><?php echo $this->lang['mod']['label']['timeNote']; ?></small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['common']['label']['spec']; ?></label>
                            <div class="input-group">
                                <input type="text" id="spec_key" name="spec_key" placeholder="<?php echo $this->lang['mod']['label']['key']; ?>" class="form-control">
                                <span class="input-group-append">
                                    <button type="button" data-target="#article_modal" class="btn btn-info" data-toggle="modal" data-act="spec">
                                        <span class="oi oi-magnifying-glass"></span>
                                    </button>
                                </span>
                            </div>
                            <div id="spec_check_list">
                                <?php foreach ($this->tplData['specRows'] as $key=>$value) { ?>
                                    <div class="form-check" id="spec_checkbox_<?php echo $value['spec_id']; ?>">
                                        <label for="article_spec_ids_<?php echo $value['spec_id']; ?>" class="form-check-label">
                                            <input type="checkbox" id="article_spec_ids_<?php echo $value['spec_id']; ?>" checked name="article_spec_ids[]" value="<?php echo $value['spec_id']; ?>" class="form-check-input">
                                            <?php echo $value['spec_name']; ?>
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="article_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var _sourceJson = <?php echo $this->tplData['sourceJson']; ?>;

    var opts_validator_form = {
        <?php custom_validataJson($this->tplData['customRows'], $this->lang['rcode']); ?>
        article_title: {
            len: { min: 1, max: 300 },
            validate: { type: "str", format: "text" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x120201']; ?>", too_long: "<?php echo $this->lang['rcode']['x120202']; ?>" }
        },
        article_link: {
            len: { min: 0, max: 900 },
            validate: { type: "str", format: "url" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x120204']; ?>", format_err: "<?php echo $this->lang['rcode']['x120205']; ?>" }
        },
        article_excerpt: {
            len: { min: 0, max: 900 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x120206']; ?>" }
        },
        article_tag: {
            len: { min: 0, max: 0 },
            validate: { type: "str", format: "strDigit" },
            msg: { format_err: "<?php echo $this->lang['rcode']['x120215']; ?>" }
        },
        article_cate_id: {
            len: { min: 1, max: 0 },
            validate: { type: "select" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x120207']; ?>" }
        },
        article_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='article_status']", type: "radio" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x120208']; ?>" }
        },
        article_box: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='article_box']", type: "radio" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x120209']; ?>" }
        },
        article_time_show: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "datetime" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x120221']; ?>", format_err: "<?php echo $this->lang['rcode']['x120222']; ?>" }
        },
        article_time_pub: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "datetime" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x120210']; ?>", format_err: "<?php echo $this->lang['rcode']['x120211']; ?>" }
        },
        article_time_hide: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "datetime" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x120219']; ?>", format_err: "<?php echo $this->lang['rcode']['x120220']; ?>" }
        },
        article_source: {
            len: { min: 0, max: 300 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x260202']; ?>" }
        },
        article_author: {
            len: { min: 0, max: 300 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x260203']; ?>" }
        },
        article_source_url: {
            len: { min: 0, max: 900 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x260204']; ?>" }
        }
    };

    var options_validator_form = {
        msg_global:{
            msg: "<?php echo $this->lang['common']['label']['errInput']; ?>"
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=article&c=request",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    function article_cate_id(_cate_id) {
        $(".custom_group").hide();
        $(".custom_group_0").show();
        $(".custom_group_" + _cate_id).show();
    }

    function excerpt_type(_excerpt_type) {
        if (_excerpt_type == "manual") {
            $("#group_article_excerpt").show();
        } else {
            $("#group_article_excerpt").hide();
        }
    }

    function cate_ids_check(_is_checked) {
        if (_is_checked) {
            $("#cate_ids_input").show();
        } else {
            $("#cate_ids_input").hide();
        }
    }

    function time_pub_check(_is_checked) {
        if (_is_checked) {
            $("#time_pub_input").show();
        } else {
            $("#time_pub_input").hide();
        }
    }

    function time_hide_check(_is_checked) {
        if (_is_checked) {
            $("#time_hide_input").show();
        } else {
            $("#time_hide_input").hide();
        }
    }

    $(document).ready(function(){
        article_cate_id("<?php echo $this->tplData['articleRow']['article_cate_id']; ?>");
        excerpt_type("<?php echo $this->tplData['articleRow']['article_excerpt_type']; ?>");
        cate_ids_check(<?php if (count($this->tplData['articleRow']['cate_ids']) > 1) { ?>true<?php } else { ?>false<?php } ?>);
        time_pub_check(<?php if ($this->tplData['articleRow']['article_is_time_pub'] > 0) { ?>true<?php } else { ?>false<?php } ?>);
        time_hide_check(<?php if ($this->tplData['articleRow']['article_is_time_hide'] > 0) { ?>true<?php } else { ?>false<?php } ?>);

        $("#article_modal").on("shown.bs.modal",function(event) {
    		var _obj_button   = $(event.relatedTarget);
    		var _act      = _obj_button.data("act");
    		switch (_act) {
        		case 'spec':
                    var _spec_key = $("#spec_key").val();
                    var _url = "<?php echo BG_URL_CONSOLE; ?>index.php?m=spec&a=insert&target=article&article_id=<?php echo $this->tplData['articleRow']['article_id']; ?>&view=modal&key=" + _spec_key;
        		break;

        		default:
            		var _id = _obj_button.data("id");
                    var _url = "<?php echo BG_URL_CONSOLE; ?>index.php?m=attach&a=form&view=modal&article_id=" + _id;
        		break;
    		}

            $("#article_modal .modal-content").load(_url);
    	}).on("hidden.bs.modal", function(){
        	$("#article_modal .modal-content").empty();
    	});

        $(".article_excerpt_type").click(function(){
            var _excerpt_type = $(this).val();
            excerpt_type(_excerpt_type);
        });

        $("#article_cate_id").change(function(){
            var _cate_id = $(this).val();
            article_cate_id(_cate_id);
        });

        $("#article_source_often").change(function(){
            var _source_id = $(this).val();
            $("#article_source").val(_sourceJson[_source_id].source_name);
            $("#article_source_url").val(_sourceJson[_source_id].source_url);
            $("#article_author").val(_sourceJson[_source_id].source_author);
        });

        var obj_validate_form = $("#article_form").baigoValidator(opts_validator_form, options_validator_form);
        var obj_submit_form   = $("#article_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            tinyMCE.triggerSave();
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
        $(".input_date").datetimepicker(opts_datetimepicker);

        $("#cate_ids_checkbox").click(function(){
            var _is_checked = $(this).prop("checked");
            cate_ids_check(_is_checked);
        });

        $("#article_is_time_pub").click(function(){
            var _is_checked = $(this).prop("checked");
            time_pub_check(_is_checked);
        });

        $("#article_is_time_hide").click(function(){
            var _is_checked = $(this).prop("checked");
            time_hide_check(_is_checked);
        });

        var obj_tagMan = jQuery("#article_tag").tagsManager({
            <?php if (!fn_isEmpty($this->tplData['articleRow']['article_tags'])) { ?>
                prefilled: <?php echo $this->tplData['articleRow']['article_tags']; ?>,
            <?php } ?>
            maxTags: 5,
            backspace: ""
        });

        $("#article_tag").typeahead({
            limit: 1000,
            prefetch: "<?php echo BG_URL_CONSOLE; ?>index.php?m=tag&c=request&a=list"
        }).on("typeahead:selected", function(e, d) {
            obj_tagMan.tagsManager("pushTag", d.value);
        });

        $("#tag_add").on("click", function(e) {
            var _str_tag = $("#article_tag").val();
            obj_tagMan.tagsManager("pushTag", _str_tag);
        });
    });
    </script>

<?php include('include' . DS . 'html_foot.php');