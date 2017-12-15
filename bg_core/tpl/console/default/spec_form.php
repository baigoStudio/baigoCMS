<?php if ($this->tplData['specRow']['spec_id'] < 1) {
    $title_sub  = $this->lang['mod']['page']['add'];
    $sub_active = 'form';
} else {
    $title_sub = $this->lang['mod']['page']['edit'];
    $sub_active = 'list';
}

$cfg = array(
    'title'          => $this->lang['consoleMod']['spec']['main']['title'] . ' &raquo; ' . $title_sub,
    'menu_active'    => 'spec',
    'sub_active'     => $sub_active,
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'tinymce'        => 'true',
    'upload'         => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?mod=spec"
);

include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group">
        <ul class="nav nav-pills bg-nav-pills">
            <li>
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=spec&act=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <?php echo $this->lang['common']['href']['back']; ?>
                </a>
            </li>
            <?php if ($this->tplData['specRow']['spec_id'] > 0) { ?>
                <li>
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=spec&act=select&spec_id=<?php echo $this->tplData['specRow']['spec_id']; ?>">
                        <span class="glyphicon glyphicon-ok-sign"></span>
                        <?php echo $this->lang['mod']['href']['select']; ?>
                    </a>
                </li>
            <?php } ?>
            <li>
                <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=spec#form" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    <?php echo $this->lang['mod']['href']['help']; ?>
                </a>
            </li>
        </ul>
    </div>

    <form name="spec_form" id="spec_form">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="act" value="submit">
        <input type="hidden" name="spec_id" value="<?php echo $this->tplData['specRow']['spec_id']; ?>">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div id="group_spec_name">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['specName']; ?><span id="msg_spec_name">*</span></label>
                                <input type="text" name="spec_name" id="spec_name" value="<?php echo $this->tplData['specRow']['spec_name']; ?>" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <a href="#spec_modal" class="btn btn-success" data-toggle="modal">
                                <span class="glyphicon glyphicon-picture"></span>
                                <?php echo $this->lang['mod']['href']['uploadList']; ?>
                            </a>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['specContent']; ?></label>
                            <textarea name="spec_content" id="spec_content" class="tinymce bg-textarea-lg"><?php echo $this->tplData['specRow']['spec_content']; ?></textarea>
                        </div>

                        <div class="bg-submit-box"></div>
                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['save']; ?></button>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="well">
                    <?php if ($this->tplData['specRow']['spec_id'] > 0) { ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['id']; ?></label>
                            <div class="form-control-static"><?php echo $this->tplData['specRow']['spec_id']; ?></div>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <div id="group_spec_status">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['status']; ?><span id="msg_spec_status">*</span></label>
                            <?php foreach ($this->tplData['status'] as $key=>$value) { ?>
                                <div class="bg-radio">
                                    <label for="spec_status_<?php echo $value; ?>">
                                        <input type="radio" name="spec_status" id="spec_status_<?php echo $value; ?>" <?php if ($this->tplData['specRow']['spec_status'] == $value) { ?>checked<?php } ?> value="<?php echo $value; ?>" data-validate="spec_status">
                                        <?php if (isset($this->lang['mod']['status'][$value])) {
                                            echo $this->lang['mod']['status'][$value];
                                        } else {
                                            echo $value;
                                        } ?>
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

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>


    <script type="text/javascript">
    var opts_validator_form = {
        spec_name: {
            len: { min: 1, max: 300 },
            validate: { type: "str", format: "text", group: "#group_spec_name" },
            msg: { selector: "#msg_spec_name", too_short: "<?php echo $this->lang['rcode']['x180201']; ?>", too_long: "<?php echo $this->lang['rcode']['x180202']; ?>" }
        },
        spec_content: {
            len: { min: 0, max: 3000 },
            validate: { type: "str", format: "text" },
            msg: { selector: "#msg_spec_content", too_long: "<?php echo $this->lang['rcode']['x180203']; ?>" }
        },
        spec_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='spec_status']", type: "radio", group: "#group_spec_status" },
            msg: { selector: "#msg_spec_status", too_few: "<?php echo $this->lang['rcode']['x180205']; ?>" }
        }
    };
    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=spec",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    $(document).ready(function(){
        $("#spec_modal").on("shown.bs.modal", function() {
            $("#spec_modal .modal-content").load("<?php echo BG_URL_CONSOLE; ?>index.php?mod=attach&act=form&view=modal");
    	}).on("hidden.bs.modal", function(){
        	$("#spec_modal .modal-content").empty();
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

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>

