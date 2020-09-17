<?php $cfg = array(
    'title'         => $lang->get('Category', 'console.common') . ' &raquo; ' . $lang->get('Sort'),
    'menu_active'   => 'cate',
    'sub_active'    => 'index',
    'baigoSubmit'   => 'true',
    'dad'           => 'true',
    'pathInclude'   => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>cate/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <form name="cate_order" id="cate_order" action="<?php echo $route_console; ?>cate/order-submit/">
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
                        <div class="drag drag-box alert alert-secondary" data-id="<?php echo $value['cate_id']; ?>">
                             <input type="hidden" name="cate_orders[<?php echo $value['cate_id']; ?>]" id="cate_order_<?php echo $value['cate_id']; ?>" value="<?php echo $value['cate_order']; ?>">

                             <div class="d-flex justify-content-between">
                                <ul class="list-inline mb-0">
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
                                    include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?>
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

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL); ?>

    <script type="text/javascript">
    var opts_submit_list = {
        modal: {
            btn_text: {
                close: '<?php echo $lang->get('Close'); ?>',
                ok: '<?php echo $lang->get('OK'); ?>'
            }
        },
        msg_text: {
            submitting: '<?php echo $lang->get('Submitting'); ?>'
        }
    };

    function sortProcess() {
        $('.bg-drag > .dads-children').each(function(_key, _value){
            var _id  = $(this).data('id');
            $('#cate_order_' + _id).val(_key);
        });
    }

    $(document).ready(function(){
        $('.bg-drag').dad({
            target: '.drag-box',
            callback: function(ele) {
                sortProcess();
            }
        });

        var obj_submit_list     = $('#cate_order').baigoSubmit(opts_submit_list);

        $('#cate_order').submit(function(){
            obj_submit_list.formSubmit();
        });
    });
    </script>
<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);