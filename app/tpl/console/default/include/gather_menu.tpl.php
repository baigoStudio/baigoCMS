        <nav class="nav mb-3">
            <a href="<?php echo $route_console; ?>grab/" class="nav-link<?php if ($route['ctrl'] == 'grab') { ?> disabled<?php } ?>">
                <span class="fas fa-project-diagram"></span>
                <?php echo $lang->get('Gather data', 'console.common'); ?>
            </a>
            <a href="<?php echo $route_console; ?>gather/" class="nav-link<?php if ($route['ctrl'] == 'gather') { ?> disabled<?php } ?>">
                <span class="fas fa-check-double"></span>
                <?php echo $lang->get('Approve', 'console.common'); ?>
            </a>
        </nav>
