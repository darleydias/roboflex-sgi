<?php require_once('./../../config.php') ?>
<?php 
 $qry = $conn->query("SELECT f.* FROM `fornecedor_list` f where  f.id = '{$_GET['id']}' ");
 if($qry->num_rows > 0){
     foreach($qry->fetch_assoc() as $k => $v){
         $$k=$v;
     }
 }
?>
   <style>
    #uni_modal .modal-footer{
        display:none;
    }
    .fade{
    background-color: transparent;
    }
</style> 
<div class="container-fluid" id="print_out">
    <div id='transaction-printable-details' class='position-relative'>
        <div class="row">
            <fieldset class="w-100">
                <div class="col-12">
                    
                    <dl>
                        <dt class="text-info">Razão Social:</dt>
                        <dd class="pl-3"><?php echo $name ?></dd>
                        <dt class="text-info">CNPJ:</dt>
                        <dd class="pl-3"><?php echo $cnpj_fornecedor ?></dd>
                        <dt class="text-info">Pessoa para Contato:</dt>
                        <dd class="pl-3"><?php echo $pessoa_fornecedor ?></dd>
                        <dt class="text-info">Telefone:</dt>
                        <dd class="pl-3"><?php echo $tel_fornecedor ?></dd>
                        <dt class="text-info">Email:</dt>
                        <dd class="pl-3"><?php echo $email_fornecedor ?></dd>
                        
                        <dt class="text-info">Status:</dt>
                        <dd class="pl-3">
                            <?php if($status == 1): ?>
                                <span class="badge badge-success rounded-pill">Ativo</span>
                            <?php else: ?>
                                <span class="badge badge-danger rounded-pill">Inativo</span>
                            <?php endif; ?>
                        </dd>
                    </dl>
                </div>
            </fieldset>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-12">
        <div class="d-flex justify-content-end align-items-center">
            <button class="btn btn-dark btn-flat" type="button" id="cancel" data-dismiss="modal">Fechar</button>
        </div>
    </div>
</div>
    

<script>
    /* $(function(){
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
    }) */
</script>