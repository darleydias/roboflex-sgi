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
.dataTables_scrollHead,
.dataTables_scrollHeadInner{
    display: none;
}

</style>

<div class="card card-outline card-primary">
    <div class="card-header">
        <h4 class="card-title"><?php echo 'REQUISIÇÃO ' .$po_code ?></h4>
    </div>
    <div class="card-body">
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
                        <input type="text" tabindex="-1" style="width:100%;" class="select2 text-center" value="<?php echo isset($po_code) ? $po_code : '' ?>">
                    </div>
                   <!--  <.?php else: ?> -->
                        <!-- <div class="col-md-3">
                        <label class="control-label">Código pendente</label>
                        <input type="text" class="select2 text-center" value="<.?php echo isset($bo_code) ? $bo_code : '' ?>" readonly>
                    </div> -->
                    <!-- <.?php endif; ?>  -->           
                 <div class="col-12 col-sm-6 col-md-3 offset-md-1 text-center">
                                <label for="req_date" class="control-label">Data da Requisição</label>
                                <input type="date" tabindex="-1" style="width:100%;" class="select2 text-center" id="req_date" value="<?php echo isset($req_date) ? $req_date : ''; ?>">
                       
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
                        <select name="req_requisitante" id="req_requisitante" class="select2 text-center" style="width:100%" tabindex="-1">
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
  
<br><br><br>
   
                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <label for="req_projeto" class="control-label">Projeto</label>
                        <select id="req_projeto" tabindex="-1" class="select2 text-center" style="width:100%" onchange="toggleInput();">
                            <option value="" selected disabled> Escolha aqui </option>
                            <option value="1" <?php echo isset($req_projeto) && $req_projeto == 1 ? 'selected' : '' ?>>Não</option>
                            <option value="0" <?php echo isset($req_projeto) && $req_projeto == 0 ? 'selected' : '' ?>>Sim</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 offset-md-1 text-center">
                        <label for="req_proj_cod" class="control-label">Código Projeto</label>
                        <input type="text" tabindex="-1" id="req_proj_cod" class="select2 text-center" style="width:100%;" value="<?php echo isset($req_proj_cod) ? $req_proj_cod : ''; ?>">
                    </div>
                    <div class="col-12 col-sm-12 col-md-3 offset-md-1 text-center">
                        <label for="req_proj_nome" class="control-label">Nome Projeto</label>
                        <input type="text" tabindex="-1" id="req_proj_nome" class="select2 text-center" style="width:100%;" value="<?php echo isset($req_proj_nome) ? $req_proj_nome : ''; ?>">
                    </div>

                </div> <!-- fim linha -->
            
          <br>
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
          
                 
                <table class="table table-striped table-bordered tabela-form-r" id="list" >
                        <tr class="text-light bg-navy">
                        <!-- <th class="text-center py-1 px-2 align-middle">#</th> -->
                            <th class="text-center py-1 px-2 align-middle">Código</th>
                            <th class="text-center py-1 px-2 align-middle">Nome e Descrição</th>
                            <th class="text-center py-1 px-2 align-middle">Qtde</th>
                            <th class="text-center py-1 px-2 align-middle">Und</th>
                            <th class="text-center py-1 px-2 align-middle">Observação</th>
                            <th class="text-center py-1 px-2 align-middle">Ind. Fornecedor</th>
                            <th class="text-center py-1 px-2 align-middle">Data Previsão</th>
                            <th class="text-center py-1 px-2 align-middle">Cotação 1</th>
                
                        
                        </tr>
                 
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

                            <td class="py-1 px-2 cod_item">
                            <?php echo $row['cod_item']; ?>
                            </td>

                            <td class="py-1 px-2 item">
                            <?php echo $row['name']; ?> <br>
                            <?php echo $row['description']; ?>
                            </td>

                            <td class="py-1 px-2 text-center qty">
                                <input type="number" name="qty[]" style="width:50px !important" tabindex="-1" value="<?php echo $row['qty']; ?>" class="select2">
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
                            
                            <td class="py-1 px-2 text-center unit">
                            <?php echo $row['unit']; ?>
                            </td>
                            
                            <td class="py-1 px-2 obs_item">
                            <?php echo $row['obs_item']; ?>
                            </td>

                           <td class="py-1 px-2 obs_item">
                            <?php echo $row['fornecedor_item']; ?>
                            </td>

                            <td class="py-1 px-2 prev_data">
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
                      
                            <div class="row justify-content-around">
                            <?php if ($row['bot1']==='0'){ ?> <!-- cotacao 1 -->
                                
                            <strong>Fornecedor</strong><br>
                            <?php echo $row['cot1']?> <!-- resultado 1 -->

                            <strong>Valor Total</strong><br>
                            <?php echo $row['cot2']?> <!-- resultado 1 -->

                            <strong>Frete</strong><br>
                            <?php echo $row['cot3']?> <!-- resultado 1 -->

                            <?php }
                             elseif ($row['bot1']==='1'){ ?> <!-- cotacao 2 -->
                            
                            <strong>Fornecedor</strong><br>
                            <?php echo $row['cot4']?> <!-- resultado 2 -->

                            <strong>Valor Total</strong><br>
                            <?php echo $row['cot5']?> <!-- resultado 2 -->

                            <strong>Frete</strong><br>
                            <?php echo $row['cot6']?> <!-- resultado 2 -->
                            
                            <?php } 
                             elseif ($row['bot1']==='2'){ ?> <!-- cotacao 3 -->
                            
                            <strong>Fornecedor</strong><br>
                            <?php echo $row['cot7']?> <!-- resultado 3 -->
    
                            <strong>Valor Total</strong><br>
                            <?php echo $row['cot8']?> <!-- resultado 3 -->
    
                            <strong>Frete</strong><br>
                            <?php echo $row['cot9']?> <!-- resultado 3 -->
                                
                            <?php }  
                            ?>
                            </div>

                            </td>

                        </tr>
                        <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
