<?php function cate_list_opt($arr_cateRows, $cate_Id = 0, $is_disable = false) {
    if (!fn_isEmpty($arr_cateRows)) {
        foreach ($arr_cateRows as $key=>$value) { ?>
            <option value="<?php echo $value["cate_id"]; ?>"<?php if ($cate_Id == $value["cate_id"]) { ?> selected<?php } ?><?php if ($is_disable && $value["cate_type"] != "normal") { ?> disabled<?php } ?>>
                <?php if ($value["cate_level"] > 1) {
                    for ($_i = 1; $_i < $value["cate_level"]; $_i++) { ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                    <?php }
                }
                echo $value["cate_name"]; ?>
            </option>

            <?php if (isset($value["cate_childs"]) && !fn_isEmpty($value["cate_childs"])) {
                cate_list_opt($value["cate_childs"], $cate_Id, $is_disable);
            }
        }
    }
}

function allow_list($arr_consoleMod, $arr_opt, $lang = array(), $group_allow = array(), $is_edit = true) { ?>
    <dl class="bg-dl">
        <?php if ($is_edit) { ?>
            <dd>
                <div class="bg-checkbox">
                    <label for="chk_all">
                        <input type="checkbox" id="chk_all" data-parent="first">
                        <?php echo $lang["label"]["all"]; ?>
                    </label>
                </div>
            </dd>
        <?php }

        foreach ($arr_consoleMod as $key_m=>$value_m) { ?>
            <dt><?php echo $value_m["main"]["title"]; ?></dt>
            <dd>
                <?php if ($is_edit) { ?>
                    <label for="allow_<?php echo $key_m; ?>" class="checkbox-inline">
                        <input type="checkbox" id="allow_<?php echo $key_m; ?>" data-parent="chk_all">
                        <?php echo $lang["label"]["all"]; ?>
                    </label>
                <?php }

                foreach ($value_m["allow"] as $key_s=>$value_s) {
                    if ($is_edit) { ?>
                        <label for="allow_<?php echo $key_m; ?>_<?php echo $key_s; ?>" class="checkbox-inline">
                            <input type="checkbox" name="group_allow[<?php echo $key_m; ?>][<?php echo $key_s; ?>]" value="1" id="allow_<?php echo $key_m; ?>_<?php echo $key_s; ?>" <?php if (isset($group_allow[$key_m][$key_s])) { ?>checked<?php } ?> data-parent="allow_<?php echo $key_m; ?>">
                            <?php echo $value_s; ?>
                        </label>
                    <?php } else { ?>
                        <span>
                            <span class="glyphicon glyphicon-<?php if (isset($group_allow[$key_m][$key_s])) { ?>ok-sign text-success<?php } else { ?>remove-sign text-danger<?php } ?>"></span>
                            <?php echo $value_s; ?>
                        </span>
                    <?php }
                } ?>
            </dd>
        <?php } ?>

        <dt><?php echo $lang["label"]["opt"]; ?></dt>
        <dd>
            <?php if ($is_edit) { ?>
                <label for="allow_opt" class="checkbox-inline">
                    <input type="checkbox" id="allow_opt" data-parent="chk_all">
                    <?php echo $lang["label"]["all"]; ?>
                </label>
            <?php }

            foreach ($arr_opt as $key_s=>$value_s) {
                if ($is_edit) { ?>
                    <label for="allow_opt_<?php echo $key_s; ?>" class="checkbox-inline">
                        <input type="checkbox" name="group_allow[opt][<?php echo $key_s; ?>]" value="1" id="allow_opt_<?php echo $key_s; ?>" data-parent="allow_opt" <?php if (isset($group_allow["opt"][$key_s])) { ?>checked<?php } ?>>
                        <?php echo $value_s["title"]; ?>
                    </label>
                <?php } else { ?>
                    <span>
                        <span class="glyphicon glyphicon-<?php if (isset($group_allow["opt"][$key_s])) { ?>ok-sign text-success<?php } else { ?>remove-sign text-danger<?php } ?>"></span>
                        <?php echo $value_s["title"]; ?>
                    </span>
                <?php }
            }

            if ($is_edit) { ?>
                <label for="allow_opt_app" class="checkbox-inline">
                    <input type="checkbox" name="group_allow[opt][app]" value="1" id="allow_opt_app" data-parent="allow_opt" <?php if (isset($group_allow["opt"]["app"])) { ?>checked<?php } ?>>
                    <?php echo $lang["page"]["app"]; ?>
                </label>
                <label for="allow_opt_dbconfig" class="checkbox-inline">
                    <input type="checkbox" name="group_allow[opt][dbconfig]" value="1" id="allow_opt_dbconfig" data-parent="allow_opt" <?php if (isset($group_allow["opt"]["dbconfig"])) { ?>checked<?php } ?>>
                    <?php echo $lang["page"]["setupDbConfig"]; ?>
                </label>
                <label for="allow_opt_chkver" class="checkbox-inline">
                    <input type="checkbox" name="group_allow[opt][chkver]" value="1" id="allow_opt_chkver" data-parent="allow_opt" <?php if (isset($group_allow["opt"]["chkver"])) { ?>checked<?php } ?>>
                    <?php echo $lang["page"]["chkver"]; ?>
                </label>
            <?php } else { ?>
                <span>
                    <span class="glyphicon glyphicon-<?php if (isset($group_allow["opt"]["app"])) { ?>ok-sign text-success<?php } else { ?>remove-sign text-danger<?php } ?>"></span>
                    <?php echo $lang["page"]["app"]; ?>
                </span>
                <span>
                    <span class="glyphicon glyphicon-<?php if (isset($group_allow["opt"]["dbconfig"])) { ?>ok-sign text-success<?php } else { ?>remove-sign text-danger<?php } ?>"></span>
                    <?php echo $lang["page"]["setupDbConfig"]; ?>
                </span>
                <span>
                    <span class="glyphicon glyphicon-<?php if (isset($group_allow["opt"]["chkver"])) { ?>ok-sign text-success<?php } else { ?>remove-sign text-danger<?php } ?>"></span>
                    <?php echo $lang["page"]["chkver"]; ?>
                </span>
            <?php } ?>
        </dd>
    </dl>
<?php }

