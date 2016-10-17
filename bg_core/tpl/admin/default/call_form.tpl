{function cate_checkbox arr="" level=""}
    <ul class="list-unstyled{if $level > 0} list_padding{/if}">
        {foreach $arr as $key=>$value}
            <li>
                <div class="checkbox_baigo">
                    <label for="call_cate_ids_{$value.cate_id}">
                        <input type="checkbox" {if $value.cate_id|in_array:$tplData.callRow.call_cate_ids}checked{/if} value="{$value.cate_id}" name="call_cate_ids[]" id="call_cate_ids_{$value.cate_id}" data-parent="call_cate_ids_{$value.cate_parent_id}" {if $value.cate_type != "normal"}disabled{/if}>
                        {$value.cate_name}
                    </label>
                </div>
                {if $value.cate_childs}
                    {cate_checkbox arr=$value.cate_childs level=$value.cate_level}
                {/if}
            </li>
        {/foreach}
    </ul>
{/function}

{function cate_radio arr="" level=""}
    <ul class="list-unstyled{if $level > 0} list_padding{/if}">
        {foreach $arr as $key=>$value}
            <li>
                <div class="radio_baigo">
                    <label for="call_cate_id_{$value.cate_id}">
                        <input type="radio" {if $tplData.callRow.call_cate_id == $value.cate_id}checked{/if} value="{$value.cate_id}" name="call_cate_id" id="call_cate_id_{$value.cate_id}" {if !$value.cate_childs}disabled{/if}>
                        {$value.cate_name}
                    </label>

                    <label for="call_cate_excepts_{$value.cate_id}">
                        <input type="checkbox" {if $value.cate_id|in_array:$tplData.callRow.call_cate_excepts}checked{/if} value="{$value.cate_id}" name="call_cate_excepts[]" id="call_cate_excepts_{$value.cate_id}">
                        {$lang.label.except}
                    </label>
                </div>

                {if $value.cate_childs}
                    {cate_radio arr=$value.cate_childs level=$value.cate_level}
                {/if}
            </li>
        {/foreach}
    </ul>
{/function}

{if $tplData.callRow.call_id < 1}
    {$title_sub = $lang.page.add}
    {$sub_active = "form"}
{else}
    {$title_sub = $lang.page.edit}
    {$sub_active = "list"}
{/if}

