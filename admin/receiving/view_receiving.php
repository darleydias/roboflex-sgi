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

.table td, .table th {
        font-size: 11px;
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

table{
font-size: small;
}

body{
zoom: 90%;
}

</style>


<div id="print_out">
<div class="card card-outline card-primary">

<div class="card-header">
        <h4 class="card-title"><strong>REQUISIÇÃO <?php echo $po_code ?></strong></h4>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="row justify-content-around">
            <div class="col-12 col-sm-6 col-md-3 text-center">
            <label class="control-label">Código requisição</label>
                        <input type="text" style="width:100%;" tabindex="-1" class="select2 text-center" value="<?php echo isset($po_code) ? $po_code : '' ?>">
                    </div>

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

                    <br><br><br>
                    
   
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
  
   
                    <div class="col-12 col-sm-6 col-md-3 offset-md-1 text-center">
                        <label for="req_projeto" class="control-label">Projeto</label>
                        <select id="req_projeto" tabindex="-1" class="select2 text-center" style="width:100%" onchange="toggleInput();">
                            <option value="" selected disabled> Escolha aqui </option>
                            <option value="1" <?php echo isset($req_projeto) && $req_projeto == 1 ? 'selected' : '' ?>>Não</option>
                            <option value="0" <?php echo isset($req_projeto) && $req_projeto == 0 ? 'selected' : '' ?>>Sim</option>
                        </select>
                    </div>


                    </br></br></br>

<?php if($req_projeto =='0'):?>
                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <label for="req_proj_cod" class="control-label">Código Projeto</label>
                        <input type="text" tabindex="-1" id="req_proj_cod" class="select2 text-center" style="width:100%;" value="<?php echo isset($req_proj_cod) ? $req_proj_cod : ''; ?>">
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 offset-md-1 text-center">
                        <label for="req_proj_nome" class="control-label">Nome Projeto</label>
                        <input type="text" tabindex="-1" id="req_proj_nome" class="select2 text-center" style="width:100%;" value="<?php echo isset($req_proj_nome) ? $req_proj_nome : ''; ?>">
                    </div>
<?php endif; ?>
                </div> <!-- fim linha -->
            
          <br>

<?php if(!empty($remarks)) { ?>          
<?php
// Verificar a quantidade de linhas no texto anterior
$lineCount = isset($remarks) ? substr_count($remarks, "\n") + 1 : 10;
?>

<div class="row justify-content-around">
  <div class="col" style="width:100%;">
    <div class="form-group text-center">
      <label for="remarks" class="control-label">Observações da requisição</label>
      <textarea name="remarks" id="remarks" rows="<?php echo $lineCount; ?>" class="form-control rounded-0 text-center" readonly><?php echo isset($remarks) ? htmlspecialchars($remarks) : ''; ?></textarea>
    </div>
  </div>
</div>
<?php } ?>

               <!-- INICIO TABELA --> 
               <br>

               
               <?php echo $etapa_mat_ou_ser == 1 ? "<h5 class='text-center'><a style='color:#f29f05'>MATERIAIS</a> SOLICITADOS</h5>" : "<h5 class='text-center'><a style='color:#035aa6'>SERVIÇOS</a> SOLICITADOS</h5>" ?>
<br>
                <table class="table table-striped table-bordered tabela-form-r" style="width:100%;" id="list_visu" >
            <colgroup>
            <col width="7%">
            <col width="13%">
            <col width="5%">
            <col width="5%">
            <col width="5%" style="<?php echo $etapa_mat_ou_ser == 1 ? "" : "display:none;" ?>"> <!-- tipo -->
            <col width="20%">
            <col width="10%">
            <col width="8%">
            <col width="22%">
            <col width="5%">
            </colgroup> 
                <thead>
                <tr class="text-light bg-navy">
                        
                            <th class="text-center py-1 px-2 align-middle">Cód</th>
                            <th class="text-center py-1 px-2 align-middle">Nome Descrição</th>
                            <th class="text-center py-1 px-2 align-middle">Categoria</th>
                            <th class="text-center py-1 px-2 align-middle">Qtde</th>
                            <th class="text-center py-1 px-2 align-middle" style="<?php echo $etapa_mat_ou_ser == 1 ? "" : "display:none;" ?>">Tipo</th>
                            <th class="text-center py-1 px-2 align-middle">Observação</th>
                            <th class="text-center py-1 px-2 align-middle">Ind. Fornecedor</th>
                            <th class="text-center py-1 px-2 align-middle">Data Prev.</th>
                            <th class="text-center py-1 px-2 align-middle">Cotação Vencedora</th>
                            <th class="text-center py-1 px-2 align-middle">Pedido Omie</th>  
                        </tr>
                        </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        if(isset($po_id)):
                        if(!isset($bo_id))
                        $qry = $conn->query("SELECT p.*,i.name,i.description,i.cod_item,i.supplier_id,s.name AS cat_compra FROM `po_items` p inner join item_list i on p.item_id = i.id inner join supplier_list s on s.id = i.supplier_id where p.po_id = '{$po_id}'");
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

                                $ped1 = $conn->query("SELECT * FROM `stock_list` where id in ($stock_ids) and item_id = '{$row['item_id']}'
                                ");
                                $row['ped1'] = $ped1->num_rows > 0 ? $ped1->fetch_assoc()['pedido_omie'] : $row['ped1'];


                                $bot1 = $conn->query("SELECT * FROM `stock_list` where id in ($stock_ids) and item_id = '{$row['item_id']}'");
                                $row['bot1'] = $bot1->num_rows > 0 ? $bot1->fetch_assoc()['botao_cot1'] : $row['bot1'];
                            }
                        ?>
                        <tr>
                           <!--  <td class="py-1 px-2 text-center">
                                <button class="btn btn-outline-danger btn-sm rem_row" type="button"><i class="fa fa-times"></i></button>
                            </td> -->

                            <td class="py-1 px-2 cod_item text-center">
                            <?php echo $row['cod_item']; ?>
                            </td>

                            <td class="py-1 px-2 item">
                            <?php echo $row['name']; ?> <br>
                            <?php echo $row['description']; ?>
                            </td>

                            <td class="py-1 px-2 text-center cat_compra">
                            <?php echo $row['cat_compra']; ?>
                            </td>

                            <td class="py-1 px-2 text-center qty">
                                <input type="number" name="qty[]" style="width:50px !important" tabindex="-1" value="<?php echo $row['qty']; ?>" class="select2 text-center">
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
                            </td>
                            
                            <td class="py-1 px-2 text-center" style="<?php echo $etapa_mat_ou_ser == 1 ? "" : "display:none;" ?>"><?php echo ($row['unit']) ?></td>

                            <td class="py-1 px-2 obs_item">
                            <?php echo $row['obs_item']; ?>
                            </td>

                             <td class="py-1 px-2 obs_item">
                             <?php echo $row['fornecedor_item']; ?>
                             </td>

                            <td class="py-1 px-2 prev_data text-center">
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

                            <div class="text-center">
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
                            echo $row['cot9']?> <!-- resultado 3 -->
                            </div>
                             
                            <?php }  
                            ?>
                            </div>

                            </td>


                            <td class="text-center">
                                <?php echo$row['ped1']?>
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

