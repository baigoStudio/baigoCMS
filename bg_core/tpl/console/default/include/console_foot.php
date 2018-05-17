            </div>
        </div>
    </div>

    <footer class="container-fluid bg-secondary text-light p-3 clearfix mt-3">
        <div class="float-left">
            <img class="img-fluid" src="<?php echo BG_URL_STATIC; ?>console/<?php echo BG_DEFAULT_UI; ?>/image/logo.png">
        </div>
        <div class="float-right">
            <?php echo PRD_CMS_POWERED, ' ';
            if (BG_DEFAULT_UI == 'default') { ?>
                <a href="<?php echo PRD_CMS_URL; ?>" class="text-light" target="_blank"><?php echo PRD_CMS_NAME; ?></a>
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
                        <div class="modal-title" id="gen_msg_box">
                            <span id="gen_msg_icon" class="oi oi-loop-circular bg-spin"></span>
                            <span id="gen_msg_text">
                                <?php echo $this->lang['common']['page']['gening']; ?>
                            </span>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <div class="embed-responsive embed-responsive-1by1">
                            <iframe class="embed-responsive-item"></iframe>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
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
            	$("#gen_modal iframe").attr("src", "");
            	$("#gen_msg_box").attr("class", "");
            	$("#gen_msg_icon").attr("class", "oi oi-loop-circular bg-spin");
            	$("#gen_msg_text").text("<?php echo $this->lang['common']['page']['gening']; ?>");
        	});
    	});
        </script>
    <?php } ?>