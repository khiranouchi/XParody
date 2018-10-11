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
