<?php '' ?>
<?php
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT i.cod_item,p.*,s.name as supplier
    FROM purchase_order_list p
    inner join supplier_list s on p.supplier_id = s.id
    inner join item_list i
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

label {
    display: inline !important;
    white-space:nowrap;
}

table{
font-size: small;
border-color: black !important;
}

.nowrap-r{
white-space:nowrap;
}

body{
zoom:90%;
}
</style>


<div class="card card-outline card-warning">
    <div class="card-header">
        <h4 class="card-title"><strong><?php echo 'REQUISIÇÃO ' .$po_code ?></strong></h4>
    </div>
    <div class="card-body">
        <form action="" id="po-form" enctype="multipart/form-data">     
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
            <div class="container-fluid">

                <!-- INICIO EDIÇÃO -->
                <div class="form-horizontal">
                <div class="row justify-content-around">
                    <div class="col-12 col-sm-6 col-md-3 text-center">
                   
                        <label class="control-label">Requisição</label>
                        <input type="text" class="form-control rounded-0 text-center" tabindex="-1" value="<?php echo isset($po_code) ? $po_code : '' ?>" readonly>
                    
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 offset-md-1 text-center">
           
                        <label for="req_date" class="control-label">Data da Requisição</label>
                        <input type="date" name="req_date" id="req_date" class="form-control rounded-0 text-center" tabindex="-1" value="<?php echo $req_date?>" readonly>  
                
                    </div>

                    <div class="col-12 col-sm-6 col-md-3 offset-md-1 text-center">
                        <label for="req_unidade" class="control-label">Unidade Requisitante *</label>
                        <select name="req_unidade" id="req_unidade" class="select2" style="width:100%" required>
                            <option value="" selected disabled></option>
                            <option value="1" <?php echo isset($req_unidade) && $req_unidade == 1 ? 'selected' : '' ?>>Roboflex</option>
                            <option value="0" <?php echo isset($req_unidade) && $req_unidade == 0 ? 'selected' : '' ?>>Zontec</option>
                        </select>
                    </div>
            
                </br></br></br>
                    
              

                    <div class="col-12 col-sm-6 col-md-3 text-center">
                 
                        <label for="req_requisitante" class="control-label">Solicitante *</label>
                        <select name="req_requisitante" id="req_requisitante" class="select2 text-center" style="width:100%" required>
                            <option <?php echo !isset($req_requisitante) ? 'selected' : '' ?> disabled></option>
                            <?php
                            $requisitante = $conn->query("SELECT r.* FROM `requisitante_list` r where status = 1 order by `name` asc");
                            while ($row = $requisitante->fetch_assoc()) :
                            ?>
                                <option value="<?php echo $row['name'] ?>" <?php echo isset($req_requisitante) && $req_requisitante == $row['name'] ? "selected" : "" ?>><?php echo $row['name'] ?></option>
                            <?php endwhile; ?>
                        </select>
       
                    </div>


                    <div class="col-12 col-sm-6 col-md-3 offset-md-1 text-center">
                        <label for="req_setor_util" class="control-label">Setor de Utilização *</label>
                        <select name="req_setor_util" id="req_setor_util" class="select2" style="width:100%" required>
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
                        <label for="req_projeto" class="control-label">Projeto *</label>
                        <select name="req_projeto" id="req_projeto" class="select2" style="width:100%" onclick="toggleInput();" required>
                            <option value="" selected disabled></option>
                            <option value="1" <?php echo isset($req_projeto) && $req_projeto == 1 ? 'selected' : '' ?>>Não</option>
                            <option value="0" <?php echo isset($req_projeto) && $req_projeto == 0 ? 'selected' : '' ?>>Sim</option>
                        </select>
                    </div>

                    </br></br></br>

                    
                    <div class="col-12 col-sm-6 col-md-3 offset-md-1 text-center">
                        <label for="req_proj_cod" class="control-label">Código Projeto</label>
                        <input type="text" name="req_proj_cod" id="req_proj_cod" class="form-control rounded-0" value="<?php echo isset($req_proj_cod) ? $req_proj_cod : ''; ?>" required>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <label for="req_proj_nome" class="control-label">Nome Projeto</label>
                        <input type="text" name="req_proj_nome" id="req_proj_nome" class="form-control rounded-0" value="<?php echo isset($req_proj_nome) ? $req_proj_nome : ''; ?>" required>
        
                    </div>
                
                </br></br></br>


                </div> <!-- fim linha -->
                <hr>
                
