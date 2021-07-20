<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Arrays;
use ginkgo\Func;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------MIME 模型-------------*/
class Mime extends Model {

    function check($mix_mime, $str_by = 'mime_id', $num_notId = 0) {
        $_arr_select = array(
            'mime_id',
        );

        return $this->readProcess($mix_mime, $str_by, $num_notId, $_arr_select);
    }


    /*============允许类型检查============
    @str_mimeName 允许类型

    返回提示
    */
    function read($mix_mime, $str_by = 'mime_id', $num_notId = 0, $arr_select = array()) {
        $_arr_mimeRow = $this->readProcess($mix_mime, $str_by, $num_notId, $arr_select);

        if ($_arr_mimeRow['rcode'] != 'y080102') {
            return $_arr_mimeRow;
        }

        return $this->rowProcess($_arr_mimeRow);
    }


    function readProcess($mix_mime, $str_by = 'mime_id', $num_notId = 0, $arr_select = array()) {
        if (Func::isEmpty($arr_select)) {
            $arr_select = array(
                'mime_id',
                'mime_content',
                'mime_ext',
                'mime_note',
            );
        }

        $_arr_where = $this->readQueryProcess($mix_mime, $str_by, $num_notId);

        $_arr_mimeRow = $this->where($_arr_where)->find($arr_select);

        if (!$_arr_mimeRow) {
            return array(
                'msg'   => 'MIME not found',
                'rcode' => 'x080102', //不存在记录
            );
        }

        $_arr_mimeRow['rcode'] = 'y080102';
        $_arr_mimeRow['msg']   = '';

        return $_arr_mimeRow;
    }


    /*============列出允许类型============
    返回多维数组
        mime_id 允许类型 ID
        mime_content 允许类型宽度
    */
    function lists($pagination = 0) {
        $_arr_mimeSelect = array(
            'mime_id',
            'mime_content',
            'mime_ext',
            'mime_note',
        );

        $_arr_pagination    = $this->paginationProcess($pagination);
        $_arr_getData       = $this->order('mime_id', 'DESC')->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select($_arr_mimeSelect);

        if (isset($_arr_getData['dataRows'])) {
            $_arr_eachData = &$_arr_getData['dataRows'];
        } else {
            $_arr_eachData = &$_arr_getData;
        }

        if (!Func::isEmpty($_arr_eachData)) {
            foreach ($_arr_eachData as $_key=>&$_value) {
                $_value = $this->rowProcess($_value);
            }
        }

        return $_arr_getData;
    }


    function count() {
        $_num_mimeCount = $this->count();

        return $_num_mimeCount;
    }


    protected function rowProcess($arr_mimeRow = array()) {
        if (isset($arr_mimeRow['mime_content'])) {
            $arr_mimeRow['mime_content'] = Arrays::fromJson($arr_mimeRow['mime_content']); //json解码
        } else {
            $arr_mimeRow['mime_content'] = array();
        }

        return $arr_mimeRow;
    }


    function readQueryProcess($mix_mime, $str_by = 'mime_id', $num_notId = 0) {
        $_arr_where[] = array($str_by, '=', $mix_mime);

        if ($num_notId > 0) {
            $_arr_where[] = array('mime_id', '<>', $num_notId);
        }

        return $_arr_where;
    }
}
