<style>

body{
zoom: 90%;
}

.fade{
background-color: transparent;
}

table#tb_apontamento.dataTable tbody tr:hover {
  background-color: #ffa;
}

</style>

<div class="card card-outline card-gray">
    <div class="card-header">
        <h4 class="text-center padding">Vinculação de roteiros</h4>        
    </div> <!-- header -->

    <div class="card-body">
    <div class="row justify-content-center">
        <div class="form col-sm-6 col-md-3">
		<a style="width:100%;" class="btn btn-outline-success" id="create_roteiro" href="javascript:void(0)"><span class="fas fa-plus"></span>
        <strong> Nova OP </strong></a>
	    </div><br><br>
    </div> <!-- row -->
        <div class="container-fluid">

            <div class="table-responsive">
            <table class="table nowrap mx-auto" id="tb_apontamento" style="width:40%;">
            <thead>
                        <tr class="bg-gray table-active">
                          
                            <th class="align-middle text-center">Código OP</th>
                            <!-- <th class="align-middle text-center">Código da OP</th> -->
                            <th class="align-middle text-center">Adicionar Roteiro</th>
                        </tr>
            </thead>
            <tbody>
                        <?php
                        /* $usuario_historico = $_settings->userdata('id');
                        WHERE p.req_solicitante_type = $usuario_historico */
                     
                        $qry = $conn->query("SELECT p.* FROM `apontamento_roteiro` p");
                        while ($row = $qry->fetch_assoc()) : ?>
                            <tr>
                 

                            <td class="align-middle text-center"><?php echo $row['op_codigo'] ?></td>

                            <td class="align-middle text-center">  

                            <!-- <a style="width:100%;" class="btn btn-outline-primary btn-sm create-anexo-roteiro" href="javascript:void(0)"><span class="fas fa-plus"><strong> Roteiro </strong></a>     -->         
                            <a class="btn btn-outline-primary" style="width:100%;" href="<?php echo base_url.'/admin?page=apontamento/adicionar_roteiro_apontamento&id='.$row['id']?>"><span class="fa-solid fa-plus"></span> Roteiro</a>
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
    $('#create_roteiro').click(function() {
            uni_modal("Associar roteiro a Ordem de Produção", "apontamento/roteiro_apontamento.php", "mid-large")
        });

var table = $('#tb_apontamento').DataTable({
    "order": [[0,"desc"]],
    language: {
			url: 'http://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
		}
    });

        /*  js em cada linha*/
        
        /* $('.create-anexo-roteiro').each(function(index) {
            $(this).on("click", function(){
            var tableRow = $(this).closest("tr"); // comentar
            var trid = $(this).parent().siblings(":first-child").text()
            alert(trid); // comentar
            uni_modal("<i class='fa fa-plus'></i> Adicionar", "<.?php echo base_url.'/admin?page=apontamento/adicionar_roteiro_apontamento&id="+trid+"'?>", "mid-large")
        });

    }); */

    }); /* FIM */

</script>