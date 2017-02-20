    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <?php echo $this->consoleMod["attach"]["main"]["title"] . " &raquo; " . $this->consoleMod["attach"]["sub"]["thumb"]["title"]; ?>
    </div>
    <div class="modal-body">
        <form name="thumb_form" id="thumb_form">

            <input type="hidden" name="<?php echo $this->common["tokenRow"]["name_session"]; ?>" value="<?php echo $this->common["tokenRow"]["token"]; ?>">
            <input type="hidden" name="thumb_id" value="<?php echo $this->tplData["thumbRow"]["thumb_id"]; ?>">
            <input type="hidden" name="act" value="submit">

            <?php if ($this->tplData["thumbRow"]["thumb_id"] > 0) { ?>
                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang["label"]["id"]; ?></label>
                    <div class="form-control-static"><?php echo $this->tplData["thumbRow"]["thumb_id"]; ?></div>
                </div>
            <?php } ?>

            <div class="form-group">
                <label class="control-label"><?php echo $this->lang["label"]["thumbWidth"]; ?><span id="msg_thumb_width">*</span></label>
                <input type="text" name="thumb_width" id="thumb_width" value="<?php echo $this->tplData["thumbRow"]["thumb_width"]; ?>" data-validate class="form-control">
            </div>

            <div class="form-group">
                <label class="control-label"><?php echo $this->lang["label"]["thumbHeight"]; ?><span id="msg_thumb_height">*</span></label>
                <input type="text" name="thumb_height" id="thumb_height" value="<?php echo $this->tplData["thumbRow"]["thumb_height"]; ?>" data-validate class="form-control">
            </div>

            <div class="form-group">
                <div id="group_thumb_type">
                    <label class="control-label"><?php echo $this->lang["label"]["thumbType"]; ?><span id="msg_thumb_type">*</span></label>
                    <?php foreach ($this->type["thumb"] as $key=>$value) { ?>
                        <div class="bg-radio">
                            <label for="thumb_type_<?php echo $key; ?>">
                                <input type="radio" name="thumb_type" id="thumb_type_<?php echo $key; ?>" value="<?php echo $key; ?>" <?php if ($this->tplData["thumbRow"]["thumb_type"] == $key) { ?>checked<?php } ?> data-validate="thumb_type">
                                <?php echo $value; ?>
                            </label>
                        </div>
                    <?php } ?>
                </div>
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
        thumb_width: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "int" },
            msg: { selector: "#msg_thumb_width", too_short: "<?php echo $this->rcode["x090201"]; ?>", format_err: "<?php echo $this->rcode["x090202"]; ?>" }
        },
        thumb_height: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "int" },
            msg: { selector: "#msg_thumb_height", too_short: "<?php echo $this->rcode["x090203"]; ?>", format_err: "<?php echo $this->rcode["x090204"]; ?>" }
        },
        thumb_type: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='thumb_type']", type: "radio", group: "#group_thumb_type" },
            msg: { selector: "#msg_thumb_type", too_few: "<?php echo $this->rcode["x090205"]; ?>" }
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=thumb",
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
        var obj_validate_form = $("#thumb_form").baigoValidator(opts_validator_form);
        var obj_submit_form   = $("#thumb_form").baigoSubmit(opts_submit_form);
        $(".bg-submit-modal").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
    });
    </script>