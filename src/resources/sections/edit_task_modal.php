<?php
    use DynamicalWeb\HTML;
?>
<div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="editTodoTask" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
        <div class="modal-content">
            <section class="todo-form">
                <form id="form-edit-todo" class="todo-input">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTodoTask"><?PHP HTML::print(TEXT_EDIT_TASK_MODAL_NAME); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times
                                <i class="vs-icon feather icon-close mr-0"></i>
                            </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="todo-item-action ml-auto">
                            <div class="edit-item-color ml-auto">
                                <a class="todo-item-color no-update">
                                    <i class="feather icon-circle"></i>
                                </a>
                            </div>
                        </div>
                        <input type="text" hidden="hidden" id="todo-item-color-value" name="todo-item-color-value" value="0">
                        <fieldset class="form-group">
                            <input type="text" class="edit-todo-item-title form-control" placeholder="<?PHP HTML::print(TEXT_EDIT_TASK_TITLE_PLACEHOLDER); ?>">
                        </fieldset>
                        <fieldset class="form-group">
                            <textarea class="edit-todo-item-desc form-control" rows="3" placeholder="<?PHP HTML::print(TEXT_EDIT_TASK_DESCRIPTION_PLACEHOLDER); ?>"></textarea>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <fieldset class="form-group position-relative has-icon-left mb-0">
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                                <i class="feather icon-x d-block d-lg-none"></i>
                                <span class="d-none d-lg-block"><?PHP HTML::print(TEXT_EDIT_TASK_CANCEL_BUTTON); ?></span>
                            </button>
                        </fieldset>
                        <fieldset class="form-group position-relative has-icon-left mb-0">
                            <button type="button" class="btn btn-primary update-todo-item" data-dismiss="modal">
                                <i class="feather icon-edit d-block d-lg-none"></i>
                                <span class="d-none d-lg-block"><?PHP HTML::print(TEXT_EDIT_TASK_UPDATE_BUTTON); ?></span>
                            </button>
                        </fieldset>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
