<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------采集点模型-------------*/
class MODEL_GSITE_STEP extends MODEL_GSITE {

    public $obj_db;

    function __construct() { //构造函数
        $this->obj_db = $GLOBALS['obj_db']; //设置数据库对象
    }


    function mdl_step_page_content() { //列表解析
        $_arr_gsiteData = array(
            'gsite_page_content_selector'   => $this->inputStepPageContent['gsite_page_content_selector'],
            'gsite_page_content_attr'       => strtolower($this->inputStepPageContent['gsite_page_content_attr']),
            'gsite_page_content_filter'     => $this->inputStepPageContent['gsite_page_content_filter'],
            'gsite_page_content_replace'    => $this->inputStepPageContent['gsite_page_content_replace'],
        );

        $_num_gsiteId    = $this->inputStepPageContent['gsite_id'];
        $_num_db      = $this->obj_db->update(BG_DB_TABLE . 'gsite', $_arr_gsiteData, '`gsite_id`=' . $_num_gsiteId);

        if ($_num_db > 0) { //数据库更新是否成功
            $_str_rcode = 'y270103';
        } else {
            return array(
                'gsite_id'  => $_num_gsiteId,
                'rcode'     => 'x270103',
            );
        }

        return array(
            'gsite_id'  => $_num_gsiteId,
            'rcode'     => $_str_rcode,
        );
    }


    function mdl_step_page_list() { //列表解析
        $_arr_gsiteData = array(
            'gsite_page_list_selector'  => $this->inputStepPageList['gsite_page_list_selector'],
        );

        $_num_gsiteId    = $this->inputStepPageList['gsite_id'];
        $_num_db      = $this->obj_db->update(BG_DB_TABLE . 'gsite', $_arr_gsiteData, '`gsite_id`=' . $_num_gsiteId);

        if ($_num_db > 0) { //数据库更新是否成功
            $_str_rcode = 'y270103';
        } else {
            return array(
                'gsite_id'  => $_num_gsiteId,
                'rcode'     => 'x270103',
            );
        }

        return array(
            'gsite_id'  => $_num_gsiteId,
            'rcode'     => $_str_rcode,
        );
    }

    function mdl_step_list() { //列表解析
        $_arr_gsiteData = array(
            'gsite_list_selector'   => $this->inputStepList['gsite_list_selector'],
        );

        $_num_gsiteId    = $this->inputStepList['gsite_id'];
        $_num_db      = $this->obj_db->update(BG_DB_TABLE . 'gsite', $_arr_gsiteData, '`gsite_id`=' . $_num_gsiteId);

        if ($_num_db > 0) { //数据库更新是否成功
            $_str_rcode = 'y270103';
        } else {
            return array(
                'gsite_id'  => $_num_gsiteId,
                'rcode'     => 'x270103',
            );
        }

        return array(
            'gsite_id'  => $_num_gsiteId,
            'rcode'     => $_str_rcode,
        );
    }

    function mdl_step_content() { //列表解析

        $_arr_gsiteData = array(
            'gsite_title_selector'      => $this->inputStepContent['gsite_title_selector'],
            'gsite_title_attr'          => strtolower($this->inputStepContent['gsite_title_attr']),
            'gsite_title_filter'        => $this->inputStepContent['gsite_title_filter'],
            'gsite_title_replace'       => $this->inputStepContent['gsite_title_replace'],
            'gsite_content_selector'    => $this->inputStepContent['gsite_content_selector'],
            'gsite_content_attr'        => strtolower($this->inputStepContent['gsite_content_attr']),
            'gsite_content_filter'      => $this->inputStepContent['gsite_content_filter'],
            'gsite_content_replace'     => $this->inputStepContent['gsite_content_replace'],
            'gsite_time_selector'       => $this->inputStepContent['gsite_time_selector'],
            'gsite_time_attr'           => strtolower($this->inputStepContent['gsite_time_attr']),
            'gsite_time_filter'         => $this->inputStepContent['gsite_time_filter'],
            'gsite_time_replace'        => $this->inputStepContent['gsite_time_replace'],
            'gsite_source_selector'     => $this->inputStepContent['gsite_source_selector'],
            'gsite_source_attr'         => strtolower($this->inputStepContent['gsite_source_attr']),
            'gsite_source_filter'       => $this->inputStepContent['gsite_source_filter'],
            'gsite_source_replace'      => $this->inputStepContent['gsite_source_replace'],
            'gsite_author_selector'     => $this->inputStepContent['gsite_author_selector'],
            'gsite_author_attr'         => strtolower($this->inputStepContent['gsite_author_attr']),
            'gsite_author_filter'       => $this->inputStepContent['gsite_author_filter'],
            'gsite_author_replace'      => $this->inputStepContent['gsite_author_replace'],
            //'gsite_img_attr'            => strtolower($this->inputStepContent['gsite_img_attr']),
            'gsite_img_filter'          => strtolower($this->inputStepContent['gsite_img_filter']),
            'gsite_keep_tag'            => strtolower($this->inputStepContent['gsite_keep_tag']),
            'gsite_attr_allow'          => strtolower($this->inputStepContent['gsite_attr_allow']),
            'gsite_ignore_tag'          => strtolower($this->inputStepContent['gsite_ignore_tag']),
            'gsite_attr_except'         => strtolower($this->inputStepContent['gsite_attr_except']),
        );

        $_num_gsiteId    = $this->inputStepContent['gsite_id'];

        $_num_db      = $this->obj_db->update(BG_DB_TABLE . 'gsite', $_arr_gsiteData, '`gsite_id`=' . $_num_gsiteId);

        if ($_num_db > 0) { //数据库更新是否成功
            $_str_rcode = 'y270103';
        } else {
            return array(
                'gsite_id'  => $_num_gsiteId,
                'rcode'     => 'x270103',
            );
        }

        return array(
            'gsite_id'  => $_num_gsiteId,
            'rcode'     => $_str_rcode,
        );
    }


