{* install_1.tpl 登录界面 *}

{include "include/install_head.tpl" cfg=$cfg}

	<div class="page_head">
		{$lang.page.installStep}
		&raquo;
		{$lang.page.installTable}
	</div>

	<div class="page_body">
		<form name="instal_form_dbtable" id="instal_form_dbtable">
			<input type="hidden" name="act_post" value="dbtable">
			<ul>
				<li>{$lang.label.installTable}</li>
				<li class="line_dashed"> </li>
				<li>
					<button type="button" id="go_pre" class="float_left">{$lang.btn.installPre}</button>
					<button type="button" id="go_skip" class="float_left">{$lang.btn.skip}</button>
					<button type="button" id="go_next" class="float_right">{$lang.btn.submit}</button>
				</li>
			<ul>
		</form>
	</div>

{include "include/install_foot.tpl" cfg=$cfg}

	<script type="text/javascript">
	var opts_submit_form = { ajax_url: "{$smarty.const.BG_URL_INSATLL}ajax.php?mod=install", btn_text: "{$lang.btn.installNext}", btn_url: "{$smarty.const.BG_URL_INSATLL}install.php?mod=install&act_get=base" };

	$(document).ready(function(){
		var obj_submit_form = $("#instal_form_dbtable").baigoSubmit(opts_submit_form);
		$("#go_pre").click(function(){
			window.location.href = "{$smarty.const.BG_URL_INSATLL}install.php";
		});
		$("#go_skip").click(function(){
			window.location.href = "{$smarty.const.BG_URL_INSTALL}install.php?mod=install&act_get=base";
		});
		$("#go_next").click(function(){
			obj_submit_form.formSubmit();
		});
	})
	</script>

</html>