/**
 * Switch visibility of table row.
 * Not support multiple reason(by what rows are filtered).
 * @param {Boolean} isSwitchOn - true: make visible / false: make invisible
 * @param {String} targetRowClass - class of row(tr) which you want to switch visibility
 * @param {String} path - url path to POST (for cookie)
 * @param {String} targetRowKey - key of row (for cookie)
 */
function FilterVisibleRow(isSwitchOn, targetRowClass, path, targetRowKey){
    var data = {};
    if(isSwitchOn){
        $('.' + targetRowClass).css('display', 'table-row');
        data[targetRowKey] = 1;
    }else{
        $('.' + targetRowClass).css('display', 'none');
        data[targetRowKey] = 0;
    }
    // save visibility state of target row in cookie
    if(path){
        $.ajax({
            type: 'POST',
            url: path,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: data,
            async: true
        });
    }
}
