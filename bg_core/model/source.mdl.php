<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------来源模型-------------*/
class MODEL_SOURCE {

    function __construct() { //构造函数
        $this->obj_db = $GLOBALS['obj_db']; //设置数据库对象
    }



    function mdl_create_table() {
        $_arr_sourceCreat = array(
            'source_id'     => 'smallint NOT NULL AUTO_INCREMENT COMMENT \'ID\'',
            'source_name'   => 'varchar(300) NOT NULL COMMENT \'来源名称\'',
            'source_author' => 'varchar(300) NOT NULL COMMENT \'作者\'',
            'source_url'    => 'varchar(900) NOT NULL COMMENT \'来源 URL\'',
            'source_note'   => 'varchar(30) NOT NULL COMMENT \'备注\'',
        );

        $_num_db = $this->obj_db->create_table(BG_DB_TABLE . 'source', $_arr_sourceCreat, 'source_id', '来源');

        if ($_num_db > 0) {
            $_str_rcode = 'y260105'; //更新成功
        } else {
            $_str_rcode = 'x260105'; //更新成功
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
        );
    }


    function mdl_column() {
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . 'source');

        $_arr_col = array();

        if (!fn_isEmpty($_arr_colRows)) {
            foreach ($_arr_colRows as $_key=>$_value) {
                $_arr_col[] = $_value['Field'];
            }
        }

