<?php $cfg = array(
    'title'             => $lang->get('Article management', 'console.common') . ' &raquo; ' . $lang->get('Tag', 'console.common'),
    'menu_active'       => 'article',
    'sub_active'        => 'tag',
    'baigoValidate'     => 'true',
    'baigoSubmit'       => 'true',
    'baigoCheckall'     => 'true',
    'baigoQuery'        => 'true',
    'baigoDialog'       => 'true',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <div class="d-flex justify-content-between">
        <nav class="nav mb-3">
            <a href="#tag_modal" data-toggle="modal" data-id="0" class="nav-link">
                <span class="fas fa-plus"></span>
                <?php echo $lang->get('Add'); ?>
            </a>
        </nav>
        <form name="tag_search" id="tag_search" class="d-none d-lg-block" action="<?php echo $route_console; ?>tag/index/">
            <div class="input-group mb-3">
                <input type="text" name="key" value="<?php echo $search['key']; ?>" placeholder="<?php echo $lang->get('Keyword'); ?>" class="form-control">
                <span class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">
                        <span class="fas fa-search"></span>
                    </button>
                </span>
                <span class="input-group-append">
                    <button class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" type="button" data-toggle="collapse" data-target="#bg-search-more">
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

    <?php if (!empty($search['key']) || !empty($search['status']) || !empty($search['type'])) { ?>
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

            <a href="<?php echo $route_console; ?>tag/index/" class="badge badge-danger badge-pill">
                <span class="fas fa-times-circle"></span>
                <?php echo $lang->get('Reset'); ?>
            </a>
        </div>
    <?php } ?>


    <form name="tag_list" id="tag_list" action="<?php echo $route_console; ?>tag/status/">
        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">

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
                            <?php echo $lang->get('Tag'); ?>
                        </th>
                        <th class="d-none d-lg-table-cell bg-td-md text-right">
                            <small><?php echo $lang->get('Status'); ?></small>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tagRows as $key=>$value) { ?>
                        <tr class="bg-manage-tr">
                            <td class="text-nowrap bg-td-xs">
                                <div class="form-check">
                                    <input type="checkbox" name="tag_ids[]" value="<?php echo $value['tag_id']; ?>" id="tag_id_<?php echo $value['tag_id']; ?>" data-parent="chk_all" data-validate="tag_ids" class="form-check-input tag_id">
                                    <label for="tag_id_<?php echo $value['tag_id']; ?>" class="form-check-label">
                                        <small><?php echo $value['tag_id']; ?></small>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <a class="dropdown-toggle float-right d-block d-lg-none" data-toggle="collapse" href="#td-collapse-<?php echo $value['tag_id']; ?>">
                                    <span class="sr-only">Dropdown</span>
                                </a>
                                <div class="mb-2 text-wrap text-break">
                                    <a href="#tag_modal" data-toggle="modal" data-id="<?php echo $value['tag_id']; ?>">
                                        <?php echo $value['tag_name']; ?>
                                    </a>
                                </div>
                                <div class="bg-manage-menu">
                                    <div class="d-flex flex-wrap">
                                        <a href="#tag_modal" data-toggle="modal" data-id="<?php echo $value['tag_id']; ?>" class="mr-2">
                                            <span class="fas fa-edit"></span>
                                            <?php echo $lang->get('Edit'); ?>
                                        </a>
                                        <a href="javascript:void(0);" data-id="<?php echo $value['tag_id']; ?>" class="tag_delete text-danger">
                                            <span class="fas fa-trash-alt"></span>
                                            <?php echo $lang->get('Delete'); ?>
                                        </a>
                                    </div>
                                </div>
                                <dl class="row collapse mt-3 mb-0" id="td-collapse-<?php echo $value['tag_id']; ?>">
                                    <dt class="col-3">
                                        <small><?php echo $lang->get('Status'); ?></small>
                                    </dt>
                                    <dd class="col-9">
                                        <?php $str_status = $value['tag_status'];
                                        include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?>
                                    </dd>
                                </dl>
                            </td>
                            <td class="d-none d-lg-table-cell bg-td-md text-right">
                                <?php $str_status = $value['tag_status'];
                                include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="mb-3">
            <small class="form-text" id="msg_tag_ids"></small>
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

    <div class="modal fade" id="tag_modal">
        <div class="modal-dialog">
            <div class="modal-content">

            </div>
        </div>
    </div>

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
            tag_ids: {
                checkbox: '1'
            }
        },
        attr_names: {
            tag_ids: '<?php echo $lang->get('Tag'); ?>'
        },
        type_msg: {
            checkbox: '<?php echo $lang->get('Choose at least one {:attr}'); ?>'
        },
        selector_types: {
            tag_ids: 'validate'
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
        $('#tag_modal').on('shown.bs.modal',function(event){
    		var _obj_button   = $(event.relatedTarget);
    		var _id           = _obj_button.data('id');
            $('#tag_modal .modal-content').load('<?php echo $route_console; ?>tag/form/id/' + _id + '/view/modal/');
    	}).on('hidden.bs.modal', function(){
        	$('#tag_modal .modal-content').empty();
    	});

        var obj_dialog          = $.baigoDialog(opts_dialog);
        var obj_validate_list   = $('#tag_list').baigoValidate(opts_validate_list);
        var obj_submit_list     = $('#tag_list').baigoSubmit(opts_submit_list);

        $('#tag_list').submit(function(){
            var _act = $('#act').val();
            if (obj_validate_list.verify()) {
                switch (_act) {
                    case 'delete':
                        obj_dialog.confirm('<?php echo $lang->get('Are you sure to delete?'); ?>', function(confirm_result){
                            if (confirm_result) {
                                obj_submit_list.formSubmit('<?php echo $route_console; ?>tag/delete/');
                            }
                        });
                    break;

                    default:
                        obj_submit_list.formSubmit('<?php echo $route_console; ?>tag/status/');
                    break;
                }
            }
        });

        $('.tag_delete').click(function(){
            var _tag_id = $(this).data('id');
            $('.tag_id').prop('checked', false);
            $('#tag_id_' + _tag_id).prop('checked', true);
            $('#act').val('delete');
            $('#tag_list').submit();
        });

        $('#tag_list').baigoCheckall();

        var obj_query = $('#tag_search').baigoQuery();

        $('#tag_search').submit(function(){
            obj_query.formSubmit();
        });
    });
    </script>
<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);