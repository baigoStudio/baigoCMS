<?php $cfg = array(
  'title'         => $lang->get('Error', 'gen.common'),
  'no_token'      => 'true',
);

switch ($rstatus) {
  case 'y':
    $str_color  = 'success';
    $str_icon   = 'check-circle';
  break;

  default:
    $str_color  = 'danger';
    $str_icon   = 'times-circle';
  break;
}

include($tpl_include . 'html_head' . GK_EXT_TPL); ?>
  <div class="m-3">
    <h3 class="text-<?php echo $str_color; ?>">
      <span class="bg-icon">
        <?php include($tpl_icon . $str_icon . BG_EXT_SVG); ?>
      </span>
      <?php if (isset($msg)) {
        echo $msg;
      } ?>
    </h3>
    <div class="text-<?php echo $str_color; ?> lead">
      <?php if (isset($rcode)) {
          echo $rcode;
      } ?>
    </div>
    <?php if (isset($detail) && !empty($detail)) { ?>
      <hr>
      <div>
        <?php echo $detail; ?>
      </div>
    <?php } ?>
  </div>

  <?php if (isset($rcode) && ($rcode == 'y120406' || $rcode == 'y280404' || $rcode == 'y250406' || $rcode == 'y180406')) {
    include($tpl_include . 'script_foot' . GK_EXT_TPL); ?>

    <script type="text/javascript">
    $(document).ready(function(){
      $('#gen_modal #gen_modal_icon', parent.document).attr('class', 'bg-icon text-<?php echo $str_color; ?>');
      $('#gen_modal #gen_modal_icon', parent.document).html('<?php include($tpl_icon . $str_icon . BG_EXT_SVG); ?>');
      $('#gen_modal #gen_modal_msg', parent.document).attr('class', 'text-<?php echo $str_color; ?>');
      $('#gen_modal #gen_modal_msg', parent.document).text('<?php echo $lang->get($msg); ?>');
    });
    </script>
  <?php }

include($tpl_include . 'html_foot' . GK_EXT_TPL);
