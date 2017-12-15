<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['cate']['main']['title'],
    'menu_active'    => 'cate',
    'sub_active'     => "list",
    'baigoCheckall'  => 'true',
    'baigoSubmit'    => 'true',
    'baigoValidator' => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?mod=cate&act=list&" . $this->tplData['query'],
);

include($cfg['pathInclude'] . 'function.php');

function cate_list_table($arr_cateRows, $status_cate, $type_cate, $lang = array()) {
    foreach ($arr_cateRows as $key=>$value) { ?>
        <tr<?php if ($value['cate_level'] == 1) { ?> class="active"<?php } ?>>
            <td class="text-nowrap bg-td-xs">
                <input type="checkbox" name="cate_ids[]" value="<?php echo $value['cate_id']; ?>" id="cate_id_<?php echo $value['cate_id']; ?>" data-validate="cate_id" data-parent="chk_all">
            </td>
            <td class="text-nowrap bg-td-xs"><?php echo $value['cate_id']; ?></td>
            <td class="bg-child-<?php echo $value['cate_level']; ?>">
                <ul class="list-unstyled">
                    <li>
                        <?php if ($value['cate_level'] > 1) { ?>
                            | -
                        <?php }
                        if (fn_isEmpty($value['cate_name'])) {
                            echo $lang['label']['noname'];
                        } else {
                            echo $value['cate_name'];
                        } ?>
                    </li>
                    <li>
                        <ul class="bg-nav-line">
                            <li>
                                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=cate&act=form&cate_id=<?php echo $value['cate_id']; ?>"><?php echo $lang['href']['edit']; ?></a>
                            </li>
                            <li>
                                <a href="#cate_modal" data-toggle="modal" data-id="<?php echo $value['cate_id']; ?>"><?php echo $lang['href']['order']; ?></a>
                            </li>
                            <li>
                                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=article&cate_id=<?php echo $value['cate_id']; ?>"><?php echo $lang['href']['articleList']; ?></a>
                            </li>
                            <?php if (BG_MODULE_GEN > 0 && BG_VISIT_TYPE == 'static' && $value['cate_status'] == 'show') { ?>
                                <li>
                                    <a data-url="<?php echo BG_URL_CONSOLE; ?>index.php?mod=cate_gen&act=single&cate_id=<?php echo $value['cate_id']; ?>&view=iframe" data-toggle="modal" href="#gen_modal">
                                        <span class="glyphicon glyphicon-refresh"></span>
                                        <?php echo $lang['btn']['genSingle']; ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                </ul>
            </td>
            <td>
                <?php if (fn_isEmpty($value['cate_alias'])) {
                    echo $value['cate_id'];
                } else {
                    echo $value['cate_alias'];
                } ?>
            </td>
            <td class="text-nowrap bg-td-sm">
                <ul class="list-unstyled">
                    <li>
                        <?php cate_status_process($value['cate_status'], $status_cate); ?>
                    </li>
                    <li><?php echo $type_cate[$value['cate_type']]; ?></li>
                </ul>
            </td>
        </tr>

        <?php if (isset($value['cate_childs']) && !fn_isEmpty($value['cate_childs'])) {
            cate_list_table($value['cate_childs'], $status_cate, $type_cate, $lang);
        }
    }
}

include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group clearfix">
        <div class="pull-left">
            <div class="form-group">
                <ul class="nav nav-pills bg-nav-pills">
                    <li>
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=cate&act=form">
                            <span class="glyphicon glyphicon-plus"></span>
                            <?php echo $this->lang['mod']['href']['add']; ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=cate" target="_blank">
                            <span class="glyphicon glyphicon-question-sign"></span>
                            <?php echo $this->lang['mod']['href']['help']; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pull-right">
            <form name="cate_search" id="cate_search" action="<?php echo BG_URL_CONSOLE; ?>index.php" method="get" class="form-inline">
                <input type="hidden" name="mod" value="cate">
                <input type="hidden" name="act" value="list">
                <div class="form-group hidden-sm hidden-xs">
                    <select name="type" class="form-control input-sm">
                        <option value=""><?php echo $this->lang['mod']['option']['allType']; ?></option>
                        <?php foreach ($this->tplData['type'] as $key=>$value) { ?>
                            <option <?php if ($this->tplData['search']['type'] == $value) { ?>selected<?php } ?> value="<?php echo $value; ?>">
                                <?php if (isset($this->lang['mod']['type'][$value])) {
                                    echo $this->lang['mod']['type'][$value];
                                } else {
                                    echo $value;
                                } ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group hidden-sm hidden-xs">
                    <select name="status" class="form-control input-sm">
                        <option value=""><?php echo $this->lang['mod']['option']['allStatus']; ?></option>
                        <?php foreach ($this->tplData['status'] as $key=>$value) { ?>
                            <option <?php if ($this->tplData['search']['status'] == $value) { ?>selected<?php } ?> value="<?php echo $value; ?>">
                                <?php if (isset($this->lang['mod']['status'][$value])) {
                                    echo $this->lang['mod']['status'][$value];
                                } else {
                                    echo $value;
                                } ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <div class="input-group input-group-sm">
                        <input type="text" name="key" class="form-control" value="<?php echo $this->tplData['search']['key']; ?>" placeholder="<?php echo $this->lang['mod']['label']['key']; ?>">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <form name="cate_list" id="cate_list" class="form-inline">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">

        <div class="panel panel-default">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="text-nowrap bg-td-xs">
                                <label for="chk_all" class="checkbox-inline">
                                    <input type="checkbox" name="chk_all" id="chk_all" data-parent="first">
                                    <?php echo $this->lang['mod']['label']['all']; ?>
                                </label>
                            </th>
                            <th class="text-nowrap bg-td-xs"><?php echo $this->lang['mod']['label']['id']; ?></th>
                            <th><?php echo $this->lang['mod']['label']['cateName']; ?></th>
                            <th><?php echo $this->lang['mod']['label']['cateAlias']; ?></th>
                            <th class="text-nowrap bg-td-sm"><?php echo $this->lang['mod']['label']['status']; ?> / <?php echo $this->lang['mod']['label']['type']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php cate_list_table($this->tplData['cateRows'], $this->lang['mod']['status'], $this->lang['mod']['type'], $this->lang['mod']); ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><span id="msg_cate_id"></span></td>
                            <td colspan="4">
                                <div class="bg-submit-box"></div>
                                <div class="form-group">
                                    <div id="group_act">
                                        <select name="act" id="act" data-validate class="form-control input-sm">
                                            <option value=""><?php echo $this->lang['mod']['option']['batch']; ?></option>
                                            <?php foreach ($this->tplData['status'] as $key=>$value) { ?>
                                                <option value="<?php echo $value; ?>">
                                                    <?php if (isset($this->lang['mod']['status'][$value])) {
                                                        echo $this->lang['mod']['status'][$value];
                                                    } else {
                                                        echo $value;
                                                    } ?>
                                                </option>
                                            <?php } ?>
                                            <option value="cache"><?php echo $this->lang['mod']['option']['cache']; ?></option>
                                            <option value="del"><?php echo $this->lang['mod']['option']['del']; ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-sm bg-submit"><?php echo $this->lang['mod']['btn']['submit']; ?></button>
                                </div>
                                <div class="form-group">
                                    <span id="msg_act"></span>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </form>

    <div class="text-right">
        <?php include($cfg['pathInclude'] . 'page.php'); ?>
    </div>

    <div class="modal fade" id="cate_modal">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_list = {
        cate_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='cate_id']", type: "checkbox" },
            msg: { selector: "#msg_cate_id", too_few: "<?php echo $this->lang['rcode']['x030202']; ?>" }
        },
        act: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_act" },
            msg: { selector: "#msg_act", too_few: "<?php echo $this->lang['rcode']['x030203']; ?>" }
        }
    };

    var opts_submit_list = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=cate",
        confirm: {
            selector: "#act",
            val: "del",
            msg: "<?php echo $this->lang['mod']['confirm']['del']; ?>"
        },
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    $(document).ready(function(){
        $("#cate_modal").on("shown.bs.modal",function(event){
    		var _obj_button   = $(event.relatedTarget);
    		var _id           = _obj_button.data("id");
            $("#cate_modal .modal-content").load("<?php echo BG_URL_CONSOLE; ?>index.php?mod=cate&act=order&cate_id=" + _id + "&view=modal");
    	}).on("hidden.bs.modal", function(){
        	$("#cate_modal .modal-content").empty();
    	});

        var obj_validate_list  = $("#cate_list").baigoValidator(opts_validator_list);
        var obj_submit_list    = $("#cate_list").baigoSubmit(opts_submit_list);
        $(".bg-submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });
        $("#cate_list").baigoCheckall();
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>