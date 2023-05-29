
<?php include_once('datatable\tabelas.php'); ?>


<style>
body{
zoom: 90%;
}

table#tb_ordem_aprov.dataTable tbody tr:hover {
  background-color: #ffa;
}
</style>

<div class="card card-outline card-danger">
    <div class="card-header">
        <h4 class="text-center padding">Autorizações Recusadas</h4>
        <!-- <div class="card-tools">
			<a href="<.?php echo base_url ?>admin/?page=requisicoes/solicitacao_material" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Novo</a>
		</div> -->
    </div> <!-- header -->
    <div class="card-body">
        <div class="container-fluid">
            

        <div>
        <i><strong>Mostrar/Ocultar colunas:</strong></i><br>
        
        <a class="toggle-vis btn btn-outline-danger btn-sm bt-disabled" data-column="0">Requisição</a>
        <a class="toggle-vis btn btn-outline-primary btn-sm" data-column="1">Material / Serviço</a>
        <a class="toggle-vis btn btn-outline-primary btn-sm" data-column="2">Requisitante</a>
        <a class="toggle-vis btn btn-outline-primary btn-sm" data-column="3">Grupo</a>
        <!-- <.?php echo $etapa_mat_ou_ser == 1 ? "" : "display:none;" ?> -->
        <a class="toggle-vis btn btn-outline-primary btn-sm" data-column="4">Observação</a>
        <a class="toggle-vis btn btn-outline-primary btn-sm" data-column="5">Observação Item</a>
        <a class="toggle-vis btn btn-outline-primary btn-sm" data-column="6">Fornecedor</a>
        <a class="toggle-vis btn btn-outline-primary btn-sm" data-column="7">Data Solicitação</a>
        <a class="toggle-vis btn btn-outline-primary btn-sm bt-disabled" data-column="7">Visualização</a>
        
        </div><br>

                <div class="table-responsive">
                <table class="table" id="tb_ordem_aprov" style="width: 100%;">
                    <thead>
                        <tr class="bg-danger table-active">
                            <th class="text-center">Requisição</th>
                            <th class="text-center">Material / Serviço</th>
                            <th class="text-center">Requisitante</th>
                            <th class="text-center">Grupo</th>
                            <th class="text-center">Observação Req.</th>
                            <th class="text-center">Observação Item</th>
                            <th class="text-center">Fornecedor</th>
                            <th class="text-center">Data Solicitação</th>
                            <th class="text-center">Visualização</th>
                        </tr>
                    </thead>
                    <tbody>

