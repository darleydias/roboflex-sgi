
<style>
body{
zoom: 90%;
}
</style>

<head>
    <div style="height: 120px;">
    </div>
</head>

<div class="container-fluid">
<div class="row d-flex justify-content-center">

    <div class="zoom shadow p-3 mb-5 bg-body rounded font-color-solicitar bg-material" style="cursor: pointer; width:250px;" onclick="window.location='<?php echo base_url ?>admin/?page=requisicoes/solicitacao_material';">
        MATERIAL <br> <br>
        <span style="color: white">
            <i class="fas fa-box fa-4x"></i>
    </div>
    
    <div class="zoom shadow p-3 mb-5 bg-body rounded font-color-solicitar bg-servico" style="cursor: pointer; width:250px;" onclick="window.location='<?php echo base_url ?>admin/?page=requisicoes/solicitacao_servico';">
        SERVIÇO <br> <br>
        <span style="color: white">
            <i class="fas fa-wrench fa-5x"></i>
    </div>

    <div class="zoom shadow p-3 mb-5 bg-body rounded font-color-solicitar bg-gray" style="cursor: pointer; width:250px; " onclick="window.location='<?php echo base_url ?>admin/?page=historico_req';">
        ACOMPANHAMENTO <br> <br>
        <span style="color: white">
        <i class="fa fa-search fa-5x"></i>
    </div>

</div>

<!-- <div class="row justify-content-around">
        <div class="form col-sm-6 col-md-3">
		<a style="width:100%;" onclick="window.location='<?php echo base_url ?>admin/?page=historico_req'" class="btn btn-flat btn-success">Histórico das requisições</a>
	    </div>
    </div> row -->
</div>
