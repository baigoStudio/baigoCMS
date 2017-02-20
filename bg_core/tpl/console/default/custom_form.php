<?php function custom_list_opt($arr_customRows, $customRow = array()) {
    if (!fn_isEmpty($arr_customRows)) {
        foreach ($arr_customRows as $key=>$value) { ?>
            <option value="<?php echo $value["custom_id"]; ?>" <?php if ($customRow["custom_parent_id"] == $value["custom_id"]) { ?> selected <?php } ?> <?php if ($customRow["custom_id"] == $value["custom_id"]) { ?> disabled<?php } ?>>
                <?php if ($value["custom_level"] > 1) {
                    for ($_iii = 2; $_iii <= $value["custom_level"]; $_iii++) { ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                    <?php }
                }
                echo $value["custom_name"]; ?>
            </option>

            <?php if (isset($value["custom_childs"]) && !fn_isEmpty($value["custom_childs"])) {
                custom_list_opt($value["custom_childs"], $customRow);
            }
        }
    }
}

$cfg = array(
    "title"          => $this->consoleMod["article"]["main"]["title"] . " &raquo; " . $this->lang["page"]["custom"],
    "menu_active"    => "article",
    "sub_active"     => "custom",
    "baigoValidator" => "true",
    "baigoSubmit"    => "true",
    "pathInclude"    => BG_PATH_TPLSYS . "console/default/include/",
    "str_url"        => BG_URL_CONSOLE . "index.php?mod=custom"
);

