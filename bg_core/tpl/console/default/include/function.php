<?php function cate_list_opt($arr_cateRows, $cate_Id = 0, $is_disable = false) {
    if (!fn_isEmpty($arr_cateRows)) {
        foreach ($arr_cateRows as $_key=>$_value) { ?>
            <option <?php if ($cate_Id == $_value['cate_id']) { ?>selected<?php } ?> value="<?php echo $_value['cate_id']; ?>" <?php if ($is_disable && $_value['cate_type'] != 'normal') { ?>disabled<?php } ?>>
                <?php if ($_value['cate_level'] > 1) {
                    for ($_i = 1; $_i < $_value['cate_level']; $_i++) { ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                    <?php }
                }
                echo $_value['cate_name']; ?>
            </option>

            <?php if (isset($_value['cate_childs']) && !fn_isEmpty($_value['cate_childs'])) {
                cate_list_opt($_value['cate_childs'], $cate_Id, $is_disable);
            }
        }
    }
}

function allow_list($arr_consoleMod, $lang_consoleMod = array(), $arr_opt = array(), $lang_opt = array(), $lang_mod = array(), $lang_common = array(), $group_allow = array(), $is_edit = true) { ?>
    <dl>
        <?php if ($is_edit) { ?>
            <dd>
                <div class="form-check">
                    <label for="chk_all"  class="form-check-label">
                        <input type="checkbox" id="chk_all" data-parent="first" class="form-check-input">
                        <?php echo $lang_mod['label']['all']; ?>
                    </label>
                </div>
            </dd>
        <?php }

        foreach ($arr_consoleMod as $_key_m=>$_value_m) { ?>
            <dt>
                <?php if (isset($lang_consoleMod[$_key_m]['main']['title'])) {
                    echo $lang_consoleMod[$_key_m]['main']['title'];
                } else {
                    echo $_value_m['main']['title'];
                } ?>
            </dt>
            <dd>
                <?php if ($is_edit) { ?>
                    <div class="form-check form-check-inline">
                        <label for="allow_<?php echo $_key_m; ?>" class="form-check-label">
                            <input type="checkbox" id="allow_<?php echo $_key_m; ?>" data-parent="chk_all" class="form-check-input">
                            <?php echo $lang_mod['label']['all']; ?>
                        </label>
                    </div>
                <?php }

                foreach ($_value_m['allow'] as $_key_s=>$_value_s) {
                    if ($is_edit) { ?>
                        <div class="form-check form-check-inline">
                            <label for="allow_<?php echo $_key_m; ?>_<?php echo $_key_s; ?>" class="form-check-label">
                                <input type="checkbox" name="group_allow[<?php echo $_key_m; ?>][<?php echo $_key_s; ?>]" value="1" id="allow_<?php echo $_key_m; ?>_<?php echo $_key_s; ?>" <?php if (isset($group_allow[$_key_m][$_key_s])) { ?>checked<?php } ?> data-parent="allow_<?php echo $_key_m; ?>" class="form-check-input">
                                <?php if (isset($lang_consoleMod[$_key_m]['allow'][$_key_s])) {
                                    echo $lang_consoleMod[$_key_m]['allow'][$_key_s];
                                } else {
                                    echo $_value_s;
                                } ?>
                            </label>
                        </div>
                    <?php } else { ?>
                        <span>
                            <span class="oi oi-<?php if (isset($group_allow[$_key_m][$_key_s])) { ?>circle-check text-success<?php } else { ?>circle-x text-danger<?php } ?>"></span>
                            <?php if (isset($lang_consoleMod[$_key_m]['allow'][$_key_s])) {
                                echo $lang_consoleMod[$_key_m]['allow'][$_key_s];
                            } else {
                                echo $_value_s;
                            } ?>
                        </span>
                    <?php }
                } ?>
            </dd>
        <?php } ?>

        <dt><?php echo $lang_common['page']['opt']; ?></dt>
        <dd>
            <?php if ($is_edit) { ?>
                <div class="form-check form-check-inline">
                    <label for="allow_opt" class="form-check-label">
                        <input type="checkbox" id="allow_opt" data-parent="chk_all" class="form-check-input">
                        <?php echo $lang_mod['label']['all']; ?>
                    </label>
                </div>
            <?php }

            foreach ($arr_opt as $_key_s=>$_value_s) {
                if ($is_edit) { ?>
                    <div class="form-check form-check-inline">
                        <label for="allow_opt_<?php echo $_key_s; ?>" class="form-check-label">
                            <input type="checkbox" name="group_allow[opt][<?php echo $_key_s; ?>]" value="1" id="allow_opt_<?php echo $_key_s; ?>" data-parent="allow_opt" <?php if (isset($group_allow['opt'][$_key_s])) { ?>checked<?php } ?> class="form-check-input">
                            <?php if (isset($lang_opt[$_key_s]['title'])) {
                                echo $lang_opt[$_key_s]['title'];
                            } else {
                                echo $_value_s['title'];
                            } ?>
                        </label>
                    </div>
                <?php } else { ?>
                    <span>
                        <span class="oi oi-<?php if (isset($group_allow['opt'][$_key_s])) { ?>circle-check text-success<?php } else { ?>circle-x text-danger<?php } ?>"></span>
                        <?php if (isset($lang_opt[$_key_s]['title'])) {
                            echo $lang_opt[$_key_s]['title'];
                        } else {
                            echo $_value_s['title'];
                        } ?>
                    </span>
                <?php }
            }

            if ($is_edit) { ?>
                <div class="form-check form-check-inline">
                    <label for="allow_opt_app" class="form-check-label">
                        <input type="checkbox" name="group_allow[opt][app]" value="1" id="allow_opt_app" data-parent="allow_opt" <?php if (isset($group_allow['opt']['app'])) { ?>checked<?php } ?> class="form-check-input">
                        <?php echo $lang_common['page']['optApp']; ?>
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label for="allow_opt_dbconfig" class="form-check-label">
                        <input type="checkbox" name="group_allow[opt][dbconfig]" value="1" id="allow_opt_dbconfig" data-parent="allow_opt" <?php if (isset($group_allow['opt']['dbconfig'])) { ?>checked<?php } ?> class="form-check-input">
                        <?php echo $lang_common['page']['dbconfig']; ?>
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label for="allow_opt_chkver" class="form-check-label">
                        <input type="checkbox" name="group_allow[opt][chkver]" value="1" id="allow_opt_chkver" data-parent="allow_opt" <?php if (isset($group_allow['opt']['chkver'])) { ?>checked<?php } ?> class="form-check-input">
                        <?php echo $lang_common['page']['chkver']; ?>
                    </label>
                </div>
            <?php } else { ?>
                <span>
                    <span class="oi oi-<?php if (isset($group_allow['opt']['app'])) { ?>circle-check text-success<?php } else { ?>circle-x text-danger<?php } ?>"></span>
                    <?php echo $lang_common['page']['optApp']; ?>
                </span>
                <span>
                    <span class="oi oi-<?php if (isset($group_allow['opt']['dbconfig'])) { ?>circle-check text-success<?php } else { ?>circle-x text-danger<?php } ?>"></span>
                    <?php echo $lang_common['page']['dbconfig']; ?>
                </span>
                <span>
                    <span class="oi oi-<?php if (isset($group_allow['opt']['chkver'])) { ?>circle-check text-success<?php } else { ?>circle-x text-danger<?php } ?>"></span>
                    <?php echo $lang_common['page']['chkver']; ?>
                </span>
            <?php } ?>
        </dd>
    </dl>
<?php }

