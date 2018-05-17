<?php
$cfg = array(
    'title'          => $this->lang['consoleMod']['article']['main']['title'],
    'menu_active'    => 'article',
    'sub_active'     => 'list',
    'baigoCheckall'  => 'true',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'tooltip'        => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . 'index.php?m=article&a=list&' . $this->tplData['query'],
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="clearfix mb-3">
        <div class="float-left">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=article&a=form" class="nav-link">
                        <span class="oi oi-plus"></span>
                        <?php echo $this->lang['mod']['href']['add']; ?>
                    </a>
                </li>
                <li class="nav-item d-none d-md-block">
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=article" class="nav-link<?php if (fn_isEmpty($this->tplData['search']['box'])) { ?> active<?php } ?>">
                        <?php echo $this->lang['mod']['href']['all']; ?>
                        <span class="badge badge-pill badge-<?php if (fn_isEmpty($this->tplData['search']['box'])) { ?>light<?php } else { ?>primary<?php } ?>"><?php echo $this->tplData['articleCount']['all']; ?></span>
                    </a>
                </li>
                <li class="nav-item d-none d-md-block">
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=article&box=draft" class="nav-link<?php if ($this->tplData['search']['box'] == 'draft') { ?> active<?php } ?>">
                        <?php echo $this->lang['mod']['href']['draft']; ?>
                        <span class="badge badge-pill badge-<?php if ($this->tplData['search']['box'] == 'draft') { ?>light<?php } else { ?>primary<?php } ?>"><?php echo $this->tplData['articleCount']['draft']; ?></span>
                    </a>
                </li>
                <?php if ($this->tplData['articleCount']['recycle'] > 0) { ?>
                    <li class="nav-item d-none d-md-block">
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=article&box=recycle" class="nav-link <?php if ($this->tplData['search']['box'] == 'recycle') { ?> active<?php } ?>">
                            <?php echo $this->lang['mod']['href']['recycle']; ?>
                            <span class="badge badge-pill badge-<?php if ($this->tplData['search']['box'] == 'recycle') { ?>light<?php } else { ?>primary<?php } ?>"><?php echo $this->tplData['articleCount']['recycle']; ?></span>
                        </a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a href="<?php echo BG_URL_HELP; ?>index.php?m=console&a=article" target="_blank" class="nav-link">
                        <span class="badge badge-pill badge-primary">
                            <span class="oi oi-question-mark"></span>
                        </span>
                        <?php echo $this->lang['mod']['href']['help']; ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="float-right">
            <form name="article_search" id="article_search" action="<?php echo BG_URL_CONSOLE; ?>index.php" method="get">
                <input type="hidden" name="m" value="article">
                <input type="hidden" name="a" value="list">
                <input type="hidden" name='box' value="<?php echo $this->tplData['search']['box']; ?>">
                <div class="input-group">
                    <select name="cate_id" class="custom-select">
                        <option value=""><?php echo $this->lang['mod']['option']['allCate']; ?></option>
                        <?php cate_list_opt($this->tplData['cateRows'], $this->tplData['search']['cate_id']); ?>
                        <option<?php if ($this->tplData['search']['cate_id'] == -1) { ?> selected<?php } ?> value="-1">
                            <?php echo $this->lang['mod']['option']['unCate']; ?>
                        </option>
                    </select>
                    <select name="year" class="custom-select d-none d-md-block">
                        <option value=""><?php echo $this->lang['mod']['option']['allYear']; ?></option>
                        <?php foreach ($this->tplData['articleYear'] as $key=>$value) { ?>
                            <option<?php if ($this->tplData['search']['year'] == $value['article_year']) { ?> selected<?php } ?> value="<?php echo $value['article_year']; ?>"><?php echo $value['article_year']; ?></option>
                        <?php } ?>
                    </select>
                    <select name="month" class="custom-select d-none d-md-block">
                        <option value=""><?php echo $this->lang['mod']['option']['allMonth']; ?></option>
                        <?php for ($iii = 1 ; $iii <= 12; $iii++) {
                            if ($iii < 10) {
                                $str_month = "0" . $iii;
                            } else {
                                $str_month = $iii;
                            } ?>
                            <option<?php if ($this->tplData['search']['month'] == $str_month) { ?> selected<?php } ?> value="<?php echo $str_month; ?>"><?php echo $str_month; ?></option>
                        <?php } ?>
                    </select>
                    <select name="mark_id" class="custom-select d-none d-md-block">
                        <option value=""><?php echo $this->lang['mod']['option']['allMark']; ?></option>
                        <?php foreach ($this->tplData['markRows'] as $key=>$value) { ?>
                            <option<?php if ($this->tplData['search']['mark_id'] == $value['mark_id']) { ?> selected<?php } ?> value="<?php echo $value['mark_id']; ?>"><?php echo $value['mark_name']; ?></option>
                        <?php } ?>
                    </select>
                    <select name="status" class="custom-select d-none d-md-block">
                        <option value=""><?php echo $this->lang['mod']['option']['allStatus']; ?></option>
                        <?php foreach ($this->tplData['status'] as $key=>$value) { ?>
                            <option<?php if ($this->tplData['search']['status'] == $value) { ?> selected<?php } ?> value="<?php echo $value; ?>">
                                <?php if (isset($this->lang['mod']['status'][$value])) {
                                    echo $this->lang['mod']['status'][$value];
                                } else {
                                    echo $value;
                                } ?>
                            </option>
                        <?php } ?>
                    </select>
                    <input type="text" name="key" class="form-control" value="<?php echo $this->tplData['search']['key']; ?>" placeholder="<?php echo $this->lang['mod']['label']['key']; ?>">
                    <span class="input-group-append">
                        <button class="btn btn-secondary" type="submit">
                            <span class="oi oi-magnifying-glass"></span>
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>

    <?php if ($this->tplData['search']['box'] == "recycle") { ?>
        <form name="article_empty" id="article_empty">
            <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
            <input type="hidden" id="act_empty" name="a" value="empty">
            <div class="bg-submit-box bg-submit-box-empty"></div>
            <div class="form-group">
                <button type="button" class="btn btn-info bg-submit-empty">
                    <span class="oi oi-trash"></span>
                    <?php echo $this->lang['mod']['btn']['emptyMy']; ?>
                </button>
            </div>
        </form>
    <?php } ?>

    <form name="article_list" id="article_list">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">

        <div class="table-responsive">
            <table class="table table-striped table-hover border">
                <thead>
                    <tr>
                        <th class="text-nowrap bg-td-xs">
                            <div class="form-check">
                                <label for="chk_all" class="form-check-label">
                                    <input type="checkbox" name="chk_all" id="chk_all" data-parent="first" class="form-check-input">
                                    <?php echo $this->lang['mod']['label']['all']; ?>
                                </label>
                            </div>
                        </th>
                        <th class="text-nowrap bg-td-xs"><?php echo $this->lang['mod']['label']['id']; ?></th>
                        <th><?php echo $this->lang['mod']['label']['title']; ?></th>
                        <th class="text-nowrap bg-td-md"><?php echo $this->lang['common']['label']['cate']; ?> / <?php echo $this->lang['mod']['label']['mark']; ?></th>
                        <th class="text-nowrap bg-td-md"><?php echo $this->lang['mod']['label']['admin']; ?> / <?php echo $this->lang['mod']['label']['hits']; ?></th>
                        <th class="text-nowrap bg-td-md"><?php echo $this->lang['mod']['label']['status']; ?> / <?php echo $this->lang['mod']['label']['time']; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->tplData['articleRows'] as $key=>$value) {
                        if ($value['article_is_gen'] == "yes") {
                            $css_gen = 'secondary';
                        } else {
                            $css_gen = "danger";
                        }

                        $str_gen = $this->lang['mod']['status'][$value['article_is_gen']]; ?>
                        <tr>
                            <td class="text-nowrap bg-td-xs"><input type="checkbox" name="article_ids[]" value="<?php echo $value['article_id']; ?>" id="article_id_<?php echo $value['article_id']; ?>" data-validate="article_id" data-parent="chk_all"></td>
                            <td class="text-nowrap bg-td-xs"><?php echo $value['article_id']; ?></td>
                            <td>
                                <ul class="list-unstyled">
                                    <li>
                                        <?php if (fn_isEmpty($value['article_title'])) {
                                            echo $this->lang['mod']['label']['noTitle'];
                                        } else {
                                            echo $value['article_title'];
                                        } ?>
                                    </li>
                                    <li>
                                        <ul class="bg-nav-line">
                                            <li>
                                                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=article&a=show&article_id=<?php echo $value['article_id']; ?>"><?php echo $this->lang['mod']['href']['show']; ?></a>
                                            </li>
                                            <li>
                                                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=article&a=form&article_id=<?php echo $value['article_id']; ?>"><?php echo $this->lang['mod']['href']['edit']; ?></a>
                                            </li>
                                            <?php if (BG_MODULE_GEN > 0 && BG_VISIT_TYPE == 'static' && $value['article_box'] == 'normal' && $value['article_status'] == 'pub' && ($value['article_is_time_pub'] < 1 || $value['article_time_pub'] < time()) && ($value['article_is_time_hide'] < 1 || $value['article_time_hide'] > time())) { ?>
                                                <li>
                                                    <a href="#gen_modal" data-url="<?php echo BG_URL_CONSOLE; ?>index.php?m=article_gen&a=single&article_id=<?php echo $value['article_id']; ?>&view=iframe" data-toggle="modal">
                                                        <span class="oi oi-loop-circular"></span>
                                                        <?php echo $this->lang['mod']['btn']['genSingle']; ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                </ul>
                            </td>
                            <td class="text-nowrap bg-td-md">
                                <ul class="list-unstyled">
                                    <li>
                                        <?php $str_cateTrees = '';
                                        if (isset($value['cateRow']['cate_trees'])) {
                                            $_count = 1;
                                            foreach ($value['cateRow']['cate_trees'] as $key_tree=>$value_tree) {
                                                $str_cateTrees .= $value_tree['cate_name'];
                                                if ($_count < count($value['cateRow']['cate_trees'])) {
                                                    $str_cateTrees .= ' &raquo; ';
                                                }
                                                $_count++;
                                            }
                                        }

                                        if (isset($value['cateRow']['cate_name'])) { ?>
                                            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=article&a=list&cate_id=<?php echo $value_tree['cate_id']; ?>">
                                                <abbr data-toggle="tooltip" data-placement="bottom" title="<?php echo $str_cateTrees; ?>">
                                                    <?php echo $value['cateRow']['cate_name']; ?>
                                                </abbr>
                                            </a>
                                        <?php } else {
                                            echo $this->lang['mod']['label']['unCate'];
                                        } ?>
                                    </li>
                                    <li>
                                        <?php if (isset($value['markRow']['mark_name'])) { ?>
                                            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=article&mark_id=<?php echo $value['article_mark_id']; ?>"><?php echo $value['markRow']['mark_name']; ?></a>
                                        <?php } else {
                                            echo $this->lang['mod']['label']['noMark'];
                                        } ?>
                                    </li>
                                </ul>
                            </td>
                            <td class="text-nowrap bg-td-md">
                                <ul class="list-unstyled">
                                    <li>
                                        <?php if (isset($value['adminRow']['admin_name'])) { ?>
                                            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=article&admin_id=<?php echo $value['article_admin_id']; ?>&box=<?php echo $this->tplData['search']['box']; ?>"><?php echo $value['adminRow']['admin_name']; ?></a>
                                        <?php } else {
                                            echo $this->lang['mod']['label']['unAdmin'];
                                        } ?>
                                    </li>
                                    <li>
                                        <abbr data-toggle="tooltip" data-placement="bottom" title="
                                            <?php echo $this->lang['mod']['label']['hitsDay'], ' ', $value['article_hits_day']; ?><br>
                                            <?php echo $this->lang['mod']['label']['hitsWeek'], ' ', $value['article_hits_week']; ?><br>
                                            <?php echo $this->lang['mod']['label']['hitsMonth'], ' ', $value['article_hits_month']; ?><br>
                                            <?php echo $this->lang['mod']['label']['hitsYear'], ' ', $value['article_hits_year']; ?><br>
                                            <?php echo $this->lang['mod']['label']['hitsAll'], ' ', $value['article_hits_all']; ?>
                                        ">
                                            <?php echo $value['article_hits_all']; ?>
                                        </abbr>
                                    </li>
                                </ul>
                            </td>
                            <td class="text-nowrap bg-td-md">
                                <ul class="list-unstyled">
                                    <li>
                                        <?php article_status_process($value, $this->lang['mod']['status'], $this->lang['mod']);
                                        if (BG_MODULE_GEN > 0 && BG_VISIT_TYPE == 'static') { ?>
                                            <span class="badge badge-<?php echo $css_gen; ?>"><?php echo $str_gen; ?></span>
                                        <?php } ?>
                                    </li>
                                    <li>
                                        <abbr data-toggle="tooltip" data-placement="bottom" title="<?php echo date(BG_SITE_DATE . ' ' . BG_SITE_TIME, $value['article_time_show']); ?>">
                                            <?php echo date(BG_SITE_DATESHORT . ' ' . BG_SITE_TIMESHORT, $value['article_time_show']); ?>
                                        </abbr>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <small class="form-text" id="msg_article_id"></small>
            <div class="bg-submit-box bg-submit-box-list"></div>
        </div>

        <div class="clearfix mt-3">
            <div class="float-left">
                <div class="input-group">
                    <select name="a" id="a" data-validate class="custom-select">
                        <option value=""><?php echo $this->lang['mod']['option']['batch']; ?></option>
                        <?php switch ($this->tplData['search']['box']) {
                            case 'recycle': ?>
                                <option value="normal"><?php echo $this->lang['mod']['option']['revert']; ?></option>
                                <option value="draft"><?php echo $this->lang['mod']['option']['draft']; ?></option>
                                <option value="del"><?php echo $this->lang['mod']['option']['del']; ?></option>
                            <?php break;

                            case 'draft': ?>
                                <option value="normal"><?php echo $this->lang['mod']['option']['revert']; ?></option>
                                <option value="recycle"><?php echo $this->lang['mod']['option']['recycle']; ?></option>
                            <?php break;

                            default:
                                foreach ($this->tplData['status'] as $key=>$value) { ?>
                                    <option value="<?php echo $value; ?>">
                                        <?php if (isset($this->lang['mod']['status'][$value])) {
                                            echo $this->lang['mod']['status'][$value];
                                        } else {
                                            echo $value;
                                        } ?>
                                    </option>
                                <?php } ?>
                                <option value="top"><?php echo $this->lang['mod']['option']['top']; ?></option>
                                <option value="untop"><?php echo $this->lang['mod']['option']['untop']; ?></option>
                                <option value="move"><?php echo $this->lang['mod']['option']['moveToCate']; ?></option>
                                <option value="normal"><?php echo $this->lang['mod']['option']['revert']; ?></option>
                                <option value="draft"><?php echo $this->lang['mod']['option']['draft']; ?></option>
                                <option value="recycle"><?php echo $this->lang['mod']['option']['recycle']; ?></option>
                            <?php break;
                        } ?>
                    </select>
                    <select id="cate_id" name="cate_id" data-validate class="custom-select">
                        <option value="">
                            <?php echo $this->lang['mod']['option']['pleaseSelect']; ?>
                        </option>
                        <?php cate_list_opt($this->tplData['cateRows'], $this->tplData['search']['cate_id'], true); ?>
                    </select>
                    <span class="input-group-append">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['submit']; ?></button>
                    </span>
                </div>
                <small class="form-text" id="msg_a"></small>
                <small class="form-text" id="msg_cate_id"></small>
            </div>
            <div class="float-right">
                <?php include($cfg['pathInclude'] . 'page.php'); ?>
            </div>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_list = {
        article_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='article_id']", type: "checkbox" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x030202']; ?>" }
        },
        cate_id: {
            len: { min: 1, "max": 0 },
            validate: { type: "select" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x250225']; ?>" }
        },
        a: {
            len: { min: 1, "max": 0 },
            validate: { type: "select" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x030203']; ?>" }
        }
    };

    var opts_submit_list = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=article&c=request",
        confirm: {
            selector: "#a",
            val: "del",
            msg: "<?php echo $this->lang['mod']['confirm']['del']; ?>"
        },
        box: {
            selector: ".bg-submit-box-list"
        },
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    var opts_submit_empty = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=article&c=request",
        confirm: {
            selector: "#act_empty",
            val: "empty",
            msg: "<?php echo $this->lang['mod']['confirm']['empty']; ?>"
        },
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        },
        box: {
            selector: ".bg-submit-box-empty"
        },
        selector: {
            submit_btn: ".bg-submit-empty"
        }
    };

    $(document).ready(function(){
        $("#cate_id").hide();
        var obj_validate_list = $("#article_list").baigoValidator(opts_validator_list);
        var obj_submit_list   = $("#article_list").baigoSubmit(opts_submit_list);
        $(".bg-submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });

        var obj_submit_empty = $("#article_empty").baigoSubmit(opts_submit_empty);
        $(".bg-submit-empty").click(function(){
            obj_submit_empty.formSubmit();
        });

        $("#a").change(function(){
            var _act = $(this).val();
            if (_act == "move") {
                $("#cate_id").show();
            } else {
                $("#cate_id").hide();
            }
        });

        $("#article_list").baigoCheckall();
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php');