<!-- 
                <.?php if($status > 0): ?>
                <div class="col-md-3">
                        <h5><br>
                    <span class="text-info float-right"><.?php echo ($status == 2)? "APROVADO" : "APROVADO PARCIALMENTE" ?></span>
                    </h5>
                </div>
                
                <.?php endif; ?> -->
    
                <?php if(!empty($obs_cotacao)) { ?>          
<?php
// Verificar a quantidade de linhas no texto anterior
$lineCount = isset($obs_cotacao) ? substr_count($obs_cotacao, "\n") + 1 : 10;
?>

<div class="row justify-content-around">
  <div class="col" style="width:100%;">
    <div class="form-group text-center">
      <label for="obs_cotacao" class="control-label">Observação cotação</label>
      <textarea name="obs_cotacao" id="obs_cotacao" rows="<?php echo $lineCount; ?>" class="form-control rounded-0 text-center" readonly><?php echo isset($obs_cotacao) ? htmlspecialchars($obs_cotacao) : ''; ?></textarea>
    </div>
  </div>
</div>
<?php } ?>
           
        </div> <!-- FIM CONTAINER FLUID -->
        </div> <!-- card body -->
</div> <!-- div card -->

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
                </div>

<!-- PARTE ESCONDIDA DA PAGINA NORMAL, APENAS PARA PRINT -->
<div class="hide-from-page">

