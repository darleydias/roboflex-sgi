
<?php include_once('datatable\tabelas.php'); ?>


<style>
body{
zoom: 90%;
}
</style>

<div class="card card-outline card-gray">
    <div class="card-header">
        <h4 class="text-center padding">Acompanhamento das Requisições</h4>
        <!-- <div class="card-tools">
			<a href="<.?php echo base_url ?>admin/?page=requisicoes/solicitacao_material" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Novo</a>
		</div> -->

        
    </div> <!-- header -->
    <div class="card-body">

    <div class="row justify-content-center">
        <div class="form col-sm-6 col-md-3">
		<a style="width:100%;" onclick="window.location='<?php echo base_url ?>admin/?page=solicitar_requisicao'" class="btn btn-flat bg-gray"><strong> VOLTAR </strong>  <!-- <span class="fas fa-circle-xmark"></span> --></a>
	    </div><br><br>
    </div> <!-- row -->
<br>
        <div class="container-fluid">
            
        <div class="table-responsive">
                <!-- <table class="table table-bordered table-stripped" id="tb_acomp"> -->
                <table class="table display" id="tb_acomp" style="width:100%;">
                    <!-- <colgroup>
                        <col width="5%">
                        <col width="20%">
                        <col width="10%">
                        <col width="15%">
                        <col width="15%">
                        <col width="15%">
                        <col width="5%">
                        <col width="5%">
                    </colgroup> -->
                    <thead>
                        <tr class="bg-gray table-active">
                            <!-- <th class="text-center">#</th> -->
                            <th class="text-center" >Requisição</th>
                            <th class="text-center">Material / Serviço</th>
                            <th class="text-center">Data Requisição</th>
                            <th class="text-center">Situação</th>
                            <th class="text-center">Etapa Atual</th>
                            <th class="text-center">PDF</th>
                            <th class="text-center">EDITAR</th>
                        </tr>
                    </thead>
                    <tbody>               
                     <!-- Aprovação Administrativo 1 Administrativo nível 1 --> 
                     
                        <?php
                        $usuario_historico = $_settings->userdata('id');
                        $i = 1;
                        $qry = $conn->query("SELECT p.*, r.req_aprov, r.estado_requisicao, r.req_aprov2, r.form_id FROM `purchase_order_list` p
                        left join receiving_list r on r.form_id = p.id
                        WHERE p.etapa_solicitacao = 1 AND p.req_solicitante_type = $usuario_historico");
                        while ($row = $qry->fetch_assoc()) : ?>
                                <tr>
                                <!-- <td class="text-center"><.?php echo $i++; ?></td> -->
                                <td class="text-center"><?php echo $row['po_code'] ?></td>
                                <td class="text-center">
                                <?php if ($row['etapa_mat_ou_ser'] == 0) : ?>
                                <span class="badge badge-primary rounded-pill">SERVIÇO</span>
                                <?php elseif ($row['etapa_mat_ou_ser'] == 1) : ?>
                                <span class="badge badge-warning rounded-pill">MATERIAL</span>
                                <?php endif; ?> </td>
                                <td class="text-center"><?php echo date("d-m-Y H:i", strtotime($row['date_created'])) ?></td>

                                <td class="text-center">
                                <?php if ($row['estado_requisicao'] == 1 && $row['req_aprov'] == 1) : ?>
                                <span class="badge badge-success rounded-pill">Req. Autorizada</span>
                                <?php elseif ($row['estado_requisicao'] == 1 && $row['req_aprov'] == 0) : ?>
                                <span class="badge badge-danger rounded-pill">Req. Recusada</span>
                                <?php elseif ($row['etapa_solicitacao'] == 1 && $row['estado_requisicao'] == 1) : ?>
                                <span class="badge badge-warning rounded-pill">Aguardando Autorização</span>

                                
                                <!-- VERSÃO 1.06 -->
                                <?php elseif ($row['req_autorizada'] == 'Sim' && $row['estado_requisicao'] == NULL) : ?>
                                <span class="badge badge-success rounded-pill">Req. Autorizada</span>
                                <!-- FIM -->

                                <?php elseif ($row['estado_requisicao'] == 2) : ?>
                                <span class="badge badge-success rounded-pill">Cotação Realizada</span>
                                <?php elseif ($row['estado_requisicao'] == 3 && $row['req_aprov2'] == 1) : ?>
                                <span class="badge badge-success rounded-pill">Requisição Aprovada</span>
                                <?php elseif ($row['estado_requisicao'] == 3 && $row['req_aprov2'] == 0) : ?>
                                <span class="badge badge-danger rounded-pill">Req. Recusada</span>
                                <?php elseif ($row['estado_requisicao'] == 4) : ?>
                                <span class="badge badge-success rounded-pill">Pedido Realizado</span>
                                <?php else: ?>
                                <span class="badge badge-warning rounded-pill">Aguardando Autorização</span>  
                                <?php endif; ?>
                                </td>
                                    
                                <td class="text-center">
                                <?php if ($row['estado_requisicao'] == 0) : ?>
                                <span class="badge badge-dark rounded-pill">AUTORIZAÇÃO</span>

                                <!-- VERSÃO 1.06 -->
                                <?php elseif ($row['estado_requisicao'] == 0 && $row['req_autorizada'] == 'Sim') : ?>
                                <span class="badge badge-dark rounded-pill">COTAÇÃO</span>
                                <!-- FIM -->

                                <?php elseif ($row['estado_requisicao'] == 1 && $row['req_aprov'] == 0) : ?>
                                <span class="badge badge-danger rounded-pill">ENCERRADA (Autorização)</span>
                                <?php elseif ($row['estado_requisicao'] == 1) : ?>
                                <span class="badge badge-dark rounded-pill">COTAÇÃO</span>
                                <?php elseif ($row['estado_requisicao'] == 2) : ?>
                                <span class="badge badge-dark rounded-pill">APROVAÇÃO DIRETORIA</span>
                                <?php elseif ($row['estado_requisicao'] == 3 && $row['req_aprov2'] == 0) : ?>
                                <span class="badge badge-danger rounded-pill">ENCERRADA (Aprovação)</span>
                                <?php elseif ($row['estado_requisicao'] == 3) : ?>
                                <span class="badge badge-dark rounded-pill">PEDIDO DE COMPRA</span>
                                <?php elseif ($row['estado_requisicao'] == 4) : ?>
                                <span class="badge badge-success rounded-pill">CONCLUÍDA</span>
                                <?php endif; ?>
                                </td>

                                <td class="text-center">
                                <a class="dropdown-item bg-success" href="<?php echo base_url.'/admin?page=requisicoes/gerarpdf_solicitacao&id='.$row['id']?>"><span class="fa-solid fa-file-pdf fa-lg"></span></a>
                                </td>

                                
                                <td class="text-center">
                                <?php if ($row['status'] == 0) : ?>
                                <a class="dropdown-item bg-blue" href="<?php echo base_url.'/admin?page=requisicoes/atualizar_solicitacao&id='.$row['id']?>"><span class="fa fa-edit"></span></a>
                                <?php endif; ?>
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
        });
        $('.view_details').click(function() {
            uni_modal("Detalhes", "transaction/view_payment.php?id=" + $(this).attr('data-id'), 'mid-large')
        });
        /* $('.table td,.table th').addClass('py-1 px-2 align-middle')
        $('.table').dataTable(); */


// VERSÃO 1.06
var table = $('#tb_acomp').DataTable({
order: [[0, 'desc']],
language: {
url: 'http://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
}
});
// FIM

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
    }
</script>