{* admin_groupList.tpl 后台用户组 *}
{$cfg = [
	title          => $adminMod.group.main.title,
	menu_active    => "group",
	sub_active     => "list",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	tokenReload    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=group&{$tplData.query}"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl" cfg=$cfg}

	<li>{$adminMod.group.main.title}</li>

	{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<div class="pull-left">
			<div class="form-group">
				<ul class="nav nav-pills nav_baigo">
					<li>
						<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=group&act_get=form">
							<span class="glyphicon glyphicon-plus"></span>
							{$lang.href.add}
						</a>
					</li>
					<li>
						<a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=group" target="_blank">
							<span class="glyphicon glyphicon-question-sign"></span>
							{$lang.href.help}
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="pull-right">
			<form name="group_search" id="group_search" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get" class="form-inline">
				<input type="hidden" name="mod" value="group">
				<input type="hidden" name="act_get" value="list">
				<div class="form-group">
					<select name="type" class="form-control input-sm">
						<option value="">{$lang.option.allType}</option>
						{foreach $type.group as $key=>$value}
							<option {if $tplData.search.type == $key}selected{/if} value="{$key}">{$value}</option>
						{/foreach}
					</select>
				</div>
				<div class="form-group">
					<div class="input-group">
						<input type="text" name="key" value="{$tplData.search.key}" placeholder="{$lang.label.key}" class="form-control input-sm">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-default btn-sm">
								<span class="glyphicon glyphicon-search"></span>
							</button>
						</span>
					</div>
				</div>
			</form>
		</div>
		<div class="clearfix"></div>
	</div>

	<form name="group_list" id="group_list" class="form-inline">
		<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">

		<div class="panel panel-default">
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th class="text-nowrap td_mn">
								<label for="chk_all" class="checkbox-inline">
									<input type="checkbox" name="chk_all" id="chk_all" class="first">
									{$lang.label.all}
								</label>
							</th>
							<th class="text-nowrap td_mn">{$lang.label.id}</th>
							<th>{$lang.label.group}</th>
							<th class="text-nowrap td_md">{$lang.label.type} / {$lang.label.groupNote}</th>
							<th class="text-nowrap td_sm">{$lang.label.status}</th>
						</tr>
					</thead>
					<tbody>
						{foreach $tplData.groupRows as $key=>$value}
							{if $value.group_status == "enable"}
								{$_css_status = "success"}
							{else}
								{$_css_status = "danger"}
							{/if}
							<tr>
								<td class="text-nowrap td_mn"><input type="checkbox" name="group_id[]" value="{$value.group_id}" id="group_id_{$value.group_id}" class="chk_all validate" group="group_id"></td>
								<td class="text-nowrap td_mn">{$value.group_id}</td>
								<td>
									<ul class="list-unstyled">
										<li>{$value.group_name}</li>
										<li>
											<ul class="list_menu">
												<li>
													<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=group&act_get=show&group_id={$value.group_id}">{$lang.href.show}</a>
												</li>
												<li>
													<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=group&act_get=form&group_id={$value.group_id}">{$lang.href.edit}</a>
												</li>
											</ul>
										</li>
									</ul>
								</td>
								<td class="text-nowrap td_md">
									<ul class="list-unstyled">
										<li>{$type.group[$value.group_type]}</li>
										<li>{$value.group_note}</li>
									</ul>
								</td>
								<td class="td_sm label_baigo">
									<span class="label label-{$_css_status}">{$status.group[$value.group_status]}</span>
								</td>
							</tr>
						{/foreach}
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2"><span id="msg_group_id"></span></td>
							<td colspan="3">
								<div class="form-group">
									<select name="act_post" id="act_post" class="validate form-control input-sm">
										<option value="">{$lang.option.batch}</option>
										{foreach $status.group as $key=>$value}
											<option value="{$key}">{$value}</option>
										{/foreach}
										<option value="del">{$lang.option.del}</option>
									</select>
								</div>
								<div class="form-group">
									<button type="button" id="go_submit" class="btn btn-primary btn-sm">{$lang.btn.submit}</button>
								</div>
								<div class="form-group">
									<span id="msg_act_post"></span>
								</div>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>

	</form>

	<div class="text-right">
		{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/page.tpl" cfg=$cfg}
	</div>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_foot.tpl" cfg=$cfg}

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
		confirm_selector: "#act_post",
		confirm_val: "del",
		confirm_msg: "{$lang.confirm.del}",
		text_submitting: "{$lang.label.submitting}",
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

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}

