<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------文章模型-------------*/
class MODEL_GATHER {

    private $is_magic;

    function __construct() { //构造函数
        $this->obj_db     = $GLOBALS['obj_db']; //设置数据库对象
        $this->is_magic   = get_magic_quotes_gpc();
    }


    /** 创建表
     * mdl_create_table function.
     *
     * @access public
     * @return void
     */
    function mdl_create_table() {
        $_str_rcode = 'y280105';

        $_arr_gatherCreat = array(
            'gather_id'         => 'int NOT NULL AUTO_INCREMENT COMMENT \'ID\'',
            'gather_title'      => 'varchar(300) NOT NULL COMMENT \'标题\'',
            'gather_time'       => 'int NOT NULL COMMENT \'记录时间\'',
            'gather_time_show'  => 'int NOT NULL COMMENT \'显示时间\'',
            'gather_content'    => 'text NOT NULL COMMENT \'内容\'',
            'gather_source'     => 'varchar(300) NOT NULL COMMENT \'来源\'',
            'gather_source_url' => 'varchar(900) NOT NULL COMMENT \'来源 URL\'',
            'gather_author'     => 'varchar(300) NOT NULL COMMENT \'作者\'',
            'gather_cate_id'    => 'smallint NOT NULL COMMENT \'栏目 ID\'',
            'gather_article_id' => 'int NOT NULL COMMENT \'已审核文章 ID\'',
            'gather_admin_id'   => 'int NOT NULL COMMENT \'发布用户 ID\'',
            'gather_gsite_id'   => 'int NOT NULL COMMENT \'隶属采集点 ID\'',
        );

        $_num_db = $this->obj_db->create_table(BG_DB_TABLE . 'gather', $_arr_gatherCreat, 'gather_id', '采集');

        if ($_num_db < 1) {
            $_str_rcode = 'x280105';
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
        );
    }



    /** 列出字段
     * mdl_column function.
     *
     * @access public
     * @return void
     */
    function mdl_column() {
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . 'gather');

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

        if (in_array('gather_auther', $_arr_col)) {
            $_arr_alter['gather_auther'] = array('CHANGE', 'varchar(300) NOT NULL COMMENT \'作者\'', 'gather_author');
        }

        $_str_rcode = 'y280111';

        if (!fn_isEmpty($_arr_alter)) {
            $_reselt = $this->obj_db->alter_table(BG_DB_TABLE . 'gather', $_arr_alter);

            if (!fn_isEmpty($_reselt)) {
                $_str_rcode = 'y280106';
            }
        }

