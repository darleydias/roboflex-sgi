SE SALVAR, FECHAR O TOOGLE DA TABELA, E SALVAR COM ELE OCULTO, FICA ZERADO


alteração de id para name

antes
<div class="col-12 col-sm-6 col-md-3 text-center">
                 
                                                <label for="req_requisitante" class="control-label">Requisitante *</label>
                        <select name="req_requisitante" id="req_requisitante" class="select2 text-center" style="width:100%">
                            <option <?php echo !isset($req_requisitante) ? 'selected' : '' ?> disabled></option>
                            <?php
                            $requisitante = $conn->query("SELECT r.id, r.name FROM `requisitante_list` r where status = 1 order by `name` asc");
                            while ($row = $requisitante->fetch_assoc()) :
                            ?>
                                <option value="<?php echo $row['name'] ?>" <?php echo isset($req_requisitante) && $req_requisitante == $row['name'] ? "selected" : "" ?>><?php echo $row['name'] ?></option>
                            <?php endwhile; ?>
                        </select>
       
                    </div>

depois

<div class="col-12 col-sm-6 col-md-3 text-center">
                 
                                                <label for="req_requisitante" class="control-label">Requisitante *</label>
                        <select name="req_requisitante" id="req_requisitante" class="select2 text-center" style="width:100%">
                            <option <?php echo !isset($req_requisitante) ? 'selected' : '' ?> disabled></option>
                            <?php
                            $requisitante = $conn->query("SELECT r.id, r.name FROM `requisitante_list` r where status = 1 order by `name` asc");
                            while ($row = $requisitante->fetch_assoc()) :
                            ?>
                                <option value="<?php echo $row['name'] ?>" <?php echo isset($req_requisitante) && $req_requisitante == $row['name'] ? "selected" : "" ?>><?php echo $row['name'] ?></option>
                            <?php endwhile; ?>
                        </select>
       
                    </div>

                    
