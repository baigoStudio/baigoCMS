<?php function custom_list_show($arr_customRows, $article_customs = array()) {
    if (!fn_isEmpty($arr_customRows)) {
        foreach ($arr_customRows as $key=>$value) {
            if (isset($value["custom_childs"]) && fn_isEmpty($value["custom_childs"])) { ?>
                <div class="form-group">
                    <label class="control-label"><?php echo $value["custom_name"] ; ?></label>
                    <div class="form-control-static">
                        <?php if (isset($article_customs["custom_" . $value["custom_id"]])) {
                            echo $article_customs["custom_" . $value["custom_id"]];
                        } ?>
                    </div>
                </div>
            <?php } else { ?>
                <label class="control-label"><?php echo $value["custom_name"] ; ?></label>
            <?php }

            if (isset($value["custom_childs"]) && !fn_isEmpty($value["custom_childs"])) {
                custom_list_show($value["custom_childs"], $article_customs);
            }
        }
    }
}

$cfg = array(
    "title"          => $this->consoleMod["article"]["main"]["title"] . " &raquo; " . $this->lang["page"]["show"],
    "menu_active"    => "article",
    "sub_active"     => "list",
    "tooltip"        => "true",
    "pathInclude"    => BG_PATH_TPLSYS . "console/default/include/",
);

include($cfg["pathInclude"] . "function.php");
include($cfg["pathInclude"] . "console_head.php"); ?>

    <div class="form-group">
        <ul class="nav nav-pills bg-nav-pills">
            <li>
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=article&act=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <?php echo $this->lang["href"]["back"]; ?>
                </a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang["label"]["articleTitle"]; ?></label>
                        <div class="form-control-static">
                            <?php echo $this->tplData["articleRow"]["article_title"]; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang["label"]["articleContent"]; ?></label>
                        <p class="bg-content">
                            <?php echo $this->tplData["articleRow"]["article_content"]; ?>
                        </p>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang["label"]["articleExcerpt"]; ?></label>
                        <p class="bg-content">
                            <?php echo $this->tplData["articleRow"]["article_excerpt"]; ?>
                        </p>
                    </div>

                    <?php if (isset($this->tplData["articleRow"]["article_customs"])) {
                        custom_list_show($this->tplData["customRows"], $this->tplData["articleRow"]["article_customs"]);
                    } ?>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang["label"]["articleTag"]; ?></label>
                        <ul class="list-inline">
                            <?php foreach ($this->tplData["tagRows"] as $key=>$value) { ?>
                                <li><?php echo $value["tag_name"]; ?></li>
                            <?php } ?>
                        </ul>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang["label"]["articleLink"]; ?></label>
                        <div class="form-control-static">
                            <?php echo $this->tplData["articleRow"]["article_link"]; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang["label"]["hits"]; ?></label>
                        <ul class="list-inline">
                            <li>
                                <?php echo $this->lang["label"]["hitsDay"]; ?>
                                <?php echo $this->tplData["articleRow"]["article_hits_day"]; ?>
                            </li>
                            <li>
                                <?php echo $this->lang["label"]["hitsWeek"]; ?>
                                <?php echo $this->tplData["articleRow"]["article_hits_week"]; ?>
                            </li>
                            <li>
                                <?php echo $this->lang["label"]["hitsMonth"]; ?>
                                <?php echo $this->tplData["articleRow"]["article_hits_month"]; ?>
                            </li>
                            <li>
                                <?php echo $this->lang["label"]["hitsYear"]; ?>
                                <?php echo $this->tplData["articleRow"]["article_hits_year"]; ?>
                            </li>
                            <li>
                                <?php echo $this->lang["label"]["hitsAll"]; ?>
                                <?php echo $this->tplData["articleRow"]["article_hits_all"]; ?>
                            </li>
                        </ul>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang["label"]["articleUrl"]; ?></label>
                        <div class="form-control-static">
                            <a href="<?php echo $this->tplData["articleRow"]["urlRow"]["article_url"]; ?>" target="_blank"><?php echo $this->tplData["articleRow"]["urlRow"]["article_url"]; ?></a>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang["label"]["articlePath"]; ?></label>
                        <div class="form-control-static">
                            <?php echo $this->tplData["articleRow"]["urlRow"]["article_pathFull"]; ?>
                        </div>
                    </div>

                    <?php if (BG_MODULE_GEN > 0 && BG_VISIT_TYPE == "static") {
                        if ($this->tplData["articleRow"]["article_is_gen"] == "yes") {
                            $css_gen = "default";
                        } else {
                            $css_gen = "danger";
                        } ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang["label"]["staticFile"]; ?></label>
                            <div class="form-control-static">
                                <span class="label label-<?php echo $css_gen; ?> bg-label"><?php echo $this->status["gen"][$this->tplData["articleRow"]["article_is_gen"]]; ?></span>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=article&act=form&article_id=<?php echo $this->tplData["articleRow"]["article_id"]; ?>">
                            <span class="glyphicon glyphicon-edit"></span>
                            <?php echo $this->lang["href"]["edit"]; ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="well">
                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang["label"]["id"]; ?></label>
                    <div class="form-control-static"><?php echo $this->tplData["articleRow"]["article_id"]; ?></div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang["label"]["belongCate"]; ?></label>
                    <div class="form-control-static"><?php echo $this->tplData["cateRow"]["cate_name"]; ?></div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang["label"]["articleBelong"]; ?></label>
                    <table class="bg-table-empty">
                        <tbody>
                            <?php cate_list_checkbox($this->tplData["cateRows"], $this->tplData["articleRow"]["cate_ids"], "", false); ?>
                        </tbody>
                    </table>
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

                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang["label"]["articleSpec"]; ?></label>
                    <ul class="list-inline">
                        <?php foreach ($this->tplData["specRows"] as $key=>$value) { ?>
                            <li><?php echo $value["spec_name"]; ?></li>
                        <?php } ?>
                    </ul>
                </div>

                <div class="form-group">
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=article&act=form&article_id=<?php echo $this->tplData["articleRow"]["article_id"]; ?>">
                        <span class="glyphicon glyphicon-edit"></span>
                        <?php echo $this->lang["href"]["edit"]; ?>
                    </a>
                </div>
            </div>
        </div>
    </div>


<?php include($cfg["pathInclude"] . "console_foot.php");
include($cfg["pathInclude"] . "html_foot.php"); ?>