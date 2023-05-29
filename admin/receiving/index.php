<?php include_once ('datatable\tabelas.php'); ?>


<style>
body{
zoom: 90%;
}

table#tb_completa.dataTable tbody tr:hover {
  background-color: #ffa;
}

</style>
<div class="card card-outline card-dark">
	<div class="card-header">
		<h4 class="text-center padding">Requisições Finalizadas</h4>
        <!-- <div class="card-tools">
			<a href="<.?php echo base_url ?>admin/?page=requisicoes/solicitacao_material" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Novo</a>
		</div> -->
	</div>
	<div class="card-body">
		<div class="container-fluid">
            <div class="table-responsive">
			<table class="table nowrap" id="tb_completa">
                    <thead>
                        <tr class="bg-dark">
                            <th class="text-center">Requisição</th>
                            <th class="text-center">Material / Serviço</th>
                            <th class="text-center">Requisitante</th>
                            <th class="text-center">Grupo</th>
                            <th class="text-center">Data Requisição</th>

                            <th class="text-center">Pedido Omie</th>

                            <th class="text-center">Visualizar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT r.*, p.status, p.req_requisitante, p.req_grupo,s.pedido_omie FROM `receiving_list` r
                        INNER JOIN purchase_order_list p ON r.form_id = p.id
                        INNER JOIN po_items q ON q.po_id = p.id
                        INNER JOIN stock_list s ON s.item_id = q.item_id
                        WHERE r.estado_requisicao = 4 or r.estado_requisicao = 5
                        GROUP BY p.id");
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

                                <!-- <td class="text-right"><?php echo number_format(count($row['items'])) ?></td> -->
                                <td class="text-center">
                                <?php if ($row['etapa_mat_ou_ser2'] == 0) : ?>
                                <span class="badge badge-primary rounded-pill">SERVIÇO</span>

                                <?php elseif ($row['etapa_mat_ou_ser2'] == 1) : ?>
                                <span class="badge badge-warning rounded-pill">MATERIAL</span>

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

                                <td class="text-center">
                                                <?php echo $row['pedido_omie']?>
                                            </td>

                                <td class="text-center">

                                <a class="dropdown-item" href="<?php echo base_url.'admin?page=receiving/view_receiving&id='.$row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-black"></span></a>
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
		$('.delete_data').click(function(){
			_conf("Você tem certeza que deseja deletar essa requisição ?","delete_receiving",[$(this).attr('data-id')])
		})
		$('.view_details').click(function(){
			uni_modal("Detalhes","receiving/view_receiving.php?id="+$(this).attr('data-id'),'mid-large')
		})

        $('#tb_completa').DataTable({
		 order: [ 0, 'desc' ],
		language: {
			url: 'http://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
		}
	});

	});
    
	function delete_receiving($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_receiving",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("Ocorreu um erro.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("Ocorreu um erro.",'error');
					end_loader();
				}
			}
		})
	}
</script>