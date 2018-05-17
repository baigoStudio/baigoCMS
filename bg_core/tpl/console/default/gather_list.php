<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['gather']['main']['title'] . ' &raquo; ' . $this->lang['consoleMod']['gather']['sub']['approve'],
    'menu_active'    => 'gather',
    'sub_active'     => "approve",
    'baigoCheckall'  => 'true',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    "tooltip"        => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?m=gather&a=list&" . $this->tplData['query'],
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="clearfix mb-3">
        <div class="float-left">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a href="<?php echo BG_URL_HELP; ?>index.php?m=gather&a=gather#store" class="nav-link" target="_blank">
                        <span class="badge badge-pill badge-primary">
                            <span class="oi oi-question-mark"></span>
                        </span>
                        <?php echo $this->lang['mod']['href']['help']; ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="float-right">
            <form name="gather_search" id="gather_search" action="<?php echo BG_URL_CONSOLE; ?>index.php" method="get">
                <input type="hidden" name="m" value="gather">
                <input type="hidden" name="a" value="list">
                <div class="input-group">
                    <select name="gsite_id" class="custom-select">
                        <option value=""><?php echo $this->lang['mod']['option']['allGsite']; ?></option>
                        <?php foreach ($this->tplData['gsiteRows'] as $_key=>$_value) { ?>
                            <option <?php if ($_value['gsite_id'] == $this->tplData['search']['gsite_id']) { ?>selected<?php } ?> value="<?php echo $_value['gsite_id']; ?>"><?php echo $_value['gsite_name']; ?></option>
                        <?php } ?>
                    </select>
                    <select name="cate_id" class="custom-select d-none d-md-block">
                        <option value=""><?php echo $this->lang['mod']['option']['allCate']; ?></option>
                        <?php cate_list_opt($this->tplData['cateRows'], $this->tplData['search']['cate_id']); ?>
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

    <div class="form-group">
        <button class="btn btn-primary" data-toggle="modal" data-act="storeAll" data-target="#gather_modal">
            <span class="oi oi-saved"></span>
            <?php echo $this->lang['mod']['btn']['storeAll']; ?>
        </button>
    </div>

    <form name="gather_list" id="gather_list">
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
                        <th><?php echo $this->lang['mod']['label']['title']; ?></th>
                        <th class="text-nowrap"><?php echo $this->lang['mod']['label']['gsite']; ?> / <?php echo $this->lang['mod']['label']['belongCate']; ?></th>
                        <th class="text-nowrap"><?php echo $this->lang['mod']['label']['status']; ?> / <?php echo $this->lang['mod']['label']['time']; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->tplData['gatherRows'] as $key=>$value) { ?>
                        <tr>
                            <td class="text-nowrap bg-td-xs">
                                <input type="checkbox" name="gather_ids[]" value="<?php echo $value['gather_id']; ?>" id="gather_id_<?php echo $value['gather_id']; ?>" data-parent="chk_all" data-validate="gather_id" class="gather_id">
                            </td>
                            <td class="text-nowrap bg-td-xs"><?php echo $value['gather_id']; ?></td>
                            <td>
                                <ul class="list-unstyled">
                                    <li><?php echo $value['gather_title']; ?></li>
                                    <li>
                                        <ul class="bg-nav-line">
                                            <li>
                                                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=gather&a=show&gather_id=<?php echo $value['gather_id']; ?>"><?php echo $this->lang['mod']['href']['show']; ?></a>
                                            </li>
                                            <li>
                                                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=article&a=form&gather_id=<?php echo $value['gather_id']; ?>">
                                                    <?php echo $this->lang['mod']['href']['edit']; ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </td>
                            <td class="text-nowrap">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=gather&a=list&gsite_id=<?php echo $value['gather_gsite_id']; ?>">
                                            <?php if (isset($value['gsiteRow']['gsite_name'])) {
                                                echo $value['gsiteRow']['gsite_name'];
                                            } else {
                                                echo $this->lang['mod']['label']['unknown'];
                                            } ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=gather&a=list&cate_id=<?php echo $value['gather_cate_id']; ?>">
                                            <?php if (isset($value['cateRow']['cate_name'])) {
                                                echo $value['cateRow']['cate_name'];
                                            } else {
                                                echo $this->lang['mod']['label']['unknown'];
                                            } ?>
                                        </a>
                                    </li>
                                </ul>
                            </td>
                            <td class="text-nowrap">
                                <ul class="list-unstyled">
                                    <li><?php gather_status_process($value['gather_article_id'], $this->lang['mod']['status']); ?></li>
                                    <li>
                                        <abbr data-toggle="tooltip" data-placement="bottom" title="<?php echo date(BG_SITE_DATE . ' ' . BG_SITE_TIME, $value['gather_time']); ?>">
                                            <?php echo date(BG_SITE_DATESHORT . ' ' . BG_SITE_TIMESHORT, $value['gather_time']); ?>
                                        </abbr>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

         <div class="mt-3">
            <small class="form-text" id="msg_gather_id"></small>
            <div class="bg-submit-box bg-submit-box-list"></div>
        </div>

       <div class="clearfix mt-3">
            <div class="float-left">
                <input type="hidden" name="a" id="a" value="del">
                <div class="btn-toolbar">
                    <div class="btn-group mr-3">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-act="store" data-enforce="false" data-target="#gather_modal"><?php echo $this->lang['mod']['btn']['store']; ?></button>
                        <button type="button" class="btn btn-outline-secondary bg-submit"><?php echo $this->lang['mod']['btn']['del']; ?></button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-act="store" data-enforce="true" data-target="#gather_modal"><?php echo $this->lang['mod']['btn']['storeEnforce']; ?></button>
                    </div>
                </div>
                <small class="form-text" id="msg_a"></small>
            </div>
            <div class="float-right">
                <?php include($cfg['pathInclude'] . 'page.php'); ?>
            </div>
        </div>
    </form>

    <div class="modal fade" id="gather_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <span class="oi oi-loop-circular bg-spin"></span>
                        <?php echo $this->lang['mod']['page']['storing']; ?>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="embed-responsive embed-responsive-1by1">
                    <iframe class="embed-responsive-item" name="iframe_gen"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <?php echo $this->lang['common']['btn']['close']; ?>
                    </button>
                </div>
            </div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_list = {
        gather_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='gather_id']", type: "checkbox" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x030202']; ?>" }
        }
    };

    var opts_submit_list = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=gather&c=request",
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
    	$("#gather_modal").on("shown.bs.modal", function(event){
    		var _obj_button   = $(event.relatedTarget);
    		var _act          = _obj_button.data("act");
    		var _enforce      = _obj_button.data("enforce");
            var _ids          = $(".gather_id:checked").serialize();

    		$("#gather_modal iframe").attr("src", "<?php echo BG_URL_CONSOLE; ?>index.php?m=gather&view=iframe&a=" + _act + "&" + _ids + "&enforce=" + _enforce);
    	}).on("hidden.bs.modal", function(){
        	$("#gather_modal .iframe").attr("src", "");
    	});

        var obj_validate_list   = $("#gather_list").baigoValidator(opts_validator_list);
        var obj_submit_list     = $("#gather_list").baigoSubmit(opts_submit_list);
        $(".bg-submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });
        $("#gather_list").baigoCheckall();
    });
    </script>

<?php include('include' . DS . 'html_foot.php');