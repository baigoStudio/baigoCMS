<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------TAG 归属模型-------------*/
class MODEL_TAG_BELONG {

    function __construct() { //构造函数
        $this->obj_db = $GLOBALS['obj_db']; //设置数据库对象
    }


    function mdl_create_table() {
        $_arr_belongCreat = array(
            'belong_id'          => 'int NOT NULL AUTO_INCREMENT COMMENT \'ID\'',
            'belong_tag_id'      => 'int NOT NULL COMMENT \'TAG ID\'',
            'belong_article_id'  => 'int NOT NULL COMMENT \'文章 ID\'',
        );

        $_num_db = $this->obj_db->create_table(BG_DB_TABLE . 'tag_belong', $_arr_belongCreat, 'belong_id', '标签从属');

        if ($_num_db > 0) {
            $_str_rcode = 'y160105'; //更新成功
        } else {
            $_str_rcode = 'x160105'; //更新成功
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
        );
    }


    function mdl_create_index() {
        $_str_rcode = 'y160109'; //更新成功
        $_arr_indexRow    = $this->obj_db->show_index(BG_DB_TABLE . 'tag_belong');

        $is_exists        = false;
        foreach ($_arr_indexRow as $_key=>$_value) {
            if (in_array('search_article', $_value)) {
                $is_exists = true;
                break;
            }
        }

        $_arr_tagBelongIndex = array(
            'belong_article_id',
        );

        $_num_db = $this->obj_db->create_index('search_article', BG_DB_TABLE . 'tag_belong', $_arr_tagBelongIndex, 'BTREE', $is_exists);

        if ($_num_db < 1) {
            $_str_rcode = 'x160109'; //更新成功
        }

        $is_exists        = false;
        foreach ($_arr_indexRow as $_key=>$_value) {
            if (in_array('search_tag', $_value)) {
                $is_exists = true;
                break;
            }
        }

        $_arr_tagBelongIndex = array(
            'belong_tag_id',
        );

        $_num_db = $this->obj_db->create_index('search_tag', BG_DB_TABLE . 'tag_belong', $_arr_tagBelongIndex, 'BTREE', $is_exists);

        if ($_num_db < 1) {
            $_str_rcode = 'x160109'; //更新成功
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
        );
    }


    function mdl_create_view() {
        $_arr_viewCreat = array(
            array('tag_id',             BG_DB_TABLE . 'tag'),
            array('tag_name',           BG_DB_TABLE . 'tag'),
            array('tag_status',         BG_DB_TABLE . 'tag'),
            array('tag_article_count',  BG_DB_TABLE . 'tag'),
            array('belong_article_id',  BG_DB_TABLE . 'tag_belong'),
        );

        $_str_sqlJoin = 'LEFT JOIN `' . BG_DB_TABLE . 'tag_belong` ON (`' . BG_DB_TABLE . 'tag`.`tag_id`=`' . BG_DB_TABLE . 'tag_belong`.`belong_tag_id`)';

        $_num_db = $this->obj_db->create_view(BG_DB_TABLE . 'tag_view', $_arr_viewCreat, BG_DB_TABLE . 'tag', $_str_sqlJoin);

        if ($_num_db > 0) {
            $_str_rcode = 'y160109'; //更新成功
        } else {
            $_str_rcode = 'x160109'; //更新成功
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
        );
    }


    function mdl_column() {
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . 'tag_belong');

        $_arr_col = array();

        if (!fn_isEmpty($_arr_colRows)) {
            foreach ($_arr_colRows as $_key=>$_value) {
                $_arr_col[] = $_value['Field'];
            }
        }

