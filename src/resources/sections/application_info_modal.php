<div class="modal fade" id="appInfoModal" tabindex="-1" role="dialog" aria-labelledby="appInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="appInfoModalLabel">
                    Intellivoid Suite - Todo
                    <div class="badge badge-primary">Beta</div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times
                        <i class="vs-icon feather icon-close mr-0"></i>
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <h5>About</h5>
                <p>Intellivoid Suite - Todo (Web Application Build), Copyright &copy; Intellivoid Technologies 2017-<?PHP \DynamicalWeb\HTML::print(date("Y")); ?></p>
                <h5>Components Info (PPM)</h5>
                <ul class="list-unstyled">
                    <?PHP
                        foreach(\ppm\ppm::getImportedPackages() as $package_name => $package_version)
                        {
                            ?>
                            <li class="text-light">
                                <?PHP \DynamicalWeb\HTML::print($package_name); ?>==<code><?PHP \DynamicalWeb\HTML::print($package_version); ?></code>
                            </li>
                            <?PHP
                        }
                    ?>
                </ul>
                <h5>DynamicalWeb Build Info</h5>
                <ul class="list-unstyled">
                    <li class="text-light">
                        Version==<code><?PHP \DynamicalWeb\HTML::print(DYNAMICAL_WEB_VERSION); ?></code>
                    </li>
                    <li class="text-light">
                        Author==<code><?PHP \DynamicalWeb\HTML::print(DYNAMICAL_WEB_AUTHOR); ?></code>
                    </li>
                    <li class="text-light">
                        Company==<code><?PHP \DynamicalWeb\HTML::print(DYNAMICAL_WEB_COMPANY); ?></code>
                    </li>
                </ul>
                <h5>Device Info</h5>
                <ul class="list-unstyled">
                    <li class="text-light">
                        Host==<code><?PHP \DynamicalWeb\HTML::print(CLIENT_REMOTE_HOST); ?></code>
                    </li>
                    <li class="text-light">
                        UserAgent==<code><?PHP \DynamicalWeb\HTML::print(CLIENT_USER_AGENT); ?></code>
                    </li>
                    <li class="text-light">
                        Platform==<code><?PHP \DynamicalWeb\HTML::print(CLIENT_PLATFORM); ?></code>
                    </li>
                    <li class="text-light">
                        Browser==<code><?PHP \DynamicalWeb\HTML::print(CLIENT_BROWSER); ?></code>
                    </li>
                    <li class="text-light">
                        Version==<code><?PHP \DynamicalWeb\HTML::print(CLIENT_VERSION); ?></code>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>