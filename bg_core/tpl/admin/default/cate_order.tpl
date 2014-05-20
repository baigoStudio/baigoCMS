{*cate_order.php 栏目编辑界面*}
{$cfg = [
	title          => $lang.page.admin,
	css            => "admin_iframe",
	colorbox       => "true",
	baigoSubmit    => "true",
	baigoValidator => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=cate"
]}

{include "include/iframe_head.tpl" cfg=$cfg}

	<h1>{$adminMod.cate.main.title} - {$lang.page.order}</h1>

	<form name="cate_order" id="cate_order">
		<input type="hidden" name="token_session" value="{$common.token_session}" />
		<input type="hidden" name="act_post" id="act_post" value="order" />
		<input type="hidden" name="cate_id" value="{$tplData.cateRow.cate_id}" />
		<input type="hidden" name="cate_parent_id" value="{$tplData.cateRow.cate_parent_id}" />

		<ul>
			<li class="title">{$lang.label.cateName}</li>
			<li class="title_b">{$tplData.cateRow.cate_name}</li>

			<li class="title">{$lang.label.order}<span id="msg_order_type">*</span></li>
			<li class="list">
				<label for="order_first">
					<input type="radio" name="order_type" id="order_first" value="order_first" class="validate" group="order_type" checked="checked" />
					{$lang.label.orderFirst}
				</label>
			</li>
			<li class="list">
				<label for="order_last">
					<input type="radio" name="order_type" id="order_last" value="order_last" class="validate" group="order_type" />
					{$lang.label.orderLast}
				</label>
			</li>
			<li class="list">
				<label for="order_before">
					<input type="radio" name="order_type" id="order_before" value="order_before" class="validate" group="order_type" />
					{$lang.label.orderBefore}
					<input type="text" name="order_target_before" />
				</label>
			</li>
			<li class="list">
				<label for="order_after">
					<input type="radio" name="order_type" id="order_after" value="order_after" class="validate" group="order_type" />
					{$lang.label.orderAfter}
					<input type="text" name="order_target_after" />
				</label>
			</li>

			<li><button type="button" id="go_submit">{$lang.btn.submit}</button></li>
		</ul>

	</form>

{include "include/iframe_foot.tpl" cfg=$cfg}

<script type="text/javascript">
var opts_validator_form = {
	order_type: {
		length: { min: 1, max: 0 },
		validate: { type: "radio" },
		msg: { id: "msg_order_type", too_short: "{$alert.x020101}" }
	}
};
var opts_submit_form = { ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=cate", btn_text: "{$lang.btn.ok}", btn_url: "{$cfg.str_url}" };

$(".c_iframe").colorbox({ iframe: true, width: "640px", height: "480px" });
$(document).ready(function(){
	var obj_validate_form = $("#cate_order").baigoValidator(opts_validator_form);
	var obj_submit_form = $("#cate_order").baigoSubmit(opts_submit_form);
	$("#go_submit").click(function(){
		if (obj_validate_form.validateSubmit()) {
			obj_submit_form.formSubmit();
		}
	});
})
</script>

{include "include/html_foot.tpl" cfg=$cfg}

