    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <?php echo $this->lang['consoleMod']['attach']['main']['title'], ' &raquo; ', $this->lang['consoleMod']['attach']['sub']['thumb']; ?>
    </div>
    <div class="modal-body">
        <form name="thumb_form" id="thumb_form">

            <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
            <input type="hidden" name="thumb_id" value="<?php echo $this->tplData['thumbRow']['thumb_id']; ?>">
            <input type="hidden" name="act" value="submit">

            <?php if ($this->tplData['thumbRow']['thumb_id'] > 0) { ?>
                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang['mod']['label']['id']; ?></label>
                    <div class="form-control-static"><?php echo $this->tplData['thumbRow']['thumb_id']; ?></div>
                </div>
            <?php } ?>

            <div class="form-group">
                <label class="control-label"><?php echo $this->lang['mod']['label']['thumbWidth']; ?><span id="msg_thumb_width">*</span></label>
                <input type="text" name="thumb_width" id="thumb_width" value="<?php echo $this->tplData['thumbRow']['thumb_width']; ?>" data-validate class="form-control">
            </div>

            <div class="form-group">
                <label class="control-label"><?php echo $this->lang['mod']['label']['thumbHeight']; ?><span id="msg_thumb_height">*</span></label>
                <input type="text" name="thumb_height" id="thumb_height" value="<?php echo $this->tplData['thumbRow']['thumb_height']; ?>" data-validate class="form-control">
            </div>

            <div class="form-group">
                <div id="group_thumb_type">
                    <label class="control-label"><?php echo $this->lang['mod']['label']['thumbType']; ?><span id="msg_thumb_type">*</span></label>
                    <?php foreach ($this->tplData['type'] as $key=>$value) { ?>
                        <div class="bg-radio">
                            <label for="thumb_type_<?php echo $value; ?>">
                                <input type="radio" name="thumb_type" id="thumb_type_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($this->tplData['thumbRow']['thumb_type'] == $value) { ?>checked<?php } ?> data-validate="thumb_type">
                                <?php if (isset($this->lang['mod']['type'][$value])) {
                                    echo $this->lang['mod']['type'][$value];
                                } else {
                                    echo $value;
                                } ?>
                            </label>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </form>

        <div class="bg-submit-box bg-submit-box-modal"></div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary bg-submit-modal"><?php echo $this->lang['mod']['btn']['save']; ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang['common']['btn']['close']; ?></button>
    </div>

    <script type="text/javascript">
    var opts_validator_form = {
        thumb_width: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "int" },
            msg: { selector: "#msg_thumb_width", too_short: "<?php echo $this->lang['rcode']['x090201']; ?>", format_err: "<?php echo $this->lang['rcode']['x090202']; ?>" }
        },
        thumb_height: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "int" },
            msg: { selector: "#msg_thumb_height", too_short: "<?php echo $this->lang['rcode']['x090203']; ?>", format_err: "<?php echo $this->lang['rcode']['x090204']; ?>" }
        },
        thumb_type: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='thumb_type']", type: "radio", group: "#group_thumb_type" },
            msg: { selector: "#msg_thumb_type", too_few: "<?php echo $this->lang['rcode']['x090205']; ?>" }
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=thumb",
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
        var obj_validate_form = $("#thumb_form").baigoValidator(opts_validator_form);
        var obj_submit_form   = $("#thumb_form").baigoSubmit(opts_submit_form);
        $(".bg-submit-modal").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
    });
    </script>