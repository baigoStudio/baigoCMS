                </div>
            </div>
        </div>
    </div>

    <footer class="container-fluid text-light p-3 clearfix bg-secondary mt-3">
        <div class="float-left">
            <img class="img-fluid bg-foot-logo" src="<?php echo $ui_ctrl['logo_console_foot']; ?>">
        </div>
        <?php if (!isset($ui_ctrl['copyright']) || $ui_ctrl['copyright'] === 'on') { ?>
            <div class="float-right">
                <span class="d-none d-lg-inline-block">Powered by</span>
                <a href="<?php echo PRD_CMS_URL; ?>" class="text-light" target="_blank"><?php echo PRD_CMS_NAME; ?></a>
                <?php echo PRD_CMS_VER; ?>
            </div>
        <?php } ?>
    </footer>

    <?php if ($gen_open === true) { ?>
        <div class="modal fade" id="gen_modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title">
                            <span id="gen_modal_icon" class="spinner-grow spinner-grow-sm text-info"></span>
                            <span id="gen_modal_msg" class="text-info"><?php echo $lang->get('Generating', 'console.common'); ?></span>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <div class="embed-responsive embed-responsive-1by1">
                            <iframe class="embed-responsive-item"></iframe>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
                            <?php echo $lang->get('Close'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
        $(document).ready(function(){
        	$('#gen_modal').on('shown.bs.modal', function(event){
        		var _obj_button   = $(event.relatedTarget);
        		var _url          = _obj_button.data('url');
        		$('#gen_modal iframe').attr('src', _url);
        	}).on('hidden.bs.modal', function(){
            	$('#gen_modal #gen_modal_icon').attr('class', 'spinner-grow spinner-grow-sm text-info');
            	$('#gen_modal #gen_modal_msg').attr('class', 'text-info');
            	$('#gen_modal #gen_modal_msg').text('<?php echo $lang->get('Generating', 'console.common'); ?>');
            	$('#gen_modal iframe').attr('src', '');
        	});
    	});
        </script>
    <?php } ?>