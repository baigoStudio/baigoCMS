<?php use ginkgo\Plugin; ?>
              </div>
          </div>
      </div>
  </div>

  <?php Plugin::listen('action_console_foot_before'); //后台界面底部触发 ?>

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

  <?php Plugin::listen('action_console_foot_after'); //后台界面底部触发

  if ($gen_open === true) { ?>
    <div class="modal fade" id="gen_modal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title">
              <span id="gen_modal_icon" class="bg-icon text-info">
                <span class="spinner-grow spinner-grow-sm"></span>
              </span>
              <span id="gen_modal_msg" class="text-info"><?php echo $lang->get('Generating', 'console.common'); ?></span>
            </div>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="embed-responsive embed-responsive-1by1">
            <iframe class="embed-responsive-item"></iframe>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
              <?php echo $lang->get('Close', 'console.common'); ?>
            </button>
          </div>
        </div>
      </div>
    </div>
  <?php }

  if (isset($adminLogged['rcode']) && $adminLogged['rcode'] == 'y020102' && !isset($cfg['no_token'])) { ?>
    <div class="modal fade" id="msg_token">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
              <?php echo $lang->get('OK', 'console.common'); ?>
            </button>
          </div>
        </div>
      </div>
    </div>
  <?php }

include($tpl_include . 'script_foot' . GK_EXT_TPL);
