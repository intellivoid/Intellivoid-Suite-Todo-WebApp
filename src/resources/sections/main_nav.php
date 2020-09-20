<?PHP

use COASniffle\Abstracts\AvatarResourceName;
use COASniffle\Handlers\COA;
use DynamicalWeb\DynamicalWeb;
use DynamicalWeb\HTML;

?>
<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-fixed navbar-brand-center">
    <div class="navbar-header d-xl-block d-none">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item">
                <a class="navbar-brand" href="<?PHP DynamicalWeb::getRoute("index", [], true); ?>">
                    <div class="brand-logo"></div>
                </a>
            </li>
        </ul>
    </div>
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav bookmark-icons">
                        <li class="nav-item d-block">
                            <a class="nav-link" href="https://accounts.intellivoid.net" data-toggle="tooltip" data-placement="top" title="Accounts">
                                <i class="ficon feather icon-user"></i>
                            </a>
                        </li>
                        <li class="nav-item d-block">
                            <a class="nav-link disabled" href="#" data-toggle="tooltip" data-placement="top" title="Todo">
                                <i class="ficon feather icon-check-square"></i>
                            </a>
                        </li>

                    </ul>
                </div>
                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-language nav-item">
                        <a class="nav-link" id="dropdown-flag" href="#" data-toggle="modal" data-target="#change-language-dialog">
                            <i class="ficon feather icon-globe"></i>
                        </a>
                    </li>
                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none">
                                <span class="user-name text-bold-600">
                                    <?PHP HTML::print(WEB_ACCOUNT_USERNAME); ?>
                                </span>
                                <span class="user-status"><?PHP HTML::print(WEB_ACCESS_EMAIL); ?></span>
                            </div>
                            <span>
                                <img class="round" src="<?PHP HTML::print(COA::getAvatarUrl(AvatarResourceName::Normal, WEB_ACCOUNT_PUBID)); ?>" alt="<?PHP HTML::print(WEB_ACCOUNT_USERNAME); ?>" height="40" width="40">
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#appInfoModal">
                                <i class="feather icon-info"></i> <?PHP HTML::print(TEXT_NAV_APPLICATION_INFO); ?>
                            </a>
                            <a class="dropdown-item" href="https://accounts.intellivoid.net/">
                                <i class="feather icon-user"></i> <?PHP HTML::print(TEXT_NAV_MANAGE_ACCOUNT); ?>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<?php HTML::importSection("application_info_modal"); ?>