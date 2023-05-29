
<?php include_once('datatable\tabelas.php'); ?>

<div class="card card-outline card-success">
    <div class="card-header">
        <h4 class="text-center padding">Recebidos</h4>
        <!-- <div class="card-tools">
			<a href="<.?php echo base_url ?>admin/?page=requisicoes/solicitacao_material" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Novo</a>
		</div> -->
    </div> <!-- header -->
    <div class="card-body">
        <div class="container-fluid">
            
                <table class="table table-bordered table-stripped" id="tb_ordem_aprov">
                    <thead>
                        <tr class="bg-success table-active">
                            <th>#</th>
                            <th>Código de Requisição</th>
                            <!-- <th>Categoria</th> -->
                            <th>Itens</th>
                            <th>Data Autorização</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Visualizar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT r.*, p.status FROM `receiving_list` r
                        INNER JOIN purchase_order_list p ON r.form_id = p.id
                        WHERE r.etapa_chegada = 1
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

                                <a class="dropdown-item" href="<?php echo base_url.'admin?page=chegada/chegada_visu&id='.$row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-black"></span></a>
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
<br>
    <div class="center text-center">
		<a onclick="window.location='<?php echo base_url ?>admin/?page=chegada'" class="btn btn-outline-primary col-md-2"><strong> Voltar </strong></a> <br><br>

	</div>
    
</div>


<script>
    $(document).ready(function() {
        $('.delete_data').click(function() {
            _conf("Você tem certeza que deseja deletar essa Requisição de Entrada permanentemente ?", "delete_po", [$(this).attr('data-id')])
        })
        $('.view_details').click(function() {
            uni_modal("Detalhes", "transaction/view_payment.php?id=" + $(this).attr('data-id'), 'mid-large')
        })
        $('.table td,.table th').addClass('py-1 px-2 align-middle')
        $('.table').dataTable();
    })

    function delete_po($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_po",
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