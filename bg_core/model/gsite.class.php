<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------采集点模型-------------*/
class MODEL_GSITE {

    public $obj_db;
    public $arr_status = array('enable', 'disable');
    public $keepTag    = array( //保留标签
        'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'p', 'div',
        'mark', 'del', 's', 'ins', 'u', 'em', 'i', 'small', 'strong', 'b',
        'abbr', 'address', 'span',
        'blockquote', 'br',
        'ul', 'ol', 'li',
        'dl', 'dt', 'dd',
        'code', 'var', 'samp',
        'img',
        'table', 'thead', 'tbody', 'tfoot', 'tr', 'th', 'td',
    );

    public $keepAttr = array(
        'img' => array(
            'src'
        ),
        'a' => array(
            'href',
            'target',
        ),
    );

    function __construct() { //构造函数
        $this->obj_db = $GLOBALS['obj_db']; //设置数据库对象
    }


    function mdl_create_table() {
        $_str_status = implode('\',\'', $this->arr_status);

        $_arr_gsiteCreat = array(
            'gsite_id'                      => 'smallint NOT NULL AUTO_INCREMENT COMMENT \'ID\'',
            'gsite_name'                    => 'varchar(300) NOT NULL COMMENT \'采集点\'',
            'gsite_url'                     => 'varchar(900) NOT NULL COMMENT \'目标 URL\'',
            'gsite_status'                  => 'enum(\'' . $_str_status . '\') NOT NULL COMMENT \'状态\'',
            'gsite_keep_tag'                => 'varchar(300) NOT NULL COMMENT \'保留标签\'',
            'gsite_note'                    => 'varchar(30) NOT NULL COMMENT \'备注\'',
            'gsite_charset'                 => 'varchar(100) NOT NULL COMMENT \'字符编码\'',
            'gsite_cate_id'                 => 'smallint NOT NULL COMMENT \'隶属于栏目\'',
            'gsite_list_selector'           => 'varchar(100) NOT NULL COMMENT \'列表选择器\'',
            'gsite_title_selector'          => 'varchar(100) NOT NULL COMMENT \'标题选择器\'',
            'gsite_title_attr'              => 'varchar(100) NOT NULL COMMENT \'标题属性\'',
            'gsite_title_filter'            => 'varchar(100) NOT NULL COMMENT \'标题过滤器\'',
            'gsite_title_replace'           => 'text NOT NULL COMMENT \'标题替换\'',
            'gsite_content_selector'        => 'varchar(100) NOT NULL COMMENT \'内容选择器\'',
            'gsite_content_attr'            => 'varchar(100) NOT NULL COMMENT \'内容属性\'',
            'gsite_content_filter'          => 'varchar(100) NOT NULL COMMENT \'内容过滤器\'',
            'gsite_content_replace'         => 'text NOT NULL COMMENT \'内容替换\'',
            'gsite_time_selector'           => 'varchar(100) NOT NULL COMMENT \'时间选择器\'',
            'gsite_time_attr'               => 'varchar(100) NOT NULL COMMENT \'时间属性\'',
            'gsite_time_filter'             => 'varchar(100) NOT NULL COMMENT \'时间过滤器\'',
            'gsite_time_replace'            => 'text NOT NULL COMMENT \'时间替换\'',
            'gsite_source_selector'         => 'varchar(100) NOT NULL COMMENT \'文章来源选择器\'',
            'gsite_source_attr'             => 'varchar(100) NOT NULL COMMENT \'文章来源属性\'',
            'gsite_source_filter'           => 'varchar(100) NOT NULL COMMENT \'文章来源过滤器\'',
            'gsite_source_replace'          => 'text NOT NULL COMMENT \'文章来源替换\'',
            'gsite_author_selector'         => 'varchar(100) NOT NULL COMMENT \'作者选择器\'',
            'gsite_author_attr'             => 'varchar(100) NOT NULL COMMENT \'作者属性\'',
            'gsite_author_filter'           => 'varchar(100) NOT NULL COMMENT \'作者过滤器\'',
            'gsite_author_replace'          => 'text NOT NULL COMMENT \'作者替换\'',
            'gsite_page_list_selector'      => 'varchar(100) NOT NULL COMMENT \'分页链接选择器\'',
            'gsite_page_content_selector'   => 'varchar(100) NOT NULL COMMENT \'分页内容选择器\'',
            'gsite_page_content_attr'       => 'varchar(100) NOT NULL COMMENT \'分页内容属性\'',
            'gsite_page_content_filter'     => 'varchar(100) NOT NULL COMMENT \'分页内容过滤器\'',
            'gsite_page_content_replace'    => 'text NOT NULL COMMENT \'分页内容替换\'',
            //'gsite_img_attr'                => 'varchar(100) NOT NULL COMMENT \'图片地址属性\'',
            'gsite_img_filter'              => 'varchar(100) NOT NULL COMMENT \'图片过滤器\'',
            'gsite_attr_allow'              => 'varchar(100) NOT NULL COMMENT \'允许的属性\'',
            'gsite_ignore_tag'              => 'varchar(300) NOT NULL COMMENT \'忽略标签\'',
            'gsite_attr_except'             => 'text NOT NULL COMMENT \'例外\'',
        );

        $_num_db = $this->obj_db->create_table(BG_DB_TABLE . 'gsite', $_arr_gsiteCreat, 'gsite_id', '采集点');

        if ($_num_db > 0) {
            $_str_rcode = 'y270105'; //更新成功
        } else {
            $_str_rcode = 'x270105'; //更新成功
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
        );
    }


