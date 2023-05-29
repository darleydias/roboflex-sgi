<style>
    .zoom {
        padding: 50px;
        background-color: #2c2c2c;
        transition: transform .2s;
        /* Animation */
        width: 200px;
        height: 200px;
        margin: 0 auto;
        text-align: center;
    }

    .zoom2 {
        padding: 50px;
        background-color: darkcyan;
        transition: transform .2s;
        /* Animation */
        width: 200px;
        height: 75px;
        margin: 0 auto;
        text-align: center;
    }


    .pad-1 {
        padding-top: 120px;
        padding-left: 200px;
        padding-right: 200px;
    }

    .pad-2 {
        padding-top: 20px;
        padding-left: 200px;
        padding-right: 200px;
    }

    .font_color {
        color: #f2f2f2;
    }

    .zoom:hover {
        transform: scale(1.3);
        background-color: #3C8DBC;
        /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
    }

    .zoom2:hover {
        transform: scale(1.3);
        background-color: #3C8DBC;
        /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
    }

    .padding-btn {
        padding-top: 25px !important;
        padding-bottom: 20px !important;
    }

    .padding-btn-1 {
        padding-top: 15px !important;
        padding-bottom: 20px !important;
    }

    .font-w {
        font-weight: 600;
    }

</style>
<head>
    <div style="height:120px;"></div>
</head>

<div class="container-fluid">
<div class="row d-flex justify-content-around">
    <div class="form-group">
    <div class="font-w zoom shadow p-3 mb-5 bg-danger rounded font_color" id="create_requisitante" style="cursor: pointer;" href="javascript:void(0)" ;>
        REQUISITANTE<br> <br>
        <span style="color: white">
            <i class="fa-solid fa-address-card fa-4x"></i>
    </div>
    <div class="zoom2 shadow p-3 mb-5 bg-danger rounded font_color padding-btn" style="cursor: pointer;" onclick="window.location='<?php echo base_url ?>admin/?page=maintenance/requisitante';">
        Lista de Requisitantes
        <span style="color: white">
    </div>
    </div>


<!-- <div class="form-group">
    <div class="font-w zoom shadow p-3 mb-5 bg-success rounded font_color" id="create_cat_compra" style="cursor: pointer;" href="javascript:void(0)" ;>
        CATEGORIA DE COMPRA <br> <br>
        <span style="color: white">
            <i class="fa-solid fa-tag fa-5x"></i>
    </div>
    <div class="zoom2 shadow p-3 mb-5 bg-success rounded font_color text-center" style="cursor: pointer;" onclick="window.location='<?php echo base_url ?>admin/?page=maintenance/cat_compra';">
        Lista de Categorias de Compra
        <span style="color: white">
    </div>
</div> -->



<div class="form-group">
    <div class="font-w zoom shadow p-3 mb-5 bg-primary rounded font_color" id="create_setor" style="cursor: pointer;" href="javascript:void(0)" ;>
        SETOR UTILIZAÇÃO <br> <br>
        <span style="color: white">
            <i class="fa-solid fa-building fa-5x"></i>
    </div>
    <div class="zoom2 shadow p-3 mb-5 bg-primary rounded font_color padding-btn" style="cursor: pointer;" onclick="window.location='<?php echo base_url ?>admin/?page=maintenance/setor';">
        Lista de Setores
        <span style="color: white">
    </div>
    </div>

    
</div> <!-- row -->
</div> <!-- container -->
<script>
    $(document).ready(function() {
        $('#create_requisitante').click(function() {
            uni_modal("<i class='fa fa-plus'></i> Adicionar novo requisitante", "maintenance/manage_requisitante.php", "mid-large")
        });

        $('#create_cat_compra').click(function() {
            uni_modal("<i class='fa fa-plus'></i> Adicionar nova categoria de compra", "maintenance/manage_cat_compra.php", "mid-large")
        });

        $('#create_setor').click(function() {
            uni_modal("<i class='fa fa-plus'></i> Adicionar novo setor", "maintenance/manage_setor.php", "mid-large")
        });
    }) /* FIM */
</script>