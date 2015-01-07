{*cate_order.php 栏目编辑界面*}
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	{$adminMod.cate.main.title} - {$lang.page.order}
</div>
<div class="modal-body">

	<form name="cate_order" id="cate_order" class="form_input">
		<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
		<input type="hidden" name="act_post" id="act_post" value="order">
		<input type="hidden" name="cate_id" value="{$tplData.cateRow.cate_id}">

		<div class="form-group">
			<label class="control-label">{$lang.label.id}</label>
			<p class="form-control-static">{$tplData.cateRow.cate_id}</p>
		</div>

		<div class="form-group">
			<label class="control-label">{$lang.label.cateName}</label>
			<p class="form-control-static">{$tplData.cateRow.cate_name}</p>
		</div>

		<div class="form-group">
			<label class="control-label">{$lang.label.order}<span id="msg_order_type">*</span></label>
			<div class="radio">
				<label for="order_first">
					<input type="radio" name="order_type" id="order_first" value="order_first" class="validate" checked group="order_type">
					{$lang.label.orderFirst}
				</label>
			</div>
			<div class="radio">
				<label for="order_last">
					<input type="radio" name="order_type" id="order_last" value="order_last" class="validate" group="order_type">
					{$lang.label.orderLast}
				</label>
			</div>
			<div class="radio">
				<label for="order_after">
					<input type="radio" name="order_type" id="order_after" value="order_after" class="validate" group="order_type">
					<input type="text" name="order_target" class="form-control" placeholder="{$lang.label.orderAfter}">
				</label>
			</div>
		</div>
	</form>

</div>
<div class="modal-footer">
	<button type="button" class="btn btn-primary" id="go_order">{$lang.btn.save}</button>
	<button type="button" class="btn btn-default" data-dismiss="modal">{$lang.btn.cancel}</button>
</div>

<script type="text/javascript">
var opts_validator_order = {
	order_type: {
		length: { min: 1, max: 0 },
		validate: { type: "radio",  },
		msg: { id: "msg_order_type", too_few: "{$alert.x110212}" }
	}
};

var opts_submit_order = {
	ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=cate",
	btn_text: "{$lang.btn.ok}",
	btn_url: "{$cfg.str_url}",
	btn_close: "{$lang.btn.close}"
};

$(document).ready(function(){
	var obj_validate_order = $("#cate_order").baigoValidator(opts_validator_order);
	var obj_submit_order = $("#cate_order").baigoSubmit(opts_submit_order);
	$("#go_order").click(function(){
		if (obj_validate_order.validateSubmit()) {
			obj_submit_order.formSubmit();
		}
	});
});
</script>