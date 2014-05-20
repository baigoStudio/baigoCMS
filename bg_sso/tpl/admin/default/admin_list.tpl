{* admin_list.tpl 管理员列表 *}
{$cfg = [
	title          => $adminMod.admin.main.title,
	css            => "admin_list",
	menu_active    => "admin",
	sub_active     => "list",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	colorbox       => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=admin&{$tplData.query}"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<h5>
		<div>
			<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=admin&act_get=form">+ {$lang.href.add}</a>
		</div>
		<form name="admin_search" id="admin_search" action="{$smarty.const.BG_URL_ADMIN}admin.php" method="get">
			<input type="hidden" name="mod" value="admin" />
			<select name="status">
				<option value="">{$lang.option.allStatus}</option>
				{foreach $status.admin as $key=>$value}
					<option {if $tplData.search.status == $key}selected="selected"{/if} value="{$key}">{$value}</option>
				{/foreach}
			</select>
			<input type="text" name="key" value="{$tplData.search.key}" />
			<button type="submit">{$lang.btn.filter}</button>
		</form>
	</h5>

	<form name="admin_list" id="admin_list" class="tlist">

		<input type="hidden" name="token_session" value="{$common.token_session}" />

		<ul>
			<li class="thead">
				<ol>
					<li class="float_left">
						<div class="tmini">
							<input type="checkbox" name="chk_all" id="chk_all" class="first" />
							{$lang.label.all}
						</div>
						<div class="tmini">{$lang.label.id}</div>
						<div class="float_left">{$lang.label.admin}</div>
					</li>
					<li class="float_right">
						<div class="tshort">{$lang.label.status}</div>
					</li>
					<li class="float_clear"></li>
				</ol>
			</li>
			<li class="tbody">
				{foreach $tplData.adminRows as $value}
					<ol id="admin_list_{$value.admin_id}">
						<li class="float_left">
							<div class="tmini"><input type="checkbox" name="admin_id[]" value="{$value.admin_id}" id="admin_id_{$value.admin_id}" group="admin_id" class="validate chk_all" /></div>
							<div class="tmini">{$value.admin_id}</div>
							<div class="float_left">
								<div class="title {$value.admin_status}">
									{$value.admin_name} {if $value.admin_note}[ {$value.admin_note} ]{/if}
								</div>
								<div class="double">
									<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=admin&act_get=show&admin_id={$value.admin_id}">{$lang.href.show}</a>
									&#160;|&#160;
									<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=admin&act_get=form&admin_id={$value.admin_id}">{$lang.href.edit}</a>
								</div>
							</div>
						</li>
						<li class="float_right {$value.admin_status}">
							<div class="tshort">{$status.admin[$value.admin_status]}</div>
						</li>
						<li class="float_clear"></li>
					</ol>
				{/foreach}
			</li>
			<li class="tfoot">
				<ol>
					<li class="float_left">
						<div class="tshort"><span id="msg_admin_id"></span></div>
					</li>
					<li class="float_left">
						<div>
							<select name="act_post" id="act_post" class="validate">
								<option value="">{$lang.option.batch}</option>
								{foreach $status.admin as $key=>$value}
									<option value="{$key}">{$value}</option>
								{/foreach}
								<option value="del">{$lang.option.del}</option>
							</select>
							<button type="button" id="go_list">{$lang.btn.submit}</button>
							<span id="msg_act_post"></span>
						<div>
					</li>
					<li class="float_clear"></li>
				</ol>
			</li>
		</ul>
	</form>

	<h6>
		<ul>
			<li class="float_right">
				{include "include/page.tpl" cfg=$cfg}
			</li>
			<li class="float_clear"></li>
		</ul>
	</h6>

{include "include/admin_foot.tpl" cfg=$cfg}

<script type="text/javascript">
var opts_validator_list = {
	admin_id: {
		length: { min: 1, max: 0 },
		validate: { type: "checkbox" },
		msg: { id: "msg_admin_id", too_few: "{$alert.x030202}" }
	},
	act_post: {
		length: { min: 1, max: 0 },
		validate: { type: "select" },
		msg: { id: "msg_act_post", too_few: "{$alert.x030203}" }
	}
};
var opts_submit_list = {
	ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=admin",
	confirm_id: "act_post",
	confirm_val: "del",
	confirm_msg: "{$lang.confirm.del}",
	btn_text: "{$lang.btn.ok}",
	btn_url: "{$cfg.str_url}"
};

$(document).ready(function(){
	$(".chk_all").click(function(){
		var _admin_id = $(this).val();
		if ($(this).prop("checked")) {
			$("#admin_list_" + _admin_id).addClass("div_checked");
		} else {
			$("#admin_list_" + _admin_id).removeClass("div_checked");
		}
	});

	var obj_validator_list = $("#admin_list").baigoValidator(opts_validator_list);
	var obj_submit_list = $("#admin_list").baigoSubmit(opts_submit_list);
	$("#go_list").click(function(){
		if (obj_validator_list.validateSubmit()) {
			obj_submit_list.formSubmit();
		}
	});
	$("#admin_list").baigoCheckall();
})
</script>

{include "include/html_foot.tpl" cfg=$cfg}
