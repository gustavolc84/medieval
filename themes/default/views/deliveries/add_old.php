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
                        <?= form_open_multipart("deliveries/add", 'class="validation"');?>
                        <input type="hidden" name = "created" value = "<?= date('Y-m-d') ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?= lang('sale'); ?>
                                    <?= form_input('sale_id', set_value('sale_id'), 'class="form-control tip" id="sale_id"  required="required"'); ?>
                                </div>

                                <div class="form-group">
                                    <?= lang('employees'); ?>
                                    <?php $opts = $employees; ?>
                                    <?= form_dropdown('employee_id', $opts, set_value('employee_id'), 'class="form-control tip select2" id="employee_id"  required="required" style="width:100%;"'); ?>
                                </div>

                                <div class="form-group">
                                    <?= lang('customers'); ?>
                                    <?php $opts = $customers; ?>
                                    <?= form_dropdown('customer_id', $opts, set_value('customer_id'), 'class="form-control tip select2" id="customer_id"  required="required" style="width:100%;"'); ?>
                                </div>

                                <div class="form-group">
                                    <?= lang('change_money'); ?>
                                    <?= form_input('change_money', set_value('change_money'), 'class="form-control tip" id="change_money"'); ?>
                                </div>

                                <div class="form-group">
                                    <?= lang('status', 'status'); ?>
                                    <?php $opts = $status; ?>
                                    <?= form_dropdown('status', $opts, set_value('status', 0), 'class="form-control tip select2" id="status"  required="required" style="width:100%;"'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <?= form_submit('add_delivery', lang('add_delivery'), 'class="btn btn-primary"'); ?>
                        </div>
                        <?= form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?= $assets ?>plugins/input-mask/jquery.maskMoney.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function(){
        $("#change_money").maskMoney({showSymbol:true, symbol:"R$", decimal:",", thousands:"."});
    });
</script>