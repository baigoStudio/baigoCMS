            </div>
        </div>
    </div>

    <footer class="container-fluid bg-footer bg-info clearfix">
        <div class="pull-left">
            <img class="img-responsive" src="<?php echo BG_URL_STATIC; ?>console/<?php echo BG_DEFAULT_UI; ?>/image/logo.png">
        </div>
        <div class="pull-right">
            <?php echo PRD_CMS_POWERED; ?>
            <?php if (BG_DEFAULT_UI == "default") { ?>
                <a href="<?php echo PRD_CMS_URL; ?>" target="_blank"><?php echo PRD_CMS_NAME; ?></a>
            <?php } else {
                echo BG_DEFAULT_UI . " CMS";
            } ?>
            <?php echo PRD_CMS_VER; ?>
        </div>
    </footer>

    <?php if (BG_MODULE_GEN > 0 && BG_VISIT_TYPE == "static") { ?>
        <div class="modal fade" id="gen_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <span class="glyphicon glyphicon-refresh bg-spin"></span>
                        <?php echo $this->lang["page"]["gening"]; ?>
                    </div>
                    <div class="modal-body">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" name="iframe_gen"></iframe>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <?php echo $this->lang["btn"]["close"]; ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
    	$("#gen_modal").on("shown.bs.modal", function(event){
    		var _obj_button   = $(event.relatedTarget);
    		var _url          = _obj_button.data("url");
    		$("#gen_modal iframe").attr("src", _url);
    	})
        </script>
    <?php } ?>