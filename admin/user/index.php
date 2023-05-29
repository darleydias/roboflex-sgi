<?php 
$user = $conn->query("SELECT * FROM users where id ='".$_settings->userdata('id')."'");
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
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
				<input type="hidden" name="id" value="<?php echo $_settings->userdata('id') ?>">
				<div class="form-group">
					<label for="name">Nome</label>
					<input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname']: '' ?>" required readonly>
				</div>
				<div class="form-group">
					<label for="name">Sobrenome</label>
					<input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname']: '' ?>" required readonly>
				</div>
				<div class="form-group">
					<label for="username">Usuário</label>
					<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required readonly autocomplete="off">
				</div>
				<div class="form-group">
    <label for="password">Senha</label>
    <input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
    <small><i>Deixe em branco para não alterar a senha.</i></small>
</div>
<div class="form-group">
    <label for="password_confirmation">Confirme a senha</label>
    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" value="" autocomplete="off">
</div>
<div class="form-group">
    <label for="" class="control-label">Foto</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
        <label class="custom-file-label" for="customFile">Escolher arquivo</label>
    </div>
</div>
<div class="form-group d-flex justify-content-center">
    <img src="<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] :'') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
</div>
</form>
</div>
</div>
<div class="card-footer">
    <div class="col-md-12">
        <div class="row">
            <button class="btn btn-sm btn-primary" id="submitBtn">Salvar</button>
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
function displayImg(input,_this) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#cimg').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$('#submitBtn').click(function(e){
    e.preventDefault();
    var password = $('#password').val();
    var password_confirmation = $('#password_confirmation').val();
    if (password != password_confirmation) {
        alert('As senhas não coincidem!');
        return false;
    }
    var _this = $('#manage-user');
    start_loader()
    $.ajax({
        url:_base_url_+'classes/Users.php?f=save',
        data: new FormData(_this[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success:function(resp){
            if(resp ==1){
                location.reload()
            }else{
                $('#msg').html('<div class="alert alert-danger">Usuário já existe</div>')
                end_loader()
            }
        }
    })
})

</script>