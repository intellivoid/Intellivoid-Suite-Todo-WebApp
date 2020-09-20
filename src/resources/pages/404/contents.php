<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
?>
<!DOCTYPE html>
<html class="loading" lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>" data-textdirection="ltr">
    <head>
        <?PHP HTML::importSection('generic_headers'); ?>
        <title><?PHP HTML::print(TEXT_PAGE_TITLE); ?></title>
    </head>
    <body class="horizontal-layout horizontal-menu 1-column navbar-floating footer-static blank-page" data-open="hover" data-menu="horizontal-menu" data-col="1-columns">
        <div class="app-content content mb-0 pt-0" style="min-height: auto; overflow: hidden;">
            <div class="content-wrapper mt-0">
                <div class="content-body">
                    <section class="row flexbox-container">
                        <div class="col-xl-7 col-md-8 col-12 d-flex justify-content-center">
                            <div class="card auth-card bg-transparent shadow-none rounded-0 mb-0 w-100">
                                <div class="card-content">
                                    <div class="card-body text-center">
                                        <img src="/assets/images/undraw/404.svg" class="img-fluid align-self-center" alt="404 Not Found">
                                        <h1 class="font-large-2 my-1 text-light"><?PHP HTML::print(TEXT_HEADER); ?></h1>
                                        <a class="btn btn-primary btn-lg mt-2" href="<?PHP DynamicalWeb::getRoute('index', [], true); ?>"><?PHP HTML::print(TEXT_HOME_LINK); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <?PHP HTML::importSection('generic_js'); ?>
    </body>
</html>