  <?php if ($articleRow['article_id'] > 0) { ?>
    <li class="nav-item dropdown">
      <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="javascript:void(0);">
        <?php echo $lang->get('More'); ?>
      </a>
      <div class="dropdown-menu">
        <a href="<?php echo $hrefRow['attach'], $articleRow['article_id']; ?>" class="dropdown-item<?php if ($route['ctrl'] == 'article' && $route['act'] == 'attach') { ?> active<?php } ?>">
          <?php echo $lang->get('Cover management'); ?>
        </a>
        <a href="<?php echo $hrefRow['show'], $articleRow['article_id']; ?>" class="dropdown-item<?php if ($route['ctrl'] == 'article' && $route['act'] == 'show') { ?> active<?php } ?>">
          <?php echo $lang->get('Show'); ?>
        </a>
        <a href="<?php echo $hrefRow['edit'], $articleRow['article_id']; ?>" class="dropdown-item<?php if ($route['ctrl'] == 'article' && $route['act'] == 'form') { ?> active<?php } ?>">
          <?php echo $lang->get('Edit'); ?>
        </a>
      </div>
    </li>
  <?php } ?>