function cate_list_allow($arr_cateRows, $lang = array(), $admin_allow_cate = array(), $group_allow_article = array(), $admin_type = "", $is_edit = true) {
    if (!fn_isEmpty($arr_cateRows)) {
        foreach ($arr_cateRows as $key=>$value) { ?>
            <tr>
                <td class="bg-child-<?php echo $value["cate_level"]; ?>">
                    <div><strong><?php echo $value["cate_name"]; ?></strong></div>
                    <div>
                        <?php if ($is_edit) { ?>
                            <label for="cate_<?php echo $value["cate_id"]; ?>" class="checkbox-inline">
                                <input type="checkbox" id="cate_<?php echo $value["cate_id"]; ?>" data-parent="chk_all">
                                <?php echo $lang["label"]["all"]; ?>
                            </label>
                        <?php }

                        foreach ($lang["allow"] as $key_s=>$value_s) {
                            if ($is_edit) { ?>
                                <label for="cate_<?php echo $value["cate_id"]; ?>_<?php echo $key_s; ?>" class="checkbox-inline">
                                    <input type="checkbox" name="admin_allow_cate[<?php echo $value["cate_id"]; ?>][<?php echo $key_s; ?>]" value="1" id="cate_<?php echo $value["cate_id"]; ?>_<?php echo $key_s; ?>" data-parent="cate_<?php echo $value["cate_id"]; ?>"<?php if (isset($admin_allow_cate[$value["cate_id"]][$key_s]) || isset($group_allow_article[$key_s]) || $admin_type == "super") { ?> checked<?php } ?>>
                                    <?php echo $value_s; ?>
                                </label>
                            <?php } else { ?>
                                <span>
                                    <span class="glyphicon glyphicon-<?php if (isset($admin_allow_cate[$value["cate_id"]][$key_s]) || isset($group_allow_article[$key_s]) || $admin_type == "super") { ?>ok-sign text-success<?php } else { ?>remove-sign text-danger<?php } ?>"></span>
                                    <?php echo $value_s; ?>
                                </span>
                            <?php }
                        } ?>
                    </div>
                </td>
            </tr>

            <?php if (isset($value["cate_childs"]) && !fn_isEmpty($value["cate_childs"])) {
                cate_list_allow($value["cate_childs"], $lang, $admin_allow_cate, $group_allow_article, $admin_type, $is_edit);
            }
        }
    }
}

