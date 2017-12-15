<?php $cfg = array(
    'title'          => $this->lang['mod']['page']['login'],
    'active'         => 'login',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'reloadImg'      => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
);

include($cfg['pathInclude'] . 'login_head.php'); ?>

    <form name="login_form" id="login_form">
        <input type="hidden" name="act" value="login">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">

        <div class="form-group">
            <div id="group_admin_name">
                <label class="control-label"><?php echo $this->lang['mod']['label']['username']; ?><span id="msg_admin_name">*</span></label>
                <input type="text" name="admin_name" id="admin_name" placeholder="<?php echo $this->lang['rcode']['x010201']; ?>" data-validate class="form-control input-lg">
            </div>
        </div>

        <div class="form-group">
            <div id="group_admin_pass">
                <label class="control-label"><?php echo $this->lang['mod']['label']['password']; ?><span id="msg_admin_pass">*</span></label>
                <input type="password" name="admin_pass" id="admin_pass" placeholder="<?php echo $this->lang['rcode']['x010212']; ?>" data-validate class="form-control input-lg">
            </div>
        </div>

        <div class="form-group">
            <div id="group_captcha">
                <label class="control-label"><?php echo $this->lang['mod']['label']['captcha']; ?><span id="msg_captcha">*</span></label>
                <ul class="list-inline">
                    <li>
                        <a href="javascript:void(0);" class="captchaBtn">
                            <img src="<?php echo BG_URL_CONSOLE; ?>index.php?mod=captcha&act=make" class="captchaImg" alt="<?php echo $this->lang['mod']['btn']['captcha']; ?>">
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="captchaBtn">
                            <span class="glyphicon glyphicon-repeat"></span>
                            <?php echo $this->lang['mod']['btn']['captcha']; ?>
                        </a>
                    </li>
                </ul>

                <input type="text" name="captcha" id="captcha" placeholder="<?php echo $this->lang['rcode']['x030201']; ?>" data-validate class="form-control input-lg">
            </div>
        </div>

        <!--<div class="form-group">
            <div id="group_admin_remenber">
                <div class="checkbox">
                    <label for="admin_remenber" data-toggle="tooltip" data-placement="right" title="<?php echo $this->lang['mod']['label']['remenberNote']; ?>">
                        <input type="checkbox" name="admin_remenber" id="admin_remenber" value="remenber">
                        <?php echo $this->lang['mod']['label']['remenber']; ?>
                    </label>
                </div>

                <div class="alert alert-danger hidden" id="msg_admin_remenber"><?php echo $this->lang['mod']['label']['remenberNote']; ?></div>
            </div>
        </div>-->

        <div class="bg-submit-box"></div>

        <div class="form-group">
            <button type="button" class="btn btn-primary btn-block btn-lg bg-submit">
                <?php echo $this->lang['mod']['btn']['login']; ?>
            </button>
        </div>

    </form>

<?php include($cfg['pathInclude'] . 'login_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_form = {
        admin_name: {
            len: { min: 1, max: 30 },
            validate: { type: "str", format: "strDigit", group: "#group_admin_name" },
            msg: { selector: "#msg_admin_name", too_short: "<?php echo $this->lang['rcode']['x010201']; ?>", too_long: "<?php echo $this->lang['rcode']['x010202']; ?>", format_err: "<?php echo $this->lang['rcode']['x010203']; ?>" }
        },
        admin_pass: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "text", group: "#group_admin_pass" },
            msg: { selector: "#msg_admin_pass", too_short: "<?php echo $this->lang['rcode']['x010212']; ?>" }
        },
        captcha: {
            len: { min: 4, max: 4 },
            validate: { type: "ajax", format: "text", group: "#group_captcha" },
            msg: { selector: "#msg_captcha", too_short: "<?php echo $this->lang['rcode']['x030201']; ?>", too_long: "<?php echo $this->lang['rcode']['x030201']; ?>", ajaxIng: "<?php echo $this->lang['rcode']['x030401']; ?>", ajax_err: "<?php echo $this->lang['rcode']['x030402']; ?>" },
            ajax: { url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=captcha&act=chk", key: "captcha", type: "str" }
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=login",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        },
        jump: {
            url: "<?php echo $this->tplData['jump']; ?>",
            text: "<?php echo $this->lang['mod']['href']['jumping']; ?>",
            delay: 1000
        }
    };

    $(document).ready(function(){
        $("#admin_name").focus();
        var obj_validate_form  = $("#login_form").baigoValidator(opts_validator_form);
        var obj_submit_form    = $("#login_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
        $('[data-toggle="tooltip"]').tooltip();

        $("body").keydown(function(e){
            if(e.keyCode == 13){
                if (obj_validate_form.verify()) {
                    obj_submit_form.formSubmit();
                }
            }
        });
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>
