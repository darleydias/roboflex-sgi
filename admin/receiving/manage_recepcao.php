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
.hidden {
display: none;
}

table#list_recepcao.dataTable tbody tr:hover {
background-color: #ffa;
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

table.dataTable thead tr>
.dtfc-fixed-left,table.dataTable thead tr>
.dtfc-fixed-right,table.dataTable tfoot tr>
.dtfc-fixed-left,table.dataTable tfoot tr>
.dtfc-fixed-right{
    top:0;
    bottom:0;
    z-index:3;
    background-color:#001f3f
}
table.dataTable tbody tr>
.dtfc-fixed-left,table.dataTable tbody tr>
.dtfc-fixed-right{
    z-index:1;
    background-color:#f4f6f9
}
div.dtfc-left-top-blocker,div.dtfc-right-top-blocker{
    background-color:white
}
body{
    zoom: 90%;
}

table{
font-size: small;
}
</style>

<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.2.1/js/dataTables.fixedColumns.min.js"></script>
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<form action="" id="receive-form">

<div class="card card-outline card-primary">
    <div class="card-header">
        <h4 class="card-title"><strong><?php echo 'REQUISIÇÃO ' .$po_code ?></strong></h4>
    </div>

    <div class="card-body">
        
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
            
          <br>
          <?php if(!empty($remarks)) { ?>
          <div class="row justify-content-around">
          <div class="col" style="width:100%;">
                <div class="form-group text-center">
                <label for="remarks" class="control-label">Observações da Requisição</label>
                <textarea name="remarks" id="remarks" rows="6" class="form-control rounded-0 text-center" readonly><?php echo isset($remarks) ? $remarks : '' ?></textarea>
                </div>
                </div>
                </div>
                <?php } ?>
          <br>
                <?php echo $etapa_mat_ou_ser == 1 ? "<h5 class='text-center'><a style='color:#f29f05'>MATERIAIS</a> SOLICITADOS</h5>" : "<h5 class='text-center'><a style='color:#035aa6'>SERVIÇOS</a> SOLICITADOS</h5>" ?>
              <br>
              
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
                <table class="table table-striped table-bordered tabela-form-r" id="list_recepcao" style="width:100%;">
                    <thead>
                        <tr class="text-light bg-navy">
                        <!-- <th class="text-center py-1 px-2 align-middle">#</th> -->
                            <th class="text-center py-1 px-2 align-middle">Código</th>
                            <th class="text-center py-1 px-2 align-middle">Nome e Descrição</th>
                            <th class="text-center py-1 px-2 align-middle">Qtde</th>
                            <th class="text-center py-1 px-2 align-middle">Tipo</th>
                            <th class="text-center py-1 px-2 align-middle">Observação</th>
                            <th class="text-center py-1 px-2 align-middle">Ind. Fornecedor</th>
                            <th class="text-center py-1 px-2 align-middle">Data Previsão</th>
                            <th class="text-center py-1 px-2 align-middle">Valores</th>
                            <th class="text-center py-1 px-2 align-middle">Pedido Omie</th>
                            <th class="text-center py-1 px-2 align-middle">Nota Fiscal</th>
                            <th class="text-center py-1 px-2 align-middle">Recebido</th>
                            <th class="text-center py-1 px-2 align-middle">Conforme</th>
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
                            $row['ped1'] = $row['pedido_omie'];
                            $row['ped2'] = $row['notafiscal_rec'];
                            $row['ped3'] = $row['recebido_rec'];
                            $row['ped4'] = $row['conforme_rec'];
                            $row['ped5'] = $row['datarec_rec'];
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

                                $ped1 = $conn->query("SELECT * FROM `stock_list` where id in ($stock_ids) and item_id = '{$row['item_id']}'");
                                $row['ped1'] = $ped1->num_rows > 0 ? $ped1->fetch_assoc()['pedido_omie'] : $row['ped1'];

                                $ped2 = $conn->query("SELECT * FROM `stock_list` where id in ($stock_ids) and item_id = '{$row['item_id']}'");
                                $row['ped2'] = $ped2->num_rows > 0 ? $ped2->fetch_assoc()['notafiscal_rec'] : $row['ped2'];

                                $ped3 = $conn->query("SELECT * FROM `stock_list` where id in ($stock_ids) and item_id = '{$row['item_id']}'");
                                $row['ped3'] = $ped3->num_rows > 0 ? $ped3->fetch_assoc()['recebido_rec'] : $row['ped3'];

                                $ped4 = $conn->query("SELECT * FROM `stock_list` where id in ($stock_ids) and item_id = '{$row['item_id']}'");
                                $row['ped4'] = $ped4->num_rows > 0 ? $ped4->fetch_assoc()['conforme_rec'] : $row['ped4'];

                                $ped5 = $conn->query("SELECT * FROM `stock_list` where id in ($stock_ids) and item_id = '{$row['item_id']}'");
                                $row['ped5'] = $ped5->num_rows > 0 ? $ped5->fetch_assoc()['datarec_rec'] : $row['ped5'];
                            }
                        ?>
                        <tr class="linha-tabela">
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
                                <input type="number" step="any" tabindex="-1" class="select2 text-center" name="qty[]" style="width:70px !important" value="<?php echo $row['qty']; ?>">
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
                                <input type="hidden" name="oped1[]" value="<?php echo $row['pedido_omie']; ?>">
                                <input type="hidden" name="oped2[]" value="<?php echo $row['notafiscal_rec']; ?>">
                                <input type="hidden" name="oped3[]" value="<?php echo $row['recebido_rec']; ?>">
                                <input type="hidden" name="oped4[]" value="<?php echo $row['conforme_rec']; ?>">
                                <input type="hidden" name="oped5[]" value="<?php echo $row['datarec_rec']; ?>">

                            </td>
                            
                            <td align="center" style="<?php echo $etapa_mat_ou_ser == 1 ? "" : "display:none;" ?>">
                            <div style="width: 100px;">
                            <?php echo ($row['unit']) ?>
                            </div>
                            </td>

        <td class="obs_item">
        <div class="content esconderTexto">
        <div style="width:100%; min-width:250px;">
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
                            <input type="number" tabindex="-1" step="any" class="form-control select2 input-cotacao" name="cot2[]" value="<?php echo $row['cot2']; ?>">
                            </div>

                            <div class="col-12 col-sm-4 col-md-4">
                            <label for="cotacao_1_2" class="control-label">Frete</label><br>
                            <input type="number" tabindex="-1" step="any" class="form-control select2 input-cotacao" name="cot3[]" value="<?php echo $row['cot3']; ?>">
                            </div>
                            
                            <!-- cotacao 2 -->

                            <div class="col-12 col-sm-4 col-md-4">
                            <label for="cotacao_2_0" class="control-label">Fornecedor</label><br>
                            <input type="text" tabindex="-1" class="form-control select2 input-cotacao" name="cot4[]" value="<?php echo $row['cot4']; ?>">
                            </div>

                            <div class="col-12 col-sm-4 col-md-4">
                            <label for="cotacao_2_1" class="control-label">Valor Total</label><br>
                            <input type="number" tabindex="-1" step="any" class="form-control select2 input-cotacao" name="cot5[]" value="<?php echo $row['cot5']; ?>">
                            </div>

                            <div class="col-12 col-sm-4 col-md-4">
                            <label for="cotacao_2_2" class="control-label">Frete</label><br>
                            <input type="number" tabindex="-1" step="any" class="form-control select2 input-cotacao" name="cot6[]" value="<?php echo $row['cot6']; ?>">
                        </div>

                            <!-- cotacao 3 -->

                            <div class="col-12 col-sm-4 col-md-4">
                            <label for="cotacao_3_0" class="control-label">Fornecedor</label><br>
                            <input type="text" tabindex="-1" class="form-control select2 input-cotacao" name="cot7[]" value="<?php echo $row['cot7']; ?>">
                            </div>

                            <div class="col-12 col-sm-4 col-md-4">
                            <label for="cotacao_3_1" class="control-label">Valor Total</label><br>
                            <input type="number" tabindex="-1" step="any" class="form-control select2 input-cotacao" name="cot8[]" value="<?php echo $row['cot8']; ?>">
                            </div>

                            <div class="col-12 col-sm-4 col-md-4">
                            <label for="cotacao_3_2" class="control-label">Frete</label><br>
                            <input type="number" tabindex="-1" step="any" class="form-control select2 input-cotacao" name="cot9[]" value="<?php echo $row['cot9']; ?>">
                            </div>

                            </div><!-- fim hidden div -->
                      
                            <div class="row justify-content-around" style="min-width:400px;">
                            <?php if ($row['bot1']==='0'){ ?> <!-- cotacao 1 -->
                            
                            <div>
                            <strong>Fornecedor</strong><br>
                            <?php echo $row['cot1']?> <!-- resultado 1 -->
                            </div>

                            <div>
                            <strong>Valor Total</strong><br>                            
                            <?php
                            echo 'R$ ';
                            echo $row['cot2']?> <!-- resultado 1 -->
                            </div>

                            <div>
                            <strong>Frete</strong><br>
                            <?php
                            echo 'R$ ';
                            echo $row['cot3']?> <!-- resultado 1 -->
                            </div>

                            <?php }
                             elseif ($row['bot1']==='1'){ ?> <!-- cotacao 2 -->

                            <div>
                            <strong>Fornecedor</strong><br>
                            <?php echo $row['cot4']?> <!-- resultado 2 -->
                            </div>

                            <div>
                            <strong>Valor Total</strong><br>
                            <?php
                            echo 'R$ ';
                            echo $row['cot5']?> <!-- resultado 2 -->
                            </div>

                            <div>
                            <strong>Frete</strong><br>
                            <?php
                            echo 'R$ ';
                            echo $row['cot6']?> <!-- resultado 2 -->
                            </div>

                            <?php } 
                             elseif ($row['bot1']==='2'){ ?> <!-- cotacao 3 -->
                            
                            <div>
                            <strong>Fornecedor</strong><br>
                            <?php echo $row['cot7']?> <!-- resultado 3 -->
                            </div>

                            <div>
                            <strong>Valor Total</strong><br>
                            <?php
                            echo 'R$ ';
                            echo $row['cot8']?> <!-- resultado 3 -->
                            </div>

                            <div>
                            <strong>Frete</strong><br>
                            <?php
                            echo 'R$ ';
                            echo $row['cot9'];?> <!-- resultado 3 -->
                            </div>   
                            <?php }  
                            ?>
                            </div>
                            </td>
                            <td class="align-middle text-center" style="min-width:100px;">
                            <div style="display:none;">
                            <input type="number" tabindex="-1" step="any" class="form-control input-cotacao text-center" name="ped1[]" value="<?php echo $row['ped1']; ?>">
                            </div>
                            <?php echo $row['ped1'];?>
                            </td>

                            <td class="align-middle" style="min-width:200px;">
                            <div>
                            <input type="number" tabindex="-1" step="any" style="font-weight: bold;" class="form-control input-cotacao text-center" name="ped2[]" value="<?php echo $row['ped2']; ?>">
                            </div>    
                            </td>

                        <td class="text-center">
                        <input class="checkbox_recebido" type="checkbox" data-toggle="toggle" data-on="Sim" data-off="Não" data-onstyle="success" data-offstyle="danger">
                        <input class="ped3" name="ped3[]" value="<?php echo $row['ped3']; ?>" type="hidden">
                        <input type="datetime-local" class="ped5 hidden" name="ped5[]" value="<?php echo $row['ped5']; ?>">
                        </td>
                        
                        <td style="max-width:82px;" class="text-center">
                        <input class="checkbox_conforme" type="checkbox" data-toggle="toggle" data-on="Sim" data-off="Não" data-onstyle="success" data-offstyle="danger">
                        <input class="ped4" name="ped4[]" value="<?php echo $row['ped4']; ?>" type="hidden">
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
                            <option value="5" selected <?php echo isset($estado_requisicao) && $estado_requisicao == 5 ? 'selected' : '' ?>>chegada</option>
                        </select>
                    </div>
                    
                    <!-- ETAPA CONCLUÍDA -->
