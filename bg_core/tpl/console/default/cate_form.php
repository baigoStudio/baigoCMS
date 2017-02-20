<?php if ($this->tplData["cateRow"]["cate_id"] < 1) {
    $title_sub    = $this->lang["page"]["add"];
    $sub_active   = "form";
} else {
    $title_sub    = $this->lang["page"]["edit"];
    $sub_active   = "list";
}

$cfg = array(
    "title"          => $this->consoleMod["cate"]["main"]["title"] . " &raquo; " . $title_sub,
    "menu_active"    => "cate",
    "sub_active"     => $sub_active,
    "tinymce"        => "true",
    "baigoSubmit"    => "true",
    "baigoValidator" => "true",
    "upload"         => "true",
    "pathInclude"    => BG_PATH_TPLSYS . "console/default/include/",
    "str_url"        => BG_URL_CONSOLE . "index.php?mod=cate",
);

include($cfg["pathInclude"] . "function.php");
include($cfg["pathInclude"] . "console_head.php"); ?>

    <div class="form-group">
        <ul class="nav nav-pills bg-nav-pills">
            <li>
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=cate&act=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <?php echo $this->lang["href"]["back"]; ?>
                </a>
            </li>
            <li>
                <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=cate#form" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    <?php echo $this->lang["href"]["help"]; ?>
                </a>
            </li>
        </ul>
    </div>

    <form name="cate_form" id="cate_form">
        <input type="hidden" name="<?php echo $this->common["tokenRow"]["name_session"]; ?>" value="<?php echo $this->common["tokenRow"]["token"]; ?>">
        <input type="hidden" name="act" value="submit">
        <input type="hidden" name="cate_id" id="cate_id" value="<?php echo $this->tplData["cateRow"]["cate_id"]; ?>">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div id="group_cate_name">
                                <label class="control-label"><?php echo $this->lang["label"]["cateName"]; ?><span id="msg_cate_name">*</span></label>
                                <input type="text" name="cate_name" id="cate_name" value="<?php echo $this->tplData["cateRow"]["cate_name"]; ?>" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_cate_alias">
                                <label class="control-label"><?php echo $this->lang["label"]["cateAlias"]; ?><span id="msg_cate_alias"></span></label>
                                <input type="text" name="cate_alias" id="cate_alias" value="<?php echo $this->tplData["cateRow"]["cate_alias"]; ?>" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group" id="item_cate_perpage">
                            <div id="group_cate_perpage">
                                <label class="control-label"><?php echo $this->lang["label"]["catePerpage"]; ?><span id="msg_cate_perpage">*</span></label>
                                <input type="text" name="cate_perpage" id="cate_perpage" value="<?php echo $this->tplData["cateRow"]["cate_perpage"]; ?>" data-validate class="form-control">
                            </div>
                        </div>

                        <?php if ($this->tplData["cateRow"]["cate_parent_id"] < 1) { ?>
                            <div class="form-group">
                                <label class="control-label"><?php echo $this->lang["label"]["cateDomain"]; ?><span id="msg_cate_domain"></span></label>
                                <input type="text" name="cate_domain" id="cate_domain" value="<?php echo $this->tplData["cateRow"]["cate_domain"]; ?>" data-validate class="form-control">
                                <span class="help-block"><?php echo $this->lang["label"]["cateDomainNote"]; ?></span>
                            </div>
                        <?php } ?>

                        <div id="item_cate_content">
                            <div class="form-group">
                                <a class="btn btn-success" data-toggle="modal" href="#cate_modal">
                                    <span class="glyphicon glyphicon-picture"></span>
                                    <?php echo $this->lang["href"]["uploadList"]; ?>
                                </a>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo $this->lang["label"]["cateContent"]; ?></label>
                                <textarea name="cate_content" id="cate_content" class="tinymce bg-textarea-lg"><?php echo $this->tplData["cateRow"]["cate_content"]; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group" id="item_cate_link">
                            <div id="group_cate_link">
                                <label class="control-label"><?php echo $this->lang["label"]["cateLink"]; ?><span id="msg_cate_link"></span></label>
                                <input type="text" name="cate_link" id="cate_link" value="<?php echo $this->tplData["cateRow"]["cate_link"]; ?>" data-validate class="form-control">
                            </div>
                        </div>

                        <?php if (BG_MODULE_GEN > 0 && BG_MODULE_FTP > 0 && $this->tplData["cateRow"]["cate_parent_id"] < 1) { ?>
                            <div class="form-group">
                                <label for="more_checkbox" class="checkbox-inline">
                                    <input type="checkbox" id="more_checkbox" name="more_checkbox" <?php if (!fn_isEmpty($this->tplData["cateRow"]["cate_ftp_host"])) { ?>checked<?php } ?>>
                                    <?php echo $this->lang["label"]["more"]; ?>
                                </label>
                            </div>

                            <div id="more_input">
                                <div class="form-group">
                                    <label class="control-label"><?php echo $this->lang["label"]["cateFtpServ"]; ?><span id="msg_cate_ftp_host"></span></label>
                                    <input type="text" name="cate_ftp_host" id="cate_ftp_host" value="<?php echo $this->tplData["cateRow"]["cate_ftp_host"]; ?>" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label class="control-label"><?php echo $this->lang["label"]["cateFtpPort"]; ?><span id="msg_cate_ftp_port"></span></label>
                                    <input type="text" name="cate_ftp_port" id="cate_ftp_port" value="<?php echo $this->tplData["cateRow"]["cate_ftp_port"]; ?>" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label class="control-label"><?php echo $this->lang["label"]["cateFtpUser"]; ?><span id="msg_cate_ftp_user"></span></label>
                                    <input type="text" name="cate_ftp_user" id="cate_ftp_user" value="<?php echo $this->tplData["cateRow"]["cate_ftp_user"]; ?>" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label class="control-label"><?php echo $this->lang["label"]["cateFtpPass"]; ?><span id="msg_cate_ftp_pass"></span></label>
                                    <input type="text" name="cate_ftp_pass" id="cate_ftp_pass" value="<?php echo $this->tplData["cateRow"]["cate_ftp_pass"]; ?>" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label class="control-label"><?php echo $this->lang["label"]["cateFtpPath"]; ?><span id="msg_cate_ftp_path"></span></label>
                                    <input type="text" name="cate_ftp_path" id="cate_ftp_path" value="<?php echo $this->tplData["cateRow"]["cate_ftp_path"]; ?>" class="form-control">
                                    <span class="help-block"><?php echo $this->lang["label"]["cateFtpPathNote"]; ?></span>
                                </div>

                                <div class="form-group">
                                    <label class="control-label"><?php echo $this->lang["label"]["cateFtpPasv"]; ?><span id="msg_cate_ftp_pasv"></span></label>
                                    <?php foreach ($this->status["pasv"] as $key=>$value) { ?>
                                        <div class="bg-radio">
                                            <label for="cate_ftp_pasv_<?php echo $key; ?>">
                                                <input type="radio" name="cate_ftp_pasv" id="cate_ftp_pasv_<?php echo $key; ?>" value="<?php echo $key; ?>" <?php if ($this->tplData["cateRow"]["cate_ftp_pasv"] == $key) { ?>checked<?php } ?>>
                                                <?php echo $value; ?>
                                            </label>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="bg-submit-box"></div>
                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang["btn"]["submit"]; ?></button>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="well">
                    <?php if ($this->tplData["cateRow"]["cate_id"] > 0) { ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang["label"]["id"]; ?></label>
                            <div class="form-control-static"><?php echo $this->tplData["cateRow"]["cate_id"]; ?></div>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <div id="group_cate_parent_id">
                            <label class="control-label"><?php echo $this->lang["label"]["belongCate"]; ?><span id="msg_cate_parent_id">*</span></label>
                            <select name="cate_parent_id" id="cate_parent_id" data-validate class="form-control">
                                <option value=""><?php echo $this->lang["option"]["pleaseSelect"]; ?></option>
                                <option <?php if ($this->tplData["cateRow"]["cate_parent_id"] == 0) { ?>selected<?php } ?> value="0"><?php echo $this->lang["option"]["asCateParent"]; ?></option>
                                <?php cate_list_opt($this->tplData["cateRows"], $this->tplData["cateRow"]["cate_parent_id"]); ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="group_cate_tpl">
                            <label class="control-label"><?php echo $this->lang["label"]["tpl"]; ?><span id="msg_cate_tpl">*</span></label>
                            <select name="cate_tpl" id="cate_tpl" data-validate class="form-control">
                                <option value=""><?php echo $this->lang["option"]["pleaseSelect"]; ?></option>
                                <option <?php if (isset($this->tplData["cateRow"]["cate_tpl"]) && $this->tplData["cateRow"]["cate_tpl"] == "inherit") { ?>selected<?php } ?> value="inherit"><?php echo $this->lang["option"]["tplInherit"]; ?></option>
                                <?php foreach ($this->tplData["tplRows"] as $key=>$value) {
                                    if ($value["type"] == "dir") { ?>
                                        <option <?php if (isset($this->tplData["cateRow"]["cate_tpl"]) && $this->tplData["cateRow"]["cate_tpl"] == $value["name"]) { ?>selected<?php } ?> value="<?php echo $value["name"]; ?>"><?php echo $value["name"]; ?></option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="group_cate_type">
                            <label class="control-label"><?php echo $this->lang["label"]["cateType"]; ?><span id="msg_cate_type">*</span></label>
                            <?php foreach ($this->type["cate"] as $key=>$value) { ?>
                                <div class="bg-radio">
                                    <label for="cate_type_<?php echo $key; ?>">
                                        <input type="radio" name="cate_type" id="cate_type_<?php echo $key; ?>" value="<?php echo $key; ?>" <?php if ($this->tplData["cateRow"]["cate_type"] == $key) { ?>checked<?php } ?> data-validate="cate_type">
                                        <?php echo $value; ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="group_cate_status">
                            <label class="control-label"><?php echo $this->lang["label"]["cateStatus"]; ?><span id="msg_cate_status">*</span></label>
                            <?php foreach ($this->status["cate"] as $key=>$value) { ?>
                                <div class="bg-radio">
                                    <label for="cate_status_<?php echo $key; ?>">
                                        <input type="radio" name="cate_status" id="cate_status_<?php echo $key; ?>" value="<?php echo $key; ?>" <?php if ($this->tplData["cateRow"]["cate_status"] == $key) { ?>checked<?php } ?> data-validate="cate_status">
                                        <?php echo $value; ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="cate_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>

<?php include($cfg["pathInclude"] . "console_foot.php"); ?>

    <script type="text/javascript">
    var opts_validator_form = {
        cate_name: {
            len: { min: 1, max: 300 },
            validate: { type: "ajax", format: "text", group: "#group_cate_name" },
            msg: { selector: "#msg_cate_name", too_short: "<?php echo $this->rcode["x250201"]; ?>", too_long: "<?php echo $this->rcode["x250202"]; ?>", ajaxIng: "<?php echo $this->rcode["x030401"]; ?>", ajax_err: "<?php echo $this->rcode["x030402"]; ?>" },
            ajax: { url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=cate&act=chkname", key: "cate_name", type: "str", attach_selectors: ["#cate_id","#cate_parent_id"], attach_keys: ["cate_id","cate_parent_id"] }
        },
        cate_alias: {
            len: { min: 0, max: 300 },
            validate: { type: "ajax", format: "alias", group: "#group_cate_alias" },
            msg: { selector: "#msg_cate_alias", too_long: "<?php echo $this->rcode["x250204"]; ?>", format_err: "<?php echo $this->rcode["x250205"]; ?>", ajaxIng: "<?php echo $this->rcode["x030401"]; ?>", ajax_err: "<?php echo $this->rcode["x030402"]; ?>" },
            ajax: { url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=cate&act=chkalias", key: "cate_alias", type: "str", attach_selectors: ["#cate_id","#cate_parent_id"], attach_keys: ["cate_id","cate_parent_id"] }
        },
        cate_link: {
            len: { min: 0, max: 3000 },
            validate: { type: "str", format: "text", group: "#group_cate_link" },
            msg: { selector: "#msg_cate_link", too_long: "<?php echo $this->rcode["x250211"]; ?>" }
        },
        cate_parent_id: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_cate_parent_id" },
            msg: { selector: "#msg_cate_parent_id", too_few: "<?php echo $this->rcode["x250213"]; ?>" }
        },
        cate_tpl: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_cate_tpl" },
            msg: { selector: "#msg_cate_tpl", too_few: "<?php echo $this->rcode["x250214"]; ?>" }
        },
        cate_type: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='cate_type']", type: "radio", group: "#group_cate_type" },
            msg: { selector: "#msg_cate_type", too_few: "<?php echo $this->rcode["x250215"]; ?>" }
        },
        cate_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='cate_status']", type: "radio", group: "#group_cate_status" },
            msg: { selector: "#msg_cate_status", too_few: "<?php echo $this->rcode["x250216"]; ?>" }
        },
        cate_domain: {
            len: { min: 0, max: 3000 },
            validate: { type: "str", format: "text" },
            msg: { selector: "#msg_cate_domain", too_long: "<?php echo $this->rcode["x250207"]; ?>", format_err: "<?php echo $this->rcode["x250208"]; ?>" }
        },
        cate_perpage: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "int", group: "#group_cate_perpage" },
            msg: { selector: "#msg_cate_perpage", too_short: "<?php echo $this->rcode["x250223"]; ?>", format_err: "<?php echo $this->rcode["x250224"]; ?>" }
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=cate",
        msg_text: {
            submitting: "<?php echo $this->lang["label"]["submitting"]; ?>"
        }
    };

    function cate_type(cate_type) {
        switch (cate_type) {
            case "single":
                $("#item_cate_perpage").hide();
                $("#item_cate_content").show();
                $("#item_cate_link").hide();
            break;

            case "link":
                $("#item_cate_perpage").hide();
                $("#item_cate_content").hide();
                $("#item_cate_link").show();
            break;

            case "normal":
                $("#item_cate_perpage").show();
                $("#item_cate_content").show();
                $("#item_cate_link").hide();
            break;

            default:
                $("#item_cate_perpage").show();
                $("#item_cate_content").show();
                $("#item_cate_link").hide();
            break;
        }
    }

    function show_more() {
        if ($("#more_checkbox").prop("checked")) {
            var _cate_parent = $("#cate_parent_id").val();
            if (_cate_parent < 1) {
                $("#more_input").show();
            } else {
                $("#more_input").hide();
            }
        } else {
            $("#more_input").hide();
        }
    }

    $(document).ready(function(){
        cate_type("<?php echo $this->tplData["cateRow"]["cate_type"]; ?>");
        show_more();
        $("#cate_modal").on("shown.bs.modal", function() {
            $("#cate_modal .modal-content").load("<?php echo BG_URL_CONSOLE; ?>index.php?mod=attach&act=form&view=iframe");
        });
        $("#cate_parent_id").change(function(){
            show_more();
        });
        var obj_validate_form  = $("#cate_form").baigoValidator(opts_validator_form);
        var obj_submit_form    = $("#cate_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            tinyMCE.triggerSave();
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });

        $("#more_checkbox").click(function(){
            show_more();
        });

        $("input[name='cate_type']").click(function(){
            var _cate_type = $(this).val();
            cate_type(_cate_type);
        });
    });
    </script>

<?php include($cfg["pathInclude"] . "html_foot.php"); ?>