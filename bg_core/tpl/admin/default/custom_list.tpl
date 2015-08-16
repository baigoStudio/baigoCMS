{* custom_list.tpl 标签列表 *}
{function custom_list arr=""}
	{foreach $arr as $key=>$value}
		{if $value.custom_status == "enable"}
			{$_css_status = "success"}
		{else}
			{$_css_status = "danger"}
		{/if}
		<tr{if $value.custom_level == 1} class="active"{/if}>
			<td class="td_mn"><input type="checkbox" name="custom_id[]" value="{$value.custom_id}" id="custom_id_{$value.custom_id}" group="custom_id" class="chk_all validate"></td>
			<td class="td_mn">{$value.custom_id}</td>
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
								<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=custom&act_get=list&custom_id={$value.custom_id}">{$lang.href.edit}</a>
							</li>
							<li>
								<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=custom&act_get=order&custom_id={$value.custom_id}&view=iframe" data-toggle="modal" data-target="#custom_modal">{$lang.href.order}</a>
							</li>
						</ul>
					</li>
				</ul>
			</td>
			<td class="td_sm">
				<ul class="list-unstyled">
					<li class="label_baigo">{$value.custom_type}</li>
					<li>{$value.custom_opt}</li>
				</ul>
			</td>
			<td class="td_sm">
				<ul class="list-unstyled">
					<li class="label_baigo">
						<span class="label label-{$_css_status}">{$status.custom[$value.custom_status]}</span>
					</li>
					<li>{$type.target[$value.custom_target]}</li>
				</ul>
			</td>
		</tr>

		{if $value.custom_childs}
			{custom_list arr=$value.custom_childs}
		{/if}
	{/foreach}
{/function}

{function custom_opt arr=""}
	{foreach $arr as $key=>$value}
		<option value="{$value.custom_id}" {if $tplData.customRow.custom_parent_id == $value.custom_id}selected{/if} {if $tplData.customRow.custom_id == $value.custom_id}disabled{/if}>
			{if $value.custom_level > 1}
				{for $_i=2 to $value.custom_level}
					&nbsp;&nbsp;
				{/for}
			{/if}
			{$value.custom_name}
		</option>

		{if $value.custom_childs}
			{custom_opt arr=$value.custom_childs}
		{/if}
	{/foreach}
{/function}

{$cfg = [
	title          => "{$adminMod.opt.main.title} - {$adminMod.opt.sub.custom.title}",
	menu_active    => "opt",
	sub_active     => "custom",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	tokenReload    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=custom&{$tplData.query}"
]}

