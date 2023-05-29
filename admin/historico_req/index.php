
<?php include_once('datatable\tabelas.php'); ?>


<style>

body{
zoom: 90%;
}

table#tb_acomp.dataTable tbody tr:hover {
  background-color: #ffa;
}

</style>

<div class="card card-outline card-gray">
    <div class="card-header">
        <h4 class="text-center padding">Acompanhamento das requisições</h4>
        <!-- <div class="card-tools">
			<a href="<.?php echo base_url ?>admin/?page=requisicoes/solicitacao_material" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Novo</a>
		</div> -->

        
    </div> <!-- header -->
    <div class="card-body">

    <div class="row justify-content-center">
        <div class="form col-sm-6 col-md-3">
		<a style="width:100%;" onclick="window.location='<?php echo base_url ?>admin/?page=solicitar_requisicao'" class="btn btn-outline-secondary"><strong> VOLTAR </strong>  <!-- <span class="fas fa-circle-xmark"></span> --></a>
	    </div><br><br>
    </div> <!-- row -->
<br>
        <div class="container-fluid">
            
        <div class="table-responsive">
                <!-- <table class="table table-bordered table-stripped" id="tb_acomp"> -->
                <table class="table nowrap" id="tb_acomp" style="width:100%;">
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
                        <tr class="bg-secondary table-active">
                            <!-- <th class="text-center">#</th> -->
                            <th class="text-center">Requisição</th>
                            <th class="text-center">Material / Serviço</th>
                            <th class="text-center">Data Requisição</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Etapa atual</th>
                            <th class="text-center">PDF</th>
                            <th class="text-center">EDITAR</th>
                        </tr>
                    </thead>
                    <tbody>               
                     <!-- Aprovação Administrativo 1 Administrativo nível 1 --> 
                     
                        <?php
                        $usuario_historico = $_settings->userdata('id');
                        $i = 1;
                        $qry = $conn->query("SELECT p.*, r.*, p.id as idr, p.date_created as datareq FROM `purchase_order_list` p
                        left join receiving_list r on r.form_id = p.id
                        WHERE p.etapa_solicitacao = 1 AND p.req_solicitante_type = $usuario_historico");
                        while ($row = $qry->fetch_assoc()) : ?>
                                <tr>
                                <!-- <td class="text-center"><.?php echo $i++; ?></td> -->
                                <td class="text-center"><?php echo $row['po_code'] ?></td>
                                <td class="text-center">
                                <?php if ($row['etapa_mat_ou_ser'] == 0) : ?>
                                <span class="badge badge-primary">SERVIÇO</span>
                                <?php elseif ($row['etapa_mat_ou_ser'] == 1) : ?>
                                <span class="badge badge-warning">MATERIAL</span>
                                <?php endif; ?> </td>
                                <td class="text-center"><?php echo date("d-m-Y H:i", strtotime($row['datareq'])) ?>
                                                        
                            </td>

                                <td class="text-center">

                                <?php if ($row['estado_requisicao'] === 0) : ?>
                                <span class="badge badge-warning">AGUARDANDO AUTORIZAÇÃO</span>

                                <!-- VERSÃO 1.06 -->
                                <?php elseif ($row['estado_requisicao'] == 0 && $row['req_autorizada'] == 'Sim') : ?>
                                <span class="badge badge-primary">REQUISIÇÃO AUTORIZADA</span>
                                <!-- FIM -->

                                <?php elseif ($row['estado_requisicao'] == 1 && $row['req_aprov'] == 0) : ?>
                                <span class="badge badge-danger">REQ. RECUSADA (AUTORIZAÇÃO)</span>

                                <?php elseif ($row['estado_requisicao'] == 1 && $row['req_aprov'] == 1) : ?>
                                <span class="badge badge-primary">REQUISIÇÃO AUTORIZADA</span>

                                <?php elseif ($row['estado_requisicao'] == 2 && $row['total_aprov'] <= 2000.00) : ?>
                                <span class="badge badge-primary">COTAÇÃO REALIZADA</span>

                                <?php elseif ($row['estado_requisicao'] == 3 && $row['total_aprov'] >= 2000.01 && $row['total_aprov'] <= 9000000.00 && $row['nome_aprovacao2'] == '') : ?>
                                <span class="badge badge-primary">COTAÇÃO REALIZADA</span>
                                <!-- ferias ERA 2.000.01 A 10000 4 MUDANÇAS-->
                                <?php elseif ($row['total_aprov'] >= 9000000.01 && ($row['nome_aprovacao2'] == '' || $row['nome_aprovacao3'] == '' && $row['estado_requisicao'] == 3)) : ?>
                                <span class="badge badge-primary">COTAÇÃO REALIZADA</span>

                                <?php elseif ($row['estado_requisicao'] == 3 && $row['req_aprov2'] == 0) : ?>
                                <span class="badge badge-danger">REQ. RECUSADA (APROVAÇÃO)</span>

                                <?php elseif ($row['estado_requisicao'] == 3 && $row['req_aprov2'] == 1 && $row['total_aprov'] <= 2000.00) : ?>
                                <span class="badge badge-primary">REQUISIÇÃO APROVADA</span>

                                <?php elseif ($row['estado_requisicao'] == 3 && $row['req_aprov2'] == 1 && $row['nome_aprovacao2'] != '' && $row['total_aprov'] >= 2000.01 && $row['total_aprov'] <= 9000000.00) : ?>
                                <span class="badge badge-primary">REQUISIÇÃO APROVADA</span>

                                <?php elseif ($row['estado_requisicao'] == 3 && $row['req_aprov2'] == 1 && $row['nome_aprovacao2'] != '' && $row['nome_aprovacao3'] != '' && $row['total_aprov'] >= 9000000.01) : ?>
                                <span class="badge badge-primary">REQUISIÇÃO APROVADA</span>

                                <?php elseif ($row['estado_requisicao'] == 4) : ?>
                                <span class="badge badge-primary">PEDIDO REALIZADO</span>

                                <?php elseif ($row['estado_requisicao'] == 5 && $row['recepcao_final'] == 0) : ?>
                                <span class="badge badge-primary">AGUARDANDO RECEBIMENTO</span>

                                <?php elseif ($row['estado_requisicao'] == 5 && $row['recepcao_final'] == 1) : ?>
                                <span class="badge badge-success">PEDIDO RECEBIDO</span>

                                <?php elseif ($row['estado_requisicao'] == 7 && $row['etapa_financeiro'] == 0) : ?>
                                <span class="badge badge-primary">INFORMAÇÕES ADICIONADAS</span>

                                <?php elseif ($row['estado_requisicao'] == 7 && $row['etapa_financeiro'] == 1) : ?>
                                <span class="badge badge-primary">PAGAMENTO REALIZADO</span>
                                
                                <?php endif; ?>

                                
                                </td>

                                <td class="text-center">

                                <?php if ($row['estado_requisicao'] === 0) : ?>
                                <span class="badge badge-dark">AUTORIZAÇÃO</span>                             
                                <!-- VERSÃO 1.06 -->
                                <?php elseif ($row['estado_requisicao'] == 0 && $row['req_autorizada'] == 'Sim') : ?>
                                <span class="badge badge-dark">COTAÇÃO</span>
                                <!-- FIM -->

                                <?php elseif ($row['estado_requisicao'] == 1 && $row['req_aprov'] == 0) : ?>
                                <span class="badge badge-danger">AUTORIZAÇÃO RECUSADA</span>

                                <?php elseif ($row['estado_requisicao'] == 1 && $row['req_aprov'] == 1) : ?>
                                <span class="badge badge-dark">COTAÇÃO</span>

                                <?php elseif ($row['estado_requisicao'] == 2 && $row['total_aprov'] <= 2000.00) : ?>
                                <span class="badge badge-dark">APROVAÇÃO</span>

                                <?php elseif ($row['estado_requisicao'] == 3 && $row['total_aprov'] >= 2000.00 && $row['total_aprov'] <= 9000000.00 && $row['nome_aprovacao2'] == '') : ?>
                                <span class="badge badge-dark">APROVAÇÃO</span>
                                <!-- ferias ERA 2.000.01 A 10000 -->

                                <?php elseif ($row['total_aprov'] >= 0.01 && $row['estado_requisicao'] == 3 && ($row['nome_aprovacao2'] != '' || $row['nome_aprovacao3'] != '')) : ?>
                                <span class="badge badge-dark">COMPRAS</span>


                                <?php elseif ($row['estado_requisicao'] == 3 && $row['req_aprov2'] == 0) : ?>
                                <span class="badge badge-danger">APROVAÇÃO RECUSADA</span>

                                <?php elseif ($row['estado_requisicao'] == 3 && $row['req_aprov2'] == 1 && $row['total_aprov'] <= 2000.00) : ?>
                                <span class="badge badge-dark">COMPRAS</span>

                                <?php elseif ($row['estado_requisicao'] == 3 && $row['req_aprov2'] == 1 && $row['nome_aprovacao2'] != '' && $row['total_aprov'] >= 2000.01 && $row['total_aprov'] <= 9000000.00) : ?>
                                <span class="badge badge-dark">COMPRAS</span>

                                <?php elseif ($row['estado_requisicao'] == 3 && $row['req_aprov2'] == 1 && $row['nome_aprovacao2'] != '' && $row['nome_aprovacao3'] != '' && $row['total_aprov'] >= 9000000.01) : ?>
                                <span class="badge badge-dark">COMPRAS</span>

                                <?php elseif ($row['estado_requisicao'] == 4) : ?>
                                <span class="badge badge-dark">RECEPÇÃO</span>

                                <?php elseif ($row['estado_requisicao'] == 5 && $row['recepcao_final'] == 0) : ?>
                                <span class="badge badge-success">RECEPÇÃO</span>

                                <?php elseif ($row['estado_requisicao'] == 5 && $row['recepcao_final'] == 1) : ?>
                                <span class="badge badge-success">PEDIDO FINALIZADO</span>

                                <?php elseif ($row['estado_requisicao'] == 7 && $row['etapa_financeiro'] == 0) : ?>
                                <span class="badge badge-dark">FINANCEIRO</span>

                                <?php elseif ($row['estado_requisicao'] == 7 && $row['etapa_financeiro'] == 1) : ?>
                                <span class="badge badge-success">SERVIÇO FINALIZADO</span>

                                <?php endif; ?>

                                </td>

                                <td class="text-center">
                                <a class="dropdown-item bg-success" href="<?php echo base_url.'/admin?page=requisicoes/gerarpdf_solicitacao&id='.$row['idr']?>"><span class="fa-solid fa-file-pdf fa-lg"></span></a>
                                </td>

                                
                                <td class="text-center">
                                <?php if ($row['status'] == 0) : ?>
                                <a class="dropdown-item bg-blue" href="<?php echo base_url.'/admin?page=requisicoes/atualizar_solicitacao&id='.$row['idr']?>"><span class="fa fa-edit"></span></a>
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
// VERSÃO 1.06
var table = $('#tb_acomp').DataTable({
order: [[6, 'desc'],[0, 'desc']],
language: {
url: 'http://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
}
});
// FIM

});

</script>