<div style="display:none;">
<select name="etapa_recepcao" id="etapa_recepcao" class="select2" style="width:100%">
                            <option selected value="1" <?php echo isset($etapa_recepcao) && $etapa_recepcao == 1 ? 'selected' : '' ?>>concluido</option>
                        </select>
                        </div>


            </div> <!-- FECHA CONTAINER -->
    </div> <!-- card body -->
    </div> <!-- card total -->

<!-- PARTE RECEPÇÃO -->
<div class="card card-outline card-primary">
<div class="card-header">

<h4 class="card-title"><strong>RECEPÇÃO</strong></h4>
</div>
<div class="card-body">
<div class="row justify-content-around">

<div class="col-12 col-sm-12 col-md-3 text-center">
                <label for="recepcao_nome" class="control-label">Nome</label>
                <input type="text" name="recepcao_nome" tabindex="-1" id="recepcao_nome" style="width:100%;" class="select2 text-center" value="<?php echo isset($recepcao_nome) ? $recepcao_nome : ''; ?><?php if (empty($recepcao_nome)) { echo ucwords($_settings->userdata('firstname').' '.$_settings->userdata('lastname')); } ?>" readonly>
                </div>

                <div class="col-12 col-sm-12 col-md-6 text-center">
                <div class="form-group">
                    <label for="recepcao_obs" class="control-label">Observações</label>
                    <textarea name="recepcao_obs" id="recepcao_obs" rows="6" class="form-control rounded-0 text-center" onload="autoResizeTextarea(this)" oninput="autoResizeTextarea(this)"><?php echo isset($recepcao_obs) ? $recepcao_obs : '' ?></textarea>
                </div>
            </div>

                <div class="col-12 col-sm-12 col-md-3 text-center">
                        <label for="recepcao_data" class="control-label">Data</label>
                        <input type="date" tabindex="-1" name="recepcao_data" id="recepcao_data" style="width:100%;" class="select3 text-center" value="<?php echo isset($recepcao_data) ? $recepcao_data : ''; ?><?php if (empty($recepcao_data)) { echo date('Y-m-d'); } ?>">
                </div>
