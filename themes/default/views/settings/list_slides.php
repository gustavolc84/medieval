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
                                    <th class="col-xs-2"> Arquivo                      </th>
                                    <th class="col-xs-2"><?= lang("order_slides"); ?>  </th>
                                    <th class="col-xs-2"><?= lang("status_image_video"); ?>  </th>
                                    <th class="col-xs-2"><?= lang("actions"); ?>       </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($dados as $dado): ?>                               
                                    <tr style="text-align: center">                                        
                                        <td> <?= $dado->name ?>   </td> 
                                        <td> <?= $dado->orders ?> </td>
                                        <td> <?= $status[$dado->status] ?> </td>
                                        <td> 
                                            <div class="btn-group">
                                                <!--
                                                <a href="slides/<?= $dado->id ?>" class = "tip btn btn-primary btn-xs add" data-toggle="tooltip" title="Editar">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                -->
                                                <a href="slides/<?= $dado->id?>" data-id = "<?= $dado->id ?>" data-status = "<?= $dado->status ?>" class = "tip btn btn-primary btn-xs edit" data-toggle="tooltip" title="Atualizar Status">
                                                    <i class="fa fa-picture-o"></i>
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
    $('.edit').click(function(e){
            e.preventDefault();
            
            let id    = $(this).attr('data-id');
            let status = $(this).attr('data-status');
            let url   = $('#path').val() + 'settings/slides';
            let value = $('#spos_token').val();
            
            $.ajax({
                url:url,
                type: 'post',
                data: { id:id , spos_token:value , status:status },
                dataType: 'json',
                success:function(data){
                    location.reload();
                },
                error:function(){
                    alert('Erro no sistema!');
                }
            });
        });
</script>