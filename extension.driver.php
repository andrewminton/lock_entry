<?php
	
	require_once(TOOLKIT . '/class.sectionmanager.php');
	
	class Extension_Lock_Entry extends Extension {
		
		public function getSubscribedDelegates() {
			return array(
				array(
					'page' => '/backend/',
					'delegate' => 'InitaliseAdminPageHead',
					'callback' => 'initaliseAdminPageHead'
				)
			);
		}
		
		public function initaliseAdminPageHead($context) {
	    
			require_once(TOOLKIT . '/class.sectionmanager.php');
		
			$page = Administration::instance()->Page;
			$pageContext = $page->getContext();
			$entryID = $pageContext['entry_id'];
			
			if ($page instanceof ContentPublish and ($pageContext['page'] == 'edit')) {
				$page->addScriptToHead(URL . '/extensions/lock_entry/assets/lock_entry.js', 300000);
			    $page->addScriptToHead(SYMPHONY_URL . '/extension/lock_entry/lock/?lock=checkLocked&entry_id='.$entryID, 300001);
			}
		}
		
		public function uninstall(){
			return Symphony::Database()->query("DROP TABLE `tbl_entry_lock`");
		}


		public function install(){
			return Symphony::Database()->query("CREATE TABLE `tbl_entry_lock` (
			  `entry_id` int(11) NOT NULL,
			  `user_id` int(11) default NULL,
			  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
		}
}