<div class="col-12 col-sm-6 col-md-3">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-th-list"></i></span>

            <div class="info-box-content">
            <span class="info-box-number text-left"><!-- PO Records --><h6>SOLICITAÇÃO</h6></span>
            <span class="info-box-number text-right"> Pendentes
                <?php 
                    echo $conn->query("SELECT p.id FROM `purchase_order_list` p
                    where status = 1")->num_rows;
                ?>
            </span>

            <span class="info-box-text text-left">
                Nome 1 <br>
                Nome 2 <br>
                Nome 3 <br>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>



    <!-- if e ifelse  -->

    <div class="row justify-content-around">
                            <?php if ($row['bot1']==='0'){ ?> <!-- cotacao 1 -->
                            
                            <div>
                            <strong>Fornecedor</strong><br>
                            <?php echo $row['cot1']?> <!-- resultado 1 -->
                            </div>

                            <div>
                            <strong>Valor</strong><br>
                            <?php echo $row['cot2']?> <!-- resultado 1 -->
                            </div>

                            <div>
                            <strong>Frete</strong><br>
                            <?php echo $row['cot3']?> <!-- resultado 1 -->
                            </div>

                            
                            <?php }
                             elseif ($row['bot1']==='1'){ ?> <!-- cotacao 2 -->
                            
                            <div>
                            <strong>Fornecedor</strong><br>
                            <?php echo $row['cot4']?> <!-- resultado 2 -->
                            </div>

                            <div>
                            <strong>Valor</strong><br>
                            <?php echo $row['cot5']?> <!-- resultado 2 -->
                            </div>

                            <div>
                            <strong>Frete</strong><br>
                            <?php echo $row['cot6']?> <!-- resultado 2 -->
                            </div>

                            <?php } 
                             elseif ($row['bot1']==='2'){ ?> <!-- cotacao 3 -->
                            <div>
                            <strong>Fornecedor</strong><br>
                            <?php echo $row['cot7']?> <!-- resultado 3 -->
                            </div>

                            <div>
                            <strong>Valor</strong><br>
                            <?php echo $row['cot8']?> <!-- resultado 3 -->
                            </div>

                            <div>
                            <strong>Frete</strong><br>
                            <?php echo $row['cot9']?> <!-- resultado 3 -->
                            </div>

                            <?php }  
                            ?>
                            </div>


                            









<!-- DIV AUTORIZAÇÃO -->

<!-- DIV AUTORIZAÇÃO -->
                    
<div class="form-group" style="display:none;">
                        <label for="estado_requisicao" class="control-label">Estado</label>
                        <select name="estado_requisicao" id="estado_requisicao" class="custom-select select2" required>
                            <option value="" disabled>s</option>
                            <option value="0" <?php echo isset($estado_requisicao) && $estado_requisicao == 0 ? 'selected' : '' ?>>solicitacao</option>
                            <option value="1" <?php echo isset($estado_requisicao) && $estado_requisicao == 1 ? 'selected' : '' ?>>autorizacao</option>
                            <option value="2" <?php echo isset($estado_requisicao) && $estado_requisicao == 2 ? 'selected' : '' ?>>cotacao</option>
                            <option value="3" <?php echo isset($estado_requisicao) && $estado_requisicao == 3 ? 'selected' : '' ?>>omie</option>
                            <option value="4" selected <?php echo isset($estado_requisicao) && $estado_requisicao == 4 ? 'selected' : '' ?>>chegada</option>
                        </select>
                    </div>









<div class="col-md-6">
                        <div class="form-group">
                            <label for="supplier_id" class="control-label">Categoria</label>
                            <select name="supplier_id" id="supplier_id" class="custom-select" required>
                            <option <?php echo !isset($supplier_id) ? 'selected' : '' ?> disabled></option>
                            <?php 
                            $supplier = $conn->query("SELECT * FROM `supplier_list` where status = 1 order by `name` asc");
                            while($row=$supplier->fetch_assoc()):
                            ?>
                            <option value="<?php echo $row['id'] ?>" <?php echo isset($supplier_id) && $supplier_id == $row['id'] ? "selected" : "" ?> ><?php echo $row['name'] ?></option>
                            <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                <!-- TEMPLATES -->
                
SELECIONAR DUAS OPÇÕES

<div class="form-group">
			<label for="NOME_DB" class="control-label">Status</label>
			<select name="NOME_DB" id="NOME_DB" class="custom-select selevt">
            <option value="" selected disabled>Escolha aqui</option>
			<option value="1" <?php echo isset($NOME_DB) && $NOME_DB == 1 ? 'selected' : '' ?>>Ativo</option>
			<option value="0" <?php echo isset($NOME_DB) && $NOME_DB == 0 ? 'selected' : '' ?>>Inativo</option>
			</select>
		</div>


INPUT PARA PREENCHER

<div class="col-md-3">
                                <label for="NOME_BANCOI" class="control-label">Data</label>
                                <input type="date" name="NOME_BANCOI" id="NOME_BANCOI" class="form-control rounded-0" value="<?php echo isset($NOME_BANCOI) ? $NOME_BANCOI : ''; ?>">
                       
                        </div>

INPUT PEGANDO DADOS DO BANCO ------ CRIAÇÃO

<div class="col-md-3">
			<label for="NOME_BANCOA" class="control-label">NOME_CAMPO</label>
			<select name="NOME_BANCOA" id="NOME_BANCOA" class="custom-select select2">
			<option <?php echo !isset($NOME_BANCOA) ? 'selected' : '' ?> disabled></option>
			<?php 
			$NOME_VARIAVEL = $conn->query("SELECT * FROM `NOME_TABELA` where status = 1 order by `name` asc");
			while($row=$NOME_VARIAVEL->fetch_assoc()):
			?>
			<option value="<?php echo $row['id'] ?>" <?php echo isset($NOME_BANCOA) && $NOME_BANCOA == $row['id'] ? "selected" : "" ?> ><?php echo $row['name'] ?></option>
			<?php endwhile; ?>
			</select>
            </div>


CRIAÇÃO DE UMA NOVA REQUISIÇÃO

EDITAR LINHAS:

5, supplier_list
6, item_list

171, supplier_list
187, item_list
252, po_items, item_list
497, Master
512, view_po


COLOCAR SERVIDOS EM LAN.

1- ABRIR CONFIG, 
APACHE HTTPD-XAMPP-CONF

2-Alias /phpmyadmin "C:/xampp7/phpMyAdmin/"
    <Directory "C:/xampp7/phpMyAdmin">
        AllowOverride AuthConfig
        Require local <------------- colocar require local ou require all granted
        ErrorDocument 403 /error/XAMPP_FORBIDDEN.html.var
    </Directory>

3- mudar base url, para ip








-----------------------------------------------------------------------------------------------
<div class="row justify-content-around">
<div class="col-md-3">  
			<label for="req_projeto" class="control-label">Projeto</label>
			<select name="req_projeto" id="req_projeto" class="custom-select selevt" onchange="showDiv(this);">
			<option value="1" <?php echo isset($req_projeto) && $req_projeto == 1 ? 'selected' : '' ?>>NÃO</option> 
			<option value="0" <?php echo isset($req_projeto) && $req_projeto == 0 ? 'selected' : '' ?>>SIM</option>
			</select>
            </div>
</div><br> <!-- fim linha -->
            
<div id="projeto_sim_nao" style="display:none">
<div class="row justify-content-around">

                        <div class="col-md-3">
                                <label for="req_proj_cod" class="control-label">Código Projeto</label>
                                <input type="text" name="req_proj_cod" id="req_proj_cod" class="form-control rounded-0" value="<?php echo isset($req_proj_cod) ? $req_proj_cod : ''; ?>">
                       
                        </div>

                        <div class="col-md-3">
                                <label for="req_proj_nome" class="control-label">Nome Projeto</label>
                                <input type="text" name="req_proj_nome" id="req_proj_nome" class="form-control rounded-0" value="<?php echo isset($req_proj_nome) ? $req_proj_nome : ''; ?>">
                       
                        </div>
</div><br> <!-- FIM LINHA -->
</div>



----------------------------------------------------------------------------------------------

<script>
function showDiv(select){
   if(select.value==0){
    document.getElementById('projeto_sim_nao').style.display = "block";
   } else{
    document.getElementById('projeto_sim_nao').style.display = "none";
   }
}
</script>

----------------------------------------------------------------------------


ADICIONAR POPOVER

ADICIONAR NO LABEL,A,TITLE, ETC....

data-toggle="popover" data-trigger="hover" data-content="Para melhor identificação e aquisição"

<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});
</script>





FORMATAÇÕES DAS FUNÇÕES

<APROVAR>
<a style="color: darkgreen"
<span style="color: Green;" class="fa fa-solid fa-check"></span>
</APROVAR>

