                        <div class="form-group">
                            <label><?php echo $lang->get('Path'); ?></label>
                            <div>
                                <img src="{:DIR_STATIC}image/loading.gif" data-src="<?php echo $attachRow['attach_url']; ?>" data-toggle="async" alt="<?php echo $value['attach_name']; ?>" class="img-fluid">
                            </div>

                            <div>
                                <a href="<?php echo $attachRow['attach_url']; ?>" target="_blank" data-toggle="tooltip" data-placement="bottom" title="<?php echo $attachRow['attach_path']; ?>">
                                    <?php echo $attachRow['attach_url']; ?>
                                </a>
                                <?php $str_status = $attachRow['attach_exists'];
                                include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?>
                            </div>
                        </div>

                        <?php if ($attachRow['attach_type'] == 'image') { ?>
                            <div class="form-group">
                                <label><?php echo $lang->get('Thumbnail'); ?></label>
                                <ul class="list-unstyled">
                                    <?php foreach ($attachRow['thumbRows'] as $key_thumb=>$value_thumb) { ?>
                                        <li class="media mb-3">
                                            <img src="{:DIR_STATIC}image/loading.gif" data-src="<?php echo $value_thumb['thumb_url']; ?>" data-toggle="async" alt="<?php echo $value['attach_name']; ?>" class="mr-3" width="60">

                                            <div class="media-body">
                                                <h6><?php echo $value_thumb['thumb_width'], ' x ', $value_thumb['thumb_height'], ' ', $lang->get($value_thumb['thumb_type']); ?></h6>
                                                <a href="<?php echo $value_thumb['thumb_url']; ?>" target="_blank" data-toggle="tooltip" data-placement="bottom" title="<?php echo $value_thumb['thumb_path']; ?>" class="text-wrap text-break">
                                                    <?php echo $value_thumb['thumb_url']; ?>
                                                </a>
                                                <?php $str_status = $value_thumb['thumb_exists'];
                                                include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>

                        <form name="attach_fix" id="attach_fix" action="<?php echo $route_console; ?>attach/fix/">
                            <input type="hidden" name="__token__" value="<?php echo $token; ?>">
                            <input type="hidden" name="attach_id" id="attach_id" value="<?php echo $attachRow['attach_id']; ?>">

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <span class="fas fa-redo-alt"></span>
                                    <?php echo $lang->get('Fix it'); ?>
                                </button>
                                <small class="form-text"><?php echo $lang->get('If the path or thumbnail is not found, you can try to fix it.'); ?></small>
                            </div>
                        </form>

                        <script type="text/javascript">
                        var opts_submit_fix = {
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

                        $(document).ready(function(){
                            var obj_submit_fix = $('#attach_fix').baigoSubmit(opts_submit_fix);

                            $('#attach_fix').submit(function(){
                                obj_submit_fix.formSubmit();
                            });
                        });
                        </script>

                        <div class="form-group">
                            <label><?php echo $lang->get('Size'); ?></label>
                            <div class="form-text"><?php echo $attachRow['attach_size_format']; ?></div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Time'); ?></label>
                            <div class="form-text"><?php echo $attachRow['attach_time_format']['date_time']; ?></div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Administrator'); ?></label>
                            <div class="form-text">
                                <?php if (isset($adminRow['admin_name'])) { ?>
                                    <a href="<?php echo $route_console; ?>admin/show/id/<?php echo $attachRow['attach_admin_id']; ?>/" target="_blank"><?php echo $adminRow['admin_name']; ?></a>
                                <?php } else {
                                    echo $lang->get('Unknown');
                                } ?>
                            </div>
                        </div>