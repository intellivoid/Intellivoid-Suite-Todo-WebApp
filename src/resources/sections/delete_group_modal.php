<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use Todo\Objects\Group;

    if(isset(DynamicalWeb::$globalObjects["selected_group"]))
    {
        /** @var Group $Group */
        $Group = DynamicalWeb::getMemoryObject("selected_group");

        ?>
        <div class="modal fade" id="deleteGroupModal" tabindex="-1" role="dialog" aria-labelledby="deleteGroupModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
                <div class="modal-content">
                    <section class="group-form">
                        <form id="form-delete-group" class="group-input">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteGroupModalLabel">Delete Group</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times
                                    <i class="vs-icon feather icon-close mr-0"></i>
                                </span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this group? all tasks associated with this group will
                                    be deleted as well.</p>
                            </div>
                            <div class="modal-footer">
                                <fieldset class="form-group position-relative has-icon-left mb-0">
                                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                                        <i class="feather icon-x d-block d-lg-none"></i>
                                        <span class="d-none d-lg-block">Cancel</span>
                                    </button>
                                </fieldset>
                                <fieldset class="form-group position-relative has-icon-left mb-0">
                                    <button type="button" class="btn btn-danger delete-group-item" data-dismiss="modal">
                                        <i class="feather icon-check d-block d-lg-none"></i>
                                        <span class="d-none d-lg-block">Delete</span>
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