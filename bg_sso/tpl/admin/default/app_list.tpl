{* admin_list.tpl 管理员列表 *}
{$cfg = [
	title          => $adminMod.app.main.title,
	css            => "admin_list",
	menu_active    => "app",
	sub_active     => "list",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	colorbox       => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=app&{$tplData.query}"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<h5>
		<div><a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=app&act_get=form">+ {$lang.href.add}</a></div>
		<form name="app_search" id="app_search" action="{$smarty.const.BG_URL_ADMIN}admin.php" method="get">
			<input type="hidden" name="mod" value="app" />
			<select name="status">
				<option value="">{$lang.option.allStatus}</option>
				{foreach $status.app as $key=>$value}
					<option {if $tplData.search.status == $key}selected="selected"{/if} value="{$key}">{$value}</option>
				{/foreach}
			</select>
			<input type="text" name="key" value="{$tplData.search.key}" />
			<button type="submit">{$lang.btn.filter}</button>
		</form>
	</h5>

	<form name="app_list" id="app_list" class="tlist">

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
						<div class="float_left">{$lang.label.appName}</div>
					</li>
					<li class="float_right">
						<div class="tmiddle">{$lang.label.note}</div>
						<div class="tshort">{$lang.label.status}</div>
					</li>
					<li class="float_clear"></li>
				</ol>
			</li>
			<li class="tbody">
				{foreach $tplData.appRows as $value}
					<ol id="app_list_{$value.app_id}">
						<li class="float_left">
							<div class="tmini"><input type="checkbox" name="app_id[]" value="{$value.app_id}" id="app_id_{$value.app_id}" group="app_id" class="validate chk_all" /></div>
							<div class="tmini">{$value.app_id}</div>
							<div class="float_left">
								<div class="title {$value.app_status}">{$value.app_name}</div>
								<div class="double">
									<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=app&act_get=show&app_id={$value.app_id}">{$lang.href.show}</a>
									&#160;|&#160;
									<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=app&act_get=form&app_id={$value.app_id}">{$lang.href.edit}</a>
									&#160;|&#160;
									<a href="javascript:void(0);" class="go_notice" id="{$value.app_id}">{$lang.href.noticeTest}</a>
								</div>
							</div>
						</li>
						<li class="float_right {$value.app_status}">
							<div class="tmiddle">
								{$value.app_note}
							</div>
							<div class="tshort">{$status.app[$value.app_status]}</div>
						</li>
						<li class="float_clear"></li>
					</ol>
				{/foreach}
			</li>
			<li class="tfoot">
				<ol>
					<li class="float_left">
						<div class="tshort"><span id="msg_app_id"></span></div>
					</li>
					<li class="float_left">
						<div>
							<select name="act_post" id="act_post" class="validate">
								<option value="">{$lang.option.batch}</option>
								{foreach $status.app as $key=>$value}
									<option value="{$key}">{$value}</option>
								{/foreach}
								<option value="del">{$lang.option.del}</option>
							</select>
							<button type="button" id="go_list">{$lang.btn.submit}</button>
							<span id="msg_act_post"></span>
						</div>
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

	<form name="app_notice" id="app_notice">
		<input type="hidden" name="act_post" value="notice" />
		<input type="hidden" name="app_id_notice" id="app_id_notice" value="" />
	</form>

{include "include/admin_foot.tpl" cfg=$cfg}

<script type="text/javascript">
var opts_validator_list = {
	app_id: {
		length: { min: 1, max: 0 },
		validate: { type: "checkbox" },
		msg: { id: "msg_app_id", too_few: "{$alert.x030202}" }
	},
	act_post: {
		length: { min: 1, max: 0 },
		validate: { type: "select" },
		msg: { id: "msg_act_post", too_few: "{$alert.x030203}" }
	}
};
var opts_submit_list = {
	ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=app",
	confirm_id: "act_post",
	confirm_val: "del",
	confirm_msg: "{$lang.confirm.del}",
	btn_text: "{$lang.btn.ok}",
	btn_url: "{$cfg.str_url}"
};

var opts_submit_notice = { ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=app", type: "post" };

$(document).ready(function(){
	$(".chk_all").click(function(){
		var _app_id = $(this).val();
		if ($(this).prop("checked")) {
			$("#app_list_" + _app_id).addClass("div_checked");
		} else {
			$("#app_list_" + _app_id).removeClass("div_checked");
		}
	});

	var obj_validator_list = $("#app_list").baigoValidator(opts_validator_list);
	var obj_submit_list = $("#app_list").baigoSubmit(opts_submit_list);
	$("#go_list").click(function(){
		if (obj_validator_list.validateSubmit()) {
			obj_submit_list.formSubmit();
		}
	});

	var obj_notice = $("#app_notice").baigoSubmit(opts_submit_notice);
	$(".go_notice").click(function(){
		var __id = $(this).attr("id");
		$("#app_id_notice").val(__id);
		obj_notice.formSubmit();
	});
	$("#app_list").baigoCheckall();
})
</script>

{include "include/html_foot.tpl" cfg=$cfg}