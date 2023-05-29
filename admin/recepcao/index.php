<?php include_once ('datatable\tabelas.php'); ?>
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
<div class="card card-outline card-danger">
	<div class="card-header">
		<h4 class="text-center padding">Recepção</h4>
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
			<table class="table nowrap" id="tb_completa" style="width: 100%;">
                    <thead>
                        <tr class="bg-danger">
                            <th class="text-center">Requisição</th>
                            <th class="text-center">Solicitante</th>
                            <th class="text-center">Requisitante</th>
                            <th class="text-center">Grupo</th>
                            <th class="text-center">Qtde de Itens</th>
                            <th class="text-center">NF em Aberto</th>
                            <th class="text-center">Receber</th>
                            <th class="text-center">FORNECEDOR BUSCAR</th>
                        </tr>
                    </thead>
                        <tbody>
                        <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT r.*, p.status, p.req_requisitante, p.req_grupo, s.pedido_omie, p.req_solicitante, s.cotacao_1_0
                        FROM `receiving_list` r
                        INNER JOIN purchase_order_list p ON r.form_id = p.id
                        INNER JOIN po_items q ON q.po_id = p.id
                        INNER JOIN stock_list s ON s.item_id = q.item_id
                        WHERE r.estado_requisicao = 4 AND r.etapa_omie = 1
                        OR (r.estado_requisicao = 5 AND r.recepcao_final is null OR r.recepcao_final = 0)
                        GROUP BY p.id"); 
                        while($row = $qry->fetch_assoc()):
                            $row['items'] = explode(',',$row['stock_ids']);
                            if($row['from_order'] == 1){
                                $code = $conn->query("SELECT po_code from `purchase_order_list` where id='{$row['form_id']}'")->fetch_assoc()['po_code'];
                            } ?>
                            <tr> 
                                <td class="text-center"><?php echo $code ?>
                                </td>

                                <td class="text-center"><?php echo $row['req_requisitante'] ?>
                                </td>

                                <td class="text-center"><?php echo $row['req_solicitante'] ?>
                                </td>
                            
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

                                <td class="text-center"><?php echo number_format(count($row['items'])) ?>
                                </td>
                              
<td class="align-middle text-center">
<?php
$stock_ids = explode(',', $row['stock_ids']);
$count = 0; // começa
foreach ($stock_ids as $stock_id) {
    $qry2 = $conn->query("SELECT notafiscal_rec FROM stock_list WHERE id = {$stock_id} AND notafiscal_rec = 0");
    $notafiscal_row = $qry2->fetch_assoc();
    if (isset($notafiscal_row['notafiscal_rec'])) {
        $count++; //
        /* echo $notafiscal_row['notafiscal_rec'] . ', '; */
    }
} ?>
<strong> <?php echo $count; ?></strong>
</td>

                                <td class="text-center">
                                <a class="dropdown-item bg-warning" href="<?php echo base_url.'admin?page=receiving/manage_recepcao&id='.$row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-black"></span></a>
                                </td>

                                <td>
                                <?php
                                $stock_ids = explode(',', $row['stock_ids']);
                                foreach ($stock_ids as $stock_id) {
                                $qry1 = $conn->query("SELECT cotacao_1_0 FROM stock_list WHERE id = {$stock_id}");
                                $cotacao_row = $qry1->fetch_assoc();
                                if (isset($cotacao_row['cotacao_1_0'])) {
                                echo $cotacao_row['cotacao_1_0'] . ', ';
                                }
                                } ?>
                                </td>
                                
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>


                <table class="table nowrap" id="tb_completa2" style="width: 100%;">
                    <thead>
                        <tr class="bg-success">
                            <th class="text-center">Requisição</th>
                            <th class="text-center">Solicitante</th>
                            <th class="text-center">Requisitante</th>
                            <th class="text-center">Grupo</th>
                            <th class="text-center">Visualizar</th>
                            <th class="text-center">FORNECEDOR BUSCAR</th>
                        </tr>
                    </thead>
                        <tbody>
                        <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT r.*, p.status, p.req_requisitante, p.req_grupo, s.pedido_omie, p.req_solicitante, s.cotacao_1_0
                        FROM `receiving_list` r
                        INNER JOIN purchase_order_list p ON r.form_id = p.id
                        INNER JOIN po_items q ON q.po_id = p.id
                        INNER JOIN stock_list s ON s.item_id = q.item_id
                        WHERE r.recepcao_final = 1
                        GROUP BY p.id"); 
                        while($row = $qry->fetch_assoc()):
                            $row['items'] = explode(',',$row['stock_ids']);
                            if($row['from_order'] == 1){
                                $code = $conn->query("SELECT po_code from `purchase_order_list` where id='{$row['form_id']}'")->fetch_assoc()['po_code'];
                            } ?>
                            <tr> 
                                <td class="text-center"><?php echo $code ?>
                                </td>

                                <td class="text-center"><?php echo $row['req_requisitante'] ?>
                                </td>

                                <td class="text-center"><?php echo $row['req_solicitante'] ?>
                                </td>
                            
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

                              


                                <td class="text-center">
                                    <span>Não disponível</span>
                                <!-- <a class="dropdown-item bg-warning" href="<?php echo base_url.'admin?page=receiving/manage_recepcao&id='.$row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-black"></span></a> -->
                                </td>

                                <td>
                                <?php
                                $stock_ids = explode(',', $row['stock_ids']);
                                foreach ($stock_ids as $stock_id) {
                                $qry1 = $conn->query("SELECT cotacao_1_0 FROM stock_list WHERE id = {$stock_id}");
                                $cotacao_row = $qry1->fetch_assoc();
                                if (isset($cotacao_row['cotacao_1_0'])) {
                                echo $cotacao_row['cotacao_1_0'] . ', ';
                                }
                                } ?>
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
	$(document).ready(function(){
		$('.view_details').click(function(){
			uni_modal("Detalhes","receiving/view_receiving.php?id="+$(this).attr('data-id'),'mid-large')
		});

      $('#tb_completa').DataTable({
		order: [ 0, 'desc' ],
        "columnDefs": [
        {
        "targets": 7, // FORNECEDOR BUSCAR
        visible: false,
         },
        ],
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
                order: [ 0, 'desc' ],
                "columnDefs": [
        {
        "targets": 7, // FORNECEDOR BUSCAR
        visible: false,
         },
        ],
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
                order: [ 0, 'desc' ],
        "columnDefs": [
        {
        "targets": 5, // FORNECEDOR BUSCAR
        visible: false,
         },
        ],
                language: {
                    url: 'http://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
                }
            });
        }
    }
</script>