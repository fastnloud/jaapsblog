// check support transitions
$.support.transition = (function(){
    var thisBody = document.body || document.documentElement,
        thisStyle = thisBody.style,
        support = thisStyle.transition !== undefined || thisStyle.WebkitTransition !== undefined || thisStyle.MozTransition !== undefined || thisStyle.MsTransition !== undefined || thisStyle.OTransition !== undefined;
    return support;
})();

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
        // first reset
        resetTransition(searchContainer);

        // for desktop version
        if (bodyWidth > 800) {
            $(searchContainer).height($('#page').height()+20);
            $(searchContainer).css('margin', '0 -410px 0 0');
            $(searchContainer).css('top', '86px');
            $(searchContainer).css('right', '50%');
        } else { // reset if needed
            $(searchContainer).height($('#page').height()+40);
            $(searchContainer).css('margin', '54px 0 0 0');
            $(searchContainer).css('top', '0');
            $(searchContainer).css('right', '0');
        }

        // double check
        setTimeout(function() {
            if (bodyWidth > 800) {
                $(searchContainer).height($('#page').height()+20);
            } else { // reset if needed
                $(searchContainer).height($('#page').height()+40);
            }
        }, 400);
    }
}

function search(searchContainer) {
    if (true === $.support.transition) {
        if ($(searchContainer).width() < 100) {
            $(searchContainer).transition({
                delay: 0,
                width: 230
            }, function() {
                $(this).find('form').fadeToggle(100);
                $(this).find('div').fadeToggle(100);
            });
        } else {
            $(searchContainer).find('form').fadeToggle(100);
            $(searchContainer).find('div').fadeToggle(100);
            $(searchContainer).transition({
                delay: 100,
                width: 1
            });
        }
    } else {
        if ($(searchContainer).width() < 100) {
            $(searchContainer).width(220);
            $(searchContainer).find('form').toggle(0);
            $(searchContainer).find('div').toggle(0);
        } else {
            $(searchContainer).width(1);
            $(searchContainer).find('form').toggle(0);
            $(searchContainer).find('div').toggle(0);
        }
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