<!--                     <tfoot>
                        <tr>
                            <th class="text-right py-1 px-2" colspan="8">Sub Total</th>
                            <th class="text-right py-1 px-2 sub-total">0</th>
                        </tr>
                        <tr>
                            <th class="text-right py-1 px-2" colspan="8">Desconto <input style="width:40px !important" name="discount_perc" class='' type="number" min="0" max="100" value="<.?php echo isset($discount_perc) ? $discount_perc : 0 ?>">%
                                <input type="hidden" name="discount" value="<.?php echo isset($discount) ? $discount : 0 ?>">
                            </th>
                            <th class="text-right py-1 px-2 discount"><.?php echo isset($discount) ? number_format($discount) : 0 ?></th>
                        </tr>
                        <tr>
                            <th class="text-right py-1 px-2" colspan="8">Taxas <input style="width:40px !important" name="tax_perc" class='' type="number" min="0" max="100" value="<.?php echo isset($tax_perc) ? $tax_perc : 0 ?>">%
                                <input type="hidden" name="tax" value="<.?php echo isset($discount) ? $discount : 0 ?>">
                            </th>
                            <th class="text-right py-1 px-2 tax"><.?php echo isset($tax) ? number_format($tax) : 0 ?></th>
                        </tr>
                        <tr>
                            <th class="text-right py-1 px-2" colspan="8">Total
                                <input type="hidden" name="amount" value="<.?php echo isset($discount) ? $discount : 0 ?>">
                            </th>
                            <th class="text-right py-1 px-2 grand-total">0</th>
                        </tr>
                    </tfoot> -->
                </table>
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
<select name="etapa_chegada" id="etapa_chegada" class="select2" style="width:100%">
                            <option selected value="1" <?php echo isset($etapa_chegada) && $etapa_chegada == 1 ? 'selected' : '' ?>>concluido</option>
                        </select>
                        </div>

                    
            </div> <!-- FECHA CONTAINER -->
    </div> <!-- card body -->
    </div> <!-- card total -->


 <!-- PARTE Autorização -->

 <div class="card card-outline card-primary">
 <div class="card-body">
        <h6 class="text-center">AUTORIZAÇÃO REALIZADA POR</h6>
        <div class="row justify-content-around">
        <div class="col-12 col-sm-6 col-md-3 text-center">
                        <label for="nome_autorizacao" class="control-label">Nome</label>
                        <input type="text" tabindex="-1" name="nome_autorizacao" id="nome_autorizacao" class="select2 text-center" style="width:100%;" value="<?php echo isset($nome_autorizacao) ? $nome_autorizacao : ''; ?>">
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 text-center">
                                <label for="data_autorizacao" class="control-label">Data Autorização</label>
                                <input type="date" tabindex="-1" name="data_autorizacao" id="data_autorizacao" class="select2 text-center" style="width:100%;" value="<?php echo isset($data_autorizacao) ? $data_autorizacao : ''; ?>">
                        </div>  
                    </div>
 </div> <!-- card body -->
        </div> <!-- card -->

