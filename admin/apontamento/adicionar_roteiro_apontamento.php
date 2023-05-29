<?php
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT p.*
    FROM apontamento_roteiro p
    where p.id = '{$_GET['id']}'");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_array() as $k => $v) {
            $$k = $v;
        }
    }
}
?>

<style>


.visua{
width: 283px;
}

.dropZoneOverlay, .FileUpload {
            width: 283px;
            height: 108px;
            cursor: move;
        }

        .dropZoneOverlay {
            border: 3px dashed #000000;
            font-family: cursive;
            color: black;
            position: absolute;
            top: 0px;
            text-align: center;
            /* background: url('uploadcover.png') no-repeat;
background-size: 283px 100px; */
        }

        .FileUpload {
            opacity: 0;
            position: relative;
            z-index: 1;
        }

/* input[type='file'] {
    border: 3px dashed #999;
    padding: 100px 10px 10px 10px;
    cursor: move;
    position:relative;
}

input[type='file']:before {
    content: "Arraste e solte os arquivos aqui";
    display: block;
    position: absolute;
    text-align: center;
    top: 50%;
    left: 42%;
    width: 200px;
    height: 40px;
    margin: -25px 0 0 -100px;
    font-size: 18px;
    font-weight: bold;
    color: #999;
} */

body{
zoom: 90%;
}

.fade{
background-color: transparent;
}

</style>

<!-- INICIO PARTE ANEXO -->
<div class="card card-outline card-primary">
    
<div class="container">
<form action="anexo/upload_roteiro.php" method="post" enctype="multipart/form-data" id="form-up">

