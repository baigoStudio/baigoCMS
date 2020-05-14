<?php $cfg = array(
    'title'             => $lang->get('Article management', 'console.common'),
    'menu_active'       => 'article',
    'sub_active'        => 'index',
    'baigoValidate'     => 'true',
    'baigoSubmit'       => 'true',
    'baigoCheckall'     => 'true',
    'baigoQuery'        => 'true',
    'baigoDialog'       => 'true',
    'tooltip'           => 'true',
    'datetimepicker'    => 'true',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <div class="d-flex justify-content-between">
        <nav class="nav mb-3">
            <a href="<?php echo $route_console; ?>article/form/" class="nav-link">
                <span class="fas fa-plus"></span>
                <?php echo $lang->get('Add'); ?>
            </a>
            <a href="<?php echo $route_console; ?>article/" class="nav-link d-none d-lg-block<?php if ($search['box'] == 'normal') { ?> disabled<?php } ?>">
                <?php echo $lang->get('All'); ?>
                <span class="badge badge-pill badge-<?php if ($search['box'] == 'normal') { ?>secondary<?php } else { ?>primary<?php } ?>"><?php echo $articleCount['all']; ?></span>
            </a>
            <a href="<?php echo $route_console; ?>article/index/box/draft/" class="nav-link d-none d-lg-block<?php if ($search['box'] == 'draft') { ?> disabled<?php } ?>">
                <?php echo $lang->get('Draft'); ?>
                <span class="badge badge-pill badge-<?php if ($search['box'] == 'draft') { ?>secondary<?php } else { ?>primary<?php } ?>"><?php echo $articleCount['draft']; ?></span>
            </a>
            <?php if ($articleCount['recycle'] > 0) { ?>
                <a href="<?php echo $route_console; ?>article/index/box/recycle/" class="nav-link d-none d-lg-block<?php if ($search['box'] == 'recycle') { ?> disabled<?php } ?>">
                    <?php echo $lang->get('Recycle'); ?>
                    <span class="badge badge-pill badge-<?php if ($search['box'] == 'recycle') { ?>secondary<?php } else { ?>primary<?php } ?>"><?php echo $articleCount['recycle']; ?></span>
                </a>
            <?php } ?>
        </nav>
        <form name="article_search" id="article_search" class="d-none d-lg-inline-block" action="<?php echo $route_console; ?>article/index/">
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
                    <select name="cate" class="custom-select">
                        <option value=""><?php echo $lang->get('All categories'); ?></option>
                        <?php $check_id = $search['cate'];
                        include($cfg['pathInclude'] . 'cate_list_option' . GK_EXT_TPL); ?>
                        <option<?php if ($search['cate'] == -1) { ?> selected<?php } ?> value="-1">
                            <?php echo $lang->get('Not belong'); ?>
                        </option>
                    </select>
                    <select name="year" class="custom-select">
                        <option value=""><?php echo $lang->get('All years'); ?></option>
                        <?php foreach ($articleYear as $key=>$value) { ?>
                            <option<?php if ($search['year'] == $value['article_year']) { ?> selected<?php } ?> value="<?php echo $value['article_year']; ?>"><?php echo $value['article_year']; ?></option>
                        <?php } ?>
                    </select>
                    <select name="month" class="custom-select">
                        <option value=""><?php echo $lang->get('All months'); ?></option>
                        <?php for ($iii = 1 ; $iii <= 12; ++$iii) {
                            if ($iii < 10) {
                                $str_month = '0' . $iii;
                            } else {
                                $str_month = $iii;
                            } ?>
                            <option<?php if ($search['month'] == $str_month) { ?> selected<?php } ?> value="<?php echo $str_month; ?>"><?php echo $str_month; ?></option>
                        <?php } ?>
                    </select>
                    <select name="mark" class="custom-select">
                        <option value=""><?php echo $lang->get('All marks'); ?></option>
                        <?php foreach ($markRows as $key=>$value) { ?>
                            <option<?php if ($search['mark'] == $value['mark_id']) { ?> selected<?php } ?> value="<?php echo $value['mark_id']; ?>"><?php echo $value['mark_name']; ?></option>
                        <?php } ?>
                    </select>
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

    <?php if (!empty($search['key']) || !empty($search['cate']) || isset($cateRow['cate_name']) || !empty($search['year']) || !empty($search['month']) || isset($markRow['mark_name']) || !empty($search['status'])) { ?>
        <div class="mb-3 text-right">
            <?php if (!empty($search['key'])) { ?>
                <span class="badge badge-info">
                    <?php echo $lang->get('Keyword'); ?>:
                    <?php echo $search['key']; ?>
                </span>
            <?php }

            if (!empty($search['cate']) || isset($cateRow['cate_name'])) { ?>
                <span class="badge badge-info">
                    <?php echo $lang->get('Category'); ?>:
                    <?php if (isset($cateRow['cate_name'])) {
                        echo $cateRow['cate_name'];
                    } else if ($search['cate'] < 0) {
                        echo $lang->get('Not belong');
                    } ?>
                </span>
            <?php }

            if (!empty($search['year'])) { ?>
                <span class="badge badge-info">
                    <?php echo $lang->get('Year'); ?>:
                    <?php echo $search['year']; ?>
                </span>
            <?php }

            if (!empty($search['month'])) { ?>
                <span class="badge badge-info">
                    <?php echo $lang->get('Month'); ?>:
                    <?php echo $search['month']; ?>
                </span>
            <?php }

            if (isset($markRow['mark_name'])) { ?>
                <span class="badge badge-info">
                    <?php echo $lang->get('Mark'); ?>:
                    <?php echo $markRow['mark_name']; ?>
                </span>
            <?php }

            if (!empty($search['status'])) { ?>
                <span class="badge badge-info">
                    <?php echo $lang->get('Status'); ?>:
                    <?php echo $lang->get($search['status']); ?>
                </span>
            <?php } ?>

            <a href="<?php echo $route_console; ?>article/index/" class="badge badge-danger badge-pill">
                <span class="fas fa-times-circle"></span>
                <?php echo $lang->get('Reset'); ?>
            </a>
        </div>
    <?php } ?>


    <?php if ($search['box'] == 'recycle') { ?>
        <div class="card bg-light mb-3">
            <div class="card-body">
                <div class="alert alert-danger">
                    <span class="fas fa-exclamation-triangle"></span>
                    <?php echo $lang->get('Warning! This operation is not recoverable!'); ?>
                </div>

                <form name="article_empty" id="article_empty" action="<?php echo $route_console; ?>article/empty-recycle/">
                    <input type="hidden" name="__token__" value="<?php echo $token; ?>">
                    <button type="submit" class="btn btn-danger">
                        <span class="fas fa-trash-alt"></span>
                        <?php echo $lang->get('Empty'); ?>
                    </button>
                </form>
            </div>
        </div>
    <?php } ?>

    <form name="article_list" id="article_list" action="<?php echo $route_console; ?>article/status/">
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
                        <th><?php echo $lang->get('Article'); ?></th>
                        <th class="d-none d-lg-table-cell bg-td-md">
                            <small><?php echo $lang->get('Category'); ?></small>
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
                    <?php foreach ($articleRows as $key=>$value) {
                        $str_cateBeadcrumb = '';

                        if (isset($value['cateRow']['cate_breadcrumb'])) {
                            $_count = 1;
                            foreach ($value['cateRow']['cate_breadcrumb'] as $key_cate=>$value_cate) {
                                $str_cateBeadcrumb .= $value_cate['cate_name'];

                                if ($_count < count($value['cateRow']['cate_breadcrumb'])) {
                                    $str_cateBeadcrumb .= ' &raquo; ';
                                }

                                ++$_count;
                            }
                        } ?>
                        <tr class="bg-manage-tr">
                            <td class="text-nowrap bg-td-xs">
                                <div class="form-check">
                                    <input type="checkbox" name="article_ids[]" value="<?php echo $value['article_id']; ?>" id="article_id_<?php echo $value['article_id']; ?>" data-parent="chk_all" data-validate="article_ids" class="form-check-input article_id">
                                    <label for="article_id_<?php echo $value['article_id']; ?>" class="form-check-label">
                                        <small><?php echo $value['article_id']; ?></small>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <a class="dropdown-toggle float-right d-block d-lg-none" data-toggle="collapse" href="#td-collapse-<?php echo $value['article_id']; ?>">
                                    <span class="sr-only">Dropdown</span>
                                </a>
                                <div class="mb-2 text-wrap text-break">
                                    <a href="<?php echo $route_console; ?>article/form/id/<?php echo $value['article_id']; ?>/">
                                        <?php echo $value['article_title']; ?>
                                    </a>
                                </div>
                                <div class="bg-manage-menu">
                                    <div class="d-flex flex-wrap">
                                        <a href="<?php echo $route_console; ?>article/show/id/<?php echo $value['article_id']; ?>/" class="mr-2">
                                            <span class="fas fa-eye"></span>
                                            <?php echo $lang->get('Show'); ?>
                                        </a>
                                        <?php if ($search['box'] == 'recycle') { ?>
                                            <a href="javascript:void(0);" data-id="<?php echo $value['article_id']; ?>" class="article_restore mr-2">
                                                <span class="fas fa-redo-alt"></span>
                                                <?php echo $lang->get('Restore'); ?>
                                            </a>
                                            <a href="javascript:void(0);" data-id="<?php echo $value['article_id']; ?>" class="article_delete text-danger mr-2">
                                                <span class="fas fa-trash-alt"></span>
                                                <?php echo $lang->get('Delete'); ?>
                                            </a>
                                        <?php } else { ?>
                                            <a href="<?php echo $route_console; ?>article/form/id/<?php echo $value['article_id']; ?>/" class="mr-2">
                                                <span class="fas fa-edit"></span>
                                                <?php echo $lang->get('Edit'); ?>
                                            </a>
                                            <a data-toggle="modal" href="#article_modal" data-id="<?php echo $value['article_id']; ?>" class="mr-2">
                                                <span class="fas fa-pen-square"></span>
                                                <?php echo $lang->get('Quick edit'); ?>
                                            </a>
                                            <?php if ($gen_open === true) { ?>
                                                <a href="#gen_modal" data-url="<?php echo $route_gen; ?>article/single/id/<?php echo $value['article_id']; ?>/view/iframe/" data-toggle="modal" class="mr-2">
                                                    <span class="fas fa-sync-alt"></span>
                                                    <?php echo $lang->get('Generate'); ?>
                                                </a>
                                            <?php } ?>
                                            <a href="javascript:void(0);" data-id="<?php echo $value['article_id']; ?>" class="article_recycle text-danger">
                                                <span class="fas fa-trash-alt"></span>
                                                <?php echo $lang->get('Recycle'); ?>
                                            </a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <dl class="row collapse mt-3 mb-0" id="td-collapse-<?php echo $value['article_id']; ?>">
                                    <dt class="col-3">
                                        <small><?php echo $lang->get('Category'); ?></small>
                                    </dt>
                                    <dd class="col-9">
                                        <?php if (isset($value['cateRow']['cate_name'])) { ?>
                                            <small data-toggle="tooltip" data-placement="bottom" title="<?php echo $str_cateBeadcrumb; ?>">
                                                <?php echo $value['cateRow']['cate_name']; ?>
                                            </small>
                                        <?php } ?>
                                    </dd>
                                    <dt class="col-3">
                                        <small><?php echo $lang->get('Status'); ?></small>
                                    </dt>
                                    <dd class="col-9">
                                        <?php $articleRow = $value;
                                        include($cfg['pathInclude'] . 'status_article' . GK_EXT_TPL); ?>
                                    </dd>
                                    <dt class="col-3">
                                        <small><?php echo $lang->get('Time'); ?></small>
                                    </dt>
                                    <dd class="col-9">
                                        <small data-toggle="tooltip" data-placement="bottom" title="<?php echo $value['article_time_pub_format']['date_time']; ?>"><?php echo $value['article_time_pub_format']['date_time_short']; ?></small>
                                    </dd>
                                </dl>
                            </td>
                            <td class="d-none d-lg-table-cell bg-td-md">
                                <?php if (isset($value['cateRow']['cate_name'])) { ?>
                                    <small data-toggle="tooltip" data-placement="bottom" title="<?php echo $str_cateBeadcrumb; ?>">
                                        <?php echo $value['cateRow']['cate_name']; ?>
                                    </small>
                                <?php } ?>
                            </td>
                            <td class="d-none d-lg-table-cell bg-td-md text-right">
                                <div class="mb-2">
                                    <?php $articleRow = $value;
                                    include($cfg['pathInclude'] . 'status_article' . GK_EXT_TPL); ?>
                                </div>
                                <div>
                                    <small data-toggle="tooltip" data-placement="bottom" title="<?php echo $value['article_time_pub_format']['date_time']; ?>"><?php echo $value['article_time_pub_format']['date_time_short']; ?></small>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="mb-3">
            <small class="form-text" id="msg_article_ids"></small>
        </div>

        <div class="clearfix">
            <div class="float-left">
                <div class="input-group mb-3">
                    <select name="act" id="act" class="custom-select">
                        <option value=""><?php echo $lang->get('Bulk actions'); ?></option>
                        <?php switch ($search['box']) {
                            case 'recycle': ?>
                                <option value="normal"><?php echo $lang->get('Restore'); ?></option>
                                <option value="delete"><?php echo $lang->get('Delete'); ?></option>
                            <?php break;

                            case 'draft': ?>
                                <option value="normal"><?php echo $lang->get('Restore'); ?></option>
                                <option value="recycle"><?php echo $lang->get('Move to recycle'); ?></option>
                            <?php break;

                            default:
                                foreach ($status as $key=>$value) { ?>
                                    <option value="<?php echo $value; ?>">
                                        <?php echo $lang->get($value); ?>
                                    </option>
                                <?php } ?>
                                <option value="draft"><?php echo $lang->get('Draft'); ?></option>
                                <option value="move"><?php echo $lang->get('Move'); ?></option>
                                <option value="recycle"><?php echo $lang->get('Move to recycle'); ?></option>
                            <?php break;
                        } ?>
                    </select>
                    <select id="cate_id" name="cate_id" class="custom-select">
                        <option value="">
                            <?php echo $lang->get('Please select'); ?>
                        </option>
                        <?php cate_list_option($cateRows); ?>
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

    <div class="modal fade" id="article_modal">
        <div class="modal-dialog">
            <div class="modal-content"></div>
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
            article_ids: {
                checkbox: '1'
            },
            act: {
                require: true
            }
        },
        attr_names: {
            article_ids: '<?php echo $lang->get('Article'); ?>',
            act: '<?php echo $lang->get('Action'); ?>'
        },
        type_msg: {
            require: '<?php echo $lang->get('Choose at least one {:attr}'); ?>',
            checkbox: '<?php echo $lang->get('Choose at least one {:attr}'); ?>'
        },
        selector_types: {
            article_ids: 'validate'
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
        $('#cate_id').hide();
        $('#article_modal').on('shown.bs.modal',function(event) {
    		var _obj_button   = $(event.relatedTarget);
    		var _id           = _obj_button.data('id');
            $('#article_modal .modal-content').load('<?php echo $route_console; ?>article/simple/id/' + _id + '/view/modal/');
    	}).on('hidden.bs.modal', function(){
        	$('#article_modal .modal-content').empty();
    	});

        var obj_dialog          = $.baigoDialog(opts_dialog);
        var obj_validate_list   = $('#article_list').baigoValidate(opts_validate_list);
        var obj_submit_list     = $('#article_list').baigoSubmit(opts_submit_list);

        //console.log(obj_submit_list);

        $('#article_list').submit(function(){
            var _act = $('#act').val();
            if (obj_validate_list.verify()) {
                switch (_act) {
                    case 'delete':
                        obj_dialog.confirm('<?php echo $lang->get('Are you sure to delete?'); ?>', function(confirm_result){
                            if (confirm_result) {
                                obj_submit_list.formSubmit('<?php echo $route_console; ?>article/delete/');
                            }
                        });
                    break;

                    case 'recycle':
                        obj_dialog.confirm('<?php echo $lang->get('Are you sure move to recycle?'); ?>', function(confirm_result){
                            if (confirm_result) {
                                obj_submit_list.formSubmit('<?php echo $route_console; ?>article/box/');
                            }
                        });
                    break;

                    case 'normal':
                    case 'draft':
                        obj_submit_list.formSubmit('<?php echo $route_console; ?>article/box/');
                    break;

                    case 'move':
                        obj_submit_list.formSubmit('<?php echo $route_console; ?>article/move/');
                    break;

                    default:
                        obj_submit_list.formSubmit('<?php echo $route_console; ?>article/status/');
                    break;
                }
            }
        });


        var obj_submit_empty     = $('#article_empty').baigoSubmit(opts_submit_list);

        $('#article_empty').submit(function(){
            obj_dialog.confirm('<?php echo $lang->get('Warning! This operation is not recoverable!'); ?>', function(confirm_result){
                if (confirm_result) {
                    obj_submit_empty.formSubmit();
                }
            });
        });


        $('#act').change(function(){
            var _act = $(this).val();
            if (_act == 'move') {
                $('#cate_id').show();
            } else {
                $('#cate_id').hide();
            }
        });

        $('.article_delete').click(function(){
            var _article_id = $(this).data('id');
            $('.article_id').prop('checked', false);
            $('#article_id_' + _article_id).prop('checked', true);
            $('#act').val('delete');
            $('#article_list').submit();
        });

        $('.article_restore').click(function(){
            var _article_id = $(this).data('id');
            $('.article_id').prop('checked', false);
            $('#article_id_' + _article_id).prop('checked', true);
            $('#act').val('normal');
            $('#article_list').submit();
        });

        $('.article_recycle').click(function(){
            var _article_id = $(this).data('id');
            $('.article_id').prop('checked', false);
            $('#article_id_' + _article_id).prop('checked', true);
            $('#act').val('recycle');
            $('#article_list').submit();
        });

        $('#article_list').baigoCheckall();

        var obj_query = $('#article_search').baigoQuery();

        $('#article_search').submit(function(){
            obj_query.formSubmit();
        });
    });
    </script>
<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);