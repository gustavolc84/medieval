<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
    $(document).ready(function(){        
        $('#tableDados').dataTable({
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
        });
    });

</script>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?= lang('list_results'); ?></h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="tableDados" class="table table-striped table-bordered table-hover" style="margin-bottom:5px;">
                            <thead>
                                <tr class="active">
                                    <th class="col-xs-1"><?= lang("sale"); ?>      </th>
                                    <th class="col-xs-2"><?= lang("customer"); ?>  </th>
                                    <th class="col-xs-2"><?= lang("employee"); ?>  </th>
                                    <th class="col-xs-2"><?= lang("hour_exit"); ?> </th>
                                    <th class="col-xs-2"><?= lang("hour_return"); ?> </th>
                                    <th class="col-xs-1"><?= lang("status"); ?>      </th>
                                    <th class="col-xs-1"><?= lang("actions"); ?>    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    foreach($dados as $dado):
                                    //manipula a coluna dt_hr_exit para retorna somente as horas 
                                    $hr_exit   = null;
                                    $hr_return = null;
                                    if(!is_null($dado->dt_hr_exit)){
                                        $hr_exit = new \Datetime($dado->dt_hr_exit);
                                        $hr_exit = $hr_exit->format('H:i:s');
                                    } 

                                    if(!is_null($dado->dt_hr_return)){
                                        $hr_return = new \Datetime($dado->dt_hr_return);
                                        $hr_return = $hr_return->format('H:i:s');
                                    }

                                    $background_color = '';
                                    $disabled         = '';
                                    if($dado->status == 2){
                                        $background_color = '#f1c40f';
                                    }elseif($dado->status == 3){
                                        $background_color = '#2ecc71';
                                        $disabled         = 'disabled';
                                    }                                                                       
                                ?>                                   
                                    <tr style="text-align: center; background-color: <?= $background_color ?>;">                                        
                                        <td> 
                                            <?= $dado->sale_id ?>         
                                        </td>

                                        <td> <?= $dado->name ?> </td>

                                        <td> 
                                            <?php if(!is_null($dado->first_name)): ?>
                                                <?= $dado->first_name; ?>
                                            <?php else: ?>
                                                <div class="form-group">
                                                    <?php $opts = $employees; ?>
                                                    <?= form_dropdown('employee_id', $opts, set_value('employee_id'), 'class="form-control tip select2" data-id = "'. $dado->id .'" id="employee_id" required="required" style="width:280px;"'); ?>
                                                </div>
                                            <?php endif; ?>                                            
                                        </td>

                                        <td> <?= $hr_exit ?>               </td>
                                        <td> <?= $hr_return ?>             </td>
                                        <td> <?= $status[$dado->status] ?> </td>
                                        <td> 
                                            <div class="btn-group">
                                                <a href="<?=$dado->id?>" <?= $disabled ?> data-status = "1" class = "tip btn btn-primary btn-xs" data-toggle="tooltip" title="<?= $status[1] ?>">
                                                    <i class="fa fa-meh-o"></i>
                                                </a>
                                                <a href="<?=$dado->id?>" <?= $disabled ?> data-status = "2" class = "tip btn btn-warning btn-xs" data-toggle="tooltip" title="<?= $status[2] ?>">
                                                    <i class="fa fa-share"></i>
                                                </a>
                                                <a href="<?=$dado->id?>" <?= $disabled ?> data-status = "3" class = "tip btn btn-danger btn-xs" data-toggle="tooltip"  title="<?= $status[3] ?>">
                                                    <i class="fa fa-reply"></i>
                                                </a>                                               
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<input type="hidden" id="path" value = "<?= base_url() ?>">
<input type="hidden" id="spos_token" value = "<?=$this->security->get_csrf_hash()?>">
<script type="text/javascript">
    $(function(){
        $('.tip').click(function(e){
            e.preventDefault();
            //let tr        = $(this).closest('tr');
            let type      = 'status';
            let status    = $(this).attr('data-status');
            let id_entrga = $(this).attr('href');
            let url       = $('#path').val() + 'deliveries/atualiza';             
            let value     = $('#spos_token').val();
            
            $.ajax({
                url:url,
                type: 'post',
                data: { id:id_entrga , status:status , spos_token:value , type:type },
                dataType: 'json',
                success:function(data){
                    if(data.sucesso){                       
                        location.reload();
                    }
                },
                error:function(){
                    alert('Erro no sistema!');
                }
            });
        });

        $('#employee_id').change(function(e){
            e.preventDefault();

            let type     = 'employee';
            let employee = $(this).val();
            let id       = $(this).attr('data-id');
            let url      = $('#path').val() + 'deliveries/atualiza';             
            let value    = $('#spos_token').val();

            $.ajax({
                url : url,
                type: 'post',
                data : {id:id , employee:employee , type:type , spos_token:value },
                dataType: 'json',
                success:function(data){
                    if(data.sucesso){                       
                        location.reload();
                    }else{
                        alert('Error');
                    }
                },
                error:function(){
                    alert('Erro no sistema!');
                }
            });
        });
    });
</script>