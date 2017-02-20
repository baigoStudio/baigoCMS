<?php $cfg = array(
    "title"          => $this->consoleMod["group"]["main"]["title"] . " &raquo; " . $this->lang["page"]["show"],
    "menu_active"    => "group",
    "sub_active"     => "list",
    "pathInclude"    => BG_PATH_TPLSYS . "console/default/include/",
);

include($cfg["pathInclude"] . "function.php");
include($cfg["pathInclude"] . "console_head.php"); ?>

    <div class="form-group">
        <ul class="nav nav-pills bg-nav-pills">
            <li>
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=group&act=list">
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
                        <label class="control-label"><?php echo $this->lang["label"]["groupName"]; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData["groupRow"]["group_name"]; ?></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang["label"]["groupAllow"]; ?></label>
                        <?php allow_list($this->consoleMod, $this->opt, $this->lang, $this->tplData["groupRow"]["group_allow"], false); ?>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang["label"]["groupNote"]; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData["groupRow"]["group_note"]; ?></div>
                    </div>

                    <div class="form-group">
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=group&act=form&group_id=<?php echo $this->tplData["groupRow"]["group_id"]; ?>">
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
                    <div class="form-control-static"><?php echo $this->tplData["groupRow"]["group_id"]; ?></div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang["label"]["status"]; ?></label>
                    <div class="form-control-static">
                        <?php group_status_process($this->tplData["groupRow"]["group_status"], $this->status["group"]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang["label"]["groupType"]; ?></label>
                    <div class="form-control-static"><?php echo $this->type["group"][$this->tplData["groupRow"]["group_type"]]; ?></div>
                </div>

                <div class="form-group">
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=group&act=form&group_id=<?php echo $this->tplData["groupRow"]["group_id"]; ?>">
                        <span class="glyphicon glyphicon-edit"></span>
                        <?php echo $this->lang["href"]["edit"]; ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php include($cfg["pathInclude"] . "console_foot.php");
include($cfg["pathInclude"] . "html_foot.php"); ?>