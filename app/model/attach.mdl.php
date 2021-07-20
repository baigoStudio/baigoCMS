<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\Arrays;
use ginkgo\Config;
use ginkgo\Strings;

//不能非法包含或直接执行
if (!defined('IN_GINKGO')) {
    return 'Access denied';
}

/*-------------附件模型-------------*/
class Attach extends Model {

    public $thumbRows   = array();
    public $arr_box     = array('normal', 'recycle', 'reserve');

    public $urlPrefix;

    function m_init() { //构造函数
        parent::m_init();

        $_arr_configUpload  = Config::get('upload', 'var_extra');
        $_mdl_thumb         = Loader::model('Thumb', '', false);

        $this->thumbRows    = $_mdl_thumb->cache();

        $_str_dirAttach     = str_ireplace(GK_PATH_PUBLIC, '', GK_PATH_ATTACH);
        $_str_dirAttach     = str_replace(DS, '/', $_str_dirAttach);
        $_str_dirAttach     = Func::fixDs($_str_dirAttach, '/');

        $_str_dirRoot       = $this->obj_request->root();

        $this->urlPrefix    = $_str_dirRoot . $_str_dirAttach;
        $this->dirPrefix    = $_str_dirRoot . GK_NAME_STATIC . '/image/';

        if (!Func::isEmpty($_arr_configUpload['ftp_host']) && !Func::isEmpty($_arr_configUpload['url_prefix'])) {
            $this->urlPrefix = Func::fixDs($_arr_configUpload['url_prefix'], '/');
        }

        $this->configUpload = $_arr_configUpload;
        $this->dirAttach    = $_str_dirAttach;
    }


    function check($mix_attach, $str_by = 'attach_id', $str_box = '') {
        $_arr_select = array(
            'attach_id',
            'attach_time',
        );

        return $this->readProcess($mix_attach, $str_by, $str_box, $_arr_select);
    }


    function read($mix_attach, $str_by = 'attach_id', $str_box = '', $arr_select = array()) {
        $_arr_attachRow = $this->readProcess($mix_attach, $str_by, $str_box, $arr_select);

        if ($_arr_attachRow['rcode'] != 'y070102') {
            return $_arr_attachRow;
        }

        $_arr_attachRow = $this->rowProcess($_arr_attachRow);
        $_arr_attachRow = $this->thumbProcess($_arr_attachRow);

        return $_arr_attachRow;
    }


    /**
     * read function.
     *
     * @access public
     * @param mixed $num_attachId
     * @return void
     */
    function readProcess($mix_attach, $str_by = 'attach_id', $str_box = '', $arr_select = array()) {
        if (Func::isEmpty($arr_select)) {
            $arr_select = array(
                'attach_id',
                'attach_name',
                'attach_note',
                'attach_time',
                'attach_ext',
                'attach_mime',
                'attach_size',
                'attach_box',
                'attach_admin_id',
                'attach_src_hash',
            );
        }

        $_arr_where = $this->readQueryProcess($mix_attach, $str_by, $str_box);

        $_arr_attachRow = $this->where($_arr_where)->find($arr_select);

        if (!$_arr_attachRow) {
            return array(
                'msg'   => 'Attachment not found',
                'rcode' => 'x070102', //不存在记录
            );
        }

        $_arr_attachRow['rcode'] = 'y070102';
        $_arr_attachRow['msg']   = '';

        return $_arr_attachRow;
    }


    /**
     * mdl_list function.
     *
     * @access public
     * @param string $str_year (default: '')
     * @param string $str_month (default: '')
     * @param string $str_ext (default: '')
     * @param int $num_adminId (default: 0)
     * @return void
     */
    function lists($pagination = 0, $arr_search = array(), $arr_order = array(), $arr_select = array()) {
        if (Func::isEmpty($arr_select)) {
            $arr_select = array(
                'attach_id',
                'attach_name',
                'attach_note',
                'attach_time',
                'attach_ext',
                'attach_mime',
                'attach_size',
                'attach_admin_id',
                'attach_box',
                'attach_src_hash',
            );
        }

        if (Func::isEmpty($arr_order)) {
            $arr_order = array('attach_id', 'DESC');
        }

        $_arr_where         = $this->queryProcess($arr_search);
        $_arr_pagination    = $this->paginationProcess($pagination);
        $_arr_getData       = $this->where($_arr_where)->order($arr_order)->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'], $_arr_pagination['pageparam'])->select($arr_select);

        if (isset($_arr_getData['dataRows'])) {
            $_arr_eachData = &$_arr_getData['dataRows'];
        } else {
            $_arr_eachData = &$_arr_getData;
        }

        if (!Func::isEmpty($_arr_eachData)) {
            foreach ($_arr_eachData as $_key=>&$_value) {
                $_value = $this->rowProcess($_value);
                $_value = $this->thumbProcess($_value);
            }
        }

        return $_arr_getData;
    }


    /**
     * mdl_count function.
     *
     * @access public
     * @param string $str_year (default: '')
     * @param string $str_month (default: '')
     * @param string $str_ext (default: '')
     * @param int $num_adminId (default: 0)
     * @return void
     */
    function count($arr_search = array()) {
        $_arr_where = $this->queryProcess($arr_search);

        return $this->where($_arr_where)->count();
    }


    function nameProcess($arr_attachRow, $arr_thumbRow = array(), $ds = '/') {
        $_str_return = date('Y', $arr_attachRow['attach_time']) . $ds . date('m', $arr_attachRow['attach_time']) . $ds . $arr_attachRow['attach_id'];

        if (!Func::isEmpty($arr_thumbRow)) {
            $_str_return .= '_' . $arr_thumbRow['thumb_width'] . '_' . $arr_thumbRow['thumb_height'] . '_' . $arr_thumbRow['thumb_type'];
        }

        return $_str_return . '.' . $arr_attachRow['attach_ext'];
    }


