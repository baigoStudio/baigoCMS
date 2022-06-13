  <?php if ($specRow['spec_id'] > 0) { ?>
    <li class="nav-item dropdown">
      <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="javascript:void(0);">
        <?php echo $lang->get('More'); ?>
      </a>
      <div class="dropdown-menu">
        <a href="<?php echo $hrefRow['spec_belong'], $specRow['spec_id']; ?>" class="dropdown-item<?php if ($route['ctrl'] == 'spec_belong' && $route['act'] == 'index') { ?> active<?php } ?>">
          <?php echo $lang->get('Choose article'); ?>
        </a>
        <a href="<?php echo $hrefRow['attach'], $specRow['spec_id']; ?>" class="dropdown-item<?php if ($route['ctrl'] == 'spec' && $route['act'] == 'attach') { ?> active<?php } ?>">
          <?php echo $lang->get('Cover management'); ?>
        </a>
        <a href="<?php echo $hrefRow['show'], $specRow['spec_id']; ?>" class="dropdown-item<?php if ($route['ctrl'] == 'spec' && $route['act'] == 'show') { ?> active<?php } ?>">
          <?php echo $lang->get('Show'); ?>
        </a>
        <a href="<?php echo $hrefRow['edit'], $specRow['spec_id']; ?>" class="dropdown-item<?php if ($route['ctrl'] == 'spec' && $route['act'] == 'form') { ?> active<?php } ?>">
          <?php echo $lang->get('Edit'); ?>
        </a>
      </div>
    </li>
  <?php } ?>
