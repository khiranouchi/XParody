/**
 * Insert one empty box.
 * @param {Object} curId - id of the box AFTER which you want to insert box
 * @param {String} path - url path to POST
 * @param {String} songId - song_id which the box is in (for POST data)
 * @param {String} curBoxIdx - box_idx of the line (for POST data)
 * @param {Boolean} insertBefore - insert box BEFORE the specified box if true
 */
function InsertBox(curId, path, songId, curBoxIdx, insertBefore=false) {
    // insert data in database and get resource
    var box_idx;
    if (insertBefore) {
        box_idx = parseInt(curBoxIdx);
    } else {
        box_idx = parseInt(curBoxIdx) + 1;
    }
    $.ajax({
        type: 'POST',
        url: path,
        data: {
            'lyrics_old': '(new_box)',
            'song_id': songId,
            'box_idx': box_idx,
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
 * @param {String} boxId - box_id which the line is in (for POST data)
 * @param {String} curLineIdx - line_idx of the line (for POST data)
 */
function InsertBoxLine(curId, path, boxId, curLineIdx) {
    // insert data in database and get resource
    $.ajax({
        type: 'POST',
        url: path,
        data: {
            'lyrics_new': '(new_line)',
            'box_id': boxId,
            'line_idx': parseInt(curLineIdx) + 1,
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
