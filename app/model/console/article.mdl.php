<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

namespace app\model\console;

use app\model\Article as Article_Base;
use ginkgo\Func;
use ginkgo\Html;
use ginkgo\Plugin;

//不能非法包含或直接执行
defined('IN_GINKGO') or exit('Access Denied');

/*-------------文章模型-------------*/
class Article extends Article_Base {

    public $inputSubmit = array();
    public $inputSimple = array();


    /** 提交
     * mdl_submit function.
     *
     * @access public
     * @param int $num_adminId (default: 0)
     * @param mixed $str_status
     * @return void
     */
    function submit() {
        if (isset($this->inputSubmit['article_id'])) {
            $_num_articleId = $this->inputSubmit['article_id'];
        } else {
            $_num_articleId = 0;
        }

        if (isset($this->inputSubmit['article_status'])) {
            $_arr_articleData['article_status'] = $this->inputSubmit['article_status'];
        }

        if (isset($this->inputSubmit['article_excerpt'])) {
            $_arr_articleData['article_excerpt'] = $this->inputSubmit['article_excerpt'];
        }

        if (isset($this->inputSubmit['article_mark_id'])) {
            $_arr_articleData['article_mark_id'] = $this->inputSubmit['article_mark_id'];
        }

        if (isset($this->inputSubmit['article_link'])) {
            $_arr_articleData['article_link'] = $this->inputSubmit['article_link'];
        }

        if (isset($this->inputSubmit['article_time_show'])) {
            $_arr_articleData['article_time_show'] = $this->inputSubmit['article_time_show'];
        } else if (isset($this->inputSubmit['article_time_show_format'])) {
            $_arr_articleData['article_time_show'] = Func::strtotime($this->inputSubmit['article_time_show_format']);
        }

        if (isset($this->inputSubmit['article_is_time_pub'])) {
            $_arr_articleData['article_is_time_pub'] = $this->inputSubmit['article_is_time_pub'];
        } else {
            $_arr_articleData['article_is_time_pub'] = 0;
        }

        if (isset($this->inputSubmit['article_time_pub'])) {
            $_arr_articleData['article_time_pub'] = $this->inputSubmit['article_time_pub'];
        } else {
            if ($_num_articleId > 0) { //编辑文章时
                if ($_arr_articleData['article_is_time_pub'] > 0 && isset($this->inputSubmit['article_time_pub_format'])) { //表单有输入则更新
                    $_arr_articleData['article_time_pub'] = Func::strtotime($this->inputSubmit['article_time_pub_format']);
                }
            } else { //创建文章时
                if ($_arr_articleData['article_is_time_pub'] > 0 && isset($this->inputSubmit['article_time_pub_format'])) { //表单有输入
                    $_arr_articleData['article_time_pub'] = Func::strtotime($this->inputSubmit['article_time_pub_format']);
                } else {
                    $_arr_articleData['article_time_pub'] = GK_NOW; //表单无输入则当前时间
                }
            }
        }

        if (isset($this->inputSubmit['article_is_time_hide'])) {
            $_arr_articleData['article_is_time_hide'] = $this->inputSubmit['article_is_time_hide'];
        } else {
            $_arr_articleData['article_is_time_hide'] = 0;
        }

        if (isset($this->inputSubmit['article_time_hide'])) {
            $_arr_articleData['article_time_hide'] = $this->inputSubmit['article_time_hide'];
        } else {
            if ($_arr_articleData['article_is_time_hide'] > 0 && isset($this->inputSubmit['article_time_hide_format'])) { //表单有输入则更新
                $_arr_articleData['article_time_hide'] = Func::strtotime($this->inputSubmit['article_time_hide_format']);
            }
        }

        if (isset($this->inputSubmit['article_title'])) {
            $_arr_articleData['article_title'] = $this->inputSubmit['article_title'];
        }

        if (isset($this->inputSubmit['article_cate_id'])) {
            $_arr_articleData['article_cate_id'] = $this->inputSubmit['article_cate_id'];
        }

        if (isset($this->inputSubmit['article_box'])) {
            $_arr_articleData['article_box'] = $this->inputSubmit['article_box'];
        }

        if (isset($this->inputSubmit['article_attach_id'])) {
            $_arr_articleData['article_attach_id'] = $this->inputSubmit['article_attach_id'];
        }

        if (isset($this->inputSubmit['article_tpl'])) {
            $_arr_articleData['article_tpl'] = $this->inputSubmit['article_tpl'];
        }

        if (isset($this->inputSubmit['article_is_gen'])) {
            $_arr_articleData['article_is_gen'] = $this->inputSubmit['article_is_gen'];
        }

        if ($_num_articleId > 0) {
            $_str_hook = 'edit'; //编辑文章时触发
        } else {
            $_str_hook = 'add';
        }

        $_mix_result        = Plugin::listen('filter_console_article_'. $_str_hook, $_arr_articleData);
        $_arr_articleData   = Plugin::resultProcess($_arr_articleData, $_mix_result);

        $_mix_vld = $this->validate($_arr_articleData, '', 'submit_db');

        if ($_mix_vld !== true) {
            return array(
                'article_id'    => $_num_articleId,
                'rcode'         => 'x120201',
                'msg'           => end($_mix_vld),
            );
        }

        if ($_num_articleId > 0) {
            $_num_count     = $this->where('article_id', '=', $_num_articleId)->update($_arr_articleData); //更新数

            if ($_num_count > 0) {
                $_str_rcode = 'y120103';
                $_str_msg   = 'Update article successfully';
            } else {
                $_str_rcode = 'x120103';
                $_str_msg   = 'Did not make any changes';
            }
        } else {
            if (isset($this->inputSubmit['article_admin_id'])) {
                $_arr_articleData['article_admin_id'] = $this->inputSubmit['article_admin_id'];
            }
            $_arr_articleData['article_time']        = GK_NOW;

            $_num_articleId   = $this->insert($_arr_articleData);

            if ($_num_articleId > 0) {
                $_str_rcode = 'y120101';
                $_str_msg   = 'Add article successfully';
            } else {
                $_str_rcode = 'x120101';
                $_str_msg   = 'Add article failed';
            }
        }

        if ($_num_articleId > 0) {
            $_arr_contentResult = $this->submitContent($_num_articleId);

            if ($_str_rcode == 'x120103') {
                $_str_rcode = $_arr_contentResult['rcode'];
                $_str_msg   = $_arr_contentResult['msg'];
            }

            $_arr_customResult = $this->submitCustom($_num_articleId);

            if ($_str_rcode == 'x120103') {
                $_str_rcode = $_arr_customResult['rcode'];
                $_str_msg   = $_arr_customResult['msg'];
            }
        }

        /*print_r($_arr_userRow);
        exit;*/

        return array(
            'article_id' => $_num_articleId,
            'rcode'      => $_str_rcode,
            'msg'        => $_str_msg,
        );
    }


