<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------栏目模型-------------*/
class MODEL_CATE {

    private $is_magic;
    public $arr_status = array('show', 'hide');
    public $arr_type   = array('normal', 'single', 'link');
    public $arr_pasv   = array('off', 'on');

    function __construct() { //构造函数
        $this->obj_db   = $GLOBALS['obj_db']; //设置数据库对象
        $this->obj_file  = new CLASS_FILE();
        $this->is_magic = get_magic_quotes_gpc();
    }


    function mdl_create_table() {
        $_str_status    = implode('\',\'', $this->arr_status);
        $_str_type      = implode('\',\'', $this->arr_type);
        $_str_pasvs     = implode('\',\'', $this->arr_pasv);

        $_arr_cateCreat = array(
            'cate_id'        => 'smallint NOT NULL AUTO_INCREMENT COMMENT \'ID\'',
            'cate_name'      => 'varchar(300) NOT NULL COMMENT \'栏目名称\'',
            'cate_domain'    => 'varchar(3000) NOT NULL COMMENT \'URL 前缀\'',
            'cate_type'      => 'enum(\'' . $_str_type . '\') NOT NULL COMMENT \'类型\'',
            'cate_tpl'       => 'varchar(1000) NOT NULL COMMENT \'模板\'',
            'cate_content'   => 'text NOT NULL COMMENT \'栏目介绍\'',
            'cate_link'      => 'varchar(3000) NOT NULL COMMENT \'链接地址\'',
            'cate_parent_id' => 'smallint NOT NULL COMMENT \'父栏目\'',
            'cate_alias'     => 'varchar(300) NOT NULL COMMENT \'别名\'',
            'cate_perpage'   => 'tinyint NOT NULL COMMENT \'每页文章数\'',
            'cate_ftp_host'  => 'varchar(3000) NOT NULL COMMENT \'分发 FTP 地址\'',
            'cate_ftp_port'  => 'char(5) NOT NULL COMMENT \'FTP 端口\'',
            'cate_ftp_user'  => 'varchar(300) NOT NULL COMMENT \'FTP 用户名\'',
            'cate_ftp_pass'  => 'varchar(300) NOT NULL COMMENT \'FTP 密码\'',
            'cate_ftp_path'  => 'varchar(3000) NOT NULL COMMENT \'FTP 目录\'',
            'cate_ftp_pasv'  => 'enum(\'' . $_str_pasvs . '\') NOT NULL COMMENT \'是否打开 PASV 模式\'',
            'cate_status'    => 'enum(\'' . $_str_status . '\') NOT NULL COMMENT \'状态\'',
            'cate_order'     => 'smallint NOT NULL COMMENT \'排序\'',
        );

        $_num_db = $this->obj_db->create_table(BG_DB_TABLE . 'cate', $_arr_cateCreat, 'cate_id', '栏目');

        if ($_num_db > 0) {
            $_str_rcode = 'y250105'; //更新成功
        } else {
            $_str_rcode = 'x250105'; //更新成功
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
        );
    }


    function mdl_create_index() {
        $_str_rcode = 'y250109';
        $_arr_indexRow    = $this->obj_db->show_indexs(BG_DB_TABLE . 'cate');

        $drop_overlap        = false;
        foreach ($_arr_indexRow as $_key=>$_value) {
            if (in_array('order', $_value)) {
                $drop_overlap = true;
                break;
            }
        }

        $_arr_cateIndex = array(
            'cate_order',
            'cate_id',
        );

        $_num_db = $this->obj_db->create_index('order', BG_DB_TABLE . 'cate', $_arr_cateIndex, 'BTREE', $drop_overlap);

        if ($_num_db < 1) {
            $_str_rcode = 'x250109';
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
        );
    }


    function mdl_column() {
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . 'cate');

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
        $_str_pasvs     = implode('\',\'', $this->arr_pasv);

        $_arr_col     = $this->mdl_column();
        $_arr_alter   = array();

        if (in_array('cate_id', $_arr_col)) {
            $_arr_alter['cate_id'] = array('CHANGE', 'smallint NOT NULL AUTO_INCREMENT COMMENT \'ID\'', 'cate_id');
        }

        if (in_array('cate_type', $_arr_col)) {
            $_arr_alter['cate_type'] = array('CHANGE', 'enum(\'' . $_str_type . '\') NOT NULL COMMENT \'类型\'', 'cate_type');
        }

        if (in_array('cate_parent_id', $_arr_col)) {
            $_arr_alter['cate_parent_id'] = array('CHANGE', 'smallint NOT NULL COMMENT \'父栏目\'', 'cate_parent_id');
        }

        if (in_array('cate_ftp_port', $_arr_col)) {
            $_arr_alter['cate_ftp_port'] = array('CHANGE', 'char(5) NOT NULL COMMENT \'FTP端口\'', 'cate_ftp_port');
        }

        if (in_array('cate_status', $_arr_col)) {
            $_arr_alter['cate_status'] = array('CHANGE', 'enum(\'' . $_str_status . '\') NOT NULL COMMENT \'状态\'', 'cate_status');
        }

        if (in_array('cate_order', $_arr_col)) {
            $_arr_alter['cate_order'] = array('CHANGE', 'smallint NOT NULL COMMENT \'排序\'', 'cate_order');
        }

        if (!in_array('cate_perpage', $_arr_col)) {
            $_arr_alter['cate_perpage'] = array('ADD', 'tinyint NOT NULL COMMENT \'每页文章数\'');
        }

        if (!in_array('cate_ftp_pasv', $_arr_col)) {
            $_arr_alter['cate_ftp_pasv'] = array('ADD', 'enum(\'' . $_str_pasvs . '\') NOT NULL COMMENT \'是否打开 PASV 模式\'');
        }

        $_str_rcode = 'y250111';

        if (!fn_isEmpty($_arr_alter)) {
            $_reselt = $this->obj_db->alter_table(BG_DB_TABLE . 'cate', $_arr_alter);

            if (!fn_isEmpty($_reselt)) {
                $_str_rcode = 'y250106';
                $_arr_cateData = array(
                    'cate_type' => $this->arr_type[0],
                );
                $this->obj_db->update(BG_DB_TABLE . 'cate', $_arr_cateData, 'LENGTH(`cate_type`)<1'); //更新数据

                $_arr_cateData = array(
                    'cate_status' => $this->arr_status[0],
                );
                $this->obj_db->update(BG_DB_TABLE . 'cate', $_arr_cateData, 'LENGTH(`cate_status`)<1'); //更新数据
            }
        }

