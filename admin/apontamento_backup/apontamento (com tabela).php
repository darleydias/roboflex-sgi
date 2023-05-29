<?php '' ?>
<?php
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT i.cod_item,p.*,s.name as supplier
    FROM apontamento_list p
    inner join apontamento_setor s on p.supplier_id = s.id
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

#list thead{
    margin: 0;
    opacity: 0;
    height: 0px;
    padding: 0;
}
/* 
label {
    display: inline !important;
    white-space:nowrap;
} */

</style>


<body>
    

<div class="card card-outline card-warning">
    <div class="card-header">
        <h4 class=" padding center text-dark"><?php echo isset($id) ? "Detalhes Requisição de Entrada - " . $po_code : ' TESTE APONTAMENTO' ?></h4>
    </div>
    <div class="card-body">
        <form action="" id="apontamento-form" enctype="multipart/form-data">

        <div style="display: none;">
        <input type="text" name="req_solicitante_type" tabindex="-1" id="req_solicitante_type" class="text-center" style="width:100%;" value="<?php echo isset($req_solicitante_type) ? $req_solicitante_type : ''; ?><?php echo ($_settings->userdata('id')) ?>">
        <input type="text" name="req_solicitante" tabindex="-1" id="req_solicitante" class="text-center" style="width:100%;" value="<?php echo isset($req_solicitante) ? /* $req_solicitante */ : ''; ?><?php echo ucwords($_settings->userdata('firstname').' '.$_settings->userdata('lastname')) ?>">
        </div>
        
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
                                <input type="text" name="apontamento_op" id="apontamento_op" class="form-control rounded-0" value="<?php echo isset($apontamento_op) ? $apontamento_op : ''; ?>">
                    </div>

                    <div class="col-12 col-sm-6 col-md-3 offset-md-1 text-center">
                       <!--  <label for="req_date" class="control-label">Data</label>
                        <input type="datetime" name="req_date" id="req_date" class="form-control rounded-0 text-center" tabindex="-1" 
                        value="<.?php $req_date= date('Y-m-d h:i:s a', time()); ?>"
                        <.?php echo date('d-m-Y H:i:s', strtotime($req_date)) ?> readonly> -->
                
                         <label for="req_date" class="control-label">Data</label>
                        <input type="datetime" name="req_date" id="req_date" class="form-control rounded-0 text-center" tabindex="-1" value="<?php echo isset($req_date) ? $req_date : ''; ?><?php echo $timestamp = date('Y-m-d H:i:s') ?>" readonly>
                
                    </div>

<!--     <p id="time"></p>
                    <input type="datetime" name="req_date" id="req_date1" class="form-control rounded-0 text-center" tabindex="-1" readonly>    
                     -->

<!-- <script>
var timeDisplay = document.getElementById("time");


function refreshTime() {
  var dateString = new Date().toLocaleString("pt-BR", {timeZone: "America/Sao_Paulo"});
  var formattedString = dateString.replace(", ", " - ");
  timeDisplay.innerHTML = formattedString;
}

setInterval(refreshTime, 1000);

$( document ).ready(function() {
var text = $('#time').html();
$('#req_date1').val(text);
});

