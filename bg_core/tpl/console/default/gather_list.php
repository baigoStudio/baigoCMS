<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['gather']['main']['title'] . ' &raquo; ' . $this->lang['consoleMod']['gather']['sub']['approve'],
    'menu_active'    => 'gather',
    'sub_active'     => "approve",
    'baigoCheckall'  => 'true',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    "tooltip"        => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?mod=gather&act=list&" . $this->tplData['query'],
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group clearfix">
        <div class="pull-left">
            <div class="form-group">
                <ul class="nav nav-pills bg-nav-pills">
                    <li>
                        <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=gather" target="_blank">
                            <span class="glyphicon glyphicon-question-sign"></span>
                            <?php echo $this->lang['mod']['href']['help']; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pull-right">
            <form name="gather_search" id="gather_search" action="<?php echo BG_URL_CONSOLE; ?>index.php" method="get" class="form-inline">
                <input type="hidden" name="mod" value="gather">
                <input type="hidden" name="act" value="list">
                <div class="form-group hidden-sm hidden-xs">
                    <select name="cate_id" class="form-control input-sm">
                        <option value=""><?php echo $this->lang['mod']['option']['allCate']; ?></option>
                        <?php cate_list_opt($this->tplData['cateRows'], $this->tplData['search']['cate_id']); ?>
                    </select>
                </div>
                <div class="form-group hidden-sm hidden-xs">
                    <select name="gsite_id" class="form-control input-sm">
                        <option value=""><?php echo $this->lang['mod']['option']['allGsite']; ?></option>
                        <?php foreach ($this->tplData['gsiteRows'] as $_key=>$_value) { ?>
                            <option <?php if ($_value['gsite_id'] == $this->tplData['search']['gsite_id']) { ?>selected<?php } ?> value="<?php echo $_value['gsite_id']; ?>"><?php echo $_value['gsite_name']; ?></option>
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

    <div class="form-group">
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-act="storeAll" data-target="#gather_modal">
            <span class="glyphicon glyphicon-saved"></span>
            <?php echo $this->lang['mod']['btn']['storeAll']; ?>
        </button>
    </div>

    <form name="gather_list" id="gather_list" class="form-inline">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">

        <div class="panel panel-default">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-nowrap bg-td-xs">
                                <label for="chk_all" class="checkbox-inline">
                                    <input type="checkbox" name="chk_all" id="chk_all" data-parent="first">
                                    <?php echo $this->lang['mod']['label']['all']; ?>
                                </label>
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
                                                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=gather&act=show&gather_id=<?php echo $value['gather_id']; ?>"><?php echo $this->lang['mod']['href']['show']; ?></a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=article&act=form&gather_id=<?php echo $value['gather_id']; ?>">
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
                                            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=gather&act=list&gsite_id=<?php echo $value['gather_gsite_id']; ?>">
                                                <?php if (isset($value['gsiteRow']['gsite_name'])) {
                                                    echo $value['gsiteRow']['gsite_name'];
                                                } else {
                                                    echo $this->lang['mod']['label']['unknown'];
                                                } ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=gather&act=list&cate_id=<?php echo $value['gather_cate_id']; ?>">
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
                    <tfoot>
                        <tr>
                            <td colspan="2"><span id="msg_gather_id"></span></td>
                            <td colspan="3">
                                <div class="bg-submit-box"></div>
                                <input type="hidden" name="act" id="act" value="del">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-act="store" data-enforce="false" data-target="#gather_modal"><?php echo $this->lang['mod']['btn']['store']; ?></button>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-default btn-sm bg-submit"><?php echo $this->lang['mod']['btn']['del']; ?></button>
                                </div>
                                <div class="form-group pull-right">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-act="store" data-enforce="true" data-target="#gather_modal"><?php echo $this->lang['mod']['btn']['storeEnforce']; ?></button>
                                </div>
                                <div class="clearfix"></div>
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

    <div class="modal fade" id="gather_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="glyphicon glyphicon-refresh bg-spin"></span>
                    <?php echo $this->lang['mod']['page']['storing']; ?>
                </div>
                <div class="modal-body">
                    <div class="embed-responsive embed-responsive-4by3">
                        <iframe class="embed-responsive-item" name="iframe_gen"></iframe>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
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
            msg: { selector: "#msg_gather_id", too_few: "<?php echo $this->lang['rcode']['x030202']; ?>" }
        }
    };

    var opts_submit_list = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=gather",
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
    	$("#gather_modal").on("shown.bs.modal", function(event){
    		var _obj_button   = $(event.relatedTarget);
    		var _act          = _obj_button.data("act");
    		var _enforce      = _obj_button.data("enforce");
            var _ids          = $(".gather_id:checked").serialize();

    		$("#gather_modal iframe").attr("src", "<?php echo BG_URL_CONSOLE; ?>index.php?mod=gather&view=iframe&act=" + _act + "&" + _ids + "&enforce=" + _enforce);
    	}).on("hidden.bs.modal", function(){
        	$("#gather_modal .iframe").attr("src", '');
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

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>