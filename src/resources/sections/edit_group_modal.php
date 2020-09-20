<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use Todo\Objects\Group;

    if(isset(DynamicalWeb::$globalObjects["selected_group"]))
    {
        /** @var Group $Group */
        $Group = DynamicalWeb::getMemoryObject("selected_group");

        ?>
        <div class="modal fade" id="editGroupModal" tabindex="-1" role="dialog" aria-labelledby="editGroupModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
                <div class="modal-content">
                    <section class="group-form">
                        <form id="form-edit-group" class="group-input">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editGroupModalLabel"><?PHP HTML::print(TEXT_EDIT_GROUP_MODAL_TITLE); ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times
                                    <i class="vs-icon feather icon-close mr-0"></i>
                                </span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <fieldset class="form-group">
                                    <input type="text" class="edit-group-item-name form-control" name="name" id="name" placeholder="<?PHP HTML::print(TEXT_EDIT_GROUP_NAME_PLACEHOLDER); ?>" value="<?PHP HTML::print($Group->Title); ?>">
                                </fieldset>
                                <input type="text" hidden="hidden" class="new-group-item-color form-control" name="task-input-color" id="task-input-color" value="0">
                            </div>
                            <div class="modal-footer">
                                <fieldset class="form-group position-relative has-icon-left mb-0">
                                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                                        <i class="feather icon-x d-block d-lg-none"></i>
                                        <span class="d-none d-lg-block"><?PHP HTML::print(TEXT_EDIT_GROUP_CANCEL_BUTTON); ?></span>
                                    </button>
                                </fieldset>
                                <fieldset class="form-group position-relative has-icon-left mb-0">
                                    <button type="button" class="btn btn-primary edit-group-item" data-dismiss="modal">
                                        <i class="feather icon-check d-block d-lg-none"></i>
                                        <span class="d-none d-lg-block"><?PHP HTML::print(TEXT_EDIT_GROUP_UPDATE_BUTTON); ?></span>
                                    </button>
                                </fieldset>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
        <?php
    }