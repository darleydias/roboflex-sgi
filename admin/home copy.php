<style>
    .card-painel{
        width: 30px;
        height: 30px;
        text-align: center;
        line-height: 30px;
        margin: auto;
    }

</style>

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

    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check"></i></span>

            <div class="info-box-content">
            <span class="info-box-number text-left"><h6>AUTORIZAÇÕES</h6></span>
            </div>
            <div class="card-painel font-weight-bold bg-warning">
                <?php 
                    echo $conn->query("SELECT p.status FROM `purchase_order_list` p
                    where status = 0")->num_rows;
                ?>
            </div>
           
            <!-- /.info-box-content -->
        </div>
<?php
        $sql = "SELECT po_code FROM purchase_order_list where status = 0";
$result = mysqli_query($conn, $sql); // First parameter is just return of "mysqli_connect()" function
echo "<br>";
echo "<table border='1'>";
while ($row = mysqli_fetch_assoc($result)) { // Important line !!! Check summary get row on array ..
    echo "<tr>";
    foreach ($row as $field => $value) { // I you want you can right this line like this: foreach($row as $value) {
        echo "<td>" . $value . "</td>"; // I just did not use "htmlspecialchars()" function. 
    }
    echo "</tr>";
}
echo "</table>";
?>

        <!-- /.info-box -->
    </div>

    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-brazilian-real-sign"></i></span>

            <div class="info-box-content">
            <span class="info-box-number text-left"><h6>COTAÇÕES</h6></span>
            </div>
            <div class="card-painel font-weight-bold bg-warning">
            <?php 
                    echo $conn->query("SELECT r.estado_requisicao FROM `receiving_list` r
                    where estado_requisicao = 1 and r.req_aprov = 1")->num_rows;
                ?>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-double"></i></span>

            <div class="info-box-content">
            <span class="info-box-number text-left"><h6>APROVAÇÕES</h6></span>
        
            </div>
            <div class="card-painel font-weight-bold bg-warning">
            <?php 
                    echo $conn->query("SELECT r.estado_requisicao FROM `receiving_list` r
                    where estado_requisicao = 2")->num_rows;
                ?>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-boxes-packing"></i></span>

            <div class="info-box-content">
            <span class="info-box-number text-left"><h6>PEDIDO DE COMPRA DE MATERIAL</h6></span>
            </div>
            <div class="card-painel font-weight-bold bg-warning">
            <?php 
                    echo $conn->query("SELECT r.estado_requisicao FROM `receiving_list` r
                    INNER JOIN purchase_order_list p ON r.form_id = p.id
                    where r.estado_requisicao = 3 and r.req_aprov2 = 1 and p.etapa_mat_ou_ser = 1")->num_rows;
                ?>
           
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-screwdriver-wrench"></i></span>

            <div class="info-box-content">
            <span class="info-box-number text-left"><h6>PEDIDO DE COMPRA DE SERVIÇO</h6></span>
            </div>
            <div class="card-painel font-weight-bold bg-warning">
            <?php 
                    echo $conn->query("SELECT r.estado_requisicao FROM `receiving_list` r
                    INNER JOIN purchase_order_list p ON r.form_id = p.id
                    where r.estado_requisicao = 3 and r.req_aprov2 = 1 and p.etapa_mat_ou_ser = 0")->num_rows;
                ?>
           
            </div>
            <!-- /.info-box-content -->
        </div>
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