<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['spec']['main']['title'] . ' &raquo; ' . $this->lang['mod']['page']['select'],
    'menu_active'    => 'spec',
    'sub_active'     => "list",
    'baigoCheckall'  => 'true',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'tinymce'        => 'true',
    'upload'         => 'true',
    "tooltip"        => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?mod=spec&act=select&spec_id=" . $this->tplData['specRow']['spec_id'] . '&' . $this->tplData['query'],
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group">
        <ul class="nav nav-pills bg-nav-pills">
            <li>
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=spec&act=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <?php echo $this->lang['common']['href']['back']; ?>
                </a>
            </li>
            <li>
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=spec&act=form&spec_id=<?php echo $this->tplData['specRow']['spec_id']; ?>">
                    <span class="glyphicon glyphicon-edit"></span>
                    <?php echo $this->lang['mod']['href']['edit']; ?>
                </a>
            </li>
            <li>
                <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=spec#select" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    <?php echo $this->lang['mod']['href']['help']; ?>
                </a>
            </li>
            <li>
                <button type="button" class="btn btn-warning btn-sm"><?php echo $this->lang['mod']['label']['specName']; ?> <strong><?php echo $this->tplData['specRow']['spec_name']; ?></strong></button>
            </li>
        </ul>
    </div>

    <div class="row">

        <div class="col-md-6">

            <div class="well">
                <label class="control-label"><?php echo $this->lang['mod']['label']['belongArticle']; ?></label>
                <form name="belong_search" id="belong_search" action="<?php echo BG_URL_CONSOLE; ?>index.php" method="get" class="form-inline">
                    <input type="hidden" name="mod" value="spec">
                    <input type="hidden" name="act" value="select">
                    <input type="hidden" name="spec_id" value="<?php echo $this->tplData['specRow']['spec_id']; ?>">
                    <div class="form-group">
                        <div class="input-group input-group-sm">
                            <input type="text" name="key_belong" class="form-control" value="<?php echo $this->tplData['searchBelong']['key']; ?>" placeholder="<?php echo $this->lang['mod']['label']['key']; ?>">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>

            <form name="belong_form" id="belong_form">
                <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">

                <div class="panel panel-default">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-nowrap bg-td-xs">
                                        <label for="belong_all" class="checkbox-inline">
                                            <input type="checkbox" name="belong_all" id="belong_all" data-parent="first">
                                            <?php echo $this->lang['mod']['label']['all']; ?>
                                        </label>
                                    </th>
                                    <th class="text-nowrap bg-td-xs"><?php echo $this->lang['mod']['label']['id']; ?></th>
                                    <th><?php echo $this->lang['common']['label']['article']; ?></th>
                                    <th class="text-nowrap bg-td-xl"><?php echo $this->lang['mod']['label']['status']; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($this->tplData['belongRows'] as $key=>$value) { ?>
                                    <tr>
                                        <td class="text-nowrap bg-td-xs"><input type="checkbox" name="article_ids[]" value="<?php echo $value['article_id']; ?>" id="belong_id_<?php echo $value['article_id']; ?>" data-validate="belong_id" data-parent="belong_all"></td>
                                        <td class="text-nowrap bg-td-xs"><?php echo $value['article_id']; ?></td>
                                        <td>
                                            <?php if (fn_isEmpty($value['article_title'])) {
                                                echo $this->lang['mod']['label']['noname'];
                                            } else {
                                                echo $value['article_title'];
                                            } ?>
                                        </td>
                                        <td class="text-nowrap bg-td-xl">
                                            <ul class="list-unstyled">
                                                <li>
                                                    <?php article_status_process($value, $this->lang['mod']['status'], $this->lang['mod']); ?>
                                                </li>
                                                <li><?php echo date(BG_SITE_DATESHORT . "  " . BG_SITE_TIMESHORT, $value['article_time_show']); ?></li>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"><span id="msg_belong_id"></span></td>
                                    <td colspan="2">
                                        <div class="bg-submit-box bg-submit-box-del"></div>
                                        <input type="hidden" name="act" value="belongDel">
                                        <button type="button" class="btn btn-primary btn-sm bg-submit-del"><?php echo $this->lang['mod']['btn']['belongDel']; ?></button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </form>
        </div>

        <div class="col-md-6">

            <div class="well">
                <label class="control-label"><?php echo $this->lang['mod']['label']['selectArticle']; ?></label>
                <form name="select_search" id="select_search" action="<?php echo BG_URL_CONSOLE; ?>index.php" method="get" class="form-inline">
                    <input type="hidden" name="mod" value="spec">
                    <input type="hidden" name="act" value="select">
                    <input type="hidden" name="spec_id" value="<?php echo $this->tplData['specRow']['spec_id']; ?>">
                    <div class="form-group">
                        <select name="cate_id" class="form-control input-sm">
                            <option value=""><?php echo $this->lang['mod']['option']['allCate']; ?></option>
                            <?php cate_list_opt($this->tplData['cateRows'], $this->tplData['search']['cate_id']); ?>
                            <option <?php if ($this->tplData['search']['cate_id'] == -1) { ?>selected<?php } ?> value="-1"><?php echo $this->lang['mod']['option']['unknown']; ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="status" class="form-control input-sm">
                            <option value=""><?php echo $this->lang['mod']['option']['allStatus']; ?></option>
                            <?php foreach ($this->tplData['statusArticle'] as $key=>$value) { ?>
                                <option <?php if ($this->tplData['search']['status'] == $value) { ?>selected<?php } ?> value="<?php echo $value; ?>">
                                    <?php if (isset($this->lang['mod']['status'][$value])) {
                                        echo $this->lang['mod']['status'][$value];
                                    } else {
                                        echo $value;
                                    } ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-sm">
                            <input type="text" name="key" class="form-control" value="<?php echo $this->tplData['search']['key']; ?>" placeholder="<?php echo $this->lang['mod']['label']['key']; ?>">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>

            <form name="select_form" id="select_form">
                <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
                <input type="hidden" name="spec_id" value="<?php echo $this->tplData['specRow']['spec_id']; ?>">

                <div class="panel panel-default">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-nowrap bg-td-xs">
                                        <label for="select_all" class="checkbox-inline">
                                            <input type="checkbox" name="select_all" id="select_all" data-parent="first">
                                            <?php echo $this->lang['mod']['label']['all']; ?>
                                        </label>
                                    </th>
                                    <th class="text-nowrap bg-td-xs"><?php echo $this->lang['mod']['label']['id']; ?></th>
                                    <th><?php echo $this->lang['common']['label']['article']; ?> / <?php echo $this->lang['common']['label']['spec']; ?></th>
                                    <th class="text-nowrap bg-td-xl"><?php echo $this->lang['mod']['label']['status']; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($this->tplData['articleRows'] as $key=>$value) { ?>
                                    <tr>
                                        <td class="text-nowrap bg-td-xs"><input type="checkbox" name="article_ids[]" value="<?php echo $value['article_id']; ?>" id="select_ids_<?php echo $value['article_id']; ?>" data-validate="select_ids" data-parent="select_all"></td>
                                        <td class="text-nowrap bg-td-xs"><?php echo $value['article_id']; ?></td>
                                        <td>
                                            <ul class="list-unstyled">
                                                <li>
                                                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=article&act=show&article_id=<?php echo $value['article_id']; ?>">
                                                        <?php if (fn_isEmpty($value['article_title'])) {
                                                            echo $this->lang['mod']['label']['noname'];
                                                        } else {
                                                            echo $value['article_title'];
                                                        } ?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <?php if (isset($value['specRow']['spec_name'])) { ?>
                                                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=spec&act=select&spec_id=<?php echo $value['specRow']['spec_id']; ?>"><?php echo $value['specRow']['spec_name']; ?></a>
                                                    <?php } ?>
                                                </li>
                                            </ul>
                                        </td>
                                        <td class="text-nowrap bg-td-xl">
                                            <ul class="list-unstyled">
                                                <li>
                                                    <?php article_status_process($value, $this->lang['mod']['status'], $this->lang['mod']); ?>
                                                </li>
                                                <li><?php echo date(BG_SITE_DATESHORT . ' ' . BG_SITE_TIMESHORT, $value['article_time_show']); ?></li>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"><span id="msg_select_ids"></span></td>
                                    <td colspan="2">
                                        <div class="bg-submit-box bg-submit-box-list"></div>
                                        <input type="hidden" name="act" value="belongAdd">
                                        <button type="button" class="btn btn-primary btn-sm bg-submit"><?php echo $this->lang['mod']['btn']['belongAdd']; ?></button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </form>

            <div class="text-right">
                <?php include($cfg['pathInclude'] . 'page.php'); ?>
            </div>

        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>


    <script type="text/javascript">
    var opts_validator_select = {
        select_ids: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='select_ids']", type: "checkbox" },
            msg: { selector: "#msg_select_ids", too_few: "<?php echo $this->lang['rcode']['x030202']; ?>" }
        }
    };

    var opts_validator_belong = {
        belong_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='belong_id']", type: "checkbox" },
            msg: { selector: "#msg_belong_id", too_few: "<?php echo $this->lang['rcode']['x030202']; ?>" }
        }
    };

    var opts_submit_select = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=spec",
        box: {
            selector: ".bg-submit-box-list"
        },
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    var opts_submit_belong = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=spec",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        },
        box: {
            selector: ".bg-submit-box-del"
        },
        selector: {
            submit_btn: ".bg-submit-modal"
        }
    };

    $(document).ready(function(){
        var obj_validate_select   = $("#select_form").baigoValidator(opts_validator_select);
        var obj_submit_select     = $("#select_form").baigoSubmit(opts_submit_select);
        $(".bg-submit").click(function(){
            if (obj_validate_select.verify()) {
                obj_submit_select.formSubmit();
            }
        });
        var obj_validate_belong   = $("#belong_form").baigoValidator(opts_validator_belong);
        var obj_submit_belong     = $("#belong_form").baigoSubmit(opts_submit_belong);
        $(".bg-submit-del").click(function(){
            if (obj_validate_belong.verify()) {
                obj_submit_belong.formSubmit();
            }
        });
        $("#belong_form").baigoCheckall();
        $("#select_form").baigoCheckall();
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>