    function submitContent($num_articleId) {
        $num_articleId = (int)$num_articleId;

        $_str_rcode = 'x120103';
        $_str_msg   = 'Did not make any changes';

        $_arr_contentSubmit = array(
            'article_id' => $num_articleId,
        );

        if (isset($this->inputSubmit['article_content'])) {
            $_arr_contentSubmit['article_content'] = $this->inputSubmit['article_content'];
        }

        if (isset($this->inputSubmit['article_source'])) {
            $_arr_contentSubmit['article_source'] = $this->inputSubmit['article_source'];
        }

        if (isset($this->inputSubmit['article_source_url'])) {
            $_arr_contentSubmit['article_source_url'] = $this->inputSubmit['article_source_url'];
        }

        if (isset($this->inputSubmit['article_author'])) {
            $_arr_contentSubmit['article_author'] = $this->inputSubmit['article_author'];
        }

        //print_r($_arr_contentSubmit);

        $_arr_contentResult = $this->mdl_articleContent->submit($_arr_contentSubmit);

        if ($_arr_contentResult['rcode'] == 'y150101' || $_arr_contentResult['rcode'] == 'y150103') {
            $_str_rcode = 'y120103';
            $_str_msg   = 'Update article successfully';
        }

        return array(
            'article_id' => $num_articleId,
            'rcode'      => $_str_rcode,
            'msg'        => $_str_msg,
        );
    }


    function submitCustom($num_articleId) {
        $_str_rcode = 'x120103';
        $_str_msg   = 'Did not make any changes';

        $_arr_customData = array(
            'article_id' => $num_articleId,
        );

        if (isset($this->inputSubmit['article_customs'])) {
            foreach ($this->inputSubmit['article_customs'] as $_key=>$_value) {
                $_arr_customData['custom_' . $_key] = $_value;
            }
        }

        //print_r($_arr_customData);

        $_arr_customResult = $this->mdl_articleCustom->submit($_arr_customData);

        if ($_arr_customResult['rcode'] == 'y210101' || $_arr_customResult['rcode'] == 'y210103') {
            $_str_rcode = 'y120103';
            $_str_msg   = 'Update article successfully';
        }

        return array(
            'article_id' => $num_articleId,
            'rcode'      => $_str_rcode,
            'msg'        => $_str_msg,
        );
    }


