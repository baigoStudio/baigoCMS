<?php $cfg = array(
    'title'             => $lang->get('Category', 'console.common') . ' &raquo; ' . $lang->get('Show'),
    'menu_active'       => 'cate',
    'sub_active'        => 'index',
    'baigoSubmit'       => 'true',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>cate/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <form name="cate_form" id="cate_form" action="<?php echo $route_console; ?>cate/duplicate/">
        <input type="hidden" name="__token__" value="<?php echo $token; ?>">
        <input type="hidden" name="cate_id" id="cate_id" value="<?php echo $cateRow['cate_id']; ?>">

        <div class="row">
            <div class="col-xl-9">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $lang->get('Name'); ?></label>
                            <div class="form-text"><?php echo $cateRow['cate_name']; ?></div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Alias'); ?></label>
                            <div class="form-text"><?php echo $cateRow['cate_alias']; ?></div>
                            <small class="form-text"><?php echo $lang->get('Usually used to build URLs'); ?></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Count of per page'); ?></label>
                            <div class="form-text"><?php echo $cateRow['cate_perpage']; ?></div>
                        </div>

                        <?php if ($cateRow['cate_parent_id'] < 1) { ?>
                            <div class="form-group">
                                <label><?php echo $lang->get('URL Prefix'); ?></label>
                                <div class="form-text"><?php echo $cateRow['cate_prefix']; ?></div>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label><?php echo $lang->get('Content'); ?></label>
                            <div class="form-text"><?php echo $cateRow['cate_content']; ?></div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Jump to'); ?></label>
                            <div class="form-text"><?php echo $cateRow['cate_link']; ?></div>
                        </div>

                        <?php if (isset($ftp_open) && $cateRow['cate_parent_id'] < 1) { ?>
                            <div class="form-group">
                                <label><?php echo $lang->get('FTP Host'); ?></label>
                                <div class="form-text"><?php echo $cateRow['cate_ftp_host']; ?></div>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('Host port'); ?></label>
                                <div class="form-text"><?php echo $cateRow['cate_ftp_port']; ?></div>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('Username'); ?></label>
                                <div class="form-text"><?php echo $cateRow['cate_ftp_user']; ?></div>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('Password'); ?></label>
                                <div class="form-text"><?php echo $cateRow['cate_ftp_pass']; ?></div>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('Remote path'); ?></label>
                                <div class="form-text"><?php echo $cateRow['cate_ftp_path']; ?></div>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" <?php if ($cateRow['cate_ftp_pasv'] === 'on') { ?>checked<?php } ?> class="custom-control-input" disabled>
                                    <label for="cate_ftp_pasv" class="custom-control-label">
                                        <?php echo $lang->get('Passive mode'); ?>
                                    </label>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <?php echo $lang->get('Duplicate'); ?>
                            </button>

                            <a href="<?php echo $route_console; ?>cate/form/id/<?php echo $cateRow['cate_id']; ?>/">
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
                            <div class="form-text"><?php echo $cateRow['cate_id']; ?></div>
                        </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('Parent category'); ?></label>
                                <div class="form-text"><?php if (isset($cateParent['cate_name'])) {
                                    echo $cateParent['cate_name'];
                                } else {
                                    echo $lang->get('As a primary category');
                                } ?></div>
                            </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Template'); ?></label>
                            <div class="form-text"><?php echo $lang->get($cateRow['cate_tpl']); ?></div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Status'); ?></label>
                            <div class="form-text">
                                <?php $str_status = $cateRow['cate_status'];
                                include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="<?php echo $route_console; ?>cate/form/id/<?php echo $cateRow['cate_id']; ?>/">
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
        var obj_submit_form     = $('#cate_form').baigoSubmit(opts_submit_form);

        $('#cate_form').submit(function(){
            obj_submit_form.formSubmit();
        });
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);