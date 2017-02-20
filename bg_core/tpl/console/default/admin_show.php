<?php $cfg = array(
    "title"          => $this->consoleMod["admin"]["main"]["title"] .  " &raquo; " . $this->lang["page"]["show"],
    "menu_active"    => "admin",
    "sub_active"     => "list",
    "pathInclude"    => BG_PATH_TPLSYS . "console/default/include/",
);

include($cfg["pathInclude"] . "function.php");
include($cfg["pathInclude"] . "console_head.php"); ?>

    <div class="form-group">
        <ul class="nav nav-pills bg-nav-pills">
            <li>
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=admin&act=list">
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
                        <label class="control-label"><?php echo $this->lang["label"]["username"]; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData["adminRow"]["ssoRow"]["user_name"]; ?></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang["label"]["mail"]; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData["adminRow"]["ssoRow"]["user_mail"]; ?></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang["label"]["nick"]; ?></label>
                        <div class="form-control-static">
                            <?php if (!fn_isEmpty($this->tplData["adminRow"]["admin_nick"])) {
                                echo $this->tplData["adminRow"]["admin_nick"];
                            } else {
                                echo $this->tplData["adminRow"]["ssoRow"]["user_nick"];
                            } ?>
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <?php echo $this->lang["label"]["cateAllow"]; ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php cate_list_allow($this->tplData["cateRows"], $this->lang, $this->tplData["adminRow"]["admin_allow_cate"], $this->tplData["adminLogged"]["groupRow"]["group_allow"]["article"], $this->tplData["adminRow"]["admin_type"], false); ?>
                        </tbody>
                    </table>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang["label"]["note"]; ?><span id="msg_admin_note"></span></label>
                        <div class="form-control-static"><?php echo $this->tplData["adminRow"]["admin_note"]; ?></div>
                    </div>

                    <div class="form-group">
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=admin&act=form&admin_id=<?php echo $this->tplData["adminRow"]["admin_id"]; ?>">
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
                    <div class="form-control-static"><?php echo $this->tplData["adminRow"]["admin_id"]; ?></div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang["label"]["type"]; ?></label>
                    <div class="form-control-static"><?php echo $this->type["admin"][$this->tplData["adminRow"]["admin_type"]]; ?></div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang["label"]["status"]; ?></label>
                    <div class="form-control-static">
                        <?php admin_status_process($this->tplData["adminRow"]["admin_status"], $this->status["admin"]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php foreach ($this->type["profile"] as $_key=>$_value) {
                        if (isset($this->tplData["adminRow"]["admin_allow_profile"][$_key]) && $this->tplData["adminRow"]["admin_allow_profile"][$_key] == 1) { ?>
                            <div>
                                <span class="label label-danger bg-label"><?php echo $this->lang["label"]["forbidModi"] . $_value["title"]; ?></span>
                            </div>
                        <?php }
                    } ?>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang["label"]["adminGroup"]; ?></label>
                    <div class="form-control-static">
                        <?php if (isset($this->tplData["groupRow"]["group_name"]) && !fn_isEmpty($this->tplData["groupRow"]["group_name"])) {
                            echo $this->tplData["groupRow"]["group_name"]; ?> | <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=group&act=show&group_id=<?php echo $this->tplData["adminRow"]["admin_group_id"]; ?>"><?php echo $this->lang["href"]["show"]; ?></a>
                        <?php } else {
                            echo $this->lang["label"]["none"];
                        } ?>
                    </div>
                </div>

                <div class="form-group">
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=admin&act=form&admin_id=<?php echo $this->tplData["adminRow"]["admin_id"]; ?>">
                        <span class="glyphicon glyphicon-edit"></span>
                        <?php echo $this->lang["href"]["edit"]; ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php include($cfg["pathInclude"] . "console_foot.php");
include($cfg["pathInclude"] . "html_foot.php"); ?>