{* admin_groupForm.tpl 管理组编辑界面 *}
{if $tplData.groupRow.group_id == 0}
	{$title_sub = $lang.page.add}
	{$sub_active = "form"}
{else}
	{$title_sub = $lang.page.edit}
	{$sub_active = "list"}
{/if}

{$cfg = [
	title          => "{$adminMod.group.main.title} - {$title_sub}",
	menu_active    => "group",
	sub_active     => $sub_active,
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=group"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=group&act_get=list">{$adminMod.group.main.title}</a></li>
	<li>{$title_sub}</li>

	{include "include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<ul class="list-inline">
			<li>
				<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=group&act_get=list">
					<span class="glyphicon glyphicon-chevron-left"></span>
					{$lang.href.back}
				</a>
			</li>
			<li>
				<a href="{$smarty.const.BG_URL_HELP}?lang=zh_CN&mod=help&act=group#form" target="_blank">
					<span class="glyphicon glyphicon-question-sign"></span>
					{$lang.href.help}
				</a>
			</li>
		</ul>
	</div>

	<form name="group_form" id="group_form">
		<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
		<input type="hidden" name="act_post" value="submit">
		<input type="hidden" name="group_id" value="{$tplData.groupRow.group_id}">

		<div class="row">
			<div class="col-md-9">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="form-group">
							<div id="group_group_name">
								<label for="group_name" class="control-label">{$lang.label.groupName}<span id="msg_group_name">*</span></label>
								<input type="text" name="group_name" id="group_name" value="{$tplData.groupRow.group_name}" class="validate form-control">
							</div>
						</div>

						<div id="groupAdmin" class="form-group">
							<label class="control-label">{$lang.label.groupAllow}<span id="msg_group_allow">*</span></label>
							<dl class="list_baigo">
								<dd>
									<div class="checkbox_baigo">
										<label for="chk_all">
											<input type="checkbox" id="chk_all" class="first">
											{$lang.label.all}
										</label>
									</div>
								</dd>
								{foreach $adminMod as $key_m=>$value_m}
									<dt>{$value_m.main.title}</dt>
									<dd>
										<label for="allow_{$key_m}" class="checkbox-inline">
											<input type="checkbox" id="allow_{$key_m}" class="chk_all">
											{$lang.label.all}
										</label>
										{foreach $value_m.allow as $key_s=>$value_s}
											<label for="allow_{$key_m}_{$key_s}" class="checkbox-inline">
												<input type="checkbox" name="group_allow[{$key_m}][{$key_s}]" value="1" id="allow_{$key_m}_{$key_s}" {if $tplData.groupRow.group_allow[$key_m][$key_s] == 1}checked{/if} class="allow_{$key_m}" group="group_allow">
												{$value_s}
											</label>
										{/foreach}
									</dd>
								{/foreach}
							</dl>
						</div>

						<div id="groupUser" class="form-group">
							<label class="control-label">{$lang.label.none}</label>
						</div>

						<div class="form-group">
							<div id="group_group_note">
								<label class="control-label">{$lang.label.groupNote}<span id="msg_group_note">*</span></label>
								<input type="text" name="group_note" id="group_note" value="{$tplData.groupRow.group_note}" class="validate form-control">
							</div>
						</div>

						<div class="form-group">
							<button type="button" class="go_submit btn btn-primary">{$lang.btn.submit}</button>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="well">
					{if $tplData.groupRow.group_id > 0}
						<div class="form-group">
							<label class="control-label">{$lang.label.id}</label>
							<p class="form-control-static">{$tplData.groupRow.group_id}</p>
						</div>
					{/if}

					<label class="control-label">{$lang.label.groupType}<span id="msg_group_type">*</span></label>
					<div class="form-group">
						{foreach $type.group as $key=>$value}
							<label for="group_type_{$key}" class="radio-inline">
								<input type="radio" name="group_type" id="group_type_{$key}" {if $tplData.groupRow.group_type == $key}checked{/if} value="{$key}" class="validate" group="group_type">
								{$value}
							</label>
						{/foreach}
					</div>

					<label class="control-label">{$lang.label.status}<span id="msg_group_status">*</span></label>
					<div class="form-group">
						{foreach $status.group as $key=>$value}
							<label for="group_status_{$key}" class="radio-inline">
								<input type="radio" name="group_status" id="group_status_{$key}" {if $tplData.groupRow.group_status == $key}checked{/if} value="{$key}" class="validate" group="group_status">
								{$value}
							</label>
						{/foreach}
					</div>
				</div>
			</div>
		</div>

	</form>

{include "include/admin_foot.tpl" cfg=$cfg}

	<script type="text/javascript">
	var opts_validator_form = {
		group_name: {
			length: { min: 1, max: 30 },
			validate: { type: "ajax", format: "text", group: "group_group_name" },
			msg: { id: "msg_group_name", too_short: "{$alert.x040201}", too_long: "{$alert.x040202}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
			ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=group&act_get=chkname", key: "group_name", type: "str", attach: "group_id={$tplData.groupRow.group_id}" }
		},
		group_note: {
			length: { min: 0, max: 30 },
			validate: { type: "str", format: "text", group: "group_group_note" },
			msg: { id: "msg_group_note", too_long: "{$alert.x040204}" }
		},
		group_type: {
			length: { min: 1, max: 0 },
			validate: { type: "radio" },
			msg: { id: "msg_group_type", too_few: "{$alert.x040205}" }
		},
		group_status: {
			length: { min: 1, max: 0 },
			validate: { type: "radio" },
			msg: { id: "msg_group_status", too_few: "{$alert.x040207}" }
		}
	};

	var opts_submit_form = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=group",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	function group_type(group_type) {
		switch (group_type) {
			case "admin":
				$("#groupAdmin").show();
				$("#groupUser").hide();
			break;

			default:
				$("#groupAdmin").hide();
				$("#groupUser").show();
			break;
		}
	}

	$(document).ready(function(){
		var obj_validate_form = $("#group_form").baigoValidator(opts_validator_form);
		var obj_submit_form = $("#group_form").baigoSubmit(opts_submit_form);
		$(".go_submit").click(function(){
			if (obj_validate_form.validateSubmit()) {
				obj_submit_form.formSubmit();
			}
		});
		group_type("{$tplData.groupRow.group_type}");
		$("input[name='group_type']").click(function(){
			var _group_type = $("input[name='group_type']:checked").val();
			group_type(_group_type);
		});
		$("#group_form").baigoCheckall();
	});
	</script>

{include "include/html_foot.tpl" cfg=$cfg}

