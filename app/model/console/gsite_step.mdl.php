<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Gsite;
use ginkgo\Json;
use ginkgo\Config;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------采集点模型-------------*/
class Gsite_Step extends Gsite {

    protected $table = 'gsite';

    function m_init() { //构造函数
        parent::m_init();

        $this->configContent = Config::get('gsite_step_content', 'console');
    }


    function setPageContent() { //列表解析
        $_arr_gsiteData = array(
            'gsite_page_content_selector'   => $this->inputPageContent['gsite_page_content_selector'],
            'gsite_page_content_attr'       => strtolower($this->inputPageContent['gsite_page_content_attr']),
            'gsite_page_content_filter'     => $this->inputPageContent['gsite_page_content_filter'],
            'gsite_page_content_replace'    => $this->inputPageContent['gsite_page_content_replace'],
        );

        $_num_gsiteId   = $this->inputPageContent['gsite_id'];

        $_mix_vld = $this->validate($_arr_gsiteData, '', 'page_content_db');

        if ($_mix_vld !== true) {
            return array(
                'gsite_id'  => $_num_gsiteId,
                'rcode'     => 'x270201',
                'msg'       => end($_mix_vld),
            );
        }

        $_arr_gsiteData['gsite_page_content_replace']  = Json::encode($_arr_gsiteData['gsite_page_content_replace']);

        $_num_count     = $this->where('gsite_id', '=', $_num_gsiteId)->update($_arr_gsiteData);

        if ($_num_count > 0) { //数据库更新是否成功
            $_str_rcode = 'y270103';
            $_str_msg   = 'Update site successfully';
        } else {
            $_str_rcode = 'x270103';
            $_str_msg   = 'Did not make any changes';
        }

        return array(
            'gsite_id'  => $_num_gsiteId,
            'msg'       => $_str_msg,
            'rcode'     => $_str_rcode,
        );
    }


    function setPageLists() { //列表解析
        $_arr_gsiteData = array(
            'gsite_page_list_selector'  => $this->inputPageLists['gsite_page_list_selector'],
        );

        $_num_gsiteId   = $this->inputPageLists['gsite_id'];

        $_mix_vld = $this->validate($_arr_gsiteData, '', 'page_lists_db');

        if ($_mix_vld !== true) {
            return array(
                'gsite_id'  => $_num_gsiteId,
                'rcode'     => 'x270201',
                'msg'       => end($_mix_vld),
            );
        }

        $_num_count     = $this->where('gsite_id', '=', $_num_gsiteId)->update($_arr_gsiteData);

        if ($_num_count > 0) { //数据库更新是否成功
            $_str_rcode = 'y270103';
            $_str_msg   = 'Update site successfully';
        } else {
            $_str_rcode = 'x270103';
            $_str_msg   = 'Did not make any changes';
        }

        return array(
            'gsite_id'  => $_num_gsiteId,
            'msg'       => $_str_msg,
            'rcode'     => $_str_rcode,
        );
    }

    function setLists() { //列表解析
        $_arr_gsiteData = array(
            'gsite_list_selector'   => $this->inputLists['gsite_list_selector'],
        );

        $_num_gsiteId   = $this->inputLists['gsite_id'];

        $_mix_vld = $this->validate($_arr_gsiteData, '', 'lists_db');

        if ($_mix_vld !== true) {
            return array(
                'gsite_id'  => $_num_gsiteId,
                'rcode'     => 'x270201',
                'msg'       => end($_mix_vld),
            );
        }

        $_num_count     = $this->where('gsite_id', '=', $_num_gsiteId)->update($_arr_gsiteData);

        if ($_num_count > 0) { //数据库更新是否成功
            $_str_rcode = 'y270103';
            $_str_msg   = 'Update site successfully';
        } else {
            $_str_rcode = 'x270103';
            $_str_msg   = 'Did not make any changes';
        }

        return array(
            'gsite_id'  => $_num_gsiteId,
            'msg'       => $_str_msg,
            'rcode'     => $_str_rcode,
        );
    }