<!-- PARTE APROVAÇÃO -->
<div class="card card-outline card-primary">
<div class="card-body">

        <h6 class="text-center">APROVAÇÃO</h6>
        <div class="row justify-content-around">

        <div class="col-12 col-sm-6 col-md-3 text-center">
                        <label for="nome_aprovacao" class="control-label">Nome</label>
                        <input type="text" tabindex="-1" name="nome_aprovacao" id="nome_aprovacao" style="width:100%;" class="select2 text-center" value="<?php echo isset($nome_aprovacao) ? $nome_aprovacao : ''; ?>" readonly>
                        </div>

                        <div class="col-12 col-sm-12 col-md-6 text-center">
                        <div class="form-group">
                            <label for="obs_aprovacao" class="control-label">Observação</label>
                            <p style="width: 100%;"><?php echo isset($obs_aprovacao) ? $obs_aprovacao : '' ?></p>
                        </div>
                    </div>
                    
                        <div class="col-12 col-sm-6 col-md-3 text-center">
                                <label for="data_aprovacao" class="control-label">Data Aprovação</label>
                                <input type="date" tabindex="-1" name="data_aprovacao" id="data_aprovacao" style="width:100%;" class="select2 text-center" value="<?php echo isset($data_aprovacao) ? $data_aprovacao : ''; ?>">
                        </div>

                    </div>
</div>
                </div>

                <!-- PARTE OMIE -->
<!-- <div class="card card-outline card-primary">
<div class="card-body">
        <h6 class="text-center">OMIE</h6>
        <div class="row justify-content-around">

        <div class="col-12 col-sm-6 col-md-3 text-center">
                        <label for="numero_omie" class="control-label">Número Omie *</label>
                        <input type="text" tabindex="-1" name="numero_omie" id="numero_omie" style="width:100%;" class="select2 text-center" value="<?php echo isset($numero_omie) ? $numero_omie : ''; ?>" required>
                        </div>
                    </div>
                </div>
</div> -->

<!-- PARTE recebimento -->

<div class="card card-outline card-primary">
<div class="card-body">
        <h6 class="text-center">RECEBIMENTO</h6>
        
        <div class="row justify-content-around">

        <div class="col-12 col-sm-6 col-md-3 text-center">
                        <label for="nf_chegada" class="control-label">Nota Fiscal</label>
                        <input type="text" name="nf_chegada" id="nf_chegada" autocomplete="off" class="form-control rounded-0 text-center" style="width:100%;" value="<?php echo isset($nf_chegada) ? $nf_chegada : ''; ?>">
                        </div>

        <div class="col-12 col-sm-6 col-md-3 text-center">
                        <label for="data_chegada" class="control-label">Data do Recebimento</label>
                        <input type="date" name="data_chegada" id="data_chegada" class="form-control rounded-0 text-center" style="width:100%;" value="<?php echo isset($data_chegada) ? $data_chegada : ''; ?>">
                        </div>

                    </div> <!-- row -->
                </div> <!-- card body -->
</div> <!-- card total -->


    </form> <!-- FECHA ORDER -->

    <div class="card-footer py-1 text-center">
        <button class="btn btn-flat btn-success" type="submit" form="receive-form">Salvar</button>
        <a class="btn btn-flat btn-dark" href="<?php echo base_url.'/admin?page=chegada' ?>">Voltar</a>
    </div>

<script>
    $(function(){

        $('#list').removeAttr('width').DataTable( {
		"scrollX": true,
        paging:false,
        "lengthChange": false,
        scrollCollapse: true,
        "searching": false,
        "bInfo" : false,
        "ordering": false,
        fixedColumns:   true,
        fixedHeader: true,
        columnDefs: [
            { width: 150, targets: 0 }, /* cod */
            { width: 250, targets: 1 }, /* desc */
            { width: 70, targets: 2 }, /* qtde */
            { width: 70, targets: 3 }, /* uni */
            { width: 200, targets: 4 }, /* obs */
            { width: 200, targets: 5 }, /* fornecedor */
            { width: 100, targets: 6 }, /* data prev */
            { width: 400, targets: 7 }, /* cot1 */

            
           /*  { width: 70, targets: 8 }, 
            { width: 70, targets: 9 }, */
        ],
        language : {
        "zeroRecords": " "            
    }
})
        /* $('.select2').select2({
            placeholder:"Escolha aqui",
            width:'resolve',
        }) */
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
                        location.replace(_base_url_+"admin/?page=chegada");
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
        $('table#list tbody tr').each(function(){
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
/*             price = $(this).find('[name="price[]"]').val()
            total = parseFloat(price) * parseFloat(qty)
            $(this).find('[name="total[]"]').val(total)
            $(this).find('.total').text(parseFloat(total).toLocaleString('en-US',{style:'decimal',maximumFractionDigit:2})) */
        })
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