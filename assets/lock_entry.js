var EntryLock;

(function($) {
	
	EntryLock = {
		
		locked_message: 'This entry is locked for editing by another user.',
		
		entry_id: null,
		user_id: null,
		
		is_locked: false,
		
		init: function() {
			this.entry_id = window.location.href.match(/([0-9]+)\/$/)[1];
			//this.user_id = $('ul#usr li:eq(0) a').attr('href').match(/([0-9]+)\/$/)[1];
			
			if (this.is_locked) {
				this.lockEntryForm();
			} else {
				this.lockEntry();
			}
			//Not sure the Lock entry should trigger by default??
			this.lockEntry();
		},
		
		lockEntryForm: function() {
			this.appendNotice(this.locked_message);
			//$('body > form div.notifier').remove();
			//alert('This is working');
			$('#contents > form').find('input, select, textarea, button').attr('disabled', 'disabled');
		},
		
		appendNotice: function(message) {
			var notice = $('div.notifier').css('display','');
			var noticetext = $('<p class="error notice active"></p>')
			noticetext.appendTo(notice);
			noticetext.text(message);
		},
		
		lockEntry: function() {
			var self = this;
			var url = Symphony.Context.get('root') + '/symphony/extension/lock_entry/lock/';
			var data = 'lock=lockEntry&entry_id=' + this.entry_id;
			$.get(url, data, function(response){
				self.updateLockTimer();
			});
		},
		
		updateLockTimer: function() {
			var self = this;
			var timemout = setInterval(function() {
				self.lockEntry();
			}, 10000)
		}
	}
		
})(jQuery.noConflict());

jQuery(document).ready(function() {
	EntryLock.init();
});