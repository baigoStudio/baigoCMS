    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <?php echo $this->consoleMod["article"]["main"]["title"] . " &raquo; " . $this->consoleMod["article"]["sub"]["mark"]["title"]; ?>
    </div>
    <div class="modal-body">

        <form name="mark_form" id="mark_form">
            <input type="hidden" name="<?php echo $this->common["tokenRow"]["name_session"]; ?>" value="<?php echo $this->common["tokenRow"]["token"]; ?>">
            <input type="hidden" name="mark_id" id="mark_id" value="<?php echo $this->tplData["markRow"]["mark_id"]; ?>">
            <input type="hidden" name="act" value="submit">

            <?php if ($this->tplData["markRow"]["mark_id"] > 0) { ?>
                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang["label"]["id"]; ?></label>
                    <div class="form-control-static"><?php echo $this->tplData["markRow"]["mark_id"]; ?></div>
                </div>
            <?php } ?>

            <div class="form-group">
                <label class="control-label"><?php echo $this->lang["label"]["markName"]; ?><span id="msg_mark_name">*</span></label>
                <input type="text" name="mark_name" id="mark_name" value="<?php echo $this->tplData["markRow"]["mark_name"]; ?>" data-validate class="form-control">
            </div>
        </form>

        <div class="bg-submit-box bg-submit-box-modal"></div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary bg-submit-modal"><?php echo $this->lang["btn"]["save"]; ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang["btn"]["cancel"]; ?></button>
    </div>

    <script type="text/javascript">
    var opts_validator_form = {
        mark_name: {
            len: { min: 1, max: 30 },
            validate: { type: "ajax", format: "text" },
            msg: { selector: "#msg_mark_name", too_short: "<?php echo $this->rcode["x140201"]; ?>", too_long: "<?php echo $this->rcode["x140202"]; ?>", ajaxIng: "<?php echo $this->rcode["x030401"]; ?>", ajax_err: "<?php echo $this->rcode["x030402"]; ?>" },
            ajax: { url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=mark&act=chkname", key: "mark_name", type: "str", attach_selectors: ["#mark_id"], attach_keys: ["mark_id"] }
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=mark",
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
        var obj_validate_form = $("#mark_form").baigoValidator(opts_validator_form);
        var obj_submit_form   = $("#mark_form").baigoSubmit(opts_submit_form);
        $(".bg-submit-modal").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
    });
    </script>