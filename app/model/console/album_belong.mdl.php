<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/
namespace app\model\console;

use app\model\Album_Belong as Album_Belong_Base;
use ginkgo\Loader;
use ginkgo\Func;
use ginkgo\Arrays;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access denied');

/*-------------应用归属-------------*/
class Album_Belong extends Album_Belong_Base {


    /** 提交
     * choose function.
     *
     * @access public
     * @param mixed $num_attachId
     * @param mixed $num_albumId
     * @return void
     */
    function choose() {
        $_num_count = 0;

        foreach ($this->inputChoose['attach_ids'] as $_key=>$_value) {
            if ($_value > 0 && $this->inputChoose['album_id'] > 0) { //插入
                $_arr_submitResult = $this->submit($_value, $this->inputChoose['album_id']);
                if ($_arr_submitResult['rcode'] == 'y290101' || $_arr_submitResult['rcode'] == 'y290103') {
                    ++$_num_count;
                }
            }
        }

        if ($_num_count > 0) {
            $_str_rcode = 'y290103';
            $_str_msg   = 'Successfully processed {:count} datas';
        } else {
            $_str_rcode = 'x290103';
            $_str_msg   = 'Did not make any changes';
        }

        return array(
            'msg'    => $_str_msg,
            'count'  => $_num_count,
            'rcode'  => $_str_rcode,
        );
    }


    function remove() {
        $_num_count         = 0;
        $_num_countGlobal   = 0;

        foreach ($this->inputRemove['attach_ids_belong'] as $_key=>$_value) {
            if ($_value > 0 && $this->inputRemove['album_id'] > 0) { //插入
                $_arr_belongRow = $this->read($this->inputRemove['album_id'], $_value); //是否存在

                /*print_r($_arr_belongRow);
                print_r(PHP_EOL);*/

                if ($_arr_belongRow['rcode'] == 'y290102') { //存在
                    $_arr_belongData = array(
                        'belong_album_id'  => 0,
                    );

                    $_num_count = $this->delete(0, 0, false, false, false, false, $_arr_belongRow['belong_id']); //作为闲置数据

                    if ($_num_count > 0) {
                        $_num_countGlobal = $_num_countGlobal + $_num_count;
                    }
                }
            }
        }

        if ($_num_countGlobal > 0) {
            $_str_rcode = 'y290104';
            $_str_msg   = 'Successfully remove {:count} datas';
        } else {
            $_str_rcode = 'x290104';
            $_str_msg   = 'No data have been removed';
        }

        return array(
            'msg'    => $_str_msg,
            'count'  => $_num_countGlobal,
            'rcode'  => $_str_rcode,
        );
    }


    function clear($pagination = 0, $arr_search = array()) {
        $_arr_belongSelect = array(
            'belong_id',
            'belong_album_id',
            'belong_attach_id',
        );

        $_arr_where         = $this->queryProcess($arr_search);
        $_arr_pagination    = $this->paginationProcess($pagination);
        $_arr_getData       = $this->where($_arr_where)->order('belong_id', 'DESC')->limit($_arr_pagination['limit'], $_arr_pagination['length'])->paginate($_arr_pagination['perpage'], $_arr_pagination['current'])->select($_arr_belongSelect);

        if (isset($_arr_getData['dataRows'])) {
            $_arr_clearData = $_arr_getData['dataRows'];
        } else {
            $_arr_clearData = $_arr_getData;
        }

        if (!Func::isEmpty($_arr_clearData)) {
            $_mdl_attach = Loader::model('Attach');
            $_mdl_album  = Loader::model('Album');

            foreach ($_arr_getData as $_key=>$_value) {
                $_arr_attachRow = $_mdl_attach->check($_value['belong_attach_id']);

                if ($_arr_attachRow['rcode'] != 'y070102') {
                    $this->delete(0, 0, false, false, false, false, $_value['belong_id']);
                }

                $_arr_albumRow = $_mdl_album->check($_value['belong_album_id']);

                if ($_arr_albumRow['rcode'] != 'y060102') {
                    $this->delete(0, 0, false, false, false, false, $_value['belong_id']);
                }
            }
        }

        return $_arr_getData;
    }


