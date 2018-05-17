<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['cate']['main']['title'],
    'menu_active'    => 'cate',
    'sub_active'     => "list",
    'baigoCheckall'  => 'true',
    'baigoSubmit'    => 'true',
    'baigoValidator' => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?m=cate&a=list&" . $this->tplData['query'],
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
                                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=cate&a=form&cate_id=<?php echo $value['cate_id']; ?>"><?php echo $lang['href']['edit']; ?></a>
                            </li>
                            <li>
                                <a href="#cate_modal" data-toggle="modal" data-id="<?php echo $value['cate_id']; ?>"><?php echo $lang['href']['order']; ?></a>
                            </li>
                            <li>
                                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=article&cate_id=<?php echo $value['cate_id']; ?>"><?php echo $lang['href']['articleList']; ?></a>
                            </li>
                            <?php if (BG_MODULE_GEN > 0 && BG_VISIT_TYPE == 'static' && $value['cate_status'] == 'show') { ?>
                                <li>
                                    <a data-url="<?php echo BG_URL_CONSOLE; ?>index.php?m=cate_gen&a=single&cate_id=<?php echo $value['cate_id']; ?>&view=iframe" data-toggle="modal" href="#gen_modal">
                                        <span class="oi oi-loop-circular"></span>
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

    <div class="clearfix mb-3">
        <div class="float-left">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=cate&a=form" class="nav-link">
                        <span class="oi oi-plus"></span>
                        <?php echo $this->lang['mod']['href']['add']; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BG_URL_HELP; ?>index.php?m=console&a=cate" class="nav-link" target="_blank">
                        <span class="badge badge-pill badge-primary">
                            <span class="oi oi-question-mark"></span>
                        </span>
                        <?php echo $this->lang['mod']['href']['help']; ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="float-right">
            <form name="cate_search" id="cate_search" action="<?php echo BG_URL_CONSOLE; ?>index.php" method="get">
                <input type="hidden" name="m" value="cate">
                <input type="hidden" name="a" value="list">
                <div class="input-group">
                    <select name="status" class="custom-select">
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
                    <select name="type" class="custom-select d-none d-md-block">
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
                    <input type="text" name="key" class="form-control" value="<?php echo $this->tplData['search']['key']; ?>" placeholder="<?php echo $this->lang['mod']['label']['key']; ?>">
                    <span class="input-group-append">
                        <button class="btn btn-secondary" type="submit">
                            <span class="oi oi-magnifying-glass"></span>
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>

    <form name="cate_list" id="cate_list">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">

        <div class="table-responsive">
            <table class="table table-hover border">
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
                        <th><?php echo $this->lang['mod']['label']['cateName']; ?></th>
                        <th><?php echo $this->lang['mod']['label']['cateAlias']; ?></th>
                        <th class="text-nowrap bg-td-sm"><?php echo $this->lang['mod']['label']['status']; ?> / <?php echo $this->lang['mod']['label']['type']; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php cate_list_table($this->tplData['cateRows'], $this->lang['mod']['status'], $this->lang['mod']['type'], $this->lang['mod']); ?>
                </tbody>
            </table>
        </div>

         <div class="mt-3">
            <small class="form-text" id="msg_cate_id"></small>
            <div class="bg-submit-box bg-submit-box-list"></div>
        </div>

       <div class="clearfix mt-3">
            <div class="float-left">
                <div class="input-group">
                    <select name="a" id="a" data-validate class="custom-select">
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
            msg: { too_few: "<?php echo $this->lang['rcode']['x030202']; ?>" }
        },
        a: {
            len: { min: 1, max: 0 },
            validate: { type: "select" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x030203']; ?>" }
        }
    };

    var opts_submit_list = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=cate&c=request",
        confirm: {
            selector: "#a",
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
            $("#cate_modal .modal-content").load("<?php echo BG_URL_CONSOLE; ?>index.php?m=cate&a=order&cate_id=" + _id + "&view=modal");
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

<?php include('include' . DS . 'html_foot.php');