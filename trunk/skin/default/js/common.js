var $j = jQuery.noConflict();
$j(document).ready(function () {
    $j('div.header-nav ul.nav-list>li').hover(function () {
            $j(this).children('div.cui_subnav_wrap').show();
        },
        function () {
            $j(this).children('div.cui_subnav_wrap').hide();
        }
    );
});