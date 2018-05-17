    <div class="modal-header">
        <div class="modal-title"><?php echo $this->lang['consoleMod']['article']['main']['title'], ' &raquo; ', $this->lang['consoleMod']['article']['sub']['mark']; ?></div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        <form name="mark_form" id="mark_form">
            <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
            <input type="hidden" name="mark_id" id="mark_id" value="<?php echo $this->tplData['markRow']['mark_id']; ?>">
            <input type="hidden" name="a" value="submit">

            <?php if ($this->tplData['markRow']['mark_id'] > 0) { ?>
                <div class="form-group">
                    <label><?php echo $this->lang['mod']['label']['id']; ?></label>
                    <div class="form-text"><?php echo $this->tplData['markRow']['mark_id']; ?></div>
                </div>
            <?php } ?>

            <div class="form-group">
                <label><?php echo $this->lang['mod']['label']['mark']; ?> <span class="text-danger">*</span></label>
                <input type="text" name="mark_name" id="mark_name" value="<?php echo $this->tplData['markRow']['mark_name']; ?>" data-validate class="form-control">
                <small class="form-text" id="msg_mark_name"></small>
            </div>
        </form>

        <div class="bg-submit-box bg-submit-box-modal"></div>
        <div class="bg-validator-box mt-3 bg-validator-box-modal"></div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary bg-submit-modal"><?php echo $this->lang['mod']['btn']['save']; ?></button>
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><?php echo $this->lang['common']['btn']['close']; ?></button>
    </div>

    <script type="text/javascript">
    var opts_validator_form = {
        mark_name: {
            len: { min: 1, max: 30 },
            validate: { type: "ajax", format: "text" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x140201']; ?>", too_long: "<?php echo $this->lang['rcode']['x140202']; ?>", ajaxIng: "<?php echo $this->lang['rcode']['x030401']; ?>", ajax_err: "<?php echo $this->lang['rcode']['x030402']; ?>" },
            ajax: { url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=mark&c=request&a=chkname", key: "mark_name", type: "str", attach_selectors: ["#mark_id"], attach_keys: ["mark_id"] }
        }
    };

    var options_validator_form = {
        msg_global:{
            selector: {
                parent: "#bg-validator-box-modal"
            },
            msg: "<?php echo $this->lang['common']['label']['errInput']; ?>"
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=mark&c=request",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        },
        box: {
            selector: ".bg-submit-box-modal"
        },
        selector: {
            submit_btn: ".bg-submit-modal"
        }
    };

    $(document).ready(function(){
        var obj_validate_form = $("#mark_form").baigoValidator(opts_validator_form, options_validator_form);
        var obj_submit_form   = $("#mark_form").baigoSubmit(opts_submit_form);
        $(".bg-submit-modal").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
    });
    </script>