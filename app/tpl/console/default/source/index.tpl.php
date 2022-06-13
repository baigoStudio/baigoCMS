<?php $cfg = array(
  'title'             => $lang->get('Article management', 'console.common') . ' &raquo; ' . $lang->get('Article source', 'console.common'),
  'menu_active'       => 'article',
  'sub_active'        => 'source',
  'baigoValidate'     => 'true',
  'baigoSubmit'       => 'true',
  'baigoCheckall'     => 'true',
  'baigoQuery'        => 'true',
  'baigoDialog'       => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <div class="d-flex justify-content-between">
    <nav class="nav mb-3">
      <a href="#modal_nm" data-toggle="modal" data-href="<?php echo $hrefRow['add']; ?>" class="nav-link">
        <span class="bg-icon"><?php include($tpl_icon . 'plus' . BG_EXT_SVG); ?></span>
        <?php echo $lang->get('Add'); ?>
      </a>
    </nav>
    <form name="source_search" id="source_search" class="d-none d-lg-block" action="<?php echo $hrefRow['index']; ?>">
      <div class="input-group mb-3">
        <input type="text" name="key" value="<?php echo $search['key']; ?>" placeholder="<?php echo $lang->get('Keyword'); ?>" class="form-control">
        <span class="input-group-append">
          <button class="btn btn-outline-secondary" type="submit">
            <span class="bg-icon"><?php include($tpl_icon . 'search' . BG_EXT_SVG); ?></span>
          </button>
        </span>
      </div>
    </form>
  </div>

  <?php if (!empty($search['key'])) { ?>
    <div class="mb-3 text-right">
      <?php if (!empty($search['key'])) { ?>
        <span class="badge badge-info">
          <?php echo $lang->get('Keyword'); ?>:
          <?php echo $search['key']; ?>
        </span>
      <?php } ?>

      <a href="<?php echo $hrefRow['index']; ?>" class="badge badge-danger badge-pill">
        <span class="bg-icon"><?php include($tpl_icon . 'times-circle' . BG_EXT_SVG); ?></span>
        <?php echo $lang->get('Reset'); ?>
      </a>
    </div>
  <?php } ?>

  <form name="source_list" id="source_list" action="<?php echo $hrefRow['delete']; ?>">
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
              <?php echo $lang->get('Source'); ?>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($sourceRows as $key=>$value) { ?>
            <tr class="bg-manage-tr">
              <td class="text-nowrap bg-td-xs">
                <div class="form-check">
                  <input type="checkbox" name="source_ids[]" value="<?php echo $value['source_id']; ?>" id="source_id_<?php echo $value['source_id']; ?>" data-parent="chk_all" data-validate="source_ids" class="form-check-input source_id">
                  <label for="source_id_<?php echo $value['source_id']; ?>" class="form-check-label">
                    <small><?php echo $value['source_id']; ?></small>
                  </label>
                </div>
              </td>
              <td>
                <div class="mb-2 text-wrap text-break">
                  <a href="#modal_nm" data-toggle="modal" data-href="<?php echo $hrefRow['edit'], $value['source_id']; ?>">
                    <?php echo $value['source_name']; ?>
                  </a>
                </div>
                <div class="bg-manage-menu">
                  <div class="d-flex flex-wrap">
                    <a href="#modal_nm" data-toggle="modal" data-href="<?php echo $hrefRow['show'], $value['source_id']; ?>" class="mr-2">
                      <span class="bg-icon"><?php include($tpl_icon . 'eye' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Show'); ?>
                    </a>
                    <a href="#modal_nm" data-toggle="modal" data-href="<?php echo $hrefRow['edit'], $value['source_id']; ?>" class="mr-2">
                      <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Edit'); ?>
                    </a>
                    <a href="javascript:void(0);" data-id="<?php echo $value['source_id']; ?>" class="source_delete text-danger">
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
      <small class="form-text" id="msg_source_ids"></small>
    </div>

    <div class="clearfix">
      <div class="float-left">
        <button type="submit" class="btn btn-primary">
          <?php echo $lang->get('Delete'); ?>
        </button>
      </div>
      <div class="float-right">
        <?php include($tpl_include . 'pagination' . GK_EXT_TPL); ?>
      </div>
    </div>
  </form>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL);

  include($tpl_include . 'modal_nm' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  var opts_validate_list = {
    rules: {
      source_ids: {
        checkbox: '1'
      }
    },
    attr_names: {
      source_ids: '<?php echo $lang->get('Source'); ?>'
    },
    type_msg: {
      checkbox: '<?php echo $lang->get('Choose at least one {:attr}'); ?>'
    },
    selector_types: {
      source_ids: 'validate'
    }
  };

  $(document).ready(function(){
    var obj_dialog          = $.baigoDialog(opts_dialog);
    var obj_validate_list   = $('#source_list').baigoValidate(opts_validate_list);
    var obj_submit_list     = $('#source_list').baigoSubmit(opts_submit);

    $('#source_list').submit(function(){
      if (obj_validate_list.verify()) {
        obj_dialog.confirm('<?php echo $lang->get('Are you sure to delete?'); ?>', function(confirm_result){
          if (confirm_result) {
            obj_submit_list.formSubmit();
          }
        });
      }
    });

    $('.source_delete').click(function(){
      var _source_id = $(this).data('id');
      $('.source_id').prop('checked', false);
      $('#source_id_' + _source_id).prop('checked', true);
      $('#source_list').submit();
    });

    $('#source_list').baigoCheckall();

    var obj_query = $('#source_search').baigoQuery();

    $('#source_search').submit(function(){
      obj_query.formSubmit();
    });
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
