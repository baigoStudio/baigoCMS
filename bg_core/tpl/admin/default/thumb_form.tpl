<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    {$adminMod.attach.main.title} - {$adminMod.attach.sub.thumb.title}
</div>
<div class="modal-body">
    <form name="thumb_form" id="thumb_form">

        <input type="hidden" name="{$common.tokenRow.name_session}" value="{$common.tokenRow.token}">
        <input type="hidden" name="thumb_id" value="{$tplData.thumbRow.thumb_id}">
        <input type="hidden" name="act_post" value="submit">

        {if $tplData.thumbRow.thumb_id > 0}
            <div class="form-group">
                <label class="control-label">{$lang.label.id}</label>
                <p class="form-control-static">{$tplData.thumbRow.thumb_id}</p>
            </div>
        {/if}

        <div class="form-group">
            <label class="control-label">{$lang.label.thumbWidth}<span id="msg_thumb_width">*</span></label>
            <input type="text" name="thumb_width" id="thumb_width" value="{$tplData.thumbRow.thumb_width}" data-validate class="form-control">
        </div>

        <div class="form-group">
            <label class="control-label">{$lang.label.thumbHeight}<span id="msg_thumb_height">*</span></label>
            <input type="text" name="thumb_height" id="thumb_height" value="{$tplData.thumbRow.thumb_height}" data-validate class="form-control">
        </div>

        <div class="form-group">
            <div id="group_thumb_type">
                <label class="control-label">{$lang.label.thumbType}<span id="msg_thumb_type">*</span></label>
                {foreach $type.thumb as $key=>$value}
                    <div class="radio_baigo">
                        <label for="thumb_type_{$key}">
                            <input type="radio" name="thumb_type" id="thumb_type_{$key}" value="{$key}" {if $tplData.thumbRow.thumb_type == $key}checked{/if} data-validate="thumb_type">
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
    <button type="button" class="btn btn-primary" id="thumb_add">{$lang.btn.save}</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">{$lang.btn.cancel}</button>
</div>

<script type="text/javascript">
var opts_validator_form = {
    thumb_width: {
        len: { min: 1, max: 0 },
        validate: { type: "str", format: "int" },
        msg: { selector: "#msg_thumb_width", too_short: "{$alert.x090201}", format_err: "{$alert.x090202}" }
    },
    thumb_height: {
        len: { min: 1, max: 0 },
        validate: { type: "str", format: "int" },
        msg: { selector: "#msg_thumb_height", too_short: "{$alert.x090203}", format_err: "{$alert.x090204}" }
    },
    thumb_type: {
        len: { min: 1, max: 0 },
        validate: { selector: "input[name='thumb_type']", type: "radio", group: "#group_thumb_type" },
        msg: { selector: "#msg_thumb_type", too_few: "{$alert.x090205}" }
    }
};

var opts_submit_form = {
    ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=thumb",
    text_submitting: "{$lang.label.submitting}",
    btn_text: "{$lang.btn.ok}",
    btn_close: "{$lang.btn.close}",
    btn_url: "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=thumb&act_get=list",
    btn_submit: "#thumb_add",
    msg_box: "#msg_submitting"
};

$(document).ready(function(){
    var obj_validate_form = $("#thumb_form").baigoValidator(opts_validator_form);
    var obj_submit_form   = $("#thumb_form").baigoSubmit(opts_submit_form);
    $("#thumb_add").click(function(){
        if (obj_validate_form.verify()) {
            obj_submit_form.formSubmit();
        }
    });
});
</script>