<?php
// PEGAR IMAGEM DO BANCO DE DADOS
$query = $conn->query("SELECT * FROM apontamento_roteiro WHERE id = $id");
if($query->num_rows > 0){
    while($row = $query->fetch_assoc()){
        // imagem - file_name
        $imageURL1 = 'http://192.168.0.5/sistema/admin/anexo/upload_roteiro/'.$row["setor_mec"];
        $imageURL2 = 'http://192.168.0.5/sistema/admin/anexo/upload_roteiro/'.$row["setor_ide"];
        $imageURL3 = 'http://192.168.0.5/sistema/admin/anexo/upload_roteiro/'.$row["setor_eletri"];
        $imageURL4 = 'http://192.168.0.5/sistema/admin/anexo/upload_roteiro/'.$row["setor_fin"];
        $imageURL5 = 'http://192.168.0.5/sistema/admin/anexo/upload_roteiro/'.$row["setor_exp"];
        $pdfURL1 = 'http://192.168.0.5/sistema/admin/anexo/upload_roteiro/'.$row["setor_eletro"];
?>
<!-- FIM CONFIG BANCO DE DADOS -->
<br><br>
<div class="text-center">
    <h4><?php echo 'Ordem de Produção ', $op_codigo ?></h4>
</div>
<br><br>
<div class="text-center form-group"><strong>ESCOLHER ARQUIVOS PARA VINCULAR A ORDEM DE PRODUÇÃO</strong><br>
(Para confirmar o envio, utilize o botão "<strong><i style="color: green;">ENVIAR ARQUIVOS</i></strong>")
</div>
<br>
<!-------------------------------------------------------------------->
<?php
$_SESSION['id_req_roteiro'] = $id;
$_SESSION['id_req_op'] = $op_codigo;
?>

<div class="row justify-content-around">
<!-------------------------------------------------- FILE 1 ------------------------------------------------------------->
<div class="mt-4 form-group col text-center dropZoneContainer" style="max-width: 283px; height:108px">
<input type="file" onchange="setfilename1(this.value);" class="FileUpload" name="file1" accept="image/jpeg,image/gif,image/png,application/pdf,image/application/pdf,application/vnd.ms-excel" id="file-upload1">
<div class="dropZoneOverlay"> <strong>Mecânica</strong> <br> Arraste ou clique para adicionar um arquivo <br>
<input id="uploadFile1" name="uploadFileOne" type="text" disabled="disabled" placeholder="Nenhum arquivo selecionado" class="name-info-form file-witdth" />
</div>
<?php if(empty($setor_mec)){
}
else{ ?>
<div class="visua">
<a href="<?php echo $imageURL1; ?>" target="_blank" rel="noopener noreferrer"><?php echo $setor_mec; ?></a><br>
</div>
<?php } ?>
</div>
<!-------------------------------------------- FIM ---------------------------------------------------->
<!-------------------------------------------------- FILE 2 ------------------------------------------------------------->
<div class="mt-4 form-group col text-center dropZoneContainer" style="max-width: 283px; height:108px">
<input type="file" onchange="setfilename2(this.value);" class="FileUpload" name="file2" accept="image/jpeg,image/gif,image/png,application/pdf,image/application/pdf,application/vnd.ms-excel" id="file-upload2">
<div class="dropZoneOverlay"><strong>Identificação</strong> <br> Arraste ou clique para adicionar um arquivo <br>
<input id="uploadFile2" name="uploadFileOne" type="text" disabled="disabled" placeholder="Nenhum arquivo selecionado" class="name-info-form file-witdth" />
</div>
<?php if(empty($setor_ide)){
}
else{ ?>
<div class="visua">
<a href="<?php echo $imageURL2; ?>" target="_blank" rel="noopener noreferrer"><?php echo $setor_ide; ?></a>
</div>
<?php } ?>
</div>
<!-------------------------------------------- FIM ---------------------------------------------------->
<!-------------------------------------------------- FILE 3 ------------------------------------------------------------->
<div class="mt-4 form-group col text-center dropZoneContainer" style="max-width: 283px; height:108px">
<input type="file" onchange="setfilename3(this.value);" class="FileUpload" name="file3" accept="image/jpeg,image/gif,image/png,application/pdf,image/application/pdf,application/vnd.ms-excel" id="file-upload3">
<div class="dropZoneOverlay"><strong>Elétrica</strong> <br> Arraste ou clique para adicionar um arquivo <br>
<input id="uploadFile3" name="uploadFileOne" type="text" disabled="disabled" placeholder="Nenhum arquivo selecionado" class="name-info-form file-witdth" />
</div>
<?php if(empty($setor_eletri)){
}
else{ ?>
<div class="visua">
<a href="<?php echo $imageURL3; ?>" target="_blank" rel="noopener noreferrer"><?php echo $setor_eletri; ?></a>
</div>
<?php } ?>
</div>
<!-------------------------------------------- FIM ---------------------------------------------------->
</div>
<div class="row justify-content-around">
<!-------------------------------------------------- FILE 4 ------------------------------------------------------------->
<div class="mt-4 form-group col text-center dropZoneContainer" style="max-width: 283px; height:108px">
<input type="file" onchange="setfilename4(this.value);" class="FileUpload" name="file4" accept="image/jpeg,image/gif,image/png,application/pdf,image/application/pdf,application/vnd.ms-excel" id="file-upload4">
<div class="dropZoneOverlay"><strong>Finalização</strong> <br> Arraste ou clique para adicionar um arquivo <br>
<input id="uploadFile4" name="uploadFileOne" type="text" disabled="disabled" placeholder="Nenhum arquivo selecionado" class="name-info-form file-witdth" />
</div>
<?php if(empty($setor_fin)){
}
else{ ?>
<div class="visua">
<a href="<?php echo $imageURL4; ?>" target="_blank" rel="noopener noreferrer"><?php echo $setor_fin; ?></a><br>
</div>
<?php } ?>
</div>
<!-------------------------------------------- FIM ---------------------------------------------------->
<!-------------------------------------------------- FILE 5 ------------------------------------------------------------->
<div class="mt-4 form-group col text-center dropZoneContainer" style="max-width: 283px; height:108px">
<input type="file" onchange="setfilename5(this.value);" class="FileUpload" name="file5" accept="image/jpeg,image/gif,image/png,application/pdf,image/application/pdf,application/vnd.ms-excel" id="file-upload5">
<div class="dropZoneOverlay"><strong>Expedição</strong> <br> Arraste ou clique para adicionar um arquivo <br>
<input id="uploadFile5" name="uploadFileOne" type="text" disabled="disabled" placeholder="Nenhum arquivo selecionado" class="name-info-form file-witdth" />
</div>
<?php if(empty($setor_exp)){
}
else{ ?>
<div class="visua">
<a href="<?php echo $imageURL5; ?>" target="_blank" rel="noopener noreferrer"><?php echo $setor_exp; ?></a><br>
</div>
<?php } ?>
</div>
<!-------------------------------------------- FIM ---------------------------------------------------->
<!-------------------------------------------------- FILE 6 ------------------------------------------------------------->
<div class="mt-4 form-group col text-center dropZoneContainer" style="max-width: 283px; height:108px">
<input type="file" onchange="setfilename6(this.value);" class="FileUpload" name="file6" accept="image/jpeg,image/gif,image/png,application/pdf,image/application/pdf,application/vnd.ms-excel" id="file-upload6">
<div class="dropZoneOverlay"><strong>Eletrônica</strong> <br> Arraste ou clique para adicionar um arquivo <br>
<input id="uploadFile6" name="uploadFileOne" type="text" disabled="disabled" placeholder="Nenhum arquivo selecionado" class="name-info-form file-witdth" />
</div>
<?php if(empty($setor_eletro)){
}
else{ ?>
<div class="visua">
<a href="<?php echo $pdfURL1; ?>" target="_blank" rel="noopener noreferrer"><?php echo $setor_eletro; ?></a><br>
</div>
<?php } ?>
</div>
<!-------------------------------------------- FIM ---------------------------------------------------->
</div> <!-- fim row -->
<br><br>

<div class="row justify-content-around">

<div class="col-md-3">
<a onclick="window.location='<?php echo base_url ?>admin/?page=apontamento/gerencia_apontamento'" style="width:100%;" class="btn btn-outline-primary">
<strong> Voltar </strong></a>
</div>

<div class="col-md-3">
<button id="create_roteiro" href="javascript:void(0)" type="submit" name="submit" value="Upload" form="form-up" class="btn btn-outline-success" style="width:100%;">
<strong> Enviar Arquivos </strong></button>
</div>
</div>
<br>
<!-------------------------------------------------------------------->

<?php }
}else{ ?>

<?php } ?>

