    <?php include(BG_PATH_TPLSYS . "console/default/include/function.php");
    $_arr_status = pm_status_process($this->tplData["pmRow"], $this->status["pm"], $this->lang, $this->tplData["pmRow"]["pm_type"]); ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <?php echo $this->lang["page"]["pm"] . " &raquo; " . $this->lang["page"]["show"]; ?>
    </div>
    <div class="modal-body">
        <form name="pm_form" id="pm_form">
            <input type="hidden" name="<?php echo $this->common["tokenRow"]["name_session"]; ?>" value="<?php echo $this->common["tokenRow"]["token"]; ?>">
            <?php if ($this->tplData["pmRow"]["pm_type"] == "out") { ?>
                <input type="hidden" name="pm_id" id="pm_id" value="<?php echo $this->tplData["pmRow"]["pm_send_id"]; ?>">
            <?php } ?>
            <input type="hidden" name="act" value="revoke">

            <div class="form-group">
                <label class="control-label"><?php echo $this->lang["label"]["id"]; ?></label>
                <div class="form-control-static"><?php echo $this->tplData["pmRow"]["pm_id"]; ?></div>
            </div>

            <div class="form-group">
                <label class="control-label"><?php echo $this->lang["label"]["title"]; ?></label>
                <div class="form-control-static"><?php echo fn_htmlcode($this->tplData["pmRow"]["pm_title"], "decode", "json"); ?></div>
            </div>

            <div class="form-group">
                <label class="control-label"><?php echo $this->lang["label"]["content"]; ?></label>
                <div class="bg-content"><?php echo fn_htmlcode($this->tplData["pmRow"]["pm_content"], "decode", "json"); ?></div>
            </div>

            <div class="form-group">
                <label class="control-label"><?php echo $this->lang["label"]["status"]; ?></label>
                <div class="form-control-static">
                    <span class="label label-<?php echo $_arr_status["css_label"]; ?> bg-label"><?php echo $_arr_status["str_text"]; ?></span>
                </div>
            </div>

        </form>

        <div class="bg-submit-box bg-submit-box-modal"></div>
    </div>
    <div class="modal-footer">
        <?php if ($this->tplData["pmRow"]["pm_type"] == "out") { ?>
            <button type="button" class="btn btn-default bg-submit-modal"><?php echo $this->lang["btn"]["revoke"]; ?></button>
        <?php } ?>
        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=pm&act=send&pm_id=<?php echo $this->tplData["pmRow"]["pm_id"]; ?>" class="btn btn-primary"><?php echo $this->lang["href"]["reply"]; ?></a>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang["btn"]["close"]; ?></button>
    </div>

    <script type="text/javascript">
    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=pm",
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
        var obj_submit_form   = $("#pm_form").baigoSubmit(opts_submit_form);
        $(".bg-submit-modal").click(function(){
            obj_submit_form.formSubmit();
        });
    });
    </script>