                </div>

                <div class="panel-footer clearfix">
                    <div class="pull-left">
                        <?php echo PRD_CMS_POWERED; ?>
                        <?php if (BG_DEFAULT_UI == "default") { ?>
                            <a href="<?php echo PRD_CMS_URL; ?>" target="_blank"><?php echo PRD_CMS_NAME; ?></a>
                        <?php } else {
                            echo BG_DEFAULT_UI; ?> CMS
                        <?php } ?>
                        <?php echo PRD_CMS_VER; ?>
                    </div>
                    <div class="pull-right">
                        <a href="<?php echo BG_URL_HELP; ?>index.php?mod=<?php echo $cfg["mod_help"]; ?>&act=<?php echo $cfg["act_help"]; ?>" target="_blank">
                            <span class="glyphicon glyphicon-question-sign"></span>
                            <?php echo $this->lang["href"]["help"]; ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
