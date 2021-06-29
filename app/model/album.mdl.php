<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model;

use app\classes\Model;
use ginkgo\Func;
use ginkgo\Arrays;
use ginkgo\Config;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------群组模型-------------*/
class Album extends Model {

    public $arr_status = array('enable', 'disabled');

    function m_init() { //构造函数
        parent::m_init();

        $this->configVisit  = Config::get('visit', 'var_extra');;
        $this->routeAlbum   = Config::get('album', 'index.route');
    }

    function ids($arr_search) {
        $_arr_albumSelect = array(
            'album_id',
        );

        $_arr_where = $this->queryProcess($arr_search);

        $_arr_albumRows = $this->where($_arr_where)->select($_arr_albumSelect);

        $_arr_albumIds  = array();

        foreach ($_arr_albumRows as $_key=>$_value) {
            $_arr_albumIds[]   = $_value['album_id'];
        }

        return Arrays::filter($_arr_albumIds);
    }


    function check($mix_album, $str_by = 'album_id', $num_notId = 0) {
        $_arr_select = array(
            'album_id',
        );

        return $this->readProcess($mix_album, $str_by, $num_notId, $_arr_select);
    }


    /**
     * read function.
     *
     * @access public
     * @param mixed $mix_album
     * @param string $str_by (default: 'album_id')
     * @param int $num_notId (default: 0)
     * @return void
     */
    function read($mix_album, $str_by = 'album_id', $num_notId = 0, $arr_select = array()) {
        $_arr_albumRow = $this->readProcess($mix_album, $str_by, $num_notId, $arr_select);

        if ($_arr_albumRow['rcode'] != 'y060102') {
            return $_arr_albumRow;
        }

        return $this->rowProcess($_arr_albumRow);
    }



    function readProcess($mix_album, $str_by = 'album_id', $num_notId = 0, $arr_select = array()) {
        if (Func::isEmpty($arr_select)) {
            $arr_select = array(
                'album_id',
                'album_name',
                'album_content',
                'album_status',
                'album_time',
                'album_attach_id',
                'album_tpl',
            );
        }

        $_arr_where = $this->readQueryProcess($mix_album, $str_by, $num_notId);

        $_arr_albumRow = $this->where($_arr_where)->find($arr_select);

        if (!$_arr_albumRow) {
            return array(
                'msg'   => 'Album not found',
                'rcode' => 'x060102', //不存在记录
            );
        }

        $_arr_albumRow['rcode'] = 'y060102';
        $_arr_albumRow['msg']   = '';

        //print_r($_arr_albumRow);

        return $_arr_albumRow;
    }



    /**
     * mdl_list function.
     *
     * @access public
     * @param string $str_key (default: '')
     * @param string $str_type (default: '')
     * @return void
     */
    function lists($pagination = 0, $arr_search = array()) {

        $_arr_albumSelect = array(
            'album_id',
            'album_name',
            'album_status',
            'album_time',
            'album_attach_id',
        );

        $_arr_where         = $this->queryProcess($arr_search);
        $_arr_pagination    = $this->paginationProcess($pagination);
        $_arr_getData       = $this->where($_arr_where)->order('album_id', 'DESC')->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select($_arr_albumSelect);

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


    /**
     * mdl_count function.
     *
     * @access public
     * @param string $str_key (default: '')
     * @param string $str_status (default: '')
     * @return void
     */
    function count($arr_search = array()) {
        $_arr_where = $this->queryProcess($arr_search);

        return $this->where($_arr_where)->count();
    }


    protected function queryProcess($arr_search = array()) {
        $_arr_where = array();

        if (isset($arr_search['key']) && !Func::isEmpty($arr_search['key'])) {
            $_arr_where[] = array('album_name', 'LIKE', '%' . $arr_search['key'] . '%', 'key');
        }

        if (isset($arr_search['status']) && !Func::isEmpty($arr_search['status'])) {
            $_arr_where[] = array('album_status', '=', $arr_search['status']);
        }

        if (isset($arr_search['album_ids']) && !Func::isEmpty($arr_search['album_ids'])) {
            $arr_search['album_ids'] = Arrays::filter($arr_search['album_ids']);

            $_arr_where[] = array('album_id', 'IN', $arr_search['album_ids'], 'album_ids');
        }

        return $_arr_where;
    }


    function readQueryProcess($mix_album, $str_by = 'album_id', $num_notId = 0) {
        $_arr_where[] = array($str_by, '=', $mix_album);

        if ($num_notId > 0) {
            $_arr_where[] = array('album_id', '<>', $num_notId);
        }

        return $_arr_where;
    }


    protected function rowProcess($arr_albumRow = array()) {
        $_str_albumNameUrl                = 'id/' . $arr_albumRow['album_id'] . '/';
        $arr_albumRow['album_url_name']   = $_str_albumNameUrl;

        return $arr_albumRow;
    }
}