    function input_step_page_content() {
        if (!fn_token('chk')) { //令牌
            return array(
                'rcode' => 'x030206',
            );
        }

        $this->inputStepPageContent['gsite_id'] = fn_getSafe(fn_post('gsite_id'), 'int', 0);

        if ($this->inputStepPageContent['gsite_id'] < 1) {
            return array(
                'rcode' => 'x270213',
            );
        }

        $_arr_gsiteRow = $this->mdl_read($this->inputStepPageContent['gsite_id']);
        if ($_arr_gsiteRow['rcode'] != 'y270102') {
            return $_arr_gsiteRow;
        }

        $_arr_gsitePageContentSelector = fn_validate(fn_post('gsite_page_content_selector'), 1, 100);
        switch ($_arr_gsitePageContentSelector['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x270218',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x270219',
                );
            break;

            case 'ok':
                $this->inputStepPageContent['gsite_page_content_selector'] = $_arr_gsitePageContentSelector['str'];
            break;
        }

        $_arr_gsitePageContentAttr = fn_validate(fn_post('gsite_page_content_attr'), 0, 100);
        switch ($_arr_gsitePageContentAttr['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x270236',
                );
            break;

            case 'ok':
                $this->inputStepPageContent['gsite_page_content_attr'] = $_arr_gsitePageContentAttr['str'];
            break;
        }

        $_arr_gsitePageContentFilter = fn_validate(fn_post('gsite_page_content_filter'), 0, 100);
        switch ($_arr_gsitePageContentFilter['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x270224',
                );
            break;

            case 'ok':
                $this->inputStepPageContent['gsite_page_content_filter'] = $_arr_gsitePageContentFilter['str'];
            break;
        }

        $this->inputStepPageContent['gsite_page_content_replace'] = fn_jsonEncode(fn_post('gsite_page_content_replace'), true);

        $this->inputStepPageContent['rcode']   = 'ok';

        return $this->inputStepPageContent;
    }


    function input_step_page_list() {
        if (!fn_token('chk')) { //令牌
            return array(
                'rcode' => 'x030206',
            );
        }

        $this->inputStepPageList['gsite_id'] = fn_getSafe(fn_post('gsite_id'), 'int', 0);

        if ($this->inputStepPageList['gsite_id'] < 1) {
            return array(
                'rcode' => 'x270213',
            );
        }

        $_arr_gsiteRow = $this->mdl_read($this->inputStepPageList['gsite_id']);
        if ($_arr_gsiteRow['rcode'] != 'y270102') {
            return $_arr_gsiteRow;
        }

        $_arr_gsitePageListSelector = fn_validate(fn_post('gsite_page_list_selector'), 1, 100);
        switch ($_arr_gsitePageListSelector['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x270216',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x270217',
                );
            break;

            case 'ok':
                $this->inputStepPageList['gsite_page_list_selector'] = $_arr_gsitePageListSelector['str'];
            break;
        }

        $this->inputStepPageList['rcode']   = 'ok';

        return $this->inputStepPageList;
    }