</div> <!-- row -->

<div class="text-center">
<a class="btn btn-outline-primary" data-toggle="collapse" href="#collapseFinalrec"
role="button" aria-expanded="false" aria-controls="collapseFinalrec"><strong><?php echo "A requisição " .$po_code. " está finalizada ?"?></strong></a>
</div>

<div class="collapse" id="collapseFinalrec">
<br>
<div class="col-12 col-sm-6 col-md-4 text-center mx-auto" >


<div class="btn-group btn-group-toggle" data-toggle="buttons">
<label class="btn btn-rounded bt-active0" style="width: 150px;">
  <input type="radio" id="recepcao_final" name="recepcao_final" value="0" <?php echo isset($recepcao_final) && $recepcao_final == 0 ? 'selected' : '' ?>> Não
  </label>

  <label class="btn btn-rounded bt-active1" style="width: 150px;">
  <input type="radio" id="recepcao_final" name="recepcao_final" value="1" <?php echo isset($recepcao_final) && $recepcao_final == 1 ? 'selected' : '' ?>> Sim
  </label>
</div>

</div>
</div>


</div><!-- card body -->
</div><!-- card -->
<!-- FIM -->



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
        $imageURL1 = 'http://192.168.0.5/sistema/admin/anexo/upload_requisicao/'.$file_name1;
        $imageURL2 = 'http://192.168.0.5/sistema/admin/anexo/upload_requisicao/'.$file_name2;
        $imageURL3 = 'http://192.168.0.5/sistema/admin/anexo/upload_requisicao/'.$file_name3;
        $imageURL4 = 'http://192.168.0.5/sistema/admin/anexo/upload_requisicao/'.$file_name4;
        $imageURL5 = 'http://192.168.0.5/sistema/admin/anexo/upload_requisicao/'.$file_name5;
        $pdfURL1 = 'http://192.168.0.5/sistema/admin/anexo/upload_requisicao/'.$file_name6;
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
<div class="test">
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

                        <?php if (!empty($obs_aprovacao)) { ?>
                        <div class="col-12 col-sm-12 col-md-6 text-center">
                        <div class="form-group">
                            <label for="obs_aprovacao" class="control-label">Observação</label>
                            <p style="width: 100%;"><?php echo isset($obs_aprovacao) ? $obs_aprovacao : '' ?></p>
                        </div>
                    </div>
                            <?php } ?>

                        <div class="col-12 col-sm-6 col-md-3 text-center">
                                <label for="data_aprovacao" class="control-label">Data</label>
                                <input type="date" tabindex="-1" name="data_aprovacao" id="data_aprovacao" style="width:100%;" class="select3 text-center" value="<?php echo isset($data_aprovacao) ? $data_aprovacao : ''; ?>">
                        </div>


                        
                    </div>