    function setContent() { //列表解析
        $_arr_gsiteData = array(
            'gsite_img_filter'  => strtolower($this->inputContent['gsite_img_filter']),
            'gsite_img_src'     => strtolower($this->inputContent['gsite_img_src']),
            'gsite_keep_tag'    => strtolower($this->inputContent['gsite_keep_tag']),
            'gsite_attr_allow'  => strtolower($this->inputContent['gsite_attr_allow']),
            'gsite_ignore_tag'  => strtolower($this->inputContent['gsite_ignore_tag']),
            'gsite_attr_except' => strtolower($this->inputContent['gsite_attr_except']),
        );

        foreach ($this->configContent as $_key=>$_value) {
            $_arr_gsiteData['gsite_' . $_key . '_selector'] = $this->inputContent['gsite_' . $_key . '_selector'];
            $_arr_gsiteData['gsite_' . $_key . '_attr']     = strtolower($this->inputContent['gsite_' . $_key . '_attr']);
            $_arr_gsiteData['gsite_' . $_key . '_filter']   = $this->inputContent['gsite_' . $_key . '_filter'];
            $_arr_gsiteData['gsite_' . $_key . '_replace']  = $this->inputContent['gsite_' . $_key . '_replace'];
        }

        $_num_gsiteId   = $this->inputContent['gsite_id'];

        $_mix_vld = $this->validate($_arr_gsiteData, '', 'content_db');

        if ($_mix_vld !== true) {
            return array(
                'gsite_id'  => $_num_gsiteId,
                'rcode'     => 'x270201',
                'msg'       => end($_mix_vld),
            );
        }

        foreach ($this->configContent as $_key=>$_value) {
            $_arr_gsiteData['gsite_' . $_key . '_replace']  = Json::encode($_arr_gsiteData['gsite_' . $_key . '_replace']);
        }

        $_num_count     = $this->where('gsite_id', '=', $_num_gsiteId)->update($_arr_gsiteData);

        if ($_num_count > 0) { //数据库更新是否成功
            $_str_rcode = 'y270103';
            $_str_msg   = 'Update site successfully';
        } else {
            $_str_rcode = 'x270103';
            $_str_msg   = 'Did not make any changes';
        }

        return array(
            'gsite_id'  => $_num_gsiteId,
            'msg'       => $_str_msg,
            'rcode'     => $_str_rcode,
        );
    }


    function inputPageContent() {
        $_arr_inputParam = array(
            'gsite_id'                      => array('int', 0),
            'gsite_page_content_selector'   => array('str', ''),
            'gsite_page_content_attr'       => array('str', ''),
            'gsite_page_content_filter'     => array('str', ''),
            'gsite_page_content_replace'    => array('arr', array()),
            '__token__'                     => array('str', ''),
        );

        $_arr_inputPageContent = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputPageContent, '', 'page_content');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x270201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_gsiteRow = $this->check($_arr_inputPageContent['gsite_id']);

        if ($_arr_gsiteRow['rcode'] != 'y270102') {
            return $_arr_gsiteRow;
        }

        $_arr_inputPageContent['rcode'] = 'y270201';

        $this->inputPageContent = $_arr_inputPageContent;

        return $_arr_inputPageContent;
    }


    function inputPageLists() {
        $_arr_inputParam = array(
            'gsite_id'                  => array('int', 0),
            'gsite_page_list_selector'  => array('str', ''),
            '__token__'                 => array('str', ''),
        );

        $_arr_inputPageLists = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputPageLists, '', 'page_lists');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x270201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_gsiteRow = $this->check($_arr_inputPageLists['gsite_id']);

        if ($_arr_gsiteRow['rcode'] != 'y270102') {
            return $_arr_gsiteRow;
        }

        $_arr_inputPageLists['rcode'] = 'y270201';

        $this->inputPageLists = $_arr_inputPageLists;

        return $_arr_inputPageLists;
    }


    function inputLists() {
        $_arr_inputParam = array(
            'gsite_id'              => array('int', 0),
            'gsite_list_selector'   => array('str', ''),
            '__token__'             => array('str', ''),
        );

        $_arr_inputLists = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputLists, '', 'lists');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x270201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_gsiteRow = $this->check($_arr_inputLists['gsite_id']);

        if ($_arr_gsiteRow['rcode'] != 'y270102') {
            return $_arr_gsiteRow;
        }

        $_arr_inputLists['rcode'] = 'y270201';

        $this->inputLists = $_arr_inputLists;

        return $_arr_inputLists;
    }


    function inputContent() {
        $_arr_inputParam = array(
            'gsite_id'          => array('int', 0),
            'gsite_keep_tag'    => array('str', ''),
            'gsite_img_filter'  => array('str', ''),
            'gsite_img_src'     => array('str', ''),
            'gsite_attr_allow'  => array('str', ''),
            'gsite_ignore_tag'  => array('str', ''),
            'gsite_attr_except' => array('str', ''),
            '__token__'         => array('str', ''),
        );

        foreach ($this->configContent as $_key=>$_value) {
            $_arr_inputParam['gsite_' . $_key . '_selector']    = array('str', '');
            $_arr_inputParam['gsite_' . $_key . '_attr']        = array('str', '');
            $_arr_inputParam['gsite_' . $_key . '_filter']      = array('str', '');
            $_arr_inputParam['gsite_' . $_key . '_replace']     = array('arr', array());
        }

        $_arr_inputContent = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputContent, '', 'content');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x270201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_gsiteRow = $this->check($_arr_inputContent['gsite_id']);

        if ($_arr_gsiteRow['rcode'] != 'y270102') {
            return $_arr_gsiteRow;
        }

        $_arr_inputContent['rcode'] = 'y270201';

        $this->inputContent = $_arr_inputContent;

        return $_arr_inputContent;
    }
}
