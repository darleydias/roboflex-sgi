<?php 
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT p.* FROM receiving_list p where p.id = '{$_GET['id']}'");
    if($qry->num_rows >0){
        foreach($qry->fetch_array() as $k => $v){
            $$k = $v;
        }
        if($from_order == 1){
            $qry = $conn->query("SELECT p.*,s.name as supplier FROM purchase_order_list p inner join supplier_list s on p.supplier_id = s.id  where p.id = '{$form_id}'");
            if($qry->num_rows >0){
                foreach($qry->fetch_array() as $k => $v){
                    if($k == 'id')
                    $k = 'po_id';
                    if(!isset($$k))
                    $$k = $v;
                }
            }
        }else{
            $qry = $conn->query("SELECT b.*,s.name as supplier,p.po_code FROM back_order_list b inner join supplier_list s on b.supplier_id = s.id inner join purchase_order_list p on b.po_id = p.id  where b.id = '{$_GET['bo_id']}'");
            if($qry->num_rows >0){
                foreach($qry->fetch_array() as $k => $v){
                    if($k == 'id')
                    $k = 'bo_id';
                    if(!isset($$k))
                    $$k = $v;
                }
            }
        }
    }
}
if(isset($_GET['po_id'])){
    $qry = $conn->query("SELECT p.*,s.name as supplier FROM purchase_order_list p inner join supplier_list s on p.supplier_id = s.id  where p.id = '{$_GET['po_id']}'");
    if($qry->num_rows >0){
        foreach($qry->fetch_array() as $k => $v){
            if($k == 'id')
            $k = 'po_id';
            $$k = $v;
        }
    }
}
if(isset($_GET['bo_id'])){
    $qry = $conn->query("SELECT b.*,s.name as supplier,p.po_code FROM back_order_list b inner join supplier_list s on b.supplier_id = s.id inner join purchase_order_list p on b.po_id = p.id  where b.id = '{$_GET['bo_id']}'");
    if($qry->num_rows >0){
        foreach($qry->fetch_array() as $k => $v){
            if($k == 'id')
            $k = 'bo_id';
            $$k = $v;
        }
    }
}

?>
<style>

.bt-escolhido{
    background-color: green;
}

.center{
    display: flex;
justify-content: center;
align-items: center;
}

input[type="date"]::-webkit-inner-spin-button,
input[type="date"]::-webkit-calendar-picker-indicator {
    display: none;
    -webkit-appearance: none;
    opacity: 0;
} 

.select2{
        pointer-events: none;
        touch-action: none;
        background-color: transparent;
        box-shadow: none;
        border: 0;
        display: flex;
        appearance: none;
    -o-appearance: none;
   -ms-appearance: none;
   -webkit-appearance: none;
   -moz-appearance: none;
    }

    input[type="date"]::-webkit-inner-spin-button,
input[type="date"]::-webkit-calendar-picker-indicator {
    display: none;
    -webkit-appearance: none;
    opacity: 0;
}

label {
    display: inline !important;
    white-space:nowrap;
}


body{
   zoom: 90%; 
}

.visua{
width: 283px;
}

.dropZoneOverlay, .FileUpload {
            width: 283px;
            height: 108px;
            cursor: move;
        }

        .dropZoneOverlay {
            border: 3px dashed #000000;
            font-family: cursive;
            color: black;
            position: absolute;
            top: 0px;
            text-align: center;
        }

        .FileUpload {
            opacity: 0;
            position: relative;
            z-index: 1;
            
        }
</style>

