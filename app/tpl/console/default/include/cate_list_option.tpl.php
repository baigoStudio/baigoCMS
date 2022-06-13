<?php
if (!function_exists('cate_list_option')) {
  function cate_list_option($arr_cateRows, $check_id = -1, $disabled_id = -1) {
    if (!empty($arr_cateRows)) {
      foreach ($arr_cateRows as $_key=>$_value) { ?>
        <option <?php if ($check_id == $_value['cate_id']) { ?>selected<?php } ?> <?php if ($disabled_id == $_value['cate_id']) { ?>disabled<?php } ?> value="<?php echo $_value['cate_id']; ?>">
          <?php if ($_value['cate_level'] > 1) {
            for ($_iii = 1; $_iii < $_value['cate_level']; ++$_iii) { ?>
              &nbsp;&nbsp;
            <?php }
          }
          echo $_value['cate_name']; ?>
        </option>

        <?php if (isset($_value['cate_childs'])) {
          cate_list_option($_value['cate_childs'], $check_id, $disabled_id);
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

if (!isset($check_id)) {
  $check_id = -1;
}

if (!isset($disabled_id)) {
  $disabled_id = -1;
}

cate_list_option($_arr_cateRows, $check_id, $disabled_id);
