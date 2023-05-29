<style>
/* TEXTO */
.nav-link {
color: white !important;
}

.bg-primary{
background-color: #1f286e !important;
}

.font-r{
width: 30px;
text-align: center;
font-weight: bold;
}
</style>

<!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-no-expand">
        <!-- Brand Logo -->
        <a href="<?php echo base_url ?>admin" class="brand-link bg-primary text-sm">
        <img src="<?php echo validate_image($_settings->info('min_logo'))?>" alt="Store Logo" class="brand-image img-circle elevation-3 bg-black" style="width: 1.8rem;height: 1.8rem;max-height: unset">
        <span class="brand-text font-weight-light"><?php echo $_settings->info('short_name') ?></span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden">
          <div class="os-resize-observer-host observed">
            <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
          </div>
          <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
            <div class="os-resize-observer"></div>
          </div>
          <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 646px;"></div>
          <div class="os-padding">
            <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
              <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
                <!-- Sidebar user panel (optional) -->
                <div class="clearfix"></div>
                <!-- Sidebar Menu -->
                <nav class="mt-4"> <h1>
                   <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">

<!-- PAINEL - TODOS -->

                   <li class="nav-item dropdown">
                      <a href="./" class="nav-link nav-home">
                      <div class="d-flex justify-content-start">
                      <i class="nav-icon fa-solid fa-tachometer-alt"></i>
                        <p class="text-center">
                        &nbsp;  &nbsp; Painel
                        </p>
                      </div>
                      </a>
                    </li>

