<style>
body{
zoom: 90%;
}
.item {
  cursor: pointer;
  width: 280px;
  text-align: center;
  overflow: hidden;
  transition: all 0.2s ease-in-out;
  position: relative;
}

.item:hover {
  transform: scale(1.1) rotate(5deg);
}

.item i {
  margin-top: 20px;
  margin-bottom: 20px;
  color: white;
}

.item h2 {
  color: white;
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 20px;
  margin-top: 0;
  position: absolute;
  bottom: -35px;
  left: 0;
  width: 100%;
  background-color: rgba(0,0,0,0.5);
  padding: 20px;
  transition: all 0.2s ease-in-out;
}

.item:hover h2 {
  bottom: 0;
}
</style>

<div style="height:120px">

</div>


<div class="row d-flex justify-content-around" style="height: 100%;">
    <div class="form-group">
    <div class="item zoom shadow p-3 mb-5 bg-body rounded font-color-solicitar bg-material" onclick="window.location='<?php echo base_url ?>admin/?page=requisicoes/solicitacao_material';">
        <i class="fas fa-box fa-4x"></i>
        <h2>MATERIAL</h2>
    </div>
    </div>
    <div class="form-group">
    <div class="item zoom shadow p-3 mb-5 bg-body rounded font-color-solicitar bg-servico" onclick="window.location='<?php echo base_url ?>admin/?page=requisicoes/solicitacao_servico';">
        <i class="fas fa-wrench fa-5x"></i>
        <h2>SERVIÇO</h2>
    </div>
    </div>
    <div class="form-group">
    <div class="item zoom shadow p-3 mb-5 bg-body rounded font-color-solicitar bg-gray" onclick="window.location='<?php echo base_url ?>admin/?page=historico_req';">
        <i class="fa fa-search fa-5x"></i>
        <h2>ACOMPANHAMENTO</h2>
    </div>
    </div>
</div>
