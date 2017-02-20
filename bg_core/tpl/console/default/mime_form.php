    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <?php echo $this->consoleMod["attach"]["main"]["title"] . " &raquo; " . $this->consoleMod["attach"]["sub"]["mime"]["title"]; ?>
    </div>
    <div class="modal-body">

        <form name="mime_form" id="mime_form">
            <input type="hidden" name="<?php echo $this->common["tokenRow"]["name_session"]; ?>" value="<?php echo $this->common["tokenRow"]["token"]; ?>">
            <input type="hidden" name="mime_id" id="mime_id" value="<?php echo $this->tplData["mimeRow"]["mime_id"]; ?>">
            <input type="hidden" name="act" value="submit">

            <?php if ($this->tplData["mimeRow"]["mime_id"] > 0) { ?>
                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang["label"]["id"]; ?></label>
                    <div class="form-control-static"><?php echo $this->tplData["mimeRow"]["mime_id"]; ?></div>
                </div>
            <?php } ?>

            <div class="form-group">
                <label class="control-label"><?php echo $this->lang["label"]["mimeName"]; ?><span id="msg_mime_name">*</span></label>
                <input type="text" name="mime_name" id="mime_name" value="<?php echo $this->tplData["mimeRow"]["mime_name"]; ?>" data-validate class="form-control">
            </div>

            <div class="form-group">
                <label class="control-label"><?php echo $this->lang["label"]["ext"]; ?><span id="msg_mime_ext">*</span></label>
                <input type="text" name="mime_ext" id="mime_ext" value="<?php echo $this->tplData["mimeRow"]["mime_ext"]; ?>" data-validate class="form-control">
            </div>

            <div class="form-group">
                <label class="control-label"><?php echo $this->lang["label"]["note"]; ?><span id="msg_mime_note"></span></label>
                <input type="text" name="mime_note" id="mime_note" value="<?php echo $this->tplData["mimeRow"]["mime_note"]; ?>" data-validate class="form-control">
            </div>

            <div class="form-group">
                <label class="control-label"><?php echo $this->lang["label"]["mimeOften"]; ?></label>
                <select id="mime_name_often" class="form-control">
                    <option value=""><?php echo $this->lang["option"]["pleaseSelect"]; ?></option>
                    <?php foreach ($this->tplData["mimeOften"] as $key=>$value) { ?>
                        <option value="<?php echo $key; ?>"><?php echo $key; ?> [<?php echo $value["note"]; ?>]</option>
                    <?php } ?>
                </select>
            </div>

        </form>

        <div class="bg-submit-box bg-submit-box-modal"></div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary bg-submit-modal"><?php echo $this->lang["btn"]["save"]; ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang["btn"]["cancel"]; ?></button>
    </div>

    <script type="text/javascript">
    var obj_mime_list = <?php echo $this->tplData["mimeJson"]; ?>;

    var opts_validator_form = {
        mime_name: {
            len: { min: 1, max: 300 },
            validate: { type: "ajax", format: "text" },
            msg: { selector: "#msg_mime_name", too_short: "<?php echo $this->rcode["x080201"]; ?>", too_long: "<?php echo $this->rcode["x080202"]; ?>", ajaxIng: "<?php echo $this->rcode["x030401"]; ?>", ajax_err: "<?php echo $this->rcode["x030402"]; ?>" },
            ajax: { url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=mime&act=chkname", key: "mime_name", type: "str" }
        },
        mime_ext: {
            len: { min: 1, max: 10 },
            validate: { type: "str", format: "text" },
            msg: { selector: "#msg_mime_ext", too_short: "<?php echo $this->rcode["x080203"]; ?>", too_long: "<?php echo $this->rcode["x080204"]; ?>" }
        },
        mime_note: {
            len: { min: 0, max: 300 },
            validate: { type: "str", format: "text" },
            msg: { selector: "#msg_mime_note", too_long: "<?php echo $this->rcode["x080205"]; ?>" }
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=mime",
        msg_text: {
            submitting: "<?php echo $this->lang["label"]["submitting"]; ?>"
        },
        box: {
            selector: ".bg-submit-box-modal"
        },
        selector: {
            submit_btn: ".bg-submit-modal"
        }
    };

    $(document).ready(function(){
        var obj_validate_form = $("#mime_form").baigoValidator(opts_validator_form);
        var obj_submit_form = $("#mime_form").baigoSubmit(opts_submit_form);
        $(".bg-submit-modal").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
        //常用MIME
        $("#mime_name_often").change(function(){
            var _this_val = $(this).val();
            if (_this_val.length > 0) {
                var _this_ext = obj_mime_list[_this_val].ext;
                var _this_note = obj_mime_list[_this_val].note;
                $("#mime_name").val(_this_val);
                $("#mime_ext").val(_this_ext);
                $("#mime_note").val(_this_note);
            }
        });
    });
    </script>