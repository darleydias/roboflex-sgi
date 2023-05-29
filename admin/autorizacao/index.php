
<?php include_once('datatable\tabelas.php'); ?>


<style>

body{
zoom: 90%;
}

table#tb_autorizacao.dataTable tbody tr:hover {
  background-color: #ffa;
}

</style>

<div class="card card-outline card-blue">
    <div class="card-header">
        <h4 class="text-center padding">Autorizações</h4>
        <!-- <div class="card-tools">
			<a href="<.?php echo base_url ?>admin/?page=requisicoes/solicitacao_material" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Novo</a>
		</div> -->

        
    </div> <!-- header -->
    <div class="card-body">

    <div class="row justify-content-around">
        <div class="form col-sm-6 col-md-3">
		<a style="width:100%;" onclick="window.location='<?php echo base_url ?>admin/?page=autorizacao/autorizacao_rec'" class="btn btn-outline-danger"> <strong> Autorizações Recusadas </strong><span class="fas fa-circle-xmark"></span></a>
	    </div><br><br>

        <div class="form col-sm-6 col-md-3">
		<a style="width:100%;" onclick="window.location='<?php echo base_url ?>admin/?page=autorizacao/autorizacao_aprov'" class="btn btn-outline-success"> <strong> Autorizações Realizadas </strong> <span class="fas fa-circle-check"></span></a>
	    </div>
    </div> <!-- row -->
<br>
        <div class="container-fluid">

        <div class="table-responsive">

                <table class="table nowrap" id="tb_autorizacao" style="width: 100%;">
                    <thead>
                    <tr class="bg-success table-active">
                            <th class="text-center">Requisição</th>
                            <th class="text-center">Material / Serviço</th>
                            <th class="text-center">Grupo</th>
                            <th class="text-center">Solicitante</th>
                            <th class="text-center">Data Solicitação</th>
                            <th class="text-center">Autorização</th>
                        </tr>
                    </thead>
                    <tbody>

<!-- se for administrador -->
<?php if($_settings->userdata('user_adm') == 'ADM') : ?>
                        <?php
                        $i = 1;
                        $qry = $conn->query("SELECT p.*, s.name as supplier FROM `purchase_order_list` p
                        inner join supplier_list s on p.supplier_id = s.id
                        WHERE (p.status = 0 and p.req_autorizada = 'Não')
                        group by p.id");
                        while ($row = $qry->fetch_assoc()) : ?>
                            <tr>
                                <td style="width:150px;" class="text-center"><?php echo $row['po_code'] ?></td>
                               
                                <td class="text-center" style="min-width:120px;">
                                <?php if ($row['etapa_mat_ou_ser'] == 0) : ?>
                                <span class="badge bg-blue rounded-pill">SERVIÇO</span>
                                <?php elseif ($row['etapa_mat_ou_ser'] == 1) : ?>
                                <span class="badge bg-warning rounded-pill">MATERIAL</span>
                                <?php endif; ?> </td>
                                
                                <td class="text-center" style="min-width: 150px;">
                                <?php if ($row['req_grupo'] == 'Operacional') : ?>
                                <span class="badge bg-dark rounded-pill">Operacional</span>
                                
                                <?php elseif ($row['req_grupo'] == 'Administrativo') : ?>
                                <span class="badge bg-blue rounded-pill">Administrativo</span>
                                
                                <?php elseif ($row['req_grupo'] == 'Assistência Técnica') : ?>
                                <span class="badge bg-orange rounded-pill">Assistência Técnica</span>
                                
                                <?php elseif ($row['req_grupo'] == 'P&D') : ?>
                                <span class="badge bg-warning rounded-pill">P&D</span>
                                
                                <?php elseif ($row['req_grupo'] == 'Negócios') : ?>
                                <span class="badge bg-gray rounded-pill">Negócios</span>
                                
                                <?php elseif ($row['req_grupo'] == 'Financeiro') : ?>
                                <span class="badge bg-green rounded-pill">Financeiro</span>

                                <?php elseif ($row['req_grupo'] == 'Compras Matérias-primas') : ?>
                                    <span class="badge bg-danger rounded-pill">Compras Matérias-primas</span>
                                <?php endif; ?>
                                </td>  

                                <td class="text-center" style="min-width:150px;"><?php echo $row['req_requisitante'] ?></td>

                                <td class="text-center" style="min-width:150px"><?php echo date("d-m-Y H:i", strtotime($row['date_created'])) ?></td>
                                
                                <td class="text-center align-middle" style="min-width: 100px;">
                                <a class="dropdown-item bg-warning" href="<?php echo base_url . 'admin?page=receiving/manage_autorizacao&po_id=' . $row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-black"></span></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
<!-- se não for -->
<?php else : ?>
<?php
                        $usuario_setor = $_settings->userdata('usuario_setor');
                        $i = 1;
                        $qry = $conn->query("SELECT p.*, s.name as supplier FROM `purchase_order_list` p
                        inner join supplier_list s on p.supplier_id = s.id
                        WHERE (p.status = 0 AND p.req_autorizada = 'Não' AND p.req_grupo = '$usuario_setor')
                        group by p.id");
                        while ($row = $qry->fetch_assoc()) : ?>
                             <tr>
                                <td style="width:150px;" class="text-center"><?php echo $row['po_code'] ?></td>
                               
                                <td class="text-center" style="min-width:120px;">
                                <?php if ($row['etapa_mat_ou_ser'] == 0) : ?>
                                <span class="badge bg-blue rounded-pill">SERVIÇO</span>
                                <?php elseif ($row['etapa_mat_ou_ser'] == 1) : ?>
                                <span class="badge bg-warning rounded-pill">MATERIAL</span>
                                <?php endif; ?> </td>
                                
                                <td class="text-center" style="min-width: 150px;;">
                                <?php if ($row['req_grupo'] == 'Operacional') : ?>
                                <span class="badge bg-dark rounded-pill">Operacional</span>
                                
                                <?php elseif ($row['req_grupo'] == 'Administrativo') : ?>
                                <span class="badge bg-blue rounded-pill">Administrativo</span>
                                
                                <?php elseif ($row['req_grupo'] == 'Assistência Técnica') : ?>
                                <span class="badge bg-orange rounded-pill">Assistência Técnica</span>
                                
                                <?php elseif ($row['req_grupo'] == 'P&D') : ?>
                                <span class="badge bg-warning rounded-pill">P&D</span>
                                
                                <?php elseif ($row['req_grupo'] == 'Negócios') : ?>
                                <span class="badge bg-gray rounded-pill">Negócios</span>
                                
                                <?php elseif ($row['req_grupo'] == 'Financeiro') : ?>
                                <span class="badge bg-green rounded-pill">Financeiro</span>

                                <?php elseif ($row['req_grupo'] == 'Compras Matérias-primas') : ?>
                                    <span class="badge bg-danger rounded-pill">Compras Matérias-primas</span>
                                <?php endif; ?>
                                </td>  

                                <td class="text-center" style="min-width:150px;"><?php echo $row['req_requisitante'] ?></td>

                                <td class="text-center" style="min-width:150px"><?php echo date("d-m-Y H:i", strtotime($row['date_created'])) ?></td>
                                
                                <td class="text-center align-middle" style="min-width: 100px;">
                                <a class="dropdown-item bg-warning" href="<?php echo base_url . 'admin?page=receiving/manage_autorizacao&po_id=' . $row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-black"></span></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <?php endif; ?>
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
        });
        $('.view_details').click(function() {
            uni_modal("Detalhes", "transaction/view_payment.php?id=" + $(this).attr('data-id'), 'mid-large')
        });
    });

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
    };
    
</script>