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
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------自定义字段模型-------------*/
class Custom extends Model {

    private $create;

    function m_init() {
        $_mdl_custom = Loader::model('Custom', '', false);
        $this->arr_status   = $_mdl_custom->arr_status;
        $this->arr_type     = $_mdl_custom->arr_type;
        $this->arr_format   = $_mdl_custom->arr_format;

        $_str_status    = implode('\',\'', $this->arr_status);
        $_str_type      = implode('\',\'', $this->arr_type);
        $_str_format    = implode('\',\'', $this->arr_format);

        $this->create = array(
            'custom_id' => array(
                'type'      => 'smallint(6)',
                'not_null'  => true,
                'ai'        => true,
                'comment'   => 'ID',
            ),
            'custom_name' => array(
                'type'      => 'varchar(90)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '名称',
            ),
            'custom_type' => array(
                'type'      => 'enum(\'' . $_str_type . '\')',
                'not_null'  => true,
                'default'   => $this->arr_type[0],
                'comment'   => '类型',
                'update'    => $this->arr_type[0],
            ),
            'custom_status' => array(
                'type'      => 'enum(\'' . $_str_status . '\')',
                'not_null'  => true,
                'default'   => $this->arr_status[0],
                'comment'   => '状态',
                'update'    => $this->arr_status[0],
            ),
            'custom_format' => array(
                'type'      => 'enum(\'' . $_str_format . '\')',
                'not_null'  => true,
                'default'   => $this->arr_format[0],
                'comment'   => '格式',
                'update'    => $this->arr_format[0],
            ),
            'custom_opt' => array(
                'type'      => 'varchar(1000)',
                'not_null'  => true,
                'default'   => '',
                'comment'   => '选项',
            ),
            'custom_order' => array(
                'type'      => 'smallint(6)',
                'not_null'  => true,
                'default'   => 0,
                'comment'   => '排序',
            ),
            'custom_parent_id' => array(
                'type'      => 'smallint(6)',
                'not_null'  => true,
                'default'   => 0,
                'comment'   => '父字段',
            ),
            'custom_cate_id' => array(
                'type'      => 'smallint(6)',
                'not_null'  => true,
                'default'   => 0,
                'comment'   => '栏目ID',
            ),
            'custom_size' => array(
                'type'      => 'smallint(6)',
                'not_null'  => true,
                'default'   => 0,
                'comment'   => '字段长度',
            ),
        );
    }


    /**
     * mdl_create_table function.
     *
     * @access public
     * @return void
     */
    function createTable() {
        $_num_count  = $this->create($this->create, 'custom_id', '自定义字段');

        if ($_num_count !== false) {
            $_str_rcode = 'y200105'; //更新成功
            $_str_msg   = 'Create table successfully';
        } else {
            $_str_rcode = 'x200105'; //更新成功
            $_str_msg   = 'Create table failed';
        }

        return array(
            'rcode' => $_str_rcode, //更新成功
            'msg'   => $_str_msg,
        );
    }



    function alterTable() {
        $_arr_alter = $this->alterProcess($this->create);

        $_str_rcode = 'y200111';
        $_str_msg   = 'No need to update table';

        if (!Func::isEmpty($_arr_alter)) {
            $_num_count  = $this->alter($_arr_alter);

            if ($_num_count !== false) {
                $_str_rcode = 'y200106';
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
                $_str_rcode = 'x200106';
                $_str_msg   = 'Update table failed';
            }
        }

        unset($_arr_alter);

        $_arr_col = $this->show();

        if (isset($_arr_col['custom_type'])) {
            $_str_type      = implode('\',\'', $this->arr_type);

            $_arr_customData = array(
                'custom_type' => 'text'
            );
            $this->update($_arr_customData); //全部更新为 text 类型 (原类型内包含)

            $_arr_alter['custom_type'] = array('CHANGE', 'enum(\'' . $_str_type . '\',\'text\') NOT NULL DEFAULT \'' . $this->arr_type[0] . '\' COMMENT \'类型\'', 'custom_type');

            $this->alter($_arr_alter);

            $_arr_customData = array(
                'custom_type' => $this->arr_type[0],
            );
            $this->update($_arr_customData); //全部更新为 str 类型

            $_arr_alter['custom_type'] = array('CHANGE', 'enum(\'' . $_str_type . '\') NOT NULL DEFAULT \'' . $this->arr_type[0] . '\' COMMENT \'类型\'', 'custom_type');

            $this->alter($_arr_alter);
        }

        return array(
            'rcode' => $_str_rcode,
            'msg'   => $_str_msg,
        );
    }


    function dropColumn() {
        $_arr_col   = $this->show();
        $_arr_alter = array();

        $_str_rcode = 'y200115';
        $_str_msg   = 'No need to drop fields';

        if (in_array('custom_target', $_arr_col)) {
            $_arr_alter['custom_target'] = array('DROP');
        }

        if (!Func::isEmpty($_arr_alter)) {
            $_reselt = $this->alter($_arr_alter);

            $_num_count  = $this->alter($_arr_alter);

            if ($_num_count !== false) {
                $_str_rcode = 'y200113';
                $_str_msg   = 'Drop fields successfully';
            } else {
                $_str_rcode = 'x200113';
                $_str_msg   = 'Drop fields failed';
            }
        }

        return array(
            'rcode' => $_str_rcode,
        );
    }
}
