<style>
body{
zoom: 90%;
}

table#tb_apontamento.dataTable tbody tr:hover {
  background-color: #ffa;
}
</style>

<div class="card card-outline card-gray">
    <div class="card-header">
        <h4 class="text-center padding">Apontamentos de produção</h4>        
    </div> <!-- header -->

    <div class="card-body">
    <div class="row justify-content-center">
        <div class="form col-sm-6 col-md-3">
		<a style="width:100%;" onclick="window.location='<?php echo base_url ?>admin/?page=apontamento/apontamento'" class="btn btn-outline-success"><strong> NOVO APONTAMENTO </strong>  <!-- <span class="fas fa-circle-xmark"></span> --></a>
	    </div>
        
        <?php if($_settings->userdata('username') == 'Admin') { ?>
        <div class="form col-sm-6 col-md-3">
		<a style="width:100%;" onclick="window.location='<?php echo base_url ?>admin/?page=apontamento/parametro'" class="btn btn-outline-danger">
        <strong> PARÂMETROS </strong></a>
	    </div>
<?php } ?>
        
        <br><br>
    </div> <!-- row -->
<br>
        <div class="container-fluid">
            
        <div class="table-responsive">
                <table class="table nowrap" id="tb_apontamento" style="width:100%;">
                    
                    <thead>
                        <tr class="bg-gray table-active">
                            <th class="align-middle text-center">Apontamento</th>
                            <th class="align-middle text-center">Código da OP</th>
                            <th class="align-middle text-center">Serviços em Aberto</th>
                            <th class="align-middle text-center">Editar</th>
                        </tr>
                    </thead>
                    <tbody>                              
                        <?php
                        $usuario_historico = $_settings->userdata('id');
                        $i = 1;
                        $qry = $conn->query("SELECT p.* FROM `apontamento_list` p
                        WHERE p.req_solicitante_type = $usuario_historico AND p.apontamento_final = 0");
                        while ($row = $qry->fetch_assoc()) : ?>
                                <tr>

                                <td class="align-middle text-center"><?php echo $row['po_code'] ?></td>

                                <td class="align-middle text-center">
                                <?php echo $row['apontamento_op']?>
                                </td>

                                <td class="align-middle text-center">
                                <strong>
                                <?php echo $conn->query("SELECT p.id
                                FROM apontamento_list p
                                INNER JOIN apontamento_items q ON q.po_id = p.id
                                WHERE p.id = '".$row['id']."' AND q.datafinal1 = '0000-00-00 00:00:00' ")->num_rows; ?>
                                </strong>
                                </td>

                                <td class="align-middle col-md-3 text-center">                 
                                <a class="dropdown-item bg-blue" style="height:40px;" href="<?php echo base_url.'/admin?page=apontamento/atualizar_apontamento&id='.$row['id']?>"><span class="fa fa-edit align-middle"></span></a>
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
$(document).ready(function() {

var table = $('#tb_apontamento').DataTable({
    "order": [[1,"desc"]],
    language: {
			url: 'http://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
		}
    });
});

</script>