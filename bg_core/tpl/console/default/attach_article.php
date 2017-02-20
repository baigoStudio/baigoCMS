<?php $cfg = array(
    "title"          => $this->consoleMod["article"]["main"]["title"] . " &raquo; " . $this->lang["page"]["attachArticle"],
    "menu_active"    => "article",
    "sub_active"     => "list",
    "baigoValidator" => "true",
    "baigoSubmit"    => "true",
    "tooltip"        => "true",
    "pathInclude"    => BG_PATH_TPLSYS . "console/default/include/",
    "str_url"        => BG_URL_CONSOLE . "index.php?mod=attach&act=article&article_id=" . $this->tplData["articleRow"]["article_id"],
);

include($cfg["pathInclude"] . "function.php");
include($cfg["pathInclude"] . "console_head.php"); ?>

    <div class="form-group clearfix">
        <div class="pull-left">
            <div class="form-group">
                <ul class="nav nav-pills bg-nav-pills">
                    <li>
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=article&act=form&article_id=<?php echo $this->tplData["articleRow"]["article_id"]; ?>">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                            <?php echo $this->lang["href"]["back"]; ?>
                        </a>
                    </li>
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
            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=attach&ids=<?php echo $this->tplData["ids"]; ?>" class="btn btn-info btn-sm"><?php echo $this->lang["href"]["attachList"]; ?></a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="well">
                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang["label"]["id"]; ?></label>
                    <div class="form-control-static"><?php echo $this->tplData["articleRow"]["article_id"]; ?></div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang["label"]["articleTitle"]; ?></label>
                    <div class="form-control-static">
                        <?php echo $this->tplData["articleRow"]["article_title"]; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang["label"]["belongCate"]; ?></label>
                    <div class="form-control-static"><?php echo $this->tplData["cateRow"]["cate_name"]; ?></div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang["label"]["status"]; ?></label>
                    <div class="form-control-static">
                        <?php article_status_process($this->tplData["articleRow"], $this->status["article"], $this->lang); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang["label"]["time"]; ?></label>
                    <div class="form-control-static">
                        <?php echo date("Y-m-d H:i", $this->tplData["articleRow"]["article_time"]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang["label"]["articleMark"]; ?></label>
                    <div class="form-control-static">
                        <?php if (isset($this->tplData["markRow"]["mark_name"])) {
                            echo $this->tplData["markRow"]["mark_name"];
                        } else {
                            echo $this->lang["label"]["none"];
                        } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <form name="attach_list" id="attach_list">
                <input type="hidden" name="<?php echo $this->common["tokenRow"]["name_session"]; ?>" value="<?php echo $this->common["tokenRow"]["token"]; ?>">
                <input type="hidden" name="article_id" value="<?php echo $this->tplData["articleRow"]["article_id"]; ?>">
                <div class="panel panel-default">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-nowrap bg-td-xs">

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
                                        <td class="text-nowrap bg-td-xs">
                                            <input type="radio" name="attach_id" value="<?php echo $value["attach_id"]; ?>" <?php if ($value["attach_id"] == $this->tplData["articleRow"]["article_attach_id"]) { ?>checked<?php } ?> id="attach_id_<?php echo $value["attach_id"]; ?>" data-validate="attach_id">
                                        </td>
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
                                        <input type="hidden" name="act" value="primary">
                                        <button type="button" class="btn btn-primary btn-sm bg-submit"><?php echo $this->lang["btn"]["setPrimary"]; ?></button>
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
            validate: { selector: "input[name='attach_id']", type: "radio" },
            msg: { selector: "#msg_attach_id", too_few: "<?php echo $this->rcode["x120214"]; ?>" }
        }
    };

    var opts_submit_list = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=article",
        msg_text: {
            submitting: "<?php echo $this->lang["label"]["submitting"]; ?>"
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
    });
    </script>

<?php include($cfg["pathInclude"] . "html_foot.php"); ?>