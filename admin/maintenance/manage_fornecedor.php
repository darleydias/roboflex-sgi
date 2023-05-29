<?php
require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT *
	from `fornecedor_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>

<div class="container-fluid">
	<form action="" id="fornecedor-form" autocomplete="off">
		<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="form-group">
			<label for="name" class="control-label">Razão Social</label>
			<input type="text" required="required" name="name" id="name" class="form-control rounded-0" value="<?php echo isset($name) ? $name : ''; ?>">
		</div>
		<div class="form-group">
			<label for="cnpj_fornecedor" class="control-label">CNPJ / CPF</label>
			<input type="text" name="cnpj_fornecedor" id="cnpj_fornecedor" class="form-control rounded-0" value="<?php echo isset($cnpj_fornecedor) ? $cnpj_fornecedor : ''; ?>">
		</div>
		<div class="form-group">
			<label for="pessoa_fornecedor" class="control-label">Pessoa para contato</label>
			<input type="text" name="pessoa_fornecedor" id="pessoa_fornecedor" class="form-control rounded-0" value="<?php echo isset($pessoa_fornecedor) ? $pessoa_fornecedor : ''; ?>">
		</div>
		
		<div class="form-group">
			<label for="tel_fornecedor" class="control-label">Telefone</label>
			<input type="text" name="tel_fornecedor" id="tel_fornecedor" class="form-control rounded-0 phone" value="<?php echo isset($tel_fornecedor) ? $tel_fornecedor : ''; ?>">
		</div>
		<div class="form-group">
			<label for="email_fornecedor" class="control-label">Email</label>
			<input type="email" name="email_fornecedor" id="email_fornecedor" step="any" class="form-control rounded-0 text-end" value="<?php echo isset($email_fornecedor) ? $email_fornecedor : ''; ?>">
		</div>
		<div class="form-group">
			<label for="status" class="control-label">Status</label>
			<select name="status" id="status" class="custom-select select">
			<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Ativo</option>
			<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inativo</option>
			</select>
		</div>
	</form>
</div>



<script>

jQuery.fn.maskCpfCnpj = function () {
    const masks = ['000.000.000-000', '00.000.000/0000-00'];
    const maskBehavior = function (val) {
        return val.length > 14 ? masks[1] : masks[0];
    };

    return this.mask(maskBehavior, {
        onKeyPress: function(val, e, field, options) {
            field.mask(maskBehavior.apply({}, arguments), options);
        }
    });
};


	$(document).ready(function(){

		$('#cnpj_fornecedor').maskCpfCnpj();

		$('body').on('focus', '.phone', function(){
        var maskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        options = {
            onKeyPress: function(val, e, field, options) {
                field.mask(maskBehavior.apply({}, arguments), options);

                if(field[0].value.length >= 14){
                    var val = field[0].value.replace(/\D/g, '');
                    if(/\d\d(\d)\1{7,8}/.test(val)){
                        field[0].value = '';
                        alert('Telefone Inválido');
                    }
                }
            }
        };
        $(this).mask(maskBehavior, options);
    });


        $('.select2').select2({placeholder:"Escolha aqui",width:"relative"})
		$('#fornecedor-form').submit(function(e){
			e.preventDefault();			
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_fornecedor",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("Ocorreu um erro",'error');
					end_loader();
				},
				success:function(resp){
					e.preventDefault();
					if(typeof resp =='object' && resp.status == 'success'){
						location.reload();
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            end_loader()
                    }else{
						alert_toast("Ocorreu um erro",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})
	})
	
</script>