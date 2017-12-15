<?php if ($this->tplData['callRow']['call_id'] < 1) {
    $title_sub  = $this->lang['mod']['page']['add'];
    $sub_active = 'form';
} else {
    $title_sub = $this->lang['mod']['page']['edit'];
    $sub_active = 'list';
}

$cfg = array(
    'title'          => $this->lang['consoleMod']['call']['main']['title'] . ' &raquo; ' . $title_sub,
    'menu_active'    => "call",
    'sub_active'     => $sub_active,
    'baigoCheckall'  => 'true',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?mod=call"
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group">
        <ul class="nav nav-pills bg-nav-pills">
            <li>
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=call&act=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <?php echo $this->lang['common']['href']['back']; ?>
                </a>
            </li>
            <li>
                <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=call#form" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    <?php echo $this->lang['mod']['href']['help']; ?>
                </a>
            </li>
        </ul>
    </div>

    <form name="call_form" id="call_form">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="act" value="submit">
        <input type="hidden" name="call_id" id="call_id" value="<?php echo $this->tplData['callRow']['call_id']; ?>">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div id="group_call_name">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['callName']; ?><span id="msg_call_name">*</span></label>
                                <input type="text" name="call_name" id="call_name" value="<?php echo $this->tplData['callRow']['call_name']; ?>" data-validate class="form-control">
                            </div>
                        </div>

                        <div id="call_article">
                            <div class="alert alert-success"><?php echo $this->lang['mod']['label']['callFilter']; ?></div>

                            <div class="form-group">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['callCate']; ?></label>
                                <div class="bg-checkbox">
                                    <label for="call_cate_ids_0">
                                        <input type="checkbox" id="call_cate_ids_0" data-parent="first">
                                        <?php echo $this->lang['mod']['label']['allCate']; ?>
                                    </label>
                                </div>
                                <table class="bg-table-empty">
                                    <tbody>
                                        <?php cate_list_checkbox($this->tplData['cateRows'], $this->tplData['callRow']['call_cate_ids'], "call"); ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?php echo $this->lang['common']['label']['spec']; ?></label>
                                <div class="input-group">
                                    <input type="text" id="spec_key" name="spec_key" placeholder="<?php echo $this->lang['mod']['label']['key']; ?>" class="form-control">
                                    <span class="input-group-btn">
                                        <button type="button" data-target="#call_modal" class="btn btn-info" data-toggle="modal">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </button>
                                    </span>
                                </div>
                                <div id="spec_check_list">
                                    <?php foreach ($this->tplData['specRows'] as $key=>$value) { ?>
                                        <div class="checkbox" id="spec_checkbox_<?php echo $value['spec_id']; ?>">
                                            <label for="call_spec_ids_<?php echo $value['spec_id']; ?>">
                                                <input type="checkbox" id="call_spec_ids_<?php echo $value['spec_id']; ?>" checked name="call_spec_ids[]" value="<?php echo $value['spec_id']; ?>">
                                                <?php echo $value['spec_name']; ?>
                                            </label>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['callAttach']; ?></label>
                                <select id="call_attach" name="call_attach" class="form-control">
                                    <?php foreach ($this->tplData['attach'] as $key=>$value) { ?>
                                        <option <?php if ($this->tplData['callRow']['call_attach'] == $value) { ?>selected<?php } ?> value="<?php echo $value; ?>">
                                            <?php if (isset($this->lang['mod']['attach'][$value])) {
                                                echo $this->lang['mod']['attach'][$value];
                                            } else {
                                                echo $value;
                                            } ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['callMark']; ?><span id="msg_call_mark_ids"></span></label>
                                <?php foreach ($this->tplData['markRows'] as $key=>$value) { ?>
                                    <div class="bg-checkbox">
                                        <label for="call_mark_ids_<?php echo $value['mark_id']; ?>">
                                            <input type="checkbox" <?php if (in_array($value['mark_id'], $this->tplData['callRow']['call_mark_ids'])) { ?>checked<?php } ?> value="<?php echo $value['mark_id']; ?>" name="call_mark_ids[]" id="call_mark_ids_<?php echo $value['mark_id']; ?>">
                                            <?php echo $value['mark_name']; ?>
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div id="call_cate">
                            <div class="alert alert-success"><?php echo $this->lang['mod']['label']['callFilter']; ?></div>

                            <div class="form-group">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['callCate']; ?></label>
                                <div class="bg-radio">
                                    <label for="call_cate_id_0">
                                        <input type="radio" <?php if ($this->tplData['callRow']['call_cate_id'] == 0) { ?>checked<?php } ?> value="0" name="call_cate_id" id="call_cate_id_0">
                                        <?php echo $this->lang['mod']['label']['allCate']; ?>
                                    </label>
                                </div>
                                <table class="bg-table-empty">
                                    <tbody>
                                        <?php cate_list_radio($this->tplData['cateRows'], $this->lang['mod'], $this->tplData['callRow']['call_cate_id'], $this->tplData['callRow']['call_cate_excepts']); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="bg-submit-box"></div>
                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['save']; ?></button>
                        <?php if ($this->tplData['callRow']['call_id'] > 0) { ?>
                            <button type="button" class="btn btn-default bg-duplicate"><?php echo $this->lang['mod']['btn']['duplicate']; ?></button>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="well">
                    <?php if ($this->tplData['callRow']['call_id'] > 0) { ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['id']; ?></label>
                            <div class="form-control-static"><?php echo $this->tplData['callRow']['call_id']; ?></div>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <div id="group_call_type">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['type']; ?><span id="msg_call_type">*</span></label>
                            <select id="call_type" name="call_type" data-validate class="form-control">
                                <option value=""><?php echo $this->lang['mod']['option']['pleaseSelect']; ?></option>
                                <?php foreach ($this->tplData['type'] as $key=>$value) { ?>
                                    <option <?php if ($this->tplData['callRow']['call_type'] == $value) { ?>selected<?php } ?> value="<?php echo $value; ?>">
                                        <?php if (isset($this->lang['mod']['type'][$value])) {
                                            echo $this->lang['mod']['type'][$value];
                                        } else {
                                            echo $value;
                                        } ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <?php if (BG_MODULE_GEN > 0 && BG_VISIT_TYPE == 'static') { ?>
                        <div class="form-group">
                            <div id="group_call_file">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['callFile']; ?><span id="msg_call_file">*</span></label>
                                <select name="call_file" id="call_file" data-validate class="form-control">
                                    <option value=""><?php echo $this->lang['mod']['option']['pleaseSelect']; ?></option>
                                    <?php foreach ($this->tplData['file'] as $key=>$value) { ?>
                                        <option <?php if ($this->tplData['callRow']['call_file'] == $value) { ?>selected<?php } ?> value="<?php echo $value; ?>">
                                            <?php if (isset($this->lang['mod']['file'][$value])) {
                                                echo $this->lang['mod']['file'][$value];
                                            } else {
                                                echo $value;
                                            } ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_call_tpl">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['callTpl']; ?><span id="msg_call_tpl">*</span></label>
                                <select name="call_tpl" id="call_tpl" data-validate class="form-control">
                                    <option value=""><?php echo $this->lang['mod']['option']['pleaseSelect']; ?></option>
                                    <?php foreach ($this->tplData['tplRows'] as $key=>$value) {
                                        if ($value['type'] == 'file') { ?>
                                            <option <?php if ($this->tplData['callRow']['call_tpl'] == $value['name_s']) { ?>selected<?php } ?> value="<?php echo $value['name']; ?>">
                                                <?php echo $value['name']; ?>
                                            </option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <div id="group_call_status">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['status']; ?><span id="msg_call_status">*</span></label>
                            <?php foreach ($this->tplData['status'] as $key=>$value) { ?>
                                <div class="bg-radio">
                                    <label for="call_status_<?php echo $value; ?>">
                                        <input type="radio" name="call_status" id="call_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($this->tplData['callRow']['call_status'] == $value) { ?>checked<?php } ?> data-validate="call_status">
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

                    <div class="alert alert-success"><?php echo $this->lang['mod']['label']['callAmount']; ?></div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['callAmoutTop']; ?><span id="msg_call_amount_top">*</span></label>
                        <input type="text" name="call_amount[top]" id="call_amount_top" value="<?php echo $this->tplData['callRow']['call_amount']['top']; ?>" data-validate class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['callAmoutExcept']; ?><span id="msg_call_amount_except">*</span></label>
                        <input type="text" name="call_amount[except]" id="call_amount_except" value="<?php echo $this->tplData['callRow']['call_amount']['except']; ?>" data-validate class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form name="call_duplicate" id="call_duplicate">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="act" value="duplicate">
        <input type="hidden" name="call_id" id="call_id" value="<?php echo $this->tplData['callRow']['call_id']; ?>">
    </form>

    <div class="modal fade" id="call_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_form = {
        call_name: {
            len: { min: 1, max: 300 },
            validate: { type: "str", format: "text", group: "#group_call_name" },
            msg: { selector: "#msg_call_name", too_short: "<?php echo $this->lang['rcode']['x170201']; ?>", too_long: "<?php echo $this->lang['rcode']['x170202']; ?>" }
        },
        call_type: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_call_type" },
            msg: { selector: "#msg_call_type", too_few: "<?php echo $this->lang['rcode']['x170204']; ?>" }
        },
        call_file: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_call_file" },
            msg: { selector: "#msg_call_file", too_few: "<?php echo $this->lang['rcode']['x170205']; ?>" }
        },
        call_tpl: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_call_tpl" },
            msg: { selector: "#msg_call_tpl", too_few: "<?php echo $this->lang['rcode']['x170217']; ?>" }
        },
        call_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='call_status']", type: "radio", group: "#group_call_status" },
            msg: { selector: "#msg_call_status", too_few: "<?php echo $this->lang['rcode']['x170206']; ?>" }
        },
        call_amount_top: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "int" },
            msg: { selector: "#msg_call_amount_top", too_short: "<?php echo $this->lang['rcode']['x170207']; ?>", format_err: "<?php echo $this->lang['rcode']['x170208']; ?>" }
        },
        call_amount_except: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "int" },
            msg: { selector: "#msg_call_amount_except", too_short: "<?php echo $this->lang['rcode']['x170209']; ?>", format_err: "<?php echo $this->lang['rcode']['x170210']; ?>" }
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=call",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    var opts_duplicate_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=call",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    function call_type(call_type) {
        switch (call_type) {
            case 'cate':
                $("#call_article").hide();
                $("#call_cate").show();
            break;

            case 'link':
            case 'spec':
            case 'tag_list':
            case 'tag_rank':
                $("#call_article").hide();
                $("#call_cate").hide();
            break;

            default:
                $("#call_article").show();
                $("#call_cate").hide();
            break;
        }
    }

    $(document).ready(function(){
        call_type("<?php echo $this->tplData['callRow']['call_type']; ?>");
        $("#call_modal").on("shown.bs.modal",function(event){
    		var _spec_key = $("#spec_key").val();
    		var _obj_button   = $(event.relatedTarget);
            $("#call_modal .modal-content").load("<?php echo BG_URL_CONSOLE; ?>index.php?mod=spec&act=insert&target=call&call_id=<?php echo $this->tplData['callRow']['call_id']; ?>&view=modal&key=" + _spec_key);
    	}).on("hidden.bs.modal", function(){
        	$("#call_modal .modal-content").empty();
    	});

        var obj_validate_form = $("#call_form").baigoValidator(opts_validator_form);
        var obj_submit_form   = $("#call_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
        var obj_duplicate_form   = $("#call_duplicate").baigoSubmit(opts_duplicate_form);
        $(".bg-duplicate").click(function(){
            obj_duplicate_form.formSubmit();
        });
        $("#call_type").change(function(){
            var _call_type = $(this).val();
            call_type(_call_type);
        });
        $("#call_form").baigoCheckall();
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>