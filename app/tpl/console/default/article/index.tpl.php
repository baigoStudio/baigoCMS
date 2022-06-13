<?php $cfg = array(
  'title'             => $lang->get('Article management', 'console.common'),
  'menu_active'       => 'article',
  'sub_active'        => 'index',
  'baigoValidate'     => 'true',
  'baigoSubmit'       => 'true',
  'baigoCheckall'     => 'true',
  'baigoQuery'        => 'true',
  'baigoDialog'       => 'true',
  'tooltip'           => 'true',
  'datetimepicker'    => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <div class="d-flex justify-content-between">
    <nav class="nav mb-3">
      <a href="<?php echo $hrefRow['add']; ?>article/form/" class="nav-link">
        <span class="bg-icon"><?php include($tpl_icon . 'plus' . BG_EXT_SVG); ?></span>
        <?php echo $lang->get('Add'); ?>
      </a>
      <a href="<?php echo $hrefRow['index']; ?>" class="nav-link d-none d-lg-block<?php if ($search['box'] == 'normal') { ?> disabled<?php } ?>">
        <?php echo $lang->get('All'); ?>
        <span class="badge badge-pill badge-<?php if ($search['box'] == 'normal') { ?>secondary<?php } else { ?>primary<?php } ?>"><?php echo $articleCount['all']; ?></span>
      </a>
      <a href="<?php echo $hrefRow['index-box']; ?>draft" class="nav-link d-none d-lg-block<?php if ($search['box'] == 'draft') { ?> disabled<?php } ?>">
        <?php echo $lang->get('Draft'); ?>
        <span class="badge badge-pill badge-<?php if ($search['box'] == 'draft') { ?>secondary<?php } else { ?>primary<?php } ?>"><?php echo $articleCount['draft']; ?></span>
      </a>
      <?php if ($articleCount['recycle'] > 0) { ?>
        <a href="<?php echo $hrefRow['index-box']; ?>recycle" class="nav-link d-none d-lg-block<?php if ($search['box'] == 'recycle') { ?> disabled<?php } ?>">
          <?php echo $lang->get('Recycle'); ?>
          <span class="badge badge-pill badge-<?php if ($search['box'] == 'recycle') { ?>secondary<?php } else { ?>primary<?php } ?>"><?php echo $articleCount['recycle']; ?></span>
        </a>
      <?php } ?>
    </nav>
    <form name="article_search" id="article_search" class="d-none d-lg-inline-block" action="<?php echo $hrefRow['index']; ?>">
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
          <select name="cate" class="custom-select">
            <option value=""><?php echo $lang->get('All categories'); ?></option>
            <?php $check_id = $search['cate'];
            include($tpl_include . 'cate_list_option' . GK_EXT_TPL); ?>
            <option<?php if ($search['cate'] == -1) { ?> selected<?php } ?> value="-1">
              <?php echo $lang->get('Not affiliated'); ?>
            </option>
          </select>
          <select name="year" class="custom-select">
            <option value=""><?php echo $lang->get('All years'); ?></option>
            <?php foreach ($articleYear as $key=>$value) { ?>
              <option<?php if ($search['year'] == $value['article_year']) { ?> selected<?php } ?> value="<?php echo $value['article_year']; ?>"><?php echo $value['article_year']; ?></option>
            <?php } ?>
          </select>
          <select name="month" class="custom-select">
            <option value=""><?php echo $lang->get('All months'); ?></option>
            <?php for ($iii = 1 ; $iii <= 12; ++$iii) {
              if ($iii < 10) {
                $str_month = '0' . $iii;
              } else {
                $str_month = $iii;
              } ?>
              <option<?php if ($search['month'] == $str_month) { ?> selected<?php } ?> value="<?php echo $str_month; ?>"><?php echo $str_month; ?></option>
            <?php } ?>
          </select>
          <select name="mark" class="custom-select">
            <option value=""><?php echo $lang->get('All marks'); ?></option>
            <?php foreach ($markRows as $key=>$value) { ?>
              <option<?php if ($search['mark'] == $value['mark_id']) { ?> selected<?php } ?> value="<?php echo $value['mark_id']; ?>"><?php echo $value['mark_name']; ?></option>
            <?php } ?>
          </select>
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

  <?php if (!empty($search['key']) || !empty($search['cate']) || isset($cateRow['cate_name']) || !empty($search['year']) || !empty($search['month']) || isset($markRow['mark_name']) || !empty($search['status']) || isset($adminRow['admin_name'])) { ?>
    <div class="mb-3 text-right">
      <?php if (!empty($search['key'])) { ?>
        <span class="badge badge-info">
          <?php echo $lang->get('Keyword'); ?>:
          <?php echo $search['key']; ?>
        </span>
      <?php }

      if (!empty($search['cate']) || isset($cateRow['cate_name'])) { ?>
        <span class="badge badge-info">
          <?php echo $lang->get('Category'); ?>:
          <?php if (isset($cateRow['cate_name'])) {
            echo $cateRow['cate_name'];
          } else if ($search['cate'] < 0) {
            echo $lang->get('Not affiliated');
          } ?>
        </span>
      <?php }

      if (!empty($search['year'])) { ?>
        <span class="badge badge-info">
          <?php echo $lang->get('Year'); ?>:
          <?php echo $search['year']; ?>
        </span>
      <?php }

      if (!empty($search['month'])) { ?>
        <span class="badge badge-info">
          <?php echo $lang->get('Month'); ?>:
          <?php echo $search['month']; ?>
        </span>
      <?php }

      if (isset($markRow['mark_name'])) { ?>
        <span class="badge badge-info">
          <?php echo $lang->get('Mark'); ?>:
          <?php echo $markRow['mark_name']; ?>
        </span>
      <?php }

      if (!empty($search['status'])) { ?>
        <span class="badge badge-info">
          <?php echo $lang->get('Status'); ?>:
          <?php echo $lang->get($search['status']); ?>
        </span>
      <?php }

      if (isset($adminRow['admin_name'])) { ?>
        <span class="badge badge-info">
          <?php echo $lang->get('Administrator'); ?>:
          <?php echo $adminRow['admin_name']; ?>
        </span>
      <?php } ?>

      <a href="<?php echo $hrefRow['index']; ?>" class="badge badge-danger badge-pill">
        <span class="bg-icon"><?php include($tpl_icon . 'times-circle' . BG_EXT_SVG); ?></span>
          <?php echo $lang->get('Reset'); ?>
      </a>
    </div>
  <?php }

  if ($search['box'] == 'recycle') { ?>
    <div class="card bg-light mb-3">
      <div class="card-body">
        <div class="alert alert-danger">
          <span class="bg-icon"><?php include($tpl_icon . 'exclamation-triangle' . BG_EXT_SVG); ?></span>
            <?php echo $lang->get('Warning! This operation is not recoverable!'); ?>
        </div>

        <form name="article_empty" id="article_empty" action="<?php echo $hrefRow['empty-recycle']; ?>">
          <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
          <button type="submit" class="btn btn-danger">
            <span class="bg-icon"><?php include($tpl_icon . 'trash-alt' . BG_EXT_SVG); ?></span>
            <?php echo $lang->get('Empty'); ?>
          </button>
        </form>
      </div>
    </div>
  <?php } ?>

  <form name="article_list" id="article_list" action="<?php echo $hrefRow['status']; ?>">
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
            <th><?php echo $lang->get('Article'); ?></th>
            <th class="d-none d-lg-table-cell bg-td-md">
              <small><?php echo $lang->get('Category'); ?></small>
            </th>
            <th class="d-none d-lg-table-cell bg-td-md text-right">
              <small>
                <?php echo $lang->get('Administrator'); ?>
                /
                <?php echo $lang->get('Hits'); ?>
              </small>
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
          <?php foreach ($articleRows as $key=>$value) {
            $str_cateBeadcrumb = '';

            if (isset($value['cateRow']['cate_breadcrumb'])) {
              foreach ($value['cateRow']['cate_breadcrumb'] as $key_cate=>$value_cate) {
                $str_cateBeadcrumb .= $value_cate['cate_name'];

                if ($value_cate['cate_end'] < 1) {
                  $str_cateBeadcrumb .= ' &raquo; ';
                }
              }
            } ?>
            <tr class="bg-manage-tr">
              <td class="text-nowrap bg-td-xs">
                <div class="form-check">
                  <input type="checkbox" name="article_ids[]" value="<?php echo $value['article_id']; ?>" id="article_id_<?php echo $value['article_id']; ?>" data-parent="chk_all" data-validate="article_ids" class="form-check-input article_id">
                  <label for="article_id_<?php echo $value['article_id']; ?>" class="form-check-label">
                    <small><?php echo $value['article_id']; ?></small>
                  </label>
                </div>
              </td>
              <td>
                <a class="dropdown-toggle float-right d-block d-lg-none" data-toggle="collapse" href="#td-collapse-<?php echo $value['article_id']; ?>">
                  <span class="sr-only">Dropdown</span>
                </a>
                <div class="mb-2 text-wrap text-break">
                  <a href="<?php echo $hrefRow['edit'], $value['article_id']; ?>">
                    <?php echo $value['article_title']; ?>
                  </a>
                </div>
                <div class="bg-manage-menu">
                  <div class="d-flex flex-wrap">
                    <a href="<?php echo $hrefRow['show'], $value['article_id']; ?>" class="mr-2">
                      <span class="bg-icon"><?php include($tpl_icon . 'eye' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Show'); ?>
                    </a>
                    <?php if ($search['box'] == 'recycle') { ?>
                      <a href="javascript:void(0);" data-id="<?php echo $value['article_id']; ?>" class="article_restore mr-2">
                        <span class="bg-icon"><?php include($tpl_icon . 'redo-alt' . BG_EXT_SVG); ?></span>
                        <?php echo $lang->get('Restore'); ?>
                      </a>
                      <a href="javascript:void(0);" data-id="<?php echo $value['article_id']; ?>" class="article_delete text-danger mr-2">
                        <span class="bg-icon"><?php include($tpl_icon . 'trash-alt' . BG_EXT_SVG); ?></span>
                        <?php echo $lang->get('Delete'); ?>
                      </a>
                    <?php } else { ?>
                      <a href="<?php echo $hrefRow['edit'], $value['article_id']; ?>" class="mr-2">
                        <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
                        <?php echo $lang->get('Edit'); ?>
                      </a>
                      <a data-toggle="modal" href="#modal_nm" data-href="<?php echo $hrefRow['simple'], $value['article_id']; ?>" class="mr-2">
                        <span class="bg-icon"><?php include($tpl_icon . 'pen-square' . BG_EXT_SVG); ?></span>
                        <?php echo $lang->get('Quick edit'); ?>
                      </a>
                      <a href="<?php echo $hrefRow['attach'], $value['article_id']; ?>" class="mr-2">
                        <span class="bg-icon"><?php include($tpl_icon . 'images' . BG_EXT_SVG); ?></span>
                        <?php echo $lang->get('Cover management'); ?>
                      </a>
                      <?php if ($gen_open === true) { ?>
                        <a href="#gen_modal" data-url="<?php echo $hrefRow['gen'], $value['article_id']; ?>" data-toggle="modal" class="mr-2">
                          <span class="bg-icon"><?php include($tpl_icon . 'sync-alt' . BG_EXT_SVG); ?></span>
                          <?php echo $lang->get('Generate'); ?>
                        </a>
                      <?php } ?>
                      <a href="javascript:void(0);" data-id="<?php echo $value['article_id']; ?>" class="article_recycle text-danger">
                        <span class="bg-icon"><?php include($tpl_icon . 'trash-alt' . BG_EXT_SVG); ?></span>
                        <?php echo $lang->get('Recycle'); ?>
                      </a>
                    <?php } ?>
                  </div>
                </div>
                <dl class="row collapse mt-3 mb-0" id="td-collapse-<?php echo $value['article_id']; ?>">
                  <dt class="col-3">
                    <small><?php echo $lang->get('Category'); ?></small>
                  </dt>
                  <dd class="col-9">
                    <small>
                      <?php if (isset($value['cateRow']['cate_name'])) { ?>
                        <abbr data-toggle="tooltip" data-placement="bottom" title="<?php echo $str_cateBeadcrumb; ?>">
                          <a href="<?php echo $hrefRow['index-cate'], $value['cateRow']['cate_id']; ?>">
                            <?php echo $value['cateRow']['cate_name']; ?>
                          </a>
                        </abbr>
                      <?php } else {
                        echo $lang->get('Unknown');
                      } ?>
                    </small>
                  </dd>
                  <dt class="col-3">
                    <small><?php echo $lang->get('Administrator'); ?></small>
                  </dt>
                  <dd class="col-9">
                    <small>
                      <?php if (isset($value['adminRow']['admin_name'])) { ?>
                        <a href="<?php echo $hrefRow['index-admin'], $value['adminRow']['admin_id']; ?>">
                          <?php echo $value['adminRow']['admin_name']; ?>
                        </a>
                      <?php } else {
                        echo $lang->get('Unknown');
                      } ?>
                    </small>
                  </dd>
                  <dt class="col-3">
                    <small><?php echo $lang->get('Hits'); ?></small>
                  </dt>
                  <dd class="col-9">
                    <small>
                      <abbr data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang->get('Daily hits'), ' ', $value['article_hits_day'], '<br>', $lang->get('Weekly hits'), ' ', $value['article_hits_week'], '<br>', $lang->get('Monthly hits'), ' ', $value['article_hits_month'], '<br>', $lang->get('Yearly hits'), ' ', $value['article_hits_year'], '<br>', $lang->get('Total hits'), ' ', $value['article_hits_all']; ?>">
                        <?php echo $value['article_hits_all']; ?>
                      </abbr>
                    </small>
                  </dd>
                  <dt class="col-3">
                    <small><?php echo $lang->get('Status'); ?></small>
                  </dt>
                  <dd class="col-9">
                    <?php $articleRow = $value;
                    include($tpl_include . 'status_article' . GK_EXT_TPL); ?>
                  </dd>
                  <dt class="col-3">
                    <small><?php echo $lang->get('Time'); ?></small>
                  </dt>
                  <dd class="col-9">
                    <small data-toggle="tooltip" data-placement="bottom" title="<?php echo $value['article_time_pub_format']['date_time']; ?>"><?php echo $value['article_time_pub_format']['date_time_short']; ?></small>
                  </dd>
                </dl>
              </td>
              <td class="d-none d-lg-table-cell bg-td-md">
                <small>
                  <?php if (isset($value['cateRow']['cate_name'])) { ?>
                    <abbr data-toggle="tooltip" data-placement="bottom" title="<?php echo $str_cateBeadcrumb; ?>">
                      <a href="<?php echo $hrefRow['index-cate'], $value['cateRow']['cate_id']; ?>">
                        <?php echo $value['cateRow']['cate_name']; ?>
                      </a>
                    </abbr>
                  <?php } else {
                    echo $lang->get('Unknown');
                  } ?>
                </small>
              </td>
              <td class="d-none d-lg-table-cell bg-td-md text-right">
                <small>
                  <div class="mb-2">
                    <?php if (isset($value['adminRow']['admin_name'])) { ?>
                      <a href="<?php echo $hrefRow['index-admin'], $value['adminRow']['admin_id']; ?>">
                        <?php echo $value['adminRow']['admin_name']; ?>
                      </a>
                    <?php } else {
                      echo $lang->get('Unknown');
                    } ?>
                  </div>
                  <div>
                    <abbr data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang->get('Daily hits'), ' ', $value['article_hits_day'], '<br>', $lang->get('Weekly hits'), ' ', $value['article_hits_week'], '<br>', $lang->get('Monthly hits'), ' ', $value['article_hits_month'], '<br>', $lang->get('Yearly hits'), ' ', $value['article_hits_year'], '<br>', $lang->get('Total hits'), ' ', $value['article_hits_all']; ?>">
                      <?php echo $value['article_hits_all']; ?>
                    </abbr>
                  </div>
                </small>
              </td>
              <td class="d-none d-lg-table-cell bg-td-md text-right">
                <div class="mb-2">
                  <?php if ($gen_open === true) {
                    $str_status = $value['article_is_gen'];
                    include($tpl_include . 'status_process' . GK_EXT_TPL);
                  }

                  $articleRow = $value;
                  include($tpl_include . 'status_article' . GK_EXT_TPL); ?>
                </div>
                <div>
                  <small data-toggle="tooltip" data-placement="bottom" title="<?php echo $value['article_time_pub_format']['date_time']; ?>"><?php echo $value['article_time_pub_format']['date_time_short']; ?></small>
                </div>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <div class="mb-3">
      <small class="form-text" id="msg_article_ids"></small>
    </div>

    <div class="clearfix">
      <div class="float-left">
        <div class="input-group mb-3">
          <select name="act" id="act" class="custom-select">
            <option value=""><?php echo $lang->get('Bulk actions'); ?></option>
            <?php switch ($search['box']) {
              case 'recycle': ?>
                <option value="normal"><?php echo $lang->get('Restore'); ?></option>
                <option value="delete"><?php echo $lang->get('Delete'); ?></option>
              <?php break;

              case 'draft': ?>
                <option value="normal"><?php echo $lang->get('Restore'); ?></option>
                <option value="recycle"><?php echo $lang->get('Move to recycle'); ?></option>
              <?php break;

              default:
                foreach ($status as $key=>$value) { ?>
                  <option value="<?php echo $value; ?>">
                    <?php echo $lang->get($value); ?>
                  </option>
                <?php } ?>
                <option value="draft"><?php echo $lang->get('Draft'); ?></option>
                <option value="move"><?php echo $lang->get('Move'); ?></option>
                <option value="recycle"><?php echo $lang->get('Move to recycle'); ?></option>
              <?php break;
            } ?>
          </select>
          <select id="cate_id" name="cate_id" class="custom-select">
            <option value="">
              <?php echo $lang->get('Please select'); ?>
            </option>
            <?php cate_list_option($cateRows); ?>
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

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL);

  include($tpl_include . 'modal_nm' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  var opts_validate_list = {
    rules: {
      article_ids: {
        checkbox: '1'
      },
      act: {
        require: true
      }
    },
    attr_names: {
      article_ids: '<?php echo $lang->get('Article'); ?>',
      act: '<?php echo $lang->get('Action'); ?>'
    },
    type_msg: {
      require: '<?php echo $lang->get('Choose at least one {:attr}'); ?>',
      checkbox: '<?php echo $lang->get('Choose at least one {:attr}'); ?>'
    },
    selector_types: {
      article_ids: 'validate'
    }
  };

  $(document).ready(function(){
    $('#cate_id').hide();

    var obj_dialog          = $.baigoDialog(opts_dialog);
    var obj_validate_list   = $('#article_list').baigoValidate(opts_validate_list);
    var obj_submit_list     = $('#article_list').baigoSubmit(opts_submit);

    //console.log(obj_submit_list);

    $('#article_list').submit(function(){
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

          case 'recycle':
            obj_dialog.confirm('<?php echo $lang->get('Are you sure move to recycle?'); ?>', function(confirm_result){
              if (confirm_result) {
                obj_submit_list.formSubmit('<?php echo $hrefRow['box']; ?>');
              }
            });
          break;

          case 'normal':
          case 'draft':
            obj_submit_list.formSubmit('<?php echo $hrefRow['box']; ?>');
          break;

          case 'move':
            obj_submit_list.formSubmit('<?php echo $hrefRow['move']; ?>');
          break;

          default:
            obj_submit_list.formSubmit('<?php echo $hrefRow['status']; ?>');
          break;
        }
      }
    });

    var obj_submit_empty     = $('#article_empty').baigoSubmit(opts_submit);

    $('#article_empty').submit(function(){
      obj_dialog.confirm('<?php echo $lang->get('Warning! This operation is not recoverable!'); ?>', function(confirm_result){
        if (confirm_result) {
          obj_submit_empty.formSubmit();
        }
      });
    });

    $('#act').change(function(){
      var _act = $(this).val();
      if (_act == 'move') {
        $('#cate_id').show();
      } else {
        $('#cate_id').hide();
      }
    });

    $('.article_delete').click(function(){
      var _article_id = $(this).data('id');
      $('.article_id').prop('checked', false);
      $('#article_id_' + _article_id).prop('checked', true);
      $('#act').val('delete');
      $('#article_list').submit();
    });

    $('.article_restore').click(function(){
      var _article_id = $(this).data('id');
      $('.article_id').prop('checked', false);
      $('#article_id_' + _article_id).prop('checked', true);
      $('#act').val('normal');
      $('#article_list').submit();
    });

    $('.article_recycle').click(function(){
      var _article_id = $(this).data('id');
      $('.article_id').prop('checked', false);
      $('#article_id_' + _article_id).prop('checked', true);
      $('#act').val('recycle');
      $('#article_list').submit();
    });

    $('#article_list').baigoCheckall();

    var obj_query = $('#article_search').baigoQuery();

    $('#article_search').submit(function(){
      obj_query.formSubmit();
    });
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
