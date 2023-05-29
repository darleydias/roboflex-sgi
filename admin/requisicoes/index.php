<style>
body{
zoom: 90%;
}

table#tb_completa.dataTable tbody tr:hover,
table#tb_completa2.dataTable tbody tr:hover,
table#tb_completa3.dataTable tbody tr:hover{
  background-color: #ffa;
}

#tb_completa2,
#tb_completa3 {
display: none;
}

</style>
<div class="card card-outline card-info">
	<div class="card-header">
		<h4 class="text-center padding">Aprovações</h4>
	</div>
	<div class="card-body">

    <div class="row justify-content-around">
<div>
<a id="btnTabela1" class="btn btn-warning" onclick="exibirTabela(1)">Pendentes</a>
</div>
<div>
<a id="btnTabela2" class="btn btn-success" onclick="exibirTabela(2)">Aprovadas</a>
</div>
<div>
<a id="btnTabela3" class="btn btn-danger" onclick="exibirTabela(3)">Recusadas</a>
</div>
</div>
<br>


        <div class="container-fluid">
            <div class="table-responsive">
			<table class="table nowrap" id="tb_completa" style="width: 100%;">
                    <thead>
                    <tr class="bg-info">
                            <th class="text-center">Requisição</th>
                            <th class="text-center">Material / Serviço</th>
                            <th class="text-center">Solicitante</th>
                            <th class="text-center">Grupo</th>
                            <th class="text-center">Aprovações necessárias</th>
                            <th class="text-center">Quem já aprovou</th>
                            <th class="text-center">Data</th>
                            <th class="text-center">Aprovação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT r.*, p.status, p.req_requisitante, p.req_grupo FROM `receiving_list` r
                        INNER JOIN purchase_order_list p ON r.form_id = p.id
                        WHERE (r.estado_requisicao = 2 AND r.total_aprov <= 2000.00)
                        OR (r.total_aprov between 2000.01 AND 9000000.00 AND nome_aprovacao2 = '')
                        OR (r.total_aprov >= 9000000.01 AND (nome_aprovacao2 = '' OR nome_aprovacao3 = ''))");
                        while($row = $qry->fetch_assoc()):
                            $row['items'] = explode(',',$row['stock_ids']);
                            if($row['from_order'] == 1){
                                $code = $conn->query("SELECT po_code from `purchase_order_list` where id='{$row['form_id']}'")->fetch_assoc()['po_code'];
                            }else{
                                $code = $conn->query("SELECT bo_code from `back_order_list` where id='{$row['form_id']}'")->fetch_assoc()['bo_code'];
                            }
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $code ?></td>
                                <!-- <td class="text-right"><.?php echo number_format(count($row['items'])) ?></td> -->

                                <td class="text-center">
                                <?php if ($row['etapa_mat_ou_ser2'] == 0) : ?>
                                <span class="badge bg-blue rounded-pill">SERVIÇO</span>

                                <?php elseif ($row['etapa_mat_ou_ser2'] == 1) : ?>
                                <span class="badge bg-warning rounded-pill">MATERIAL</span>

                                <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <?php echo $row['req_requisitante'] ?>
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
<?php 
if ($row['total_aprov'] <= 2000.00) {
    echo 'Necessária 1ª Aprovação';
} elseif ($row['total_aprov'] >= 2000.01 && $row['total_aprov'] <= 9000000.00) {
    echo '2 Aprovações';
} elseif ($row['total_aprov'] >= 9000000.01 ) {
    echo '3 Aprovações';
}
?>
</td>


<td class="text-center">
<?php 
if (empty($row['nome_aprovacao'])) {
}
else{
echo $row['nome_aprovacao'], ', ' ,$row['nome_aprovacao2'], ',<br>' ,$row['nome_aprovacao3'];
}
?>
</td>

<td class="text-center"><?php echo date("d-m-Y H:i",strtotime($row['date_created'])) ?></td>

<td class="text-center">
  <?php if($row['total_aprov'] <= 2000.00) { ?>
    <a class="dropdown-item bg-warning" href="#" data-url="<?php echo base_url.'admin?page=receiving/manage_aprovacao&id='.$row['id'] ?>" data-id="<?php echo $row['id'] ?>">
      <span class="fa fa-edit text-black"></span>
    </a>
  <?php } else { ?>
    <a class="dropdown-item bg-warning" href="#" data-url="<?php echo base_url.'admin?page=receiving/manage_aprovacao2&id='.$row['id'] ?>" data-id="<?php echo $row['id'] ?>">
      <span class="fa fa-edit text-black"></span>
    </a>
  <?php } ?>
