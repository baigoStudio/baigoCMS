<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\gen;

use app\model\index\Cate as Cate_Index;
use ginkgo\Config;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------栏目模型-------------*/
class Cate extends Cate_Index {

    function read($mix_cate, $str_by = 'cate_id') {
        $_arr_select = array(
            'cate_id',
            'cate_name',
            'cate_alias',
            'cate_tpl',
            'cate_content',
            'cate_link',
            'cate_parent_id',
            'cate_prefix',
            'cate_perpage',
            'cate_ftp_host',
            'cate_ftp_port',
            'cate_ftp_user',
            'cate_ftp_pass',
            'cate_ftp_path',
            'cate_ftp_pasv',
            'cate_status',
            'cate_order',
        );

        $_arr_cateRow = $this->readProcess($mix_cate, $str_by, 0, -1, $_arr_select);

        if ($_arr_cateRow['rcode'] != 'y250102') {
            return $_arr_cateRow;
        }

        return $this->rowProcess($_arr_cateRow);
    }


    function next($num_cateId) {
        $_arr_select = array(
            'cate_id',
            'cate_name',
            'cate_alias',
            'cate_tpl',
            'cate_content',
            'cate_link',
            'cate_parent_id',
            'cate_prefix',
            'cate_perpage',
            'cate_ftp_host',
            'cate_ftp_port',
            'cate_ftp_user',
            'cate_ftp_pass',
            'cate_ftp_path',
            'cate_ftp_pasv',
            'cate_status',
            'cate_order',
        );

        $_arr_cateRow = $this->where('cate_id', '>', $num_cateId)->order('cate_id', 'ASC')->find($_arr_select);

        if (!$_arr_cateRow) {
            return array(
                'rcode' => 'x250102', //不存在记录
            );
        }

        $_arr_cateRow['rcode']    = 'y250102';

        return $this->rowProcess($_arr_cateRow);
    }


    function pathProcess($arr_cateRow = array(), $num_page = 1) {
        $_str_routeCate  = Config::get('cate', 'index.route');
        $_str_visitFile  = Config::get('visit_file', 'var_extra.visit');

        $_str_catePathRoot  = GK_PATH_PUBLIC . $_str_routeCate . DS;
        $_str_catePathName  = $this->nameProcess($arr_cateRow, DS);
        $_str_catePathFile  = 'page-' . $num_page . '.' . $_str_visitFile;
        $_str_catePathIndex = 'index.' . $_str_visitFile;

        $arr_cateRow['cate_path_name'] = $_str_catePathName. $_str_catePathFile;
        $arr_cateRow['cate_path']      = $_str_catePathRoot . $_str_catePathName . $_str_catePathFile;

        if ($num_page == 1) {
            $arr_cateRow['cate_path_index'] = $_str_catePathRoot . $_str_catePathName . $_str_catePathIndex;
        }

        return $arr_cateRow;
    }

    function inputSubmit() {
        $_arr_inputParam = array(
            'cate_id'   => array('int', 0),
            'page'      => array('int', 0),
            '__token__' => array('str', ''),
        );

        $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputSubmit);

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x250201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputSubmit['rcode'] = 'y250201';

        $this->inputSubmit = $_arr_inputSubmit;

        return $_arr_inputSubmit;
    }
}
