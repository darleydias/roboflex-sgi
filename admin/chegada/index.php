<?php include_once ('datatable\tabelas.php'); ?>

<div class="card card-outline card-secondary">
	<div class="card-header">
		<h4 class="text-center padding">Recebimentos Pendentes</h4>
        <!-- <div class="card-tools">
			<a href="<.?php echo base_url ?>admin/?page=requisicoes/solicitacao_material" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Novo</a>
		</div> -->
	</div>
	<div class="card-body">


    <div class="row justify-content-around">
        <div class="form col-sm-6 col-md-3">
		<a style="width:100%;" onclick="window.location='<?php echo base_url ?>admin/?page=chegada/chegada_aprov'" class="btn btn-flat btn-success">Entregas Finalizadas <span class="fas fa-circle-check"></span></a>
	    </div>
    </div> <!-- row -->
<br>

		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-stripped" id="tb_completa">
                    <colgroup>
                        <col width="5%">
                        <col width="10%">
                        <col width="10%">
                        <col width="15%">
                        <col width="10%">
                        <col width="10%">
                    </colgroup>
                    <thead>
                        <tr class="bg-secondary" >
                            <th>#</th>
                            <th>Requisição</th>
                            <th>Itens</th>
                            <th>Data Criação</th>
                            <th>Status</th>
                            <th class="text-center">Recebimento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT r.*, p.status FROM `receiving_list` r
                        INNER JOIN purchase_order_list p ON r.form_id = p.id
                        WHERE r.estado_requisicao = 4
                        order by `date_created` desc");
                        while($row = $qry->fetch_assoc()):
                            $row['items'] = explode(',',$row['stock_ids']);
                            if($row['from_order'] == 1){
                                $code = $conn->query("SELECT po_code from `purchase_order_list` where id='{$row['form_id']}'")->fetch_assoc()['po_code'];
                            }else{
                                $code = $conn->query("SELECT bo_code from `back_order_list` where id='{$row['form_id']}'")->fetch_assoc()['bo_code'];
                            }
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $i++; ?></td>
                                <td><?php echo $code ?></td>
                                <td class="text-right"><?php echo number_format(count($row['items'])) ?></td>
                                <td><?php echo date("d-m-Y H:i",strtotime($row['date_created'])) ?></td>
                                <td class="text-center">
                                    <?php if($row['status'] == 0): ?>
                                        <span class="badge badge-primary rounded-pill">Pendente</span>
                                    <?php elseif($row['status'] == 1): ?>
                                        <span class="badge badge-warning rounded-pill">Aprovado parcialmente</span>
                                        <?php elseif($row['status'] == 2): ?>
                                        <span class="badge badge-success rounded-pill">Aprovado</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger rounded-pill">N/A</span>
                                    <?php endif; ?>
                                </td>
                                <td align="center">
                                <a class="dropdown-item" href="<?php echo base_url.'admin?page=receiving/manage_chegada&id='.$row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-black"></span></a>

                                    <!-- <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            Ação
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item" href="<?php echo base_url.'admin?page=receiving/view_receiving&id='.$row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> Visualizar</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="<?php echo base_url.'admin?page=receiving/manage_chegada&id='.$row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> NF e Data</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Deletar</a>
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
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable();
	})
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