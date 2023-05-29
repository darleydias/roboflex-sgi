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

    .zoom:hover {
        transform: scale(1.5);
        background-color: #3C8DBC;
        /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
    }

    .zoom2:hover {
        transform: scale(1.5);
        background-color: #3C8DBC;
        /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
    }

    .bg-material {
        background-color: #F29F05;
    }

    .bg-material:hover {
        transform: scale(1.5);
        background-color: #F28705;
    }

    .bg-servico {
        background-color: #035AA6;
    }

    .bg-servico:hover {
        transform: scale(1.5);
        background-color: #0B2B40;
    }

    .font-w {
        font-weight: 600;
    }
</style>
<head>
    <div style="height: 120px;">

    </div>
</head>

<div class="container-fluid" style="height: auto;">
<div class="row d-flex justify-content-around">

<!-- <div class="form-group">

<div class="font-w zoom shadow p-3 mb-5 bg-success rounded text-light" id="create_categoria" style="cursor: pointer;" href="javascript:void(0)" ;>
        NOVA CATEGORIA <br> <br>
        <span style="color: white">
            <i class="fa-solid fa-tag fa-5x"></i>
    </div>
    <div class="zoom2 shadow p-3 mb-5 bg-success rounded text-light" style="cursor: pointer;" onclick="window.location='<.?php echo base_url ?>admin/?page=maintenance/supplier';">
        Lista de Categorias <br> <br>
        <span style="color: white">
    </div>
    
</div> -->




<div class="from-group">
    <div class="font-w zoom shadow p-3 mb-5 rounded font_color bg-material text-light" id="create_material" style="cursor: pointer;" href="javascript:void(0)" ;>
        NOVO MATERIAL <br> <br>
        <span style="color: white">
            <i class="fas fa-box fa-4x"></i>
    </div>
    <div class="zoom2 shadow p-3 mb-5 rounded text-light bg-material" style="cursor: pointer;" onclick="window.location='<?php echo base_url ?>admin/?page=maintenance/item';">
        Lista de Materiais <br> <br>
        <span style="color: white">
    </div>
</div>
<div class="form-group">
    <div class="font-w zoom shadow p-3 mb-5 rounded font_color bg-servico text-light" id="create_servico" style="cursor: pointer;" href="javascript:void(0)" ;>
        NOVO SERVIÇO <br> <br>
        <span style="color: white">
            <i class="fas fa-wrench fa-5x"></i>
    </div>
    <div class="zoom2 shadow p-3 mb-5 rounded text-light bg-servico" style="cursor: pointer;" onclick="window.location='<?php echo base_url ?>admin/?page=maintenance/servicos';">
        Lista de Serviços <br> <br>
        <span style="color: white">
    </div>
</div>

</div>

</div>
<script>
    $(document).ready(function() {
        $('#create_material').click(function() {
            uni_modal("<i class='fa fa-plus'></i> Adicionar Material", "maintenance/manage_item.php", "mid-large")
        });

        $('#create_servico').click(function() {
            uni_modal("<i class='fa fa-plus'></i> Adicionar Serviço", "maintenance/manage_servico.php", "mid-large")
        });

        $('#create_categoria').click(function() {
            uni_modal("<i class='fa fa-plus'></i> Adicionar nova categoria", "maintenance/manage_supplier.php", "mid-large")
        });

    }) /* FIM */
</script>