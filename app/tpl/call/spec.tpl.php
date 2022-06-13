  <ul role="<?php echo $callRow['call_name']; ?>">
    <?php if (isset($specRows) && !empty($specRows)) {
      foreach ($specRows as $key=>$value) { ?>
        <li>
          <a href="<?php echo $value['urlRow']['spec_url']; ?>"><?php echo $value['spec_name']; ?></a>
        </li>
      <?php }
    } ?>
  </ul>
