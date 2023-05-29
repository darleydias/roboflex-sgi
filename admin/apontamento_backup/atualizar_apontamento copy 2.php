<?php '' ?>
<?php
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT i.cod_item,p.*,s.name as supplier
    FROM apontamento_list p
    inner join apontamento_setor s
    inner join apontamento_item_list i
    where p.id = '{$_GET['id']}'");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_array() as $k => $v) {
            $$k = $v;
        }
    }
}
?>

<style>
    .box {
    display: flex;
    align-items: center;
    justify-content: center;
}

.font_color {
    color: #001E27 !important;
}

.bgcolor-text {
    background-color: #F29F05 !important;
}

.padding {
    padding: 10px 5px;

}

.center {
    text-align: center;
}

/* 
label {
    display: inline !important;
    white-space:nowrap;
} */

.bg-primary{
background-color:#0062CC !important;
}

input[type="datetime-local"], input[type="time"] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

.btn.btn-success[disabled] {
    background-color: #DC3545;
    border: #DC3545;
}

.btn.btn-success.focus,
.btn.btn-success:focus {
  color: #fff;
  background-color: #005BBD;
  border-color: #005BBD;
  outline: none;
  box-shadow: none;
}

.btn.btn-success.active,
.btn.btn-success:active {
  color: #fff;
  background-color: #005BBD;
  border-color: #005BBD;
  outline: none;
}
.btn.btn-success.active.focus,
.btn.btn-success.active:focus,
.btn.btn-success.active:hover,
.btn.btn-success:active.focus,
.btn.btn-success:active:focus,
.btn.btn-success:active:hover {
  color: #fff;
  background-color: #005BBD;
  border-color: #005BBD;
  outline: none;
  box-shadow: none;
}

.input-tabela{
border: none;
background: transparent;
outline: none;
pointer-events:none;
}
</style>



<div class="card card-outline card-primary">
    <div class="card-header">
        <h4 class=" padding center text-dark"><?php echo isset($id) ? "Apontamento - " . $po_code : ' TESTE APONTAMENTO' ?></h4>
    </div>
    <div class="card-body">
        <form action="" id="apontamento-form" enctype="multipart/form-data">
                  
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
            <div class="container-fluid">

                <!-- INICIO EDIÇÃO -->
                <div class="form-horizontal">
                <div class="row justify-content-around">
                    <div class="col-12 col-sm-6 col-md-3 text-center">
                   
                        <label class="control-label">Apontamento</label>
                        <input type="text" class="form-control rounded-0 text-center" tabindex="-1" value="<?php echo isset($po_code) ? $po_code : '' ?>" readonly>
                    
                    </div>

                    <div class="col-12 col-sm-6 col-md-3 offset-md-1 text-center">
                    <label for="apontamento_op" class="control-label">Código da OP</label>
                                <input type="text" name="apontamento_op" id="apontamento_op" class="form-control rounded-0 text-center" value="<?php echo isset($apontamento_op) ? $apontamento_op : ''; ?>" readonly>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3 offset-md-1 text-center">
                       <!--  <label for="req_date" class="control-label">Data</label>
                        <input type="datetime" name="req_date" id="req_date" class="form-control rounded-0 text-center" tabindex="-1" 
                        value="<.?php $req_date= date('Y-m-d h:i:s a', time()); ?>"
                        <.?php echo date('d-m-Y H:i:s', strtotime($req_date)) ?> readonly> -->

                         <label for="req_date" class="control-label">Data</label>
                        <input type="datetime" class="form-control rounded-0 text-center" tabindex="-1" value="<?php echo date("d-m-Y H:i:s", strtotime($req_date)) ?>" readonly>
                
                    </div>

                    
       
                </div> <!-- fim linha -->
                <hr>
                
                <!-- ESCOLHA MATERIAL -->
                <fieldset>
                <div class="row justify-content-center align-items-end">

                    <div class="col-sm-6 col-md-2 text-center" style="display:none;" >
                            <label for="supplier_id" class="control-label">Setor</label>
                            <select name="supplier_id" id="supplier_id" style="width:100%;" class="select2 text-center" style="width:100%" required disabled>
                                <option <?php echo !isset($supplier_id) ? 'selected' : '' ?> disabled></option>
                        
                                