        return $_arr_col;
    }


    function mdl_alter_table() {

        $_arr_col   = $this->mdl_column();
        $_arr_alter = array();

        if (in_array('source_auther', $_arr_col)) {
            $_arr_alter['source_auther'] = array('CHANGE', 'varchar(300) NOT NULL COMMENT \'作者\'', 'source_author');
        }

        $_str_rcode = 'y260111';

        if (!fn_isEmpty($_arr_alter)) {
            $_reselt = $this->obj_db->alter_table(BG_DB_TABLE . 'source', $_arr_alter);

            if (!fn_isEmpty($_reselt)) {
                $_str_rcode = 'y260106';
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
     * @param mixed $num_sourceId
     * @param mixed $str_sourceName
     * @param mixed $str_sourceType
     * @param mixed $str_sourceStatus
     * @return void
     */
    function mdl_submit() {

        $_arr_sourceData = array(
            'source_name'   => $this->sourceInput['source_name'],
            'source_author' => $this->sourceInput['source_author'],
            'source_url'    => $this->sourceInput['source_url'],
            'source_note'   => $this->sourceInput['source_note'],
        );

        if ($this->sourceInput['source_id'] < 1) {

            $_num_sourceId = $this->obj_db->insert(BG_DB_TABLE . 'source', $_arr_sourceData);

            if ($_num_sourceId > 0) { //数据库插入是否成功
                $_str_rcode = 'y260101';
            } else {
                return array(
                    'rcode' => 'x260101',
                );
            }

        } else {
            $_num_sourceId = $this->sourceInput['source_id'];
            $_num_db  = $this->obj_db->update(BG_DB_TABLE . 'source', $_arr_sourceData, '`source_id`=' . $_num_sourceId);

            if ($_num_db > 0) {
                $_str_rcode = 'y260103';
            } else {
                return array(
                    'rcode' => 'x260103',
                );
            }
        }

        return array(
            'source_id' => $_num_sourceId,
            'rcode'     => $_str_rcode,
        );
    }


    /**
     * mdl_read function.
     *
     * @access public
     * @param mixed $str_source
     * @param string $str_readBy (default: 'source_id')
     * @param int $num_parentId (default: 0)
     * @return void
     */
    function mdl_read($str_source, $str_readBy = 'source_id', $num_notId = 0) {
        $_arr_sourceSelect = array(
            'source_id',
            'source_name',
            'source_author',
            'source_url',
            'source_note',
        );

        if (is_numeric($str_source)) {
            $_str_sqlWhere = '`' . $str_readBy . '`=' . $str_source;
        } else {
            $_str_sqlWhere = '`' . $str_readBy . '`=\'' . $str_source . '\'';
        }

        if ($num_notId > 0) {
            $_str_sqlWhere .= ' AND `source_id`<>' . $num_notId;
        }

        $_arr_sourceRows = $this->obj_db->select(BG_DB_TABLE . 'source',  $_arr_sourceSelect, $_str_sqlWhere, '', '', 1, 0); //检查本地表是否存在记录

        if (isset($_arr_sourceRows[0])) {
            $_arr_sourceRow = $_arr_sourceRows[0];
        } else {
            return array(
                'rcode' => 'x260102', //不存在记录
            );
        }

        $_arr_sourceRow['source_url']  = fn_htmlcode($_arr_sourceRow['source_url'], 'decode', 'url');
        $_arr_sourceRow['source_url']  = fn_safe($_arr_sourceRow['source_url']);
        $_arr_sourceRow['source_url']  = fn_htmlcode($_arr_sourceRow['source_url'], 'decode', 'url');

        $_arr_sourceRow['rcode'] = 'y260102';

        return $_arr_sourceRow;
    }


    /**
     * mdl_list function.
     *
     * @access public
     * @param string $str_status (default: '')
     * @param string $str_type (default: '')
     * @param int $num_parentId (default: 0)
     * @return void
     */
    function mdl_list($num_no, $num_except = 0, $arr_search = array()) {
        $_arr_sourceSelect = array(
            'source_id',
            'source_name',
            'source_author',
            'source_url',
            'source_note',
        );

        $_str_sqlWhere = $this->sql_process($arr_search);

        $_arr_order = array(
            array('source_id', 'DESC'),
        );

        $_arr_sourceRows = $this->obj_db->select(BG_DB_TABLE . 'source',  $_arr_sourceSelect, $_str_sqlWhere, '', $_arr_order, $num_no, $num_except);

        foreach ($_arr_sourceRows as $_key=>$_value) {
            $_arr_sourceRows[$_key]['source_url']  = fn_htmlcode(fn_safe(fn_htmlcode($_value['source_url'], 'decode', 'url')), 'decode', 'url');
        }


        return $_arr_sourceRows;
    }


    function mdl_count($arr_search = array()) {

        $_str_sqlWhere = $this->sql_process($arr_search);

        $_num_sourceCount = $this->obj_db->count(BG_DB_TABLE . 'source', $_str_sqlWhere);

        return $_num_sourceCount;
    }


    /**
     * mdl_del function.
     *
     * @access public
     * @param mixed $this->sourceIds['source_ids']
     * @return void
     */
    function mdl_del() {
        $_str_sourceIds = implode(',', $this->sourceIds['source_ids']);

        $_num_db = $this->obj_db->delete(BG_DB_TABLE . 'source',  '`source_id` IN (' . $_str_sourceIds . ')'); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_db > 0) {
            $_str_rcode = 'y260104';
        } else {
            $_str_rcode = 'x260104';
        }

        return array(
            'rcode' => $_str_rcode,
        ); //成功
    }


    function input_submit() {
        if (!fn_token('chk')) { //令牌
            return array(
                'rcode' => 'x030206',
            );
        }

        $this->sourceInput['source_id'] = fn_getSafe(fn_post('source_id'), 'int', 0);

        if ($this->sourceInput['source_id'] > 0) {
            $_arr_sourceRow = $this->mdl_read($this->sourceInput['source_id']);
            if ($_arr_sourceRow['rcode'] != 'y260102') {
                return $_arr_sourceRow;
            }
        }

        $_arr_sourceName = fn_validate(fn_post('source_name'), 1, 300);
        switch ($_arr_sourceName['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x260201',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x260202',
                );
            break;

            case 'ok':
                $this->sourceInput['source_name'] = $_arr_sourceName['str'];
            break;
        }

        $_arr_sourceAuthor = fn_validate(fn_post('source_author'), 0, 300);
        switch ($_arr_sourceAuthor['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x260203',
                );
            break;

            case 'ok':
                $this->sourceInput['source_author'] = $_arr_sourceAuthor['str'];
            break;
        }

        $_arr_sourceUrl = fn_validate(fn_post('source_url'), 0, 900);
        switch ($_arr_sourceUrl['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x260204',
                );
            break;

            case 'ok':
                $this->sourceInput['source_url'] = $_arr_sourceUrl['str'];
            break;
        }

        $_arr_sourceNote = fn_validate(fn_post('source_note'), 0, 30);
        switch ($_arr_sourceNote['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x260205',
                );
            break;

            case 'ok':
                $this->sourceInput['source_note'] = $_arr_sourceNote['str'];
            break;
        }

        $this->sourceInput['rcode'] = 'ok';

        return $this->sourceInput;
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

        $_arr_sourceIds = fn_post('source_ids');

        if (fn_isEmpty($_arr_sourceIds)) {
            $_str_rcode = 'x030202';
        } else {
            foreach ($_arr_sourceIds as $_key=>$_value) {
                $_arr_sourceIds[$_key] = fn_getSafe($_value, 'int', 0);
            }
            $_str_rcode = 'ok';
        }

        $this->sourceIds = array(
            'rcode'         => $_str_rcode,
            'source_ids'    => array_filter(array_unique($_arr_sourceIds)),
        );

        return $this->sourceIds;
    }


    private function sql_process($arr_search = array()) {
        $_str_sqlWhere = '1';

        if (isset($arr_search['key']) && !fn_isEmpty($arr_search['key'])) {
            $_str_sqlWhere .= ' AND (`source_name` LIKE \'%' . $arr_search['key'] . '%\' OR `source_author` LIKE \'%' . $arr_search['key'] . '%\' OR `source_note` LIKE \'%' . $arr_search['key'] . '%\')';
        }

        return $_str_sqlWhere;
    }
}