<!-- se for administrador -->
<?php if($_settings->userdata('user_adm') == 'ADM') : ?>

    <?php
                        $usuario_setor = $_settings->userdata('usuario_setor');
                        $i = 1;
                        $qry = $conn->query("SELECT r.form_id, p.*,r.data_autorizacao,i.obs_item,i.fornecedor_item
                        FROM `purchase_order_list` p
                        inner join receiving_list r on r.form_id = p.id
                        left join po_items i on i.po_id = p.id
                        WHERE r.req_aprov = 0 and etapa_autorizacao = 1
                        group by p.id");
                        while ($row = $qry->fetch_assoc()) : ?>
                            <tr>
                                <td style="width:150px;" class="text-center"><?php echo $row['po_code'] ?></td>
                               
                                <td class="text-center" style="min-width:120px;;">
                                <?php if ($row['etapa_mat_ou_ser'] == 0) : ?>
                                <span class="badge bg-blue rounded-pill">SERVIÇO</span>
                                <?php elseif ($row['etapa_mat_ou_ser'] == 1) : ?>
                                <span class="badge bg-warning rounded-pill">MATERIAL</span>
                                <?php endif; ?> </td>

                                <td class="text-center" style="min-width:150px;"><?php echo $row['req_requisitante'] ?></td>
                                
                                <td class="text-center" style="min-width: 150px;;">
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
                                <td style="min-width:400px;">
                                <div style="width:100%;">
                                 <?php echo $row['remarks']?>
                                 </div>
                                </td>

<td style="min-width:400px;">
<div style="width:100%;">
<?php echo $row['obs_item'] ?>
</div>
</td>

<td style="min-width: 200px;">
<div style="width:100%;">
<?php echo $row['fornecedor_item'] ?>
</div>  
</td>
                                <td class="text-center" style="min-width:150px"><?php echo date("d-m-Y H:i", strtotime($row['date_created'])) ?></td>
                                <td class="text-center align-middle" style="min-width: 100px;">
                                <a class="dropdown-item" href="<?php echo base_url . 'admin?page=autorizacao/autorizacao_visu&po_id=' . $row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-black"></span></a>                          
                            
                                </td>
                            </tr>
                        <?php endwhile; ?>

<!-- se não for -->
<?php else : ?>
<?php
                        $usuario_setor = $_settings->userdata('usuario_setor');
                        $i = 1;
                        $qry = $conn->query("SELECT r.form_id, p.*,r.data_autorizacao,i.obs_item,i.fornecedor_item
                        FROM `purchase_order_list` p
                        inner join receiving_list r on r.form_id = p.id
                        inner join po_items i on i.po_id = p.id
                        WHERE r.req_aprov = 0 and p.req_grupo = '$usuario_setor' and etapa_autorizacao = 1
                        group by p.id");
                        while ($row = $qry->fetch_assoc()) : ?>
                            <tr><td style="width:150px;" class="text-center"><?php echo $row['po_code'] ?></td>
                                <td class="text-center" style="min-width:120px;;">
                                <?php if ($row['etapa_mat_ou_ser'] == 0) : ?>
                                <span class="badge bg-blue rounded-pill">SERVIÇO</span>
                                <?php elseif ($row['etapa_mat_ou_ser'] == 1) : ?>
                                <span class="badge bg-warning rounded-pill">MATERIAL</span>
                                <?php endif; ?> </td>

                                <td class="text-center" style="min-width:150px;"><?php echo $row['req_requisitante'] ?></td>
                                
                                <td class="text-center" style="min-width: 150px;;">
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
                                <td style="min-width:400px;">
                                <div style="width:100%;">
                                 <?php echo $row['remarks']?>
                                 </div>
                                </td>

<td style="min-width:400px;">
<div style="width:100%;">
<?php echo $row['obs_item'] ?>
</div>
</td>

<td style="min-width: 200px;">
<div style="width:100%;">
<?php echo $row['fornecedor_item'] ?>
</div>  
</td>
                                <td class="text-center" style="min-width:150px"><?php echo date("d-m-Y H:i", strtotime($row['date_created'])) ?></td>
                                <td class="text-center align-middle" style="min-width: 100px;">
                                <a class="dropdown-item" href="<?php echo base_url . 'admin?page=autorizacao/autorizacao_visu&po_id=' . $row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-black"></span></a>                          
                            
                                </td>
                            </tr>
                        <?php endwhile; ?>
<?php endif; ?> 



                    </tbody>
                </table>
        </div>
        </div>
        </div>
    </div>
    <div class="center text-center">
		<a onclick="window.location='<?php echo base_url ?>admin/?page=autorizacao'" class="btn btn-outline-primary col-md-2"><strong> Voltar </strong></a>
	</div>
    <br>
    
</div>


<script>

 // INICIO DATATABLES

    $(document).ready(function() {
    var table = $('#tb_ordem_aprov').DataTable({
    /* scrollY: '200px', */
    /* paging: false, */
    pageLength: 9,
    order: [[0, 'desc']],
    "columnDefs": [
        {
        "targets": 4, // obs
        visible: false,
         },
         {
        "targets": 5, // obs item
        visible: false, 
         },
         {
         "targets": 6, // fornecedor
        visible: false, 
         },

],
    language: {
			url: 'http://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
		}
    });

    $('a.toggle-vis').on('click', function (e) {
    e.preventDefault();
 
    // Get the column API object
    var column = table.column($(this).attr('data-column'));

    // Toggle the visibility
    column.visible(!column.visible());

    });


    // FIM

        $('.delete_data').click(function() {
            _conf("Você tem certeza que deseja deletar essa Requisição de Entrada permanentemente ?", "delete_po", [$(this).attr('data-id')])
        })
        $('.view_details').click(function() {
            uni_modal("Detalhes", "transaction/view_payment.php?id=" + $(this).attr('data-id'), 'mid-large')
        })

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