{$cfg = [
    title          => "{$adminMod.call.main.title} - {$title_sub}",
    menu_active    => "call",
    sub_active     => $sub_active,
    baigoCheckall  => "true",
    baigoValidator => "true",
    baigoSubmit    => "true",
    tokenReload    => "true",
    str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=call"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl" cfg=$cfg}

    <li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=call&act_get=list">{$adminMod.call.main.title}</a></li>
    <li>{$title_sub}</li>

    {include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

    <div class="form-group">
        <ul class="nav nav-pills nav_baigo">
            <li>
                <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=call&act_get=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    {$lang.href.back}
                </a>
            </li>
            <li>
                <a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=call#form" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    {$lang.href.help}
                </a>
            </li>
        </ul>
    </div>

    <form name="call_form" id="call_form">
        <input type="hidden" name="{$common.tokenRow.name_session}" value="{$common.tokenRow.token}">
        <input type="hidden" name="act_post" value="submit">
        <input type="hidden" name="call_id" id="call_id" value="{$tplData.callRow.call_id}">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div id="group_call_name">
                                <label class="control-label">{$lang.label.callName}<span id="msg_call_name">*</span></label>
                                <input type="text" name="call_name" id="call_name" value="{$tplData.callRow.call_name}" data-validate class="form-control">
                            </div>
                        </div>

                        <div id="call_article">
                            <div class="alert alert-success">{$lang.label.callFilter}</div>

                            <div class="form-group">
                                <label class="control-label">{$lang.label.callCate}</label>
                                <div class="checkbox_baigo">
                                    <label for="call_cate_ids_0">
                                        <input type="checkbox" id="call_cate_ids_0" data-parent="first">
                                        {$lang.label.cateAll}
                                    </label>
                                </div>
                                {cate_checkbox arr=$tplData.cateRows}
                            </div>

                            <div class="form-group">
                                <label class="control-label">{$lang.label.articleSpec}</label>
                                <div class="input-group">
                                    <input type="text" id="spec_key" name="spec_key" placeholder="{$lang.label.key}" class="form-control">
                                    <span class="input-group-btn">
                                        <button class="btn btn-info" type="button" id="spec_search_btn">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </button>
                                    </span>
                                </div>
                                <div id="spec_check_list">
                                    {foreach $tplData.specRows as $key=>$value}
                                        <div class="checkbox" id="spec_checkbox_{$value.spec_id}">
                                            <label for="call_spec_ids_{$value.spec_id}">
                                                <input type="checkbox" id="call_spec_ids_{$value.spec_id}" checked name="call_spec_ids[]" value="{$value.spec_id}">
                                                {$value.spec_name}
                                            </label>
                                        </div>
                                    {/foreach}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">{$lang.label.callAttach}</label>
                                <select id="call_attach" name="call_attach" class="form-control">
                                    {foreach $type.callAttach as $key=>$value}
                                        <option {if $tplData.callRow.call_attach == $key}selected{/if} value="{$key}">{$value}</option>
                                    {/foreach}
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="control-label">{$lang.label.callMark}<span id="msg_call_mark_ids"></span></label>
                                {foreach $tplData.markRows as $key=>$value}
                                    <div class="checkbox_baigo">
                                        <label for="call_mark_ids_{$value.mark_id}">
                                            <input type="checkbox" {if $value.mark_id|in_array:$tplData.callRow.call_mark_ids}checked{/if} value="{$value.mark_id}" name="call_mark_ids[]" id="call_mark_ids_{$value.mark_id}">
                                            {$value.mark_name}
                                        </label>
                                    </div>
                                {/foreach}
                            </div>
                        </div>

                        <div id="call_cate">
                            <div class="alert alert-success">{$lang.label.callFilter}</div>

                            <div class="form-group">
                                <label class="control-label">{$lang.label.callCate}</label>
                                <div class="radio_baigo">
                                    <label for="call_cate_id_0">
                                        <input type="radio" {if $tplData.callRow.call_cate_id < 1}checked{/if} value="0" name="call_cate_id" id="call_cate_id_0">
                                        {$lang.label.cateAll}
                                    </label>
                                </div>
                                {cate_radio arr=$tplData.cateRows}
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="button" class="go_submit btn btn-primary">{$lang.btn.submit}</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="well">
                    {if $tplData.callRow.call_id > 0}
                        <div class="form-group">
                            <label class="control-label">{$lang.label.id}</label>
                            <p class="form-control-static">{$tplData.callRow.call_id}</p>
                        </div>
                    {/if}

                    <div class="form-group">
                        <div id="group_call_type">
                            <label class="control-label">{$lang.label.callType}<span id="msg_call_type">*</span></label>
                            <select id="call_type" name="call_type" data-validate class="form-control">
                                <option value="">{$lang.option.pleaseSelect}</option>
                                {foreach $type.call as $key=>$value}
                                    <option {if $tplData.callRow.call_type == $key}selected{/if} value="{$key}">{$value}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>

                    {if $smarty.const.BG_MODULE_GEN > 0 && $smarty.const.BG_VISIT_TYPE == "static"}
                        <div class="form-group">
                            <div id="group_call_file">
                                <label class="control-label">{$lang.label.callFile}<span id="msg_call_file">*</span></label>
                                <select name="call_file" id="call_file" data-validate class="form-control">
                                    <option value="">{$lang.option.pleaseSelect}</option>
                                    {foreach $type.callFile as $key=>$value}
                                        <option {if $tplData.callRow.call_file == $key}selected{/if} value="{$key}">{$value}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="group_call_tpl">
                                <label class="control-label">{$lang.label.callTpl}<span id="msg_call_tpl">*</span></label>
                                <select name="call_tpl" id="call_tpl" data-validate class="form-control">
                                    <option value="">{$lang.option.pleaseSelect}</option>
                                    {foreach $tplData.tplRows as $key=>$value}
                                        {if $value["type"] == "file"}
                                            <option {if $tplData.callRow.call_tpl == $value.name}selected{/if} value="{$value.name}">{$value.name}</option>
                                        {/if}
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                    {/if}

                    <div class="form-group">
                        <div id="group_call_status">
                            <label class="control-label">{$lang.label.status}<span id="msg_call_status">*</span></label>
                            {foreach $status.call as $key=>$value}
                                <div class="radio_baigo">
                                    <label for="call_status_{$key}">
                                        <input type="radio" name="call_status" id="call_status_{$key}" value="{$key}" {if $tplData.callRow.call_status == $key}checked{/if} data-validate="call_status">
                                        {$value}
                                    </label>
                                </div>
                            {/foreach}
                        </div>
                    </div>

                    <div class="alert alert-success">{$lang.label.callAmount}</div>

                    <div class="form-group">
                        <label class="control-label">{$lang.label.callAmoutTop}<span id="msg_call_amount_top">*</span></label>
                        <input type="text" name="call_amount[top]" id="call_amount_top" value="{$tplData.callRow.call_amount.top}" data-validate class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="control-label">{$lang.label.callAmoutExcept}<span id="msg_call_amount_except">*</span></label>
                        <input type="text" name="call_amount[except]" id="call_amount_except" value="{$tplData.callRow.call_amount.except}" data-validate class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="call_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_foot.tpl" cfg=$cfg}

    <script type="text/javascript">
    var opts_validator_form = {
        call_name: {
            len: { min: 1, max: 300 },
            validate: { type: "ajax", format: "text", group: "#group_call_name" },
            msg: { selector: "#msg_call_name", too_short: "{$alert.x170201}", too_long: "{$alert.x170202}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
            ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=call&act_get=chkname", key: "call_name", type: "str", attach_selectors: ["#call_id"], attach_keys: ["call_id"] }
        },
        call_type: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_call_type" },
            msg: { selector: "#msg_call_type", too_few: "{$alert.x170204}" }
        },
        call_file: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_call_file" },
            msg: { selector: "#msg_call_file", too_few: "{$alert.x170205}" }
        },
        call_tpl: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_call_tpl" },
            msg: { selector: "#msg_call_tpl", too_few: "{$alert.x170217}" }
        },
        call_status: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='call_status']", type: "radio", group: "#group_call_status" },
            msg: { selector: "#msg_call_status", too_few: "{$alert.x170206}" }
        },
        call_amount_top: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "int" },
            msg: { selector: "#msg_call_amount_top", too_short: "{$alert.x170207}", format_err: "{$alert.x170208}" }
        },
        call_amount_except: {
            len: { min: 1, max: 0 },
            validate: { type: "str", format: "int" },
            msg: { selector: "#msg_call_amount_except", too_short: "{$alert.x170209}", format_err: "{$alert.x170210}" }
        }
    };

    var opts_submit_form = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=call",
        text_submitting: "{$lang.label.submitting}",
        btn_text: "{$lang.btn.ok}",
        btn_close: "{$lang.btn.close}",
        btn_url: "{$cfg.str_url}"
    };

    function call_type(call_type) {
        switch (call_type) {
            case "cate":
                $("#call_article").hide();
                $("#call_cate").show();
            break;

            case "spec":
            case "tag_list":
            case "tag_rank":
                $("#call_article").hide();
                $("#call_cate").hide();
            break;

            default:
                $("#call_article").show();
                $("#call_cate").hide();
            break;
        }
    }

    $(document).ready(function(){
        call_type("{$tplData.callRow.call_type}");
        var obj_validate_form = $("#call_form").baigoValidator(opts_validator_form);
        var obj_submit_form   = $("#call_form").baigoSubmit(opts_submit_form);
        $(".go_submit").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });
        $("#call_type").change(function(){
            var _call_type = $(this).val();
            call_type(_call_type);
        });

        $("#call_form").baigoCheckall();

        $("#spec_search_btn").click(function(){
            var _spec_key = $("#spec_key").val();
            $("#call_modal").modal({ remote: "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=spec&act_get=insert&target=call&call_id={$tplData.callRow.call_id}&view=iframe&key=" + _spec_key });
        });
    });
    </script>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}