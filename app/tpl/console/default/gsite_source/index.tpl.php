<?php $cfg = array(
  'prism' => 'true',
);

include($tpl_include . 'html_head' . GK_EXT_TPL); ?>

  <div class="bg-light sticky-top border-bottom">
    <div class="p-2">
      <?php echo $sourceRow['url']; ?>
    </div>
  </div>

  <div class="container-fluid">
    <pre class="bg-pre-nostyle p-0"><code class="language-markup"><?php echo $sourceRow['content']; ?></code></pre>
  </div>

<?php include($tpl_include . 'script_foot' . GK_EXT_TPL);
include($tpl_include . 'html_foot' . GK_EXT_TPL);