    protected function thumbProcess($arr_attachRow) {
        $_arr_thumbRows = array();

        $arr_attachRow['thumb_default'] = $this->dirPrefix . 'file_' . $arr_attachRow['attach_ext'] . '.png';
        $arr_attachRow['attach_thumb']  = $this->dirPrefix . 'file_' . $arr_attachRow['attach_ext'] . '.png';

        if ($arr_attachRow['attach_type'] == 'image') {
            foreach ($this->thumbRows as $_key=>$_value) {
                $_arr_thumbRows[$_key]                      = $_value;
                $_str_thumbNameUrl                          = $this->nameProcess($arr_attachRow, $_value);
                $_arr_thumbRows[$_key]['thumb_url_name']    = $_str_thumbNameUrl;
                $_arr_thumbRows[$_key]['thumb_url']         = $this->urlPrefix . $_str_thumbNameUrl;
            }

            if (isset($_arr_thumbRows[0]['thumb_url'])) {
                $arr_attachRow['thumb_default'] = $_arr_thumbRows[0]['thumb_url'];
                $arr_attachRow['attach_thumb']  = $_arr_thumbRows[0]['thumb_url'];
            }
        }

        $arr_attachRow['thumbRows'] = $_arr_thumbRows;

        return $arr_attachRow;
    }


    protected function queryProcess($arr_search = array()) {
        $_arr_where = array();

        if (isset($arr_search['key']) && !Func::isEmpty($arr_search['key'])) {
            $_arr_where[] = array('attach_name|attach_note|attach_id', 'LIKE', '%' . $arr_search['key'] . '%', 'key');
        }

        if (isset($arr_search['year']) && !Func::isEmpty($arr_search['year'])) {
            $_arr_where[] = array('FROM_UNIXTIME(`attach_time`, \'%Y\')', '=', $arr_search['year'], 'year');
        }

        if (isset($arr_search['month']) && !Func::isEmpty($arr_search['month'])) {
            $_arr_where[] = array('FROM_UNIXTIME(`attach_time`, \'%m\')', '=', $arr_search['month'], 'month');
        }

        if (isset($arr_search['ext']) && !Func::isEmpty($arr_search['ext'])) {
            $_arr_where[] = array('attach_ext', '=', $arr_search['ext']);
        }

        if (isset($arr_search['box']) && !Func::isEmpty($arr_search['box'])) {
            $_arr_where[] = array('attach_box', '=', $arr_search['box']);
        }

        if (isset($arr_search['attach_ids']) && !Func::isEmpty($arr_search['attach_ids'])) {
            $arr_search['attach_ids'] = Arrays::filter($arr_search['attach_ids']);

            $_arr_where[] = array('attach_id', 'IN', $arr_search['attach_ids'], 'attach_ids');
        }

        if (isset($arr_search['admin_id']) && $arr_search['admin_id'] > 0) {
            $_arr_where[] = array('attach_admin_id', '=', $arr_search['admin_id']);
        }

        if (isset($arr_search['min_id']) && $arr_search['min_id'] > 0) {
            $_arr_where[] = array('attach_id', '>=', $arr_search['min_id'], 'min_id');
        }

        if (isset($arr_search['max_id']) && $arr_search['max_id'] > 0) {
            $_arr_where[] = array('attach_id', '<=', $arr_search['max_id'], 'max_id');
        }

        if (isset($arr_search['album_id']) && $arr_search['album_id'] > 0) {
            $_arr_where[] = array('belong_album_id', '=', $arr_search['album_id']);
        }

        if (isset($arr_search['album_ids']) && !Func::isEmpty($arr_search['album_ids'])) {
            $arr_search['album_ids'] = Arrays::filter($arr_search['album_ids']);

            $_arr_where[] = array('belong_album_id', 'IN', $arr_search['album_ids'], 'album_ids');
        }

        return $_arr_where;
    }


    function readQueryProcess($mix_attach, $str_by = 'attach_id', $str_box = '') {
        $_arr_where[] = array($str_by, '=', $mix_attach);

        if (!Func::isEmpty($str_box)) {
            $_arr_where[] = array('attach_box', '=', $str_box);
        }

        return $_arr_where;
    }


    protected function rowProcess($arr_attachRow = array()) {
        $_arr_image         = Config::get('image');
        $_arr_imageExts     = array_keys($_arr_image);

        if (isset($arr_attachRow['attach_ext'])) {
            if (in_array($arr_attachRow['attach_ext'], $_arr_imageExts)) {
                $arr_attachRow['attach_type'] = 'image';
            } else {
                $arr_attachRow['attach_type'] = 'file';
            }
        } else {
            $arr_attachRow['attach_type'] = 'file';
        }

        if (!isset($arr_attachRow['attach_time'])) {
            $arr_attachRow['attach_time'] = 0;
        }

        if (!isset($arr_attachRow['attach_size'])) {
            $arr_attachRow['attach_size'] = 0;
        }

        $_str_attachNameUrl                  = $this->nameProcess($arr_attachRow);
        $arr_attachRow['attach_url_name']    = $_str_attachNameUrl;
        $arr_attachRow['attach_url']         = $this->urlPrefix . $_str_attachNameUrl;
        $arr_attachRow['attach_time_format'] = $this->dateFormat($arr_attachRow['attach_time']);

        $arr_attachRow['attach_size_format'] = Strings::sizeFormat($arr_attachRow['attach_size']);

        return $arr_attachRow;
    }
}
