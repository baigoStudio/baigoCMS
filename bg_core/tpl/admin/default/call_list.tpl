{* admin_callList.tpl 后台用户组 *}
{$cfg = [
	title          => $adminMod.call.main.title,
	menu_active    => "call",
	sub_active     => "list",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=call&{$tplData.query}"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<li>{$adminMod.call.main.title}</li>

	{include "include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<div class="pull-left">
			<ul class="list-inline">
				<li>
					<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=call&act_get=form">
						<span class="glyphicon glyphicon-plus"></span>
						{$lang.href.add}
					</a>
				</li>
				<li>
					<a href="{$smarty.const.BG_URL_HELP}?lang=zh_CN&mod=help&act=call" target="_blank">
						<span class="glyphicon glyphicon-question-sign"></span>
						{$lang.href.help}
					</a>
				</li>
			</ul>
		</div>
		<div class="pull-right">
			<form name="call_search" id="call_search" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get" class="form-inline">
				<input type="hidden" name="mod" value="call">
				<input type="hidden" name="act_get" value="list">
				<select name="type" class="form-control input-sm">
					<option value="">{$lang.option.allType}</option>
					{foreach $type.call as $key=>$value}
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
		<form name="call_list" id="call_list" class="form-inline">
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
							<th>{$lang.label.callName}</th>
							<th class="td_sm">{$lang.label.callType}</th>
						</tr>
					</thead>
					<tbody>
						{foreach $tplData.callRows as $value}
							<tr>
								<td class="td_mn"><input type="checkbox" name="call_id[]" value="{$value.call_id}" id="call_id_{$value.call_id}" class="chk_all validate" group="call_id"></td>
								<td class="td_mn">{$value.call_id}</td>
								<td>
									<div class="title">{$value.call_name}</div>
									<div><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=call&act_get=form&call_id={$value.call_id}">{$lang.href.edit}</a></div>
								</td>
								<td class="td_sm">{$type.call[$value.call_type]}</td>
							</tr>
						{/foreach}
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2"><span id="msg_call_id"></span></td>
							<td colspan="2">
								<input type="hidden" id="act_post" name="act_post" value="del">
								<button type="button" id="go_submit" class="btn btn-primary btn-sm">{$lang.btn.del}</button>
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
		confirm_id: "act_post",
		confirm_val: "del",
		confirm_msg: "{$lang.confirm.del}",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	$(document).ready(function(){
		var obj_validate_list = $("#call_list").baigoValidator(opts_validator_list);
		var obj_submit_list = $("#call_list").baigoSubmit(opts_submit_list);
		$("#go_submit").click(function(){
			if (obj_validate_list.validateSubmit()) {
				obj_submit_list.formSubmit();
			}
		});
		$("#call_list").baigoCheckall();
	})
	</script>

{include "include/html_foot.tpl" cfg=$cfg}
