<?php $cfg = array(
    'title'             => $lang->get('Special topic', 'console.common') . ' &raquo; ' . $specRow['spec_name'] . ' &raquo; ' . $lang->get('Choose article'),
    'menu_active'       => 'spec',
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
            <a href="<?php echo $route_console; ?>spec/" class="nav-link">
                <span class="fas fa-chevron-left"></span>
                <?php echo $lang->get('Back'); ?>
            </a>
        </nav>

        <form name="article_search" id="article_search" class="d-none d-lg-inline-block" action="<?php echo $route_console; ?>spec_belong/index/id/<?php echo $specRow['spec_id']; ?>/">
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
                    <select name="box" class="custom-select">
                        <option value=""><?php echo $lang->get('All status'); ?></option>
                        <?php foreach ($box as $key=>$value) { ?>
                            <option <?php if ($search['box'] == $value) { ?>selected<?php } ?> value="<?php echo $value; ?>">
                                <?php echo $lang->get($value); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </form>
    </div>

    <?php if (!empty($search['key']) || !empty($search['box'])) { ?>
        <div class="mb-3 text-right">
            <?php if (!empty($search['key'])) { ?>
                <span class="badge badge-info">
                    <?php echo $lang->get('Keyword'); ?>:
                    <?php echo $search['key']; ?>
                </span>
            <?php }

            if (!empty($search['box'])) { ?>
                <span class="badge badge-info">
                    <?php echo $lang->get('Status'); ?>:
                    <?php echo $lang->get($search['box']); ?>
                </span>
            <?php } ?>

            <a href="<?php echo $route_console; ?>spec_belong/index/id/<?php echo $search['id']; ?>/" class="badge badge-danger badge-pill">
                <span class="fas fa-times-circle"></span>
                <?php echo $lang->get('Reset'); ?>
            </a>
        </div>
    <?php } ?>

    <div class="card-group">
        <div class="card">
            <form name="article_list_belong" id="article_list_belong" action="<?php echo $route_console; ?>spec_belong/remove/">
                <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
                <input type="hidden" name="spec_id" value="<?php echo $specRow['spec_id']; ?>">

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-nowrap bg-td-xs">
                                    <div class="form-check">
                                        <input type="checkbox" name="chk_all_belong" id="chk_all_belong" data-parent="first" class="form-check-input">
                                        <label for="chk_all_belong" class="form-check-label">
                                            <small><?php echo $lang->get('ID'); ?></small>
                                        </label>
                                    </div>
                                </th>
                                <th><?php echo $lang->get('Articles in topic'); ?></th>
                                <th class="d-none d-lg-table-cell bg-td-md text-right">
                                    <small><?php echo $lang->get('Status'); ?></small>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($articleRowsBelong as $key=>$value) { ?>
                                <tr class="bg-manage-tr">
                                    <td class="text-nowrap bg-td-xs">
                                        <div class="form-check">
                                            <input type="checkbox" name="article_ids_belong[]" value="<?php echo $value['article_id']; ?>" id="article_id_belong_<?php echo $value['article_id']; ?>" data-parent="chk_all_belong" data-validate="article_ids_belong" class="form-check-input article_id_belong">
                                            <label for="article_id_belong_<?php echo $value['article_id']; ?>" class="form-check-label">
                                                <small><?php echo $value['article_id']; ?></small>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <a class="dropdown-toggle float-right d-block d-lg-none" data-toggle="collapse" href="#collapse-belong-<?php echo $value['article_id']; ?>">
                                            <span class="sr-only">Dropdown</span>
                                        </a>
                                        <div class="mb-2 text-wrap text-break">
                                            <?php echo $value['article_title']; ?>
                                        </div>
                                        <div class="bg-manage-menu">
                                            <div class="d-flex flex-wrap">
                                                <a href="<?php echo $route_console; ?>article/show/id/<?php echo $value['article_id']; ?>/" class="mr-2">
                                                    <span class="fas fa-eye"></span>
                                                    <?php echo $lang->get('Show'); ?>
                                                </a>
                                                <a href="javascript:void(0);" data-id="<?php echo $value['article_id']; ?>" class="text-danger article_remove">
                                                    <span class="fas fa-times"></span>
                                                    <?php echo $lang->get('Remove'); ?>
                                                </a>
                                            </div>
                                        </div>
                                        <dl class="row collapse mt-3 mb-0" id="collapse-belong-<?php echo $value['article_id']; ?>">
                                            <dt class="col-3">
                                                <small><?php echo $lang->get('Status'); ?></small>
                                            </dt>
                                            <dd class="col-9">
                                                <?php $articleRow = $value;
                                                include($cfg['pathInclude'] . 'status_article' . GK_EXT_TPL); ?>
                                            </dd>
                                        </dl>
                                    </td>
                                    <td class="d-none d-lg-table-cell bg-td-md text-right">
                                        <?php $articleRow = $value;
                                        include($cfg['pathInclude'] . 'status_article' . GK_EXT_TPL); ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <small class="form-text" id="msg_article_ids_belong"></small>
                    </div>

                    <div class="clearfix">
                        <div class="float-left">
                            <div class="mb-3">
                                <button type="submit" class="btn btn-danger">
                                    <?php echo $lang->get('Remove'); ?>
                                </button>
                            </div>
                        </div>
                        <div class="float-right">
                            <?php $pageRow = $pageRowBelong;
                            $pageParam = $pageParamBelong;
                            include($cfg['pathInclude'] . 'pagination' . GK_EXT_TPL); ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card">
            <form name="article_list" id="article_list" action="<?php echo $route_console; ?>spec_belong/choose/">
                <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
                <input type="hidden" name="spec_id" value="<?php echo $specRow['spec_id']; ?>">

                <div class="table-responsive">
                    <table class="table">
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
                                <th><?php echo $lang->get('Pending articles'); ?></th>
                                <th class="d-none d-lg-table-cell bg-td-md text-right">
                                    <small><?php echo $lang->get('Status'); ?></small>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($articleRows as $key=>$value) { ?>
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
                                            <?php echo $value['article_title']; ?>
                                        </div>
                                        <div class="bg-manage-menu">
                                            <div class="d-flex flex-wrap">
                                                <a href="<?php echo $route_console; ?>article/show/id/<?php echo $value['article_id']; ?>/" class="mr-2">
                                                    <span class="fas fa-eye"></span>
                                                    <?php echo $lang->get('Show'); ?>
                                                </a>
                                                <a href="javascript:void(0);" data-id="<?php echo $value['article_id']; ?>" class="article_choose">
                                                    <span class="fas fa-check"></span>
                                                    <?php echo $lang->get('Choose'); ?>
                                                </a>
                                            </div>
                                        </div>
                                        <dl class="row collapse mt-3 mb-0" id="td-collapse-<?php echo $value['article_id']; ?>">
                                            <dt class="col-3">
                                                <small><?php echo $lang->get('Status'); ?></small>
                                            </dt>
                                            <dd class="col-9">
                                                <?php $articleRow = $value;
                                                include($cfg['pathInclude'] . 'status_article' . GK_EXT_TPL); ?>
                                            </dd>
                                        </dl>
                                    </td>
                                    <td class="d-none d-lg-table-cell bg-td-md text-right">
                                        <?php $articleRow = $value;
                                        include($cfg['pathInclude'] . 'status_article' . GK_EXT_TPL); ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <small class="form-text" id="msg_article_ids"></small>
                    </div>

                    <div class="clearfix">
                        <div class="float-left">
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">
                                    <?php echo $lang->get('Choose'); ?>
                                </button>
                            </div>
                        </div>
                        <div class="float-right">
                            <?php $pageRow = $pageRowSpec;
                            $pageParam = 'page';
                            include($cfg['pathInclude'] . 'pagination' . GK_EXT_TPL); ?>
                        </div>
                    </div>
                </div>
            </form>
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

    var opts_validate_belong = {
        rules: {
            article_ids_belong: {
                checkbox: '1'
            }
        },
        attr_names: {
            article_ids_belong: '<?php echo $lang->get('Article'); ?>'
        },
        type_msg: {
            checkbox: '<?php echo $lang->get('Choose at least one {:attr}'); ?>'
        },
        selector_types: {
            article_ids_belong: 'validate'
        }
    };

    var opts_validate_list = {
        rules: {
            article_ids: {
                checkbox: '1'
            }
        },
        attr_names: {
            article_ids: '<?php echo $lang->get('Article'); ?>'
        },
        type_msg: {
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
        var obj_dialog            = $.baigoDialog(opts_dialog);
        var obj_validate_belong  = $('#article_list_belong').baigoValidate(opts_validate_belong);
        var obj_submit_belong     = $('#article_list_belong').baigoSubmit(opts_submit_list);

        //console.log(obj_submit_belong);

        $('#article_list_belong').submit(function(){
            if (obj_validate_belong.verify()) {
                obj_dialog.confirm('<?php echo $lang->get('Are you sure to remove?'); ?>', function(confirm_result){
                    if (confirm_result) {
                        obj_submit_belong.formSubmit();
                    }
                });
            }
        });


        $('#article_list_belong').baigoCheckall();

        var obj_validate_list  = $('#article_list').baigoValidate(opts_validate_list);
        var obj_submit_list     = $('#article_list').baigoSubmit(opts_submit_list);

        //console.log(obj_submit_list);

        $('#article_list').submit(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });


        $('.article_remove').click(function(){
            var _article_id = $(this).data('id');
            $('.article_id_belong').prop('checked', false);
            $('#article_id_belong_' + _article_id).prop('checked', true);
            $('#article_list_belong').submit();
        });


        $('.article_choose').click(function(){
            var _article_id = $(this).data('id');
            $('.article_id').prop('checked', false);
            $('#article_id_' + _article_id).prop('checked', true);
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