{* user_list.tpl 管理员列表 *}
{if $smarty.const.BG_REG_NEEDMAIL == "on"}
	{$str_mailNeed = "*"}
	{$num_mailMin = 1}
{else}
	{$num_mailMin = 0}
{/if}

{$cfg = [
	title          => $adminMod.user.main.title,
	css            => "admin_slist",
	menu_active    => "user",
	sub_active     => "list",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	colorbox       => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=user&{$tplData.query}"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<div class="tlist">
		<div class="left_form">

			<form name="user_form" id="user_form">
				<input type="hidden" name="token_session" value="{$common.token_session}" />
				<input type="hidden" name="act_post" value="submit" />
				<input type="hidden" name="user_id" value="{$tplData.userRow.user_id}" />

				<ol>
					{if $tplData.userRow.user_id > 0}
						<li class="title_b">{$lang.label.id}: {$tplData.userRow.user_id}</li>
						<li class="line_dashed"> </li>
					{/if}

					<li class="title">{$lang.label.username}<span id="msg_user_name">*</span></li>
					<li>
						<input type="text" name="user_name" id="user_name" value="{$tplData.userRow.user_name}" class="validate short" />
					</li>

					<li class="line_dashed"> </li>

					<li class="title">{$lang.label.password}{if $tplData.userRow.user_id == 0}<span id="msg_user_pass">*</span>{else}{$lang.label.onlymodi}{/if}</li>
					<li>
						<input type="text" name="user_pass" id="user_pass" {if $tplData.userRow.user_id == 0}class="validate"{/if} />
					</li>

					<li class="line_dashed"> </li>

					<li class="title">{$lang.label.email}<span id="msg_user_mail">{$str_mailNeed}</span></li>
					<li>
						<input type="text" name="user_mail" id="user_mail" value="{$tplData.userRow.user_mail}" class="validate" />
					</li>

					<li class="line_dashed"> </li>

					<li class="title">{$lang.label.nick}<span id="msg_user_nick"></span></li>
					<li>
						<input type="text" name="user_nick" id="user_nick" value="{$tplData.userRow.user_nick}" class="validate short" />
					</li>

					<li class="line_dashed"> </li>

					<li class="title">{$lang.label.note}<span id="msg_user_note"></span></li>
					<li>
						<input type="text" name="user_note" id="user_note" value="{$tplData.userRow.user_note}" class="validate short" />
					</li>

					<li class="line_dashed"> </li>

					<li class="title">{$lang.label.status}<span id="msg_user_status">*</span></li>
					<li>
						{foreach $status.user as $key=>$value}
							<input type="radio" name="user_status" id="user_status_{$key}" value="{$key}" class="validate" {if $tplData.userRow.user_status == $key}checked="checked"{/if} group="user_status" />
							<label for="user_status_{$key}">{$value}</label>
						{/foreach}
					</li>

					<li class="line_dashed"> </li>

					<li><button type="button" id="go_form">{$lang.btn.submit}</button></li>
				</ol>
			</form>

		</div>

		<div class="right_list">
			<h5>
				<div>
					<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=user&act_get=list">+ {$lang.href.add}</a>
				</div>

				<form name="user_search" id="user_search" action="{$smarty.const.BG_URL_ADMIN}admin.php" method="get">
					<input type="hidden" name="mod" value="user" />
					<select name="status">
						<option value="">{$lang.option.allStatus}</option>
						{foreach $status.user as $key=>$value}
							<option {if $tplData.search.status == $key}selected="selected"{/if} value="{$key}">{$value}</option>
						{/foreach}
					</select>
					<input type="text" name="key" value="{$tplData.search.key}" />
					<button type="submit">{$lang.btn.filter}</button>
				</form>
			</h5>

			<form name="user_list" id="user_list">

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
								<div class="float_left">{$lang.label.user}</div>
							</li>
							<li class="float_right">
								<div class="tmiddle">{$lang.label.note}</div>
								<div class="tshort">{$lang.label.status}</div>
							</li>
							<li class="float_clear"></li>
						</ol>
					</li>
					<li class="tbody">
						{foreach $tplData.userRows as $value}
							<ol id="user_list_{$value.user_id}">
								<li class="float_left">
									<div class="tmini"><input type="checkbox" name="user_id[]" value="{$value.user_id}" id="user_id_{$value.user_id}" group="user_id" class="validate chk_all" /></div>
									<div class="tmini">{$value.user_id}</div>
									<div class="float_left">
										<div class="title {$value.user_status}">
											{$value.user_name}
											{if $value.user_nick}[ {$value.user_nick} ]{/if}
										</div>
										<div class="double">
											<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=user&act_get=list&user_id={$value.user_id}">{$lang.href.edit}</a>
										</div>
									</div>
								</li>
								<li class="float_right {$value.user_status}">
									<div class="tmiddle">{$value.user_note}</div>
									<div class="tshort">{$status.user[$value.user_status]}</div>
								</li>
								<li class="float_clear"></li>
							</ol>
						{/foreach}
					</li>
					<li class="tfoot">
						<ol>
							<li class="float_left">
								<div class="tshort"><span id="msg_user_id"></span></div>
							</li>
							<li class="float_left">
								<div>
									<select name="act_post" id="act_post" class="validate">
										<option value="">{$lang.option.batch}</option>
										{foreach $status.user as $key=>$value}
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

		</div>
	</div>

{include "include/admin_foot.tpl" cfg=$cfg}

<script type="text/javascript">
var opts_validator_list = {
	user_id: {
		length: { min: 1, max: 0 },
		validate: { type: "checkbox" },
		msg: { id: "msg_user_id", too_few: "{$alert.x030202}" }
	},
	act_post: {
		length: { min: 1, max: 0 },
		validate: { type: "select" },
		msg: { id: "msg_act_post", too_few: "{$alert.x030203}" }
	}
};

var opts_validator_form = {
	user_name: {
		length: { min: 1, max: 30 },
		validate: { type: "ajax", format: "strDigit" },
		msg: { id: "msg_user_name", too_short: "{$alert.x010201}", too_long: "{$alert.x010202}", format_err: "{$alert.x010203}" },
		ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=user&act_get=chkname", key: "user_name", type: "str", attach: "user_id={$tplData.userRow.user_id}" }
	},
	user_mail: {
		length: { min: {$num_mailMin}, max: 300 },
		validate: { type: "ajax", format: "email" },
		msg: { id: "msg_user_mail", too_short: "{$alert.x010206}", too_long: "{$alert.x010207}", format_err: "{$alert.x010208}" },
		ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=user&act_get=chkmail", key: "user_mail", type: "str", attach: "user_id={$tplData.userRow.user_id}" }
	},
	user_pass: {
		length: { min: 1, max: 0 },
		validate: { type: "str", format: "text" },
		msg: { id: "msg_user_pass", too_short: "{$alert.x010212}" }
	},
	user_nick: {
		length: { min: 0, max: 30 },
		validate: { type: "str", format: "text" },
		msg: { id: "msg_user_nick", too_long: "{$alert.x010214}" }
	},
	user_note: {
		length: { min: 0, max: 30 },
		validate: { type: "str", format: "text" },
		msg: { id: "msg_user_note", too_long: "{$alert.x020206}" }
	},
	user_status: {
		length: { min: 1, max: 0 },
		validate: { type: "radio" },
		msg: { id: "msg_user_status", too_few: "{$alert.x020203}" }
	}
};

var opts_submit_list = {
	ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=user",
	confirm_id: "act_post",
	confirm_val: "del",
	confirm_msg: "{$lang.confirm.del}",
	btn_text: "{$lang.btn.ok}",
	btn_url: "{$cfg.str_url}"
};

var opts_submit_form = { ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=user", btn_text: "{$lang.btn.ok}", btn_url: "{$cfg.str_url}" };

$(document).ready(function(){
	$(".chk_all").click(function(){
		var _user_id = $(this).val();
		if ($(this).prop("checked")) {
			$("#user_list_" + _user_id).addClass("div_checked");
		} else {
			$("#user_list_" + _user_id).removeClass("div_checked");
		}
	});

	var obj_validate_list = $("#user_list").baigoValidator(opts_validator_list);
	var obj_submit_list = $("#user_list").baigoSubmit(opts_submit_list);
	$("#go_list").click(function(){
		if (obj_validate_list.validateSubmit()) {
			obj_submit_list.formSubmit();
		}
	});

	var obj_validate_form = $("#user_form").baigoValidator(opts_validator_form);
	var obj_submit_form = $("#user_form").baigoSubmit(opts_submit_form);
	$("#go_form").click(function(){
		if (obj_validate_form.validateSubmit()) {
			obj_submit_form.formSubmit();
		}
	});
	$("#user_list").baigoCheckall();
})
</script>

{include "include/html_foot.tpl" cfg=$cfg}
