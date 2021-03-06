/**
 * Show the element with "class-name" which equals to the specified obj's "name" and hide its sibings.
 * Also change activeness of the specified obj.
 * @param {Object} obj - object of the switch-button into whose mode you want to be switched
 */
function SwitchVisibility(obj) {
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
 * POST textarea content (multiple lyrics) with line-separated text.
 * @param {String} textareaId - id of the import textarea
 * @param {String} path - url path to POST
 * @param {String} message - message of confirm dialog
 */
function SaveImportLyrics(textareaId, path, message) {
    if (!confirm(message)) {
        return false;
    }
    $.ajax({
        type: 'POST',
        url: path,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { 'data': $('#' + textareaId).val() },
        async: true
    }).done(function(content){
        location.href = content['url'];
    });
}

/**
 * GET textarea content (multiple lyrics) with line-separated text.
 * @param {String} textareaId - id of the export textarea
 * @param {String} path - url path to GET
 * @param {Boolean} isStrict - one of field to GET
 */
function LoadExportLyrics(textareaId, path, isStrict=true) {
    $.ajax({
        type: 'GET',
        url: path,
        data: {'strict': isStrict},
        cache: false,
        async: true
    }).done(function(content){
        $('#' + textareaId).val(content);
    });
}
