    <?php function cate_list_radio($arr_cateRows, $lang = '', $cate_id = 0, $cate_excepts = array(), $is_edit = true) {
        if (!empty($arr_cateRows)) {
            foreach ($arr_cateRows as $_key=>$_value) { ?>
                 <tr>
                     <td class="bg-child-<?php echo $_value['cate_level']; ?>">
                         <?php if ($is_edit) { ?>
                            <div class="form-check">
                                <label for="call_cate_id_<?php echo $_value['cate_id']; ?>" class="form-check-label">
                                    <input type="radio" value="<?php echo $_value['cate_id']; ?>" name="call_cate_id" <?php if ($cate_id == $_value['cate_id']) { ?> checked<?php } ?> id="call_cate_id_<?php echo $_value['cate_id']; ?>" class="form-check-input">

                                    <?php echo $_value['cate_name']; ?>
                                </label>
                            </div>
                        <?php } else {
                            $_str_color = 'muted';
                            $_str_icon  = 'times';

                            if ($cate_id == $_value['cate_id']) {
                                $_str_color = 'primary';
                                $_str_icon  = 'check';
                            } else if (in_array($_value['cate_id'], $cate_excepts)) {
                                $_str_color = 'danger';
                            } ?>
                            <span class="text-<?php echo $_str_color; ?>">
                                <span class="fas fa-<?php echo $_str_icon; ?>-circle"></span>
                                <?php echo $_value['cate_name']; ?>
                            </span>
                        <?php } ?>
                    </td>
                    <?php if ($is_edit) { ?>
                        <td>
                            <div class="custom-control custom-switch ml-3">
                                <input value="<?php echo $_value['cate_id']; ?>" type="checkbox"<?php if (in_array($_value['cate_id'], $cate_excepts)) { ?> checked<?php } ?> name="call_cate_excepts[]" id="call_cate_excepts_<?php echo $_value['cate_id']; ?>" class="custom-control-input">
                                <label for="call_cate_excepts_<?php echo $_value['cate_id']; ?>"  class="custom-control-label">
                                    <?php echo $lang->get('Except'); ?>
                                </label>
                            </div>
                        </td>
                    <?php } ?>
                </tr>

                <?php if (isset($_value['cate_childs'])) {
                    cate_list_radio($_value['cate_childs'], $lang, $cate_id, $cate_excepts, $is_edit);
                }
            }
        }
    }

    if (isset($cateRows)) {
        $arr_cateRows = $cateRows;
    } else if (!isset($arr_cateRows)) {
        $arr_cateRows = array();
    }

    if (!isset($cate_id)) {
        $cate_id = 0;
    }

    if (!isset($cate_excepts)) {
        $cate_excepts = array();
    }

    if (!isset($is_edit)) {
        $is_edit = true;
    }

    cate_list_radio($arr_cateRows, $lang, $cate_id, $cate_excepts, $is_edit);