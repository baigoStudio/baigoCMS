{*attach_list.php 上传管理*}
{$cfg = [
	title          => $adminMod.attach.main.title,
	menu_active    => "attach",
	sub_active     => "list",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	baigoClear     => "true",
	upload         => "true",
	tokenReload    => "true",
	tooltip        => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=attach&{$tplData.query}"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl" cfg=$cfg}

	<li>{$adminMod.attach.main.title}</li>

	{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<div class="pull-left">
			<div class="form-group">
				<ul class="nav nav-pills nav_baigo">
					<li {if $tplData.search.box == "normal"}class="active"{/if}>
						<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=attach">
							{$lang.href.all}
							<span class="badge">{$tplData.attachCount.all}</span>
						</a>
					</li>
					{if $tplData.attachCount.recycle > 0}
						<li {if $tplData.search.box == "recycle"}class="active"{/if}>
							<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=attach&box=recycle">
								{$lang.href.recycle}
								<span class="badge">{$tplData.attachCount.recycle}</span>
							</a>
						</li>
					{/if}
					<li>
						<a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=attach" target="_blank">
							<span class="glyphicon glyphicon-question-sign"></span>
							{$lang.href.help}
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="pull-right">
			<form name="attach_search" id="attach_search" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get" class="form-inline">
				<input type="hidden" name="mod" value="attach">
				<input type="hidden" name="act_get" value="list">
				<div class="form-group">
					<select name="year" class="form-control input-sm">
						<option value="">{$lang.option.allYear}</option>
						{foreach $tplData.yearRows as $key=>$value}
							<option {if $tplData.search.year == $value.attach_year}selected{/if} value="{$value.attach_year}">{$value.attach_year}</option>
						{/foreach}
					</select>
				</div>
				<div class="form-group">
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
				</div>
				<div class="form-group">
					<select name="ext" class="form-control input-sm">
						<option value="">{$lang.option.allExt}</option>
						{foreach $tplData.extRows as $key=>$value}
							<option {if $tplData.search.ext == $value.attach_ext}selected{/if} value="{$value.attach_ext}">{$value.attach_ext}</option>
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

	<div class="row">
		<div class="col-md-3">
			<div class="well">
				{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/upload.tpl" cfg=$cfg}
			</div>
			<div class="well">
				{if $tplData.search.box == "recycle"}
					<form name="attach_empty" id="attach_empty">
						<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
						<input type="hidden" name="act_post" id="act_empty" value="empty">
						<div class="form-group">
							<button type="button" class="btn btn-warning" id="go_empty">
								<span class="glyphicon glyphicon-trash"></span>
								{$lang.btn.empty}
							</button>
						</div>
						<div class="form-group">
							<div class="baigoClear progress">
								<div class="progress-bar progress-bar-info progress-bar-striped active"></div>
							</div>
						</div>
						<div class="form-group">
							<div class="baigoClearMsg">

							</div>
						</div>
					</form>
				{else}
					<form name="attach_clear" id="attach_clear">
						<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
						<input type="hidden" name="act_post" id="act_clear" value="clear">
						<div class="form-group">
							<button type="button" class="btn btn-warning" id="go_clear">
								<span class="glyphicon glyphicon-trash"></span>
								{$lang.btn.attachClear}
							</button>
						</div>
						<div class="form-group">
							<div class="baigoClear progress">
								<div class="progress-bar progress-bar-info progress-bar-striped active"></div>
							</div>
						</div>
						<div class="form-group">
							<div class="baigoClearMsg">

							</div>
						</div>
					</form>
				{/if}
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
									<th class="text-nowrap td_mn">
										<label for="chk_all" class="checkbox-inline">
											<input type="checkbox" name="chk_all" id="chk_all" class="first">
											{$lang.label.all}
										</label>
									</th>
									<th class="text-nowrap td_mn">{$lang.label.id}</th>
									<th class="text-nowrap td_sm">{$lang.label.attachThumb}</th>
									<th>{$lang.label.attachInfo}</th>
									<th class="text-nowrap td_md">{$lang.label.status} / {$lang.label.admin}</th>
								</tr>
							</thead>
							<tbody>
								{foreach $tplData.attachRows as $key=>$value}
									{if $value.attach_box == "normal"}
										{$_css_status = "success"}
									{else}
										{$_css_status = "default"}
									{/if}
									<tr>
										<td class="text-nowrap td_mn"><input type="checkbox" name="attach_id[]" value="{$value.attach_id}" id="attach_id_{$value.attach_id}" group="attach_id" class="chk_all validate"></td>
										<td class="text-nowrap td_mn">{$value.attach_id}</td>
										<td class="text-nowrap td_sm">
											{if $value.attach_type == "image"}
												<a href="{$value.attach_url}" target="_blank"><img src="{$value.attach_thumb.0.thumb_url}" alt="{$value.attach_name}" width="100"></a>
											{else}
												<a href="{$value.attach_url}" target="_blank"><img src="{$smarty.const.BG_URL_STATIC}image/file_{$value.attach_ext}.png" alt="{$value.attach_name}" width="50"></a>
											{/if}
										</td>
										<td>
											<ul class="list-unstyled">
												<li><a href="{$value.attach_url}" target="_blank">{$value.attach_name}</a></li>
												<li>
													<abbr data-toggle="tooltip" data-placement="bottom" title="{$value.attach_time|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIME}"}">{$value.attach_time|date_format:$smarty.const.BG_SITE_DATE}</abbr>
												</li>
												{if $value.attach_size > 1024}
													{$_num_attachSize = $value.attach_size / 1024}
													{$_str_attachUnit = "KB"}
												{else if $value.attach_size > 1024 * 1024}
													{$_num_attachSize = $value.attach_size / 1024 / 1024}
													{$_str_attachUnit = "MB"}
												{else if $value.attach_size > 1024 * 1024 * 1024}
													{$_num_attachSize = $value.attach_size / 1024 / 1024 / 1024}
													{$_str_attachUnit = "GB"}
												{else}
													{$_num_attachSize = $value.attach_size}
													{$_str_attachUnit = "Byte"}
												{/if}
												<li>{$_num_attachSize|string_format:"%.2f"} {$_str_attachUnit}</li>
												<li>
													{if $value.attach_type == "image"}
														<div class="dropdown">
															<button class="btn btn-default dropdown-toggle btn-sm" type="button" id="attach_{$value.attach_id}" data-toggle="dropdown">
																{$lang.btn.thumb}
																<span class="caret"></span>
															</button>
															<ul class="dropdown-menu">
																{foreach $value.attach_thumb as $key_thumb=>$value_thumb}
																	<li><a href="{$value_thumb.thumb_url}" target="_blank">{$value_thumb.thumb_width}x{$value_thumb.thumb_height} {$type.thumb[$value_thumb.thumb_type]}</a></li>
																{/foreach}
															</ul>
														</div>
													{/if}
												</li>
											</ul>
										</td>
										<td class="text-nowrap td_md">
											<ul class="list-unstyled">
												<li class="label_baigo">
													<span class="label label-{$_css_status}">{$lang.label[$value.attach_box]}</span>
												</li>
												<li>
													{if isset($value.adminRow.admin_name)}
														<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=attach&admin_id={$value.attach_admin_id}">{$value.adminRow.admin_name}</a>
													{else}
														{$lang.label.unknown}
													{/if}
												</li>
											</ul>
										</td>
									</tr>
								{/foreach}
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2">
										<span id="msg_attach_id"></span>
									</td>
									<td colspan="3">
										<div class="form-group">
											<select name="act_post" id="act_post" class="validate form-control input-sm">
												<option value="">{$lang.option.batch}</option>
												{if $tplData.search.box == "recycle"}
													<option value="normal">{$lang.option.revert}</option>
													<option value="del">{$lang.option.del}</option>
												{else}
													<option value="recycle">{$lang.option.recycle}</option>
												{/if}
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
		</div>
	</div>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_foot.tpl" cfg=$cfg}

	<script type="text/javascript">
	var opts_validator_list = {
		attach_id: {
			length: { min: 1, max: 0 },
			validate: { type: "checkbox" },
			msg: { id: "msg_attach_id", too_few: "{$alert.x030202}" }
		},
		act_post: {
			length: { min: 1, "max": 0 },
			validate: { type: "select" },
			msg: { id: "msg_act_post", too_few: "{$alert.x030203}" }
		}
	};

	var opts_submit_list = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=attach",
		confirm_selector: "#act_post",
		confirm_val: "del",
		confirm_msg: "{$lang.confirm.del}",
		text_submitting: "{$lang.label.submitting}",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	var opts_empty = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=attach",
		confirm_selector: "#act_empty",
		confirm_val: "empty",
		confirm_msg: "{$lang.confirm.empty}",
		msg_loading: "{$alert.x070408}",
		msg_complete: "{$alert.y070408}"
	};

	var opts_clear = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=attach",
		confirm_selector: "#act_clear",
		confirm_val: "clear",
		confirm_msg: "{$lang.confirm.clear}",
		msg_loading: "{$alert.x070407}",
		msg_complete: "{$alert.y070407}"
	};

	$(document).ready(function(){
		var obj_validate_list = $("#attach_list").baigoValidator(opts_validator_list);
		var obj_submit_list   = $("#attach_list").baigoSubmit(opts_submit_list);
		$("#go_submit").click(function(){
			if (obj_validate_list.validateSubmit()) {
				obj_submit_list.formSubmit();
			}
		});
		var obj_empty = $("#attach_empty").baigoClear(opts_empty);
		$("#go_empty").click(function(){
			obj_empty.clearSubmit();
		});
		var obj_clear  = $("#attach_clear").baigoClear(opts_clear);
		$("#go_clear").click(function(){
			obj_clear.clearSubmit();
		});
		$("#attach_list").baigoCheckall();
	});
	</script>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}