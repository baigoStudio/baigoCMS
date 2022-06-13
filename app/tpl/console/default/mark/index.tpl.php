<?php $cfg = array(
  'title'             => $lang->get('Article management', 'console.common') . ' &raquo; ' . $lang->get('Mark', 'console.common'),
  'menu_active'       => 'article',
  'sub_active'        => 'mark',
  'baigoValidate'     => 'true',
  'baigoSubmit'       => 'true',
  'baigoCheckall'     => 'true',
  'baigoDialog'       => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <nav class="nav mb-3">
    <a href="#modal_nm" data-toggle="modal" data-href="<?php echo $hrefRow['add']; ?>" class="nav-link">
      <span class="bg-icon"><?php include($tpl_icon . 'plus' . BG_EXT_SVG); ?></span>
      <?php echo $lang->get('Add'); ?>
    </a>
  </nav>

  <form name="mark_list" id="mark_list" action="<?php echo $hrefRow['delete']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">

    <div class="table-responsive">
      <table class="table table-striped border bg-white">
        <thead>
          <tr>
            <th class="text-nowrap bg-td-xs">
              <div class="form-check">
                <input type="checkbox" name="chk_all" id="chk_all" data-parent="first" class="form-check-input">
                <label for="chk_all" class="form-check-label">
                  <small><?php echo $lang->get('ID'); ?></small>
                </label>
              </div>
            </th>
            <th>
              <?php echo $lang->get('Mark'); ?>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($markRows as $key=>$value) { ?>
            <tr class="bg-manage-tr">
              <td class="text-nowrap bg-td-xs">
                <div class="form-check">
                  <input type="checkbox" name="mark_ids[]" value="<?php echo $value['mark_id']; ?>" id="mark_id_<?php echo $value['mark_id']; ?>" data-parent="chk_all" data-validate="mark_ids" class="form-check-input mark_id">
                  <label for="mark_id_<?php echo $value['mark_id']; ?>" class="form-check-label">
                    <small><?php echo $value['mark_id']; ?></small>
                  </label>
                </div>
              </td>
              <td>
                <div class="mb-2 text-wrap text-break">
                  <a href="#modal_nm" data-toggle="modal" data-href="<?php echo $hrefRow['edit'], $value['mark_id']; ?>">
                    <?php echo $value['mark_name']; ?>
                  </a>
                </div>
                <div class="bg-manage-menu">
                  <div class="d-flex flex-wrap">
                    <a href="#modal_nm" data-toggle="modal" data-href="<?php echo $hrefRow['edit'], $value['mark_id']; ?>" class="mr-2">
                      <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Edit'); ?>
                    </a>
                    <a href="javascript:void(0);" data-id="<?php echo $value['mark_id']; ?>" class="mark_delete text-danger">
                      <span class="bg-icon"><?php include($tpl_icon . 'trash-alt' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Delete'); ?>
                    </a>
                  </div>
                </div>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <div class="mb-3">
      <small class="form-text" id="msg_mark_ids"></small>
    </div>

    <div>
      <button type="submit" class="btn btn-primary">
        <?php echo $lang->get('Delete'); ?>
      </button>
    </div>
  </form>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL);

  include($tpl_include . 'modal_nm' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  var opts_validate_list = {
    rules: {
      mark_ids: {
        checkbox: '1'
      }
    },
    attr_names: {
      mark_ids: '<?php echo $lang->get('Mark'); ?>'
    },
    type_msg: {
      checkbox: '<?php echo $lang->get('Choose at least one {:attr}'); ?>'
    },
    selector_types: {
      mark_ids: 'validate'
    }
  };

  $(document).ready(function(){
    var obj_dialog          = $.baigoDialog(opts_dialog);
    var obj_validate_list   = $('#mark_list').baigoValidate(opts_validate_list);
    var obj_submit_list     = $('#mark_list').baigoSubmit(opts_submit);

    $('#mark_list').submit(function(){
      if (obj_validate_list.verify()) {
        obj_dialog.confirm('<?php echo $lang->get('Are you sure to delete?'); ?>', function(confirm_result){
          if (confirm_result) {
            obj_submit_list.formSubmit();
          }
        });
      }
    });

    $('.mark_delete').click(function(){
      var _mark_id = $(this).data('id');
      $('.mark_id').prop('checked', false);
      $('#mark_id_' + _mark_id).prop('checked', true);
      $('#mark_list').submit();
    });

    $('#mark_list').baigoCheckall();
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
