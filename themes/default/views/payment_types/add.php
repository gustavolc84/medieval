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

                        <?php echo form_open_multipart("payment_types/add", 'class="validation"'); ?>
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    Ícone
                                    <?= form_input('icon', set_value('icon'), 'class="form-control tip" id="icon"  required="required"'); ?>
                                </div>

                                <div class="form-group">
                                    Título
                                    <?= form_input('name',set_value('name'), 'class="form-control tip" id="name"  required="required"'); ?>
                                </div>

                                <div class="form-group">
                                    Taxa %
                                    <?= form_input('tax', set_value('tax'), 'class="form-control tip" id="tax"  required="required"'); ?>
                                </div>

                                <div class="form-group">
                                    Taxa Fixa
                                    <?= form_input('fix_tax', set_value('fix_tax'), 'class="form-control tip" id="fix_tax"  required="required"'); ?>
                                </div>

                                <div class="form-group">
                                    Ordem
                                    <?= form_input('reorder', set_value('reorder'), 'class="form-control tip" id="reorder"  required="required"'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <?= form_submit('add_category', lang('add_category'), 'class="btn btn-primary"'); ?>
                        </div>

                        <?php echo form_close();?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>
