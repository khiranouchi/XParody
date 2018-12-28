/**
 * Switch visibility of table row.
 * Not support multiple reason(by what rows are filtered).
 * @param {Boolean} isSwitchOn - true: make visible / false: make invisible
 * @param {String} targetRowClass - class of row(tr) which you want to switch visibility
 */
function FilterVisibleRow(isSwitchOn, targetRowClass){
    if(isSwitchOn){
        $('.' + targetRowClass).css('display', 'table-row');
    }else{
        $('.' + targetRowClass).css('display', 'none');
    }
}