</div>
</div> <!-- card -->
</div> <!-- dois card -->

<br>
    </form> <!-- FECHA ORDER -->

    <div class="footer fixed-bottom card-footer">

    <button type="submit" style="display: none;" aria-hidden="true" form="receive-form" disabled> </button>
    <a class="col-2 col-sm-2 col-md-2 btn btn-outline-dark" href="<?php echo base_url.'/admin?page=recepcao' ?>"><strong>Voltar</strong></a>
        <button class="col-2 col-sm-2 col-md-2 btn btn-outline-success" type="submit" form="receive-form"><strong>Salvar</strong></button>
        
        <!-- <.?php echo "<a class='btn btn-flat btn-dark' href=\"javascript:history.go(-1)\">Voltar</a>"; ?> -->
    </div>


<script>

function autoResizeTextarea(textarea) {
  textarea.style.height = 'auto';
  textarea.style.height = (textarea.scrollHeight) + 'px';
};

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


// Obtém todas as linhas da tabela
var linhas = document.getElementsByClassName('linha-tabela');

// Percorre cada linha da tabela
for (var i = 0; i < linhas.length; i++) {
    // Obtém o valor de "ped3" da linha atual
    var ped3 = linhas[i].getElementsByClassName('ped3')[0].value;

    // Obtém o checkbox da linha atual
    var checkbox = linhas[i].getElementsByClassName('checkbox_recebido')[0];

    // Verifica o valor de "ped3" e marca ou desmarca o checkbox, dependendo do valor
    if (ped3 == 1) {
        checkbox.checked = true;
        checkbox.disabled = true;
    } else {
        checkbox.checked = false;
    }
}

