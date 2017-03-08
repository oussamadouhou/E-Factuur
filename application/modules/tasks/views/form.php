<?php
if ($this->mdl_tasks->form_value('task_id') &&
    ($this->mdl_tasks->form_value('task_status') == 4)
):
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#task-form').find(':input').prop('disabled', 'disabled');
            $('#btn-submit').hide();
            $('#btn-cancel').prop('disabled', false);
        });
    </script>
<?php endif ?>

<form method="post" class="form-horizontal" id="task-form">

    <input type="hidden" name="_ip_csrf" value="<?= $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <h1 class="headerbar-title"><?php echo trans('tasks_form'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">

        <?php $this->layout->load_view('layout/alerts'); ?>

        <?php if ($this->mdl_tasks->form_value('task_id') && ($this->mdl_tasks->form_value('task_status') == 4)) : ?>
            <div class="alert alert-warning small"><?php echo trans('info_task_readonly') ?></div>
        <?php endif ?>

        <div class="row">
            <div class="col-xs-12 col-sm-7">
                <fieldset>
                    <legend>
                        <?php if ($this->mdl_tasks->form_value('task_id')) : ?>
                            #<?php echo $this->mdl_tasks->form_value('task_id'); ?>&nbsp;
                            <?php echo $this->mdl_tasks->form_value('task_name'); ?>
                        <?php else : ?>
                            <?php echo trans('new_task'); ?>
                        <?php endif; ?>
                    </legend>

                    <div class="form-group">
                        <div class="col-xs-12 col-sm-3 text-right text-left-xs">
                            <label class="control-label"><?php echo trans('task_name'); ?>: </label>
                        </div>
                        <div class="col-xs-12 col-sm-9">
                            <input type="text" name="task_name" id="task_name" class="form-control"
                                   value="<?php echo $this->mdl_tasks->form_value('task_name'); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12 col-sm-3 text-right text-left-xs">
                            <label class="control-label"><?php echo trans('task_description'); ?>: </label>
                        </div>
                        <div class="col-xs-12 col-sm-9">
                            <textarea name="task_description" id="task_description" class="form-control"
                                      rows="3"><?php echo $this->mdl_tasks->form_value('task_description'); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12 col-sm-3 text-right text-left-xs">
                            <label class="control-label"><?php echo trans('task_price'); ?>: </label>
                        </div>
                        <div class="col-xs-12 col-sm-9">
                            <input type="text" name="task_price" id="task_price" class="form-control"
                                   value="<?php echo format_amount($this->mdl_tasks->form_value('task_price')); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12 col-sm-3 text-right text-left-xs">
                            <label class="control-label"><?php echo trans('tax_rate'); ?>: </label>
                        </div>
                        <div class="col-xs-12 col-sm-9">
                            <select name="tax_rate_id" id="tax_rate_id" class="form-control simple-select">
                                <option value="0"><?php echo trans('none'); ?></option>
                                <?php foreach ($tax_rates as $tax_rate) { ?>
                                    <option value="<?php echo $tax_rate->tax_rate_id; ?>"
                                        <?php if ($this->mdl_tasks->form_value('tax_rate_id') == $tax_rate->tax_rate_id) { ?> selected="selected" <?php } ?>
                                    >
                                        <?php echo $tax_rate->tax_rate_name
                                            . ' (' . format_amount($tax_rate->tax_rate_percent) . '%)'; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group has-feedback">
                        <div class="col-xs-12 col-sm-3 text-right text-left-xs">
                            <label for="task_finish_date" class="control-label"><?php echo trans('task_finish_date'); ?>
                                : </label>
                        </div>
                        <div class="col-xs-12 col-sm-9">
                            <div class="input-group">
                                <input name="task_finish_date" id="task_finish_date" class="form-control datepicker"
                                       value="<?php echo date_from_mysql($this->mdl_tasks->form_value('task_finish_date')); ?>">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar fa-fw"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12 col-sm-3 text-right text-left-xs">
                            <label class="control-label"><?php echo trans('status'); ?>: </label>
                        </div>
                        <div class="col-xs-12 col-sm-9">
                            <select name="task_status" id="task_status" class="form-control simple-select">
                                <?php foreach ($task_statuses as $key => $status) {
                                    if ($this->mdl_tasks->form_value('task_status') != 4 && $key == 4) continue;
                                    ?>
                                    <option value="<?php echo $key; ?>"
                                            <?php if ($key == $this->mdl_tasks->form_value('task_status')) { ?>selected="selected"<?php } ?>>
                                        <?php echo $status['label']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                </fieldset>
            </div>

            <div class="col-xs-12 col-sm-5">
                <fieldset>
                    <legend><?php echo trans('extra_information'); ?></legend>

                    <div class="form-group">
                        <div class="col-xs-12 col-sm-3 col-lg-2 text-right text-left-xs">
                            <label class="control-label"><?php echo trans('project'); ?>: </label>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-lg-8">
                            <select name="project_id" id="project_id" class="form-control simple-select">
                                <option value=""><?php echo trans('select_project'); ?></option>
                                <?php foreach ($projects as $project) { ?>
                                    <option value="<?php echo $project->project_id; ?>"
                                            <?php if ($this->mdl_tasks->form_value('project_id') == $project->project_id) { ?>selected="selected"<?php } ?>><?php echo $project->project_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                </fieldset>
            </div>
        </div>

    </div>

</form>
