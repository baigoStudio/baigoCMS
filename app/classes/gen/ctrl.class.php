<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\classes\gen;

use app\classes\console\Ctrl as Ctrl_Console;
use ginkgo\Loader;
use ginkgo\Config;
use ginkgo\File;
use ginkgo\Func;
use ginkgo\Ftp;
use ginkgo\View;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');


/*-------------控制中心通用控制器-------------*/
abstract class Ctrl extends Ctrl_Console {

    protected function c_init($param = array()) {
        parent::c_init();

        $this->obj_index    = Loader::classes('Index', '', false);

        $this->obj_file     = File::instance();

        $this->mdl_cate     = Loader::model('Cate');
    }


    protected function configProcess() {
        parent::configProcess();

        $_str_configIndex   = BG_PATH_CONFIG . 'console' . DS . 'common' . GK_EXT_INC;
        Config::load($_str_configIndex, 'console');
    }


    protected function outputProcess($arr_tplData, $str_pathFile, $str_tplPath, $str_tplName) {
        $_mix_init = $this->indexInit();

        //print_r($this->url);

        if ($_mix_init !== true) {
            return $_mix_init;
        }

        $arr_tplData['path_tpl_index'] = $str_tplPath;

        $_arr_tpl = array_replace_recursive($this->generalData, $arr_tplData);

        $_obj_view  = View::instance();
        $_obj_view->setPath($str_tplPath);

        $_obj_view->assign($_arr_tpl);

        $_str_outPut = '';

        if (!$_obj_view->has($str_tplName)) {
            return array(
                'rcode' => 'x030410',
                'msg'   => 'Template not found',
            );
        }

        //print_r($str_tplPath);

        $_str_outPut = $_obj_view->fetch($str_tplName);

        return $this->obj_file->fileWrite($str_pathFile, $_str_outPut);
    }


    protected function cateProcess($num_cateId, $num_page = 1) {
        //print_r($num_cateId);

        $_arr_cateRow = $this->obj_index->cateRead($num_cateId);

        if ($_arr_cateRow['rcode'] != 'y250102') {
            return $_arr_cateRow;
        }

        $_arr_cateRow['cate_tpl_do'] = $this->mdl_cate->tplProcess($_arr_cateRow['cate_id']);

        if ($this->ftpOpen && !$this->ftpInit) {
            //$this->mdl_cate   = Loader::model('Cate', '', 'console');

            $_arr_ftpRow = $this->mdl_cate->read($_arr_cateRow['cate_breadcrumb'][0]['cate_id']);

            $_config_ftp = array(
                'host' => $_arr_ftpRow['cate_ftp_host'],
                'port' => $_arr_ftpRow['cate_ftp_port'],
                'user' => $_arr_ftpRow['cate_ftp_user'],
                'pass' => $_arr_ftpRow['cate_ftp_pass'],
                'path' => $_arr_ftpRow['cate_ftp_path'],
                'pasv' => $_arr_ftpRow['cate_ftp_pasv'],
            );

            if (!Func::isEmpty($_config_ftp['host']) && !Func::isEmpty($_config_ftp['user']) && !Func::isEmpty($_config_ftp['pass'])) {
                $this->obj_ftp = Ftp::instance($_config_ftp);
                $this->ftpInit   = true;
            }
        }

        $_arr_cateRow  = $this->mdl_cate->pathProcess($_arr_cateRow, $num_page);

        $this->cateRow = $_arr_cateRow;

        return $_arr_cateRow;
    }
}
