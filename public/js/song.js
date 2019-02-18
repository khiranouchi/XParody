/**
 * Insert one empty box.
 * @param {Object} curId - id of the box AFTER which you want to insert box
 * @param {String} path - url path to POST
 * @param {String} curBoxId - box_id of the line (for POST data)
 * @param {Boolean} insertBefore - insert box BEFORE the specified box if true
 */
function InsertBox(curId, path, curBoxId, insertBefore=false) {
    // insert data in database and get resource
    $.ajax({
        type: 'POST',
        url: path,
        data: {
            'lyrics_old': '------',
            'box_id': curBoxId,
            'insert_before': insertBefore,
        },
        async: true
    }).done(function(content){
        // insert box-line in html
        if (insertBefore) {
            $(content).insertBefore('#' + curId);
        } else {
            $(content).insertAfter('#' + curId);
        }
    });
}

/**
 * Delete one box.
 * @param {Object} obj - child object of the box which you want to delete
 * @param {String} path - url path to DELETE
 */
function DeleteBox(obj, path) {
    var message = "Really delete this base lyrics? (All parody lyrics will be deleted)";
    if (!confirm(message)) {
        return false;
    }
    // delete data in database
    $.ajax({
        type: 'DELETE',
        url: path,
        async: true
    }).done(function(){
        // delete box-line in html
        $(obj).closest('.x-lyrics-box').remove();
    });
}

/**
 * Insert one empty box-line. 
 * @param {Object} curId - id of the line after which you want to insert line
 * @param {String} path - url path to POST
 * @param {String} curLineId - line_id of the line (for POST data) (if -1, create first(idx==0) line of the box)
 */
function InsertBoxLine(curId, path, curLineId) {
    // insert data in database and get resource
    $.ajax({
        type: 'POST',
        url: path,
        data: {
            'line_id': curLineId,
            'insert_before': false,
        },
        async: true
    }).done(function(content){
        // insert box-line in html
        $(content).insertAfter('#' + curId);
    });
}

/**
 * Delete one box-line.
 * @param {Object} obj - child object of the line which you want to delete
 * @param {String} path - url path to DELETE
 */
function DeleteBoxLine(obj, path) {
    var message = "Really delete this lyrics?";
    if (!confirm(message)) {
        return false;
    }
    // delete data in database
    $.ajax({
        type: 'DELETE',
        url: path,
        async: true
    }).done(function(){
        // delete box-line in html
        $(obj).closest('.x-lyrics-new').remove();
    });
}
