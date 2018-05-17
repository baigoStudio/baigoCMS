<?php if ($this->tplData['cateRow']['cate_id'] < 1) {
    $title_sub    = $this->lang['mod']['page']['add'];
    $sub_active   = 'form';
} else {
    $title_sub    = $this->lang['mod']['page']['edit'];
    $sub_active   = 'list';
}

$cfg = array(
    'title'          => $this->lang['consoleMod']['cate']['main']['title'] . ' &raquo; ' . $title_sub,
    'menu_active'    => 'cate',
    'sub_active'     => $sub_active,
    'tinymce'        => 'true',
    'baigoSubmit'    => 'true',
    'baigoValidator' => 'true',
    'upload'         => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?m=cate",
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=cate&a=list" class="nav-link">
                <span class="oi oi-chevron-left"></span>
                <?php echo $this->lang['common']['href']['back']; ?>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo BG_URL_HELP; ?>index.php?m=console&a=cate#form" class="nav-link" target="_blank">
                <span class="badge badge-pill badge-primary">
                    <span class="oi oi-question-mark"></span>
                </span>
                <?php echo $this->lang['mod']['href']['help']; ?>
            </a>
        </li>
    </ul>

    <form name="cate_form" id="cate_form">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="a" value="submit">
        <input type="hidden" name="cate_id" id="cate_id" value="<?php echo $this->tplData['cateRow']['cate_id']; ?>">

        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['cateName']; ?> <span class="text-danger">*</span></label>
                            <input type="text" name="cate_name" id="cate_name" value="<?php echo $this->tplData['cateRow']['cate_name']; ?>" data-validate class="form-control">
                            <small class="form-text" id="msg_cate_name"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['cateAlias']; ?></label>
                            <input type="text" name="cate_alias" id="cate_alias" value="<?php echo $this->tplData['cateRow']['cate_alias']; ?>" data-validate class="form-control">
                            <small class="form-text" id="msg_cate_alias"></small>
                        </div>

                        <div class="form-group" id="item_cate_perpage">
                            <label><?php echo $this->lang['mod']['label']['catePerpage']; ?> <span class="text-danger">*</span></label>
                            <input type="text" name="cate_perpage" id="cate_perpage" value="<?php echo $this->tplData['cateRow']['cate_perpage']; ?>" data-validate class="form-control">
                            <small class="form-text" id="msg_cate_perpage"></small>
                        </div>

                        <?php if ($this->tplData['cateRow']['cate_parent_id'] < 1) { ?>
                            <div class="form-group">
                                <label><?php echo $this->lang['mod']['label']['cateDomain']; ?></label>
                                <input type="text" name="cate_domain" id="cate_domain" value="<?php echo $this->tplData['cateRow']['cate_domain']; ?>" data-validate class="form-control">
                                <small class="form-text" id="msg_cate_domain"></small>
                                <small class="form-text"><?php echo $this->lang['mod']['label']['cateDomainNote']; ?></small>
                            </div>
                        <?php } ?>

                        <div id="item_cate_content">
                            <div class="form-group">
                                <a class="btn btn-success" data-toggle="modal" href="#cate_modal">
                                    <span class="oi oi-image"></span>
                                    <?php echo $this->lang['mod']['href']['uploadList']; ?>
                                </a>
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->lang['mod']['label']['cateContent']; ?></label>
                                <textarea name="cate_content" id="cate_content" class="tinymce bg-textarea-lg"><?php echo $this->tplData['cateRow']['cate_content']; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group" id="item_cate_link">
                            <label><?php echo $this->lang['mod']['label']['cateLink']; ?></label>
                            <input type="text" name="cate_link" id="cate_link" value="<?php echo $this->tplData['cateRow']['cate_link']; ?>" data-validate class="form-control">
                            <small class="form-text" id="msg_cate_link"></small>
                        </div>

                        <?php if (BG_MODULE_GEN > 0 && BG_MODULE_FTP > 0 && $this->tplData['cateRow']['cate_parent_id'] < 1) { ?>
                            <div class="form-check">
                                <label for="more_checkbox" class="form-check-label">
                                    <input type="checkbox" id="more_checkbox" name="more_checkbox" <?php if (!fn_isEmpty($this->tplData['cateRow']['cate_ftp_host'])) { ?>checked<?php } ?> class="form-check-input">
                                    <?php echo $this->lang['mod']['label']['more']; ?>
                                </label>
                            </div>

                            <div id="more_input">
                                <div class="form-group">
                                    <label><?php echo $this->lang['mod']['label']['ftpServ']; ?></label>
                                    <input type="text" name="cate_ftp_host" id="cate_ftp_host" value="<?php echo $this->tplData['cateRow']['cate_ftp_host']; ?>" class="form-control">
                                    <small class="form-text" id="msg_cate_ftp_host"></small>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $this->lang['mod']['label']['ftpPort']; ?></label>
                                    <input type="text" name="cate_ftp_port" id="cate_ftp_port" value="<?php echo $this->tplData['cateRow']['cate_ftp_port']; ?>" class="form-control">
                                    <small class="form-text" id="msg_cate_ftp_port"></small>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $this->lang['mod']['label']['ftpUser']; ?></label>
                                    <input type="text" name="cate_ftp_user" id="cate_ftp_user" value="<?php echo $this->tplData['cateRow']['cate_ftp_user']; ?>" class="form-control">
                                    <small class="form-text" id="msg_cate_ftp_user"></small>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $this->lang['mod']['label']['ftpPass']; ?></label>
                                    <input type="text" name="cate_ftp_pass" id="cate_ftp_pass" value="<?php echo $this->tplData['cateRow']['cate_ftp_pass']; ?>" class="form-control">
                                    <small class="form-text" id="msg_cate_ftp_pass"></small>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $this->lang['mod']['label']['ftpPath']; ?></label>
                                    <input type="text" name="cate_ftp_path" id="cate_ftp_path" value="<?php echo $this->tplData['cateRow']['cate_ftp_path']; ?>" class="form-control">
                                    <small class="form-text" id="msg_cate_ftp_path"></small>
                                    <small class="form-text"><?php echo $this->lang['mod']['label']['ftpPathNote']; ?></small>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $this->lang['mod']['label']['ftpPasv']; ?></label>
                                    <?php foreach ($this->tplData['pasv'] as $key=>$value) { ?>
                                        <div class="form-check">
                                            <label for="cate_ftp_pasv_<?php echo $value; ?>" class="form-check-label">
                                                <input type="radio" name="cate_ftp_pasv" id="cate_ftp_pasv_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($this->tplData['cateRow']['cate_ftp_pasv'] == $value) { ?>checked<?php } ?> class="form-check-input">
                                                <?php if (isset($this->lang['mod']['status'][$value])) {
                                                    echo $this->lang['mod']['status'][$value];
                                                } else {
                                                    echo $value;
                                                } ?>
                                            </label>
                                        </div>
                                    <?php } ?>
                                    <small class="form-text" id="msg_cate_ftp_pasv"></small>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="bg-submit-box"></div>
                        <div class="bg-validator-box mt-3"></div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['save']; ?></button>
                        <?php if ($this->tplData['cateRow']['cate_id'] > 0) { ?>
                            <button type="button" class="btn btn-outline-secondary bg-duplicate"><?php echo $this->lang['mod']['btn']['duplicate']; ?></button>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body">
                        <?php if ($this->tplData['cateRow']['cate_id'] > 0) { ?>
                            <div class="form-group">
                                <label><?php echo $this->lang['mod']['label']['id']; ?></label>
                                <div class="form-text"><?php echo $this->tplData['cateRow']['cate_id']; ?></div>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['belongCate']; ?> <span class="text-danger">*</span></label>
                            <select name="cate_parent_id" id="cate_parent_id" data-validate class="form-control">
                                <option value=""><?php echo $this->lang['mod']['option']['pleaseSelect']; ?></option>
                                <option <?php if ($this->tplData['cateRow']['cate_parent_id'] == 0) { ?>selected<?php } ?> value="0"><?php echo $this->lang['mod']['option']['asParent']; ?></option>
                                <?php cate_list_opt($this->tplData['cateRows'], $this->tplData['cateRow']['cate_parent_id']); ?>
                            </select>
                            <small class="form-text" id="msg_cate_parent_id"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['tpl']; ?> <span class="text-danger">*</span></label>
                            <select name="cate_tpl" id="cate_tpl" data-validate class="form-control">
                                <option value=""><?php echo $this->lang['mod']['option']['pleaseSelect']; ?></option>
                                <option <?php if (isset($this->tplData['cateRow']['cate_tpl']) && $this->tplData['cateRow']['cate_tpl'] == "inherit") { ?>selected<?php } ?> value="inherit"><?php echo $this->lang['mod']['option']['tplInherit']; ?></option>
                                <?php foreach ($this->tplData['tplRows'] as $key=>$value) {
                                    if ($value['type'] == "dir") { ?>
                                        <option <?php if (isset($this->tplData['cateRow']['cate_tpl']) && $this->tplData['cateRow']['cate_tpl'] == $value['name']) { ?>selected<?php } ?> value="<?php echo $value['name']; ?>"><?php echo $value['name']; ?></option>
                                    <?php }
                                } ?>
                            </select>
                            <small class="form-text" id="msg_cate_tpl"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['type']; ?> <span class="text-danger">*</span></label>
                            <?php foreach ($this->tplData['type'] as $key=>$value) { ?>
                                <div class="form-check">
                                    <label for="cate_type_<?php echo $value; ?>" class="form-check-label">
                                        <input type="radio" name="cate_type" id="cate_type_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($this->tplData['cateRow']['cate_type'] == $value) { ?>checked<?php } ?> data-validate="cate_type" class="form-check-input">
                                        <?php if (isset($this->lang['mod']['type'][$value])) {
                                            echo $this->lang['mod']['type'][$value];
                                        } else {
                                            echo $value;
                                        } ?>
                                    </label>
                                </div>
                            <?php } ?>
                            <small class="form-text" id="msg_cate_type"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['status']; ?> <span class="text-danger">*</span></label>
                            <?php foreach ($this->tplData['status'] as $key=>$value) { ?>
                                <div class="form-check">
                                    <label for="cate_status_<?php echo $value; ?>" class="form-check-label">
                                        <input type="radio" name="cate_status" id="cate_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($this->tplData['cateRow']['cate_status'] == $value) { ?>checked<?php } ?> data-validate="cate_status" class="form-check-input">
                                        <?php if (isset($this->lang['mod']['status'][$value])) {
                                            echo $this->lang['mod']['status'][$value];
                                        } else {
                                            echo $value;
                                        } ?>
                                    </label>
                                </div>
                            <?php } ?>
                            <small class="form-text" id="msg_cate_status"></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form name="cate_duplicate" id="cate_duplicate">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="a" value="duplicate">
        <input type="hidden" name="cate_id" id="cate_id" value="<?php echo $this->tplData['cateRow']['cate_id']; ?>">
    </form>

    <div class="modal fade" id="cate_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_form = {
        cate_name: {
            len: { min: 1, max: 300 },
            validate: { type: "ajax", format: "text" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x250201']; ?>", too_long: "<?php echo $this->lang['rcode']['x250202']; ?>", ajaxIng: "<?php echo $this->lang['rcode']['x030401']; ?>", ajax_err: "<?php echo $this->lang['rcode']['x030402']; ?>" },
            ajax: { url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=cate&c=request&a=chkname", key: 'cate_name', type: "str", attach_selectors: ["#cate_id","#cate_parent_id"], attach_keys: ["cate_id","cate_parent_id"] }
        },
        cate_alias: {
            len: { min: 0, max: 300 },
            validate: { type: "ajax", format: "alias" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x250204']; ?>", format_err: "<?php echo $this->lang['rcode']['x250205']; ?>", ajaxIng: "<?php echo $this->lang['rcode']['x030401']; ?>", ajax_err: "<?php echo $this->lang['rcode']['x030402']; ?>" },
            ajax: { url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=cate&c=request&a=chkalias", key: 'cate_alias', type: "str", attach_selectors: ["#cate_id","#cate_parent_id"], attach_keys: ["cate_id","cate_parent_id"] }
        },
        cate_link: {
            len: { min: 0, max: 3000 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x250211']; ?>" }
        },
        cate_parent_id: {
            len: { min: 1, max: 0 },
            validate: { type: "select" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x250213']; ?>" }
        },
        cate_tpl: {
            len: { min: 1, max: 0 },
            validate: { type: "select" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x250214']; ?>" }
        },
        cate_type: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='cate_type']", type: "radio" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x250215']; ?>" }
        },
        cate_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='cate_status']", type: "radio" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x250216']; ?>" }
        },
        cate_domain: {
            len: { min: 0, max: 3000 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x250207']; ?>", format_err: "<?php echo $this->lang['rcode']['x250208']; ?>" }
        },
        cate_perpage: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: 'int' },
            msg: { too_short: "<?php echo $this->lang['rcode']['x250223']; ?>", format_err: "<?php echo $this->lang['rcode']['x250224']; ?>" }
        }
    };

    var options_validator_form = {
        msg_global:{
            msg: "<?php echo $this->lang['common']['label']['errInput']; ?>"
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=cate&c=request",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    var opts_duplicate_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=cate&c=request",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    function cate_type(cate_type) {
        switch (cate_type) {
            case "single":
                $("#item_cate_perpage").hide();
                $("#item_cate_content").show();
                $("#item_cate_link").hide();
            break;

            case 'link':
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
        cate_type("<?php echo $this->tplData['cateRow']['cate_type']; ?>");
        show_more();

        $("#cate_modal").on("shown.bs.modal", function() {
            $("#cate_modal .modal-content").load("<?php echo BG_URL_CONSOLE; ?>index.php?m=attach&a=form&view=modal");
    	}).on("hidden.bs.modal", function(){
        	$("#cate_modal .modal-content").empty();
    	});

        $("#cate_parent_id").change(function(){
            show_more();
        });
        var obj_validate_form  = $("#cate_form").baigoValidator(opts_validator_form, options_validator_form);
        var obj_submit_form    = $("#cate_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            tinyMCE.triggerSave();
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });

        var obj_duplicate_form   = $("#cate_duplicate").baigoSubmit(opts_duplicate_form);
        $(".bg-duplicate").click(function(){
            tinyMCE.triggerSave();
            obj_duplicate_form.formSubmit();
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

<?php include('include' . DS . 'html_foot.php');