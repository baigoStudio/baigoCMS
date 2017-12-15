<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

fn_include(BG_PATH_FUNC . 'http.func.php'); //载入 http
fn_include(BG_PATH_FUNC . 'gather.func.php');

/*-------------用户类-------------*/
class CONTROL_CONSOLE_REQUEST_GATHER {

    private $group_allow    = array();
    private $is_super       = false;

    function __construct() { //构造函数
        $this->general_console  = new GENERAL_CONSOLE();
        $this->general_console->dspType = 'result';
        $this->general_console->chk_install();

        $this->adminLogged  = $this->general_console->ssin_begin();
        $this->general_console->is_admin($this->adminLogged);

        $this->obj_tpl      = $this->general_console->obj_tpl;

        if ($this->adminLogged['admin_type'] == 'super') {
            $this->is_super = true;
        }

        if (isset($this->adminLogged['groupRow']['group_allow'])) {
            $this->group_allow = $this->adminLogged['groupRow']['group_allow'];
        }

        $this->obj_attr         = new CLASS_ATTR();

        $this->mdl_gsite        = new MODEL_GSITE();
        $this->mdl_gather       = new MODEL_GATHER();
        $this->mdl_article      = new MODEL_ARTICLE();
        $this->mdl_cate_belong  = new MODEL_CATE_BELONG();
    }


