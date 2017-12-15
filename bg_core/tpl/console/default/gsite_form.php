<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['gather']['main']['title'] . ' &raquo; ' . $this->lang['consoleMod']['gather']['sub']['gsite'],
    'menu_active'    => 'gather',
    'sub_active'     => 'gsite',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?mod=gsite",
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group">
        <ul class="nav nav-pills bg-nav-pills">
            <li>
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=gsite&act=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <?php echo $this->lang['common']['href']['back']; ?>
                </a>
            </li>
            <li>
                <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=gsite#form" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    <?php echo $this->lang['mod']['href']['help']; ?>
                </a>
            </li>
        </ul>
    </div>

    <?php if ($this->tplData['gsiteRow']['gsite_id'] > 0) {
        include($cfg['pathInclude'] . "gsite_menu.php");
    } ?>

    <form name="gsite_form" id="gsite_form">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="act" value="submit">
        <input type="hidden" name="gsite_id" id="gsite_id" value="<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div id="group_gsite_name">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['gsiteName']; ?><span id="msg_gsite_name">*</span></label>
                                <input type="text" name="gsite_name" id="gsite_name" value="<?php echo $this->tplData['gsiteRow']['gsite_name']; ?>" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_gsite_url">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['gsiteUrl']; ?><span id="msg_gsite_url">*</span></label>
                                <input type="text" name="gsite_url" id="gsite_url" value="<?php echo $this->tplData['gsiteRow']['gsite_url']; ?>" data-validate class="form-control" placeholder="http://">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <div id="group_gsite_charset">
                                        <label class="control-label"><?php echo $this->lang['mod']['label']['gsiteCharset']; ?><span id="msg_gsite_charset">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="gsite_charset" id="gsite_charset" value="<?php echo $this->tplData['gsiteRow']['gsite_charset']; ?>" data-validate class="form-control" placeholder="UTF-8">
                                            <span class="input-group-btn">
                                                <a href="#charset_list_modal" class="btn btn-warning" data-toggle="modal">
                                                    <span class="glyphicon glyphicon-question-sign"></span>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label"><?php echo $this->lang['mod']['label']['charsetOften']; ?></label>
                                    <select id="charset_opt" class="form-control">
                                        <option value=""><?php echo $this->lang['mod']['option']['pleaseSelect']; ?></option>
                                        <?php foreach ($this->tplData['charsetRows'] as $key=>$value) { ?>
                                            <optgroup label="<?php echo $value['title']; ?>">
                                                <?php foreach ($value['list'] as $key_sub=>$value_sub) { ?>
                                                    <option <?php if ($this->tplData['gsiteRow']['gsite_charset'] == $key_sub) { ?>selected<?php } ?> value="<?php echo $key_sub; ?>">
                                                        <?php echo $value_sub['title'], ' ', $key_sub; ?>
                                                    </option>
                                                <?php } ?>
                                            </optgroup>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_gsite_note">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['note']; ?><span id="msg_gsite_note"></span></label>
                                <input type="text" name="gsite_note" id="gsite_note" value="<?php echo $this->tplData['gsiteRow']['gsite_note']; ?>" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="bg-submit-box"></div>
                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['save']; ?></button>
                        <?php if ($this->tplData['gsiteRow']['gsite_id'] > 0) { ?>
                            <button type="button" class="btn btn-default bg-duplicate"><?php echo $this->lang['mod']['btn']['duplicate']; ?></button>
                        <?php } ?>
                    </div>
                </div>

                <?php if ($this->tplData['gsiteRow']['gsite_id'] > 0) { ?>
                    <div class="panel panel-default">
                        <div class="panel-heading"><?php echo $this->lang['mod']['label']['gsiteSource']; ?></div>
                        <div class="panel-body" id="gsite_source">
                            <div class="loading">
                                <h1>
                                    <span class="glyphicon glyphicon-refresh bg-spin"></span>
                                    Loading...
                                </h1>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="col-md-3">
                <div class="well">
                    <?php if ($this->tplData['gsiteRow']['gsite_id'] > 0) { ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['id']; ?></label>
                            <div class="form-control-static"><?php echo $this->tplData['gsiteRow']['gsite_id']; ?></div>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <div id="group_gsite_cate_id">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['belongCate']; ?><span id="msg_gsite_cate_id">*</span></label>
                            <select name="gsite_cate_id" id="gsite_cate_id" data-validate class="form-control">
                                <option value=""><?php echo $this->lang['mod']['option']['pleaseSelect']; ?></option>
                                <?php cate_list_opt($this->tplData['cateRows'], $this->tplData['gsiteRow']['gsite_cate_id'], true); ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="group_gsite_status">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['status']; ?><span id="msg_gsite_status">*</span></label>
                            <?php foreach ($this->tplData['status'] as $key=>$value) { ?>
                                <div class="bg-radio">
                                    <label for="gsite_status_<?php echo $value; ?>">
                                        <input type="radio" name="gsite_status" id="gsite_status_<?php echo $value; ?>" <?php if ($this->tplData['gsiteRow']['gsite_status'] == $value) { ?>checked<?php } ?> value="<?php echo $value; ?>" data-validate="gsite_status">
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

    <form name="gsite_duplicate" id="gsite_duplicate">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="act" value="duplicate">
        <input type="hidden" name="gsite_id" id="gsite_id" value="<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>">
    </form>

    <div class="modal fade" id="charset_list_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo $this->lang['mod']['label']['charset']; ?></h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <?php foreach ($this->tplData['charsetRows'] as $key=>$value) { ?>
                            <thead>
                                <tr>
                                    <th class="text-nowrap"><?php echo $value['title']; ?></th>
                                    <th class="text-nowrap"><?php echo $this->lang['mod']['label']['name']; ?></th>
                                    <th><?php echo $this->lang['mod']['label']['note']; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($value['list'] as $key_sub=>$value_sub) { ?>
                                    <tr>
                                        <td class="text-nowrap"><?php echo $key_sub; ?></td>
                                        <td class="text-nowrap">
                                            <?php echo $value_sub['title'];
                                            if (isset($value_sub['often'])) { ?><code>*</code><?php } ?>
                                        </td>
                                        <td><?php echo $value_sub['note']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang['common']['btn']['close']; ?></button>
                </div>
            </div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'gsite_foot.php');
include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_form = {
        gsite_name: {
            len: { min: 1, max: 300 },
            validate: { type: "str", format: "text", group: "#group_gsite_name" },
            msg: { selector: "#msg_gsite_name", too_short: "<?php echo $this->lang['rcode']['x270201']; ?>", too_long: "<?php echo $this->lang['rcode']['x270202']; ?>" }
        },
        gsite_url: {
            len: { min: 1, max: 900 },
            validate: { type: "str", format: "url", group: "#group_gsite_url" },
            msg: { selector: "#msg_gsite_url", too_short: "<?php echo $this->lang['rcode']['x270203']; ?>", too_long: "<?php echo $this->lang['rcode']['x270204']; ?>", format_err: "<?php echo $this->lang['rcode']['x270210']; ?>" }
        },
        gsite_charset: {
            len: { min: 1, max: 100 },
            validate: { type: "str", format: "text", group: "#group_gsite_charset" },
            msg: { selector: "#msg_gsite_charset", too_short: "<?php echo $this->lang['rcode']['x270211']; ?>", too_long: "<?php echo $this->lang['rcode']['x270212']; ?>" }
        },
        gsite_cate_id: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_gsite_cate_id" },
            msg: { selector: "#msg_gsite_cate_id", too_few: "<?php echo $this->lang['rcode']['x270206']; ?>" }
        },
        gsite_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='gsite_status']", type: "radio", group: "#group_gsite_status" },
            msg: { selector: "#msg_gsite_status", too_few: "<?php echo $this->lang['rcode']['x270208']; ?>" }
        },
        gsite_note: {
            len: { min: 0, max: 30 },
            validate: { type: "str", format: "text", group: "#group_gsite_note" },
            msg: { selector: "#msg_gsite_note", too_long: "<?php echo $this->lang['rcode']['x270209']; ?>" }
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=gsite",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    var opts_duplicate_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=gsite",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    $(document).ready(function(){
        $("#charset_opt").change(function(){
            var _charset_val = $(this).val();
            $("#gsite_charset").val(_charset_val);
        });
        var obj_validate_form = $("#gsite_form").baigoValidator(opts_validator_form);
        var obj_submit_form   = $("#gsite_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
        var obj_duplicate_form   = $("#gsite_duplicate").baigoSubmit(opts_duplicate_form);
        $(".bg-duplicate").click(function(){
            obj_duplicate_form.formSubmit();
        });
        $("#gsite_source").html("<div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' scrolling='auto' src='<?php echo BG_URL_CONSOLE; ?>index.php?mod=gsite_source&act=form&gsite_id=<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>'></iframe></div>");
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>