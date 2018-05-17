<?php if (isset($this->lang['common']['profile']['prefer']['title'])) {
    $title_sub = $this->lang['common']['profile']['prefer']['title'];
} else {
    $title_sub = $this->profile['prefer']['title'];
}

$cfg = array(
    'title'          => $this->lang['mod']['page']['profile'] . ' &raquo; ' . $title_sub,
    'menu_active'    => "profile",
    'sub_active'     => "prefer",
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?m=profile&a=prefer"
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php');

    include($cfg['pathInclude'] . 'profile_menu.php'); ?>

    <form name="profile_form" id="profile_form">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="a" value="prefer">

        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['username']; ?></label>
                            <input type="text" class="form-control" readonly value="<?php echo $this->tplData['ssoRow']['user_name']; ?>">
                        </div>

                        <?php foreach ($this->tplData['prefer'] as $key=>$value) { ?>
                            <div>
                                <hr>
                                <h5>
                                    <?php if (isset($this->lang['prefer'][$key]['title'])) {
                                        echo $this->lang['prefer'][$key]['title'];
                                    } else {
                                        echo $value['title'];
                                    } ?>
                                </h5>
                                <?php foreach ($value['list'] as $key_s=>$value_s) { ?>
                                    <div class="form-group">
                                        <label>
                                            <?php if (isset($this->lang['prefer'][$key]['list'][$key_s]['label'])) {
                                                echo $this->lang['prefer'][$key]['list'][$key_s]['label'];
                                            } else {
                                                echo $value_s['label'];
                                            } ?>
                                        </label>
                                        <?php switch($value_s['type']) {
                                            case 'select': ?>
                                                <select name="admin_prefer[<?php echo $key; ?>][<?php echo $key_s; ?>]" id="admin_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>" data-validate="admin_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>" class="form-control">
                                                    <?php foreach ($value_s['option'] as $key_opt=>$value_opt) { ?>
                                                        <option <?php if (isset($this->tplData['adminLogged']['admin_prefer'][$key][$key_s]) && $this->tplData['adminLogged']['admin_prefer'][$key][$key_s] == $key_opt) { ?>selected<?php } ?> value="<?php echo $key_opt; ?>">
                                                            <?php if (isset($this->lang['prefer'][$key]['list'][$key_s]['option'][$key_opt])) {
                                                                echo $this->lang['prefer'][$key]['list'][$key_s]['option'][$key_opt];
                                                            } else {
                                                                echo $value_opt;
                                                            } ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            <?php break;

                                            case 'radio':
                                                foreach ($value_s['option'] as $key_opt=>$value_opt) { ?>
                                                    <div class="form-check form-check-inline">
                                                        <label for="admin_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>_<?php echo $key_opt; ?>" class="form-check-label">
                                                            <input type="radio" <?php if (isset($this->tplData['adminLogged']['admin_prefer'][$key][$key_s]) && $this->tplData['adminLogged']['admin_prefer'][$key][$key_s] == $key_opt) { ?>checked<?php } ?> value="<?php echo $key_opt; ?>" data-validate="admin_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>" name="admin_prefer[<?php echo $key; ?>][<?php echo $key_s; ?>]" id="admin_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>_<?php echo $key_opt; ?>" class="form-check-input">
                                                            <?php if (isset($this->lang['prefer'][$key]['list'][$key_s]['option'][$key_opt]['value'])) {
                                                                echo $this->lang['prefer'][$key]['list'][$key_s]['option'][$key_opt]['value'];
                                                            } else {
                                                                echo $value_opt['value'];
                                                            } ?>
                                                        </label>
                                                    </div>
                                                    <?php if (isset($value_opt['note'])) { ?><small class="form-text"><?php echo $value_opt['note']; ?></small><?php }
                                                }
                                            break;

                                            case 'textarea': ?>
                                                <textarea name="admin_prefer[<?php echo $key; ?>][<?php echo $key_s; ?>]" id="admin_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>" data-validate="admin_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>" class="form-control bg-textarea-md">
                                                    <?php if (isset($this->tplData['adminLogged']['admin_prefer'][$key][$key_s])) {
                                                        echo $this->tplData['adminLogged']['admin_prefer'][$key][$key_s];
                                                    } ?>
                                                </textarea>
                                            <?php
                                            break;

                                            default: ?>
                                                <input type="text" value="<?php if (isset($this->tplData['adminLogged']['admin_prefer'][$key][$key_s])) { echo $this->tplData['adminLogged']['admin_prefer'][$key][$key_s]; } ?>" name="admin_prefer[<?php echo $key; ?>][<?php echo $key_s; ?>]" id="admin_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>" data-validate="admin_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>" class="form-control">
                                            <?php
                                            break;
                                        }

                                        if (isset($value_s['note'])) { ?><small class="form-text"><?php echo $value_s['note']; ?></small><?php } ?>
                                        <small class="form-text" id="msg_admin_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>"></small>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>

                        <div class="bg-submit-box"></div>
                        <div class="bg-validator-box mt-3"></div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['save']; ?></button>
                    </div>
                </div>
            </div>

            <?php include($cfg['pathInclude'] . "profile_side.php"); ?>
        </div>

    </form>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_form = {
        <?php $_count = 1;
        foreach ($this->tplData['prefer'] as $key=>$value) {
            $_count_s = 1;
            foreach ($value['list'] as $key_s=>$value_s) {
                if ($value_s['type'] == "str" || $value_s['type'] == "textarea") {
                    $str_msg_min = "too_short";
                    $str_msg_max = "too_long";
                } else {
                    $str_msg_min = "too_few";
                    $str_msg_max = "too_many";
                } ?>
                admin_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>: {
                    len: { min: <?php echo $value_s['min']; ?>, max: 900 },
                    validate: { selector: "[data-validate='admin_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>']", type: "<?php echo $value_s['type']; ?>", <?php if (isset($value_s['format'])) { ?>format: "<?php echo $value_s['format']; ?>"<?php } ?> },
                    msg: { selector: "#msg_admin_prefer_<?php echo $key; ?>_<?php echo $key_s; ?>", <?php echo $str_msg_min; ?>: "<?php echo $this->lang['rcode']['x060201'], $value_s['label']; ?>", <?php echo $str_msg_max; ?>: "<?php echo $value_s['label'], $this->lang['rcode']['x060202']; ?>", format_err: "<?php echo $value_s['label'], $this->lang['rcode']['x060203']; ?>" }
                }<?php if ($_count < count($this->tplData['prefer']) || $_count_s < count($value['list'])) { ?>,<?php }
                $_count_s++;
            }
            $_count++;
        } ?>
    };

    var options_validator_form = {
        msg_global:{
            msg: "<?php echo $this->lang['common']['label']['errInput']; ?>"
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=profile&c=request",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    $(document).ready(function(){
        var obj_validate_form = $("#profile_form").baigoValidator(opts_validator_form, options_validator_form);
        var obj_submit_form   = $("#profile_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
    });
    </script>

<?php include('include' . DS . 'html_foot.php');