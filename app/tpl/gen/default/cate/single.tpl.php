<?php $cfg = array(
  'title'         => $lang->get('Generating'),
);

include($tpl_include . 'html_head' . GK_EXT_TPL); ?>

  <div id="modal_body">
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th><?php echo $lang->get('ID'); ?></th>
            <th><?php echo $lang->get('Category'); ?></th>
            <th><?php echo $lang->get('Pagination'); ?></th>
            <th class="text-right"><?php echo $lang->get('Status'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php for ($_iii = 1; $_iii <= $pageRow['total']; $_iii++) { ?>
            <tr>
              <td>
                <?php echo $cateRow['cate_id']; ?>
              </td>
              <td>
                <?php echo $cateRow['cate_name']; ?>
              </td>
              <td>
                <?php echo $_iii; ?> / <?php echo $pageRow['total']; ?>
              </td>
              <td id="cate_<?php echo $_iii; ?>"  class="text-right text-nowrap">
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
  </div>

<?php include($tpl_include . 'script_foot' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  $(document).ready(function(){
    <?php for ($_iii = 1; $_iii <= $pageRow['total']; $_iii++) { ?>
      $.ajax({
        url: '<?php echo $hrefRow['submit']; ?>?' + new Date().getTime() + '=' + Math.random(), //url
        //async: false, //设置为同步
        type: 'post',
        dataType: 'json',
        data: {
          cate_id: '<?php echo $cateRow['cate_id']; ?>',
          page: '<?php echo $_iii; ?>',
          <?php echo $token['name']; ?>: '<?php echo $token['value']; ?>'
        },
        timeout: 30000,
        error: function (result) {
          $('#cate_<?php echo $_iii; ?> div').attr('class', 'text-danger');
          $('#cate_<?php echo $_iii; ?> .bg-icon').html('<?php include($tpl_icon . 'times-circle' . BG_EXT_SVG); ?>');
          $('#cate_<?php echo $_iii; ?> small').text(result.statusText);
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

          $('#cate_<?php echo $_iii; ?> div').attr('class', _class);
          $('#cate_<?php echo $_iii; ?> .bg-icon').html(_icon);
          $('#cate_<?php echo $_iii; ?> small').text(_result.msg);
        }
      });
    <?php } ?>

    $(this).ajaxStop(function(){
      $('#modal_body').html('<div class="modal-body"><h4 class="text-success"><span class="bg-icon"><?php include($tpl_icon . 'check-circle' . BG_EXT_SVG); ?></span> <?php echo $lang->get('Complete generation'); ?></h4></div>');
      $('#gen_modal #gen_modal_icon', parent.document).attr('class', 'bg-icon text-success');
      $('#gen_modal #gen_modal_icon', parent.document).html('<?php include($tpl_icon . 'check-circle' . BG_EXT_SVG); ?>');
      $('#gen_modal #gen_modal_msg', parent.document).attr('class', 'text-success');
      $('#gen_modal #gen_modal_msg', parent.document).text('<?php echo $lang->get('Complete generation'); ?>');
    });
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
