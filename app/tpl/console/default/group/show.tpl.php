<?php $cfg = array(
    'title'             => $lang->get('Group', 'console.common') . ' &raquo; ' . $lang->get('Show'),
    'menu_active'       => 'group',
    'sub_active'        => 'index',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>group/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <div class="row">
        <div class="col-xl-9">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="form-group">
                        <label><?php echo $lang->get('Name'); ?></label>
                        <div class="form-text"><?php echo $groupRow['group_name']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Permission'); ?></label>
                        <table class="bg-table">
                            <tbody>
                                <?php $_is_edit = false;
                                include($cfg['pathInclude'] . 'allow_list' . GK_EXT_TPL); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Note'); ?></label>
                        <div class="form-text"><?php echo $groupRow['group_note']; ?></div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="<?php echo $route_console; ?>group/form/id/<?php echo $groupRow['group_id']; ?>/">
                        <span class="fas fa-edit"></span>
                        <?php echo $lang->get('Edit'); ?>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="form-group">
                        <label><?php echo $lang->get('ID'); ?></label>
                        <div class="form-text"><?php echo $groupRow['group_id']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Status'); ?></label>
                        <div class="form-text"><?php $str_status = $groupRow['group_status'];
                        include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?></div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="<?php echo $route_console; ?>group/form/id/<?php echo $groupRow['group_id']; ?>/">
                        <span class="fas fa-edit"></span>
                        <?php echo $lang->get('Edit'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL);
include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);