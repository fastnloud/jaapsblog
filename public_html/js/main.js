$(document).ready(function(){
    loadSearch();
    replyForm();
});

function replyForm(){
    var form = $('#reply-form');

    if (form) {
        $(form).find('input[type=text], textarea').keyup(function() {
            if ('' == $(this).val()) {
                $(this).addClass('error');
            } else {
                $(this).removeClass('error');
            }
        });
    }
}

function loadSearch(){
    var button      = $('#menu-btn-search'),
        searchBlock = $('#search'),
        searchInput = $('#search input');
    
    if (searchBlock) {
        $(searchInput).focus(function() {
            if ('Search...' == $(this).val()) {
                $(this).val('');
            }
        });
        
        $(searchInput).blur(function() {
            if ('' == $(this).val()) {
                $(this).val('Search...');
            }
        });
        
        $(button).click(function() {
            $(searchBlock).slideToggle('fast', function() {
                if ('' == $(searchInput).val()) {
                    $(searchInput).val('Search...');
                }
            });
        });
    }
}

function popup(url, title, w, h) {
    var left = (screen.width/2)-(w/2),
        top = (screen.height/2)-(h/2);

    return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}