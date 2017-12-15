<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['gather']['main']['title'] . ' &raquo; ' . $this->lang['consoleMod']['gather']['sub']['gather'],
    'menu_active'    => 'gather',
    'sub_active'     => 'gather',
    'baigoCheckall'  => 'true',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?mod=gsite&act=list&" . $this->tplData['query'],
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group clearfix">
        <div class="pull-left">
            <div class="form-group">
                <ul class="nav nav-pills bg-nav-pills">
                    <li>
                        <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=gsite" target="_blank">
                            <span class="glyphicon glyphicon-question-sign"></span>
                            <?php echo $this->lang['mod']['href']['help']; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pull-right">
            <form name="gsite_search" id="gsite_search" action="<?php echo BG_URL_CONSOLE; ?>index.php" method="get" class="form-inline">
                <input type="hidden" name="mod" value="gsite">
                <input type="hidden" name="act" value="list">
                <div class="form-group hidden-sm hidden-xs">
                    <select name="status" class="form-control input-sm">
                        <option value=""><?php echo $this->lang['mod']['option']['allStatus']; ?></option>
                        <?php foreach ($this->tplData['statusGsite'] as $key=>$value) { ?>
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

    <div class="form-group">
        <button data-id="0" class="btn btn-primary btn-sm" data-toggle="modal" data-act="1by1" data-target="#gather_modal">
            <span class="glyphicon glyphicon-refresh"></span>
            <?php echo $this->lang['mod']['btn']['gather1by1']; ?>
        </button>
    </div>

    <div class="panel panel-default">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-nowrap bg-td-xs"><?php echo $this->lang['mod']['label']['id']; ?></th>
                        <th><?php echo $this->lang['mod']['label']['gsite']; ?></th>
                        <th class="text-nowrap bg-td-md"><?php echo $this->lang['mod']['label']['status']; ?> / <?php echo $this->lang['mod']['label']['note']; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!fn_isEmpty($this->tplData['gsiteRows'])) {
                        foreach ($this->tplData['gsiteRows'] as $key=>$value) { ?>
                            <tr>
                                <td class="text-nowrap bg-td-xs"><?php echo $value['gsite_id']; ?></td>
                                <td>
                                    <ul class="list-unstyled">
                                        <li><?php echo $value['gsite_name']; ?></li>
                                        <li>
                                            <ul class="bg-nav-line">
                                                <li>
                                                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=gsite&act=show&gsite_id=<?php echo $value['gsite_id']; ?>"><?php echo $this->lang['mod']['href']['show']; ?></a>
                                                </li>
                                                <li>
                                                    <a href="#gather_modal" data-id="<?php echo $value['gsite_id']; ?>" data-act="single" data-toggle="modal"><?php echo $this->lang['mod']['btn']['gatherStart']; ?></a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </td>
                                <td class="text-nowrap bg-td-md">
                                    <ul class="list-unstyled">
                                        <li><?php gsite_status_process($value['gsite_status'], $this->lang['mod']['status']); ?></li>
                                        <li><?php echo $value['gsite_note']; ?></li>
                                    </ul>
                                </td>
                            </tr>
                        <?php }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-right">
        <?php include($cfg['pathInclude'] . 'page.php'); ?>
    </div>

    <div class="modal fade" id="gather_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div id="gather_msg_box">
                        <span id="gather_msg_icon" class="glyphicon glyphicon-refresh bg-spin"></span>
                        <span id="gather_msg_text">
                            <?php echo $this->lang['mod']['page']['gathering']; ?>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="embed-responsive embed-responsive-4by3">
                        <iframe class="embed-responsive-item"></iframe>
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
        gsite_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='gsite_id']", type: "checkbox" },
            msg: { selector: "#msg_gsite_id", too_few: "<?php echo $this->lang['rcode']['x030202']; ?>" }
        },
        act: {
            len: { min: 1, max: 0 },
            validate: { type: "select", gsite: "#gsite_act" },
            msg: { selector: "#msg_act", too_few: "<?php echo $this->lang['rcode']['x030203']; ?>" }
        }
    };

    var opts_submit_list = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=gsite",
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
    		var _id           = _obj_button.data("id");
    		var _act          = _obj_button.data("act");
    		var _url;

    		switch(_act) {
        		case '1by1':
            		_url = "<?php echo BG_URL_CONSOLE; ?>index.php?mod=gather&act=1by1&view=iframe";
        		break;

        		default:
            		_url = "<?php echo BG_URL_CONSOLE; ?>index.php?mod=gather&act=single&view=iframe&gsite_id=" + _id;
        		break;
    		}

    		$("#gather_modal iframe").attr("src", _url);
    	}).on("hidden.bs.modal", function(){
        	$("#gather_modal iframe").attr("src", '');
        	$("#gather_msg_box").attr("class", '');
        	$("#gather_msg_icon").attr("class", "glyphicon glyphicon-refresh bg-spin");
        	$("#gather_msg_text").text("<?php echo $this->lang['mod']['page']['gathering']; ?>");
    	});

        var obj_validate_list = $("#gsite_list").baigoValidator(opts_validator_list);
        var obj_submit_list = $("#gsite_list").baigoSubmit(opts_submit_list);
        $(".bg-submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });
        $("#gsite_list").baigoCheckall();
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>