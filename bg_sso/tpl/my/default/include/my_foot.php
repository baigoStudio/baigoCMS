            </div>

            <div class="panel-footer">
                <div class="text-right">
                    <?php echo PRD_SSO_POWERED; ?>
                    <?php if (BG_DEFAULT_UI == "default") { ?>
                        <a href="<?php echo PRD_SSO_URL; ?>" target="_blank"><?php echo PRD_SSO_NAME; ?></a>
                    <?php } else {
                        echo BG_DEFAULT_UI; ?> SSO
                    <?php } ?>
                    <?php echo PRD_SSO_VER; ?>
                </div>
            </div>
        </div>

    </div>

    <script src="<?php echo BG_URL_STATIC; ?>lib/baigoSubmit/baigoSubmit.min.js" type="text/javascript"></script>
    <script src="<?php echo BG_URL_STATIC; ?>lib/baigoValidator/baigoValidator.min.js" type="text/javascript"></script>
    <script src="<?php echo BG_URL_STATIC; ?>lib/reloadImg.js" type="text/javascript"></script>
    <script src="<?php echo BG_URL_STATIC; ?>lib/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

    <!--
    <?php echo PRD_SSO_POWERED; ?>
    <?php if (BG_DEFAULT_UI == "default") {
        echo PRD_SSO_NAME;
    } else {
        echo BG_DEFAULT_UI . " SSO";
    } ?>
    <?php echo PRD_SSO_VER; ?>
    -->
