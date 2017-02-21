<?php
$cfg = array(
    "title"          => $this->consoleMod["article"]["main"]["title"],
    "menu_active"    => "article",
    "sub_active"     => "list",
    "baigoCheckall"  => "true",
    "baigoValidator" => "true",
    "baigoSubmit"    => "true",
    "tooltip"        => "true",
    "pathInclude"    => BG_PATH_TPLSYS . "console/default/include/",
    "str_url"        => BG_URL_CONSOLE . "index.php?mod=article&act=list&" . $this->tplData["query"],
);

include($cfg["pathInclude"] . "function.php");
include($cfg["pathInclude"] . "console_head.php"); ?>

    <div class="form-group clearfix">
        <div class="pull-left">
            <div class="form-group">
                <ul class="nav nav-pills bg-nav-pills">
                    <li>
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=article&act=form">
                            <span class="glyphicon glyphicon-plus"></span>
                            <?php echo $this->lang["href"]["add"]; ?>
                        </a>
                    </li>
                    <li class="hidden-xs<?php if (fn_isEmpty($this->tplData["search"]["box"])) { ?> active<?php } ?>">
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=article">
                            <?php echo $this->lang["href"]["all"]; ?>
                            <span class="badge"><?php echo $this->tplData["articleCount"]["all"]; ?></span>
                        </a>
                    </li>
                    <li class="hidden-xs<?php if ($this->tplData["search"]["box"] == "draft") { ?> active<?php } ?>">
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=article&box=draft">
                            <?php echo $this->lang["href"]["draft"]; ?>
                            <span class="badge"><?php echo $this->tplData["articleCount"]["draft"]; ?></span>
                        </a>
                    </li>
                    <?php if ($this->tplData["articleCount"]["recycle"] > 0) { ?>
                        <li class="hidden-xs<?php if ($this->tplData["search"]["box"] == "recycle") { ?> active<?php } ?>">
                            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=article&box=recycle">
                                <?php echo $this->lang["href"]["recycle"]; ?>
                                <span class="badge"><?php echo $this->tplData["articleCount"]["recycle"]; ?></span>
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=article" target="_blank">
                            <span class="glyphicon glyphicon-question-sign"></span>
                            <?php echo $this->lang["href"]["help"]; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pull-right">
            <form name="article_search" id="article_search" action="<?php echo BG_URL_CONSOLE; ?>index.php" method="get" class="form-inline">
                <input type="hidden" name="mod" value="article">
                <input type="hidden" name="act" value="list">
                <input type="hidden" name="box" value="<?php echo $this->tplData["search"]["box"]; ?>">
                <div class="form-group hidden-sm hidden-xs">
                    <select name="cate_id" class="form-control input-sm">
                        <option value=""><?php echo $this->lang["option"]["allCate"]; ?></option>
                        <?php cate_list_opt($this->tplData["cateRows"], $this->tplData["search"]["cate_id"]); ?>
                        <option<?php if ($this->tplData["search"]["cate_id"] == -1) { ?> selected<?php } ?> value="-1">
                            <?php echo $this->lang["option"]["unknown"]; ?>
                        </option>
                    </select>
                </div>
                <div class="form-group hidden-sm hidden-xs">
                    <select name="year" class="form-control input-sm">
                        <option value=""><?php echo $this->lang["option"]["allYear"]; ?></option>
                        <?php foreach ($this->tplData["articleYear"] as $key=>$value) { ?>
                            <option<?php if ($this->tplData["search"]["year"] == $value["article_year"]) { ?> selected<?php } ?> value="<?php echo $value["article_year"]; ?>"><?php echo $value["article_year"]; ?></option>
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
                            }
                            ?>
                            <option<?php if ($this->tplData["search"]["month"] == $str_month) { ?> selected<?php } ?> value="<?php echo $str_month; ?>"><?php echo $str_month; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group hidden-sm hidden-xs">
                    <select name="mark_id" class="form-control input-sm">
                        <option value=""><?php echo $this->lang["option"]["allMark"]; ?></option>
                        <?php foreach ($this->tplData["markRows"] as $key=>$value) { ?>
                            <option<?php if ($this->tplData["search"]["mark_id"] == $value["mark_id"]) { ?> selected<?php } ?> value="<?php echo $value["mark_id"]; ?>"><?php echo $value["mark_name"]; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group hidden-sm hidden-xs">
                    <select name="status" class="form-control input-sm">
                        <option value=""><?php echo $this->lang["option"]["allStatus"]; ?></option>
                        <?php foreach ($this->status["article"] as $key=>$value) { ?>
                            <option<?php if ($this->tplData["search"]["status"] == $key) { ?> selected<?php } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
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

    <?php if ($this->tplData["search"]["box"] == "recycle") { ?>
        <form name="article_empty" id="article_empty">
            <input type="hidden" name="<?php echo $this->common["tokenRow"]["name_session"]; ?>" value="<?php echo $this->common["tokenRow"]["token"]; ?>">
            <input type="hidden" id="act_empty" name="act" value="empty">
            <div class="form-group">
                <button type="button" id="go_empty" class="btn btn-info btn-sm"><?php echo $this->lang["btn"]["emptyMy"]; ?></button>
            </div>
        </form>
    <?php }

    if (BG_MODULE_GEN > 0 && BG_VISIT_TYPE == "static" && fn_isEmpty($this->tplData["search"]["box"])) { ?>
        <div class="form-group">
            <div class="btn-group btn-group-sm">
                <button data-url="<?php echo BG_URL_CONSOLE; ?>gen.php?mod=article&act=1by1" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#gen_modal">
                    <span class="glyphicon glyphicon-refresh"></span>
                    <?php echo $this->lang["btn"]["articleGen1by1"]; ?>
                </button>
                <button data-url="<?php echo BG_URL_CONSOLE; ?>gen.php?mod=article&act=1by1&enforce=true" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#gen_modal">
                    <span data-toggle="tooltip" data-placement="bottom" title="<?php echo $this->lang["label"]["enforce"]; ?>"><?php echo $this->lang["btn"]["articleGenEnforce"]; ?></span>
                </button>
            </div>
        </div>
    <?php } ?>

    <form name="article_list" id="article_list" class="form-inline">
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
                            <th><?php echo $this->lang["label"]["articleTitle"]; ?></th>
                            <th class="text-nowrap bg-td-md"><?php echo $this->lang["label"]["cate"]; ?> / <?php echo $this->lang["label"]["articleMark"]; ?></th>
                            <th class="text-nowrap bg-td-md"><?php echo $this->lang["label"]["admin"]; ?> / <?php echo $this->lang["label"]["hits"]; ?></th>
                            <th class="text-nowrap bg-td-md"><?php echo $this->lang["label"]["status"]; ?> / <?php echo $this->lang["label"]["time"]; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($this->tplData["articleRows"] as $key=>$value) {
                            if ($value["article_is_gen"] == "yes") {
                                $css_gen = "default";
                            } else {
                                $css_gen = "danger";
                            }

                            $str_gen = $this->status["gen"][$value["article_is_gen"]]; ?>
                            <tr>
                                <td class="text-nowrap bg-td-xs"><input type="checkbox" name="article_ids[]" value="<?php echo $value["article_id"]; ?>" id="article_id_<?php echo $value["article_id"]; ?>" data-validate="article_id" data-parent="chk_all"></td>
                                <td class="text-nowrap bg-td-xs"><?php echo $value["article_id"]; ?></td>
                                <td>
                                    <ul class="list-unstyled">
                                        <li>
                                            <?php if (fn_isEmpty($value["article_title"])) {
                                                echo $this->lang["label"]["noname"];
                                            } else {
                                                echo $value["article_title"];
                                            } ?>
                                        </li>
                                        <li>
                                            <ul class="bg-nav-line">
                                                <li>
                                                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=article&act=show&article_id=<?php echo $value["article_id"]; ?>"><?php echo $this->lang["href"]["show"]; ?></a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=article&act=form&article_id=<?php echo $value["article_id"]; ?>"><?php echo $this->lang["href"]["edit"]; ?></a>
                                                </li>
                                                <?php if (BG_MODULE_GEN > 0 && BG_VISIT_TYPE == "static" && $value["article_box"] == "normal" && $value["article_status"] == "pub" && $value["article_time_pub"] < time() && ($value["article_time_hide"] < 1 || $value["article_time_hide"] > time())) { ?>
                                                    <li>
                                                        <a class="btn btn-xs btn-info"  href="#gen_modal" data-url="<?php echo BG_URL_CONSOLE; ?>gen.php?mod=article&act=single&article_id=<?php echo $value["article_id"]; ?>" data-toggle="modal">
                                                            <span class="glyphicon glyphicon-refresh"></span>
                                                            <?php echo $this->lang["btn"]["articleGenSingle"]; ?>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                    </ul>
                                </td>
                                <td class="text-nowrap bg-td-md">
                                    <ul class="list-unstyled">
                                        <li>
                                            <?php $str_cateTrees = "";
                                            if (isset($value["cateRow"]["cate_trees"])) {
                                                foreach ($value["cateRow"]["cate_trees"] as $key_tree=>$value_tree) {
                                                    $str_cateTrees .= $value_tree["cate_name"];
                                                    if ($value_tree != end($value["cateRow"]["cate_trees"])) {
                                                        $str_cateTrees .= " &raquo; ";
                                                    }
                                                }
                                            }

                                            if (isset($value["cateRow"]["cate_name"])) { ?>
                                                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=article&act=list&cate_id=<?php echo $value_tree["cate_id"]; ?>">
                                                    <abbr data-toggle="tooltip" data-placement="bottom" title="<?php echo $str_cateTrees; ?>">
                                                        <?php echo $value["cateRow"]["cate_name"]; ?>
                                                    </abbr>
                                                </a>
                                            <?php } else {
                                                echo $this->lang["label"]["unknown"];
                                            } ?>
                                        </li>
                                        <li>
                                            <?php if (isset($value["markRow"]["mark_name"])) { ?>
                                                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=article&mark_id=<?php echo $value["article_mark_id"]; ?>"><?php echo $value["markRow"]["mark_name"]; ?></a>
                                            <?php } else {
                                                echo $this->lang["label"]["none"];
                                            } ?>
                                        </li>
                                    </ul>
                                </td>
                                <td class="text-nowrap bg-td-md">
                                    <ul class="list-unstyled">
                                        <li>
                                            <?php if (isset($value["adminRow"]["admin_name"])) { ?>
                                                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=article&admin_id=<?php echo $value["article_admin_id"]; ?>&box=<?php echo $this->tplData["search"]["box"]; ?>"><?php echo $value["adminRow"]["admin_name"]; ?></a>
                                            <?php } else {
                                                echo $this->lang["label"]["unknown"];
                                            } ?>
                                        </li>
                                        <li>
                                            <abbr data-toggle="tooltip" data-placement="bottom" title="
                                                <?php echo $this->lang["label"]["hitsDay"]; ?>
                                                <?php echo $value["article_hits_day"]; ?><br>
                                                <?php echo $this->lang["label"]["hitsWeek"]; ?>
                                                <?php echo $value["article_hits_week"]; ?><br>
                                                <?php echo $this->lang["label"]["hitsMonth"]; ?>
                                                <?php echo $value["article_hits_month"]; ?><br>
                                                <?php echo $this->lang["label"]["hitsYear"]; ?>
                                                <?php echo $value["article_hits_year"]; ?><br>
                                                <?php echo $this->lang["label"]["hitsAll"]; ?>
                                                <?php echo $value["article_hits_all"]; ?>
                                            ">
                                                <?php echo $value["article_hits_all"]; ?>
                                            </abbr>
                                        </li>
                                    </ul>
                                </td>
                                <td class="text-nowrap bg-td-md">
                                    <ul class="list-unstyled">
                                        <li>
                                            <?php article_status_process($value, $this->status["article"], $this->lang); ?>
                                            <?php if (BG_MODULE_GEN > 0 && BG_VISIT_TYPE == "static") { ?>
                                                <span class="label label-<?php echo $css_gen; ?> bg-label"><?php echo $str_gen; ?></span>
                                            <?php } ?>
                                        </li>
                                        <li>
                                            <abbr data-toggle="tooltip" data-placement="bottom" title="<?php echo date(BG_SITE_DATE . " " . BG_SITE_TIME, $value["article_time"]); ?>">
                                                <?php echo date(BG_SITE_DATESHORT . " " . BG_SITE_TIMESHORT, $value["article_time"]); ?>
                                            </abbr>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">
                                <span id="msg_article_id"></span>
                            </td>
                            <td colspan="4">
                                <div class="bg-submit-box"></div>
                                <div class="form-group">
                                    <div id="group_act">
                                        <select name="act" id="act" data-validate class="form-control input-sm">
                                            <option value=""><?php echo $this->lang["option"]["batch"]; ?></option>
                                            <?php switch($this->tplData["search"]["box"]) {
                                                case "recycle":
                                                ?>
                                                    <option value="normal"><?php echo $this->lang["option"]["revert"]; ?></option>
                                                    <option value="draft"><?php echo $this->lang["option"]["draft"]; ?></option>
                                                    <option value="del"><?php echo $this->lang["option"]["del"]; ?></option>
                                                <?php break;

                                                case "draft": ?>
                                                    <option value="normal"><?php echo $this->lang["option"]["revert"]; ?></option>
                                                    <option value="recycle"><?php echo $this->lang["option"]["recycle"]; ?></option>
                                                <?php break;

                                                default:
                                                    foreach ($this->status["article"] as $key=>$value) { ?>
                                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                    <?php } ?>
                                                    <option value="top"><?php echo $this->lang["option"]["top"]; ?></option>
                                                    <option value="untop"><?php echo $this->lang["option"]["untop"]; ?></option>
                                                    <option value="move"><?php echo $this->lang["option"]["moveToCate"]; ?></option>
                                                    <option value="normal"><?php echo $this->lang["option"]["revert"]; ?></option>
                                                    <option value="draft"><?php echo $this->lang["option"]["draft"]; ?></option>
                                                    <option value="recycle"><?php echo $this->lang["option"]["recycle"]; ?></option>
                                            <?php break;
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="form_cate_id">
                                    <select id="cate_id" name="cate_id" data-validate class="form-control input-sm">
                                        <option value="">
                                            <?php echo $this->lang["option"]["pleaseSelect"]; ?>
                                        </option>
                                        <?php cate_list_opt($this->tplData["cateRows"], $this->tplData["search"]["cate_id"], true); ?>
                                    </select>
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

<?php include($cfg["pathInclude"] . "console_foot.php"); ?>

    <script type="text/javascript">
    var opts_validator_list = {
        article_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='article_id']", type: "checkbox" },
            msg: { selector: "#msg_article_id", too_few: "<?php echo $this->rcode["x030202"]; ?>" }
        },
        cate_id: {
            len: { min: 1, "max": 0 },
            validate: { type: "select", group: "#group_cate_id" },
            msg: { selector: "#msg_act", too_few: "<?php echo $this->rcode["x250225"]; ?>" }
        },
        act: {
            len: { min: 1, "max": 0 },
            validate: { type: "select", group: "#group_act" },
            msg: { selector: "#msg_act", too_few: "<?php echo $this->rcode["x030203"]; ?>" }
        }
    };

    var opts_submit_list = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=article",
        confirm: {
            selector: "#act",
            val: "del",
            msg: "<?php echo $this->lang["confirm"]["del"]; ?>"
        },
        msg_text: {
            submitting: "<?php echo $this->lang["label"]["submitting"]; ?>"
        }
    };

    var opts_submit_empty = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=article",
        confirm: {
            selector: "#act_empty",
            val: "empty",
            msg: "<?php echo $this->lang["confirm"]["empty"]; ?>"
        },
        msg_text: {
            submitting: "<?php echo $this->lang["label"]["submitting"]; ?>"
        }
    };

    $(document).ready(function(){
        $("#form_cate_id").hide();
        var obj_validate_list = $("#article_list").baigoValidator(opts_validator_list);
        var obj_submit_list   = $("#article_list").baigoSubmit(opts_submit_list);
        $(".bg-submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });

        var obj_submit_empty = $("#article_empty").baigoSubmit(opts_submit_empty);
        $("#go_empty").click(function(){
            obj_submit_empty.formSubmit();
        });

        $("#act").change(function(){
            var _act = $(this).val();
            if (_act == "move") {
                $("#form_cate_id").show();
            } else {
                $("#form_cate_id").hide();
            }
        });

        $("#article_list").baigoCheckall();
    });
    </script>

<?php include($cfg["pathInclude"] . "html_foot.php"); ?>