function cate_list_checkbox($arr_cateRows, $cate_ids = array(), $form_name = "", $is_edit = true) {
    if (!fn_isEmpty($arr_cateRows)) {
        foreach ($arr_cateRows as $key=>$value) { ?>
            <tr>
                <td class="bg-child-<?php echo $value["cate_level"]; ?>">
                    <?php if ($is_edit) { ?>
                        <div class="bg-checkbox">
                            <label for="<?php echo $form_name; ?>_cate_ids_<?php echo $value["cate_id"]; ?>">
                                <input type="checkbox"
                                 value="<?php echo $value["cate_id"]; ?>" name="<?php echo $form_name; ?>_cate_ids[]" id="<?php echo $form_name; ?>_cate_ids_<?php echo $value["cate_id"]; ?>" data-parent="<?php echo $form_name; ?>_cate_ids_<?php echo $value["cate_parent_id"]; ?>"<?php if (in_array($value["cate_id"], $cate_ids)) { ?> checked<?php } ?><?php if ($value["cate_type"] != "normal") { ?> disabled<?php }  ?>>

                                <?php echo $value["cate_name"]; ?>
                            </label>
                        </div>
                    <?php } else { ?>
                        <span class="text-<?php if (in_array($value["cate_id"], $cate_ids)) { ?>primary<?php } else { ?>muted<?php } ?>">
                            <span class="glyphicon glyphicon-ok-sign"></span>
                            <?php echo $value["cate_name"]; ?>
                        </span>
                    <?php } ?>

                </td>
            </tr>

            <?php if (isset($value["cate_childs"]) && !fn_isEmpty($value["cate_childs"])) {
                cate_list_checkbox($value["cate_childs"], $cate_ids, $form_name, $is_edit);
            }
        }
    }
}

function cate_list_radio($arr_cateRows, $lang = array(), $cate_id = 0, $cate_excepts = array(), $is_edit = true) {
    if (!fn_isEmpty($arr_cateRows)) {
        foreach ($arr_cateRows as $key=>$value) { ?>
             <tr>
                 <td class="bg-child-<?php echo $value["cate_level"]; ?>">
                     <?php if ($is_edit) { ?>
                        <div class="bg-radio">
                            <label for="call_cate_id_<?php echo $value["cate_id"]; ?>">
                                <input type="radio" value="<?php echo $value["cate_id"]; ?>" name="call_cate_id" id="call_cate_id_<?php echo $value["cate_id"]; ?>"<?php if ($cate_id == $value["cate_id"]) { ?> checked<?php } ?><?php if ($value["cate_type"] != "normal") { ?> disabled <?php } ?>>

                                <?php echo $value["cate_name"]; ?>
                            </label>
                        </div>
                    <?php } else { ?>
                        <span class="text-<?php if ($cate_id == $value["cate_id"]) { ?>primary<?php } else { ?>muted<?php } ?>">
                            <span class="glyphicon glyphicon-ok-sign"></span>
                            <?php echo $value["cate_name"]; ?>
                        </span>
                    <?php } ?>
                </td>

                <td class="bg-child-2">
                    <?php if ($is_edit) { ?>
                        <div class="bg-checkbox">
                            <label for="call_cate_excepts_<?php echo $value["cate_id"]; ?>">
                                <input value="<?php echo $value["cate_id"]; ?>" type="checkbox"<?php if (in_array($value["cate_id"], $cate_excepts)) { ?> checked<?php } ?> name="call_cate_excepts[]" id="call_cate_excepts_<?php echo $value["cate_id"]; ?>">
                                <?php echo $lang["label"]["except"]; ?>
                            </label>
                        </div>
                    <?php } else {
                        if (in_array($value["cate_id"], $cate_excepts)) { ?>
                            <span class="glyphicon glyphicon-remove-sign text-danger"></span>
                            <?php echo $lang["label"]["except"];
                        }
                    } ?>
                </td>
            </tr>

            <?php if (isset($value["cate_childs"]) && !fn_isEmpty($value["cate_childs"])) {
                cate_list_radio($value["cate_childs"], $lang, $cate_id, $cate_excepts, $is_edit);
            }
        }
    }
}


