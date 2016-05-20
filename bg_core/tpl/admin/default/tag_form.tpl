{* tag_list.tpl 标签列表 *}
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    {$adminMod.article.main.title} - {$adminMod.article.sub.tag.title}
</div>
<div class="modal-body">

    <form name="tag_form" id="tag_form">
        <input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
        <input type="hidden" name="tag_id" id="tag_id" value="{$tplData.tagRow.tag_id}">
        <input type="hidden" name="act_post" value="submit">
        {if $tplData.tagRow.tag_id > 0}
            <div class="form-group">
                <label class="control-label">{$lang.label.id}</label>
                <p class="form-control-static">{$tplData.tagRow.tag_id}</p>
            </div>
        {/if}

        <div class="form-group">
            <label class="control-label">{$lang.label.tagName}<span id="msg_tag_name">*</span></label>
            <input type="text" value="{$tplData.tagRow.tag_name}" name="tag_name" id="tag_name" data-validate class="form-control">
        </div>

        <div class="form-group">
            <div id="group_tag_status">
                <label class="control-label">{$lang.label.status}<span id="msg_tag_status">*</span></label>
                {foreach $status.tag as $key=>$value}
                    <div class="radio_baigo">
                        <label for="tag_status_{$key}">
                            <input type="radio" name="tag_status" id="tag_status_{$key}" {if $tplData.tagRow.tag_status == $key}checked{/if} value="{$key}" data-validate="tag_status">
                            {$value}
                        </label>
                    </div>
                {/foreach}
            </div>
        </div>
    </form>

    <div id="msg_submitting"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" id="tag_add">{$lang.btn.save}</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">{$lang.btn.cancel}</button>
</div>

<script type="text/javascript">
var opts_validator_form = {
    tag_name: {
        len: { min: 1, max: 30 },
        validate: { type: "ajax", format: "text" },
        msg: { selector: "#msg_tag_name", too_short: "{$alert.x130201}", too_long: "{$alert.x130202}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
        ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=tag&act_get=chkname", key: "tag_name", type: "str", attach_selectors: ["#tag_id"], attach_keys: ["tag_id"] }
    },
    tag_status: {
        len: { min: 1, max: 0 },
        validate: { selector: "input[name='tag_status']", type: "radio", group: "#group_tag_status" },
        msg: { selector: "#msg_tag_status", too_few: "{$alert.x130204}" }
    }
};

var opts_submit_form = {
    ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=tag",
    text_submitting: "{$lang.label.submitting}",
    btn_text: "{$lang.btn.ok}",
    btn_close: "{$lang.btn.close}",
    btn_url: "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=tag&act_get=list",
    btn_submit: "#tag_add",
    msg_box: "#msg_submitting"
};

$(document).ready(function(){
    var obj_validate_form = $("#tag_form").baigoValidator(opts_validator_form);
    var obj_submit_form   = $("#tag_form").baigoSubmit(opts_submit_form);
    $("#tag_add").click(function(){
        if (obj_validate_form.verify()) {
            obj_submit_form.formSubmit();
        }
    });
});
</script>
