<?php use ginkgo\Plugin; ?>
  </div>

<?php Plugin::listen('action_pub_foot_before'); ?>

  <footer class="container">

  </footer>

<?php Plugin::listen('action_pub_foot_after');

include($tpl_include . 'script_foot' . GK_EXT_TPL);
