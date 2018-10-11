/**
 * Switch Mode: Show the element with class-name which equals to the specified obj's name and hide its sibings.
 * Also change activeness of the specified obj.
 * @param {Object} obj - object of the switch-button into whose mode you want to be switched
 */
function SwitchMode(obj) {
    var activeId = $(obj).attr('id');
    var activeClass = $(obj).attr('name');
    // change active button
    $('#' + activeId).siblings().removeClass('active');
    $('#' + activeId).addClass('active');
    // change visible textarea and submit/copy button
    $('.' + activeClass).siblings().hide();
    $('.' + activeClass).show();
}

/**
 * POST multiple old lyrics from imported comma-separated text.
 * @param {String} textareaId - id of the import textarea
 * @param {String} path - url path to POST
 */
function SaveImportLyricsOld(textareaId, path) {
    var message = "Really import? (Existing all lyrics are deleted)";
    if (!confirm(message)) {
        return false;
    }
    $.ajax({
        type: 'POST',
        url: path,
        data: { 'data': $('#' + textareaId).val() },
        async: true
    }).done(function(content){
        location.href = content['url'];
    });
}