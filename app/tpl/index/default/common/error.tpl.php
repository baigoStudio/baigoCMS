<?php $cfg = array(
  'title'         => $lang->get('Error', 'index.common'),
);

if (isset($param['view'])) {
  switch ($param['view']) {
    case 'modal': ?>
      <div class="modal-header">
        <div class="modal-title"><?php echo $cfg['title']; ?></div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

      <div class="modal-body">
    <?php break;

    default:
      include($tpl_include . 'html_head' . GK_EXT_TPL); ?>
      <div class="m-3">
    <?php break;
  }
} else {
  include($tpl_include . 'index_head' . GK_EXT_TPL); ?>

  <nav class="nav mb-3">
    <a href="javascript:history.go(-1);" class="nav-link">
      &lt;
      <?php echo $lang->get('Back', 'index.common'); ?>
    </a>
  </nav>
<?php } ?>

  <h3 class="text-danger">
    <?php if (isset($msg)) {
      echo $msg;
    } ?>
  </h3>

  <div class="text-danger lead">
    <?php if (isset($rcode)) {
      echo $rcode;
    } ?>
  </div>
  <?php if (isset($detail) && !empty($detail)) { ?>
    <hr>
    <div>
      <?php echo $detail; ?>
    </div>
  <?php }

if (isset($param['view'])) {
  switch ($param['view']) {
    case 'modal': ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
          <?php echo $lang->get('Close', 'index.common'); ?>
        </button>
      </div>
    <?php break;

    default: ?>
      </div>
      <?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
    break;
  }
} else {
  include($tpl_include . 'index_foot' . GK_EXT_TPL);
  include($tpl_include . 'html_foot' . GK_EXT_TPL);
}
