<?php include_once ('datatable/tabelas.php'); ?>


<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<style>
    .img-avatar{
        width:45px;
        height:45px;
        object-fit:cover;
        object-position:center center;
        border-radius:100%;
    }
</style>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Lista de Usuários</h3>
		<div class="card-tools">
			<a href="?page=user/manage_user" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Novo Usuário</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped" id="tb_usuarios">
				<!-- <colgroup>
					<col width="5%">
					<col width="10%">
					<col width="20%">
					<col width="20%">
					<col width="15%">
					<col width="15%">
					<col width="10%">
				</colgroup> -->
				<thead>
					<tr>
						<th>#</th>
						<th class="text-center">Foto</th>
						<th>Nome</th>
						<th>Usuário</th>
						<th class="text-center">Grupo</th>
						<th class="text-center">Funções</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						$qry = $conn->query("SELECT *,concat(firstname,' ',lastname) as name from `users` where id != '1' order by concat(firstname,' ',lastname) asc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><img src="<?php echo validate_image($row['avatar']) ?>" class="img-avatar img-thumbnail p-0 border-2" alt="user_avatar"></td>
							<td><?php echo ucwords($row['name']) ?></td>
							<td ><p class="m-0 truncate-1"><?php echo $row['username'] ?></p></td>
							<td >
							<p class="m-0">
<div class="text-center">
							<?php if($row['type'] == '1'): ?>
                            <span class="badge badge-primary rounded-pill">Administrador nível 1</span>

							<?php elseif($row['type'] == '2'): ?>
                            <span class="badge badge-primary rounded-pill">Administrador nível 2</span>

                            <?php elseif($row['type'] == '3'): ?>
                            <span class="badge badge-success rounded-pill">Autorização Operacional</span>
							
							<?php elseif($row['type'] == '4'): ?>
                            <span class="badge badge-success rounded-pill">Autorização Financeiro</span>

							<?php elseif($row['type'] == '5'): ?>
                            <span class="badge badge-success rounded-pill">Autorização Negócios</span>

							<?php elseif($row['type'] == '6'): ?>
                            <span class="badge badge-success rounded-pill">Autorização Administrativo</span>

							<?php elseif($row['type'] == '7'): ?>
                            <span class="badge badge-success rounded-pill">Autorização P&D</span>

							<?php elseif($row['type'] == '8'): ?>
                            <span class="badge badge-success rounded-pill">Autorização Assistência Téc.</span>

							<?php elseif($row['type'] == '9'): ?>
                            <span class="badge badge-success rounded-pill">Compras</span>

							<?php elseif($row['type'] == '10'): ?>
                            <span class="badge badge-success rounded-pill">Financeiro</span>

							<?php elseif($row['type'] == '11'): ?>
                            <span class="badge badge-warning rounded-pill">Requisição Operacional</span>

							<?php elseif($row['type'] == '12'): ?>
                            <span class="badge badge-warning rounded-pill">Requisição Administrativo</span>

							<?php elseif($row['type'] == '13'): ?>
                            <span class="badge badge-warning rounded-pill">Requisição Assistência Técnica</span>

							<?php elseif($row['type'] == '14'): ?>
                            <span class="badge badge-warning rounded-pill">Requisição P&D</span>

							<?php elseif($row['type'] == '15'): ?>
                            <span class="badge badge-warning rounded-pill">Requisição Negócios</span>

							<?php elseif($row['type'] == '16'): ?>
                            <span class="badge badge-warning rounded-pill">Requisição Financeiro</span>

							<?php elseif($row['type'] == '17'): ?>
                            <span class="badge badge-warning rounded-pill">Administrativo nível 2</span>

							<?php elseif($row['type'] == '18'): ?>
                            <span class="badge badge-warning rounded-pill">Compras Matérias-primas</span>

							<?php elseif($row['type'] == '25'): ?>
                            <span class="badge badge-danger rounded-pill">Apontamento Mecânica</span>

							<?php elseif($row['type'] == '26'): ?>
                            <span class="badge badge-danger rounded-pill">Apontamento Identificação</span>

							<?php elseif($row['type'] == '27'): ?>
                            <span class="badge badge-danger rounded-pill">Apontamento Elétrica</span>

							<?php elseif($row['type'] == '28'): ?>
                            <span class="badge badge-danger rounded-pill">Apontamento Finalização</span>

							<?php elseif($row['type'] == '29'): ?>
                            <span class="badge badge-danger rounded-pill">Apontamento Expedição</span>

							<?php elseif($row['type'] == '30'): ?>
                            <span class="badge badge-danger rounded-pill">Apontamento Eletrônica</span>
                            
							<?php elseif($row['type'] == '31'): ?>
                            <span class="badge badge-danger rounded-pill">Cadastro OP</span>

							<?php elseif($row['type'] == '35'): ?>
                            <span class="badge badge-danger rounded-pill">Recepção</span>

							<?php else : ?>
                            <span class="badge badge-danger rounded-pill">N/A</span>
                            <?php endif; ?>
</div>						
						</p>		
						</td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Ação
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item" href="?page=user/manage_user&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Editar</a>
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
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Você tem certeza que deseja deletar esse usuário permanentemente?","delete_user",[$(this).attr('data-id')])
		})
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable();
	})
	function delete_user($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Users.php?f=delete",
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