            </div>
          </div>
        </div>
      </div>

      <?php if (!isset($ui_ctrl['copyright']) || $ui_ctrl['copyright'] === 'on') { ?>
        <div class="mt-3 text-right">
          <span class="d-none d-lg-inline-block">Powered by</span>
          <a href="<?php echo PRD_CMS_URL; ?>" target="_blank"><?php echo PRD_CMS_NAME; ?></a>
          <?php echo PRD_CMS_VER; ?>
        </div>
      <?php } ?>
    </div>
  </div>

<?php include($tpl_include . 'script_foot' . GK_EXT_TPL);
