<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------自定义字段模型-------------*/
class MODEL_CUSTOM {

    public $arr_status = array('enable', 'disable');
    public $arr_type   = array('str', 'radio', 'select');
    public $arr_format = array('text', 'date', 'datetime', 'int', 'digit', 'url', 'email');

    function __construct() { //构造函数
        $this->obj_db   = $GLOBALS['obj_db']; //设置数据库对象
        $this->obj_file  = new CLASS_FILE();
    }


    /**
     * mdl_create_table function.
     *
     * @access public
     * @return void
     */
    function mdl_create_table() {
        $_str_status    = implode('\',\'', $this->arr_status);
        $_str_type      = implode('\',\'', $this->arr_type);
        $_str_formats   = implode('\',\'', $this->arr_format);

        $_arr_customCreat = array(
            'custom_id'          => 'smallint NOT NULL AUTO_INCREMENT COMMENT \'ID\'',
            'custom_name'        => 'varchar(90) NOT NULL COMMENT \'名称\'',
            'custom_type'        => 'enum(\'' . $_str_type . '\') NOT NULL COMMENT \'类型\'',
            'custom_opt'         => 'varchar(1000) NOT NULL COMMENT \'选项\'',
            'custom_status'      => 'enum(\'' . $_str_status . '\') NOT NULL COMMENT \'状态\'',
            'custom_order'       => 'smallint NOT NULL COMMENT \'排序\'',
            'custom_parent_id'   => 'smallint NOT NULL COMMENT \'父字段\'',
            'custom_cate_id'     => 'smallint NOT NULL COMMENT \'栏目ID\'',
            'custom_format'      => 'enum(\'' . $_str_formats . '\') NOT NULL COMMENT \'格式\'',
            'custom_require'     => 'tinyint(1) NOT NULL COMMENT \'必需\'',
            'custom_size'        => 'smallint NOT NULL COMMENT \'字段长度\'',
        );

        $_num_db = $this->obj_db->create_table(BG_DB_TABLE . 'custom', $_arr_customCreat, 'custom_id', '自定义字段');

        if ($_num_db > 0) {
            $_str_rcode = 'y200105'; //更新成功
        } else {
            $_str_rcode = 'x200105'; //更新成功
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
        );
    }


    function mdl_create_index() {
        $_str_rcode       = 'y200109';
        $_arr_indexRow    = $this->obj_db->show_indexs(BG_DB_TABLE . 'custom');

        $drop_overlap        = false;
        foreach ($_arr_indexRow as $_key=>$_value) {
            if (in_array('order', $_value)) {
                $drop_overlap = true;
                break;
            }
        }

        $_arr_customIndex = array(
            'custom_order',
            'custom_id',
        );

        $_num_db = $this->obj_db->create_index('order', BG_DB_TABLE . 'custom', $_arr_customIndex, 'BTREE', $drop_overlap);

        if ($_num_db < 1) {
            $_str_rcode = 'x200109';
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
        );
    }


    /**
     * mdl_column function.
     *
     * @access public
     * @return void
     */
    function mdl_column() {
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . 'custom');

        //print_r($_arr_colRows);

        $_arr_col = array();

        if (!fn_isEmpty($_arr_colRows)) {
            foreach ($_arr_colRows as $_key=>$_value) {
                $_arr_col[] = $_value['Field'];
            }
        }