        return array(
            'rcode' => $_str_rcode,
        );
    }


    function mdl_store($num_gatherId, $num_articleId) {
        $_arr_gatherData = array(
            'gather_article_id' => $num_articleId,
        );

        $_num_db = $this->obj_db->update(BG_DB_TABLE . 'gather', $_arr_gatherData, '`gather_id`=' . $num_gatherId); //插入数据

        if ($_num_db > 0) { //数据库插入是否成功
            $_str_rcode = 'y280103';
        } else {
            return array(
                'rcode' => 'x280103',
            );
        }

        /*print_r($_arr_userRow);
        exit;*/

        return array(
            'gather_id' => $num_gatherId,
            'rcode'     => $_str_rcode,
        );
    }


    /** 提交
     * mdl_submit function.
     *
     * @access public
     * @param int $num_adminId (default: 0)
     * @param mixed $str_status
     * @return void
     */
    function mdl_submit($arr_gatherSubmit) {
        $_arr_gatherData = array(
            'gather_title'      => fn_getSafe($arr_gatherSubmit['gather_title'], 'txt', ''),
            'gather_time'       => time(),
            'gather_time_show'  => fn_strtotime($arr_gatherSubmit['gather_time_show']),
            'gather_content'    => fn_htmlcode(fn_safe($arr_gatherSubmit['gather_content']), 'decode'),
            'gather_source'     => fn_getSafe($arr_gatherSubmit['gather_source'], 'txt', ''),
            'gather_source_url' => fn_getSafe($arr_gatherSubmit['gather_source_url'], 'txt', ''),
            'gather_author'     => fn_getSafe($arr_gatherSubmit['gather_author'], 'txt', ''),
            'gather_cate_id'    => fn_getSafe($arr_gatherSubmit['gather_cate_id'], 'int', 0),
            'gather_gsite_id'   => fn_getSafe($arr_gatherSubmit['gather_gsite_id'], 'int', 0),
            'gather_admin_id'   => fn_getSafe($arr_gatherSubmit['gather_admin_id'], 'int', 0),
        );

        if (!$this->is_magic) {
            $_arr_gatherData['gather_content'] = addslashes($_arr_gatherData['gather_content']);
        }

        //print_r($_arr_gatherData);

        $_num_gatherId = $this->obj_db->insert(BG_DB_TABLE . 'gather', $_arr_gatherData); //插入数据

        if ($_num_gatherId > 0) { //数据库插入是否成功
            $_str_rcode = 'y280101';
        } else {
            return array(
                'rcode' => 'x280101',
            );
        }

        /*print_r($_arr_userRow);
        exit;*/

        return array(
            'gather_id' => $_num_gatherId,
            'rcode'     => $_str_rcode,
        );
    }


    /** 列出
     * mdl_list function.
     *
     * @access public
     * @param mixed $num_no
     * @param int $num_except (default: 0)
     * @param array $arr_search (default: array())
     * @return void
     */
    function mdl_list($num_no, $num_except = 0, $arr_search = array(), $str_order = 'DESC') {
        $_arr_gatherSelect = array(
            'gather_id',
            'gather_title',
            'gather_time',
            'gather_time_show',
            'gather_source',
            'gather_source_url',
            'gather_admin_id',
            'gather_article_id',
            'gather_cate_id',
            'gather_gsite_id',
        );

        $_str_sqlWhere = $this->sql_process($arr_search);

        $_arr_order = array(
            array('gather_id', $str_order),
        );

        $_arr_gatherRows = $this->obj_db->select(BG_DB_TABLE . 'gather', $_arr_gatherSelect, $_str_sqlWhere, '', $_arr_order, $num_no, $num_except);

        foreach ($_arr_gatherRows as $_key=>$_value) {
            $_arr_gatherRows[$_key]['gather_source_url'] = fn_htmlcode(fn_safe(fn_htmlcode($_value['gather_source_url'], 'decode', 'url')), 'decode', 'url');
        }

        return $_arr_gatherRows;
    }


    /** 统计
     * mdl_count function.
     *
     * @access public
     * @param array $arr_search (default: array())
     * @return void
     */
    function mdl_count($arr_search = array()) {
        $_str_sqlWhere = $this->sql_process($arr_search);

        $_num_gatherCount = $this->obj_db->count(BG_DB_TABLE . 'gather', $_str_sqlWhere); //查询数据

        return $_num_gatherCount;
    }


    /** 读取
     * mdl_read function.
     *
     * @access public
     * @param mixed $num_gatherId
     * @return void
     */
    function mdl_read($str_gather, $str_readBy = 'gather_id') {
        $_arr_gatherSelect = array(
            'gather_id',
            'gather_title',
            'gather_time',
            'gather_time_show',
            'gather_content',
            'gather_source',
            'gather_source_url',
            'gather_author',
            'gather_admin_id',
            'gather_article_id',
            'gather_cate_id',
            'gather_gsite_id',
        );

        if (is_numeric($str_gather)) {
            $_str_sqlWhere = '`' . $str_readBy . '`=' . $str_gather;
        } else {
            $_str_sqlWhere = '`' . $str_readBy . '`=\'' . $str_gather . '\'';
        }

        $_arr_gatherRows = $this->obj_db->select(BG_DB_TABLE . 'gather', $_arr_gatherSelect, $_str_sqlWhere, '', '', 1, 0); //读取数据

        if (isset($_arr_gatherRows[0])) {
            $_arr_gatherRow = $_arr_gatherRows[0];
        } else {
            return array(
                'rcode' => 'x280102',
            );
        }

        $_arr_gatherRow['gather_source_url']    = fn_htmlcode($_arr_gatherRow['gather_source_url'], 'decode', 'url');
        $_arr_gatherRow['gather_source_url']    = fn_safe($_arr_gatherRow['gather_source_url']);
        $_arr_gatherRow['gather_source_url']    = fn_htmlcode($_arr_gatherRow['gather_source_url'], 'decode', 'url');

        $_arr_gatherRow['rcode']                = 'y280102';

        return $_arr_gatherRow;
    }





    /** 删除
     * mdl_del function.
     *
     * @access public
     * @param bool $arr_cateIds (default: false)
     * @param int $num_adminId (default: 0)
     * @return void
     */
    function mdl_del($arr_cateIds = false, $num_adminId = 0) {

        $_str_gatherId   = implode(',', $this->gatherIds['gather_ids']);
        $_str_sqlWhere    = '`gather_id` IN (' . $_str_gatherId . ')';

        if (!fn_isEmpty($arr_cateIds)) {
            $_str_cateIds    = implode(',', $arr_cateIds);
            $_str_sqlWhere   .= ' AND `gather_cate_id` IN (' . $_str_cateIds . ')';
        }

        if ($num_adminId > 0) {
            $_str_sqlWhere .= ' AND `gather_admin_id`=' . $num_adminId;
        }

        $_num_db = $this->obj_db->delete(BG_DB_TABLE . 'gather', $_str_sqlWhere); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_db > 0) {
            $_str_rcode = 'y280104';
        } else {
            $_str_rcode = 'x280104';
        }

        return array(
            'rcode' => $_str_rcode,
        ); //成功
    }



    /** 列出不重复的年份
     * mdl_year function.
     *
     * @access public
     * @return void
     */
    function mdl_year() {
        $_arr_gatherSelect = array(
            'DISTINCT FROM_UNIXTIME(`gather_time_show`, \'%Y\') AS `gather_year`',
        );

        $_str_sqlWhere = '`gather_time_show`>0';

        $_arr_order = array(
            array('gather_time', 'ASC'),
        );

        $_arr_gatherRows = $this->obj_db->select(BG_DB_TABLE . 'gather', $_arr_gatherSelect, $_str_sqlWhere, '', $_arr_order, 100, 0, true);

        return $_arr_gatherRows;
    }


    /** 批量操作选择
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

        $_arr_gatherIds = fn_post('gather_ids');

        if (fn_isEmpty($_arr_gatherIds)) {
            $_str_rcode = 'x030202';
        } else {
            foreach ($_arr_gatherIds as $_key=>$_value) {
                $_arr_gatherIds[$_key] = fn_getSafe($_value, 'int', 0);
            }
            $_str_rcode = 'ok';
        }

        $this->gatherIds = array(
            'rcode'         => $_str_rcode,
            'gather_ids'    => array_filter(array_unique($_arr_gatherIds)),
        );

        return $this->gatherIds;
    }


    /** 列出及统计 SQL 处理
     * sql_process function.
     *
     * @access private
     * @param array $arr_search (default: array())
     * @return void
     */
    private function sql_process($arr_search = array()) {
        $_str_sqlWhere = '1';

        if (isset($arr_search['key']) && !fn_isEmpty($arr_search['key'])) {
            $_str_sqlWhere .= ' AND (`gather_title` LIKE \'%' . $arr_search['key'] . '%\' OR `gather_source` LIKE \'%' . $arr_search['key'] . '%\')';
        }

        if (isset($arr_search['year']) && !fn_isEmpty($arr_search['year'])) {
            $_str_sqlWhere .= ' AND FROM_UNIXTIME(`gather_time_show`, \'%Y\')=\'' . $arr_search['year'] . '\'';
        }

        if (isset($arr_search['month']) && !fn_isEmpty($arr_search['month'])) {
            $_str_sqlWhere .= ' AND FROM_UNIXTIME(`gather_time_show`, \'%m\')=\'' . $arr_search['month'] . '\'';
        }

        if (isset($arr_search['cate_id']) && $arr_search['cate_id'] > 0) {
            $_str_sqlWhere .= ' AND `gather_cate_id`=' . $arr_search['cate_id'];
        }

        if (isset($arr_search['gsite_id']) && $arr_search['gsite_id'] > 0) {
            $_str_sqlWhere .= ' AND `gather_gsite_id`=' . $arr_search['gsite_id'];
        }

        if (isset($arr_search['wait'])) {
            $_str_sqlWhere .= ' AND `gather_article_id`=0';
        }

        if (isset($arr_search['admin_id']) && $arr_search['admin_id'] > 0) {
            $_str_sqlWhere .= ' AND `gather_admin_id`=' . $arr_search['admin_id'];
        }

        if (isset($arr_search['gather_ids']) && !fn_isEmpty($arr_search['gather_ids'])) {
            $_str_gatherIds = implode(',', $arr_search['gather_ids']);
            $_str_sqlWhere .= ' AND `gather_id` IN (' . $_str_gatherIds . ')';
        }

        if (isset($arr_search['not_ids']) && !fn_isEmpty($arr_search['not_ids'])) {
            $_str_notIds = implode(',', $arr_search['not_ids']);
            $_str_sqlWhere .= ' AND `gather_id` NOT IN (' . $_str_notIds . ')';
        }

        return $_str_sqlWhere;
    }
}