// Percorre cada linha da tabela
for (var i = 0; i < linhas.length; i++) {
    // Obtém o valor de "ped4" da linha atual
    var ped4 = linhas[i].getElementsByClassName('ped4')[0].value;

    // Obtém o checkbox da linha atual
    var checkbox2 = linhas[i].getElementsByClassName('checkbox_conforme')[0];

    // Verifica o valor de "ped4" e marca ou desmarca o checkbox, dependendo do valor
    if (ped4 == 1) {
        checkbox2.checked = true;
        checkbox2.disabled = true;
    } else {
        checkbox2.checked = false;
    }
}

$(document).ready(function () {

  $('.checkbox_recebido').change(function() {
    var valor_recebido;
    var ped3_input = $(this).closest('td').find('.ped3');
    
    if ($(this).prop('checked')) {
      // Se estiver em data-on="Sim", definir o valor como 1
      valor_recebido = 1;
    } else {
      // Se estiver em data-off="Não", definir o valor como 0
      valor_recebido = 0;
    }

    // colocar datetime no campo recebido
    ped3_input.val(valor_recebido);
    if (valor_recebido == 1) {
    var ped5_input = $(this).closest('td').find('.ped5');
    var now = new Date();
    var dateTimeString = now.getFullYear() + "-" + ('0' + (now.getMonth() + 1)).slice(-2) + "-" + ('0' + now.getDate()).slice(-2) + "T" + ('0' + now.getHours()).slice(-2) + ":" + ('0' + now.getMinutes()).slice(-2);
    ped5_input.val(dateTimeString);
}
  });

  $('.checkbox_conforme').change(function() {
    var valor_conforme;
    var ped4_input = $(this).closest('td').find('.ped4');
    if ($(this).prop('checked')) {
      // Se estiver em data-on="Sim", definir o valor como 1
      valor_conforme = 1;
    } else {
      // Se estiver em data-off="Não", definir o valor como 0
      valor_conforme = 0;
    }
    ped4_input.val(valor_conforme);
  });

var table = $('#list_recepcao').DataTable({
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
        "targets": 3, // Tipo
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

    $(function(){
        $('#receive-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
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
					console.log(err)
					alert_toast("Ocorreu um erro",'error');
					end_loader();
				},
				success:function(resp){
					if(resp.status == 'success'){
                        location.replace(_base_url_+"admin/?page=recepcao");
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            end_loader()
                    }else{
						alert_toast("Ocorreu um erro",'error');
						end_loader();
                        console.log(resp)
					}
                    $('html,body').animate({scrollTop:0},'fast')
				}
			})
		})

        if('<?php echo (isset($id) && $id > 0) || (isset($po_id) && $po_id > 0) ?>' == 1){
            calc()
            $('#supplier_id').attr('readonly','readonly')
            $('#req_date').attr('readonly','readonly')
            $('#req_unidade').attr('readonly','readonly')
            $('#req_requisitante').attr('readonly','readonly')
            $('#req_projeto').attr('readonly','readonly')
            $('#req_setor_util').attr('readonly','readonly')
            $('#req_proj_nome').attr('readonly','readonly')
            $('#req_proj_cod').attr('readonly','readonly')
            $('#remarks').attr('readonly','readonly')

            $('table#list tbody tr .rem_row').click(function(){
                rem($(this))
            })
                console.log('test')
            $('[name="qty[]"],[name="discount_perc"],[name="tax_perc"]').on('input',function(){
                calc()
            })
        }
    })
    function rem(_this){
        _this.closest('tr').remove()
        calc()
        if($('table#list tbody tr').length <= 0)
            $('#supplier_id').removeAttr('readonly')
    }
    function calc(){
        var sub_total = 0;
        var grand_total = 0;
        var discount = 0;
        var tax = 0;
        /* $('table#list tbody tr').each(function(){
            qty = $(this).find('[name="qty[]"]').val()
            cot1 = $(this).find('[name="cot1[]"]').val()
            cot2 = $(this).find('[name="cot2[]"]').val()
            cot3 = $(this).find('[name="cot3[]"]').val()

            cot4 = $(this).find('[name="cot4[]"]').val()
            cot5 = $(this).find('[name="cot5[]"]').val()
            cot6 = $(this).find('[name="cot6[]"]').val()
            cot7 = $(this).find('[name="cot7[]"]').val()
            cot8 = $(this).find('[name="cot8[]"]').val()
            cot9 = $(this).find('[name="cot9[]"]').val()


            bot1 = $(this).find('[name="bot1[]"]').val()

            ped1 = $(this).find('[name="ped1[]"]').val()

            ped2 = $(this).find('[name="ped2[]"]').val()

            ped3 = $(this).find('[name="ped3[]"]').val()

            ped4 = $(this).find('[name="ped4[]"]').val()
            ped5 = $(this).find('[name="ped5[]"]').val()
        }) */

        /* $('table#list tbody input[name="total[]"]').each(function(){
            sub_total += parseFloat($(this).val())
        })
        $('table#list tfoot .sub-total').text(parseFloat(sub_total).toLocaleString('en-US',{style:'decimal',maximumFractionDigit:2}))
        var discount =   sub_total * (parseFloat($('[name="discount_perc"]').val()) /100)
        sub_total = sub_total - discount;
        var tax =   sub_total * (parseFloat($('[name="tax_perc"]').val()) /100)
        grand_total = sub_total + tax
        $('.discount').text(parseFloat(discount).toLocaleString('en-US',{style:'decimal',maximumFractionDigit:2}))
        $('[name="discount"]').val(parseFloat(discount))
        $('.tax').text(parseFloat(tax).toLocaleString('en-US',{style:'decimal',maximumFractionDigit:2}))
        $('[name="tax"]').val(parseFloat(tax))
        $('table#list tfoot .grand-total').text(parseFloat(grand_total).toLocaleString('en-US',{style:'decimal',maximumFractionDigit:2}))
        $('[name="amount"]').val(parseFloat(grand_total))
*/
    } 
</script>