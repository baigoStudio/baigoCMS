{* admin_groupForm.tpl 管理组编辑界面 *}
{$cfg = [
	title          => "{$adminMod.attach.main.title} - {$adminMod.attach.sub.thumb.title}",
	menu_active    => "attach",
	sub_active     => "thumb",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=thumb&{$tplData.query}"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=attach&act_get=list">{$adminMod.attach.main.title}</a></li>
	<li>{$adminMod.attach.sub.thumb.title}</li>

	{include "include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<ul class="list-inline">
			<li>
				<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=thumb&act_get=list">
					<span class="glyphicon glyphicon-plus"></span>
					{$lang.href.add}
				</a>
			</li>
			<li>
				<a href="{$smarty.const.BG_URL_HELP}?lang=zh_CN&mod=help&act=attach#thumb" target="_blank">
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

					<input type="hidden" name="token_session" value="{$common.token_session}">
					<input type="hidden" name="thumb_id" value="{$tplData.thumbRow.thumb_id}">
					<input type="hidden" name="act_post" value="submit">
					{if $tplData.thumbRow.thumb_id > 0}
						<div class="form-group">
							<label class="control-label">{$lang.label.id}</label>
							<p class="form-control-static">{$tplData.thumbRow.thumb_id}</p>
						</div>
					{/if}

					<div class="form-group">
						<label form="thumb_width" class="control-label">{$lang.label.thumbWidth}<span id="msg_thumb_width">*</span></label>
						<input type="text" name="thumb_width" id="thumb_width" value="{$tplData.thumbRow.thumb_width}" class="validate form-control">
					</div>

					<div class="form-group">
						<label form="thumb_height" class="control-label">{$lang.label.thumbHeight}<span id="msg_thumb_height">*</span></label>
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
						<button type="button" id="thumb_add" class="btn btn-primary">{$lang.btn.save}</button>
					</div>
				</form>
			</div>
		</div>

		<div class="col-md-9">
			<div class="panel panel-default">
				<form name="thumb_list" id="thumb_list" class="form-inline">

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
									<th>{$lang.label.thumbWidth} X {$lang.label.thumbHeight}</th>
									<th class="td_bg">{$lang.label.thumbCall}</th>
									<th class="td_sm">{$lang.label.thumbType}</th>
								</tr>
							</thead>
							<tbody>
								{foreach $tplData.thumbRows as $value}
									<tr>
										<td class="td_mn"><input type="checkbox" name="thumb_id[]" value="{$value.thumb_id}" id="thumb_id_{$value.thumb_id}" group="thumb_id" class="chk_all validate"></td>
										<td class="td_mn">{$value.thumb_id}</td>
										<td>
											<div>{$value.thumb_width} X {$value.thumb_height}</div>
											<div>
												{if $value.thumb_id > 0}
													<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=thumb&act_get=list&thumb_id={$value.thumb_id}">{$lang.href.edit}</a>
												{else}
													{$lang.href.edit}
												{/if}
											</div>
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
										<input type="hidden" name="act_post" id="act_post" value="del">
										<button type="button" id="go_submit" class="btn btn-primary btn-sm">{$lang.btn.del}</button>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="text-right">
		{include "include/page.tpl" cfg=$cfg}
	</div>


{include "include/admin_foot.tpl" cfg=$cfg}

	<script type="text/javascript">
	var opts_validator_list = {
		thumb_id: {
			length: { min: 1, max: 0 },
			validate: { type: "checkbox" },
			msg: { id: "msg_thumb_id", too_few: "{$alert.x030202}" }
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
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	var opts_submit_form = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=thumb",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	$(document).ready(function(){
		var obj_validate_list = $("#thumb_list").baigoValidator(opts_validator_list);
		var obj_submit_list = $("#thumb_list").baigoSubmit(opts_submit_list);
		$("#go_submit").click(function(){
			if (obj_validate_list.validateSubmit()) {
				obj_submit_list.formSubmit();
			}
		});
		var obj_validate_form = $("#thumb_form").baigoValidator(opts_validator_form);
		var obj_submit_form = $("#thumb_form").baigoSubmit(opts_submit_form);
		$("#thumb_add").click(function(){
			if (obj_validate_form.validateSubmit()) {
				obj_submit_form.formSubmit();
			}
		});
		$("#thumb_list").baigoCheckall();
	})
	</script>

{include "include/html_foot.tpl" cfg=$cfg}