<!-- ESCOLHA MATERIAL -->

<?php
                        $item_arr = array();
                        $cost_arr = array();
                        $item = $conn->query("SELECT i.* FROM `item_list` i
                                WHERE status = 1
                                AND mat_ou_ser = 1
                                order by `name` asc");
                        while ($row = $item->fetch_assoc()) :
                            $item_arr[$row['id']] = $row;
                            /* $item_arr[$row['supplier_id']][$row['id']] = $row; */
                            $cost_arr[$row['id']] = $row['cost'];
                        endwhile;
                        ?>

<div style="display:none;">
        <select name="supplier_id" id="supplier_id" class="select2" style="width:100%;">
                            <option selected value="35" <?php echo isset($supplier_id) && $supplier_id == 35 ? 'selected' : '' ?>>material</option>
                        </select>
        </div>

<div class="d-flex align-items-end justify-content-around">
<div class="col-20 col-sm-16 col-md-8 text-center">
    <label for="item_id" class="control-label">Material *</label>
    <select id="item_id" class="select2 lazy-load" style="width:100%">
    <option value="" selected disabled></option>
        <?php foreach ($item_arr as $item) : ?>
            <option value="<?php echo $item['id'] ?>"><?php echo $item['cod_item'], ' - ' ,$item['name'] ?></option>
        <?php endforeach; ?>
    </select>
</div>               

                        <!-- apenas autorização administrativo (paulo, andré) -->
                        <?php if($_settings->userdata('type') == '6' || $_settings->userdata('type') == '1' || $_settings->userdata('username') == 'Ricardo'): ?>
                        <div data-toggle="popover" data-trigger="hover" data-content="Adicionar novo material">
                                <button type="button" class="btn bgcolor-text" id="create_material" href="javascript:void(0)"><span class="fas fa-plus"></span> Material</button>
                            </div>
                            <?php endif; ?>

                </div><br> <!-- FIM LINHA -->
                
                <fieldset>       
                <div class="row justify-content-center align-items-end">                 
                        <div class="col-sm-6 col-md-1 text-center">
                            <div class="form-group">
                                <label for="qty" class="control-label font-15">Qtde. *</label>
                                <input type="number" step="any" class="form-control rounded-0" id="qty">
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-2 text-center">
                        <div class="form-group">
                        <label for="unit" class="control-label font-15">Tipo *</label>
                        <select id="unit" class="select2" style="width:100%">
                            <option value="" disabled selected></option>
                            <option value="Unidade" <?php echo isset($unit) && $unit == 0 ? 'selected' : '' ?>>Unidade</option>
                            <option value="Peça" <?php echo isset($unit) && $unit == 1 ? 'selected' : '' ?>>Peça</option>
                            <option value="Metro" <?php echo isset($unit) && $unit == 2 ? 'selected' : '' ?>>Metro</option>
                            <option value="Caixa" <?php echo isset($unit) && $unit == 3 ? 'selected' : '' ?>>Caixa</option>
                            <option value="Kg" <?php echo isset($unit) && $unit == 4 ? 'selected' : '' ?>>Kg</option>
                            <option value="Litro" <?php echo isset($unit) && $unit == 5 ? 'selected' : '' ?>>Litro</option>
                            <option value="Pacote" <?php echo isset($unit) && $unit == 6 ? 'selected' : '' ?>>Pacote</option>
                        </select>
                        </div>
                        </div>

                        <div class="col-sm-6 col-md-3 text-center">
                            <div class="form-group">
                                <label for="obs_item" class="control-label font-15">Observação / Motivação *</label>
                                <input type="text" step="any" class="form-control rounded-0" id="obs_item" autocomplete="off" data-toggle="popover" data-trigger="hover" data-content="Para melhor identificação e aquisição">
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-2 text-center">
                        <div class="form-group">
                        <label for="fornecedor_item" class="control-label font-15">Indicação Fornecedor</label>
                        <select name="fornecedor_item" id="fornecedor_item" class="select2 text-center" style="width:100%">
                            <option <?php echo !isset($fornecedor_item) ? 'selected' : '' ?> disabled></option>
                            <?php
                            $fornecedor_item = $conn->query("SELECT * FROM `fornecedor_list` where status = 1 order by `name` asc");
                            while ($row = $fornecedor_item->fetch_assoc()) :
                            ?>
                                <option value="<?php echo $row['name'] ?>" <?php echo isset($fornecedor_item) && $fornecedor_item == $row['name'] ? "selected" : "" ?>><?php echo $row['name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                        </div>
                    </div>
                            <div class="form-group" data-toggle="popover" data-trigger="hover" data-content="Adicionar novo fornecedor">
                                <button type="button" class="btn bgcolor-text" id="create_fornecedor" href="javascript:void(0)"><span class="fas fa-plus"></span>Novo</button>
                            </div>
                       

                        <div class="col-sm-6 col-md-2 text-center">
                            <div class="form-group">
                                <label for="prev_data" class="control-label font-15">Previsão de entrega *</label>
                                <input type="date" step="any" class="form-control rounded-0 text-center" id="prev_data">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 text-center">
                            <div class="form-group">
                                <button type="button" class="btn bgcolor-text" id="add_to_list"><span class="fas fa-plus"></span> Adicionar à lista</button>
                            </div>
                        </div>

                </fieldset>
            </div> <!-- fim linha -->

            <div class="table-responsive">
            <table class="table table-striped table-bordered" id="list">
                <colgroup>
                <col width="3%"> <!-- # -->
                        <col width="7%"> <!-- cod -->
                        <col width="23%"> <!-- desc -->
                        <col width="7%"> <!-- qtd -->
                        <col width="8%"> <!-- tipo -->
                        <col width="27%"> <!-- obs -->
                        <col width="17%"> <!-- ind -->
                        <col width="12%"> <!-- data prev -->
            </colgroup>
                <thead>
                    <tr class="bgcolor-text table-active text-light">
                        <th class="text-center py-1 px-2 align-middle">#</th>
                        <th class="text-center py-1 px-2 align-middle">Código</th>
                        <th class="text-center py-1 px-2 align-middle">Descrição</th>
                        <th class="text-center py-1 px-2 align-middle">Qtde</th>
                        <th class="text-center py-1 px-2 align-middle">Tipo</th>
                        <th class="text-center py-1 px-2 align-middle">Observação</th>
                        <th class="text-center py-1 px-2 align-middle">Fornecedor</th>
                        <th class="text-center py-1 px-2 align-middle">Data Prev</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    if (isset($id)) :
                        $qry = $conn->query("SELECT p.*,i.name,i.description,i.cod_item
                        FROM `po_items` p
                        inner join item_list i
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
                                    <?php echo $row['cod_item']; ?>
                                </td>

                                <td class="py-1 px-2 item">
                                    <?php echo $row['name']; ?> <br>
                                    <?php echo $row['description']; ?>
                                </td>

                                <td class="py-1 px-2 text-center qty">
                                    <span class="visible"><?php echo number_format($row['quantity'],2); ?></span>
                                    <input type="hidden" name="cod_item[]" value="<?php echo $row['cod_item']; ?>">
                                    <input type="hidden" name="item_id[]" value="<?php echo $row['item_id']; ?>">
                                    <input type="hidden" name="qty[]" value="<?php echo $row['quantity']; ?>">
                                    <input type="hidden" name="unit[]" value="<?php echo $row['unit']; ?>">
                                    <input type="hidden" name="obs_item[]" value="<?php echo $row['obs_item']; ?>">
                                    <input type="hidden" name="fornecedor_item[]" value="<?php echo $row['fornecedor_item']; ?>">
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
                                <td class="py-1 px-2 fornecedor_item">
                                    <?php echo $row['fornecedor_item']; ?>
                                </td>
                                <td class="py-1 px-2 prev_data nowrap-r">
                      
                                <?php echo date("d-m-Y", strtotime($row['prev_data'])) ?>
          
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
    </table>
    </div>
    <br>
    <div class="row justify-content-around">
    <div class="col" style="width:100%;">
            <div class="form-group text-center">
            <label for="remarks" class="control-label">Observações da Requisição</label>
            <textarea name="remarks" id="remarks" rows="6" class="form-control rounded-0 text-center"><?php echo isset($remarks) ? $remarks : '' ?></textarea>
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


<?php if($_settings->userdata('type') == '1' || $_settings->userdata('type') == '2' || $_settings->userdata('type') == '3' || $_settings->userdata('type') == '4' || $_settings->userdata('type') == '5' || $_settings->userdata('type') == '6' || $_settings->userdata('type') == '7' || $_settings->userdata('type') == '8' || $_settings->userdata('type') == '17' || $_settings->userdata('type') == '18'): ?>
    <div style="display:none;">
        <select name="req_autorizada" id="req_autorizada" class="select2" style="width:100%;">
                            <option selected value="Sim" <?php echo isset($req_autorizada) && $req_autorizada == 'Sim' ? 'selected' : '' ?>>Sim</option>
                        </select>
        </div>

<?php else : ?>
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

<div class="card-footer py-1 text-center">
    <div class="row">
    <!-- NOVO VERSÃO 1.02 -->
    <button type="submit" disabled style="display: none" aria-hidden="true" form="po-form"> </button>
    <!-- FIM -->
    <a style="width:50%;" class="btn btn-outline-secondary" href="<?php echo base_url . '/admin?page=solicitar_requisicao' ?>"><strong>VOLTAR</strong></a>
    <button style="width:50%;" class="btn btn-outline-success" type="submit" form="po-form"><strong>SALVAR</strong></button>
    </div>
</div>

</div> <!-- container -->
</div> <!-- card body -->
</div> <!-- card total -->




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
            <input type="hidden" name="fornecedor_item[]">
            <input type="hidden" name="prev_data[]">
            <!-- <input type="hidden" name="price[]">
            <input type="hidden" name="total[]"> -->
        </td>

        <td class="py-1 px-2 text-center unit">
        </td>

        <td class="py-1 px-2 obs_item">
        </td>

        <td class="py-1 px-2 fornecedor_item">
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

    /* ADICIONAR ITEM NA TELA DE SOLICITAÇÃO */
    $(document).ready(function() {

        $('#create_fornecedor').click(function() {
            uni_modal("<i class='fa fa-plus'></i> Adicionar novo fornecedor", "maintenance/manage_fornecedor.php", "mid-large")
        })

        $('#create_material').click(function() {
            uni_modal("<i class='fa fa-plus'></i> Adicionar novo material", "maintenance/manage_item.php", "mid-large")
        });

       

        $('#create_new').click(function() {
            uni_modal("<i class='fa fa-plus'></i> Adicionar novo material", "maintenance/manage_item.php", "mid-large")
        });

        $('[data-toggle="popover"]').popover();

    }) /* FIM */

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
        })

        $('#add_to_list').click(function() {
            var item = $('#item_id').val()
            var cod_item = items[item].cod_item || 'N/A';
            var obs_item = $('#obs_item').val().replace(/'/g, '"');
            var fornecedor_item = $('#fornecedor_item').val()
            var prev_data = $('#prev_data').val()
            var qty = $('#qty').val() > 0 ? $('#qty').val() : 0;
            var unit = $('#unit').val()
            var item_name = items[item].name || 'N/A';
            var item_description = items[item].description;
            var tr = $('#clone_list tr').clone()

            if (item == '' || qty == '' || unit == '' || obs_item == '' || prev_data == '') {
                alert_toast('Necessário preencher todos os campos.', 'warning');
                return false;
            }
            
            if ($('table#list tbody').find('tr[data-id="' + item + '"]').length > 0) {
                alert_toast('Item já existe na lista.', 'error');
                return false;
            }

            tr.find('[name="item_id[]"]').val(item)
            tr.find('[name="qty[]"]').val(qty)
            tr.find('[name="unit[]"]').val(unit)
            tr.find('[name="obs_item[]"]').val(obs_item)
            tr.find('[name="fornecedor_item[]"]').val(fornecedor_item)
            tr.find('[name="prev_data[]"]').val(prev_data)
            tr.attr('data-id', item)
            tr.find('.cod_item').html(cod_item)
            tr.find('.qty .visible').text(qty)
            tr.find('.unit').text(unit)
            tr.find('.item').html(item_name + '<br/>' + item_description)
            tr.find('.obs_item').html(obs_item)
            tr.find('.fornecedor_item').html(fornecedor_item)
            tr.find('.prev_data').html(prev_data)

            $('table#list tbody').append(tr)
            calc()
            $('#item_id').val('').trigger('change')
            $('#qty').val('')
            $('#unit').val('').trigger('change')
            $('#obs_item').val('')
            $('#fornecedor_item').val('').trigger('change')
            $('#prev_data').val('')
            tr.find('.rem_row').click(function() {
                rem($(this))
            })
        })

        $('#po-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this)
            $('.err-msg').remove();
            start_loader();

            if ($('#list tr').length === 1) {
alert_toast("A Requisição precisa conter ao menos 1 item", 'error');
end_loader();
return;
}

            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_po",
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
                        location.replace(_base_url_ + "admin/?page=requisicoes/view_po&id=" + resp.id);
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