    function submitAttach($num_articleId, $num_attachId) {
        $num_articleId = (int)$num_articleId;
        $num_attachId  = (int)$num_attachId;

        $_str_rcode = 'x120103';
        $_str_msg   = 'Did not make any changes';

        $this->inputSubmit['article_id'] = $num_articleId;

        if ($num_articleId > 0 && $num_attachId > 0) {
            $_arr_articleData['article_attach_id'] = $num_attachId;

            $_num_count = $this->where('article_id', '=', $num_articleId)->update($_arr_articleData); //更新数

            if ($_num_count > 0) {
                $_str_rcode = 'y120103';
                $_str_msg   = 'Update article successfully';
            }
        }

        return array(
            'article_id' => $num_articleId,
            'rcode'      => $_str_rcode,
            'msg'        => $_str_msg,
        );
    }


    function simple() {
        if (isset($this->inputSimple['article_id'])) {
            $_num_articleId = $this->inputSimple['article_id'];
        } else {
            $_num_articleId = 0;
        }

        $_arr_articleData = array(
            'article_title'             => $this->inputSimple['article_title'],
            'article_status'            => $this->inputSimple['article_status'],
            'article_box'               => $this->inputSimple['article_box'],
            'article_is_gen'            => $this->inputSimple['article_is_gen'],
            'article_is_time_pub'       => $this->inputSimple['article_is_time_pub'],
            'article_is_time_hide'      => $this->inputSimple['article_is_time_hide'],
            'article_cate_id'           => $this->inputSimple['article_cate_id'],
            'article_mark_id'           => $this->inputSimple['article_mark_id'],
            'article_top'               => $this->inputSimple['article_top'],
        );

        $_arr_articleData['article_time_show'] = Func::strtotime($_arr_articleData['article_time_show_format']);

        if ($_arr_articleData['article_is_time_pub'] > 0) { //表单有输入则更新
            $_arr_articleData['article_time_pub'] = Func::strtotime($_arr_articleData['article_time_pub_format']);
        }

        if ($_arr_articleData['article_is_time_hide'] > 0) { //表单有输入则更新
            $_arr_articleData['article_time_hide'] = Func::strtotime($_arr_articleData['article_time_hide_format']);
        }

        $_mix_vld = $this->validate($_arr_articleData, '', 'simple_db');

        if ($_mix_vld !== true) {
            return array(
                'article_id'    => $_num_articleId,
                'rcode'         => 'x120201',
                'msg'           => end($_mix_vld),
            );
        }

        $_num_count     = $this->where('article_id', '=', $_num_articleId)->update($_arr_articleData); //更新数

        if ($_num_count > 0) {
            $_str_rcode = 'y120103';
            $_str_msg   = 'Update article successfully';
        } else {
            $_str_rcode = 'x120103';
            $_str_msg   = 'Did not make any changes';
        }

        return array(
            'article_id' => $_num_articleId,
            'rcode'      => $_str_rcode,
            'msg'        => $_str_msg,
        );
    }


    function cover() {
        $_arr_articleData = array(
            'article_attach_id'  => $this->inputCover['attach_id'],
        );

        $_num_articleId  = $this->inputCover['article_id'];

        $_num_count     = $this->where('article_id', '=', $_num_articleId)->update($_arr_articleData); //更新数

        if ($_num_count > 0) { //数据库更新是否成功
            $_str_rcode = 'y120103';
            $_str_msg   = 'Set cover successfully';
        } else {
            $_str_rcode = 'x120103';
            $_str_msg   = 'Did not make any changes';
        }

        return array(
            'article_id'    => $_num_articleId,
            'rcode'         => $_str_rcode,
            'msg'           => $_str_msg,
        );
    }


    function move($arr_cateIds = false, $num_adminId = 0) {
        $_arr_articleUpdate = array(
            'article_cate_id' => $this->inputMove['cate_id'],
        );

        $_arr_where = $this->actQueryProcess($this->inputMove['article_ids'], $arr_cateIds, $num_adminId);

        $_num_count     = $this->where($_arr_where)->update($_arr_articleUpdate); //更新数

        //如车影响行数小于0则返回错误
        if ($_num_count > 0) {
            $_str_rcode = 'y120103';
            $_str_msg   = 'Successfully updated {:count} articles';
        } else {
            $_str_rcode = 'x120103';
            $_str_msg   = 'Did not make any changes';
        }

        return array(
            'rcode' => $_str_rcode,
            'count' => $_num_count,
            'msg'   => $_str_msg,
        );
    }