<style>

.table td, .table th {
        font-size: 11px;
    }
    
.dataTables_scrollHead,
.dataTables_scrollHeadInner{
    display: none;
}

/* Escondido na pagina normal */
.hide-from-page { 
    display:none;
} 
    
    /* visível apenas no print */
@media print {
    .hide-from-page {
    display:inline;
    }
}
.linha-assinatura {
        border: 0;
        border-bottom: 2px solid #000;
        top: -3.5em;
        position: relative;
        width: 250px;
        text-align: center;
}
.input-abaixo {
      display: block; 
      padding-top: 1.5em;
      text-align: center;
}

#assinaturas{
display: flex;
flex-flow: row wrap;
}

.esquerda {
  width:33.33333%;
  text-align:left;
}

.meio {
  width:33.33333%;
  text-align:center;
}

.direita {
 width:33.33333%;
 text-align:right;
}

#div-print{
width: 300px;
margin-left: auto;
/* border: solid; */
text-align: center;
vertical-align: middle;
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

</style>

</div>


<!-- FIM DA PARTE ESCONDIDA -->
</div> <!-- FIM DIV PRINT -->





<!-- PARTE ANEXOS -->

<?php if(empty($file_name6) && empty($file_name1) && empty($file_name2) && empty($file_name3) && empty($file_name4) && empty($file_name5)){
 ?> 
   <div class="card card-outline card-primary">
 <div class="card-header">
    <h4 class="card-title"><strong>ANEXOS</strong></h4>
    </div>
<div class="card-body">
<div class="text-center"><i><strong>Requisição sem anexos</strong></i></div><br>
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
<br>
<?php } ?>

<br>
    <div class="footer fixed-bottom card-footer">
    <a class="col-2 col-sm-2 col-md-2 btn btn-outline-dark" href="<?php echo base_url.'/admin?page=receiving' ?>"><strong>Voltar</strong></a>
    <button class="col-2 col-sm-2 col-md-2 btn btn-outline-success" type="button" id="print"><strong>PDF</strong></button>
        <!-- <a class="btn btn-outline-primary" href="<.?php echo base_url.'/admin?page=receiving/manage_receiving&id='.(isset($id) ? $id : '') ?>">Editar</a> -->
    </div>
</div>
<table id="clone_list" class="d-none">
    <tr>
        <td class="py-1 px-2 text-center">
            <button class="btn btn-outline-danger btn-sm rem_row" type="button"><i class="fa fa-times"></i></button>
        </td>
        <td class="py-1 px-2 text-center qty">
            <span class="visible"></span>
            <input type="hidden" name="item_id[]">
            <input type="hidden" name="unit[]">
            <input type="hidden" name="qty[]">
            <input type="hidden" name="price[]">
            <input type="hidden" name="total[]">
        </td>
        <td class="py-1 px-2 text-center unit">
        </td>
        <td class="py-1 px-2 item">
        </td>
        <td class="py-1 px-2 fornecedor_item">
        </td>
        
    </tr>
</table>




<script>
    $(function(){

        $('#print').click(function(){
            start_loader()
            var _el = $('<div>')
            var _head = $('head').clone()
                _head.find('title').text("Entrada - Print")
            var p = $('#print_out').clone()
            p.find('tr.text-light').removeClass("text-light bg-navy")
            _el.append(_head)
            _el.append('<div class="d-flex justify-content-center" style="width:100%;">'+
                      '<div class="form-group col-1">'+
                      '<img src="<?php echo validate_image($_settings->info('logo')) ?>" width="165px" height="65px" />'+
                      '</div>'+
                      '<div class="form-group col-10">'+
                      '<h4 class="text-center"><?php echo $_settings->info('name') ?></h4>'+
                      '</div>'+
                      '</div>'+
                      '<br>'
                      )
            _el.append(p.html())
            var nw = window.open("","","width=1200,height=900,left=250,location=no,titlebar=yes")
                     nw.document.write(_el.html())
                     nw.document.close()
                     setTimeout(() => {
                         nw.print()
                         setTimeout(() => {
                            nw.close()
                            end_loader()
                         }, 200);
                     }, 500);
        })
    })
</script>