$(document).ready(function () {
    setNavigation();
});

function setNavigation() {
    var path = window.location.pathname;

    path = path.replace(/\/$/, "");
    path = decodeURIComponent(path);

    $(".nav a, a.list-group-item").each(function () {
        var href = $(this).attr('href');
        href = href.replace(/\/$/, "");
        href = decodeURIComponent(href);
        
        if (path == href) {
            $(this).closest('li').addClass('active');
            $(this).addClass('active');
        }
    });
}