include($cfg["pathInclude"] . "function.php");
include($cfg["pathInclude"] . "console_head.php"); ?>

    <div class="form-group clearfix">
        <div class="pull-left">
            <div class="form-group">
                <ul class="nav nav-pills bg-nav-pills">
                    <li>
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=custom&act=list">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                            <?php echo $this->lang["href"]["back"]; ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=custom" target="_blank">
                            <span class="glyphicon glyphicon-question-sign"></span>
                            <?php echo $this->lang["href"]["help"]; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <form name="custom_form" id="custom_form">
        <input type="hidden" name="<?php echo $this->common["tokenRow"]["name_session"]; ?>" value="<?php echo $this->common["tokenRow"]["token"]; ?>">
        <input type="hidden" name="custom_id" id="custom_id" value="<?php echo $this->tplData["customRow"]["custom_id"]; ?>">
        <input type="hidden" name="act" value="submit">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div id="group_custom_name">
                                <label class="control-label"><?php echo $this->lang["label"]["customName"]; ?><span id="msg_custom_name">*</span></label>
                                <input type="text" name="custom_name" id="custom_name" value="<?php echo $this->tplData["customRow"]["custom_name"]; ?>" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_custom_parent_id">
                                <label class="control-label"><?php echo $this->lang["label"]["customParent"]; ?><span id="msg_custom_parent_id">*</span></label>
                                <select name="custom_parent_id" id="custom_parent_id" data-validate class="form-control">
                                    <option value=""><?php echo $this->lang["option"]["pleaseSelect"]; ?></option>
                                    <option <?php if ($this->tplData["customRow"]["custom_parent_id"] == 0) { ?>selected<?php } ?> value="0"><?php echo $this->lang["option"]["asCustomParent"]; ?></option>
                                    <?php custom_list_opt($this->tplData["customRows"], $this->tplData["customRow"]); ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_custom_type">
                                <label class="control-label"><?php echo $this->lang["label"]["type"]; ?><span id="msg_custom_type">*</span></label>
                                <select name="custom_type" id="custom_type" data-validate class="form-control">
                                    <option value=""><?php echo $this->lang["option"]["pleaseSelect"]; ?></option>
                                    <?php foreach ($this->tplData["fields"] as $key=>$value) { ?>
                                        <option <?php if ($this->tplData["customRow"]["custom_type"] == $key) { ?>selected<?php } ?> value="<?php echo $key; ?>"><?php echo $value["label"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <?php foreach ($this->tplData["fields"] as $key_field=>$value_field) {
                            if ($key_field == "radio" || $key_field == "select") { ?>
                                <div id="group_<?php echo $key_field; ?>" class="group_opt">
                                    <div id="group_<?php echo $key_field; ?>_option">
                                        <?php foreach ($value_field["option"] as $key_opt=>$value_opt) { ?>
                                            <div class="form-group" id="group_<?php echo $key_field; ?>_<?php echo $key_opt; ?>">
                                                <div class="input-group">
                                                    <input type="text" name="custom_opt[<?php echo $key_field; ?>][<?php echo $key_opt; ?>]" value="<?php echo $value_opt; ?>" class="form-control">
                                                    <span class="input-group-btn">
                                                        <a class="btn btn-info" href="javascript:del_<?php echo $key_field; ?>(<?php echo $key_opt; ?>);">
                                                            <span class="glyphicon glyphicon-trash"></span>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <div class="form-group">
                                        <a class="btn btn-success" href="javascript:add_<?php echo $key_field; ?>(<?php echo $key_opt + 1; ?>;">
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </a>
                                    </div>
                                </div>
                            <?php }
                        } ?>

                        <div class="form-group">
                            <div id="group_custom_format">
                                <label class="control-label"><?php echo $this->lang["label"]["format"]; ?><span id="msg_custom_format">*</span></label>
                                <select name="custom_format" id="custom_format" data-validate class="form-control">
                                    <option value=""><?php echo $this->lang["option"]["pleaseSelect"]; ?></option>
                                    <?php foreach ($this->type["custom"] as $key=>$value) { ?>
                                        <option <?php if ($this->tplData["customRow"]["custom_format"] == $key) { ?>selected<?php } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
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
                    <?php if ($this->tplData["customRow"]["custom_id"] > 0) { ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang["label"]["id"]; ?></label>
                            <div class="form-control-static"><?php echo $this->tplData["customRow"]["custom_id"]; ?></div>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <div id="group_custom_cate_id">
                            <label class="control-label"><?php echo $this->lang["label"]["belongCate"]; ?><span id="msg_custom_cate_id">*</span></label>
                            <select name="custom_cate_id" id="custom_cate_id" data-validate class="form-control">
                                <option value=""><?php echo $this->lang["option"]["pleaseSelect"]; ?></option>
                                <option <?php if ($this->tplData["customRow"]["custom_cate_id"] == 0) { ?>selected<?php } ?> value="0"><?php echo $this->lang["option"]["allCate"]; ?></option>
                                <?php cate_list_opt($this->tplData["cateRows"], $this->tplData["customRow"]["custom_cate_id"], true); ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="group_custom_status">
                            <label class="control-label"><?php echo $this->lang["label"]["status"]; ?><span id="msg_custom_status">*</span></label>
                            <?php foreach ($this->status["custom"] as $key=>$value) { ?>
                                <div class="bg-radio">
                                    <label for="custom_status_<?php echo $key; ?>">
                                        <input type="radio" name="custom_status" id="custom_status_<?php echo $key; ?>" value="<?php echo $key; ?>" <?php if ($this->tplData["customRow"]["custom_status"] == $key) { ?>checked<?php } ?> data-validate="custom_status">
                                        <?php echo $value; ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label for="custom_require">
                                <input type="checkbox" id="custom_require" name="custom_require" <?php if ($this->tplData["customRow"]["custom_require"] > 0) { ?>checked<?php } ?> value="1">
                                <?php echo $this->lang["label"]["require"]; ?>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

<?php include($cfg["pathInclude"] . "console_foot.php"); ?>

    <script type="text/javascript">
    var opts_validator_form = {
        custom_name: {
            len: { min: 1, max: 90 },
            validate: { type: "ajax", format: "text", group: "#group_custom_name" },
            msg: { selector: "#msg_custom_name", too_short: "<?php echo $this->rcode["x200201"]; ?>", too_long: "<?php echo $this->rcode["x200202"]; ?>", ajaxIng: "<?php echo $this->rcode["x030401"]; ?>", ajax_err: "<?php echo $this->rcode["x030402"]; ?>" },
            ajax: { url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=custom&act=chkname", key: "custom_name", type: "str", attach_selectors: ["#custom_id","#custom_type"], attach_keys: ["custom_id","custom_type"] }
        },
        custom_type: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_custom_type" },
            msg: { selector: "#msg_custom_type", too_few: "<?php echo $this->rcode["x200211"]; ?>" }
        },
        custom_format: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_custom_format" },
            msg: { selector: "#msg_custom_format", too_few: "<?php echo $this->rcode["x200205"]; ?>" }
        },
        custom_parent_id: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_custom_parent_id" },
            msg: { selector: "#msg_custom_parent_id", too_few: "<?php echo $this->rcode["x200207"]; ?>" }
        },
        custom_cate_id: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_custom_cate_id" },
            msg: { selector: "#msg_custom_cate_id", too_few: "<?php echo $this->rcode["x200213"]; ?>" }
        },
        custom_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='custom_status']", type: "radio", group: "#group_custom_status" },
            msg: { selector: "#msg_custom_status", too_few: "<?php echo $this->rcode["x200206"]; ?>" }
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=custom",
        msg_text: {
            submitting: "<?php echo $this->lang["label"]["submitting"]; ?>"
        }
    };

    function custom_type(_custom_type) {
        $(".group_opt").hide();
        $("#group_" + _custom_type).show();
    }

    <?php foreach ($this->tplData["fields"] as $key_field=>$value_field) {
        if ($key_field == "radio" || $key_field == "select") { ?>
            function del_<?php echo $key_field; ?>(_radio_id) {
                $("#group_<?php echo $key_field; ?>_" + _radio_id).remove();
            }

            function add_<?php echo $key_field; ?>(_count) {
                $("#group_<?php echo $key_field; ?>_option").append("<div class='form-group' id='group_<?php echo $key_field; ?>_" + _count + "'>" +
                    "<div class='input-group'>" +
                        "<input type='text' name='custom_opt[<?php echo $key_field; ?>][]' class='form-control'>" +
                        "<span class='input-group-btn'>" +
                            "<a class='btn btn-info' href='javascript:del_<?php echo $key_field; ?>(" + _count + ");'>" +
                                "<span class='glyphicon glyphicon-trash'></span>" +
                            "</a>" +
                        "</span>" +
                    "</div>" +
                "</div>");
            }
        <?php }
    } ?>

    $(document).ready(function(){
        custom_type("<?php echo $this->tplData["customRow"]["custom_type"]; ?>");
        var obj_validate_form = $("#custom_form").baigoValidator(opts_validator_form);
        var obj_submit_form   = $("#custom_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
        $("#custom_type").change(function(){
            var _this_val = $(this).val();
            if (_this_val.length > 0) {
                custom_type(_this_val);
            }
        });
    });
    </script>

<?php include($cfg["pathInclude"] . "html_foot.php"); ?>