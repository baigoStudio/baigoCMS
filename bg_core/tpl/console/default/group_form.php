<?php if ($this->tplData['groupRow']['group_id'] < 1) {
    $title_sub = $this->lang['mod']['page']['add'];
    $sub_active = 'form';
} else {
    $title_sub = $this->lang['mod']['page']['edit'];
    $sub_active = 'list';
}

$cfg = array(
    'title'          => $this->lang['consoleMod']['group']['main']['title'] . ' &raquo; ' . $title_sub,
    'menu_active'    => 'group',
    'sub_active'     => $sub_active,
    'baigoCheckall'  => 'true',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?mod=group",
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group">
        <ul class="nav nav-pills bg-nav-pills">
            <li>
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=group&act=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <?php echo $this->lang['common']['href']['back']; ?>
                </a>
            </li>
            <li>
                <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=group#form" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    <?php echo $this->lang['mod']['href']['help']; ?>
                </a>
            </li>
        </ul>
    </div>

    <form name="group_form" id="group_form">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="act" value="submit">
        <input type="hidden" name="group_id" id="group_id" value="<?php echo $this->tplData['groupRow']['group_id']; ?>">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div id="group_group_name">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['groupName']; ?><span id="msg_group_name">*</span></label>
                                <input type="text" name="group_name" id="group_name" value="<?php echo $this->tplData['groupRow']['group_name']; ?>" data-validate class="form-control">
                            </div>
                        </div>

                        <div id="groupAdmin" class="form-group">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['groupAllow']; ?><span id="msg_group_allow">*</span></label>
                            <?php allow_list($this->consoleMod, $this->lang['consoleMod'], $this->opt, $this->lang['opt'], $this->lang['mod'], $this->lang['common'], $this->tplData['groupRow']['group_allow']); ?>
                        </div>

                        <div id="groupUser" class="form-group">

                        </div>

                        <div class="form-group">
                            <div id="group_group_note">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['note']; ?><span id="msg_group_note"></span></label>
                                <input type="text" name="group_note" id="group_note" value="<?php echo $this->tplData['groupRow']['group_note']; ?>" data-validate class="form-control">
                            </div>
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
                    <?php if ($this->tplData['groupRow']['group_id'] > 0) { ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['id']; ?></label>
                            <div class="form-control-static"><?php echo $this->tplData['groupRow']['group_id']; ?></div>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <div id="group_group_type">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['type']; ?><span id="msg_group_type">*</span></label>
                            <?php foreach ($this->tplData['type'] as $key=>$value) { ?>
                                <div class="bg-radio">
                                    <label for="group_type_<?php echo $value; ?>">
                                        <input type="radio" name="group_type" id="group_type_<?php echo $value; ?>" <?php if ($this->tplData['groupRow']['group_type'] == $value) { ?>checked<?php } ?> value="<?php echo $value; ?>" data-validate="group_type">
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

                    <div class="form-group">
                        <div id="group_group_status">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['status']; ?><span id="msg_group_status">*</span></label>
                            <?php foreach ($this->tplData['status'] as $key=>$value) { ?>
                                <div class="bg-radio">
                                    <label for="group_status_<?php echo $value; ?>">
                                        <input type="radio" name="group_status" id="group_status_<?php echo $value; ?>" <?php if ($this->tplData['groupRow']['group_status'] == $value) { ?>checked<?php } ?> value="<?php echo $value; ?>" data-validate="group_status">
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

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_form = {
        group_name: {
            len: { min: 1, max: 30 },
            validate: { type: "ajax", format: "text", group: "#group_group_name" },
            msg: { selector: "#msg_group_name", too_short: "<?php echo $this->lang['rcode']['x040201']; ?>", too_long: "<?php echo $this->lang['rcode']['x040202']; ?>", ajaxIng: "<?php echo $this->lang['rcode']['x030401']; ?>", ajax_err: "<?php echo $this->lang['rcode']['x030402']; ?>" },
            ajax: { url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=group&act=chkname", key: "group_name", type: "str", attach_selectors: ["#group_id"], attach_keys: ["group_id"] }
        },
        group_note: {
            len: { min: 0, max: 30 },
            validate: { type: "str", format: "text", group: "#group_group_note" },
            msg: { selector: "#msg_group_note", too_long: "<?php echo $this->lang['rcode']['x040204']; ?>" }
        },
        group_type: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='group_type']", type: "radio", group: "#group_group_type" },
            msg: { selector: "#msg_group_type", too_few: "<?php echo $this->lang['rcode']['x040205']; ?>" }
        },
        group_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='group_status']", type: "radio", group: "#group_group_status" },
            msg: { selector: "#msg_group_status", too_few: "<?php echo $this->lang['rcode']['x040207']; ?>" }
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=group",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    function group_type(group_type) {
        switch (group_type) {
            case 'admin':
                $("#groupAdmin").show();
                $("#groupUser").hide();
            break;

            default:
                $("#groupAdmin").hide();
                $("#groupUser").show();
            break;
        }
    }

    $(document).ready(function(){
        var obj_validate_form = $("#group_form").baigoValidator(opts_validator_form);
        var obj_submit_form   = $("#group_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
        group_type("<?php echo $this->tplData['groupRow']['group_type']; ?>");
        $("input[name='group_type']").click(function(){
            var _group_type = $("input[name='group_type']:checked").val();
            group_type(_group_type);
        });
        $("#group_form").baigoCheckall();
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>