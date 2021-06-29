<?php $cfg = array(
    'title'             => $lang->get('Special topic', 'console.common') . ' &raquo; ' . $lang->get('Show'),
    'menu_active'       => 'spec',
    'sub_active'        => 'index',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>spec/" class="nav-link">
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
                        <div class="form-text"><?php echo $specRow['spec_name']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Content'); ?></label>
                        <div class="form-text"><?php echo $specRow['spec_content']; ?></div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="<?php echo $route_console; ?>spec/form/id/<?php echo $specRow['spec_id']; ?>/">
                        <span class="fas fa-edit"></span>
                        <?php echo $lang->get('Edit'); ?>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3">
            <div class="card bg-light">
                <div class="card-body">
                    <?php include($cfg['pathInclude'] . 'spec_info' . GK_EXT_TPL); ?>
                </div>
                <div class="card-footer text-right">
                    <a href="<?php echo $route_console; ?>spec/form/id/<?php echo $specRow['spec_id']; ?>/">
                        <span class="fas fa-edit"></span>
                        <?php echo $lang->get('Edit'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL);
include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);
