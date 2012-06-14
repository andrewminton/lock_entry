<?php

	require_once(TOOLKIT . '/class.administrationpage.php');
	require_once(TOOLKIT . '/class.extensionmanager.php');
	require_once(TOOLKIT . '/class.sectionmanager.php');
	
	class ContentExtensionLock_EntryLock extends AdministrationPage {
		
		protected $_driver = null;
		
		public function __construct(){
			parent::__construct();
			$this->_uri = SYMPHONY_URL . '/extension/lock_entry';
			$this->_driver = Symphony::ExtensionManager()->create('lock_entry');
		
		}
		
		public function __viewIndex() {

		
		
			$timeout = 3580;
			$entry_id = $_GET['entry_id'];
			$user_id = Administration::instance()->Author->get(id);
		
			//$lock = Symphony::Database()->fetchRow(0, "SELECT * FROM tbl_entry_lock WHERE entry_id=$entry_id");
			//$getthetime = ((strtotime($lock['timestamp'])) - time());
			//$timeout = 20;
			//var_dump($getthetime, time(), $timeout);
		
		
			switch($_GET['lock']) {
				//check if entry has been locked
				case 'checkLocked':
				
					$lock = Symphony::Database()->fetchRow(0, "SELECT * FROM tbl_entry_lock WHERE entry_id=$entry_id");
					$locked = false;
					$lockmessage = false;
					
					// page has been locked by someone else
					if ($lock && $lock['user_id'] != $user_id) {
						
						// lock has expired, remove it for housekeeping
						if ((strtotime($lock['timestamp']) - time()) <= $timeout) {
							Symphony::Database()->query("DELETE FROM tbl_entry_lock WHERE entry_id=$entry_id");
						    $lockmessage = true;
						} else {
							$locked = true;
							$lockmessage = false;
							
						}
                         
					}
					
					header('content-type: text/javascript');
					echo 'EntryLock.is_locked = ' . (($locked) ? 'true' : 'false') . ';';
					echo 'EntryLock.lock_message = ' . (($lockmessage) ? 'true' : 'false') . ';';
					
					
				break;
				
				case 'lockEntry':
				//Need a means to check if the current user matches the locked user so that the table isn't overridden
					$lock = Symphony::Database()->fetchRow(0, "SELECT * FROM tbl_entry_lock WHERE entry_id=$entry_id");
					if ($lock)
					Symphony::Database()->query("DELETE FROM tbl_entry_lock WHERE entry_id=$entry_id");
					Symphony::Database()->query("INSERT INTO tbl_entry_lock (entry_id, user_id) VALUES ($entry_id, $user_id)");
					
					header('content-type: text/javascript');
					echo 'Entry Has been Locked';
				break;
			}
			
			exit;
			
		}
	}