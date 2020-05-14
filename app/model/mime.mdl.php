<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Json;
use ginkgo\Func;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------MIME 模型-------------*/
class Mime extends Model {

    function check($mix_mime, $str_by = 'mime_id', $num_notId = 0) {
        $_arr_select = array(
            'mime_id',
        );

        $_arr_mimeRow = $this->read($mix_mime, $str_by, $num_notId, $_arr_select);

        return $_arr_mimeRow;
    }


    /*============允许类型检查============
    @str_mimeName 允许类型

    返回提示
    */
    function read($mix_mime, $str_by = 'mime_id', $num_notId = 0, $arr_select = array()) {
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

        return $this->rowProcess($_arr_mimeRow);
    }


    /*============列出允许类型============
    返回多维数组
        mime_id 允许类型 ID
        mime_content 允许类型宽度
    */
    function lists($num_no, $num_except = 0) {
        $_arr_mimeSelect = array(
            'mime_id',
            'mime_content',
            'mime_ext',
            'mime_note',
        );

        $_arr_mimeRows = $this->order('mime_id', 'DESC')->limit($num_except, $num_no)->select($_arr_mimeSelect);

        foreach ($_arr_mimeRows as $_key=>$_value) {
            $_arr_mimeRows[$_key]['mime_content'] = Json::decode($_value['mime_content']);
        }

        return $_arr_mimeRows;
    }


    function count() {
        $_num_mimeCount = $this->count();

        return $_num_mimeCount;
    }


    protected function rowProcess($arr_mimeRow = array()) {
        if (isset($arr_mimeRow['mime_content'])) {
            $arr_mimeRow['mime_content'] = Json::decode($arr_mimeRow['mime_content']); //json解码
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
