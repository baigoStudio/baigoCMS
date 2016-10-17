<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    {$adminMod.attach.main.title} - {$adminMod.attach.sub.mime.title}
</div>
<div class="modal-body">

    <form name="mime_form" id="mime_form">
        <input type="hidden" name="{$common.tokenRow.name_session}" value="{$common.tokenRow.token}">
        <input type="hidden" name="mime_id" id="mime_id" value="{$tplData.mimeRow.mime_id}">
        <input type="hidden" name="act_post" value="submit">

        {if $tplData.mimeRow.mime_id > 0}
            <div class="form-group">
                <label class="control-label">{$lang.label.id}</label>
                <p class="form-control-static">{$tplData.mimeRow.mime_id}</p>
            </div>
        {/if}

        <div class="form-group">
            <label class="control-label">{$lang.label.mimeName}<span id="msg_mime_name">*</span></label>
            <input type="text" name="mime_name" id="mime_name" value="{$tplData.mimeRow.mime_name}" data-validate class="form-control">
        </div>

        <div class="form-group">
            <label class="control-label">{$lang.label.ext}<span id="msg_mime_ext">*</span></label>
            <input type="text" name="mime_ext" id="mime_ext" value="{$tplData.mimeRow.mime_ext}" data-validate class="form-control">
        </div>

        <div class="form-group">
            <label class="control-label">{$lang.label.note}<span id="msg_mime_note"></span></label>
            <input type="text" name="mime_note" id="mime_note" value="{$tplData.mimeRow.mime_note}" data-validate class="form-control">
        </div>

        <div class="form-group">
            <label class="control-label">{$lang.label.mimeOften}</label>
            <select id="mime_name_often" class="form-control">
                <option value="">{$lang.option.pleaseSelect}</option>
                {foreach $tplData.mimeOften as $key=>$value}
                    <option value="{$key}">{$key} [{$value.note}]</option>
                {/foreach}
            </select>
        </div>

    </form>

    <div id="msg_submitting"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" id="mime_add">{$lang.btn.save}</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">{$lang.btn.cancel}</button>
</div>

<script type="text/javascript">
var obj_mime_list = {$tplData.mimeJson};

var opts_validator_form = {
    mime_name: {
        len: { min: 1, max: 300 },
        validate: { type: "ajax", format: "text" },
        msg: { selector: "#msg_mime_name", too_short: "{$alert.x080201}", too_long: "{$alert.x080202}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
        ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=mime&act_get=chkname", key: "mime_name", type: "str" }
    },
    mime_ext: {
        len: { min: 1, max: 10 },
        validate: { type: "str", format: "text" },
        msg: { selector: "#msg_mime_ext", too_short: "{$alert.x080203}", too_long: "{$alert.x080204}" }
    },
    mime_note: {
        len: { min: 0, max: 300 },
        validate: { type: "str", format: "text" },
        msg: { selector: "#msg_mime_note", too_long: "{$alert.x080205}" }
    }
};

var opts_submit_form = {
    ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=mime",
    text_submitting: "{$lang.label.submitting}",
    btn_text: "{$lang.btn.ok}",
    btn_close: "{$lang.btn.close}",
    btn_url: "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=mime&act_get=list",
    btn_submit: "#mime_add",
    msg_box: "#msg_submitting"
};

$(document).ready(function(){
    var obj_validate_form = $("#mime_form").baigoValidator(opts_validator_form);
    var obj_submit_form = $("#mime_form").baigoSubmit(opts_submit_form);
    $("#mime_add").click(function(){
        if (obj_validate_form.verify()) {
            obj_submit_form.formSubmit();
        }
    });
    //常用MIME
    $("#mime_name_often").change(function(){
        var _this_val = $(this).val();
        if (_this_val.length > 0) {
            var _this_ext = obj_mime_list[_this_val].ext;
            var _this_note = obj_mime_list[_this_val].note;
            $("#mime_name").val(_this_val);
            $("#mime_ext").val(_this_ext);
            $("#mime_note").val(_this_note);
        }
    });
});
</script>