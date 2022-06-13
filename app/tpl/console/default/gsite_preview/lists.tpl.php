<?php $cfg = array(
);

include($tpl_include . 'html_head' . GK_EXT_TPL); ?>

  <div class="container-fluid">
    <?php if (!empty($listRows)) { ?>
      <ul>
        <?php foreach ($listRows as $_key=>$_value) { ?>
          <li>
            <a href="<?php echo $_value['url']; ?>" target="_blank"><?php echo $_value['content']; ?></a>
          </li>
        <?php } ?>
      </ul>
    <?php } ?>
  </div>

<?php include($tpl_include . 'script_foot' . GK_EXT_TPL);
include($tpl_include . 'html_foot' . GK_EXT_TPL);
