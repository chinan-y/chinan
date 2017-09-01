<?php if ($fn_include = $this->_include("nheader.html")) include($fn_include); ?>
<script type="text/javascript">
function _dr_confirm_set_all(title, del) {
	art.dialog.confirm(title, function(){
		dr_tips("<?php echo fc_lang('正在执行中...'); ?>", 999999, 2);
		var _data = $("#myform").serialize();
		var _url = window.location.href;
		if ((_data.split('ids')).length-1 <= 0) {
			dr_tips(lang['select_null'], 2);
			return true;
		}
		// 将表单数据ajax提交验证
		$.ajax({type: "POST",dataType:"json", url: _url, data: _data,
			success: function(data) {
				//验证成功
				if (data.status == 1) {
					dr_tips(data.code, 3, 1);
					if (del == 1) {
						$(".dr_select").each(function(){ 
							if ($(this).prop('checked')) {
								$("#dr_row_"+$(this).val()).remove();
							} 
						});
					} else {
						setTimeout('window.location.reload(true)', 3000); // 刷新页
					}
				} else {
					dr_tips(data.code, 3, 2);
					return true;
				}
			},
			error: function(HttpRequest, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + HttpRequest.statusText + "\r\n" + HttpRequest.responseText);
			}
		});
		return true;
	});
	return false;
}
</script>
<div class="page-bar">
	<ul class="page-breadcrumb mylink">
		<?php echo $menu['link']; ?>

	</ul>
	<ul class="page-breadcrumb myname">
		<?php echo $menu['name']; ?>
	</ul>
	<div class="page-toolbar">
		<div class="btn-group pull-right">
			<button type="button" class="btn green btn-sm btn-outline dropdown-toggle" data-toggle="dropdown" aria-expanded="false" data-hover="dropdown"> <?php echo fc_lang('操作菜单'); ?>
				<i class="fa fa-angle-down"></i>
			</button>
			<ul class="dropdown-menu pull-right" role="menu">
				<?php if (is_array($menu['quick'])) { $count=count($menu['quick']);foreach ($menu['quick'] as $t) { ?>
				<li>
					<a href="<?php echo $t['url']; ?>"><?php echo $t['icon'];  echo $t['name']; ?></a>
				</li>
				<?php } } ?>
				<li class="divider"> </li>
				<li>
					<a href="javascript:window.location.reload();">
						<i class="icon-refresh"></i> <?php echo fc_lang('刷新页面'); ?></a>
				</li>
			</ul>
		</div>
	</div>
</div>
<h3 class="page-title">
	<small><?php echo fc_lang('联动菜单可以作为地区菜单、类型菜单等等，也可以按站点来设置联动菜单值'); ?></small>
</h3>

<form action="" method="post" name="myform" id="myform">
	<input name="action" id="action" type="hidden" value="order" />
<div class="portlet mylistbody">
	<div class="portlet-body">
		<div class="table-scrollable">

			<table class="mytable table table-striped table-bordered table-hover table-checkable dataTable">

		<thead>
        <tr>
            <th width="20"></th>
            <th width="30"><?php echo fc_lang('排序'); ?></th>
            <th width="200"><?php echo fc_lang('别名'); ?></th>
            <th width="250"><?php echo fc_lang('名称'); ?></th>
            <th width="90" style="text-align: center"><?php echo fc_lang('前端隐藏'); ?></th>
            <th><?php if ($this->ci->is_auth(APP_DIR.'/admin/linkage/adds')) { ?><a class="add" title="<?php echo fc_lang('添加子菜单'); ?>" href='javascript:dr_dialog("<?php echo dr_url(APP_DIR.'/linkage/adds', array('key'=>$key)); ?>&pid=<?php echo $pid; ?>", "add");'></a><?php } ?></th>
        </tr>
        </thead>
            <tbody>
            <?php if (is_array($list)) { $count=count($list);foreach ($list as $t) { ?>
            <tr>
                <td><input name='ids[]' type='checkbox' class='dr_select toggle md-check' value='<?php echo $t['id']; ?>' /></td>
                <td><input class='input-text displayorder' type='text' name='data[<?php echo $t['id']; ?>][displayorder]' value='<?php echo $t['displayorder']; ?>' /></td>
                <td><?php echo $t['cname']; ?></td>
                <?php if ($this->ci->is_auth(APP_DIR.'/admin/linkage/edits')) { ?>
                <td><a href='javascript:dr_dialog("<?php echo dr_url(APP_DIR.'/linkage/edits', array('key'=>$key)); ?>&id=<?php echo $t['id']; ?>", "edit");'><?php echo $t['name']; ?></a></td>
                <?php } else { ?>
                <td><?php echo $t['name']; ?></td>
                <?php } ?>
				<td style="text-align: center">
					<a href="<?php echo dr_url('linkage/hidden', array('id' => $t['id'], 'key' => $key)); ?>"><img src="<?php echo THEME_PATH; ?>admin/images/<?php if ($t['hidden']) { ?>1<?php } else { ?>0<?php } ?>.gif"></a></td>
                <td class="dr_option">
                    <?php if ($t['child']) { ?><a class="alist" href="<?php echo dr_url(APP_DIR.'/linkage/data', array('key'=>$key, 'pid'=>$t['id'])); ?>"> <i class="fa fa-navicon"></i> <?php echo fc_lang('子菜单管理'); ?></a>&nbsp;&nbsp;&nbsp;<?php }  if ($this->ci->is_auth(APP_DIR.'/admin/linkage/edits')) { ?><a class="aedit" href='javascript:dr_dialog("<?php echo dr_url(APP_DIR.'/linkage/edits', array('key'=>$key)); ?>&id=<?php echo $t['id']; ?>", "edit");'> <i class="fa fa-edit"></i> <?php echo fc_lang('修改'); ?></a>&nbsp;&nbsp;&nbsp;<?php } ?>
                </td>
            </tr>
            <?php } } ?>
			<tr class="mtable_bottom">
			<th><input name="dr_select" class="toggle md-check" type="checkbox" onClick="dr_selected()" /></th>
			<td colspan="8">
            <?php if ($this->ci->is_auth('linkage/del')) { ?>
				<label><button type="button" class="btn red btn-sm" name="option" onClick="$('#action').val('del');return _dr_confirm_set_all('<?php echo fc_lang('您确定要这样操作吗？'); ?>');"><i class="fa fa-trash"></i> <?php echo fc_lang('删除'); ?></button></label>

			<?php }  if ($this->ci->is_auth('linkage/edits')) { ?>
				<label><button type="button" class="btn green btn-sm" name="option" onClick="$('#action').val('move');return _dr_confirm_set_all('<?php echo fc_lang('您确定要这样操作吗？'); ?>');"><i class="fa fa-edit"></i> <?php echo fc_lang('移动至'); ?></button></label>
				<label><?php echo $select; ?></label>
				<?php }  if ($this->ci->is_auth('linkage/edits')) { ?>

				<label><button type="button" class="btn green btn-sm" name="option" onClick="$('#action').val('order');return _dr_confirm_set_all('<?php echo fc_lang('您确定要这样操作吗？'); ?>');"><i class="fa fa-edit"></i> <?php echo fc_lang('排序'); ?></button></label>
				<div class="onShow"><?php echo fc_lang('排序按从小到大排列，最大支持99'); ?></div>
				<?php } ?>
			</td>
		</tr>
		</tbody>
		</table>
		</div>
	</div>
</div>
</form>
<?php if ($fn_include = $this->_include("footer.html")) include($fn_include); ?>