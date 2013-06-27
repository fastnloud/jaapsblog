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
    var searchContainer  = $('#search'),
        searchButton     = $('#menu-btn-search'),
        searchInput      = $('#search input');

    if (searchContainer) {
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

        $(searchButton).click(function() {
            search(searchContainer);
        });
    }
}

function search(searchContainer) {
    if (0 == searchContainer.css('opacity')) {
        $(searchContainer).transition({
            y: 170,
            opacity: 1,
            delay: 0
        });
    } else {
        $(searchContainer).transition({
            y: 0,
            opacity: 0,
            delay: 0
        });
    }
}

function popup(url, title, w, h) {
    var left = (screen.width/2)-(w/2),
        top = (screen.height/2)-(h/2);

    return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}