</script>
        -->
                </div> <!-- fim linha -->
                <hr>
                
                <!-- ESCOLHA MATERIAL -->
                <fieldset>
                <div class="row justify-content-center align-items-end">
                    
                    <div class="col-md-2 text-center">
                            <label for="supplier_id" class="control-label">Setor</label>
                            <select name="supplier_id" id="supplier_id" style="width:100%;" class="select2 text-center" style="width:100%" required>
                                <option <?php echo !isset($supplier_id) ? 'selected' : '' ?> disabled></option>
                                <?php
                                $supplier = $conn->query("SELECT s.*
                        FROM `apontamento_setor` s
                        where status = 1
                        order by `name` asc");
                                while ($row = $supplier->fetch_assoc()) :
                                ?>
                                    <option value="<?php echo $row['id'] ?>" <?php echo isset($supplier_id) && $supplier_id == $row['id'] ? "selected" : "" ?>><?php echo $row['name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        
                    </div>
                    <!-- <div class="form-group align-content-right">
                        <div class="card-tools">
                            <a href="javascript:void(0)" id="create_new" class="btn bgcolor-text"><span class="fas fa-plus"></span> Criar Material </a>
                        </div>
                    </div> -->

                    <div class="col-20 col-sm-16 col-md-4 text-center">
                          
                                <label for="item_id" class="control-label">Código do Serviço</label>
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


                          

                        
                        <div class="col-sm-6 col-md-1 text-center">
           
                                <label for="qty" class="control-label font-15">Quantidade a ser produzida</label>
                                <input type="number" step="any" class="form-control rounded-0" id="qty">
                          
                        </div>

                        <div class="col-sm-6 col-md-2 text-center">
                     
                        <label for="unit" class="control-label font-15">Colaborador *</label>
                        <select id="unit" class="select2" style="width:100%">
                            <option value="" disabled selected></option>
                  
                            <option value="Colaborador1" <?php echo isset($unit) && $unit == 0 ? 'selected' : '' ?>>Colaborador1</option>
                            <option value="Colaborador2" <?php echo isset($unit) && $unit == 1 ? 'selected' : '' ?>>Colaborador2</option>
                            <option value="Colaborador3" <?php echo isset($unit) && $unit == 2 ? 'selected' : '' ?>>Colaborador3</option>
                            
                            <option value="Colaborador4" <?php echo isset($unit) && $unit == 3 ? 'selected' : '' ?>>Colaborador4</option>
                            <option value="Colaborador5" <?php echo isset($unit) && $unit == 4 ? 'selected' : '' ?>>Colaborador5</option>
                            <option value="Colaborador6" <?php echo isset($unit) && $unit == 5 ? 'selected' : '' ?>>Colaborador6</option>


                        </select>
                      
                        </div>

                        <div class="col-sm-6 col-md-3 text-center">
                  
                                <label for="obs_item" class="control-label font-15">Observação</label>
                                <input type="text" step="any" class="form-control rounded-0" id="obs_item" autocomplete="off">
                   
                        </div>


               
          
                       

                        <div class="col-sm-6 col-md-2 text-center">
                       
                                <label for="prev_data" class="control-label font-15">Inicio</label>
                                <input type="datetime" step="any" class="form-control rounded-0 text-center" id="prev_data" value="<?php echo date('Y-m-d H:i:s') ?>" readonly>
              
                        </div>
                        <div class="col-sm-6 col-md-4 text-center">
                
                                <button type="button" class="btn bg-red" id="add_to_list"><span class="fas fa-plus"></span> Adicionar Apontamento</button>
             
                        </div>

                </fieldset>
            </div> <!-- fim linha -->

            <table class="table table-striped table-bordered" id="list">
            <colgroup>
                        <col width="5%">
                        <col width="10%">
                        <col width="10%">
                        <col width="15%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                    </colgroup>
                <thead>
                    <tr class="bgcolor-text table-active text-light">
                        <th class="text-center py-1 px-2 align-middle">#</th>
                        <th class="text-center py-1 px-2 align-middle">Código</th>
                        <th class="text-center py-1 px-2 align-middle">Descrição</th>
                        <th class="text-center py-1 px-2 align-middle">Qtde.</th>
                        <th class="text-center py-1 px-2 align-middle">Tipo</th>
                        <th class="text-center py-1 px-2 align-middle">Observação</th>
                        <th class="text-center py-1 px-2 align-middle">Data previsão</th>
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
                            $total += $row['total']
                    ?>
                            <tr>
                                <td class="py-1 px-2 text-center">
                                    <button class="btn btn-outline-danger btn-sm rem_row" type="button"><i class="fa fa-times"></i></button>
                                </td>

                                <td class="py-1 px-2 cod_item">
                                <?php echo $row['name']; ?> <br>
                                </td>

                                <td class="py-1 px-2 item">
                                 
                                    <?php echo $row['description']; ?>
                                </td>

                                <td class="py-1 px-2 text-center qty">
                                    <span class="visible"><?php echo number_format($row['quantity']); ?></span>
                                    <input type="hidden" name="cod_item[]" value="<?php echo $row['name']; ?>">
                                    <input type="hidden" name="item_id[]" value="<?php echo $row['item_id']; ?>">
                                    <input type="hidden" name="qty[]" value="<?php echo $row['quantity']; ?>">
                                    <input type="hidden" name="unit[]" value="<?php echo $row['unit']; ?>">
                                    <input type="hidden" name="obs_item[]" value="<?php echo $row['obs_item']; ?>">
              
                                    <input type="hidden" name="prev_data[]" value="<?php echo $row['prev_data']; ?>">
                                    
                                    <!-- <input type="hidden" name="price[]" value="<.?php echo $row['price']; ?>">
                                    <input type="hidden" name="total[]" value="<.?php echo $row['total']; ?>"> -->
                                </td>

                               <td class="py-1 px-2 text-center unit">
                                    <?php echo $row['unit']; ?>
                                </td>

                                <td class="py-1 px-2 obs_item">
                                    <?php echo $row['obs_item']; ?>
                                </td>

                                <td class="py-1 px-2 prev_data">
                                    <?php echo $row['prev_data']; ?>
                                </td>
                                
                                <!-- <td class="py-1 px-2 text-right cost">
                                    <.?php echo number_format($row['price']); ?>
                                </td>
                                <td class="py-1 px-2 text-right total">
                                    <.?php echo number_format($row['total']); ?>
                                </td> -->

                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
                <!-- <tfoot>
                    <tr>
                        <th class="text-right py-1 px-2" colspan="9">Sub Total</th>
                        <th class="text-right py-1 px-2 sub-total">0</th>
                    </tr>
                    <tr>
                        <th class="text-right py-1 px-2" colspan="9">Desconto <input style="width:40px !important" name="discount_perc" class='' type="number" min="0" max="100" value="<.?php echo isset($discount_perc) ? $discount_perc : 0 ?>">%
                            <input type="hidden" name="discount" value="<.?php echo isset($discount) ? $discount : 0 ?>">
                        </th>
                        <th class="text-right py-1 px-2 discount"><.?php echo isset($discount) ? number_format($discount) : 0 ?></th>
                    </tr>
                    <tr>
                        <th class="text-right py-1 px-2" colspan="9">Taxas <input style="width:40px !important" name="tax_perc" class='' type="number" min="0" max="100" value="<.?php echo isset($tax_perc) ? $tax_perc : 0 ?>">%
                            <input type="hidden" name="tax" value="<.?php echo isset($discount) ? $discount : 0 ?>">
                        </th>
                        <th class="text-right py-1 px-2 tax"><.?php echo isset($tax) ? number_format($tax) : 0 ?></th>
                    </tr>
                    <tr>
                        <th class="text-right py-1 px-2" colspan="9">Total
                            <input type="hidden" name="amount" value="<.?php echo isset($discount) ? $discount : 0 ?>">
                        </th>
                        <th class="text-right py-1 px-2 grand-total">0</th>
                    </tr>
    </tfoot> -->
    </table>
    <br>
    <div class="row justify-content-around">
        <div class="col-md-6 text-center">
            <div class="form-group">
                <label for="remarks" class="control-label">Observações da Requisição</label>
                <textarea name="remarks" id="remarks" rows="3" class="form-control rounded-0"><?php echo isset($remarks) ? $remarks : '' ?></textarea>
            </div>
        </div>
    </div>


<!-- ------anexo -->
<br>
<div class="text-center">
<i class="fa-sharp fa-solid fa-circle-exclamation" style="color: red;"></i>
    <strong><a>Os anexos poderão ser incluídos na próxima página. </a></strong>
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



</div> <!-- container -->
</div> <!-- card body -->
</div> <!-- card total -->

<div class="card-footer py-1 text-center">
    <!-- NOVO VERSÃO 1.02 -->
    <button type="submit" disabled style="display: none" aria-hidden="true" form="apontamento-form"> </button>
    <!-- FIM -->
    <button class="btn btn-flat btn-success col-md-2" type="submit" form="apontamento-form"><strong>SALVAR</strong></button>
    <a class="btn btn-flat btn-dark" href="<?php echo base_url . '/admin?page=apontamento' ?>">Voltar</a>
</div>


<table id="clone_list" class="d-none">
    <tr>
        <td class="py-1 px-2 text-center">
            <button class="btn btn-outline-danger btn-sm rem_row" type="button"><i class="fa fa-times fa-2xs"></i></button>
        </td>
        
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
            <input type="hidden" name="obs_item[]">

            <input type="hidden" name="prev_data[]">
            <!-- <input type="hidden" name="price[]">
            <input type="hidden" name="total[]"> -->
        </td>

        <td class="py-1 px-2 text-center unit">
        </td>

        <td class="py-1 px-2 obs_item">
        </td>


        <td class="py-1 px-2 prev_data">
        </td>

        <!-- <td class="py-1 px-2 text-right cost">
        </td>

        <td class="py-1 px-2 text-right total">
        </td> -->
    </tr>
</table>


<script>
    


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
            
            var obs_item = $('#obs_item').val().replace(/'/g, '"');

            var prev_data = $('#prev_data').val()
            var qty = $('#qty').val() > 0 ? $('#qty').val() : 0;
            var unit = $('#unit').val()
            /* var price = costs[item] || 0
            var total = parseFloat(qty) * parseFloat(price) */


       
            var item_description = items[supplier][item].description;
            var tr = $('#clone_list tr').clone()

          /*   if (item == '' || qty == '' || unit == '' || obs_item == '' || prev_data == '') {
                alert_toast('Necessário preencher todos os campos.', 'warning');
                return false;
            } */
            
            /* if ($('table#list tbody').find('tr[data-id="' + item + '"]').length > 0) {
                alert_toast('Item já existe na lista.', 'error');
                return false;
            } */

            tr.find('[name="item_id[]"]').val(item)
            tr.find('[name="qty[]"]').val(qty)
            tr.find('[name="unit[]"]').val(unit)
            tr.find('[name="obs_item[]"]').val(obs_item)

            tr.find('[name="prev_data[]"]').val(prev_data)
         /*    tr.find('[name="price[]"]').val(price)
            tr.find('[name="total[]"]').val(total) */




            tr.attr('data-id', item)
            tr.find('.cod_item').html(cod_item)
            tr.find('.qty .visible').text(qty)
            tr.find('.unit').text(unit)
            tr.find('.item').html(item_description)
            tr.find('.obs_item').html(obs_item)

            tr.find('.prev_data').html(prev_data)
           /*  tr.find('.cost').text(parseFloat(price).toLocaleString('en-US'))
            tr.find('.total').text(parseFloat(total).toLocaleString('en-US')) */






            $('table#list tbody').append(tr)
            calc()
            $('#item_id').val('').trigger('change')
            $('#qty').val('')
            $('#unit').val('').trigger('change')
            $('#obs_item').val('')



            $/* ('#prev_data').val('') */
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
                        location.replace(_base_url_ + "admin/?page=apontamento");
                        /* location.replace(_base_url_ + "admin/?page=requisicoes/view_po&id=" + resp.id); */
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

        
    }
</script>

