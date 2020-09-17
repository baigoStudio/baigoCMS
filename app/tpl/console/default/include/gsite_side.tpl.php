            <div class="col-xl-3">
                <div class="card bg-light">
                    <?php if ($gsiteRow['gsite_id'] > 0 && $route_orig['act'] != 'show') { ?>
                        <div class="list-group list-group-flush">
                            <a href="<?php echo $route_console; ?>gsite/form/id/<?php echo $gsiteRow['gsite_id']; ?>/" class="list-group-item list-group-item-action<?php if ($route_orig['act'] == 'form') { ?> active<?php } ?>">
                                <span class="fas fa-pen fa-fw"></span>
                                <?php echo $lang->get('Edit'); ?>
                            </a>
                            <a href="<?php echo $route_console; ?>gsite-step/lists/id/<?php echo $gsiteRow['gsite_id']; ?>/" class="list-group-item list-group-item-action<?php if ($route_orig['act'] == 'lists') { ?> active<?php } ?>">
                                <span class="fas fa-list fa-fw"></span>
                                <?php echo $lang->get('List settings'); ?>
                            </a>
                            <a href="<?php echo $route_console; ?>gsite-step/content/id/<?php echo $gsiteRow['gsite_id']; ?>/" class="list-group-item list-group-item-action<?php if ($route_orig['act'] == 'content') { ?> active<?php } ?>">
                                <span class="fas fa-file fa-fw"></span>
                                <?php echo $lang->get('Content settings'); ?>
                            </a>
                            <a href="<?php echo $route_console; ?>gsite-step/page-lists/id/<?php echo $gsiteRow['gsite_id']; ?>/" class="list-group-item list-group-item-action<?php if ($route_orig['act'] == 'page-lists') { ?> active<?php } ?>">
                                <span class="fas fa-ellipsis-h fa-fw"></span>
                                <?php echo $lang->get('Paging list settings'); ?>
                            </a>
                            <a href="<?php echo $route_console; ?>gsite-step/page-content/id/<?php echo $gsiteRow['gsite_id']; ?>/" class="list-group-item list-group-item-action<?php if ($route_orig['act'] == 'page-content') { ?> active<?php } ?>">
                                <span class="fas fa-scroll fa-fw"></span>
                                <?php echo $lang->get('Paging content settings'); ?>
                            </a>
                        </div>
                    <?php } ?>
                    <div class="card-body">
                        <?php if ($gsiteRow['gsite_id'] > 0) { ?>
                            <div class="form-group">
                                <label><?php echo $lang->get('ID'); ?></label>
                                <div class="form-text"><?php echo $gsiteRow['gsite_id']; ?></div>
                            </div>
                        <?php }

                        if ($route_orig['act'] != 'form') { ?>
                            <div class="form-group">
                                <label><?php echo $lang->get('Status'); ?></label>
                                <div class="form-text">
                                    <?php $str_status = $gsiteRow['gsite_status'];
                                    include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('Name'); ?></label>
                                <div class="form-text"><?php echo $gsiteRow['gsite_name']; ?></div>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('Note'); ?></label>
                                <div class="form-text"><?php echo $gsiteRow['gsite_note']; ?></div>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('Belong to category'); ?></label>
                                <div class="form-text">
                                    <?php if (isset($cateRow['cate_name'])) {
                                        echo $cateRow['cate_name'];
                                    } ?>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="form-group">
                                <label><?php echo $lang->get('Belong to category'); ?> <span class="text-danger">*</span></label>
                                <select name="gsite_cate_id" id="gsite_cate_id" class="form-control">
                                    <option value=""><?php echo $lang->get('Please select'); ?></option>
                                    <?php $check_id = $gsiteRow['gsite_cate_id'];
                                    include($cfg['pathInclude'] . 'cate_list_option' . GK_EXT_TPL); ?>
                                </select>
                                <small class="form-text" id="msg_gsite_cate_id"></small>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('Status'); ?> <span class="text-danger">*</span></label>
                                <div>
                                    <?php foreach ($status as $key=>$value) { ?>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="gsite_status" id="gsite_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($gsiteRow['gsite_status'] == $value) { ?>checked<?php } ?> class="form-check-input">
                                            <label for="gsite_status_<?php echo $value; ?>" class="form-check-label">
                                                <?php echo $lang->get($value); ?>
                                            </label>
                                        </div>
                                    <?php } ?>
                                </div>
                                <small class="form-text" id="msg_gsite_status"></small>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>