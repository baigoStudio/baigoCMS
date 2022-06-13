  <ul role="<?php echo $callRow['call_name']; ?>">
    <?php if (isset($tagRows) && !empty($tagRows)) {
      foreach ($tagRows as $key=>$value) { ?>
        <li>
          <a href="<?php echo $value['tag_url']['url']; ?>"><?php echo $value['tag_name']; ?></a>
        </li>
      <?php }
    } ?>
  </ul>
