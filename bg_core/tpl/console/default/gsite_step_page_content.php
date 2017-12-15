<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['gather']['main']['title'] . ' &raquo; ' . $this->lang['consoleMod']['gather']['sub']['gsite'],
    'menu_active'    => 'gather',
    'sub_active'     => 'gsite',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    "prism"          => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?mod=gsite",
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group">
        <ul class="nav nav-pills bg-nav-pills">
            <li>
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=gsite&act=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <?php echo $this->lang['common']['href']['back']; ?>
                </a>
            </li>
            <li>
                <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=gsite#form" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    <?php echo $this->lang['mod']['href']['help']; ?>
                </a>
            </li>
        </ul>
    </div>

    <?php if ($this->tplData['gsiteRow']['gsite_id'] > 0) {
        include($cfg['pathInclude'] . "gsite_menu.php");
    } ?>

    <form name="gsite_form" id="gsite_form">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="act" value="stepPageContent">
        <input type="hidden" name="gsite_id" id="gsite_id" value="<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4><?php echo $this->lang['mod']['label']['parsePageContent']; ?></h4>

                        <div class="form-group">
                            <div id="group_gsite_page_content_selector">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['selector']; ?><span id="msg_gsite_page_content_selector">*</span></label>
                                <input type="text" name="gsite_page_content_selector" id="gsite_page_content_selector" value="<?php echo $this->tplData['gsiteRow']['gsite_page_content_selector']; ?>" data-validate class="form-control">
                                <span class="help-block"><?php echo $this->lang['mod']['label']['selectorNote']; ?></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <div id="group_gsite_page_content_attr">
                                        <label class="control-label"><?php echo $this->lang['mod']['label']['attrGather']; ?><span id="msg_gsite_page_content_attr"></span></label>
                                        <div class="input-group">
                                            <input type="text" name="gsite_page_content_attr" id="gsite_page_content_attr" value="<?php echo $this->tplData['gsiteRow']['gsite_page_content_attr']; ?>" data-validate class="form-control">
                                            <span class="input-group-btn">
                                                <a href="#attr_modal" class="btn btn-warning" data-toggle="modal">
                                                    <span class="glyphicon glyphicon-question-sign"></span>
                                                </a>
                                            </span>
                                        </div>
                                        <span class="help-block"><?php echo $this->lang['mod']['label']['attrNote']; ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label"><?php echo $this->lang['mod']['label']['attrOften']; ?></label>
                                    <select class="form-control attr_often">
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
                        </div>

                        <div class="form-group">
                            <div id="group_gsite_page_content_filter">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['filter']; ?><span id="msg_gsite_page_content_filter"></span></label>
                                <div class="input-group">
                                    <input type="text" name="gsite_page_content_filter" id="gsite_page_content_filter" value="<?php echo $this->tplData['gsiteRow']['gsite_page_content_filter']; ?>" data-validate class="form-control">
                                    <span class="input-group-btn">
                                        <a href="#filter_modal" class="btn btn-warning" data-toggle="modal">
                                            <span class="glyphicon glyphicon-question-sign"></span>
                                        </a>
                                    </span>
                                </div>
                                <span class="help-block"><?php echo $this->lang['mod']['label']['filterNote']; ?></span>
                            </div>
                        </div>

                        <label class="control-label"><?php echo $this->lang['mod']['label']['replace']; ?><span id="msg_gsite_page_content_replace"></span></label>

                        <div id="page_content_replace">
                            <?php $key_replace = 0;
                            foreach ($this->tplData['gsiteRow']['gsite_page_content_replace'] as $key_replace=>$value_replace) { ?>
                                <div id="page_content_replace_group_<?php echo $key_replace; ?>" class="form-group row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo $this->lang['mod']['label']['search']; ?></span>
                                            <input type="text" name="gsite_page_content_replace[<?php echo $key_replace; ?>][search]" id="gsite_page_content_replace_<?php echo $key_replace; ?>_search" value="<?php echo $value_replace['search']; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo $this->lang['mod']['label']['replace']; ?></span>
                                            <input type="text" name="gsite_page_content_replace[<?php echo $key_replace; ?>][replace]" id="gsite_page_content_replace_<?php echo $key_replace; ?>_replace" value="<?php echo $value_replace['replace']; ?>" class="form-control">
                                            <span class="input-group-btn">
                                                <a href="javascript:replace_del(<?php echo $key_replace; ?>);" class="btn btn-info">
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="form-group">
                            <button type="button" id="page_content_replace_add" class="btn btn-info">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                        </div>

                        <span class="help-block"><?php echo $this->lang['mod']['label']['replaceNote']; ?></span>

                        <div class="bg-submit-box"></div>
                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['save']; ?></button>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading"><?php echo $this->lang['mod']['label']['previewPage']; ?></div>
                    <div class="panel-body" id="gsite_preview">
                        <div class="loading">
                            <h1>
                                <span class="glyphicon glyphicon-refresh bg-spin"></span>
                                Loading...
                            </h1>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading"><?php echo $this->lang['mod']['label']['gsiteSource']; ?></div>
                    <div class="panel-body" id="gsite_source">
                        <div class="loading">
                            <h1>
                                <span class="glyphicon glyphicon-refresh bg-spin"></span>
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
        gsite_page_content_selector: {
            len: { min: 1, max: 100 },
            validate: { type: "str", format: "text", group: "#group_gsite_page_content_selector" },
            msg: { selector: "#msg_gsite_page_content_selector", too_short: "<?php echo $this->lang['rcode']['x270218']; ?>", too_long: "<?php echo $this->lang['rcode']['x270219']; ?>" }
        },
        gsite_page_content_attr: {
            len: { min: 0, max: 100 },
            validate: { type: "str", format: "text", group: "#group_gsite_page_content_attr" },
            msg: { selector: "#msg_gsite_page_content_attr", too_long: "<?php echo $this->lang['rcode']['x270236']; ?>" }
        },
        gsite_page_content_filter: {
            len: { min: 0, max: 100 },
            validate: { type: "str", format: "text", group: "#group_gsite_page_content_filter" },
            msg: { selector: "#msg_gsite_page_content_filter", too_long: "<?php echo $this->lang['rcode']['x270224']; ?>" }
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=gsite",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    function replace_del(_page_content_replace_id) {
        $("#page_content_replace_group_" + _page_content_replace_id).remove();
    }

    $(document).ready(function(){
        var obj_validate_form = $("#gsite_form").baigoValidator(opts_validator_form);
        var obj_submit_form   = $("#gsite_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });

        $(".attr_often").change(function(){
            var _attr_val   = $(this).val();
            $("#gsite_page_content_attr").val(_attr_val);

        });

        var _count_page_content_replace     = <?php echo $key_replace++; ?>;
        $("#page_content_replace_add").click(function(){
            _count_page_content_replace++;
            $("#page_content_replace").append("<div id=\"page_content_replace_group_" + _count_page_content_replace + "\" class=\"form-group row\">" +
                "<div class=\"col-md-6\">" +
                    "<div class=\"input-group\">" +
                        "<span class=\"input-group-addon\"><?php echo $this->lang['mod']['label']['search']; ?></span>" +
                        "<input type=\"text\" name=\"gsite_page_content_replace[" + _count_page_content_replace + "][search]\" id=\"gsite_page_content_replace_" + _count_page_content_replace + "\" class=\"form-control\">" +
                    "</div>" +
                "</div>" +
                "<div class=\"col-md-6\">" +
                    "<div class=\"input-group\">" +
                        "<span class=\"input-group-addon\"><?php echo $this->lang['mod']['label']['replace']; ?></span>" +
                        "<input type=\"text\" name=\"gsite_page_content_replace[" + _count_page_content_replace + "][replace]\" id=\"gsite_page_content_replace_" + _count_page_content_replace + "\" class=\"form-control\">" +
                        "<span class=\"input-group-btn\">" +
                            "<a href=\"javascript:replace_del(" + _count_page_content_replace + ");\" class=\"btn btn-info\">" +
                                "<span class=\"glyphicon glyphicon-trash\"></span>" +
                            "</a>" +
                        "</span>" +
                    "</div>" +
                "</div>" +
            "</div>");
        });

        $("#gsite_preview").html("<div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' scrolling='auto' src='<?php echo BG_URL_CONSOLE; ?>index.php?mod=gsite_preview&act=pageContent&gsite_id=<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>'></iframe></div>");

        $("#gsite_source").html("<div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' scrolling='auto' src='<?php echo BG_URL_CONSOLE; ?>index.php?mod=gsite_source&act=pageContent&gsite_id=<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>'></iframe></div>");
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>