    /** 编辑状态
     * mdl_status function.
     *
     * @access public
     * @param mixed $str_status
     * @param bool $arr_cateIds (default: false)
     * @param int $num_adminId (default: 0)
     * @return void
     */
    function status($arr_cateIds = false, $num_adminId = 0) {
        $_arr_articleUpdate = array(
            'article_status' => $this->inputStatus['act'],
        );

        if ($this->inputStatus['act'] != 'pub') {
            $_arr_articleUpdate['article_is_gen'] = 'not';
        }

        $_arr_where = $this->actQueryProcess($this->inputStatus['article_ids'], $arr_cateIds, $num_adminId);

        $_num_count     = $this->where($_arr_where)->update($_arr_articleUpdate); //更新数

        //如车影响行数小于0则返回错误
        if ($_num_count > 0) {
            $_str_rcode = 'y120103';
            $_str_msg   = 'Successfully updated {:count} articles';
        } else {
            $_str_rcode = 'x120103';
            $_str_msg   = 'Did not make any changes';
        }

        return array(
            'rcode' => $_str_rcode,
            'count' => $_num_count,
            'msg'   => $_str_msg,
        ); //成功
    }


    /** 编辑所处盒子
     * mdl_box function.
     *
     * @access public
     * @param mixed $str_box
     * @param bool $arr_cateIds (default: false)
     * @param int $num_adminId (default: 0)
     * @return void
     */
    function box($arr_cateIds = false, $num_adminId = 0) {
        $_arr_articleUpdate = array(
            'article_box'        => $this->inputStatus['act'],
        );

        if ($this->inputStatus['act'] != 'normal') {
            $_arr_articleUpdate['article_is_gen'] = 'not';
        }

        $_arr_where = $this->actQueryProcess($this->inputStatus['article_ids'], $arr_cateIds, $num_adminId);

        $_num_count     = $this->where($_arr_where)->update($_arr_articleUpdate); //更新数

        //如车影响行数小于0则返回错误
        if ($_num_count > 0) {
            $_str_rcode = 'y120103';
            $_str_msg   = 'Successfully updated {:count} articles';
        } else {
            $_str_rcode = 'x120103';
            $_str_msg   = 'Did not make any changes';
        }

        return array(
            'rcode' => $_str_rcode,
            'count' => $_num_count,
            'msg'   => $_str_msg,
        ); //成功
    }


    /** 删除
     * mdl_del function.
     *
     * @access public
     * @param bool $arr_cateIds (default: false)
     * @param int $num_adminId (default: 0)
     * @return void
     */
    function delete($arr_cateIds = false, $num_adminId = 0, $str_box = '') {
        $_arr_where = $this->actQueryProcess($this->inputDelete['article_ids'], $arr_cateIds, $num_adminId, $str_box);

        $_num_count     = $this->where($_arr_where)->delete();

        //如车影响行数小于0则返回错误
        if ($_num_count > 0) {
            $_str_rcode = 'y120104';
            $_str_msg   = 'Successfully deleted {:count} articles';
        } else {
            $_str_rcode = 'x120104';
            $_str_msg   = 'No article have been deleted';
        }

        return array(
            'rcode' => $_str_rcode,
            'count' => $_num_count,
            'msg'   => $_str_msg,
        ); //成功
    }


    /** 处理不属于任何栏目的文章
     * mdl_unknownCate function.
     *
     * @access public
     * @return void
     */
    function unknownCate($arr_articleIds) {

        $_arr_articleData = array(
            'article_cate_id' => -1,
        );

        $_num_count     = $this->where('article_id', 'IN', $arr_articleIds, 'article_ids')->update($_arr_articleData);

        //如车影响行数小于0则返回错误
        if ($_num_count > 0) {
            $_str_rcode = 'y120103';
        } else {
            $_str_rcode = 'x120103';
        }

        return array(
            'rcode' => $_str_rcode,
        ); //成功
    }


    /** 列出不重复的年份
     * mdl_year function.
     *
     * @access public
     * @return void
     */
    function year() {
        $_arr_articleSelect = array(
            'DISTINCT FROM_UNIXTIME(`article_time_pub`, \'%Y\') AS `article_year`',
        );

        $_arr_articleRows     = $this->where('article_time', '>', 0, 'article_time')->order('article_time', 'ASC')->limit(100)->select($_arr_articleSelect);

        return $_arr_articleRows;
    }


