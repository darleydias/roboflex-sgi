<?php include_once('datatable/tabelas.php'); ?>

<div class="card card-outline card-primary">
	<div class="card-header">
		<h4 class="text-center padding">Lista de Fornecedores</h4>
		<!-- <div class="card-tools">
			<a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Adicionar novo</a>
		</div> -->
		<div class="card-tools">
		</div>
	</div>

	<style>
		table 
{
    table-layout:fixed;
    width:100%;
}
	</style>

	<div class="card-body">
		<div class="container-fluid">
			<div class="container-fluid">
				<table class="table table-bordered table-striped table-hover nowrap" id="tb_item">
				<colgroup>
						<col width="5%">
						<col width="10%">
						<col width="10%">
						<col width="10%">
						<col width="15%">
						<col width="10%">
						<col width="10%">
						<col width="10%">
					</colgroup>
				<thead>
						<tr>
							<th>#</th>
							<th>Nome</th>
							<th>Pessoa Contato</th>
							<th>Telefone</th>
							<th>Email</th>
							<th>Criação</th>
							<th>Status</th>
							<th>Funções</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						$qry = $conn->query("SELECT f.*
						from `fornecedor_list` f");
						while ($row = $qry->fetch_assoc()) :
						?>
							<tr>
								<td class="text-center"><?php echo $i++; ?></td>
								<td><?php echo $row['name'] ?></td>
								<td><?php echo $row['pessoa_fornecedor'] ?></td>
								<td><?php echo $row['tel_fornecedor'] ?></td>
								<td><?php echo $row['email_fornecedor'] ?></td>
								<td><?php echo date("d-m-Y H:i", strtotime($row['date_created'])) ?></td>
								<td class="text-center">
									<?php if ($row['status'] == 1) : ?>
										<span class="badge badge-success rounded-pill">Ativo</span>
									<?php else : ?>
										<span class="badge badge-danger rounded-pill">Inativo</span>
									<?php endif; ?>
								</td>
								<td>
									<button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
										Ação
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<div class="dropdown-menu" role="menu">
										<a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> Visualizar</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Editar</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Deletar</a>
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
		<a onclick="window.location='<?php echo base_url ?>admin/?page=inclusao_fornecedor'" 
		class="btn btn-flat btn-primary"><span class="fas fa-backward"></span> Voltar</a> <br><br>

	</div>
</div>
<script>
	$(document).ready(function() {
		$('.delete_data').click(function() {
			_conf("Tem certeza que deseja deletar este Fornecedor permanentemente?", "delete_category", [$(this).attr('data-id')])
		})
		$('#create_new').click(function() {
			uni_modal("<i class='fa fa-plus'></i> Adicionar novo Fornecedor", "maintenance/manage_fornecedor.php", "mid-large")
		})
		$('.edit_data').click(function() {
			uni_modal("<i class='fa fa-edit'></i> Editar Fornecedor", "maintenance/manage_fornecedor.php?id=" + $(this).attr('data-id'), "mid-large")
		})
		$('.view_data').click(function() {
			uni_modal("<i class='fa fa-box'></i> Detalhes do Fornecedor", "maintenance/view_fornecedor.php?id=" + $(this).attr('data-id'), "")
		})
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