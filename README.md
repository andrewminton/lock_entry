Lock Entry
==========

Locking of Entry Editing if the entry is being edited by another user

Initial code provided by Nick Dunn. Thought I'd take a stab at seeing if I could get to to work.

##How to use it?

Install `lock_entry` into your extensions folder and enable it.

When more than one user attempt to access the same entry for editing, the second user to the page will be issued with a notification that the entry is locked and all editable fields will be disabled until the lock period has timeout or the user completes his changes and exits the entry editor.