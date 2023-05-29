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
        height: 60px;
        margin: 0 auto;
        text-align: center;
    }



    .font_color {
        color: #f2f2f2;
    }

    .zoom:hover {
        transform: scale(1.5);
        background-color: #3C8DBC;
        /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
    }

    .zoom2:hover {
        transform: scale(1.4);
        background-color: #3C8DBC;
        /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
    }

    .color-btn {
        background-color: #BF4565 !important;
    }

    .font-w {
        font-weight: 600;
    }
</style>

<head>
    <div style="height: 120px;">

    </div>
</head>

<div class="row d-flex justify-content-around">
<div class="form-group">
<div class="font-w zoom shadow p-3 mb-5 bg-success rounded text-light" id="create_fornecedor" style="cursor: pointer;" href="javascript:void(0)" ;>
        NOVO FORNECEDOR <br> <br>
        <span style="color: white">
            <i class="fa-solid fa-tag fa-5x"></i>
    </div>
    <div class="zoom2 shadow p-3 mb-5 bg-success rounded text-light" style="cursor: pointer;" onclick="window.location='<?php echo base_url ?>admin/?page=maintenance/fornecedor';">
        Lista de Fornecedores <br> <br>
        <span style="color: white">
    </div>
</div>
</div>

</div>
<script>
    $(document).ready(function() {
        $('#create_fornecedor').click(function() {
            uni_modal("<i class='fa fa-plus'></i> Adicionar novo fornecedor", "maintenance/manage_fornecedor.php", "mid-large")
        })

    }) /* FIM */
</script>