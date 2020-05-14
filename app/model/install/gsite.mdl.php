<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\install;

use app\classes\install\Model;
use ginkgo\Loader;
use ginkgo\Func;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------采集点模型-------------*/
class Gsite extends Model {

    private $create;

    function m_init() {
        $_mdl_gsite = Loader::model('Gsite', '', false);
        $this->arr_status = $_mdl_gsite->arr_status;

        $_str_status = implode('\',\'', $this->arr_status);

        $this->create = array(
            'gsite_id' => array(
                'type'      => 'smallint(6)',
                'not_null'  => true,
                'ai'        => true,
                'comment'   => 'ID',
            ),
            'gsite_name' => array(
                'type'      => 'varchar(300)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '采集点',
            ),
            'gsite_url' => array(
                'type'      => 'varchar(900)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '目标 URL',
            ),
            'gsite_status' => array(
                'type'      => 'enum(\'' . $_str_status . '\')',
                'not_null'  => true,
                'default'   => $this->arr_status[0],
                'comment'   => '状态',
                'update'    => $this->arr_status[0],
            ),
            'gsite_keep_tag' => array(
                'type'      => 'varchar(300)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '保留标签',
            ),
            'gsite_note' => array(
                'type'      => 'varchar(30)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '备注',
            ),
            'gsite_charset' => array(
                'type'      => 'varchar(100)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '字符编码',
            ),
            'gsite_cate_id' => array(
                'type'      => 'smallint(6)',
                'not_null'  => true,
                'default'   => 0,
                'comment'   => '隶属于栏目',
            ),
            'gsite_list_selector' => array(
                'type'      => 'varchar(100)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '列表选择器',
            ),
            'gsite_title_selector' => array(
                'type'      => 'varchar(100)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '标题选择器',
            ),
            'gsite_title_attr' => array(
                'type'      => 'varchar(100)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '标题属性',
            ),
            'gsite_title_filter' => array(
                'type'      => 'varchar(100)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '标题过滤器',
            ),
            'gsite_title_replace' => array(
                'type'      => 'varchar(900)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '标题替换',
            ),
            'gsite_content_selector' => array(
                'type'      => 'varchar(100)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '内容选择器',
            ),
            'gsite_content_attr' => array(
                'type'      => 'varchar(100)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '内容属性',
            ),
            'gsite_content_filter' => array(
                'type'      => 'varchar(100)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '内容过滤器',
            ),
            'gsite_content_replace' => array(
                'type'      => 'varchar(900)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '内容替换',
            ),
            'gsite_time_selector' => array(
                'type'      => 'varchar(100)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '时间选择器',
            ),
            'gsite_time_attr' => array(
                'type'      => 'varchar(100)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '时间属性',
            ),
            'gsite_time_filter' => array(
                'type'      => 'varchar(100)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '时间过滤器',
            ),
            'gsite_time_replace' => array(
                'type'      => 'varchar(900)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '时间替换',
            ),
            'gsite_source_selector' => array(
                'type'      => 'varchar(100)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '文章来源选择器',
            ),
            'gsite_source_attr' => array(
                'type'      => 'varchar(100)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '文章来源属性',
            ),
            'gsite_source_filter' => array(
                'type'      => 'varchar(100)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '文章来源过滤器',
            ),
            'gsite_source_replace' => array(
                'type'      => 'varchar(900)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '文章来源替换',
            ),
            'gsite_author_selector' => array(
                'type'      => 'varchar(100)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '作者选择器',
                'old'       => 'gsite_auther_selector',
            ),
            'gsite_author_attr' => array(
                'type'      => 'varchar(100)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '作者属性',
            ),
            'gsite_author_filter' => array(
                'type'      => 'varchar(100)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '作者过滤器',
            ),
            'gsite_author_replace' => array(
                'type'      => 'varchar(900)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '作者替换',
            ),
            'gsite_page_list_selector' => array(
                'type'      => 'varchar(100)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '分页链接选择器',
            ),
            'gsite_page_content_selector' => array(
                'type'      => 'varchar(100)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '分页内容选择器',
            ),
            'gsite_page_content_attr' => array(
                'type'      => 'varchar(100)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '分页内容属性',
            ),
            'gsite_page_content_filter' => array(
                'type'      => 'varchar(100)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '分页内容过滤器',
            ),
            'gsite_page_content_replace' => array(
                'type'      => 'varchar(900)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '分页内容替换',
            ),
            'gsite_img_filter' => array(
                'type'      => 'varchar(100)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '图片过滤器',
            ),
            'gsite_img_src' => array(
                'type'      => 'varchar(100)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '图片地址属性',
            ),
            'gsite_attr_allow' => array(
                'type'      => 'varchar(100)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '允许的属性',
            ),
            'gsite_ignore_tag' => array(
                'type'      => 'varchar(300)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '忽略标签',
            ),
            'gsite_attr_except' => array(
                'type'      => 'varchar(900)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '例外',
            ),
        );
    }


    function createTable() {
        $_num_count  = $this->create($this->create, 'gsite_id', '采集点');

        if ($_num_count !== false) {
            $_str_rcode = 'y270105'; //更新成功
            $_str_msg   = 'Create table successfully';
        } else {
            $_str_rcode = 'x270105'; //更新成功
            $_str_msg   = 'Create table failed';
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
            'msg'   => $_str_msg,
        );
    }



    function alterTable() {
        $_arr_alter = $this->alterProcess($this->create);

        $_str_rcode = 'y270111';
        $_str_msg   = 'No need to update table';

        if (!Func::isEmpty($_arr_alter)) {
            $_num_count  = $this->alter($_arr_alter);

            if ($_num_count !== false) {
                $_str_rcode = 'y270106';
                $_str_msg   = 'Update table successfully';

                foreach ($this->create as $_key=>$_value) {
                    if (isset($_value['update'])) {
                        $_arr_data = array(
                            $_key => $_value['update'],
                        );
                        $this->where('LENGTH(`' . $_key . '`) < 1')->update($_arr_data);
                    }
                }
            } else {
                $_str_rcode = 'x270106';
                $_str_msg   = 'Update table failed';
            }
        }

        return array(
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }
}
