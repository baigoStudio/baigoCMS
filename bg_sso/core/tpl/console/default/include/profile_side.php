    <div class="col-md-3">
        <div class="well">
            <div class="form-group">
                <label class="control-label"><?php echo $this->lang["label"]["id"]; ?></label>
                <div class="form-control-static"><?php echo $this->tplData["adminLogged"]["admin_id"]; ?></div>
            </div>

            <?php if ($this->tplData["adminLogged"]["admin_status"] == "enable") {
                $css_status = "success";
            } else {
                $css_status = "default";
            } ?>

            <div class="form-group">
                <label class="control-label"><?php echo $this->lang["label"]["status"]; ?></label>
                <div class="form-control-static">
                    <span class="label label-<?php echo $css_status; ?> bg-label"><?php echo $this->status["admin"][$this->tplData["adminLogged"]["admin_status"]]; ?></span>
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
        </div>
    </div>