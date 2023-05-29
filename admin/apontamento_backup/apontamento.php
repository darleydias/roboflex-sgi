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
    

<div class="card card-outline card-primary">
    <div class="card-header">
        <h4 class=" padding center text-dark">APONTAMENTO</h4>
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
                                <input type="text" autocomplete="off" name="apontamento_op" id="apontamento_op" class="form-control rounded-0" value="<?php echo isset($apontamento_op) ? $apontamento_op : ''; ?>">
                    </div>

                    <div class="col-12 col-sm-6 col-md-3 offset-md-1 text-center">
                       <!--  <label for="req_date" class="control-label">Data</label>
                        <input type="datetime" name="req_date" id="req_date" class="form-control rounded-0 text-center" tabindex="-1" 
                        value="<.?php $req_date= date('Y-m-d h:i:s a', time()); ?>"
                        <.?php echo date('d-m-Y H:i:s', strtotime($req_date)) ?> readonly> -->
               
                         <label for="req_date" class="control-label">Data</label>
                        <input type="datetime" name="req_date" id="req_date" class="form-control rounded-0 text-center" tabindex="-1" value="<?php echo isset($req_date) ? $req_date : ''; ?><?php echo $timestamp = date('Y-m-d H:i:s') ?>" readonly>
                    </div>
                </div> <!-- fim linha -->
                <hr>

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
    <button class="btn btn-flat btn-success col-md-2" type="submit" form="apontamento-form"><strong>SALVAR</strong></button><br><br>
    <a class="btn btn-flat btn-dark" href="<?php echo base_url . '/admin?page=apontamento' ?>">Voltar</a>
</div>

<script>
    $(function() {        
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
    })  
</script>

