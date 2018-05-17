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
class MODEL_ARTICLE_CONTENT {

    private $is_magic;

    function __construct() { //构造函数
        $this->obj_db     = $GLOBALS['obj_db']; //设置数据库对象
        $this->is_magic   = get_magic_quotes_gpc();
    }


    function mdl_create_table() {
        $_str_rcode = 'y120105';

        $_arr_articleCreat = array(
            'article_id'            => 'int NOT NULL AUTO_INCREMENT COMMENT \'ID\'',
            'article_content'       => 'text NOT NULL COMMENT \'内容\'',
            'article_source'        => 'varchar(300) NOT NULL COMMENT \'来源\'',
            'article_source_url'    => 'varchar(900) NOT NULL COMMENT \'来源 URL\'',
            'article_author'        => 'varchar(300) NOT NULL COMMENT \'作者\'',
        );

        $_num_db = $this->obj_db->create_table(BG_DB_TABLE . 'article_content', $_arr_articleCreat, 'article_id', '文章');

        if ($_num_db < 1) {
            $_str_rcode = 'x120111';
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
        );
    }


    /** 列出内容表字段
     * mdl_column function.
     *
     * @access public
     * @return void
     */
    function mdl_column() {
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . 'article_content');

        foreach ($_arr_colRows as $_key=>$_value) {
            $_arr_col[] = $_value['Field'];
        }

        return $_arr_col;
    }


    /** 修改表
     * mdl_alter_table function.
     *
     * @access public
     * @return void
     */
    function mdl_alter_table() {

        $_arr_col   = $this->mdl_column();
        $_arr_alter = array();

        if (!in_array('article_source', $_arr_col)) {
            $_arr_alter['article_source'] = array('ADD', 'varchar(300) NOT NULL COMMENT \'来源\'');
        }

        if (!in_array('article_source_url', $_arr_col)) {
            $_arr_alter['article_source_url'] = array('ADD', 'varchar(900) NOT NULL COMMENT \'来源\'');
        }

        if (in_array('article_auther', $_arr_col)) {
            $_arr_alter['article_auther'] = array('CHANGE', 'varchar(300) NOT NULL COMMENT \'作者\'', 'article_author');
        } else if (!in_array('article_author', $_arr_col)) {
            $_arr_alter['article_author'] = array('ADD', 'varchar(300) NOT NULL COMMENT \'作者\'');
        }

        $_str_rcode = 'y120115';

        if (!fn_isEmpty($_arr_alter)) {
            $_reselt = $this->obj_db->alter_table(BG_DB_TABLE . 'article_content', $_arr_alter);

            if (!fn_isEmpty($_reselt)) {
                $_str_rcode = 'y120113';
            }
        }

        return array(
            'rcode' => $_str_rcode,
        );
    }
}