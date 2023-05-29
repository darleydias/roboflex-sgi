<style>
    .card-painel{
        width: 30px;
        height: 30px;
        text-align: center;
        line-height: 30px;
        margin: auto;
    }

body{
zoom: 90%;
}

</style>

<?php if($_settings->userdata('type') == 25 || $_settings->userdata('type') == 26 || $_settings->userdata('type') == 27 || $_settings->userdata('type') == 28 || $_settings->userdata('type') == 29 || $_settings->userdata('type') == 30 || $_settings->userdata('type') == 36) : ?>
    <div style="height: 250px;"></div>
    <h1 class="" style="text-align: center"> SGI ROBOFLEX</h1>
<br><br>
    <div class="row justify-content-center">
        <div class="form col-sm-6 col-md-3">
		<a style="width:100%;" onclick="window.location='<?php echo base_url ?>admin/?page=apontamento'" class="btn btn-outline-secondary"><strong> PÁGINA DE APONTAMENTOS </strong></a>
	    </div><br><br>
    </div> <!-- row -->

<?php else : ?>
<h1 class="" style="text-align: center"> SGI ROBOFLEX</h1>
<h4 class="" style="text-align: center"> FLUXOGRAMA</h4>
<hr>
<div class="row">
<div class="col-12 col-sm-6 col-md-4">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-list"></i></span>

            <div class="info-box-content">
            <span class="info-box-number text-left"><h6>REQUISIÇÕES</h6></span>
            </div>
            <div class="card-painel font-weight-bold bg-green">
                <?php 
                    echo $conn->query("SELECT p.id FROM `purchase_order_list` p")->num_rows;
                ?>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>