    function chkAttach($arr_attachRow) {
        $_arr_where = array(
            array('article_attach_id', '=', $arr_attachRow['attach_id'], 'article_attach_id', 'int', 'OR'),
            array('article_excerpt', 'LIKE', '%' . $arr_attachRow['attach_url_name'] . '%', 'article_excerpt', 'str', 'OR'),
        );

        return $this->where($_arr_where)->find('article_id');
    }


    /** 提交输入
     * input_submit function.
     *
     * @access public
     * @return void
     */
    function inputSubmit() {
        //定义参数结构
        $_arr_inputParam = array(
            'article_id'                => array('int', 0),
            'article_title'             => array('str', ''),
            'article_link'              => array('str', ''),
            'article_status'            => array('str', ''),
            'article_box'               => array('str', ''),
            'article_is_gen'            => array('str', ''),
            'article_time_show_format'  => array('str', ''),
            'article_excerpt'           => array('str', ''),
            'article_content'           => array('str', '', true),
            'article_is_time_pub'       => array('int', 0),
            'article_time_pub_format'   => array('str', ''),
            'article_is_time_hide'      => array('int', 0),
            'article_time_hide_format'  => array('str', ''),
            'article_cate_id'           => array('int', 0),
            'cate_ids_check'            => array('int', 0),
            'article_cate_ids'          => array('arr', array()),
            'article_source'            => array('str', ''),
            'article_source_url'        => array('str', ''),
            'article_author'            => array('str', ''),
            'article_mark_id'           => array('int', 0),
            'article_spec_ids'          => array('arr', array()),
            'article_tags'              => array('arr', array()),
            'article_customs'           => array('arr', array()),
            'article_excerpt_type'      => array('str', 'auto'),
            'article_tag_hidden'        => array('str', ''),
            'article_tpl'               => array('str', ''),
            '__token__'                 => array('str', ''),
        );

        $_arr_inputSubmit = $this->obj_request->post($_arr_inputParam);

        $_arr_inputSubmit['article_time_show_format'] = Html::decode($_arr_inputSubmit['article_time_show_format'], 'date_time');
        $_arr_inputSubmit['article_time_pub_format']  = Html::decode($_arr_inputSubmit['article_time_pub_format'], 'date_time');
        $_arr_inputSubmit['article_time_hide_format'] = Html::decode($_arr_inputSubmit['article_time_hide_format'], 'date_time');

        if ($_arr_inputSubmit['cate_ids_check'] > 0) {
            array_unshift($_arr_inputSubmit['article_cate_ids'], $_arr_inputSubmit['article_cate_id']);
        } else {
            $_arr_inputSubmit['article_cate_ids'] = array($_arr_inputSubmit['article_cate_id']);
        }

        $_arr_inputSubmit['article_cate_ids'] = Func::arrayFilter($_arr_inputSubmit['article_cate_ids']);

        $_arr_inputSubmit['article_spec_ids'] = Func::arrayFilter($_arr_inputSubmit['article_spec_ids']);

        $_arr_articleTags   = explode(',', $_arr_inputSubmit['article_tag_hidden']);
        $_arr_inputSubmit['article_tags'] = Func::arrayFilter($_arr_articleTags);

        $_mix_vld = $this->validate($_arr_inputSubmit, '', 'submit');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x120201',
                'msg'   => end($_mix_vld),
            );
        }

        if ($_arr_inputSubmit['article_id'] > 0) {
            //验证文章
            $_arr_articleRow = $this->check($_arr_inputSubmit['article_id']);

            if ($_arr_articleRow['rcode'] != 'y120102') {
                return $_arr_articleRow;
            }
        }

        $_arr_inputSubmit['rcode'] = 'y120201';

        $this->inputSubmit = $_arr_inputSubmit;

        return $_arr_inputSubmit;
    }


    function inputSimple() {
        //定义参数结构
        $_arr_inputParam = array(
            'article_id'                => array('int', 0),
            'article_title'             => array('str', ''),
            'article_status'            => array('str', ''),
            'article_box'               => array('str', ''),
            'article_is_gen'            => array('str', ''),
            'article_time_show_format'  => array('str', ''),
            'article_is_time_pub'       => array('int', 0),
            'article_time_pub_format'   => array('str', ''),
            'article_is_time_hide'      => array('int', 0),
            'article_time_hide_format'  => array('str', ''),
            'article_cate_id'           => array('int', 0),
            'article_mark_id'           => array('int', 0),
            'article_top'               => array('int', 0),
            '__token__'                 => array('str', ''),
        );

        $_arr_inputSimple = $this->obj_request->post($_arr_inputParam);

        $_arr_inputSimple['article_time_show_format']   = Html::decode($_arr_inputSimple['article_time_show_format'], 'date_time');
        $_arr_inputSimple['article_time_pub_format']    = Html::decode($_arr_inputSimple['article_time_pub_format'], 'date_time');
        $_arr_inputSimple['article_time_hide_format']   = Html::decode($_arr_inputSimple['article_time_hide_format'], 'date_time');

        $_mix_vld = $this->validate($_arr_inputSimple, '', 'simple');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x120201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputSimple['rcode'] = 'y120201';

        $this->inputSimple = $_arr_inputSimple;

        return $_arr_inputSimple;
    }


    function inputCover() {
        $_arr_inputParam = array(
            'article_id' => array('int', 0),
            'attach_id'  => array('int', 0),
            '__token__'  => array('str', ''),
        );

        $_arr_inputCover = $this->obj_request->post($_arr_inputParam);

        $_mix_vld = $this->validate($_arr_inputCover, '', 'cover');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x120201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_articleRow = $this->check($_arr_inputCover['article_id']);

        if ($_arr_articleRow['rcode'] != 'y120102') {
            return $_arr_articleRow;
        }

        $_arr_inputCover['rcode'] = 'y120201';

        $this->inputCover = $_arr_inputCover;

        return $_arr_inputCover;
    }


    /** 选择
     * inputDelete function.
     *
     * @access public
     * @return void
     */
    function inputDelete() {
        $_arr_inputParam = array(
            'article_ids'   => array('arr', array()),
            '__token__'     => array('str', ''),
        );

        $_arr_inputDelete = $this->obj_request->post($_arr_inputParam);

        //print_r($_arr_inputDelete);

        $_arr_inputDelete['article_ids'] = Func::arrayFilter($_arr_inputDelete['article_ids']);

        $_mix_vld = $this->validate($_arr_inputDelete, '', 'delete');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x120201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputDelete['rcode'] = 'y120201';

        $this->inputDelete = $_arr_inputDelete;

        return $_arr_inputDelete;
    }


    function inputStatus() {
        $_arr_inputParam = array(
            'article_ids'   => array('arr', array()),
            'act'           => array('str', ''),
            '__token__'     => array('str', ''),
        );

        $_arr_inputStatus = $this->obj_request->post($_arr_inputParam);

        //print_r($_arr_inputStatus);

        $_arr_inputStatus['article_ids'] = Func::arrayFilter($_arr_inputStatus['article_ids']);

        $_mix_vld = $this->validate($_arr_inputStatus, '', 'status');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x120201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputStatus['rcode'] = 'y120201';

        $this->inputStatus = $_arr_inputStatus;

        return $_arr_inputStatus;
    }


    function inputMove() {
        $_arr_inputParam = array(
            'article_ids'   => array('arr', array()),
            'cate_id'       => array('int', 0),
            '__token__'     => array('str', ''),
        );

        $_arr_inputMove = $this->obj_request->post($_arr_inputParam);

        //print_r($_arr_inputMove);

        $_arr_inputMove['article_ids'] = Func::arrayFilter($_arr_inputMove['article_ids']);

        $_mix_vld = $this->validate($_arr_inputMove, '', 'move');

        if ($_mix_vld !== true) {
            return array(
                'rcode' => 'x120201',
                'msg'   => end($_mix_vld),
            );
        }

        $_arr_inputMove['rcode'] = 'y120201';

        $this->inputMove = $_arr_inputMove;

        return $_arr_inputMove;
    }


    protected function actQueryProcess($arr_articleIds = false, $arr_cateIds = false, $num_adminId = 0, $str_box = '') {
        $_arr_where[] = array('article_id', 'IN', $arr_articleIds, 'article_ids');

        if (!Func::isEmpty($arr_cateIds)) {
            $_str_cateIds = Func::arrayFilter($arr_cateIds);
            $_arr_where[] = array('article_cate_id', 'IN', $arr_cateIds, 'cate_ids');
        }

        if ($num_adminId > 0) {
            $_arr_where[] = array('article_admin_id', '=', $num_adminId);
        }

        if (!Func::isEmpty($str_box)) {
            $_arr_where[] = array('article_box', '=', $str_box);
        }

        return $_arr_where;
    }
}
