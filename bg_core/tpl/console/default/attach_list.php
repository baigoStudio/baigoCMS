<?php $cfg = array(
    "title"          => $this->consoleMod["attach"]["main"]["title"],
    "menu_active"    => "attach",
    "sub_active"     => "list",
    "baigoCheckall"  => "true",
    "baigoValidator" => "true",
    "baigoSubmit"    => "true",
    "baigoClear"     => "true",
    "upload"         => "true",
    "tooltip"        => "true",
    "pathInclude"    => BG_PATH_TPLSYS . "console/default/include/",
    "str_url"        => BG_URL_CONSOLE . "index.php?mod=attach&act=list&" . $this->tplData["query"],
);

include($cfg["pathInclude"] . "function.php");
include($cfg["pathInclude"] . "console_head.php"); ?>

    <div class="form-group clearfix">
        <div class="pull-left">
            <div class="form-group">
                <ul class="nav nav-pills bg-nav-pills">
                    <li<?php if ($this->tplData["search"]["box"] == "normal") { ?> class="active"<?php } ?>>
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=attach">
                            <?php echo $this->lang["href"]["all"]; ?>
                            <span class="badge"><?php echo $this->tplData["attachCount"]["all"]; ?></span>
                        </a>
                    </li>
                    <?php if ($this->tplData["attachCount"]["recycle"] > 0) { ?>
                        <li<?php if ($this->tplData["search"]["box"] == "recycle") { ?> class="active"<?php } ?>>
                            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=attach&box=recycle">
                                <?php echo $this->lang["href"]["recycle"]; ?>
                                <span class="badge"><?php echo $this->tplData["attachCount"]["recycle"]; ?></span>
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=attach" target="_blank">
                            <span class="glyphicon glyphicon-question-sign"></span>
                            <?php echo $this->lang["href"]["help"]; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pull-right">
            <form name="attach_search" id="attach_search" action="<?php echo BG_URL_CONSOLE; ?>index.php" method="get" class="form-inline">
                <input type="hidden" name="mod" value="attach">
                <input type="hidden" name="act" value="list">
                <div class="form-group hidden-sm hidden-xs">
                    <select name="year" class="form-control input-sm">
                        <option value=""><?php echo $this->lang["option"]["allYear"]; ?></option>
                        <?php foreach ($this->tplData["yearRows"] as $key=>$value) { ?>
                            <option <?php if ($this->tplData["search"]["year"] == $value["attach_year"]) { ?>selected<?php } ?> value="<?php echo $value["attach_year"]; ?>"><?php echo $value["attach_year"]; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group hidden-sm hidden-xs">
                    <select name="month" class="form-control input-sm">
                        <option value=""><?php echo $this->lang["option"]["allMonth"]; ?></option>
                        <?php for ($iii = 1 ; $iii <= 12; $iii++) {
                            if ($iii < 10) {
                                $str_month = "0" . $iii;
                            } else {
                                $str_month = $iii;
                            } ?>
                            <option <?php if ($this->tplData["search"]["month"] == $str_month) { ?>selected<?php } ?> value="<?php echo $str_month; ?>"><?php echo $str_month; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group hidden-sm hidden-xs">
                    <select name="ext" class="form-control input-sm">
                        <option value=""><?php echo $this->lang["option"]["allExt"]; ?></option>
                        <?php foreach ($this->tplData["extRows"] as $key=>$value) { ?>
                            <option <?php if ($this->tplData["search"]["ext"] == $value["attach_ext"]) { ?>selected<?php } ?> value="<?php echo $value["attach_ext"]; ?>"><?php echo $value["attach_ext"]; ?></option>
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

    <div class="row">
        <div class="col-md-3">
            <?php if ($this->tplData["search"]["box"] != "recycle") {
                include($cfg["pathInclude"] . "upload.php");
            } ?>

            <div class="well">
                <?php if ($this->tplData["search"]["box"] == "recycle") { ?>
                    <form name="attach_empty" id="attach_empty">
                        <input type="hidden" name="<?php echo $this->common["tokenRow"]["name_session"]; ?>" value="<?php echo $this->common["tokenRow"]["token"]; ?>">
                        <input type="hidden" name="act" id="act_empty" value="empty">
                        <div class="form-group">
                            <button type="button" class="btn btn-warning" id="go_empty">
                                <span class="glyphicon glyphicon-trash"></span>
                                <?php echo $this->lang["btn"]["empty"]; ?>
                            </button>
                        </div>
                        <div class="form-group">
                            <div class="baigoClear progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped active"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="baigoClearMsg">

                            </div>
                        </div>
                    </form>
                <?php } else { ?>
                    <form name="attach_clear" id="attach_clear">
                        <input type="hidden" name="<?php echo $this->common["tokenRow"]["name_session"]; ?>" value="<?php echo $this->common["tokenRow"]["token"]; ?>">
                        <input type="hidden" name="act" id="act_clear" value="clear">
                        <div class="form-group">
                            <button type="button" class="btn btn-warning" id="go_clear">
                                <span class="glyphicon glyphicon-trash"></span>
                                <?php echo $this->lang["btn"]["attachClear"]; ?>
                            </button>
                        </div>
                        <div class="form-group">
                            <div class="baigoClear progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped active"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="baigoClearMsg">

                            </div>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>

        <div class="col-md-9">
            <form name="attach_list" id="attach_list" class="form-inline">
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
                                    <th class="text-nowrap bg-td-sm"><?php echo $this->lang["label"]["attachThumb"]; ?></th>
                                    <th><?php echo $this->lang["label"]["attachInfo"]; ?></th>
                                    <th class="text-nowrap bg-td-md"><?php echo $this->lang["label"]["status"]; ?> / <?php echo $this->lang["label"]["admin"]; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($this->tplData["attachRows"] as $key=>$value) {
                                    if ($value["attach_box"] == "normal") {
                                        $css_status = "success";
                                    } else {
                                        $css_status = "default";
                                    } ?>
                                    <tr>
                                        <td class="text-nowrap bg-td-xs"><input type="checkbox" name="attach_ids[]" value="<?php echo $value["attach_id"]; ?>" id="attach_id_<?php echo $value["attach_id"]; ?>" data-validate="attach_id" data-parent="chk_all"></td>
                                        <td class="text-nowrap bg-td-xs"><?php echo $value["attach_id"]; ?></td>
                                        <td class="text-nowrap bg-td-sm">
                                            <?php if ($value["attach_type"] == "image") { ?>
                                                <a href="<?php echo $value["attach_url"]; ?>" target="_blank"><img src="<?php echo $value["attach_thumb"][0]["thumb_url"]; ?>" alt="<?php echo $value["attach_name"]; ?>" width="100"></a>
                                            <?php } else { ?>
                                                <a href="<?php echo $value["attach_url"]; ?>" target="_blank"><img src="<?php echo BG_URL_STATIC; ?>image/file_<?php echo $value["attach_ext"]; ?>.png" alt="<?php echo $value["attach_name"]; ?>" width="50"></a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <ul class="list-unstyled">
                                                <li><a href="<?php echo $value["attach_url"]; ?>" target="_blank"><?php echo $value["attach_name"]; ?></a></li>
                                                <li>
                                                    <abbr data-toggle="tooltip" data-placement="bottom" title="<?php echo date(BG_SITE_DATE . " " . BG_SITE_TIME, $value["attach_time"]); ?>"><?php echo date(BG_SITE_DATE, $value["attach_time"]); ?></abbr>
                                                </li>
                                                <?php
                                                $arr_size = attach_size_process($value["attach_size"]);
                                                $num_attachSize = $arr_size["size"];
                                                $str_attachUnit = $arr_size["unit"];
                                                ?>
                                                <li>
                                                    <?php echo fn_numFormat($num_attachSize, 2); ?>
                                                    <?php echo $str_attachUnit; ?>
                                                </li>
                                                <li>
                                                    <?php if ($value["attach_type"] == "image") { ?>
                                                        <div class="dropdown">
                                                            <button class="btn btn-default dropdown-toggle btn-sm" type="button" id="attach_<?php echo $value["attach_id"]; ?>" data-toggle="dropdown">
                                                                <?php echo $this->lang["btn"]["thumb"]; ?>
                                                                <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <?php foreach ($value["attach_thumb"] as $key_thumb=>$value_thumb) { ?>
                                                                    <li>
                                                                        <a href="<?php echo $value_thumb["thumb_url"]; ?>" target="_blank">
                                                                            <?php echo $value_thumb["thumb_width"]; ?>
                                                                            x
                                                                            <?php echo $value_thumb["thumb_height"]; ?>
                                                                            <?php echo $this->type["thumb"][$value_thumb["thumb_type"]]; ?>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>
                                                            </ul>
                                                        </div>
                                                    <?php } ?>
                                                </li>
                                            </ul>
                                        </td>
                                        <td class="text-nowrap bg-td-md">
                                            <ul class="list-unstyled">
                                                <li>
                                                    <span class="label label-<?php echo $css_status; ?> bg-label"><?php echo $this->lang["label"][$value["attach_box"]]; ?></span>
                                                </li>
                                                <li>
                                                    <?php if (isset($value["adminRow"]["admin_name"])) { ?>
                                                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=attach&admin_id=<?php echo $value["attach_admin_id"]; ?>"><?php echo $value["adminRow"]["admin_name"]; ?></a>
                                                    <?php } else {
                                                        echo $this->lang["label"]["unknown"];
                                                    } ?>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2">
                                        <span id="msg_attach_id"></span>
                                    </td>
                                    <td colspan="3">
                                        <div class="bg-submit-box"></div>
                                        <div class="form-group">
                                            <div id="group_act">
                                                <select name="act" id="act" data-validate class="form-control input-sm">
                                                    <option value=""><?php echo $this->lang["option"]["batch"]; ?></option>
                                                    <?php if ($this->tplData["search"]["box"] == "recycle") { ?>
                                                        <option value="normal"><?php echo $this->lang["option"]["revert"]; ?></option>
                                                        <option value="del"><?php echo $this->lang["option"]["del"]; ?></option>
                                                    <?php } else { ?>
                                                        <option value="recycle"><?php echo $this->lang["option"]["recycle"]; ?></option>
                                                    <?php } ?>
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
        </div>
    </div>

<?php include($cfg["pathInclude"] . "console_foot.php"); ?>

    <script type="text/javascript">
    var opts_validator_list = {
        attach_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='attach_id']", type: "checkbox" },
            msg: { selector: "#msg_attach_id", too_few: "<?php echo $this->rcode["x030202"]; ?>" }
        },
        act: {
            len: { min: 1, "max": 0 },
            validate: { type: "select", group: "#group_act" },
            msg: { selector: "#msg_act", too_few: "<?php echo $this->rcode["x030203"]; ?>" }
        }
    };

    var opts_submit_list = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=attach",
        confirm: {
            selector: "#act",
            val: "del",
            msg: "<?php echo $this->lang["confirm"]["del"]; ?>"
        },
        msg_text: {
            submitting: "<?php echo $this->lang["label"]["submitting"]; ?>"
        }
    };

    var opts_empty = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=attach",
        confirm: {
            selector: "#act_empty",
            val: "empty",
            msg: "<?php echo $this->lang["confirm"]["empty"]; ?>"
        },
        msg: {
            loading: "<?php echo $this->rcode["x070408"]; ?>",
            complete: "<?php echo $this->rcode["y070408"]; ?>"
        }
    };

    var opts_clear = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=attach",
        confirm: {
            selector: "#act_clear",
            val: "clear",
            msg: "<?php echo $this->lang["confirm"]["clear"]; ?>"
        },
        msg: {
            loading: "<?php echo $this->rcode["x070407"]; ?>",
            complete: "<?php echo $this->rcode["y070407"]; ?>"
        }
    };

    $(document).ready(function(){
        var obj_validate_list = $("#attach_list").baigoValidator(opts_validator_list);
        var obj_submit_list   = $("#attach_list").baigoSubmit(opts_submit_list);
        $(".bg-submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });
        var obj_empty = $("#attach_empty").baigoClear(opts_empty);
        $("#go_empty").click(function(){
            obj_empty.clearSubmit();
        });
        var obj_clear  = $("#attach_clear").baigoClear(opts_clear);
        $("#go_clear").click(function(){
            obj_clear.clearSubmit();
        });
        $("#attach_list").baigoCheckall();
    });
    </script>

<?php include($cfg["pathInclude"] . "html_foot.php"); ?>