<?PHP
    use DynamicalWeb\DynamicalWeb;
?>
<div class="modal fade text-left" id="change-language-dialog" tabindex="-1" role="dialog" aria-labelledby="crd" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="crd">Change Language</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <i class="feather icon-x-circle"></i>
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <a class="text-light" href="<?PHP DynamicalWeb::getRoute('change_language', array('language' => 'en', 'cache' => hash('sha256', time())), true); ?>">
                            <i class="flag-icon flag-icon-gb" title="gb" id="gb"></i> English (UK)
                        </a>
                    </div>
                    <div class="col-4">
                        <a class="text-light" href="<?PHP DynamicalWeb::getRoute('change_language', array('language' => 'zh', 'cache' => hash('sha256', time())), true); ?>">
                            <i class="flag-icon flag-icon-cn" title="cn" id="cn"></i> 中文
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect waves-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>