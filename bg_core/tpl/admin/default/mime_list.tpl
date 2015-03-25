{* mime_list.php 允许上传类型列表 *}
{$cfg = [
	title          => "{$adminMod.attach.main.title} - {$adminMod.attach.sub.mime.title}",
	menu_active    => "attach",
	sub_active     => "mime",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	tokenReload    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=mime&{$tplData.query}"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=attach&act_get=list">{$adminMod.attach.main.title}</a></li>
	<li>{$adminMod.attach.sub.mime.title}</li>

	{include "include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<ul class="list-inline">
			<li>
				<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=mime&act_get=list">
					<span class="glyphicon glyphicon-plus"></span>
					{$lang.href.add}
				</a>
			</li>
			<li>
				<a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=attach#mime" target="_blank">
					<span class="glyphicon glyphicon-question-sign"></span>
					{$lang.href.help}
				</a>
			</li>
		</ul>
	</div>

	<div class="row">
		<div class="col-md-3">
			<div class="well">
				<form name="mime_form" id="mime_form">
					<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
					<input type="hidden" name="mime_id" value="{$tplData.mimeRow.mime_id}">
					<input type="hidden" name="act_post" value="submit">

					{if $tplData.mimeRow.mime_id > 0}
						<div class="form-group">
							<label class="control-label">{$lang.label.id}</label>
							<p class="form-control-static">{$tplData.mimeRow.mime_id}</p>
						</div>
					{/if}

					<div class="form-group">
						<label for="mime_name" class="control-label">{$lang.label.mimeName}<span id="msg_mime_name">*</span></label>
						<input type="text" name="mime_name" id="mime_name" value="{$tplData.mimeRow.mime_name}" class="validate form-control">
					</div>

					<div class="form-group">
						<label for="mime_ext" class="control-label">{$lang.label.ext}<span id="msg_mime_ext">*</span></label>
						<input type="text" name="mime_ext" id="mime_ext" value="{$tplData.mimeRow.mime_ext}" class="validate form-control">
					</div>

					<div class="form-group">
						<label for="mime_note" class="control-label">{$lang.label.note}<span id="msg_mime_note"></span></label>
						<input type="text" name="mime_note" id="mime_note" value="{$tplData.mimeRow.mime_note}" class="validate form-control">
					</div>

					<div class="form-group">
						<label form="mime_name_often" class="control-label">{$lang.label.mimeOften}</label>
						<select id="mime_name_often" class="form-control">
							<option value="">{$lang.option.pleaseSelect}</option>
							{foreach $tplData.mimeOften as $key=>$value}
								<option value="{$key}">{$key}</option>
							{/foreach}
						</select>
					</div>

					<div class="form-group">
						<button type="button" id="mime_add" class="btn btn-primary">{$lang.btn.save}</button>
					</div>
				</form>
			</div>
		</div>

		<div class="col-md-9">
			<form name="mime_list" id="mime_list">
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
									<th>{$lang.label.mimeName}</th>
									<th class="td_md">{$lang.label.ext} / {$lang.label.note}</th>
								</tr>
							</thead>
							<tbody>
								{foreach $tplData.mimeRows as $value}
									<tr>
										<td class="td_mn"><input type="checkbox" name="mime_id[]" value="{$value.mime_id}" id="mime_id_{$value.mime_id}" class="chk_all validate" group="mime_id"></td>
										<td class="td_mn">{$value.mime_id}</td>
										<td>
											<ul class="list-unstyled">
												<li>{$value.mime_name}</li>
												<li>
													<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=mime&act_get=list&mime_id={$value.mime_id}">{$lang.href.edit}</a>
												</li>
											</ul>
										</td>
										<td class="td_md">
											<ul class="list-unstyled">
												<li>{$value.mime_ext}</li>
												<li>{$value.mime_note}</li>
											</ul>
										</td>
									</tr>
								{/foreach}
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2"><span id="msg_mime_id"></span></td>
									<td colspan="2">
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
		mime_id: {
			length: { min: 1, max: 0 },
			validate: { type: "checkbox" },
			msg: { id: "msg_mime_id", too_few: "{$alert.x030202}" }
		}
	};

	var obj_mime_list = {$tplData.mimeJson};

	var opts_validator_form = {
		mime_name: {
			length: { min: 1, max: 300 },
			validate: { type: "ajax", format: "text" },
			msg: { id: "msg_mime_name", too_short: "{$alert.x080201}", too_long: "{$alert.x080202}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
			ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=mime&act_get=chkname", key: "mime_name", type: "str" }
		},
		mime_ext: {
			length: { min: 1, max: 10 },
			validate: { type: "str", format: "text" },
			msg: { id: "msg_mime_ext", too_short: "{$alert.x080203}", too_long: "{$alert.x080204}" }
		},
		mime_note: {
			length: { min: 0, max: 300 },
			validate: { type: "str", format: "text" },
			msg: { id: "msg_mime_note", too_long: "{$alert.x080205}" }
		}
	};

	var opts_submit_list = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=mime",
		confirm_id: "act_post",
		confirm_val: "del",
		confirm_msg: "{$lang.confirm.del}",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	var opts_submit_form = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=mime",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	$(document).ready(function(){
		var obj_validate_list = $("#mime_list").baigoValidator(opts_validator_list);
		var obj_submit_list = $("#mime_list").baigoSubmit(opts_submit_list);
		$("#go_submit").click(function(){
			if (obj_validate_list.validateSubmit()) {
				obj_submit_list.formSubmit();
			}
		});
		var obj_validate_form = $("#mime_form").baigoValidator(opts_validator_form);
		var obj_submit_form = $("#mime_form").baigoSubmit(opts_submit_form);
		$("#mime_add").click(function(){
			if (obj_validate_form.validateSubmit()) {
				obj_submit_form.formSubmit();
			}
		});
		//常用MIME
		$("#mime_name_often").change(function(){
			var _this_val = $(this).val();
			if (_this_val.length > 0) {
				var _this_ext = obj_mime_list[_this_val].ext;
				var _this_note = obj_mime_list[_this_val].note;
				$("#mime_name").val(_this_val);
				$("#mime_ext").val(_this_ext);
				$("#mime_note").val(_this_note);
			}
		});
		$("#mime_list").baigoCheckall();
	})
	</script>

{include "include/html_foot.tpl" cfg=$cfg}