    function mdl_column() {
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . 'gsite');

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

        if (in_array('gsite_auther_selector', $_arr_col)) {
            $_arr_alter['gsite_auther_selector'] = array('CHANGE', 'varchar(100) NOT NULL COMMENT \'作者选择器\'', 'gsite_author_selector');
        }

        if (!in_array('gsite_keep_tag', $_arr_col)) {
            $_arr_alter['gsite_keep_tag'] = array('ADD', 'varchar(300) NOT NULL COMMENT \'保留标签\'');
        }

        if (!in_array('gsite_title_attr', $_arr_col)) {
            $_arr_alter['gsite_title_attr'] = array('ADD', 'varchar(100) NOT NULL COMMENT \'标题属性\'');
        }

        if (!in_array('gsite_title_filter', $_arr_col)) {
            $_arr_alter['gsite_title_filter'] = array('ADD', 'varchar(100) NOT NULL COMMENT \'标题过滤器\'');
        }

        if (!in_array('gsite_title_replace', $_arr_col)) {
            $_arr_alter['gsite_title_replace'] = array('ADD', 'text NOT NULL COMMENT \'标题替换\'');
        }

        if (!in_array('gsite_content_attr', $_arr_col)) {
            $_arr_alter['gsite_content_attr'] = array('ADD', 'varchar(100) NOT NULL COMMENT \'内容属性\'');
        }

        if (!in_array('gsite_content_filter', $_arr_col)) {
            $_arr_alter['gsite_content_filter'] = array('ADD', 'varchar(100) NOT NULL COMMENT \'内容过滤器\'');
        }

        if (!in_array('gsite_content_replace', $_arr_col)) {
            $_arr_alter['gsite_content_replace'] = array('ADD', 'text NOT NULL COMMENT \'内容替换\'');
        }

        if (!in_array('gsite_time_attr', $_arr_col)) {
            $_arr_alter['gsite_time_attr'] = array('ADD', 'varchar(100) NOT NULL COMMENT \'时间属性\'');
        }

        if (!in_array('gsite_time_filter', $_arr_col)) {
            $_arr_alter['gsite_time_filter'] = array('ADD', 'varchar(100) NOT NULL COMMENT \'时间过滤器\'');
        }

        if (!in_array('gsite_time_replace', $_arr_col)) {
            $_arr_alter['gsite_time_replace'] = array('ADD', 'text NOT NULL COMMENT \'时间替换\'');
        }

        if (!in_array('gsite_source_attr', $_arr_col)) {
            $_arr_alter['gsite_source_attr'] = array('ADD', 'varchar(100) NOT NULL COMMENT \'来源属性\'');
        }

        if (!in_array('gsite_source_filter', $_arr_col)) {
            $_arr_alter['gsite_source_filter'] = array('ADD', 'varchar(100) NOT NULL COMMENT \'来源过滤器\'');
        }

        if (!in_array('gsite_source_replace', $_arr_col)) {
            $_arr_alter['gsite_source_replace'] = array('ADD', 'text NOT NULL COMMENT \'来源替换\'');
        }

        if (!in_array('gsite_author_attr', $_arr_col)) {
            $_arr_alter['gsite_author_attr'] = array('ADD', 'varchar(100) NOT NULL COMMENT \'来源属性\'');
        }

