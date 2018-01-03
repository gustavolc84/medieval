<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?= lang('enter_info'); ?></h3>
                </div>
                <div class="box-body">
                    <div class="col-lg-12">
                        <?= form_open_multipart("employees/add", 'class="validation"');?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?= lang('first_name', 'first_name'); ?>
                                    <?= form_input('first_name', set_value('first_name'), 'class="form-control tip" id="first_name"  required="required"'); ?>
                                </div>

                                <div class="form-group">
                                    <?= lang('last_name', 'last_name'); ?>
                                    <?= form_input('last_name', set_value('last_name'), 'class="form-control tip" id="last_name"  required="required"'); ?>
                                </div>

                                <div class="form-group">
                                    <?= lang('type_employee', 'type_employee'); ?>
                                    <?php $opts = $tipos_func; ?>
                                    <?= form_dropdown('type_employee', $opts, set_value('type_employee', 'default'), 'class="form-control tip select2" id="type_employee"  required="required" style="width:100%;"'); ?>
                                </div>

                                <div class="form-group">
                                    <?= lang('status', 'status'); ?>
                                    <?php $opts = $status; ?>
                                    <?= form_dropdown('status', $opts, set_value('status', 1), 'class="form-control tip select2" id="type_employee"  required="required" style="width:100%;"'); ?>
                                </div>                                
                            </div>
                        </div>
                        <div class="form-group">
                            <?= form_submit('add_employees', lang('add_employees'), 'class="btn btn-primary"'); ?>
                        </div>
                        <?= form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>