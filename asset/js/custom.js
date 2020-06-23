//Chặn click chột phải
// document.addEventListener('contextmenu', event => event.preventDefault());
//Chặn F12 và Ctrl U
// document.onkeydown = function (e) {
//     if (e.ctrlKey && (e.keyCode === 85) || (e.keyCode === 123) || e.ctrlKey && (e.keyCode === 16) && (e.keyCode === 73)) {
//         $("#linkGG").attr("href", "#");
//         return false;
//     }
// };
//Hiệu ứng waiting cho button
function pleaseWaitButton(thatButton) {
    thatButton.disabled = true;
    thatButton.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đợi xíu nha...';
}
// Định dạng tiền tệ
function formatNumber(nStr, decSeperate, groupSeperate) {
    nStr += '';
    x = nStr.split(decSeperate);
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + groupSeperate + '$2');
    }
    return x1 + x2;
}