function article_status_process($articleRow, $status_article, $lang = array()) {
    $_str_css       = "";
    $_str_status    = "";
    if ($articleRow["article_box"] == "normal") {
        if ($articleRow["article_time_pub"] > time()) {
            $_str_css       = "info";
            $_str_status    = $lang["label"]["timePub"];
            $_str_title     = $lang["label"]["timePub"] . " " . date(BG_SITE_DATE . " " . BG_SITE_TIMESHORT, $articleRow["article_time_pub"]);
        } else {
            if ($articleRow["article_time_hide"] > 0 && $articleRow["article_time_pub"] < time()) {
                $_str_css       = "default";
                $_str_status    = $lang["label"]["timeHide"];
                $_str_title     = $lang["label"]["timeHide"] . " " . date(BG_SITE_DATE . " " . BG_SITE_TIMESHORT, $articleRow["article_time_hide"]);
            } else {
                if ($articleRow["article_top"] == 1) {
                    $_str_css       = "primary";
                    $_str_status    = $lang["label"]["top"];
                    $_str_title     = "";
                } else {
                    switch($articleRow["article_status"]) {
                        case "pub":
                            $_str_css = "success";
                        break;

                        case "wait":
                            $_str_css = "warning";
                        break;

                        default:
                            $_str_css = "default";
                        break;
                    }

                    $_str_status    = $status_article[$articleRow["article_status"]];
                    $_str_title     = "";
                }
            }
        }
    } else {
        $_str_css       = "default";
        $_str_status    = $lang["label"][$articleRow["article_box"]];
        $_str_title     = "";
    } ?>
    <span class="label label-<?php echo $_str_css; ?> bg-label" <?php if (!fn_isEmpty($_str_title)) { ?>data-toggle="tooltip" data-placement="bottom" title="<?php echo $_str_title; ?>"<?php } ?>><?php echo $_str_status; ?></span>
<?php }

function attach_size_process($attach_size) {
    if ($attach_size > 1024) {
        $num_attachSize = $attach_size / 1024;
        $str_attachUnit = "KB";
    } else if ($attach_size > 1024 * 1024) {
        $num_attachSize = $attach_size / 1024 / 1024;
        $str_attachUnit = "MB";
    } else if ($attach_size > 1024 * 1024 * 1024) {
        $num_attachSize = $attach_size / 1024 / 1024 / 1024;
        $str_attachUnit = "GB";
    } else {
        $num_attachSize = $attach_size;
        $str_attachUnit = "Byte";
    }

    return array(
        "size" => $num_attachSize,
        "unit" => $str_attachUnit,
    );
}

