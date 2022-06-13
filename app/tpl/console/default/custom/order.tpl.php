<?php $cfg = array(
  'title'         => $lang->get('Custom fields', 'console.common') . ' &raquo; ' . $lang->get('Sort'),
  'menu_active'   => 'article',
  'sub_active'    => 'custom',
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

  <form name="custom_order" id="custom_order" action="<?php echo $hrefRow['order-submit']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">

    <div class="card">
      <div class="card-header">
        <?php if (isset($customRow['custom_name'])) {
          echo $customRow['custom_name'];
        } else {
          echo $lang->get('Primary field');
        } ?>
      </div>
      <div class="card-body">
        <div class="bg-drag">
          <?php foreach ($customRows as $key=>$value) { ?>
            <div class="alert alert-secondary" data-id="<?php echo $value['custom_id']; ?>">
               <input type="hidden" name="custom_orders[<?php echo $value['custom_id']; ?>]" id="custom_order_<?php echo $value['custom_id']; ?>" value="<?php echo $value['custom_order']; ?>">

               <div class="d-flex justify-content-between">
                <ul class="list-inline mb-0 flex-fill bg-cursor-move">
                  <li class="list-inline-item">
                    <span class="bg-icon fa-fw"><?php include($tpl_icon . 'ellipsis-v' . BG_EXT_SVG); ?></span>
                  </li>
                  <li class="list-inline-item">
                    <?php echo $lang->get('ID'), ': ', $value['custom_id']; ?>
                  </li>
                  <li class="list-inline-item">
                    <?php echo $lang->get('Name'), ': ';

                    if (empty($value['custom_name'])) {
                      echo $lang->get('Unnamed');
                    } else {
                      echo $value['custom_name'];
                    } ?>
                  </li>
                </ul>
                <span>
                  <?php $str_status = $value['custom_status'];
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
      $('#custom_order_' + _id).val(_key);
    });
  }

  $(document).ready(function(){
    $('.bg-drag').dad({
      draggable: '.alert',
      cloneClass: 'bg-dad-clone',
      placeholderClass: 'bg-dad-placeholder'
    });

    var obj_submit_list = $('#custom_order').baigoSubmit(opts_submit);

    $('#custom_order').submit(function(){
      sortProcess();
      obj_submit_list.formSubmit();
    });
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