function cate_list_allow($arr_cateRows, $cate_allow, $lang_mod = array(), $admin_allow_cate = array(), $group_allow_article = array(), $admin_type = '', $is_edit = true) {
    if (!fn_isEmpty($arr_cateRows)) {
        foreach ($arr_cateRows as $_key=>$_value) { ?>
            <tr>
                <td class="bg-child-<?php echo $_value['cate_level']; ?>">
                    <div><strong><?php echo $_value['cate_name']; ?></strong></div>
                    <div>
                        <?php if ($is_edit) { ?>
                            <div class="form-check form-check-inline">
                                <label for="cate_<?php echo $_value['cate_id']; ?>" class="form-check-label">
                                    <input type="checkbox" id="cate_<?php echo $_value['cate_id']; ?>" data-parent="chk_all" class="form-check-input">
                                    <?php echo $lang_mod['label']['all']; ?>
                                </label>
                            </div>
                        <?php }

                        foreach ($cate_allow as $_key_s=>$_value_s) {
                            if ($is_edit) { ?>
                                <div class="form-check form-check-inline">
                                    <label for="cate_<?php echo $_value['cate_id']; ?>_<?php echo $_key_s; ?>" class="form-check-label">
                                        <input type="checkbox" name="admin_allow_cate[<?php echo $_value['cate_id']; ?>][<?php echo $_key_s; ?>]" value="1" id="cate_<?php echo $_value['cate_id']; ?>_<?php echo $_key_s; ?>" data-parent="cate_<?php echo $_value['cate_id']; ?>"<?php if (isset($admin_allow_cate[$_value['cate_id']][$_key_s]) || isset($group_allow_article[$_key_s]) || $admin_type == 'super') { ?> checked<?php } ?> class="form-check-input">
                                        <?php if(isset($lang_mod['allow'][$_key_s])) {
                                            echo $lang_mod['allow'][$_key_s];
                                        } else {
                                            echo $_value_s;
                                        } ?>
                                    </label>
                                </div>
                            <?php } else { ?>
                                <span>
                                    <span class="oi oi-<?php if (isset($admin_allow_cate[$_value['cate_id']][$_key_s]) || isset($group_allow_article[$_key_s]) || $admin_type == 'super') { ?>circle-check text-success<?php } else { ?>circle-x text-danger<?php } ?>"></span>
                                    <?php if(isset($lang_mod['allow'][$_key_s])) {
                                        echo $lang_mod['allow'][$_key_s];
                                    } else {
                                        echo $_value_s;
                                    } ?>
                                </span>
                            <?php }
                        } ?>
                    </div>
                </td>
            </tr>

            <?php if (isset($_value['cate_childs']) && !fn_isEmpty($_value['cate_childs'])) {
                cate_list_allow($_value['cate_childs'], $cate_allow, $lang_mod, $admin_allow_cate, $group_allow_article, $admin_type, $is_edit);
            }
        }
    }
}

