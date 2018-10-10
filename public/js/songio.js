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
