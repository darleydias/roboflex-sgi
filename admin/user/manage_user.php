
<?php 
if(isset($_GET['id']) && $_GET['id'] > 0){
    $user = $conn->query("SELECT * FROM users where id ='{$_GET['id']}'");
    foreach($user->fetch_array() as $k =>$v){
        $meta[$k] = $v;
    }
}
?>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-body">
		<div class="container-fluid">
			<div id="msg"></div>
			<form action="" id="manage-user">	
				<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
				<div class="form-group col-6">
					<label for="name">Nome</label>
					<input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname']: '' ?>" required>
				</div>
				<div class="form-group col-6">
					<label for="name">Sobrenome</label>
					<input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname']: '' ?>" required>
				</div>
				<div class="form-group col-6">
					<label for="username">Usuário</label>
					<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required  autocomplete="off">
				</div>
				<div class="form-group col-6">
					<label for="password">Senha</label>
					<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off" <?php echo isset($meta['id']) ? "": 'required' ?>>
                    <?php if(isset($_GET['id'])): ?>
					<small class="text-info"><i>Deixe em branco para não alterar a senha.</i></small>
                    <?php endif; ?>
				</div>
				<div class="form-group col-6">
					<label for="type">Tipo de Usuário</label>
					<select name="type" id="type" class="custom-select" value="<?php echo isset($meta['type']) ? $meta['type']: '' ?>" required>
						<option value="1" <?php echo isset($type) && $type == 1 ? 'selected': '' ?>>Administrador nível 1</option>
						<option value="2"> <?php echo isset($type) && $type == 2 ? 'selected': '' ?>Administrador nível 2</option>
						<option value="3"> <?php echo isset($type) && $type == 3 ? 'selected': '' ?>Autorização Operacional</option>
						<option value="4" <?php echo isset($type) && $type == 4 ? 'selected': '' ?>>Autorização Financeiro</option>
						<option value="5"> <?php echo isset($type) && $type == 5 ? 'selected': '' ?>Autorização Negócios</option>
						<option value="6"> <?php echo isset($type) && $type == 6 ? 'selected': '' ?>Autorização Administrativo</option>
						<option value="7" <?php echo isset($type) && $type == 7 ? 'selected': '' ?>>Autorização P&D</option>
						<option value="8"> <?php echo isset($type) && $type == 8 ? 'selected': '' ?>Autorização Assistência Téc.</option>
						<option value="9"> <?php echo isset($type) && $type == 9 ? 'selected': '' ?>Compras</option>
						<option value="10" <?php echo isset($type) && $type == 10 ? 'selected': '' ?>>Financeiro</option>
						<option value="11"> <?php echo isset($type) && $type == 11 ? 'selected': '' ?>Requisição Operacional</option>
						<option value="12"> <?php echo isset($type) && $type == 12 ? 'selected': '' ?>Requisição Administrativo</option>
						<option value="13"> <?php echo isset($type) && $type == 13 ? 'selected': '' ?>Requisição Assistência Téc.</option>
						<option value="14"> <?php echo isset($type) && $type == 14 ? 'selected': '' ?>Requisição P&D</option>
						<option value="15"> <?php echo isset($type) && $type == 15 ? 'selected': '' ?>Requisição Negócios</option>
						<option value="16"> <?php echo isset($type) && $type == 16 ? 'selected': '' ?>Requisição Financeiro</option>
						<option value="17"> <?php echo isset($type) && $type == 17 ? 'selected': '' ?>Administrador nível 2 (Carlos)</option>
						<option value="18"> <?php echo isset($type) && $type == 18 ? 'selected': '' ?>Compras Matérias-primas</option>
						<option value="25"> <?php echo isset($type) && $type == 25 ? 'selected': '' ?>Apt. Mecânica</option>
						<option value="26"> <?php echo isset($type) && $type == 26 ? 'selected': '' ?>Apt. Identificação</option>
						<option value="27"> <?php echo isset($type) && $type == 27 ? 'selected': '' ?>Apt. Elétrica</option>
						<option value="28"> <?php echo isset($type) && $type == 28 ? 'selected': '' ?>Apt. Finalização</option>
						<option value="29"> <?php echo isset($type) && $type == 29 ? 'selected': '' ?>Apt. Expedição</option>
						<option value="30"> <?php echo isset($type) && $type == 30 ? 'selected': '' ?>Apt. Eletrônica</option>
						<option value="31"> <?php echo isset($type) && $type == 31 ? 'selected': '' ?>Cadastro AP</option>
						<option value="35"> <?php echo isset($type) && $type == 35 ? 'selected': '' ?>Recepção</option>
						<option value="36"> <?php echo isset($type) && $type == 36 ? 'selected': '' ?>Apt. Almoxarifado</option>
					</select>
				</div>
	

				<div class="form-group col-6">
					<label for="" class="control-label">Foto</label>
					<div class="custom-file">
		              <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
		              <label class="custom-file-label" for="customFile">Escolher Arquivo</label>
		            </div>
				</div>
				<div class="form-group col-6 d-flex justify-content-center">
					<img src="<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] :'') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
				</div>
			</form>
		</div>
	</div>
	
	<div class="card-footer">
			<div class="col-md-12">
				<div class="row">
					<button class="btn btn-sm btn-primary mr-2" form="manage-user">Salvar</button>
					<a class="btn btn-sm btn-secondary" href="./?page=user/list">Cancelar</a>
				</div>
			</div>
		</div>
</div>
<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<script>
	$(function(){
		$('.select2').select2({
			width:'resolve'
		})
	})
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$('#manage-user').submit(function(e){
		e.preventDefault();
		var _this = $(this)
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Users.php?f=save',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp ==1){
					location.href = './?page=user/list';
				}else{
					$('#msg').html('<div class="alert alert-danger">Usuário já existe</div>')
					$("html, body").animate({ scrollTop: 0 }, "fast");
				}
                end_loader()
			}
		})
	})

</script>