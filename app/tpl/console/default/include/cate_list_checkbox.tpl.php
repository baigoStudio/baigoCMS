    <?php function cate_list_checkbox($arr_cateRows, $cate_ids = array(), $form_name = 'call', $is_edit = true) {
        if (!empty($arr_cateRows)) {
            foreach ($arr_cateRows as $_key=>$_value) { ?>
                <tr>
                    <td class="bg-child-<?php echo $_value['cate_level']; ?>">
                        <?php if ($is_edit) { ?>
                            <div class="form-check">
                                <input type="checkbox" value="<?php echo $_value['cate_id']; ?>" name="<?php echo $form_name; ?>_cate_ids[]" id="<?php echo $form_name; ?>_cate_ids_<?php echo $_value['cate_id']; ?>" <?php if (in_array($_value['cate_id'], $cate_ids)) { ?> checked<?php } ?> data-parent="<?php echo $form_name; ?>_cate_ids_<?php echo $_value['cate_parent_id']; ?>" class="form-check-input">
                                <label for="<?php echo $form_name; ?>_cate_ids_<?php echo $_value['cate_id']; ?>"  class="form-check-label">
                                    <?php echo $_value['cate_name']; ?>
                                </label>
                            </div>
                        <?php } else { ?>
                            <span class="text-<?php if (in_array($_value['cate_id'], $cate_ids)) { ?>primary<?php } else { ?>muted<?php } ?>">
                                <span class="fas fa-<?php if (in_array($_value['cate_id'], $cate_ids)) { ?>check-circle<?php } else { ?>times-circle<?php } ?>"></span>
                                <?php echo $_value['cate_name']; ?>
                            </span>
                        <?php } ?>

                    </td>
                </tr>

                <?php if (isset($_value['cate_childs'])) {
                    cate_list_checkbox($_value['cate_childs'], $cate_ids, $form_name, $is_edit);
                }
            }
        }
    }

    if (isset($cateRows)) {
        $_arr_cateRows = $cateRows;
    } else if (!isset($_arr_cateRows)) {
        $_arr_cateRows = array();
    }

    if (!isset($cate_ids)) {
        $cate_ids = array();
    }

    if (!isset($is_edit)) {
        $is_edit = true;
    }

    if (!isset($form_name)) {
        $form_name = 'call';
    }

    cate_list_checkbox($_arr_cateRows, $cate_ids, $form_name, $is_edit);