<?php if($_settings->userdata('type') == '1') : ?>
<?php
$supplier = $conn->query("SELECT s.*
FROM `apontamento_setor` s
where status = 1
                        order by `name` asc");
                                                elseif ($_settings->userdata('type') == '25') :
                                                    $supplier = $conn->query("SELECT s.*
                                                    FROM `apontamento_setor` s
                                                    where status = 1 and name = 'Mecânica'
                                                    order by `name` asc");
                        elseif ($_settings->userdata('type') == '26') :
                        $supplier = $conn->query("SELECT s.*
                        FROM `apontamento_setor` s
                        where status = 1 and name = 'Identificação'
                        order by `name` asc");

elseif ($_settings->userdata('type') == '27') :
    $supplier = $conn->query("SELECT s.*
    FROM `apontamento_setor` s
    where status = 1 and name = 'Elétrica'
    order by `name` asc");
elseif ($_settings->userdata('type') == '28') :
    $supplier = $conn->query("SELECT s.*
    FROM `apontamento_setor` s
    where status = 1 and name = 'Finalização'
    order by `name` asc");
                        endif;
                                while ($row = $supplier->fetch_assoc()) :
                                ?>
                                    <option value="<?php echo $row['id'] ?>" <?php echo isset($supplier_id) && $supplier_id == $row['id'] ? "selected" : "" ?>><?php echo $row['name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                    </div>

                    <div class="col-sm-8 col-md-6 text-center">
                          
                                <label for="item_id" class="control-label">Código do Serviço *</label>
                                <select id="item_id" class="select2" style="width:100%">
                                    <option disabled selected></option>
                                </select>
                    
                        </div><br><br><br>
                        

                
          
                    
                        <?php
                        $item_arr = array();
                        $cost_arr = array();
                        $item = $conn->query("SELECT i.* FROM `apontamento_item_list` i
                                WHERE status = 1
                                order by `name` asc");
                        while ($row = $item->fetch_assoc()) :
                            $item_arr[$row['supplier_id']][$row['id']] = $row;
                            $cost_arr[$row['id']] = $row['cost'];
                        endwhile;
                        ?>


                          

                        
                        <div class="col-sm-4 col-md-2 text-center">
           <br>
                                <label for="qty" class="control-label">Quantidade a ser produzida *</label>
                                <input type="number" step="any" class="form-control rounded-0" id="qty">
                          
                        </div>
                        </div>

                        <div class="row justify-content-center align-items-end">
                        <div class="col-sm-6 col-md-3 text-center">
                            <br>
                            <div class="form-group">
                        <label for="unit" class="control-label">Colaborador *</label>
                        <select id="unit" class="select2" style="width:100%" multiple>
                            <option value="Colaborador1" <?php echo isset($unit) && $unit == 0 ? 'selected' : '' ?>>Colaborador1</option>
                            <option value="Colaborador2" <?php echo isset($unit) && $unit == 1 ? 'selected' : '' ?>>Colaborador2</option>
                            <option value="Colaborador3" <?php echo isset($unit) && $unit == 2 ? 'selected' : '' ?>>Colaborador3</option>
                            <option value="Colaborador4" <?php echo isset($unit) && $unit == 3 ? 'selected' : '' ?>>Colaborador4</option>
                            <option value="Colaborador5" <?php echo isset($unit) && $unit == 4 ? 'selected' : '' ?>>Colaborador5</option>
                            <option value="Colaborador6" <?php echo isset($unit) && $unit == 5 ? 'selected' : '' ?>>Colaborador6</option>
                        </select>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 text-center">
                            <div class="form-group">
                                <label for="datainicio1" class="control-label">Início do Serviço</label>
                                <input type="datetime-local" step="any" class="form-control rounded-0 text-center" id="datainicio1" value="" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="button" class="btn bg-success" id="inicioTempo" value=""><span class="fa-solid fa-clock"></span></button>
                                </div>

                      <!--   <div class="col-sm-6 col-md-3 text-center">
                                <label for="obs_item" class="control-label font-15">Observação</label>
                                <input type="text" step="any" class="form-control rounded-0" id="obs_item" autocomplete="off">
                        </div> -->
                        </div>
                        <div class="row justify-content-center align-items-end">
                        <div class="col-sm-8 col-md-4 text-center">
                        <button type="button" class="btn bg-red" id="add_to_list"><span class="fas fa-plus"></span> Apontamento</button>
                        </div>
                     
                           
                        </div> <!-- fim linha -->
<br>
                        <div class="row justify-content-center align-items-end">
                        <!-- <div class="col-sm-6 col-md-6 text-center">
                        <button type="button" class="btn bg-red" id="add_to_list"><span class="fas fa-plus"></span> Adicionar Apontamento</button>
                        </div> -->
                        </div>
                </fieldset>
          
<br>



<div class="table-responsive">
            <table class="table table-striped table-bordered" id="list">
         
                <thead>
                    <tr class="bg-primary table-active text-light">
                        <!-- <th class="text-center py-1 px-2 align-middle">#</th> -->
                        <th class="text-center align-middle">Código</th>
                        <th class="text-center py-1 px-2 align-middle">Descrição do Serviço</th>
                        <th class="text-center py-1 px-2 align-middle">Qtde.</th>
                        <th class="text-center py-1 px-2 align-middle">Colaborador</th>
                       <!--  <th class="text-center py-1 px-2 align-middle">Observação</th> -->
                        <th class="text-center py-1 px-2 align-middle">Início 1</th>
                        <th class="text-center py-1 px-2 align-middle">Final 1</th>
                        <th class="text-center py-1 px-2 align-middle">Pausa</th>
                        <th class="text-center py-1 px-2 align-middle">Início 2</th>
                        <th class="text-center py-1 px-2 align-middle">Final 2</th>
                        <th class="text-center py-1 px-2 align-middle">Quantidade Produzida</th>
                        <th class="text-center py-1 px-2 align-middle">Observação</th>
            
                        <!-- <th class="text-center py-1 px-2 align-middle">Custo</th>
                        <th class="text-center py-1 px-2 align-middle">Total</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    if (isset($id)) :
                        $qry = $conn->query("SELECT p.*,i.name,i.description,i.cod_item
                        FROM `apontamento_items` p
                        inner join apontamento_item_list i
                        on p.item_id = i.id
                        where p.po_id = '{$id}'");
                        while ($row = $qry->fetch_assoc()) :
                            $total += $row['total'];
                            $row['cot1'] = $row['datafinal1'];
                            $row['cot2'] = $row['datainicio2'];
                            $row['cot3'] = $row['datafinal2'];
                            $row['cot4'] = $row['pausainicio1'];
                            $row['cot5'] = $row['pausafinal1'];
                /*             $row['cot6'] = $row['pausainicio2'];
                            $row['cot7'] = $row['pausafinal2'];
                            $row['cot8'] = $row['pausainicio3'];
                            $row['cot9'] = $row['pausafinal3'];
                            $row['cot10'] = $row['pausainicio4'];
                            $row['cot11'] = $row['pausafinal4'];
                            $row['cot12'] = $row['pausainicio5'];
                            $row['cot13'] = $row['pausafinal5']; */

                            $row['cot14'] = $row['qtdeproduzida'];
                            $row['cot15'] = $row['obsapontamento'];


                    ?>
                            <tr>
                                <!-- <td class="py-1 px-2 text-center">
                                    <button class="btn btn-outline-danger btn-sm rem_row" type="button"><i class="fa fa-times"></i></button>
                                </td> -->

                                <td class="py-1 px-2 cod_item">
                                    <div class="text-center" style="width: 100px;">
                                <?php echo $row['name']; ?> <br>
                                </div>
                                </td>

                                <td class="py-1 px-2 item">
                                    <div class="text-center" style="min-width: 150px;">
                                    <?php echo $row['description']; ?>
                                    </div>
                                </td>

                                <td class="py-1 px-2 text-center qty">
                                    <span class="visible"><?php echo number_format($row['quantity']); ?></span>
                                    <input type="hidden" name="cod_item[]" value="<?php echo $row['name']; ?>">
                                    <input type="hidden" name="item_id[]" value="<?php echo $row['item_id']; ?>">
                                    <input type="hidden" name="qty[]" value="<?php echo $row['quantity']; ?>">
                                    <input type="hidden" name="unit[]" value="<?php echo $row['unit']; ?>">
                                    <input type="hidden" name="obs_item[]" value="<?php echo $row['obs_item']; ?>">
                                    <input type="hidden" name="datainicio1[]" value="<?php echo $row['datainicio1']; ?>">

                                <input type="hidden" name="ocot1[]" value="<?php echo $row['datafinal1']; ?>">
                                <input type="hidden" name="ocot2[]" value="<?php echo $row['datainicio2']; ?>">
                                <input type="hidden" name="ocot3[]" value="<?php echo $row['datafinal2']; ?>">
                                <input type="hidden" name="ocot4[]" value="<?php echo $row['pausainicio1']; ?>">
                                <input type="hidden" name="ocot5[]" value="<?php echo $row['pausafinal1']; ?>">





                                <input type="hidden" name="ocot14[]" value="<?php echo $row['qtdeproduzida']; ?>">
                                <input type="hidden" name="ocot15[]" value="<?php echo $row['obsapontamento']; ?>">
                                    
                                    <!-- <input type="hidden" name="price[]" value="<.?php echo $row['price']; ?>">
                                    <input type="hidden" name="total[]" value="<.?php echo $row['total']; ?>"> -->
                                </td>

                               <td class="py-1 px-2 text-center unit">
                                    <?php echo $row['unit']; ?>
                                </td>

                               <!--  <td class="py-1 px-2 obs_item">
                                    <.?php echo $row['obs_item']; ?>
                                </td> -->

                                <td class="py-1 px-2 datainicio1">
                                    <div style="width:110px" class="text-center">
                                <?php echo date("d-m-Y H:i:s", strtotime($row['datainicio1'])) ?>
                                </div>
                                </td>

<td>             
<?php
/* if ($apontamento_op == '0000-00-00 00:00:00') {  */
if ($row['cot1'] == '0000-00-00 00:00:00') {    
$disabled1 = "";
} else {
$disabled1 = "disabled";
}
?>

<!-- FINAL 1 -->
<div class="text-center">
<input type="datetime-local" style="display:none;" class="final-total-col1 col-sm-8 col-md-8 input-tabela" step="any" name="cot1[]" value="<?php echo $row['cot1']; ?>" readonly>
<button type="button" class="btn btn-success botao-horas-col1" value="" <?php echo $disabled1 ?>><span class="fa-solid fa-clock"></span></button>   
</div>                      
</td>


<td>
<div class="d-flex">

<div class="form-group">
<?php 
if ($row['cot4'] == '0000-00-00 00:00:00') {    
$disabled4 = "";
} else {
$disabled4 = "disabled";
}
?>
<input type="datetime-local" style="display:none;" class="final-total-col4 col-sm-8 col-md-8 input-tabela" step="any" name="cot4[]" value="<?php echo $row['cot4']; ?>" readonly>
<button type="button" class="btn btn-warning botao-horas-col4" value="" <?php echo $disabled4 ?>><span class="fa-solid fa-pause"></span></button> 
</div>

<div style="width:20px;">
</div>

<div class="form-group">
<?php
if ($row['cot5'] == '0000-00-00 00:00:00') {    
$disabled5 = "";
} else {
$disabled5 = "disabled";
}
?>
<input type="datetime-local" style="display:none;" class="final-total-col5 col-sm-8 col-md-8 input-tabela" step="any" name="cot5[]" value="<?php echo $row['cot5']; ?>" readonly>
<button type="button" class="btn btn-warning botao-horas-col5" value="" <?php echo $disabled5 ?>><span class="fa-solid fa-play"></span></button> 
</div>
</div>
</td>


<!-- inicio 2 -->
<td>
<?php
if ($row['cot2'] == '0000-00-00 00:00:00') {    
$disabled2 = "";
} else {
$disabled2 = "disabled";
}
?>

<div class="text-center">
<input type="datetime-local" style="display:none;" class="final-total-col2 col-sm-8 col-md-8 input-tabela" step="any" name="cot2[]" value="<?php echo $row['cot2']; ?>" readonly>
<button type="button" class="btn btn-success botao-horas-col2" value="" <?php echo $disabled2 ?>><span class="fa-solid fa-clock"></span></button>   
</div> 
</td>


<!-- FINAL 2 -->
<td>
<?php
if ($row['cot3'] == '0000-00-00 00:00:00') {    
$disabled3 = "";
} else {
$disabled3 = "disabled";
}
?>
<div class="text-center">
<input type="datetime-local" style="display:none;" class="final-total-col3 col-sm-8 col-md-8 input-tabela" step="any" name="cot3[]" value="<?php echo $row['cot3']; ?>" readonly>
<button type="button" class="btn btn-success botao-horas-col3" value="" <?php echo $disabled3 ?>><span class="fa-solid fa-clock"></span></button>   
</div> 
</td>
      
<td>
<input type="number" step="any" style="width:60px" class="form-control input-cotacao" name="cot14[]" value="<?php echo $row['cot14']?>">
</td>

<td>
<input type="text"a\ style="width:150px" class="form-control input-cotacao" name="cot15[]" value="<?php echo $row['cot15']?>">
</td>

                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>

                <script>

$(".botao-horas-col1").click(function() {
    var tableRow = $(this).closest("tr"); 
    var dataAtual = moment().format('YYYY-MM-DDTHH:mm:ss');
    var dataFinal = Number(tableRow.find(".final-total-col1").val(dataAtual));
    
});

$(".botao-horas-col2").click(function() {
    var tableRow = $(this).closest("tr"); 
    var dataAtual = moment().format('YYYY-MM-DDTHH:mm:ss');
    var dataFinal = Number(tableRow.find(".final-total-col2").val(dataAtual));
    
});

$(".botao-horas-col3").click(function() {
    var tableRow = $(this).closest("tr"); 
    var dataAtual = moment().format('YYYY-MM-DDTHH:mm:ss');
    var dataFinal = Number(tableRow.find(".final-total-col3").val(dataAtual));
    
});

$(".botao-horas-col4").click(function() {
    var tableRow = $(this).closest("tr"); 
    var dataAtual = moment().format('YYYY-MM-DDTHH:mm:ss');
    var dataFinal = Number(tableRow.find(".final-total-col4").val(dataAtual));
    
});

$(".botao-horas-col5").click(function() {
    var tableRow = $(this).closest("tr"); 
    var dataAtual = moment().format('YYYY-MM-DDTHH:mm:ss');
    var dataFinal = Number(tableRow.find(".final-total-col5").val(dataAtual));
    
});

$(".botao-horas-col6").click(function() {
    var tableRow = $(this).closest("tr"); 
    var dataAtual = moment().format('YYYY-MM-DDTHH:mm:ss');
    var dataFinal = Number(tableRow.find(".final-total-col6").val(dataAtual));
    
});

$(".botao-horas-col7").click(function() {
    var tableRow = $(this).closest("tr"); 
    var dataAtual = moment().format('YYYY-MM-DDTHH:mm:ss');
    var dataFinal = Number(tableRow.find(".final-total-col7").val(dataAtual));
    
});

$(".botao-horas-col8").click(function() {
    var tableRow = $(this).closest("tr"); 
    var dataAtual = moment().format('YYYY-MM-DDTHH:mm:ss');
    var dataFinal = Number(tableRow.find(".final-total-col8").val(dataAtual));
    
});

$(".botao-horas-col9").click(function() {
    var tableRow = $(this).closest("tr"); 
    var dataAtual = moment().format('YYYY-MM-DDTHH:mm:ss');
    var dataFinal = Number(tableRow.find(".final-total-col9").val(dataAtual));
    
});

$(".botao-horas-col10").click(function() {
    var tableRow = $(this).closest("tr"); 
    var dataAtual = moment().format('YYYY-MM-DDTHH:mm:ss');
    var dataFinal = Number(tableRow.find(".final-total-col10").val(dataAtual));
    
});

$(".botao-horas-col11").click(function() {
    var tableRow = $(this).closest("tr"); 
    var dataAtual = moment().format('YYYY-MM-DDTHH:mm:ss');
    var dataFinal = Number(tableRow.find(".final-total-col11").val(dataAtual));
    
});

$(".botao-horas-col12").click(function() {
    var tableRow = $(this).closest("tr"); 
    var dataAtual = moment().format('YYYY-MM-DDTHH:mm:ss');
    var dataFinal = Number(tableRow.find(".final-total-col12").val(dataAtual));
    
});

$(".botao-horas-col13").click(function() {
    var tableRow = $(this).closest("tr"); 
    var dataAtual = moment().format('YYYY-MM-DDTHH:mm:ss');
    var dataFinal = Number(tableRow.find(".final-total-col13").val(dataAtual));
    
});

                </script>
    </table>
</div>

<!-- ETAPA CONCLUÍDA -->
<div style="display:none;">
<select name="etapa_solicitacao" id="etapa_solicitacao" class="select2" style="width:100%;">
                            <option selected value="1" <?php echo isset($etapa_solicitacao) && $etapa_solicitacao == 1 ? 'selected' : '' ?>>concluido</option>
                        </select>
                        </div>

<!-- MATERIAL OU SERVIÇO -->
<div style="display:none;">
<select name="etapa_mat_ou_ser" id="etapa_mat_ou_ser" class="select2" style="width:100%;">
                            <option value="" selected disabled></option>
                            <option selected value="1" <?php echo isset($etapa_mat_ou_ser) && $etapa_mat_ou_ser == 1 ? 'selected' : '' ?>>Mat</option>
                            <option value="0" <?php echo isset($etapa_mat_ou_ser) && $etapa_mat_ou_ser == 0 ? 'selected' : '' ?>>Ser</option>
                        </select>
</div>


<!-- USUÁRIOS QUE NÃO PASSAM POR AUTORIZAÇÃO -->
<!--
AUTORIZAÇÃO
2-Administrativo NIVEL 2 // 3-OPERACIONAL // 4-FINANCEIRO // 5-NEGÓCIOS // 6-ADMINISTRATIVO // 7-P&D // 8-ASSISTÊNCIA TEC.

SOLICITAÇÃO
1-Administrativo NIVEL 1 // 11-OPERACIONAL // 12-ADMINISTRATIVO // 13-ASSISTÊNCIA TÉCNICA // 14-P&D // 15-NEGÓCIOS // 16-FINANCEIRO
-->

<?php if($_settings->userdata('type') == '2' || $_settings->userdata('type') == '3' || $_settings->userdata('type') == '4' || $_settings->userdata('type') == '5' || $_settings->userdata('type') == '6' || $_settings->userdata('type') == '7' || $_settings->userdata('type') == '8' || $_settings->userdata('type') == '17'): ?>
    <div style="display:none;">
        <select name="req_autorizada" id="req_autorizada" class="select2" style="width:100%;">
                            <option selected value="Sim" <?php echo isset($req_autorizada) && $req_autorizada == 'Sim' ? 'selected' : '' ?>>Sim</option>
                        </select>
        </div>

<?php elseif($_settings->userdata('type') == '1' || $_settings->userdata('type') == '11' || $_settings->userdata('type') == '12' || $_settings->userdata('type') == '13' || $_settings->userdata('type') == '14' || $_settings->userdata('type') == '15' || $_settings->userdata('type') == '16' || $_settings->userdata('type') == '18' ): ?>
    <div style="display:none;">
        <select name="req_autorizada" id="req_autorizada" class="select2" style="width:100%;">
                            <option selected value="Não" <?php echo isset($req_autorizada) && $req_autorizada == 'Não' ? 'selected' : '' ?>>Não</option>
                        </select>
        </div>
<?php endif; ?>

<!-- Administrativo -->

<?php if($_settings->userdata('type') == '1' || $_settings->userdata('type') == '2'): ?>
<div style="display:none;">
        <select name="req_grupo" id="req_grupo" class="select2" style="width:100%;">
                            <option selected value="Administrativo" <?php echo isset($req_grupo) && $req_grupo == 'Administrativo' ? 'selected' : '' ?>>Administrativo</option>
                        </select>

        </div>
        <?php endif; ?>

<!-- TIPO DE USUÁRIO -->

<?php if($_settings->userdata('type') == '11' || $_settings->userdata('type') == '3'): ?>

        <div style="display:none;">
        <select name="req_grupo" id="req_grupo" class="select2" style="width:100%;">
                            <option selected value="Operacional" <?php echo isset($req_grupo) && $req_grupo == 'Operacional' ? 'selected' : '' ?>>Operacional</option>
                        </select>
        </div>

        <?php elseif($_settings->userdata('type') == '12' || $_settings->userdata('type') == '9' || $_settings->userdata('type') == '6'): ?>
            <div style="display:none;">
            <select name="req_grupo" id="req_grupo" class="select2" style="width:100%;">
                            <option selected value="Administrativo" <?php echo isset($req_grupo) && $req_grupo == 'Administrativo' ? 'selected' : '' ?>>Administrativo</option>
                        </select>
            </div>

        <?php elseif($_settings->userdata('type') == '13' || $_settings->userdata('type') == '8'): ?>
            <div style="display:none;">
            <select name="req_grupo" id="req_grupo" class="select2" style="width:100%;"> 
                            <option selected value="Assistência Técnica" <?php echo isset($req_grupo) && $req_grupo == 'Assistência Técnica' ? 'selected' : '' ?>>Assistência Técnica</option>
                        </select>
            </div>

        <?php elseif($_settings->userdata('type') == '14' || $_settings->userdata('type') == '7'): ?>
            <div style="display:none;">
            <select name="req_grupo" id="req_grupo" class="select2" style="width:100%;"> 
                            <option selected value="P&D" <?php echo isset($req_grupo) && $req_grupo == 'P&D' ? 'selected' : '' ?>>P&D</option>
                        </select>
            </div>

        <?php elseif($_settings->userdata('type') == '15' || $_settings->userdata('type') == '5'): ?>
            <div style="display:none;">
        <select name="req_grupo" id="req_grupo" class="select2" style="width:100%;"> 
                            <option selected value="Negócios" <?php echo isset($req_grupo) && $req_grupo == 'Negócios' ? 'selected' : '' ?>>Negócios</option>
                        </select>
            </div>

        <?php elseif($_settings->userdata('type') == '16' || $_settings->userdata('type') == '4'): ?>
            <div style="display:none;">
        <select name="req_grupo" id="req_grupo" class="select2" style="width:100%;"> 
                            <option selected value="Financeiro" <?php echo isset($req_grupo) && $req_grupo == 'Financeiro' ? 'selected' : '' ?>>Financeiro</option>
                        </select>
            </div>

            <?php elseif($_settings->userdata('type') == '17' || $_settings->userdata('type') == '18'): ?>
            <div style="display:none;">
        <select name="req_grupo" id="req_grupo" class="select2" style="width:100%;"> 
                            <option selected value="Compras Matérias-primas" <?php echo isset($req_grupo) && $req_grupo == 'Compras Matérias-primas' ? 'selected' : '' ?>>Compras Matérias-primas</option>
                        </select>
            </div>
        <?php endif; ?>
<br>
</form> <!-- form -->


<br>
<div class="card-footer py-1 text-center">
    <!-- NOVO VERSÃO 1.02 -->
    <button type="submit" disabled style="display: none" aria-hidden="true" form="apontamento-form"> </button>
    <!-- FIM -->
    <button class="btn btn-flat btn-success" style="width:100%; height:45px" type="submit" form="apontamento-form"><strong>SALVAR</strong></button>
    <br><br>
    <a class="btn btn-flat btn-dark col-md-4" href="<?php echo base_url . '/admin?page=apontamento' ?>">Voltar</a>
</div>

</div> <!-- container -->
</div> <!-- card body -->
</div> <!-- card total -->




<table id="clone_list" class="d-none">
    <tr>
      <!--   <td class="py-1 px-2 text-center">
            <button class="btn btn-outline-danger btn-sm rem_row" type="button"><i class="fa fa-times fa-2xs"></i></button>
        </td> -->
        
        <td class="py-1 px-2 cod_item">
        </td>

        <td class="py-1 px-2 item">
        </td>
 
        <td class="py-1 px-2 text-center qty">
            <span class="visible"></span>
            <input type="hidden" name="item_id[]">
            <input type="hidden" name="cod_item[]">
            <input type="hidden" name="qty[]">
            <input type="hidden" name="unit[]">
           <!--  <input type="hidden" name="obs_item[]"> -->

            <input type="hidden" name="datainicio1[]">
            <!-- <input type="hidden" name="price[]">
            <input type="hidden" name="total[]"> -->
        </td>

        <td class="py-1 px-2 text-center unit">
        </td>

       <!--  <td class="py-1 px-2 obs_item">
        </td> -->


        <td class="py-1 px-2 datainicio1">
        </td>

        <!-- <td class="py-1 px-2 text-right cost">
        </td>

        <td class="py-1 px-2 text-right total">
        </td> -->
    </tr>
</table>


<script>


$( document ).ready(function() {
$('#inicioTempo').click(function(){
            var time = moment().format('YYYY-MM-DDTHH:mm:ss');
            $('#datainicio1').val(time);
        });
    });



    var items = $.parseJSON('<?php echo json_encode($item_arr) ?>')
    var costs = $.parseJSON('<?php echo json_encode($cost_arr) ?>')


    $(function() {

        $('#req_proj_cod').prop('disabled', true);
        $('#req_proj_nome').prop('disabled', true);

        $('#req_projeto').change(function() {
            if ($(this).val() == "0") {
                $('#req_proj_cod').prop('disabled', false);
                $('#req_proj_nome').prop('disabled', false);
            } else {
                $('#req_proj_cod').prop('disabled', true);
                $('#req_proj_nome').prop('disabled', true);
            }
        });
    });

    $(function() {
        $('.select2').select2({
            placeholder: "Selecione",
            width: 'resolve',
        })
        $('#item_id').select2({
            placeholder: "Escolha a categoria primeiro",
            width: 'resolve',
        })

        $('#supplier_id').change(function() {
            var supplier_id = $(this).val()
            $('#item_id').select2('destroy')
            if (!!items[supplier_id]) {
                $('#item_id').html('')
                var list_item = new Promise(resolve => {
                    Object.keys(items[supplier_id]).map(function(k) {
                        var row = items[supplier_id][k]
                        var opt = $('<option>')
                        opt.attr('value', row.id)
                        opt.text(row.name + ' - ' + row.description)
                        $('#item_id').append(opt)
                    })
                    resolve()
                })
                list_item.then(function() {
                    $('#item_id').select2({
                        placeholder: "Selecione",
                        width: 'resolve',
                    })
                })
            }

        })

        $('#add_to_list').click(function() {
            var supplier = $('#supplier_id').val()
            var item = $('#item_id').val()
            var cod_item = items[supplier][item].name || 'N/A';
            
           /*  var obs_item = $('#obs_item').val().replace(/'/g, '"'); */

            var datainicio1 = $('#datainicio1').val().replace("T"," ");
            var qty = $('#qty').val() > 0 ? $('#qty').val() : 0;
            var unit = $('#unit').val()
            /* var price = costs[item] || 0
            var total = parseFloat(qty) * parseFloat(price) */


       
            var item_description = items[supplier][item].description;
            var tr = $('#clone_list tr').clone()

            if (qty == '' || unit == '' || datainicio1 == '') {
                alert_toast('Necessário preencher todos os campos.', 'warning');
                return false;
            }
            
            /* if ($('table#list tbody').find('tr[data-id="' + item + '"]').length > 0) {
                alert_toast('Item já existe na lista.', 'error');
                return false;
            } */

            tr.find('[name="item_id[]"]').val(item)
            tr.find('[name="qty[]"]').val(qty)
            tr.find('[name="unit[]"]').val(unit)
        /*     tr.find('[name="obs_item[]"]').val(obs_item) */

            tr.find('[name="datainicio1[]"]').val(datainicio1)
         /*    tr.find('[name="price[]"]').val(price)
            tr.find('[name="total[]"]').val(total) */




            tr.attr('data-id', item)
            tr.find('.cod_item').html(cod_item)
            tr.find('.qty .visible').text(qty)
            tr.find('.unit').text(unit)
            tr.find('.item').html(item_description)
           /*  tr.find('.obs_item').html(obs_item) */

            tr.find('.datainicio1').html(datainicio1)
           /*  tr.find('.cost').text(parseFloat(price).toLocaleString('en-US'))
            tr.find('.total').text(parseFloat(total).toLocaleString('en-US')) */






            $('table#list tbody').append(tr)
            calc()
            $('#datainicio1').val('').trigger('change')
            $('#item_id').val('').trigger('change')
            $('#qty').val('')
            $('#unit').val('').trigger('change')
            /* $('#obs_item').val('') */



            $/* ('#datainicio1').val('') */
            tr.find('.rem_row').click(function() {
                rem($(this))
            })

           /*  $('[name="discount_perc"],[name="tax_perc"]').on('input', function() {
                calc()
            }) */
            $('#supplier_id').attr('readonly', 'readonly')
        })

        $('#apontamento-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this)
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_apontamento",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err)
                    alert_toast("Ocorreu um erro", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (resp.status == 'success') {
                        /* location.replace(_base_url_ + "admin/?page=apontamento"); */
                        location.replace(_base_url_ + "admin/?page=apontamento/atualizar_apontamento&id=" + resp.id);
                    } else if (resp.status == 'failed' && !!resp.msg) {
                        var el = $('<div>')
                        el.addClass("alert alert-danger err-msg").text(resp.msg)
                        _this.prepend(el)
                        el.show('slow')
                        end_loader()
                    } else {
                        alert_toast("Ocorreu um erro", 'error');
                        end_loader();
                        console.log(resp)
                    }
                    $('html,body').animate({
                        scrollTop: 0
                    }, 'fast')
                }
            })
        })

        if ('<?php echo isset($id) && $id > 0 ?>' == 1) {
            calc()
            $('#supplier_id').trigger('change')
            $('#supplier_id').attr('readonly', 'readonly')
            $('table#list tbody tr .rem_row').click(function() {
                rem($(this))
            })
        }
    })

    function rem(_this) {
        _this.closest('tr').remove()
        calc()
        if ($('table#list tbody tr').length <= 0)
            $('#supplier_id').removeAttr('readonly')

    }


    function calc() {
        var sub_total = 0;
        var grand_total = 0;
        var discount = 0;
        var tax = 0;
        /* $('table#list tbody input[name="total[]"]').each(function() {
            sub_total += parseFloat($(this).val())

        })
        $('table#list tfoot .sub-total').text(parseFloat(sub_total).toLocaleString('en-US', {
            style: 'decimal',
            maximumFractionDigit: 2
        }))
        var discount = sub_total * (parseFloat($('[name="discount_perc"]').val()) / 100)
        sub_total = sub_total - discount;
        var tax = sub_total * (parseFloat($('[name="tax_perc"]').val()) / 100)
        grand_total = sub_total + tax
        $('.discount').text(parseFloat(discount).toLocaleString('en-US', {
            style: 'decimal',
            maximumFractionDigit: 2
        }))
        $('[name="discount"]').val(parseFloat(discount))
        $('.tax').text(parseFloat(tax).toLocaleString('en-US', {
            style: 'decimal',
            maximumFractionDigit: 2
        }))
        $('[name="tax"]').val(parseFloat(tax))
        $('table#list tfoot .grand-total').text(parseFloat(grand_total).toLocaleString('en-US', {
            style: 'decimal',
            maximumFractionDigit: 2
        }))
        $('[name="amount"]').val(parseFloat(grand_total)) */

     
        $('table#list tbody tr').each(function(){
            cot1 = $(this).find('[name="cot1[]"]').val()
            cot2 = $(this).find('[name="cot2[]"]').val()
            cot3 = $(this).find('[name="cot3[]"]').val()


            cot4 = $(this).find('[name="cot4[]"]').val()
            cot5 = $(this).find('[name="cot5[]"]').val()

       /*      cot6 = $(this).find('[name="cot6[]"]').val()
            cot7 = $(this).find('[name="cot7[]"]').val()
            cot8 = $(this).find('[name="cot8[]"]').val()
            cot9 = $(this).find('[name="cot9[]"]').val() */


            cot14 = $(this).find('[name="cot14[]"]').val()
            cot15 = $(this).find('[name="cot15[]"]').val()


           /*  price = $(this).find('[name="price[]"]').val()
            total = parseFloat(price) * parseFloat(qty)
            $(this).find('[name="total[]"]').val(total)
            $(this).find('.total').text(parseFloat(total).toLocaleString('en-US',{style:'decimal',maximumFractionDigit:2}))
       */ })

    }
</script>

