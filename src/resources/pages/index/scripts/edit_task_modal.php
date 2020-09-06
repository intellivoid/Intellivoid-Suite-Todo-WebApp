<div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="editTodoTask" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
        <div class="modal-content">
            <section class="todo-form">
                <form id="form-edit-todo" class="todo-input">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTodoTask">Edit Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="todo-item-action ml-auto">
                            <a class='edit-todo-item-info todo-item-info'><i class="feather icon-info"></i></a>
                            <a class='edit-todo-item-favorite todo-item-favorite'><i class="feather icon-star"></i></a>
                            <div class="dropdown todo-item-label">
                                <i class="dropdown-toggle mr-0 mb-1 feather icon-tag" id="todoEditLabel" data-toggle="dropdown">
                                </i>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="todoEditLabel">
                                    <div class="dropdown-item">
                                        <div class="vs-checkbox-con">
                                            <input type="checkbox" data-color="primary" data-value="Frontend">
                                            <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                            <i class="vs-icon feather icon-check mr-0"></i>
                                                                        </span>
                                                                    </span>
                                            <span>Frontend</span>
                                        </div>
                                    </div>
                                    <div class="dropdown-item">
                                        <div class="vs-checkbox-con">
                                            <input type="checkbox" data-color="warning" data-value="Backend">
                                            <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                            <i class="vs-icon feather icon-check mr-0"></i>
                                                                        </span>
                                                                    </span>
                                            <span>Backend</span>
                                        </div>
                                    </div>
                                    <div class="dropdown-item">
                                        <div class="vs-checkbox-con">
                                            <input type="checkbox" data-color="success" data-value="Doc">
                                            <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                            <i class="vs-icon feather icon-check mr-0"></i>
                                                                        </span>
                                                                    </span>
                                            <span>Doc</span>
                                        </div>
                                    </div>
                                    <div class="dropdown-item">
                                        <div class="vs-checkbox-con">
                                            <input type="checkbox" data-color="danger" data-value="Bug">
                                            <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                            <i class="vs-icon feather icon-check mr-0"></i>
                                                                        </span>
                                                                    </span>
                                            <span>Bug</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <fieldset class="form-group">
                            <input type="text" class="edit-todo-item-title form-control" placeholder="Title">
                        </fieldset>
                        <fieldset class="form-group">
                            <textarea class="edit-todo-item-desc form-control" rows="3" placeholder="Add description"></textarea>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <fieldset class="form-group position-relative has-icon-left mb-0">
                            <button type="button" class="btn btn-primary update-todo-item" data-dismiss="modal"><i class="feather icon-edit d-block d-lg-none"></i>
                                <span class="d-none d-lg-block">Update</span></button>
                        </fieldset>
                        <fieldset class="form-group position-relative has-icon-left mb-0">
                            <button type="button" class="btn" data-dismiss="modal"><i class="feather icon-x d-block d-lg-none"></i>
                                <span class="d-none d-lg-block">Cancel</span></button>
                        </fieldset>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
