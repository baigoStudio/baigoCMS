<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------自定义字段值模型-------------*/
class MODEL_ARTICLE_CUSTOM {

    function __construct() { //构造函数
        $this->obj_db = $GLOBALS['obj_db']; //设置数据库对象
    }


    function mdl_create_table($arr_customRows) {
        $_str_rcode = 'x210105';

        $_arr_articleCreat = array(
            'article_id' => 'int NOT NULL AUTO_INCREMENT COMMENT \'ID\'',
        );

        //print_r($arr_customRows);

        foreach ($arr_customRows as $_key=>$_value) {
            $_arr_articleCreat['custom_' . $_value['custom_id']] = 'varchar(' . $_value['custom_size'] . ') NOT NULL COMMENT \'自定义字段 ' . $_value['custom_id'] . '\'';
        }

        $_num_db = $this->obj_db->create_table(BG_DB_TABLE . 'article_custom', $_arr_articleCreat, 'article_id', '自定义字段'); //创建表

        if ($_num_db > 1) {
            $_str_rcode = 'y210105';
        }

        $_arr_col     = $this->mdl_column();
        $_arr_alter   = array();
        $_arr_custom  = array();

        foreach ($arr_customRows as $_key=>$_value) {
            if ($_value['custom_size'] < 1) {
                $_value['custom_size'] = 90;
            }

            if (in_array('custom_' . $_value['custom_id'], $_arr_col)) {
                $_arr_alter['custom_' . $_value['custom_id']] = array('CHANGE', 'varchar(' . $_value['custom_size'] . ') NOT NULL COMMENT \'' . $_value['custom_id'] . ' ' . $_value['custom_name'] . '\'', 'custom_' . $_value['custom_id']); //如果字段存在,修改字段
            } else {
                $_arr_alter['custom_' . $_value['custom_id']] = array('ADD', 'varchar(' . $_value['custom_size'] . ') NOT NULL COMMENT \'' . $_value['custom_id'] . ' ' . $_value['custom_name'] . '\''); //创建字段
            }
            $_arr_custom[] = 'custom_' . $_value['custom_id'];
        }

        if (!in_array('article_id', $_arr_col)) {
            $_arr_alter['article_id'] = array('ADD', 'int NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT \'ID\'');
        }

        foreach ($_arr_col as $_key=>$_value) {
            if (!in_array($_value, $_arr_custom) && $_value != 'article_id') {
                $_arr_alter[$_value] = array('DROP'); //丢弃字段
            }
        }

        //print_r($_arr_alter);

        if (!fn_isEmpty($_arr_alter)) {
            $_reselt = $this->obj_db->alter_table(BG_DB_TABLE . 'article_custom', $_arr_alter);

            if (!fn_isEmpty($_reselt)) {
                $_str_rcode = 'y210105';
            }
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
        );
    }


    function mdl_column() {
        $_arr_colRows = $this->obj_db->show_columns(BG_DB_TABLE . 'article_custom');

        $_arr_col = array();

        if (!fn_isEmpty($_arr_colRows)) {
            foreach ($_arr_colRows as $_key=>$_value) {
                $_arr_col[] = $_value['Field'];
            }
        }

        return $_arr_col;
    }
}