        if (!in_array('gsite_author_filter', $_arr_col)) {
            $_arr_alter['gsite_author_filter'] = array('ADD', 'varchar(100) NOT NULL COMMENT \'来源过滤器\'');
        }

        if (!in_array('gsite_author_replace', $_arr_col)) {
            $_arr_alter['gsite_author_replace'] = array('ADD', 'text NOT NULL COMMENT \'来源替换\'');
        }

        if (!in_array('gsite_page_content_attr', $_arr_col)) {
            $_arr_alter['gsite_page_content_attr'] = array('ADD', 'varchar(100) NOT NULL COMMENT \'分页内容属性\'');
        }

        if (!in_array('gsite_page_content_filter', $_arr_col)) {
            $_arr_alter['gsite_page_content_filter'] = array('ADD', 'varchar(100) NOT NULL COMMENT \'分页内容过滤器\'');
        }

        if (!in_array('gsite_page_content_replace', $_arr_col)) {
            $_arr_alter['gsite_page_content_replace'] = array('ADD', 'text NOT NULL COMMENT \'分页内容替换\'');
        }

        if (!in_array('gsite_attr_allow', $_arr_col)) {
            $_arr_alter['gsite_attr_allow'] = array('ADD', 'varchar(100) NOT NULL COMMENT \'允许的属性\'');
        }

        if (!in_array('gsite_ignore_tag', $_arr_col)) {
            $_arr_alter['gsite_ignore_tag'] = array('ADD', 'varchar(300) NOT NULL COMMENT \'忽略标签\'');
        }

        if (!in_array('gsite_attr_except', $_arr_col)) {
            $_arr_alter['gsite_attr_except'] = array('ADD', 'text NOT NULL COMMENT \'例外\'');
        }

        if (!in_array('gsite_img_filter', $_arr_col)) {
            $_arr_alter['gsite_img_filter'] = array('ADD', 'varchar(100) NOT NULL COMMENT \'图片过滤器\'');
        }

        $_str_rcode = 'y270111';

        if (!fn_isEmpty($_arr_alter)) {
            $_reselt = $this->obj_db->alter_table(BG_DB_TABLE . 'gsite', $_arr_alter);

            if (!fn_isEmpty($_reselt)) {
                $_str_rcode = 'y270106';
            }
        }

