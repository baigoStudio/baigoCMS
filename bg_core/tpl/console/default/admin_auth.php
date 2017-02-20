<?php $cfg = array(
    "title"          => $this->consoleMod["admin"]["main"]["title"] . " &raquo; " . $this->lang["page"]["auth"],
    "menu_active"    => "admin",
    "sub_active"     => "auth",
    "baigoCheckall"  => "true",
    "baigoValidator" => "true",
    "baigoSubmit"    => "true",
    "pathInclude"    => BG_PATH_TPLSYS . "console/default/include/",
    "str_url"        => BG_URL_CONSOLE . "index.php?mod=admin",
);

include($cfg["pathInclude"] . "function.php");
include($cfg["pathInclude"] . "console_head.php"); ?>

    <div class="form-group">
        <ul class="nav nav-pills bg-nav-pills">
            <li>
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=admin&act=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <?php echo $this->lang["href"]["back"]; ?>
                </a>
            </li>
            <li>
                <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=admin#auth" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    <?php echo $this->lang["href"]["help"]; ?>
                </a>
            </li>
        </ul>
    </div>

    <form name="admin_form" id="admin_form">
        <input type="hidden" name="<?php echo $this->common["tokenRow"]["name_session"]; ?>" value="<?php echo $this->common["tokenRow"]["token"]; ?>">
        <input type="hidden" name="act" value="auth">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div id="group_admin_name">
                                <label class="control-label"><?php echo $this->lang["label"]["username"]; ?><span id="msg_admin_name">*</span></label>
                                <input type="text" name="admin_name" id="admin_name" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_admin_nick">
                                <label class="control-label"><?php echo $this->lang["label"]["nick"]; ?><span id="msg_admin_nick"></span></label>
                                <input type="text" name="admin_nick" id="admin_nick" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang["label"]["cateAllow"]; ?></label>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="bg-checkbox">
                                                <label for="chk_all">
                                                    <input type="checkbox" id="chk_all" data-parent="first">
                                                    <?php echo $this->lang["label"]["all"]; ?>
                                                </label>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php cate_list_allow($this->tplData["cateRows"], $this->lang); ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group">
                            <div id="group_admin_note">
                                <label class="control-label"><?php echo $this->lang["label"]["note"]; ?><span id="msg_admin_note"></span></label>
                                <input type="text" name="admin_note" id="admin_note" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="bg-submit-box"></div>
                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang["btn"]["submit"]; ?></button>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="well">
                    <div class="form-group">
                        <div id="group_admin_type">
                            <label class="control-label"><?php echo $this->lang["label"]["type"]; ?><span id="msg_admin_type">*</span></label>
                            <?php foreach ($this->type["admin"] as $key=>$value) { ?>
                                <div class="bg-radio">
                                    <label for="admin_type_<?php echo $key; ?>">
                                        <input type="radio" name="admin_type" id="admin_type_<?php echo $key; ?>" value="<?php echo $key; ?>" <?php if ($this->tplData["adminRow"]["admin_type"] == $key) { ?>checked<?php } ?> data-validate="admin_type">
                                        <?php echo $value; ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="group_admin_status">
                            <label class="control-label"><?php echo $this->lang["label"]["status"]; ?><span id="msg_admin_status">*</span></label>
                            <?php foreach ($this->status["admin"] as $key=>$value) { ?>
                                <div class="bg-radio">
                                    <label for="admin_status_<?php echo $key; ?>">
                                        <input type="radio" name="admin_status" id="admin_status_<?php echo $key; ?>" value="<?php echo $key; ?>" <?php if ($this->tplData["adminRow"]["admin_status"] == $key) { ?>checked<?php } ?> data-validate="admin_status">
                                        <?php echo $value; ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang["label"]["profileAllow"]; ?></label>
                        <?php foreach ($this->type["profile"] as $_key=>$_value) { ?>
                            <div class="bg-checkbox">
                                <label for="admin_allow_profile_<?php echo $_key; ?>">
                                    <input type="checkbox" name="admin_allow_profile[<?php echo $_key; ?>]" id="admin_allow_profile_<?php echo $_key; ?>" value="1">
                                    <?php echo $this->lang["label"]["forbidModi"] . $_value["title"]; ?>
                                </label>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

    </form>

<?php include($cfg["pathInclude"] . "console_foot.php"); ?>

    <script type="text/javascript">
    var opts_validator_form = {
        admin_name: {
            len: { min: 1, max: 0 },
            validate: { type: "ajax", format: "strDigit", group: "#group_admin_name" },
            msg: { selector: "#msg_admin_name", too_short: "<?php echo $this->rcode["x010201"]; ?>", too_long: "<?php echo $this->rcode["x010202"]; ?>", format_err: "<?php echo $this->rcode["x010203"]; ?>", ajaxIng: "<?php echo $this->rcode["x030401"]; ?>", ajax_err: "<?php echo $this->rcode["x030402"]; ?>" },
            ajax: { url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=admin&act=chkauth", key: "admin_name", type: "str" }
        },
        admin_nick: {
            len: { min: 0, max: 30 },
            validate: { type: "str", format: "text", group: "#group_admin_nick" },
            msg: { selector: "#msg_admin_nick", too_long: "<?php echo $this->rcode["x020216"]; ?>" }
        },
        admin_note: {
            len: { min: 0, max: 30 },
            validate: { type: "str", format: "text", group: "#group_admin_note" },
            msg: { selector: "#msg_admin_note", too_long: "<?php echo $this->rcode["x020212"]; ?>" }
        },
        admin_type: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='admin_type']", type: "radio", group: "#group_admin_type" },
            msg: { selector: "#msg_admin_type", too_few: "<?php echo $this->rcode["x020219"]; ?>" }
        },
        admin_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='admin_status']", type: "radio", group: "#group_admin_status" },
            msg: { selector: "#msg_admin_status", too_few: "<?php echo $this->rcode["x020213"]; ?>" }
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=admin",
        msg_text: {
            submitting: "<?php echo $this->lang["label"]["submitting"]; ?>"
        }
    };

    $(document).ready(function(){
        var obj_validate_form  = $("#admin_form").baigoValidator(opts_validator_form);
        var obj_submit_form    = $("#admin_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
        $("#admin_form").baigoCheckall();
    });
    </script>

<?php include($cfg["pathInclude"] . "html_foot.php"); ?>