<?php
function custom_list_option($arr_customRows, $check_id, $disabled_id) {
  if (!empty($arr_customRows)) {
    foreach ($arr_customRows as $_key=>$_value) { ?>
      <option <?php if ($check_id == $_value['custom_id']) { ?>selected<?php } ?> <?php if ($disabled_id == $_value['custom_id']) { ?>disabled<?php } ?> value="<?php echo $_value['custom_id']; ?>">
        <?php if ($_value['custom_level'] > 1) {
          for ($_iii = 1; $_iii < $_value['custom_level']; ++$_iii) { ?>
            &nbsp;&nbsp;
          <?php }
        }
        echo $_value['custom_name']; ?>
      </option>

      <?php if (isset($_value['custom_childs'])) {
        custom_list_option($_value['custom_childs'], $check_id, $disabled_id);
      }
    }
  }
}

if (isset($customRows)) {
  $_arr_customRows = $customRows;
} else if (!isset($_arr_customRows)) {
  $_arr_customRows = array();
}

if (!isset($check_id)) {
  $check_id = -1;
}

if (!isset($disabled_id)) {
  $disabled_id = 0;
}

if ($customRow['custom_id'] > 0) {
  $title_sub    = $lang->get('Edit');
} else {
  $title_sub    = $lang->get('Add');
}

$cfg = array(
  'title'             => $lang->get('Custom fields', 'console.common') . ' &raquo; ' . $lang->get('Show'),
  'menu_active'       => 'article',
  'sub_active'        => 'custom',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <nav class="nav mb-3">
    <a href="<?php echo $hrefRow['index']; ?>" class="nav-link">
      <span class="bg-icon"><?php include($tpl_icon . 'chevron-left' . BG_EXT_SVG); ?></span>
      <?php echo $lang->get('Back'); ?>
    </a>
  </nav>

  <div class="row">
    <div class="col-xl-9">
      <div class="card mb-3">
        <div class="card-body">
          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Name'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $customRow['custom_name']; ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Size'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $customRow['custom_size']; ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Parent field'); ?></label>
            <div class="form-text font-weight-bolder">
              <?php if (isset($customParent['custom_name'])) {
                echo $customParent['custom_name'];
              } else {
                echo $lang->get('As a primary field');
              } ?>
            </div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Type'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $lang->get($customRow['custom_type']); ?></div>
          </div>

          <?php if (isset($customRow['custom_opt'][$customRow['custom_type']])) { ?>
            <div class="form-group">
              <?php foreach ($customRow['custom_opt'][$customRow['custom_type']] as $key_opt=>$value_opt) { ?>
                <div class="input-group mb-3">
                  <span class="input-group-prepend">
                    <span class="input-group-text"><?php echo $lang->get('Option'); ?></span>
                  </span>
                  <input type="text" value="<?php echo $value_opt; ?>" class="form-control bg-transparent" readonly>
                </div>
              <?php } ?>
            </div>
          <?php } ?>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Format'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $lang->get($customRow['custom_format']); ?></div>
          </div>
        </div>

        <div class="card-footer text-right">
          <a href="<?php echo $hrefRow['edit'], $customRow['custom_id']; ?>">
            <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
            <?php echo $lang->get('Edit'); ?>
          </a>
        </div>
      </div>
    </div>
    <div class="col-xl-3">
      <div class="card bg-light">
        <div class="card-body">
          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('ID'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $customRow['custom_id']; ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Status'); ?></label>
            <div class="form-text font-weight-bolder">
              <?php $str_status = $customRow['custom_status'];
              include($tpl_include . 'status_process' . GK_EXT_TPL); ?>
            </div>
          </div>

          <?php if ($customRow['custom_parent_id'] < 1) { ?>
            <div class="form-group">
              <label class="text-muted font-weight-light"><?php echo $lang->get('Belong to category'); ?></label>
              <div class="form-text font-weight-bolder">
                <?php if (isset($cateRow['cate_name'])) {
                  echo $cateRow['cate_name'];
                } else {
                  echo $lang->get('All categories');
                } ?>
              </div>
            </div>
          <?php } ?>
        </div>
        <div class="card-footer text-right">
          <a href="<?php echo $hrefRow['edit'], $customRow['custom_id']; ?>">
            <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
            <?php echo $lang->get('Edit'); ?>
          </a>
        </div>
      </div>
    </div>
  </div>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL);
include($tpl_include . 'html_foot' . GK_EXT_TPL);
