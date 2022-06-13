<?php
if (!function_exists('cate_list_allow')) {
  function cate_list_allow($arr_cateRows, $cate_allow, $lang = '', $tpl_icon = '', $admin_allow_cate = array(), $group_allow_article = array(), $admin_type = '', $is_edit = true) {
    if (!empty($arr_cateRows)) {
      foreach ($arr_cateRows as $_key=>$_value) { ?>
        <tr>
          <td class="bg-child-<?php echo $_value['cate_level']; ?>">
            <div><strong><?php echo $_value['cate_name']; ?></strong></div>
            <div>
              <?php if ($is_edit) { ?>
                <div class="form-check form-check-inline">
                  <input type="checkbox" id="cate_<?php echo $_value['cate_id']; ?>" data-parent="chk_all" class="form-check-input">
                  <label for="cate_<?php echo $_value['cate_id']; ?>" class="form-check-label">
                    <?php echo $lang->get('All'); ?>
                  </label>
                </div>
              <?php }

              foreach ($cate_allow as $_key_s=>$_value_s) {
                if ($is_edit) { ?>
                  <div class="form-check form-check-inline">
                    <input type="checkbox" name="admin_allow_cate[<?php echo $_value['cate_id']; ?>][<?php echo $_key_s; ?>]" value="1" id="cate_<?php echo $_value['cate_id']; ?>_<?php echo $_key_s; ?>" data-parent="cate_<?php echo $_value['cate_id']; ?>" data-validate="admin_allow_cate"<?php if (isset($admin_allow_cate[$_value['cate_id']][$_key_s]) || isset($group_allow_article[$_key_s])) { ?> checked<?php } ?> class="form-check-input">
                    <label for="cate_<?php echo $_value['cate_id']; ?>_<?php echo $_key_s; ?>" class="form-check-label">
                      <?php echo $lang->get($_value_s, 'console.common'); ?>
                    </label>
                  </div>
                <?php } else {
                  if (isset($admin_allow_cate[$_value['cate_id']][$_key_s]) || isset($group_allow_article[$_key_s]) || $admin_type == 'super') {
                    $str_icon  = 'check-circle';
                    $str_color = 'success';
                  } else {
                    $str_icon  = 'times-circle';
                    $str_color = 'danger';
                  } ?>
                  <span>
                    <span class="text-<?php echo $str_color; ?>">
                      <span class="bg-icon"><?php include($tpl_icon . $str_icon . BG_EXT_SVG); ?></span>
                    </span>
                    <?php echo $lang->get($_value_s, 'console.common'); ?>
                  </span>
                <?php }
              } ?>
            </div>
          </td>
        </tr>

        <?php if (isset($_value['cate_childs'])) {
          cate_list_allow($_value['cate_childs'], $cate_allow, $lang, $tpl_icon, $admin_allow_cate, $group_allow_article, $admin_type, $is_edit);
        }
      }
    }
  }
}

if (isset($cateRows)) {
  $_arr_cateRows = $cateRows;
} else if (!isset($_arr_cateRows)) {
  $_arr_cateRows = array();
}

if (isset($adminRow)) {
  $_arr_adminRow = $adminRow;
} else if (!isset($_arr_adminRow)) {
  $_arr_adminRow = array(
    'admin_allow_cate'  => array(),
    'admin_type'        => '',
  );
}

if (isset($groupRow['group_allow']['article'])) {
  $_arr_groupAllowArticle = $groupRow['group_allow']['article'];
} else if (!isset($_arr_groupAllowArticle)) {
  $_arr_groupAllowArticle = array();
}

if (isset($config['console']['console_mod']['cate']['allow'])) {
  $cate_allow = $config['console']['console_mod']['cate']['allow'];
} else if (!isset($cate_allow)) {
  $cate_allow = array();
}

if (!isset($_is_edit)) {
  $_is_edit = true;
}

cate_list_allow($_arr_cateRows, $cate_allow, $lang, $tpl_icon, $_arr_adminRow['admin_allow_cate'], $_arr_groupAllowArticle, $_arr_adminRow['admin_type'], $_is_edit);
