            </div>
        </div>
    </div>

    <footer class="container-fluid bg-footer bg-info clearfix">
        <div class="pull-left">
            <img class="img-responsive" src="<?php echo BG_URL_STATIC; ?>console/<?php echo BG_DEFAULT_UI; ?>/image/logo.png">
        </div>
        <div class="pull-right">
            <?php echo PRD_CMS_POWERED, ' ';
            if (BG_DEFAULT_UI == 'default') { ?>
                <a href="<?php echo PRD_CMS_URL; ?>" target="_blank"><?php echo PRD_CMS_NAME; ?></a>
            <?php } else {
                echo BG_DEFAULT_UI, ' CMS ';
            }
            echo PRD_CMS_VER; ?>
        </div>
    </footer>

    <?php if (defined('BG_MODULE_GEN') && BG_MODULE_GEN > 0 && defined('BG_VISIT_TYPE') && BG_VISIT_TYPE == 'static') { ?>
        <div class="modal fade" id="gen_modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <div id="gen_msg_box">
                            <span id="gen_msg_icon" class="glyphicon glyphicon-refresh bg-spin"></span>
                            <span id="gen_msg_text">
                                <?php echo $this->lang['common']['page']['gening']; ?>
                            </span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="embed-responsive embed-responsive-4by3">
                            <iframe class="embed-responsive-item"></iframe>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <?php echo $this->lang['common']['btn']['close']; ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
        $(document).ready(function(){
        	$("#gen_modal").on("shown.bs.modal", function(event){
        		var _obj_button   = $(event.relatedTarget);
        		var _url          = _obj_button.data("url");
        		$("#gen_modal iframe").attr("src", _url);
        	}).on("hidden.bs.modal", function(){
            	$("#gen_modal iframe").attr("src", '');
            	$("#gen_msg_box").attr("class", '');
            	$("#gen_msg_icon").attr("class", "glyphicon glyphicon-refresh bg-spin");
            	$("#gen_msg_text").text("<?php echo $this->lang['common']['page']['gening']; ?>");
        	});
    	});
        </script>
    <?php } ?>