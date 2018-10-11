/**
 * Insert one empty box-line. 
 * @param {Object} curId - id of the line after which you want to insert line
 * @param {String} path - url path to POST
 * @param {String} boxId - box_id which the line is in (for POST data)
 * @param {String} curLineIdx - line_idx of the line (for POST data)
 */
function InsertBoxLine(curId, path, boxId, curLineIdx) {
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
        $(content).insertAfter('#' + curId);
    });
}
