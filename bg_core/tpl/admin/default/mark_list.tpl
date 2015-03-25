{* mark_list.tpl 标签列表 *}
{$cfg = [
	title          => "{$adminMod.article.main.title} - {$adminMod.article.sub.mark.title}",
	menu_active    => "article",
	sub_active     => "mark",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	tokenReload    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=mark&{$tplData.query}"
]}

{include "include/admin_head.tpl"}

	<li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=list">{$adminMod.article.main.title}</a></li>
	<li>{$adminMod.article.sub.mark.title}</li>

	{include "include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<div class="pull-left">
			<ul class="list-inline">
				<li>
					<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=mark&act_get=list">
						<span class="glyphicon glyphicon-plus"></span>
						{$lang.href.add}
					</a>
				</li>
				<li>
					<a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=tag#mark" target="_blank">
						<span class="glyphicon glyphicon-question-sign"></span>
						{$lang.href.help}
					</a>
				</li>
			</ul>
		</div>
		<div class="pull-right">
			<form name="mark_search" id="mark_search" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get" class="form-inline">
				<input type="hidden" name="mod" value="mark">
				<input type="hidden" name="act_get" value="list">
				<div class="form-group">
					<input type="text" name="key" value="{$tplData.search.key}" placeholder="{$lang.label.key}" class="form-control input-sm">
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-default btn-sm">
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</div>
			</form>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="row">
		<div class="col-md-3">
			<div class="well">
				<form name="mark_form" id="mark_form">
					<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
					<input type="hidden" name="mark_id" value="{$tplData.markRow.mark_id}">
					<input type="hidden" name="act_post" value="submit">

					{if $tplData.markRow.mark_id > 0}
						<div class="form-group">
							<label class="control-label">{$lang.label.id}</label>
							<p class="form-control-static">{$tplData.markRow.mark_id}</p>
						</div>
					{/if}

					<div class="form-group">
						<label for="mark_name" class="control-label">{$lang.label.markName}<span id="msg_mark_name">*</span></label>
						<input type="text" name="mark_name" id="mark_name" value="{$tplData.markRow.mark_name}" class="validate form-control">
					</div>

					<div class="form-group">
						<button type="button" id="mark_add" class="btn btn-primary">{$lang.btn.save}</button>
					</div>
				</form>
			</div>
		</div>

		<div class="col-md-9">
			<form name="mark_list" id="mark_list">
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
									<th>{$lang.label.markName}</th>
								</tr>
							</thead>
							<tbody>
								{foreach $tplData.markRows as $value}
									<tr>
										<td class="td_mn"><input type="checkbox" name="mark_id[]" value="{$value.mark_id}" id="mark_id_{$value.mark_id}" group="mark_id" class="chk_all validate"></td>
										<td class="td_mn">{$value.mark_id}</td>
										<td>
											<ul class="list-unstyled">
												<li>
													{if $value.mark_name}
														{$value.mark_name}
													{else}
														{$lang.label.noname}
													{/if}
												</li>
												<li>
													<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=mark&act_get=list&mark_id={$value.mark_id}">{$lang.href.edit}</a>
												</li>
											</ul>
										</td>
									</tr>
								{/foreach}
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2"><span id="msg_mark_id"></span></td>
									<td>
										<input type="hidden" name="act_post" id="act_post" value="del">
										<button type="button" id="go_submit" class="btn btn-primary btn-sm">{$lang.btn.del}</button>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>

			</form>
		</div>
	</div>

	<div class="text-right">
		{include "include/page.tpl" cfg=$cfg}
	</div>

{include "include/admin_foot.tpl"}

	<script type="text/javascript">
	var opts_validator_list = {
		mark_id: {
			length: { min: 1, max: 0 },
			validate: { type: "checkbox" },
			msg: { id: "msg_mark_id", too_few: "{$alert.x030202}" }
		}
	};

	var opts_validator_form = {
		mark_name: {
			length: { min: 1, max: 30 },
			validate: { type: "ajax", format: "text" },
			msg: { id: "msg_mark_name", too_short: "{$alert.x140201}", too_long: "{$alert.x140202}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
			ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=mark&act_get=chkname", key: "mark_name", type: "str", attach: "mark_id={$tplData.markRow.mark_id}" }
		}
	};

	var opts_submit_list = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=mark",
		confirm_id: "act_post",
		confirm_val: "del",
		confirm_msg: "{$lang.confirm.del}",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	var opts_submit_form = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=mark",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	$(document).ready(function(){
		var obj_validate_list = $("#mark_list").baigoValidator(opts_validator_list);
		var obj_submit_list = $("#mark_list").baigoSubmit(opts_submit_list);
		$("#go_submit").click(function(){
			if (obj_validate_list.validateSubmit()) {
				obj_submit_list.formSubmit();
			}
		});
		var obj_validate_form = $("#mark_form").baigoValidator(opts_validator_form);
		var obj_submit_form = $("#mark_form").baigoSubmit(opts_submit_form);
		$("#mark_add").click(function(){
			if (obj_validate_form.validateSubmit()) {
				obj_submit_form.formSubmit();
			}
		});
		$("#mark_list").baigoCheckall();
	})
	</script>

{include "include/html_foot.tpl" cfg=$cfg}

