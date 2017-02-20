<?php function custom_list_form($arr_customRows, $article_customs = array(), $lang) {
    if (!fn_isEmpty($arr_customRows)) {
        foreach ($arr_customRows as $key=>$value) {
            if (isset($value["custom_childs"]) && !fn_isEmpty($value["custom_childs"])) { ?>
                <div class="custom_group custom_group_<?php echo $value["custom_cate_id"] ; ?> col-md-12">
                    <h4>
                        <span class="label label-default"><?php echo $value["custom_name"] ; ?></span>
                    </h4>
                </div>
                <?php custom_list_form($value["custom_childs"], $article_customs, $lang);

            } else { ?>
                <div class="custom_group custom_group_<?php echo $value["custom_cate_id"] ; ?> col-md-6">
                    <div class="form-group">
                        <label class="control-label">
                            <?php echo $value["custom_name"] ; ?>
                            <span id="msg_article_custom_<?php echo $value["custom_id"] ; ?>"></span>
                        </label>

                        <?php switch($value["custom_type"]) {
                            case "radio":
                                foreach ($value["custom_opt"] as $key_option=>$value_option) { ?>
                                    <div class="bg-radio">
                                        <label for="article_customs_<?php echo $value["custom_id"] ; ?>_<?php echo $key_option ; ?>">
                                            <input type="radio" id="article_customs_<?php echo $value["custom_id"] ; ?>_<?php echo $key_option ; ?>" name="article_customs[<?php echo $value["custom_id"] ; ?>]" value="<?php echo $value_option ; ?>" data-validate="article_customs_<?php echo $value["custom_id"] ; ?>" <?php if (isset($article_customs["custom_" . $value["custom_id"]]) && $article_customs["custom_" . $value["custom_id"]] == $value_option) { ?> checked<?php } ?>>
                                            <?php echo $value_option ; ?>
                                        </label>
                                    </div>
                                <?php }
                            break;

                            case "select": ?>
                                <select id="article_customs_<?php echo $value["custom_id"] ; ?>" name="article_customs[<?php echo $value["custom_id"] ; ?>]" data-validate class="form-control">
                                    <option value=""><?php echo $lang["option"]["pleaseSelect"]; ?></option>
                                    <?php foreach ($value["custom_opt"] as $key_option=>$value_option) { ?>
                                        <option
                                        <?php if (isset($article_customs["custom_" . $value["custom_id"]]) && $article_customs["custom_" . $value["custom_id"]] == $value_option) { ?>
                                             selected
                                        <?php } ?>
                                         value="<?php echo $value_option ; ?>">
                                            <?php echo $value_option ; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            <?php break;

                            case "textarea": ?>
                                <textarea id="article_customs_<?php echo $value["custom_id"] ; ?>" name="article_customs[<?php echo $value["custom_id"] ; ?>]" data-validate class="form-control bg-textarea-md">
                                    <?php if (isset($article_customs["custom_" . $value["custom_id"]])) {
                                        echo $article_customs["custom_" . $value["custom_id"]];
                                    } ?>
                                </textarea>
                            <?php break;

                            default: ?>
                                <input type="text" id="article_customs_<?php echo $value["custom_id"] ; ?>" name="article_customs[<?php echo $value["custom_id"] ; ?>]" value="<?php if (isset($article_customs["custom_" . $value["custom_id"]])) { echo $article_customs["custom_" . $value["custom_id"]];} ?>" data-validate class="form-control">
                            <?php break;
                        } ?>
                    </div>
                </div>
            <?php }
        }
    }
}


function custom_validataJson($arr_customRows, $rcode = array()) {
    foreach ($arr_customRows as $key=>$value) {
        if (isset($value["custom_childs"]) && !fn_isEmpty($value["custom_childs"])) {
            custom_validataJson($value["custom_childs"], $rcode);
        } else { ?>
            article_customs_<?php echo $value["custom_id"]; ?>: {
                len: {
                    min: <?php echo $value["custom_require"]; ?>,
                    max: 90
                },
                validate: {
                    type: "<?php echo $value["custom_type"]; ?>"
                    <?php if ($value["custom_type"] != "radio" && $value["custom_type"] != "select") { ?>
                        , format: "<?php echo $value["custom_format"]; ?>"
                    <?php } ?>
                },
                msg: {
                    selector: "#msg_article_custom_<?php echo $value["custom_id"]; ?>",
                    <?php if ($value["custom_type"] != "radio" && $value["custom_type"] != "select") { ?>
                        too_short: "<?php echo $rcode["x120216"] . $value["custom_name"]; ?>"
                    <?php } else { ?>
                        too_few: "<?php echo $rcode["x120218"] . $value["custom_name"]; ?>"
                    <?php }
                    if ($value["custom_type"] != "radio" && $value["custom_type"] != "select") { ?>
                        , too_long: "<?php echo $value["custom_name"] . $rcode["x120217"]; ?>"
                    <?php } ?>

                }
            },
        <?php }
    }
}


if ($this->tplData["articleRow"]["article_id"] < 1) {
    $title_sub  = $this->lang["page"]["add"];
    $sub_active = "form";
} else {
    $title_sub = $this->lang["page"]["edit"];
    $sub_active = "list";
}

$cfg = array(
    "title"          => $this->consoleMod["article"]["main"]["title"] . " &raquo; " . $title_sub,
    "menu_active"    => "article",
    "sub_active"     => $sub_active,
    "baigoValidator" => "true",
    "baigoSubmit"    => "true",
    "tinymce"        => "true",
    "datepicker"     => "true",
    "tagmanager"     => "true",
    "upload"         => "true",
    "pathInclude"    => BG_PATH_TPLSYS . "console/default/include/",
    "str_url"        => BG_URL_CONSOLE . "index.php?mod=article",
);

include($cfg["pathInclude"] . "function.php");
include($cfg["pathInclude"] . "console_head.php"); ?>

    <div class="form-group">
        <ul class="nav nav-pills bg-nav-pills">
            <li>
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=article&act=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <?php echo $this->lang["href"]["back"]; ?>
                </a>
            </li>
            <li>
                <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=article#form" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    <?php echo $this->lang["href"]["help"]; ?>
                </a>
            </li>
        </ul>
    </div>

    <form name="article_form" id="article_form">
        <input type="hidden" name="<?php echo $this->common["tokenRow"]["name_session"]; ?>" value="<?php echo $this->common["tokenRow"]["token"]; ?>">
        <input type="hidden" name="act" value="submit">
        <input type="hidden" name="article_id" value="<?php echo $this->tplData["articleRow"]["article_id"]; ?>">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div id="group_article_title">
                                <label class="control-label"><?php echo $this->lang["label"]["articleTitle"]; ?><span id="msg_article_title">*</span></label>
                                <input type="text" name="article_title" id="article_title" value="<?php echo $this->tplData["articleRow"]["article_title"]; ?>" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group" data-spy="affix" data-offset-top="260">
                            <div class="btn-group">
                                <a href="#article_modal" class="btn btn-success" data-toggle="modal" data-act="attach" data-id="<?php echo $this->tplData["articleRow"]["article_id"]; ?>">
                                    <span class="glyphicon glyphicon-picture"></span>
                                    <?php echo $this->lang["href"]["uploadList"]; ?>
                                </a>
                                <?php if ($this->tplData["articleRow"]["article_id"] > 0) { ?>
                                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=attach&act=article&article_id=<?php echo $this->tplData["articleRow"]["article_id"]; ?>" class="btn btn-default">
                                        <?php echo $this->lang["href"]["attachArticle"]; ?>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang["label"]["articleContent"]; ?></label>
                            <textarea name="article_content" id="article_content" class="tinymce bg-textarea-lg"><?php echo $this->tplData["articleRow"]["article_content"]; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang["label"]["excerptType"]; ?></label>
                            <div>
                                <?php foreach ($this->type["excerpt"] as $key=>$value) { ?>
                                    <label for="article_excerpt_type_<?php echo $key; ?>" class="radio-inline">
                                        <input type="radio" name="article_excerpt_type" id="article_excerpt_type_<?php echo $key; ?>" <?php if ($this->tplData["articleRow"]["article_excerpt_type"] == $key) { ?>checked<?php } ?> value="<?php echo $key; ?>" class="article_excerpt_type">
                                        <?php echo $value; ?>
                                    </label>
                                <?php } ?>
                            </div>
                        </div>

                        <div id="group_article_excerpt">
                            <label class="control-label"><?php echo $this->lang["label"]["articleExcerpt"]; ?></label>
                            <div class="form-group">
                                <textarea name="article_excerpt" id="article_excerpt" class="tinymce bg-textarea-md"><?php echo $this->tplData["articleRow"]["article_excerpt"]; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang["label"]["articleTag"]; ?><span id="msg_article_tag"></span></label>
                            <div class="tm-input-group form-inline">
                                <input type="text" name="article_tag" id="article_tag" data-validate class="form-control tm-input tm-input-success">
                                <button type="button" class="btn btn-info btn-sm tm-btn" id="tag_add"><span class="glyphicon glyphicon-plus"></span></button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_article_link" <?php if (!fn_isEmpty($this->tplData["articleRow"]["article_link"])) { ?>class="has-warning"<?php } ?>>
                                <label class="control-label"><?php echo $this->lang["label"]["articleLink"]; ?><span id="msg_article_link"></span></label>
                                <input type="text" name="article_link" id="article_link" value="<?php echo $this->tplData["articleRow"]["article_link"]; ?>" data-validate class="form-control">
                                <span class="help-block"><?php echo $this->lang["label"]["articleLinkNote"]; ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <?php if (isset($this->tplData["articleRow"]["article_customs"])) {
                                    custom_list_form($this->tplData["customRows"], $this->tplData["articleRow"]["article_customs"], $this->lang);
                                } ?>
                            </div>
                        </div>

                        <div class="bg-submit-box"></div>
                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang["btn"]["save"]; ?></button>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="well">
                    <?php if ($this->tplData["articleRow"]["article_id"] > 0) { ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang["label"]["id"]; ?></label>
                            <div class="form-control-static"><?php echo $this->tplData["articleRow"]["article_id"]; ?></div>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <div id="group_article_cate_id">
                            <label class="control-label"><?php echo $this->lang["label"]["belongCate"]; ?><span id="msg_article_cate_id">*</span></label>
                            <select name="article_cate_id" id="article_cate_id" data-validate class="form-control">
                                <option value=""><?php echo $this->lang["option"]["pleaseSelect"]; ?></option>
                                <?php cate_list_opt($this->tplData["cateRows"], $this->tplData["articleRow"]["article_cate_id"], true); ?>
                            </select>
                        </div>
                    </div>

                    <div class="checkbox">
                        <label for="cate_ids_checkbox">
                            <input type="checkbox" <?php if (!fn_isEmpty($this->tplData["articleRow"]["cate_ids"])) { ?>checked<?php } ?> id="cate_ids_checkbox" name="cate_ids_checkbox" value="1">
                            <?php echo $this->lang["label"]["articleBelong"]; ?>
                        </label>
                    </div>

                    <div class="form-group">
                        <div id="cate_ids_input">
                            <table class="bg-table-empty">
                                <tbody>
                                    <?php cate_list_checkbox($this->tplData["cateRows"], $this->tplData["articleRow"]["cate_ids"], "article"); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="group_article_status">
                            <label class="control-label"><?php echo $this->lang["label"]["status"]; ?><span id="msg_article_status">*</span></label>
                            <?php foreach ($this->status["article"] as $key=>$value) { ?>
                                <div class="bg-radio">
                                    <label for="article_status_<?php echo $key; ?>">
                                        <input type="radio" name="article_status" id="article_status_<?php echo $key; ?>" <?php if ($this->tplData["articleRow"]["article_status"] == $key) { ?>checked<?php } ?> value="<?php echo $key; ?>" data-validate="article_status">
                                        <?php echo $value; ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="group_article_box">
                            <label class="control-label"><?php echo $this->lang["label"]["box"]; ?><span id="msg_article_box">*</span></label>
                            <div class="bg-radio">
                                <label for="article_box_normal">
                                    <input type="radio" name="article_box" id="article_box_normal" <?php if ($this->tplData["articleRow"]["article_box"] == "normal") { ?>checked<?php } ?> value="normal" data-validate="article_box">
                                    <?php echo $this->lang["label"]["normal"]; ?>
                                </label>
                            </div>
                            <div class="bg-radio">
                                <label for="article_box_draft">
                                    <input type="radio" name="article_box" id="article_box_draft" <?php if ($this->tplData["articleRow"]["article_box"] == "draft") { ?>checked<?php } ?> value="draft" data-validate="article_box">
                                    <?php echo $this->lang["label"]["draft"]; ?>
                                </label>
                            </div>
                            <div class="bg-radio">
                                <label for="article_box_recycle">
                                    <input type="radio" name="article_box" id="article_box_recycle" <?php if ($this->tplData["articleRow"]["article_box"] == "recycle") { ?>checked<?php } ?> value="recycle" data-validate="article_box">
                                    <?php echo $this->lang["label"]["recycle"]; ?>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang["label"]["articleMark"]; ?></label>
                        <select name="article_mark_id" class="form-control">
                            <option value=""><?php echo $this->lang["option"]["noMark"]; ?></option>
                            <?php foreach ($this->tplData["markRows"] as $key=>$value) { ?>
                                <option <?php if ($value["mark_id"] == $this->tplData["articleRow"]["article_mark_id"]) { ?>selected<?php } ?> value="<?php echo $value["mark_id"]; ?>"><?php echo $value["mark_name"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label for="time_pub_checkbox">
                                <input type="checkbox" <?php if ($this->tplData["articleRow"]["article_time_pub"] > time()) { ?>checked<?php } ?> name="time_pub_checkbox" id="time_pub_checkbox" value="1">
                                <?php echo $this->lang["label"]["timePub"]; ?>
                                <span id="msg_article_time_pub"></span>
                            </label>
                        </div>
                    </div>
                    <div id="time_pub_input">
                        <div class="form-group">
                            <input type="text" name="article_time_pub" id="article_time_pub" value="<?php echo date("Y-m-d H:i", $this->tplData["articleRow"]["article_time_pub"]); ?>" data-validate class="form-control input_date">
                            <span class="help-block"><?php echo $this->lang["label"]["timeNote"]; ?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label for="time_hide_checkbox">
                                <input type="checkbox" <?php if ($this->tplData["articleRow"]["article_time_hide"] > 0) { ?>checked<?php } ?> id="time_hide_checkbox" name="time_hide_checkbox" value="1">
                                <?php echo $this->lang["label"]["timeHide"]; ?>
                                <span id="msg_article_time_hide"></span>
                            </label>
                        </div>
                    </div>

                    <div id="time_hide_input">
                        <div class="form-group">
                            <input type="text" name="article_time_hide" id="article_time_hide" value="<?php echo date("Y-m-d H:i", $this->tplData["articleRow"]["article_time_hide"]); ?>" data-validate class="form-control input_date">
                            <span class="help-block"><?php echo $this->lang["label"]["timeNote"]; ?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang["label"]["articleSpec"]; ?></label>
                        <div class="input-group">
                            <input type="text" id="spec_key" name="spec_key" placeholder="<?php echo $this->lang["label"]["key"]; ?>" class="form-control">
                            <span class="input-group-btn">
                                <button type="button" data-target="#article_modal" class="btn btn-info" data-toggle="modal" data-act="spec">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                        <div id="spec_check_list">
                            <?php foreach ($this->tplData["specRows"] as $key=>$value) { ?>
                                <div class="checkbox" id="spec_checkbox_<?php echo $value["spec_id"]; ?>">
                                    <label for="article_spec_ids_<?php echo $value["spec_id"]; ?>">
                                        <input type="checkbox" id="article_spec_ids_<?php echo $value["spec_id"]; ?>" checked name="article_spec_ids[]" value="<?php echo $value["spec_id"]; ?>">
                                        <?php echo $value["spec_name"]; ?>
                                    </label>
                                </div>
                            <?php } ?>
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

<?php include($cfg["pathInclude"] . "console_foot.php"); ?>

    <script type="text/javascript">
    var opts_validator_form = {
        <?php custom_validataJson($this->tplData["customRows"], $this->rcode); ?>
        article_title: {
            len: { min: 1, max: 300 },
            validate: { type: "str", format: "text", group: "#group_article_title" },
            msg: { selector: "#msg_article_title", too_short: "<?php echo $this->rcode["x120201"]; ?>", too_long: "<?php echo $this->rcode["x120202"]; ?>" }
        },
        article_link: {
            len: { min: 0, max: 900 },
            validate: { type: "str", format: "url", group: "#group_article_link" },
            msg: { selector: "#msg_article_link", too_long: "<?php echo $this->rcode["x120204"]; ?>", format_err: "<?php echo $this->rcode["x120205"]; ?>" }
        },
        article_excerpt: {
            len: { min: 0, max: 900 },
            validate: { type: "str", format: "text" },
            msg: { selector: "#msg_article_excerpt", too_long: "<?php echo $this->rcode["x120206"]; ?>" }
        },
        article_tag: {
            len: { min: 0, max: 0 },
            validate: { type: "str", format: "strDigit" },
            msg: { selector: "#msg_article_tag", format_err: "<?php echo $this->rcode["x120215"]; ?>" }
        },
        article_cate_id: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_article_cate_id" },
            msg: { selector: "#msg_article_cate_id", too_few: "<?php echo $this->rcode["x120207"]; ?>" }
        },
        article_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='article_status']", type: "radio", group: "#group_article_status" },
            msg: { selector: "#msg_article_status", too_few: "<?php echo $this->rcode["x120208"]; ?>" }
        },
        article_box: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='article_box']", type: "radio", group: "#group_article_box" },
            msg: { selector: "#msg_article_box", too_few: "<?php echo $this->rcode["x120209"]; ?>" }
        },
        article_time_pub: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "datetime" },
            msg: { selector: "#msg_article_time_pub", too_short: "<?php echo $this->rcode["x120210"]; ?>", format_err: "<?php echo $this->rcode["x120211"]; ?>" }
        },
        article_time_hide: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "datetime" },
            msg: { selector: "#msg_article_time_hide", too_short: "<?php echo $this->rcode["x120219"]; ?>", format_err: "<?php echo $this->rcode["x120220"]; ?>" }
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=article",
        msg_text: {
            submitting: "<?php echo $this->lang["label"]["submitting"]; ?>"
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
        article_cate_id("<?php echo $this->tplData["articleRow"]["article_cate_id"]; ?>");
        excerpt_type("<?php echo $this->tplData["articleRow"]["article_excerpt_type"]; ?>");
        cate_ids_check(<?php if (count($this->tplData["articleRow"]["cate_ids"]) > 1) { ?>true<?php } else { ?>false<?php } ?>);
        time_pub_check(<?php if ($this->tplData["articleRow"]["article_time_pub"] > time()) { ?>true<?php } else { ?>false<?php } ?>);
        time_hide_check(<?php if ($this->tplData["articleRow"]["article_time_hide"] > 0) { ?>true<?php } else { ?>false<?php } ?>);

        $("#article_modal").on("shown.bs.modal",function(event) {
    		var _obj_button   = $(event.relatedTarget);
    		var _act      = _obj_button.data("act");
    		switch (_act) {
        		case "spec":
                    var _spec_key = $("#spec_key").val();
                    var _url = "<?php echo BG_URL_CONSOLE; ?>index.php?mod=spec&act=insert&target=article&article_id=<?php echo $this->tplData["articleRow"]["article_id"]; ?>&view=iframe&key=" + _spec_key;
        		break;

        		default:
            		var _id = _obj_button.data("id");
                    var _url = "<?php echo BG_URL_CONSOLE; ?>index.php?mod=attach&act=form&view=iframe&article_id=" + _id;
        		break;
    		}

            $("#article_modal .modal-content").load(_url);
        });

        $(".article_excerpt_type").click(function(){
            var _excerpt_type = $(this).val();
            excerpt_type(_excerpt_type);
        });

        $("#article_cate_id").change(function(){
            var _cate_id = $(this).val();
            article_cate_id(_cate_id);
        });

        var obj_validate_form = $("#article_form").baigoValidator(opts_validator_form);
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

        $("#time_pub_checkbox").click(function(){
            var _is_checked = $(this).prop("checked");
            time_pub_check(_is_checked);
        });

        $("#time_hide_checkbox").click(function(){
            var _is_checked = $(this).prop("checked");
            time_hide_check(_is_checked);
        });

        var obj_tagMan = jQuery("#article_tag").tagsManager({
            <?php if (!fn_isEmpty($this->tplData["articleRow"]["article_tags"])) { ?>
                prefilled: <?php echo $this->tplData["articleRow"]["article_tags"]; ?>,
            <?php } ?>
            maxTags: 5,
            backspace: ""
        });

        $("#article_tag").typeahead({
            limit: 1000,
            prefetch: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=tag&act=list"
        }).on("typeahead:selected", function(e, d) {
            obj_tagMan.tagsManager("pushTag", d.value);
        });

        $("#tag_add").on("click", function(e) {
            var _str_tag = $("#article_tag").val();
            obj_tagMan.tagsManager("pushTag", _str_tag);
        });
    });
    </script>

<?php include($cfg["pathInclude"] . "html_foot.php"); ?>