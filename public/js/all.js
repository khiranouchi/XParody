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
        $($(obj)[0].nodeName + '> input').focus().select().blur(
            // listener which activates when the focus is lost
            function(){
                var inputVal = $(this).val();
                var defaultVal = this.defaultValue;
                // if arrowEmpty==true OR inputted value is not empty
                if(arrowEmpty || inputVal){
                    // update data in database
                    var data = {};
                    data[fieldName] = inputVal;
                    $.ajax({
                        type: 'PATCH',
                        url: path,
                        headers: { Accept: "application/json" },
                        data: data,
                        async: true
                    }).done(function(){
                        // update text in html
                        $(obj).removeClass('input_mode_on').text(inputVal);
                    }).fail(function(){
                        // reset default value
                        $(obj).removeClass('input_mode_on').text(defaultVal);
                    });
                // if arrowEmpty==false AND inputted value is empty
                }else{
                    // reset default value
                    $(obj).removeClass('input_mode_on').text(defaultVal);
                }
            }
        )
    }
}

/**
 * Switch normal-text(eg. <...>aaa</...>) and select-mode(eg. <...><select><option...></select></...>).
 * Also send http request to PATCH modification of text.
 * @param {Object} obj - object of the tag whose content you want to be switched
 * @param {String} path - url path to PATCH modification
 * @param {String} fieldName - field name to PATCH modification
 * @param {String} options - options of select with comma separated string (eg. '1,2,3,4,5')
 */
function SwitchSelectMode(obj, path, fieldName, options) {
    if(!$(obj).hasClass('input_mode_on')){
        $(obj).addClass('input_mode_on');
        var defaultVal = $(obj).text();
        var optionArray = options.split(',');
        var content = '<select>';
        for(var i in optionArray){
            if(optionArray[i] == $(obj).text()){ // use current text as default selection
                content += '<option selected>' + optionArray[i] + '</option>';
            }else{
                content += '<option>' + optionArray[i] + '</option>';
            }
        }
        content += '</select>';
        $(obj).html(content);
        $($(obj)[0].nodeName + '> select').focus().blur(
            // listener which activates when the focus is lost
            function(){
                var inputVal = $(this).val();
                // update data in database
                var data = {};
                data[fieldName] = inputVal;
                $.ajax({
                    type: 'PATCH',
                    url: path,
                    headers: { Accept: "application/json" },
                    data: data,
                    async: true
                }).done(function(){
                    // update text in html
                    $(obj).removeClass('input_mode_on').text(inputVal);
                }).fail(function(){
                    // reset default value
                    $(obj).removeClass('input_mode_on').text(defaultVal);
                });
            }
        )
    }
}
