{* mark_list.tpl 标签列表 *}
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    {$adminMod.article.main.title} - {$adminMod.article.sub.mark.title}
</div>
<div class="modal-body">

    <form name="mark_form" id="mark_form">
        <input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
        <input type="hidden" name="mark_id" id="mark_id" value="{$tplData.markRow.mark_id}">
        <input type="hidden" name="act_post" value="submit">

        {if $tplData.markRow.mark_id > 0}
            <div class="form-group">
                <label class="control-label">{$lang.label.id}</label>
                <p class="form-control-static">{$tplData.markRow.mark_id}</p>
            </div>
        {/if}

        <div class="form-group">
            <label class="control-label">{$lang.label.markName}<span id="msg_mark_name">*</span></label>
            <input type="text" name="mark_name" id="mark_name" value="{$tplData.markRow.mark_name}" data-validate class="form-control">
        </div>
    </form>

    <div id="msg_submitting"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" id="mark_add">{$lang.btn.save}</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">{$lang.btn.cancel}</button>
</div>

<script type="text/javascript">
var opts_validator_form = {
    mark_name: {
        len: { min: 1, max: 30 },
        validate: { type: "ajax", format: "text" },
        msg: { selector: "#msg_mark_name", too_short: "{$alert.x140201}", too_long: "{$alert.x140202}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
        ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=mark&act_get=chkname", key: "mark_name", type: "str", attach_selectors: ["#mark_id"], attach_keys: ["mark_id"] }
    }
};

var opts_submit_form = {
    ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=mark",
    text_submitting: "{$lang.label.submitting}",
    btn_text: "{$lang.btn.ok}",
    btn_close: "{$lang.btn.close}",
    btn_url: "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=mark&act_get=list",
    btn_submit: "#mark_add",
    msg_box: "#msg_submitting"
};

$(document).ready(function(){
    var obj_validate_form = $("#mark_form").baigoValidator(opts_validator_form);
    var obj_submit_form   = $("#mark_form").baigoSubmit(opts_submit_form);
    $("#mark_add").click(function(){
        if (obj_validate_form.verify()) {
            obj_submit_form.formSubmit();
        }
    });
});
</script>