function cate_list_checkbox($arr_cateRows, $cate_ids = array(), $form_name = '', $is_edit = true) {
    if (!fn_isEmpty($arr_cateRows)) {
        foreach ($arr_cateRows as $_key=>$_value) { ?>
            <tr>
                <td class="bg-child-<?php echo $_value['cate_level']; ?>">
                    <?php if ($is_edit) { ?>
                        <div class="form-check">
                            <label for="<?php echo $form_name; ?>_cate_ids_<?php echo $_value['cate_id']; ?>"  class="form-check-label">
                                <input type="checkbox"
                                 value="<?php echo $_value['cate_id']; ?>" name="<?php echo $form_name; ?>_cate_ids[]" id="<?php echo $form_name; ?>_cate_ids_<?php echo $_value['cate_id']; ?>" <?php if (in_array($_value['cate_id'], $cate_ids)) { ?> checked<?php } ?> data-parent="<?php echo $form_name; ?>_cate_ids_<?php echo $_value['cate_parent_id']; ?>" <?php if ($_value['cate_type'] != 'normal') { ?>disabled<?php }  ?> class="form-check-input">

                                <?php echo $_value['cate_name']; ?>
                            </label>
                        </div>
                    <?php } else { ?>
                        <span class="text-<?php if (in_array($_value['cate_id'], $cate_ids)) { ?>primary<?php } else { ?>muted<?php } ?>">
                            <span class="oi oi-<?php if (in_array($_value['cate_id'], $cate_ids)) { ?>circle-check<?php } else { ?>circle-x<?php } ?>"></span>
                            <?php echo $_value['cate_name']; ?>
                        </span>
                    <?php } ?>

                </td>
            </tr>

            <?php if (isset($_value['cate_childs']) && !fn_isEmpty($_value['cate_childs'])) {
                cate_list_checkbox($_value['cate_childs'], $cate_ids, $form_name, $is_edit);
            }
        }
    }
}

