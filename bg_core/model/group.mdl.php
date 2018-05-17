<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------群组模型-------------*/
class MODEL_GROUP {

    public $arr_status = array('enable', 'disable');
    public $arr_type   = array('admin'/*, 'user'*/);

    function __construct() { //构造函数
        $this->obj_db = $GLOBALS['obj_db']; //设置数据库对象
    }


    function mdl_create_table() {
        $_str_status    = implode('\',\'', $this->arr_status);
        $_str_type      = implode('\',\'', $this->arr_type);

        $_arr_groupCreat = array(
            'group_id'       => 'smallint NOT NULL AUTO_INCREMENT COMMENT \'ID\'',
            'group_name'     => 'varchar(30) NOT NULL COMMENT \'组名\'',
            'group_note'     => 'varchar(30) NOT NULL COMMENT \'备注\'',
            'group_allow'    => 'varchar(1000) NOT NULL COMMENT \'权限\'',
            'group_type'     => 'enum(\'' . $_str_type . '\') NOT NULL COMMENT \'类型\'',
            'group_status'   => 'enum(\'' . $_str_status . '\') NOT NULL COMMENT \'状态\'',
        );

        $_num_db = $this->obj_db->create_table(BG_DB_TABLE . 'group', $_arr_groupCreat, 'group_id', '群组');

        if ($_num_db > 0) {
            $_str_rcode = 'y040105'; //更新成功
        } else {
            $_str_rcode = 'x040105'; //更新成功
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
        );
    }


    function mdl_column() {
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . 'group');

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
        $_str_type     = implode('\',\'', $this->arr_type);

        $_arr_col     = $this->mdl_column();
        $_arr_alter   = array();

        if (in_array('group_status', $_arr_col)) {
            $_arr_alter['group_status'] = array('CHANGE', 'enum(\'' . $_str_status . '\') NOT NULL COMMENT \'状态\'', 'group_status');
        } else {
            $_arr_alter['group_status'] = array('ADD', 'enum(\'' . $_str_status . '\') NOT NULL COMMENT \'状态\'');
        }

        if (in_array('group_id', $_arr_col)) {
            $_arr_alter['group_id'] = array('CHANGE', 'smallint NOT NULL AUTO_INCREMENT COMMENT \'ID\'', 'group_id');
        }

        if (in_array('group_type', $_arr_col)) {
            $_arr_alter['group_type'] = array('CHANGE', 'enum(\'' . $_str_type . '\') NOT NULL COMMENT \'类型\'', 'group_type');
        }

        $_str_rcode = 'y040111';

