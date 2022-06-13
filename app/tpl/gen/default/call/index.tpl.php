<?php $cfg = array(
  'title'         => $lang->get('Generating'),
);

include($tpl_include . 'html_head' . GK_EXT_TPL); ?>

  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th><?php echo $lang->get('ID'); ?></th>
          <th><?php echo $lang->get('Call'); ?></th>
          <th class="text-right"><?php echo $lang->get('Status'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($callRows as $_key=>$_value) { ?>
          <tr>
            <td>
              <?php echo $_value['call_id']; ?>
            </td>
            <td>
              <?php echo $_value['call_name']; ?>
            </td>
            <td id="call_<?php echo $_value['call_id']; ?>" class="text-right text-nowrap">
              <div class="text-info">
                <span class="bg-icon">
                  <span class="spinner-grow spinner-grow-sm"></span>
                </span>
                <small>
                  <?php echo $lang->get('Generating'); ?>
                </small>
              </div>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

<?php include($tpl_include . 'script_foot' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  $(document).ready(function(){
    <?php if (!empty($callRows)) {
      foreach ($callRows as $_key=>$_value) { ?>
        $.ajax({
          url: '<?php echo $hrefRow['submit']; ?>?' + new Date().getTime() + '=' + Math.random(), //url
          //async: false, //设置为同步
          type: 'post',
          dataType: 'json',
          data: {
            call_id: '<?php echo $_value['call_id']; ?>',
            <?php echo $token['name']; ?>: '<?php echo $token['value']; ?>'
          },
          timeout: 30000,
          error: function (result) {
            $('#call_<?php echo $_value['call_id']; ?> div').attr('class', 'text-danger');
            $('#call_<?php echo $_value['call_id']; ?> .bg-icon').html('<?php include($tpl_icon . 'check-circle' . BG_EXT_SVG); ?>');
            $('#call_<?php echo $_value['call_id']; ?> small').text(result.statusText);
          },
          success: function(_result){ //读取返回结果
            _rcode_status  = _result.rcode.substr(0, 1);

            switch (_rcode_status) {
              case 'y':
                _class  = 'text-success';
                _icon   = '<?php include($tpl_icon . 'check-circle' . BG_EXT_SVG); ?>';
              break;

              default:
                _class  = 'text-danger';
                _icon   = '<?php include($tpl_icon . 'times-circle' . BG_EXT_SVG); ?>';
              break;
            }

            $('#call_<?php echo $_value['call_id']; ?> div').attr('class', _class);
            $('#call_<?php echo $_value['call_id']; ?> .bg-icon').html(_icon);
            $('#call_<?php echo $_value['call_id']; ?> small').text(_result.msg);
          }
        });
      <?php } ?>

      $(this).ajaxStop(function(){
        setTimeout(function(){
          window.location.href = '<?php echo $jump; ?>';
        }, 1000);
      });
    <?php } else { ?>
      setTimeout(function(){
        window.location.href = '<?php echo $jump; ?>';
      }, 1000);
    <?php } ?>
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