        return $_arr_col;
    }


    /**
     * mdl_submit function.
     *
     * @access public
     * @param mixed $num_belongId
     * @param mixed $num_tagId
     * @param mixed $num_belongId
     * @return void
     */
    function mdl_submit($num_articleId, $num_tagId) {
        $_str_rcode = 'x160101';

        if ($num_articleId > 0 && $num_tagId > 0) { //插入
            $_arr_belongRow = $this->mdl_read($num_articleId, $num_tagId);

            if ($_arr_belongRow['rcode'] == 'x160102') { //插入
                    if ($_arr_belongRow['rcode'] == 'x160102') { //插入
                    $_arr_belongData = array(
                        'belong_article_id'  => $num_articleId,
                        'belong_tag_id'     => $num_tagId,
                    );

                    $_arr_belongRow = $this->mdl_read($num_articleId, 0);

                    if ($_arr_belongRow['rcode'] == 'y160102') {
                        $_num_db = $this->obj_db->update(BG_DB_TABLE . 'tag_belong', $_arr_belongData, '`belong_id`=' . $_arr_belongRow['belong_id']); //删除数据
                        if ($_num_db > 0) {
                            $_str_rcode = 'y160103';
                        } else {
                            $_str_rcode = 'x160103';
                        }
                    } else {
                        $_num_belongId = $this->obj_db->insert(BG_DB_TABLE . 'tag_belong', $_arr_belongData);

                        if ($_num_belongId > 0) { //数据库插入是否成功
                            $_str_rcode = 'y160101';
                        } else {
                            $_str_rcode = 'x160101';
                        }
                    }
                } else {
                    $_arr_belongData = array(
                        'belong_tag_id'  => 0,
                    );

                    $_num_db = $this->obj_db->update(BG_DB_TABLE . 'tag_belong', $_arr_belongData, '`belong_id`=' . $_arr_belongRow['belong_id']); //删除数据

                    if ($_num_db > 0) {
                        $_str_rcode = 'y160103';
                    } else {
                        $_str_rcode = 'x160103';
                    }
                }
            }
        }

        return array(
            'rcode'  => $_str_rcode,
        );
    }


    /**
     * mdl_read function.
     *
     * @access public
     * @param mixed $str_belong
     * @param string $str_readBy (default: 'belong_id')
     * @param int $num_notThisId (default: 0)
     * @param int $num_parentId (default: 0)
     * @return void
     */
    function mdl_read($num_articleId = 0, $num_tagId = 0) {
        $_arr_belongSelect = array(
            'belong_article_id',
            'belong_tag_id',
        );

        $_str_sqlWhere = '`belong_tag_id`=' . $num_tagId;

        if ($num_articleId > 0) {
            $_str_sqlWhere .= ' AND `belong_article_id`=' . $num_articleId;
        }

        $_arr_belongRows  = $this->obj_db->select(BG_DB_TABLE . 'tag_belong',  $_arr_belongSelect, $_str_sqlWhere, '', '', 1, 0); //检查本地表是否存在记录

        if (isset($_arr_belongRows[0])) {
            $_arr_belongRow   = $_arr_belongRows[0];
        } else {
            return array(
                'rcode' => 'x160102', //不存在记录
            );
        }

        $_arr_belongRow['rcode'] = 'y160102';

        return $_arr_belongRow;
    }


    function mdl_count($num_tagId = 0) {
        $_str_sqlWhere = '1';

        if ($num_tagId > 0) {
            $_str_sqlWhere .= ' AND `belong_tag_id`=' . $num_tagId;
        }

        $_num_tagCount  = $this->obj_db->count(BG_DB_TABLE . 'tag_belong', $_str_sqlWhere);

        return $_num_tagCount;
    }


    /**
     * mdl_del function.
     *
     * @access public
     * @param int $num_tagId (default: 0)
     * @param int $num_articleId (default: 0)
     * @return void
     */
    function mdl_del($num_tagId = 0, $num_articleId = 0, $arr_tagIds = false, $arr_articleIds = false, $arr_notTagIds = false, $arr_notArticleIds = false) {

        $_str_sqlWhere = '1';

        if ($num_tagId > 0) {
            $_str_sqlWhere .= ' AND `belong_tag_id`=' . $num_tagId;
        }

        if ($num_articleId > 0) {
            $_str_sqlWhere .= ' AND `belong_article_id`=' . $num_articleId;
        }

        if (!fn_isEmpty($arr_tagIds)) {
            $_str_tagIds     = implode(',', $arr_tagIds);
            $_str_sqlWhere  .= ' AND `belong_tag_id` IN (' . $_str_tagIds . ')';
        }

        if (!fn_isEmpty($arr_articleIds)) {
            $_str_articleIds = implode(',', $arr_articleIds);
            $_str_sqlWhere  .= ' AND `belong_article_id` IN (' . $_str_articleIds . ')';
        }

        if (!fn_isEmpty($arr_notTagIds)) {
            $_str_notTagIds     = implode(',', $arr_notTagIds);
            $_str_sqlWhere  .= ' AND `belong_tag_id` NOT IN (' . $_str_notTagIds . ')';
        }

        if (!fn_isEmpty($arr_notArticleIds)) {
            $_str_notArticleIds = implode(',', $arr_notArticleIds);
            $_str_sqlWhere  .= ' AND `belong_article_id` NOT IN (' . $_str_notArticleIds . ')';
        }

        $_arr_belongData = array(
            'belong_tag_id'  => 0,
        );

        $_num_db = $this->obj_db->update(BG_DB_TABLE . 'tag_belong', $_arr_belongData, $_str_sqlWhere); //删除数据

        if ($_num_db > 0) {
            $_str_rcode = 'y160104';
        } else {
            $_str_rcode = 'x160104';
        }

        return array(
            'rcode' => $_str_rcode,
        ); //成功
    }
}
