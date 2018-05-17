    <div class="modal-header">
        <div class="modal-title"><?php echo $this->lang['consoleMod']['article']['main']['title'], ' &raquo; ', $this->lang['consoleMod']['article']['sub']['tag']; ?></div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        <form name="tag_form" id="tag_form">
            <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
            <input type="hidden" name="tag_id" id="tag_id" value="<?php echo $this->tplData['tagRow']['tag_id']; ?>">
            <input type="hidden" name="a" value="submit">
            <?php if ($this->tplData['tagRow']['tag_id'] > 0) { ?>
                <div class="form-group">
                    <label><?php echo $this->lang['mod']['label']['id']; ?></label>
                    <div class="form-text"><?php echo $this->tplData['tagRow']['tag_id']; ?></div>
                </div>
            <?php } ?>

            <div class="form-group">
                <label><?php echo $this->lang['mod']['label']['tag']; ?> <span class="text-danger">*</span></label>
                <input type="text" value="<?php echo $this->tplData['tagRow']['tag_name']; ?>" name="tag_name" id="tag_name" data-validate class="form-control">
                <small class="form-text" id="msg_tag_name"></small>
            </div>

            <div class="form-group">
                <label><?php echo $this->lang['mod']['label']['status']; ?> <span class="text-danger">*</span></label>
                <?php foreach ($this->tplData['status'] as $key=>$value) { ?>
                    <div class="bg-radio">
                        <label for="tag_status_<?php echo $value; ?>">
                            <input type="radio" name="tag_status" id="tag_status_<?php echo $value; ?>" <?php if ($this->tplData['tagRow']['tag_status'] == $value) { ?>checked<?php } ?> value="<?php echo $value; ?>" data-validate="tag_status">
                            <?php if (isset($this->lang['mod']['status'][$value])) {
                                echo $this->lang['mod']['status'][$value];
                            } else {
                                echo $value;
                            } ?>
                        </label>
                    </div>
                <?php } ?>
                <small class="form-text" id="msg_tag_status"></small>
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
        tag_name: {
            len: { min: 1, max: 30 },
            validate: { type: "ajax", format: "text" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x130201']; ?>", too_long: "<?php echo $this->lang['rcode']['x130202']; ?>", ajaxIng: "<?php echo $this->lang['rcode']['x030401']; ?>", ajax_err: "<?php echo $this->lang['rcode']['x030402']; ?>" },
            ajax: { url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=tag&c=request&a=chkname", key: 'tag_name', type: "str", attach_selectors: ["#tag_id"], attach_keys: ["tag_id"] }
        },
        tag_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='tag_status']", type: "radio" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x130204']; ?>" }
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
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=tag&c=request",
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
        var obj_validate_form = $("#tag_form").baigoValidator(opts_validator_form, options_validator_form);
        var obj_submit_form   = $("#tag_form").baigoSubmit(opts_submit_form);
        $(".bg-submit-modal").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
    });
    </script>