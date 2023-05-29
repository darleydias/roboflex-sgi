<style>
body{
zoom: 90%;
}

table#tb_completa.dataTable tbody tr:hover,
table#tb_completa2.dataTable tbody tr:hover{
  background-color: #ffa;
}

#tb_completa2 {
        display: none;
    }

</style>
<div class="card card-outline card-gray">
	<div class="card-header">
		<h4 class="text-center padding">Serviços</h4>
        <!-- <div class="card-tools">
			<a href="<.?php echo base_url ?>admin/?page=requisicoes/solicitacao_material" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Novo</a>
		</div> -->
	</div>
	<div class="card-body">

<div class="row justify-content-around">
<div>
<a id="btnTabela1" class="btn btn-warning" onclick="exibirTabela(1)">Pendentes</a>
</div>
<div>
<a id="btnTabela2" class="btn btn-success" onclick="exibirTabela(2)">Concluídos</a>
</div>
</div>
<br>
		<div class="container-fluid">
        <div class="table-responsive">
        <table class="table nowrap" id="tb_completa" style="width:100%;">
                    <thead>
                        <tr class="bg-secondary">
                            <th class="text-center">Requisição</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Solicitante</th>
                            <th class="text-center">Grupo</th>
                            <th class="text-center">Data Solicitação</th>
                            <th class="text-center">Serviço</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        
                        $qry = $conn->query("SELECT r.*, p.status,p.req_requisitante,req_grupo FROM `receiving_list` r
                        INNER JOIN purchase_order_list p ON r.form_id = p.id
                        WHERE (r.estado_requisicao = 3 and req_aprov2 = 1 and p.etapa_mat_ou_ser = 0 and total_aprov <= 2000.00)
                        OR (r.estado_requisicao = 3 and req_aprov2 = 1 and p.etapa_mat_ou_ser = 0 and not nome_aprovacao2 = '' and total_aprov between 2000.01 and 9000000.00) /* ferias ERA 2.000.01 A 10000 */
                        OR (r.estado_requisicao = 3 and req_aprov2 = 1 and p.etapa_mat_ou_ser = 0 and not nome_aprovacao2 = '' and not nome_aprovacao3 = '' and total_aprov >= 9000000.01)");
    
                        while($row = $qry->fetch_assoc()):
                            $row['items'] = explode(',',$row['stock_ids']);
                            if($row['from_order'] == 1){
                                $code = $conn->query("SELECT po_code from `purchase_order_list` where id='{$row['form_id']}'")->fetch_assoc()['po_code'];
                            }else{
                                $code = $conn->query("SELECT bo_code from `back_order_list` where id='{$row['form_id']}'")->fetch_assoc()['bo_code'];
                            } ?>

                            <tr>
                                <td class="text-center"><?php echo $code ?></td>

                                <!-- <td class="text-right"><.?php echo number_format(count($row['items'])) ?></td> -->

                                <td class="text-center">
                                <?php if ($row['estado_requisicao'] == 3) : ?>
                                <span class="badge badge-warning rounded-pill">Aguardando informações</span>

                                <?php elseif ($row['estado_requisicao'] == 6) : ?>
                                <span class="badge badge-success rounded-pill">Concluída</span>

                                <?php endif; ?>
                                </td>

                                <td class="text-center"><?php echo $row['req_requisitante'] ?></td>

                                <td class="text-center">
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

                                <td class="text-center"><?php echo date("d-m-Y H:i",strtotime($row['date_created'])) ?></td>
                                
                                <td align="center">
                                <a class="dropdown-item bg-warning" href="<?php echo base_url.'admin?page=receiving/manage_servico&id='.$row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-black"></span></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>


                <table class="table nowrap" id="tb_completa2" style="width:100%;">
                    <thead>
                        <tr class="bg-success">
                            <th class="text-center">Requisição</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Solicitante</th>
                            <th class="text-center">Grupo</th>
                            <th class="text-center">Data Solicitação</th>
                            <th class="text-center">Visualizar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $qry = $conn->query("SELECT r.*, p.status,p.req_requisitante,req_grupo FROM `receiving_list` r
                        INNER JOIN purchase_order_list p ON r.form_id = p.id
                        WHERE (r.estado_requisicao = 6 and r.etapa_financeiro = 1 and r.req_aprov3 = 1)");
 
                        while($row = $qry->fetch_assoc()):
                            $row['items'] = explode(',',$row['stock_ids']);
                            if($row['from_order'] == 1){
                                $code = $conn->query("SELECT po_code from `purchase_order_list` where id='{$row['form_id']}'")->fetch_assoc()['po_code'];
                            }else{
                                $code = $conn->query("SELECT bo_code from `back_order_list` where id='{$row['form_id']}'")->fetch_assoc()['bo_code'];
                            } ?>

                            <tr>
                                <td class="text-center"><?php echo $code ?></td>

                                <!-- <td class="text-right"><.?php echo number_format(count($row['items'])) ?></td> -->

                                <td class="text-center">
                                <?php if ($row['estado_requisicao'] == 3) : ?>
                                <span class="badge badge-warning rounded-pill">Aguardando informações</span>

                                <?php elseif ($row['estado_requisicao'] == 6) : ?>
                                <span class="badge badge-success rounded-pill">Concluída</span>

                                <?php endif; ?>
                                </td>

                                <td class="text-center"><?php echo $row['req_requisitante'] ?></td>

                                <td class="text-center">
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

                                <td class="text-center"><?php echo date("d-m-Y H:i",strtotime($row['date_created'])) ?></td>
                                
                                <td align="center">
                                <a class="dropdown-item" href="<?php echo base_url.'admin?page=servico/servico_visu&id='.$row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-black"></span></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                
                </div>
		</div> <!-- fluid -->
	</div> <!-- body -->
</div> <!-- card -->



<script>
$( document ).ready(function() {
$('#tb_completa').DataTable({
                order: [0, 'desc'],
                language: {
                    url: 'http://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
                }
            });
        });

function exibirTabela(tabela) {
        if (tabela === 1) {
            document.getElementById('tb_completa').style.display = 'table';
            document.getElementById('tb_completa2').style.display = 'none';
            document.getElementById('btnTabela1').disabled = true;
            document.getElementById('btnTabela2').disabled = false;

            // Destruir a instância do DataTable da tabela 2 (caso exista)
            if ($.fn.DataTable.isDataTable('#tb_completa2')) {
                $('#tb_completa2').DataTable().destroy();
            }

            if ($.fn.DataTable.isDataTable('#tb_completa')) {
                $('#tb_completa').DataTable().destroy();
            }

            // Inicializar o DataTable para a tabela 1
            $('#tb_completa').DataTable({
                order: [0, 'desc'],
                language: {
                    url: 'http://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
                }
            });
        } else if (tabela === 2) {
            document.getElementById('tb_completa').style.display = 'none';
            document.getElementById('tb_completa2').style.display = 'table';
            document.getElementById('btnTabela1').disabled = false;
            document.getElementById('btnTabela2').disabled = true;

            // Destruir a instância do DataTable da tabela 1 (caso exista)
            if ($.fn.DataTable.isDataTable('#tb_completa')) {
                $('#tb_completa').DataTable().destroy();
            }

            if ($.fn.DataTable.isDataTable('#tb_completa2')) {
                $('#tb_completa2').DataTable().destroy();
            }

            // Inicializar o DataTable para a tabela 2
            $('#tb_completa2').DataTable({
                order: [0, 'desc'],
                language: {
                    url: 'http://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
                }
            });
        }
    }
</script>