<!-- AUTORIZAÇÃO -->

    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check"></i></span>
            <div class="info-box-content">
            <span class="info-box-number text-left"><h6>AUTORIZAÇÕES</h6></span>
            </div>
            <div>
            <div class="card-painel font-weight-bold bg-warning">
                <?php 
                    echo $conn->query("SELECT p.status FROM `purchase_order_list` p
                    where status = 0")->num_rows;
                ?>
            </div>

            <a class="btn btn-outline-primary " data-toggle="collapse" href="#collapseAutorizacao"
            role="button" aria-expanded="false" aria-controls="collapseAutorizacao"><i class="fa-plus"></i></a>
            </div>
</div> <!-- /.info-box-content --> 
<?php $sql = "SELECT p.req_grupo,p.po_code FROM purchase_order_list p where status = 0 order by p.po_code ASC ";
        $result = mysqli_query($conn, $sql);
        /* echo "<br>"; */
        echo '<div class="collapse" id="collapseAutorizacao">';
        echo "<table border='0' class='text-center nowrap'>";
        while ($row = mysqli_fetch_assoc($result)) { 
        echo "<tr>";
        foreach ($row as $field => $value) {
        echo "<td class='col-md-1'>" . $value . "</td>";}
        echo "</tr>";}
        echo "</table>"; 
        echo '</div>'; ?>
</div> <!-- /.info-box -->


    <!-- COTAÇÃO -->
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-brazilian-real-sign"></i></span>

            <div class="info-box-content">
            <span class="info-box-number text-left"><h6>COTAÇÕES</h6></span>
            </div>
            <div>
            <div class="card-painel font-weight-bold bg-warning">
            <?php 
                    echo $conn->query("SELECT r.estado_requisicao FROM `receiving_list` r
                    where estado_requisicao = 1 and r.req_aprov = 1")->num_rows;
                ?>
            </div>

            <a class="btn btn-outline-primary " data-toggle="collapse" href="#collapseCotacao"
            role="button" aria-expanded="false" aria-controls="collapseCotacao"><i class="fa-plus"></i></a>
            </div>
        </div>  <!-- /.info-box-content -->
        <?php
        $sql = "SELECT p.po_code FROM purchase_order_list p
        inner join receiving_list r on r.form_id = p.id WHERE estado_requisicao = 1 and r.req_aprov = 1 order by po_code ASC";
       $result = mysqli_query($conn, $sql);
       /* echo "<br>"; */
       echo '<div class="collapse" id="collapseCotacao">';
       echo "<table border='0' class='text-center'>";
       while ($row = mysqli_fetch_assoc($result)) { 
       echo "<tr>";
       foreach ($row as $field => $value) {
       echo "<td class='col-md-1'>" . $value . "</td>";}
       echo "</tr>";}
       echo "</table>"; 
       echo '</div>'; ?>        
    </div> <!-- /.info-box -->
    
    <!-- APROVAÇÃO -->

    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-double"></i></span>

            <div class="info-box-content">
            <span class="info-box-number text-left"><h6>APROVAÇÕES</h6></span>
        
            </div>
            <div>
            <div class="card-painel font-weight-bold bg-warning">
            <?php 
                    echo $conn->query("SELECT r.estado_requisicao FROM `receiving_list` r
                    where estado_requisicao = 2")->num_rows;
                ?>
            </div>

            <a class="btn btn-outline-primary " data-toggle="collapse" href="#collapseAprovacao"
            role="button" aria-expanded="false" aria-controls="collapseAprovacao"><i class="fa-plus"></i></a>
            </div>
            <!-- /.info-box-content -->
        </div>

        <?php
        $sql = "SELECT p.po_code FROM purchase_order_list p
        inner join receiving_list r on r.form_id = p.id WHERE estado_requisicao = 2 order by po_code ASC";
       $result = mysqli_query($conn, $sql);
       /* echo "<br>"; */
       echo '<div class="collapse" id="collapseAprovacao">';
       echo "<table border='0' class='text-center'>";
       while ($row = mysqli_fetch_assoc($result)) { 
       echo "<tr>";
       foreach ($row as $field => $value) {
       echo "<td class='col-md-1'>" . $value . "</td>";}
       echo "</tr>";}
       echo "</table>"; 
       echo '</div>'; ?>   
       
        <!-- /.info-box -->
    </div>


    <!-- PEDIDO DE COMPRA DE MATERIAL -->


    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-boxes-packing"></i></span>

            <div class="info-box-content">
            <span class="info-box-number text-left"><h6>PEDIDO DE COMPRA DE MATERIAL</h6></span>
            </div>
            <div>
            <div class="card-painel font-weight-bold bg-warning">
            <?php 
                    echo $conn->query("SELECT r.estado_requisicao FROM `receiving_list` r
                    INNER JOIN purchase_order_list p ON r.form_id = p.id
                    where r.estado_requisicao = 3 and r.req_aprov2 = 1 and p.etapa_mat_ou_ser = 1")->num_rows;
                ?>
           
            </div>

            <a class="btn btn-outline-primary " data-toggle="collapse" href="#collapseMaterial"
            role="button" aria-expanded="false" aria-controls="collapseMaterial"><i class="fa-plus"></i></a>
            </div>

        
            <!-- /.info-box-content -->
        </div>
        <?php
        $sql = "SELECT p.po_code FROM purchase_order_list p
        inner join receiving_list r on r.form_id = p.id where r.estado_requisicao = 3 and r.req_aprov2 = 1 and p.etapa_mat_ou_ser = 1 order by po_code ASC";
       $result = mysqli_query($conn, $sql);
       /* echo "<br>"; */
       echo '<div class="collapse" id="collapseMaterial">';
       echo "<table border='0' class='text-center'>";
       while ($row = mysqli_fetch_assoc($result)) { 
       echo "<tr>";
       foreach ($row as $field => $value) {
       echo "<td class='col-md-1'>" . $value . "</td>";}
       echo "</tr>";}
       echo "</table>"; 
       echo '</div>'; ?>
        <!-- /.info-box -->
    </div>

    <!-- PEDIDO DE COMPRA DE SERVIÇO -->
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-screwdriver-wrench"></i></span>

            <div class="info-box-content">
            <span class="info-box-number text-left"><h6>PEDIDO DE COMPRA DE SERVIÇO</h6></span>
            </div>
            <div>
            <div class="card-painel font-weight-bold bg-warning">
            <?php 
                    echo $conn->query("SELECT r.estado_requisicao FROM `receiving_list` r
                    INNER JOIN purchase_order_list p ON r.form_id = p.id
                    where r.estado_requisicao = 3 and r.req_aprov2 = 1 and p.etapa_mat_ou_ser = 0")->num_rows;
                ?>
           
            </div>

            <a class="btn btn-outline-primary " data-toggle="collapse" href="#collapseServico"
            role="button" aria-expanded="false" aria-controls="collapseServico"><i class="fa-plus"></i></a>
            </div>
            <!-- /.info-box-content -->
        </div>

        <?php
        $sql = "SELECT p.po_code FROM purchase_order_list p
        inner join receiving_list r on r.form_id = p.id where r.estado_requisicao = 3 and r.req_aprov2 = 1 and p.etapa_mat_ou_ser = 0 order by po_code ASC";
       $result = mysqli_query($conn, $sql);
       /* echo "<br>"; */
       echo '<div class="collapse" id="collapseServico">';
       echo "<table border='0' class='text-center'>";
       while ($row = mysqli_fetch_assoc($result)) { 
       echo "<tr>";
       foreach ($row as $field => $value) {
       echo "<td class='col-md-1'>" . $value . "</td>";}
       echo "</tr>";}
       echo "</table>"; 
       echo '</div>'; ?>

        <!-- /.info-box -->
    </div>



    <!-- hidden -->

  <!--   <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-navy elevation-1"><i class="fas fa-truck-loading"></i></span>

            <div class="info-box-content">
            <span class="info-box-number text-left"><h6>RECEBIMENTOS</h6></span>
            </div>
            <div class="card-painel font-weight-bold bg-warning">
            <?php 
                    echo $conn->query("SELECT r.estado_requisicao FROM `receiving_list` r
                    where estado_requisicao = 4")->num_rows;
                ?>
       
            </div>

        </div>

    </div> -->






    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-lightblue elevation-1"><i class="fas fa-th-list"></i></span>

            <div class="info-box-content">
            <span class="info-box-number text-left"><h6>CONCLUÍDAS</h6></span>
            </div>
            <div class="card-painel font-weight-bold bg-success">
            <?php 
                    echo $conn->query("SELECT r.estado_requisicao FROM `receiving_list` r
                    where r.estado_requisicao = 4 OR r.estado_requisicao = 6")->num_rows;
                ?>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

    <?php endif; ?>
    <?php if($_settings->userdata('type') == 1): ?>
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-teal elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
            <span class="info-box-text"><!-- Users -->Usuários</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `users` where id != 1 ")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <?php endif; ?>
</div>