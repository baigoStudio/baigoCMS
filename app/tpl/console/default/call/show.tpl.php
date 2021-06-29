<?php $cfg = array(
    'title'             => $lang->get('Call', 'console.common') . ' &raquo; ' . $lang->get('Show'),
    'menu_active'       => 'call',
    'sub_active'        => 'index',
    'baigoSubmit'       => 'true',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>call/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <form name="call_form" id="call_form" action="<?php echo $route_console; ?>call/duplicate/">
        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
        <input type="hidden" name="call_id" id="call_id" value="<?php echo $callRow['call_id']; ?>">

        <div class="row">
            <div class="col-xl-9">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $lang->get('Suggested calling code'); ?></label>
                            <div class="form-text">
                                <code>
                                    <?php echo $callRow['call_code']; ?>
                                </code>
                            </div>
                        </div>

                        <?php if ($gen_open === true) { ?>
                            <div class="form-group">
                                <label><?php echo $lang->get('URL'); ?></label>
                                <div class="form-text">
                                    <code>
                                        <?php echo $callRow['call_url']; ?>
                                    </code>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('Path'); ?></label>
                                <div class="form-text">
                                    <code>
                                        <?php echo $callRow['call_path']; ?>
                                    </code>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label><?php echo $lang->get('Name'); ?></label>
                            <div class="form-text"><?php echo $callRow['call_name']; ?></div>
                        </div>

                        <?php if ($callRow['call_type'] == 'cate') {
                            if ($callRow['call_cate_id'] < 1) {
                                $_str_color = 'primary';
                                $_str_icon  = 'check';
                            } else {
                                $_str_color = 'muted';
                                $_str_icon  = 'times';
                            } ?>
                            <div class="alert alert-success">
                                <span class="fas fa-filter"></span>
                                <?php echo $lang->get('Filter'); ?>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('Category'); ?></label>
                                <div class="form-text text-<?php echo $_str_color; ?>">
                                    <span class="fas fa-<?php echo $_str_icon; ?>-circle"></span>
                                    <?php echo $lang->get('All categories'); ?>
                                </div>
                                <table class="bg-table">
                                    <tbody>
                                        <?php $cate_id = $callRow['call_cate_id'];
                                        $cate_excepts = $callRow['call_cate_excepts'];
                                        //$lang = $callRow['call_cate_excepts'];
                                        $is_edit = false;
                                        include($cfg['pathInclude'] . 'cate_list_radio' . GK_EXT_TPL); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else if ($callRow['call_type'] != 'spec' && $callRow['call_type'] != 'tag_list' && $callRow['call_type'] != 'tag_rank' && $callRow['call_type'] != 'link') { ?>
                            <div class="alert alert-success">
                                <span class="fas fa-filter"></span>
                                <?php echo $lang->get('Filter'); ?>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('Category'); ?></label>
                                <table class="bg-table">
                                    <tbody>
                                        <?php $cate_ids = $callRow['call_cate_ids'];
                                        $is_edit = false;
                                        include($cfg['pathInclude'] . 'cate_list_checkbox' . GK_EXT_TPL); ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('Special topic'); ?></label>
                                <div>
                                    <?php foreach ($specRows as $key=>$value) { ?>
                                        <div class="input-group mb-2" id="spec_item_<?php echo $value['spec_id']; ?>">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text border-success">
                                                    <span class="fas fa-check-circle text-primary"></span>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control border-success bg-transparent" readonly value="<?php echo $value['spec_name']; ?>">
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('With pictures'); ?></label>
                                <div class="form-text">
                                    <?php echo $lang->get($callRow['call_attach']); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('Mark'); ?></label>
                                <div class="form-text">
                                    <?php foreach ($markRows as $key=>$value) {
                                        if (in_array($value['mark_id'], $callRow['call_mark_ids'])) {
                                            $_str_color = 'primary';
                                            $_str_icon  = 'check';
                                        } else {
                                            $_str_color = 'muted';
                                            $_str_icon  = 'times';
                                        } ?>
                                        <div class="text-<?php echo $_str_color; ?>">
                                            <span class="fas fa-<?php echo $_str_icon; ?>-circle"></span>
                                            <?php echo $value['mark_name']; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <?php echo $lang->get('Duplicate'); ?>
                            </button>

                            <a href="<?php echo $route_console; ?>call/form/id/<?php echo $callRow['call_id']; ?>/">
                                <span class="fas fa-edit"></span>
                                <?php echo $lang->get('Edit'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="card bg-light">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $lang->get('ID'); ?></label>
                            <div class="form-text"><?php echo $callRow['call_id']; ?></div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Status'); ?></label>
                            <div class="form-text">
                                <?php echo $lang->get($callRow['call_status']); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Type'); ?></label>
                            <div class="form-text">
                                <?php echo $lang->get($callRow['call_type']); ?>
                            </div>
                        </div>

                        <?php if ($gen_open === true) { ?>
                            <div class="form-group">
                                <label><?php echo $lang->get('Type of generate file'); ?></label>
                                <div class="form-text">
                                    <?php echo $callRow['call_file']; ?>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label><?php echo $lang->get('Amount of display'); ?></label>

                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <?php echo $lang->get('Top'); ?>
                                    </div>
                                </div>
                                <input type="text" value="<?php echo $callRow['call_amount']['top']; ?>" class="form-control" readonly>
                            </div>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <?php echo $lang->get('Except top'); ?>
                                    </div>
                                </div>
                                <input type="text" value="<?php echo $callRow['call_amount']['except']; ?>" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="<?php echo $route_console; ?>call/form/id/<?php echo $callRow['call_id']; ?>/">
                            <span class="fas fa-edit"></span>
                            <?php echo $lang->get('Edit'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL); ?>

    <script type="text/javascript">
    var opts_submit_form = {
        modal: {
            btn_text: {
                close: '<?php echo $lang->get('Close'); ?>',
                ok: '<?php echo $lang->get('OK'); ?>'
            }
        },
        msg_text: {
            submitting: '<?php echo $lang->get('Saving'); ?>'
        }
    };

    $(document).ready(function(){
        var obj_submit_form     = $('#call_form').baigoSubmit(opts_submit_form);

        $('#call_form').submit(function(){
            obj_submit_form.formSubmit();
        });
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);
