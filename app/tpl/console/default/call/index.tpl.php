<?php $cfg = array(
    'title'             => $lang->get('Call', 'console.common'),
    'menu_active'       => 'call',
    'sub_active'        => 'index',
    'baigoValidate'    => 'true',
    'baigoSubmit'       => 'true',
    'baigoCheckall'     => 'true',
    'baigoQuery'        => 'true',
    'baigoDialog'       => 'true',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <div class="d-flex justify-content-between">
        <nav class="nav mb-3">
            <a href="<?php echo $route_console; ?>call/form/" class="nav-link">
                <span class="fas fa-plus"></span>
                <?php echo $lang->get('Add'); ?>
            </a>
        </nav>
        <form name="call_search" id="call_search" class="d-none d-lg-block" action="<?php echo $route_console; ?>call/index/">
            <div class="input-group mb-3">
                <input type="text" name="key" value="<?php echo $search['key']; ?>" placeholder="<?php echo $lang->get('Keyword'); ?>" class="form-control">
                <span class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">
                        <span class="fas fa-search"></span>
                    </button>
                </span>
                <span class="input-group-append">
                    <button class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" type="button" data-toggle="collapse" data-target="#bg-search-more" >
                        <span class="sr-only">Dropdown</span>
                    </button>
                </span>
            </div>
            <div class="collapse" id="bg-search-more">
                <div class="input-group mb-3">
                    <select name="status" class="custom-select">
                        <option value=""><?php echo $lang->get('All status'); ?></option>
                        <?php foreach ($status as $key=>$value) { ?>
                            <option <?php if ($search['status'] == $value) { ?>selected<?php } ?> value="<?php echo $value; ?>">
                                <?php echo $lang->get($value); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </form>
    </div>

    <?php if (!empty($search['key'])) { ?>
        <div class="mb-3 text-right">
            <?php if (!empty($search['key'])) { ?>
                <span class="badge badge-info">
                    <?php echo $lang->get('Keyword'); ?>:
                    <?php echo $search['key']; ?>
                </span>
            <?php }

            if (!empty($search['status'])) { ?>
                <span class="badge badge-info">
                    <?php echo $lang->get('Status'); ?>:
                    <?php echo $lang->get($search['status']); ?>
                </span>
            <?php } ?>

            <a href="<?php echo $route_console; ?>call/index/" class="badge badge-danger badge-pill">
                <span class="fas fa-times-circle"></span>
                <?php echo $lang->get('Reset'); ?>
            </a>
        </div>
    <?php } ?>

    <div class="card bg-light mb-3">
        <div class="card-body">
            <form name="call_cache" id="call_cache" action="<?php echo $route_console; ?>call/cache/">
                <input type="hidden" name="__token__" value="<?php echo $token; ?>">
                <button type="submit" class="btn btn-primary">
                    <span class="fas fa-redo-alt"></span>
                    <?php echo $lang->get('Refresh cache'); ?>
                </button>
            </form>
        </div>
    </div>

    <form name="call_list" id="call_list" action="<?php echo $route_console; ?>call/delete/">
        <input type="hidden" name="__token__" value="<?php echo $token; ?>">

        <div class="table-responsive">
            <table class="table table-striped border bg-white">
                <thead>
                    <tr>
                        <th class="text-nowrap bg-td-xs">
                            <div class="form-check">
                                <input type="checkbox" name="chk_all" id="chk_all" data-parent="first" class="form-check-input">
                                <label for="chk_all" class="form-check-label">
                                    <small><?php echo $lang->get('ID'); ?></small>
                                </label>
                            </div>
                        </th>
                        <th>
                            <?php echo $lang->get('Call'); ?>
                        </th>
                        <th class="d-none d-lg-table-cell bg-td-md text-right">
                            <small>
                                <?php echo $lang->get('Status'); ?>
                                /
                                <?php echo $lang->get('Type'); ?>
                            </small>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($callRows as $key=>$value) { ?>
                        <tr class="bg-manage-tr">
                            <td class="text-nowrap bg-td-xs">
                                <div class="form-check">
                                    <input type="checkbox" name="call_ids[]" value="<?php echo $value['call_id']; ?>" id="call_id_<?php echo $value['call_id']; ?>" data-parent="chk_all" data-validate="call_ids" class="form-check-input call_id">
                                    <label for="call_id_<?php echo $value['call_id']; ?>" class="form-check-label">
                                        <small><?php echo $value['call_id']; ?></small>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <a class="dropdown-toggle float-right d-block d-lg-none" data-toggle="collapse" href="#td-collapse-<?php echo $value['call_id']; ?>">
                                    <span class="sr-only">Dropdown</span>
                                </a>
                                <div class="mb-2 text-wrap text-break">
                                    <a href="<?php echo $route_console; ?>call/form/id/<?php echo $value['call_id']; ?>/">
                                        <?php echo $value['call_name']; ?>
                                    </a>
                                </div>
                                <div class="bg-manage-menu">
                                    <div class="d-flex flex-wrap">
                                        <a href="<?php echo $route_console; ?>call/show/id/<?php echo $value['call_id']; ?>/" class="mr-2">
                                            <span class="fas fa-eye"></span>
                                            <?php echo $lang->get('Show'); ?>
                                        </a>
                                        <a href="<?php echo $route_console; ?>call/form/id/<?php echo $value['call_id']; ?>/" class="mr-2">
                                            <span class="fas fa-edit"></span>
                                            <?php echo $lang->get('Edit'); ?>
                                        </a>
                                        <?php if ($gen_open === true) { ?>
                                            <a href="#gen_modal" data-url="<?php echo $route_gen; ?>call/single/id/<?php echo $value['call_id']; ?>/view/iframe/" data-toggle="modal" class="mr-2">
                                                <span class="fas fa-sync-alt"></span>
                                                <?php echo $lang->get('Generate'); ?>
                                            </a>
                                        <?php } ?>
                                        <a href="javascript:void(0);" data-id="<?php echo $value['call_id']; ?>" class="call_delete text-danger">
                                            <span class="fas fa-trash-alt"></span>
                                            <?php echo $lang->get('Delete'); ?>
                                        </a>
                                    </div>
                                </div>
                                <dl class="row collapse mt-3 mb-0" id="td-collapse-<?php echo $value['call_id']; ?>">
                                    <dt class="col-3">
                                        <small><?php echo $lang->get('Status'); ?></small>
                                    </dt>
                                    <dd class="col-9">
                                        <?php $str_status = $value['call_status'];
                                        include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?>
                                    </dd>
                                    <dt class="col-3">
                                        <small><?php echo $lang->get('Type'); ?></small>
                                    </dt>
                                    <dd class="col-9">
                                        <small><?php echo $lang->get($value['call_type']); ?></small>
                                    </dd>
                                </dl>
                            </td>
                            <td class="d-none d-lg-table-cell bg-td-md text-right">
                                <div class="mb-2">
                                    <?php $str_status = $value['call_status'];
                                    include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?>
                                </div>
                                <div>
                                    <small><?php echo $lang->get($value['call_type']); ?></small>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="mb-3">
            <small class="form-text" id="msg_call_ids"></small>
        </div>

        <div class="clearfix">
            <div class="float-left">
                <div class="input-group mb-3">
                    <select name="act" id="act" class="custom-select">
                        <option value=""><?php echo $lang->get('Bulk actions'); ?></option>
                        <?php foreach ($status as $key=>$value) { ?>
                            <option value="<?php echo $value; ?>">
                                <?php echo $lang->get($value); ?>
                            </option>
                        <?php } ?>
                        <option value="delete"><?php echo $lang->get('Delete'); ?></option>
                    </select>
                    <span class="input-group-append">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $lang->get('Apply'); ?>
                        </button>
                    </span>
                </div>
                <small id="msg_act" class="form-text"></small>
            </div>
            <div class="float-right">
                <?php include($cfg['pathInclude'] . 'pagination' . GK_EXT_TPL); ?>
            </div>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL); ?>

    <script type="text/javascript">
    var opts_dialog = {
        btn_text: {
            cancel: '<?php echo $lang->get('Cancel'); ?>',
            confirm: '<?php echo $lang->get('Confirm'); ?>'
        }
    };

    var opts_validate_list = {
        rules: {
            call_ids: {
                checkbox: '1'
            },
            act: {
                require: true
            }
        },
        attr_names: {
            call_ids: '<?php echo $lang->get('Call'); ?>',
            act: '<?php echo $lang->get('Action'); ?>'
        },
        type_msg: {
            checkbox: '<?php echo $lang->get('Choose at least one {:attr}'); ?>'
        },
        selector_types: {
            call_ids: 'validate'
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
        var obj_dialog          = $.baigoDialog(opts_dialog);
        var obj_validate_list  = $('#call_list').baigoValidate(opts_validate_list);
        var obj_submit_list     = $('#call_list').baigoSubmit(opts_submit_list);

        $('#call_list').submit(function(){
            var _act = $('#act').val();
            if (obj_validate_list.verify()) {
                switch (_act) {
                    case 'delete':
                        obj_dialog.confirm('<?php echo $lang->get('Are you sure to delete?'); ?>', function(confirm_result){
                            if (confirm_result) {
                                obj_submit_list.formSubmit('<?php echo $route_console; ?>call/delete/');
                            }
                        });
                    break;

                    default:
                        obj_submit_list.formSubmit('<?php echo $route_console; ?>call/status/');
                    break;
                }
            }
        });

        var obj_cache = $('#call_cache').baigoSubmit(opts_submit_list);
        $('#call_cache').submit(function(){
            obj_cache.formSubmit();
        });

        $('.call_delete').click(function(){
            var _call_id = $(this).data('id');
            $('.call_id').prop('checked', false);
            $('#call_id_' + _call_id).prop('checked', true);
            $('#call_list').submit();
        });

        $('#call_list').baigoCheckall();

        var obj_query = $('#call_search').baigoQuery();

        $('#call_search').submit(function(){
            obj_query.formSubmit();
        });
    });
    </script>
<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);