<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['attach']['main']['title'] . ' &raquo; ' . $this->lang['consoleMod']['attach']['sub']['mime'],
    'menu_active'    => 'attach',
    'sub_active'     => 'mime',
    'baigoCheckall'  => 'true',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?m=mime&a=list"
);

include($cfg['pathInclude'] . 'console_head.php'); ?>

    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=mime&a=list" class="nav-link">
                <span class="oi oi-chevron-left"></span>
                <?php echo $this->lang['common']['href']['back']; ?>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo BG_URL_HELP; ?>index.php?m=console&a=attach#mime" class="nav-link" target="_blank">
                <span class="badge badge-pill badge-primary">
                    <span class="oi oi-question-mark"></span>
                </span>
                <?php echo $this->lang['mod']['href']['help']; ?>
            </a>
        </li>
    </ul>

    <form name="mime_form" id="mime_form">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="mime_id" id="mime_id" value="<?php echo $this->tplData['mimeRow']['mime_id']; ?>">
        <input type="hidden" name="a" value="submit">

        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['ext']; ?> <span class="text-danger">*</span></label>
                            <input type="text" name="mime_ext" id="mime_ext" value="<?php echo $this->tplData['mimeRow']['mime_ext']; ?>" data-validate class="form-control">
                            <small class="form-text" id="msg_mime_ext"></small>
                        </div>

                        <label><?php echo $this->lang['mod']['label']['mimeContent']; ?> <span class="text-danger">*</span></label>

                        <div id="mime_list">
                            <?php $key = 0;
                            foreach ($this->tplData['mimeRow']['mime_content'] as $key=>$value) { ?>
                                <div id="mime_group_<?php echo $key; ?>">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" name="mime_content[]" id="mime_content_<?php echo $key; ?>" value="<?php echo $value; ?>" class="form-control">
                                            <span class="input-group-append">
                                                <a href="javascript:mime_del(<?php echo $key; ?>);" class="btn btn-info">
                                                    <span class="oi oi-trash"></span>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="form-group">
                            <button type="button" id="mime_add" class="btn btn-info">
                                <span class="oi oi-plus"></span>
                                <?php echo $this->lang['mod']['btn']['mimeAdd']; ?>
                            </button>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['note']; ?></label>
                            <input type="text" name="mime_note" id="mime_note" value="<?php echo $this->tplData['mimeRow']['mime_note']; ?>" data-validate class="form-control">
                            <small class="form-text" id="msg_mime_note"></small>
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
                        <?php if ($this->tplData['mimeRow']['mime_id'] > 0) { ?>
                            <div class="form-group">
                                <label><?php echo $this->lang['mod']['label']['id']; ?></label>
                                <div class="form-text"><?php echo $this->tplData['mimeRow']['mime_id']; ?></div>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label form="mime_often"><?php echo $this->lang['mod']['label']['mimeOften']; ?></label>
                            <select id="mime_often" class="form-control">
                                <option value=""><?php echo $this->lang['mod']['option']['pleaseSelect']; ?></option>
                                <?php foreach ($this->tplData['mimeOften'] as $key_often=>$value_often) { ?>
                                    <option value="<?php echo $key_often; ?>">
                                        <?php if (isset($this->lang['mime'][$key_often]['note'])) {
                                            echo $this->lang['mime'][$key_often]['note'], ' - ';
                                        }
                                        echo $key_often; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var obj_mime_often  = <?php echo $this->tplData['mimeOftenJson']; ?>;
    var obj_mime_lang   = <?php echo $this->lang['mimeJson']; ?>;

    var opts_validator_form = {
        mime_ext: {
            len: { min: 1, max: 30 },
            validate: { type: "ajax", format: "text" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x080203']; ?>", too_long: "<?php echo $this->lang['rcode']['x080204']; ?>", ajaxIng: "<?php echo $this->lang['rcode']['x030401']; ?>", ajax_err: "<?php echo $this->lang['rcode']['x030402']; ?>" },
            ajax: { url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=mime&c=request&a=chkext", key: "mime_ext", type: "str", attach_selectors: ["#mime_id"], attach_keys: ["mime_id"] }
        },
        mime_note: {
            len: { min: 0, max: 300 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x080205']; ?>" }
        }
    };

    var options_validator_form = {
        msg_global:{
            msg: "<?php echo $this->lang['common']['label']['errInput']; ?>"
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=mime&c=request",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    function mime_del(_mime_id) {
        $("#mime_group_" + _mime_id).remove();
    }

    function mime_form_process(count_mime, value_mime) {
       var _str_form = "<div id=\"mime_group_" + count_mime + "\">" +
            "<div class=\"form-group\">" +
                "<div class=\"input-group\">" +
                    "<input type=\"text\" name=\"mime_content[]\" id=\"mime_content_" + count_mime + "\" class=\"form-control\" value=\"" + value_mime + "\">" +
                    "<span class=\"input-group-append\">" +
                        "<a href=\"javascript:mime_del(" + count_mime + ");\" class=\"btn btn-info\">" +
                            "<span class=\"oi oi-trash\"></span>" +
                        "</a>" +
                    "</span>" +
                "</div>" +
            "</div>" +
        "</div>";

        return _str_form;
    }

    $(document).ready(function(){
        var _count_mime = <?php echo $key++; ?>;

        var obj_validate_form   = $("#mime_form").baigoValidator(opts_validator_form, options_validator_form);
        var obj_submit_form     = $("#mime_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
        //常用MIME
        $("#mime_often").change(function(){
            var _this_ext   = $(this).val();
            var _this_note  = "";
            var _str_form   = "";
            if (typeof _this_ext != "undefined") {
                if (typeof obj_mime_lang[_this_ext].note != "undefined") {
                    _this_note  = obj_mime_lang[_this_ext].note;
                }
                $("#mime_ext").val(_this_ext);
                $("#mime_note").val(_this_note);
                $.each(obj_mime_often[_this_ext], function(_key, _value){
                    _count_mime++;
                    _str_form += mime_form_process(_count_mime, _value);
                });
                $("#mime_list").html(_str_form);
            }
        });

        $("#mime_add").click(function(){
            _count_mime++;
            _str_form = mime_form_process(_count_mime, '');
            $("#mime_list").append(_str_form);
        });
    });
    </script>

<?php include('include' . DS . 'html_foot.php');