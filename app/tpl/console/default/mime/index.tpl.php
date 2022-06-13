<?php $cfg = array(
  'title'             => $lang->get('Attachment', 'console.common') . ' &raquo; ' . $lang->get('MIME', 'console.common'),
  'menu_active'       => 'attach',
  'sub_active'        => 'mime',
  'baigoValidate'    => 'true',
  'baigoSubmit'       => 'true',
  'baigoCheckall'     => 'true',
  'baigoDialog'       => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <nav class="nav mb-3">
    <a href="<?php echo $hrefRow['add']; ?>" class="nav-link">
      <span class="bg-icon"><?php include($tpl_icon . 'plus' . BG_EXT_SVG); ?></span>
      <?php echo $lang->get('Add'); ?>
    </a>
  </nav>

  <div class="card bg-light mb-3">
    <div class="card-body">
      <form name="mime_cache" id="mime_cache" action="<?php echo $hrefRow['cache']; ?>">
        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
        <button type="submit" class="btn btn-primary">
          <span class="bg-icon"><?php include($tpl_icon . 'redo-alt' . BG_EXT_SVG); ?></span>
          <?php echo $lang->get('Refresh cache'); ?>
        </button>
      </form>
    </div>
  </div>

  <form name="mime_list" id="mime_list" action="<?php echo $hrefRow['delete']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
    <input type="hidden" name="act" id="act" value="delete">

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
              <?php echo $lang->get('MIME'); ?>
            </th>
            <th class="d-none d-lg-table-cell bg-td-md text-right">
              <small>
                <?php echo $lang->get('Extension name'); ?>
              </small>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($mimeRows as $key=>$value) { ?>
            <tr class="bg-manage-tr">
              <td class="text-nowrap bg-td-xs">
                <div class="form-check">
                  <input type="checkbox" name="mime_ids[]" value="<?php echo $value['mime_id']; ?>" id="mime_id_<?php echo $value['mime_id']; ?>" data-parent="chk_all" data-validate="mime_ids" class="form-check-input mime_id">
                  <label for="mime_id_<?php echo $value['mime_id']; ?>" class="form-check-label" >
                    <small><?php echo $value['mime_id']; ?></small>
                  </label>
                </div>
              </td>
              <td>
                <a class="dropdown-toggle float-right d-block d-lg-none" data-toggle="collapse" href="#td-collapse-<?php echo $value['mime_id']; ?>">
                  <span class="sr-only">Dropdown</span>
                </a>
                <div class="mb-2 text-wrap text-break">
                  <a href="<?php echo $hrefRow['edit'], $value['mime_id']; ?>">
                    <?php echo $value['mime_note']; ?>
                  </a>
                </div>
                <div class="bg-manage-menu">
                  <div class="d-flex flex-wrap">
                    <a href="<?php echo $hrefRow['show'], $value['mime_id']; ?>" class="mr-2">
                      <span class="bg-icon"><?php include($tpl_icon . 'eye' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Show'); ?>
                    </a>
                    <a href="<?php echo $hrefRow['edit'], $value['mime_id']; ?>" class="mr-2">
                      <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Edit'); ?>
                    </a>
                    <a href="javascript:void(0);" data-id="<?php echo $value['mime_id']; ?>" class="mime_delete text-danger">
                      <span class="bg-icon"><?php include($tpl_icon . 'trash-alt' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Delete'); ?>
                    </a>
                  </div>
                </div>
                <dl class="row collapse mt-3 mb-0" id="td-collapse-<?php echo $value['mime_id']; ?>">
                  <dt class="col-3">
                    <small><?php echo $lang->get('Extension name'); ?></small>
                  </dt>
                  <dd class="col-9">
                    <small><?php echo $value['mime_ext']; ?></small>
                  </dd>
                </dl>
              </td>
              <td class="d-none d-lg-table-cell bg-td-md text-right">
                <small><?php echo $value['mime_ext']; ?></small>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <div class="mb-3">
      <small class="form-text" id="msg_mime_ids"></small>
    </div>

    <div>
      <button type="submit" class="btn btn-primary">
        <?php echo $lang->get('Delete'); ?>
      </button>
    </div>
  </form>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  var opts_validate_list = {
    rules: {
      mime_ids: {
        checkbox: '1'
      }
    },
    attr_names: {
      mime_ids: '<?php echo $lang->get('MIME'); ?>'
    },
    type_msg: {
      checkbox: '<?php echo $lang->get('Choose at least one {:attr}'); ?>'
    },
    selector_types: {
      mime_ids: 'validate'
    }
  };

  $(document).ready(function(){
    var obj_dialog          = $.baigoDialog(opts_dialog);
    var obj_validate_list   = $('#mime_list').baigoValidate(opts_validate_list);
    var obj_submit_list     = $('#mime_list').baigoSubmit(opts_submit);

    $('#mime_list').submit(function(){
      if (obj_validate_list.verify()) {
        obj_dialog.confirm('<?php echo $lang->get('Are you sure to delete?'); ?>', function(confirm_result){
          if (confirm_result) {
            obj_submit_list.formSubmit();
          }
        });
      }
    });

    var obj_cache = $('#mime_cache').baigoSubmit(opts_submit);
    $('#mime_cache').submit(function(){
      obj_cache.formSubmit();
    });

    $('.mime_delete').click(function(){
      var _mime_id = $(this).data('id');
      $('.mime_id').prop('checked', false);
      $('#mime_id_' + _mime_id).prop('checked', true);
      $('#mime_list').submit();
    });

    $('#mime_list').baigoCheckall();
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
