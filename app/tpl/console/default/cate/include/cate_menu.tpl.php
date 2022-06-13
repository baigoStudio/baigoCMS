  <?php if ($cateRow['cate_id'] > 0) { ?>
    <li class="nav-item dropdown">
      <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="javascript:void(0);">
        <?php echo $lang->get('More'); ?>
      </a>
      <div class="dropdown-menu">
        <a href="<?php echo $hrefRow['attach'], $cateRow['cate_id']; ?>" class="dropdown-item<?php if ($route['ctrl'] == 'cate' && $route['act'] == 'attach') { ?> active<?php } ?>">
          <?php echo $lang->get('Cover management'); ?>
        </a>
        <a href="<?php echo $hrefRow['show'], $cateRow['cate_id']; ?>" class="dropdown-item<?php if ($route['ctrl'] == 'cate' && $route['act'] == 'show') { ?> active<?php } ?>">
          <?php echo $lang->get('Show'); ?>
        </a>
        <a href="<?php echo $hrefRow['edit'], $cateRow['cate_id']; ?>" class="dropdown-item<?php if ($route['ctrl'] == 'cate' && $route['act'] == 'form') { ?> active<?php } ?>">
          <?php echo $lang->get('Edit'); ?>
        </a>
      </div>
    </li>
  <?php } ?>
