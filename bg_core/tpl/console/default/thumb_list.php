<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['attach']['main']['title'] . ' &raquo; ' . $this->lang['consoleMod']['attach']['sub']['thumb'],
    'menu_active'    => 'attach',
    'sub_active'     => "thumb",
    'baigoCheckall'  => 'true',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    "baigoClear"     => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?m=thumb&a=list"
);

include($cfg['pathInclude'] . 'console_head.php'); ?>

    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <a href="#thumb_modal" data-toggle="modal" data-id="0" class="nav-link">
                <span class="oi oi-plus"></span>
                <?php echo $this->lang['mod']['href']['add']; ?>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo BG_URL_HELP; ?>index.php?m=console&a=attach#thumb" class="nav-link" target="_blank">
                <span class="badge badge-pill badge-primary">
                    <span class="oi oi-question-mark"></span>
                </span>
                <?php echo $this->lang['mod']['href']['help']; ?>
            </a>
        </li>
    </ul>

    <form name="thumb_list" id="thumb_list">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">

        <div class="table-responsive">
            <table class="table table-striped table-hover border">
                <thead>
                    <tr>
                        <th class="text-nowrap bg-td-xs">
                            <div class="form-check">
                                <label for="chk_all" class="form-check-label">
                                    <input type="checkbox" name="chk_all" id="chk_all" data-parent="first" class="form-check-input">
                                    <?php echo $this->lang['mod']['label']['all']; ?>
                                </label>
                            </div>
                        </th>
                        <th class="text-nowrap bg-td-xs"><?php echo $this->lang['mod']['label']['id']; ?></th>
                        <th><?php echo $this->lang['mod']['label']['thumbWidth']; ?> X <?php echo $this->lang['mod']['label']['thumbHeight']; ?></th>
                        <th class="text-nowrap bg-td-lg"><?php echo $this->lang['mod']['label']['thumbCall']; ?></th>
                        <th class="text-nowrap bg-td-sm"><?php echo $this->lang['mod']['label']['thumbType']; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->tplData['thumbRows'] as $key=>$value) { ?>
                        <tr>
                            <td class="text-nowrap bg-td-xs"><input type="checkbox" name="thumb_ids[]" value="<?php echo $value['thumb_id']; ?>" id="thumb_id_<?php echo $value['thumb_id']; ?>" data-validate="thumb_id" data-parent="chk_all"></td>
                            <td class="text-nowrap bg-td-xs"><?php echo $value['thumb_id']; ?></td>
                            <td>
                                <ul class="list-unstyled">
                                    <li><?php echo $value['thumb_width']; ?> X <?php echo $value['thumb_height']; ?></li>
                                    <li>
                                        <ul class="bg-nav-line">
                                            <?php if ($value['thumb_id'] > 0) { ?>
                                                <li>
                                                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=thumb&a=show&thumb_id=<?php echo $value['thumb_id']; ?>"><?php echo $this->lang['mod']['href']['show']; ?></a>
                                                </li>
                                                <li>
                                                    <a href="#thumb_modal" data-toggle="modal" data-id="<?php echo $value['thumb_id']; ?>"><?php echo $this->lang['mod']['href']['edit']; ?></a>
                                                </li>
                                            <?php } else { ?>
                                                <li>
                                                    <?php echo $this->lang['mod']['href']['show']; ?>
                                                </li>
                                                <li>
                                                    <?php echo $this->lang['mod']['href']['edit']; ?>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                </ul>
                            </td>
                            <td class="text-nowrap bg-td-lg">thumb_<?php echo $value['thumb_width']; ?>_<?php echo $value['thumb_height']; ?>_<?php echo $value['thumb_type']; ?></td>
                            <td class="text-nowrap bg-td-sm">
                                <?php if (isset($this->lang['mod']['type'][$value['thumb_type']])) {
                                    echo $this->lang['mod']['type'][$value['thumb_type']];
                                } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <small class="form-text" id="msg_thumb_id"></small>
            <div class="bg-submit-box bg-submit-box-list"></div>
        </div>

        <div class="clearfix mt-3">
            <div class="float-left">
                <div class="input-group">
                    <select name="a" id="a" data-validate class="custom-select">
                        <option value=""><?php echo $this->lang['mod']['option']['batch']; ?></option>
                        <option value="cache"><?php echo $this->lang['mod']['option']['cache']; ?></option>
                        <option value="del"><?php echo $this->lang['mod']['option']['del']; ?></option>
                    </select>
                    <span class="input-group-append">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['submit']; ?></button>
                    </span>
                </div>
                <small class="form-text" id="msg_a"></small>
            </div>
            <div class="float-right">
                <?php include($cfg['pathInclude'] . 'page.php'); ?>
            </div>
        </div>
    </form>

    <div class="modal fade" id="thumb_modal">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_list = {
        thumb_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='thumb_id']", type: "checkbox" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x030202']; ?>" }
        },
        a: {
            len: { min: 1, max: 0 },
            validate: { type: "select" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x030203']; ?>" }
        }
    };

    var opts_submit_list = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=thumb&c=request",
        confirm: {
            selector: "#a",
            val: "del",
            msg: "<?php echo $this->lang['mod']['confirm']['del']; ?>"
        },
        box: {
            selector: ".bg-submit-box-list"
        },
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    $(document).ready(function(){
        $("#thumb_modal").on("shown.bs.modal", function(event) {
    		var _obj_button   = $(event.relatedTarget);
    		var _id           = _obj_button.data("id");
            $("#thumb_modal .modal-content").load("<?php echo BG_URL_CONSOLE; ?>index.php?m=thumb&a=form&thumb_id=" + _id + "&view=modal");
    	}).on("hidden.bs.modal", function(){
        	$("#thumb_modal .modal-content").empty();
    	});

        var obj_validate_list = $("#thumb_list").baigoValidator(opts_validator_list);
        var obj_submit_list   = $("#thumb_list").baigoSubmit(opts_submit_list);
        $(".bg-submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });
        $("#thumb_list").baigoCheckall();
    });
    </script>

<?php include('include' . DS . 'html_foot.php');