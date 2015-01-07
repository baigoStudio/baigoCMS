{*cate_list.php 栏目列表*}
{* 栏目显示函数（递归） *}
{function cate_list arr=""}
	{foreach $arr as $value}
		{if $value.cate_status == "show"}
			{$_css_status = "success"}
		{else}
			{$_css_status = "danger"}
		{/if}
		<tr class="cate_{$value.cate_level}">
			<td class="td_mn"><input type="checkbox" name="cate_id[]" value="{$value.cate_id}" id="cate_id_{$value.cate_id}" group="cate_id" class="chk_all validate"></td>
			<td>
				{if $value.cate_level > 1}
					{for $_i=2 to $value.cate_level}
						--
					{/for}
				{/if}
				{$value.cate_id}
				/
				{if $value.cate_name}
					{$value.cate_name}
				{else}
					{$lang.label.noname}
				{/if}
			</td>
			<td class="td_bg">
				<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&cate_id={$value.cate_id}">{$lang.href.articleList}</a>
				&nbsp;|&nbsp;
				<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=cate&act_get=form&cate_id={$value.cate_id}">{$lang.href.edit}</a>
				&nbsp;|&nbsp;
				<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=cate&act_get=order&cate_id={$value.cate_id}&view=iframe" data-toggle="modal" data-target="#cate_modal">{$lang.href.order}</a>
			</td>
			<td class="td_bg">
				{if $value.cate_alias}
					{$value.cate_alias}
				{else}
					{$value.cate_id}
				{/if}
			</td>
			<td class="td_sm">{$type.cate[$value.cate_type]}</td>
			<td class="td_sm">
				<span class="label label-{$_css_status}">{$status.cate[$value.cate_status]}</span>
			</td>
		</tr>

		{if $value.cate_childs}
			{cate_list arr=$value.cate_childs}
		{/if}
	{/foreach}
{/function}

{$cfg = [
	title          => $adminMod.cate.main.title,
	menu_active    => "cate",
	sub_active     => "list",
	baigoCheckall  => "true",
	validate       => "true",
	baigoSubmit    => "true",
	baigoValidator => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=cate&{$tplData.query}"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<li>{$adminMod.cate.main.title}</li>

	{include "include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<div class="pull-left">
			<ul class="list-inline">
				<li>
					<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=cate&act_get=form">
						<span class="glyphicon glyphicon-plus"></span>
						{$lang.href.add}
					</a>
				</li>
				<li>
					<a href="{$smarty.const.BG_URL_HELP}?lang=zh_CN&mod=help&act=cate" target="_blank">
						<span class="glyphicon glyphicon-question-sign"></span>
						{$lang.href.help}
					</a>
				</li>
			</ul>
		</div>
		<div class="pull-right">
			<form name="cate_search" id="cate_search" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get" class="form-inline">
				<input type="hidden" name="mod" value="cate">
				<input type="hidden" name="act_get" value="list">
				<select name="type" class="form-control input-sm">
					<option value="">{$lang.option.allType}</option>
					{foreach $type.cate as $key=>$value}
						<option {if $tplData.search.type == $key}selected{/if} value="{$key}">{$value}</option>
					{/foreach}
				</select>
				<select name="status" class="form-control input-sm">
					<option value="">{$lang.option.allStatus}</option>
					{foreach $status.cate as $key=>$value}
						<option {if $tplData.search.status == $key}selected{/if} value="{$key}">{$value}</option>
					{/foreach}
				</select>
				<input type="test" name="key" value="{$tplData.search.key}" placeholder="{$lang.label.key}" class="form-control input-sm">
				<button type="submit" class="btn btn-default btn-sm">{$lang.btn.filter}</button>
			</form>
		</div>
		<div class="clearfix"></div>
	</div>

	<form name="cate_list" id="cate_list" class="form-inline">
		<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">

		<div class="panel panel-default">
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th class="td_mn">
								<label for="chk_all" class="checkbox-inline">
									<input type="checkbox" name="chk_all" id="chk_all" class="first">
									{$lang.label.all}
								</label>
							</th>
							<th>
								{$lang.label.id}
								/
								{$lang.label.cateName}
							</th>
							<th class="td_bg"> </th>
							<th class="td_bg">{$lang.label.cateAlias}</th>
							<th class="td_sm">{$lang.label.cateType}</th>
							<th class="td_sm">{$lang.label.status}</th>
						</tr>
					</thead>
					<tbody>
						{cate_list arr=$tplData.cateRows}
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2"><span id="msg_cate_id"></span></td>
							<td colspan="4">
								<select name="act_post" id="act_post" class="validate form-control input-sm">
									<option value="">{$lang.option.batch}</option>
									{foreach $status.cate as $key=>$value}
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

	<div class="modal fade" id="cate_modal">
		<div class="modal-dialog">
			<div class="modal-content"></div>
		</div>
	</div>

{include "include/admin_foot.tpl" cfg=$cfg}

	<script type="text/javascript">
	var opts_validator_list = {
		cate_id: {
			length: { min: 1, max: 0 },
			validate: { type: "checkbox" },
			msg: { id: "msg_cate_id", too_few: "{$alert.x030202}" }
		},
		act_post: {
			length: { min: 1, max: 0 },
			validate: { type: "select" },
			msg: { id: "msg_act_post", too_few: "{$alert.x030203}" }
		}
	};

	var opts_submit_list = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=cate",
		confirm_id: "act_post",
		confirm_val: "del",
		confirm_msg: "{$lang.confirm.del}",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	$(document).ready(function(){
		$("#cate_modal").on("hidden.bs.modal", function() {
		    $(this).removeData("bs.modal");
		});
		var obj_validate_list  = $("#cate_list").baigoValidator(opts_validator_list);
		var obj_submit_list    = $("#cate_list").baigoSubmit(opts_submit_list);
		$("#go_submit").click(function(){
			if (obj_validate_list.validateSubmit()) {
				obj_submit_list.formSubmit();
			}
		});
		$("#cate_list").baigoCheckall();
	})
	</script>

{include "include/html_foot.tpl" cfg=$cfg}

