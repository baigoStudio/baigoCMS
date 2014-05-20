{* install_dbconfig.tpl 登录界面 *}

{include "include/install_head.tpl" cfg=$cfg}

	<div class="page_head">
		{$lang.page.installStep}
		&raquo;
		{$lang.page.installDb}
	</div>

	<div class="page_body">
		<form name="instal_form_dbconfig" id="instal_form_dbconfig">
			<input type="hidden" name="act_post" value="dbconfig">
			<ul>
				<li class="title">{$lang.label.dbHost}<span id="msg_db_host">*</span></li>
				<li class="field"><input type="text" name="db_host" id="db_host" class="validate" value="{if $smarty.const.BG_DB_HOST}{$smarty.const.BG_DB_HOST}{else}localhost{/if}" /></li>
				<li class="title">{$lang.label.dbName}<span id="msg_db_name">*</span></li>
				<li class="field"><input type="text" name="db_name" id="db_name" class="validate" value="{if $smarty.const.BG_DB_NAME}{$smarty.const.BG_DB_NAME}{else}sso{/if}" /></li>
				<li class="title">{$lang.label.dbUser}<span id="msg_db_user">*</span></li>
				<li class="field"><input type="text" name="db_user" id="db_user" class="validate" value="{if $smarty.const.BG_DB_USER}{$smarty.const.BG_DB_USER}{else}sso{/if}" /></li>
				<li class="title">{$lang.label.dbPass}<span id="msg_db_pass">*</span></li>
				<li class="field"><input type="text" name="db_pass" id="db_pass" class="validate" value="{if $smarty.const.BG_DB_PASS}{$smarty.const.BG_DB_PASS}{/if}" /></li>
				<li class="title">{$lang.label.dbCharset}<span id="msg_db_charset">*</span></li>
				<li class="field"><input type="text" name="db_charset" id="db_charset" class="validate" value="{if $smarty.const.BG_DB_CHARSET}{$smarty.const.BG_DB_CHARSET}{else}utf8{/if}" /></li>
				<li class="title">{$lang.label.dbTable}<span id="msg_db_table"></span></li>
				<li class="field"><input type="text" name="db_table" id="db_table" class="validate" value="{if $smarty.const.BG_DB_TABLE}{$smarty.const.BG_DB_TABLE}{else}sso_{/if}" /></li>

				<li class="line_dashed"> </li>

				<li>
					<button type="button" id="go_skip" class="float_left">{$lang.btn.skip}</button>
					<button type="button" id="go_next" class="float_right">{$lang.btn.submit}</button>
				</li>
			<ul>
		</form>
	</div>

{include "include/install_foot.tpl" cfg=$cfg}

	<script type="text/javascript">
	var opts_validator_form = {
		db_host: {
			length: { min: 1, max: 0 },
			validate: { type: "str", format: "text" },
			msg: { id: "msg_db_host", too_short: "{$alert.x030204}" }
		},
		db_name: {
			length: { min: 1, max: 0 },
			validate: { type: "str", format: "text" },
			msg: { id: "msg_db_name", too_short: "{$alert.x030205}" }
		},
		db_user: {
			length: { min: 1, max: 0 },
			validate: { type: "str", format: "text" },
			msg: { id: "msg_db_user", too_short: "{$alert.x030206}" }
		},
		db_pass: {
			length: { min: 1, max: 0 },
			validate: { type: "str", format: "text" },
			msg: { id: "msg_db_pass", too_short: "{$alert.x030207}" }
		},
		db_charset: {
			length: { min: 1, max: 0 },
			validate: { type: "str", format: "text" },
			msg: { id: "msg_db_charset", too_short: "{$alert.x030208}" }
		},
		db_table: {
			length: { min: 1, max: 0 },
			validate: { type: "str", format: "text" },
			msg: { id: "msg_db_table", too_short: "{$alert.x030209}" }
		},
		db_debug: {
			length: { min: 1, max: 0 },
			validate: { type: "radio" },
			msg: { id: "msg_db_debug", too_few: "{$alert.x030210}" }
		}
	};
	var opts_submit_form = { ajax_url: "{$smarty.const.BG_URL_INSATLL}ajax.php?mod=install", btn_text: "{$lang.btn.installNext}", btn_url: "{$smarty.const.BG_URL_INSATLL}install.php?mod=install&act_get=dbtable" };

	$(document).ready(function(){
		var obj_validator_form = $("#instal_form_dbconfig").baigoValidator(opts_validator_form);
		var obj_submit_form = $("#instal_form_dbconfig").baigoSubmit(opts_submit_form);
		$("#go_skip").click(function(){
			window.location.href = "{$smarty.const.BG_URL_INSTALL}install.php?mod=install&act_get=dbtable";
		});
		$("#go_next").click(function(){
			if (obj_validator_form.validateSubmit()) {
				obj_submit_form.formSubmit();
			}
		});
	})
	</script>

</html>