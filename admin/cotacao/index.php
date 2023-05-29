<?php include_once ('datatable\tabelas.php'); ?>


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


<div class="card card-outline card-primary">
	<div class="card-header">
		<h4 class="text-center padding">Cotações</h4>
	</div>
	<div class="card-body">

    <div class="row justify-content-around">
<div>
<a id="btnTabela1" class="btn btn-warning" onclick="exibirTabela(1)">Pendentes</a>
</div>
<div>
<a id="btnTabela2" class="btn btn-primary" onclick="exibirTabela(2)">Editáveis</a>
</div>
<div>
<a id="btnTabela3" class="btn btn-success" onclick="exibirTabela(3)">Realizadas</a>
</div>
</div>
<br>

        <div class="container-fluid">
            <div class="table-responsive">
			<table class="table nowrap" id="tb_completa" style="width:100%;">
                    <thead>
                        <tr class="bg-primary">
                            <th class="text-center">Requisição</th>
                            <th class="text-center">Material / Serviço</th>
                            <th class="text-center">Solicitante</th>
                            <th class="text-center">Grupo</th>
                            <th class="text-center">Data Criação</th>
                            <th class="text-center">Cotação</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php if($_settings->userdata('username') == 'Ana Gomes') : ?>

                        <?php 
                        $qry = $conn->query("SELECT p.*, r.req_aprov,r.estado_requisicao,r.id AS idreq FROM purchase_order_list p
                        left join receiving_list r on r.form_id = p.id
                        WHERE (p.req_autorizada = 'Sim' and r.estado_requisicao IS NULL AND p.req_grupo = 'P&D')
                        OR (r.estado_requisicao = 1 and r.req_aprov = 1 AND p.req_grupo = 'P&D')");

                        while($row = $qry->fetch_assoc()):
                            $row['items'] = explode(',',$row['stock_ids']);
                            if($row['from_order'] == 1){
                                $code = $conn->query("SELECT po_code from `purchase_order_list` where id='{$row['form_id']}'")->fetch_assoc()['po_code'];
                            }else{
                                $code = $conn->query("SELECT bo_code from `back_order_list` where id='{$row['form_id']}'")->fetch_assoc()['bo_code'];
                            }
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $row['po_code'] ?></td>
                                <td class="text-center">
                                <?php if ($row['etapa_mat_ou_ser'] == 0) : ?>
                                <span class="badge bg-blue rounded-pill">SERVIÇO</span>
                                <?php elseif ($row['etapa_mat_ou_ser'] == 1) : ?>
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

                                <td class="text-center"><?php echo date("d-m-Y H:i",strtotime($row['date_created'])) ?></td>
                                                                
                                <td class="text-center">
                                <?php if($row['req_autorizada'] == 'Não' || ($row['req_autorizada'] == 'Sim' && $row['req_aprov'] == '1' && $row['estado_requisicao'] != NULL )) { ?>
                                    <a class="dropdown-item bg-warning" href="<?php echo base_url.'admin?page=receiving/manage_cotacao&id='.$row['idreq'] ?>" data-id="<?php echo $row['idreq'] ?>"><span class="fa fa-edit text-black"></span></a>
                                <?php } ?>
                                <?php if($row['req_autorizada'] == 'Sim' && $row['estado_requsicao'] == NULL && $row['idreq'] == NULL) { ?>
                                    <a class="dropdown-item bg-warning" href="<?php echo base_url.'admin?page=receiving/manage_cotacao&po_id='.$row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-black"></span></a>
                                    <?php } ?>
                            </td>

                            </tr>
                        <?php endwhile; ?>

                        <?php else :?>

                            <?php 
                        $qry = $conn->query("SELECT p.*, r.req_aprov,r.estado_requisicao,r.id AS idreq FROM purchase_order_list p
                        left join receiving_list r on r.form_id = p.id
                        WHERE (p.req_autorizada = 'Sim' and r.estado_requisicao IS NULL)
                        OR (r.estado_requisicao = 1 and r.req_aprov = 1)");

                        while($row = $qry->fetch_assoc()):
                            $row['items'] = explode(',',$row['stock_ids']);
                            if($row['from_order'] == 1){
                                $code = $conn->query("SELECT po_code from `purchase_order_list` where id='{$row['form_id']}'")->fetch_assoc()['po_code'];
                            }else{
                                $code = $conn->query("SELECT bo_code from `back_order_list` where id='{$row['form_id']}'")->fetch_assoc()['bo_code'];
                            }
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $row['po_code'] ?></td>
                                <td class="text-center">
                                <?php if ($row['etapa_mat_ou_ser'] == 0) : ?>
                                <span class="badge bg-blue rounded-pill">SERVIÇO</span>
                                <?php elseif ($row['etapa_mat_ou_ser'] == 1) : ?>
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

                                <td class="text-center"><?php echo date("d-m-Y H:i",strtotime($row['date_created'])) ?></td>
                                                                
                                <td class="text-center">
                                <?php if($row['req_autorizada'] == 'Não' || ($row['req_autorizada'] == 'Sim' && $row['req_aprov'] == '1' && $row['estado_requisicao'] != NULL )) { ?>
                                    <a class="dropdown-item bg-warning" href="<?php echo base_url.'admin?page=receiving/manage_cotacao&id='.$row['idreq'] ?>" data-id="<?php echo $row['idreq'] ?>"><span class="fa fa-edit text-black"></span></a>
                                <?php } ?>
                                <?php if($row['req_autorizada'] == 'Sim' && $row['estado_requsicao'] == NULL && $row['idreq'] == NULL) { ?>
                                    <a class="dropdown-item bg-warning" href="<?php echo base_url.'admin?page=receiving/manage_cotacao&po_id='.$row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-black"></span></a>
                                    <?php } ?>
                            </td>

                            </tr>
                        <?php endwhile; ?>

                            <?php endif;?>
                    </tbody>
                </table>




                <!-- TABELA 2 - EDITAVEIS -->



                <table class="table nowrap" id="tb_completa2" style="width:100%;">
                    
                    <thead>
                        <tr class="bg-success">
                            <th class="text-center">Requisição</th>
                            <th class="text-center">Material / Serviço</th>
                            <th class="text-center">Solicitante</th>
                            <th class="text-center">Grupo</th>
                            <th class="text-center">Data Criação</th>
                            <th class="text-center">Editar</th>
                        </tr>
                    </thead>
                    <tbody>

<?php if($_settings->userdata('username') == 'Ana Gomes') : ?>
    <?php
                        $i = 1;
                        $qry = $conn->query("SELECT r.*, p.status, p.req_grupo,p.req_requisitante FROM `receiving_list` r
                        INNER JOIN purchase_order_list p ON r.form_id = p.id
                        WHERE r.etapa_cotacao = 1 AND p.req_grupo = 'P&D' AND estado_requisicao = 2
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
                                
                                <td class="text-center"><?php echo $code ?></td>

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

                                <td class="text-center"><?php echo date("d-m-Y H:i",strtotime($row['date_created'])) ?></td>

                                <td class="text-center">
                                <?php if ($row['estado_requisicao'] == 2) : ?>
                                <a class="dropdown-item bg-blue" href="<?php echo base_url.'/admin?page=cotacao/cotacao_atualizar&id='.$row['id']?>"><span class="fa fa-edit"></span></a>
                                <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
    
<?php else : ?>
    <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT r.*, p.status, p.req_grupo,p.req_requisitante FROM `receiving_list` r
                        INNER JOIN purchase_order_list p ON r.form_id = p.id
                        WHERE r.etapa_cotacao = 1 AND estado_requisicao = 2
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
                                
                                <td class="text-center"><?php echo $code ?></td>

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
                    
                                <td class="text-center"><?php echo date("d-m-Y H:i",strtotime($row['date_created'])) ?></td>

                                <td class="text-center">
                                <?php if ($row['estado_requisicao'] == 2) : ?>
                                <a class="dropdown-item bg-blue" href="<?php echo base_url.'/admin?page=cotacao/cotacao_atualizar&id='.$row['id']?>"><span class="fa fa-edit"></span></a>
                                <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>

    
    <?php endif;?>

                    </tbody>
                </table>



                                    <!-- TABELA 3 REALIZADAS -->



                                    <table class="table nowrap" id="tb_completa3" style="width:100%;">
                    
                    <thead>
                        <tr class="bg-success">
                            <th class="text-center">Requisição</th>
                            <th class="text-center">Material / Serviço</th>
                            <th class="text-center">Solicitante</th>
                            <th class="text-center">Grupo</th>
                            <th class="text-center">Data Criação</th>
                            <th class="text-center">Visualizar</th>
                        </tr>
                    </thead>
                    <tbody>

<?php if($_settings->userdata('username') == 'Ana Gomes') : ?>
    <?php
                        $i = 1;
                        $qry = $conn->query("SELECT r.*, p.status, p.req_grupo,p.req_requisitante FROM `receiving_list` r
                        INNER JOIN purchase_order_list p ON r.form_id = p.id
                        WHERE r.etapa_cotacao = 1 AND p.req_grupo = 'P&D'
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
                                
                                <td class="text-center"><?php echo $code ?></td>

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

                                <!-- <td class="text-right"><?php echo number_format(count($row['items'])) ?></td> -->
                                <td class="text-center"><?php echo date("d-m-Y H:i",strtotime($row['date_created'])) ?></td>

                                <td class="text-center">
                                <a class="dropdown-item" href="<?php echo base_url.'admin?page=cotacao/cotacao_visu&id='.$row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa-solid fa-eye"></span></a>
                                </td>

                            </tr>
                        <?php endwhile; ?>
    
<?php else : ?>
    <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT r.*, p.status, p.req_grupo,p.req_requisitante FROM `receiving_list` r
                        INNER JOIN purchase_order_list p ON r.form_id = p.id
                        WHERE r.etapa_cotacao = 1
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
                                
                                <td class="text-center"><?php echo $code ?></td>

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
                          
                                <td class="text-center"><?php echo date("d-m-Y H:i",strtotime($row['date_created'])) ?></td>

                                <td class="text-center">
                                <a class="dropdown-item" href="<?php echo base_url.'admin?page=cotacao/cotacao_visu&id='.$row['id'] ?>" data-id="<?php echo $row['id'] ?>"><span class="fa-solid fa-eye"></span></a>
                                </td>
                          
                            </tr>
                        <?php endwhile; ?>

    
    <?php endif;?>

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
		});
		$('.view_details').click(function(){
			uni_modal("Detalhes","receiving/view_receiving.php?id="+$(this).attr('data-id'),'mid-large')
		});

        $('#tb_completa').DataTable({
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