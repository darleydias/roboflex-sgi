<?php
session_start();
?>

<?php 
$qry = $conn->query("SELECT p.*,s.name as supplier FROM purchase_order_list p inner join supplier_list s on p.supplier_id = s.id  where p.id = '{$_GET['id']}'");
if($qry->num_rows >0){
    foreach($qry->fetch_array() as $k => $v){
        $$k = $v;
    }
}
?>

<style>
body{
zoom:90%;
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

.custom-file-upload {
  border: 1px solid #ccc;
  display: inline-block;
  padding: 6px 12px;
  cursor: pointer;
}

table{
    font-size: 11px;
}
</style>


<div class="card card-outline card-primary">
    <div class="card-header">
        <h4 class="card-title"><strong><?php echo 'REQUISIÇÃO ' .$po_code ?></strong></h4>
    </div>


    <div class="card-body" id="print_out">
        <br>
        <div class="container-fluid">
            <div class="row justify-content-around">
                <div class="col-12 col-sm-6 col-md-3 text-center">
                    <label class="control-label">Código Requisição</label>
                    <div><?php echo isset($po_code) ? $po_code : '' ?></div>
                </div>
                <!-- <div class="col-md-6">
                    <div class="form-group">
                        <label for="supplier_id" class="control-label">Categoria</label>
                        <div><.?php echo isset($supplier) ? $supplier : '' ?></div>
                    </div>
                </div> -->
                <div class="col-12 col-sm-6 col-md-3 offset-md-1 text-center">
                <label for="req_date" class="control-label">Data da Requisição</label>
                <input type="date" id="req_date" class="select3 text-center" style="width:100%;" tabindex="-1" value="<?php echo isset($req_date) ? $req_date : ''; ?>" required>
                        </div>


                        <div class="col-12 col-sm-6 col-md-3 offset-md-1 text-center">
                        <label for="req_unidade" class="control-label">Unidade Requisitante</label>
                        <select id="req_unidade" class="select2 text-center" style="width:100%;" tabindex="-1">
                            <option value="1" <?php echo isset($req_unidade) && $req_unidade == 1 ? 'selected' : '' ?>>Roboflex</option>
                            <option value="0" <?php echo isset($req_unidade) && $req_unidade == 0 ? 'selected' : '' ?>>Zontec</option>
                        </select>
                    </div>
                    <!-- <div class="col-md-3">
                        <label for="req_unidade" class="control-label">Unidade Requisitante</label>
                        <select id="req_unidade" class="select2">
                            <option value="1" <.?php echo isset($req_unidade) && $req_unidade == 1 ? 'selected' : '' ?>>Roboflex</option>
                            <option value="0" <.?php echo isset($req_unidade) && $req_unidade == 0 ? 'selected' : '' ?>>Zontec</option>
                        </select>
                    </div> -->
              
                    </br></br></br>


            <div class="col-12 col-sm-6 col-md-3 text-center">
			<label for="req_requisitante" class="control-label">Solicitante</label>
			<select id="req_requisitante" name="req_requisitante" class="select2 text-center" style="width:100%;" tabindex="-1">
			<option <?php echo !isset($req_requisitante) ? 'selected' : '' ?> disabled></option>
			<?php 
			$requisitante = $conn->query("SELECT r.id, r.name FROM `requisitante_list` r where status = 1 order by `name` asc");
			while($row=$requisitante->fetch_assoc()):
			?>
			<option value="<?php echo $row['id'] ?>" <?php echo isset($req_requisitante) && $req_requisitante == $row['name'] ? "selected" : "" ?> ><?php echo $row['name'] ?></option>
			<?php endwhile; ?>
			</select>
            </div>

                    <div class="col-12 col-sm-6 col-md-3 offset-md-1 text-center">
                        <label for="req_setor_util" class="control-label">Setor de Utilização</label>
                        <select id="req_setor_util" class="select2 text-center" style="width:100%;" tabindex="-1">
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
                        <select id="req_projeto" class="select2 text-center" onchange="toggleInput();" style="width:100%;" tabindex="-1">
                            <option value="" selected disabled> Escolha aqui </option>
                            <option value="1" <?php echo isset($req_projeto) && $req_projeto == 1 ? 'selected' : '' ?>>Não</option>
                            <option value="0" <?php echo isset($req_projeto) && $req_projeto == 0 ? 'selected' : '' ?>>Sim</option>
                        </select>
                    </div>

             

                    </br></br></br>
                    <?php if ($req_projeto == '0') : ?>
                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <label for="req_proj_cod" class="control-label">Código Projeto</label>
                        <div><?php echo isset($req_proj_cod) ? $req_proj_cod : '' ?></div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 offset-md-1 text-center">
                        <label for="req_proj_nome" class="control-label">Nome Projeto</label>
                        <div><?php echo isset($req_proj_nome) ? $req_proj_nome : '' ?></div>
                    </div>
                    <?php endif;?>

                </div><br> <!-- FIM LINHA -->
           
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


            <?php echo $etapa_mat_ou_ser == 1 ? "<h5 class='text-center'>MATERIAIS SOLICITADOS</h5>" : "<h5 class='text-center'>SERVIÇOS SOLICITADOS</h5>" ?>
            <br>

            <div style="<?php echo $etapa_mat_ou_ser == 1 ? "" : "display:none;" ?>">
            </div>

            <table class="table table-striped table-bordered tabela-form-r" id="list">
            <colgroup>
                    <col width="7%"> <!-- Código -->
                    <col width="22%"> <!-- material -->
                    <col width="12%"> <!-- categoria -->
                    <col width="5%"> <!-- qtde -->
                    <col width="5%" style="<?php echo $etapa_mat_ou_ser == 1 ? "" : "display:none;" ?>"> <!-- tipo -->
                    <col width="26%"> <!-- Obs -->
                    <col width="13%"> <!-- Fornecedor -->
                    <col width="10%"> <!-- Prev data -->
                </colgroup>
                <thead>
                <tr class="text-light bg-navy">
                            <th class="text-center py-1 px-2 align-middle">Código</th>
                            <th class="text-center py-1 px-2 align-middle">Material e Descrição</th>
                            <th class="text-center py-1 px-2 align-middle">Categoria</th>
                            <th class="text-center py-1 px-2 align-middle">Qtde</th>
                            <th class="text-center py-1 px-2 align-middle" style="<?php echo $etapa_mat_ou_ser == 1 ? "" : "display:none;" ?>">Tipo</th>
                            <th class="text-center py-1 px-2 align-middle">Observação</th>
                            <th class="text-center py-1 px-2 align-middle">Ind. Fornecedor</th>
                            <th class="text-center py-1 px-2 align-middle">Data Previsão</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    $qry = $conn->query("SELECT cod_item,p.*,i.name,i.description,i.supplier_id,s.name AS cat_compra
                    FROM `po_items` p
                    inner join item_list i on p.item_id = i.id
                    inner join supplier_list s on s.id = i.supplier_id
                    where p.po_id = '{$id}'");
                    while($row = $qry->fetch_assoc()):
                        $total += $row['total']
                    ?>
                    <tr>
                            <td class="py-1 px-2 cod_item">
                            <?php echo $row['cod_item']; ?>
                            </td>

                            <td class="py-1 px-2 item">
                            <?php echo $row['name']; ?> <br>
                            <?php echo $row['description']; ?>
                            </td>

                            <td class="py-1 px-2 cat_compra text-center">
                            <?php echo $row['cat_compra']; ?>
                            </td>

                            <td class="py-1 px-2 text-center"><?php echo number_format($row['quantity'],2) ?></td>

                            
                            <td class="py-1 px-2 text-center" style="<?php echo $etapa_mat_ou_ser == 1 ? "" : "display:none;" ?>"><?php echo ($row['unit']) ?></td>

                    <!-- ',2' dois zeros apos a virgula -->
                       <!--  <td class="py-1 px-2 text-center"><.?php echo number_format($row['quantity'],2) ?></td> -->

                       
             
                        <td class="py-1 px-2 obs_item">
                            <?php echo $row['obs_item']; ?>
                            </td>

                            <td class="py-1 px-2 fornecedor_item text-center">
                            <?php echo $row['fornecedor_item']; ?>
                            </td>

                            <td class="py-1 px-2 prev_data text-center">
                            <?php echo date("d-m-Y", strtotime($row['prev_data'])) ?>
                            <!-- <.?php echo $row['prev_data']; ?> -->
                            </td>

                    </tr>

                    <?php endwhile; ?>
                    
                </tbody>
            </table>
    
        </div>  <!-- FIM CONTAINER -->


<!-- PARTE ESCONDIDA DA PAGINA NORMAL, APENAS PARA PRINT -->

<div class="hide-from-page">

<style>

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
<!-- FIM PARTE ESCONDIDA -->

</div> 
 <!-- fim div print -->

<div class="card-footer py-1 text-center row">
<a class="btn btn-outline-secondary" style="width: 50%;" href="<?php echo base_url.'/admin?page=historico_req'?>"><strong>VOLTAR</strong></a>
<button class="btn btn-outline-success " type="button" id="print" style="width: 50%;"><strong>Gerar PDF</strong></button>
    </div>
    <br>
</div> <!-- card primary -->
<table id="clone_list" class="d-none">
    <tr>
        <td class="py-1 px-2 text-center">
            <button class="btn btn-outline-danger btn-sm rem_row" type="button"><i class="fa fa-times"></i></button>
        </td>

        <td class="py-1 px-2 cod_item">
        </td>

        <td class="py-1 px-2 item">
        </td>

        <td class="py-1 px-2 text-center qty">
            <span class="visible"></span>
            <input type="hidden" name="item_id[]">
            <input type="hidden" name="cod_item[]">
            <input type="hidden" name="unit[]">
            <input type="hidden" name="qty[]">
            <input type="hidden" name="obs_item[]">
            <input type="hidden" name="prev_data[]">
        </td>

        <td class="py-1 px-2 text-center unit">
        </td>

        <td class="py-1 px-2 obs_item">
        </td>

        <td class="py-1 px-2 prev_data">
        </td>

    </tr>
</table>

<script>
    $(function(){
        $('#print').click(function(){
            start_loader()
            var _el = $('<div>')
            var _head = $('head').clone()
                _head.find('title').text("Requisição")
            var p = $('#print_out').clone()
            p.find('tr.text-light').removeClass("text-light bg-navy")
            _el.append(_head)
            _el.append('<div class="d-flex justify-content-center">'+
                      '<div class="col-1 text-right">'+
                      '<img src="<?php echo validate_image($_settings->info('logo')) ?>" width="165px" height="65px" />'+
                      '</div>'+
                      '<div class="col-10">'+
                      '<h4 class="text-center"><?php echo $_settings->info('name') ?></h4>'+
                      '<h4 class="text-center"><?php echo $po_code ?></h4>'+
                      '</div>'+
                      '<div class="col-1 text-right">'+
                      '</div>'+
                      '</div><hr/>'            
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
    });
</script>