    function submit($num_attachId, $num_albumId) {
        $_str_rcode = 'x290101';

        if ($num_attachId > 0 && $num_albumId > 0) { //插入
            $_arr_belongRow = $this->read($num_albumId, $num_attachId);

            if ($_arr_belongRow['rcode'] == 'x290102') { //插入
                $_arr_belongData = array(
                    'belong_attach_id'  => $num_attachId,
                    'belong_album_id'   => $num_albumId,
                );

                $_arr_belongRowSub = $this->read(0, $num_attachId);

                if ($_arr_belongRowSub['rcode'] == 'y290102') {
                    $_num_count     = $this->where('belong_id', '=', $_arr_belongRowSub['belong_id'])->update($_arr_belongData); //更新数

                    if ($_num_count > 0) {
                        $_str_rcode = 'y290103';
                    } else {
                        $_str_rcode = 'x290103';
                    }
                } else {
                    $_num_belongId   = $this->insert($_arr_belongData);

                    if ($_num_belongId > 0) { //数据库插入是否成功
                        $_str_rcode = 'y290101';
                    } else {
                        $_str_rcode = 'x290101';
                    }
                }
            }
        }

        return array(
            'rcode'  => $_str_rcode,
        );
    }


    /** 删除
     * delete function.
     *
     * @access public
     * @param int $num_albumId (default: 0)
     * @param int $num_attachId (default: 0)
     * @param bool $arr_albumIds (default: false)
     * @param bool $arr_attachIds (default: false)
     * @param bool $arr_notAlbumIds (default: false)
     * @param bool $arr_notAttachIds (default: false)
     * @return void
     */
    function delete($num_albumId = 0, $num_attachId = 0, $arr_albumIds = false, $arr_attachIds = false, $arr_notAlbumIds = false, $arr_notAttachIds = false, $num_belongId = 0) {

        $_arr_where = array();

        if ($num_albumId > 0) {
            $_arr_where[] = array('belong_album_id', '=', $num_albumId);
        }

        if ($num_attachId > 0) {
            $_arr_where[] = array('belong_attach_id', '=', $num_attachId);
        }

        if (!Func::isEmpty($arr_albumIds)) {
            $arr_albumIds = Arrays::filter($arr_albumIds);

            $_arr_where[] = array('belong_album_id', 'IN', $arr_albumIds, 'album_ids');
        }

        if (!Func::isEmpty($arr_attachIds)) {
            $arr_attachIds = Arrays::filter($arr_attachIds);

            $_arr_where[] = array('belong_attach_id', 'IN', $arr_attachIds, 'attach_ids');
        }

        if (!Func::isEmpty($arr_notAlbumIds)) {
            $arr_notAlbumIds = Arrays::filter($arr_notAlbumIds);

            $_arr_where[] = array('belong_album_id', 'NOT IN', $arr_notAlbumIds, 'not_album_ids');
        }

        if (!Func::isEmpty($arr_notAttachIds)) {
            $arr_notAttachIds = Arrays::filter($arr_notAttachIds);

            $_arr_where[] = array('belong_attach_id', 'NOT IN', $arr_notAttachIds, 'not_attach_ids');
        }

        if ($num_belongId > 0) {
            $_arr_where[] = array('belong_id', '=', $num_belongId);
        }

        $_arr_belongData = array(
            //'belong_attach_id'  => 0,
            'belong_album_id'   => 0,
        );

        $_num_count     = $this->where($_arr_where)->update($_arr_belongData); //更新数

        return $_num_count; //成功
    }


    function chkAttach($arr_attachRow) {
        return $this->where('belong_attach_id', '=', $arr_attachRow['attach_id'])->find('belong_id');
    }

    function inputChoose() {
        $_arr_inputParam = array(
            'album_id'    => array('int', 0),
            'attach_ids'  => array('arr', array()),
            '__token__'   => array('str', ''),
        );

        $_arr_inputChoose = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputChoose, '', 'choose');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x290201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputChoose['rcode'] = 'y290201';

        $this->inputChoose = $_arr_inputChoose;

        return $_arr_inputChoose;
    }


    function inputRemove() {
        $_arr_inputParam = array(
            'album_id'            => array('int', 0),
            'attach_ids_belong'   => array('arr', array()),
            '__token__'           => array('str', ''),
        );

        $_arr_inputRemove = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputRemove, '', 'remove');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x290201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputRemove['rcode'] = 'y290201';

        $this->inputRemove = $_arr_inputRemove;

        return $_arr_inputRemove;
    }


    function inputClear() {
        $_arr_inputParam = array(
            'max_id'    => array('int', 0),
            '__token__' => array('str', ''),
        );

        $_arr_inputClear = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputClear, '', 'clear');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x290201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputClear['rcode'] = 'y290201';

        $this->inputClear = $_arr_inputClear;

        return $_arr_inputClear;
    }
}
