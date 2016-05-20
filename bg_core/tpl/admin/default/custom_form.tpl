{* custom_list.tpl 标签列表 *}
{function custom_option arr=""}
    {foreach $arr as $key=>$value}
        <option value="{$value.custom_id}" {if $tplData.customRow.custom_parent_id == $value.custom_id}selected{/if} {if $tplData.customRow.custom_id == $value.custom_id}disabled{/if}>
            {if $value.custom_level > 1}
                {for $_i=2 to $value.custom_level}
                    &nbsp;&nbsp;
                {/for}
            {/if}
            {$value.custom_name}
        </option>

        {if $value.custom_childs}
            {custom_option arr=$value.custom_childs}
        {/if}
    {/foreach}
{/function}

{function cate_select arr="" level=""}
    {foreach $arr as $key=>$value}
        <option {if $value.cate_id == $tplData.customRow.custom_cate_id}selected{/if} value="{$value.cate_id}">
            {if $value.cate_level > 1}
                {for $_i=2 to $value.cate_level}
                    &nbsp;&nbsp;
                {/for}
            {/if}
            {$value.cate_name}
        </option>

        {if $value.cate_childs}
            {cate_select arr=$value.cate_childs level=$value.cate_level}
        {/if}
    {/foreach}
{/function}

{$cfg = [
    title          => "{$lang.page.opt} - {$lang.page.custom}",
    menu_active    => "opt",
    sub_active     => "custom",
    baigoValidator => "true",
    baigoSubmit    => "true",
    tokenReload    => "true",
    str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=custom"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl"}

    <li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=custom">{$lang.page.opt}</a></li>
    <li>{$lang.page.custom}</li>

    {include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

    <div class="form-group">
        <div class="pull-left">
            <div class="form-group">
                <ul class="nav nav-pills nav_baigo">
                    <li>
                        <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=custom&act_get=list">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                            {$lang.href.back}
                        </a>
                    </li>
                    <li>
                        <a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=custom" target="_blank">
                            <span class="glyphicon glyphicon-question-sign"></span>
                            {$lang.href.help}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    <form name="custom_form" id="custom_form">
        <input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
        <input type="hidden" name="custom_id" id="custom_id" value="{$tplData.customRow.custom_id}">
        <input type="hidden" name="act_post" value="submit">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div id="group_custom_name">
                                <label class="control-label">{$lang.label.customName}<span id="msg_custom_name">*</span></label>
                                <input type="text" name="custom_name" id="custom_name" value="{$tplData.customRow.custom_name}" data-validate class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_custom_parent_id">
                                <label class="control-label">{$lang.label.customParent}<span id="msg_custom_parent_id">*</span></label>
                                <select name="custom_parent_id" id="custom_parent_id" data-validate class="form-control">
                                    <option value="">{$lang.option.pleaseSelect}</option>
                                    <option {if $tplData.customRow.custom_parent_id == 0}selected{/if} value="0">{$lang.option.asCustomParent}</option>
                                    {custom_option arr=$tplData.customRows}
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_custom_type">
                                <label class="control-label">{$lang.label.type}<span id="msg_custom_type">*</span></label>
                                <select name="custom_type" id="custom_type" data-validate class="form-control">
                                    <option value="">{$lang.option.pleaseSelect}</option>
                                    {foreach $tplData.fields as $key=>$value}
                                        <option {if $tplData.customRow.custom_type == $key}selected{/if} value="{$key}">{$value["label"]}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>

                        {foreach $tplData.fields as $key_field=>$value_field}
                            {if $key_field == "radio" || $key_field == "select"}
                                <div id="group_{$key_field}" class="group_opt">
                                    <div id="group_{$key_field}_option">
                                        {foreach $value_field.option as $key_opt=>$value_opt}
                                            <div class="form-group" id="group_{$key_field}_{$key_opt}">
                                                <div class="input-group">
                                                    <input type="text" name="custom_opt[{$key_field}][{$key_opt}]" value="{$value_opt}" class="form-control">
                                                    <span class="input-group-btn">
                                                        <a class="btn btn-info" href="javascript:del_{$key_field}({$key_opt});">
                                                            <span class="glyphicon glyphicon-trash"></span>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        {/foreach}
                                    </div>

                                    <div class="form-group">
                                        <a class="btn btn-success" href="javascript:add_{$key_field}({$key_opt + 1});">
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </a>
                                    </div>
                                </div>
                            {/if}
                        {/foreach}

                        <div class="form-group">
                            <div id="group_custom_format">
                                <label class="control-label">{$lang.label.format}<span id="msg_custom_format">*</span></label>
                                <select name="custom_format" id="custom_format" data-validate class="form-control">
                                    <option value="">{$lang.option.pleaseSelect}</option>
                                    {foreach $type.custom as $key=>$value}
                                        <option {if $tplData.customRow.custom_format == $key}selected{/if} value="{$key}">{$value}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="button" id="custom_save" class="btn btn-primary">{$lang.btn.save}</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="well">
                    {if $tplData.customRow.custom_id > 0}
                        <div class="form-group">
                            <label class="control-label">{$lang.label.id}</label>
                            <p class="form-control-static">{$tplData.customRow.custom_id}</p>
                        </div>
                    {/if}

                    <div class="form-group">
                        <div id="group_custom_cate_id">
                            <label class="control-label">{$lang.label.customCate}<span id="msg_custom_cate_id">*</span></label>
                            <select name="custom_cate_id" id="custom_cate_id" data-validate class="form-control">
                                <option value="">{$lang.option.pleaseSelect}</option>
                                <option {if $tplData.customRow.custom_cate_id == 0}selected{/if} value="0">{$lang.option.allCate}</option>
                                {cate_select arr=$tplData.cateRows}
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="group_custom_status">
                            <label class="control-label">{$lang.label.status}<span id="msg_custom_status">*</span></label>
                            {foreach $status.custom as $key=>$value}
                                <div class="radio_baigo">
                                    <label for="custom_status_{$key}">
                                        <input type="radio" name="custom_status" id="custom_status_{$key}" value="{$key}" {if $tplData.customRow.custom_status == $key}checked{/if} data-validate="custom_status">
                                        {$value}
                                    </label>
                                </div>
                            {/foreach}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label for="custom_require">
                                <input type="checkbox" id="custom_require" name="custom_require" {if $tplData.customRow.custom_require == 1}checked{/if} value="1">
                                {$lang.label.require}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_foot.tpl"}

    <script type="text/javascript">
    var opts_validator_form = {
        custom_name: {
            len: { min: 1, max: 90 },
            validate: { type: "ajax", format: "text", group: "#group_custom_name" },
            msg: { selector: "#msg_custom_name", too_short: "{$alert.x200201}", too_long: "{$alert.x200202}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
            ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=custom&act_get=chkname", key: "custom_name", type: "str", attach_selectors: ["#custom_id","#custom_type"], attach_keys: ["custom_id","custom_type"] }
        },
        custom_type: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_custom_type" },
            msg: { selector: "#msg_custom_type", too_few: "{$alert.x200211}" }
        },
        custom_format: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_custom_format" },
            msg: { selector: "#msg_custom_format", too_few: "{$alert.x200205}" }
        },
        custom_parent_id: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_custom_parent_id" },
            msg: { selector: "#msg_custom_parent_id", too_few: "{$alert.x200207}" }
        },
        custom_cate_id: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_custom_cate_id" },
            msg: { selector: "#msg_custom_cate_id", too_few: "{$alert.x200213}" }
        },
        custom_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='custom_status']", type: "radio", group: "#group_custom_status" },
            msg: { selector: "#msg_custom_status", too_few: "{$alert.x200206}" }
        }
    };

    var opts_submit_form = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=custom",
        text_submitting: "{$lang.label.submitting}",
        btn_text: "{$lang.btn.ok}",
        btn_close: "{$lang.btn.close}",
        btn_url: "{$cfg.str_url}"
    };

    function custom_type(_custom_type) {
        $(".group_opt").hide();
        $("#group_" + _custom_type).show();
    }

    {foreach $tplData.fields as $key_field=>$value_field}
        {if $key_field == "radio" || $key_field == "select"}
            function del_{$key_field}(_radio_id) {
                $("#group_{$key_field}_" + _radio_id).remove();
            }

            function add_{$key_field}(_count) {
                $("#group_{$key_field}_option").append("<div class='form-group' id='group_{$key_field}_" + _count + "'>" +
                    "<div class='input-group'>" +
                        "<input type='text' name='custom_opt[{$key_field}][]' class='form-control'>" +
                        "<span class='input-group-btn'>" +
                            "<a class='btn btn-info' href='javascript:del_{$key_field}(" + _count + ");'>" +
                                "<span class='glyphicon glyphicon-trash'></span>" +
                            "</a>" +
                        "</span>" +
                    "</div>" +
                "</div>");
            }
        {/if}
    {/foreach}

    $(document).ready(function(){
        custom_type("{$tplData.customRow.custom_type}");
        var obj_validate_form = $("#custom_form").baigoValidator(opts_validator_form);
        var obj_submit_form   = $("#custom_form").baigoSubmit(opts_submit_form);
        $("#custom_save").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
        $("#custom_type").change(function(){
            var _this_val = $(this).val();
            if (_this_val.length > 0) {
                custom_type(_this_val);
            }
        });
    });
    </script>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}

