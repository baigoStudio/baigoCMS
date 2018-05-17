<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['gather']['main']['title'] . ' &raquo; ' . $this->lang['consoleMod']['gather']['sub']['gsite'],
    'menu_active'    => 'gather',
    'sub_active'     => 'gsite',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    "prism"          => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?m=gsite",
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php');
include($cfg['pathInclude'] . 'gsite_head.php'); ?>

    <form name="gsite_form" id="gsite_form">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="a" value="stepContent">
        <input type="hidden" name="gsite_id" id="gsite_id" value="<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>">

        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <?php include($cfg['pathInclude'] . 'gsite_menu.php'); ?>
                    <div class="card-body">
                        <ul class="nav nav-pills mb-3">
                            <li class="nav-item">
                                <a class="nav-link active" href="#tab_main" aria-controls="tab_main" data-toggle="tab">
                                    <?php echo $this->lang['mod']['href']['parseMain']; ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tab_attach" aria-controls="tab_attach" data-toggle="tab">
                                    <?php echo $this->lang['mod']['href']['parseAttach']; ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tab_other" aria-controls="tab_other" data-toggle="tab">
                                    <?php echo $this->lang['mod']['href']['other']; ?>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_main">
                                <p class="lead"><?php echo $this->lang['mod']['label']['parseTitle']; ?></p>

                                <div class="form-group">
                                    <label><?php echo $this->lang['mod']['label']['selector']; ?> <span class="text-danger">*</span></label>
                                    <input type="text" name="gsite_title_selector" id="gsite_title_selector" value="<?php echo $this->tplData['gsiteRow']['gsite_title_selector']; ?>" data-validate class="form-control">
                                    <small class="form-text" id="msg_gsite_title_selector"></small>
                                    <small class="form-text"><?php echo $this->lang['mod']['label']['selectorNote']; ?></small>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-sm-8">
                                        <label><?php echo $this->lang['mod']['label']['attrGather']; ?></label>
                                        <div class="input-group">
                                            <input type="text" name="gsite_title_attr" id="gsite_title_attr" value="<?php echo $this->tplData['gsiteRow']['gsite_title_attr']; ?>" data-validate class="form-control">
                                            <span class="input-group-append">
                                                <a href="#attr_modal" class="btn btn-warning" data-toggle="modal">
                                                    <span class="oi oi-question-mark"></span>
                                                </a>
                                            </span>
                                        </div>
                                        <small class="form-text" id="msg_gsite_title_attr"></small>
                                        <small class="form-text"><?php echo $this->lang['mod']['label']['attrNote']; ?></small>
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label><?php echo $this->lang['mod']['label']['attrOften']; ?></label>
                                        <select class="form-control attr_often" data-type="title">
                                            <option value=""><?php echo $this->lang['mod']['option']['pleaseSelect']; ?></option>
                                            <?php foreach ($this->tplData['attrOften'] as $_key=>$_value) { ?>
                                                <option <?php if ($this->tplData['gsiteRow']['gsite_title_attr'] == $_key) { ?>selected<?php } ?> value="<?php echo $_key; ?>">
                                                    <?php echo $_key; ?>
                                                    -
                                                    <?php if (isset($this->lang['mod']['attrOften'][$_key])) {
                                                        echo $this->lang['mod']['attrOften'][$_key];
                                                    } else {
                                                        echo $_value;
                                                    } ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $this->lang['mod']['label']['filter']; ?></label>
                                    <div class="input-group">
                                        <input type="text" name="gsite_title_filter" id="gsite_title_filter" value="<?php echo $this->tplData['gsiteRow']['gsite_title_filter']; ?>" data-validate class="form-control">
                                        <span class="input-group-append">
                                            <a href="#filter_modal" class="btn btn-warning" data-toggle="modal">
                                                <span class="oi oi-question-mark"></span>
                                            </a>
                                        </span>
                                    </div>
                                    <small class="form-text" id="msg_gsite_title_filter"></small>
                                    <small class="form-text"><?php echo $this->lang['mod']['label']['filterNote']; ?></small>
                                </div>

                                <label><?php echo $this->lang['mod']['label']['replace']; ?></label>

                                <div id="title_replace">
                                    <?php $key_title_replace = 0;
                                    foreach ($this->tplData['gsiteRow']['gsite_title_replace'] as $key_title_replace=>$value_title_replace) { ?>
                                        <div id="title_replace_group_<?php echo $key_title_replace; ?>" class="form-row">
                                            <div class="form-group col">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><?php echo $this->lang['mod']['label']['search']; ?></span>
                                                    </div>
                                                    <input type="text" name="gsite_title_replace[<?php echo $key_title_replace; ?>][search]" id="gsite_title_replace_<?php echo $key_title_replace; ?>_search" value="<?php echo $value_title_replace['search']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group col">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><?php echo $this->lang['mod']['label']['replace']; ?></span>
                                                    </div>
                                                    <input type="text" name="gsite_title_replace[<?php echo $key_title_replace; ?>][replace]" id="gsite_title_replace_<?php echo $key_title_replace; ?>_replace" value="<?php echo $value_title_replace['replace']; ?>" class="form-control">
                                                    <span class="input-group-append">
                                                        <a href="javascript:replace_del(<?php echo $key_title_replace; ?>,'title');" class="btn btn-info">
                                                            <span class="oi oi-trash"></span>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>

                                <div class="form-group">
                                    <button type="button" id="title_replace_add" class="btn btn-info">
                                        <span class="oi oi-plus"></span>
                                    </button>
                                </div>

                                <small class="form-text"><?php echo $this->lang['mod']['label']['replaceNote']; ?></small>

                                <hr class="bg-card-hr">

                                <p class="lead"><?php echo $this->lang['mod']['label']['parseContent']; ?></p>

                                <div class="form-group">
                                    <label><?php echo $this->lang['mod']['label']['selector']; ?> <span class="text-danger">*</span></label>
                                    <input type="text" name="gsite_content_selector" id="gsite_content_selector" value="<?php echo $this->tplData['gsiteRow']['gsite_content_selector']; ?>" data-validate class="form-control">
                                    <small class="form-text" id="msg_gsite_content_selector"></small>
                                    <small class="form-text"><?php echo $this->lang['mod']['label']['selectorNote']; ?></small>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-sm-8">
                                        <label><?php echo $this->lang['mod']['label']['attrGather']; ?></label>
                                        <div class="input-group">
                                            <input type="text" name="gsite_content_attr" id="gsite_content_attr" value="<?php echo $this->tplData['gsiteRow']['gsite_content_attr']; ?>" data-validate class="form-control">
                                            <span class="input-group-append">
                                                <a href="#attr_modal" class="btn btn-warning" data-toggle="modal">
                                                    <span class="oi oi-question-mark"></span>
                                                </a>
                                            </span>
                                        </div>
                                        <small class="form-text" id="msg_gsite_content_attr"></small>
                                        <small class="form-text"><?php echo $this->lang['mod']['label']['attrNote']; ?></small>
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label><?php echo $this->lang['mod']['label']['attrOften']; ?></label>
                                        <select class="form-control attr_often" data-type="content">
                                            <option value=""><?php echo $this->lang['mod']['option']['pleaseSelect']; ?></option>
                                            <?php foreach ($this->tplData['attrOften'] as $_key=>$_value) { ?>
                                                <option <?php if ($this->tplData['gsiteRow']['gsite_title_attr'] == $_key) { ?>selected<?php } ?> value="<?php echo $_key; ?>">
                                                    <?php echo $_key; ?>
                                                    -
                                                    <?php if (isset($this->lang['mod']['attrOften'][$_key])) {
                                                        echo $this->lang['mod']['attrOften'][$_key];
                                                    } else {
                                                        echo $_value;
                                                    } ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $this->lang['mod']['label']['filter']; ?></label>
                                    <div class="input-group">
                                        <input type="text" name="gsite_content_filter" id="gsite_content_filter" value="<?php echo $this->tplData['gsiteRow']['gsite_content_filter']; ?>" data-validate class="form-control">
                                        <span class="input-group-append">
                                            <a href="#filter_modal" class="btn btn-warning" data-toggle="modal">
                                                <span class="oi oi-question-mark"></span>
                                            </a>
                                        </span>
                                    </div>
                                    <small class="form-text" id="msg_gsite_content_filter"></small>
                                    <small class="form-text"><?php echo $this->lang['mod']['label']['filterNote']; ?></small>
                                </div>

                                <label><?php echo $this->lang['mod']['label']['replace']; ?></label>

                                <div id="content_replace">
                                    <?php $key_content_replace = 0;
                                    foreach ($this->tplData['gsiteRow']['gsite_content_replace'] as $key_content_replace=>$value_content_replace) { ?>
                                        <div id="content_replace_group_<?php echo $key_content_replace; ?>" class="form-row">
                                            <div class="form-group col">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><?php echo $this->lang['mod']['label']['search']; ?></span>
                                                    </div>
                                                    <input type="text" name="gsite_content_replace[<?php echo $key_content_replace; ?>][search]" id="gsite_content_replace_<?php echo $key_content_replace; ?>_search" value="<?php echo $value_content_replace['search']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group col">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><?php echo $this->lang['mod']['label']['replace']; ?></span>
                                                    </div>
                                                    <input type="text" name="gsite_content_replace[<?php echo $key_content_replace; ?>][replace]" id="gsite_content_replace_<?php echo $key_content_replace; ?>_replace" value="<?php echo $value_content_replace['replace']; ?>" class="form-control">
                                                    <span class="input-group-append">
                                                        <a href="javascript:replace_del(<?php echo $key_content_replace; ?>,'content');" class="btn btn-info">
                                                            <span class="oi oi-trash"></span>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>

                                <div class="form-group">
                                    <button type="button" id="content_replace_add" class="btn btn-info">
                                        <span class="oi oi-plus"></span>
                                    </button>
                                </div>

                                <small class="form-text"><?php echo $this->lang['mod']['label']['replaceNote']; ?></small>
                            </div>

                            <div class="tab-pane" id="tab_attach">
                                <p class="lead"><?php echo $this->lang['mod']['label']['parseTime']; ?></p>

                                <div class="form-group">
                                    <label><?php echo $this->lang['mod']['label']['selector']; ?></label>
                                    <input type="text" name="gsite_time_selector" id="gsite_time_selector" value="<?php echo $this->tplData['gsiteRow']['gsite_time_selector']; ?>" data-validate class="form-control">
                                    <small class="form-text" id="msg_gsite_time_selector"></small>
                                    <small class="form-text"><?php echo $this->lang['mod']['label']['selectorNote']; ?></small>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-sm-8">
                                        <label><?php echo $this->lang['mod']['label']['attrGather']; ?></label>
                                        <div class="input-group">
                                            <input type="text" name="gsite_time_attr" id="gsite_time_attr" value="<?php echo $this->tplData['gsiteRow']['gsite_time_attr']; ?>" data-validate class="form-control">
                                            <span class="input-group-append">
                                                <a href="#attr_modal" class="btn btn-warning" data-toggle="modal">
                                                    <span class="oi oi-question-mark"></span>
                                                </a>
                                            </span>
                                        </div>
                                        <small class="form-text" id="msg_gsite_time_attr"></small>
                                        <small class="form-text"><?php echo $this->lang['mod']['label']['attrNote']; ?></small>
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label><?php echo $this->lang['mod']['label']['attrOften']; ?></label>
                                        <select class="form-control attr_often" data-type="time">
                                            <option value=""><?php echo $this->lang['mod']['option']['pleaseSelect']; ?></option>
                                            <?php foreach ($this->tplData['attrOften'] as $_key=>$_value) { ?>
                                                <option <?php if ($this->tplData['gsiteRow']['gsite_title_attr'] == $_key) { ?>selected<?php } ?> value="<?php echo $_key; ?>">
                                                    <?php echo $_key; ?>
                                                    -
                                                    <?php if (isset($this->lang['mod']['attrOften'][$_key])) {
                                                        echo $this->lang['mod']['attrOften'][$_key];
                                                    } else {
                                                        echo $_value;
                                                    } ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $this->lang['mod']['label']['filter']; ?></label>
                                    <div class="input-group">
                                        <input type="text" name="gsite_time_filter" id="gsite_time_filter" value="<?php echo $this->tplData['gsiteRow']['gsite_time_filter']; ?>" data-validate class="form-control">
                                        <span class="input-group-append">
                                            <a href="#filter_modal" class="btn btn-warning" data-toggle="modal">
                                                <span class="oi oi-question-mark"></span>
                                            </a>
                                        </span>
                                    </div>
                                    <small class="form-text" id="msg_gsite_time_filter"></small>
                                    <small class="form-text"><?php echo $this->lang['mod']['label']['filterNote']; ?></small>
                                </div>

                                <label><?php echo $this->lang['mod']['label']['replace']; ?></label>

                                <div id="time_replace">
                                    <?php $key_time_replace = 0;
                                    foreach ($this->tplData['gsiteRow']['gsite_time_replace'] as $key_time_replace=>$value_time_replace) { ?>
                                        <div id="time_replace_group_<?php echo $key_time_replace; ?>" class="form-row">
                                            <div class="form-group col">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><?php echo $this->lang['mod']['label']['search']; ?></span>
                                                    </div>
                                                    <input type="text" name="gsite_time_replace[<?php echo $key_time_replace; ?>][search]" id="gsite_time_replace_<?php echo $key_time_replace; ?>_search" value="<?php echo $value_time_replace['search']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group col">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><?php echo $this->lang['mod']['label']['replace']; ?></span>
                                                    </div>
                                                    <input type="text" name="gsite_time_replace[<?php echo $key_time_replace; ?>][replace]" id="gsite_time_replace_<?php echo $key_time_replace; ?>_replace" value="<?php echo $value_time_replace['replace']; ?>" class="form-control">
                                                    <span class="input-group-append">
                                                        <a href="javascript:replace_del(<?php echo $key_time_replace; ?>,'time');" class="btn btn-info">
                                                            <span class="oi oi-trash"></span>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>

                                <div class="form-group">
                                    <button type="button" id="time_replace_add" class="btn btn-info">
                                        <span class="oi oi-plus"></span>
                                    </button>
                                </div>

                                <small class="form-text"><?php echo $this->lang['mod']['label']['replaceNote']; ?></small>

                                <hr class="bg-card-hr">

                                <p class="lead"><?php echo $this->lang['mod']['label']['parseSource']; ?></p>

                                <div class="form-group">
                                    <label><?php echo $this->lang['mod']['label']['selector']; ?></label>
                                    <input type="text" name="gsite_source_selector" id="gsite_source_selector" value="<?php echo $this->tplData['gsiteRow']['gsite_source_selector']; ?>" data-validate class="form-control">
                                    <small class="form-text" id="msg_gsite_source_selector"></small>
                                    <small class="form-text"><?php echo $this->lang['mod']['label']['selectorNote']; ?></small>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-sm-8">
                                        <label><?php echo $this->lang['mod']['label']['attrGather']; ?></label>
                                        <div class="input-group">
                                            <input type="text" name="gsite_source_attr" id="gsite_source_attr" value="<?php echo $this->tplData['gsiteRow']['gsite_source_attr']; ?>" data-validate class="form-control">
                                            <span class="input-group-append">
                                                <a href="#attr_modal" class="btn btn-warning" data-toggle="modal">
                                                    <span class="oi oi-question-mark"></span>
                                                </a>
                                            </span>
                                        </div>
                                        <small class="form-text" id="msg_gsite_source_attr"></small>
                                        <small class="form-text"><?php echo $this->lang['mod']['label']['attrNote']; ?></small>
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label><?php echo $this->lang['mod']['label']['attrOften']; ?></label>
                                        <select class="form-control attr_often" data-type="source">
                                            <option value=""><?php echo $this->lang['mod']['option']['pleaseSelect']; ?></option>
                                            <?php foreach ($this->tplData['attrOften'] as $_key=>$_value) { ?>
                                                <option <?php if ($this->tplData['gsiteRow']['gsite_title_attr'] == $_key) { ?>selected<?php } ?> value="<?php echo $_key; ?>">
                                                    <?php echo $_key; ?>
                                                    -
                                                    <?php if (isset($this->lang['mod']['attrOften'][$_key])) {
                                                        echo $this->lang['mod']['attrOften'][$_key];
                                                    } else {
                                                        echo $_value;
                                                    } ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $this->lang['mod']['label']['filter']; ?></label>
                                    <div class="input-group">
                                        <input type="text" name="gsite_source_filter" id="gsite_source_filter" value="<?php echo $this->tplData['gsiteRow']['gsite_source_filter']; ?>" data-validate class="form-control">
                                        <span class="input-group-append">
                                            <a href="#filter_modal" class="btn btn-warning" data-toggle="modal">
                                                <span class="oi oi-question-mark"></span>
                                            </a>
                                        </span>
                                    </div>
                                    <small class="form-text" id="msg_gsite_source_filter"></small>
                                    <small class="form-text"><?php echo $this->lang['mod']['label']['filterNote']; ?></small>
                                </div>

                                <label><?php echo $this->lang['mod']['label']['replace']; ?></label>

                                <div id="source_replace">
                                    <?php $key_source_replace = 0;
                                    foreach ($this->tplData['gsiteRow']['gsite_source_replace'] as $key_source_replace=>$value_source_replace) { ?>
                                        <div id="source_replace_group_<?php echo $key_source_replace; ?>" class="form-row">
                                            <div class="form-group col">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><?php echo $this->lang['mod']['label']['search']; ?></span>
                                                    </div>
                                                    <input type="text" name="gsite_source_replace[<?php echo $key_source_replace; ?>][search]" id="gsite_source_replace_<?php echo $key_source_replace; ?>_search" value="<?php echo $value_source_replace['search']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group col">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><?php echo $this->lang['mod']['label']['replace']; ?></span>
                                                    </div>
                                                    <input type="text" name="gsite_source_replace[<?php echo $key_source_replace; ?>][replace]" id="gsite_source_replace_<?php echo $key_source_replace; ?>_replace" value="<?php echo $value_source_replace['replace']; ?>" class="form-control">
                                                    <span class="input-group-append">
                                                        <a href="javascript:replace_del(<?php echo $key_source_replace; ?>,'source');" class="btn btn-info">
                                                            <span class="oi oi-trash"></span>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>

                                <div class="form-group">
                                    <button type="button" id="source_replace_add" class="btn btn-info">
                                        <span class="oi oi-plus"></span>
                                    </button>
                                </div>

                                <small class="form-text"><?php echo $this->lang['mod']['label']['replaceNote']; ?></small>

                                <hr class="bg-card-hr">

                                <p class="lead"><?php echo $this->lang['mod']['label']['parseAuthor']; ?></p>

                                <div class="form-group">
                                    <label><?php echo $this->lang['mod']['label']['selector']; ?></label>
                                    <input type="text" name="gsite_author_selector" id="gsite_author_selector" value="<?php echo $this->tplData['gsiteRow']['gsite_author_selector']; ?>" data-validate class="form-control">
                                    <small class="form-text" id="msg_gsite_author_selector"></small>
                                    <small class="form-text"><?php echo $this->lang['mod']['label']['selectorNote']; ?></small>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-sm-8">
                                        <label><?php echo $this->lang['mod']['label']['attrGather']; ?></label>
                                        <div class="input-group">
                                            <input type="text" name="gsite_author_attr" id="gsite_author_attr" value="<?php echo $this->tplData['gsiteRow']['gsite_author_attr']; ?>" data-validate class="form-control">
                                            <span class="input-group-append">
                                                <a href="#attr_modal" class="btn btn-warning" data-toggle="modal">
                                                    <span class="oi oi-question-mark"></span>
                                                </a>
                                            </span>
                                        </div>
                                        <small class="form-text" id="msg_gsite_author_attr"></small>
                                        <small class="form-text"><?php echo $this->lang['mod']['label']['attrNote']; ?></small>
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label><?php echo $this->lang['mod']['label']['attrOften']; ?></label>
                                        <select class="form-control attr_often" data-type="author">
                                            <option value=""><?php echo $this->lang['mod']['option']['pleaseSelect']; ?></option>
                                            <?php foreach ($this->tplData['attrOften'] as $_key=>$_value) { ?>
                                                <option <?php if ($this->tplData['gsiteRow']['gsite_title_attr'] == $_key) { ?>selected<?php } ?> value="<?php echo $_key; ?>">
                                                    <?php echo $_key; ?>
                                                    -
                                                    <?php if (isset($this->lang['mod']['attrOften'][$_key])) {
                                                        echo $this->lang['mod']['attrOften'][$_key];
                                                    } else {
                                                        echo $_value;
                                                    } ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $this->lang['mod']['label']['filter']; ?></label>
                                    <div class="input-group">
                                        <input type="text" name="gsite_author_filter" id="gsite_author_filter" value="<?php echo $this->tplData['gsiteRow']['gsite_author_filter']; ?>" data-validate class="form-control">
                                        <span class="input-group-append">
                                            <a href="#filter_modal" class="btn btn-warning" data-toggle="modal">
                                                <span class="oi oi-question-mark"></span>
                                            </a>
                                        </span>
                                    </div>
                                    <small class="form-text" id="msg_gsite_author_filter"></small>
                                    <small class="form-text"><?php echo $this->lang['mod']['label']['filterNote']; ?></small>
                                </div>

                                <label><?php echo $this->lang['mod']['label']['replace']; ?></label>

                                <div id="author_replace">
                                    <?php $key_author_replace = 0;
                                    foreach ($this->tplData['gsiteRow']['gsite_author_replace'] as $key_author_replace=>$value_author_replace) { ?>
                                        <div id="author_replace_group_<?php echo $key_author_replace; ?>" class="form-row">
                                            <div class="form-group col">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><?php echo $this->lang['mod']['label']['search']; ?></span>
                                                    </div>
                                                    <input type="text" name="gsite_author_replace[<?php echo $key_author_replace; ?>][search]" id="gsite_author_replace_<?php echo $key_author_replace; ?>_search" value="<?php echo $value_author_replace['search']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group col">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><?php echo $this->lang['mod']['label']['replace']; ?></span>
                                                    </div>
                                                    <input type="text" name="gsite_author_replace[<?php echo $key_author_replace; ?>][replace]" id="gsite_author_replace_<?php echo $key_author_replace; ?>_replace" value="<?php echo $value_author_replace['replace']; ?>" class="form-control">
                                                    <span class="input-group-append">
                                                        <a href="javascript:replace_del(<?php echo $key_author_replace; ?>,'author');" class="btn btn-info">
                                                            <span class="oi oi-trash"></span>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>

                                <div class="form-group">
                                    <button type="button" id="author_replace_add" class="btn btn-info">
                                        <span class="oi oi-plus"></span>
                                    </button>
                                </div>

                                <small class="form-text"><?php echo $this->lang['mod']['label']['replaceNote']; ?></small>
                            </div>

                            <div class="tab-pane" id="tab_other">
                                <div class="form-group">
                                    <label><?php echo $this->lang['mod']['label']['gsiteKeepTag']; ?></label>
                                    <div class="input-group">
                                        <input type="text" name="gsite_keep_tag" id="gsite_keep_tag" value="<?php echo $this->tplData['gsiteRow']['gsite_keep_tag']; ?>" data-validate class="form-control">
                                        <span class="input-group-append">
                                            <a href="#keep_modal" class="btn btn-warning" data-toggle="modal">
                                                <span class="oi oi-question-mark"></span>
                                            </a>
                                        </span>
                                    </div>
                                    <small class="form-text" id="msg_gsite_keep_tag"></small>
                                    <small class="form-text">
                                        <?php echo $this->lang['mod']['label']['gsiteKeepTagNote']; ?>
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $this->lang['mod']['label']['imgFilter']; ?></label>
                                    <input type="text" name="gsite_img_filter" id="gsite_img_filter" value="<?php echo $this->tplData['gsiteRow']['gsite_img_filter']; ?>" data-validate class="form-control">
                                    <small class="form-text" id="msg_gsite_img_filter"></small>
                                    <small class="form-text"><?php echo $this->lang['mod']['label']['imgFilterNote']; ?></small>
                                </div>

                                <hr class="bg-card-hr">

                                <p class="lead"><?php echo $this->lang['mod']['label']['attrFilter']; ?></p>
                                <p><?php echo $this->lang['mod']['label']['attrFilterNote']; ?></p>

                                <div class="form-group">
                                    <label><?php echo $this->lang['mod']['label']['attrAllow']; ?></label>
                                    <input type="text" name="gsite_attr_allow" id="gsite_attr_allow" value="<?php echo $this->tplData['gsiteRow']['gsite_attr_allow']; ?>" data-validate class="form-control">
                                    <small class="form-text" id="msg_gsite_attr_allow"></small>
                                    <small class="form-text">
                                        <?php echo $this->lang['mod']['label']['attrAllowNote']; ?>
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $this->lang['mod']['label']['tagIgnore']; ?></label>
                                    <input type="text" name="gsite_ignore_tag" id="gsite_ignore_tag" value="<?php echo $this->tplData['gsiteRow']['gsite_ignore_tag']; ?>" data-validate class="form-control">
                                    <small class="form-text" id="msg_gsite_ignore_tag"></small>
                                    <small class="form-text">
                                        <?php echo $this->lang['mod']['label']['tagIgnoreNote']; ?>
                                    </small>
                                </div>

                                <label><?php echo $this->lang['mod']['label']['attrExcept']; ?></label>

                                <div id="attr_except">
                                    <?php $key_attr_except = 0;
                                    foreach ($this->tplData['gsiteRow']['gsite_attr_except'] as $key_attr_except=>$value_attr_except) { ?>
                                        <div id="attr_except_group_<?php echo $key_attr_except; ?>" class="form-row">
                                            <div class="form-group col-md-4">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><?php echo $this->lang['mod']['label']['attrExceptTag']; ?></span>
                                                    </div>
                                                    <input type="text" name="gsite_attr_except[<?php echo $key_attr_except; ?>][tag]" id="gsite_attr_except_<?php echo $key_attr_except; ?>_tag" value="<?php echo $value_attr_except['tag']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><?php echo $this->lang['mod']['label']['attrExceptAttr']; ?></span>
                                                    </div>
                                                    <input type="text" name="gsite_attr_except[<?php echo $key_attr_except; ?>][attr]" id="gsite_attr_except_<?php echo $key_attr_except; ?>_attr" value="<?php echo $value_attr_except['attr']; ?>" class="form-control">
                                                    <span class="input-group-append">
                                                        <a href="javascript:except_del(<?php echo $key_attr_except; ?>);" class="btn btn-info">
                                                            <span class="oi oi-trash"></span>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>

                                <div class="form-group">
                                    <button type="button" id="attr_except_add" class="btn btn-info">
                                        <span class="oi oi-plus"></span>
                                    </button>
                                </div>

                                <small class="form-text">
                                    <?php echo $this->lang['mod']['label']['attrExceptNote']; ?>
                                    <a href="#attr_except_modal" class="btn btn-warning" data-toggle="modal">
                                        <span class="oi oi-question-mark"></span>
                                    </a>
                                </small>
                            </div>
                        </div>

                        <div class="bg-submit-box"></div>
                        <div class="bg-validator-box mt-3"></div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['save']; ?></button>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header"><?php echo $this->lang['mod']['label']['previewContent']; ?></div>
                    <div class="card-body" id="gsite_preview">
                        <div class="loading">
                            <h1>
                                <span class="oi oi-loop-circular bg-spin"></span>
                                Loading...
                            </h1>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header"><?php echo $this->lang['mod']['label']['gsiteSource']; ?></div>
                    <div class="card-body" id="gsite_source">
                        <div class="loading">
                            <h1>
                                <span class="oi oi-loop-circular bg-spin"></span>
                                Loading...
                            </h1>
                        </div>
                    </div>
                </div>
            </div>

            <?php include($cfg['pathInclude'] . 'gsite_side.php'); ?>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'gsite_foot.php');
include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_form = {
        gsite_title_selector: {
            len: { min: 1, max: 100 },
            validate: { type: "str", format: "text" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x270232']; ?>", too_long: "<?php echo $this->lang['rcode']['x270233']; ?>" }
        },
        gsite_title_attr: {
            len: { min: 0, max: 100 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x270237']; ?>" }
        },
        gsite_title_filter: {
            len: { min: 0, max: 100 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x270227']; ?>" }
        },
        gsite_content_selector: {
            len: { min: 1, max: 100 },
            validate: { type: "str", format: "text" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x270234']; ?>", too_long: "<?php echo $this->lang['rcode']['x270235']; ?>" }
        },
        gsite_content_attr: {
            len: { min: 0, max: 100 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x270238']; ?>" }
        },
        gsite_content_filter: {
            len: { min: 0, max: 100 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x270228']; ?>" }
        },
        gsite_time_selector: {
            len: { min: 0, max: 100 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x270220']; ?>" }
        },
        gsite_time_attr: {
            len: { min: 0, max: 100 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x270239']; ?>" }
        },
        gsite_time_filter: {
            len: { min: 0, max: 100 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x270229']; ?>" }
        },
        gsite_source_selector: {
            len: { min: 0, max: 100 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x270221']; ?>" }
        },
        gsite_source_attr: {
            len: { min: 0, max: 100 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x270240']; ?>" }
        },
        gsite_source_filter: {
            len: { min: 0, max: 100 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x270230']; ?>" }
        },
        gsite_author_selector: {
            len: { min: 0, max: 100 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x270222']; ?>" }
        },
        gsite_author_attr: {
            len: { min: 0, max: 100 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x270241']; ?>" }
        },
        gsite_author_filter: {
            len: { min: 0, max: 100 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x270231']; ?>" }
        },
        gsite_img_filter: {
            len: { min: 0, max: 100 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x270244']; ?>" }
        },
        gsite_keep_tag: {
            len: { min: 0, max: 300 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x270205']; ?>" }
        },
        gsite_attr_allow: {
            len: { min: 0, max: 100 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x270242']; ?>" }
        },
        gsite_ignore_tag: {
            len: { min: 0, max: 300 },
            validate: { type: "str", format: "text" },
            msg: { too_long: "<?php echo $this->lang['rcode']['x270243']; ?>" }
        }
    };

    var options_validator_form = {
        msg_global:{
            msg: "<?php echo $this->lang['common']['label']['errInput']; ?>"
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=gsite&c=request",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    function replace_add(_count_replace, _type_replace) {
        $("#" + _type_replace + "_replace").append("<div id=\"" + _type_replace + "_replace_group_" + _count_replace + "\" class=\"form-row\">" +
            "<div class=\"form-group col\">" +
                "<div class=\"input-group\">" +
                    "<div class=\"input-group-prepend\">" +
                        "<span class=\"input-group-text\"><?php echo $this->lang['mod']['label']['search']; ?></span>" +
                    "</div>" +
                    "<input type=\"text\" name=\"gsite_" + _type_replace + "_replace[" + _count_replace + "][search]\" id=\"gsite_" + _type_replace + "_replace_" + _count_replace + "\" class=\"form-control\">" +
                "</div>" +
            "</div>" +
            "<div class=\"form-group col\">" +
                "<div class=\"input-group\">" +
                    "<div class=\"input-group-prepend\">" +
                        "<span class=\"input-group-text\"><?php echo $this->lang['mod']['label']['replace']; ?></span>" +
                    "</div>" +
                    "<input type=\"text\" name=\"gsite_" + _type_replace + "_replace[" + _count_replace + "][replace]\" id=\"gsite_" + _type_replace + "_replace_" + _count_replace + "\" class=\"form-control\">" +
                    "<span class=\"input-group-append\">" +
                        "<a href=\"javascript:replace_del(" + _count_replace + ",'" + _type_replace + "');\" class=\"btn btn-info\">" +
                            "<span class=\"oi oi-trash\"></span>" +
                        "</a>" +
                    "</span>" +
                "</div>" +
            "</div>" +
        "</div>");
    }

    function except_add(_count_except) {
        $("#attr_except").append("<div id=\"attr_except_group_" + _count_except + "\" class=\"form-row\">" +
            "<div class=\"form-group col-md-4\">" +
                "<div class=\"input-group\">" +
                    "<div class=\"input-group-prepend\">" +
                        "<span class=\"input-group-text\"><?php echo $this->lang['mod']['label']['attrExceptTag']; ?></span>" +
                    "</div>" +
                    "<input type=\"text\" name=\"gsite_attr_except[" + _count_except + "][tag]\" id=\"gsite_attr_except_" + _count_except + "_tag\" class=\"form-control\">" +
                "</div>" +
            "</div>" +
            "<div class=\"form-group col-md-8\">" +
                "<div class=\"input-group\">" +
                    "<div class=\"input-group-prepend\">" +
                        "<span class=\"input-group-text\"><?php echo $this->lang['mod']['label']['attrExceptAttr']; ?></span>" +
                    "</div>" +
                    "<input type=\"text\" name=\"gsite_attr_except[" + _count_except + "][attr]\" id=\"gsite_attr_except_" + _count_except + "_attr\" class=\"form-control\">" +
                    "<span class=\"input-group-append\">" +
                        "<a href=\"javascript:except_del(" + _count_except + ");\" class=\"btn btn-info\">" +
                            "<span class=\"oi oi-trash\"></span>" +
                        "</a>" +
                    "</span>" +
                "</div>" +
            "</div>" +
        "</div>");
    }


    function replace_del(_replace_id, _type_replace) {
        $("#" + _type_replace + "_replace_group_" + _replace_id).remove();
    }

    function except_del(_except_id) {
        $("#attr_except_group_" + _except_id).remove();
    }

    $(document).ready(function(){
        var obj_validate_form = $("#gsite_form").baigoValidator(opts_validator_form, options_validator_form);
        var obj_submit_form   = $("#gsite_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });

        $(".attr_often").change(function(){
            var _attr_val   = $(this).val();
            var _attr_type  = $(this).data('type');
            $("#gsite_" + _attr_type + "_attr").val(_attr_val);

        });

        var _count_title_replace     = <?php echo $key_title_replace++; ?>;
        $("#title_replace_add").click(function(){
            _count_title_replace++;
            replace_add(_count_title_replace, "title");
        });

        var _count_content_replace     = <?php echo $key_content_replace++; ?>;
        $("#content_replace_add").click(function(){
            _count_content_replace++;
            replace_add(_count_content_replace, "content");
        });

        var _count_time_replace     = <?php echo $key_time_replace++; ?>;
        $("#time_replace_add").click(function(){
            _count_time_replace++;
            replace_add(_count_time_replace, "time");
        });

        var _count_source_replace     = <?php echo $key_source_replace++; ?>;
        $("#source_replace_add").click(function(){
            _count_source_replace++;
            replace_add(_count_source_replace, "source");
        });

        var _count_author_replace     = <?php echo $key_author_replace++; ?>;
        $("#author_replace_add").click(function(){
            _count_author_replace++;
            replace_add(_count_author_replace, "author");
        });

        var _count_attr_except        = <?php echo $key_attr_except++; ?>;
        $("#attr_except_add").click(function(){
            _count_attr_except++;
            except_add(_count_attr_except);
        });

        $("#gsite_preview").html("<div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' scrolling='auto' src='<?php echo BG_URL_CONSOLE; ?>index.php?m=gsite_preview&a=content&gsite_id=<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>'></iframe></div>");

        $("#gsite_source").html("<div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' scrolling='auto' src='<?php echo BG_URL_CONSOLE; ?>index.php?m=gsite_source&a=content&gsite_id=<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>'></iframe></div>");
    });
    </script>

<?php include('include' . DS . 'html_foot.php');