    function input_step_list() {
        if (!fn_token('chk')) { //令牌
            return array(
                'rcode' => 'x030206',
            );
        }

        $this->inputStepList['gsite_id'] = fn_getSafe(fn_post('gsite_id'), 'int', 0);

        if ($this->inputStepList['gsite_id'] < 1) {
            return array(
                'rcode' => 'x270213',
            );
        }

        $_arr_gsiteRow = $this->mdl_read($this->inputStepList['gsite_id']);
        if ($_arr_gsiteRow['rcode'] != 'y270102') {
            return $_arr_gsiteRow;
        }

        $_arr_gsiteListSelector = fn_validate(fn_post('gsite_list_selector'), 1, 100);
        switch ($_arr_gsiteListSelector['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x270214',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x270215',
                );
            break;

            case 'ok':
                $this->inputStepList['gsite_list_selector'] = $_arr_gsiteListSelector['str'];
            break;
        }

        $this->inputStepList['rcode']   = 'ok';

        return $this->inputStepList;
    }


    function input_step_content() {
        if (!fn_token('chk')) { //令牌
            return array(
                'rcode' => 'x030206',
            );
        }

        $this->inputStepContent['gsite_id'] = fn_getSafe(fn_post('gsite_id'), 'int', 0);

        if ($this->inputStepContent['gsite_id'] < 1) {
            return array(
                'rcode' => 'x270213',
            );
        }

        $_arr_gsiteRow = $this->mdl_read($this->inputStepContent['gsite_id']);
        if ($_arr_gsiteRow['rcode'] != 'y270102') {
            return $_arr_gsiteRow;
        }

        $_arr_gsiteTitleSelector = fn_validate(fn_post('gsite_title_selector'), 1, 100);
        switch ($_arr_gsiteTitleSelector['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x270232',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x270233',
                );
            break;

            case 'ok':
                $this->inputStepContent['gsite_title_selector'] = $_arr_gsiteTitleSelector['str'];
            break;
        }

        $_arr_gsiteTitleAttr = fn_validate(fn_post('gsite_title_attr'), 0, 100);
        switch ($_arr_gsiteTitleAttr['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x270237',
                );
            break;

            case 'ok':
                $this->inputStepContent['gsite_title_attr'] = $_arr_gsiteTitleAttr['str'];
            break;
        }

        $_arr_gsiteTitleFilter = fn_validate(fn_post('gsite_title_filter'), 0, 100);
        switch ($_arr_gsiteTitleFilter['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x270227',
                );
            break;

            case 'ok':
                $this->inputStepContent['gsite_title_filter'] = $_arr_gsiteTitleFilter['str'];
            break;
        }

        $this->inputStepContent['gsite_title_replace'] = fn_jsonEncode(fn_post('gsite_title_replace'), true);

        $_arr_gsiteContentSelector = fn_validate(fn_post('gsite_content_selector'), 1, 100);
        switch ($_arr_gsiteContentSelector['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x270234',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x270235',
                );
            break;

            case 'ok':
                $this->inputStepContent['gsite_content_selector'] = $_arr_gsiteContentSelector['str'];
            break;
        }

        $_arr_gsiteContentAttr = fn_validate(fn_post('gsite_content_attr'), 0, 100);
        switch ($_arr_gsiteContentAttr['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x270238',
                );
            break;

            case 'ok':
                $this->inputStepContent['gsite_content_attr'] = $_arr_gsiteContentAttr['str'];
            break;
        }

        $_arr_gsiteContentFilter = fn_validate(fn_post('gsite_content_filter'), 0, 100);
        switch ($_arr_gsiteContentFilter['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x270227',
                );
            break;

            case 'ok':
                $this->inputStepContent['gsite_content_filter'] = $_arr_gsiteContentFilter['str'];
            break;
        }

        $this->inputStepContent['gsite_content_replace'] = fn_jsonEncode(fn_post('gsite_content_replace'), true);

        $_arr_gsiteTimeSelector = fn_validate(fn_post('gsite_time_selector'), 0, 100);
        switch ($_arr_gsiteTimeSelector['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x270220',
                );
            break;

            case 'ok':
                $this->inputStepContent['gsite_time_selector'] = $_arr_gsiteTimeSelector['str'];
            break;
        }

        $_arr_gsiteTimeAttr = fn_validate(fn_post('gsite_time_attr'), 0, 100);
        switch ($_arr_gsiteTimeAttr['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x270239',
                );
            break;

            case 'ok':
                $this->inputStepContent['gsite_time_attr'] = $_arr_gsiteTimeAttr['str'];
            break;
        }

        $_arr_gsiteTimeFilter = fn_validate(fn_post('gsite_time_filter'), 0, 100);
        switch ($_arr_gsiteTimeFilter['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x270229',
                );
            break;

            case 'ok':
                $this->inputStepContent['gsite_time_filter'] = $_arr_gsiteTimeFilter['str'];
            break;
        }

        $this->inputStepContent['gsite_time_replace'] = fn_jsonEncode(fn_post('gsite_time_replace'), true);

        $_arr_gsiteSourceSelector = fn_validate(fn_post('gsite_source_selector'), 0, 100);
        switch ($_arr_gsiteSourceSelector['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x270221',
                );
            break;

            case 'ok':
                $this->inputStepContent['gsite_source_selector'] = $_arr_gsiteSourceSelector['str'];
            break;
        }

        $_arr_gsiteSourceAttr = fn_validate(fn_post('gsite_source_attr'), 0, 100);
        switch ($_arr_gsiteSourceAttr['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x270240',
                );
            break;

            case 'ok':
                $this->inputStepContent['gsite_source_attr'] = $_arr_gsiteSourceAttr['str'];
            break;
        }

        $_arr_gsiteSourceFilter = fn_validate(fn_post('gsite_source_filter'), 0, 100);
        switch ($_arr_gsiteSourceFilter['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x270230',
                );
            break;

            case 'ok':
                $this->inputStepContent['gsite_source_filter'] = $_arr_gsiteSourceFilter['str'];
            break;
        }

        $this->inputStepContent['gsite_source_replace'] = fn_jsonEncode(fn_post('gsite_source_replace'), true);

        $_arr_gsiteAuthorSelector = fn_validate(fn_post('gsite_author_selector'), 0, 100);
        switch ($_arr_gsiteAuthorSelector['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x270222',
                );
            break;

            case 'ok':
                $this->inputStepContent['gsite_author_selector'] = $_arr_gsiteAuthorSelector['str'];
            break;
        }

        $_arr_gsiteAuthorAttr = fn_validate(fn_post('gsite_author_attr'), 0, 100);
        switch ($_arr_gsiteAuthorAttr['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x270241',
                );
            break;

            case 'ok':
                $this->inputStepContent['gsite_author_attr'] = $_arr_gsiteAuthorAttr['str'];
            break;
        }

        $_arr_gsiteAuthorFilter = fn_validate(fn_post('gsite_author_filter'), 0, 100);
        switch ($_arr_gsiteAuthorFilter['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x270231',
                );
            break;

            case 'ok':
                $this->inputStepContent['gsite_author_filter'] = $_arr_gsiteAuthorFilter['str'];
            break;
        }

        $this->inputStepContent['gsite_author_replace'] = fn_jsonEncode(fn_post('gsite_author_replace'), true);

        $_arr_gsiteKeepTag = fn_validate(fn_post('gsite_keep_tag'), 0, 300);
        switch ($_arr_gsiteKeepTag['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x270205',
                );
            break;

            case 'ok':
                $this->inputStepContent['gsite_keep_tag'] = $_arr_gsiteKeepTag['str'];
            break;
        }

        /*$_arr_gsiteImgAttr = fn_validate(fn_post('gsite_img_attr'), 0, 100);
        switch ($_arr_gsiteImgAttr['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x270223',
                );
            break;

            case 'ok':
                $this->inputStepContent['gsite_img_attr'] = $_arr_gsiteImgAttr['str'];
            break;
        }*/

        $_arr_gsiteImgFilter = fn_validate(fn_post('gsite_img_filter'), 0, 100);
        switch ($_arr_gsiteImgFilter['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x270244',
                );
            break;

            case 'ok':
                $this->inputStepContent['gsite_img_filter'] = $_arr_gsiteImgFilter['str'];
            break;
        }

        $_arr_gsiteAttrAllow = fn_validate(fn_post('gsite_attr_allow'), 0, 100);
        switch ($_arr_gsiteAttrAllow['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x270242',
                );
            break;

            case 'ok':
                $this->inputStepContent['gsite_attr_allow'] = $_arr_gsiteAttrAllow['str'];
            break;
        }

        $_arr_gsiteIgnoreTag = fn_validate(fn_post('gsite_ignore_tag'), 0, 300);
        switch ($_arr_gsiteIgnoreTag['status']) {
            case 'too_long':
                return array(
                    'rcode' => 'x270243',
                );
            break;

            case 'ok':
                $this->inputStepContent['gsite_ignore_tag'] = $_arr_gsiteIgnoreTag['str'];
            break;
        }

        $this->inputStepContent['gsite_attr_except'] = fn_jsonEncode(fn_post('gsite_attr_except'));

        //print_r($this->inputStepContent['gsite_attr_except']);

        $this->inputStepContent['rcode']   = 'ok';

        return $this->inputStepContent;
    }
}
