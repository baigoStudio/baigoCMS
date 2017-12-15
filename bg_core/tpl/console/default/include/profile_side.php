    <div class="col-md-3">
        <div class="well">
            <div class="form-group">
                <label class="control-label"><?php echo $this->lang['mod']['label']['id']; ?></label>
                <div class="form-control-static"><?php echo $this->tplData['adminLogged']['admin_id']; ?></div>
            </div>

            <div class="form-group">
                <label class="control-label"><?php echo $this->lang['mod']['label']['status']; ?></label>
                <div class="form-control-static">
                    <?php admin_status_process($this->tplData['adminLogged']['admin_status'], $this->lang['mod']['status']); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label"><?php echo $this->lang['mod']['label']['type']; ?></label>
                <div class="form-control-static">
                    <?php if (isset($this->lang['mod']['type'][$this->tplData['adminLogged']['admin_type']])) {
                        echo $this->lang['mod']['type'][$this->tplData['adminLogged']['admin_type']];
                    } ?>
                </div>
            </div>

            <div class="form-group">
                <?php foreach ($this->profile as $_key=>$_value) {
                    if (isset($this->tplData['adminLogged']['admin_allow_profile'][$_key]) && $this->tplData['adminLogged']['admin_allow_profile'][$_key] == 1) { ?>
                        <div>
                            <span class="label label-danger bg-label">
                                <?php echo $this->lang['mod']['label']['forbidModi'];
                                if (isset($this->lang['common']['profile'][$_key]['title'])) {
                                    echo $this->lang['common']['profile'][$_key]['title'];
                                } else {
                                    echo $_value['title'];
                                } ?>
                            </span>
                        </div>
                    <?php }
                } ?>
            </div>

            <div class="form-group">
                <label class="control-label"><?php echo $this->lang['mod']['label']['adminGroup']; ?></label>
                <div class="form-control-static">
                    <?php if (isset($this->tplData['adminLogged']['groupRow']['group_name'])) { ?>
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=group&act=show&group_id=<?php echo $this->tplData['adminLogged']['admin_group_id']; ?>">
                            <?php echo $this->tplData['adminLogged']['groupRow']['group_name']; ?>
                        </a>
                    <?php } else {
                        echo $this->lang['mod']['label']['none'];
                    } ?>
                </div>
            </div>
        </div>
    </div>