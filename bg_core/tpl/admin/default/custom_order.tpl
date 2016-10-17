<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    {$lang.page.custom} - {$lang.page.order}
</div>
<div class="modal-body">
    <form name="custom_order" id="custom_order" class="form_input">
        <input type="hidden" name="{$common.tokenRow.name_session}" value="{$common.tokenRow.token}">
        <input type="hidden" name="act_post" value="order">
        <input type="hidden" name="custom_id" value="{$tplData.customRow.custom_id}">
        <input type="hidden" name="custom_parent_id" value="{$tplData.customRow.custom_parent_id}">

        <div class="form-group">
            <label class="control-label">{$lang.label.id}</label>
            <p class="form-control-static">{$tplData.customRow.custom_id}</p>
        </div>

        <div class="form-group">
            <label class="control-label">{$lang.label.customName}</label>
            <p class="form-control-static">{$tplData.customRow.custom_name}</p>
        </div>

        <div class="form-group">
            <div id="group_order_type">
                <label class="control-label">{$lang.label.order}<span id="msg_order_type">*</span></label>
                <div class="radio">
                    <label for="order_first">
                        <input type="radio" name="order_type" id="order_first" value="order_first" checked data-validate="order_type">
                        {$lang.label.orderFirst}
                    </label>
                </div>
                <div class="radio">
                    <label for="order_last">
                        <input type="radio" name="order_type" id="order_last" value="order_last" data-validate="order_type">
                        {$lang.label.orderLast}
                    </label>
                </div>
                <div class="radio">
                    <label for="order_after">
                        <input type="radio" name="order_type" id="order_after" value="order_after" data-validate="order_type">
                        <input type="text" name="order_target" class="form-control" placeholder="{$lang.label.orderAfter}">
                    </label>
                </div>
            </div>
        </div>
    </form>

    <div id="msg_submitting"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" id="go_order">{$lang.btn.save}</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">{$lang.btn.cancel}</button>
</div>

<script type="text/javascript">
var opts_validator_order = {
    order_type: {
        len: { min: 1, max: 0 },
        validate: { selector: "input[name='order_type']", type: "radio", group: "#group_order_type" },
        msg: { selector: "#msg_order_type", too_few: "{$alert.x200210}" }
    }
};

var opts_submit_order = {
    ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=custom",
    text_submitting: "{$lang.label.submitting}",
    btn_text: "{$lang.btn.ok}",
    btn_url: "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=custom",
    btn_close: "{$lang.btn.close}",
    btn_submit: "#go_order",
    msg_box: "#msg_submitting"
};

$(document).ready(function(){
    var obj_validate_order = $("#custom_order").baigoValidator(opts_validator_order);
    var obj_submit_order   = $("#custom_order").baigoSubmit(opts_submit_order);
    $("#go_order").click(function(){
        if (obj_validate_order.verify()) {
            obj_submit_order.formSubmit();
        }
    });
});
</script>