</td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>




                <table class="table nowrap" id="tb_completa2" style="width:100%;">
                    <thead>
                    <tr class="bg-success table-active">
                            <th class="text-center">Requisição</th>
                            <th class="text-center">Material / Serviço</th>
                            <th class="text-center">Solicitante</th>
                            <th class="text-center">Grupo</th>
                            <th class="text-center">Data Solicitação</th>
                            <th class="text-center">Aprovação</th>
                            <th class="text-center">Valor Total</th>
                            <th class="text-center">Autorização</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT r.*, p.status, p.req_requisitante, p.req_grupo FROM `receiving_list` r INNER JOIN purchase_order_list p ON r.form_id = p.id
                        WHERE (r.etapa_aprovacao = 1 and req_aprov2 = 1 and total_aprov <= 2000.00)
                        OR (r.etapa_aprovacao = 1 and req_aprov2 = 1 and not nome_aprovacao2 = '' and total_aprov between 2000.01 and 9000000.00)
                        OR (r.etapa_aprovacao = 1 AND req_aprov2 = 1 AND estado_requisicao != 2 AND estado_requisicao != 3)
                        OR (r.etapa_aprovacao = 1 and req_aprov2 = 1 and not nome_aprovacao2 = '' and not nome_aprovacao3 = '' and total_aprov >= 9000000.01)");
                        while($row = $qry->fetch_assoc()):
                            if($row['from_order'] == 1){
                                $code = $conn->query("SELECT po_code from `purchase_order_list` where id='{$row['form_id']}'")->fetch_assoc()['po_code'];
                            }else{
                                $code = $conn->query("SELECT bo_code from `back_order_list` where id='{$row['form_id']}'")->fetch_assoc()['bo_code'];
                            }
                        ?>
                            <tr>

                                <td class="text-center"><?php echo $code ?></td>
                                <td class="text-center">
                                <?php if ($row['etapa_mat_ou_ser2'] == 0) : ?>
                                <span class="badge bg-blue rounded-pill">SERVIÇO</span>
                                <?php elseif ($row['etapa_mat_ou_ser2'] == 1) : ?>
                                <span class="badge bg-warning rounded-pill">MATERIAL</span>
                                <?php endif; ?> </td>

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

                                <td class="text-center">
                                <?php 
if (empty($row['nome_aprovacao']) && empty($row['nome_aprovacao2']) || empty($row['nome_aprovacao3'])) {
echo $row['nome_aprovacao'];
}
else{
echo $row['nome_aprovacao'], ', ' ,$row['nome_aprovacao2'], ', <br>' ,$row['nome_aprovacao3'];
}
?>
                                </td>

<td class="text-center">
    <?php echo 'R$ ' . number_format($row['total_aprov'], 2, ',', '.'); ?>