<!-- ADMINISTRAÇÃO 1,2,17-->
<?php if($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2 || $_settings->userdata('type') == 17) : ?>
                    <li class="nav-header">Apontamento</li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=apontamento" class="nav-link nav-apontamento">
                      <div class="d-flex justify-content-start">
                      <i class="nav-icon fas fa-bullseye"></i>
                        <p class="text-center">
                        &nbsp;  &nbsp; Realizar Apontamento
                        </p>
                      </div>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=apontamento/gerencia_apontamento" class="nav-link nav-gerencia_apontamento">
                      <div class="d-flex justify-content-start"> 
                      <i class="nav-icon fa-solid fa-list"></i>
                        <p class="text-center">
                          &nbsp; &nbsp; Adicionar Roteiro
                        </p>
                      </div>
                      </a>
                    </li>
                  
                    <li class="nav-header">Requisição</li>
                    <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=solicitar_requisicao" class="nav-link nav-solicitar_requisicao">
                      <div class="d-flex justify-content-start">
                      <i class="nav-icon fas fa-th-list"></i>
                        <p class="text-center">
                        &nbsp;  &nbsp; Requisição
                        </p>
                      </div>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=autorizacao" class="nav-link nav-autorizacao text-center">
                     <div class="d-flex flex-nowrap">
                      <div class="d-flex justify-content-start align-items-end">
                      <div class="align-items-end font-r bg-warning">
                        <?php
                     echo $conn->query("SELECT p.id FROM `purchase_order_list` p
                     inner join supplier_list s on p.supplier_id = s.id
                     WHERE (p.status = 0 and p.req_autorizada = 'Não')
                     group by p.id")->num_rows; ?>
                        </div>
                        <p class="text-center">
                        &nbsp; &nbsp; Autorização
                        </p>
                      </div>
                        </div>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=cotacao" class="nav-link nav-cotacao">
                        <div class="d-flex flex-nowrap">
                      <div class="d-flex justify-content-start">
                      <div class="font-r bg-warning align-items-end">
                        <?php 
                         echo $conn->query("SELECT p.id FROM purchase_order_list p
                         left join receiving_list r on r.form_id = p.id
                         WHERE (p.req_autorizada = 'Sim' and r.estado_requisicao IS NULL)
                         OR (r.estado_requisicao = 1 and r.req_aprov = 1)")->num_rows; ?>
                        </div>
                        <p class="text-center">
                        &nbsp; &nbsp; Cotação
                        </p>
                      </div>
                        </div>
                      </a>
                    </li>

                     <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=requisicoes" class="nav-link nav-requisicoes">
                      <div class="d-flex flex-nowrap">
                      <div class="d-flex justify-content-start">
                      <div class="font-r bg-warning align-items-end">
                        <?php 
                    echo $conn->query("SELECT r.id FROM `receiving_list` r
                    INNER JOIN purchase_order_list p ON r.form_id = p.id
                    WHERE (r.estado_requisicao = 2 AND r.total_aprov <= 2000.00)
                    OR (r.total_aprov between 2000.01 AND 9000000.00 AND nome_aprovacao2 = '')
                    OR (r.total_aprov >= 9000000.01 AND (nome_aprovacao2 = '' OR nome_aprovacao3 = ''))")->num_rows; ?>
                        </div>
                        <p class="text-center">
                        &nbsp; &nbsp; Aprovação
                        </p>
                      </div>
                        </div>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=omie" class="nav-link nav-omie">
                      <div class="d-flex flex-nowrap">
                      <div class="d-flex justify-content-start">
                      <div class="font-r bg-warning align-items-end">
                        <?php 
                    echo $conn->query("SELECT r.id FROM `receiving_list` r
                    INNER JOIN purchase_order_list p ON r.form_id = p.id
                    WHERE (r.estado_requisicao = 3 and req_aprov2 = 1 and p.etapa_mat_ou_ser = 1 and total_aprov <= 2000.00)
                    OR (r.estado_requisicao = 3 and req_aprov2 = 1 and p.etapa_mat_ou_ser = 1 and not nome_aprovacao2 = '' and total_aprov between 2000.01 and 9000000.00)
                    OR (r.estado_requisicao = 3 and req_aprov2 = 1 and p.etapa_mat_ou_ser = 1 and not nome_aprovacao2 = '' and not nome_aprovacao3 = '' and total_aprov >= 9000000.01)")->num_rows; ?>
                        </div>
                      <!-- <i class="nav-icon fa-solid fa-boxes-packing"></i> -->
                        <p class="text-center">
                        &nbsp; &nbsp; Pedido de Compra Material
                        </p>
                      </div>
                        </div>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=servico" class="nav-link nav-servico">
                       <div class="d-flex flex-nowrap">
                      <div class="d-flex justify-content-start">
                      <div class="font-r bg-warning align-items-end">
                        <?php 
                    echo $conn->query("SELECT r.id FROM `receiving_list` r
                    INNER JOIN purchase_order_list p ON r.form_id = p.id
                    WHERE (r.estado_requisicao = 3 and req_aprov2 = 1 and p.etapa_mat_ou_ser = 0 and total_aprov <= 2000.00)
                    OR (r.estado_requisicao = 3 and req_aprov2 = 1 and p.etapa_mat_ou_ser = 0 and not nome_aprovacao2 = '' and total_aprov between 2000.01 and 9000000.00) /* ferias ERA 2.000.01 A 10000 */
                    OR (r.estado_requisicao = 3 and req_aprov2 = 1 and p.etapa_mat_ou_ser = 0 and not nome_aprovacao2 = '' and not nome_aprovacao3 = '' and total_aprov >= 9000000.01)")->num_rows; ?>
                        </div>
                        <p class="text-center">
                        &nbsp; &nbsp; Pedido de Compra Serviço
                        </p>
                      </div>
                        </div>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=financeiro" class="nav-link nav-financeiro">
                       <div class="d-flex flex-nowrap">
                      <div class="d-flex justify-content-start">
                      <div class="font-r bg-warning align-items-end">
                        <?php 
                    echo $conn->query("SELECT r.id FROM `receiving_list` r
                    INNER JOIN purchase_order_list p ON r.form_id = p.id
                    WHERE (r.estado_requisicao = 7 and req_aprov2 = 1 and total_aprov <= 2000.00)
                    OR (r.estado_requisicao = 7 and req_aprov2 = 1 and not nome_aprovacao2 = '' and total_aprov between 2000.01 and 9000000.00) /* ferias ERA 2.000.01 A 10000 */
                    OR (r.estado_requisicao = 7 and req_aprov2 = 1 and not nome_aprovacao2 = '' and not nome_aprovacao3 = '' and total_aprov >= 9000000.01)")->num_rows; ?>
                        </div>
                        <p class="text-center">
                        &nbsp; &nbsp; Pagamento
                        </p>
                      </div>
                        </div>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=recepcao" class="nav-link nav-recepcao">
                       <div class="d-flex flex-nowrap">
                      <div class="d-flex justify-content-start">
                      <div class="font-r bg-warning align-items-end">
                        <?php 
                    echo $conn->query("SELECT r.id FROM `receiving_list` r
                    INNER JOIN purchase_order_list p ON r.form_id = p.id
                    INNER JOIN po_items q ON q.po_id = p.id
                    INNER JOIN stock_list s ON s.item_id = q.item_id
                    WHERE r.estado_requisicao = 4 AND r.etapa_omie = 1
                    OR (r.estado_requisicao = 5 AND r.recepcao_final is null OR r.recepcao_final = 0)
                    GROUP BY p.id")->num_rows; ?>
                        </div>
                        <p class="text-center">
                        &nbsp; &nbsp; Recebimento
                        </p>
                      </div>
                        </div>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=receiving" class="nav-link nav-receiving">
                      <div class="d-flex justify-content-start">
                      <i class="nav-icon fa-solid fa-eye"></i>
                        <p class="text-center">
                        &nbsp; &nbsp; Visualização
                        </p>
                      </div>
                      </a>
                    </li>


<?php endif; ?>
<!-- FIM ADMINISTRAÇÃO -->


<!-- GERENCIA 1 -->
<?php if($_settings->userdata('type') == 1) : ?>
                    <li class="nav-header">Gerenciamento</li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=inclusao_fornecedor" class="nav-link nav-inclusao_fornecedor">
                        <i class="nav-icon fas fa-tag"></i>
                        <p>
                          Fornecedor
                        </p>
                      </a>
                    </li>

                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=inclusao_mat_serv" class="nav-link nav-inclusao_mat_serv">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                          Materiais e Serviços
                        </p>
                      </a>
                    </li>

                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=inclusao_diversa" class="nav-link nav-inclusao_diversa">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                          Outros
                        </p>
                      </a>
                    </li>

                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=user/list" class="nav-link nav-user_list">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                          Usuários
                        </p>
                      </a>
                    </li>

                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=system_info" class="nav-link nav-system_info">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                          Configurações
                        </p>
                      </a>
                    </li>
<?php endif; ?> 
<!-- FIM GERENCIA -->

<!-- AUTORIZAÇÃO 3,4,5,6,7,8-->
<!-- grupos
  grupo 3 = operacional
  grupo 4 = financeiro
  grupo 5 = negócios
  grupo 6 = administrativo
  grupo 7 = p&d
  grupo 8 = assistência técnica -->
<?php if($_settings->userdata('type') == '3' || $_settings->userdata('type') == '4' || $_settings->userdata('type') == '5' || $_settings->userdata('type') == '6' || $_settings->userdata('type') == '7' || $_settings->userdata('type') == '8') : ?>
                    <li class="nav-header">Requisição</li>
                 <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=solicitar_requisicao" class="nav-link nav-solicitar_requisicao">
                      <div class="d-flex justify-content-start">
                      <i class="nav-icon fas fa-th-list"></i>
                        <p class="text-center">
                        &nbsp;  &nbsp; Requisição
                        </p>
                      </div>
                      </a>
                    </li>

                     <li class="nav-item">
                <a href="<?php echo base_url ?>admin/?page=autorizacao" class="nav-link nav-autorizacao text-center">
                     <div class="d-flex flex-nowrap">
                      <div class="d-flex justify-content-start align-items-end">
                      <div class="align-items-end font-r bg-warning">
                    <?php
                    $usuario_setor = $_settings->userdata('usuario_setor');
                    echo $conn->query("SELECT p.id FROM `purchase_order_list` p
                    inner join supplier_list s on p.supplier_id = s.id
                    WHERE (p.status = 0 AND p.req_autorizada = 'Não' AND p.req_grupo = '$usuario_setor')
                    group by p.id")->num_rows; ?>
                        </div>
                        <p class="text-center">
                        &nbsp; &nbsp; Autorização
                        </p>
                      </div>
                        </div>
                      </a>
                    </li>
<?php endif; ?>
<!-- FIM AUTORIZAÇÃO -->


<!-- FINANCEIRO AUTORIZAÇÃO 4,10 -->
<?php if($_settings->userdata('type') == '4' || $_settings->userdata('type') == 10) : ?>
  <li class="nav-header">Requisição</li>
  <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=servico" class="nav-link nav-servico">
                       <div class="d-flex flex-nowrap">
                      <div class="d-flex justify-content-start">
                      <div class="font-r bg-warning align-items-end">
                        <?php 
                    echo $conn->query("SELECT r.id FROM `receiving_list` r
                    INNER JOIN purchase_order_list p ON r.form_id = p.id
                    WHERE (r.estado_requisicao = 3 and req_aprov2 = 1 and p.etapa_mat_ou_ser = 0 and total_aprov <= 2000.00)
                    OR (r.estado_requisicao = 3 and req_aprov2 = 1 and p.etapa_mat_ou_ser = 0 and not nome_aprovacao2 = '' and total_aprov between 2000.01 and 9000000.00) /* ferias ERA 2.000.01 A 10000 */
                    OR (r.estado_requisicao = 3 and req_aprov2 = 1 and p.etapa_mat_ou_ser = 0 and not nome_aprovacao2 = '' and not nome_aprovacao3 = '' and total_aprov >= 9000000.01)")->num_rows; ?>
                        </div>
                        <p class="text-center">
                        &nbsp; &nbsp; Pedido de Compra Serviço
                        </p>
                      </div>
                        </div>
                      </a>
                    </li>

  <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=financeiro" class="nav-link nav-financeiro">
                       <div class="d-flex flex-nowrap">
                      <div class="d-flex justify-content-start">
                      <div class="font-r bg-warning align-items-end">
                        <?php 
                    echo $conn->query("SELECT r.id FROM `receiving_list` r
                    INNER JOIN purchase_order_list p ON r.form_id = p.id
                    WHERE (r.estado_requisicao = 7 and req_aprov2 = 1 and total_aprov <= 2000.00)
                    OR (r.estado_requisicao = 7 and req_aprov2 = 1 and not nome_aprovacao2 = '' and total_aprov between 2000.01 and 9000000.00) /* ferias ERA 2.000.01 A 10000 */
                    OR (r.estado_requisicao = 7 and req_aprov2 = 1 and not nome_aprovacao2 = '' and not nome_aprovacao3 = '' and total_aprov >= 9000000.01)")->num_rows; ?>
                        </div>
                        <p class="text-center">
                        &nbsp; &nbsp; Pagamento
                        </p>
                      </div>
                        </div>
                      </a>
                    </li>
                    
                    <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=receiving" class="nav-link nav-receiving">
                      <div class="d-flex justify-content-start">
                      <i class="nav-icon fa-solid fa-eye"></i>
                        <p class="text-center">
                        &nbsp; &nbsp; Visualização
                        </p>
                      </div>
                      </a>
                    </li>
<?php endif; ?>
<!-- FIM FINANCEIRO -->


<!-- COMPRAS (OMIE) 9 e COMPRAS MATÉRIAS PRIMAS 18 -->
<?php if($_settings->userdata('type') == '9' || $_settings->userdata('type') == '18'): ?>
    <li class="nav-header">Requisição</li>
    <li class="nav-item">
                    <a href="<?php echo base_url ?>admin/?page=solicitar_requisicao" class="nav-link nav-solicitar_requisicao">
                    <div class="d-flex justify-content-start">
                    <i class="nav-icon fas fa-th-list"></i>
                      <p class="text-center">
                      &nbsp;  &nbsp; Requisição
                      </p>
                    </div>
                    </a>
                  </li>

                  <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=cotacao" class="nav-link nav-cotacao">
                        <div class="d-flex flex-nowrap">
                      <div class="d-flex justify-content-start">
                      <div class="font-r bg-warning align-items-end">
                        <?php 
                         echo $conn->query("SELECT p.id FROM purchase_order_list p
                         left join receiving_list r on r.form_id = p.id
                         WHERE (p.req_autorizada = 'Sim' and r.estado_requisicao IS NULL)
                         OR (r.estado_requisicao = 1 and r.req_aprov = 1)")->num_rows; ?>
                        </div>
                        <p class="text-center">
                        &nbsp; &nbsp; Cotação
                        </p>
                      </div>
                        </div>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=omie" class="nav-link nav-omie">
                      <div class="d-flex flex-nowrap">
                      <div class="d-flex justify-content-start">
                      <div class="font-r bg-warning align-items-end">
                        <?php 
                    echo $conn->query("SELECT r.id FROM `receiving_list` r
                    INNER JOIN purchase_order_list p ON r.form_id = p.id
                    WHERE (r.estado_requisicao = 3 and req_aprov2 = 1 and p.etapa_mat_ou_ser = 1 and total_aprov <= 2000.00)
                    OR (r.estado_requisicao = 3 and req_aprov2 = 1 and p.etapa_mat_ou_ser = 1 and not nome_aprovacao2 = '' and total_aprov between 2000.01 and 9000000.00)
                    OR (r.estado_requisicao = 3 and req_aprov2 = 1 and p.etapa_mat_ou_ser = 1 and not nome_aprovacao2 = '' and not nome_aprovacao3 = '' and total_aprov >= 9000000.01)")->num_rows;?>
                        </div>
                        <p class="text-center">
                        &nbsp; &nbsp; Pedido de Compra Material
                        </p>
                      </div>
                        </div>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=servico" class="nav-link nav-servico">
                       <div class="d-flex flex-nowrap">
                      <div class="d-flex justify-content-start">
                      <div class="font-r bg-warning align-items-end">
                        <?php 
                    echo $conn->query("SELECT r.id FROM `receiving_list` r
                    INNER JOIN purchase_order_list p ON r.form_id = p.id
                    WHERE (r.estado_requisicao = 3 and req_aprov2 = 1 and p.etapa_mat_ou_ser = 0 and total_aprov <= 2000.00)
                    OR (r.estado_requisicao = 3 and req_aprov2 = 1 and p.etapa_mat_ou_ser = 0 and not nome_aprovacao2 = '' and total_aprov between 2000.01 and 9000000.00) /* ferias ERA 2.000.01 A 10000 */
                    OR (r.estado_requisicao = 3 and req_aprov2 = 1 and p.etapa_mat_ou_ser = 0 and not nome_aprovacao2 = '' and not nome_aprovacao3 = '' and total_aprov >= 9000000.01)")->num_rows; ?>
                        </div>
                        <p class="text-center">
                        &nbsp; &nbsp; Pedido de Compra Serviço
                        </p>
                      </div>
                        </div>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=receiving" class="nav-link nav-receiving">
                      <div class="d-flex justify-content-start">
                      <i class="nav-icon fa-solid fa-eye"></i>
                        <p class="text-center">
                        &nbsp; &nbsp; Visualização
                        </p>
                      </div>
                      </a>
                    </li>
                    
                    <li class="nav-header">Gerenciamento</li>
                  <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=inclusao_mat_serv" class="nav-link nav-inclusao_mat_serv">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                          Materiais e Serviços
                        </p>
                      </a>
                    </li>                    
<?php endif; ?>
<!-- FIM COMPRAS -->


<!-- REQUISIÇÃO 11,12,13,14,15,16 -->
<?php if($_settings->userdata('type') == '11' || $_settings->userdata('type') == '12' || $_settings->userdata('type') == '13' || $_settings->userdata('type') == '14' || $_settings->userdata('type') == '15' || $_settings->userdata('type') == '16') : ?>
           <li class="nav-header">Requisição</li>
               <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=solicitar_requisicao" class="nav-link nav-solicitar_requisicao">
                      <div class="d-flex justify-content-start">
                      <i class="nav-icon fas fa-th-list"></i>
                        <p class="text-center">
                        &nbsp;  &nbsp; Requisição
                        </p>
                      </div>

                      </a>
                    </li>               
<?php endif; ?>
<!-- FIM REQUISIÇÃO-->


<!-- APONTAMENTO 25,26,27,28,29,30 -->
<?php if($_settings->userdata('type') == 25 || $_settings->userdata('type') == 26 || $_settings->userdata('type') == 27 || $_settings->userdata('type') == 28 || $_settings->userdata('type') == 29 || $_settings->userdata('type') == 30) : ?>
    <li class="nav-header">Apontamento</li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=apontamento" class="nav-link nav-apontamento">
                        <i class="nav-icon fas fa-bullseye"></i>
                        <p>
                          Realizar Apontamento
                        </p>
                      </a>
                    </li>
<?php endif; ?>
<!-- FIM APONTAMENTO -->


<!-- Recebimento 35 -->
<?php if($_settings->userdata('type') == 35) : ?>                   
                    <li class="nav-header">Requisição</li>
                    <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=recepcao" class="nav-link nav-recepcao">
                       <div class="d-flex flex-nowrap">
                      <div class="d-flex justify-content-start">
                      <div class="font-r bg-warning align-items-end">
                        <?php 
                    echo $conn->query("SELECT r.id FROM `receiving_list` r
                    INNER JOIN purchase_order_list p ON r.form_id = p.id
                    INNER JOIN po_items q ON q.po_id = p.id
                    INNER JOIN stock_list s ON s.item_id = q.item_id
                    WHERE r.estado_requisicao = 4 AND r.etapa_omie = 1
                    OR (r.estado_requisicao = 5 AND r.recepcao_final is null OR r.recepcao_final = 0)
                    GROUP BY p.id")->num_rows; ?>
                        </div>
                        <p class="text-center">
                        &nbsp; &nbsp; Recebimento
                        </p>
                      </div>
                        </div>
                      </a>
                    </li>
<?php endif; ?>
<!-- FIM Recebimento -->


<!-- ALMOXARIFADO 36 -->
<?php if($_settings->userdata('type') == '36'): ?>
  <li class="nav-header">Apontamento</li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=apontamento" class="nav-link nav-apontamento">
                        <i class="nav-icon fas fa-bullseye"></i>
                        <p>
                          Realizar Apontamento
                        </p>
                      </a>
                    </li>
<?php endif; ?>
<!-- FIM ALMOXARIFADO-->


<!--*******************-->
<!-- CASOS ESPECÍFICOS -->
<!--*******************-->

<!-- Ana Paula Gomes (P&D) -->
<?php if($_settings->userdata('username') == 'Ana Gomes') : ?>
      <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=cotacao" class="nav-link nav-cotacao">
                        <div class="d-flex flex-nowrap">
                      <div class="d-flex justify-content-start">
                      <div class="font-r bg-warning align-items-end">
                        <?php 
                         echo $conn->query("SELECT p.id FROM purchase_order_list p
                         left join receiving_list r on r.form_id = p.id
                         WHERE (p.req_autorizada = 'Sim' and r.estado_requisicao IS NULL AND p.req_grupo = 'P&D')
                         OR (r.estado_requisicao = 1 and r.req_aprov = 1 AND p.req_grupo = 'P&D')")->num_rows;
                          ?>
                        </div>
                      <!-- <i class="nav-icon fa-solid fa-brazilian-real-sign"></i> -->
                        <p class="text-center">
                        &nbsp; &nbsp; Cotação
                        </p>
                      </div>
                        </div>
                      </a>
                    </li>
<?php endif; ?>
<!-- FIM Ana Paula Gomes -->


<!-- Isabela Resende -->
<?php if($_settings->userdata('username') == 'Isabela Resende' || $_settings->userdata('username') == 'Raiane') : ?>

  <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=omie" class="nav-link nav-omie">
                      <div class="d-flex flex-nowrap">
                      <div class="d-flex justify-content-start">
                      <div class="font-r bg-warning align-items-end">
                        <?php 
                    echo $conn->query("SELECT r.id FROM `receiving_list` r
                    INNER JOIN purchase_order_list p ON r.form_id = p.id
                    WHERE (r.estado_requisicao = 3 and req_aprov2 = 1 and p.etapa_mat_ou_ser = 1 and total_aprov <= 2000.00)
                    OR (r.estado_requisicao = 3 and req_aprov2 = 1 and p.etapa_mat_ou_ser = 1 and not nome_aprovacao2 = '' and total_aprov between 2000.01 and 9000000.00)
                    OR (r.estado_requisicao = 3 and req_aprov2 = 1 and p.etapa_mat_ou_ser = 1 and not nome_aprovacao2 = '' and not nome_aprovacao3 = '' and total_aprov >= 9000000.01)")->num_rows; ?>
                        </div>
                      <!-- <i class="nav-icon fa-solid fa-boxes-packing"></i> -->
                        <p class="text-center">
                        &nbsp; &nbsp; Pedido de Compra Material
                        </p>
                      </div>
                        </div>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=financeiro" class="nav-link nav-financeiro">
                       <div class="d-flex flex-nowrap">
                      <div class="d-flex justify-content-start">
                      <div class="font-r bg-warning align-items-end">
                        <?php 
                    echo $conn->query("SELECT r.id FROM `receiving_list` r
                    INNER JOIN purchase_order_list p ON r.form_id = p.id
                    WHERE (r.estado_requisicao = 3 and req_aprov2 = 1 and p.etapa_mat_ou_ser = 0 and total_aprov <= 2000.00)
                    OR (r.estado_requisicao = 3 and req_aprov2 = 1 and p.etapa_mat_ou_ser = 0 and not nome_aprovacao2 = '' and total_aprov between 2000.01 and 9000000.00)
                    OR (r.estado_requisicao = 3 and req_aprov2 = 1 and p.etapa_mat_ou_ser = 0 and not nome_aprovacao2 = '' and not nome_aprovacao3 = '' and total_aprov >= 9000000.01)")->num_rows; ?>
                        </div>
                        <p class="text-center">
                        &nbsp; &nbsp; Pagamento
                        </p>
                      </div>
                        </div>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=recepcao" class="nav-link nav-recepcao">
                       <div class="d-flex flex-nowrap">
                      <div class="d-flex justify-content-start">
                      <div class="font-r bg-warning align-items-end">
                        <?php 
                    echo $conn->query("SELECT r.id FROM `receiving_list` r
                    INNER JOIN purchase_order_list p ON r.form_id = p.id
                    INNER JOIN po_items q ON q.po_id = p.id
                    INNER JOIN stock_list s ON s.item_id = q.item_id
                    WHERE r.estado_requisicao = 4 AND r.etapa_omie = 1
                    OR (r.estado_requisicao = 5 AND r.recepcao_final is null OR r.recepcao_final = 0)
                    GROUP BY p.id")->num_rows; ?>
                        </div>
                        <p class="text-center">
                        &nbsp; &nbsp; Recebimento
                        </p>
                      </div>
                        </div>
                      </a>
                    </li>

      <li class="nav-header">Apontamento</li>
      <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=apontamento/gerencia_apontamento" class="nav-link nav-gerencia_apontamento">
                      <div class="d-flex justify-content-start"> 
                      <i class="nav-icon fa-solid fa-list"></i>
                        <p class="text-center">
                          &nbsp; &nbsp; Adicionar Roteiro
                        </p>
                      </div>
                      </a>
                    </li>
<?php endif; ?>
<!-- FIM Isabel Resende-->

<!-- Carolina Alves  -->
<?php if($_settings->userdata('username') == 'Carolina') : ?>
      <li class="nav-header">Apontamento</li>
      <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=apontamento/gerencia_apontamento" class="nav-link nav-gerencia_apontamento">
                      <div class="d-flex justify-content-start"> 
                      <i class="nav-icon fa-solid fa-list"></i>
                        <p class="text-center">
                          &nbsp; &nbsp; Adicionar Roteiro
                        </p>
                      </div>
                      </a>
                    </li>
<?php endif; ?>
<!-- FIM Carolina Alves-->


<!-- Ana Paula Moura, Ana Vitória -->
<?php if($_settings->userdata('username') == 'Ana Moura' || $_settings->userdata('username') == 'Ana Vitoria') : ?>
                    <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=recepcao" class="nav-link nav-recepcao">
                       <div class="d-flex flex-nowrap">
                      <div class="d-flex justify-content-start">
                      <div class="font-r bg-warning align-items-end">
                        <?php 
                    echo $conn->query("SELECT r.id FROM `receiving_list` r
                    INNER JOIN purchase_order_list p ON r.form_id = p.id
                    INNER JOIN po_items q ON q.po_id = p.id
                    INNER JOIN stock_list s ON s.item_id = q.item_id
                    WHERE r.estado_requisicao = 4 AND r.etapa_omie = 1
                    OR (r.estado_requisicao = 5 AND r.recepcao_final is null OR r.recepcao_final = 0)
                    GROUP BY p.id")->num_rows; ?>
                        </div>
                        <p class="text-center">
                        &nbsp; &nbsp; Recebimento
                        </p>
                      </div>
                        </div>
                      </a>
                    </li>
<?php endif; ?>
<!-- FIM Ana Paula Moura e Ana Vitória-->

<!-- Nathan Souza -->
<?php if($_settings->userdata('username') == 'Nathan') : ?>
  <li class="nav-header">Apontamento</li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=apontamento" class="nav-link nav-apontamento">
                        <i class="nav-icon fas fa-bullseye"></i>
                        <p>
                          Realizar Apontamento
                        </p>
                      </a>
                    </li>
<?php endif; ?>
<!-- FIM Nathan-->


                  </ul>
                </nav>
                <!-- /.sidebar-menu -->
              </div>
            </div>
          </div>
          <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
              <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
            </div>
          </div>
          <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
              <div class="os-scrollbar-handle" style="height: 55.017%; transform: translate(0px, 0px);"></div>
            </div>
          </div>
          <div class="os-scrollbar-corner"></div>
        </div>

        <!-- /.sidebar -->
      </aside>

      <script>
        var page;
    $(document).ready(function(){
      page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
      page = page.replace(/\//gi,'_');

      if($('.nav-link.nav-'+page).length > 0){
             $('.nav-link.nav-'+page).addClass('active')
        if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
            $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
          $('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
        }
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }
      }
      
		$('#receive-nav').click(function(){
      $('#uni_modal').on('shown.bs.modal',function(){
        $('#find-transaction [name="tracking_code"]').focus();
      })
			uni_modal("Enter Tracking Number","transaction/find_transaction.php");
		})
    })
  </script>