<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['gather']['main']['title'] . ' &raquo; ' . $this->lang['consoleMod']['gather']['sub']['gsite'],
    'menu_active'    => 'gather',
    'sub_active'     => 'gsite',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?m=gsite",
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php');
include($cfg['pathInclude'] . 'gsite_head.php'); ?>

    <form name="gsite_form" id="gsite_form">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="a" value="submit">
        <input type="hidden" name="gsite_id" id="gsite_id" value="<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>">

        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <?php if ($this->tplData['gsiteRow']['gsite_id'] > 0) {
                        include($cfg['pathInclude'] . 'gsite_menu.php');
                    } ?>
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['gsiteName']; ?> <span class="text-danger">*</span></label>
                            <input type="text" name="gsite_name" id="gsite_name" value="<?php echo $this->tplData['gsiteRow']['gsite_name']; ?>" data-validate class="form-control">
                            <small class="form-text" id="msg_gsite_name"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['gsiteUrl']; ?> <span class="text-danger">*</span></label>
                            <input type="text" name="gsite_url" id="gsite_url" value="<?php echo $this->tplData['gsiteRow']['gsite_url']; ?>" data-validate class="form-control" placeholder="http://">
                            <small class="form-text" id="msg_gsite_url"></small>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-sm-8">
                                <label><?php echo $this->lang['mod']['label']['gsiteCharset']; ?> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="gsite_charset" id="gsite_charset" value="<?php echo $this->tplData['gsiteRow']['gsite_charset']; ?>" data-validate class="form-control" placeholder="UTF-8">
                                    <span class="input-group-append">
                                        <a href="#charset_list_modal" class="btn btn-warning" data-toggle="modal">
                                            <span class="oi oi-question-mark"></span>
                                        </a>
                                    </span>
                                </div>
                                <small class="form-text" id="msg_gsite_charset"></small>
                            </div>
                            <div class="form-group col-sm-4">
                                <label><?php echo $this->lang['mod']['label']['charsetOften']; ?></label>
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

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['note']; ?></label>
                            <input type="text" name="gsite_note" id="gsite_note" value="<?php echo $this->tplData['gsiteRow']['gsite_note']; ?>" data-validate class="form-control">
                            <small class="form-text" id="msg_gsite_note"></small>
                        </div>

                        <div class="bg-submit-box"></div>
                        <div class="bg-validator-box mt-3"></div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['save']; ?></button>
                        <?php if ($this->tplData['gsiteRow']['gsite_id'] > 0) { ?>
                            <button type="button" class="btn btn-outline-secondary bg-duplicate"><?php echo $this->lang['mod']['btn']['duplicate']; ?></button>
                        <?php } ?>
                    </div>
                </div>

                <?php if ($this->tplData['gsiteRow']['gsite_id'] > 0) { ?>
                    <div class="card mt-3">
                        <div class="card-header"><?php echo $this->lang['mod']['label']['gsiteSource']; ?></div>
                        <div class="card-body" id="gsite_source">
                            <div class="loading">
                                <h1>
                                    <span class="oi oi-loop-circular bg-spin"></span>
                                    Loading...
                                </h1>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-body">
                        <?php if ($this->tplData['gsiteRow']['gsite_id'] > 0) { ?>
                            <div class="form-group">
                                <label><?php echo $this->lang['mod']['label']['id']; ?></label>
                                <div class="form-text"><?php echo $this->tplData['gsiteRow']['gsite_id']; ?></div>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['belongCate']; ?> <span class="text-danger">*</span></label>
                            <select name="gsite_cate_id" id="gsite_cate_id" data-validate class="form-control">
                                <option value=""><?php echo $this->lang['mod']['option']['pleaseSelect']; ?></option>
                                <?php cate_list_opt($this->tplData['cateRows'], $this->tplData['gsiteRow']['gsite_cate_id'], true); ?>
                            </select>
                            <small class="form-text" id="msg_gsite_cate_id"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['status']; ?> <span class="text-danger">*</span></label>
                            <?php foreach ($this->tplData['status'] as $key=>$value) { ?>
                                <div class="form-check">
                                    <label for="gsite_status_<?php echo $value; ?>" class="form-check-label">
                                        <input type="radio" name="gsite_status" id="gsite_status_<?php echo $value; ?>" <?php if ($this->tplData['gsiteRow']['gsite_status'] == $value) { ?>checked<?php } ?> value="<?php echo $value; ?>" data-validate="gsite_status" class="form-check-input">
                                        <?php if (isset($this->lang['mod']['status'][$value])) {
                                            echo $this->lang['mod']['status'][$value];
                                        } else {
                                            echo $value;
                                        } ?>
                                    </label>
                                </div>
                            <?php } ?>
                            <small class="form-text" id="msg_gsite_status"></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form name="gsite_duplicate" id="gsite_duplicate">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="a" value="duplicate">
        <input type="hidden" name="gsite_id" id="gsite_id" value="<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>">
    </form>

    <div class="modal fade" id="charset_list_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title"><?php echo $this->lang['mod']['label']['charset']; ?></div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
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
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <?php echo $this->lang['common']['btn']['close']; ?>
                    </button>
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
            validate: { type: "str", format: "text" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x270201']; ?>", too_long: "<?php echo $this->lang['rcode']['x270202']; ?>" }
        },
        gsite_url: {
            len: { min: 1, max: 900 },
            validate: { type: "str", format: "url" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x270203']; ?>", too_long: "<?php echo $this->lang['rcode']['x270204']; ?>", format_err: "<?php echo $this->lang['rcode']['x270210']; ?>" }
        },
        gsite_charset: {
            len: { min: 1, max: 100 },
            validate: { type: "str", format: "text" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x270211']; ?>", too_long: "<?php echo $this->lang['rcode']['x270212']; ?>" }
        },
        gsite_cate_id: {
            len: { min: 1, max: 0 },
            validate: { type: "select" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x270206']; ?>" }
        },
        gsite_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='gsite_status']", type: "radio" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x270208']; ?>" }
        },
        gsite_note: {
            len: { min: 0, max: 30 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x270209']; ?>" }
        }
    };

    var options_validator_form = {
        msg_global:{
            msg: "<?php echo $this->lang['common']['label']['errInput']; ?>"
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=gsite&c=request",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    var opts_duplicate_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=gsite&c=request",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    $(document).ready(function(){
        $("#charset_opt").change(function(){
            var _charset_val = $(this).val();
            $("#gsite_charset").val(_charset_val);
        });
        var obj_validate_form = $("#gsite_form").baigoValidator(opts_validator_form, options_validator_form);
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
        $("#gsite_source").html("<div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' scrolling='auto' src='<?php echo BG_URL_CONSOLE; ?>index.php?m=gsite_source&a=form&gsite_id=<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>'></iframe></div>");
    });
    </script>

<?php include('include' . DS . 'html_foot.php');