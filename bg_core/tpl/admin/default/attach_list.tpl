{*attach_list.php 上传管理*}
{$cfg = [
	title          => $adminMod.attach.main.title,
	menu_active    => "attach",
	sub_active     => "list",
	baigoCheckall  => "true",
	baigoValidator => "true",
	uploadify      => "true",
	baigoSubmit    => "true",
	upload         => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=attach&{$tplData.query}"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<li>{$adminMod.attach.main.title}</li>

	{include "include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<div class="pull-left">
			<a href="{$smarty.const.BG_URL_HELP}?lang=zh_CN&mod=help&act=attach" target="_blank">
				<span class="glyphicon glyphicon-question-sign"></span>
				{$lang.href.help}
			</a>
		</div>
		<div class="pull-right">
			<form name="attach_search" id="attach_search" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get" class="form-inline">
				<input type="hidden" name="mod" value="attach">
				<input type="hidden" name="act_get" value="list">

				<select name="year" class="form-control input-sm">
					<option value="">{$lang.option.allYear}</option>
					{foreach $tplData.pathRows as $value}
						<option {if $tplData.search.year == $value.attach_year}selected{/if} value="{$value.attach_year}">{$value.attach_year}</option>
					{/foreach}
				</select>
				<select name="month" class="form-control input-sm">
					<option value="">{$lang.option.allMonth}</option>
					{for $_i = 1 to 12}
						{if $_i < 10}
							{$_str_month = "0{$_i}"}
						{else}
							{$_str_month = $_i}
						{/if}
						<option {if $tplData.search.month == $_str_month}selected{/if} value="{$_str_month}">{$_str_month}</option>
					{/for}
				</select>
				<select name="ext" class="form-control input-sm">
					<option value="">{$lang.option.allExt}</option>
					{foreach $tplData.extRows as $value}
						<option {if $tplData.search.ext == $value.attach_ext}selected{/if} value="{$value.attach_ext}">{$value.attach_ext}</option>
					{/foreach}
				</select>
				<button type="submit" class="btn btn-default btn-sm">{$lang.btn.filter}</button>
			</form>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="row">
		<div class="col-md-3">
			<div class="well">
				{include "include/upload.tpl" cfg=$cfg}
			</div>
		</div>

		<div class="col-md-9">
			<form name="attach_list" id="attach_list" class="form-inline">
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
									<th class="td_sm">{$lang.label.attachThumb}</th>
									<th>{$lang.label.attachInfo}</th>
									<th class="td_md">{$lang.label.admin}</th>
								</tr>
							</thead>
							<tbody>
								{foreach $tplData.attachRows as $value}
									<tr>
										<td class="td_mn"><input type="checkbox" name="attach_id[]" value="{$value.attach_id}" id="attach_id_{$value.attach_id}" group="attach_id" class="chk_all validate"></td>
										<td class="td_mn">{$value.attach_id}</td>
										<td class="td_sm">
											{if $value.attach_type == "image"}
												<a href="{$value.attach_url}" target="_blank"><img src="{$value.attach_thumb.0.thumb_url}" alt="{$value.attach_name}"></a>
											{else}
												<a href="{$value.attach_url}" target="_blank"><img src="{$smarty.const.BG_URL_IMAGE}file_{$value.attach_ext}.png" alt="{$value.attach_name}"></a>
											{/if}
										</td>
										<td>
											<div><a href="{$value.attach_url}" target="_blank">{$value.attach_name}</a></div>
											{if $value.attach_size > 1024}
												{$_num_attachSize = $value.attach_size / 1024}
												{$_str_attachUnit = "KB"}
											{else if $value.attach_size > 1024 * 1024}
												{$_num_attachSize = $value.attach_size / 1024 / 1024}
												{$_str_attachUnit = "MB"}
											{else if $value.attach_size > 1024 * 1024 * 1024}
												{$_num_attachSize = $value.attach_size / 1024 / 1024 / 1024}
												{$_str_attachUnit = "GB"}
											{/if}
											<div>{$_num_attachSize|string_format:"%.2f"} {$_str_attachUnit}</div>
											<div>{$value.attach_time|date_format:$smarty.const.BG_SITE_DATE}</div>
											<div>
												{if $value.attach_type == "image"}
													<div class="dropdown">
														<button class="btn btn-default dropdown-toggle btn-sm" type="button" id="attach_{$value.attach_id}" data-toggle="dropdown">
															{$lang.btn.thumb}
															<span class="caret"></span>
														</button>
														<ul class="dropdown-menu">
															{foreach $value.attach_thumb as $value_thumb}
																<li><a href="{$value_thumb.thumb_url}" target="_blank">{$value_thumb.thumb_width}x{$value_thumb.thumb_height} {$type.thumb[$value_thumb.thumb_type]}</a></li>
															{/foreach}
														</ul>
													</div>
												{/if}
											</div>
										</td>
										<td class="td_md">
											{if $value.adminRow.admin_name}
												<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=attach&admin_id={$value.attach_admin_id}">{$value.adminRow.admin_name} {if $value.adminRow.admin_nick}[ {$value.adminRow.admin_nick} ]{/if}</a>
											{else}
												{$lang.label.unknow}
											{/if}
										</td>
									</tr>
								{/foreach}
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2"><span id="msg_attach_id"></span></td>
									<td colspan="3">
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

{include "include/admin_foot.tpl" cfg=$cfg}

	<script type="text/javascript">
	var opts_validator_list = {
		attach_id: {
			length: { min: 1, max: 0 },
			validate: { type: "checkbox" },
			msg: { id: "msg_attach_id", too_few: "{$alert.x030202}" }
		}
	};

	var opts_submit_list = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=attach",
		confirm_id: "act_post",
		confirm_val: "del",
		confirm_msg: "{$lang.confirm.del}",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	$(document).ready(function(){
		var obj_validate_list = $("#attach_list").baigoValidator(opts_validator_list);
		var obj_submit_list = $("#attach_list").baigoSubmit(opts_submit_list);
		$("#go_submit").click(function(){
			if (obj_validate_list.validateSubmit()) {
				obj_submit_list.formSubmit();
			}
		});
		$("#attach_list").baigoCheckall();
	});
	</script>

{include "include/html_foot.tpl" cfg=$cfg}