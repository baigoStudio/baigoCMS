<?php if ($cateRow['cate_id'] > 0) {
    $title_sub    = $lang->get('Edit');
    $str_sub      = 'index';
} else {
    $title_sub    = $lang->get('Add');
    $str_sub      = 'form';
}

$cfg = array(
    'title'             => $lang->get('Category', 'console.common') . ' &raquo; ' . $title_sub,
    'menu_active'       => 'cate',
    'sub_active'        => $str_sub,
    'baigoValidate'     => 'true',
    'baigoSubmit'       => 'true',
    'tinymce'           => 'true',
    'upload'            => 'true',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>cate/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <form name="cate_form" id="cate_form" action="<?php echo $route_console; ?>cate/submit/">
        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
        <input type="hidden" name="cate_id" id="cate_id" value="<?php echo $cateRow['cate_id']; ?>">

        <div class="row">
            <div class="col-xl-9">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $lang->get('Name'); ?> <span class="text-danger">*</span></label>
                            <input type="text" name="cate_name" id="cate_name" value="<?php echo $cateRow['cate_name']; ?>" class="form-control">
                            <small class="form-text" id="msg_cate_name"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Alias'); ?></label>
                            <input type="text" name="cate_alias" id="cate_alias" value="<?php echo $cateRow['cate_alias']; ?>" class="form-control">
                            <small class="form-text" id="msg_cate_alias"><?php echo $lang->get('Usually used to build URLs'); ?></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Count of per page'); ?></label>
                            <input type="text" name="cate_perpage" id="cate_perpage" value="<?php echo $cateRow['cate_perpage']; ?>" class="form-control">
                            <small class="form-text" id="msg_cate_perpage"><?php echo $lang->get('<kbd>0</kbd> is inherit'); ?></small>
                        </div>

                        <?php if ($cateRow['cate_parent_id'] < 1) { ?>
                            <div class="form-group">
                                <label><?php echo $lang->get('URL Prefix'); ?></label>
                                <input type="text" name="cate_prefix" id="cate_prefix" value="<?php echo $cateRow['cate_prefix']; ?>" class="form-control">
                                <small class="form-text" id="msg_cate_prefix"><?php echo $lang->get('Do not add a slash <kbd>/</kbd> at the end'); ?></small>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label><?php echo $lang->get('Content'); ?></label>
                            <div class="mb-2">
                                <div class="btn-group btn-group-sm">
                                    <a class="btn btn-outline-success" data-toggle="modal" href="#cate_modal" data-act="attach">
                                        <span class="fas fa-photo-video"></span>
                                        <?php echo $lang->get('Add media'); ?>
                                    </a>
                                    <a class="btn btn-outline-secondary" data-toggle="modal" href="#cate_modal" data-act="album">
                                        <span class="fas fa-images"></span>
                                        <?php echo $lang->get('Add album'); ?>
                                    </a>
                                    <?php if ($cateRow['cate_id'] > 0) { ?>
                                        <a href="<?php echo $route_console; ?>cate/attach/id/<?php echo $cateRow['cate_id']; ?>/" class="btn btn-outline-secondary">
                                            <?php echo $lang->get('Cover management'); ?>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                            <textarea name="cate_content" id="cate_content" class="form-control tinymce"><?php echo $cateRow['cate_content']; ?></textarea>
                        </div>

                        <div class="bg-validate-box"></div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $lang->get('Save'); ?>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="card bg-light">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item">
                            <?php if ($cateRow['cate_id'] > 0) { ?>
                                <div class="form-group">
                                    <label><?php echo $lang->get('ID'); ?></label>
                                    <input type="text" value="<?php echo $cateRow['cate_id']; ?>" class="form-control-plaintext" readonly>
                                </div>
                            <?php } ?>

                            <div class="form-group">
                                <label><?php echo $lang->get('Status'); ?> <span class="text-danger">*</span></label>
                                <?php foreach ($status as $key=>$value) { ?>
                                    <div class="form-check">
                                        <input type="radio" name="cate_status" id="cate_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($cateRow['cate_status'] == $value) { ?>checked<?php } ?> class="form-check-input">
                                        <label for="cate_status_<?php echo $value; ?>" class="form-check-label">
                                            <?php echo $lang->get($value); ?>
                                        </label>
                                    </div>
                                <?php } ?>
                                <small class="form-text" id="msg_cate_status"></small>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('Parent category'); ?> <span class="text-danger">*</span></label>
                                <select name="cate_parent_id" id="cate_parent_id" class="form-control">
                                    <option value=""><?php echo $lang->get('Please select'); ?></option>
                                    <option <?php if ($cateRow['cate_parent_id'] == 0) { ?>selected<?php } ?> value="0"><?php echo $lang->get('As a primary category'); ?></option>
                                    <?php $check_id = $cateRow['cate_parent_id'];
                                    $disabled_id = $cateRow['cate_id'];
                                    include($cfg['pathInclude'] . 'cate_list_option' . GK_EXT_TPL); ?>
                                </select>
                                <small class="form-text" id="msg_cate_parent_id"></small>
                            </div>

                            <div class="form-group">
                                <label><?php echo $lang->get('Template'); ?> <span class="text-danger">*</span></label>
                                <select name="cate_tpl" id="cate_tpl" class="form-control">
                                    <option value=""><?php echo $lang->get('Please select'); ?></option>
                                    <option <?php if (isset($cateRow['cate_tpl']) && $cateRow['cate_tpl'] == '-1') { ?>selected<?php } ?> value="-1"><?php echo $lang->get('Inherit'); ?></option>
                                    <?php foreach ($tplRows as $key=>$value) {
                                        if ($value['type'] == 'dir') { ?>
                                            <option <?php if (isset($cateRow['cate_tpl']) && $cateRow['cate_tpl'] == $value['name']) { ?>selected<?php } ?> value="<?php echo $value['name']; ?>"><?php echo $value['name']; ?></option>
                                        <?php }
                                    } ?>
                                </select>
                                <small class="form-text" id="msg_cate_tpl"></small>
                            </div>
                        </div>

                        <a class="list-group-item list-group-item-action bg-light d-flex justify-content-between align-items-center" data-toggle="collapse" href="#bg-form-cover">
                            <span><?php echo $lang->get('Cover'); ?></span>
                            <small class="fas fa-chevron-down" id="bg-caret-form-cover"></small>
                        </a>

                        <div id="bg-form-cover" data-key="cover" class="list-group-item collapse">
                            <div class="form-group">
                                <div id="cate_attach_img" class="mb-2">
                                    <?php if (isset($attachRow['attach_thumb']) && !empty($attachRow['attach_thumb'])) { ?>
                                        <img src="<?php echo $attachRow['attach_thumb']; ?>" class="img-fluid">
                                    <?php } ?>
                                </div>

                                <div class="input-group mb-3">
                                    <input type="text" id="cate_attach_src" readonly value="<?php if (isset($attachRow['attach_thumb'])) { echo $attachRow['attach_thumb']; } ?>" class="form-control">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary" data-toggle="modal" href="#cate_modal" data-id="<?php echo $cateRow['cate_id']; ?>" data-act="cover">
                                            <span class="fas fa-image"></span>
                                            <?php echo $lang->get('Select'); ?>
                                        </button>
                                    </div>
                                </div>

                                <input type="hidden" name="cate_attach_id" id="cate_attach_id" value="<?php echo $cateRow['cate_attach_id']; ?>">
                            </div>
                        </div>

                        <?php if ($gen_open === true && isset($ftp_open) && $cateRow['cate_parent_id'] < 1) { ?>
                            <div class="list-group list-group-flush">
                                <a class="list-group-item list-group-item-action bg-light d-flex justify-content-between align-items-center" data-toggle="collapse" href="#bg-form-ftp">
                                    <span>
                                        <?php echo $lang->get('FTP Issue'); ?>
                                    </span>
                                    <small class="fas fa-chevron-<?php if (!empty($cateRow['cate_ftp_host'])) { ?>up<?php } else { ?>down<?php } ?>" id="bg-caret-form-ftp"></small>
                                </a>

                                <div id="bg-form-ftp" data-key="ftp" class="list-group-item collapse<?php if (!empty($cateRow['cate_ftp_host'])) { ?> show<?php } ?>">
                                    <div class="form-group">
                                        <label><?php echo $lang->get('FTP Host'); ?></label>
                                        <input type="text" name="cate_ftp_host" id="cate_ftp_host" value="<?php echo $cateRow['cate_ftp_host']; ?>" class="form-control">
                                        <small class="form-text" id="msg_cate_ftp_host"></small>
                                    </div>

                                    <div class="form-group">
                                        <label><?php echo $lang->get('Host port'); ?></label>
                                        <input type="text" name="cate_ftp_port" id="cate_ftp_port" value="<?php echo $cateRow['cate_ftp_port']; ?>" class="form-control">
                                        <small class="form-text" id="msg_cate_ftp_port"></small>
                                    </div>

                                    <div class="form-group">
                                        <label><?php echo $lang->get('Username'); ?></label>
                                        <input type="text" name="cate_ftp_user" id="cate_ftp_user" value="<?php echo $cateRow['cate_ftp_user']; ?>" class="form-control">
                                        <small class="form-text" id="msg_cate_ftp_user"></small>
                                    </div>

                                    <div class="form-group">
                                        <label><?php echo $lang->get('Password'); ?></label>
                                        <input type="text" name="cate_ftp_pass" id="cate_ftp_pass" value="<?php echo $cateRow['cate_ftp_pass']; ?>" class="form-control">
                                        <small class="form-text" id="msg_cate_ftp_pass"></small>
                                    </div>

                                    <div class="form-group">
                                        <label><?php echo $lang->get('Remote path'); ?></label>
                                        <input type="text" name="cate_ftp_path" id="cate_ftp_path" value="<?php echo $cateRow['cate_ftp_path']; ?>" class="form-control">
                                        <small class="form-text" id="msg_cate_ftp_path"><?php echo $lang->get('Do not add a slash <kbd>/</kbd> at the end'); ?></small>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" name="cate_ftp_pasv" id="cate_ftp_pasv" value="on" <?php if ($cateRow['cate_ftp_pasv'] === 'on') { ?>checked<?php } ?> class="custom-control-input">
                                            <label for="cate_ftp_pasv" class="custom-control-label">
                                                <?php echo $lang->get('Passive mode'); ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <a class="list-group-item list-group-item-action bg-light d-flex justify-content-between align-items-center" data-toggle="collapse" href="#bg-form-link">
                            <span>
                                <?php echo $lang->get('Jump to'); ?>
                            </span>
                            <small class="fas fa-chevron-<?php if (!empty($cateRow['cate_link'])) { ?>up<?php } else { ?>down<?php } ?>" id="bg-caret-form-link"></small>
                        </a>

                        <div id="bg-form-link" data-key="link" class="list-group-item collapse<?php if (!empty($cateRow['cate_link'])) { ?> show list-group-item-warning<?php } ?>">
                            <textarea type="text" name="cate_link" id="cate_link" class="form-control bg-textarea-sm"><?php echo $cateRow['cate_link']; ?></textarea>
                            <small class="form-text" id="msg_cate_link"></small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $lang->get('Save'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="cate_modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content"></div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL); ?>

    <script type="text/javascript">
    var opts_validate_form = {
        rules: {
            cate_name: {
                length: '1,300'
            },
            cate_alias: {
                max: 300,
                format: 'alpha_dash',
                ajax: {
                    url: '<?php echo $route_console; ?>cate/check/',
                    attach: {
                        selectors: ['#cate_id', '#cate_parent_id'],
                        keys: ['cate_id', 'cate_parent_id']
                    }
                }
            },
            cate_perpage: {
                format: 'int'
            },
            cate_prefix: {
                max: 3000
            },
            cate_link: {
                max: 900
            },
            cate_parent_id: {
                require: true
            },
            cate_tpl: {
                require: true
            },
            cate_status: {
                require: true
            },
            cate_ftp_host: {
                max: 3000
            },
            cate_ftp_port: {
                max: 5
            },
            cate_ftp_user: {
                max: 300
            },
            cate_ftp_path: {
                max: 3000
            }
        },
        attr_names: {
            cate_name: '<?php echo $lang->get('Name'); ?>',
            cate_alias: '<?php echo $lang->get('Alias'); ?>',
            cate_perpage: '<?php echo $lang->get('Count of per page'); ?>',
            cate_prefix: '<?php echo $lang->get('URL Prefix'); ?>',
            cate_link: '<?php echo $lang->get('Jump to'); ?>',
            cate_parent_id: '<?php echo $lang->get('Parent category'); ?>',
            cate_tpl: '<?php echo $lang->get('Template'); ?>',
            cate_status: '<?php echo $lang->get('Status'); ?>',
            cate_ftp_host: '<?php echo $lang->get('FTP Host'); ?>',
            cate_ftp_port: '<?php echo $lang->get('Host port'); ?>',
            cate_ftp_user: '<?php echo $lang->get('Username'); ?>',
            cate_ftp_path: '<?php echo $lang->get('Remote path'); ?>'
        },
        type_msg: {
            require: '<?php echo $lang->get('{:attr} require'); ?>',
            max: '<?php echo $lang->get('Max size of {:attr} must be {:rule}'); ?>',
            length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>'
        },
        format_msg: {
            'int': '<?php echo $lang->get('{:attr} must be integer'); ?>',
            alpha_dash: '<?php echo $lang->get('{:attr} must be alpha-numeric, dash, underscore'); ?>'
        },
        msg: {
            loading: '<?php echo $lang->get('Loading'); ?>'
        },
        box: {
            msg: '<?php echo $lang->get('Input error'); ?>'
        }
    };

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

    function showMore() {
        var _cate_parent = $('#cate_parent_id').val();
        if (_cate_parent < 1) {
            $('#ftp_form').show();
        } else {
            $('#ftp_form').hide();
        }
    }

    $(document).ready(function(){
        showMore();
        $('#cate_parent_id').change(function(){
            showMore();
        });

        $('#cate_modal').on('shown.bs.modal', function(event) {
    		var _obj_button   = $(event.relatedTarget);
    		var _act          = _obj_button.data('act');
            var _id           = _obj_button.data('id');
            var _url          = '<?php echo $route_console; ?>';

    		switch (_act) {
        		case 'album':
            		_url  += 'album/choose/view/modal/';
        		break;

                case 'cover':
                    _url  += 'attach/choose/cate/' + _id + '/target/cate_cover/';
                break;

        		default:
            		_url  += 'attach/choose/view/modal/';
        		break;
            }

            $('#cate_modal .modal-content').load(_url);
    	}).on('hidden.bs.modal', function(){
        	$('#cate_modal .modal-content').empty();
    	});

        var obj_validate_form  = $('#cate_form').baigoValidate(opts_validate_form);
        var obj_submit_form     = $('#cate_form').baigoSubmit(opts_submit_form);

        $('#cate_form').submit(function(){
            if (obj_validate_form.verify()) {
                tinyMCE.triggerSave();
                obj_submit_form.formSubmit();
            }
        });

        $('.list-group-item.collapse').on('shown.bs.collapse', function(){
            var _key = $(this).data('key');
            $('#bg-caret-form-' + _key).attr('class', 'fas fa-chevron-up');
        });

        $('.list-group-item.collapse').on('hidden.bs.collapse', function(){
            var _key = $(this).data('key');
            $('#bg-caret-form-' + _key).attr('class', 'fas fa-chevron-down');
        });
    });
    </script>
<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);
