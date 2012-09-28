<?php 
if($_POST['update_draft']){
	update_option('DXAP_draft_time',$_POST['draft_to_publish']);
	update_option('DXAP_draf_orderby',$_POST['orderby']);
	wp_schedule_event( time(),'DXAP-draft','DXAP_cron_draft_update_hook' );
}
if($_POST['delete_draft']){
	wp_clear_scheduled_hook( 'DXAP_cron_draft_update_hook' );
}
?>

<style type="text/css">
#main{ width:700px; border:1px solid #ccc; background-color:#f9f9f9; padding:10px; margin-top:20px; }
.button-primary{margin-right:20px;}
</style>

<div class="wrap">

	<div id="icon-options-general" class="icon32"><br></div><h2>计划任务</h2>
	
	<div id="main">
	
		<h3>定时发布草稿文章</h3>
		<div id="draft">
		<form action="" method="post">
			<p><label for="draft_to_publish">每隔多少秒钟发布一篇：</label>
			<input type="text" id="draft_to_publish" name="draft_to_publish" value="<?php echo get_option('DXAP_draft_time'); ?>" /></p>
			<p><label for="orderby">发表顺序</label>
			<select name="orderby">
				<option value="rand" <?php selected( get_option('DXAP_draf_orderby'), 'rand' ); ?>>随机</option>
				<option value="ID" <?php selected( get_option('DXAP_draf_orderby'), 'ID' ); ?>>ID</option>
			</select>
			</p>
			<p><?php submit_button('更新计划','primary','update_draft',''); submit_button('取消计划','secondary','delete_draft','');?></p>
		</form>
		<?php if(wp_next_scheduled('DXAP_cron_draft_update_hook')):?><p style="color:red">下一个计划任务时间：<?php echo date('Y-m-d H:i:s',wp_next_scheduled('DXAP_cron_draft_update_hook'));?></p><?php else:?>
		<p style="color:gray;">计划任务已停止！</p>
		<?php endif;?>
		</div>
		
	</div>

</div>


<?php do_action( 'DX_auto_publish_form_bottom' ); ?>