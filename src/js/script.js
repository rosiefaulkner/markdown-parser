/**
 * script.js
 *
 * Creates copy functionality
 * for the user to copy any output to
 * the clipboard
 *
 */
function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
  }