function opt_form_process($arr_formList, $tplRows = array(), $timezoneRows = array(), $timezoneType = "", $timezoneJson = "", $lang = array(), $rcode = array()) {
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

                if (isset($value["note"]) && !fn_isEmpty($value["note"])) { ?>
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
                            <option<?php if (BG_SITE_TPL == $value["name"]) { ?> selected<?php } ?> value="<?php echo $value["name"]; ?>"><?php echo $value["name"]; ?></option>
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


function admin_status_process($str_status, $status_admin) {
    $_str_css = "";

    switch($str_status) {
        case "enable":
            $_str_css = "success";
        break;

        default:
            $_str_css = "default";
        break;
    }

    ?><span class="label label-<?php echo $_str_css; ?> bg-label"><?php echo $status_admin[$str_status]; ?></span><?php
}


function app_status_process($str_status, $status_app) {
    $_str_css = "";

    switch($str_status) {
        case "enable":
            $_str_css = "success";
        break;

        default:
            $_str_css = "default";
        break;
    }

    ?><span class="label label-<?php echo $_str_css; ?> bg-label"><?php echo $status_app[$str_status]; ?></span><?php
}


function call_status_process($str_status, $status_call) {
    $_str_css = "";

    switch($str_status) {
        case "enable":
            $_str_css = "success";
        break;

        default:
            $_str_css = "default";
        break;
    }

    ?><span class="label label-<?php echo $_str_css; ?> bg-label"><?php echo $status_call[$str_status]; ?></span><?php
}


function cate_status_process($str_status, $status_cate) {
    $_str_css = "";

    switch($str_status) {
        case "show":
            $_str_css = "success";
        break;

        default:
            $_str_css = "default";
        break;
    }

    ?><span class="label label-<?php echo $_str_css; ?> bg-label"><?php echo $status_cate[$str_status]; ?></span><?php
}


function custom_status_process($str_status, $status_custom) {
    $_str_css = "";

    switch($str_status) {
        case "enable":
            $_str_css = "success";
        break;

        default:
            $_str_css = "default";
        break;
    }

    ?><span class="label label-<?php echo $_str_css; ?> bg-label"><?php echo $status_custom[$str_status]; ?></span><?php
}


function group_status_process($str_status, $status_group) {
    $_str_css = "";

    switch($str_status) {
        case "enable":
            $_str_css = "success";
        break;

        default:
            $_str_css = "default";
        break;
    }

    ?><span class="label label-<?php echo $_str_css; ?> bg-label"><?php echo $status_group[$str_status]; ?></span><?php
}


function link_status_process($str_status, $status_link) {
    $_str_css = "";

    switch($str_status) {
        case "enable":
            $_str_css = "success";
        break;

        default:
            $_str_css = "default";
        break;
    }

    ?><span class="label label-<?php echo $_str_css; ?> bg-label"><?php echo $status_link[$str_status]; ?></span><?php
}


function spec_status_process($str_status, $status_spec) {
    $_str_css = "";

    switch($str_status) {
        case "enable":
            $_str_css = "success";
        break;

        default:
            $_str_css = "default";
        break;
    }

    ?><span class="label label-<?php echo $_str_css; ?> bg-label"><?php echo $status_spec[$str_status]; ?></span><?php
}


function tag_status_process($str_status, $status_tag) {
    $_str_css = "";

    switch($str_status) {
        case "show":
            $_str_css = "success";
        break;

        default:
            $_str_css = "default";
        break;
    }

    ?><span class="label label-<?php echo $_str_css; ?> bg-label"><?php echo $status_tag[$str_status]; ?></span><?php
}


function pm_status_process($arr_pmRow, $status_pm, $lang, $search_type) {
    $_bold_begin    = "";
    $_bold_end      = "";
    $_str_text      = "";
    $_css_text      = "";
    $_css_label     = "";

    if ($search_type == "in") {
        if ($arr_pmRow["pm_status"] == "wait") {
            $_bold_begin    = "<strong>";
            $_bold_end      = "</strong>";
            $_css_text      = "warning";
            $_css_label     = "warning";
        } else {
            $_css_label     = "success";
        }

        $_str_text = $status_pm[$arr_pmRow["pm_status"]];
    } else {
        switch($arr_pmRow["pm_send_status"]) {
            case "wait":
                $_bold_begin    = "<strong>";
                $_bold_end      = "</strong>";
                $_css_text      = "warning";
                $_css_label     = "warning";
                $_str_text      = $status_pm[$arr_pmRow["pm_send_status"]];
            break;

            case "revoke":
                $_str_text      = $lang["label"]["revoke"];
                $_css_label     = "default";
            break;

            default:
                $_css_label     = "success";
                $_str_text      = $status_pm[$arr_pmRow["pm_send_status"]];
            break;
        }
    }

    return array(
        "bold_begin"    => $_bold_begin,
        "bold_end"      => $_bold_end,
        "str_text"      => $_str_text,
        "css_text"      => $_css_text,
        "css_label"     => $_css_label,
    );
}