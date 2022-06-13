  <ul role="<?php echo $callRow['call_name']; ?>">
    <?php if (isset($linkRows) && !empty($linkRows)) {
      foreach ($linkRows as $key=>$value) { ?>
        <li>
          <a href="<?php echo $value['link_url']; ?>"<?php if ($value['link_blank'] > 0) { ?> target="_blank"<?php } ?>><?php echo $value['link_name']; ?></a>
        </li>
      <?php }
    } ?>
  </ul>
