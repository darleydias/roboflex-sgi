<?php include_once ('datatable/tabelas.php'); ?>

<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Registros de Saídas</h3>
        <div class="card-tools">
			<a href="<?php echo base_url ?>admin/?page=sales/manage_sale" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Nova</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-stripped" id="tb_saida">
                    <colgroup>
                        <col width="5%">
                        <col width="20%">
                        <col width="20%">
                        <col width="10%">
                        <col width="20%"> <!-- Total de itens -->
                        <col width="10%">
                        <!-- <col width="10%"> -->
                    </colgroup>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Solicitante</th>
                            <th>Total de itens</th>
                            <!-- <th>Total</th> -->
                            <th>Data Criação</th>
                            <th>Funções</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT * FROM `sales_list` order by `date_created` desc");
                        while($row = $qry->fetch_assoc()):
                            $row['items'] = count(explode(',',$row['stock_ids']));
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $i++; ?></td>
                                <td><?php echo $row['sales_code'] ?></td>
                                <td><?php echo $row['client'] ?></td>
                                <td class="text-right"><?php echo number_format($row['items']) ?></td>
                                <!-- <td class="text-right"><.?php echo number_format($row['amount'],2) ?></td> -->
                                <td><?php echo date("d-m-Y H:i",strtotime($row['date_created'])) ?></td>
                                <td align="center">
                                    <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            Ação
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item" href="<?php echo base_url.'admin?page=sales/view_sale&id='.$row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> Visualizar</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="<?php echo base_url.'admin?page=sales/manage_sale&id='.$row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Editar</a>
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
			_conf("Você tem certeza que deseja deletar esse registro de saída permanentemente?","delete_sale",[$(this).attr('data-id')])
		}) 
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable();
	})
	function delete_sale($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_sale",
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