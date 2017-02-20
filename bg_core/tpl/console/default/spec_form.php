<?php $cfg = array(
    "title"          => $this->consoleMod["article"]["main"]["title"] . " &raquo; " . $this->consoleMod["article"]["sub"]["spec"]["title"],
    "menu_active"    => "article",
    "sub_active"     => "spec",
    "baigoValidator" => "true",
    "baigoSubmit"    => "true",
    "tinymce"        => "true",
    "upload"         => "true",
    "pathInclude"    => BG_PATH_TPLSYS . "console/default/include/",
    "str_url"        => BG_URL_CONSOLE . "index.php?mod=spec"
);

include($cfg["pathInclude"] . "console_head.php"); ?>

    <div class="form-group">
        <ul class="nav nav-pills bg-nav-pills">
            <li>
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=spec&act=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <?php echo $this->lang["href"]["back"]; ?>
                </a>
            </li>
            <?php if ($this->tplData["specRow"]["spec_id"] > 0) { ?>
                <li>
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=spec&act=select&spec_id=<?php echo $this->tplData["specRow"]["spec_id"]; ?>">
                        <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php echo $this->lang["href"]["specSelect"]; ?>
                    </a>
                </li>
            <?php } ?>
            <li>
                <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=spec#form" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    <?php echo $this->lang["href"]["help"]; ?>
                </a>
            </li>
        </ul>
    </div>

    <form name="spec_form" id="spec_form">
        <input type="hidden" name="<?php echo $this->common["tokenRow"]["name_session"]; ?>" value="<?php echo $this->common["tokenRow"]["token"]; ?>">
        <input type="hidden" name="act" value="submit">
        <input type="hidden" name="spec_id" value="<?php echo $this->tplData["specRow"]["spec_id"]; ?>">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div id="group_spec_name">
                                <label class="control-label"><?php echo $this->lang["label"]["specName"]; ?><span id="msg_spec_name">*</span></label>
                                <input type="text" name="spec_name" id="spec_name" value="<?php echo $this->tplData["specRow"]["spec_name"]; ?>" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <a href="#spec_modal" class="btn btn-success" data-toggle="modal">
                                <span class="glyphicon glyphicon-picture"></span>
                                <?php echo $this->lang["href"]["uploadList"]; ?>
                            </a>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang["label"]["specContent"]; ?></label>
                            <textarea name="spec_content" id="spec_content" class="tinymce bg-textarea-lg"><?php echo $this->tplData["specRow"]["spec_content"]; ?></textarea>
                        </div>

                        <div class="bg-submit-box"></div>
                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang["btn"]["submit"]; ?></button>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="well">
                    <?php if ($this->tplData["specRow"]["spec_id"] > 0) { ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang["label"]["id"]; ?></label>
                            <div class="form-control-static"><?php echo $this->tplData["specRow"]["spec_id"]; ?></div>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <div id="group_spec_status">
                            <label class="control-label"><?php echo $this->lang["label"]["status"]; ?><span id="msg_spec_status">*</span></label>
                            <?php foreach ($this->status["spec"] as $key=>$value) { ?>
                                <div class="bg-radio">
                                    <label for="spec_status_<?php echo $key; ?>">
                                        <input type="radio" name="spec_status" id="spec_status_<?php echo $key; ?>" <?php if ($this->tplData["specRow"]["spec_status"] == $key) { ?>checked<?php } ?> value="<?php echo $key; ?>" data-validate="spec_status">
                                        <?php echo $value; ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <div class="modal fade" id="spec_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>

<?php include($cfg["pathInclude"] . "console_foot.php"); ?>


    <script type="text/javascript">
    var opts_validator_form = {
        spec_name: {
            len: { min: 1, max: 300 },
            validate: { type: "str", format: "text", group: "#group_spec_name" },
            msg: { selector: "#msg_spec_name", too_short: "<?php echo $this->rcode["x180201"]; ?>", too_long: "<?php echo $this->rcode["x180202"]; ?>" }
        },
        spec_content: {
            len: { min: 0, max: 3000 },
            validate: { type: "str", format: "text" },
            msg: { selector: "#msg_spec_content", too_long: "<?php echo $this->rcode["x180203"]; ?>" }
        },
        spec_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='spec_status']", type: "radio", group: "#group_spec_status" },
            msg: { selector: "#msg_spec_status", too_few: "<?php echo $this->rcode["x180205"]; ?>" }
        }
    };
    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=spec",
        msg_text: {
            submitting: "<?php echo $this->lang["label"]["submitting"]; ?>"
        }
    };

    $(document).ready(function(){
        $("#spec_modal").on("shown.bs.modal", function() {
            $("#spec_modal .modal-content").load("<?php echo BG_URL_CONSOLE; ?>index.php?mod=attach&act=form&view=iframe");
        });

        var obj_validate_form   = $("#spec_form").baigoValidator(opts_validator_form);
        var obj_submit_form     = $("#spec_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            tinyMCE.triggerSave();
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
    });
    </script>

<?php include($cfg["pathInclude"] . "html_foot.php"); ?>

