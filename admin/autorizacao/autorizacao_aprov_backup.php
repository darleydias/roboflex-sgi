
<?php include_once('datatable\tabelas.php'); ?>


<style>
body{
zoom: 90%;
}
</style>

<div class="card card-outline card-success">
    <div class="card-header">
        <h4 class="text-center padding">Autorizações Realizadas</h4>
        <!-- <div class="card-tools">
			<a href="<.?php echo base_url ?>admin/?page=requisicoes/solicitacao_material" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Novo</a>
		</div> -->
    </div> <!-- header -->
    <div class="card-body">
        <div class="container-fluid">
            
                <div class="table-responsive">
                <table class="table table-bordered table-stripped nowrap" id="tb_ordem_aprov">

                <colgroup>
                        <col width="5%">
                        <col width="10%">
                        <col width="10%">
                        <col width="15%">
                        <col width="15%">
                        <col width="15%">
                        <col width="15%">
                    </colgroup>

                    <thead>
                        <tr class="bg-blue table-active">
                            <th class="text-center">#</th>
                            <th class="text-center">Requisição</th>
                            <th class="text-center">Material / Serviço</th>
                            <th class="text-center">Requisitante</th>
                            <th class="text-center">Grupo</th>
                            <th class="text-center">Data Solicitação</th>
                            <th class="text-center">Visualização</th>
                        </tr>
                    </thead>
                    <tbody>
                                        <!-- Aprovação Operacional 3 -->
                    <?php if($_settings->userdata('type') == '3' || $_settings->userdata('type') == '1' || $_settings->userdata('type') == '2'): ?>
                        <?php
                        $i = 1;
                        $qry = $conn->query("SELECT r.form_id, p.*,r.data_autorizacao FROM `purchase_order_list` p
                        inner join receiving_list r on r.form_id = p.id WHERE p.req_grupo = 'Operacional' and r.req_aprov = 1 order by p.`date_created` desc");
                        while ($row = $qry->fetch_assoc()) :?>
                            <tr><td class="text-center"><?php echo $i++; ?></td>
                                <td><?php echo $row['po_code'] ?></td>

                                <td class="text-center">
                                <?php if ($row['etapa_mat_ou_ser'] == 0) : ?>
                                <span class="badge bg-blue rounded-pill">SERVIÇO</span>
                                <?php elseif ($row['etapa_mat_ou_ser'] == 1) : ?>
                                <span class="badge bg-warning rounded-pill">MATERIAL</span>
                                <?php endif; ?> </td>

                                <td><?php echo $row['req_requisitante'] ?></td>
                                
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

                                <td><?php echo date("d-m-Y H:i", strtotime($row['date_created'])) ?></td>
                                <td align="center">
                                <a class="dropdown-item" href="<?php echo base_url . 'admin?page=autorizacao/autorizacao_visu&po_id=' . $row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-black"></span></a>                          
                            
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <?php endif; ?>


                                 <!-- Aprovação Financeiro 4 -->
                        <?php if($_settings->userdata('type') == '4' || $_settings->userdata('type') == '1' || $_settings->userdata('type') == '2'): ?>
                        <?php
                        $i = 1;
                        $qry = $conn->query("SELECT r.form_id, p.*,r.data_autorizacao FROM `purchase_order_list` p
                        inner join receiving_list r on r.form_id = p.id WHERE p.req_grupo = 'Financeiro' and r.req_aprov = 1 order by p.`date_created` desc");
                        while ($row = $qry->fetch_assoc()) :?>
                            <tr><td class="text-center"><?php echo $i++; ?></td>
                                <td><?php echo $row['po_code'] ?></td>
                                <td class="text-center">
                                <?php if ($row['etapa_mat_ou_ser'] == 0) : ?>
                                <span class="badge bg-blue rounded-pill">SERVIÇO</span>
                                <?php elseif ($row['etapa_mat_ou_ser'] == 1) : ?>
                                <span class="badge bg-warning rounded-pill">MATERIAL</span>
                                <?php endif; ?> </td>
                                <td><?php echo $row['req_requisitante'] ?></td>
                                <td class="text-center">
                                <?php if ($row['req_grupo'] == 'Financeiro') : ?>
                                <span class="badge bg-green rounded-pill">Financeiro</span>
                                <?php endif; ?>
                                </td>
                                <td><?php echo date("d-m-Y H:i", strtotime($row['date_created'])) ?></td>
                                <td align="center">
                                <a class="dropdown-item" href="<?php echo base_url . 'admin?page=autorizacao/autorizacao_visu&po_id=' . $row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-black"></span></a>                          
                         
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <?php endif; ?>

                                    <!-- Aprovação Negócios 5 -->
                                    <?php if($_settings->userdata('type') == '5' || $_settings->userdata('type') == '1' || $_settings->userdata('type') == '2'): ?>
                        <?php
                        $i = 1;
                        $qry = $conn->query("SELECT r.form_id, p.*,r.data_autorizacao FROM `purchase_order_list` p
                        inner join receiving_list r on r.form_id = p.id WHERE p.req_grupo = 'Negócios' and r.req_aprov = 1 order by p.`date_created` desc");
                        while ($row = $qry->fetch_assoc()) :?>
                            <tr><td class="text-center"><?php echo $i++; ?></td>
                                <td><?php echo $row['po_code'] ?></td>
                                <td class="text-center">
                                <?php if ($row['etapa_mat_ou_ser'] == 0) : ?>
                                <span class="badge bg-blue rounded-pill">SERVIÇO</span>
                                <?php elseif ($row['etapa_mat_ou_ser'] == 1) : ?>
                                <span class="badge bg-warning rounded-pill">MATERIAL</span>
                                <?php endif; ?> </td>
                                <td><?php echo $row['req_requisitante'] ?></td>
                                <td class="text-center">
                                <?php if ($row['req_grupo'] == 'Negócios') : ?>
                                <span class="badge bg-gray rounded-pill">Negócios</span>
                                <?php endif; ?>
                                </td>
                                <td><?php echo date("d-m-Y H:i", strtotime($row['date_created'])) ?></td>
                                <td align="center">
                                <a class="dropdown-item" href="<?php echo base_url . 'admin?page=autorizacao/autorizacao_visu&po_id=' . $row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-black"></span></a>                          
             
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <?php endif; ?>

                                    <!-- Aprovação Administrativo 6 -->

                        <?php if($_settings->userdata('type') == '6' || $_settings->userdata('type') == '1' || $_settings->userdata('type') == '2'): ?>
                        <?php
                        $i = 1;
                        $qry = $conn->query("SELECT r.form_id, p.*,r.data_autorizacao FROM `purchase_order_list` p
                        inner join receiving_list r on r.form_id = p.id WHERE p.req_grupo = 'Administrativo' and r.req_aprov = 1 order by p.`date_created` desc");
                        while ($row = $qry->fetch_assoc()) :?>
                            <tr><td class="text-center"><?php echo $i++; ?></td>
                                <td><?php echo $row['po_code'] ?></td>
                                <td class="text-center">
                                <?php if ($row['etapa_mat_ou_ser'] == 0) : ?>
                                <span class="badge bg-blue rounded-pill">SERVIÇO</span>
                                <?php elseif ($row['etapa_mat_ou_ser'] == 1) : ?>
                                <span class="badge bg-warning rounded-pill">MATERIAL</span>
                                <?php endif; ?> </td>
                                <td><?php echo $row['req_requisitante'] ?></td>
                                <td class="text-center">
                                <?php if ($row['req_grupo'] == 'Administrativo') : ?>
                                <span class="badge bg-blue rounded-pill">Administrativo</span>
                                <?php endif; ?>
                                </td>
                                <td><?php echo date("d-m-Y H:i", strtotime($row['date_created'])) ?></td>
                                <td align="center">
                                <a class="dropdown-item" href="<?php echo base_url . 'admin?page=autorizacao/autorizacao_visu&po_id=' . $row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-black"></span></a>                          
                        
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <?php endif; ?>

                                    <!-- Aprovação P&D 7 -->

                                    <?php if($_settings->userdata('type') == '7' || $_settings->userdata('type') == '1' || $_settings->userdata('type') == '2'): ?>
                        <?php
                        $i = 1;
                        $qry = $conn->query("SELECT r.form_id, p.*,r.data_autorizacao FROM `purchase_order_list` p
                        inner join receiving_list r on r.form_id = p.id WHERE p.req_grupo = 'P&D' and r.req_aprov = 1 order by p.`date_created` desc");
                        while ($row = $qry->fetch_assoc()) :?>
                            <tr><td class="text-center"><?php echo $i++; ?></td>
                                <td><?php echo $row['po_code'] ?></td>
                                <td class="text-center">
                                <?php if ($row['etapa_mat_ou_ser'] == 0) : ?>
                                <span class="badge bg-blue rounded-pill">SERVIÇO</span>
                                <?php elseif ($row['etapa_mat_ou_ser'] == 1) : ?>
                                <span class="badge bg-warning rounded-pill">MATERIAL</span>
                                <?php endif; ?> </td>
                                <td><?php echo $row['req_requisitante'] ?></td>
                                <td class="text-center">
                                <?php if ($row['req_grupo'] == 'P&D') : ?>
                                <span class="badge badge-warning rounded-pill">P&D</span>
                                <?php endif; ?>
                                </td>
                                <td><?php echo date("d-m-Y H:i", strtotime($row['date_created'])) ?></td>
                                <td align="center">
                                <a class="dropdown-item" href="<?php echo base_url . 'admin?page=autorizacao/autorizacao_visu&po_id=' . $row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-black"></span></a>                          
                           
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <?php endif; ?>

                                    <!-- Aprovação  Assistência Técnica 8 -->

                                    <?php if($_settings->userdata('type') == '8' || $_settings->userdata('type') == '1' || $_settings->userdata('type') == '2'): ?>
                        <?php
                        $i = 1;
                        $qry = $conn->query("SELECT r.form_id, p.*,r.data_autorizacao FROM `purchase_order_list` p
                        inner join receiving_list r on r.form_id = p.id WHERE p.req_grupo = 'Assistência Técnica' and r.req_aprov = 1 order by p.`date_created` desc");
                        while ($row = $qry->fetch_assoc()) :?>
                            <tr><td class="text-center"><?php echo $i++; ?></td>
                                <td><?php echo $row['po_code'] ?></td>
                                <td class="text-center">
                                <?php if ($row['etapa_mat_ou_ser'] == 0) : ?>
                                <span class="badge bg-blue rounded-pill">SERVIÇO</span>
                                <?php elseif ($row['etapa_mat_ou_ser'] == 1) : ?>
                                <span class="badge bg-warning rounded-pill">MATERIAL</span>
                                <?php endif; ?> </td>
                                <td><?php echo $row['req_requisitante'] ?></td>
                                <td class="text-center">
                                <?php if ($row['req_grupo'] == 'Assistência Técnica') : ?>
                                <span class="badge bg-orange rounded-pill">Assistência Técnica</span>
                                <?php endif; ?>
                                </td>
                                <td><?php echo date("d-m-Y H:i", strtotime($row['date_created'])) ?></td>
                                <td align="center">
                                <a class="dropdown-item" href="<?php echo base_url . 'admin?page=autorizacao/autorizacao_visu&po_id=' . $row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-black"></span></a>                          
                              
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <?php endif; ?>

                        <!-- ADM CARLOS -->
                        <?php if($_settings->userdata('type') == '17' || $_settings->userdata('type') == '1' || $_settings->userdata('type') == '2' ): ?>
                        <?php
                        $i = 1;
                        $qry = $conn->query("SELECT r.form_id, p.*,r.data_autorizacao FROM `purchase_order_list` p
                        inner join receiving_list r on r.form_id = p.id WHERE p.req_grupo = 'Compras Matérias-primas' and r.req_aprov = 1 order by p.`date_created` desc");
                        while ($row = $qry->fetch_assoc()) :?>
                            <tr><td class="text-center"><?php echo $i++; ?></td>
                                <td><?php echo $row['po_code'] ?></td>
                                <td class="text-center">
                                <?php if ($row['etapa_mat_ou_ser'] == 0) : ?>
                                <span class="badge bg-blue rounded-pill">SERVIÇO</span>
                                <?php elseif ($row['etapa_mat_ou_ser'] == 1) : ?>
                                <span class="badge bg-warning rounded-pill">MATERIAL</span>
                                <?php endif; ?> </td>
                                <td><?php echo $row['req_requisitante'] ?></td>
                                <td class="text-center">
                                <?php if ($row['req_grupo'] == 'Compras Matérias-primas') : ?>
                                <span class="badge bg-danger rounded-pill">Compras Matérias-primas</span>
                                <?php endif; ?>
                                </td>
                                <td><?php echo date("d-m-Y H:i", strtotime($row['date_created'])) ?></td>
                                <td align="center">
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