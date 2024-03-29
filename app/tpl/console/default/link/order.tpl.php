<?php $cfg = array(
  'title'         => $lang->get('Link', 'console.common') . ' &raquo; ' . $lang->get('Sort'),
  'menu_active'   => 'link',
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

  <form name="link_order" id="link_order" action="<?php echo $hrefRow['order-submit']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">

    <div class="card">
      <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
          <?php foreach ($type as $key=>$value) { ?>
            <li class="nav-item">
              <a class="nav-link<?php if ($search['type'] == $value) { ?> active<?php } ?>" href="<?php echo $hrefRow['order'], $value; ?>">
                <?php echo $lang->get($value); ?>
              </a>
            </li>
          <?php } ?>
        </ul>
      </div>
      <div class="card-body">
        <div class="bg-drag">
          <?php foreach ($linkRows as $key=>$value) { ?>
            <div class="alert alert-secondary" data-id="<?php echo $value['link_id']; ?>">
               <input type="hidden" name="link_orders[<?php echo $value['link_id']; ?>]" id="link_order_<?php echo $value['link_id']; ?>" value="<?php echo $value['link_order']; ?>">

               <div class="d-flex justify-content-between">
                <ul class="list-inline mb-0 flex-fill bg-cursor-move">
                  <li class="list-inline-item">
                    <span class="bg-icon fa-fw"><?php include($tpl_icon . 'ellipsis-v' . BG_EXT_SVG); ?></span>
                  </li>
                  <li class="list-inline-item">
                    <?php echo $lang->get('ID'), ': ', $value['link_id']; ?>
                  </li>
                  <li class="list-inline-item">
                    <?php echo $lang->get('Name'), ': ';

                    if (empty($value['link_name'])) {
                      echo $lang->get('Unnamed');
                    } else {
                      echo $value['link_name'];
                    } ?>
                  </li>
                </ul>
                <span>
                  <?php $str_status = $value['link_status'];
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
      $('#link_order_' + _id).val(_key);
    });
  }

  $(document).ready(function(){
    $('.bg-drag').dad({
      draggable: '.alert',
      cloneClass: 'bg-dad-clone',
      placeholderClass: 'bg-dad-placeholder'
    });

    var obj_submit_list = $('#link_order').baigoSubmit(opts_submit);

    $('#link_order').submit(function(){
      sortProcess();
      obj_submit_list.formSubmit();
    });
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