        if (!fn_isEmpty($_arr_alter)) {
            $_reselt = $this->obj_db->alter_table(BG_DB_TABLE . 'group', $_arr_alter);

            if (!fn_isEmpty($_reselt)) {
                $_str_rcode = 'y040106';
                $_arr_groupData = array(
                    'group_status' => $this->arr_status[0],
                );
                $this->obj_db->update(BG_DB_TABLE . 'group', $_arr_groupData, 'LENGTH(`group_status`)<1'); //更新数据

                $_arr_groupData = array(
                    'group_type' => $this->arr_type[0],
                );
                $this->obj_db->update(BG_DB_TABLE . 'group', $_arr_groupData, 'LENGTH(`group_type`)<1'); //更新数据
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
     * @param mixed $num_groupId
     * @param mixed $str_groupName
     * @param mixed $str_groupType
     * @param string $str_groupNote (default: '')
     * @param string $str_groupAllow (default: '')
     * @return void
     */
    function mdl_submit() {

        $_arr_groupData = array(
            'group_name'     => $this->groupInput['group_name'],
            'group_type'     => $this->groupInput['group_type'],
            'group_note'     => $this->groupInput['group_note'],
            'group_allow'    => $this->groupInput['group_allow'],
            'group_status'   => $this->groupInput['group_status'],
        );

        if ($this->groupInput['group_id'] < 1) { //插入
            $_num_groupId = $this->obj_db->insert(BG_DB_TABLE . 'group', $_arr_groupData);

            if ($_num_groupId > 0) { //数据库插入是否成功
                $_str_rcode = 'y040101';
            } else {
                return array(
                    'rcode' => 'x040101',
                );
            }
        } else {
            $_num_groupId    = $this->groupInput['group_id'];
            $_num_db      = $this->obj_db->update(BG_DB_TABLE . 'group', $_arr_groupData, '`group_id`=' . $_num_groupId);

            if ($_num_db > 0) { //数据库更新是否成功
                $_str_rcode = 'y040103';
            } else {
                return array(
                    'rcode' => 'x040103',
                );
            }
        }

        return array(
            'group_id'  => $_num_groupId,
            'rcode'     => $_str_rcode,
        );

    }


    /**
     * mdl_read function.
     *
     * @access public
     * @param mixed $str_group
     * @param string $str_readBy (default: 'group_id')
     * @param int $num_notId (default: 0)
     * @return void
     */
    function mdl_read($str_group, $str_readBy = 'group_id', $num_notId = 0) {

        $_arr_groupSelect = array(
            'group_id',
            'group_name',
            'group_note',
            'group_allow',
            'group_type',
            'group_status',
        );

        if (is_numeric($str_group)) {
            $_str_sqlWhere = '`' . $str_readBy . '`=' . $str_group;
        } else {
            $_str_sqlWhere = '`' . $str_readBy . '`=\'' . $str_group . '\'';
        }

        if ($num_notId > 0) {
            $_str_sqlWhere .= ' AND `group_id`<>' . $num_notId;
        }

        $_arr_groupRows = $this->obj_db->select(BG_DB_TABLE . 'group',  $_arr_groupSelect, $_str_sqlWhere, '', '', 1, 0); //检查本地表是否存在记录

        if (isset($_arr_groupRows[0])) {
            $_arr_groupRow = $_arr_groupRows[0];
        } else {
            return array(
                'group_allow'   => array(),
                'rcode'         => 'x040102', //不存在记录
            );
        }

        if (fn_isEmpty($_arr_groupRow['group_allow'])) {
            $_arr_groupRow['group_allow'] = array();
        } else {
            $_arr_groupRow['group_allow'] = fn_jsonDecode($_arr_groupRow['group_allow']); //json解码
        }

        $_arr_groupRow['rcode']   = 'y040102';

        //print_r($_arr_groupRow);

        return $_arr_groupRow;
    }


    function mdl_status($str_status) {

        $_str_groupId = implode(',', $this->groupIds['group_ids']);

        $_arr_groupUpdate = array(
            'group_status' => $str_status,
        );

        $_num_db = $this->obj_db->update(BG_DB_TABLE . 'group', $_arr_groupUpdate, '`group_id` IN (' . $_str_groupId . ')'); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_db > 0) {
            $_str_rcode = 'y040103';
        } else {
            $_str_rcode = 'x040103';
        }

        return array(
            'rcode' => $_str_rcode,
        ); //成功

    }

    /**
     * mdl_list function.
     *
     * @access public
     * @param mixed $num_no
     * @param int $num_except (default: 0)
     * @param string $str_key (default: '')
     * @param string $str_type (default: '')
     * @return void
     */
    function mdl_list($num_no, $num_except = 0, $arr_search = array()) {

        $_arr_groupSelect = array(
            'group_id',
            'group_name',
            'group_note',
            'group_type',
            'group_status',
        );

        $_str_sqlWhere = $this->sql_process($arr_search);

        $_arr_order = array(
            array('group_id', 'DESC'),
        );

        $_arr_groupRows = $this->obj_db->select(BG_DB_TABLE . 'group',  $_arr_groupSelect, $_str_sqlWhere, '', $_arr_order, $num_no, $num_except); //列出本地表是否存在记录

        return $_arr_groupRows;

    }


    /**
     * mdl_count function.
     *
     * @access public
     * @param string $str_key (default: '')
     * @param string $str_status (default: '')
     * @return void
     */
    function mdl_count($arr_search = array()) {
        $_str_sqlWhere = $this->sql_process($arr_search);

        $_num_count = $this->obj_db->count(BG_DB_TABLE . 'group', $_str_sqlWhere); //查询数据

        return $_num_count;
    }


    /**
     * mdl_del function.
     *
     * @access public
     * @param mixed $this->groupIds['group_ids']
     * @return void
     */
    function mdl_del() {

        $_str_groupId = implode(',', $this->groupIds['group_ids']);

        $_num_db = $this->obj_db->delete(BG_DB_TABLE . 'group',  '`group_id` IN (' . $_str_groupId . ')'); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_db > 0) {
            $_str_rcode = 'y040104';
        } else {
            $_str_rcode = 'x040104';
        }

        return array(
            'rcode' => $_str_rcode,
        );

    }


