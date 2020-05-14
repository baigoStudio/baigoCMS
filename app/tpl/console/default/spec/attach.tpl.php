<?php $cfg = array(
    'title'          => $lang->get('Special topic', 'console.common') . ' &raquo; ' . $lang->get('Cover management'),
    'menu_active'    => 'spec',
    'sub_active'     => 'index',
    'baigoValidate' => 'true',
    'baigoSubmit'    => 'true',
    'tooltip'        => 'true',
    'imageAsync'     => 'true',
    'pathInclude'    => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>spec/form/id/<?php echo $specRow['spec_id']; ?>/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <div class="row">
        <div class="col-xl-9">
            <form name="attach_list" id="attach_list" action="<?php echo $route_console; ?>spec/cover/">
                <input type="hidden" name="__token__" value="<?php echo $token; ?>">
                <input type="hidden" name="spec_id" value="<?php echo $specRow['spec_id']; ?>">

                <div class="table-responsive">
                    <table class="table table-striped border bg-white">
                        <thead>
                            <tr>
                                <th class="text-nowrap bg-td-xs">
                                    <small><?php echo $lang->get('ID'); ?></small>
                                </th>
                                <th class="d-none d-lg-table-cell bg-td-xs">&nbsp;</th>
                                <th><?php echo $lang->get('Detail'); ?></th>
                                <th class="d-none d-lg-table-cell bg-td-md">
                                    <small><?php echo $lang->get('Size'); ?></small>
                                </th>
                                <th class="d-none d-lg-table-cell bg-td-md text-right">
                                    <small>
                                        <?php echo $lang->get('Status'); ?>
                                        /
                                        <?php echo $lang->get('Time'); ?>
                                    </small>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($attachRows as $key=>$value) { ?>
                                <tr class="bg-manage-tr<?php if ($specRow['spec_attach_id'] == $value['attach_id']) { ?> table-success<?php } ?>">
                                    <td class="text-nowrap bg-td-xs">
                                        <div class="form-check">
                                            <input type="radio" name="attach_id" value="<?php echo $value['attach_id']; ?>" id="attach_id_<?php echo $value['attach_id']; ?>" class="form-check-input" <?php if ($specRow['spec_attach_id'] == $value['attach_id']) { ?>checked<?php } ?>>
                                            <label for="attach_id_<?php echo $value['attach_id']; ?>" class="form-check-label">
                                                <small><?php echo $value['attach_id']; ?></small>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="d-none d-lg-table-cell bg-td-xs">
                                        <a href="<?php echo $route_console; ?>attach/show/id/<?php echo $value['attach_id']; ?>/">
                                            <img src="{:DIR_STATIC}image/loading.gif" data-src="<?php echo $value['thumb_default']; ?>" data-toggle="async" alt="<?php echo $value['attach_name']; ?>" class="img-fluid rounded">
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
                                                <?php if ($specRow['spec_attach_id'] == $value['attach_id']) { ?>
                                                    <span class="mr-2">
                                                        <span class="fas fa-image"></span>
                                                        <?php echo $lang->get('Set as cover'); ?>
                                                    </span>
                                                <?php } else { ?>
                                                    <a href="javascript:void(0);" data-id="<?php echo $value['attach_id']; ?>" class="attach_cover" class="mr-2">
                                                        <span class="fas fa-image"></span>
                                                        <?php echo $lang->get('Set as cover'); ?>
                                                    </a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <dl class="row collapse mt-3 mb-0" id="td-collapse-<?php echo $value['attach_id']; ?>">
                                            <dt class="col-3">
                                                <small>&nbsp;</small>
                                            </dt>
                                            <dd class="col-9">
                                                <a href="<?php echo $route_console; ?>attach/show/id/<?php echo $value['attach_id']; ?>/">
                                                    <img src="{:DIR_STATIC}image/loading.gif" data-src="<?php echo $value['thumb_default']; ?>" data-toggle="async" alt="<?php echo $value['attach_name']; ?>" class="img-fluid rounded" id="img_<?php echo $value['attach_id']; ?>">
                                                </a>
                                            </dd>
                                            <dt class="col-3">
                                                <small><?php echo $lang->get('Size'); ?></small>
                                            </dt>
                                            <dd class="col-9">
                                                <small><?php echo $value['attach_size_format']; ?></small>
                                            </dd>
                                            <dt class="col-3">
                                                <small><?php echo $lang->get('Status'); ?></small>
                                            </dt>
                                            <dd class="col-9">
                                                <?php if ($specRow['spec_attach_id'] == $value['attach_id']) { ?>
                                                    <span class="badge badge-info"><?php echo $lang->get('Cover'); ?></span>
                                                <?php }
                                                $str_status = $value['attach_box'];
                                                include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?>
                                            </dd>
                                            <dt class="col-3">
                                                <small><?php echo $lang->get('Time'); ?></small>
                                            </dt>
                                            <dd class="col-9">
                                                <small data-toggle="tooltip" data-placement="bottom" title="<?php echo $value['attach_time_format']['date_time']; ?>"><?php echo $value['attach_time_format']['date_time_short']; ?></small>
                                            </dd>
                                        </dl>
                                    </td>
                                    <td class="d-none d-lg-table-cell bg-td-md">
                                        <small><?php echo $value['attach_size_format']; ?></small>
                                    </td>
                                    <td class="d-none d-lg-table-cell bg-td-md text-right">
                                        <div>
                                            <?php if ($specRow['spec_attach_id'] == $value['attach_id']) { ?>
                                                <span class="badge badge-info"><?php echo $lang->get('Cover'); ?></span>
                                            <?php }
                                            $str_status = $value['attach_box'];
                                            include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?>
                                        </div>
                                        <div>
                                            <small data-toggle="tooltip" data-placement="bottom" title="<?php echo $value['attach_time_format']['date_time']; ?>"><?php echo $value['attach_time_format']['date_time_short']; ?></small>
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

                <div class="btn-group mb-3">
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
                        <div class="form-text"><?php echo $specRow['spec_id']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Name'); ?></label>
                        <div class="form-text">
                            <?php echo $specRow['spec_name']; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Time'); ?></label>
                        <div class="form-text"><?php echo $specRow['spec_time_format']['date_time']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Updated time'); ?></label>
                        <div class="form-text"><?php echo $specRow['spec_time_update_format']['date_time']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Status'); ?></label>
                        <div class="form-text"><?php $str_status = $specRow['spec_status'];
                        include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?></div>
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