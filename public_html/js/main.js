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

    loadSidebar();
    validateReplyForm();
});

$(window).resize(function() {
    // reload if body width changes
    if (bodyWidth != $('body').width()) {
        // register new size
        bodyWidth = $('body').width();

        // reset
        loadSidebarCss();
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

function loadSidebar(){
    var sidebarContainer = $('#sidebar'),
        searchButton     = $('#menu-btn-sidebar'),
        searchInput      = $('#sidebar #search input');

    if (sidebarContainer) {
        // apply css props
        loadSidebarCss();

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
            sidebar(sidebarContainer);
        });
    }
}

function loadSidebarCss() {
    var sidebarContainer = $('#sidebar');

    if (sidebarContainer) {
        // first reset
        resetTransition(sidebarContainer);

        // for desktop version
        if (bodyWidth > 800) {
            $(sidebarContainer).height($('#page').height()+20);
            $(sidebarContainer).css('margin', '0 -410px 0 0');
            $(sidebarContainer).css('top', '86px');
            $(sidebarContainer).css('right', '50%');
        } else { // reset if needed
            $(sidebarContainer).height($('#page').height()+40);
            $(sidebarContainer).css('margin', '54px 0 0 0');
            $(sidebarContainer).css('top', '0');
            $(sidebarContainer).css('right', '0');
        }

        // double check
        setTimeout(function() {
            if (bodyWidth > 800) {
                $(sidebarContainer).height($('#page').height()+20);
            } else { // reset if needed
                $(sidebarContainer).height($('#page').height()+40);
            }
        }, 400);
    }
}

function sidebar(sidebarContainer) {
    if (true === $.support.transition) {
        if ($(sidebarContainer).width() < 100) {
            $(sidebarContainer).transition({
                delay: 0,
                width: 230
            }, function() {
                $(this).find('div').fadeToggle(100);
            });
        } else {
            $(sidebarContainer).find('div').fadeToggle(100);
            $(sidebarContainer).transition({
                delay: 100,
                width: 1
            });
        }
    } else {
        if ($(sidebarContainer).width() < 100) {
            $(sidebarContainer).width(220);
            $(sidebarContainer).find('div').toggle(0);
        } else {
            $(sidebarContainer).width(1);
            $(sidebarContainer).find('div').toggle(0);
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