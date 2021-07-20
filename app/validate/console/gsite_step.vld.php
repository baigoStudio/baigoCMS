<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\validate\console;

use ginkgo\Validate;
use ginkgo\Config;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------管理员模型-------------*/
class Gsite_Step extends Validate {

    protected $rule     = array(
        'gsite_id' => array(
            '>' => 0,
        ),
        'gsite_list_selector' => array(
            'length'  => '1,100'
        ),
        'gsite_keep_tag' => array(
            'max' => 300
        ),
        'gsite_img_filter' => array(
            'max' => 100
        ),
        'gsite_img_src' => array(
            'max' => 100
        ),
        'gsite_attr_allow' => array(
            'max' => 100
        ),
        'gsite_ignore_tag' => array(
            'max' => 300
        ),
        'gsite_page_list_selector' => array(
            'length'  => '1,100'
        ),
        'gsite_page_content_selector' => array(
            'length' => '1,100'
        ),
        'gsite_page_content_attr' => array(
            'max' => 100
        ),
        'gsite_page_content_filter' => array(
            'max' => 100
        ),
        '__token__' => array(
            'require' => true,
            'token'   => true,
        ),
    );

    protected $scene    = array(
        'lists' => array(
            'gsite_id',
            'gsite_list_selector',
            '__token__',
        ),
        'lists_db' => array(
            'gsite_list_selector',
        ),
        'content' => array(
            'gsite_id',
            'gsite_keep_tag',
            'gsite_img_filter',
            'gsite_img_src',
            'gsite_attr_allow',
            'gsite_ignore_tag',
            '__token__',
        ),
        'content_db' => array(
            'gsite_keep_tag',
            'gsite_img_filter',
            'gsite_img_src',
            'gsite_attr_allow',
            'gsite_ignore_tag',
        ),
        'page_lists' => array(
            'gsite_id',
            'gsite_page_list_selector',
            '__token__',
        ),
        'page_lists_db' => array(
            'gsite_page_list_selector',
        ),
        'page_content' => array(
            'gsite_id',
            'gsite_page_content_selector',
            'gsite_page_content_attr',
            'gsite_page_content_filter',
            '__token__',
        ),
        'page_content_db' => array(
            'gsite_page_content_selector',
            'gsite_page_content_attr',
            'gsite_page_content_filter',
        ),
    );

    function v_init() { //构造函数
        $_arr_configContent    = Config::get('gsite_step_content', 'console');

        $_arr_attrName = array(
            'gsite_id'                      => $this->obj_lang->get('ID'),
            'gsite_list_selector'           => $this->obj_lang->get('List selector'),
            'gsite_keep_tag'                => $this->obj_lang->get('Retained tags'),
            'gsite_img_filter'              => $this->obj_lang->get('Filter image'),
            'gsite_img_src'                 => $this->obj_lang->get('Attribute of image source'),
            'gsite_attr_allow'              => $this->obj_lang->get('Retained attributes'),
            'gsite_ignore_tag'              => $this->obj_lang->get('Ignore tags'),
            'gsite_page_list_selector'      => $this->obj_lang->get('List selector'),
            'gsite_page_content_selector'   => $this->obj_lang->get('Selector'),
            'gsite_page_content_attr'       => $this->obj_lang->get('Gathering attribute'),
            'gsite_page_content_filter'     => $this->obj_lang->get('Filter'),
            '__token__'                     => $this->obj_lang->get('Token'),
        );

        foreach ($_arr_configContent as $_key=>$_value) {
            if (isset($_value['require'])) {
                $_str_rule = '1';
            } else {
                $_str_rule = '0';
            }
            $this->rule['gsite_' . $_key . '_selector']['length']    = $_str_rule . ',100';
            $this->rule['gsite_' . $_key . '_attr']['max']           = 100;
            $this->rule['gsite_' . $_key . '_filter']['max']         = 100;

            $_arr_attrName['gsite_' . $_key . '_selector']  = $this->obj_lang->get('Selector');
            $_arr_attrName['gsite_' . $_key . '_attr']      = $this->obj_lang->get('Gathering attribute');
            $_arr_attrName['gsite_' . $_key . '_filter']    = $this->obj_lang->get('Filter');
        }

        $_arr_typeMsg = array(
            'max'       => $this->obj_lang->get('Max size of {:attr} must be {:rule}'),
            'length'    => $this->obj_lang->get('Size of {:attr} must be {:rule}'),
            'gt'        => $this->obj_lang->get('{:attr} require'),
            'require'   => $this->obj_lang->get('{:attr} require'),
            'token'     => $this->obj_lang->get('Form token is incorrect'),
        );

        $this->setAttrName($_arr_attrName);
        $this->setTypeMsg($_arr_typeMsg);
    }
}
