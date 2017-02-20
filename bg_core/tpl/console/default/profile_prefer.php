<?php $cfg = array(
    "title"          => $this->lang["page"]["profile"] . " &raquo; " . $this->type["profile"]["prefer"]["title"],
    "menu_active"    => "profile",
    "sub_active"     => "prefer",
    "baigoValidator" => "true",
    "baigoSubmit"    => "true",
    "pathInclude"    => BG_PATH_TPLSYS . "console/default/include/",
    "str_url"        => BG_URL_CONSOLE . "index.php?mod=profile&act=prefer"
);

include($cfg["pathInclude"] . "function.php");
include($cfg["pathInclude"] . "console_head.php"); ?>

    <div class="form-group">
        <ul class="nav nav-pills bg-nav-pills">
            <?php include($cfg["pathInclude"] . "profile_menu.php"); ?>
        </ul>
    </div>

    <form name="profile_form" id="profile_form">
        <input type="hidden" name="<?php echo $this->common["tokenRow"]["name_session"]; ?>" value="<?php echo $this->common["tokenRow"]["token"]; ?>">
        <input type="hidden" name="act" value="prefer">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang["label"]["username"]; ?></label>
                            <input type="text" class="form-control" readonly value="<?php echo $this->tplData["ssoRow"]["user_name"]; ?>">
                        </div>

                        <?php foreach ($this->tplData["prefer"] as $key=>$value) { ?>
                            <div>
                                <hr>
                                <h4><?php echo $value["title"]; ?></h4>
                                <?php foreach ($value["list"] as $key_s=>$value_s) { ?>
                                    <div class="form-group">
                                        <div id="group_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>">
                                            <label class="control-label"><?php echo $value_s["label"]; ?><span id="msg_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>"></span></label>
                                            <?php switch($value_s["type"]) {
                                                case "select": ?>
                                                    <select name="prefer[<?php echo $key; ?>][<?php echo $key_s; ?>]" id="prefer_<?php echo $key; ?>_<?php echo $key_s; ?>" data-validate="prefer_<?php echo $key; ?>_<?php echo $key_s; ?>" class="form-control">
                                                        <?php foreach ($value_s["option"] as $key_opt=>$value_opt) { ?>
                                                            <option <?php if ($value_s["default"] == $key_opt) { ?>selected<?php } ?> value="<?php echo $key_opt; ?>"><?php echo $value_opt; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                <?php
                                                break;

                                                case "radio":
                                                    foreach ($value_s["option"] as $key_opt=>$value_opt) { ?>
                                                        <div class="bg-radio">
                                                            <label for="prefer_<?php echo $key; ?>_<?php echo $key_s; ?>_<?php echo $key_opt; ?>" class="radio-inline">
                                                                <input type="radio" <?php if ($value_s["default"] == $key_opt) { ?>checked<?php } ?> value="<?php echo $key_opt; ?>" data-validate="prefer_<?php echo $key; ?>_<?php echo $key_s; ?>" name="prefer[<?php echo $key; ?>][<?php echo $key_s; ?>]" id="prefer_<?php echo $key; ?>_<?php echo $key_s; ?>_<?php echo $key_opt; ?>">
                                                                <?php echo $value_opt["value"]; ?>
                                                            </label>
                                                        </div>
                                                        <?php if (isset($value_opt["note"])) { ?><span class="help-block"><?php echo $value_opt["note"]; ?></span><?php }
                                                    }
                                                break;

                                                case "textarea": ?>
                                                    <textarea name="prefer[<?php echo $key; ?>][<?php echo $key_s; ?>]" id="prefer_<?php echo $key; ?>_<?php echo $key_s; ?>" data-validate="prefer_<?php echo $key; ?>_<?php echo $key_s; ?>" class="form-control bg-textarea-md"><?php echo $value_s["default"]; ?></textarea>
                                                <?php
                                                break;

                                                default: ?>
                                                    <input type="text" value="<?php echo $value_s["default"]; ?>" name="prefer[<?php echo $key; ?>][<?php echo $key_s; ?>]" id="prefer_<?php echo $key; ?>_<?php echo $key_s; ?>" data-validate="prefer_<?php echo $key; ?>_<?php echo $key_s; ?>" class="form-control">
                                                <?php
                                                break;
                                            }

                                            if (isset($value_s["note"])) { ?><span class="help-block"><?php echo $value_s["note"]; ?></span><?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>

                        <div class="bg-submit-box"></div>
                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang["btn"]["save"]; ?></button>
                    </div>
                </div>
            </div>

            <?php include($cfg["pathInclude"] . "profile_side.php"); ?>
        </div>

    </form>

<?php include($cfg["pathInclude"] . "console_foot.php"); ?>

    <script type="text/javascript">
    var opts_validator_form = {
        <?php foreach ($this->tplData["prefer"] as $key=>$value) {
            foreach ($value["list"] as $key_s=>$value_s) {
                if ($value_s["type"] == "str" || $value_s["type"] == "textarea") {
                    $str_msg_min = "too_short";
                    $str_msg_max = "too_long";
                } else {
                    $str_msg_min = "too_few";
                    $str_msg_max = "too_many";
                } ?>
                prefer_<?php echo $key; ?>_<?php echo $key_s; ?>: {
                    len: { min: <?php echo $value_s["min"]; ?>, max: 900 },
                    validate: { selector: "[data-validate='prefer_<?php echo $key; ?>_<?php echo $key_s; ?>']", type: "<?php echo $value_s["type"]; ?>", <?php if (isset($value_s["format"])) { ?>format: "<?php echo $value_s["format"]; ?>", <?php } ?>group: "#group_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>" },
                    msg: { selector: "#msg_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>", <?php echo $str_msg_min; ?>: "<?php echo $this->rcode["x060201"] . $value_s["label"]; ?>", <?php echo $str_msg_max; ?>: "<?php echo $value_s["label"] . $this->rcode["x060202"]; ?>", format_err: "<?php echo $value_s["label"] . $this->rcode["x060203"]; ?>" }
                }<?php if ($value != end($this->tplData["prefer"]) || $value_s != end($value["list"])) { ?>,<?php }
            }
        } ?>
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=profile",
        msg_text: {
            submitting: "<?php echo $this->lang["label"]["submitting"]; ?>"
        }
    };

    $(document).ready(function(){
        var obj_validate_form = $("#profile_form").baigoValidator(opts_validator_form);
        var obj_submit_form   = $("#profile_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
    });
    </script>

<?php include($cfg["pathInclude"] . "html_foot.php"); ?>