        return array(
            'rcode' => $_str_rcode,
        );
    }


    function mdl_duplicate() {

        $_arr_gsiteData = array(
            'gsite_name',
            'gsite_url',
            'gsite_status',
            'gsite_keep_tag',
            'gsite_note',
            'gsite_cate_id',
            'gsite_charset',
            'gsite_list_selector',
            'gsite_title_selector',
            'gsite_title_attr',
            'gsite_title_filter',
            'gsite_title_replace',
            'gsite_content_selector',
            'gsite_content_attr',
            'gsite_content_filter',
            'gsite_content_replace',
            'gsite_time_selector',
            'gsite_time_attr',
            'gsite_time_filter',
            'gsite_time_replace',
            'gsite_source_selector',
            'gsite_source_attr',
            'gsite_source_filter',
            'gsite_source_replace',
            'gsite_author_selector',
            'gsite_author_attr',
            'gsite_author_filter',
            'gsite_author_replace',
            'gsite_page_list_selector',
            'gsite_page_content_selector',
            'gsite_page_content_attr',
            'gsite_page_content_filter',
            'gsite_page_content_replace',
            //'gsite_img_attr',
            'gsite_img_filter',
            'gsite_attr_allow',
            'gsite_ignore_tag',
            'gsite_attr_except',
        );

        $_num_gsiteId = $this->obj_db->duplicate(BG_DB_TABLE . 'gsite', $_arr_gsiteData, BG_DB_TABLE . 'gsite', $_arr_gsiteData, '`gsite_id`=' . $this->gsiteDuplicate['gsite_id']);

        if ($_num_gsiteId > 0) { //数据库更新是否成功
            $_str_rcode = 'y270112';
        } else {
            return array(
                'gsite_id'  => $_num_gsiteId,
                'rcode'     => 'x270112',
            );
        }

        return array(
            'gsite_id'  => $_num_gsiteId,
            'rcode'     => $_str_rcode,
        );
    }


    /**
     * mdl_submit function.
     *
     * @access public
     * @param mixed $num_gsiteId
     * @param mixed $str_gsiteName
     * @param mixed $str_gsiteType
     * @param string $str_gsiteNote (default: '')
     * @param string $str_gsiteAllow (default: '')
     * @return void
     */
    function mdl_submit() {

        $_arr_gsiteData = array(
            'gsite_name'    => $this->gsiteInput['gsite_name'],
            'gsite_url'     => $this->gsiteInput['gsite_url'],
            'gsite_status'  => $this->gsiteInput['gsite_status'],
            'gsite_note'    => $this->gsiteInput['gsite_note'],
            'gsite_cate_id' => $this->gsiteInput['gsite_cate_id'],
            'gsite_charset' => strtoupper($this->gsiteInput['gsite_charset']),
        );

        if ($this->gsiteInput['gsite_id'] < 1) { //插入
            $_num_gsiteId = $this->obj_db->insert(BG_DB_TABLE . 'gsite', $_arr_gsiteData);

            if ($_num_gsiteId > 0) { //数据库插入是否成功
                $_str_rcode = 'y270101';
            } else {
                return array(
                    'gsite_id'  => $_num_gsiteId,
                    'rcode'     => 'x270101',
                );
            }
        } else {
            $_num_gsiteId    = $this->gsiteInput['gsite_id'];
            $_num_db      = $this->obj_db->update(BG_DB_TABLE . 'gsite', $_arr_gsiteData, '`gsite_id`=' . $_num_gsiteId);

            if ($_num_db > 0) { //数据库更新是否成功
                $_str_rcode = 'y270103';
            } else {
                return array(
                    'gsite_id'  => $_num_gsiteId,
                    'rcode'     => 'x270103',
                );
            }
        }

        return array(
            'gsite_id'  => $_num_gsiteId,
            'rcode'     => $_str_rcode,
        );
    }


    /**
     * mdl_read function.
     *
     * @access public
     * @param mixed $str_gsite
     * @param string $str_readBy (default: 'gsite_id')
     * @param int $num_notId (default: 0)
     * @return void
     */
    function mdl_read($str_gsite, $str_readBy = 'gsite_id', $is_min = false) {

        $_arr_gsiteSelect = array(
            'gsite_id',
            'gsite_name',
            'gsite_url',
            'gsite_status',
            'gsite_keep_tag',
            'gsite_note',
            'gsite_cate_id',
            'gsite_charset',
            'gsite_list_selector',
            'gsite_title_selector',
            'gsite_title_attr',
            'gsite_title_filter',
            'gsite_title_replace',
            'gsite_content_selector',
            'gsite_content_attr',
            'gsite_content_filter',
            'gsite_content_replace',
            'gsite_time_selector',
            'gsite_time_attr',
            'gsite_time_filter',
            'gsite_time_replace',
            'gsite_source_selector',
            'gsite_source_attr',
            'gsite_source_filter',
            'gsite_source_replace',
            'gsite_author_selector',
            'gsite_author_attr',
            'gsite_author_filter',
            'gsite_author_replace',
            'gsite_page_list_selector',
            'gsite_page_content_selector',
            'gsite_page_content_attr',
            'gsite_page_content_filter',
            'gsite_page_content_replace',
            //'gsite_img_attr',
            'gsite_img_filter',
            'gsite_attr_allow',
            'gsite_ignore_tag',
            'gsite_attr_except',
        );

        if ($is_min) {
            $_str_sqlWhere = '`' . $str_readBy . '`>' . $str_gsite;
        } else {
            if (is_numeric($str_gsite)) {
                $_str_sqlWhere = '`' . $str_readBy . '`=' . $str_gsite;
            } else {
                $_str_sqlWhere = '`' . $str_readBy . '`=\'' . $str_gsite . '\'';
            }
        }

        $_arr_gsiteRows = $this->obj_db->select(BG_DB_TABLE . 'gsite',  $_arr_gsiteSelect, $_str_sqlWhere, '', '', 1, 0); //检查本地表是否存在记录

        if (isset($_arr_gsiteRows[0])) {
            $_arr_gsiteRow = $_arr_gsiteRows[0];
        } else {
            return array(
                'rcode' => 'x270102', //不存在记录
            );
        }

        $_arr_gsiteRow['gsite_title_attr']              = strtolower($_arr_gsiteRow['gsite_title_attr']);
        $_arr_gsiteRow['gsite_content_attr']            = strtolower($_arr_gsiteRow['gsite_content_attr']);
        $_arr_gsiteRow['gsite_time_attr']               = strtolower($_arr_gsiteRow['gsite_time_attr']);
        $_arr_gsiteRow['gsite_source_attr']             = strtolower($_arr_gsiteRow['gsite_source_attr']);
        $_arr_gsiteRow['gsite_author_attr']             = strtolower($_arr_gsiteRow['gsite_author_attr']);
        $_arr_gsiteRow['gsite_page_content_attr']       = strtolower($_arr_gsiteRow['gsite_page_content_attr']);
        //$_arr_gsiteRow['gsite_img_attr']                = strtolower($_arr_gsiteRow['gsite_img_attr']);
        $_arr_gsiteRow['gsite_img_filter']              = strtolower($_arr_gsiteRow['gsite_img_filter']);

        $_arr_gsiteRow['gsite_attr_allow']              = strtolower($_arr_gsiteRow['gsite_attr_allow']);
        //$_arr_gsiteRow['gsite_attr_allow']              = strtolower($_arr_gsiteRow['gsite_attr_allow']);

        $_arr_gsiteRow['gsite_charset']                 = strtoupper($_arr_gsiteRow['gsite_charset']);

        $_arr_gsiteRow['gsite_attr_except']             = fn_jsonDecode($_arr_gsiteRow['gsite_attr_except'], 'no');

        $_arr_gsiteRow['gsite_title_replace']           = fn_jsonDecode($_arr_gsiteRow['gsite_title_replace'], 'decode');
        $_arr_gsiteRow['gsite_content_replace']         = fn_jsonDecode($_arr_gsiteRow['gsite_content_replace'], 'decode');
        $_arr_gsiteRow['gsite_time_replace']            = fn_jsonDecode($_arr_gsiteRow['gsite_time_replace'], 'decode');
        $_arr_gsiteRow['gsite_source_replace']          = fn_jsonDecode($_arr_gsiteRow['gsite_source_replace'], 'decode');
        $_arr_gsiteRow['gsite_author_replace']          = fn_jsonDecode($_arr_gsiteRow['gsite_author_replace'], 'decode');
        $_arr_gsiteRow['gsite_page_content_replace']    = fn_jsonDecode($_arr_gsiteRow['gsite_page_content_replace'], 'decode');

        $_arr_gsiteRow['rcode']                         = 'y270102';

        return $_arr_gsiteRow;
    }


    function mdl_status($str_status) {

        $_str_gsiteId = implode(',', $this->gsiteIds['gsite_ids']);

        $_arr_gsiteUpdate = array(
            'gsite_status' => $str_status,
        );

        $_num_db = $this->obj_db->update(BG_DB_TABLE . 'gsite', $_arr_gsiteUpdate, '`gsite_id` IN (' . $_str_gsiteId . ')'); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_db > 0) {
            $_str_rcode = 'y270103';
        } else {
            $_str_rcode = 'x270103';
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
     * @return void
     */
    function mdl_list($num_no, $num_except = 0, $arr_search = array()) {

        $_arr_gsiteSelect = array(
            'gsite_id',
            'gsite_name',
            'gsite_note',
            'gsite_status',
            'gsite_cate_id',
        );

        $_str_sqlWhere = $this->sql_process($arr_search);

        $_arr_order = array(
            array('gsite_id', 'DESC'),
        );

        $_arr_gsiteRows = $this->obj_db->select(BG_DB_TABLE . 'gsite',  $_arr_gsiteSelect, $_str_sqlWhere, '', $_arr_order, $num_no, $num_except); //列出本地表是否存在记录

        return $_arr_gsiteRows;

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

        $_num_count = $this->obj_db->count(BG_DB_TABLE . 'gsite', $_str_sqlWhere); //查询数据

        return $_num_count;
    }


    /**
     * mdl_del function.
     *
     * @access public
     * @param mixed $this->gsiteIds['gsite_ids']
     * @return void
     */
    function mdl_del() {

        $_str_gsiteId = implode(',', $this->gsiteIds['gsite_ids']);

        $_num_db = $this->obj_db->delete(BG_DB_TABLE . 'gsite',  '`gsite_id` IN (' . $_str_gsiteId . ')'); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_db > 0) {
            $_str_rcode = 'y270104';
        } else {
            $_str_rcode = 'x270104';
        }

        return array(
            'rcode' => $_str_rcode,
        );

    }


    function input_duplicate() {
        if (!fn_token('chk')) { //令牌
            return array(
                'rcode' => 'x030206',
            );
        }

        $this->gsiteDuplicate['gsite_id'] = fn_getSafe(fn_post('gsite_id'), 'int', 0);

        if ($this->gsiteDuplicate['gsite_id'] < 1) {
            return array(
                'rcode' => 'x270213',
            );
        }

        $_arr_gsiteRow = $this->mdl_read($this->gsiteDuplicate['gsite_id']);
        if ($_arr_gsiteRow['rcode'] != 'y270102') {
            return $_arr_gsiteRow;
        }

        $this->gsiteDuplicate['rcode']   = 'ok';

        return $this->gsiteDuplicate;
    }


    function input_submit() {
        if (!fn_token('chk')) { //令牌
            return array(
                'rcode' => 'x030206',
            );
        }

        $this->gsiteInput['gsite_id'] = fn_getSafe(fn_post('gsite_id'), 'int', 0);

        if ($this->gsiteInput['gsite_id'] > 0) {
            $_arr_gsiteRow = $this->mdl_read($this->gsiteInput['gsite_id']);
            if ($_arr_gsiteRow['rcode'] != 'y270102') {
                return $_arr_gsiteRow;
            }
        }

        $_arr_gsiteName = fn_validate(fn_post('gsite_name'), 1, 300);
        switch ($_arr_gsiteName['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x270201',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x270202',
                );
            break;

            case 'ok':
                $this->gsiteInput['gsite_name'] = $_arr_gsiteName['str'];
            break;

        }

        $_arr_gsiteUrl = fn_validate(fn_post('gsite_url'), 1, 900, 'str', 'url');
        switch ($_arr_gsiteUrl['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x270203',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x270204',
                );
            break;

            case 'format_err':
                return array(
                    'rcode' => 'x270210',
                );
            break;

            case 'ok':
                $this->gsiteInput['gsite_url'] = $_arr_gsiteUrl['str'];
            break;
        }

        $_arr_gsiteCateId = fn_validate(fn_post('gsite_cate_id'), 1, 0, 'str', 'int');
        switch ($_arr_gsiteCateId['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x270206',
                );
            break;

            case 'format_err':
                return array(
                    'rcode' => 'x270207',
                );
            break;

            case 'ok':
                $this->gsiteInput['gsite_cate_id'] = $_arr_gsiteCateId['str'];
            break;
        }

        $_arr_gsiteStatus = fn_validate(fn_post('gsite_status'), 1, 0);
        switch ($_arr_gsiteStatus['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x270208',
                );
            break;

            case 'ok':
                $this->gsiteInput['gsite_status'] = $_arr_gsiteStatus['str'];
            break;
        }

        $_arr_gsiteNote = fn_validate(fn_post('gsite_note'), 0, 30);
        switch ($_arr_gsiteNote['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x270209',
                );
            break;

            case 'ok':
                $this->gsiteInput['gsite_note'] = $_arr_gsiteNote['str'];
            break;
        }

        $_arr_gsiteCharset = fn_validate(fn_post('gsite_charset'), 1, 100);
        switch ($_arr_gsiteCharset['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x270211',
                );
            break;

            case 'ok':
                $this->gsiteInput['gsite_charset'] = $_arr_gsiteCharset['str'];
            break;
        }

        $this->gsiteInput['rcode']   = 'ok';

        return $this->gsiteInput;
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

        $_arr_gsiteIds = fn_post('gsite_ids');

        if (fn_isEmpty($_arr_gsiteIds)) {
            $_str_rcode = 'x030202';
        } else {
            foreach ($_arr_gsiteIds as $_key=>$_value) {
                $_arr_gsiteIds[$_key] = fn_getSafe($_value, 'int', 0);
            }
            $_str_rcode = 'ok';
        }

        $this->gsiteIds = array(
            'rcode'     => $_str_rcode,
            'gsite_ids' => array_filter(array_unique($_arr_gsiteIds)),
        );

        return $this->gsiteIds;
    }

    function selector_process($arr_gsiteRow) {
        $arr_gsiteRow['gsite_url']      = fn_htmlcode($arr_gsiteRow['gsite_url'], 'decode', 'url');
        $arr_gsiteRow['gsite_charset']  = strtoupper(fn_htmlcode($arr_gsiteRow['gsite_charset'], 'decode', 'url'));

        if (!fn_isEmpty($arr_gsiteRow['gsite_list_selector'])) {
            $arr_gsiteRow['gsite_list_selector']            = fn_htmlcode($arr_gsiteRow['gsite_list_selector'], 'decode', 'selector');
        }
        if (!fn_isEmpty($arr_gsiteRow['gsite_title_selector'])) {
            $arr_gsiteRow['gsite_title_selector']           = fn_htmlcode($arr_gsiteRow['gsite_title_selector'], 'decode', 'selector');
        }
        if (!fn_isEmpty($arr_gsiteRow['gsite_title_attr'])) {
            $arr_gsiteRow['gsite_title_attr']               = fn_htmlcode($arr_gsiteRow['gsite_title_attr'], 'decode', 'selector');
        } else {
            $arr_gsiteRow['gsite_title_attr']               = 'html';
        }
        if (!fn_isEmpty($arr_gsiteRow['gsite_title_filter'])) {
            $arr_gsiteRow['gsite_title_filter']             = fn_htmlcode($arr_gsiteRow['gsite_title_filter'], 'decode', 'selector');
        }
        if (!fn_isEmpty($arr_gsiteRow['gsite_content_selector'])) {
            $arr_gsiteRow['gsite_content_selector']         = fn_htmlcode($arr_gsiteRow['gsite_content_selector'], 'decode', 'selector');
        }
        if (!fn_isEmpty($arr_gsiteRow['gsite_content_attr'])) {
            $arr_gsiteRow['gsite_content_attr']             = fn_htmlcode($arr_gsiteRow['gsite_content_attr'], 'decode', 'selector');
        } else {
            $arr_gsiteRow['gsite_content_attr']             = 'html';
        }
        if (!fn_isEmpty($arr_gsiteRow['gsite_content_filter'])) {
            $arr_gsiteRow['gsite_content_filter']           = fn_htmlcode($arr_gsiteRow['gsite_content_filter'], 'decode', 'selector');
        }
        if (!fn_isEmpty($arr_gsiteRow['gsite_time_selector'])) {
            $arr_gsiteRow['gsite_time_selector']            = fn_htmlcode($arr_gsiteRow['gsite_time_selector'], 'decode', 'selector');
        }
        if (!fn_isEmpty($arr_gsiteRow['gsite_time_attr'])) {
            $arr_gsiteRow['gsite_time_attr']                = fn_htmlcode($arr_gsiteRow['gsite_time_attr'], 'decode', 'selector');
        } else {
            $arr_gsiteRow['gsite_time_attr']                = 'html';
        }
        if (!fn_isEmpty($arr_gsiteRow['gsite_time_filter'])) {
            $arr_gsiteRow['gsite_time_filter']              = fn_htmlcode($arr_gsiteRow['gsite_time_filter'], 'decode', 'selector');
        }
        if (!fn_isEmpty($arr_gsiteRow['gsite_source_selector'])) {
            $arr_gsiteRow['gsite_source_selector']          = fn_htmlcode($arr_gsiteRow['gsite_source_selector'], 'decode', 'selector');
        }
        if (!fn_isEmpty($arr_gsiteRow['gsite_source_attr'])) {
            $arr_gsiteRow['gsite_source_attr']              = fn_htmlcode($arr_gsiteRow['gsite_source_attr'], 'decode', 'selector');
        } else {
            $arr_gsiteRow['gsite_source_attr']              = 'html';
        }
        if (!fn_isEmpty($arr_gsiteRow['gsite_source_filter'])) {
            $arr_gsiteRow['gsite_source_filter']            = fn_htmlcode($arr_gsiteRow['gsite_source_filter'], 'decode', 'selector');
        }
        if (!fn_isEmpty($arr_gsiteRow['gsite_author_selector'])) {
            $arr_gsiteRow['gsite_author_selector']          = fn_htmlcode($arr_gsiteRow['gsite_author_selector'], 'decode', 'selector');
        }
        if (!fn_isEmpty($arr_gsiteRow['gsite_author_attr'])) {
            $arr_gsiteRow['gsite_author_attr']              = fn_htmlcode($arr_gsiteRow['gsite_author_attr'], 'decode', 'selector');
        } else {
            $arr_gsiteRow['gsite_author_attr']              = 'html';
        }
        if (!fn_isEmpty($arr_gsiteRow['gsite_author_filter'])) {
            $arr_gsiteRow['gsite_author_filter']            = fn_htmlcode($arr_gsiteRow['gsite_author_filter'], 'decode', 'selector');
        }
        if (!fn_isEmpty($arr_gsiteRow['gsite_page_list_selector'])) {
            $arr_gsiteRow['gsite_page_list_selector']       = fn_htmlcode($arr_gsiteRow['gsite_page_list_selector'], 'decode', 'selector');
        }
        if (!fn_isEmpty($arr_gsiteRow['gsite_page_content_selector'])) {
            $arr_gsiteRow['gsite_page_content_selector']    = fn_htmlcode($arr_gsiteRow['gsite_page_content_selector'], 'decode', 'selector');
        }
        if (!fn_isEmpty($arr_gsiteRow['gsite_page_content_attr'])) {
            $arr_gsiteRow['gsite_page_content_attr']        = fn_htmlcode($arr_gsiteRow['gsite_page_content_selector'], 'decode', 'selector');
        } else {
            $arr_gsiteRow['gsite_page_content_attr']        = 'html';
        }
        if (!fn_isEmpty($arr_gsiteRow['gsite_page_content_filter'])) {
            $arr_gsiteRow['gsite_page_content_filter']      = fn_htmlcode($arr_gsiteRow['gsite_page_content_filter'], 'decode', 'selector');
        }
        /*if (!fn_isEmpty($arr_gsiteRow['gsite_img_attr'])) {
            $arr_gsiteRow['gsite_img_attr']                 = fn_htmlcode($arr_gsiteRow['gsite_img_attr'], 'decode', 'selector');
        } else {
            $arr_gsiteRow['gsite_img_attr']                 = 'src';
        }*/
        if (!fn_isEmpty($arr_gsiteRow['gsite_img_filter'])) {
            $arr_gsiteRow['gsite_img_filter']               = fn_htmlcode($arr_gsiteRow['gsite_img_filter'], 'decode');
            $arr_gsiteRow['gsite_img_filter']               = explode('|', $arr_gsiteRow['gsite_img_filter']);
        }


        if (!fn_isEmpty($arr_gsiteRow['gsite_keep_tag'])) {
            $arr_gsiteRow['gsite_keep_tag']                 = fn_htmlcode($arr_gsiteRow['gsite_keep_tag'], 'decode');
            $arr_gsiteRow['gsite_keep_tag']                 = explode('|', $arr_gsiteRow['gsite_keep_tag']);
        }
        if (!fn_isEmpty($arr_gsiteRow['gsite_attr_allow'])) {
            $arr_gsiteRow['gsite_attr_allow']               = fn_htmlcode($arr_gsiteRow['gsite_attr_allow'], 'decode');
            $arr_gsiteRow['gsite_attr_allow']               = explode('|', $arr_gsiteRow['gsite_attr_allow']);
        }
        if (!fn_isEmpty($arr_gsiteRow['gsite_ignore_tag'])) {
            $arr_gsiteRow['gsite_ignore_tag']               = fn_htmlcode($arr_gsiteRow['gsite_ignore_tag'], 'decode');
            $arr_gsiteRow['gsite_ignore_tag']               = explode('|', $arr_gsiteRow['gsite_ignore_tag']);
        }

        if (!fn_isEmpty($arr_gsiteRow['gsite_attr_except'])) {
            foreach ($arr_gsiteRow['gsite_attr_except'] as $_key=>$_value) {
                $_str_attrExcept = fn_htmlcode($_value['attr'], 'decode');

                $_arr_attrExcept = explode('|', $_str_attrExcept);

                $this->keepAttr[$_value['tag']] = array_merge($this->keepAttr[$_value['tag']], $_arr_attrExcept);
            }
        }
        $arr_gsiteRow['gsite_attr_except'] = $this->keepAttr;

        return $arr_gsiteRow;
    }

    private function sql_process($arr_search = array()) {
        $_str_sqlWhere = '1';

        if (isset($arr_search['key']) && !fn_isEmpty($arr_search['key'])) {
            $_str_sqlWhere .= ' AND (`gsite_name` LIKE \'%' . $arr_search['key'] . '%\' OR `gsite_note` LIKE \'%' . $arr_search['key'] . '%\')';
        }

        if (isset($arr_search['status']) && !fn_isEmpty($arr_search['status'])) {
            $_str_sqlWhere .= ' AND `gsite_status`=\'' . $arr_search['status'] . '\'';
        }

        return $_str_sqlWhere;
    }
}