        return array(
            'rcode' => $_str_rcode,
        );
    }


    function mdl_submit() {
        $_arr_cateData = array(
            'cate_name'         => $this->cateInput['cate_name'],
            'cate_alias'        => $this->cateInput['cate_alias'],
            'cate_type'         => $this->cateInput['cate_type'],
            'cate_status'       => $this->cateInput['cate_status'],
            'cate_tpl'          => $this->cateInput['cate_tpl'],
            'cate_content'      => $this->cateInput['cate_content'],
            'cate_link'         => $this->cateInput['cate_link'],
            'cate_parent_id'    => $this->cateInput['cate_parent_id'],
            'cate_domain'       => $this->cateInput['cate_domain'],
            'cate_perpage'      => $this->cateInput['cate_perpage'],
            'cate_ftp_host'     => $this->cateInput['cate_ftp_host'],
            'cate_ftp_port'     => $this->cateInput['cate_ftp_port'],
            'cate_ftp_user'     => $this->cateInput['cate_ftp_user'],
            'cate_ftp_pass'     => $this->cateInput['cate_ftp_pass'],
            'cate_ftp_path'     => $this->cateInput['cate_ftp_path'],
            'cate_ftp_pasv'     => $this->cateInput['cate_ftp_pasv'],
        );

        if ($this->cateInput['cate_id'] < 1) { //插入
            $_num_cateId = $this->obj_db->insert(BG_DB_TABLE . 'cate', $_arr_cateData);

            if ($_num_cateId > 0) { //数据库插入是否成功
                $_str_rcode = 'y250101';
            } else {
                return array(
                    'cate_id'   => 0,
                    'rcode'     => 'x250101',
                );
            }
        } else {
            $_num_cateId = $this->cateInput['cate_id'];
            $_num_db  = $this->obj_db->update(BG_DB_TABLE . 'cate', $_arr_cateData, '`cate_id`=' . $_num_cateId);

            if ($_num_db > 0) { //数据库更新是否成功
                $_str_rcode = 'y250103';
            } else {
                return array(
                    'cate_id'   => $_num_cateId,
                    'rcode'     => 'x250103',
                );
            }
        }

        return array(
            'cate_id'   => $_num_cateId,
            'rcode'     => $_str_rcode,
        );
    }


    /**
     * mdl_order function.
     *
     * @access public
     * @param string $str_orderType (default: '')
     * @param int $num_doId (default: 0)
     * @param int $num_targetId (default: 0)
     * @return void
     */
    function mdl_order($str_orderType = '', $num_doId = 0, $num_targetId = 0, $num_parentId = 0) {

        //处理重复排序号
        $_str_sqlDistinct = 'SELECT `cate_id` FROM `' . BG_DB_TABLE . 'cate` WHERE `cate_order` IN (SELECT `cate_order` FROM `' . BG_DB_TABLE . 'cate` GROUP BY `cate_order` HAVING COUNT(`cate_order`)>1) ORDER BY `cate_id` DESC' ;
        $_obj_reselt      = $this->obj_db->query($_str_sqlDistinct);
        $_arr_row         = $this->obj_db->fetch_assoc($_obj_reselt);

        if (!fn_isEmpty($_arr_row)) {
            $_arr_selectData = array(
                'cate_id',
            );

            $_arr_order = array(
                array('cate_id', 'DESC'),
            );
            $_arr_lastRows  = $this->obj_db->select(BG_DB_TABLE . 'cate', $_arr_selectData, '', '', $_arr_order, 1, 0); //读取倒数第一排序号
            if (isset($_arr_lastRows[0])) {
                $_arr_lastRow   = $_arr_lastRows[0];

                $_arr_updateData = array(
                    'cate_order' => $_arr_row['cate_id'] + 1,
                );

                $_str_sqlWhere = '`cate_id`=' . $_arr_row['cate_id'];

                $this->obj_db->update(BG_DB_TABLE . 'cate', $_arr_updateData, $_str_sqlWhere, true); //所有小于本条大于目标记录的数据排序号加1
            }
        }
        //end

        //
        $_arr_selectData = array(
            'cate_order',
        );

        switch ($str_orderType) {
            case 'order_first':
                $_str_sqlWhere = '`cate_parent_id`=' . $num_parentId;
                $_arr_order = array(
                    array('cate_order', 'ASC'),
                );
                $_arr_firstRows = $this->obj_db->select(BG_DB_TABLE . 'cate', $_arr_selectData, $_str_sqlWhere, '', $_arr_order, 1, 0); //读取第一排序号
                if (isset($_arr_firstRows[0])) {
                    $_arr_firstRow  = $_arr_firstRows[0];
                }

                $_str_sqlWhere  = '`cate_id`=' . $num_doId . ' AND `cate_parent_id`=' . $num_parentId;
                $_arr_doRows    = $this->obj_db->select(BG_DB_TABLE . 'cate', $_arr_selectData, $_str_sqlWhere, '', '', 1, 0); //读取本条排序号
                if (isset($_arr_doRows[0])) {
                    $_arr_doRow     = $_arr_doRows[0];
                } else {
                    return array(
                        'rcode' => 'x250217',
                    );
                }

                $_arr_targetData = array(
                    'cate_order' => '`cate_order`+1',
                );
                $_str_sqlWhere = '`cate_order`<' . $_arr_doRow['cate_order'] . ' AND `cate_parent_id`=' . $num_parentId;
                $this->obj_db->update(BG_DB_TABLE . 'cate', $_arr_targetData, $_str_sqlWhere, true); //所有小于本条的数据排序号加1

                $_arr_doData = array(
                    'cate_order' => $_arr_firstRow['cate_order'],
                );
                $_str_sqlWhere = '`cate_id`=' . $num_doId . ' AND `cate_parent_id`=' . $num_parentId;
                $this->obj_db->update(BG_DB_TABLE . 'cate', $_arr_doData, $_str_sqlWhere); //更新本条排序号为1
            break;

            case 'order_last':
                $_str_sqlWhere = '`cate_parent_id`=' . $num_parentId;
                $_arr_order = array(
                    array('cate_order', 'DESC'),
                );
                $_arr_lastRows  = $this->obj_db->select(BG_DB_TABLE . 'cate', $_arr_selectData, $_str_sqlWhere, '', $_arr_order, 1, 0); //读取倒数第一排序号
                if (isset($_arr_lastRows[0])) {
                    $_arr_lastRow   = $_arr_lastRows[0];
                }

                $_str_sqlWhere  = '`cate_id`=' . $num_doId . ' AND `cate_parent_id`=' . $num_parentId;
                $_arr_doRows    = $this->obj_db->select(BG_DB_TABLE . 'cate', $_arr_selectData, $_str_sqlWhere, '', '', 1, 0); //读取本条排序号
                if (isset($_arr_doRows[0])) {
                    $_arr_doRow     = $_arr_doRows[0];
                } else {
                    return array(
                        'rcode' => 'x250217',
                    );
                }

                $_arr_targetData = array(
                    'cate_order' => '`cate_order`-1',
                );
                $_str_sqlWhere = '`cate_order`>' . $_arr_doRow['cate_order'] . ' AND `cate_parent_id`=' . $num_parentId;
                $this->obj_db->update(BG_DB_TABLE . 'cate', $_arr_targetData, $_str_sqlWhere, true); //所有大于本条的数据排序号减1

                $_arr_doData = array(
                    'cate_order' => $_arr_lastRow['cate_order'],
                );
                $_str_sqlWhere = '`cate_id`=' . $num_doId . ' AND `cate_parent_id`=' . $num_parentId;
                $this->obj_db->update(BG_DB_TABLE . 'cate', $_arr_doData, $_str_sqlWhere); //更新本条排序号为最大
            break;

            case 'order_after':
                $_str_sqlWhere = '`cate_id`=' . $num_targetId . ' AND `cate_parent_id`=' . $num_parentId;
                $_arr_targetRows    = $this->obj_db->select(BG_DB_TABLE . 'cate', $_arr_selectData, $_str_sqlWhere, '', '', 1, 0); //读取目标记录排序号
                if (isset($_arr_targetRows[0])) {
                    $_arr_targetRow     = $_arr_targetRows[0];
                } else {
                    return array(
                        'rcode' => 'x250220',
                    );
                }

                $_str_sqlWhere      = '`cate_id`=' . $num_doId . ' AND `cate_parent_id`=' . $num_parentId;
                $_arr_doRows    = $this->obj_db->select(BG_DB_TABLE . 'cate', $_arr_selectData, $_str_sqlWhere, '', '', 1, 0); //读取本条排序号
                if (isset($_arr_doRows[0])) {
                    $_arr_doRow     = $_arr_doRows[0];
                } else {
                    return array(
                        'rcode' => 'x250217',
                    );
                }

                //print_r($_arr_doRow);

                if ($_arr_targetRow['cate_order'] > $_arr_doRow['cate_order']) { //往下移
                    $_arr_targetData = array(
                        'cate_order' => '`cate_order`-1',
                    );
                    $_str_sqlWhere = '`cate_order`>' . $_arr_doRow['cate_order'] . ' AND `cate_order`<=' . $_arr_targetRow['cate_order'] . ' AND `cate_parent_id`=' . $num_parentId;
                    $this->obj_db->update(BG_DB_TABLE . 'cate', $_arr_targetData, $_str_sqlWhere, true); //所有大于本条小于目标记录的数据排序号减1

                    $_arr_doData = array(
                        'cate_order' => $_arr_targetRow['cate_order'],
                    );
                } else {
                    $_arr_targetData = array(
                        'cate_order' => '`cate_order`+1',
                    );
                    $_str_sqlWhere = '`cate_order`<' . $_arr_doRow['cate_order'] . ' AND `cate_order`>' . $_arr_targetRow['cate_order'] . ' AND `cate_parent_id`=' . $num_parentId;
                    $this->obj_db->update(BG_DB_TABLE . 'cate', $_arr_targetData, $_str_sqlWhere, true); //所有大于本条小于目标记录的数据排序号减1

                    $_arr_doData = array(
                        'cate_order' => $_arr_targetRow['cate_order'] + 1,
                    );
                }

                $_str_sqlWhere = '`cate_id`=' . $num_doId . ' AND `cate_parent_id`=' . $num_parentId;
                $this->obj_db->update(BG_DB_TABLE . 'cate', $_arr_doData, $_str_sqlWhere); //更新本条排序号为目标记录排序号
            break;
        }

        return array(
            'rcode' => 'y250103',
        );
    }


    /**
     * mdl_read function.
     *
     * @access public
     * @param mixed $str_cate
     * @param string $str_readBy (default: 'cate_id')
     * @param int $num_notId (default: 0)
     * @param int $num_parentId (default: 0)
     * @return void
     */
    function mdl_read($str_cate, $str_readBy = 'cate_id', $num_notId = 0, $num_parentId = -1) {
        $_arr_cateSelect = array(
            'cate_id',
            'cate_name',
            'cate_alias',
            'cate_type',
            'cate_tpl',
            'cate_content',
            'cate_link',
            'cate_parent_id',
            'cate_domain',
            'cate_perpage',
            'cate_ftp_host',
            'cate_ftp_port',
            'cate_ftp_user',
            'cate_ftp_pass',
            'cate_ftp_path',
            'cate_ftp_pasv',
            'cate_status',
        );

        if (is_numeric($str_cate)) {
            $_str_sqlWhere = '`' . $str_readBy . '`=' . $str_cate;
        } else {
            $_str_sqlWhere = '`' . $str_readBy . '`=\'' . $str_cate . '\'';
        }

        if ($num_notId > 0) {
            $_str_sqlWhere .= ' AND `cate_id`<>' . $num_notId;
        }

        if ($num_parentId >= 0) {
            $_str_sqlWhere .= ' AND `cate_parent_id`=' . $num_parentId;
        }

        $_arr_cateRows    = $this->obj_db->select(BG_DB_TABLE . 'cate', $_arr_cateSelect, $_str_sqlWhere, '', '', 1, 0); //检查本地表是否存在记录

        if (isset($_arr_cateRows[0])) {
            $_arr_cateRow     = $_arr_cateRows[0];
        } else {
            return array(
                'rcode' => 'x250102', //不存在记录
            );
        }

        //if (!$this->is_magic) {
            $_arr_cateRow['cate_content'] = stripslashes($_arr_cateRow['cate_content']);
        //}

        $_arr_cateRow['cate_trees']   = $this->trees_process($_arr_cateRow['cate_id']);
        ksort($_arr_cateRow['cate_trees']);
        $_arr_cateRow['urlRow']       = $this->url_process($_arr_cateRow);

        $_arr_cateRow['rcode']        = 'y250102';

        //print_r($_arr_cateRow);

        return $_arr_cateRow;
    }


    function mdl_readPub($str_cate, $str_readBy = 'cate_id', $num_notId = 0, $num_parentId = 0, $is_min = false) {
        $_arr_cateSelect = array(
            'cate_id',
            'cate_name',
            'cate_alias',
            'cate_type',
            'cate_tpl',
            'cate_content',
            'cate_link',
            'cate_parent_id',
            'cate_domain',
            'cate_status',
            'cate_perpage',
        );

        if ($is_min) {
            $_str_sqlWhere = '`' . $str_readBy . '`>' . $str_cate;
        } else {
            if (is_numeric($str_cate)) {
                $_str_sqlWhere = '`' . $str_readBy . '`=' . $str_cate;
            } else {
                $_str_sqlWhere = '`' . $str_readBy . '`=\'' . $str_cate . '\'';
            }
        }

        if ($num_notId > 0) {
            $_str_sqlWhere .= ' AND `cate_id`<>' . $num_notId;
        }

        if ($num_parentId > 0) {
            $_str_sqlWhere .= ' AND `cate_parent_id`=' . $num_parentId;
        }

        $_arr_order = array(
            array('cate_id', 'ASC'),
        );
        $_arr_cateRows    = $this->obj_db->select(BG_DB_TABLE . 'cate', $_arr_cateSelect, $_str_sqlWhere, '', $_arr_order, 1, 0); //检查本地表是否存在记录

        if (isset($_arr_cateRows[0])) {
            $_arr_cateRow     = $_arr_cateRows[0];
        } else {
            return array(
                'rcode' => 'x250102', //不存在记录
            );
        }

        //if (!$this->is_magic) {
            $_arr_cateRow['cate_content'] = stripslashes($_arr_cateRow['cate_content']);
        //}

        $_arr_cateRow['cate_trees']   = $this->trees_process($_arr_cateRow['cate_id']);
        ksort($_arr_cateRow['cate_trees']);
        $_arr_cateRow['urlRow']       = $this->url_process($_arr_cateRow);

        $_arr_cateRow['rcode']    = 'y250102';

        return $_arr_cateRow;
    }


    function mdl_listPub($num_no, $num_except = 0, $arr_search = array(), $num_level = 1) {
        $_arr_cateSelect = array(
            'cate_id',
            'cate_name',
            'cate_link',
            'cate_alias',
            'cate_status',
            'cate_type',
            'cate_parent_id',
            'cate_domain',
        );

        $_str_sqlWhere  = $this->sql_process($arr_search);

        $_arr_order = array(
            array('cate_order', 'ASC'),
            array('cate_id', 'ASC'),
        );

        $_arr_cateRows  = $this->obj_db->select(BG_DB_TABLE . 'cate', $_arr_cateSelect, $_str_sqlWhere, '', $_arr_order, $num_no, $num_except);

        //print_r($_arr_cateRows);

        $_arr_cates = array();

        foreach ($_arr_cateRows as $_key=>$_value) {
            $_value['cate_trees']       = $this->trees_process($_value['cate_id']);
            ksort($_value['cate_trees']);
            $arr_search['parent_id']    = $_value['cate_id'];

            $_arr_cates[$_value['cate_id']]                 = $_value;
            $_arr_cates[$_value['cate_id']]['urlRow']       = $this->url_process($_value);
            $_arr_cates[$_value['cate_id']]['cate_level']   = $num_level;
            $_arr_cates[$_value['cate_id']]['cate_childs']  = $this->mdl_listPub(1000, 0, $arr_search, $num_level + 1);
        }

        return $_arr_cates;
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
    function mdl_list($num_no, $num_except = 0, $arr_search = array(), $num_level = 1, $is_tree = true) {
        $_arr_updateData = array(
            'cate_order' => '`cate_id`',
        );

        $_num_db = $this->obj_db->update(BG_DB_TABLE . 'cate', $_arr_updateData, '`cate_order`<1', true); //更新数据

        $_arr_cateSelect = array(
            'cate_id',
            'cate_name',
            'cate_link',
            'cate_alias',
            'cate_status',
            'cate_type',
            'cate_parent_id',
            'cate_domain',
            'cate_ftp_host',
            'cate_ftp_port',
            'cate_ftp_user',
            'cate_ftp_pass',
            'cate_ftp_path',
            'cate_ftp_pasv',
        );

        $_str_sqlWhere  = $this->sql_process($arr_search, $is_tree);

        //print_r($_str_sqlWhere);

        $_arr_order = array(
            array('cate_order', 'ASC'),
            array('cate_id', 'ASC'),
        );

        $_arr_cateRows  = $this->obj_db->select(BG_DB_TABLE . 'cate', $_arr_cateSelect, $_str_sqlWhere, '', $_arr_order, $num_no, $num_except);

        //print_r($_arr_cateRows);

        foreach ($_arr_cateRows as $_key=>$_value) {
            $_value['cate_trees']                   = $this->trees_process($_value['cate_id']);
            ksort($_value['cate_trees']);
            //$_arr_cateRows[$_key]['cate_trees']     = $_value['cate_trees'];
            $_arr_cateRows[$_key]['urlRow']         = $this->url_process($_value);
            $_arr_cateRows[$_key]['cate_level']     = $num_level;
            $arr_search['parent_id']                = $_value['cate_id'];
            if ($is_tree) {
                $_arr_cateRows[$_key]['cate_childs']    = $this->mdl_list(1000, 0, $arr_search, $num_level + 1);
            }
        }

        return $_arr_cateRows;
    }


    /**
     * mdl_count function.
     *
     * @access public
     * @param string $str_status (default: '')
     * @param string $str_type (default: '')
     * @param int $num_parentId (default: 0)
     * @return void
     */
    function mdl_count($arr_search = array()) {

        $_str_sqlWhere = $this->sql_process($arr_search);

        $_num_cateCount = $this->obj_db->count(BG_DB_TABLE . 'cate', $_str_sqlWhere); //查询数据

        /*print_r($_arr_userRow);
        exit;*/

        return $_num_cateCount;
    }


    function mdl_ids($num_cateId) {
        $_arr_search = array(
            'status'    => 'show',
            'parent_id' => $num_cateId,
        );
        $_arr_cateRows  = $this->mdl_list(1000, 0, $_arr_search);
        $_arr_cateIds   = $this->ids_process($_arr_cateRows);
        $_arr_cateIds[] = $num_cateId;
        return array_filter(array_unique($_arr_cateIds));
    }


    function mdl_list_ids() {
        $_arr_cateSelect = array(
            'cate_id',
        );

        $_str_sqlWhere = '1';

        $_arr_order = array(
            array('cate_id', 'ASC'),
        );
        $_arr_cateRows = $this->obj_db->select(BG_DB_TABLE . 'cate', $_arr_cateSelect, $_str_sqlWhere, '', $_arr_order, 1000, 0);

        foreach ($_arr_cateRows as $_key=>$_value) {
            $_arr_list_id[] = $_value['cate_id'];
        }

        return $_arr_list_id;
    }


    /**
     * mdl_status function.
     *
     * @access public
     * @param mixed $this->cateIds['cate_ids']
     * @param mixed $str_status
     * @return void
     */
    function mdl_status($str_status) {
        $_str_cateId = implode(',', $this->cateIds['cate_ids']);

        $_arr_cateData = array(
            'cate_status' => $str_status,
        );

        $_num_db = $this->obj_db->update(BG_DB_TABLE . 'cate', $_arr_cateData, '`cate_id` IN (' . $_str_cateId . ')'); //更新数据

        //如车影响行数小于0则返回错误
        if ($_num_db > 0) {
            $_str_rcode = 'y250103';
        } else {
            $_str_rcode = 'x250103';
        }

        return array(
            'rcode' => $_str_rcode,
        ); //成功
    }

    /**
     * mdl_del function.
     *
     * @access public
     * @return void
     */
    function mdl_del() {
        $_str_cateId = implode(',', $this->cateIds['cate_ids']);

        $_num_db = $this->obj_db->delete(BG_DB_TABLE . 'cate', '`cate_id` IN (' . $_str_cateId . ')'); //删除数据

        //如车影响行数小于0则返回错误
        if ($_num_db > 0) {
            $_str_rcode = 'y250104';

            $_arr_cateData = array(
                'cate_parent_id' => 0
            );
            $this->obj_db->update(BG_DB_TABLE . 'cate', $_arr_cateData, '`cate_parent_id` IN (' . $_str_cateId . ')'); //更新数据

            $_arr_articleData = array(
                'article_cate_id' => -1
            );
            $this->obj_db->update(BG_DB_TABLE . 'article', $_arr_articleData, '`article_cate_id` IN (' . $_str_cateId . ')'); //更新数据

            $this->obj_db->delete(BG_DB_TABLE . 'cate_belong', '`belong_cate_id` IN (' . $_str_cateId . ')'); //更新数据
        } else {
            $_str_rcode = 'x250104';
        }

        return array(
            'rcode' => $_str_rcode,
        ); //成功
    }


    function mdl_duplicate() {

        $_arr_cateData = array(
            'cate_name',
            'cate_alias',
            'cate_type',
            'cate_tpl',
            'cate_content',
            'cate_link',
            'cate_parent_id',
            'cate_domain',
            'cate_perpage',
            'cate_ftp_host',
            'cate_ftp_port',
            'cate_ftp_user',
            'cate_ftp_pass',
            'cate_ftp_path',
            'cate_ftp_pasv',
            'cate_status',
        );

        $_num_cateId = $this->obj_db->duplicate(BG_DB_TABLE . 'cate', $_arr_cateData, BG_DB_TABLE . 'cate', $_arr_cateData, '`cate_id`=' . $this->cateDuplicate['cate_id']);

        if ($_num_cateId > 0) { //数据库更新是否成功
            $_str_rcode = 'y250112';
        } else {
            return array(
                'cate_id'   => $_num_cateId,
                'rcode'     => 'x250112',
            );
        }

        return array(
            'cate_id'   => $_num_cateId,
            'rcode'     => $_str_rcode,
        );
    }


    /**
     * cache_generate function.
     *
     * @access public
     * @return void
     */
    function mdl_cache($num_cateId = 0, $is_reGen = false) {
        $_str_cacheReturn = '{"rcode":"x250102"}';

        if ($is_reGen || !file_exists(BG_PATH_CACHE . 'sys' . DS . 'cate_trees.json')) {
            $_arr_search = array(
                'status' => 'show',
            );
            $_arr_cateRows  = $this->mdl_list(1000, 0, $_arr_search);

            $_arr_cateRows  = $this->cache_tree_process($_arr_cateRows);

            $_str_outPut    = json_encode($_arr_cateRows);

            $_num_size      = $this->obj_file->file_put(BG_PATH_CACHE . 'sys' . DS . 'cate_trees.json', $_str_outPut);
        }

        if ($is_reGen) {
            $arr_cateIds = $this->mdl_list_ids();

            foreach ($arr_cateIds as $_key=>$_value) {
                $_arr_cateRow   = $this->cache_row_process($_value);
                if ($_arr_cateRow['rcode'] == 'y250102') {
                    $_str_outPut    = json_encode($_arr_cateRow);
                    $_num_sizeCate  = $this->obj_file->file_put(BG_PATH_CACHE . 'sys' . DS . 'cate_' . $_arr_cateRow['cate_id'] . '.json', $_str_outPut);
                }
            }
        }

        if ($num_cateId > 0) { //读取指定 ID 的 cache
            if (!file_exists(BG_PATH_CACHE . 'sys' . DS . 'cate_' . $num_cateId . '.json')) {
                $_arr_cateRow   = $this->cache_row_process($num_cateId);
                if ($_arr_cateRow['rcode'] == 'y250102') {
                    $_str_outPut    = json_encode($_arr_cateRow);
                    $_num_size      = $this->obj_file->file_put(BG_PATH_CACHE . 'sys' . DS . 'cate_' . $num_cateId . '.json', $_str_outPut);
                }
            }

            $_str_cacheReturn   = $this->obj_file->file_read(BG_PATH_CACHE . 'sys' . DS . 'cate_' . $num_cateId . '.json');
            $_arr_cacheReturn   = json_decode($_str_cacheReturn, true);
            //$_arr_cacheReturn['cate_content'] = stripslashes($_arr_cacheReturn['cate_content']);
        } else { //读取栏目树
            $_str_cacheReturn   = $this->obj_file->file_read(BG_PATH_CACHE . 'sys' . DS . 'cate_trees.json');
            $_arr_cacheReturn   = json_decode($_str_cacheReturn, true);
        }

        return $_arr_cacheReturn;
    }


    function mdl_cache_del($arr_cateDels = false) {
        if (is_array($arr_cateDels)) {
            foreach ($arr_cateDels as $_key=>$_value) {
                $this->obj_file->file_del(BG_PATH_CACHE . 'sys' . DS . 'cate_' . $_value . '.json');
            }
        }
    }


    /**
     * input_submit function.
     *
     * @access public
     * @return void
     */
    function input_submit($arr_input = false) {
        if (!fn_token('chk')) { //令牌
            return array(
                'rcode' => 'x030206',
            );
        }

        //定义参数结构
        $_arr_inputParam = array(
            'cate_id',
            'cate_name',
            'cate_alias',
            'cate_type',
            'cate_status',
            'cate_tpl',
            'cate_content',
            'cate_link',
            'cate_parent_id',
            'cate_domain',
            'cate_perpage',
            'cate_ftp_host',
            'cate_ftp_port',
            'cate_ftp_user',
            'cate_ftp_pass',
            'cate_ftp_path',
            'cate_ftp_pasv',
        );

        if ($arr_input && is_array($arr_input) && !fn_isEmpty($arr_input)) {
            $this->cateInput = fn_paramChk($arr_input, $_arr_inputParam);
        } else {
            $this->cateInput = fn_post(false, $_arr_inputParam);
        }

        $this->cateInput['cate_id'] = fn_getSafe($this->cateInput['cate_id'], 'int', 0);

        if ($this->cateInput['cate_id'] > 0) {
            $_arr_cateRow = $this->mdl_read($this->cateInput['cate_id']);
            if ($_arr_cateRow['rcode'] != 'y250102') {
                return $_arr_cateRow;
            }
        }

        $_arr_cateName = fn_validate($this->cateInput['cate_name'], 1, 300);
        switch ($_arr_cateName['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x250201',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x250202',
                );
            break;

            case 'ok':
                $this->cateInput['cate_name'] = $_arr_cateName['str'];
            break;

        }

        $_arr_cateParentId = fn_validate($this->cateInput['cate_parent_id'], 1, 0);
        switch ($_arr_cateParentId['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x250213',
                );
            break;

            case 'ok':
                $this->cateInput['cate_parent_id'] = $_arr_cateParentId['str'];
            break;
        }

        if ($this->cateInput['cate_parent_id'] > 0 && $this->cateInput['cate_parent_id'] == $this->cateInput['cate_id']) {
            return array(
                'rcode' => 'x250221',
            );
        }

        $_arr_cateRow = $this->mdl_read($this->cateInput['cate_name'], 'cate_name', $this->cateInput['cate_id'], $this->cateInput['cate_parent_id']);

        if ($_arr_cateRow['rcode'] == 'y250102') {
            return array(
                'rcode' => 'x250203',
            );
        }

        $_arr_cateAlias = fn_validate($this->cateInput['cate_alias'], 0, 300, 'str', 'alias');
        switch ($_arr_cateAlias['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x250204',
                );
            break;

            case 'format_err':
                return array(
                    'rcode' => 'x250205',
                );
            break;

            case 'ok':
                $this->cateInput['cate_alias'] = $_arr_cateAlias['str'];
            break;
        }

        if (!fn_isEmpty($this->cateInput['cate_alias'])) {
            $_arr_cateRow = $this->mdl_read($this->cateInput['cate_alias'], 'cate_alias', $this->cateInput['cate_id'], $this->cateInput['cate_parent_id']);
            if ($_arr_cateRow['rcode'] == 'y250102') {
                return array(
                    'rcode' => 'x250206',
                );
            }
        }

        $_arr_cateLink = fn_validate($this->cateInput['cate_link'], 0, 3000);
        switch ($_arr_cateLink['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x250211',
                );
            break;

            case 'ok':
                $this->cateInput['cate_link'] = $_arr_cateLink['str'];
            break;
        }

        $_arr_cateTpl = fn_validate($this->cateInput['cate_tpl'], 1, 0);
        switch ($_arr_cateTpl['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x250214',
                );
            break;

            case 'ok':
                $this->cateInput['cate_tpl'] = $_arr_cateTpl['str'];
            break;

        }

        $_arr_cateType = fn_validate($this->cateInput['cate_type'], 1, 0);
        switch ($_arr_cateType['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x250215',
                );
            break;

            case 'ok':
                $this->cateInput['cate_type'] = $_arr_cateType['str'];
            break;

        }

        $_arr_cateStatus = fn_validate($this->cateInput['cate_status'], 1, 0);
        switch ($_arr_cateStatus['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x250216',
                );
            break;

            case 'ok':
                $this->cateInput['cate_status'] = $_arr_cateStatus['str'];
            break;

        }

        $_arr_cateDomain = fn_validate($this->cateInput['cate_domain'], 0, 3000);
        switch ($_arr_cateDomain['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x250207',
                );
            break;

            case 'format_err':
                return array(
                    'rcode' => 'x250208',
                );
            break;

            case 'ok':
                $this->cateInput['cate_domain'] = rtrim($_arr_cateDomain['str'], '/\\');
            break;
        }

        $this->cateInput['cate_content']     = fn_htmlcode(fn_safe($this->cateInput['cate_content']), 'decode');

        if (!$this->is_magic) {
            $this->cateInput['cate_content']    = addslashes($this->cateInput['cate_content']);
        }

        $this->cateInput['cate_perpage']     = fn_getSafe($this->cateInput['cate_perpage'], 'int', BG_SITE_PERPAGE);
        $this->cateInput['cate_ftp_host']    = fn_getSafe($this->cateInput['cate_ftp_host'], 'txt', '');
        $this->cateInput['cate_ftp_port']    = fn_getSafe($this->cateInput['cate_ftp_port'], 'txt', '');
        $this->cateInput['cate_ftp_user']    = fn_getSafe($this->cateInput['cate_ftp_user'], 'txt', '');
        $this->cateInput['cate_ftp_pass']    = fn_getSafe($this->cateInput['cate_ftp_pass'], 'txt', '');
        $this->cateInput['cate_ftp_path']    = rtrim(fn_getSafe($this->cateInput['cate_ftp_path'], 'txt', ''), '/\\');
        $this->cateInput['cate_ftp_pasv']    = fn_getSafe($this->cateInput['cate_ftp_pasv'], 'txt', '');

        $this->cateInput['rcode']            = 'ok';

        return $this->cateInput;
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

        $_arr_cateIds = fn_post('cate_ids');

        if (fn_isEmpty($_arr_cateIds)) {
            $_str_rcode = 'x030202';
        } else {
            foreach ($_arr_cateIds as $_key=>$_value) {
                $_arr_cateIds[$_key] = fn_getSafe($_value, 'int', 0);
            }
            $_str_rcode = 'ok';
        }

        $this->cateIds = array(
            'rcode'     => $_str_rcode,
            'cate_ids'  => array_filter(array_unique($_arr_cateIds)),
        );

        return $this->cateIds;
    }


    function input_duplicate() {
        if (!fn_token('chk')) { //令牌
            return array(
                'rcode' => 'x030206',
            );
        }

        $this->cateDuplicate['cate_id'] = fn_getSafe(fn_post('cate_id'), 'int', 0);

        if ($this->cateDuplicate['cate_id'] < 1) {
            return array(
                'rcode' => 'x250217',
            );
        }

        $_arr_cateRow = $this->mdl_read($this->cateDuplicate['cate_id']);
        if ($_arr_cateRow['rcode'] != 'y250102') {
            return $_arr_cateRow;
        }

        $this->cateDuplicate['rcode']   = 'ok';

        return $this->cateDuplicate;
    }


    private function mdl_readDb($num_cateId) {
        $_arr_cateSelect = array(
            'cate_id',
            'cate_name',
            'cate_alias',
            'cate_type',
            'cate_tpl',
            //'cate_content',
            'cate_link',
            'cate_parent_id',
            'cate_domain',
            'cate_status',
        );

        $_str_sqlWhere    = '`cate_id`=' . $num_cateId;

        $_arr_cateRows    = $this->obj_db->select(BG_DB_TABLE . 'cate', $_arr_cateSelect, $_str_sqlWhere, '', '', 1, 0); //检查本地表是否存在记录

        if (isset($_arr_cateRows[0])) {
            $_arr_cateRow     = $_arr_cateRows[0];
        } else {
            return array(
                'rcode' => 'x250102', //不存在记录
            );
        }

        //if (!$this->is_magic) {
            //$_arr_cateRow['cate_content'] = stripslashes($_arr_cateRow['cate_content']);
        //}

        $_arr_cateRow['rcode']    = 'y250102';

        return $_arr_cateRow;
    }


    private function url_process($arr_cateRow) {
        $_str_cateUrlParent = '';
        $_str_catePath      = '';
        $_str_catePathShort = '';
        $_str_cateUrl       = '';
        $_str_cateUrlMore   = '';
        $_str_pageAttach    = '';
        $_str_pageExt       = '';

        if ($arr_cateRow['cate_type'] == 'link' && !fn_isEmpty($arr_cateRow['cate_link'])) {
            $_str_cateUrl = $arr_cateRow['cate_link'];
        } else {
            if (isset($arr_cateRow['cate_trees'][0]['cate_domain']) && !fn_isEmpty($arr_cateRow['cate_trees'][0]['cate_domain'])) {
                $_str_urlPrefix = $arr_cateRow['cate_domain'] . '/';
            } else {
                $_str_urlPrefix = BG_URL_ROOT;
            }

            switch (BG_VISIT_TYPE) {
                case 'static':
                    foreach ($arr_cateRow['cate_trees'] as $_key_tree=>$_value_tree) {
                        if (fn_isEmpty($_value_tree['cate_alias'])) {
                            $_str_cateUrlParent .= $_value_tree['cate_id'] . '/';
                        } else {
                            $_str_cateUrlParent .= $_value_tree['cate_alias'] . '/';
                        }
                    }

                    $_str_catePath      = BG_PATH_ROOT . 'cate' . DS . $_str_cateUrlParent;
                    $_str_catePathShort = '/' . $_str_cateUrlParent;
                    $_str_cateUrl       = $_str_urlPrefix . 'cate/' . $_str_cateUrlParent;
                    $_str_cateUrlMore   = $_str_urlPrefix . 'cate/' . $_str_cateUrlParent . 'id-' . $arr_cateRow['cate_id'] . '/';
                    $_str_pageAttach    = 'page-';
                    $_str_pageExt       = '.' . BG_VISIT_FILE;
                break;

                case 'pstatic':
                    foreach ($arr_cateRow['cate_trees'] as $_key_tree=>$_value_tree) {
                        if (fn_isEmpty($_value_tree['cate_alias'])) {
                            $_str_cateUrlParent .= $_value_tree['cate_id'] . '/';
                        } else {
                            $_str_cateUrlParent .= $_value_tree['cate_alias'] . '/';
                        }
                    }

                    $_str_cateUrl       = $_str_urlPrefix . 'cate/' . $_str_cateUrlParent . 'id-' . $arr_cateRow['cate_id'] . '/';
                    $_str_pageAttach    = 'page-';
                break;

                default:
                    $_str_cateUrl       = $_str_urlPrefix . 'index.php?m=cate&a=show&cate_id=' . $arr_cateRow['cate_id'];
                    $_str_pageAttach    = '&page=';
                break;
            }
        }

        return array(
            'cate_path'         => $_str_catePath,
            'cate_pathShort'    => $_str_catePathShort,
            'cate_url'          => $_str_cateUrl,
            'cate_urlMore'      => $_str_cateUrlMore,
            'page_attach'       => $_str_pageAttach,
            'page_ext'          => $_str_pageExt,
        );
    }


    function article_url_process($arr_articleRow, $arr_cateRow = false) {
        $_str_articlePath       = '';
        $_str_articlePathFull   = '';
        $_str_articlePathShort  = '';
        $_str_pageExt           = '';

        if (fn_isEmpty($arr_articleRow['article_link'])) {
            if (fn_isEmpty($arr_cateRow)) {
                $_str_urlPrefix = BG_URL_ROOT;
            } else {
                if (fn_isEmpty($arr_cateRow['cate_trees'][0]['cate_domain'])) {
                    $_str_urlPrefix = BG_URL_ROOT;
                } else {
                    $_str_urlPrefix = $arr_cateRow['cate_domain'] . '/';
                }
            }

            switch (BG_VISIT_TYPE) {
                case 'static':
                    $_str_articlePath = BG_PATH_ROOT . 'article' . DS . date('Y', $arr_articleRow['article_time']) . DS . date('m', $arr_articleRow['article_time']) . DS;
                    $_str_articlePathFull = BG_PATH_ROOT . 'article' . DS . date('Y', $arr_articleRow['article_time']) . DS . date('m', $arr_articleRow['article_time']) . DS . $arr_articleRow['article_id'] . '.' . BG_VISIT_FILE;
                    $_str_articlePathShort = '/article/' . date('Y', $arr_articleRow['article_time']) . '/' . date('m', $arr_articleRow['article_time']) . '/' . $arr_articleRow['article_id'] . '.' . BG_VISIT_FILE;
                    $_str_articleUrl = $_str_urlPrefix . 'article/' . date('Y', $arr_articleRow['article_time']) . '/' . date('m', $arr_articleRow['article_time']) . '/' . $arr_articleRow['article_id'] . '.' . BG_VISIT_FILE;
                    $_str_pageExt = '.' . BG_VISIT_FILE;
                break;

                case 'pstatic':
                    $_str_articleUrl = $_str_urlPrefix . 'article/id-' . $arr_articleRow['article_id'];
                break;

                default:
                    $_str_articleUrl = $_str_urlPrefix . 'index.php?m=article&a=show&article_id=' . $arr_articleRow['article_id'];
                break;
            }
        } else {
            $_str_articleUrl = $arr_articleRow['article_link'];
        }

        return array(
            'article_path'      => $_str_articlePath,
            'article_pathFull'  => $_str_articlePathFull,
            'article_pathShort' => $_str_articlePathShort,
            'article_url'       => $_str_articleUrl,
            'page_ext'          => $_str_pageExt,
        );
    }


    private function ids_process($arr_cateRows) {
        $_arr_ids = array();
        foreach ($arr_cateRows as $_key=>$_value) {
            if ($_value['cate_id'] > 0) {
                $_arr_ids[] = $_value['cate_id'];
            }
            if (!fn_isEmpty($_value['cate_childs'])) {
                $_arr_cate  = $this->ids_process($_value['cate_childs']);
                $_arr_ids   = array_merge($_arr_cate, $_arr_ids);
            }
        }

        return $_arr_ids;
    }


    private function trees_process($num_cateId) {
        $_arr_cateTrees     = array();
        $_arr_cateRow       = $this->mdl_readDb($num_cateId);
        $_arr_cateTrees[]   = $_arr_cateRow;

        if (isset($_arr_cateRow['cate_parent_id']) && $_arr_cateRow['cate_parent_id'] > 0 && $_arr_cateRow['cate_parent_id'] != $_arr_cateRow['cate_id']) {
            $_arr_cate = $this->trees_process($_arr_cateRow['cate_parent_id']);
            $_arr_cateTrees   = array_merge($_arr_cate, $_arr_cateTrees);
        }

        return $_arr_cateTrees;
    }


    private function cache_tree_process($arr_cateRows) {
        $_arr_cates = array();

        foreach ($arr_cateRows as $_key=>$_value) {
            unset($_value['urlRow']['cate_path'], $_value['urlRow']['cate_pathShort']);

            $_arr_cates[$_value['cate_id']] = $_value;

            if (is_array($_value['cate_childs']) && !fn_isEmpty($_value['cate_childs'])) {
                $_arr_cates[$_value['cate_id']]['cate_childs'] = $this->cache_tree_process($_value['cate_childs']);
            }
        }

        return $_arr_cates;
    }


    private function cache_row_process($num_cateId) {
        $_arr_cateRow = $this->mdl_readPub($num_cateId);

        if ($_arr_cateRow['rcode'] == 'y250102' && $_arr_cateRow['cate_status'] == 'show') {
            unset($_arr_cateRow['urlRow']['cate_path'], $_arr_cateRow['urlRow']['cate_pathShort']);

            $_str_tplDo    = $this->tpl_process($_arr_cateRow['cate_id']);

            $_arr_cateRow['cate_tplDo']     = $_str_tplDo;
            //$_arr_cateRow['cate_content']   = stripslashes($_arr_cateRow['cate_content']);

            $_arr_ids   = $this->mdl_ids($_arr_cateRow['cate_id']);
            $_arr_ids[] = $_arr_cateRow['cate_id'];
            $_arr_ids   = array_filter(array_unique($_arr_ids));

            $_arr_cateRow['cate_ids'] = $_arr_ids;

            if (!fn_isEmpty($_arr_cateRow['cate_trees'])) {
                foreach ($_arr_cateRow['cate_trees'] as $_key_tree=>$_value_tree) {
                    if (isset($_value_tree['cate_id']) && $_value_tree['cate_id'] > 0) {
                        $_arr_cate = $this->mdl_readPub($_value_tree['cate_id']);
                        if ($_arr_cate['rcode'] == 'y250102' && $_arr_cate['cate_status'] == 'show') {
                            unset($_arr_cate['urlRow']['cate_path'], $_arr_cate['urlRow']['cate_pathShort']);
                            $_arr_cateRow['cate_trees'][$_key_tree]['urlRow'] = $_arr_cate['urlRow'];
                        }
                    }
                }
            }
        }

        return $_arr_cateRow;
    }


    function tpl_process($num_cateId) {
        $_str_tpl = BG_SITE_TPL;

        $_arr_cateRow = $this->mdl_readPub($num_cateId);
        if ($_arr_cateRow['rcode'] == 'y250102' && $_arr_cateRow['cate_status'] == 'show') {
            $_str_cateTpl = $_arr_cateRow['cate_tpl'];

            if ($_str_cateTpl == 'inherit' && $_arr_cateRow['cate_parent_id'] > 0) {
                $_str_cateTpl = $this->tpl_process($_arr_cateRow['cate_parent_id']);
            }
        } else {
            $_str_cateTpl = $_str_tpl;
        }

        if ($_str_cateTpl == 'inherit') {
            $_str_cateTpl = $_str_tpl;
        } else {
            $_str_cateTpl = $_str_cateTpl;
        }
        if (fn_isEmpty($_str_cateTpl)) {
            $_str_cateTpl = $_str_tpl;
        }

        return $_str_cateTpl;
    }


    private function sql_process($arr_search = array(), $is_tree = true) {
        if (!isset($arr_search['parent_id'])) {
            if ($is_tree) {
                $_str_sqlWhere = '`cate_parent_id`=0';
            } else {
                $_str_sqlWhere = '1';
            }
        } else {
            $_str_sqlWhere = '`cate_parent_id`=' . $arr_search['parent_id'];
        }

        if (isset($arr_search['status']) && !fn_isEmpty($arr_search['status'])) {
            $_str_sqlWhere .= ' AND `cate_status`=\'' . $arr_search['status'] . '\'';
        }

        if (isset($arr_search['type']) && !fn_isEmpty($arr_search['type'])) {
            $_str_sqlWhere .= ' AND `cate_type`=\'' . $arr_search['type'] . '\'';
        }

        if (isset($arr_search['excepts']) && !fn_isEmpty($arr_search['excepts'])) {
            $_str_excepts    = implode(',', $arr_search['excepts']);
            $_str_sqlWhere  .= ' AND `cate_id` NOT IN (' . $_str_excepts . ')';
        }

        if (isset($arr_search['cate_ids']) && !fn_isEmpty($arr_search['cate_ids'])) {
            $_str_cateIds    = implode(',', $arr_search['cate_ids']);
            $_str_sqlWhere  .= ' AND `cate_id` IN (' . $_str_cateIds . ')';
        }

        return $_str_sqlWhere;
    }
}
