{$cfg = [
	title          => "{$adminMod.article.main.title} - {$adminMod.article.sub.spec.title}",
	menu_active    => "article",
	sub_active     => "spec",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	tinymce        => "true",
	upload         => "true",
	tokenReload    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=spec"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl" cfg=$cfg}

	<li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=list">{$adminMod.article.main.title}</a></li>
	<li>{$adminMod.article.sub.spec.title}</li>

	{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<ul class="nav nav-pills nav_baigo">
			<li>
				<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=spec&act_get=list">
					<span class="glyphicon glyphicon-chevron-left"></span>
					{$lang.href.back}
				</a>
			</li>
			{if $tplData.specRow.spec_id > 0}
				<li>
					<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=spec&act_get=select&spec_id={$tplData.specRow.spec_id}">
						<span class="glyphicon glyphicon-ok-sign"></span>
						{$lang.href.specSelect}
					</a>
				</li>
			{/if}
			<li>
				<a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=spec#form" target="_blank">
					<span class="glyphicon glyphicon-question-sign"></span>
					{$lang.href.help}
				</a>
			</li>
		</ul>
	</div>

	<form name="spec_form" id="spec_form">
		<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
		<input type="hidden" name="act_post" value="submit">
		<input type="hidden" name="spec_id" value="{$tplData.specRow.spec_id}">

		<div class="row">
			<div class="col-md-9">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="form-group">
							<div id="group_spec_name">
								<label for="spec_name" class="control-label">{$lang.label.specName}<span id="msg_spec_name">*</span></label>
								<input type="text" name="spec_name" id="spec_name" value="{$tplData.specRow.spec_name}" class="validate form-control">
							</div>
						</div>

						<label class="control-label">{$lang.label.specContent}</label>
						<div class="form-group">
							<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=attach&act_get=form&view=iframe" class="btn btn-success btn-sm" data-toggle="modal" data-target="#attach_modal">
								<span class="glyphicon glyphicon-picture"></span>
								{$lang.href.uploadList}
							</a>
						</div>
						<div class="form-group">
							<textarea name="spec_content" id="spec_content" class="tinymce text_bg">{$tplData.specRow.spec_content}</textarea>
						</div>

						<div class="form-group">
							<button type="button" class="go_submit btn btn-primary">{$lang.btn.submit}</button>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="well">
					{if $tplData.specRow.spec_id > 0}
						<div class="form-group">
							<label class="control-label">{$lang.label.id}</label>
							<p class="form-control-static">{$tplData.specRow.spec_id}</p>
						</div>
					{/if}

					<label class="control-label">{$lang.label.status}<span id="msg_spec_status">*</span></label>
					<div class="form-group">
						{foreach $status.spec as $key=>$value}
							<div class="radio_baigo">
								<label for="spec_status_{$key}">
									<input type="radio" name="spec_status" id="spec_status_{$key}" {if $tplData.specRow.spec_status == $key}checked{/if} value="{$key}" class="validate" group="spec_status">
									{$value}
								</label>
							</div>
						{/foreach}
					</div>
				</div>
			</div>
		</div>

	</form>

	<div class="modal fade" id="attach_modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content"></div>
		</div>
	</div>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_foot.tpl" cfg=$cfg}


	<script type="text/javascript">
	var opts_validator_form = {
		spec_name: {
			length: { min: 1, max: 300 },
			validate: { type: "str", format: "text", group: "group_spec_name" },
			msg: { id: "msg_spec_name", too_short: "{$alert.x180201}", too_long: "{$alert.x180202}" }
		},
		spec_content: {
			length: { min: 0, max: 3000 },
			validate: { type: "str", format: "text" },
			msg: { id: "msg_spec_content", too_long: "{$alert.x180203}" }
		},
		spec_status: {
			length: { min: 1, max: 0 },
			validate: { type: "radio" },
			msg: { id: "msg_spec_status", too_few: "{$alert.x180205}" }
		}
	};
	var opts_submit_form = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=spec",
		text_submitting: "{$lang.label.submitting}",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	$(document).ready(function(){
		$("#attach_modal").on("hidden.bs.modal", function() {
		    $(this).removeData("bs.modal");
		});

		var obj_validate_form = $("#spec_form").baigoValidator(opts_validator_form);
		var obj_submit_form = $("#spec_form").baigoSubmit(opts_submit_form);
		$(".go_submit").click(function(){
			tinyMCE.triggerSave();
			if (obj_validate_form.validateSubmit()) {
				obj_submit_form.formSubmit();
			}
		});
		$("#spec_form").baigoCheckall();
	});
	</script>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}

