<?php $cfg = array(
    'title'             => $lang->get('Gathering', 'console.common') . ' &raquo; ' . $lang->get('Show'),
    'menu_active'       => 'gather',
    'sub_active'        => 'approve',
    'tooltip'           => 'true',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>gather/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <div class="row">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <h3><?php echo $gatherRow['gather_title']; ?></h3>
                    </div>

                    <div class="form-group">
                        <div class="text-wrap text-break bg-content"><?php echo $gatherRow['gather_content']; ?></div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between">
                    <div class="btn-group mr-3">
                        <button type="button" class="btn btn-primary" data-target="#store_modal" data-toggle="modal" data-id="<?php echo $gatherRow['gather_id']; ?>"><?php echo $lang->get('Store'); ?></button>
                        <button type="button" class="btn btn-outline-primary" data-target="#store_modal" data-toggle="modal" data-id="<?php echo $gatherRow['gather_id']; ?>" data-enforce="enforce"><?php echo $lang->get('Store enforce'); ?></button>
                    </div>

                    <a href="<?php echo $route_console; ?>article/form/gather/<?php echo $gatherRow['gather_id']; ?>/">
                        <span class="fas fa-edit"></span>
                        <?php echo $lang->get('Edit and store'); ?>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="form-group">
                        <label><?php echo $lang->get('ID'); ?></label>
                        <div class="form-text"><?php echo $gatherRow['gather_id']; ?></div>
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
                        <div class="form-text"><?php $str_status = $gatherRow['gather_status'];
                        include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Article ID'); ?></label>
                        <div class="form-text"><?php echo $gatherRow['gather_article_id']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Display time'); ?></label>
                        <div class="form-text"><?php echo $gatherRow['gather_time_show_format']['date_time']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Source'); ?></label>
                        <div class="form-text"><?php echo $gatherRow['gather_source']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Author'); ?></label>
                        <div class="form-text"><?php echo $gatherRow['gather_author']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Source URL'); ?></label>
                        <div class="form-text">
                            <a href="<?php echo $gatherRow['gather_source_url']; ?>" target="_blank"><?php echo $gatherRow['gather_source_url']; ?></a>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="<?php echo $route_console; ?>article/form/gather/<?php echo $gatherRow['gather_id']; ?>/">
                        <span class="fas fa-edit"></span>
                        <?php echo $lang->get('Edit and store'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL);
include($cfg['pathInclude'] . 'gather_modal' . GK_EXT_TPL);
include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);