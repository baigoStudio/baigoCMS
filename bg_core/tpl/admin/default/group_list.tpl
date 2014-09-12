{* admin_groupList.tpl 后台用户组 *}
{$cfg = [
	title          => $adminMod.group.main.title,
	menu_active    => "group",
	sub_active     => "list",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=group&{$tplData.query}"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<li>{$adminMod.group.main.title}</li>

	{include "include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<div class="pull-left">
			<ul class="list-inline">
				<li>
					<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=group&act_get=form">
						<span class="glyphicon glyphicon-plus"></span>
						{$lang.href.add}
					</a>
				</li>
				<li>
					<a href="{$smarty.const.BG_URL_HELP}?lang=zh_CN&mod=help&act=group" target="_blank">
						<span class="glyphicon glyphicon-question-sign"></span>
						{$lang.href.help}
					</a>
				</li>
			</ul>
		</div>
		<div class="pull-right">
			<form name="group_search" id="group_search" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get" class="form-inline">
				<input type="hidden" name="mod" value="group">
				<input type="hidden" name="act_get" value="list">
				<select name="type" class="form-control input-sm">
					<option value="">{$lang.option.allType}</option>
					{foreach $type.group as $key=>$value}
						<option {if $tplData.search.type == $key}selected{/if} value="{$key}">{$value}</option>
					{/foreach}
				</select>
				<input type="text" name="key" value="{$tplData.search.key}" placeholder="{$lang.label.key}" class="form-control input-sm">
				<button type="submit" class="btn btn-default btn-sm">{$lang.btn.filter}</button>
			</form>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="panel panel-default">
		<form name="group_list" id="group_list" class="form-inline">

			<input type="hidden" name="token_session" value="{$common.token_session}">
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th class="td_mn">
								<label for="chk_all" class="checkbox-inline">
									<input type="checkbox" name="chk_all" id="chk_all" class="first">
									{$lang.label.all}
								</label>
							</th>
							<th class="td_mn">{$lang.label.id}</th>
							<th>{$lang.label.group}</th>
							<th class="td_lg">{$lang.label.groupNote}</th>
							<th class="td_sm">{$lang.label.groupType}</th>
							<th class="td_sm">{$lang.label.status}</th>
						</tr>
					</thead>
					<tbody>
						{foreach $tplData.groupRows as $value}
							{if $value.group_status == "enable"}
								{$_css_status = "success"}
							{else}
								{$_css_status = "danger"}
							{/if}
							<tr>
								<td class="td_mn"><input type="checkbox" name="group_id[]" value="{$value.group_id}" id="group_id_{$value.group_id}" class="chk_all validate" group="group_id"></td>
								<td class="td_mn">{$value.group_id}</td>
								<td>
									<div class="title">{$value.group_name}</div>
									<div>
										<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=group&act_get=show&group_id={$value.group_id}">{$lang.href.show}</a>
										&nbsp;|&nbsp;
										<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=group&act_get=form&group_id={$value.group_id}">{$lang.href.edit}</a>
									</div>
								</td>
								<td class="td_lg">{$value.group_note}</td>
								<td class="td_sm">{$type.group[$value.group_type]}</td>
								<td class="td_sm">
									<span class="label label-{$_css_status}">{$status.group[$value.group_status]}</span>
								</td>
							</tr>
						{/foreach}
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2"><span id="msg_group_id"></span></td>
							<td colspan="4">
								<select name="act_post" id="act_post" class="validate form-control input-sm">
									<option value="">{$lang.option.batch}</option>
									{foreach $status.group as $key=>$value}
										<option value="{$key}">{$value}</option>
									{/foreach}
									<option value="del">{$lang.option.del}</option>
								</select>
								<button type="button" id="go_submit" class="btn btn-primary btn-sm">{$lang.btn.submit}</button>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</form>
	</div>

	<div class="text-right">
		{include "include/page.tpl" cfg=$cfg}
	</div>

{include "include/admin_foot.tpl" cfg=$cfg}

	<script type="text/javascript">
	var opts_validator_list = {
		group_id: {
			length: { min: 1, max: 0 },
			validate: { type: "checkbox" },
			msg: { id: "msg_group_id", too_few: "{$alert.x030202}" }
		},
		act_post: {
			length: { min: 1, max: 0 },
			validate: { type: "select" },
			msg: { id: "msg_act_post", too_few: "{$alert.x030203}" }
		}
	};

	var opts_submit_list = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=group",
		confirm_id: "act_post",
		confirm_val: "del",
		confirm_msg: "{$lang.confirm.del}",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	$(document).ready(function(){
		var obj_validate_list = $("#group_list").baigoValidator(opts_validator_list);
		var obj_submit_list = $("#group_list").baigoSubmit(opts_submit_list);
		$("#go_submit").click(function(){
			if (obj_validate_list.validateSubmit()) {
				obj_submit_list.formSubmit();
			}
		});
		$("#group_list").baigoCheckall();
	})
	</script>

{include "include/html_foot.tpl" cfg=$cfg}

