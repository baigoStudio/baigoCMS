  <nav class="nav mb-3">
    <a href="<?php echo $hrefRow['grab-index']; ?>" class="nav-link<?php if ($route['ctrl'] == 'grab') { ?> disabled<?php } ?>">
      <span class="bg-icon"><?php include($tpl_icon . 'project-diagram' . BG_EXT_SVG); ?></span>
      <?php echo $lang->get('Gather data', 'console.common'); ?>
    </a>
    <a href="<?php echo $hrefRow['gather-index']; ?>" class="nav-link<?php if ($route['ctrl'] == 'gather') { ?> disabled<?php } ?>">
      <span class="bg-icon"><?php include($tpl_icon . 'check-double' . BG_EXT_SVG); ?></span>
      <?php echo $lang->get('Approve', 'console.common'); ?>
    </a>
  </nav>
