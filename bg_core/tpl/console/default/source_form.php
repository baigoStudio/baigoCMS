    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <?php echo $this->lang['consoleMod']['article']['main']['title'], ' &raquo; ', $this->lang['consoleMod']['article']['sub']['source']; ?>
    </div>
    <div class="modal-body">

        <form name="source_form" id="source_form">
            <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
            <input type="hidden" name="source_id" id="source_id" value="<?php echo $this->tplData['sourceRow']['source_id']; ?>">
            <input type="hidden" name="act" value="submit">

            <?php if ($this->tplData['sourceRow']['source_id'] > 0) { ?>
                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang['mod']['label']['id']; ?></label>
                    <div class="form-control-static"><?php echo $this->tplData['sourceRow']['source_id']; ?></div>
                </div>
            <?php } ?>

            <div class="form-group">
                <div id="group_source_name">
                    <label class="control-label"><?php echo $this->lang['mod']['label']['sourceName']; ?><span id="msg_source_name">*</span></label>
                    <input type="text" name="source_name" id="source_name" value="<?php echo $this->tplData['sourceRow']['source_name']; ?>" data-validate class="form-control">
                </div>
            </div>

            <div class="form-group">
                <div id="group_source_author">
                    <label class="control-label"><?php echo $this->lang['mod']['label']['author']; ?><span id="msg_source_author"></span></label>
                    <input type="text" name="source_author" id="source_author" value="<?php echo $this->tplData['sourceRow']['source_author']; ?>" data-validate class="form-control">
                </div>
            </div>

            <div class="form-group">
                <div id="group_source_url">
                    <label class="control-label"><?php echo $this->lang['mod']['label']['sourceUrl']; ?><span id="msg_source_url"></span></label>
                    <input type="text" name="source_url" id="source_url" value="<?php echo $this->tplData['sourceRow']['source_url']; ?>" data-validate class="form-control">
                </div>
            </div>

            <div class="form-group">
                <div id="group_source_note">
                    <label class="control-label"><?php echo $this->lang['mod']['label']['note']; ?><span id="msg_source_note"></span></label>
                    <input type="text" name="source_note" id="source_note" value="<?php echo $this->tplData['sourceRow']['source_note']; ?>" data-validate class="form-control">
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
        source_name: {
            len: { min: 1, max: 300 },
            validate: { type: "str", format: "text", group: "#group_source_name" },
            msg: { selector: "#msg_source_name", too_short: "<?php echo $this->lang['rcode']['x260201']; ?>", too_long: "<?php echo $this->lang['rcode']['x260202']; ?>" }
        },
        source_author: {
            len: { min: 0, max: 300 },
            validate: { type: "str", format: "text", group: "#group_source_author" },
            msg: { selector: "#msg_source_author", too_long: "<?php echo $this->lang['rcode']['x260203']; ?>" }
        },
        source_url: {
            len: { min: 0, max: 900 },
            validate: { type: "str", format: "text", group: "#group_source_url" },
            msg: { selector: "#msg_source_url", too_long: "<?php echo $this->lang['rcode']['x260204']; ?>" }
        },
        source_note: {
            len: { min: 0, max: 30 },
            validate: { type: "str", format: "text", group: "#group_source_note" },
            msg: { selector: "#msg_source_note", too_long: "<?php echo $this->lang['rcode']['x260205']; ?>" }
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=source",
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
        var obj_validate_form = $("#source_form").baigoValidator(opts_validator_form);
        var obj_submit_form   = $("#source_form").baigoSubmit(opts_submit_form);
        $(".bg-submit-modal").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
    });
    </script>