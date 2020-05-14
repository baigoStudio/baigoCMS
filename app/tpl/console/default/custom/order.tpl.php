<?php $cfg = array(
    'title'         => $lang->get('Custom fields', 'console.common') . ' &raquo; ' . $lang->get('Sort'),
    'menu_active'   => 'article',
    'sub_active'    => 'custom',
    'baigoSubmit'   => 'true',
    'dad'           => 'true',
    'pathInclude'   => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>custom/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <form name="custom_order" id="custom_order" action="<?php echo $route_console; ?>custom/order-submit/">
        <input type="hidden" name="__token__" value="<?php echo $token; ?>">

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
                        <div class="drag drag-box alert alert-secondary" data-id="<?php echo $value['custom_id']; ?>">
                             <input type="hidden" name="custom_orders[<?php echo $value['custom_id']; ?>]" id="custom_order_<?php echo $value['custom_id']; ?>" value="<?php echo $value['custom_order']; ?>">

                             <div class="d-flex justify-content-between">
                                <ul class="list-inline mb-0">
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
            $('#custom_order_' + _id).val(_key);
        });
    }

    $(document).ready(function(){
        $('.bg-drag').dad({
            target: '.drag-box',
            callback: function(ele) {
                sortProcess();
            }
        });

        var obj_submit_list = $('#custom_order').baigoSubmit(opts_submit_list);

        $('#custom_order').submit(function(){
            obj_submit_list.formSubmit();
        });
    });
    </script>
<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);