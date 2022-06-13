  <nav class="nav mb-3">
    <a href="<?php echo $hrefRow['index']; ?>" class="nav-link">
      <span class="bg-icon"><?php include($tpl_icon . 'chevron-left' . BG_EXT_SVG); ?></span>
      <?php echo $lang->get('Back'); ?>
    </a>
    <?php if ($route_orig['act'] != 'form') { ?>
      <a href="#help_modal" data-toggle="modal" class="nav-link" data-href="<?php echo $hrefRow['gsite-help']; ?>selector" data-size="lg">
        <span class="bg-icon"><?php include($tpl_icon . 'hand-pointer' . BG_EXT_SVG); ?></span>
        <?php echo $lang->get('Selector help'); ?>
      </a>
    <?php } ?>
  </nav>
