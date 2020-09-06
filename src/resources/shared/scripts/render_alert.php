<?php

    use DynamicalWeb\HTML;

    /**
     * Renders a alert in the document
     *
     * @param string $text
     * @param string $type
     * @param string $icon
     */
    function RenderAlert(string $text, string $type, string $icon)
    {
        HTML::print("<div class=\"content-area-wrapper\">", false);
        HTML::print("<div class=\"alert mb-0 alert-", false);
        HTML::print($type);
        HTML::print("\" role=\"alert\" style=\"border-radius: 0px; width: 100%;\">", false);
        HTML::print("<i class=\"px-1 feather ", false);
        HTML::print($icon);
        HTML::print("\"></i>", false);
        HTML::print($text);
        HTML::print("</div>", false);
        HTML::print("</div>", false);
    }