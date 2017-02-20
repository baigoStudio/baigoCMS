<?php if ($this->tplData["linkRow"]["link_id"] < 1) {
    $title_sub  = $this->lang["page"]["add"];
} else {
    $title_sub = $this->lang["page"]["edit"];
}

$cfg = array(
    "title"          => $this->consoleMod["link"]["sub"]["list"]["title"] . " &raquo; " . $title_sub,
    "menu_active"    => "link",
    "sub_active"     => "list",
    "baigoValidator" => "true",
    "baigoSubmit"    => "true",
    "pathInclude"    => BG_PATH_TPLSYS . "console/default/include/",
    "str_url"        => BG_URL_CONSOLE . "index.php?mod=link"
);

include($cfg["pathInclude"] . "function.php");
include($cfg["pathInclude"] . "console_head.php"); ?>

    <div class="form-group clearfix">
        <div class="pull-left">
            <div class="form-group">
                <ul class="nav nav-pills bg-nav-pills">
                    <li>
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=link&act=list">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                            <?php echo $this->lang["href"]["back"]; ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=link" target="_blank">
                            <span class="glyphicon glyphicon-question-sign"></span>
                            <?php echo $this->lang["href"]["help"]; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <form name="link_form" id="link_form">
        <input type="hidden" name="<?php echo $this->common["tokenRow"]["name_session"]; ?>" value="<?php echo $this->common["tokenRow"]["token"]; ?>">
        <input type="hidden" name="link_id" id="link_id" value="<?php echo $this->tplData["linkRow"]["link_id"]; ?>">
        <input type="hidden" name="act" value="submit">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div id="group_link_name">
                                <label class="control-label"><?php echo $this->lang["label"]["linkName"]; ?><span id="msg_link_name">*</span></label>
                                <input type="text" name="link_name" id="link_name" value="<?php echo $this->tplData["linkRow"]["link_name"]; ?>" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_link_url">
                                <label class="control-label"><?php echo $this->lang["label"]["linkUrl"]; ?><span id="msg_link_url">*</span></label>
                                <input type="text" name="link_url" id="link_url" value="<?php echo $this->tplData["linkRow"]["link_url"]; ?>" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_link_cate_id">
                                <label class="control-label"><?php echo $this->lang["label"]["belongCate"]; ?><span id="msg_link_cate_id">*</span></label>
                                <select name="link_cate_id" id="link_cate_id" data-validate class="form-control">
                                    <option value=""><?php echo $this->lang["option"]["pleaseSelect"]; ?></option>
                                    <option <?php if ($this->tplData["linkRow"]["link_cate_id"] == 0) { ?>selected<?php } ?> value="0"><?php echo $this->lang["option"]["allCate"]; ?></option>
                                    <?php cate_list_opt($this->tplData["cateRows"], $this->tplData["linkRow"]["link_cate_id"]); ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label for="link_blank">
                                    <input type="checkbox" id="link_blank" name="link_blank" <?php if ($this->tplData["linkRow"]["link_blank"] > 0) { ?>checked<?php } ?> value="1">
                                    <?php echo $this->lang["label"]["isBlank"]; ?>
                                </label>
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
                    <?php if ($this->tplData["linkRow"]["link_id"] > 0) { ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang["label"]["id"]; ?></label>
                            <div class="form-control-static"><?php echo $this->tplData["linkRow"]["link_id"]; ?></div>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <div id="group_link_type">
                            <label class="control-label"><?php echo $this->lang["label"]["type"]; ?><span id="msg_link_type">*</span></label>
                            <?php foreach ($this->type["link"] as $key=>$value) { ?>
                                <div class="bg-radio">
                                    <label for="link_type_<?php echo $key; ?>">
                                        <input type="radio" name="link_type" id="link_type_<?php echo $key; ?>" value="<?php echo $key; ?>" <?php if ($this->tplData["linkRow"]["link_type"] == $key) { ?>checked<?php } ?> data-validate="link_type">
                                        <?php echo $value; ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="group_link_status">
                            <label class="control-label"><?php echo $this->lang["label"]["status"]; ?><span id="msg_link_status">*</span></label>
                            <?php foreach ($this->status["link"] as $key=>$value) { ?>
                                <div class="bg-radio">
                                    <label for="link_status_<?php echo $key; ?>">
                                        <input type="radio" name="link_status" id="link_status_<?php echo $key; ?>" value="<?php echo $key; ?>" <?php if ($this->tplData["linkRow"]["link_status"] == $key) { ?>checked<?php } ?> data-validate="link_status">
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

<?php include($cfg["pathInclude"] . "console_foot.php"); ?>

    <script type="text/javascript">
    var opts_validator_form = {
        link_name: {
            len: { min: 1, max: 300 },
            validate: { type: "str", format: "text", group: "#group_link_name" },
            msg: { selector: "#msg_link_name", too_short: "<?php echo $this->rcode["x240201"]; ?>", too_long: "<?php echo $this->rcode["x240202"]; ?>" }
        },
        link_url: {
            len: { min: 1, max: 900 },
            validate: { type: "str", format: "url", group: "#group_link_url" },
            msg: { selector: "#msg_link_url", too_short: "<?php echo $this->rcode["x240203"]; ?>", too_long: "<?php echo $this->rcode["x240204"]; ?>", format_err: "<?php echo $this->rcode["x240205"]; ?>" }
        },
        link_type: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='link_type']", type: "radio", group: "#group_link_type" },
            msg: { selector: "#msg_link_type", too_few: "<?php echo $this->rcode["x240206"]; ?>" }
        },
        link_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='link_status']", type: "radio", group: "#group_link_status" },
            msg: { selector: "#msg_link_status", too_few: "<?php echo $this->rcode["x240207"]; ?>" }
        },
        link_cate_id: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_link_cate_id" },
            msg: { selector: "#msg_link_cate_id", too_few: "<?php echo $this->rcode["x240208"]; ?>" }
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=link",
        msg_text: {
            submitting: "<?php echo $this->lang["label"]["submitting"]; ?>"
        }
    };

    $(document).ready(function(){
        var obj_validate_form = $("#link_form").baigoValidator(opts_validator_form);
        var obj_submit_form   = $("#link_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
    });
    </script>

<?php include($cfg["pathInclude"] . "html_foot.php"); ?>