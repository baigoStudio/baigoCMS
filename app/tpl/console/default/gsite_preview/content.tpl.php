<?php $cfg = array(
);

include($tpl_include . 'html_head' . GK_EXT_TPL); ?>

  <div class="container-fluid">
    <?php if (isset($contentRow['title'])) { ?>
      <h3>
        <a href="<?php echo $contentRow['url']; ?>" target="_blank"><?php echo $contentRow['title']; ?></a>
      </h3>
    <?php } ?>

    <div>
      <dl class="row">
        <?php if (isset($contentRow['time'])) { ?>
          <dt class="col-3">
            <?php echo $lang->get('Time'); ?>
          </dt>
          <dd class="col-9">
            <?php echo $contentRow['time']; ?>
          </dd>
        <?php }

        if (isset($contentRow['source'])) { ?>
          <dt class="col-3">
            <?php echo $lang->get('Source'); ?>
          </dt>
          <dd class="col-9">
            <?php echo $contentRow['source']; ?>
          </dd>
        <?php }

        if (isset($contentRow['author'])) { ?>
          <dt class="col-3">
            <?php echo $lang->get('Author'); ?>
          </dt>
          <dd class="col-9">
            <?php echo $contentRow['author']; ?>
          </dd>
        <?php } ?>
      </ul>
    </div>

    <div class="bg-content"><?php echo $contentRow['content']; ?></div>
  </div>

<?php include($tpl_include . 'script_foot' . GK_EXT_TPL);
include($tpl_include . 'html_foot' . GK_EXT_TPL);
