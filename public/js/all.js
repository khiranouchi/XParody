/**
 * Show check dialog.
 * Prevent default if not confirmed. 
 * @param {Object} e - event object
 */
function ShowCheckDialog(e, message="Do you really submit?") {
    if (!confirm(message)) {
        e.preventDefault();
    }
}
