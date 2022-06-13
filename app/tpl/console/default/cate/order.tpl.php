<?php $cfg = array(
  'title'         => $lang->get('Category', 'console.common') . ' &raquo; ' . $lang->get('Sort'),
  'menu_active'   => 'cate',
  'sub_active'    => 'index',
  'baigoSubmit'   => 'true',
  'dad'           => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <nav class="nav mb-3">
    <a href="<?php echo $hrefRow['index']; ?>" class="nav-link">
      <span class="bg-icon"><?php include($tpl_icon . 'chevron-left' . BG_EXT_SVG); ?></span>
      <?php echo $lang->get('Back'); ?>
    </a>
  </nav>

  <form name="cate_order" id="cate_order" action="<?php echo $hrefRow['order-submit']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">

    <div class="card">
      <div class="card-header">
        <?php if (isset($cateRow['cate_name'])) {
          echo $cateRow['cate_name'];
        } else {
          echo $lang->get('Primary category');
        } ?>
      </div>
      <div class="card-body">
        <div class="bg-drag">
          <?php foreach ($cateRows as $key=>$value) { ?>
            <div class="alert alert-secondary" data-id="<?php echo $value['cate_id']; ?>">
               <input type="hidden" name="cate_orders[<?php echo $value['cate_id']; ?>]" id="cate_order_<?php echo $value['cate_id']; ?>" value="<?php echo $value['cate_order']; ?>">

               <div class="d-flex justify-content-between">
                <ul class="list-inline mb-0 flex-fill bg-cursor-move">
                  <li class="list-inline-item">
                    <span class="bg-icon fa-fw"><?php include($tpl_icon . 'ellipsis-v' . BG_EXT_SVG); ?></span>
                  </li>
                  <li class="list-inline-item">
                    <?php echo $lang->get('ID'), ': ', $value['cate_id']; ?>
                  </li>
                  <li class="list-inline-item">
                    <?php echo $lang->get('Name'), ': ';

                    if (empty($value['cate_name'])) {
                      echo $lang->get('Unnamed');
                    } else {
                      echo $value['cate_name'];
                    } ?>
                  </li>
                </ul>
                <span>
                  <?php $str_status = $value['cate_status'];
                  include($tpl_include . 'status_process' . GK_EXT_TPL); ?>
                </span>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">
          <?php echo $lang->get('Apply'); ?>
        </button>
      </div>
    </div>
  </form>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  function sortProcess() {
    $('.bg-drag > .alert').each(function(_key, _value){
      var _id  = $(this).data('id');
      $('#cate_order_' + _id).val(_key);
    });
  }

  $(document).ready(function(){
    $('.bg-drag').dad({
      draggable: '.alert',
      cloneClass: 'bg-dad-clone',
      placeholderClass: 'bg-dad-placeholder'
    });

    var obj_submit_list     = $('#cate_order').baigoSubmit(opts_submit);

    $('#cate_order').submit(function(){
      sortProcess();
      obj_submit_list.formSubmit();
    });
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