<?php
$_SESSION['id_op_servico'] = $po_code;
?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h4 class="card-title"> <strong><?php echo 'REQUISIÇÃO ' .$po_code ?></strong></h4>
    </div>
    <div class="card-body">
    <form action="anexo/upload_servico.php" method="post" enctype="multipart/form-data" id="form-anexo"></form>
        <form action="" id="receive-form">
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
            <input type="hidden" name="from_order" value="<?php echo isset($bo_id) ? 2 : 1 ?>">
            <input type="hidden" name="form_id" value="<?php echo isset($bo_id) ? $bo_id : $po_id ?>">
            <input type="hidden" name="po_id" value="<?php echo isset($po_id) ? $po_id : '' ?>">
            <div class="container-fluid">

                <div class="row justify-content-around">
                    <!-- <.?php if(!isset($bo_id)): ?> -->
                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <label class="control-label">Código requisição</label>
                        <input type="text" style="width:100%;" tabindex="-1" class="select2 text-center" value="<?php echo isset($po_code) ? $po_code : '' ?>">
                    </div>
                   <!--  <.?php else: ?> -->
                        <!-- <div class="col-md-3">
                        <label class="control-label">Código pendente</label>
                        <input type="text" class="select2 text-center" value="<.?php echo isset($bo_code) ? $bo_code : '' ?>" readonly>
                    </div> -->
                    <!-- <.?php endif; ?>  -->           
                 <div class="col-12 col-sm-6 col-md-3 offset-md-1 text-center">
                                <label for="req_date" class="control-label">Data da Requisição</label>
                                <input type="date" style="width:100%;" tabindex="-1" class="select3 text-center" id="req_date" value="<?php echo isset($req_date) ? $req_date : ''; ?>">
                       
                        </div>

                    <div class="col-12 col-sm-6 col-md-3 offset-md-1 text-center">
                        <label for="req_unidade" class="control-label">Unidade Requisitante</label>
                        <select id="req_unidade" tabindex="-1" class="select2 text-center" style="width:100%">
                            <option value="1" <?php echo isset($req_unidade) && $req_unidade == 1 ? 'selected' : '' ?>>Roboflex</option>
                            <option value="0" <?php echo isset($req_unidade) && $req_unidade == 0 ? 'selected' : '' ?>>Zontec</option>
                        </select>
                    </div>
                    
   

                </br></br></br>


            <div class="col-12 col-sm-6 col-md-3 text-center">
                 
                        <label for="req_requisitante" class="control-label">Solicitante</label>
                        <select id="req_requisitante" class="select2 text-center" style="width:100%" tabindex="-1">
                            <option <?php echo !isset($req_requisitante) ? 'selected' : '' ?> disabled></option>
                            <?php
                            $requisitante = $conn->query("SELECT r.id, r.name FROM `requisitante_list` r where status = 1 order by `name` asc");
                            while ($row = $requisitante->fetch_assoc()) :
                            ?>
                                <option value="<?php echo $row['name'] ?>" <?php echo isset($req_requisitante) && $req_requisitante == $row['name'] ? "selected" : "" ?>><?php echo $row['name'] ?></option>
                            <?php endwhile; ?>
                        </select>
       
                    </div>

                    <div class="col-12 col-sm-6 col-md-3 offset-md-1 text-center">
                        <label for="req_setor_util" class="control-label">Setor de Utilização</label>
                        <select id="req_setor_util" tabindex="-1" class="select2 text-center" style="width:100%">
                            <option <?php echo !isset($req_setor_util) ? 'selected' : '' ?> disabled></option>
                            <?php
                            $setor_utilizacao = $conn->query("SELECT * FROM `setor_list` where status = 1 order by `name` asc");
                            while ($row = $setor_utilizacao->fetch_assoc()) :
                            ?>
                                <option value="<?php echo $row['id'] ?>" <?php echo isset($req_setor_util) && $req_setor_util == $row['id'] ? "selected" : "" ?>><?php echo $row['name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
  

   
                    <div class="col-12 col-sm-6 col-md-3 offset-md-1 text-center">
                        <label for="req_projeto" class="control-label">Projeto</label>
                        <select id="req_projeto" tabindex="-1" class="select2 text-center" style="width:100%" onchange="toggleInput();">
                            <option value="" selected disabled> Escolha aqui </option>
                            <option value="1" <?php echo isset($req_projeto) && $req_projeto == 1 ? 'selected' : '' ?>>Não</option>
                            <option value="0" <?php echo isset($req_projeto) && $req_projeto == 0 ? 'selected' : '' ?>>Sim</option>
                        </select>
                    </div>
                    
                    <br><br><br>

                    <?php if($req_projeto == '0') : ?>
                    <div class="col-12 col-sm-6 col-md-3  text-center">
                        <label for="req_proj_cod" class="control-label">Código Projeto</label>
                        <input type="text" tabindex="-1" id="req_proj_cod" class="select2 text-center" style="width:100%;" value="<?php echo isset($req_proj_cod) ? $req_proj_cod : ''; ?>">
                    </div>
                    <div class="col-12 col-sm-12 col-md-3 offset-md-1 text-center">
                        <label for="req_proj_nome" class="control-label">Nome Projeto</label>
                        <input type="text" tabindex="-1" id="req_proj_nome" class="select2 text-center" style="width:100%;" value="<?php echo isset($req_proj_nome) ? $req_proj_nome : ''; ?>">
                    </div>
                    <?php endif; ?>
                </div> <!-- fim linha -->
        
                <?php if(!empty($remarks)) { ?>
<div class="row justify-content-around">
<div class="col-md-10">
<div class="form-group text-center">
<label for="remarks" class="control-label">Observações da requisição</label>
<?php
// Verificar a quantidade de linhas no texto anterior
$lineCount = isset($remarks) ? substr_count($remarks, "\n") + 1 : 1;
$rows = ($lineCount > 1) ? $lineCount : 3; // Definir pelo menos 2 linhas visíveis
?>
<textarea name="remarks" id="remarks" rows="<?php echo $rows; ?>" class="form-control rounded-0 text-center" readonly><?php echo isset($remarks) ? htmlspecialchars($remarks) : ''; ?></textarea>
</div>
</div>
</div>
<?php } ?>
                 
<br>
          <?php echo $etapa_mat_ou_ser == 1 ? "<h5 class='text-center'><a style='color:#f29f05'>MATERIAIS</a> SOLICITADOS</h5>" : "<h5 class='text-center'><a style='color:#035aa6'>SERVIÇOS</a> SOLICITADOS</h5>" ?>


          <div>
        <i><strong>Mostrar/Ocultar colunas:</strong></i><br>
       
        <a class="toggle-vis btn btn-outline-primary btn-sm" data-column="0">Código</a>
        <a class="toggle-vis btn btn-outline-primary btn-sm" data-column="1">Nome</a>
        <a class="toggle-vis btn btn-outline-primary btn-sm" data-column="2">Quantidade</a>
        <a class="toggle-vis btn btn-outline-primary btn-sm" data-column="3" style="<?php echo $etapa_mat_ou_ser == 1 ? "" : "display:none;" ?>">Tipo</a>
        <a class="toggle-vis btn btn-outline-primary btn-sm" data-column="4">Observação</a>
        <a class="toggle-vis btn btn-outline-primary btn-sm" data-column="5">Fornecedor</a>
        <a class="toggle-vis btn btn-outline-primary btn-sm" data-column="6">Data</a>
        
        
        </div>

          <div class="table-responsive">
                <table class="table table-striped table-bordered tabela-form-r" id="list_servico" style="width:100%;">
                        <thead>
                <tr class="text-light bg-navy">
                        <!-- <th class="text-center py-1 px-2 align-middle">#</th> -->
                            <th class="text-center py-1 px-2 align-middle">Código</th>
                            <th class="text-center py-1 px-2 align-middle">Nome e Descrição</th>
                            <th class="text-center py-1 px-2 align-middle">Qtde</th>
                            <th class="text-center align-middle" style="<?php echo $etapa_mat_ou_ser == 1 ? "" : "display:none;" ?>">Tipo</th>
                            <th class="text-center py-1 px-2 align-middle">Observação</th>
                            <th class="text-center py-1 px-2 align-middle">Indicação Fornecedor</th>
                            <th class="text-center py-1 px-2 align-middle">Data Previsão</th>
                            <th class="text-center py-1 px-2 align-middle">Cotação 1</th>
                        </tr>
                        </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        if(isset($po_id)):
                        if(!isset($bo_id))
                        $qry = $conn->query("SELECT p.*,i.name,i.description,i.cod_item FROM `po_items` p inner join item_list i on p.item_id = i.id where p.po_id = '{$po_id}'");
                        else
                        $qry = $conn->query("SELECT b.*,i.name,i.description FROM `bo_items` b inner join item_list i on b.item_id = i.id where b.bo_id = '{$bo_id}'");
                        while($row = $qry->fetch_assoc()):
                            $total += $row['total'];
                            $row['qty'] = $row['quantity'];
                            $row['cot1'] = $row['cotacao_1_0'];
                            $row['cot2'] = $row['cotacao_1_1'];
                            $row['cot3'] = $row['cotacao_1_2'];

                            $row['cot4'] = $row['cotacao_2_0'];
                            $row['cot5'] = $row['cotacao_2_1'];
                            $row['cot6'] = $row['cotacao_2_2'];
                            $row['cot7'] = $row['cotacao_3_0'];
                            $row['cot8'] = $row['cotacao_3_1'];
                            $row['cot9'] = $row['cotacao_3_2'];

                            $row['bot1'] = $row['botao_cot1'];


                            if(isset($stock_ids)){
                                // echo "SELECT * FROM `stock_list` where id in ($stock_ids) and item_id = '{$row['item_id']}'";
                                $qty = $conn->query("SELECT * FROM `stock_list` where id in ($stock_ids) and item_id = '{$row['item_id']}'");
                                $row['qty'] = $qty->num_rows > 0 ? $qty->fetch_assoc()['quantity'] : $row['qty'];

                                $cot1 = $conn->query("SELECT * FROM `stock_list` where id in ($stock_ids) and item_id = '{$row['item_id']}'
                                ");
                                $row['cot1'] = $cot1->num_rows > 0 ? $cot1->fetch_assoc()['cotacao_1_0'] : $row['cot1'];

                                $cot2 = $conn->query("SELECT * FROM `stock_list` where id in ($stock_ids) and item_id = '{$row['item_id']}'
                                ");
                                $row['cot2'] = $cot2->num_rows > 0 ? $cot2->fetch_assoc()['cotacao_1_1'] : $row['cot2'];

                                $cot3 = $conn->query("SELECT * FROM `stock_list` where id in ($stock_ids) and item_id = '{$row['item_id']}'
                                ");
                                $row['cot3'] = $cot3->num_rows > 0 ? $cot3->fetch_assoc()['cotacao_1_2'] : $row['cot3'];

                                $cot4 = $conn->query("SELECT * FROM `stock_list` where id in ($stock_ids) and item_id = '{$row['item_id']}'
                                ");
                                $row['cot4'] = $cot4->num_rows > 0 ? $cot4->fetch_assoc()['cotacao_2_0'] : $row['cot4'];

                                $cot5 = $conn->query("SELECT * FROM `stock_list` where id in ($stock_ids) and item_id = '{$row['item_id']}'
                                ");
                                $row['cot5'] = $cot5->num_rows > 0 ? $cot5->fetch_assoc()['cotacao_2_1'] : $row['cot5'];

                                $cot6 = $conn->query("SELECT * FROM `stock_list` where id in ($stock_ids) and item_id = '{$row['item_id']}'
                                ");
                                $row['cot6'] = $cot6->num_rows > 0 ? $cot6->fetch_assoc()['cotacao_2_2'] : $row['cot6'];

                                $cot7 = $conn->query("SELECT * FROM `stock_list` where id in ($stock_ids) and item_id = '{$row['item_id']}'
                                ");
                                $row['cot7'] = $cot7->num_rows > 0 ? $cot7->fetch_assoc()['cotacao_3_0'] : $row['cot7'];

                                $cot8 = $conn->query("SELECT * FROM `stock_list` where id in ($stock_ids) and item_id = '{$row['item_id']}'
                                ");
                                $row['cot8'] = $cot8->num_rows > 0 ? $cot8->fetch_assoc()['cotacao_3_1'] : $row['cot8'];

                                $cot9 = $conn->query("SELECT * FROM `stock_list` where id in ($stock_ids) and item_id = '{$row['item_id']}'
                                ");
                                $row['cot9'] = $cot9->num_rows > 0 ? $cot9->fetch_assoc()['cotacao_3_2'] : $row['cot9'];




                                $bot1 = $conn->query("SELECT * FROM `stock_list` where id in ($stock_ids) and item_id = '{$row['item_id']}'");
                                $row['bot1'] = $bot1->num_rows > 0 ? $bot1->fetch_assoc()['botao_cot1'] : $row['bot1'];
                            }
                        ?>
                        <tr>
                           <!--  <td class="py-1 px-2 text-center">
                                <button class="btn btn-outline-danger btn-sm rem_row" type="button"><i class="fa fa-times"></i></button>
                            </td> -->

                            <td class="text-center cod_item" style="max-width:110px;" >
                            <?php echo $row['cod_item']; ?>
                            </td>

                            <td class="item" style="min-width:250px;">
                            <div style="width:100%;">
                            <?php echo $row['name']; ?> <br>
                            <?php echo $row['description']; ?>
                            </div>
                            </td>

                            <td class="text-center qty">
                                <input type="number" step="any" class="select2 text-center" name="qty[]" tabindex="-1" style="width:70px !important" value="<?php echo $row['qty']; ?>">
                                <input type="hidden" name="cod_item[]" value="<?php echo $row['cod_item']; ?>">
                                <input type="hidden" name="item_id[]" value="<?php echo $row['item_id']; ?>">
                                <input type="hidden" name="oqty[]" value="<?php echo $row['quantity']; ?>">
                                <input type="hidden" name="unit[]" value="<?php echo $row['unit']; ?>">
                                <input type="hidden" name="obs_item[]" value="<?php echo $row['obs_item']; ?>">
                                <input type="hidden" name="prev_data[]" value="<?php echo $row['prev_data']; ?>">
                                <input type="hidden" name="price[]" value="<?php echo $row['price']; ?>">
                                <input type="hidden" name="total[]" value="<?php echo $row['total']; ?>">
                                <input type="hidden" name="ocot1[]" value="<?php echo $row['cotacao_1_0']; ?>">
                                <input type="hidden" name="ocot2[]" value="<?php echo $row['cotacao_1_1']; ?>">
                                <input type="hidden" name="ocot3[]" value="<?php echo $row['cotacao_1_2']; ?>">
                                <input type="hidden" name="ocot4[]" value="<?php echo $row['cotacao_2_0']; ?>">
                                <input type="hidden" name="ocot5[]" value="<?php echo $row['cotacao_2_1']; ?>">
                                <input type="hidden" name="ocot6[]" value="<?php echo $row['cotacao_2_2']; ?>">
                                <input type="hidden" name="ocot7[]" value="<?php echo $row['cotacao_3_0']; ?>">
                                <input type="hidden" name="ocot8[]" value="<?php echo $row['cotacao_3_1']; ?>">
                                <input type="hidden" name="ocot9[]" value="<?php echo $row['cotacao_3_2']; ?>">


                                <input type="hidden" name="obot1[]" value="<?php echo $row['botao_cot1']; ?>">
                            </td>
                            
                            <td align="center" class="" style="<?php echo $etapa_mat_ou_ser == 1 ? "" : "display:none;" ?>">
                            <div style="width: 100px;">
                            <?php echo ($row['unit']) ?>
                            </div>
                            </td>
                            
                            <!-- <td class="obs_item" style="min-width:250px;">
                            <div class="width:100%;">
                            <.?php echo $row['obs_item']; ?>
                            </div>
                            </td> -->

        <td class="obs_item">
        <div class="content esconderTexto">
        <div style="width:100%; min-width:250px; max-width:250px;">
        <?php echo $row['obs_item']; ?>
        </div>
        </div>
        <?php if (mb_strlen($row['obs_item'], 'UTF-8') > 55 ) { ?>
        <div class="mostrarMais">
        <a href="javascript:void();" class="btn-r btn btn-outline-primary btn-sm">Expandir</a>
        </div>
        <?php } ?>
        </td>

                            <td class="obs_item" style="min-width:200px;">
                            <?php echo $row['fornecedor_item']; ?>
                            </td>

                            <td class="text-center prev_data" style="min-width:100px;">
                            <?php echo date("d-m-Y", strtotime($row['prev_data'])) ?>
                            <!-- <.?php echo $row['prev_data']; ?> -->
                            </td>


                            <td class="py-1 px-2 cotacao_1">

                            <div style="display: none;">

                            <!-- botao da escolha da cotação -->
                            <input type="text" name="bot1[]" class="from-group" value="<?php echo $row['bot1'];?>">

                            <!-- cotacao 1 -->
                            <div class="col-12 col-sm-4 col-md-4">
                            <label for="cotacao_1_0" class="control-label">Fornecedor</label><br>
                            <input type="text" tabindex="-1" class="form-control select2 input-cotacao" name="cot1[]" value="<?php echo $row['cot1']; ?>">
                            </div>

                            <div class="col-12 col-sm-4 col-md-4">
                            <label for="cotacao_1_1" class="control-label">Valor Total</label><br>
                            <input type="text" tabindex="-1" step="any" class="form-control select2 input-cotacao" name="cot2[]" value="<?php echo $row['cot2']; ?>">
                            </div>

                            <div class="col-12 col-sm-4 col-md-4">
                            <label for="cotacao_1_2" class="control-label">Frete</label><br>
                            <input type="text" tabindex="-1" step="any" class="form-control select2 input-cotacao" name="cot3[]" value="<?php echo $row['cot3']; ?>">
                            </div>
                            
                            <!-- cotacao 2 -->

                            <div class="col-12 col-sm-4 col-md-4">
                            <label for="cotacao_2_0" class="control-label">Fornecedor</label><br>
                            <input type="text" tabindex="-1" class="form-control select2 input-cotacao" name="cot4[]" value="<?php echo $row['cot4']; ?>">
                            </div>

                            <div class="col-12 col-sm-4 col-md-4">
                            <label for="cotacao_2_1" class="control-label">Valor Total</label><br>
                            <input type="text" tabindex="-1" step="any" class="form-control select2 input-cotacao" name="cot5[]" value="<?php echo $row['cot5']; ?>">
                            </div>

                            <div class="col-12 col-sm-4 col-md-4">
                            <label for="cotacao_2_2" class="control-label">Frete</label><br>
                            <input type="text" tabindex="-1" step="any" class="form-control select2 input-cotacao" name="cot6[]" value="<?php echo $row['cot6']; ?>">
                        </div>

                            <!-- cotacao 3 -->

                            <div class="col-12 col-sm-4 col-md-4">
                            <label for="cotacao_3_0" class="control-label">Fornecedor</label><br>
                            <input type="text" tabindex="-1" class="form-control select2 input-cotacao" name="cot7[]" value="<?php echo $row['cot7']; ?>">
                            </div>

                            <div class="col-12 col-sm-4 col-md-4">
                            <label for="cotacao_3_1" class="control-label">Valor Total</label><br>
                            <input type="text" tabindex="-1" step="any" class="form-control select2 input-cotacao" name="cot8[]" value="<?php echo $row['cot8']; ?>">
                            </div>

                            <div class="col-12 col-sm-4 col-md-4">
                            <label for="cotacao_3_2" class="control-label">Frete</label><br>
                            <input type="text" tabindex="-1" step="any" class="form-control select2 input-cotacao" name="cot9[]" value="<?php echo $row['cot9']; ?>">
                            </div>

                            </div><!-- fim hidden div -->
                      
                            <div class="row justify-content-around" style="min-width:400px;">
                            <?php if ($row['bot1']==='0'){ ?> <!-- cotacao 1 -->
                            
                            <div style="min-width: 150px;">
                            <strong>Fornecedor</strong><br>
                            <?php echo $row['cot1']?> <!-- resultado 1 -->
                            </div>

                            <div>
                            <strong>Valor total</strong><br>
                            <?php
                            echo 'R$ ';
                            echo number_format($row['cot2'], 2, ',', '.'); ?> <!-- resultado 1 -->

                            </div>

                            <div>
                            <strong>Frete</strong><br>
                            <?php
                            echo 'R$ ';
                            echo number_format($row['cot3'], 2, ',', '.'); ?> <!-- resultado 1 -->
                            </div>

                            <?php }
                             elseif ($row['bot1']==='1'){ ?> <!-- cotacao 2 -->

                            <div>
                            <strong>Fornecedor</strong><br>
                            <?php echo $row['cot4']?> <!-- resultado 2 -->
                            </div>

                            <div>
                            <strong>Valor total</strong><br>
                            <?php
                            echo 'R$ ';
                            echo number_format($row['cot5'], 2, ',', '.'); ?> <!-- resultado 2 -->
                            </div>

                            <div>
                            <strong>Frete</strong><br>
                            <?php
                            echo 'R$ ';
                            echo number_format($row['cot6'], 2, ',', '.'); ?> <!-- resultado 2 -->
                            </div>

                            <?php } 
                             elseif ($row['bot1']==='2'){ ?> <!-- cotacao 3 -->
                            
                            <div>
                            <strong>Fornecedor</strong><br>
                            <?php echo $row['cot7']?> <!-- resultado 3 -->
                            </div>

                            <div>
                            <strong>Valor total</strong><br>
                            <?php
                            echo 'R$ ';
                            echo number_format($row['cot8'], 2, ',', '.'); ?> <!-- resultado 3 -->
                            </div>

                            <div>
                            <strong>Frete</strong><br>
                            <?php
                            echo 'R$ ';
                            echo number_format($row['cot9'], 2, ',', '.'); ?> <!-- resultado 3 -->
                            </div>   
                            <?php }  
                            ?>
                            </div>

                            </td>

                        </tr>
                        <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                </div>
<br>
        <?php if(!empty($obs_cotacao)) { ?>
        <div class="row justify-content-around">
        <div class="col-md-6 text-center">
            <div class="form-group">
                <label for="obs_cotacao" class="control-label">Observações da Cotação</label>
                <p style="width: 100%;"><?php echo isset($obs_cotacao) ? $obs_cotacao : '' ?></p>
            </div>
        </div>
    </div>
    <?php } ?>
                    <!-- DIV AUTORIZAÇÃO -->
                    
                    <div class="form-group" style="display:none;">
                        <label for="estado_requisicao" class="control-label">Unidade Requisitante</label>
                        <select name="estado_requisicao" id="estado_requisicao" class="custom-select select2" required>
                            <option value="" disabled>Selecione a unidade</option>
                            <option value="1" <?php echo isset($estado_requisicao) && $estado_requisicao == 1 ? 'selected' : '' ?>>autorizacao</option>
                            <option value="0" <?php echo isset($estado_requisicao) && $estado_requisicao == 0 ? 'selected' : '' ?>>solicitacao</option>
                            <option value="2" <?php echo isset($estado_requisicao) && $estado_requisicao == 2 ? 'selected' : '' ?>>cotacao</option>
                            <option value="3" <?php echo isset($estado_requisicao) && $estado_requisicao == 3 ? 'selected' : '' ?>>aprovacao</option>
                            <option value="4" <?php echo isset($estado_requisicao) && $estado_requisicao == 4 ? 'selected' : '' ?>>omie</option>
                            <option value="5" <?php echo isset($estado_requisicao) && $estado_requisicao == 5 ? 'selected' : '' ?>>chegada</option>
                            <option value="6" <?php echo isset($estado_requisicao) && $estado_requisicao == 6 ? 'selected' : '' ?>>financeiro</option>
                            <option value="7" selected <?php echo isset($estado_requisicao) && $estado_requisicao == 7 ? 'selected' : '' ?>>servico</option>
                        </select>
                    </div>
                    
                    <!-- ETAPA CONCLUÍDA -->
<div style="display:none;">
<select name="etapa_servico" id="etapa_servico" class="select2" style="width:100%">
                            <option selected value="1" <?php echo isset($etapa_servico) && $etapa_servico == 1 ? 'selected' : '' ?>>concluido</option>
                        </select>
                        </div>


            </div> <!-- FECHA CONTAINER -->
    </div> <!-- card body -->
    </div> <!-- card total -->


<!-- PARTE SERVIÇO -->

<?php 
$servicoURL1 = base_url . '/admin/anexo/upload_servico/'.$po_code.'-recibo.pdf';
$servicoURL2 = base_url . '/admin/anexo/upload_servico/'.$po_code.'-nf.pdf';
$servicoURL3 = base_url . '/admin/anexo/upload_servico/'.$po_code.'-contrato.pdf';
?>

<div class="card card-outline card-primary">
<div class="card-header">
    <h4 class="card-title"><strong>SERVIÇO</strong></h4>
    </div>
<div class="card-body">

<div class="row justify-content-around">



<div id="pergunta-servico" class="text-center col-md-6" >

    <div class="btn-group btn-group-toggle center" data-toggle="buttons" style="height: 100%; display: flex; align-items: center;">
        <div>
            <label class="btn btn-rounded bt-active0 first0">
                <input class="escolha-servico" type="radio" id="servico_pagamento" name="servico_pagamento" value="0" <?php echo isset($servico_pagamento) && $servico_pagamento == 0 ? 'selected' : '' ?>> Recibo
            </label>
            <label class="btn btn-rounded bt-active1 first1">
                <input class="escolha-servico" type="radio" id="servico_pagamento" name="servico_pagamento" value="1" <?php echo isset($servico_pagamento) && $servico_pagamento == 1 ? 'selected' : '' ?>> Nota Fiscal
            </label>
        </div>
    </div>
    
</div> <!-- fim div pergunta-servico -->


<div id="div-recibo" class="text-center col-md-12 my-auto" >
<br><br>
<div class="col text-center mx-auto dropZoneContainer" style="max-width: 283px; height:108px">
<input id="servico_anexo1" name="servico_anexo1" type="file" onchange="setfilename1(this.value);" class="FileUpload" accept="application/pdf">
<div class="dropZoneOverlay"> <strong>Recibo</strong> <br> Arraste ou clique para adicionar um arquivo <br>
<input id="uploadFile1" name="uploadFileOne" type="text" disabled="disabled" placeholder="Nenhum arquivo selecionado" class="name-info-form file-witdth" />
</div>
<?php if(empty($servico_anexo1)){
}
else{ ?>
<div class="visua">
<a href="<?php echo $servicoURL1; ?>" target="_blank" rel="noopener noreferrer"><?php echo $servico_anexo1; ?></a><br>
</div>
<?php } ?>
</div>

</div> <!-- fim não contratual -->

<div id="div-nf" class="text-center col-md-6" >

<div class="btn-group btn-group-toggle center" data-toggle="buttons" style="height: 100%; display: flex; align-items: center;">
<div>
  <label class="btn btn-rounded bt-active0 second0">
  <input class="servico-contrato" id="servico_contrato" type="radio" name="servico_contrato" value="0" <?php echo isset($servico_contrato) && $servico_contrato == 0 ? 'selected' : '' ?>> Sem Contrato
  </label>
  
  <label class="btn btn-rounded bt-active1 second1">
    <input class="servico-contrato" id="servico_contrato" type="radio" name="servico_contrato" value="1" <?php echo isset($servico_contrato) && $servico_contrato == 1 ? 'selected' : '' ?>> Contrato
  </label>
  </div>
</div>
</div> <!-- fim div nf -->


<div id="nao-contratual"class="text-center col-md-6 my-auto" >
<br><br>
<label for="nf_num_servico">NF.</label>
<input class="col-8 col-sm-6 col-md-8 col-lg-6 col-xl-4 text-center" type="number" name="nf_num_servico" id="nf_num_servico">
<br><br>
<div class="col mx-auto text-center dropZoneContainer" style="max-width: 283px; height:108px; display:inline-block;">
<input id="servico_anexo2" name="servico_anexo2" type="file" onchange="setfilename2(this.value);" class="FileUpload anexo2" accept="application/pdf">
<div class="dropZoneOverlay"><strong>Nota Fiscal</strong> <br> Arraste ou clique para adicionar um arquivo <br>
<input id="uploadFile2" name="uploadFileOne" type="text" disabled="disabled" placeholder="Nenhum arquivo selecionado" class="name-info-form file-witdth" />
</div>
<?php if(empty($servico_anexo2)){
}
else{ ?>
<div class="visua">
<a href="<?php echo $servicoURL2; ?>" target="_blank" rel="noopener noreferrer"><?php echo $servico_anexo2; ?></a>
</div>
<?php } ?>
</div>
</div> <!-- fim não contratual -->


<div id="contratual" class="text-center col-md-6 my-auto">
<br><br><br><br>
<div class="col mx-auto text-center dropZoneContainer" style="max-width: 283px; height:108px; display:inline-block;">            <!-- accept="image/jpeg,image/gif,image/png,application/pdf,image/application/pdf,application/vnd.ms-excel" -->
<input id="servico_anexo3" name="servico_anexo3" type="file" onchange="setfilename3(this.value);" class="FileUpload anexo3" accept="application/pdf">
<div class="dropZoneOverlay"><strong>Contrato</strong> <br> Arraste ou clique para adicionar um arquivo <br>
<input id="uploadFile3" name="uploadFileOne" type="text" disabled="disabled" placeholder="Nenhum arquivo selecionado" class="name-info-form file-witdth" />
</div>
<?php if(empty($servico_anexo3)){
}
else{ ?>
<div class="visua">
<a href="<?php echo $servicoURL3; ?>" target="_blank" rel="noopener noreferrer"><?php echo $servico_anexo3; ?></a>
</div>
<?php } ?>
</div>
</div> <!-- fim contratual -->


</div> <!-- fim row -->

<script>

// NOVO SCRIPT PARA SERVIÇO
function setfilename1(val)
{ var fileName = val.substr(val.lastIndexOf("\\")+1, val.length);
document.getElementById("uploadFile1").value = fileName; };

function setfilename2(val)
{ var fileName = val.substr(val.lastIndexOf("\\")+1, val.length);
document.getElementById("uploadFile2").value = fileName; };

function setfilename3(val)
{ var fileName = val.substr(val.lastIndexOf("\\")+1, val.length);
document.getElementById("uploadFile3").value = fileName; };

$('#file-upload1').change(function() {
  var i = $(this).prev('label').clone();
  var file = $('#file-upload1')[0].files[0].name;
  $(this).prev('label').text(file);
});

$('#file-upload2').change(function() {
  var i = $(this).prev('label').clone();
  var file = $('#file-upload2')[0].files[0].name;
  $(this).prev('label').text(file);
});

$('#file-upload3').change(function() {
  var i = $(this).prev('label').clone();
  var file = $('#file-upload3')[0].files[0].name;
  $(this).prev('label').text(file);
});

$(document).ready(function() {

  // esconde as divs no início
  $("#contratual").hide();
  $("#nao-contratual").hide();
  $("#div-recibo").hide();
  $("#div-nf").hide();

  $("input[name='servico_pagamento']").change(function() {
    if ($(this).val() == "0") {
      // se a opção RECIBO foi selecionada
      $("#div-recibo").show();
      $("#div-nf").hide();
      $("#contratual").hide();
      $("#nao-contratual").hide();

    // redefinir a seleção da classe "servico-contrato"
    $(".servico-contrato").prop("checked", false);
    
    // redefinir a cor dos botões da classe "servico-contrato"
    $(".first0").css("background-color", "#00864A");

    $(".second0").css("background-color", "#6c757d");
    $(".second1").css("background-color", "#6c757d");

    // remover valor do input anexo1
  if ($("#servico_anexo2").val()) {
    $("#servico_anexo2").val(null);
    $("#uploadFile2").val("Nenhum arquivo selecionado");
  }

  // remover valor do input anexo1
  if ($("#servico_anexo3").val()) {
    $("#servico_anexo3").val(null);
    $("#uploadFile3").val("Nenhum arquivo selecionado");
  }

    // remover valor do input NF
    if ($("#nf_num_servico").val()){
    $("#nf_num_servico").val(null);
  }

    } else if ($(this).val() == "1") {
      // se a opção NOTA FISCAL foi selecionada
      $("#div-nf").show();
      $("#div-recibo").hide();

      $(".first0").css("background-color", "#6c757d");

// remover valor do input anexo1
  if ($("#servico_anexo1").val()) {
    $("#servico_anexo1").val(null);
    $("#uploadFile1").val("Nenhum arquivo selecionado");
  }
    }
  });

  $("input[name='servico_contrato']").change(function() {
    if ($(this).val() == "0") {
      // se a opção Sem Contrato foi selecionada
      $("#div-nf").show();
      $("#nao-contratual").show();
      $("#div-recibo").hide();
      $("#contratual").hide();

    $(".second0").css("background-color", "#00864A");
    $(".second1").css("background-color", "#6c757d");

    if ($("#servico_anexo3").val()) {
    $("#servico_anexo3").val(null);
    $("#uploadFile3").val("Nenhum arquivo selecionado");
  }

    } else if ($(this).val() == "1") {
      // se a opção Contratual foi selecionada
      $("#div-nf").show();
      $("#contratual").show();
      $("#div-recibo").hide();
      $("#nao-contratual").show();

    $(".second0").css("background-color", "#6c757d");
    $(".second1").css("background-color", "#00864A");
    }
  });
});

$("input[name='servico_pagamento']").change(function() {
  if ($(this).val() == "0") {
    // se a opção RECIBO foi selecionada
    $("#div-recibo").show();
    $("#div-nf").hide();
    $("#contratual").hide();
    $("#nao-contratual").hide();

    // remover/resetar valores da classe servico-contrato
    $("input.servico-contrato").removeAttr("checked");
  } else if ($(this).val() == "1") {

    // se a opção NOTA FISCAL foi selecionada
    $("#div-nf").show();
    $("#div-recibo").hide();
    
  }
});

</script>


</div> <!--  card body -->
</div> <!-- card outline -->


<!-- PARTE ANEXOS -->

<?php if(empty($file_name6) && empty($file_name1) && empty($file_name2) && empty($file_name3) && empty($file_name4) && empty($file_name5)){
 ?>
 <div class="card card-outline card-primary">
 <div class="card-header">
    <h4 class="card-title"><strong>ANEXOS</strong></h4>
    </div>
<div class="card-body">
<div class="text-center"><i><strong>Requisição sem anexos</strong></i></div>
</div>
 </div>
 <?php } 
else{ ?> 

<div class="card card-outline card-primary">

<div class="card-header">
    <h4 class="card-title"><strong>ANEXOS</strong></h4>
    </div>
<div class="card-body">
      

<?php 
        $imageURL1 = base_url . '/admin/anexo/upload_requisicao/'.$file_name1;
        $imageURL2 = base_url . '/admin/anexo/upload_requisicao/'.$file_name2;
        $imageURL3 = base_url . '/admin/anexo/upload_requisicao/'.$file_name3;
        $imageURL4 = base_url . '/admin/anexo/upload_requisicao/'.$file_name4;
        $imageURL5 = base_url . '/admin/anexo/upload_requisicao/'.$file_name5;
        $pdfURL1 = base_url . '/admin/anexo/upload_requisicao/'.$file_name6;
        ?>

<!-------------------------------------------------- FILE 6 -------------------------------------------->
<div class="row d-flex flex-column text-center">
<div class="p-2">
<?php if(empty($file_name6)){
}
else{ ?>
<!-- MOSTRAR FILE_NAME6 -->
<a class="btn btn-outline-primary btn-sm" data-toggle="collapse" href="#collapseImagem6" role="button" aria-expanded="false" aria-controls="collapseImagem6">
<i class="fa-solid fa-paperclip"></i> Exibir Anexo</a>
<?php } ?>
<!-- MOSTRAR FILE_NAME1 -->
<?php if(empty($file_name1)){
}
else{ ?>
<a class="btn btn-outline-primary btn-sm" data-toggle="collapse" href="#collapseImagem1" role="button" aria-expanded="false" aria-controls="collapseImagem1">
<i class="fa-solid fa-paperclip"></i> Exibir Anexo</a>
<?php } ?>

<!-- MOSTRAR FILE_NAME2 -->
<?php if(empty($file_name2)){
}
else{ ?>
<a class="btn btn-outline-primary btn-sm" data-toggle="collapse" href="#collapseImagem2" role="button" aria-expanded="false" aria-controls="collapseImagem2">
<i class="fa-solid fa-paperclip"></i> Exibir Anexo</a>
<?php } ?>
<!-- MOSTRAR FILE_NAME3 -->
<?php if(empty($file_name3)){
}
else{ ?>
<a class="btn btn-outline-primary btn-sm" data-toggle="collapse" href="#collapseImagem3" role="button" aria-expanded="false" aria-controls="collapseImagem3">
<i class="fa-solid fa-paperclip"></i> Exibir Anexo</a>
<?php } ?>
<!-- MOSTRAR FILE_NAME4 -->
<?php if(empty($file_name4)){
}
else{ ?>
<a class="btn btn-outline-primary btn-sm" data-toggle="collapse" href="#collapseImagem4" role="button" aria-expanded="false" aria-controls="collapseImagem4">
<i class="fa-solid fa-paperclip"></i> Exibir Anexo</a>
<?php } ?>
<!-- MOSTRAR FILE_NAME5 -->
<?php if(empty($file_name5)){
}
else{ ?>
<a class="btn btn-outline-primary btn-sm" data-toggle="collapse" href="#collapseImagem5" role="button" aria-expanded="false" aria-controls="collapseImagem5">
<i class="fa-solid fa-paperclip"></i> Exibir Anexo</a>
<?php } ?>

</div>
</div>
<!-------------------------------------------- FIM ---------------------------------------------------->
<!-------------------------------------------------- FILE 1 -------------------------------------------->

 <!-- div collapse -->
<div class="collapse multi-collapse text-center" id ="collapseImagem1">
 <!-- download file_name1 -->
 <a href="<?php echo $imageURL1; ?>" target="_blank" rel="noopener noreferrer">Download / Visualização</a><br>
    <img src="<?php echo $imageURL1; ?>" alt="" width="10%"/>
    </div>
<!-------------------------------------------- FIM ---------------------------------------------------->
<!-------------------------------------------------- FILE 2 -------------------------------------------->

 <!-- div collapse -->
<div class="collapse multi-collapse text-center" id ="collapseImagem2">
 <!-- download file_name2 -->
 <a href="<?php echo $imageURL2; ?>" target="_blank" rel="noopener noreferrer">Download / Visualização</a><br>
    <img src="<?php echo $imageURL2; ?>" alt="" width="10%"/>
    </div>
<!-------------------------------------------- FIM ---------------------------------------------------->
<!-------------------------------------------------- FILE 3 -------------------------------------------->

 <!-- div collapse -->
<div class="collapse multi-collapse text-center" id ="collapseImagem3">
 <!-- download file_name3 -->
 <a href="<?php echo $imageURL3; ?>" target="_blank" rel="noopener noreferrer">Download / Visualização</a><br>
    <img src="<?php echo $imageURL3; ?>" alt="" width="10%"/>
    </div>
<!-------------------------------------------- FIM ---------------------------------------------------->
<!-------------------------------------------------- FILE 4 -------------------------------------------->

 <!-- div collapse -->
<div class="collapse multi-collapse text-center" id ="collapseImagem4">
 <!-- download file_name4 -->
 <a href="<?php echo $imageURL4; ?>" target="_blank" rel="noopener noreferrer">Download / Visualização</a><br>
    <img src="<?php echo $imageURL4; ?>" alt="" width="10%"/>
    </div>
<!-------------------------------------------- FIM ---------------------------------------------------->
<!-------------------------------------------------- FILE 5 -------------------------------------------->

 <!-- div collapse -->
<div class="collapse multi-collapse text-center" id ="collapseImagem5">
 <!-- download file_name5 -->
 <a href="<?php echo $imageURL5; ?>" target="_blank" rel="noopener noreferrer">Download / Visualização</a><br>
    <img src="<?php echo $imageURL5; ?>" alt="" width="10%"/>
    </div>
<!-------------------------------------------- FIM ---------------------------------------------------->
<!-------------------------------------------------- FILE 6 -------------------------------------------->

 <!-- div collapse -->
 <div class="collapse multi-collapse text-center" id ="collapseImagem6">
 <!-- download file_name6 -->
 <a href="<?php echo $pdfURL1; ?>" target="_blank" rel="noopener noreferrer">Download / Visualização</a><br>
    <img src="<?php echo $pdfURL1; ?>" alt="" width="10%"/>
    </div>
<!-------------------------------------------- FIM ---------------------------------------------------->
                  
               
</div> <!-- card body -->
        </div> <!-- card -->

<?php } ?>


 <!-- PARTE Autorização -->

 <div class="card card-outline card-primary">
 <div class="card-header">
    <h4 class="card-title"><strong>AUTORIZAÇÃO</strong></h4>
    </div>
 <div class="card-body">
        <div class="row justify-content-around">
        <div class="col-12 col-sm-6 col-md-3 text-center">
                        <label for="nome_autorizacao" class="control-label">Nome</label>
                        <input type="text" tabindex="-1" name="nome_autorizacao" id="nome_autorizacao" class="select2 text-center" style="width:100%;" value="<?php echo isset($nome_autorizacao) ? $nome_autorizacao : ''; ?>">
                        </div>

                        <?php if(!empty($obs_autorizacao)) { ?>
                        <div class="col-12 col-sm-12 col-md-6 text-center">
                        <div class="form-group">
                            <label for="obs_autorizacao" class="control-label">Observação</label>
                            <p style="width: 100%;"><?php echo isset($obs_autorizacao) ? $obs_autorizacao : '' ?></p>
                        </div>
                    </div>
                    <?php } ?>
                    
                        <div class="col-12 col-sm-6 col-md-3 text-center">
                                <label for="data_autorizacao" class="control-label">Data</label>
                                <input type="date" tabindex="-1" name="data_autorizacao" id="data_autorizacao" class="select3 text-center" style="width:100%;" value="<?php echo isset($data_autorizacao) ? $data_autorizacao : ''; ?>">
                        </div>  
                    </div>
 </div> <!-- card body -->
        </div> <!-- card -->

<!-- PARTE APROVAÇÃO -->
<div class="card card-outline card-primary">
<div class="card-header">
    <h4 class="card-title"><strong>APROVAÇÃO</strong></h4>
    </div>
<div class="card-body">

        <div class="row justify-content-around">

        <div class="col-12 col-sm-6 col-md-3 text-center">
                        <label for="nome_aprovacao" class="control-label">Nome</label>
                        <input type="text" tabindex="-1" name="nome_aprovacao" id="nome_aprovacao" style="width:100%;" class="select2 text-center" value="<?php echo isset($nome_aprovacao) ? $nome_aprovacao : ''; ?>" readonly>
                        </div>

                        <?php if(!empty($obs_aprovacao)) { ?>
                        <div class="col-12 col-sm-12 col-md-6 text-center">
                        <div class="form-group">
                            <label for="obs_aprovacao" class="control-label">Observação Aprovação</label>
                            <p style="width: 100%;"><?php echo isset($obs_aprovacao) ? $obs_aprovacao : '' ?></p>
                            <!-- <textarea name="obs_aprovacao" tabindex="-1" name="obs_aprovacao" id="obs_aprovacao" style="width:100%; border:0;" rows="3" class="text-center" readonly><?php echo isset($obs_aprovacao) ? $obs_aprovacao : ''; ?></textarea> -->
                        </div>
                    </div>
                    <?php } ?>



                        <div class="col-12 col-sm-6 col-md-3 text-center">
                                <label for="data_aprovacao" class="control-label">Data</label>
                                <input type="date" tabindex="-1" name="data_aprovacao" id="data_aprovacao" style="width:100%;" class="select3 text-center" value="<?php echo isset($data_aprovacao) ? $data_aprovacao : ''; ?>">
                        </div>


                        
                    </div>
</div>
                </div>

<br>


    </form> <!-- FECHA ORDER -->

    <div class="footer fixed-bottom card-footer">
    <button type="submit" style="display: none;" aria-hidden="true" form="receive-form" disabled> </button>
    <a class="col-2 col-sm-2 col-md-2 btn btn-outline-dark" href="<?php echo base_url.'/admin?page=servico' ?>"><strong>Voltar</strong></a>
        <button class="col-2 col-sm-2 col-md-2 btn btn-outline-success" type="submit" form="receive-form"><strong>Salvar</strong></button>
        
    </div>

   <div id="result">

   </div>

<script>

$(".mostrarMais a").on("click", function() {
    var $this = $(this); 
    var $content = $this.parent().prev("div.content");
    var linkText = $this.text().toUpperCase();    
    
    if(linkText === "EXPANDIR"){
        linkText = "Ocultar";
        $content.switchClass("esconderTexto", "mostrarTexto", 100);
    } else {
        linkText = "Expandir";
        $content.switchClass("mostrarTexto", "esconderTexto", 100);
    };

    $this.text(linkText);
});

$(document).ready(function () {

var table = $('#list_servico').DataTable({
    paging:false,
    "lengthChange": false,
    "searching": false,
    "bInfo" : false,
    "ordering": false,
    "columnDefs": [
        {
        "targets": 0, // cod
        visible: false,
         },
         {
        "targets": 5, // fornecedor
         visible: false,
         },
         {
         "targets": 6, // data
         visible:false,
         },
],
fixedColumns:   {
            right: 0,
        },
    language: {
			url: 'http://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
		}
    })

    $('a.toggle-vis').on('click', function (e) {
    e.preventDefault();
 
    // Get the column API object
    var column = table.column($(this).attr('data-column'));

    // Toggle the visibility
    column.visible(!column.visible());

    });
});

$('#receive-form').submit(function(e) {
    e.preventDefault();
    var _this = $(this)
    $('.err-msg').remove();

    var escolhaServicoSelecionado = $(".escolha-servico:checked").val();
    var anexo1 = $("#servico_anexo1").val();
    if (escolhaServicoSelecionado == 0 && anexo1 != "") {
        // "Recibo" esta selecionado

        start_loader();
        $.ajax({
				url:_base_url_+"classes/Master.php?f=save_receiving",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err);
					alert_toast("Ocorreu um erro",'error');
					end_loader();
				},
				success:function(resp){
					if(resp.status == 'success'){
                        location.replace(_base_url_+"admin/?page=servico");
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>');
                            el.addClass("alert alert-danger err-msg").text(resp.msg);
                            _this.prepend(el);
                            el.show('slow');
                            end_loader();
                    }else{
						alert_toast("Ocorreu um erro",'error');
						end_loader();
                        console.log(resp);
					}
                    $('html,body').animate({scrollTop:0},'fast')
				}
			})
    } else {
        // "Nota Fiscal" esta selecionado
        var servicoContratoSelecionado = $(".servico-contrato:checked").val();
        var anexo2 = $(".anexo2").val();
        var anexo3 = $(".anexo3").val();
        if (servicoContratoSelecionado === undefined ||(servicoContratoSelecionado === 0 || anexo2 === "") ||(servicoContratoSelecionado === 1 && (anexo2 === "" || anexo3 === ""))){
            // "servico-contrato" radio button not selected, so show error message
            var el = $('<div class="text-center">');
            el.addClass("alert alert-danger err-msg").text("Selecione as informações do serviço e realize os anexos");
            $(this).prepend(el);
            el.show('slow');
            $('html,body').animate({ scrollTop: 0 }, 'fast');
            return false;
        } else {

            // "servico-contrato" radio button selected, so proceed with saving the form data
            start_loader();
            $.ajax({
				url:_base_url_+"classes/Master.php?f=save_receiving",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err);
					alert_toast("Ocorreu um erro",'error');
					end_loader();
				},
				success:function(resp){
					if(resp.status == 'success'){
                        location.replace(_base_url_+"admin/?page=servico");
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>');
                            el.addClass("alert alert-danger err-msg").text(resp.msg);
                            _this.prepend(el);
                            el.show('slow');
                            end_loader();
                    }else{
						alert_toast("Ocorreu um erro",'error');
						end_loader();
                        console.log(resp);
					}
                    $('html,body').animate({scrollTop:0},'fast')
				}
			})
        }
    }
});

</script>