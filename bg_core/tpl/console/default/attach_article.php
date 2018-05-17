<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['article']['main']['title'] . ' &raquo; ' . $this->lang['mod']['page']['attachArticle'],
    'menu_active'    => 'article',
    'sub_active'     => "list",
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    "tooltip"        => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?m=attach&a=article&article_id=" . $this->tplData['articleRow']['article_id'],
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="clearfix mb-3">
        <div class="float-left">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=article&a=form&article_id=<?php echo $this->tplData['articleRow']['article_id']; ?>" class="nav-link">
                        <span class="oi oi-chevron-left"></span>
                        <?php echo $this->lang['common']['href']['back']; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BG_URL_HELP; ?>index.php?m=console&a=attach" class="nav-link" target="_blank">
                        <span class="badge badge-pill badge-primary">
                            <span class="oi oi-question-mark"></span>
                        </span>
                        <?php echo $this->lang['mod']['href']['help']; ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="float-right">
            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=attach&ids=<?php echo $this->tplData['ids']; ?>" class="btn btn-info"><?php echo $this->lang['mod']['href']['attachList']; ?></a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['id']; ?></label>
                        <div class="form-text"><?php echo $this->tplData['articleRow']['article_id']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['title']; ?></label>
                        <div class="form-text">
                            <?php echo $this->tplData['articleRow']['article_title']; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['belongCate']; ?></label>
                        <div class="form-text"><?php echo $this->tplData['cateRow']['cate_name']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['status']; ?></label>
                        <div class="form-text">
                            <?php article_status_process($this->tplData['articleRow'], $this->lang['mod']['status'], $this->lang['mod']); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['time']; ?></label>
                        <div class="form-text">
                            <?php echo date("Y-m-d H:i", $this->tplData['articleRow']['article_time_show']); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['mark']; ?></label>
                        <div class="form-text">
                            <?php if (isset($this->tplData['markRow']['mark_name'])) {
                                echo $this->tplData['markRow']['mark_name'];
                            } else {
                                echo $this->lang['mod']['label']['none'];
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <form name="attach_list" id="attach_list">
                <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
                <input type="hidden" name="article_id" value="<?php echo $this->tplData['articleRow']['article_id']; ?>">

                <div class="table-responsive">
                    <table class="table table-striped table-hover border">
                        <thead>
                            <tr>
                                <th class="text-nowrap bg-td-xs">

                                </th>
                                <th class="text-nowrap bg-td-xs"><?php echo $this->lang['mod']['label']['id']; ?></th>
                                <th class="text-nowrap bg-td-sm"><?php echo $this->lang['mod']['label']['thumb']; ?></th>
                                <th><?php echo $this->lang['mod']['label']['detail']; ?></th>
                                <th class="text-nowrap bg-td-md"><?php echo $this->lang['mod']['label']['status']; ?> / <?php echo $this->lang['mod']['label']['admin']; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($this->tplData['attachRows'] as $key=>$value) {
                                if ($value['attach_box'] == 'normal') {
                                    $css_status = 'success';
                                } else {
                                    $css_status = 'secondary';
                                } ?>
                                <tr>
                                    <td class="text-nowrap bg-td-xs">
                                        <input type="radio" name="attach_id" value="<?php echo $value['attach_id']; ?>" <?php if ($value['attach_id'] == $this->tplData['articleRow']['article_attach_id']) { ?>checked<?php } ?> id="attach_id_<?php echo $value['attach_id']; ?>" data-validate="attach_id">
                                    </td>
                                    <td class="text-nowrap bg-td-xs"><?php echo $value['attach_id']; ?></td>
                                    <td class="text-nowrap bg-td-sm">
                                        <?php if ($value['attach_type'] == 'image') { ?>
                                            <a href="<?php echo $value['attach_url']; ?>" target="_blank"><img src="<?php echo $value['attach_thumb'][0]['thumb_url']; ?>" alt="<?php echo $value['attach_name']; ?>" width="100"></a>
                                        <?php } else { ?>
                                            <a href="<?php echo $value['attach_url']; ?>" target="_blank"><img src="<?php echo BG_URL_STATIC; ?>image/file_<?php echo $value['attach_ext']; ?>.png" alt="<?php echo $value['attach_name']; ?>" width="50"></a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <ul class="list-unstyled">
                                            <li><a href="<?php echo $value['attach_url']; ?>" target="_blank"><?php echo $value['attach_name']; ?></a></li>
                                            <li>
                                                <abbr data-toggle="tooltip" data-placement="bottom" title="<?php echo date(BG_SITE_DATE . ' ' . BG_SITE_TIME, $value['attach_time']); ?>"><?php echo date(BG_SITE_DATE, $value['attach_time']); ?></abbr>
                                            </li>
                                            <?php
                                            $arr_size = attach_size_process($value['attach_size']);
                                            $num_attachSize = $arr_size['size'];
                                            $str_attachUnit = $arr_size['unit'];
                                            ?>
                                            <li>
                                                <?php echo fn_numFormat($num_attachSize, 2), ' ', $str_attachUnit; ?>
                                            </li>
                                            <li>
                                                <?php if ($value['attach_type'] == 'image') { ?>
                                                    <div class="dropdown dropright">
                                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="attach_<?php echo $value['attach_id']; ?>" data-toggle="dropdown">
                                                            <?php echo $this->lang['mod']['btn']['thumb']; ?>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <?php foreach ($value['attach_thumb'] as $key_thumb=>$value_thumb) { ?>
                                                                <a class="dropdown-item" href="<?php echo $value_thumb['thumb_url']; ?>" target="_blank">
                                                                    <?php echo $value_thumb['thumb_width']; ?>
                                                                    x
                                                                    <?php echo $value_thumb['thumb_height'];
                                                                    if (isset($this->lang['mod']['type'][$value_thumb['thumb_type']])) {
                                                                        echo $this->lang['mod']['type'][$value_thumb['thumb_type']];
                                                                    } ?>
                                                                </a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </li>
                                        </ul>
                                    </td>
                                    <td class="text-nowrap bg-td-md">
                                        <ul class="list-unstyled">
                                            <li>
                                                <span class="badge badge-<?php echo $css_status; ?>"><?php echo $this->lang['mod']['box'][$value['attach_box']]; ?></span>
                                            </li>
                                            <li>
                                                <?php if (isset($value['adminRow']['admin_name'])) { ?>
                                                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=attach&admin_id=<?php echo $value['attach_admin_id']; ?>"><?php echo $value['adminRow']['admin_name']; ?></a>
                                                <?php } else {
                                                    echo $this->lang['mod']['label']['unknown'];
                                                } ?>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <small class="form-text" id="msg_attach_id"></small>
                    <div class="bg-submit-box bg-submit-box-list"></div>
                </div>

                <div class="clearfix mt-3">
                    <div class="float-left">
                        <input type="hidden" name="a" value="primary">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['setPrimary']; ?></button>
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
    var opts_validator_list = {
        attach_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='attach_id']", type: "radio" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x120214']; ?>" }
        }
    };

    var opts_submit_list = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=article&c=request",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    $(document).ready(function(){
        var obj_validate_list = $("#attach_list").baigoValidator(opts_validator_list);
        var obj_submit_list   = $("#attach_list").baigoSubmit(opts_submit_list);
        $(".bg-submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php');