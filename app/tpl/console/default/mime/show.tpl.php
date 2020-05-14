<?php $cfg = array(
    'title'         => $lang->get('MIME', 'console.common') . ' &raquo; ' . $lang->get('Show'),
    'menu_active'   => 'attach',
    'sub_active'    => 'mime',
    'pathInclude'   => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>mime/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <div class="row">
        <div class="col-xl-9">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="form-group">
                        <label><?php echo $lang->get('Extension name'); ?></label>
                        <div class="form-text"><?php echo $mimeRow['mime_ext']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('MIME content'); ?></label>
                        <?php foreach ($mimeRow['mime_content'] as $key=>$value) { ?>
                            <div class="form-text"><?php echo $value; ?></div>
                        <?php } ?>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="<?php echo $route_console; ?>mime/form/id/<?php echo $mimeRow['mime_id']; ?>/">
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
                        <div class="form-text"><?php echo $mimeRow['mime_id']; ?></div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="<?php echo $route_console; ?>mime/form/id/<?php echo $mimeRow['mime_id']; ?>/">
                        <span class="fas fa-edit"></span>
                        <?php echo $lang->get('Edit'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL);
include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);