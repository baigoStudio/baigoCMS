<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------MIME 模型-------------*/
class MODEL_MIME {

    function __construct() { //构造函数
        $this->obj_db = $GLOBALS['obj_db']; //设置数据库对象
    }


    function mdl_create_table() {
        $_arr_mimeCreat = array(
            'mime_id'       => 'smallint NOT NULL AUTO_INCREMENT COMMENT \'ID\'',
            'mime_content'  => 'text NOT NULL COMMENT \'MIME\'',
            'mime_note'     => 'varchar(300) NOT NULL COMMENT \'备注\'',
            'mime_ext'      => 'char(30) NOT NULL COMMENT \'扩展名\'',
        );

        $_num_db = $this->obj_db->create_table(BG_DB_TABLE . 'mime', $_arr_mimeCreat, 'mime_id', 'MIME');

        if ($_num_db > 0) {
            $_str_rcode = 'y080105'; //更新成功
        } else {
            $_str_rcode = 'x080105'; //更新成功
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
        );
    }


    function mdl_column() {
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . 'mime');

        $_arr_col = array();

        if (!fn_isEmpty($_arr_colRows)) {
            foreach ($_arr_colRows as $_key=>$_value) {
                $_arr_col[] = $_value['Field'];
            }
        }

        return $_arr_col;
    }


    function mdl_alter_table() {
        $_arr_col     = $this->mdl_column();
        $_arr_alter   = array();

        if (in_array('mime_id', $_arr_col)) {
            $_arr_alter['mime_id'] = array('CHANGE', 'smallint NOT NULL AUTO_INCREMENT COMMENT \'ID\'', 'mime_id');
        }

        if (in_array('mime_ext', $_arr_col)) {
            $_arr_alter['mime_ext'] = array('CHANGE', 'varchar(30) NOT NULL COMMENT \'扩展名\'', 'mime_ext');
        }

        if (in_array('mime_name', $_arr_col)) {
            $_arr_alter['mime_name'] = array('CHANGE', 'text NOT NULL COMMENT \'MIME\'', 'mime_content');
        }

        $_str_rcode = 'y080111';

        if (!fn_isEmpty($_arr_alter)) {
            $_reselt = $this->obj_db->alter_table(BG_DB_TABLE . 'mime', $_arr_alter);

            if (!fn_isEmpty($_reselt)) {
                $_str_rcode = 'y080106';
            }
        }

        return array(
            'rcode' => $_str_rcode,
        );
    }


    /*============提交允许类型============
    @str_mimeName 允许类型

    返回多维数组
        num_mimeId ID
        str_rcode 提示
    */
    function mdl_submit() {
        $_arr_mimeData = array(
            'mime_content'  => $this->mimeInput['mime_content'],
            'mime_ext'      => $this->mimeInput['mime_ext'],
            'mime_note'     => $this->mimeInput['mime_note'],
        );

        if ($this->mimeInput['mime_id'] < 1) {
            $_num_mimeId = $this->obj_db->insert(BG_DB_TABLE . 'mime', $_arr_mimeData);

            if ($_num_mimeId > 0) { //数据库插入是否成功
                $_str_rcode = 'y080101';
            } else {
                return array(
                    'rcode' => 'x080101',
                );
            }
        } else {
            $_num_mimeId = $this->mimeInput['mime_id'];
            $_num_db  = $this->obj_db->update(BG_DB_TABLE . 'mime', $_arr_mimeData, '`mime_id`=' . $_num_mimeId);

            if ($_num_db > 0) { //数据库插入是否成功
                $_str_rcode = 'y080103';
            } else {
                return array(
                    'rcode' => 'x080103',
                );
            }
        }

        return array(
            'rcode' => $_str_rcode,
            'mime_id' => $_num_mimeId,
        );
    }

    /*============允许类型检查============
    @str_mimeName 允许类型

    返回提示
    */
    function mdl_read($str_mime, $str_readBy = 'mime_id', $num_notId = 0) {
        $_arr_mimeSelect = array(
            'mime_id',
            'mime_content',
            'mime_ext',
            'mime_note',
        );

        if (is_numeric($str_mime)) {
            $_str_sqlWhere = '`' . $str_readBy . '`=' . $str_mime;
        } else {
            $_str_sqlWhere = '`' . $str_readBy . '`=\'' . $str_mime . '\'';
        }

        if ($num_notId > 0) {
            $_str_sqlWhere .= ' AND `mime_id`<>' . $num_notId;
        }

        $_arr_mimeRows = $this->obj_db->select(BG_DB_TABLE . 'mime',  $_arr_mimeSelect, $_str_sqlWhere, '', '', 1, 0); //查询数据

        if (isset($_arr_mimeRows[0])) {
            $_arr_mimeRow = $_arr_mimeRows[0];
        } else {
            return array(
                'rcode' => 'x080102', //不存在记录
            );
        }

        $_arr_mimeRow['mime_content'] = fn_jsonDecode($_arr_mimeRow['mime_content'], 'no'); //json解码

        $_arr_mimeRow['rcode'] = 'y080102';

        return $_arr_mimeRow;
    }

    /*============列出允许类型============
    返回多维数组
        mime_id 允许类型 ID
        mime_content 允许类型宽度
    */
    function mdl_list($num_no, $num_except = 0) {
        $_arr_mimeSelect = array(
            'mime_id',
            'mime_content',
            'mime_ext',
            'mime_note',
        );

        $_arr_order = array(
            array('mime_id', 'DESC'),
        );

        $_arr_mimeRows = $this->obj_db->select(BG_DB_TABLE . 'mime',  $_arr_mimeSelect, '', '', $_arr_order, $num_no, $num_except); //查询数据

        foreach ($_arr_mimeRows as $_key=>$_value) {
            $_arr_mimeRows[$_key]['mime_content'] = fn_jsonDecode($_value['mime_content'], 'no');
        }

        return $_arr_mimeRows;
    }

    function mdl_count() {
        $_num_count = $this->obj_db->count(BG_DB_TABLE . 'mime'); //查询数据
        return $_num_count;
    }


    /*============删除允许类型============
    @arr_mimeId 允许类型 ID 数组

    返回提示信息
    */
    function mdl_del() {
        $_str_mimeId = implode(',', $this->mimeIds['mime_ids']);

        $_num_db = $this->obj_db->delete(BG_DB_TABLE . 'mime', '`mime_id` IN (' . $_str_mimeId . ')'); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_db > 0) {
            $_str_rcode = 'y080104';
        } else {
            $_str_rcode = 'x080104';
        }

        return array(
            'rcode' => $_str_rcode
        );
    }


    function input_submit() {
        if (!fn_token('chk')) { //令牌
            return array(
                'rcode' => 'x030206',
            );
        }

        $this->mimeInput['mime_id'] = fn_getSafe(fn_post('mime_id'), 'int', 0);

        if ($this->mimeInput['mime_id'] > 0) {
            $_arr_mimeRow = $this->mdl_read($this->mimeInput['mime_id']);
            if ($_arr_mimeRow['rcode'] != 'y080102') {
                return $_arr_mimeRow;
            }
        }

        $_arr_mimeExt = fn_validate(fn_post('mime_ext'), 1, 30);
        switch ($_arr_mimeExt['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x080203',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x080204',
                );
            break;

            case 'ok':
                $this->mimeInput['mime_ext'] = $_arr_mimeExt['str'];
            break;

        }

        $_arr_mimeRow = $this->mdl_read($this->mimeInput['mime_ext'], 'mime_ext', $this->mimeInput['mime_id']);
        if ($_arr_mimeRow['rcode'] == 'y080102') {
            return array(
                'rcode' => 'x080206',
            );
        }

        $_arr_mimeNote = fn_validate(fn_post('mime_note'), 0, 300);
        switch ($_arr_mimeNote['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x080205',
                );
            break;

            case 'ok':
                $this->mimeInput['mime_note'] = $_arr_mimeNote['str'];
            break;

        }

        $this->mimeInput['mime_content']    = fn_jsonEncode(fn_post('mime_content'), 'no');

        $this->mimeInput['rcode'] = 'ok';

        return $this->mimeInput;
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

        $_arr_mimeIds = fn_post('mime_ids');

        if (fn_isEmpty($_arr_mimeIds)) {
            $_str_rcode = 'x030202';
        } else {
            foreach ($_arr_mimeIds as $_key=>$_value) {
                $_arr_mimeIds[$_key] = fn_getSafe($_value, 'int', 0);
            }
            $_str_rcode = 'ok';
        }

        $this->mimeIds = array(
            'rcode'     => $_str_rcode,
            'mime_ids'  => array_filter(array_unique($_arr_mimeIds)),
        );

        return $this->mimeIds;
    }
}
