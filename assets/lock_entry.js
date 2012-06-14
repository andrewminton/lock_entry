var EntryLock;

(function($) {
	
	EntryLock = {
		
		locked_message: 'This entry is locked for editing by another user.',
		not_locked_message: 'This entry is no longer Locked Refresh the page to gain control of the Entry',
		entry_id: null,
		user_id: null,
		is_locked: false,
		lock_message: false,

		init: function() {
		
			this.entry_id = Symphony.Context.get('env').entry_id;

			if (this.is_locked) {
				this.lockEntryForm();
			} else if(this.is_locked == false && this.lock_message == true){
				this.lockEntryForm();
				alert('Both statements are true');
			} else{
			  this.lockEntry();
			}
		},
		
		lockEntryForm: function() {
		
			if(this.lock_message){
			this.appendNotice(this.not_locked_message);
			}else{
			this.appendNotice(this.locked_message);
			}
			$('#contents > form').find('input, select, textarea, button').attr('disabled', 'disabled');
			var self = this;
			var url = Symphony.Context.get('root') + '/symphony/extension/lock_entry/lock/';
			var data = 'lock=checkLocked&entry_id=' + this.entry_id;
			$.get(url, data, setTimeout(function() {self.init();}, 10000));
			
		},
		
		appendNotice: function(message) {
	
		var notice = $('div.notifier').css('display','');
		if(this.lock_message){
		var noticetext = $('<p id="locked" class="notice success active"></p>');}
		else{
		var noticetext = $('<p id="locked" class="error notice active"></p>');	
			}
		noticetext.text(message);
		noticetext.appendTo(notice);
		$('#locked').remove();
		noticetext.appendTo(notice);
			
		},
		
		lockEntry: function() {
		
			var self = this;
			var url = Symphony.Context.get('root') + '/symphony/extension/lock_entry/lock/';
			var data = 'lock=lockEntry&entry_id=' + this.entry_id;
			$.get(url, data, setTimeout(function() {self.lockEntry();}, 10000));
			
		},
		
		//updateLockTimer: function() {
		
		//Good reference to using setTimout instead of setInterval: http://javascript.info/tutorial/settimeout-setinterval
		//var self = this;
		// 
		//}
	}
		
})(jQuery.noConflict());

jQuery(document).ready(function() {
	EntryLock.init();
});