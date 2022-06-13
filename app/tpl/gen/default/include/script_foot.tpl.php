  <!--jQuery 库-->
  <script src="{:DIR_STATIC}lib/jquery/1.12.4/jquery.min.js" type="text/javascript"></script>
  <!--bootstrap-->
  <script src="{:DIR_STATIC}lib/bootstrap/4.6.0/js/bootstrap.bundle.min.js" type="text/javascript"></script>

  <?php if (isset($cfg['baigoQuery'])) { ?>
    <!--全选 js-->
    <script src="{:DIR_STATIC}lib/baigoQuery/1.0.0/baigoQuery.min.js" type="text/javascript"></script>
  <?php }

  if (isset($cfg['baigoDialog'])) { ?>
    <!--表单 ajax 提交 js-->
    <script src="{:DIR_STATIC}lib/baigoDialog/1.1.0/baigoDialog.min.js" type="text/javascript"></script>
  <?php } ?>

  <script type="text/javascript">
  <?php if (isset($cfg['baigoDialog'])) { ?>
    var opts_dialog = {
      btn_text: {
        cancel: '<?php echo $lang->get('Cancel', 'gen.common'); ?>',
        confirm: '<?php echo $lang->get('Confirm', 'gen.common'); ?>',
        ok: '<?php echo $lang->get('OK', 'gen.common'); ?>'
      }
    };
  <?php }

  if (isset($cfg['baigoSubmit'])) { ?>
    var opts_submit = {
      modal: {
        btn_text: {
          close: '<?php echo $lang->get('Close', 'gen.common'); ?>',
          ok: '<?php echo $lang->get('OK', 'gen.common'); ?>'
        }
      },
      msg_text: {
        submitting: '<?php echo $lang->get('Submitting', 'gen.common'); ?>'
      }
    };
  <?php }

  if (isset($cfg['baigoClear'])) { ?>
    var opts_clear = {
      msg: {
        loading: '<?php echo $lang->get('Submitting', 'gen.common'); ?>',
        complete: '<?php echo $lang->get('Complete', 'gen.common'); ?>'
      }
    };
  <?php } ?>

  $(document).ready(function(){
    <?php if (isset($cfg['popover'])) { ?>
      $('[data-toggle="popover"]').popover({
        html: true,
        template: '<div class="popover bg-popover"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
      });
    <?php }

    if (isset($cfg['tooltip'])) { ?>
      $('[data-toggle="tooltip"]').tooltip({
        html: true,
        template: '<div class="tooltip bg-tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
      });
    <?php } ?>
  });
  </script>
