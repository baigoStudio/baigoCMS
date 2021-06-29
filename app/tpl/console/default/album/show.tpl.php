<?php $cfg = array(
    'title'             => $lang->get('Album', 'console.common') . ' &raquo; ' . $lang->get('Show'),
    'menu_active'       => 'album',
    'sub_active'        => 'index',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>album/" class="nav-link">
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
                        <div class="form-text"><?php echo $albumRow['album_name']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Intro'); ?></label>
                        <div class="form-text"><?php echo $albumRow['album_content']; ?></div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="<?php echo $route_console; ?>album/form/id/<?php echo $albumRow['album_id']; ?>/">
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
                        <div class="form-text"><?php echo $albumRow['album_id']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Status'); ?></label>
                        <div class="form-text"><?php $str_status = $albumRow['album_status'];
                        include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('Cover'); ?></label>
                        <div class="mb-2">
                            <?php if (isset($attachRow['attach_thumb']) && !empty($attachRow['attach_thumb'])) { ?>
                                <img src="<?php echo $attachRow['attach_thumb']; ?>" class="img-fluid">
                            <?php } ?>
                        </div>

                        <div class="form-text"><?php if (isset($attachRow['attach_thumb'])) { echo $attachRow['attach_thumb']; } ?></div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="<?php echo $route_console; ?>album/form/id/<?php echo $albumRow['album_id']; ?>/">
                        <span class="fas fa-edit"></span>
                        <?php echo $lang->get('Edit'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL);
include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);
