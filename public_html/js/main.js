$(document).ready(function(){
    // global variable
    bodyWidth = $('body').width();

    loadSearch();
    validateReplyForm();
});

$(window).resize(function() {
    // reload if body width changes
    if (bodyWidth != $('body').width()) {
        // register new size
        bodyWidth = $('body').width();

        // reset
        loadSearchCss();
    }
});

function validateReplyForm(){
    var form = $('#reply-form');

    if (form) {
        $(form).find('input[type=text], textarea').keyup(function() {
            // validate input
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
        // apply css props
        loadSearchCss();

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

function loadSearchCss() {
    var searchContainer = $('#search');

    if (searchContainer) {
        $(searchContainer).height($('#page').height()+40);
        $(searchContainer).css('position', 'fixed');
        $(searchContainer).css('opacity', 0);

        resetTransition(searchContainer);

        // for desktop version
        if (bodyWidth > 800) {
            $(searchContainer).height($('#page').height()+20);
            $(searchContainer).css('margin', '0 -640px 0 0');
            $(searchContainer).css('top', '86px');
            $(searchContainer).css('right', '50%');
        } else { // reset if needed
            $(searchContainer).height($('#page').height()+40);
            $(searchContainer).css('margin', '54px -230px 0 0');
            $(searchContainer).css('top', '0');
            $(searchContainer).css('right', '0');
        }
    }
}

function search(searchContainer) {
    if (0 == searchContainer.css('opacity')) {
        $(searchContainer).transition({
            x: -230,
            opacity: 0.9,
            delay: 0
        }, function() {
            $(this).css('position', 'absolute');

            if (bodyWidth > 800) {
                $(this).height($('#page').height()+20);
            } else { // reset if needed
                $(this).height($('#page').height()+40);
            }
        });
    } else {
        // from the start
        $(searchContainer).css('position', 'fixed');
        $(searchContainer).transition({
            x: 230,
            opacity: 0,
            delay: 0
        });
    }
}

function resetTransition(elm) {
    $(elm).css('-webkit-transform', 'none');
    $(elm).css('-moz-transform', 'none');
    $(elm).css('-ms-transform', 'none');
    $(elm).css('-o-transform', 'none');
    $(elm).css('transform', 'none');
}

function popup(url, title, w, h) {
    var left = (screen.width/2)-(w/2),
        top = (screen.height/2)-(h/2);

    return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}