    function input_submit() {
        if (!fn_token('chk')) { //令牌
            return array(
                'rcode' => 'x030206',
            );
        }

        $this->groupInput['group_id'] = fn_getSafe(fn_post('group_id'), 'int', 0);

        if ($this->groupInput['group_id'] > 0) {
            $_arr_groupRow = $this->mdl_read($this->groupInput['group_id']);
            if ($_arr_groupRow['rcode'] != 'y040102') {
                return $_arr_groupRow;
            }
        }

        $_arr_groupName = fn_validate(fn_post('group_name'), 1, 30);
        switch ($_arr_groupName['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x040201',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x040202',
                );
            break;

            case 'ok':
                $this->groupInput['group_name'] = $_arr_groupName['str'];
            break;

        }

        $_arr_groupRow = $this->mdl_read($this->groupInput['group_name'], 'group_name', $this->groupInput['group_id']);

        if ($_arr_groupRow['rcode'] == 'y040102') {
            return array(
                'rcode' => 'x040203',
            );
        }

        $_arr_groupNote = fn_validate(fn_post('group_note'), 0, 30);
        switch ($_arr_groupNote['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x040204',
                );
            break;

            case 'ok':
                $this->groupInput['group_note'] = $_arr_groupNote['str'];
            break;
        }

        $_arr_groupType = fn_validate(fn_post('group_type'), 1, 0);
        switch ($_arr_groupType['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x040205',
                );
            break;

            case 'ok':
                $this->groupInput['group_type'] = $_arr_groupType['str'];
            break;
        }

        $_arr_groupStatus = fn_validate(fn_post('group_status'), 1, 0);
        switch ($_arr_groupStatus['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x040207',
                );
            break;

            case 'ok':
                $this->groupInput['group_status'] = $_arr_groupStatus['str'];
            break;
        }

        $this->groupInput['group_allow'] = fn_jsonEncode(fn_post('group_allow'));
        $this->groupInput['rcode']   = 'ok';

        return $this->groupInput;
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

        $_arr_groupIds = fn_post('group_ids');

        if (fn_isEmpty($_arr_groupIds)) {
            $_str_rcode = 'x030202';
        } else {
            foreach ($_arr_groupIds as $_key=>$_value) {
                $_arr_groupIds[$_key] = fn_getSafe($_value, 'int', 0);
            }
            $_str_rcode = 'ok';
        }

        $this->groupIds = array(
            'rcode'     => $_str_rcode,
            'group_ids' => array_filter(array_unique($_arr_groupIds)),
        );

        return $this->groupIds;
    }


    private function sql_process($arr_search = array()) {
        $_str_sqlWhere = '1';

        if (isset($arr_search['key']) && !fn_isEmpty($arr_search['key'])) {
            $_str_sqlWhere .= ' AND (`group_name` LIKE \'%' . $arr_search['key'] . '%\' OR `group_note` LIKE \'%' . $arr_search['key'] . '%\')';
        }

        if (isset($arr_search['type']) && !fn_isEmpty($arr_search['type'])) {
            $_str_sqlWhere .= ' AND `group_type`=\'' . $arr_search['type'] . '\'';
        }

        if (isset($arr_search['status']) && !fn_isEmpty($arr_search['status'])) {
            $_str_sqlWhere .= ' AND `group_status`=\'' . $arr_search['status'] . '\'';
        }

        return $_str_sqlWhere;
    }
}