function cate_list_radio($arr_cateRows, $lang_mod = array(), $cate_id = 0, $cate_excepts = array(), $is_edit = true) {
    if (!fn_isEmpty($arr_cateRows)) {
        foreach ($arr_cateRows as $_key=>$_value) { ?>
             <tr>
                 <td class="bg-child-<?php echo $_value['cate_level']; ?>">
                     <?php if ($is_edit) { ?>
                        <div class="form-check">
                            <label for="call_cate_id_<?php echo $_value['cate_id']; ?>" class="form-check-label">
                                <input type="radio" value="<?php echo $_value['cate_id']; ?>" name="call_cate_id" <?php if ($cate_id == $_value['cate_id']) { ?> checked<?php } ?> id="call_cate_id_<?php echo $_value['cate_id']; ?>" <?php if ($_value['cate_type'] != 'normal') { ?>disabled<?php } ?> class="form-check-input">

                                <?php echo $_value['cate_name']; ?>
                            </label>
                        </div>
                    <?php } else { ?>
                        <span class="text-<?php if ($cate_id == $_value['cate_id']) { ?>primary<?php } else { ?>muted<?php } ?>">
                            <span class="oi oi-circle-check"></span>
                            <?php echo $_value['cate_name']; ?>
                        </span>
                    <?php } ?>
                </td>

                <td class="bg-child-2">
                    <?php if ($is_edit) { ?>
                        <div class="form-check">
                            <label for="call_cate_excepts_<?php echo $_value['cate_id']; ?>"  class="form-check-label">
                                <input value="<?php echo $_value['cate_id']; ?>" type="checkbox"<?php if (in_array($_value['cate_id'], $cate_excepts)) { ?> checked<?php } ?> name="call_cate_excepts[]" id="call_cate_excepts_<?php echo $_value['cate_id']; ?>" class="form-check-input">
                                <?php echo $lang_mod['label']['except']; ?>
                            </label>
                        </div>
                    <?php } else {
                        if (in_array($_value['cate_id'], $cate_excepts)) { ?>
                            <span class="oi oi-circle-x text-danger"></span>
                            <?php echo $lang_mod['label']['except'];
                        }
                    } ?>
                </td>
            </tr>

            <?php if (isset($_value['cate_childs']) && !fn_isEmpty($_value['cate_childs'])) {
                cate_list_radio($_value['cate_childs'], $lang_mod, $cate_id, $cate_excepts, $is_edit);
            }
        }
    }
}


function article_status_process($articleRow, $status_article, $lang_mod = array()) {
    $_str_css       = '';
    $_str_status    = '';
    if ($articleRow['article_box'] == 'normal') {
        if ($articleRow['article_is_time_pub'] > 0 && $articleRow['article_time_pub'] > time()) {
            $_str_css       = "info";
            $_str_status    = $lang_mod['label']['timePub'];
            $_str_title     = $lang_mod['label']['timePub'] . ' ' . date(BG_SITE_DATE . ' ' . BG_SITE_TIMESHORT, $articleRow['article_time_pub']);
        } else {
            if ($articleRow['article_is_time_hide'] > 0 && $articleRow['article_time_pub'] < time()) {
                $_str_css       = 'secondary';
                $_str_status    = $lang_mod['label']['timeHide'];
                $_str_title     = $lang_mod['label']['timeHide'] . ' ' . date(BG_SITE_DATE . ' ' . BG_SITE_TIMESHORT, $articleRow['article_time_hide']);
            } else {
                if ($articleRow['article_top'] == 1) {
                    $_str_css       = "primary";
                    $_str_status    = $lang_mod['status']['top'];
                    $_str_title     = '';
                } else {
                    switch ($articleRow['article_status']) {
                        case 'pub':
                            $_str_css = 'success';
                        break;

                        case 'wait':
                            $_str_css = 'warning';
                        break;

                        default:
                            $_str_css = 'secondary';
                        break;
                    }

                    if (isset($status_article[$articleRow['article_status']])) {
                        $_str_status    = $status_article[$articleRow['article_status']];
                    }
                    $_str_title     = '';
                }
            }
        }
    } else {
        $_str_css       = 'secondary';
        if (isset($lang_mod['box'][$articleRow['article_box']])) {
            $_str_status = $lang_mod['box'][$articleRow['article_box']];
        }
        $_str_title     = '';
    } ?>
    <span class="badge badge-<?php echo $_str_css; ?>" <?php if (!fn_isEmpty($_str_title)) { ?>data-toggle="tooltip" data-placement="bottom" title="<?php echo $_str_title; ?>"<?php } ?>><?php echo $_str_status; ?></span>
<?php }

