<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

class JAK_hooks
{
	private $data = array();
	private $case = array();
	private $hooks = array();
	private $sqlwhere = '';
	
	function __construct($active) {
		/*
		/	The constructor
		*/
		
		$sqlwhere = '';
		if ($active == 1) $sqlwhere = ' WHERE active = 1 ';
		
		$jakhooks = array();
		global $jakdb;
		$result = $jakdb->query('SELECT * FROM '.DB_PREFIX.'pluginhooks'.$sqlwhere.' ORDER BY exorder ASC');
		while ($row = $result->fetch_assoc()) {
		    	$jakhooks[] = $row;
		}
		
		$this->data = $jakhooks;
	}
	
	function jakGetarray()
	{
		// Setting up an alias, so we don't have to write $this->data every time:
		$d = $this->data;
		
		return $d;
		
	}
	
	function jakGethook($hook)
	{
		// Setting up an alias, so we don't have to write $this->data every time:
		$d = $this->data;
		
		foreach($d as $c)
		{
			if ($c['hook_name'] == $hook) {
				$case[] = array('phpcode' => $c['phpcode'], 'id' => $c['id']);
				
			}
		}
		
		if (!empty($case)) return $case;
	}
	
	public static function jakAllhooks()
	{
		$hooks = array('php_search', 'php_tags', 'php_sitemap', 'php_index_top', 'php_index_page', 'php_index_bottom', 'php_rss', 'php_lang', 'php_pages_news', 'php_admin_usergroup', 'php_admin_user_rename', 'php_admin_user_delete', 'php_admin_user_delete_mass', 'php_admin_lang', 'php_admin_setting', 'php_admin_setting_post', 'php_admin_user', 'php_admin_user_edit', 'php_admin_index', 'php_admin_index_top', 'php_admin_fulltext_add', 'php_admin_fulltext_remove', 'php_admin_pages_sql', 'php_admin_news_sql', 'php_admin_pages_news_info', 'php_admin_widgets_sql', 'tpl_body_top', 'tpl_between_head', 'tpl_header', 'tpl_below_header', 'tpl_sidebar', 'tpl_page', 'tpl_below_content', 'tpl_news', 'tpl_footer', 'tpl_footer_widgets', 'tpl_footer_end', 'tpl_tags', 'tpl_sitemap', 'tpl_search', 'tpl_page_news_grid', 'tpl_admin_usergroup_edit', 'tpl_admin_usergroup', 'tpl_admin_setting', 'tpl_admin_head', 'tpl_admin_footer', 'tpl_admin_page_news', 'tpl_admin_page_news_new', 'tpl_admin_user', 'tpl_admin_user_edit', 'tpl_admin_index');
		
		return $hooks;
	}

}
?>