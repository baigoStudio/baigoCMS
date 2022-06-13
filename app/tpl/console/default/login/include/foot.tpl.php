        </div>
      </div>

      <div class="text-center">
        <div class="my-3">
          <?php if (isset($cfg['active']) && $cfg['active'] == 'login') { ?>
            <a href="<?php echo $urls['url_forgot']; ?>" target="_blank"><?php echo $lang->get('Forgot password'); ?></a>
          <?php } else { ?>
            <a href="<?php echo $hrefRow['login']; ?>"><?php echo $lang->get('Login now'); ?></a>
          <?php } ?>
        </div>

        <?php if (isset($config['var_extra']['base']['site_name'])) { ?>
          <hr>
          <div>
            <?php echo $config['var_extra']['base']['site_name']; ?>
          </div>
        <?php } ?>
      </div>

      <?php if (!isset($ui_ctrl['copyright']) || $ui_ctrl['copyright'] === 'on') { ?>
        <div class="mt-5 text-center">
          <hr>
          <div>
            <span class="d-none d-lg-inline-block">Powered by</span>
            <a href="<?php echo PRD_CMS_URL; ?>" target="_blank"><?php echo PRD_CMS_NAME; ?></a>
            <?php echo PRD_CMS_VER; ?>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>

<?php include($tpl_include . 'script_foot' . GK_EXT_TPL);
