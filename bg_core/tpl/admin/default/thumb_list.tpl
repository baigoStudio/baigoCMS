{* admin_groupForm.tpl 管理组编辑界面 *}
{$cfg = [
	title          => "{$adminMod.attach.main.title} - {$adminMod.attach.sub.thumb.title}",
	menu_active    => "attach",
	sub_active     => "thumb",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	baigoClear     => "true",
	tokenReload    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=thumb&{$tplData.query}"
]}

{include "{$smarty.const.BG_PATH_SYSTPL_ADMIN}default/include/admin_head.tpl" cfg=$cfg}

	<li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=attach&act_get=list">{$adminMod.attach.main.title}</a></li>
	<li>{$adminMod.attach.sub.thumb.title}</li>

	{include "{$smarty.const.BG_PATH_SYSTPL_ADMIN}default/include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<ul class="nav nav-pills nav_baigo">
			<li>
				<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=thumb&act_get=list">
					<span class="glyphicon glyphicon-plus"></span>
					{$lang.href.add}
				</a>
			</li>
			<li>
				<a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=attach#thumb" target="_blank">
					<span class="glyphicon glyphicon-question-sign"></span>
					{$lang.href.help}
				</a>
			</li>
		</ul>
	</div>

	<div class="row">
		<div class="col-md-3">
			<div class="well">
				<form name="thumb_form" id="thumb_form">

					<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
					<input type="hidden" name="thumb_id" value="{$tplData.thumbRow.thumb_id}">
					<input type="hidden" name="act_post" value="submit">
					{if $tplData.thumbRow.thumb_id > 0}
						<div class="form-group">
							<label class="control-label">{$lang.label.id}</label>
							<p class="form-control-static">{$tplData.thumbRow.thumb_id}</p>
						</div>
					{/if}

					<div class="form-group">
						<label class="control-label">{$lang.label.thumbWidth}<span id="msg_thumb_width">*</span></label>
						<input type="text" name="thumb_width" id="thumb_width" value="{$tplData.thumbRow.thumb_width}" class="validate form-control">
					</div>

					<div class="form-group">
						<label class="control-label">{$lang.label.thumbHeight}<span id="msg_thumb_height">*</span></label>
						<input type="text" name="thumb_height" id="thumb_height" value="{$tplData.thumbRow.thumb_height}" class="validate form-control">
					</div>

					<label class="control-label">{$lang.label.thumbType}<span id="msg_thumb_type">*</span></label>
					<div class="form-group">
						{foreach $type.thumb as $_key=>$_value}
							<div class="radio_baigo">
								<label for="thumb_type_{$_key}">
									<input type="radio" name="thumb_type" id="thumb_type_{$_key}" value="{$_key}" {if $tplData.thumbRow.thumb_type == $_key}checked{/if} class="validate" group="thumb_type">
									{$_value}
								</label>
							</div>
						{/foreach}
					</div>

					<div class="form-group">
						<button type="button" id="go_save" class="btn btn-primary">{$lang.btn.save}</button>
					</div>
				</form>
			</div>

			{if $tplData.thumbRow.thumb_id > 0}
				<div class="well">
					<form name="thumb_gen" id="thumb_gen">
						<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
						<input type="hidden" name="thumb_id" value="{$tplData.thumbRow.thumb_id}">
						<input type="hidden" name="act_post" id="act_gen" value="gen">
						<div class="form-group">
							<label class="control-label">{$lang.label.rangeId}</label>
							<div class="input-group">
								<input type="text" name="attach_range[begin]" id="attach_range_begin" value="0" class="form-control">
								<span class="input-group-addon input_range">{$lang.label.to}</span>
								<input type="text" name="attach_range[end]" id="attach_range_end" value="0" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<button type="button" class="btn btn-warning" id="go_gen">
								<span class="glyphicon glyphicon-refresh"></span>
								{$lang.btn.thumbGen}
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
				</div>
			{/if}
		</div>

		<div class="col-md-9">
			<form name="thumb_list" id="thumb_list" class="form-inline">
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
									<th>{$lang.label.thumbWidth} X {$lang.label.thumbHeight}</th>
									<th class="td_bg">{$lang.label.thumbCall}</th>
									<th class="td_sm">{$lang.label.thumbType}</th>
								</tr>
							</thead>
							<tbody>
								{foreach $tplData.thumbRows as $key=>$value}
									<tr>
										<td class="td_mn"><input type="checkbox" name="thumb_id[]" value="{$value.thumb_id}" id="thumb_id_{$value.thumb_id}" group="thumb_id" class="chk_all validate"></td>
										<td class="td_mn">{$value.thumb_id}</td>
										<td>
											<ul class="list-unstyled">
												<li>{$value.thumb_width} X {$value.thumb_height}</li>
												<li>
													{if $value.thumb_id > 0}
														<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=thumb&act_get=list&thumb_id={$value.thumb_id}">{$lang.href.edit}</a>
													{else}
														{$lang.href.edit}
													{/if}
												</li>
											</ul>
										</td>
										<td class="td_bg">thumb_{$value.thumb_width}_{$value.thumb_height}_{$value.thumb_type}</td>
										<td class="td_sm">{$type.thumb[$value.thumb_type]}</td>
									</tr>
								{/foreach}
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2"><span id="msg_thumb_id"></span></td>
									<td colspan="3">
										<div class="form-group">
											<select name="act_post" id="act_post" class="validate form-control input-sm">
												<option value="">{$lang.option.batch}</option>
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
		</div>
	</div>

	<div class="text-right">
		{include "{$smarty.const.BG_PATH_SYSTPL_ADMIN}default/include/page.tpl" cfg=$cfg}
	</div>


{include "{$smarty.const.BG_PATH_SYSTPL_ADMIN}default/include/admin_foot.tpl" cfg=$cfg}

	<script type="text/javascript">
	var opts_validator_list = {
		thumb_id: {
			length: { min: 1, max: 0 },
			validate: { type: "checkbox" },
			msg: { id: "msg_thumb_id", too_few: "{$alert.x030202}" }
		},
		act_post: {
			length: { min: 1, max: 0 },
			validate: { type: "select" },
			msg: { id: "msg_act_post", too_few: "{$alert.x030203}" }
		}
	};

	var opts_validator_form = {
		thumb_width: {
			length: { min: 1, max: 0 },
			validate: { type: "str", format: "int" },
			msg: { id: "msg_thumb_width", too_short: "{$alert.x090201}", format_err: "{$alert.x090202}" }
		},
		thumb_height: {
			length: { min: 1, max: 0 },
			validate: { type: "str", format: "int" },
			msg: { id: "msg_thumb_height", too_short: "{$alert.x090203}", format_err: "{$alert.x090204}" }
		},
		thumb_type: {
			length: { min: 1, max: 0 },
			validate: { type: "radio" },
			msg: { id: "msg_thumb_type", too_few: "{$alert.x090205}" }
		}
	};

	var opts_submit_list = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=thumb",
		confirm_id: "act_post",
		confirm_val: "del",
		confirm_msg: "{$lang.confirm.del}",
		text_submitting: "{$lang.label.submitting}",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	var opts_submit_form = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=thumb",
		text_submitting: "{$lang.label.submitting}",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	var opts_gen = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=attach",
		confirm_id: "act_gen",
		confirm_val: "gen",
		confirm_msg: "{$lang.confirm.gen}",
		msg_loading: "{$alert.x070409}",
		msg_complete: "{$alert.y070409}"
	};

	$(document).ready(function(){
		var obj_validate_list = $("#thumb_list").baigoValidator(opts_validator_list);
		var obj_submit_list   = $("#thumb_list").baigoSubmit(opts_submit_list);
		$("#go_submit").click(function(){
			if (obj_validate_list.validateSubmit()) {
				obj_submit_list.formSubmit();
			}
		});
		var obj_validate_form = $("#thumb_form").baigoValidator(opts_validator_form);
		var obj_submit_form   = $("#thumb_form").baigoSubmit(opts_submit_form);
		$("#go_save").click(function(){
			if (obj_validate_form.validateSubmit()) {
				obj_submit_form.formSubmit();
			}
		});
		var obj_gen = $("#thumb_gen").baigoClear(opts_gen);
		$("#go_gen").click(function(){
			obj_gen.clearSubmit();
		});
		$("#thumb_list").baigoCheckall();
	})
	</script>

{include "{$smarty.const.BG_PATH_SYSTPL_ADMIN}default/include/html_foot.tpl" cfg=$cfg}
