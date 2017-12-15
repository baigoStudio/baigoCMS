<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

fn_include(BG_PATH_FUNC . 'gather.func.php');

/*-------------用户类-------------*/
class CONTROL_CONSOLE_UI_GSITE_PREVIEW {

    private $group_allow    = array();
    private $is_super       = false;

    function __construct() { //构造函数
        $this->general_console  = new GENERAL_CONSOLE();
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

        $this->obj_attr     = new CLASS_ATTR();

        $this->mdl_gsite    = new MODEL_GSITE();

        $this->tplData = array(
            'adminLogged' => $this->adminLogged,
        );

        $this->gsite_init();
    }


    function ctrl_page_content() {
        $_arr_contentRow  = array(
            'url'       => '',
            'title'     => '',
            'content'   => '',
        );

        if (!fn_isEmpty($this->gsiteRow['gsite_page_list_selector'])) {
            $_arr_rule = array(
                'url'   => array($this->gsiteRow['gsite_list_selector'], 'href'),
            );

            $_obj_dom = fn_qlistDom($this->gsiteRow['gsite_url'], $_arr_rule, $this->gsiteRow['gsite_charset']);

            if (isset($_obj_dom[0]['url']) && !fn_isEmpty($_obj_dom[0]['url'])) {
                $_str_pageUrl = fn_formatUrl($_obj_dom[0]['url'], $this->gsiteRow['gsite_url']);

                $_arr_pageRule = array(
                    'url'   => array($this->gsiteRow['gsite_page_list_selector'], 'href'),
                );

                $_obj_domPage = fn_qlistDom($_str_pageUrl, $_arr_pageRule, $this->gsiteRow['gsite_charset']);

                if (isset($_obj_domPage[0]['url']) && !fn_isEmpty($this->gsiteRow['gsite_page_content_selector'])) {
                    $_str_contentUrl = fn_formatUrl($_obj_domPage[0]['url'], $this->gsiteRow['gsite_url']);

                    $_arr_contentRule = array(
                        'content'   => array($this->gsiteRow['gsite_page_content_selector'], $this->gsiteRow['gsite_page_content_attr'], $this->gsiteRow['gsite_page_content_filter']),
                    );

                    $_obj_domContent = fn_qlistDom($_str_contentUrl, $_arr_contentRule, $this->gsiteRow['gsite_charset']);

                    $_arr_contentRow['url'] = $_str_contentUrl;

                    if (isset($_obj_domContent[0]['content'])) {
                        $_str_articleContent        = strip_tags($_obj_domContent[0]['content'], $this->gsiteKeepTag); //去除标签
                        $_str_articleContent        = fn_formatSrc($_str_articleContent, $_str_contentUrl); //补全 URL
                        $_arr_contentRow['content'] = $_str_articleContent;

                        if (!fn_isEmpty($this->gsiteRow['gsite_page_content_replace'])) {
                            foreach ($this->gsiteRow['gsite_page_content_replace'] as $_key=>$_value) {
                                if (isset($_value['search'])) {
                                    if (isset($_value['replace']) && !fn_isEmpty($_value['replace'])) {
                                        $_str_replace = $_value['replace'];
                                    } else {
                                        $_str_replace = '';
                                    }
                                    $_arr_contentRow['content'] = str_ireplace($_value['search'], $_str_replace, $_arr_contentRow['content']);
                                }
                            }
                        }
                    }
                }
            }
        }

        $_arr_tpl = array(
            'contentRow' => $_arr_contentRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('gsite_preview_content', $_arr_tplData);
    }


    function ctrl_page_list() {
        $_arr_listRows = array();

        if (!fn_isEmpty($this->gsiteRow['gsite_page_list_selector'])) {
            $_arr_rule = array(
                'url'   => array($this->gsiteRow['gsite_list_selector'], 'href'),
            );

            $_obj_dom = fn_qlistDom($this->gsiteRow['gsite_url'], $_arr_rule, $this->gsiteRow['gsite_charset']);

            if (isset($_obj_dom[0]['url']) && !fn_isEmpty($_obj_dom[0]['url'])) {
                $_str_pageUrl = fn_formatUrl($_obj_dom[0]['url'], $this->gsiteRow['gsite_url']);

                $_arr_pageRule = array(
                    'url'       => array($this->gsiteRow['gsite_page_list_selector'], 'href'),
                    'content'   => array($this->gsiteRow['gsite_page_list_selector'], 'html'),
                );

                $_obj_domPage = fn_qlistDom($_str_pageUrl, $_arr_pageRule, $this->gsiteRow['gsite_charset']);

                if (!fn_isEmpty($_obj_domPage)) {
                    foreach ($_obj_domPage as $_key=>$_value) {
                        $_arr_listRows[] = array(
                            'url'       => fn_formatUrl($_value['url'], $this->gsiteRow['gsite_url']),
                            'content'   => $_value['content'],
                        );
                    }
                }
            }
        }

        $_arr_tpl = array(
            'listRows'      => $_arr_listRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('gsite_preview_list', $_arr_tplData);
    }


    function ctrl_content() {
        $_arr_contentRow  = array(
            'url'       => '',
            'title'     => '',
            'content'   => '',
            'time'      => '',
            'source'    => '',
            'author'    => '',
        );

        if (!fn_isEmpty($this->gsiteRow['gsite_list_selector'])) {
            $_arr_rule = array(
                'url'   => array($this->gsiteRow['gsite_list_selector'], 'href'),
            );

            $_obj_dom = fn_qlistDom($this->gsiteRow['gsite_url'], $_arr_rule, $this->gsiteRow['gsite_charset']);

            if (isset($_obj_dom[0]['url']) && !fn_isEmpty($_obj_dom[0]['url']) && !fn_isEmpty($this->gsiteRow['gsite_title_selector'])) {
                $_str_contentUrl    = fn_formatUrl($_obj_dom[0]['url'], $this->gsiteRow['gsite_url']);

                $_arr_ontentRule['title'] = array($this->gsiteRow['gsite_title_selector'], $this->gsiteRow['gsite_title_attr'], $this->gsiteRow['gsite_title_filter']);

                if (!fn_isEmpty($this->gsiteRow['gsite_content_selector'])) {
                    $_arr_ontentRule['content'] = array($this->gsiteRow['gsite_content_selector'], $this->gsiteRow['gsite_content_attr'], $this->gsiteRow['gsite_content_filter']);
                }

                if (!fn_isEmpty($this->gsiteRow['gsite_time_selector'])) {
                    $_arr_ontentRule['time'] = array($this->gsiteRow['gsite_time_selector'], $this->gsiteRow['gsite_time_attr'], $this->gsiteRow['gsite_time_filter']);
                }

                if (!fn_isEmpty($this->gsiteRow['gsite_source_selector'])) {
                    $_arr_ontentRule['source'] = array($this->gsiteRow['gsite_source_selector'], $this->gsiteRow['gsite_source_attr'], $this->gsiteRow['gsite_source_filter']);
                }

                if (!fn_isEmpty($this->gsiteRow['gsite_author_selector'])) {
                    $_arr_ontentRule['author'] = array($this->gsiteRow['gsite_author_selector'], $this->gsiteRow['gsite_author_attr'], $this->gsiteRow['gsite_author_filter']);
                }

                $_obj_domContent        = fn_qlistDom($_str_contentUrl, $_arr_ontentRule, $this->gsiteRow['gsite_charset']);

                $_arr_contentRow['url'] = $_str_contentUrl;

                if (isset($_obj_domContent[0]['title'])) {
                    $_arr_contentRow['title'] = $_obj_domContent[0]['title'];

                    if (!fn_isEmpty($this->gsiteRow['gsite_title_replace'])) {
                        foreach ($this->gsiteRow['gsite_title_replace'] as $_key=>$_value) {
                            if (isset($_value['search'])) {
                                if (isset($_value['replace']) && !fn_isEmpty($_value['replace'])) {
                                    $_str_replace = $_value['replace'];
                                } else {
                                    $_str_replace = '';
                                }
                                $_arr_contentRow['title'] = str_ireplace($_value['search'], $_str_replace, $_arr_contentRow['title']);
                            }
                        }
                    }
                }

                if (isset($_obj_domContent[0]['content'])) {
                    $_str_articleContent        = strip_tags($_obj_domContent[0]['content'], $this->gsiteKeepTag); //去除标签
                    $_str_articleContent        = fn_formatSrc($_str_articleContent, $_str_contentUrl); //补全 URL
                    $_arr_contentRow['content'] = $_str_articleContent;

                    if (!fn_isEmpty($this->gsiteRow['gsite_content_replace'])) {
                        foreach ($this->gsiteRow['gsite_content_replace'] as $_key=>$_value) {
                            if (isset($_value['search'])) {
                                if (isset($_value['replace']) && !fn_isEmpty($_value['replace'])) {
                                    $_str_replace = $_value['replace'];
                                } else {
                                    $_str_replace = '';
                                }
                                $_arr_contentRow['content'] = str_ireplace($_value['search'], $_str_replace, $_arr_contentRow['content']);
                            }
                        }
                    }

                    //print_r($this->gsiteRow);

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
                        $_arr_contentRow['content'] = $this->obj_attr->strip($_arr_contentRow['content']);
                    }
                }

                //$_arr_qlistImgs = fn_qlistImg($_obj_domContent[0]['content'], $this->gsiteRow['gsite_img_attr'], $this->gsiteRow['gsite_img_filter']);

                //print_r($_arr_qlistImgs);

                if (isset($_obj_domContent[0]['time'])) {
                    $_arr_contentRow['time'] = $_obj_domContent[0]['time'];

                    if (!fn_isEmpty($this->gsiteRow['gsite_time_replace'])) {
                        foreach ($this->gsiteRow['gsite_time_replace'] as $_key=>$_value) {
                            if (isset($_value['search'])) {
                                if (isset($_value['replace']) && !fn_isEmpty($_value['replace'])) {
                                    $_str_replace = $_value['replace'];
                                } else {
                                    $_str_replace = '';
                                }
                                $_arr_contentRow['time'] = str_ireplace($_value['search'], $_str_replace, $_arr_contentRow['time']);
                            }
                        }
                    }
                }

                if (isset($_obj_domContent[0]['source'])) {
                    $_arr_contentRow['source'] = $_obj_domContent[0]['source'];

                    if (!fn_isEmpty($this->gsiteRow['gsite_source_replace'])) {
                        foreach ($this->gsiteRow['gsite_source_replace'] as $_key=>$_value) {
                            if (isset($_value['search'])) {
                                if (isset($_value['replace']) && !fn_isEmpty($_value['replace'])) {
                                    $_str_replace = $_value['replace'];
                                } else {
                                    $_str_replace = '';
                                }
                                $_arr_contentRow['source'] = str_ireplace($_value['search'], $_str_replace, $_arr_contentRow['source']);
                            }
                        }
                    }
                }

                if (isset($_obj_domContent[0]['author'])) {
                    $_arr_contentRow['author'] = $_obj_domContent[0]['author'];

                    if (!fn_isEmpty($this->gsiteRow['gsite_author_replace'])) {
                        foreach ($this->gsiteRow['gsite_author_replace'] as $_key=>$_value) {
                            if (isset($_value['search'])) {
                                if (isset($_value['replace']) && !fn_isEmpty($_value['replace'])) {
                                    $_str_replace = $_value['replace'];
                                } else {
                                    $_str_replace = '';
                                }
                                $_arr_contentRow['author'] = str_ireplace($_value['search'], $_str_replace, $_arr_contentRow['author']);
                            }
                        }
                    }
                }
            }
        }

        $_arr_tpl = array(
            'contentRow'    => $_arr_contentRow,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('gsite_preview_content', $_arr_tplData);
    }


    function ctrl_list() {
        $_arr_listRows  = array();

        if (!fn_isEmpty($this->gsiteRow['gsite_list_selector'])) {
            $_arr_rule = array(
                'url'       => array($this->gsiteRow['gsite_list_selector'], 'href'),
                'content'   => array($this->gsiteRow['gsite_list_selector'], 'html'),
            );

            $_obj_dom = fn_qlistDom($this->gsiteRow['gsite_url'], $_arr_rule, $this->gsiteRow['gsite_charset']);

            if (!fn_isEmpty($_obj_dom)) {
                foreach($_obj_dom as $_key=>$_value) {
                    $_arr_listRows[] = array(
                        'url'       => fn_formatUrl($_value['url'], $this->gsiteRow['gsite_url']),
                        'content'   => $_value['content'],
                    );
                }
            }
        }

        $_arr_tpl = array(
            'listRows'  => $_arr_listRows,
        );

        $_arr_tplData = array_merge($this->tplData, $_arr_tpl);

        $this->obj_tpl->tplDisplay('gsite_preview_list', $_arr_tplData);
    }


    private function gsite_init() {
        if (!isset($this->group_allow['gather']['gsite']) && !$this->is_super) {
            $this->tplData['rcode'] = 'x270301';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_num_gsiteId = fn_getSafe(fn_get('gsite_id'), 'int', 0);
        if ($_num_gsiteId < 1) {
            $this->tplData['rcode'] = 'x270213';
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $_arr_gsiteRow = $this->mdl_gsite->mdl_read($_num_gsiteId);
        if ($_arr_gsiteRow['rcode'] != 'y270102') {
            $this->tplData['rcode'] = $_arr_gsiteRow['rcode'];
            $this->obj_tpl->tplDisplay('error', $this->tplData);
        }

        $this->gsiteRow = $this->mdl_gsite->selector_process($_arr_gsiteRow);

        $this->gsiteKeepTag = '<' . implode('><', $this->mdl_gsite->keepTag) . '>'; //拼合系统保留标签
        if (!fn_isEmpty($this->gsiteRow['gsite_keep_tag'])) {
            $this->gsiteKeepTag .= '<' . implode('><', $this->gsiteRow['gsite_keep_tag']) . '>'; //解码用户保留标签
        }
    }
}
