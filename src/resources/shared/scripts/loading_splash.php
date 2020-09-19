<?PHP
/** @noinspection PhpUnhandledExceptionInspection */

use DynamicalWeb\HTML;
?>
<!DOCTYPE html>
<html lang="en" >
    <head>
        <?PHP HTML::importSection("generic_headers_lite"); ?>
        <title>Intellivoid Suite</title>
    </head>
    <body>
        <div id="particles-background" class="vertical-centered-box"></div>
        <div id="particles-foreground" class="vertical-centered-box"></div>
        <div class="vertical-centered-box">
            <div class="content">
                <div class="loader-circle"></div>
                <div class="loader-line-mask">
                    <div class="loader-line"></div>
                </div>
                <img src="/assets/images/todoc.svg" width="120" height="120">
            </div>
        </div>
        <?PHP HTML::importSection("generic_js"); ?>
    </body>
</html>