</td>

                                <td align="center">
                                <a class="dropdown-item" href="<?php echo base_url.'admin?page=requisicoes/aprovacao_visu&id='.$row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-black"></span></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>



                 <table class="table nowrap" id="tb_completa3" style="width:100%">
                    <thead>
                    <tr class="bg-danger table-active">
                            
                            <th class="text-center">Requisição</th>
                            <th class="text-center">Material / Serviço</th>
                            <th class="text-center">Solicitante</th>
                            <th class="text-center">Grupo</th>
                            <th class="text-center">Data Solicitação</th>
                            <th class="text-center">Autorização</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT r.*, p.status, p.req_requisitante, p.req_grupo FROM `receiving_list` r INNER JOIN purchase_order_list p ON r.form_id = p.id
                        WHERE r.etapa_aprovacao = 1 and r.req_aprov2 = 0 order by `date_created` desc");
                        while($row = $qry->fetch_assoc()):
                            if($row['from_order'] == 1){
                                $code = $conn->query("SELECT po_code from `purchase_order_list` where id='{$row['form_id']}'")->fetch_assoc()['po_code'];
                            }else{
                                $code = $conn->query("SELECT bo_code from `back_order_list` where id='{$row['form_id']}'")->fetch_assoc()['bo_code'];
                            }
                        ?>
                            <tr>
                               
                                <td class="text-center"><?php echo $code ?></td>
                                <td class="text-center">
                                <?php if ($row['etapa_mat_ou_ser2'] == 0) : ?>
                                <span class="badge bg-blue rounded-pill">SERVIÇO</span>
                                <?php elseif ($row['etapa_mat_ou_ser2'] == 1) : ?>
                                <span class="badge bg-warning rounded-pill">MATERIAL</span>
                                <?php endif; ?> </td>

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

                                <a class="dropdown-item" href="<?php echo base_url.'admin?page=requisicoes/aprovacao_visu&id='.$row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-black"></span></a>
                                    <!-- <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            Ação
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item" href="<?php echo base_url.'admin?page=receiving/view_receiving&id='.$row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> Visualizar</a>
                                    </div> -->
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

        $('a.dropdown-item.bg-warning').click(function(e) {
      e.preventDefault();
      var url = $(this).data('url');
      window.location.href = url;
    });

		$('.delete_data').click(function(){
			_conf("Você tem certeza que deseja deletar essa requisição ?","delete_receiving",[$(this).attr('data-id')])
		});
		$('.view_details').click(function(){
			uni_modal("Detalhes","receiving/view_receiving.php?id="+$(this).attr('data-id'),'mid-large')
		});

        $('#tb_completa').DataTable({
		"columnDefs": [
    	{ "type": "date","targets": 6 }
    ],
		 order: [ 0, 'desc' ],
		language: {
			url: 'http://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
		}
	});
	});

    function exibirTabela(tabela) {
        if (tabela === 1) {
            document.getElementById('tb_completa').style.display = 'table';
            document.getElementById('tb_completa2').style.display = 'none';
            document.getElementById('tb_completa3').style.display = 'none';
            document.getElementById('btnTabela1').disabled = true;
            document.getElementById('btnTabela2').disabled = false;
            document.getElementById('btnTabela3').disabled = false;

            // Destruir a instância do DataTable da tabela (caso exista)
            if ($.fn.DataTable.isDataTable('#tb_completa')) {
                $('#tb_completa').DataTable().destroy();
            }
            if ($.fn.DataTable.isDataTable('#tb_completa2')) {
                $('#tb_completa2').DataTable().destroy();
            }
            if ($.fn.DataTable.isDataTable('#tb_completa3')) {
                $('#tb_completa3').DataTable().destroy();
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
            document.getElementById('tb_completa3').style.display = 'none';
            document.getElementById('tb_completa2').style.display = 'table';
            document.getElementById('btnTabela1').disabled = false;
            document.getElementById('btnTabela2').disabled = true;
            document.getElementById('btnTabela3').disabled = false;

            // Destruir a instância do DataTable da tabela (caso exista)
            if ($.fn.DataTable.isDataTable('#tb_completa')) {
                $('#tb_completa').DataTable().destroy();
            }
            if ($.fn.DataTable.isDataTable('#tb_completa2')) {
                $('#tb_completa2').DataTable().destroy();
            }
            if ($.fn.DataTable.isDataTable('#tb_completa3')) {
                $('#tb_completa3').DataTable().destroy();
            }

            // Inicializar o DataTable para a tabela 2
            $('#tb_completa2').DataTable({
                order: [0, 'desc'],
                language: {
                    url: 'http://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
                }
            });
        }

        else if (tabela === 3) {
            document.getElementById('tb_completa').style.display = 'none';
            document.getElementById('tb_completa2').style.display = 'none';
            document.getElementById('tb_completa3').style.display = 'table';
            document.getElementById('btnTabela1').disabled = false;
            document.getElementById('btnTabela2').disabled = false;
            document.getElementById('btnTabela3').disabled = true;

            // Destruir a instância do DataTable da tabela (caso exista)
            if ($.fn.DataTable.isDataTable('#tb_completa')) {
                $('#tb_completa').DataTable().destroy();
            }
            if ($.fn.DataTable.isDataTable('#tb_completa2')) {
                $('#tb_completa2').DataTable().destroy();
            }
            if ($.fn.DataTable.isDataTable('#tb_completa3')) {
                $('#tb_completa3').DataTable().destroy();
            }

            // Inicializar o DataTable para a tabela 3
            $('#tb_completa3').DataTable({
                order: [0, 'desc'],
                language: {
                    url: 'http://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
                }
            });
        }
    }
</script>