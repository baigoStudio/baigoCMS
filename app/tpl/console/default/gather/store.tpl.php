<?php $cfg = array(
  'title'         => $lang->get('Being stored'),
  'no_token'      => 'true',
);

include($tpl_include . 'html_head' . GK_EXT_TPL); ?>

  <div class="table-responsive">
    <table class="table">
      <thead>
          <tr>
            <th>
              <small><?php echo $lang->get('ID'); ?></small>
            </th>
            <th><?php echo $lang->get('Title'); ?></th>
            <th class="text-right">
              <small><?php echo $lang->get('Status'); ?></small>
            </th>
          </tr>
      </thead>
      <tbody>
        <?php foreach ($gatherRows as $_key=>$_value) { ?>
          <tr>
            <td>
              <small><?php echo $_value['gather_id']; ?></small>
            </td>
            <td><?php echo $_value['gather_title']; ?></div></td>
            <td id="gather_<?php echo $_value['gather_id']; ?>" class="text-right text-nowrap">
              <div class="text-info">
                <span class="bg-icon">
                  <span class="spinner-grow spinner-grow-sm"></span>
                </span>
                <small>
                  <?php echo $lang->get('Being stored'); ?>
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
    <?php if (!empty($gatherRows)) {
      foreach ($gatherRows as $_key=>$_value) { ?>
        $.ajax({
          url: '<?php echo $hrefRow['store-submit']; ?>?' + new Date().getTime() + '=' + Math.random(), //url
          //async: false, //设置为同步
          type: 'post',
          dataType: 'json',
          data: {
            enforce: '<?php echo $search['enforce']; ?>',
            gather_id: '<?php echo $_value['gather_id']; ?>',
            <?php echo $token['name']; ?>: '<?php echo $token['value']; ?>'
          },
          timeout: 30000,
          error: function (result) {
            $('#gather_<?php echo $_value['gather_id']; ?> div').attr('class', 'text-danger');
            $('#gather_<?php echo $_value['gather_id']; ?> .bg-icon').html('<?php include($tpl_icon . 'times-circle' . BG_EXT_SVG); ?>');
            $('#gather_<?php echo $_value['gather_id']; ?> small').text(result.statusText);
          },
          success: function(result){ //读取返回结果
            _rcode_status  = result.rcode.substr(0, 1);

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

            $('#gather_<?php echo $_value['gather_id']; ?> div').attr('class', _class);
            $('#gather_<?php echo $_value['gather_id']; ?> .bg-icon').html(_icon);
            $('#gather_<?php echo $_value['gather_id']; ?> small').text(result.msg);
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
