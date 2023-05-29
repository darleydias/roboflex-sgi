
<?php include_once('datatable\tabelas.php'); ?>

<div class="card card-outline card-gray">
    <div class="card-header">
        <h4 class="text-center padding">Apontamentos de Produção</h4>
        <!-- <div class="card-tools">
			<a href="<.?php echo base_url ?>admin/?page=requisicoes/solicitacao_material" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Novo</a>
		</div> -->

        
    </div> <!-- header -->
    <div class="card-body">

    <div class="row justify-content-center">
        <div class="form col-sm-6 col-md-3">
		<a style="width:100%;" onclick="window.location='<?php echo base_url ?>admin/?page=apontamento/apontamento'" class="btn btn-flat bg-gray"><strong> NOVO APONTAMENTO </strong>  <!-- <span class="fas fa-circle-xmark"></span> --></a>
	    </div><br><br>
    </div> <!-- row -->
<br>
        <div class="container-fluid">
            
        <div class="table-responsive">
                <table class="table table-bordered table-stripped" id="tb_apontamento">
                    <colgroup>
                        <col width="5%">
                        <col width="10%">

                        <col width="10%">
                        <!-- <col width="10%"> -->
                        <col width="10%">
                        
                       <!--  <col width="10%"> -->
                    </colgroup>
                    <thead>
                        <tr class="bg-gray table-active">
                            <th class="text-center">#</th>
                            <th class="text-center" >Apontamento</th>
                            <th class="text-center">Código da OP</th>
                            <!-- <th class="text-center">Data Requisição</th> -->
                            
                            <!-- <th class="text-center">Setor</th> -->
                            <!-- <th class="text-center">PDF</th> -->
                            <th class="text-center">Editar</th>
                        </tr>
                    </thead>
                    <tbody>               
                     <!-- Aprovação Administrativo 1 Administrativo nível 1 --> 
                     
                        <?php
                        $usuario_historico = $_settings->userdata('id');
                        $i = 1;
                        $qry = $conn->query("SELECT p.* FROM `apontamento_list` p
                        WHERE p.req_solicitante_type = $usuario_historico");
                        while ($row = $qry->fetch_assoc()) : ?>
                                <tr>
                                <td class="text-center"><?php echo $i++; ?></td>

                                <td class="text-center"><?php echo $row['po_code'] ?></td>

                                <td class="text-center">
                                <?php echo $row['apontamento_op']?>
                                </td>

                               <!--  <td class="text-center"><?php echo date("d-m-Y H:i", strtotime($row['date_created'])) ?>
                            </td> -->

                            
                               <!--  <td class="text-center">
                               
                                </td> -->

                                <!-- <td class="text-center">
                                <a class="dropdown-item bg-success" href="<?php echo base_url.'/admin?page=requisicoes/gerarpdf_solicitacao&id='.$row['id']?>"><span class="fa-solid fa-file-pdf fa-lg"></span></a>
                                </td> -->

                                
                                <td class="col-md-3 text-center">
                              <!--   <.?php if ($row['status'] == 0) : ?> -->
                                <a class="dropdown-item bg-blue" href="<?php echo base_url.'/admin?page=apontamento/atualizar_apontamento&id='.$row['id']?>"><span class="fa fa-edit"></span></a>
                               <!--  <.?php endif; ?> -->
                                 </td>
                                
                            </tr>
                        <?php endwhile; ?>
                    


                        </tbody>
                </table>
                </div>
        </div>
    </div>
</div>


<script>

    $(document).ready(function() {
        $('.delete_data').click(function() {
            _conf("Você tem certeza que deseja deletar essa Requisição de Entrada permanentemente ?", "delete_po", [$(this).attr('data-id')])
        })
        $('.view_details').click(function() {
            uni_modal("Detalhes", "transaction/view_payment.php?id=" + $(this).attr('data-id'), 'mid-large')
        })
        $('.table td,.table th').addClass('py-1 px-2 align-middle')
        $('.table').dataTable();
    })

    function delete_po($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_po",
            method: "POST",
            data: {
                id: $id
            },
            dataType: "json",
            error: err => {
                console.log(err)
                alert_toast("Ocorreu um erro.", 'error');
                end_loader();
            },
            success: function(resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    location.reload();
                } else {
                    alert_toast("Ocorreu um erro.", 'error');
                    end_loader();
                }
            }
        })
    }
</script>