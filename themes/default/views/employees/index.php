<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<script type="text/javascript">
    $(document).ready(function(){
        
        $('#fileData').dataTable({
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?= lang('all'); ?>']],
            "aaSorting": [[ 1, "asc" ]], "iDisplayLength": <?= $Settings->rows_per_page ?>,
            
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
            }            
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
                        <table id="fileData" class="table table-striped table-bordered table-hover" style="margin-bottom:5px;">
                            <thead>
                                <tr class="active">                                    
                                    <th class="col-xs-1"> Identificador                </th>
                                    <th class="col-xs-1"><?= lang("first_name"); ?>    </th>
                                    <th class="col-xs-1"><?= lang("last_name"); ?>     </th>
                                    <th class="col-xs-1"><?= lang("type_employee"); ?> </th>
                                    <th class="col-xs-1"> Status                       </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($dados as $dado): ?>
                                    <tr>
                                        <td> <?= $dado->id ?>                                </td>
                                        <td> <?= $dado->first_name ?>                        </td>
                                        <td> <?= $dado->last_name ?>                         </td>
                                        <td> <?= ucfirst($dado->type_employee) ?>            </td>
                                        <td> <?= $dado->status == 1 ? 'Ativo' : 'Inativo' ?> </td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                        </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>