        return $_arr_col;
    }


    function mdl_column_custom() {
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . 'article_custom');

        $_arr_col = array();

        if (!fn_isEmpty($_arr_colRows)) {
            foreach ($_arr_colRows as $_key=>$_value) {
                $_arr_col[] = $_value['Field'];
            }
        }

        return $_arr_col;
    }


    function mdl_alter_table() {
        $_str_status    = implode('\',\'', $this->arr_status);
        $_str_type      = implode('\',\'', $this->arr_type);
        $_str_formats   = implode('\',\'', $this->arr_format);

        $_arr_col     = $this->mdl_column();
        $_arr_alter   = array();

        if (!in_array('custom_order', $_arr_col)) {
            $_arr_alter['custom_order'] = array('ADD', 'smallint NOT NULL COMMENT \'排序\'');
        }

        if (!in_array('custom_parent_id', $_arr_col)) {
            $_arr_alter['custom_parent_id'] = array('ADD', 'smallint NOT NULL COMMENT \'父字段\'');
        }

        if (!in_array('custom_cate_id', $_arr_col)) {
            $_arr_alter['custom_cate_id'] = array('ADD', 'smallint NOT NULL COMMENT \'栏目ID\'');
        }

        if (!in_array('custom_opt', $_arr_col)) {
            $_arr_alter['custom_opt'] = array('ADD', 'varchar(1000) NOT NULL COMMENT \'选项\'');
        }

        if (!in_array('custom_format', $_arr_col)) {
            $_arr_alter['custom_format'] = array('ADD', 'enum(\'' . $_str_formats . '\') NOT NULL COMMENT \'格式\'');
        }

        if (!in_array('custom_require', $_arr_col)) {
            $_arr_alter['custom_require'] = array('ADD', 'tinyint(1) NOT NULL COMMENT \'必需\'');
        }

        if (!in_array('custom_size', $_arr_col)) {
            $_arr_alter['custom_size'] = array('ADD', 'smallint NOT NULL COMMENT \'字段长度\'');
        }

        $_str_rcode = 'y200115';

        if (!fn_isEmpty($_arr_alter)) {
            $_reselt = $this->obj_db->alter_table(BG_DB_TABLE . 'custom', $_arr_alter);

            if (!fn_isEmpty($_reselt)) {
                $_str_rcode = 'y200106';
                $_arr_customData = array(
                    'custom_format' => $this->arr_format[0],
                );
                $this->obj_db->update(BG_DB_TABLE . 'custom', $_arr_customData, 'LENGTH(`custom_format`)<1'); //更新数据
            }
        }

        unset($_arr_alter);

        if (in_array('custom_type', $_arr_col)) {
            $_arr_customData = array(
                'custom_type' => 'text'
            );
            $this->obj_db->update(BG_DB_TABLE . 'custom', $_arr_customData); //全部更新为 text 类型 (原类型内包含)

            $_arr_alter['custom_type'] = array('CHANGE', 'enum(\'' . $_str_type . '\',\'text\') NOT NULL COMMENT \'类型\'', 'custom_type');
            $this->obj_db->alter_table(BG_DB_TABLE . 'custom', $_arr_alter); //更改类型字段, 加上 text 类型

            $_arr_customData = array(
                'custom_type' => $this->arr_type[0],
            );
            $this->obj_db->update(BG_DB_TABLE . 'custom', $_arr_customData); //全部更新为 str 类型

            $_arr_alter['custom_type'] = array('CHANGE', 'enum(\'' . $_str_type . '\') NOT NULL COMMENT \'类型\'', 'custom_type');
            $this->obj_db->alter_table(BG_DB_TABLE . 'custom', $_arr_alter); //更改类型字段
        }

        return array(
            'rcode' => $_str_rcode,
        );
    }


    function mdl_drop() {
        $_arr_col   = $this->mdl_column();
        $_arr_alter = array();

        $_str_rcode = 'y200115';

        if (in_array('custom_target', $_arr_col)) {
            $_arr_alter['custom_target'] = array('DROP');
        }

        if (!fn_isEmpty($_arr_alter)) {
            $_reselt = $this->obj_db->alter_table(BG_DB_TABLE . 'custom', $_arr_alter);

            if (!fn_isEmpty($_reselt)) {
                $_str_rcode = 'y200113';
            }
        }

        return array(
            'rcode' => $_str_rcode,
        );
    }


    /**
     * mdl_submit function.
     *
     * @access public
     * @param mixed $num_customId
     * @param mixed $str_customName
     * @param mixed $str_customType
     * @param mixed $str_status
     * @return void
     */
    function mdl_submit() {

        $_arr_customData = array(
            'custom_name'        => $this->customInput['custom_name'],
            'custom_type'        => $this->customInput['custom_type'],
            'custom_opt'         => $this->customInput['custom_opt'],
            'custom_status'      => $this->customInput['custom_status'],
            'custom_parent_id'   => $this->customInput['custom_parent_id'],
            'custom_cate_id'     => $this->customInput['custom_cate_id'],
            'custom_format'      => $this->customInput['custom_format'],
            'custom_require'     => $this->customInput['custom_require'],
            'custom_size'        => $this->customInput['custom_size'],
        );

        if ($this->customInput['custom_id'] < 1) {

            $_num_customId = $this->obj_db->insert(BG_DB_TABLE . 'custom', $_arr_customData);

            if ($_num_customId > 0) { //数据库插入是否成功
                $_str_rcode = 'y200101';
            } else {
                return array(
                    'rcode' => 'x200101',
                );
            }

        } else {
            $_num_customId = $this->customInput['custom_id'];
            $_num_db  = $this->obj_db->update(BG_DB_TABLE . 'custom', $_arr_customData, '`custom_id`=' . $_num_customId);

            if ($_num_db > 0) {
                $_str_rcode = 'y200103';
            } else {
                return array(
                    'rcode' => 'x200103',
                );
            }
        }

        return array(
            'custom_id'    => $_num_customId,
            'rcode'  => $_str_rcode,
        );
    }


    /**
     * mdl_read function.
     *
     * @access public
     * @param mixed $str_custom
     * @param string $str_readBy (default: 'custom_id')
     * @param int $num_parentId (default: 0)
     * @return void
     */
    function mdl_read($str_custom, $str_readBy = 'custom_id', $num_notId = 0) {
        $_arr_customSelect = array(
            'custom_id',
            'custom_name',
            'custom_type',
            'custom_opt',
            'custom_status',
            'custom_parent_id',
            'custom_cate_id',
            'custom_format',
            'custom_require',
            'custom_size',
        );

        if (is_numeric($str_custom)) {
            $_str_sqlWhere = '`' . $str_readBy . '`=' . $str_custom;
        } else {
            $_str_sqlWhere = '`' . $str_readBy . '`=\'' . $str_custom . '\'';
        }

        if ($num_notId > 0) {
            $_str_sqlWhere .= ' AND `custom_id`<>' . $num_notId;
        }

        $_arr_customRows = $this->obj_db->select(BG_DB_TABLE . 'custom',  $_arr_customSelect, $_str_sqlWhere, '', '', 1, 0); //检查本地表是否存在记录

        if (isset($_arr_customRows[0])) {
            $_arr_customRow = $_arr_customRows[0];
        } else {
            return array(
                'rcode' => 'x200102', //不存在记录
            );
        }

        $_arr_customRow['custom_opt'] = fn_jsonDecode($_arr_customRow['custom_opt'], true);
        $_arr_customRow['rcode']      = 'y200102';

        //print_r($_arr_customRow);

        return $_arr_customRow;
    }


    /**
     * mdl_list function.
     *
     * @access public
     * @param string $str_status (default: '')
     * @param string $str_target (default: '')
     * @param int $num_parentId (default: 0)
     * @return void
     */
    function mdl_list($num_no, $num_except = 0, $arr_search = array(), $num_level = 1, $is_tree = true) {
        $_arr_updateData = array(
            'custom_order' => '`custom_id`',
        );

        $_num_db = $this->obj_db->update(BG_DB_TABLE . 'custom', $_arr_updateData, '`custom_order`<1', true); //更新数据

        $_arr_order = array(
            array('custom_order', 'ASC'),
            array('custom_id', 'ASC'),
        );

        if ($is_tree) {
            $_arr_customSelect = array(
                'custom_id',
                'custom_name',
                'custom_type',
                'custom_opt',
                'custom_status',
                'custom_parent_id',
                'custom_cate_id',
                'custom_format',
                'custom_require',
                'custom_size',
            );

            $_str_sqlWhere = $this->sql_process($arr_search);

            //print_r($_str_sqlWhere);

            $_arr_customRows = $this->obj_db->select(BG_DB_TABLE . 'custom',  $_arr_customSelect, $_str_sqlWhere, '', $_arr_order, $num_no, $num_except);

            foreach ($_arr_customRows as $_key=>$_value) {
                $_arr_customRows[$_key]['custom_opt']    = fn_jsonDecode($_value['custom_opt'], true);
                $_arr_customRows[$_key]['custom_level']  = $num_level;
                $arr_searchChild = array(
                    'parent_id' => $_value['custom_id'],
                );
                $_arr_customRows[$_key]['custom_childs'] = $this->mdl_list(1000, 0, $arr_searchChild, $num_level + 1);
            }
        } else {
            $_arr_customRows = array();

            $_arr_customSelect = array(
                'custom_id',
                'custom_name',
                'custom_size',
            );

            $_str_sqlWhere = '`custom_status`=\'enable\'';

            $_arr_customRowsTemp = $this->obj_db->select(BG_DB_TABLE . 'custom',  $_arr_customSelect, $_str_sqlWhere, '', $_arr_order, 1000, 0);

            foreach ($_arr_customRowsTemp as $_key=>$_value) {
                $arr_searchChild = array(
                    'parent_id' => $_value['custom_id'],
                );
                $_num_customCount = $this->mdl_count($arr_searchChild);
                if ($_num_customCount < 1) {
                    $_arr_customRows[] = $_value;
                }
            }
        }

        return $_arr_customRows;
    }


    /**
     * mdl_count function.
     *
     * @access public
     * @param string $str_key (default: '')
     * @param string $str_target (default: '')
     * @return void
     */
    function mdl_count($arr_search = array()) {

        $_str_sqlWhere      = $this->sql_process($arr_search);

        $_num_customCount   = $this->obj_db->count(BG_DB_TABLE . 'custom', $_str_sqlWhere); //查询数据

        /*print_r($_arr_userRow);
        exit;*/

        return $_num_customCount;
    }


    function mdl_order($str_orderType = '', $num_doId = 0, $num_targetId = 0, $num_parentId = 0) {
        //处理重复排序号
        $_str_sqlDistinct = 'SELECT `custom_id` FROM `' . BG_DB_TABLE . 'custom` WHERE `custom_order` IN (SELECT `custom_order` FROM `' . BG_DB_TABLE . 'custom` GROUP BY `custom_order` HAVING COUNT(`custom_order`)>1) ORDER BY `custom_id` DESC';
        $_obj_reselt      = $this->obj_db->query($_str_sqlDistinct);
        $_arr_row         = $this->obj_db->fetch_assoc($_obj_reselt);

        if (!fn_isEmpty($_arr_row)) {
            $_arr_selectData = array(
                'custom_id',
            );

            $_arr_order = array(
                array('custom_id', 'DESC'),
            );
            $_arr_lastRows  = $this->obj_db->select(BG_DB_TABLE . 'custom', $_arr_selectData, '', '', $_arr_order, 1, 0); //读取倒数第一排序号
            if (isset($_arr_lastRows[0])) {
                $_arr_lastRow   = $_arr_lastRows[0];

                $_arr_updateData = array(
                    'custom_order' => $_arr_row['custom_id'] + 1,
                );

                $_str_sqlWhere = '`custom_id`=' . $_arr_row['custom_id'];

                $this->obj_db->update(BG_DB_TABLE . 'custom', $_arr_updateData, $_str_sqlWhere, true); //所有小于本条大于目标记录的数据排序号加1
            }
        }
        //end

        //
        $_arr_selectData = array(
            'custom_order',
        );

        switch ($str_orderType) {
            case 'order_first':
                $_str_sqlWhere = '`custom_parent_id`=' . $num_parentId;
                $_arr_order = array(
                    array('custom_order', 'ASC'),
                );

                $_arr_firstRows = $this->obj_db->select(BG_DB_TABLE . 'custom', $_arr_selectData, $_str_sqlWhere, '', $_arr_order, 1, 0); //读取第一排序号
                if (isset($_arr_firstRows[0])) {
                    $_arr_firstRow  = $_arr_firstRows[0];
                }

                $_str_sqlWhere  = '`custom_id`=' . $num_doId . ' AND `custom_parent_id`=' . $num_parentId;
                $_arr_doRows    = $this->obj_db->select(BG_DB_TABLE . 'custom', $_arr_selectData, $_str_sqlWhere, '', '', 1, 0); //读取本条排序号
                if (isset($_arr_doRows[0])) {
                    $_arr_doRow     = $_arr_doRows[0];
                } else {
                    return array(
                        'rcode' => 'x200214',
                    );
                }

                $_arr_targetData = array(
                    'custom_order' => '`custom_order`+1',
                );
                $_str_sqlWhere = '`custom_order`<' . $_arr_doRow['custom_order'] . ' AND `custom_parent_id`=' . $num_parentId;
                $this->obj_db->update(BG_DB_TABLE . 'custom', $_arr_targetData, $_str_sqlWhere, true); //所有小于本条的数据排序号加1

                $_arr_doData = array(
                    'custom_order' => $_arr_firstRow['custom_order'],
                );
                $_str_sqlWhere = '`custom_id`=' . $num_doId . ' AND `custom_parent_id`=' . $num_parentId;
                $this->obj_db->update(BG_DB_TABLE . 'custom', $_arr_doData, $_str_sqlWhere); //更新本条排序号为1
            break;

            case 'order_last':
                $_str_sqlWhere  = '`custom_parent_id`=' . $num_parentId;
                $_arr_order = array(
                    array('custom_order', 'DESC'),
                );
                $_arr_lastRows  = $this->obj_db->select(BG_DB_TABLE . 'custom', $_arr_selectData, $_str_sqlWhere, '', $_arr_order, 1, 0); //读取倒数第一排序号
                if (isset($_arr_lastRows[0])) {
                    $_arr_lastRow   = $_arr_lastRows[0];
                }

                $_str_sqlWhere  = '`custom_id`=' . $num_doId . ' AND `custom_parent_id`=' . $num_parentId;
                $_arr_doRows    = $this->obj_db->select(BG_DB_TABLE . 'custom', $_arr_selectData, $_str_sqlWhere, '', '', 1, 0); //读取本条排序号
                if (isset($_arr_doRows[0])) {
                    $_arr_doRow     = $_arr_doRows[0];
                } else {
                    return array(
                        'rcode' => 'x200214',
                    );
                }

                $_arr_targetData = array(
                    'custom_order' => '`custom_order`-1',
                );
                $_str_sqlWhere = '`custom_order`>' . $_arr_doRow['custom_order'] . ' AND `custom_parent_id`=' . $num_parentId;
                $this->obj_db->update(BG_DB_TABLE . 'custom', $_arr_targetData, $_str_sqlWhere, true); //所有大于本条的数据排序号减1

                $_arr_doData = array(
                    'custom_order' => $_arr_lastRow['custom_order'],
                );
                $_str_sqlWhere = '`custom_id`=' . $num_doId . 'AND `custom_parent_id`=' . $num_parentId;
                $this->obj_db->update(BG_DB_TABLE . 'custom', $_arr_doData, $_str_sqlWhere); //更新本条排序号为最大
            break;

            case 'order_after':
                $_str_sqlWhere = '`custom_id`=' . $num_targetId . ' AND `custom_parent_id`=' . $num_parentId;
                $_arr_targetRows    = $this->obj_db->select(BG_DB_TABLE . 'custom', $_arr_selectData, $_str_sqlWhere, '', '', 1, 0); //读取目标记录排序号
                if (isset($_arr_targetRows[0])) {
                    $_arr_targetRow     = $_arr_targetRows[0];
                } else {
                    return array(
                        'rcode' => 'x200215',
                    );
                }

                $_str_sqlWhere      = '`custom_id`=' . $num_doId . ' AND `custom_parent_id`=' . $num_parentId;
                $_arr_doRows    = $this->obj_db->select(BG_DB_TABLE . 'custom', $_arr_selectData, $_str_sqlWhere, '', '', 1, 0); //读取本条排序号
                if (isset($_arr_doRows[0])) {
                    $_arr_doRow     = $_arr_doRows[0];
                } else {
                    return array(
                        'rcode' => 'x200214',
                    );
                }

                //print_r($_arr_doRow);

                if ($_arr_targetRow['custom_order'] > $_arr_doRow['custom_order']) { //往下移
                    $_arr_targetData = array(
                        'custom_order' => '`custom_order`-1',
                    );
                    $_str_sqlWhere = '`custom_order`>' . $_arr_doRow['custom_order'] . ' AND `custom_order`<=' . $_arr_targetRow['custom_order'] . ' AND `custom_parent_id`=' . $num_parentId;
                    $this->obj_db->update(BG_DB_TABLE . 'custom', $_arr_targetData, $_str_sqlWhere, true); //所有大于本条小于目标记录的数据排序号减1

                    $_arr_doData = array(
                        'custom_order' => $_arr_targetRow['custom_order'],
                    );
                } else {
                    $_arr_targetData = array(
                        'custom_order' => '`custom_order`+1',
                    );
                    $_str_sqlWhere = '`custom_order`<' . $_arr_doRow['custom_order'] . ' AND `custom_order`>' . $_arr_targetRow['custom_order'] . ' AND `custom_parent_id`=' . $num_parentId;
                    $this->obj_db->update(BG_DB_TABLE . 'custom', $_arr_targetData, $_str_sqlWhere, true); //所有大于本条小于目标记录的数据排序号减1

                    $_arr_doData = array(
                        'custom_order' => $_arr_targetRow['custom_order'] + 1,
                    );
                }

                $_str_sqlWhere = '`custom_id`=' . $num_doId . ' AND `custom_parent_id`=' . $num_parentId;
                $this->obj_db->update(BG_DB_TABLE . 'custom', $_arr_doData, $_str_sqlWhere); //更新本条排序号为目标记录排序号
            break;
        }

        return array(
            'rcode' => 'y200103',
        );
    }


    function mdl_status($str_status) {
        $_str_customId = implode(',', $this->customIds['custom_ids']);

        $_arr_customData = array(
            'custom_status' => $str_status,
        );

        $_num_db = $this->obj_db->update(BG_DB_TABLE . 'custom', $_arr_customData, '`custom_id` IN (' . $_str_customId . ')'); //更新数据

        //如车影响行数小于0则返回错误
        if ($_num_db > 0) {
            $_str_rcode = 'y200103';
        } else {
            $_str_rcode = 'x200103';
        }

        return array(
            'rcode' => $_str_rcode,
        ); //成功
    }


    /**
     * mdl_del function.
     *
     * @access public
     * @param mixed $this->customIds['custom_ids']
     * @return void
     */
    function mdl_del() {
        $_str_customIds = implode(',', $this->customIds['custom_ids']);

        $_num_db = $this->obj_db->delete(BG_DB_TABLE . 'custom',  '`custom_id` IN (' . $_str_customIds . ')'); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_db > 0) {
            $_str_rcode = 'y200104';
        } else {
            $_str_rcode = 'x200104';
        }

        return array(
            'rcode' => $_str_rcode,
        ); //成功
    }


    function mdl_cache($is_reGen = false) {
        if ($is_reGen || !file_exists(BG_PATH_CACHE . 'sys' . DS . 'custom_list.json')) {
            $_arr_column_custom  = $this->mdl_column_custom();

            $_arr_search = array(
                'status' => 'enable',
            );
            $_arr_customRows  = $this->mdl_list(1000, 0, $_arr_search);

            $_arr_customs = array(
                'article_customs'   => $_arr_column_custom,
                'custom_list'       => $_arr_customRows,
            );

            $_str_outPut = json_encode($_arr_customs);

            $_num_size = $this->obj_file->file_put(BG_PATH_CACHE . 'sys' . DS . 'custom_list.json', $_str_outPut);
        }

        $_str_cacheReturn = $this->obj_file->file_read(BG_PATH_CACHE . 'sys' . DS . 'custom_list.json');

        $_arr_cacheReturn = json_decode($_str_cacheReturn, true);

        return $_arr_cacheReturn;
    }


    function input_submit() {
        if (!fn_token('chk')) { //令牌
            return array(
                'rcode' => 'x030206',
            );
        }

        $this->customInput['custom_id'] = fn_getSafe(fn_post('custom_id'), 'int', 0);

        if ($this->customInput['custom_id'] > 0) {
            $_arr_customRow = $this->mdl_read($this->customInput['custom_id']);
            if ($_arr_customRow['rcode'] != 'y200102') {
                return $_arr_customRow;
            }
        }

        $_arr_customName = fn_validate(fn_post('custom_name'), 1, 90);
        switch ($_arr_customName['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x200201',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x200202',
                );
            break;

            case 'ok':
                $this->customInput['custom_name'] = $_arr_customName['str'];
            break;
        }

        $_arr_customParentId = fn_validate(fn_post('custom_parent_id'), 1, 0);
        switch ($_arr_customParentId['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x200207',
                );
            break;

            case 'ok':
                $this->customInput['custom_parent_id'] = $_arr_customParentId['str'];
            break;
        }

        $_arr_customCateId = fn_validate(fn_post('custom_cate_id'), 1, 0);
        switch ($_arr_customCateId['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x200213',
                );
            break;

            case 'ok':
                $this->customInput['custom_cate_id'] = $_arr_customCateId['str'];
            break;
        }


        if ($this->customInput['custom_parent_id'] > 0 && $this->customInput['custom_parent_id'] == $this->customInput['custom_id']) {
            return array(
                'rcode' => 'x200208',
            );
        }


        $_arr_customRow = $this->mdl_read($this->customInput['custom_name'], 'custom_name', $this->customInput['custom_id']);
        if ($_arr_customRow['rcode'] == 'y200102') {
            return array(
                'rcode' => 'x200203',
            );
        }

        $_arr_customType = fn_validate(fn_post('custom_type'), 1, 0);
        switch ($_arr_customType['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x200211',
                );
            break;

            case 'ok':
                $this->customInput['custom_type'] = $_arr_customType['str'];
            break;
        }

        $_arr_customFormat = fn_validate(fn_post('custom_format'), 1, 0);
        switch ($_arr_customFormat['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x200205',
                );
            break;

            case 'ok':
                $this->customInput['custom_format'] = $_arr_customFormat['str'];
            break;
        }

        $_arr_customStatus = fn_validate(fn_post('custom_status'), 1, 0);
        switch ($_arr_customStatus['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x200206',
                );
            break;

            case 'ok':
                $this->customInput['custom_status'] = $_arr_customStatus['str'];
            break;
        }

        $_arr_customSize = fn_validate(fn_post('custom_size'), 9, 300, 'digit', 'int');
        switch ($_arr_customSize['status']) {
            case 'too_small':
                return array(
                    'rcode' => 'x200216',
                );
            break;

            case 'too_big':
                return array(
                    'rcode' => 'x200217',
                );
            break;

            case 'ok':
                $this->customInput['custom_size'] = $_arr_customSize['str'];
            break;
        }

        $this->customInput['custom_require'] = fn_getSafe(fn_post('custom_require'), 'int', 0);

        $_arr_customOpt = fn_post('custom_opt');

        if ($this->customInput['custom_type'] == 'radio' || $this->customInput['custom_type'] == 'select') {
            $this->customInput['custom_opt']     = fn_jsonEncode($_arr_customOpt[$this->customInput['custom_type']], true);
        } else {
            $this->customInput['custom_opt']     = '';
        }

        $this->customInput['rcode']          = 'ok';

        return $this->customInput;
    }


    /**
     * input_ids function.
     *
     * @access public
     * @return void
     */
    function input_ids() {
        if (!fn_token('chk')) { //令牌
            return array(
                'rcode' => 'x030206',
            );
        }

        $_arr_customIds = fn_post('custom_ids');

        if (fn_isEmpty($_arr_customIds)) {
            $_str_rcode = 'x030202';
        } else {
            foreach ($_arr_customIds as $_key=>$_value) {
                $_arr_customIds[$_key] = fn_getSafe($_value, 'int', 0);
            }
            $_str_rcode = 'ok';
        }

        $this->customIds = array(
            'rcode'      => $_str_rcode,
            'custom_ids' => array_filter(array_unique($_arr_customIds)),
        );

        return $this->customIds;
    }


    private function sql_process($arr_search = array()) {
        if (isset($arr_search['parent_id'])) {
            $_str_sqlWhere = '`custom_parent_id`=' . $arr_search['parent_id'];
        } else {
            $_str_sqlWhere = '`custom_parent_id`=0';
        }

        if (isset($arr_search['key']) && !fn_isEmpty($arr_search['key'])) {
            $_str_sqlWhere .= ' AND `custom_name` LIKE \'%' . $arr_search['key'] . '%\'';
        }

        if (isset($arr_search['status']) && !fn_isEmpty($arr_search['status'])) {
            $_str_sqlWhere .= ' AND `custom_status`=\'' . $arr_search['status'] . '\'';
        }

        return $_str_sqlWhere;
    }
}
