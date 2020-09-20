<?php
    /** @noinspection PhpUndefinedConstantInspection */

    use DynamicalWeb\HTML;
?>
<div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
        <div class="modal-content">
            <section class="todo-form">
                <form id="form-add-todo" class="todo-input">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTaskModalLabel"><?PHP HTML::print(TEXT_CREATE_TASK_MODAL_TITLE); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times
                                <i class="vs-icon feather icon-close mr-0"></i>
                            </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="todo-item-action ml-auto">
                            <a class="todo-item-color no-update color-none" style="color: #c2c6dc;">
                                <i class="feather icon-circle"></i>
                            </a>
                        </div>
                        <fieldset class="form-group">
                            <input type="text" class="new-todo-item-title form-control" name="title" id="title" placeholder="<?PHP HTML::print(TEXT_CREATE_TASK_TITLE_PLACEHOLDER); ?>">
                        </fieldset>
                        <fieldset class="form-group">
                            <textarea class="new-todo-item-desc form-control" rows="3" name="description" id="description" placeholder="<?PHP HTML::print(TEXT_CREATE_TASK_DESCRIPTION_PLACEHOLDER); ?>"></textarea>
                        </fieldset>
                        <input type="text" hidden="hidden" class="new-todo-item-color form-control" name="task-input-color" id="task-input-color" value="0">
                    </div>
                    <div class="modal-footer">
                        <fieldset class="form-group position-relative has-icon-left mb-0">
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                                <i class="feather icon-x d-block d-lg-none"></i>
                                <span class="d-none d-lg-block"><?PHP HTML::print(TEXT_CREATE_TASK_CANCEL_BUTTON); ?></span>
                            </button>
                        </fieldset>
                        <fieldset class="form-group position-relative has-icon-left mb-0">
                            <button type="button" class="btn btn-primary add-todo-item" data-dismiss="modal">
                                <i class="feather icon-check d-block d-lg-none"></i>
                                <span class="d-none d-lg-block"><?PHP HTML::print(TEXT_CREATE_TASK_CREATE_BUTTON); ?></span>
                            </button>
                        </fieldset>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
