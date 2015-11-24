{* custom_list.tpl 标签列表 *}
{function custom_list arr=""}
	{foreach $arr as $key=>$value}
		{if $value.custom_status == "enable"}
			{$_css_status = "success"}
		{else}
			{$_css_status = "danger"}
		{/if}
		<tr{if $value.custom_level == 1} class="active"{/if}>
			<td class="text-nowrap td_mn"><input type="checkbox" name="custom_id[]" value="{$value.custom_id}" id="custom_id_{$value.custom_id}" group="custom_id" class="chk_all validate"></td>
			<td class="text-nowrap td_mn">{$value.custom_id}</td>
			<td class="child_{$value.custom_level}">
				<ul class="list-unstyled">
					<li>
						{if $value.custom_level > 1}
							| -
						{/if}
						{if $value.custom_name}
							{$value.custom_name}
						{else}
							{$lang.label.noname}
						{/if}
					</li>
					<li>
						<ul class="list_menu">
							<li>
								<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=custom&act_get=form&custom_id={$value.custom_id}">{$lang.href.edit}</a>
							</li>
							<li>
								<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=custom&act_get=order&custom_id={$value.custom_id}&view=iframe" data-toggle="modal" data-target="#custom_modal">{$lang.href.order}</a>
							</li>
						</ul>
					</li>
				</ul>
			</td>
			<td class="text-nowrap td_md">
				<ul class="list-unstyled">
					<li class="label_baigo">
						<span class="label label-{$_css_status}">{$status.custom[$value.custom_status]}</span>
					</li>
					<li>{$value.custom_type}</li>
				</ul>
			</td>
		</tr>

		{if $value.custom_childs}
			{custom_list arr=$value.custom_childs}
		{/if}
	{/foreach}
{/function}

{$cfg = [
	title          => "{$adminMod.more.main.title} - {$adminMod.more.sub.custom.title}",
	menu_active    => "more",
	sub_active     => "custom",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	tokenReload    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=custom&{$tplData.query}"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl"}

	<li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=custom">{$adminMod.more.main.title}</a></li>
	<li>{$adminMod.more.sub.custom.title}</li>

	{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<div class="pull-left">
			<div class="form-group">
				<ul class="nav nav-pills nav_baigo">
					<li>
						<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=custom&act_get=form">
							<span class="glyphicon glyphicon-plus"></span>
							{$lang.href.add}
						</a>
					</li>
					<li>
						<a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=custom" target="_blank">
							<span class="glyphicon glyphicon-question-sign"></span>
							{$lang.href.help}
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="pull-right">
			<form name="custom_search" id="custom_search" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get" class="form-inline">
				<input type="hidden" name="mod" value="custom">
				<input type="hidden" name="act_get" value="list">
				<div class="form-group">
					<select name="status" class="form-control input-sm">
						<option value="">{$lang.option.allStatus}</option>
						{foreach $status.custom as $key=>$value}
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

	<form name="custom_list" id="custom_list" class="form-inline">
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
							<th>{$lang.label.customName}</th>
							<th class="text-nowrap td_md">{$lang.label.status} / {$lang.label.type}</th>
						</tr>
					</thead>
					<tbody>
						{custom_list arr=$tplData.customRows}
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2"><span id="msg_custom_id"></span></td>
							<td colspan="2">
								<div class="form-group">
									<select name="act_post" id="act_post" class="validate form-control input-sm">
										<option value="">{$lang.option.batch}</option>
										{foreach $status.call as $key=>$value}
											<option value="{$key}">{$value}</option>
										{/foreach}
										<option value="cache">{$lang.option.cache}</option>
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

	<div class="modal fade" id="custom_modal">
		<div class="modal-dialog">
			<div class="modal-content"></div>
		</div>
	</div>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_foot.tpl"}

	<script type="text/javascript">
	var opts_validator_list = {
		custom_id: {
			length: { min: 1, max: 0 },
			validate: { type: "checkbox" },
			msg: { id: "msg_custom_id", too_few: "{$alert.x030202}" }
		},
		act_post: {
			length: { min: 1, max: 0 },
			validate: { type: "select" },
			msg: { id: "msg_act_post", too_few: "{$alert.x030203}" }
		}
	};

	var opts_submit_list = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=custom",
		confirm_selector: "#act_post",
		confirm_val: "del",
		confirm_msg: "{$lang.confirm.del}",
		text_submitting: "{$lang.label.submitting}",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	$(document).ready(function(){
		$("#custom_modal").on("hidden.bs.modal", function() {
		    $(this).removeData("bs.modal");
		});
		var obj_validate_list = $("#custom_list").baigoValidator(opts_validator_list);
		var obj_submit_list   = $("#custom_list").baigoSubmit(opts_submit_list);
		$("#go_submit").click(function(){
			if (obj_validate_list.validateSubmit()) {
				obj_submit_list.formSubmit();
			}
		});
		$("#custom_list").baigoCheckall();
	})
	</script>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}

