{function cate_list arr=""}
    {foreach $arr as $key=>$value}
        <option value="{$value.cate_id}" {if $tplData.cateRow.cate_parent_id == $value.cate_id}selected{/if} {if $tplData.cateRow.cate_id == $value.cate_id}disabled{/if}>
            {if $value.cate_level > 1}
                {for $_i=2 to $value.cate_level}
                    &nbsp;&nbsp;
                {/for}
            {/if}
            {$value.cate_name}
        </option>

        {if $value.cate_childs}
            {cate_list arr=$value.cate_childs}
        {/if}
    {/foreach}
{/function}

{if $tplData.cateRow.cate_id < 1}
    {$title_sub    = $lang.page.add}
    {$sub_active   = "form"}
{else}
    {$title_sub    = $lang.page.edit}
    {$sub_active   = "list"}
{/if}

{$cfg = [
    title          => "{$adminMod.cate.main.title} - {$title_sub}",
    menu_active    => "cate",
    sub_active     => $sub_active,
    tinymce        => "true",
    baigoSubmit    => "true",
    baigoValidator => "true",
    upload         => "true",
    tokenReload    => "true",
    str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=cate"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl" cfg=$cfg}

    <li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=cate&act_get=list">{$adminMod.cate.main.title}</a></li>
    <li>{$title_sub}</li>

    {include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

    <div class="form-group">
        <ul class="nav nav-pills nav_baigo">
            <li>
                <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=cate&act_get=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    {$lang.href.back}
                </a>
            </li>
            <li>
                <a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=cate#form" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    {$lang.href.help}
                </a>
            </li>
        </ul>
    </div>

    <form name="cate_form" id="cate_form">
        <input type="hidden" name="{$common.tokenRow.name_session}" value="{$common.tokenRow.token}">
        <input type="hidden" name="act_post" value="submit">
        <input type="hidden" name="cate_id" id="cate_id" value="{$tplData.cateRow.cate_id}">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div id="group_cate_name">
                                <label class="control-label">{$lang.label.cateName}<span id="msg_cate_name">*</span></label>
                                <input type="text" name="cate_name" id="cate_name" value="{$tplData.cateRow.cate_name}" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_cate_alias">
                                <label class="control-label">{$lang.label.cateAlias}<span id="msg_cate_alias"></span></label>
                                <input type="text" name="cate_alias" id="cate_alias" value="{$tplData.cateRow.cate_alias}" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group" id="item_cate_perpage">
                            <div id="group_cate_perpage">
                                <label class="control-label">{$lang.label.catePerpage}<span id="msg_cate_perpage">*</span></label>
                                <input type="text" name="cate_perpage" id="cate_perpage" value="{$tplData.cateRow.cate_perpage}" data-validate class="form-control">
                            </div>
                        </div>

                        {if $tplData.cateRow.cate_parent_id < 1}
                            <div class="form-group">
                                <label class="control-label">{$lang.label.cateDomain}<span id="msg_cate_domain"></span></label>
                                <input type="text" name="cate_domain" id="cate_domain" value="{$tplData.cateRow.cate_domain}" data-validate class="form-control">
                                <p class="help-block">{$lang.label.cateDomainNote}</p>
                            </div>
                        {/if}

                        <div id="item_cate_content">
                            <label class="control-label">{$lang.label.cateContent}</label>
                            <div class="form-group">
                                <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=attach&act_get=form&view=iframe" class="btn btn-success btn-xs" data-toggle="modal" data-target="#cate_modal">
                                    <span class="glyphicon glyphicon-picture"></span>
                                    {$lang.href.uploadList}
                                </a>
                            </div>
                            <div class="form-group">
                                <textarea name="cate_content" id="cate_content" class="tinymce text_bg">{$tplData.cateRow.cate_content}</textarea>
                            </div>
                        </div>

                        <div class="form-group" id="item_cate_link">
                            <div id="group_cate_link">
                                <label class="control-label">{$lang.label.cateLink}<span id="msg_cate_link"></span></label>
                                <input type="text" name="cate_link" id="cate_link" value="{$tplData.cateRow.cate_link}" data-validate class="form-control">
                            </div>
                        </div>

                        {if $smarty.const.BG_MODULE_GEN > 0 && $smarty.const.BG_MODULE_FTP > 0 && $tplData.cateRow.cate_parent_id < 1}
                            <div class="form-group">
                                <label for="more_checkbox" class="checkbox-inline">
                                    <input type="checkbox" id="more_checkbox" name="more_checkbox" {if $tplData.cateRow.cate_ftp_host}checked{/if}>
                                    {$lang.label.more}
                                </label>
                            </div>

                            <div id="more_input">
                                <div class="form-group">
                                    <label class="control-label">{$lang.label.cateFtpServ}<span id="msg_cate_ftp_host"></span></label>
                                    <input type="text" name="cate_ftp_host" id="cate_ftp_host" value="{$tplData.cateRow.cate_ftp_host}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">{$lang.label.cateFtpPort}<span id="msg_cate_ftp_port"></span></label>
                                    <input type="text" name="cate_ftp_port" id="cate_ftp_port" value="{$tplData.cateRow.cate_ftp_port}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">{$lang.label.cateFtpUser}<span id="msg_cate_ftp_user"></span></label>
                                    <input type="text" name="cate_ftp_user" id="cate_ftp_user" value="{$tplData.cateRow.cate_ftp_user}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">{$lang.label.cateFtpPass}<span id="msg_cate_ftp_pass"></span></label>
                                    <input type="text" name="cate_ftp_pass" id="cate_ftp_pass" value="{$tplData.cateRow.cate_ftp_pass}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">{$lang.label.cateFtpPath}<span id="msg_cate_ftp_path"></span></label>
                                    <input type="text" name="cate_ftp_path" id="cate_ftp_path" value="{$tplData.cateRow.cate_ftp_path}" class="form-control">
                                    <p class="help-block">{$lang.label.cateFtpPathNote}</p>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">{$lang.label.cateFtpPasv}<span id="msg_cate_ftp_pasv"></span></label>
                                    {foreach $status.pasv as $key=>$value}
                                        <div class="radio_baigo">
                                            <label for="cate_ftp_pasv_{$key}">
                                                <input type="radio" name="cate_ftp_pasv" id="cate_ftp_pasv_{$key}" value="{$key}" {if $tplData.cateRow.cate_ftp_pasv == $key}checked{/if}>
                                                {$value}
                                            </label>
                                        </div>
                                    {/foreach}
                                </div>
                            </div>
                        {/if}

                        <div class="form-group">
                            <button type="button" class="go_submit btn btn-primary">{$lang.btn.submit}</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="well">
                    {if $tplData.cateRow.cate_id > 0}
                        <div class="form-group">
                            <label class="control-label">{$lang.label.id}</label>
                            <p class="form-control-static">{$tplData.cateRow.cate_id}</p>
                        </div>
                    {/if}

                    <div class="form-group">
                        <div id="group_cate_parent_id">
                            <label class="control-label">{$lang.label.cateParent}<span id="msg_cate_parent_id">*</span></label>
                            <select name="cate_parent_id" id="cate_parent_id" data-validate class="form-control">
                                <option value="">{$lang.option.pleaseSelect}</option>
                                <option {if $tplData.cateRow.cate_parent_id < 1}selected{/if} value="0">{$lang.option.asCateParent}</option>
                                {cate_list arr=$tplData.cateRows}
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="group_cate_tpl">
                            <label class="control-label">{$lang.label.tpl}<span id="msg_cate_tpl">*</span></label>
                            <select name="cate_tpl" id="cate_tpl" data-validate class="form-control">
                                <option value="">{$lang.option.pleaseSelect}</option>
                                <option {if isset($tplData.cateRow.cate_tpl) && $tplData.cateRow.cate_tpl == "inherit"}selected{/if} value="inherit">{$lang.option.tplInherit}</option>
                                {foreach $tplData.tplRows as $key=>$value}
                                    {if $value["type"] == "dir"}
                                        <option {if isset($tplData.cateRow.cate_tpl) && $tplData.cateRow.cate_tpl == $value.name}selected{/if} value="{$value.name}">{$value.name}</option>
                                    {/if}
                                {/foreach}
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="group_cate_type">
                            <label class="control-label">{$lang.label.cateType}<span id="msg_cate_type">*</span></label>
                            {foreach $type.cate as $key=>$value}
                                <div class="radio_baigo">
                                    <label for="cate_type_{$key}">
                                        <input type="radio" name="cate_type" id="cate_type_{$key}" value="{$key}" {if $tplData.cateRow.cate_type == $key}checked{/if} data-validate="cate_type">
                                        {$value}
                                    </label>
                                </div>
                            {/foreach}
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="group_cate_status">
                            <label class="control-label">{$lang.label.cateStatus}<span id="msg_cate_status">*</span></label>
                            {foreach $status.cate as $key=>$value}
                                <div class="radio_baigo">
                                    <label for="cate_status_{$key}">
                                        <input type="radio" name="cate_status" id="cate_status_{$key}" value="{$key}" {if $tplData.cateRow.cate_status == $key}checked{/if} data-validate="cate_status">
                                        {$value}
                                    </label>
                                </div>
                            {/foreach}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="cate_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_foot.tpl" cfg=$cfg}

    <script type="text/javascript">
    var opts_validator_form = {
        cate_name: {
            len: { min: 1, max: 300 },
            validate: { type: "ajax", format: "text", group: "#group_cate_name" },
            msg: { selector: "#msg_cate_name", too_short: "{$alert.x110201}", too_long: "{$alert.x110202}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
            ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=cate&act_get=chkname", key: "cate_name", type: "str", attach_selectors: ["#cate_id","#cate_parent_id"], attach_keys: ["cate_id","cate_parent_id"] }
        },
        cate_alias: {
            len: { min: 0, max: 300 },
            validate: { type: "ajax", format: "alias", group: "#group_cate_alias" },
            msg: { selector: "#msg_cate_alias", too_long: "{$alert.x110204}", format_err: "{$alert.x110205}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
            ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=cate&act_get=chkalias", key: "cate_alias", type: "str", attach_selectors: ["#cate_id","#cate_parent_id"], attach_keys: ["cate_id","cate_parent_id"] }
        },
        cate_link: {
            len: { min: 0, max: 3000 },
            validate: { type: "str", format: "text", group: "#group_cate_link" },
            msg: { selector: "#msg_cate_link", too_long: "{$alert.x110211}" }
        },
        cate_parent_id: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_cate_parent_id" },
            msg: { selector: "#msg_cate_parent_id", too_few: "{$alert.x110213}" }
        },
        cate_tpl: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_cate_tpl" },
            msg: { selector: "#msg_cate_tpl", too_few: "{$alert.x110214}" }
        },
        cate_type: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='cate_type']", type: "radio", group: "#group_cate_type" },
            msg: { selector: "#msg_cate_type", too_few: "{$alert.x110215}" }
        },
        cate_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='cate_status']", type: "radio", group: "#group_cate_status" },
            msg: { selector: "#msg_cate_status", too_few: "{$alert.x110216}" }
        },
        cate_domain: {
            len: { min: 0, max: 3000 },
            validate: { type: "str", format: "text" },
            msg: { selector: "#msg_cate_domain", too_long: "{$alert.x110207}", format_err: "{$alert.x110208}" }
        },
        cate_perpage: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "int", group: "#group_cate_perpage" },
            msg: { selector: "#msg_cate_perpage", too_short: "{$alert.x110223}", format_err: "{$alert.x110224}" }
        }
    };

    var opts_submit_form = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=cate",
        text_submitting: "{$lang.label.submitting}",
        btn_text: "{$lang.btn.ok}",
        btn_close: "{$lang.btn.close}",
        btn_url: "{$cfg.str_url}"
    };

    function cate_type(cate_type) {
        switch (cate_type) {
            case "single":
                $("#item_cate_perpage").hide();
                $("#item_cate_content").show();
                $("#item_cate_link").hide();
            break;

            case "link":
                $("#item_cate_perpage").hide();
                $("#item_cate_content").hide();
                $("#item_cate_link").show();
            break;

            case "normal":
                $("#item_cate_perpage").show();
                $("#item_cate_content").show();
                $("#item_cate_link").hide();
            break;

            default:
                $("#item_cate_perpage").show();
                $("#item_cate_content").show();
                $("#item_cate_link").hide();
            break;
        }
    }

    function show_more() {
        if ($("#more_checkbox").prop("checked")) {
            var _cate_parent = $("#cate_parent_id").val();
            if (_cate_parent < 1) {
                $("#more_input").show();
            } else {
                $("#more_input").hide();
            }
        } else {
            $("#more_input").hide();
        }
    }

    $(document).ready(function(){
        $("#cate_modal").on("hidden.bs.modal", function() {
            $(this).removeData("bs.modal");
        });
        cate_type("{$tplData.cateRow.cate_type}");
        show_more();
        $("#cate_parent_id").change(function(){
            show_more();
        });
        var obj_validate_form  = $("#cate_form").baigoValidator(opts_validator_form);
        var obj_submit_form    = $("#cate_form").baigoSubmit(opts_submit_form);
        $(".go_submit").click(function(){
            tinyMCE.triggerSave();
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });

        $("#more_checkbox").click(function(){
            show_more();
        });

        $("input[name='cate_type']").click(function(){
            var _cate_type = $(this).val();
            cate_type(_cate_type);
        });
    });
    </script>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}