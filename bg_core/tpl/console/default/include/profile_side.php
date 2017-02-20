    <div class="col-md-3">
        <div class="well">
            <div class="form-group">
                <label class="control-label"><?php echo $this->lang["label"]["id"]; ?></label>
                <div class="form-control-static"><?php echo $this->tplData["adminLogged"]["admin_id"]; ?></div>
            </div>

            <div class="form-group">
                <label class="control-label"><?php echo $this->lang["label"]["status"]; ?></label>
                <div class="form-control-static">
                    <?php admin_status_process($this->tplData["adminLogged"]["admin_status"], $this->status["admin"]); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label"><?php echo $this->lang["label"]["type"]; ?></label>
                <div class="form-control-static">
                    <?php echo $this->type["admin"][$this->tplData["adminLogged"]["admin_type"]]; ?>
                </div>
            </div>

            <div class="form-group">
                <?php foreach ($this->type["profile"] as $_key=>$_value) {
                    if (isset($this->tplData["adminLogged"]["admin_allow_profile"][$_key]) && $this->tplData["adminLogged"]["admin_allow_profile"][$_key] == 1) { ?>
                        <div>
                            <span class="label label-danger bg-label"><?php echo $this->lang["label"]["forbidModi"] . $_value["title"]; ?></span>
                        </div>
                    <?php }
                } ?>
            </div>

            <div class="form-group">
                <label class="control-label"><?php echo $this->lang["label"]["adminGroup"]; ?></label>
                <div class="form-control-static">
                    <?php if (isset($this->tplData["adminLogged"]["groupRow"]["group_name"])) {
                        echo $this->tplData["adminLogged"]["groupRow"]["group_name"]; ?>
                        |
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=group&act=show&group_id=<?php echo $this->tplData["adminLogged"]["admin_group_id"]; ?>"><?php echo $this->lang["href"]["show"]; ?></a>
                    <?php } else {
                        echo $this->lang["label"]["none"];
                    } ?>
                </div>
            </div>
        </div>
    </div>