<!------------------------------------------------------------------------------------------------------>

</form> <!-- form -->
</div>
</div>
<script>

// pegar nome do arquivo selecionado na hora do upload

function setfilename1(val)
{ var fileName = val.substr(val.lastIndexOf("\\")+1, val.length);
document.getElementById("uploadFile1").value = fileName; };

function setfilename2(val)
{ var fileName = val.substr(val.lastIndexOf("\\")+1, val.length);
document.getElementById("uploadFile2").value = fileName; };

function setfilename3(val)
{ var fileName = val.substr(val.lastIndexOf("\\")+1, val.length);
document.getElementById("uploadFile3").value = fileName; };

function setfilename4(val)
{ var fileName = val.substr(val.lastIndexOf("\\")+1, val.length);
document.getElementById("uploadFile4").value = fileName; };

function setfilename5(val)
{ var fileName = val.substr(val.lastIndexOf("\\")+1, val.length);
document.getElementById("uploadFile5").value = fileName; };

function setfilename6(val)
{ var fileName = val.substr(val.lastIndexOf("\\")+1, val.length);
document.getElementById("uploadFile6").value = fileName; };


/* $(document).ready(function(){
    $("body").addClass("sidebar-collapse");
}); */

$('#create_roteiro').click(function() {
uni_modal("<i class='fa fa-plus'></i> Adicionar novo material", "maintenance/manage_item.php", "mid-large")
});


$(function() {  
  $('#file-upload1').change(function() {
  var i = $(this).prev('label').clone();
  var file = $('#file-upload1')[0].files[0].name;
  $(this).prev('label').text(file);
});

$('#file-upload2').change(function() {
  var i = $(this).prev('label').clone();
  var file = $('#file-upload2')[0].files[0].name;
  $(this).prev('label').text(file);
});

$('#file-upload3').change(function() {
  var i = $(this).prev('label').clone();
  var file = $('#file-upload3')[0].files[0].name;
  $(this).prev('label').text(file);
});

$('#file-upload4').change(function() {
  var i = $(this).prev('label').clone();
  var file = $('#file-upload4')[0].files[0].name;
  $(this).prev('label').text(file);
});

$('#file-upload5').change(function() {
  var i = $(this).prev('label').clone();
  var file = $('#file-upload5')[0].files[0].name;
  $(this).prev('label').text(file);
});

$('#file-upload6').change(function() {
  var i = $(this).prev('label').clone();
  var file = $('#file-upload6')[0].files[0].name;
  $(this).prev('label').text(file);
});

$('#roteiro-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this)
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_roteiro",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err)
                    alert_toast("Ocorreu um erro", 'error');
                    end_loader();
                },
                success: function(resp) {
                    e.preventDefault();
                    if (resp.status == 'success') {
                        /* location.replace(_base_url_ + "admin/?page=apontamento"); */
                        location.replace(_base_url_ + "admin/?page=apontamento/gerencia_apontamento");
                    } else if (resp.status == 'failed' && !!resp.msg) {
                        var el = $('<div>')
                        el.addClass("alert alert-danger err-msg").text(resp.msg)
                        _this.prepend(el)
                        el.show('slow')
                        end_loader()
                    } else {
                        alert_toast("Ocorreu um erro", 'error');
                        end_loader();
                        console.log(resp)
                    }
                    $('html,body').animate({
                        scrollTop: 0
                    }, 'fast')
                }
            })
        })
    })

</script>