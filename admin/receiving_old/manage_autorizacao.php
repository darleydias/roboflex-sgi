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

input[type="radio"] {
  -ms-transform: scale(1.5); /* IE 9 */
  -webkit-transform: scale(1.5); /* Chrome, Safari, Opera */
  transform: scale(1.5);
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

.nowrap-r{
white-space:nowrap;
}

body{
zoom: 90%;
}

</style>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h4 class="card-title"> <strong> <?php echo 'REQUISIÇÃO ' .$po_code ?> </strong></h4>
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
                        <label class="control-label">Código Requisição</label>
                        <input type="text" style="width:100%;" class="select2 text-center" tabindex="-1" value="<?php echo isset($po_code) ? $po_code : '' ?>">
                    </div>
                   <!--  <.?php else: ?> -->
                        <!-- <div class="col-md-3">
                        <label class="control-label">Código pendente</label>
                        <input type="text" class="select2 text-center" value="<.?php echo isset($bo_code) ? $bo_code : '' ?>" readonly>
                    </div> -->
                    <!-- <.?php endif; ?>  -->           
                 <div class="col-12 col-sm-6 col-md-3 offset-md-1 text-center">
                                <label for="req_date" class="control-label">Data da Requisição</label>
                                <input type="date" style="width:100%;" class="select3 text-center" tabindex="-1" id="req_date" value="<?php echo isset($req_date) ? $req_date : ''; ?>">
                       
                        </div>

                    <div class="col-12 col-sm-6 col-md-3 offset-md-1 text-center">
                        <label for="req_unidade" class="control-label">Unidade Requisitante</label>
                        <select id="req_unidade" class="select2 text-center" tabindex="-1" style="width:100%">
                            <option value="1" <?php echo isset($req_unidade) && $req_unidade == 1 ? 'selected' : '' ?>>Roboflex</option>
                            <option value="0" <?php echo isset($req_unidade) && $req_unidade == 0 ? 'selected' : '' ?>>Zontec</option>
                        </select>
                    </div>
                    
   

                </br></br></br>


            <div class="col-12 col-sm-6 col-md-3 text-center">
			<label for="req_requisitante" class="control-label">Solicitante</label>
			<select id="req_requisitante" tabindex="-1" class="select2 text-center" style="width:100%" tabindex="-1">
			<option <?php echo !isset($req_requisitante) ? 'selected' : '' ?> disabled></option>
			<?php 
			$requisitante = $conn->query("SELECT r.id, r.name FROM `requisitante_list` r where status = 1 order by `name` asc");
			while($row=$requisitante->fetch_assoc()):
			?>
			<option value="<?php echo $row['name'] ?>"<?php echo isset($req_requisitante) && $req_requisitante == $row['name'] ? "selected" : "" ?> ><?php echo $row['name'] ?></option>
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


                    <?php if($req_projeto == '0') :?>
                    
                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <label for="req_proj_cod" class="control-label">Código Projeto</label>
                        <input type="text" id="req_proj_cod" tabindex="-1" class="select2 text-center" style="width:100%"value="<?php echo isset($req_proj_cod) ? $req_proj_cod : ''; ?>">
                    </div>
                    <div class="col-12 col-sm-12 col-md-3 offset-md-1 text-center">
                        <label for="req_proj_nome" class="control-label">Nome Projeto</label>
                        <input type="text" id="req_proj_nome" tabindex="-1" class="select2 text-center" style="width:100%" value="<?php echo isset($req_proj_nome) ? $req_proj_nome : ''; ?>">
                    </div>
                    <?php endif;?>
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

        


                <?php echo $etapa_mat_ou_ser == 1 ? "<h5 class='text-center'><a style='color:#f29f05'>MATERIAIS</a> SOLICITADOS</h5>" : "<h5 class='text-center'><a style='color:#035aa6'>SERVIÇOS</a> SOLICITADOS</h5>" ?>
<br>


<div>
        <i><strong>Mostrar/Ocultar colunas:</strong></i><br>
        <table>
        <td><a class="toggle-vis btn btn-outline-primary btn-sm" data-column="0">Código</a></td>
        <td><a class="toggle-vis btn btn-outline-primary btn-sm" data-column="1">Nome</a></td>
        <td><a class="toggle-vis btn btn-outline-primary btn-sm" data-column="2">Quantidade</a></td>
        <td style="<?php echo $etapa_mat_ou_ser == 1 ? "" : "display:none;" ?>"><a class="toggle-vis btn btn-outline-primary btn-sm" data-column="3">Tipo</a></td>
        <td><a class="toggle-vis btn btn-outline-primary btn-sm" data-column="4">Observação</a></td>
        <td><a class="toggle-vis btn btn-outline-primary btn-sm" data-column="5">Fornecedor</a></td>
        <td><a class="toggle-vis btn btn-outline-primary btn-sm" data-column="6">Data</a></td>
        </table>
        </div>


<div class="table-responsive">
                <table class="table table-striped table-bordered tabela-form-r" id="list_autorizacao" style="width:100%;">

                <thead>
                        <tr class="text-light bg-navy">
                            <th class="text-center py-1 px-2 align-middle">Código</th>
                            <th class="text-center py-1 px-2 align-middle">Nome e Descrição</th>
                            <th class="text-center py-1 px-2 align-middle">Qtde</th>
                            
                            <!-- SERVIÇO = 0 ---- MATERIAL = 1 -->
                            <?php if ($etapa_mat_ou_ser == 0) : ?>
                                <th class="text-center py-1 px-2 align-middle" style="display:none;">Tipo</th>
                                <select name="etapa_mat_ou_ser2" id="etapa_mat_ou_ser2" class="select2" style="display: none;">
                                 <option selected value="0" <?php echo isset($etapa_mat_ou_ser2) && $etapa_mat_ou_ser2 == 0 ? 'selected' : '' ?>>serv</option>
                                 <option value="1" <?php echo isset($etapa_mat_ou_ser2) && $etapa_mat_ou_ser2 == 1 ? 'selected' : '' ?>>mat</option>
                                  </select>
                                
                                  <?php elseif ($etapa_mat_ou_ser == 1) : ?>
                                    <th class="text-center py-1 px-2 align-middle">Tipo</th>
                                    <select name="etapa_mat_ou_ser2" id="etapa_mat_ou_ser2" class="select2" style="display: none;">
                                    <option value="0" <?php echo isset($etapa_mat_ou_ser2) && $etapa_mat_ou_ser2 == 0 ? 'selected' : '' ?>>serv</option>
                                    <option selected value="1" <?php echo isset($etapa_mat_ou_ser2) && $etapa_mat_ou_ser2 == 1 ? 'selected' : '' ?>>mat</option>
                                     </select>
                                <?php endif; ?>
                            
                            
                            <th class="text-center py-1 px-2 align-middle">Observação</th>
                            <th class="text-center py-1 px-2 align-middle">Ind. Fornecedor</th>
                            <th class="text-center py-1 px-2 align-middle">Data Previsão</th>
                        </tr>
                </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        if(isset($po_id)):
                        if(!isset($bo_id))
                        $qry = $conn->query("SELECT p.*,i.name,i.description,i.cod_item,f.id AS idf
                        FROM `po_items` p
                        inner join item_list i on p.item_id = i.id
                        left join fornecedor_list f on f.name = p.fornecedor_item
                        where p.po_id = '{$po_id}' group by i.id");
                        else
                        $qry = $conn->query("SELECT b.*,i.name,i.description FROM `bo_items` b inner join item_list i on b.item_id = i.id where b.bo_id = '{$bo_id}'");
                        while($row = $qry->fetch_assoc()):
                            $total += $row['total'];
                            $row['qty'] = $row['quantity'];
                            if(isset($stock_ids)){
                                // echo "SELECT * FROM `stock_list` where id in ($stock_ids) and item_id = '{$row['item_id']}'";
                                $qty = $conn->query("SELECT * FROM `stock_list` where id in ($stock_ids) and item_id = '{$row['item_id']}'");
                                $row['qty'] = $qty->num_rows > 0 ? $qty->fetch_assoc()['quantity'] : $row['qty'];
                            }
                        ?>
                        <tr>
                            <!-- <td class="py-1 px-2 text-center">
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

                            <td class="py-1 px-2 text-center qty">
                                <input type="number" name="qty[]" class="rounded-0 text-center" style="width:70px !important" value="<?php echo $row['qty']; ?>" max = "" min="0" step="any">
                                <input type="hidden" name="cod_item[]" value="<?php echo $row['cod_item']; ?>">
                                <input type="hidden" name="cat_compra[]" value="<?php echo $row['cat_compra']; ?>">
                                <input type="hidden" name="item_id[]" value="<?php echo $row['item_id']; ?>">
                                <input type="hidden" name="oqty[]" value="<?php echo $row['quantity']; ?>">
                                <input type="hidden" name="unit[]" value="<?php echo $row['unit']; ?>">
                                <input type="hidden" name="obs_item[]" value="<?php echo $row['obs_item']; ?>">
                                <input type="hidden" name="prev_data[]" value="<?php echo $row['prev_data']; ?>">
                            </td>

                            <td class="py-1 px-2 text-center" style="<?php echo $etapa_mat_ou_ser == 1 ? "" : "display:none;" ?>"><?php echo ($row['unit']) ?></td>

                            <!-- <td class="py-1 px-2 obs_item">
                            <.?php echo $row['obs_item']; ?>
                            </td> -->

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

                            <td class="py-1 px-2 obs_item">
                            <a class="view_data" href="javascript:void(0);" data-id="<?php echo $row['idf'] ?>"><?php echo $row['fornecedor_item'];?></a>
                            </td>

                            <td class="py-1 px-2 text-center nowrap-r prev_data">
                            <?php echo date("d-m-Y", strtotime($row['prev_data'])) ?>
                            <!-- <.?php echo $row['prev_data']; ?> -->
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>

                </table>
                </div>
           <!-- ETAPA CONCLUÍDA -->
<div style="display:none;">
<select name="etapa_autorizacao" id="etapa_autorizacao" class="select2" style="width:100%">
                            <option selected value="1" <?php echo isset($etapa_autorizacao) && $etapa_autorizacao == 1 ? 'selected' : '' ?>>concluido</option>
                        </select>
                        </div>

                    <!-- DIV AUTORIZAÇÃO -->
                    
                    <div class="form-group" style="display:none;">
                        <label for="estado_requisicao" class="control-label">Unidade Requisitante</label>
                        <select name="estado_requisicao" id="estado_requisicao" class="custom-select select2" required>
                            <option value="" disabled>Selecione a unidade</option>
                            <option value="0" <?php echo isset($estado_requisicao) && $estado_requisicao == 0 ? 'selected' : '' ?>>solicitacao</option>
                            <option value="1" selected <?php echo isset($estado_requisicao) && $estado_requisicao == 1 ? 'selected' : '' ?>>autorizacao</option>
                            <option value="2" <?php echo isset($estado_requisicao) && $estado_requisicao == 2 ? 'selected' : '' ?>>cotacao</option>
                            <option value="3" <?php echo isset($estado_requisicao) && $estado_requisicao == 3 ? 'selected' : '' ?>>aprovacao</option>
                            <option value="4" <?php echo isset($estado_requisicao) && $estado_requisicao == 4 ? 'selected' : '' ?>>omie</option>
                            <option value="5" <?php echo isset($estado_requisicao) && $estado_requisicao == 5 ? 'selected' : '' ?>>chegada</option>
                        </select>
                    </div>
                    
            </div> <!-- Container -->
            </div> <!-- card body -->
    </div> <!-- card total -->








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
        <div class="row d-flex align-items-center">
                        <div class="col-12 col-sm-12 col-md-3 text-center">
                                <label for="data_autorizacao" class="control-label">Data</label>
                                <input type="date" name="data_autorizacao" tabindex="-1" id="data_autorizacao" class="select3 text-center" style="width:100%" value="<?php echo isset($data_autorizacao) ? $data_autorizacao : ''; ?><?php echo date('Y-m-d')?>">
                        </div>   

                        <div class="col-12 col-sm-12 col-md-6 text-center">
                            <label for="obs_autorizacao" class="control-label">Observação</label>
                            <textarea name="obs_autorizacao" tabindex="-1" id="obs_autorizacao" style="width:100%;" class="text-center" onload="autoResizeTextarea(this)" oninput="autoResizeTextarea(this)"><?php echo isset($obs_autorizacao) ? $obs_autorizacao : '' ?></textarea>
                    </div>

                        <div class="col-12 col-sm-12 col-md-3 text-center">
        
                        <label for="nome_autorizacao" class="control-label">Nome</label>
                        <input type="text" name="nome_autorizacao" tabindex="-1" id="nome_autorizacao" class="select2 text-center" style="width:100%;" value="<?php echo isset($nome_autorizacao) ? /* $nome_autorizacao */ : ''; ?><?php echo ucwords($_settings->userdata('firstname').' '.$_settings->userdata('lastname')) ?>">
                        </div>

                    </div><br>

<!-- <div class="d-flex justify-content-around" style="width:100%;">
<div class="col-12 col-sm-6 col-md-3 text-center">
<label class="control-label">Deseja realmente autorizar ?</label>
<br>
<div class="form-check-inline" >
    <input type="radio" id="req_aprov" class="form-check-input" name="req_aprov" value="1" <?php echo isset($req_aprov) && $req_aprov == 1 ? 'selected' : '' ?>required>Sim
</div>
<div class="form-check-inline">
    <input type="radio" id="req_aprov" class="form-check-input" name="req_aprov" value="0" <?php echo isset($req_aprov) && $req_aprov == 1 ? 'selected' : '' ?>required>Não
</div>
</div>
</div> -->


<div class="text-center">
    <h6>Deseja aprovar essa requisição para a realização da cotação ? *</h6>
<div class="btn-group btn-group-toggle" data-toggle="buttons">
  <label class="btn btn-rounded bt-active0" style="width: 150px;">
  <input type="radio" id="req_aprov" name="req_aprov" value="0" <?php echo isset($req_aprov) && $req_aprov == 0 ? 'selected' : '' ?>required> Não
    
  </label>
  <label class="btn btn-rounded bt-active1" style="width: 150px;">
    <input type="radio" id="req_aprov" name="req_aprov" value="1" <?php echo isset($req_aprov) && $req_aprov == 1 ? 'selected' : '' ?>required> Sim
  </label>
</div>
</div>


</div> <!-- card body -->
        </div> <!-- card -->
<br>
        </form> <!-- FECHA ORDER -->

<div class="footer fixed-bottom card-footer">
<button type="submit" style="display: none;" aria-hidden="true" form="receive-form" disabled> </button>
<div class="form-group">
<a class="col-2 col-sm-2 col-md-2 btn btn-outline-dark" href="<?php echo base_url.'/admin?page=autorizacao' ?>"><strong>Voltar</strong></a>
<button class="col-2 col-sm-2 col-md-2 btn btn-outline-success" type="submit" form="receive-form"><strong>Autorizar</strong></button>
</div>
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
var table = $('#list_autorizacao').DataTable({
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
         
         },
         {
         "targets": 6, // data
         
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

$('.view_data').click(function() {
uni_modal("<i class='fa fa-box'></i> Detalhes do Fornecedor", "maintenance/view_fornecedor.php?id=" + $(this).attr('data-id'), "")
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
						/* location.replace(_base_url_+"admin/?page=receiving/view_receiving&id="+resp.id); */
                        location.replace(_base_url_+"admin/?page=autorizacao");
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
        })


    }
</script>