<?php $cfg = array(
    "title"          => $this->consoleMod["admin"]["main"]["title"],
    "menu_active"    => "admin",
    "sub_active"     => "list",
    "baigoCheckall"  => "true",
    "baigoValidator" => "true",
    "baigoSubmit"    => "true",
    "pathInclude"    => BG_PATH_TPLSYS . "console/default/include/",
    "str_url"        => BG_URL_CONSOLE . "index.php?mod=admin&act=list&" . $this->tplData["query"],
);

include($cfg["pathInclude"] . "function.php");
include($cfg["pathInclude"] . "console_head.php"); ?>

    <div class="form-group clearfix">
        <div class="pull-left">
            <div class="form-group">
                <ul class="nav nav-pills bg-nav-pills">
                    <li>
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=admin&act=form">
                            <span class="glyphicon glyphicon-plus"></span>
                            <?php echo $this->lang["href"]["add"]; ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=admin&act=auth">
                            <span class="glyphicon glyphicon-ok-sign"></span>
                            <?php echo $this->lang["href"]["auth"]; ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=admin" target="_blank">
                            <span class="glyphicon glyphicon-question-sign"></span>
                            <?php echo $this->lang["href"]["help"]; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="pull-right">
            <form name="admin_search" id="admin_search" action="<?php echo BG_URL_CONSOLE; ?>index.php" method="get" class="form-inline">
                <input type="hidden" name="mod" value="admin">
                <input type="hidden" name="act" value="list">
                <div class="form-group hidden-sm hidden-xs">
                    <select name="type" class="form-control input-sm">
                        <option value=""><?php echo $this->lang["option"]["allType"]; ?></option>
                        <?php foreach ($this->type["admin"] as $key=>$value) { ?>
                            <option <?php if ($this->tplData["search"]["type"] == $key) { ?>selected<?php } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group hidden-sm hidden-xs">
                    <select name="status" class="form-control input-sm">
                        <option value=""><?php echo $this->lang["option"]["allStatus"]; ?></option>
                        <?php foreach ($this->status["admin"] as $key=>$value) { ?>
                            <option <?php if ($this->tplData["search"]["status"] == $key) { ?>selected<?php } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <div class="input-group input-group-sm">
                        <input type="text" name="key" class="form-control" value="<?php echo $this->tplData["search"]["key"]; ?>" placeholder="<?php echo $this->lang["label"]["key"]; ?>">
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

    <form name="admin_list" id="admin_list" class="form-inline">
        <input type="hidden" name="<?php echo $this->common["tokenRow"]["name_session"]; ?>" value="<?php echo $this->common["tokenRow"]["token"]; ?>">

        <div class="panel panel-default">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-nowrap bg-td-xs">
                                <label for="chk_all" class="checkbox-inline">
                                    <input type="checkbox" name="chk_all" id="chk_all" data-parent="first">
                                    <?php echo $this->lang["label"]["all"]; ?>
                                </label>
                            </th>
                            <th class="text-nowrap bg-td-xs"><?php echo $this->lang["label"]["id"]; ?></th>
                            <th><?php echo $this->lang["label"]["admin"]; ?></th>
                            <th class="text-nowrap bg-td-md"><?php echo $this->lang["label"]["adminGroup"]; ?> / <?php echo $this->lang["label"]["note"]; ?></th>
                            <th class="text-nowrap bg-td-md"><?php echo $this->lang["label"]["status"]; ?> / <?php echo $this->lang["label"]["type"]; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($this->tplData["adminRows"] as $key=>$value) { ?>
                            <tr>
                                <td class="text-nowrap bg-td-xs"><input type="checkbox" name="admin_ids[]" value="<?php echo $value["admin_id"]; ?>" id="admin_id_<?php echo $value["admin_id"]; ?>" data-parent="chk_all" data-validate="admin_id"></td>
                                <td class="text-nowrap bg-td-xs"><?php echo $value["admin_id"]; ?></td>
                                <td>
                                    <ul class="list-unstyled">
                                        <li>
                                            <?php if (fn_isEmpty($value["admin_name"])) {
                                                echo $this->lang["label"]["adminUnknow"];
                                            } else {
                                                echo $value["admin_name"];
                                                if (!fn_isEmpty($value["admin_nick"])) {
                                                    echo "[ " . $value["admin_nick"] . " ]";
                                                }
                                            } ?>
                                        </li>
                                        <li>
                                            <ul class="bg-nav-line">
                                                <?php if (fn_isEmpty($value["admin_name"])) { ?>
                                                    <li>
                                                        <?php echo $this->lang["href"]["show"]; ?>
                                                    </li>
                                                    <li>
                                                        <?php echo $this->lang["href"]["edit"]; ?>
                                                    </li>
                                                    <li>
                                                        <?php echo $this->lang["href"]["toGroup"]; ?>
                                                    </li>
                                                <?php } else { ?>
                                                    <li>
                                                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=admin&act=show&admin_id=<?php echo $value["admin_id"]; ?>"><?php echo $this->lang["href"]["show"]; ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=admin&act=form&admin_id=<?php echo $value["admin_id"]; ?>"><?php echo $this->lang["href"]["edit"]; ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="#admin_modal" data-toggle="modal" data-id="<?php echo $value["admin_id"]; ?>"><?php echo $this->lang["href"]["toGroup"]; ?></a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                    </ul>
                                </td>
                                <td class="text-nowrap bg-td-md">
                                    <ul class="list-unstyled">
                                        <li>
                                            <?php if (isset($value["groupRow"]["group_name"]) && !fn_isEmpty($value["groupRow"]["group_name"])) { ?>
                                                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=admin&act=list&group_id=<?php echo $value["admin_group_id"]; ?>"><?php echo $value["groupRow"]["group_name"]; ?></a>
                                            <?php } else {
                                                echo $this->lang["label"]["none"];
                                            } ?>
                                        </li>
                                        <li><?php echo $value["admin_note"]; ?></li>
                                    </ul>
                                </td>
                                <td class="text-nowrap bg-td-md">
                                    <ul class="list-unstyled">
                                        <li>
                                            <?php admin_status_process($value["admin_status"], $this->status["admin"]); ?>
                                        </li>
                                        <li><?php echo $this->type["admin"][$value["admin_type"]]; ?></li>
                                    </ul>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><span id="msg_admin_id"></span></td>
                            <td colspan="3">
                                <div class="bg-submit-box bg-submit-box-list"></div>
                                <div class="form-group">
                                    <div id="group_act">
                                        <select name="act" id="act" data-validate class="form-control input-sm">
                                            <option value=""><?php echo $this->lang["option"]["batch"]; ?></option>
                                            <?php foreach ($this->status["admin"] as $key=>$value) { ?>
                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php } ?>
                                            <option value="del"><?php echo $this->lang["option"]["del"]; ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-sm bg-submit"><?php echo $this->lang["btn"]["submit"]; ?></button>
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
        <?php include($cfg["pathInclude"] . "page.php"); ?>
    </div>

    <div class="modal fade" id="admin_modal">
        <div class="modal-dialog">
            <div class="modal-content">

            </div>
        </div>
    </div>

<?php include($cfg["pathInclude"] . "console_foot.php"); ?>

    <script type="text/javascript">
    var opts_validator_list = {
        admin_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='admin_id']", type: "checkbox" },
            msg: { selector: "#msg_admin_id", too_few: "<?php echo $this->rcode["x030202"]; ?>" }
        },
        act: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_act" },
            msg: { selector: "#msg_act", too_few: "<?php echo $this->rcode["x030203"]; ?>" }
        }
    };

    var opts_submit_list = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=admin",
        confirm: {
            selector: "#act",
            val: "del",
            msg: "<?php echo $this->lang["confirm"]["del"]; ?>"
        },
        box: {
            selector: ".bg-submit-box-list"
        },
        msg_text: {
            submitting: "<?php echo $this->lang["label"]["submitting"]; ?>"
        }
    };

    $(document).ready(function(){
        $("#admin_modal").on("shown.bs.modal",function(event){
    		var _obj_button   = $(event.relatedTarget);
    		var _id          = _obj_button.data("id");
            $("#admin_modal .modal-content").load("<?php echo BG_URL_CONSOLE; ?>index.php?mod=admin&act=toGroup&admin_id=" + _id + "&view=iframe");
        });

        var obj_validate_list   = $("#admin_list").baigoValidator(opts_validator_list);
        var obj_submit_list     = $("#admin_list").baigoSubmit(opts_submit_list);
        $(".bg-submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });
        $("#admin_list").baigoCheckall();
    });
    </script>

<?php include($cfg["pathInclude"] . "html_foot.php"); ?>