<?php $cfg = array(
    'title'          => $lang->get('Article management', 'console.common') . ' &raquo; ' . $lang->get('Cover management'),
    'menu_active'    => 'article',
    'sub_active'     => 'index',
    'baigoValidate' => 'true',
    'baigoSubmit'    => 'true',
    'tooltip'        => 'true',
    'imageAsync'     => 'true',
    'pathInclude'    => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>article/form/id/<?php echo $articleRow['article_id']; ?>/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <div class="row">
        <div class="col-xl-9">
            <form name="attach_list" id="attach_list" action="<?php echo $route_console; ?>article/cover/">
                <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
                <input type="hidden" name="article_id" value="<?php echo $articleRow['article_id']; ?>">

                <div class="table-responsive">
                    <table class="table table-striped border bg-white">
                        <thead>
                            <tr>
                                <th class="text-nowrap bg-td-xs">
                                    <small><?php echo $lang->get('ID'); ?></small>
                                </th>
                                <th>&nbsp;</th>
                                <th><?php echo $lang->get('Detail'); ?></th>
                                <th class="d-none d-lg-table-cell bg-td-md">
                                    <small>
                                        <?php echo $lang->get('Size'); ?>
                                        /
                                        <?php echo $lang->get('Time'); ?>
                                    </small>
                                </th>
                                <th class="d-none d-lg-table-cell bg-td-md text-right">
                                    <small>
                                        <?php echo $lang->get('Status'); ?>
                                        /
                                        <?php echo $lang->get('Note'); ?>
                                    </small>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($attachRows as $key=>$value) { ?>
                                <tr class="bg-manage-tr<?php if ($articleRow['article_attach_id'] == $value['attach_id']) { ?> table-success<?php } ?>">
                                    <td class="text-nowrap bg-td-xs">
                                        <div class="form-check">
                                            <input type="radio" name="attach_id" value="<?php echo $value['attach_id']; ?>" id="attach_id_<?php echo $value['attach_id']; ?>" class="form-check-input" <?php if ($articleRow['article_attach_id'] == $value['attach_id']) { ?>checked<?php } ?>>
                                            <label for="attach_id_<?php echo $value['attach_id']; ?>" class="form-check-label">
                                                <small><?php echo $value['attach_id']; ?></small>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="bg-td-xs">
                                        <a href="<?php echo $route_console; ?>attach/show/id/<?php echo $value['attach_id']; ?>/">
                                            <img src="{:DIR_STATIC}image/loading.gif" data-src="<?php echo $value['attach_thumb']; ?>" data-toggle="async" alt="<?php echo $value['attach_name']; ?>" class="img-fluid">
                                        </a>
                                    </td>
                                    <td>
                                        <a class="dropdown-toggle float-right d-block d-lg-none" data-toggle="collapse" href="#td-collapse-<?php echo $value['attach_id']; ?>">
                                            <span class="sr-only">Dropdown</span>
                                        </a>
                                        <div class="mb-2 text-wrap text-break">
                                            <?php echo $value['attach_name']; ?>
                                        </div>
                                        <div class="bg-manage-menu">
                                            <div class="d-flex flex-wrap">
                                                <a href="<?php echo $route_console; ?>attach/show/id/<?php echo $value['attach_id']; ?>/" class="mr-2">
                                                    <span class="fas fa-eye"></span>
                                                    <?php echo $lang->get('Show'); ?>
                                                </a>
                                                <?php if ($articleRow['article_attach_id'] == $value['attach_id']) { ?>
                                                    <span class="mr-2">
                                                        <span class="fas fa-image"></span>
                                                        <?php echo $lang->get('Set as cover'); ?>
                                                    </span>
                                                <?php } else { ?>
                                                    <a href="javascript:void(0);" data-id="<?php echo $value['attach_id']; ?>" class="attach_cover">
                                                        <span class="fas fa-image"></span>
                                                        <?php echo $lang->get('Set as cover'); ?>
                                                    </a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <dl class="row collapse mt-3 mb-0" id="td-collapse-<?php echo $value['attach_id']; ?>">
                                            <dt class="col-3">
                                                <small><?php echo $lang->get('Size'); ?></small>
                                            </dt>
                                            <dd class="col-9">
                                                <small><?php echo $value['attach_size_format']; ?></small>
                                            </dd>
                                            <dt class="col-3">
                                                <small><?php echo $lang->get('Time'); ?></small>
                                            </dt>
                                            <dd class="col-9">
                                                <small data-toggle="tooltip" data-placement="bottom" title="<?php echo $value['attach_time_format']['date_time']; ?>"><?php echo $value['attach_time_format']['date_time_short']; ?></small>
                                            </dd>
                                            <dt class="col-3">
                                                <small><?php echo $lang->get('Status'); ?></small>
                                            </dt>
                                            <dd class="col-9">
                                                <?php if ($articleRow['article_attach_id'] == $value['attach_id']) { ?>
                                                    <span class="badge badge-info"><?php echo $lang->get('Cover'); ?></span>
                                                <?php }
                                                $str_status = $value['attach_box'];
                                                include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?>
                                            </dd>
                                            <dt class="col-3">
                                                <small><?php echo $lang->get('Note'); ?></small>
                                            </dt>
                                            <dd class="col-9">
                                                <small><?php echo $value['attach_note']; ?></small>
                                            </dd>
                                        </dl>
                                    </td>
                                    <td class="d-none d-lg-table-cell bg-td-md">
                                        <small>
                                            <div class="mb-2"><?php echo $value['attach_size_format']; ?></div>
                                            <div>
                                                <abbr data-toggle="tooltip" data-placement="bottom" title="<?php echo $value['attach_time_format']['date_time']; ?>"><?php echo $value['attach_time_format']['date_time_short']; ?></abbr>
                                            </div>
                                        </small>
                                    </td>
                                    <td class="d-none d-lg-table-cell bg-td-md text-right">
                                        <div class="mb-2">
                                            <?php if ($articleRow['article_attach_id'] == $value['attach_id']) { ?>
                                                <span class="badge badge-info"><?php echo $lang->get('Cover'); ?></span>
                                            <?php }
                                            $str_status = $value['attach_box'];
                                            include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?>
                                        </div>
                                        <div>
                                            <small><?php echo $value['attach_note']; ?></small>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="mb-3">
                    <small class="form-text" id="msg_attach_id"></small>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary"><?php echo $lang->get('Set as cover'); ?></button>
                    <a href="<?php echo $route_console; ?>attach/index/ids/<?php echo $ids; ?>/" class="btn btn-outline-primary"><?php echo $lang->get('More'); ?></a>
                </div>
            </form>
        </div>
        <div class="col-xl-3">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="form-group">
                        <label><?php echo $lang->get('ID'); ?></label>
                        <div class="form-text"><?php echo $articleRow['article_id']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Title'); ?></label>
                        <div class="form-text">
                            <?php echo $articleRow['article_title']; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Belong to category'); ?></label>
                        <div class="form-text">
                            <?php if (isset($cateRow['cate_name'])) {
                                $str_cateBeadcrumb = '';

                                if (isset($cateRow['cate_breadcrumb'])) {
                                    $_count = 1;
                                    foreach ($cateRow['cate_breadcrumb'] as $key_cate=>$value_cate) {
                                        $str_cateBeadcrumb .= $value_cate['cate_name'];

                                        if ($_count < count($cateRow['cate_breadcrumb'])) {
                                            $str_cateBeadcrumb .= ' &raquo; ';
                                        }

                                        ++$_count;
                                    }
                                } ?>
                                <a href="<?php echo $route_console; ?>cate/show/id/<?php echo $cateRow['cate_id']; ?>/" data-toggle="tooltip" data-placement="bottom" title="<?php echo $str_cateBeadcrumb; ?>" target="_blank">
                                    <?php echo $cateRow['cate_name']; ?>
                                </a>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Status'); ?></label>
                        <div class="form-text"><?php $str_status = $articleRow['article_status'];
                        include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Time'); ?></label>
                        <div class="form-text">
                            <?php echo $articleRow['article_time_show_format']['date_time']; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Mark'); ?></label>
                        <div class="form-text">
                            <?php if (isset($markRow['mark_name'])) {
                                echo $markRow['mark_name'];
                            } else {
                                echo $lang->get('None');
                            } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Cover'); ?></label>
                        <div class="mb-2">
                            <?php if (isset($attachRow['attach_thumb']) && !empty($attachRow['attach_thumb'])) { ?>
                                <img src="<?php echo $attachRow['attach_thumb']; ?>" class="img-fluid">
                            <?php } ?>
                        </div>

                        <div class="form-text"><?php if (isset($attachRow['attach_thumb'])) { echo $attachRow['attach_thumb']; } ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL); ?>

    <script type="text/javascript">
    var opts_validate_list = {
        rules: {
            attach_id: {
                require: true
            }
        },
        attr_names: {
            attach_id: '<?php echo $lang->get('Attachment'); ?>'
        },
        type_msg: {
            require: '<?php echo $lang->get('Choose at least one {:attr}'); ?>'
        }
    };

    var opts_submit_list = {
        modal: {
            btn_text: {
                close: '<?php echo $lang->get('Close'); ?>',
                ok: '<?php echo $lang->get('OK'); ?>'
            }
        },
        msg_text: {
            submitting: '<?php echo $lang->get('Submitting'); ?>'
        }
    };

    $(document).ready(function(){
        var obj_validate_list = $('#attach_list').baigoValidate(opts_validate_list);
        var obj_submit_list   = $('#attach_list').baigoSubmit(opts_submit_list);
        $('#attach_list').submit(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });

        $('.attach_cover').click(function(){
            var _attach_id = $(this).data('id');
            $('#attach_id_' + _attach_id).prop('checked', true);
            $('#attach_list').submit();
        });
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);
