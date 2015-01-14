{* spec_list.tpl 标签列表 *}
{$cfg = [
	title          => "{$adminMod.article.main.title} - {$adminMod.article.sub.spec.title}",
	menu_active    => "article",
	sub_active     => "spec",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=spec&{$tplData.query}"
]}

{include "include/admin_head.tpl"}

	<li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=list">{$adminMod.article.main.title}</a></li>
	<li>{$adminMod.article.sub.spec.title}</li>

	{include "include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<div class="pull-left">
			<ul class="list-inline">
				<li>
					<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=spec&act_get=form">
						<span class="glyphicon glyphicon-plus"></span>
						{$lang.href.add}
					</a>
				</li>
				<li>
					<a href="{$smarty.const.BG_URL_HELP}?lang=zh_CN&mod=help&act=spec" target="_blank">
						<span class="glyphicon glyphicon-question-sign"></span>
						{$lang.href.help}
					</a>
				</li>
			</ul>
		</div>
		<div class="pull-right">
			<form name="spec_search" id="spec_search" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get" class="form-inline">
				<input type="hidden" name="mod" value="spec">
				<input type="hidden" name="act_get" value="list">
				<select name="status" class="form-control input-sm">
					<option value="">{$lang.option.allStatus}</option>
					{foreach $status.spec as $key=>$value}
						<option {if $tplData.search.status == $key}selected{/if} value="{$key}">{$value}</option>
					{/foreach}
				</select>
				<input type="text" name="key" value="{$tplData.search.key}" placeholder="{$lang.label.key}" class="form-control input-sm">
				<button type="submit" class="btn btn-default btn-sm">{$lang.btn.filter}</button>
			</form>
		</div>
		<div class="clearfix"></div>
	</div>

	<form name="spec_list" id="spec_list" class="form-inline">
		<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">

		<div class="panel panel-default">
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
							<th>{$lang.label.spec}</th>
							<th class="td_sm">{$lang.label.status}</th>
						</tr>
					</thead>
					<tbody>
						{foreach $tplData.specRows as $value}
							{if $value.spec_status == "show"}
								{$_css_status = "success"}
							{else}
								{$_css_status = "danger"}
							{/if}
							<tr>
								<td class="td_mn"><input type="checkbox" name="spec_id[]" value="{$value.spec_id}" id="spec_id_{$value.spec_id}" group="spec_id" class="chk_all validate"></td>
								<td class="td_mn">{$value.spec_id}</td>
								<td>
									<div>
										{if $value.spec_name}
											{$value.spec_name}
										{else}
											{$lang.label.noname}
										{/if}
									</div>
									<div>
										<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=spec&act_get=form&spec_id={$value.spec_id}">{$lang.href.edit}</a>
										&nbsp;|&nbsp;
										<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=spec&act_get=select&spec_id={$value.spec_id}">{$lang.href.specSelect}</a>
									</div>
								</td>
								<td class="td_sm">
									<span class="label label-{$_css_status}">{$status.spec[$value.spec_status]}</span>
								</td>
							</tr>
						{/foreach}
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2"><span id="msg_spec_id"></span></td>
							<td colspan="2">
								<select name="act_post" id="act_post" class="validate form-control input-sm">
									<option value="">{$lang.option.batch}</option>
									{foreach $status.spec as $key=>$value}
										<option value="{$key}">{$value}</option>
									{/foreach}
									<option value="del">{$lang.option.del}</option>
								</select>
								<button type="button" id="go_submit" class="btn btn-primary btn-sm">{$lang.btn.submit}</button>
								<span id="msg_act_post"></span>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>

	</form>

	<div class="text-right">
		{include "include/page.tpl" cfg=$cfg}
	</div>

{include "include/admin_foot.tpl"}

	<script type="text/javascript">
	var opts_validator_list = {
		spec_id: {
			length: { min: 1, max: 0 },
			validate: { type: "checkbox" },
			msg: { id: "msg_spec_id", too_few: "{$alert.x030202}" }
		},
		act_post: {
			length: { min: 1, max: 0 },
			validate: { type: "select" },
			msg: { id: "msg_act_post", too_few: "{$alert.x030203}" }
		}
	};

	var opts_submit_list = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=spec",
		confirm_id: "act_post",
		confirm_val: "del",
		confirm_msg: "{$lang.confirm.del}",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	$(document).ready(function(){
		var obj_validate_list = $("#spec_list").baigoValidator(opts_validator_list);
		var obj_submit_list = $("#spec_list").baigoSubmit(opts_submit_list);
		$("#go_submit").click(function(){
			if (obj_validate_list.validateSubmit()) {
				obj_submit_list.formSubmit();
			}
		});
		$("#spec_list").baigoCheckall();
	})
	</script>

{include "include/html_foot.tpl" cfg=$cfg}

