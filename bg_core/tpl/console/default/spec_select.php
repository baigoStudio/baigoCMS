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
    'str_url'        => BG_URL_CONSOLE . "index.php?m=spec&a=select&spec_id=" . $this->tplData['specRow']['spec_id'] . '&' . $this->tplData['query'],
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=spec&a=list" class="nav-link">
                <span class="oi oi-chevron-left"></span>
                <?php echo $this->lang['common']['href']['back']; ?>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=spec&a=form&spec_id=<?php echo $this->tplData['specRow']['spec_id']; ?>" class="nav-link">
                <span class="oi oi-pencil"></span>
                <?php echo $this->lang['mod']['href']['edit']; ?>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo BG_URL_HELP; ?>index.php?m=console&a=spec#select" class="nav-link" target="_blank">
                <span class="badge badge-pill badge-primary">
                    <span class="oi oi-question-mark"></span>
                </span>
                <?php echo $this->lang['mod']['href']['help']; ?>
            </a>
        </li>
        <li class="nav-item">
            <button type="button" class="btn btn-warning"><?php echo $this->lang['mod']['label']['specName']; ?> <strong><?php echo $this->tplData['specRow']['spec_name']; ?></strong></button>
        </li>
    </ul>

    <div class="row">
        <div class="col-md-6">
            <div class="card bg-light mb-3">
                <div class="card-body">
                    <label><?php echo $this->lang['mod']['label']['belongArticle']; ?></label>
                    <form name="belong_search" id="belong_search" action="<?php echo BG_URL_CONSOLE; ?>index.php" method="get">
                        <input type="hidden" name="m" value="spec">
                        <input type="hidden" name="a" value="select">
                        <input type="hidden" name="spec_id" value="<?php echo $this->tplData['specRow']['spec_id']; ?>">
                        <div class="input-group">
                            <input type="text" name="key_belong" class="form-control" value="<?php echo $this->tplData['searchBelong']['key']; ?>" placeholder="<?php echo $this->lang['mod']['label']['key']; ?>">
                            <span class="input-group-append">
                                <button class="btn btn-secondary" type="submit">
                                    <span class="oi oi-magnifying-glass"></span>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>

            <form name="belong_form" id="belong_form">
                <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">

                <div class="table-responsive">
                    <table class="table table-striped table-hover border">
                        <thead>
                            <tr>
                                <th class="text-nowrap bg-td-xs">
                                    <div class="form-check">
                                        <label for="belong_all" class="form-check-label">
                                            <input type="checkbox" name="belong_all" id="belong_all" data-parent="first" class="form-check-input">
                                            <?php echo $this->lang['mod']['label']['all']; ?>
                                        </label>
                                    </div>
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
                                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=article&a=show&article_id=<?php echo $value['article_id']; ?>">
                                            <?php if (fn_isEmpty($value['article_title'])) {
                                                echo $this->lang['mod']['label']['noname'];
                                            } else {
                                                echo $value['article_title'];
                                            } ?>
                                        </a>
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
                    </table>
                </div>

                <div class="mt-3">
                    <small class="form-text" id="msg_belong_id"></small>
                    <div class="bg-submit-box bg-submit-box-del"></div>
                </div>

                <div class="mt-3">
                    <input type="hidden" name="a" value="belongDel">
                    <button type="button" class="btn btn-primary bg-submit-del"><?php echo $this->lang['mod']['btn']['belongDel']; ?></button>
                </div>
            </form>
        </div>

        <div class="col-md-6">
            <div class="card bg-light mb-3">
                <div class="card-body">
                    <label><?php echo $this->lang['mod']['label']['selectArticle']; ?></label>
                    <form name="select_search" id="select_search" action="<?php echo BG_URL_CONSOLE; ?>index.php" method="get">
                        <input type="hidden" name="m" value="spec">
                        <input type="hidden" name="a" value="select">
                        <input type="hidden" name="spec_id" value="<?php echo $this->tplData['specRow']['spec_id']; ?>">
                        <div class="input-group">
                            <select name="cate_id" class="custom-select">
                                <option value=""><?php echo $this->lang['mod']['option']['allCate']; ?></option>
                                <?php cate_list_opt($this->tplData['cateRows'], $this->tplData['search']['cate_id']); ?>
                                <option <?php if ($this->tplData['search']['cate_id'] == -1) { ?>selected<?php } ?> value="-1"><?php echo $this->lang['mod']['option']['unknown']; ?></option>
                            </select>
                            <select name="status" class="custom-select">
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

            <form name="select_form" id="select_form">
                <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
                <input type="hidden" name="spec_id" value="<?php echo $this->tplData['specRow']['spec_id']; ?>">

                <div class="table-responsive">
                    <table class="table table-striped table-hover border">
                        <thead>
                            <tr>
                                <th class="text-nowrap bg-td-xs">
                                    <div class="form-check">
                                        <label for="select_all" class="form-check-label">
                                            <input type="checkbox" name="select_all" id="select_all" data-parent="first" class="form-check-input">
                                            <?php echo $this->lang['mod']['label']['all']; ?>
                                        </label>
                                    </div>
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
                                                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=article&a=show&article_id=<?php echo $value['article_id']; ?>">
                                                    <?php if (fn_isEmpty($value['article_title'])) {
                                                        echo $this->lang['mod']['label']['noname'];
                                                    } else {
                                                        echo $value['article_title'];
                                                    } ?>
                                                </a>
                                            </li>
                                            <li>
                                                <?php if (isset($value['specRow']['spec_name'])) { ?>
                                                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=spec&a=select&spec_id=<?php echo $value['specRow']['spec_id']; ?>"><?php echo $value['specRow']['spec_name']; ?></a>
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
                    </table>
                </div>

                <div class="mt-3">
                    <small class="form-text" id="msg_select_id"></small>
                    <div class="bg-submit-box bg-submit-box-list"></div>
                </div>

                <div class="clearfix mt-3">
                    <div class="float-left">
                        <input type="hidden" name="a" value="belongAdd">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['belongAdd']; ?></button>
                    </div>
                    <div class="float-right">
                        <?php include($cfg['pathInclude'] . 'page.php'); ?>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_select = {
        select_ids: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='select_ids']", type: "checkbox" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x030202']; ?>" }
        }
    };

    var opts_validator_belong = {
        belong_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='belong_id']", type: "checkbox" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x030202']; ?>" }
        }
    };

    var opts_submit_select = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=spec&c=request",
        box: {
            selector: ".bg-submit-box-list"
        },
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    var opts_submit_belong = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=spec&c=request",
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

<?php include('include' . DS . 'html_foot.php');