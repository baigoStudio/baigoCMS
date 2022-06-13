<?php $cfg = array(
  'title'             => $lang->get('Gathering', 'console.common') . ' &raquo; ' . $lang->get('Gather data', 'console.common'),
  'menu_active'       => 'gather',
  'sub_active'        => 'gather',
  'baigoQuery'        => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <div class="d-flex justify-content-between">
    <?php include($tpl_include . 'gather_menu' . GK_EXT_TPL); ?>

    <form name="gsite_search" id="gsite_search" class="d-none d-lg-block" action="<?php echo $hrefRow['index']; ?>">
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

  <?php if (!empty($search['key']) || !empty($search['status'])) { ?>
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
        <span class="bg-icon">
          <?php include($tpl_icon . 'times-circle' . BG_EXT_SVG); ?>
        </span>
        <?php echo $lang->get('Reset'); ?>
      </a>
    </div>
  <?php } ?>

  <div class="card bg-light mb-3">
    <div class="card-body">
      <button class="btn btn-primary" data-toggle="modal" data-all="all" data-target="#gather_modal">
        <span class="bg-icon">
          <?php include($tpl_icon . 'cloud-download-alt' . BG_EXT_SVG); ?>
        </span>
        <?php echo $lang->get('Gather all'); ?>
      </button>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-striped border bg-white">
      <thead>
        <tr>
          <th class="text-nowrap bg-td-xs">
            <small><?php echo $lang->get('ID'); ?></small>
          </th>
          <th>
            <?php echo $lang->get('Gathering site'); ?>
          </th>
          <th class="d-none d-lg-table-cell bg-td-md text-right">
            <small>
              <?php echo $lang->get('Status'); ?>
              /
              <?php echo $lang->get('Note'); ?>
            </small>
          </th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($gsiteRows as $key=>$value) { ?>
          <tr class="bg-manage-tr">
            <td class="text-nowrap bg-td-xs">
              <small><?php echo $value['gsite_id']; ?></small>
            </td>
            <td>
              <a class="dropdown-toggle float-right d-block d-lg-none" data-toggle="collapse" href="#td-collapse-<?php echo $value['gsite_id']; ?>">
                <span class="sr-only">Dropdown</span>
              </a>
              <div class="mb-2 text-wrap text-break">
                <?php echo $value['gsite_name']; ?>
              </div>
              <div class="bg-manage-menu">
                <div class="d-flex flex-wrap">
                  <a href="<?php echo $hrefRow['show'], $value['gsite_id']; ?>" class="mr-2">
                    <span class="bg-icon"><?php include($tpl_icon . 'eye' . BG_EXT_SVG); ?></span>
                    <?php echo $lang->get('Show'); ?>
                  </a>
                  <a href="#gather_modal" data-toggle="modal" data-id="<?php echo $value['gsite_id']; ?>">
                    <span class="bg-icon">
                      <?php include($tpl_icon . 'file-download' . BG_EXT_SVG); ?>
                    </span>
                    <?php echo $lang->get('Gather'); ?>
                  </a>
                </div>
              </div>
              <dl class="row collapse mt-3 mb-0" id="td-collapse-<?php echo $value['gsite_id']; ?>">
                <dt class="col-3">
                  <small><?php echo $lang->get('Status'); ?></small>
                </dt>
                <dd class="col-9">
                  <?php $str_status = $value['gsite_status'];
                  include($tpl_include . 'status_process' . GK_EXT_TPL); ?>
                </dd>
                <dt class="col-3">
                  <small><?php echo $lang->get('Note'); ?></small>
                </dt>
                <dd class="col-9">
                  <small><?php echo $value['gsite_note']; ?></small>
                </dd>
              </dl>
            </td>
            <td class="d-none d-lg-table-cell bg-td-md text-right">
              <div class="mb-2">
                <?php $str_status = $value['gsite_status'];
                include($tpl_include . 'status_process' . GK_EXT_TPL); ?>
              </div>
              <div>
                <small><?php echo $value['gsite_note']; ?></small>
              </div>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <div class="clearfix">
    <div class="float-right">
      <?php include($tpl_include . 'pagination' . GK_EXT_TPL); ?>
    </div>
  </div>

  <div class="modal fade" id="gather_modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title">
            <span id="gather_modal_icon" class="bg-icon text-info">
              <span class="spinner-grow spinner-grow-sm"></span>
            </span>
            <span id="gather_modal_msg" class="text-info"><?php echo $lang->get('Grabbing'); ?></span>
          </div>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="embed-responsive embed-responsive-1by1">
          <iframe class="embed-responsive-item" name="iframe_gen"></iframe>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
            <?php echo $lang->get('Close', 'console.common'); ?>
          </button>
        </div>
      </div>
    </div>
  </div>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  $(document).ready(function(){
    $('#gather_modal').on('shown.bs.modal',function(event){
      var _obj_button   = $(event.relatedTarget);
      var _all          = _obj_button.data('all');
      var _id           = _obj_button.data('id');

      var _url = '<?php echo $hrefRow['grab']; ?>';

      if (typeof _id == 'undefined' || _id < 1) {
        _id  = 0;
      }
      if (typeof _all == 'undefined' || _all.length < 1) {
        _all = 0;
      }

      _url = _url.replace('{:id}', _id);
      _url = _url.replace('{:all}', _all);

      $('#gather_modal iframe').attr('src', _url);
    }).on('hidden.bs.modal', function(){
      $('#gather_modal #gather_modal_icon').attr('class', 'bg-icon text-info');
      $('#gather_modal #gather_modal_icon').html('<span class="spinner-grow spinner-grow-sm"></span>');
      $('#gather_modal #gather_modal_msg').attr('class', 'text-info');
      $('#gather_modal #gather_modal_msg').text('<?php echo $lang->get('Grabbing'); ?>');
      $('#gather_modal iframe').attr('src', '');
    });

    var obj_query = $('#gsite_search').baigoQuery();

    $('#gsite_search').submit(function(){
      obj_query.formSubmit();
    });
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
