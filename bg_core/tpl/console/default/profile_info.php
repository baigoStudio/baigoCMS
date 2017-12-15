<?php $cfg = array(
    'title'          => $this->lang['mod']['page']['profile'],
    'menu_active'    => 'profile',
    'sub_active'     => 'info',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . 'index.php?mod=profile'
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group">
        <ul class="nav nav-pills bg-nav-pills">
            <?php include($cfg['pathInclude'] . 'profile_menu.php'); ?>
        </ul>
    </div>

    <form name="profile_form" id="profile_form">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="act" value="info">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['username']; ?></label>
                            <input type="text" class="form-control" readonly value="<?php echo $this->tplData['ssoRow']['user_name']; ?>">
                        </div>

                        <div class="form-group">
                            <div id="group_admin_pass">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['password']; ?><span id="msg_admin_pass">*</span></label>
                                <input type="password" name="admin_pass" id="admin_pass" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_admin_nick">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['nick']; ?><span id="msg_admin_nick"></span></label>
                                <input type="text" name="admin_nick" id="admin_nick" value="<?php if (fn_isEmpty($this->tplData['adminLogged']['admin_nick'])) { echo $this->tplData['ssoRow']['user_nick']; } else { echo $this->tplData['adminLogged']['admin_nick']; } ?>" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="bg-submit-box"></div>
                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['save']; ?></button>
                    </div>
                </div>

                <div class="panel panel-default">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <?php echo $this->lang['mod']['label']['cateAllow']; ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($this->tplData['adminLogged']['groupRow']['group_allow']['article'])) {
                                $_arr_groupAllowArticle = $this->tplData['adminLogged']['groupRow']['group_allow']['article'];
                            } else {
                                $_arr_groupAllowArticle = array();
                            }
                            cate_list_allow($this->tplData['cateRows'], $this->tplData['cateAllow'], $this->lang['mod'], $this->tplData['adminLogged']['admin_allow_cate'], $_arr_groupAllowArticle, $this->tplData['adminLogged']['admin_type'], false);
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php include($cfg['pathInclude'] . "profile_side.php"); ?>
        </div>

    </form>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_form = {
        admin_pass: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "text", group: "#group_admin_pass" },
            msg: { selector: "#msg_admin_pass", too_short: "<?php echo $this->lang['rcode']['x010212']; ?>" }
        },
        admin_nick: {
            len: { min: 0, max: 30 },
            validate: { type: "str", format: "text", group: "#group_admin_nick" },
            msg: { selector: "#msg_admin_nick", too_long: "<?php echo $this->lang['rcode']['x020216']; ?>" }
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=profile",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    $(document).ready(function(){
        var obj_validate_form = $("#profile_form").baigoValidator(opts_validator_form);
        var obj_submit_form   = $("#profile_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>