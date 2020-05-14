<?php function custom_list_show($arr_customRows, $article_customs = array()) {
    if (!empty($arr_customRows)) {
        foreach ($arr_customRows as $key=>$value) {
            if (isset($value['custom_childs']) && empty($value['custom_childs'])) { ?>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <?php echo $value['custom_name']; ?>
                        </div>
                    </div>
                    <input type="text" class="form-control bg-transparent" readonly value="<?php if (isset($article_customs['custom_' . $value['custom_id']])) { echo $article_customs['custom_' . $value['custom_id']]; } ?>">
                </div>
            <?php } else { ?>
                <h6>
                    <span class="badge badge-secondary"><?php echo $value['custom_name']; ?></span>
                </h6>
            <?php }

            if (isset($value['custom_childs'])) {
                custom_list_show($value['custom_childs'], $article_customs);
            }
        }
    }
}

$cfg = array(
    'title'             => $lang->get('Article management', 'console.common') . ' &raquo; ' . $lang->get('Show'),
    'menu_active'       => 'article',
    'sub_active'        => 'index',
    'tooltip'           => 'true',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>article/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

        <div class="row">
            <div class="col-xl-9">
                <div class="form-group">
                    <h3><?php echo $articleRow['article_title']; ?></h3>
                </div>

                <div class="form-group">
                    <div class="text-wrap text-break bg-content"><?php echo $articleRow['article_content']; ?></div>
                </div>

                <div class="form-group">
                    <a href="<?php echo $route_console; ?>article/form/id/<?php echo $articleRow['article_id']; ?>/">
                        <span class="fas fa-edit"></span>
                        <?php echo $lang->get('Edit'); ?>
                    </a>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="card bg-light">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs_base"><?php echo $lang->get('Base'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs_more"><?php echo $lang->get('More'); ?></a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content list-group list-group-flush">
                        <div class="tab-pane active" id="tabs_base">
                            <div class="list-group-item">
                                <div class="form-group">
                                    <?php echo $lang->get('ID'); ?>: <?php echo $articleRow['article_id']; ?>
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
                                    <label><?php echo $lang->get('Position'); ?></label>
                                    <div class="form-text"><?php $str_status = $articleRow['article_box'];
                                    include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?></div>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $lang->get('Mark'); ?></label>
                                    <div class="form-text">
                                        <?php if (isset($markRow['mark_name'])) { echo $markRow['mark_name']; } ?>
                                    </div>
                                </div>
                            </div>

                            <a class="list-group-item list-group-item-action bg-light d-flex justify-content-between align-items-center" data-toggle="collapse" href="#bg-form-time">
                                <span>
                                    <?php echo $lang->get('Time'); ?>
                                </span>
                                <small class="fas fa-chevron-down" id="bg-caret-time"></small>
                            </a>

                            <div id="bg-form-time" data-key="time" class="list-group-item collapse">
                                <div class="form-group">
                                    <label><?php echo $lang->get('Display time'); ?></label>
                                    <div class="form-text"><?php echo $articleRow['article_time_show_format']['date_time']; ?></div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" <?php if ($articleRow['article_is_time_pub'] > 0) { ?>checked<?php } ?>  class="custom-control-input" disabled>
                                        <label for="article_is_time_pub" class="custom-control-label">
                                            <?php echo $lang->get('Scheduled publish'); ?>
                                        </label>
                                    </div>
                                    <?php if ($articleRow['article_is_time_pub'] > 0) { ?>
                                        <div class="form-text"><?php echo $articleRow['article_time_pub_format']['date_time']; ?></div>
                                    <?php } ?>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" <?php if ($articleRow['article_is_time_hide'] > 0) { ?>checked<?php } ?>  class="custom-control-input" disabled>
                                        <label for="article_is_time_hide" class="custom-control-label">
                                            <?php echo $lang->get('Scheduled offline'); ?>
                                        </label>
                                    </div>
                                    <?php if ($articleRow['article_is_time_hide'] > 0) { ?>
                                        <div class="form-text"><?php echo $articleRow['article_time_hide_format']['date_time']; ?></div>
                                    <?php } ?>
                                </div>
                            </div>

                            <a class="list-group-item list-group-item-action bg-light d-flex justify-content-between align-items-center" data-toggle="collapse" href="#bg-form-tag">
                                <span>
                                    <?php echo $lang->get('Tag'); ?>
                                </span>
                                <small class="fas fa-chevron-down" id="bg-caret-tag"></small>
                            </a>

                            <div id="bg-form-tag" data-key="tag" class="list-group-item collapse">
                                <div class="bg-tag-list">
                                    <?php foreach ($articleRow['article_tags'] as $key=>$value) { ?>
                                        <div class="bg-tag-item"><?php echo $value; ?></div>
                                    <?php } ?>
                                </div>
                            </div>

                            <a class="list-group-item list-group-item-action bg-light d-flex justify-content-between align-items-center" data-toggle="collapse" href="#bg-form-excerpt">
                                <span>
                                    <?php echo $lang->get('Excerpt'); ?>
                                </span>
                                <small class="fas fa-chevron-down" id="bg-caret-excerpt"></small>
                            </a>

                            <div id="bg-form-excerpt" data-key="excerpt" class="list-group-item collapse">
                                <div class="form-text"><?php echo $articleRow['article_excerpt']; ?></div>
                            </div>

                            <a class="list-group-item list-group-item-action d-flex bg-light justify-content-between align-items-center" data-toggle="collapse" href="#bg-form-source">
                                <span>
                                    <?php echo $lang->get('Source'); ?>
                                </span>
                                <small class="fas fa-chevron-down" id="bg-caret-source"></small>
                            </a>

                            <div id="bg-form-source" data-key="source" class="list-group-item collapse">
                                <div class="form-group">
                                    <label><?php echo $lang->get('Source'); ?></label>
                                    <div class="form-text"><?php echo $articleRow['article_source']; ?></div>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $lang->get('Author'); ?></label>
                                    <div class="form-text"><?php echo $articleRow['article_author']; ?></div>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $lang->get('Source URL'); ?></label>
                                    <div class="form-text"><?php echo $articleRow['article_source_url']; ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="tabs_more">
                            <div class="list-group-item">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" <?php if ($articleRow['cate_ids_check'] > 0) { ?>checked<?php } ?> class="custom-control-input" disabled>
                                    <label for="cate_ids_check" class="custom-control-label">
                                        <?php echo $lang->get('Attached to categories'); ?>
                                    </label>
                                </div>

                                <?php if ($articleRow['cate_ids_check'] > 0) { ?>
                                    <div>
                                        <table class="bg-table">
                                            <tbody>
                                                <?php $cate_ids = $articleRow['article_cate_ids'];
                                                $is_edit        = false;
                                                include($cfg['pathInclude'] . 'cate_list_checkbox' . GK_EXT_TPL); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } ?>
                            </div>

                            <a class="list-group-item list-group-item-action bg-light d-flex justify-content-between align-items-center" data-toggle="collapse" href="#bg-form-spec">
                                <span>
                                    <?php echo $lang->get('Special topic'); ?>
                                </span>
                                <small class="fas fa-chevron-down" id="bg-caret-spec"></small>
                            </a>

                            <div id="bg-form-spec" data-key="spec" class="list-group-item collapse">
                                <div id="spec_list">
                                    <?php foreach ($specRows as $key=>$value) { ?>
                                        <div>
                                            <span class="fas fa-check-circle text-success"></span>
                                            <a href="<?php echo $route_console; ?>spec/show/id/<?php echo $value['spec_id']; ?>/" target="_blank"><?php echo $value['spec_name']; ?></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <a class="list-group-item list-group-item-action bg-light d-flex justify-content-between align-items-center" data-toggle="collapse" href="#bg-form-custom">
                                <span>
                                    <?php echo $lang->get('Custom fields'); ?>
                                </span>
                                <small class="fas fa-chevron-down" id="bg-caret-custom"></small>
                            </a>

                            <div id="bg-form-custom" data-key="custom" class="list-group-item collapse">
                                <?php if (isset($articleRow['article_customs'])) {
                                    custom_list_show($customRows, $articleRow['article_customs']);
                                } ?>
                            </div>

                            <a class="list-group-item list-group-item-action d-flex bg-light justify-content-between align-items-center" data-toggle="collapse" href="#bg-form-link">
                                <span>
                                    <?php echo $lang->get('Jump to'); ?>
                                </span>
                                <small class="fas fa-chevron-down" id="bg-caret-link"></small>
                            </a>

                            <div id="bg-form-link" data-key="link" class="list-group-item collapse <?php if (!empty($articleRow['article_link'])) { ?>show list-group-item-warning<?php } ?>">
                                <div class="form-text"><?php echo $articleRow['article_link']; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="<?php echo $route_console; ?>article/form/id/<?php echo $articleRow['article_id']; ?>/">
                            <span class="fas fa-edit"></span>
                            <?php echo $lang->get('Edit'); ?>
                        </a>
                    </div>
                </div>

                <?php if (!empty($articleRow['article_link'])) { ?>
                    <div class="alert alert-warning mt-3">
                        <span class="fas fa-exclamation-triangle">
                        <?php echo $lang->get('Warning! This article is a hyperlink'); ?>
                    </div>
                <?php } ?>
            </div>
        </div>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL);
include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);