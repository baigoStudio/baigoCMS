<?php function opt_form_process($arr_formList, $tplRows = array(), $timezoneRows = array(), $timezoneType = "", $timezoneJson = "", $lang = array(), $rcode = array()) {
    $_str_json = "var opts_validator_form = {";

    foreach ($arr_formList as $key=>$value) {
        //form
        if (defined($key)) {
            $this_value = constant($key);
        } else {
            $this_value = $value["default"];
        } ?>
        <div class="form-group">
            <div id="group_<?php echo $GLOBALS["act"]; ?>_<?php echo $key; ?>">
                <label class="control-label"><?php echo $value["label"]; ?><span id="msg_<?php echo $GLOBALS["act"]; ?>_<?php echo $key; ?>"><?php if ($value["min"] > 0) { ?>*<?php } ?></span></label>

                <?php switch($value["type"]) {
                    case "select": ?>
                        <select name="opt[<?php echo $GLOBALS["act"]; ?>][<?php echo $key; ?>]" id="opt_<?php echo $GLOBALS["act"]; ?>_<?php echo $key; ?>" data-validate="opt_<?php echo $GLOBALS["act"]; ?>_<?php echo $key; ?>" class="form-control">
                            <?php foreach ($value["option"] as $key_opt=>$value_opt) { ?>
                                <option<?php if ($this_value == $key_opt) { ?> selected<?php } ?> value="<?php echo $key_opt; ?>"><?php echo $value_opt; ?></option>
                            <?php } ?>
                        </select>
                    <?php break;

                    case "radio":
                        foreach ($value["option"] as $key_opt=>$value_opt) { ?>
                            <div class="bg-radio">
                                <label for="opt_<?php echo $GLOBALS["act"]; ?>_<?php echo $key; ?>_<?php echo $key_opt; ?>">
                                    <input type="radio"<?php if ($this_value == $key_opt) { ?> checked<?php } ?> value="<?php echo $key_opt; ?>" data-validate="opt_<?php echo $GLOBALS["act"]; ?>_<?php echo $key; ?>" name="opt[<?php echo $GLOBALS["act"]; ?>][<?php echo $key; ?>]" id="opt_<?php echo $GLOBALS["act"]; ?>_<?php echo $key; ?>_<?php echo $key_opt; ?>">
                                    <?php echo $value_opt["value"]; ?>
                                </label>
                            </div>
                            <?php if (isset($value_opt["note"]) && !fn_isEmpty($value_opt["note"])) { ?>
                                <span class="help-block"><?php echo $value_opt["note"]; ?></span>
                            <?php }
                        }
                    break;

                    case "textarea":  ?>
                        <textarea name="opt[<?php echo $GLOBALS["act"]; ?>][<?php echo $key; ?>]" id="opt_<?php echo $GLOBALS["act"]; ?>_<?php echo $key; ?>" data-validate="opt_<?php echo $GLOBALS["act"]; ?>_<?php echo $key; ?>" class="form-control bg-textarea-md"><?php echo $this_value; ?></textarea>
                    <?php break;

                    default:  ?>
                        <input type="text" value="<?php echo $this_value; ?>" name="opt[<?php echo $GLOBALS["act"]; ?>][<?php echo $key; ?>]" id="opt_<?php echo $GLOBALS["act"]; ?>_<?php echo $key; ?>" data-validate="opt_<?php echo $GLOBALS["act"]; ?>_<?php echo $key; ?>" class="form-control">
                    <?php break;
                }

                if (isset($value["note"]) && !fn_isEmpty($value["note"])) {  ?>
                    <span class="help-block"><?php echo $value["note"]; ?></span>
                <?php } ?>
            </div>
        </div>

        <?php //json
        if ($value["type"] == "str" || $value["type"] == "textarea") {
            $str_msg_min = "too_short";
            $str_msg_max = "too_long";
        } else {
            $str_msg_min = "too_few";
            $str_msg_max = "too_many";
        }
        $_str_json .= "opt_" . $GLOBALS["act"] . "_" . $key . ": {
            len: { min: " . $value["min"] . ", max: 900 },
            validate: { selector: \"[data-validate='opt_" . $GLOBALS["act"] . "_" . $key . "']\", type: \"" . $value["type"] . "\",";
            if (isset($value["format"])) {
                $_str_json .= " format: \"" . $value["format"] . "\",";
            }
            $_str_json .= " group: \"#opt_" . $GLOBALS["act"] . "_" . $key . "\" },
            msg: { selector: \"#msg_" . $GLOBALS["act"] . "_" . $key . "\", " . $str_msg_min . ": \"" . $rcode["x040201"] . $value["label"] . "\", " . $str_msg_max . ": \"" . $value["label"] . $rcode["x040202"] . "\", format_err: \"" . $value["label"] . $rcode["x040203"] . "\" }
        }";
        if ($value != end($arr_formList)) {
            $_str_json .= ",";
        }
    }

    $_str_json .= "};";

    if ($GLOBALS["act"] == "base") { ?>
        <div class="form-group">
            <div id="group_base_BG_SITE_TPL">
                <label class="control-label"><?php echo $lang["label"]["tpl"]; ?><span id="msg_base_BG_SITE_TPL">*</span></label>
                <select name="opt[base][BG_SITE_TPL]" id="opt_base_BG_SITE_TPL" data-validate class="form-control">
                    <?php foreach ($tplRows as $key=>$value) {
                        if ($value["type"] == "dir") { ?>
                            <option<?php if (BG_SITE_TPL == $value["name"]) {  ?> selected<?php } ?> value="<?php echo $value["name"]; ?>"><?php echo $value["name"]; ?></option>
                        <?php }
                   } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div id="group_base_BG_SITE_TIMEZONE">
                <label class="control-label"><?php echo $lang["label"]["timezone"]; ?><span id="msg_base_BG_SITE_TIMEZONE">*</span></label>
                <div class="row">
                    <div class="col-xs-6">
                        <select name="timezone_type" id="timezone_type" class="form-control">
                            <?php foreach ($timezoneRows as $key=>$value) { ?>
                                <option<?php if ($timezoneType == $key) { ?> selected<?php } ?> value="<?php echo $key; ?>"><?php echo $value["title"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-xs-6">
                        <select name="opt[base][BG_SITE_TIMEZONE]" id="opt_base_BG_SITE_TIMEZONE" data-validate class="form-control">
                            <?php foreach ($timezoneRows[$timezoneType]["sub"] as $key=>$value) { ?>
                                <option<?php if (BG_SITE_TIMEZONE == $key) { ?> selected<?php } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $_str_json .= "opts_validator_form.opt_base_BG_SITE_TPL = {
            len: { min: 1, max: 0 },
            validate: { type: \"select\", group: \"#opt_base_BG_SITE_TPL\" },
            msg: { selector: \"#msg_base_BG_SITE_TPL\", too_few: \"" . $rcode["x040201"] . $lang["label"]["tpl"] . "\" }
        };
        opts_validator_form.opt_base_BG_SITE_TIMEZONE = {
            len: { min: 1, max: 0 },
            validate: { type: \"select\", group: \"#opt_base_BG_SITE_TIMEZONE\" },
            msg: { selector: \"#msg_base_BG_SITE_TIMEZONE\", too_few: \"" . $rcode["x040201"] . $lang["label"]["timezone"] . "\" }
        };
        var _timezoneJson = " . $timezoneJson . ";";
    }

    return array(
        "json" => $_str_json,
    );
}