function attach_size_process($attach_size) {
    if ($attach_size > 1024) {
        $num_attachSize = $attach_size / 1024;
        $str_attachUnit = 'KB';
    } else if ($attach_size > 1024 * 1024) {
        $num_attachSize = $attach_size / 1024 / 1024;
        $str_attachUnit = 'MB';
    } else if ($attach_size > 1024 * 1024 * 1024) {
        $num_attachSize = $attach_size / 1024 / 1024 / 1024;
        $str_attachUnit = 'GB';
    } else {
        $num_attachSize = $attach_size;
        $str_attachUnit = 'Byte';
    }

    return array(
        'size' => $num_attachSize,
        'unit' => $str_attachUnit,
    );
}

function opt_form_process($arr_formList, $lang_opt, $tplRows = array(), $timezoneRows = array(), $timezoneLang = array(), $timezoneType = '', $lang_mod = array(), $rcode = array()) {
    $_str_json = 'var opts_validator_form = {';

    $_count = 1;

    foreach ($arr_formList as $_key=>$_value) {
        //form
        if (defined($_key)) {
            $_this_value = constant($_key);
        } else {
            $_this_value = $_value['default'];
        } ?>
        <div class="form-group">
            <label>
                <?php if (isset($lang_opt[$_key]['label'])) {
                    $_label = $lang_opt[$_key]['label'];
                } else {
                    $_label = $_key;
                }

                echo $_label;

                if ($_value['min'] > 0) { ?> <span class="text-danger">*</span><?php } ?>
            </label>

            <?php switch ($_value['type']) {
                case 'select': ?>
                    <select name="opt[<?php echo $GLOBALS['route']['bg_act']; ?>][<?php echo $_key; ?>]" id="opt_<?php echo $GLOBALS['route']['bg_act']; ?>_<?php echo $_key; ?>" data-validate="opt_<?php echo $GLOBALS['route']['bg_act']; ?>_<?php echo $_key; ?>" class="form-control">
                        <?php foreach ($_value['option'] as $_key_opt=>$_value_opt) { ?>
                            <option<?php if ($_this_value == $_key_opt) { ?> selected<?php } ?> value="<?php echo $_key_opt; ?>">
                                <?php if (isset($lang_opt[$_key]['option'][$_key_opt])) {
                                    echo $lang_opt[$_key]['option'][$_key_opt];
                                } else {
                                    echo $_value_opt;
                                } ?>
                            </option>
                        <?php } ?>
                    </select>
                <?php break;

                case 'radio':
                    foreach ($_value['option'] as $_key_opt=>$_value_opt) { ?>
                        <div class="form-check">
                            <label for="opt_<?php echo $GLOBALS['route']['bg_act']; ?>_<?php echo $_key; ?>_<?php echo $_key_opt; ?>" class="form-check-label">
                                <input type="radio"<?php if ($_this_value == $_key_opt) { ?> checked<?php } ?> value="<?php echo $_key_opt; ?>" data-validate="opt_<?php echo $GLOBALS['route']['bg_act']; ?>_<?php echo $_key; ?>" name="opt[<?php echo $GLOBALS['route']['bg_act']; ?>][<?php echo $_key; ?>]" id="opt_<?php echo $GLOBALS['route']['bg_act']; ?>_<?php echo $_key; ?>_<?php echo $_key_opt; ?>" class="form-check-input">
                                <?php if (isset($lang_opt[$_key]['option'][$_key_opt]['value'])) {
                                    echo $lang_opt[$_key]['option'][$_key_opt]['value'];
                                } else {
                                    echo $_value_opt['value'];
                                } ?>
                            </label>
                        </div>
                        <?php
                            if (isset($lang_opt[$_key]['option'][$_key_opt]['note']) && !fn_isEmpty($lang_opt[$_key]['option'][$_key_opt]['note'])) { ?>
                            <small class="form-text"><?php echo $lang_opt[$_key]['option'][$_key_opt]['note']; ?></small>
                        <?php }
                    }
                break;

                case 'textarea': ?>
                    <textarea name="opt[<?php echo $GLOBALS['route']['bg_act']; ?>][<?php echo $_key; ?>]" id="opt_<?php echo $GLOBALS['route']['bg_act']; ?>_<?php echo $_key; ?>" data-validate="opt_<?php echo $GLOBALS['route']['bg_act']; ?>_<?php echo $_key; ?>" class="form-control bg-textarea-md"><?php echo $_this_value; ?></textarea>
                <?php break;

                default: ?>
                    <input type="text" value="<?php echo $_this_value; ?>" name="opt[<?php echo $GLOBALS['route']['bg_act']; ?>][<?php echo $_key; ?>]" id="opt_<?php echo $GLOBALS['route']['bg_act']; ?>_<?php echo $_key; ?>" data-validate="opt_<?php echo $GLOBALS['route']['bg_act']; ?>_<?php echo $_key; ?>" class="form-control">
                <?php break;
            } ?>

            <small class="form-text" id="msg_<?php echo $GLOBALS['route']['bg_act']; ?>_<?php echo $_key; ?>"></small>

            <?php if (isset($lang_opt[$_key]['note']) && !fn_isEmpty($lang_opt[$_key]['note'])) { ?>
                <small class="form-text"><?php echo $lang_opt[$_key]['note']; ?></small>
            <?php } ?>
        </div>

        <?php //json
        if ($_value['type'] == 'str' || $_value['type'] == 'textarea') {
            $str_msg_min = 'too_short';
            $str_msg_max = 'too_long';
        } else {
            $str_msg_min = 'too_few';
            $str_msg_max = 'too_many';
        }
        $_str_json .= 'opt_' . $GLOBALS['route']['bg_act'] . '_' . $_key . ': {
            len: { min: ' . $_value['min'] . ', max: 900 },
            validate: { selector: "[data-validate=\'opt_' . $GLOBALS['route']['bg_act'] . '_' . $_key . '\']", type: "' . $_value['type'] . '",';
            if (isset($_value['format'])) {
                $_str_json .= ' format: "' . $_value['format'] . '",';
            }
            $_str_json .= ' },
            msg: { selector: "#msg_' . $GLOBALS['route']['bg_act'] . '_' . $_key . '", ' . $str_msg_min . ': "' . $rcode['x060201'] . $_label . '", ' . $str_msg_max . ': "' . $_label . $rcode['x060202'] . '", format_err: "' . $_label . $rcode['x060203'] . '" }
        }';
        if ($_count < count($arr_formList)) {
            $_str_json .= ',';
        }

        $_count++;
    }

    $_str_json .= '};';

    if ($GLOBALS['route']['bg_act'] == 'base') { ?>
        <div class="form-group">
            <label><?php echo $lang_mod['label']['tpl']; ?> <span class="text-danger">*</span></label>
            <select name="opt[base][BG_SITE_TPL]" id="opt_base_BG_SITE_TPL" data-validate class="form-control">
                <?php foreach ($tplRows as $_key=>$_value) {
                    if ($_value['type'] == 'dir') { ?>
                        <option<?php if (BG_SITE_TPL == $_value['name']) { ?> selected<?php } ?> value="<?php echo $_value['name']; ?>"><?php echo $_value['name']; ?></option>
                    <?php }
               } ?>
            </select>
            <small class="form-text" id="msg_base_BG_SITE_TPL"></small>
        </div>

        <div class="form-group">
            <label><?php echo $lang_mod['label']['timezone']; ?> <span class="text-danger">*</span></label>
            <div class="form-row">
                <div class="col">
                    <select name="timezone_type" id="timezone_type" class="form-control">
                        <?php foreach ($timezoneRows as $_key=>$_value) { ?>
                            <option<?php if ($timezoneType == $_key) { ?> selected<?php } ?> value="<?php echo $_key; ?>">
                                <?php if (isset($timezoneLang[$_key]['title'])) {
                                    echo $timezoneLang[$_key]['title'];
                                } else {
                                    echo $_value['title'];
                                } ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col">
                    <select name="opt[base][BG_SITE_TIMEZONE]" id="opt_base_BG_SITE_TIMEZONE" data-validate class="form-control">
                        <?php foreach ($timezoneRows[$timezoneType]['sub'] as $_key=>$_value) { ?>
                            <option<?php if (BG_SITE_TIMEZONE == $_key) { ?> selected<?php } ?> value="<?php echo $_key; ?>">
                                <?php if (isset($timezoneLang[$timezoneType]['sub'][$_key])) {
                                    echo $timezoneLang[$timezoneType]['sub'][$_key];
                                } else {
                                    echo $_value;
                                } ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <small class="form-text" id="msg_base_BG_SITE_TIMEZONE"></small>
        </div>

        <?php $_str_json .= 'opts_validator_form.opt_base_BG_SITE_TPL = {
            len: { min: 1, max: 0 },
            validate: { type: "select" },
            msg: { too_few: "' . $rcode['x060201'] . $lang_mod['label']['tpl'] . '" }
        };
        opts_validator_form.opt_base_BG_SITE_TIMEZONE = {
            len: { min: 1, max: 0 },
            validate: { type: "select" },
            msg: { too_few: "' . $rcode['x060201'] . $lang_mod['label']['timezone'] . '" }
        };';
    }

    return array(
        'json' => $_str_json,
    );
}


function admin_status_process($str_status, $status_admin) {
    $_str_css = '';

    switch ($str_status) {
        case 'enable':
            $_str_css = 'success';
        break;

        default:
            $_str_css = 'secondary';
        break;
    }

    if (isset($status_admin[$str_status])) {
        ?><span class="badge badge-<?php echo $_str_css; ?>"><?php echo $status_admin[$str_status]; ?></span><?php
    }
}


function app_status_process($str_status, $status_app) {
    $_str_css = '';

    switch ($str_status) {
        case 'enable':
            $_str_css = 'success';
        break;

        default:
            $_str_css = 'secondary';
        break;
    }

    if (isset($status_app[$str_status])) {
        ?><span class="badge badge-<?php echo $_str_css; ?>"><?php echo $status_app[$str_status]; ?></span><?php
    }
}


function call_status_process($str_status, $status_call) {
    $_str_css = '';

    switch ($str_status) {
        case 'enable':
            $_str_css = 'success';
        break;

        default:
            $_str_css = 'secondary';
        break;
    }

    if (isset($status_call[$str_status])) {
        ?><span class="badge badge-<?php echo $_str_css; ?>"><?php echo $status_call[$str_status]; ?></span><?php
    }
}


function cate_status_process($str_status, $status_cate) {
    $_str_css = '';

    switch ($str_status) {
        case 'show':
            $_str_css = 'success';
        break;

        default:
            $_str_css = 'secondary';
        break;
    }

    if (isset($status_cate[$str_status])) {
        ?><span class="badge badge-<?php echo $_str_css; ?>"><?php echo $status_cate[$str_status]; ?></span><?php
    }
}


function custom_status_process($str_status, $status_custom) {
    $_str_css = '';

    switch ($str_status) {
        case 'enable':
            $_str_css = 'success';
        break;

        default:
            $_str_css = 'secondary';
        break;
    }

    if (isset($status_custom[$str_status])) {
        ?><span class="badge badge-<?php echo $_str_css; ?>"><?php echo $status_custom[$str_status]; ?></span><?php
    }
}


function group_status_process($str_status, $status_group) {
    $_str_css = '';

    switch ($str_status) {
        case 'enable':
            $_str_css = 'success';
        break;

        default:
            $_str_css = 'secondary';
        break;
    }

    if (isset($status_group[$str_status])) {
        ?><span class="badge badge-<?php echo $_str_css; ?>"><?php echo $status_group[$str_status]; ?></span><?php
    }
}

function plugin_status_process($str_status, $status_plugin) {
    $_str_css = '';

    switch ($str_status) {
        case 'not':
            $_str_css = 'warning';
        break;

        case 'enable':
            $_str_css = 'success';
        break;

        default:
            $_str_css = 'secondary';
        break;
    }

    if (isset($status_plugin[$str_status])) {
        ?><span class="badge badge-<?php echo $_str_css; ?>"><?php echo $status_plugin[$str_status]; ?></span><?php
    }
}

function link_status_process($str_status, $status_link) {
    $_str_css = '';

    switch ($str_status) {
        case 'enable':
            $_str_css = 'success';
        break;

        default:
            $_str_css = 'secondary';
        break;
    }

    if (isset($status_link[$str_status])) {
        ?><span class="badge badge-<?php echo $_str_css; ?>"><?php echo $status_link[$str_status]; ?></span><?php
    }
}


function spec_status_process($str_status, $status_spec) {
    $_str_css = '';

    switch ($str_status) {
        case 'show':
            $_str_css = 'success';
        break;

        default:
            $_str_css = 'secondary';
        break;
    }

    if (isset($status_spec[$str_status])) {
        ?><span class="badge badge-<?php echo $_str_css; ?>"><?php echo $status_spec[$str_status]; ?></span><?php
    }
}


function tag_status_process($str_status, $status_tag) {
    $_str_css = '';

    switch ($str_status) {
        case 'show':
            $_str_css = 'success';
        break;

        default:
            $_str_css = 'secondary';
        break;
    }

    if (isset($status_tag[$str_status])) {
        ?><span class="badge badge-<?php echo $_str_css; ?>"><?php echo $status_tag[$str_status]; ?></span><?php
    }
}


function gsite_status_process($str_status, $status_gsite) {
    $_str_css = '';

    switch ($str_status) {
        case 'enable':
            $_str_css = 'success';
        break;

        default:
            $_str_css = 'secondary';
        break;
    }

    if (isset($status_gsite[$str_status])) {
        ?><span class="badge badge-<?php echo $_str_css; ?>"><?php echo $status_gsite[$str_status]; ?></span><?php
    }
}


function gather_status_process($num_articleId, $status_gather) {
    $_str_css = '';

    if ($num_articleId > 0) {
        $_str_css       = 'secondary';
        $_str_status    = 'store';
    } else {
        $_str_css       = 'warning';
        $_str_status    = 'wait';
    }

    if (isset($status_gather[$_str_status])) {
        ?><span class="badge badge-<?php echo $_str_css; ?>"><?php echo $status_gather[$_str_status]; ?></span><?php
    }
}


function pm_status_process($arr_pmRow, $status_pm, $lang_mod, $search_type) {
    $_bold_begin    = '';
    $_bold_end      = '';
    $_str_text      = '';
    $_css_text      = '';
    $_css_label     = '';

    if ($search_type == 'in') {
        if ($arr_pmRow['pm_status'] == 'wait') {
            $_bold_begin    = '<strong>';
            $_bold_end      = '</strong>';
            $_css_text      = 'warning';
            $_css_label     = 'warning';
        } else {
            $_css_label     = 'success';
        }

        if (isset($status_pm[$arr_pmRow['pm_status']])) {
            $_str_text = $status_pm[$arr_pmRow['pm_status']];
        }
    } else {
        switch ($arr_pmRow['pm_send_status']) {
            case 'wait':
                $_bold_begin    = '<strong>';
                $_bold_end      = '</strong>';
                $_css_text      = 'warning';
                $_css_label     = 'warning';
                if (isset($status_pm[$arr_pmRow['pm_send_status']])) {
                    $_str_text      = $status_pm[$arr_pmRow['pm_send_status']];
                }
            break;

            case 'revoke':
                $_str_text      = $lang_mod['label']['revoke'];
                $_css_label     = 'secondary';
            break;

            default:
                $_css_label     = 'success';
                if (isset($status_pm[$arr_pmRow['pm_send_status']])) {
                    $_str_text      = $status_pm[$arr_pmRow['pm_send_status']];
                }
            break;
        }
    }

    return array(
        'bold_begin'    => $_bold_begin,
        'bold_end'      => $_bold_end,
        'str_text'      => $_str_text,
        'css_text'      => $_css_text,
        'css_label'     => $_css_label,
    );
}