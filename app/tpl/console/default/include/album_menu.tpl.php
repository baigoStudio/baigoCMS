  <?php if (isset($albumRow['album_id']) && $albumRow['album_id'] > 0) { ?>
    <li class="nav-item dropdown">
      <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="javascript:void(0);">
        <?php echo $lang->get('More'); ?>
      </a>
      <div class="dropdown-menu">
        <a href="<?php echo $hrefRow['album-upload'], $albumRow['album_id']; ?>" class="dropdown-item<?php if ($route['ctrl'] == 'attach' && $route['act'] == 'form') { ?> active<?php } ?>">
          <?php echo $lang->get('Upload'); ?>
        </a>
        <a href="<?php echo $hrefRow['album_belong'], $albumRow['album_id']; ?>" class="dropdown-item<?php if ($route['ctrl'] == 'album_belong' && $route['act'] == 'index') { ?> active<?php } ?>">
          <?php echo $lang->get('Choose image'); ?>
        </a>
        <a href="<?php echo $hrefRow['album-show'], $albumRow['album_id']; ?>" class="dropdown-item<?php if ($route['ctrl'] == 'album' && $route['act'] == 'show') { ?> active<?php } ?>">
          <?php echo $lang->get('Show'); ?>
        </a>
        <a href="<?php echo $hrefRow['album-edit'], $albumRow['album_id']; ?>" class="dropdown-item<?php if ($route['ctrl'] == 'album' && $route['act'] == 'form') { ?> active<?php } ?>">
          <?php echo $lang->get('Edit'); ?>
        </a>
      </div>
    </li>
  <?php } ?>
