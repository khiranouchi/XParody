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

/**
 * Switch normal-text(eg. <...>aaa</...>) and input-mode(eg. <...><input type="text" value="aaa"></...>).
 * Also send http request to PATCH modification of text.
 * Empty input is arrowed when arrowEmpty is true.
 * @param {Object} obj - object of the tag whose content you want to be switched
 * @param {String} path - url path to PATCH modification
 * @param {String} fieldName - field name to PATCH modification
 * @param {Boolean} arrowEmpty - if empty input is arrowed or not
 */
function SwitchInputMode(obj, path, fieldName, arrowEmpty=true){
    if(!$(obj).hasClass('input_mode_on')){
        $(obj).addClass('input_mode_on');
        $(obj).html('<input type="text" '
                    + 'value="'+$(obj).text()+'">'); // use current text as default value
        $($(obj)[0].nodeName + '> input').focus().blur(
            // listener which activates when the focus is lost
            function(){
                var inputVal = $(this).val();
                // if arrowEmpty==true OR inputted value is not empty
                if(arrowEmpty || inputVal){
                    // update text in html
                    $(obj).removeClass('input_mode_on').text(inputVal);
                    // update data in database
                    var data = {};
                    data[fieldName] = inputVal;
                    $.ajax({
                        type: 'PATCH',
                        url: path,
                        data: data,
                        async: true
                    });
                // if arrowEmpty==false AND inputted value is empty
                }else{
                    // reset default value
                    $(obj).removeClass('input_mode_on').text(this.defaultValue);
                }
            }
        )
    }
}
