<?php 
/*
Plugin Name: DX-auto-publish
Plugin URI: http://www.daxiawp.com/dx-auto-publish.html
Description: Automatic timing post. 自动定时发布文章。
Version: 1.0
Author: 大侠wp
Author URI: http://www.daxiawp.com/dx-auto-publish.html
Copyright: daxiawp开发的原创插件，任何个人或团体不可擅自更改版权。
*/

class DX_Auto_Publish{

	function __construct(){		
		
		add_action( 'admin_menu',array($this,'menu_page') );		//menu page
		add_filter( 'cron_schedules',array($this,'publish_schedules') );		//schedules
		add_action( 'DXAP_cron_draft_update_hook',array($this,'DXAP_cron_draft_update') );		//publish draft		
		add_action( 'DX_auto_publish_form_bottom', array( $this,'form_bottom' ) );		//form bottom action	
		
	}

	//add menu page
	function menu_page(){
		add_menu_page( 'DX-auto-publish','自动定时发布','manage_options','DX-auto-publish',array($this,'cron_form'),plugins_url('icon.png',__FILE__) );
	}
	function cron_form(){
		include_once('form.php');
	}

	//add draft cron schedlue
	function publish_schedules($schedules){
		$schedules['DXAP-draft'] = array(
			'interval' => get_option('DXAP_draft_time'),
			'display' => '定时发布草稿文章'
		);
		return $schedules;	
	}	

	//dron draft to publish
	function DXAP_cron_draft_update(){
		query_posts(array('posts_per_page'=>1,'orderby'=>get_option('DXAP_draf_orderby'),'post_status'=>'draft','post_type'=>'post','order'=>'ASC'));
		while(have_posts()){
			the_post();
			wp_update_post(array('ID'=>get_the_ID(),'post_status'=>'publish'));
		}
		wp_reset_query();
	}
	
	//form bottom action
	function form_bottom(){
	?>
	
	<p>插件介绍：<a href="http://www.daxiawp.com/dx-auto-publish.html" target="_blank">http://www.daxiawp.com/dx-auto-publish.html</a></p>
	<p>wordpress主题请访问<a href="http://www.daxiawp.com" target="_blank">daxiawp</a>，大量大侠wp制作的主题供选择。wordpress定制、仿站、插件开发请联系：<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=1683134075&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:1683134075:44" alt="点击这里给我发消息" title="点击这里给我发消息">1683134075</a></p>
	
	<?
	}		

}

date_default_timezone_set( get_option('timezone_string') );
new DX_Auto_Publish();
if( !function_exists('_daxiawp_theme_menu_page') ) include_once( 'theme.php' );