<?php $cfg = array(
  'title'             => $lang->get('Special topic', 'console.common'),
  'menu_active'       => 'spec',
  'sub_active'        => 'index',
  'baigoValidate'     => 'true',
  'baigoSubmit'       => 'true',
  'baigoCheckall'     => 'true',
  'baigoQuery'        => 'true',
  'baigoDialog'       => 'true',
  'tooltip'           => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <div class="d-flex justify-content-between">
    <nav class="nav mb-3">
      <a href="<?php echo $hrefRow['add']; ?>" class="nav-link">
        <span class="bg-icon"><?php include($tpl_icon . 'plus' . BG_EXT_SVG); ?></span>
        <?php echo $lang->get('Add'); ?>
      </a>
    </nav>
    <form name="spec_search" id="spec_search" class="d-none d-lg-block" action="<?php echo $hrefRow['index']; ?>">
      <div class="input-group mb-3">
        <input type="text" name="key" value="<?php echo $search['key']; ?>" placeholder="<?php echo $lang->get('Keyword'); ?>" class="form-control">
        <span class="input-group-append">
          <button class="btn btn-outline-secondary" type="submit">
            <span class="bg-icon"><?php include($tpl_icon . 'search' . BG_EXT_SVG); ?></span>
          </button>
          <button class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" type="button" data-toggle="collapse" data-target="#bg-search-more">
            <span class="sr-only">Dropdown</span>
          </button>
        </span>
      </div>
      <div class="collapse" id="bg-search-more">
        <div class="input-group mb-3">
          <select name="status" class="custom-select">
            <option value=""><?php echo $lang->get('All status'); ?></option>
            <?php foreach ($status as $key=>$value) { ?>
              <option <?php if ($search['status'] == $value) { ?>selected<?php } ?> value="<?php echo $value; ?>">
                <?php echo $lang->get($value); ?>
              </option>
            <?php } ?>
          </select>
        </div>
      </div>
    </form>
  </div>

  <?php if (!empty($search['key']) || !empty($search['status']) || !empty($search['type'])) { ?>
    <div class="mb-3 text-right">
      <?php if (!empty($search['key'])) { ?>
        <span class="badge badge-info">
          <?php echo $lang->get('Keyword'); ?>:
          <?php echo $search['key']; ?>
        </span>
      <?php }

      if (!empty($search['status'])) { ?>
        <span class="badge badge-info">
          <?php echo $lang->get('Status'); ?>:
          <?php echo $lang->get($search['status']); ?>
        </span>
      <?php } ?>

      <a href="<?php echo $hrefRow['index']; ?>" class="badge badge-danger badge-pill">
        <span class="bg-icon"><?php include($tpl_icon . 'times-circle' . BG_EXT_SVG); ?></span>
        <?php echo $lang->get('Reset'); ?>
      </a>
    </div>
  <?php } ?>

  <form name="spec_list" id="spec_list" action="<?php echo $hrefRow['status']; ?>">
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
              <?php echo $lang->get('Topic'); ?>
            </th>
            <th class="d-none d-lg-table-cell bg-td-md text-right">
              <small>
                <?php echo $lang->get('Status'); ?>
                /
                <?php echo $lang->get('Time'); ?>
              </small>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($specRows as $key=>$value) { ?>
            <tr class="bg-manage-tr">
              <td class="text-nowrap bg-td-xs">
                <div class="form-check">
                  <input type="checkbox" name="spec_ids[]" value="<?php echo $value['spec_id']; ?>" id="spec_id_<?php echo $value['spec_id']; ?>" data-parent="chk_all" data-validate="spec_ids" class="form-check-input spec_id">
                  <label for="spec_id_<?php echo $value['spec_id']; ?>" class="form-check-label">
                    <small><?php echo $value['spec_id']; ?></small>
                  </label>
                </div>
              </td>
              <td>
                <a class="dropdown-toggle float-right d-block d-lg-none" data-toggle="collapse" href="#td-collapse-<?php echo $value['spec_id']; ?>">
                  <span class="sr-only">Dropdown</span>
                </a>
                <div class="mb-2 text-wrap text-break">
                  <a class="" href="<?php echo $hrefRow['edit'], $value['spec_id']; ?>">
                    <?php echo $value['spec_name']; ?>
                  </a>
                </div>
                <div class="bg-manage-menu">
                  <div class="d-flex flex-wrap">
                    <a href="<?php echo $hrefRow['show'], $value['spec_id']; ?>" class="mr-2">
                      <span class="bg-icon"><?php include($tpl_icon . 'eye' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Show'); ?>
                    </a>
                    <a href="<?php echo $hrefRow['edit'], $value['spec_id']; ?>" class="mr-2">
                      <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Edit'); ?>
                    </a>
                    <a href="<?php echo $hrefRow['spec_belong'], $value['spec_id']; ?>" class="mr-2">
                      <span class="bg-icon"><?php include($tpl_icon . 'hand-pointer' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Choose article'); ?>
                    </a>
                    <a href="<?php echo $hrefRow['attach'], $value['spec_id']; ?>" class="mr-2">
                      <span class="bg-icon"><?php include($tpl_icon . 'images' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Set cover'); ?>
                    </a>
                    <a href="javascript:void(0);" data-id="<?php echo $value['spec_id']; ?>" class="spec_delete text-danger">
                      <span class="bg-icon"><?php include($tpl_icon . 'trash-alt' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Delete'); ?>
                    </a>
                  </div>
                </div>
                <dl class="row collapse mt-3 mb-0" id="td-collapse-<?php echo $value['spec_id']; ?>">
                  <dt class="col-3">
                    <small><?php echo $lang->get('Status'); ?></small>
                  </dt>
                  <dd class="col-9">
                    <?php $str_status = $value['spec_status'];
                    include($tpl_include . 'status_process' . GK_EXT_TPL); ?>
                  </dd>
                  <dt class="col-3">
                    <small><?php echo $lang->get('Time'); ?></small>
                  </dt>
                  <dd class="col-9">
                    <small data-toggle="tooltip" data-placement="bottom" title="<?php echo $value['spec_time_update_format']['date_time']; ?>"><?php echo $value['spec_time_update_format']['date_time_short']; ?></small>
                  </dd>
                </dl>
              </td>
              <td class="d-none d-lg-table-cell bg-td-md text-right">
                <div>
                  <?php $str_status = $value['spec_status'];
                  include($tpl_include . 'status_process' . GK_EXT_TPL); ?>
                </div>
                <div>
                  <small data-toggle="tooltip" data-placement="bottom" title="<?php echo $value['spec_time_update_format']['date_time']; ?>"><?php echo $value['spec_time_update_format']['date_time_short']; ?></small>
                </div>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <div class="mb-3">
        <small class="form-text" id="msg_spec_ids"></small>
    </div>

    <div class="clearfix">
      <div class="float-left">
        <div class="input-group mb-3">
          <select name="act" id="act" class="custom-select">
            <option value=""><?php echo $lang->get('Bulk actions'); ?></option>
            <?php foreach ($status as $key=>$value) { ?>
              <option value="<?php echo $value; ?>">
                <?php echo $lang->get($value); ?>
              </option>
            <?php } ?>
            <option value="delete"><?php echo $lang->get('Delete'); ?></option>
          </select>
          <span class="input-group-append">
            <button type="submit" class="btn btn-primary">
              <?php echo $lang->get('Apply'); ?>
            </button>
          </span>
        </div>
        <small id="msg_act" class="form-text"></small>
      </div>
      <div class="float-right">
        <?php include($tpl_include . 'pagination' . GK_EXT_TPL); ?>
      </div>
    </div>
  </form>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  var opts_validate_list = {
    rules: {
      spec_ids: {
        checkbox: '1'
      },
      act: {
        require: true
      }
    },
    attr_names: {
      spec_ids: '<?php echo $lang->get('Topic'); ?>',
      act: '<?php echo $lang->get('Action'); ?>'
    },
    type_msg: {
      require: '<?php echo $lang->get('Choose at least one {:attr}'); ?>',
      checkbox: '<?php echo $lang->get('Choose at least one {:attr}'); ?>'
    },
    selector_types: {
      spec_ids: 'validate'
    }
  };

  $(document).ready(function(){
    var obj_dialog          = $.baigoDialog(opts_dialog);
    var obj_validate_list   = $('#spec_list').baigoValidate(opts_validate_list);
    var obj_submit_list     = $('#spec_list').baigoSubmit(opts_submit);

    $('#spec_list').submit(function(){
      var _act = $('#act').val();
      if (obj_validate_list.verify()) {
        switch (_act) {
          case 'delete':
            obj_dialog.confirm('<?php echo $lang->get('Are you sure to delete?'); ?>', function(confirm_result){
              if (confirm_result) {
                obj_submit_list.formSubmit('<?php echo $hrefRow['delete']; ?>');
              }
            });
          break;

          default:
            obj_submit_list.formSubmit('<?php echo $hrefRow['status']; ?>');
          break;
        }
      }
    });

    $('.spec_delete').click(function(){
      var _spec_id = $(this).data('id');
      $('.spec_id').prop('checked', false);
      $('#spec_id_' + _spec_id).prop('checked', true);
      $('#act').val('delete');
      $('#spec_list').submit();
    });

    $('#spec_list').baigoCheckall();

    var obj_query = $('#spec_search').baigoQuery();

    $('#spec_search').submit(function(){
      obj_query.formSubmit();
    });
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
