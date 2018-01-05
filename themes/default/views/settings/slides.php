<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?= lang('slides'); ?></h3>
                </div>
                <div class="box-body">
                    <div class="col-lg-12">
                        <?= form_open_multipart("settings/slides", 'class="validation"'); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?= lang('image_video', 'image_video'); ?>
                                    <input type="file" name="userfile" id="file">
                                </div>

                                <div class="form-group">
                                    <?= lang('order_slides','order_slides')?>
                                    <?= form_input('order_slides',set_value('order_slides'),'class="form-control" id="order_slides" required="required"')?>
                                </div>

                                <div class="form-group">
                                    <?= lang('status_image_video','image_video'); ?>
                                    <?php $tm = $status ?>
                                    <?= form_dropdown('image_video', $tm, set_value('status',1), 'class="form-control" id="image_video" style="width:100%;"'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <?= form_submit('add_slides', lang('add_slides'), 'class="btn btn-primary"'); ?>
                        </div>
                        <?= form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
