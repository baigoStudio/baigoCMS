    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>gsite/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
        <?php if ($route_orig['act'] != 'form') { ?>
            <a href="#help_modal_lg" data-toggle="modal" class="nav-link" data-act="selector">
                <span class="fas fa-hand-pointer"></span>
                <?php echo $lang->get('Selector help'); ?>
            </a>
        <?php } ?>
    </nav>
