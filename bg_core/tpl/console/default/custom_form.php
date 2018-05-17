<?php function custom_list_opt($arr_customRows, $customRow = array()) {
    if (!fn_isEmpty($arr_customRows)) {
        foreach ($arr_customRows as $key=>$value) { ?>
            <option <?php if ($customRow['custom_parent_id'] == $value['custom_id']) { ?>selected<?php } ?> value="<?php echo $value['custom_id']; ?>" <?php if ($customRow['custom_id'] == $value['custom_id']) { ?>disabled<?php } ?>>
                <?php if ($value['custom_level'] > 1) {
                    for ($_iii = 2; $_iii <= $value['custom_level']; $_iii++) { ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                    <?php }
                }
                echo $value['custom_name']; ?>
            </option>

            <?php if (isset($value['custom_childs']) && !fn_isEmpty($value['custom_childs'])) {
                custom_list_opt($value['custom_childs'], $customRow);
            }
        }
    }
}

$cfg = array(
    'title'          => $this->lang['consoleMod']['article']['main']['title'] . ' &raquo; ' . $this->lang['consoleMod']['article']['sub']['custom'],
    'menu_active'    => 'article',
    'sub_active'     => "custom",
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?m=custom"
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=custom&a=list" class="nav-link">
                <span class="oi oi-chevron-left"></span>
                <?php echo $this->lang['common']['href']['back']; ?>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo BG_URL_HELP; ?>index.php?m=console&a=custom" class="nav-link" target="_blank">
                <span class="badge badge-pill badge-primary">
                    <span class="oi oi-question-mark"></span>
                </span>
                <?php echo $this->lang['mod']['href']['help']; ?>
            </a>
        </li>
    </ul>

    <form name="custom_form" id="custom_form">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="custom_id" id="custom_id" value="<?php echo $this->tplData['customRow']['custom_id']; ?>">
        <input type="hidden" name="a" value="submit">

        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['custom']; ?> <span class="text-danger">*</span></label>
                            <input type="text" name="custom_name" id="custom_name" value="<?php echo $this->tplData['customRow']['custom_name']; ?>" data-validate class="form-control">
                            <small class="form-text" id="msg_custom_name"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['size']; ?> <span class="text-danger">*</span></label>
                            <input type="text" name="custom_size" id="custom_size" value="<?php echo $this->tplData['customRow']['custom_size']; ?>" data-validate class="form-control">
                            <small class="form-text" id="msg_custom_size"></small>
                            <small class="form-text"><?php echo $this->lang['mod']['label']['sizeNote']; ?></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['customParent']; ?> <span class="text-danger">*</span></label>
                            <select name="custom_parent_id" id="custom_parent_id" data-validate class="form-control">
                                <option value=""><?php echo $this->lang['mod']['option']['pleaseSelect']; ?></option>
                                <option <?php if ($this->tplData['customRow']['custom_parent_id'] == 0) { ?>selected<?php } ?> value="0"><?php echo $this->lang['mod']['option']['asParent']; ?></option>
                                <?php custom_list_opt($this->tplData['customRows'], $this->tplData['customRow']); ?>
                            </select>
                            <small class="form-text" id="msg_custom_parent_id"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['type']; ?> <span class="text-danger">*</span></label>
                            <select name="custom_type" id="custom_type" data-validate class="form-control">
                                <option value=""><?php echo $this->lang['mod']['option']['pleaseSelect']; ?></option>
                                <?php foreach ($this->tplData['type'] as $key=>$value) { ?>
                                    <option <?php if ($this->tplData['customRow']['custom_type'] == $value) { ?>selected<?php } ?> value="<?php echo $value; ?>">
                                        <?php if (isset($this->lang['mod']['type'][$value]['label'])) {
                                            echo $this->lang['mod']['type'][$value]['label'];
                                        } else {
                                            echo $value;
                                        } ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <small class="form-text" id="msg_custom_type"></small>
                        </div>

                        <?php foreach ($this->tplData['type'] as $key_type=>$value_type) {
                            if ($value_type == "radio" || $value_type == "select") { ?>
                                <div id="group_<?php echo $value_type; ?>" class="group_opt">
                                    <div id="group_<?php echo $value_type; ?>_option">
                                        <?php if (isset($this->lang['mod']['type'][$value_type]['option'])) {
                                            foreach ($this->lang['mod']['type'][$value_type]['option'] as $key_opt=>$value_opt) { ?>
                                                <div class="form-group" id="group_<?php echo $value_type; ?>_<?php echo $key_opt; ?>">
                                                    <div class="input-group">
                                                        <input type="text" name="custom_opt[<?php echo $value_type; ?>][<?php echo $key_opt; ?>]" value="<?php echo $value_opt; ?>" class="form-control">
                                                        <span class="input-group-append">
                                                            <a class="btn btn-info" href="javascript:del_<?php echo $value_type; ?>(<?php echo $key_opt; ?>);">
                                                                <span class="oi oi-trash"></span>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                            <?php }
                                        } ?>
                                    </div>

                                    <div class="form-group">
                                        <a class="btn btn-success" href="javascript:add_<?php echo $value_type; ?>(<?php echo $key_opt + 1; ?>);">
                                            <span class="oi oi-plus"></span>
                                        </a>
                                    </div>
                                </div>
                            <?php }
                        } ?>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['format']; ?> <span class="text-danger">*</span></label>
                            <select name="custom_format" id="custom_format" data-validate class="form-control">
                                <option value=""><?php echo $this->lang['mod']['option']['pleaseSelect']; ?></option>
                                <?php foreach ($this->tplData['format'] as $key=>$value) { ?>
                                    <option <?php if ($this->tplData['customRow']['custom_format'] == $value) { ?>selected<?php } ?> value="<?php echo $value; ?>">
                                        <?php if (isset($this->lang['mod']['format'][$value])) {
                                            echo $this->lang['mod']['format'][$value];
                                        } else {
                                            echo $value;
                                        } ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <small class="form-text" id="msg_custom_format"></small>
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
                        <?php if ($this->tplData['customRow']['custom_id'] > 0) { ?>
                            <div class="form-group">
                                <label><?php echo $this->lang['mod']['label']['id']; ?></label>
                                <div class="form-text"><?php echo $this->tplData['customRow']['custom_id']; ?></div>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['belongCate']; ?> <span class="text-danger">*</span></label>
                            <select name="custom_cate_id" id="custom_cate_id" data-validate class="form-control">
                                <option value=""><?php echo $this->lang['mod']['option']['pleaseSelect']; ?></option>
                                <option <?php if ($this->tplData['customRow']['custom_cate_id'] == 0) { ?>selected<?php } ?> value="0"><?php echo $this->lang['mod']['option']['allCate']; ?></option>
                                <?php cate_list_opt($this->tplData['cateRows'], $this->tplData['customRow']['custom_cate_id'], true); ?>
                            </select>
                            <small class="form-text" id="msg_custom_cate_id"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['status']; ?> <span class="text-danger">*</span></label>
                            <?php foreach ($this->tplData['status'] as $key=>$value) { ?>
                                <div class="form-check">
                                    <label for="custom_status_<?php echo $value; ?>" class="form-check-label">
                                        <input type="radio" name="custom_status" id="custom_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($this->tplData['customRow']['custom_status'] == $value) { ?>checked<?php } ?> data-validate="custom_status" class="form-check-input">
                                        <?php if (isset($this->lang['mod']['status'][$value])) {
                                            echo $this->lang['mod']['status'][$value];
                                        } else {
                                            echo $value;
                                        } ?>
                                    </label>
                                </div>
                            <?php } ?>
                            <small class="form-text" id="msg_custom_status"></small>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <label for="custom_require" class="form-check-label">
                                    <input type="checkbox" id="custom_require" name="custom_require" <?php if ($this->tplData['customRow']['custom_require'] > 0) { ?>checked<?php } ?> value="1" class="form-check-input">
                                    <?php echo $this->lang['mod']['label']['require']; ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_form = {
        custom_name: {
            len: { min: 1, max: 90 },
            validate: { type: "ajax", format: "text" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x200201']; ?>", too_long: "<?php echo $this->lang['rcode']['x200202']; ?>", ajaxIng: "<?php echo $this->lang['rcode']['x030401']; ?>", ajax_err: "<?php echo $this->lang['rcode']['x030402']; ?>" },
            ajax: { url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=custom&c=request&a=chkname", key: "custom_name", type: "str", attach_selectors: ["#custom_id","#custom_type"], attach_keys: ["custom_id","custom_type"] }
        },
        custom_size: {
            len: { min: 9, max: 300 },
            validate: { type: "digit", format: "int" },
            msg: { too_small: "<?php echo $this->lang['rcode']['x200216']; ?>", too_big: "<?php echo $this->lang['rcode']['x200217']; ?>", format_err: "<?php echo $this->lang['rcode']['x200218']; ?>" }
        },
        custom_type: {
            len: { min: 1, max: 0 },
            validate: { type: "select" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x200211']; ?>" }
        },
        custom_format: {
            len: { min: 1, max: 0 },
            validate: { type: "select" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x200205']; ?>" }
        },
        custom_parent_id: {
            len: { min: 1, max: 0 },
            validate: { type: "select" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x200207']; ?>" }
        },
        custom_cate_id: {
            len: { min: 1, max: 0 },
            validate: { type: "select" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x200213']; ?>" }
        },
        custom_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='custom_status']", type: "radio" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x200206']; ?>" }
        }
    };

    var options_validator_form = {
        msg_global:{
            msg: "<?php echo $this->lang['common']['label']['errInput']; ?>"
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=custom&c=request",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    function custom_type(_custom_type) {
        $(".group_opt").hide();
        $("#group_" + _custom_type).show();
    }

    <?php foreach ($this->tplData['type'] as $key_type=>$value_type) {
        if ($value_type == "radio" || $value_type == "select") { ?>
            function del_<?php echo $value_type; ?>(_radio_id) {
                $("#group_<?php echo $value_type; ?>_" + _radio_id).remove();
            }

            function add_<?php echo $value_type; ?>(_count) {
                $("#group_<?php echo $value_type; ?>_option").append("<div class='form-group' id='group_<?php echo $value_type; ?>_" + _count + "'>" +
                    "<div class='input-group'>" +
                        "<input type='text' name='custom_opt[<?php echo $value_type; ?>][]' class='form-control'>" +
                        "<span class='input-group-append'>" +
                            "<a class='btn btn-info' href='javascript:del_<?php echo $value_type; ?>(" + _count + ");'>" +
                                "<span class='oi oi-trash'></span>" +
                            "</a>" +
                        "</span>" +
                    "</div>" +
                "</div>");
            }
        <?php }
    } ?>

    $(document).ready(function(){
        custom_type("<?php echo $this->tplData['customRow']['custom_type']; ?>");
        var obj_validate_form = $("#custom_form").baigoValidator(opts_validator_form, options_validator_form);
        var obj_submit_form   = $("#custom_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
        $("#custom_type").change(function(){
            var _this_val = $(this).val();
            if (typeof _this_val != "undefined") {
                custom_type(_this_val);
            }
        });
    });
    </script>

<?php include('include' . DS . 'html_foot.php');