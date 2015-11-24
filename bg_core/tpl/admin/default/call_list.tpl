{* admin_callList.tpl 后台用户组 *}
{$cfg = [
	title          => $adminMod.call.main.title,
	menu_active    => "call",
	sub_active     => "list",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	tokenReload    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=call&{$tplData.query}"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl" cfg=$cfg}

	<li>{$adminMod.call.main.title}</li>

	{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<div class="pull-left">
			<div class="form-group">
				<ul class="nav nav-pills nav_baigo">
					<li>
						<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=call&act_get=form">
							<span class="glyphicon glyphicon-plus"></span>
							{$lang.href.add}
						</a>
					</li>
					<li>
						<a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=call" target="_blank">
							<span class="glyphicon glyphicon-question-sign"></span>
							{$lang.href.help}
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="pull-right">
			<form name="call_search" id="call_search" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get" class="form-inline">
				<input type="hidden" name="mod" value="call">
				<input type="hidden" name="act_get" value="list">
				<div class="form-group">
					<select name="type" class="form-control input-sm">
						<option value="">{$lang.option.allType}</option>
						{foreach $type.call as $key=>$value}
							<option {if $tplData.search.type == $key}selected{/if} value="{$key}">{$value}</option>
						{/foreach}
					</select>
				</div>
				<div class="form-group">
					<select name="status" class="form-control input-sm">
						<option value="">{$lang.option.allStatus}</option>
						{foreach $status.call as $key=>$value}
							<option {if $tplData.search.status == $key}selected{/if} value="{$key}">{$value}</option>
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

	<form name="call_list" id="call_list" class="form-inline">
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
							<th>{$lang.label.callName}</th>
							<th class="text-nowrap td_sm">{$lang.label.status} / {$lang.label.type}</th>
						</tr>
					</thead>
					<tbody>
						{foreach $tplData.callRows as $key=>$value}
							{if $value.call_status == "enable"}
								{$_css_status = "success"}
							{else}
								{$_css_status = "danger"}
							{/if}
							<tr>
								<td class="text-nowrap td_mn"><input type="checkbox" name="call_id[]" value="{$value.call_id}" id="call_id_{$value.call_id}" class="chk_all validate" group="call_id"></td>
								<td class="text-nowrap td_mn">{$value.call_id}</td>
								<td>
									<ul class="list-unstyled">
										<li>{$value.call_name}</li>
										<li>
											<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=call&act_get=form&call_id={$value.call_id}">{$lang.href.edit}</a>
										</li>
									</ul>
								</td>
								<td class="text-nowrap td_sm">
									<ul class="list-unstyled">
										<li class="label_baigo">
											<span class="label label-{$_css_status}">{$status.call[$value.call_status]}</span>
										</li>
										<li>{$type.call[$value.call_type]}</li>
									</ul>
								</td>
							</tr>
						{/foreach}
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2"><span id="msg_call_id"></span></td>
							<td colspan="2">
								<div class="form-group">
									<select name="act_post" id="act_post" class="validate form-control input-sm">
										<option value="">{$lang.option.batch}</option>
										{foreach $status.call as $key=>$value}
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
		call_id: {
			length: { min: 1, max: 0 },
			validate: { type: "checkbox" },
			msg: { id: "msg_call_id", too_few: "{$alert.x030202}" }
		},
		act_post: {
			length: { min: 1, max: 0 },
			validate: { type: "select" },
			msg: { id: "msg_act_post", too_few: "{$alert.x030203}" }
		}
	};

	var opts_submit_list = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=call",
		confirm_selector: "#act_post",
		confirm_val: "del",
		confirm_msg: "{$lang.confirm.del}",
		text_submitting: "{$lang.label.submitting}",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	$(document).ready(function(){
		var obj_validate_list = $("#call_list").baigoValidator(opts_validator_list);
		var obj_submit_list   = $("#call_list").baigoSubmit(opts_submit_list);
		$("#go_submit").click(function(){
			if (obj_validate_list.validateSubmit()) {
				obj_submit_list.formSubmit();
			}
		});
		$("#call_list").baigoCheckall();
	})
	</script>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}
