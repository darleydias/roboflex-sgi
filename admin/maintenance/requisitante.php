<?php include_once('datatable/tabelas.php'); ?>

<div class="card card-outline card-danger">
	<div class="card-header">
		<h4 class="text-center padding">Requisitantes</h4>
		<div class="card-tools">
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<div class="container-fluid">
				<table class="table table-bordered table-striped table-hover" id="tb_tipo">
					<colgroup>
						<col width="5%">
						<col width="20%">
						<col width="25%">
						<col width="15%">
						<col width="15%">
					</colgroup>
					<thead>
						<tr>
							<th>#</th>

							<th>Requisitante</th>
							<th>Data de Criação</th>
							<th>Status</th>
							<th>Funções</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						$qry = $conn->query("SELECT * from `requisitante_list`  order by `name` asc ");
						while ($row = $qry->fetch_assoc()) :
						?>
							<tr>
								<td class="text-center"><?php echo $i++; ?></td>
								<td><?php echo $row['name'] ?></td>
								<td><?php echo date("d-m-Y H:i", strtotime($row['date_created'])) ?></td>

								<!-- <td class=""><.?php echo $row['cperson'] ?></td> -->
								<td class="text-center">
									<?php if ($row['status'] == 1) : ?>
										<span class="badge badge-success rounded-pill">Ativo</span>
									<?php else : ?>
										<span class="badge badge-danger rounded-pill">Inativo</span>
									<?php endif; ?>
								</td>
								<td align="center">
									<button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
										Opção
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<div class="dropdown-menu" role="menu">
										<!-- 				                <a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> Visualizar</a> -->
										<!-- <div class="dropdown-divider"></div> -->
										<a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Editar</a>
										<!-- <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<.?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Deletar</a> -->
									</div>
								</td>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="center">
		<a onclick="window.location='<?php echo base_url ?>admin/?page=inclusao_diversa'" 
		class="btn btn-flat btn-info"><span class="fas fa-backward"></span> Voltar</a> <br> <br>
	</div>

</div>

<script>
	$(document).ready(function() {

		/* $('.delete_data').click(function(){
			_conf("Você tem certeza que deseja excluir essa categoria","delete_category",[$(this).attr('data-id')])
		}) */

		/* $('#create_new').click(function(){
			uni_modal("<i class='fa fa-plus'></i> Adicionar nova categoria","maintenance/manage_supplier.php","mid-large")
		}) */

		$('.edit_data').click(function() {
			uni_modal("<i class='fa fa-edit'></i> Editar", "maintenance/manage_requisitante.php?id=" + $(this).attr('data-id'), "mid-large")
		})

		/* $('.view_data').click(function(){
			uni_modal("<i class='fa fa-truck-loading'></i> Detalhes da categoria","maintenance/view_supplier.php?id="+$(this).attr('data-id'),"")
		}) */
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable();
	})

	function delete_category($id) {
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Master.php?f=delete_item",
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