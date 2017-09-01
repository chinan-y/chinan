<div class="table-list" style="width:500px;max-height:400px;overflow:auto;margin-bottom:10px;">
    <table width="100%">
    <thead>
    <tr>
        <th width="120" align="left"><?php echo fc_lang('名称'); ?></th>
        <th width="100" align="left"><?php echo fc_lang('类别'); ?></th>
        <th align="left"></th>
    </tr>
    </thead>
    <tbody>
    <?php if (is_array($table['field'])) { $count=count($table['field']);foreach ($table['field'] as $t) { ?>
    <tr>
        <td align="left"><?php echo $t['name']; ?></td>
        <td align="left"><?php echo str_replace('unsigned', '', $t['type']); ?></td>
        <td align="left"><?php echo $t['note']; ?></td>
    </tr>
    <?php } } ?>
    </tbody>
    </table>
</div>
<script type="text/javascript">
$(function() {
	$(".table-list tr").last().addClass("dr_border_none");

}); 
</script>