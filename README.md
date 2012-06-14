Lock Entry
==========

Locking of Entry Editing if the entry is being edited by another user

Initial code provided by Nick Dunn. Thought I'd take a stab at seeing if I could get to to work.

##How to use it?

Install `lock_entry` into your extensions folder and enable it.

When more than one user attempt to access the same entry for editing, the second user to the page will be issued with a notification that the entry is locked and all editable fields will be disabled until the lock period has timeout or the user completes his changes and exits the entry editor.

Timeout is set to 20 seconds and the javascript has a looping setTimeout that triggers the lock every 10 seconds.

This may be placed into the config and editable via preferences in the future.