{include "{$smarty.const.BG_PATH_SYSTPL_ADMIN}default/include/admin_head.tpl"}

	<li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=opt">{$adminMod.opt.main.title}</a></li>
	<li>{$adminMod.opt.sub.custom.title}</li>

	{include "{$smarty.const.BG_PATH_SYSTPL_ADMIN}default/include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<div class="pull-left">
			<div class="form-group">
				<ul class="nav nav-pills nav_baigo">
					<li>
						<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=custom&act_get=list">
							<span class="glyphicon glyphicon-plus"></span>
							{$lang.href.add}
						</a>
					</li>
					<li>
						<a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=tag#custom" target="_blank">
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
					<select name="type" class="form-control input-sm">
						<option value="">{$lang.option.allType}</option>
						{foreach $type.custom as $key=>$value}
							<option {if $tplData.search.type == $key}selected{/if} value="{$key}">{$value}</option>
						{/foreach}
					</select>
				</div>
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

	<div class="row">
		<div class="col-md-3">
			<div class="well">
				<form name="custom_form" id="custom_form">
					<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
					<input type="hidden" name="custom_id" id="custom_id" value="{$tplData.customRow.custom_id}">
					<input type="hidden" name="act_post" value="submit">

					{if $tplData.customRow.custom_id > 0}
						<div class="form-group">
							<label class="control-label">{$lang.label.id}</label>
							<p class="form-control-static">{$tplData.customRow.custom_id}</p>
						</div>
					{/if}

					<div class="form-group">
						<label for="custom_name" class="control-label">{$lang.label.customName}<span id="msg_custom_name">*</span></label>
						<input type="text" name="custom_name" id="custom_name" value="{$tplData.customRow.custom_name}" class="validate form-control">
					</div>

					<div class="form-group">
						<label for="custom_target" class="control-label">{$lang.label.customTarget}<span id="msg_custom_target">*</span></label>
						<select id="custom_target" name="custom_target" id="custom_target" class="validate form-control">
							<option value="">{$lang.option.pleaseSelect}</option>
							{foreach $type.target as $key=>$value}
								<option {if $tplData.customRow.custom_target == $key}selected{/if} value="{$key}">{$value}</option>
							{/foreach}
						</select>
					</div>

					<div class="form-group">
						<label for="custom_type" class="control-label">{$lang.label.type}<span id="msg_custom_type">*</span></label>
						<select id="custom_type" name="custom_type" id="custom_type" class="validate form-control">
							<option value="">{$lang.option.pleaseSelect}</option>
							{foreach $tplData.fields as $key=>$value}
								<option {if $tplData.customRow.custom_type == $key}selected{/if} value="{$key}">{$value["note"]}</option>
							{/foreach}
						</select>
					</div>

					<div class="form-group">
						<label for="custom_opt" class="control-label">{$lang.label.customOpt}<span id="msg_custom_opt"></span></label>
						<input type="text" name="custom_opt" id="custom_opt" value="{$tplData.customRow.custom_opt}" class="validate form-control">
						<p class="help-block">{$lang.label.customOptNote}</p>
					</div>

					<div class="form-group">
						<label for="custom_parent_id" class="control-label">{$lang.label.customParent}<span id="msg_custom_parent_id">*</span></label>
						<select name="custom_parent_id" id="custom_parent_id" class="validate form-control">
							<option value="">{$lang.option.pleaseSelect}</option>
							<option {if $tplData.customRow.custom_parent_id == 0}selected{/if} value="0">{$lang.option.asCustomParent}</option>
							{custom_opt arr=$tplData.customRows}
						</select>
					</div>

					<label class="control-label">{$lang.label.status}<span id="msg_custom_status">*</span></label>
					<div class="form-group">
						{foreach $status.custom as $key=>$value}
							<div class="radio_baigo">
								<label for="custom_status_{$key}">
									<input type="radio" name="custom_status" id="custom_status_{$key}" value="{$key}" class="validate" {if $tplData.customRow.custom_status == $key}checked{/if} group="custom_status">
									{$value}
								</label>
							</div>
						{/foreach}
					</div>

					<div class="form-group">
						<button type="button" id="custom_add" class="btn btn-primary">{$lang.btn.save}</button>
					</div>
				</form>
			</div>
		</div>

		<div class="col-md-9">
			<form name="custom_list" id="custom_list" class="form-inline">
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
									<th>{$lang.label.customName}</th>
									<th class="td_sm">{$lang.label.type} / {$lang.label.customOpt}</th>
									<th class="td_sm">{$lang.label.status} / {$lang.label.customTarget}</th>
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
		</div>
	</div>

	<div class="text-right">
		{include "{$smarty.const.BG_PATH_SYSTPL_ADMIN}default/include/page.tpl" cfg=$cfg}
	</div>

	<div class="modal fade" id="custom_modal">
		<div class="modal-dialog">
			<div class="modal-content"></div>
		</div>
	</div>

{include "{$smarty.const.BG_PATH_SYSTPL_ADMIN}default/include/admin_foot.tpl"}

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

	var obj_fields_list = {$tplData.fieldsJson};

	var opts_validator_form = {
		custom_name: {
			length: { min: 1, max: 90 },
			validate: { type: "ajax", format: "text" },
			msg: { id: "msg_custom_name", too_short: "{$alert.x200201}", too_long: "{$alert.x200202}", ajaxIng: "{$alert.x030401}", ajax_err: "{$alert.x030402}" },
			ajax: { url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=custom&act_get=chkname", key: "custom_name", type: "str", attach_selectors: ["#custom_id","#custom_type"], attach_keys: ["custom_id","custom_type"] }
		},
		custom_target: {
			length: { min: 1, max: 0 },
			validate: { type: "select" },
			msg: { id: "msg_custom_target", too_few: "{$alert.x200205}" }
		},
		custom_type: {
			length: { min: 1, max: 0 },
			validate: { type: "select" },
			msg: { id: "msg_custom_type", too_few: "{$alert.x200211}" }
		},
		custom_opt: {
			length: { min: 0, max: 900 },
			validate: { type: "str", format: "text" },
			msg: { id: "msg_custom_opt", too_long: "{$alert.x200212}" }
		},
		custom_parent_id: {
			length: { min: 1, max: 0 },
			validate: { type: "select" },
			msg: { id: "msg_custom_parent_id", too_few: "{$alert.x200207}" }
		},
		custom_status: {
			length: { min: 1, max: 0 },
			validate: { type: "radio" },
			msg: { id: "msg_custom_status", too_few: "{$alert.x200206}" }
		}
	};

	var opts_submit_list = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=custom",
		confirm_id: "act_post",
		confirm_val: "del",
		confirm_msg: "{$lang.confirm.del}",
		text_submitting: "{$lang.label.submitting}",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	var opts_submit_form = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=custom",
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
		var obj_submit_list = $("#custom_list").baigoSubmit(opts_submit_list);
		$("#go_submit").click(function(){
			if (obj_validate_list.validateSubmit()) {
				obj_submit_list.formSubmit();
			}
		});
		var obj_validate_form = $("#custom_form").baigoValidator(opts_validator_form);
		var obj_submit_form = $("#custom_form").baigoSubmit(opts_submit_form);
		$("#custom_add").click(function(){
			if (obj_validate_form.validateSubmit()) {
				obj_submit_form.formSubmit();
			}
		});
		$("#custom_type").change(function(){
			var _this_val = $(this).val();
			if (_this_val.length > 0) {
				var _this_opt = obj_fields_list[_this_val].opt;
				$("#custom_opt").val(_this_opt);
			}
		});
		$("#custom_list").baigoCheckall();
	})
	</script>

{include "{$smarty.const.BG_PATH_SYSTPL_ADMIN}default/include/html_foot.tpl" cfg=$cfg}

