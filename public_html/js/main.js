// load events
$(document).ready(function() {
    // search input field
    $('.search form > input').bind('focus focusout', function() {
        if ('Search...' == $(this).val()) {
            $(this).val('');
        } else if ('' == $(this).val()) {
            $(this).val('Search...');
        }
    });
});

// simple pupup handler
function popup(url, title, w, h) {
    var left = (screen.width/2)-(w/2),
        top = (screen.height/2)-(h/2);

    return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}