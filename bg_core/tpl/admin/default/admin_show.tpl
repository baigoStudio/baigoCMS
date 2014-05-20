{* admin_form.tpl 管理员编辑界面 *}
{* 栏目显示函数（递归） *}
{function cate_list arr=""}
	{foreach $arr as $value}
		<li class="title">
			{if $value.cate_level > 0}
				{for $_i=1 to $value.cate_level}
					&#160;&#160;&#160;&#160;&#160;&#160;
				{/for}
			{/if}
			{$value.cate_name}
		</li>

		<li class="field">
			{if $value.cate_level > 0}
				{for $_i=1 to $value.cate_level}
					&#160;&#160;&#160;&#160;&#160;&#160;
				{/for}
			{/if}

			{foreach $lang.allow as $key_s=>$value_s}
				<img src="{$smarty.const.BG_URL_IMAGE}allow_{if $tplData.adminRow.admin_allow_cate[$value.cate_id][$key_s] == 1 || $tplData.adminRow.groupRow.group_allow.article[$key_s] == 1}y{else}x{/if}.png" />
				<label for="cate_{$value.cate_id}_{$key_s}">{$value_s}</label>
			{/foreach}
		</li>

		{if $value.cate_childs}
			{cate_list arr=$value.cate_childs}
		{/if}

	{/foreach}
{/function}

{$cfg = [
	title          => "{$adminMod.admin.main.title} - {$lang.page.show}",
	css            => "admin_form",
	menu_active    => "admin",
	sub_active     => "list"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<form class="tform">

		<div>
			<ol>
				<li class="title_b">
					{$lang.label.id}: {$tplData.adminRow.admin_id}
				</li>

				<li class="line_dashed"> </li>

				<li class="title">{$lang.label.status}</li>
				<li>
					<img src="{$smarty.const.BG_URL_IMAGE}allow_{if $tplData.adminRow.admin_status == "enable"}y{else}x{/if}.png" />
					<label>{$status.admin[$tplData.adminRow.admin_status]}</label>
				</li>

				<li class="line_dashed"> </li>

				<li class="title">{$lang.label.adminGroup}</li>
				<li>
					{if $tplData.groupRow.group_name}
						{$tplData.groupRow.group_name}
						&#160;|&#160;
						<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=group&act_get=show&group_id={$tplData.groupRow.group_id}">{$lang.href.show}</a>
					{else}
						{$lang.label.none}
					{/if}
				</li>

				<li class="line_dashed"> </li>

				<li class="title_b">
					<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=admin&act_get=form&admin_id={$tplData.adminRow.admin_id}">{$lang.href.edit}</a>
				</li>
			</ol>

			<ul>
				<li class="title">{$lang.label.username}</li>
				<li class="title_b">{$tplData.adminRow.admin_name}</li>

				<li class="title">{$lang.label.mail}</li>
				<li class="title_b">{$tplData.adminRow.userRow.user_mail}</li>

				<li class="title">{$lang.label.note}</li>
				<li class="title_b">{$tplData.adminRow.admin_note}</li>

				<li class="title">{$lang.label.cateAllow}</li>
				<li>
					<ol>
						{cate_list arr=$tplData.cateRows}
					</ol>
				</li>

				<li class="title_b">
					<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=admin&act_get=form&admin_id={$tplData.adminRow.admin_id}">{$lang.href.edit}</a>
				</li>
			</ul>

		</div>

	</form>

{include "include/admin_foot.tpl" cfg=$cfg}
{include "include/html_foot.tpl" cfg=$cfg}