    function ctrl_store() {
        if (!isset($this->group_allow['gather']['gather']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x280304',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        if (!fn_token('chk')) { //令牌
            $_arr_tplData = array(
                'rcode' => 'x030206',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_num_gatherId = fn_getSafe(fn_post('gather_id'), 'int', 0);
        if ($_num_gatherId < 1) {
            $_arr_tplData = array(
                'rcode' => 'x280204',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_gatherRow = $this->mdl_gather->mdl_read($_num_gatherId);
        if ($_arr_gatherRow['rcode'] != 'y280102') {
            $_arr_tplData = array(
                'rcode' => $_arr_gatherRow['rcode'],
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_str_enforce  = fn_getSafe(fn_post('enforce'), 'txt', '');
        if ($_arr_gatherRow['gather_article_id'] > 0 && $_str_enforce != 'true') {
            $_arr_tplData = array(
                'rcode' => 'x280402',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        if (fn_isEmpty($_arr_gatherRow['gather_title'])) {
            $_arr_tplData = array(
                'rcode' => 'x280205',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        if (isset($this->group_allow['article']['approve']) || isset($this->adminLogged['admin_allow_cate'][$_arr_gatherRow['gather_cate_id']]['approve']) || $this->is_super) {
            $_str_status = 'pub';
        } else {
            $_str_status = 'wait';
        }

        $this->gsite_process($_arr_gatherRow['gather_gsite_id']);

        $_arr_articleSubmit = array(
            'article_title'         => strip_tags($_arr_gatherRow['gather_title']),
            'article_cate_id'       => $_arr_gatherRow['gather_cate_id'],
            'article_time_show'     => $_arr_gatherRow['gather_time_show'],
            'article_source'        => strip_tags($_arr_gatherRow['gather_source']),
            'article_source_url'    => $_arr_gatherRow['gather_source_url'],
            'article_author'        => strip_tags($_arr_gatherRow['gather_author']),
            'article_content'       => $_arr_gatherRow['gather_content'],
            'article_box'           => 'normal',
            'article_time_pub'      => time(),
        );

        $_arr_articleRow = $this->mdl_article->mdl_submit($this->adminLogged['admin_id'], $_str_status, $_arr_articleSubmit);

        if ($_arr_articleRow['article_id'] > 0) {
            $_arr_qlistImgs = fn_qlistImg($_arr_gatherRow['gather_content'], $this->gsiteRow['gsite_img_filter']);

            if (!fn_isEmpty($_arr_qlistImgs)) {
                $_arr_returnRows = fn_gatherImg($_arr_qlistImgs, $this->adminLogged['admin_id']);

                foreach ($_arr_returnRows as $_key=>$_value) {
                    $_arr_gatherRow['gather_content'] = str_ireplace($_value['img_src'], $_value['attach_url'], $_arr_gatherRow['gather_content']);  //图片, 用新地址替换老地址
                }
            }

            if (isset($_arr_returnRows[0]['attach_id'])) {
                $_num_attachId = $_arr_returnRows[0]['attach_id'];
            } else {
                $_num_attachId = 0;
            }

            //print_r($_num_attachId);

            $_arr_articleSubmit = array(
                'article_id'        => $_arr_articleRow['article_id'],
                'article_content'   => $_arr_gatherRow['gather_content'],
                'article_attach_id' => $_num_attachId,
            );

            $_arr_articleRow    = $this->mdl_article->mdl_submit($this->adminLogged['admin_id'], $_str_status, $_arr_articleSubmit);
            $_arr_cateBelongRow = $this->mdl_cate_belong->mdl_submit($_arr_articleRow['article_id'], $_arr_gatherRow['gather_cate_id']);

            $this->mdl_gather->mdl_store($_num_gatherId, $_arr_articleRow['article_id']);
        }

        $_arr_tplData = array(
            'rcode' => 'y280403',
        );

        $this->obj_tpl->tplDisplay('result', $_arr_tplData);
    }


    /**
     * ajax_submit function.
     *
     * @access public
     * @return void
     */
    function ctrl_submit() {
        $this->gather_init();

        $_arr_gatherSubmit  = array(
            'gather_source_url' => '',
            'gather_title'      => '',
            'gather_content'    => '',
            'gather_time_show'  => '',
            'gather_source'     => '',
            'gather_author'     => '',
            'gather_gsite_id'   => $this->gsiteRow['gsite_id'],
            'gather_cate_id'    => $this->gsiteRow['gsite_cate_id'],
            'gather_admin_id'   => $this->adminLogged['admin_id'],
        );


        $_arr_gatherRows = array();

        $_count = 1;

        $_arr_rule = array(
            'url'   => array($this->gsiteRow['gsite_list_selector'], 'href'),
            'title' => array($this->gsiteRow['gsite_list_selector'], 'html'),
        );

        $_obj_dom = fn_qlistDom($this->gsiteRow['gsite_url'], $_arr_rule, $this->gsiteRow['gsite_charset']);

        if (!fn_isEmpty($_obj_dom)) {
            foreach ($_obj_dom as $_key=>$_value) {
                if ($_count < BG_COUNT_GATHER) {
                    $_str_md5 = md5(fn_formatUrl($_value['url'], $this->gsiteRow['gsite_url']));
                    $_arr_gatherRows[$_str_md5] = array(
                        'url'   => fn_formatUrl($_value['url'], $this->gsiteRow['gsite_url']),
                    );
                }
            }
        }

        if (!isset($_arr_gatherRows[$this->key]['url'])) {
            $_arr_tplData = array(
                'rcode' => 'x280101',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_str_contentUrl = fn_formatUrl($_arr_gatherRows[$this->key]['url'], $this->gsiteRow['gsite_url']);

        $_arr_gatherRow = $this->mdl_gather->mdl_read(fn_getSafe($_str_contentUrl, 'txt', ''), 'gather_source_url');

        if ($_arr_gatherRow['rcode'] == 'y280102') {
            $_arr_tplData = array(
                'rcode' => $_arr_gatherRow['rcode'],
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_contentRule['title'] = array($this->gsiteRow['gsite_title_selector'], $this->gsiteRow['gsite_title_attr'], $this->gsiteRow['gsite_title_filter']);

        if (!fn_isEmpty($this->gsiteRow['gsite_content_selector'])) {
            $_arr_contentRule['content'] = array($this->gsiteRow['gsite_content_selector'], $this->gsiteRow['gsite_content_attr'], $this->gsiteRow['gsite_content_filter']);
        }

        if (!fn_isEmpty($this->gsiteRow['gsite_time_selector'])) {
            $_arr_contentRule['time'] = array($this->gsiteRow['gsite_time_selector'], $this->gsiteRow['gsite_time_attr'], $this->gsiteRow['gsite_time_filter']);
        }

        if (!fn_isEmpty($this->gsiteRow['gsite_source_selector'])) {
            $_arr_contentRule['source'] = array($this->gsiteRow['gsite_source_selector'], $this->gsiteRow['gsite_source_attr'], $this->gsiteRow['gsite_source_filter']);
        }

        if (!fn_isEmpty($this->gsiteRow['gsite_author_selector'])) {
            $_arr_contentRule['author'] = array($this->gsiteRow['gsite_author_selector'], $this->gsiteRow['gsite_author_attr'], $this->gsiteRow['gsite_author_filter']);
        }

        if (!fn_isEmpty($this->gsiteRow['gsite_page_list_selector']) && !fn_isEmpty($this->gsiteRow['gsite_page_content_selector'])) {
            $_arr_contentRule['page_url'] = array($this->gsiteRow['gsite_page_list_selector'], 'href');
        }

        $_obj_domContent = fn_qlistDom($_str_contentUrl, $_arr_contentRule, $this->gsiteRow['gsite_charset']);

        $_arr_gatherSubmit['gather_source_url'] = $_str_contentUrl;

        $_arr_gatherResult = array(
            'rcode' => 'x280101',
        );

        if (isset($_obj_domContent[0]['title']) && !fn_isEmpty($_obj_domContent[0]['title'])) {
            $_arr_gatherSubmit['gather_title'] = strip_tags($_obj_domContent[0]['title']);

            if (!fn_isEmpty($this->gsiteRow['gsite_title_replace'])) {
                foreach ($this->gsiteRow['gsite_title_replace'] as $_key=>$_value) {
                    if (isset($_value['search'])) {
                        if (isset($_value['replace']) && !fn_isEmpty($_value['replace'])) {
                            $_str_replace = $_value['replace'];
                        } else {
                            $_str_replace = '';
                        }
                        $_arr_gatherSubmit['gather_title'] = str_ireplace($_value['search'], $_str_replace, $_arr_gatherSubmit['gather_title']);
                    }
                }
            }

            if (isset($_obj_domContent[0]['content']) && !fn_isEmpty($_obj_domContent[0]['content'])) {
                $_str_articleContent        = strip_tags($_obj_domContent[0]['content'], $this->gsiteKeepTag); //去除标签
                $_str_articleContent        = fn_formatSrc($_str_articleContent, $_str_contentUrl); //补全 URL
                $_arr_gatherSubmit['gather_content'] = $_str_articleContent;

                if (!fn_isEmpty($this->gsiteRow['gsite_content_replace'])) {
                    foreach ($this->gsiteRow['gsite_content_replace'] as $_key=>$_value) {
                        if (isset($_value['search'])) {
                            if (isset($_value['replace']) && !fn_isEmpty($_value['replace'])) {
                                $_str_replace = $_value['replace'];
                            } else {
                                $_str_replace = '';
                            }
                            $_arr_gatherSubmit['gather_content'] = str_ireplace($_value['search'], $_str_replace, $_arr_gatherSubmit['gather_content']);
                        }
                    }
                }
            }

            if (isset($_obj_domContent[0]['time']) && !fn_isEmpty($_obj_domContent[0]['time'])) {
                $_arr_gatherSubmit['gather_time_show'] = $_obj_domContent[0]['time'];

                if (!fn_isEmpty($this->gsiteRow['gsite_time_replace'])) {
                    foreach ($this->gsiteRow['gsite_time_replace'] as $_key=>$_value) {
                        if (isset($_value['search'])) {
                            if (isset($_value['replace']) && !fn_isEmpty($_value['replace'])) {
                                $_str_replace = $_value['replace'];
                            } else {
                                $_str_replace = '';
                            }
                            $_arr_gatherSubmit['gather_time_show'] = str_ireplace($_value['search'], $_str_replace, $_arr_gatherSubmit['gather_time_show']);
                        }
                    }
                }
            }

            if (isset($_obj_domContent[0]['source']) && !fn_isEmpty($_obj_domContent[0]['source'])) {
                $_arr_gatherSubmit['gather_source'] = strip_tags($_obj_domContent[0]['source']);

                if (!fn_isEmpty($this->gsiteRow['gsite_source_replace'])) {
                    foreach ($this->gsiteRow['gsite_source_replace'] as $_key=>$_value) {
                        if (isset($_value['search'])) {
                            if (isset($_value['replace']) && !fn_isEmpty($_value['replace'])) {
                                $_str_replace = $_value['replace'];
                            } else {
                                $_str_replace = '';
                            }
                            $_arr_gatherSubmit['gather_source'] = str_ireplace($_value['search'], $_str_replace, $_arr_gatherSubmit['gather_source']);
                        }
                    }
                }
            }

            if (isset($_obj_domContent[0]['author']) && !fn_isEmpty($_obj_domContent[0]['author'])) {
                $_arr_gatherSubmit['gather_author'] = strip_tags($_obj_domContent[0]['author']);

                if (!fn_isEmpty($this->gsiteRow['gsite_author_replace'])) {
                    foreach ($this->gsiteRow['gsite_author_replace'] as $_key=>$_value) {
                        if (isset($_value['search'])) {
                            if (isset($_value['replace']) && !fn_isEmpty($_value['replace'])) {
                                $_str_replace = $_value['replace'];
                            } else {
                                $_str_replace = '';
                            }
                            $_arr_gatherSubmit['gather_author'] = str_ireplace($_value['search'], $_str_replace, $_arr_gatherSubmit['gather_author']);
                        }
                    }
                }
            }

            if (isset($_obj_domContent[0]['page_url'])) {
                $_str_pageContentDo = '';
                foreach ($_obj_domContent as $_key=>$_value) {
                    $_str_pageUrl = fn_formatUrl($_value['page_url'], $_str_contentUrl);

                    $_arr_pageRule = array(
                        'content' => array($this->gsiteRow['gsite_page_content_selector'], $this->gsiteRow['gsite_page_content_attr'], $this->gsiteRow['gsite_page_content_filter']),
                    );

                    $_obj_domPageContent = fn_qlistDom($_str_pageUrl, $_arr_pageRule, $this->gsiteRow['gsite_charset']);

                    if (isset($_obj_domPageContent[0]['content']) && !fn_isEmpty($_obj_domPageContent[0]['content'])) {
                        $_str_pageContent   = strip_tags($_obj_domPageContent[0]['content'], $this->gsiteKeepTag); //去除标签
                        $_str_pageContent   = fn_formatSrc($_str_pageContent, $_str_contentUrl); //补全 URL
                        $_str_pageContentDo .= $_str_pageContent;
                    }
                }

                $_arr_gatherSubmit['gather_content'] .= $_str_pageContentDo;

                if (!fn_isEmpty($this->gsiteRow['gsite_page_content_replace'])) {
                    foreach ($this->gsiteRow['gsite_page_content_replace'] as $_key=>$_value) {
                        if (isset($_value['search'])) {
                            if (isset($_value['replace']) && !fn_isEmpty($_value['replace'])) {
                                $_str_replace = $_value['replace'];
                            } else {
                                $_str_replace = '';
                            }
                            $_arr_gatherSubmit['gather_content'] = str_ireplace($_value['search'], $_str_replace, $_arr_gatherSubmit['gather_content']);
                        }
                    }
                }

                //过滤属性
                if (!fn_isEmpty($this->gsiteRow['gsite_attr_allow'])) {
                    $this->obj_attr->setAllow($this->gsiteRow['gsite_attr_allow']);
                }
                if (!fn_isEmpty($this->gsiteRow['gsite_ignore_tag'])) {
                    $this->obj_attr->setIgnore($this->gsiteRow['gsite_ignore_tag']);
                }
                if (!fn_isEmpty($this->gsiteRow['gsite_attr_except'])) {
                    $this->obj_attr->setExcept($this->gsiteRow['gsite_attr_except']);
                }

                if (!fn_isEmpty($this->gsiteRow['gsite_attr_allow']) || !fn_isEmpty($this->gsiteRow['gsite_ignore_tag']) || !fn_isEmpty($this->gsiteRow['gsite_attr_except'])) {
                    $_arr_gatherSubmit['gather_content'] = $this->obj_attr->strip($_arr_gatherSubmit['gather_content']);
                }
            }

            $_arr_gatherResult = $this->mdl_gather->mdl_submit($_arr_gatherSubmit);
        }

        //print_r($_arr_gatherResult);

        $_arr_tpl = array(
            'gatherRow' => $_arr_gatherResult,
            'rcode'     => $_arr_gatherResult['rcode'],
        );

        $this->obj_tpl->tplDisplay('result', $_arr_tpl);
    }



    /**
     * ajax_del function.
     *
     * @access public
     * @return void
     */
    function ctrl_del() {
        if (!isset($this->group_allow['gather']['gsite']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x280304',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_arr_gsiteIds = $this->mdl_gather->input_ids();
        if ($_arr_gsiteIds['rcode'] != 'ok') {
            $this->obj_tpl->tplDisplay('result', $_arr_gsiteIds);
        }

        $_arr_gsiteRow = $this->mdl_gather->mdl_del();

        $this->obj_tpl->tplDisplay('result', $_arr_gsiteRow);
    }


    private function gather_init() {
        if (!isset($this->group_allow['gather']['gather']) && !$this->is_super) {
            $_arr_tplData = array(
                'rcode' => 'x270303',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        if (!fn_token('chk')) { //令牌
            $_arr_tplData = array(
                'rcode' => 'x030206',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $_num_gsiteId = fn_getSafe(fn_post('gsite_id'), 'int', 0);
        if ($_num_gsiteId < 1) {
            $_arr_tplData = array(
                'rcode' => 'x270213',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $this->key = fn_getSafe(fn_post('key'), 'txt', '');
        if (fn_isEmpty($this->key)) {
            $_arr_tplData = array(
                'rcode' => 'x280201',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $this->gsite_process($_num_gsiteId);

        if (fn_isEmpty($this->gsiteRow['gsite_list_selector'])) {
            $_arr_tplData = array(
                'rcode' => 'x280203',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        if (fn_isEmpty($this->gsiteRow['gsite_title_selector'])) {
            $_arr_tplData = array(
                'rcode' => 'x280202',
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $this->gsiteKeepTag = '<' . implode('><', $this->mdl_gsite->keepTag) . '>'; //拼合系统保留标签
        if (!fn_isEmpty($this->gsiteRow['gsite_keep_tag'])) {
            $this->gsiteKeepTag .= '<' . implode('><', $this->gsiteRow['gsite_keep_tag']) . '>'; //解码用户保留标签
        }
    }


    /**
     * setUpload function.
     *
     * @access private
     * @return void
     */
    private function setUpload() {
        $_arr_mimeRows = $this->mdl_mime->mdl_list(100);
        foreach ($_arr_mimeRows as $_key=>$_value) {
            $this->attachMime[strtolower($_value['mime_ext'])] = $_value['mime_content'];
        }

        $this->mdl_attach->thumbRows  = $this->mdl_thumb->mdl_list(100);
        $this->obj_upload->thumbRows  = $this->mdl_attach->thumbRows;
        $this->obj_upload->mimeRows   = $this->attachMime;
        $this->obj_upload->ext_image  = $this->mdl_attach->ext_image;
    }


    private function gsite_process($num_gsiteId) {
        $_arr_gsiteRow = $this->mdl_gsite->mdl_read($num_gsiteId);
        if ($_arr_gsiteRow['rcode'] != 'y270102') {
            $_arr_tplData = array(
                'rcode' => $_arr_gsiteRow['rcode'],
            );
            $this->obj_tpl->tplDisplay('result', $_arr_tplData);
        }

        $this->gsiteRow = $this->mdl_gsite->selector_process($_arr_gsiteRow);
    }
}
