{* log_list.tpl 管理员列表 *}
{$cfg = [
	title          => $adminMod.log.main.title,
	css            => "admin_list",
	menu_active    => "log",
	sub_active     => "list",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	colorbox       => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=log&{$tplData.query}"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<h5>
		<form name="log_search" id="log_search" action="{$smarty.const.BG_URL_ADMIN}admin.php" method="get">
			<input type="hidden" name="mod" value="log" />
			<select name="type">
				<option value="">{$lang.option.allType}</option>
				{foreach $type.log as $key=>$value}
					<option {if $tplData.search.type == $key}selected="selected"{/if} value="{$key}">{$value}</option>
				{/foreach}
			</select>
			<select name="status">
				<option value="">{$lang.option.allStatus}</option>
				{foreach $status.log as $key=>$value}
					<option {if $tplData.search.status == $key}selected="selected"{/if} value="{$key}">{$value}</option>
				{/foreach}
			</select>
			<input type="text" name="key" value="{$tplData.search.key}" />
			<button type="submit">{$lang.btn.filter}</button>
		</form>
	</h5>

	<form name="log_list" id="log_list" class="tlist">

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
						<div class="float_left">{$lang.label.content}</div>
					</li>
					<li class="float_right">
						<div class="tshort">{$lang.label.status}</div>
						<div class="tshort">{$lang.label.type}</div>
						<div class="tmiddle">{$lang.label.operator}</div>
					</li>
					<li class="float_clear"></li>
				</ol>
			</li>
			<li class="tbody">
				{foreach $tplData.logRows as $value}
					<ol id="log_list_{$value.log_id}">
						<li class="float_left">
							<div class="tmini"><input type="checkbox" name="log_id[]" value="{$value.log_id}" id="log_id_{$value.log_id}" group="log_id" class="validate chk_all" /></div>
							<div class="tmini">{$value.log_id}</div>
							<div class="tmiddle">
								<div class="title {$value.log_status}">
									{$value.log_title}
								</div>
								<div class="double">
									<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=log&act_get=show&log_id={$value.log_id}">{$lang.href.show}</a>
								</div>
							</div>
							<div class="float_left">
								{$value.log_content}
							</div>
						</li>
						<li class="float_right {$value.log_status}">
							<div class="tshort">{$status.log[$value.log_status]}</div>
							<div class="tshort">{$type.log[$value.log_type]}</div>
							<div class="tmiddle">
								{if $value.log_type != "system"}
									<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=log&act_get=log&operator_id={$value.log_operator_id}">{$value.log_operator_name}</a>
								{/if}
							</div>
						</li>
						<li class="float_clear"></li>
					</ol>
				{/foreach}
			</li>
			<li class="tfoot">
				<ol>
					<li class="float_left">
						<div class="tshort"><span id="msg_log_id"></span></div>
					</li>
					<li class="float_left">
						<div>
							<select name="act_post" id="act_post" class="validate">
								<option value="">{$lang.option.batch}</option>
								{foreach $status.log as $key=>$value}
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

{include "include/admin_foot.tpl" cfg=$cfg}

<script type="text/javascript">
var opts_validator_list = {
	log_id: {
		length: { min: 1, max: 0 },
		validate: { type: "checkbox" },
		msg: { id: "msg_log_id", too_few: "{$alert.x030202}" }
	},
	act_post: {
		length: { min: 1, max: 0 },
		validate: { type: "select" },
		msg: { id: "msg_act_post", too_few: "{$alert.x030203}" }
	}
};
var opts_submit_list = {
	ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=log",
	confirm_id: "act_post",
	confirm_val: "del",
	confirm_msg: "{$lang.confirm.del}",
	btn_text: "{$lang.btn.ok}",
	btn_url: "{$cfg.str_url}"
};

$(document).ready(function(){
	$(".chk_all").click(function(){
		var _log_id = $(this).val();
		if ($(this).prop("checked")) {
			$("#log_list_" + _log_id).addClass("div_checked");
		} else {
			$("#log_list_" + _log_id).removeClass("div_checked");
		}
	});

	var obj_validator_form = $("#log_list").baigoValidator(opts_validator_list);
	var obj_submit_form = $("#log_list").baigoSubmit(opts_submit_list);
	$("#go_list").click(function(){
		if (obj_validator_form.validateSubmit()) {
			obj_submit_form.formSubmit();
		}
	});
	$("#log_list").baigoCheckall();
})
</script>

{include "include/html_foot.tpl" cfg=$cfg}
