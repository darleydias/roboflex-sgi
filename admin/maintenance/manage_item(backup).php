<?php
require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT *
	from `item_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<div class="container-fluid">
	<form action="" id="item-form" autocomplete="off">
		<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="form-group">
			<label for="name" class="control-label">Nome do Material</label>
			<input type="text" name="name" id="name" class="form-control rounded-0" value="<?php echo isset($name) ? $name : ''; ?>">
		</div>
		<div class="form-group">
			<label for="cod_item" class="control-label">Código (Opcional)</label>
			<input type="text" name="cod_item" id="cod_item" class="form-control rounded-0" value="<?php echo isset($cod_item) ? $cod_item : ''; ?>">
		</div>
		<div class="form-group">
			<label for="description" class="control-label">Descrição (Opcional)</label>
			<textarea name="description" id="description" cols="30" rows="2" class="form-control form no-resize"><?php echo isset($description) ? $description : ''; ?></textarea>
		</div>
		
<div style="display:none;">
<select name="supplier_id" id="supplier_id" class="select2" style="width:100%;">
<option selected value="35" <?php echo isset($supplier_id) && $supplier_id == 35 ? 'selected' : '' ?>>material</option>
</select>

<div class="form-group">
			<label for="status" class="control-label">Status</label>
			<select name="status" id="status" class="custom-select select">
			<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Ativo</option>
			<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inativo</option>
			</select>
		</div>

</div>

		<div class="form-group" style="display:none;">
			<label for="mat_ou_ser" class="control-label">mat_ou_ser</label>
			<select name="mat_ou_ser" id="mat_ou_ser" class="custom-select select">
			<option selected value="1" <?php echo isset($mat_ou_ser) && $mat_ou_ser == 1 ? 'selected' : '' ?>>Material</option>
			<option value="0" <?php echo isset($mat_ou_ser) && $mat_ou_ser == 0 ? 'selected' : '' ?>>Serviço</option>
			</select>
		</div>
	</form>
</div>

<script>

	$(document).ready(function(){
    $('.select2').select2({placeholder:"Escolha aqui",width:"relative"})
	$('#item-form').submit(function(e){
	e.preventDefault();

	var codItemValue = $('#cod_item').val();
	var nameValue = $('#name').val();
	var descriptionValue = $('#description').val();

    nameValue = nameValue.replace(/"/g, '');
    nameValue = nameValue.replace(/'/g, '');

	codItemValue = codItemValue.replace(/"/g, '');
    codItemValue = codItemValue.replace(/'/g, '');

	descriptionValue = descriptionValue.replace(/"/g, '');
    descriptionValue = descriptionValue.replace(/'/g, '');


	$('#name').val(nameValue);
	$('#cod_item').val(codItemValue);
    $('#description').val(descriptionValue);

            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_item",
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