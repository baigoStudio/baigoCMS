    <form name="admin_form" id="admin_form">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="a" value="toGroup">
        <input type="hidden" name="admin_id" value="<?php echo $this->tplData['adminRow']['admin_id']; ?>">
        <div class="modal-header">
            <div class="modal-title"><?php echo $this->lang['consoleMod']['admin']['main']['title']; ?> - <?php echo $this->lang['mod']['href']['toGroup']; ?></div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <div class="form-group">
                <label><?php echo $this->lang['mod']['label']['id']; ?></label>
                <div class="form-text"><?php echo $this->tplData['adminRow']['admin_id']; ?></div>
            </div>

            <div class="form-group">
                <label><?php echo $this->lang['mod']['label']['username']; ?></label>
                <div class="form-text"><?php echo $this->tplData['ssoRow']['user_name']; ?></div>
            </div>

            <div class="form-group">
                <label><?php echo $this->lang['mod']['label']['adminGroup']; ?> <span class="text-danger">*</span></label>
                <select name="group_id" id="group_id" data-validate class="form-control">
                    <option value=""><?php echo $this->lang['mod']['option']['pleaseSelect']; ?></option>
                    <option <?php if ($this->tplData['adminRow']['admin_group_id'] == 0) { ?>selected<?php } ?> value="0"><?php echo $this->lang['mod']['option']['noGroup']; ?></option>
                    <?php foreach ($this->tplData['groupRows'] as $key=>$value) { ?>
                        <option <?php if ($this->tplData['adminRow']['admin_group_id'] == $value['group_id']) { ?>selected<?php } ?> value="<?php echo $value['group_id']; ?>"><?php echo $value['group_name']; ?></option>
                    <?php } ?>
                </select>
                <small class="form-text" id="msg_group_id"></small>
            </div>

            <div class="bg-submit-box bg-submit-box-modal"></div>
            <div class="bg-validator-box mt-3 bg-validator-box-modal"></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary bg-submit-modal"><?php echo $this->lang['mod']['btn']['save']; ?></button>
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><?php echo $this->lang['common']['btn']['close']; ?></button>
        </div>
    </form>

    <script type="text/javascript">
    var opts_validator_form = {
        group_id: {
            len: { min: 1, max: 0 },
            validate: { type: "select" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x020214']; ?>" }
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
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=admin&c=request",
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
        var obj_validate_form  = $("#admin_form").baigoValidator(opts_validator_form, options_validator_form);
        var obj_submit_form    = $("#admin_form").baigoSubmit(opts_submit_form);
        $(".bg-submit-modal").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
    });
    </script>
