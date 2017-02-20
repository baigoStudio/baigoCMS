<?php $cfg = array(
    "title"          => $this->consoleMod["article"]["main"]["title"] . " &raquo; " . $this->lang["page"]["custom"],
    "menu_active"    => "article",
    "sub_active"     => "custom",
    "baigoCheckall"  => "true",
    "baigoValidator" => "true",
    "baigoSubmit"    => "true",
    "pathInclude"    => BG_PATH_TPLSYS . "console/default/include/",
    "str_url"        => BG_URL_CONSOLE . "index.php?mod=custom&act=list&" . $this->tplData["query"],
);

include($cfg["pathInclude"] . "function.php");

function custom_list_table($arr_customRows, $status_custom, $type_custom, $lang = array()) {
    foreach ($arr_customRows as $key=>$value) { ?>
        <tr <?php if ($value["custom_level"] == 1) { ?> class="active"<?php } ?>>
            <td class="text-nowrap bg-td-xs">
                <input type="checkbox" name="custom_ids[]" value="<?php echo $value["custom_id"]; ?>" id="custom_id_<?php echo $value["custom_id"]; ?>" data-validate="custom_id" data-parent="chk_all">
            </td>
            <td class="text-nowrap bg-td-xs"><?php echo $value["custom_id"]; ?></td>
            <td class="bg-child-<?php echo $value["custom_level"]; ?>">
                <ul class="list-unstyled">
                    <li>
                        <?php if ($value["custom_level"] > 1) { ?>
                            | -
                        <?php }
                        if (fn_isEmpty($value["custom_name"])) {
                            echo $lang["label"]["noname"];
                        } else {
                            echo $value["custom_name"];
                        } ?>
                    </li>
                    <li>
                        <ul class="bg-nav-line">
                            <li>
                                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=custom&act=form&custom_id=<?php echo $value["custom_id"]; ?>"><?php echo $lang["href"]["edit"]; ?></a>
                            </li>
                            <li>
                                <a href="#custom_modal" data-toggle="modal" data-id="<?php echo $value["custom_id"]; ?>"><?php echo $lang["href"]["order"]; ?></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </td>
            <td class="text-nowrap bg-td-md">
                <ul class="list-unstyled">
                    <li>
                        <?php custom_status_process($value["custom_status"], $status_custom); ?>
                    </li>
                    <li><?php echo $type_custom[$value["custom_format"]]; ?></li>
                </ul>
            </td>
        </tr>

        <?php if (isset($value["custom_childs"]) && !fn_isEmpty($value["custom_childs"])) {
            custom_list_table($value["custom_childs"], $status_custom, $type_custom, $lang);
        }
    }
}

include($cfg["pathInclude"] . "console_head.php"); ?>

    <div class="form-group clearfix">
        <div class="pull-left">
            <div class="form-group">
                <ul class="nav nav-pills bg-nav-pills">
                    <li>
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=custom&act=form">
                            <span class="glyphicon glyphicon-plus"></span>
                            <?php echo $this->lang["href"]["add"]; ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=custom" target="_blank">
                            <span class="glyphicon glyphicon-question-sign"></span>
                            <?php echo $this->lang["href"]["help"]; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pull-right">
            <form name="custom_search" id="custom_search" action="<?php echo BG_URL_CONSOLE; ?>index.php" method="get" class="form-inline">
                <input type="hidden" name="mod" value="custom">
                <input type="hidden" name="act" value="list">
                <div class="form-group hidden-xs">
                    <select name="status" class="form-control input-sm">
                        <option value=""><?php echo $this->lang["option"]["allStatus"]; ?></option>
                        <?php foreach ($this->status["custom"] as $key=>$value) { ?>
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

    <form name="custom_list" id="custom_list" class="form-inline">
        <input type="hidden" name="<?php echo $this->common["tokenRow"]["name_session"]; ?>" value="<?php echo $this->common["tokenRow"]["token"]; ?>">

        <div class="panel panel-default">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="text-nowrap bg-td-xs">
                                <label for="chk_all" class="checkbox-inline">
                                    <input type="checkbox" name="chk_all" id="chk_all" data-parent="first">
                                    <?php echo $this->lang["label"]["all"]; ?>
                                </label>
                            </th>
                            <th class="text-nowrap bg-td-xs"><?php echo $this->lang["label"]["id"]; ?></th>
                            <th><?php echo $this->lang["label"]["customName"]; ?></th>
                            <th class="text-nowrap bg-td-md"><?php echo $this->lang["label"]["status"]; ?> / <?php echo $this->lang["label"]["format"]; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php custom_list_table($this->tplData["customRows"], $this->status["custom"], $this->type["custom"], $this->lang); ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><span id="msg_custom_id"></span></td>
                            <td colspan="2">
                                <div class="bg-submit-box"></div>
                                <div class="form-group">
                                    <div id="group_act">
                                        <select name="act" id="act" data-validate class="form-control input-sm">
                                            <option value=""><?php echo $this->lang["option"]["batch"]; ?></option>
                                            <?php foreach ($this->status["call"] as $key=>$value) { ?>
                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php } ?>
                                            <option value="cache"><?php echo $this->lang["option"]["cache"]; ?></option>
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

    <div class="modal fade" id="custom_modal">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>

<?php include($cfg["pathInclude"] . "console_foot.php"); ?>

    <script type="text/javascript">
    var opts_validator_list = {
        custom_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='custom_id']", type: "checkbox" },
            msg: { selector: "#msg_custom_id", too_few: "<?php echo $this->rcode["x030202"]; ?>" }
        },
        act: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_act" },
            msg: { selector: "#msg_act", too_few: "<?php echo $this->rcode["x030203"]; ?>" }
        }
    };

    var opts_submit_list = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=custom",
        confirm: {
            selector: "#act",
            val: "del",
            msg: "<?php echo $this->lang["confirm"]["del"]; ?>"
        },
        msg_text: {
            submitting: "<?php echo $this->lang["label"]["submitting"]; ?>"
        }
    };

    $(document).ready(function(){
        $("#custom_modal").on("shown.bs.modal",function(event){
    		var _obj_button   = $(event.relatedTarget);
    		var _id           = _obj_button.data("id");
            $("#custom_modal .modal-content").load("<?php echo BG_URL_CONSOLE; ?>index.php?mod=custom&act=order&custom_id=" + _id + "&view=iframe");
        });
        var obj_validate_list = $("#custom_list").baigoValidator(opts_validator_list);
        var obj_submit_list   = $("#custom_list").baigoSubmit(opts_submit_list);
        $(".bg-submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });
        $("#custom_list").baigoCheckall();
    });
    </script>

<?php include($cfg["pathInclude"] . "html_foot.php"); ?>