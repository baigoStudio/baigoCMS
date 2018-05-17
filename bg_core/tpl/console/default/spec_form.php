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
    'str_url'        => BG_URL_CONSOLE . "index.php?m=spec"
);

include($cfg['pathInclude'] . 'console_head.php'); ?>

    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=spec&a=list" class="nav-link">
                <span class="oi oi-chevron-left"></span>
                <?php echo $this->lang['common']['href']['back']; ?>
            </a>
        </li>
        <?php if ($this->tplData['specRow']['spec_id'] > 0) { ?>
            <li class="nav-item">
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=spec&a=select&spec_id=<?php echo $this->tplData['specRow']['spec_id']; ?>" class="nav-link">
                    <span class="oi oi-circle-check"></span>
                    <?php echo $this->lang['mod']['href']['select']; ?>
                </a>
            </li>
        <?php } ?>
        <li class="nav-item">
            <a href="<?php echo BG_URL_HELP; ?>index.php?m=console&a=spec#form" class="nav-link" target="_blank">
                <span class="badge badge-pill badge-primary">
                    <span class="oi oi-question-mark"></span>
                </span>
                <?php echo $this->lang['mod']['href']['help']; ?>
            </a>
        </li>
    </ul>

    <form name="spec_form" id="spec_form">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="a" value="submit">
        <input type="hidden" name="spec_id" value="<?php echo $this->tplData['specRow']['spec_id']; ?>">

        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['specName']; ?> <span class="text-danger">*</span></label>
                            <input type="text" name="spec_name" id="spec_name" value="<?php echo $this->tplData['specRow']['spec_name']; ?>" data-validate class="form-control">
                            <small class="form-text" id="msg_spec_name"></small>
                        </div>

                        <div class="form-group">
                            <a href="#spec_modal" class="btn btn-success" data-toggle="modal">
                                <span class="oi oi-image"></span>
                                <?php echo $this->lang['mod']['href']['uploadList']; ?>
                            </a>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['specContent']; ?></label>
                            <textarea name="spec_content" id="spec_content" class="tinymce bg-textarea-lg"><?php echo $this->tplData['specRow']['spec_content']; ?></textarea>
                        </div>

                        <div class="bg-submit-box"></div>
                        <div class="bg-validator-box mt-3"></div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['save']; ?></button>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body">
                        <?php if ($this->tplData['specRow']['spec_id'] > 0) { ?>
                            <div class="form-group">
                                <label><?php echo $this->lang['mod']['label']['id']; ?></label>
                                <div class="form-text"><?php echo $this->tplData['specRow']['spec_id']; ?></div>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['status']; ?> <span class="text-danger">*</span></label>
                            <?php foreach ($this->tplData['status'] as $key=>$value) { ?>
                                <div class="form-check">
                                    <label for="spec_status_<?php echo $value; ?>" class="form-check-label">
                                        <input type="radio" name="spec_status" id="spec_status_<?php echo $value; ?>" <?php if ($this->tplData['specRow']['spec_status'] == $value) { ?>checked<?php } ?> value="<?php echo $value; ?>" data-validate="spec_status" class="form-check-input">
                                        <?php if (isset($this->lang['mod']['status'][$value])) {
                                            echo $this->lang['mod']['status'][$value];
                                        } else {
                                            echo $value;
                                        } ?>
                                    </label>
                                </div>
                            <?php } ?>
                            <small class="form-text" id="msg_spec_status"></small>
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
            validate: { type: "str", format: "text" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x180201']; ?>", too_long: "<?php echo $this->lang['rcode']['x180202']; ?>" }
        },
        spec_content: {
            len: { min: 0, max: 3000 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x180203']; ?>" }
        },
        spec_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='spec_status']", type: "radio" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x180205']; ?>" }
        }
    };

    var options_validator_form = {
        msg_global:{
            msg: "<?php echo $this->lang['common']['label']['errInput']; ?>"
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=spec&c=request",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    $(document).ready(function(){
        $("#spec_modal").on("shown.bs.modal", function() {
            $("#spec_modal .modal-content").load("<?php echo BG_URL_CONSOLE; ?>index.php?m=attach&a=form&view=modal");
    	}).on("hidden.bs.modal", function(){
        	$("#spec_modal .modal-content").empty();
    	});

        var obj_validate_form   = $("#spec_form").baigoValidator(opts_validator_form, options_validator_form);
        var obj_submit_form     = $("#spec_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            tinyMCE.triggerSave();
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
    });
    </script>

<?php include('include' . DS . 'html_foot.php');