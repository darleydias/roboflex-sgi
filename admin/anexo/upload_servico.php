<?php
session_start();
require_once('../../initialize.php');
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

<?php
// Incluir banco de dados
include 'dbConfig.php';
$statusMsg1 = '';
$statusMsg2 = '';
$statusMsg3 = '';

// Caminho do arquivo para salvar
$targetDir = "upload_servico/";

//setor_mec
$fileName1 = $_SESSION['id_req_op'].'mec.pdf';
$targetFilePath1 = $targetDir . $fileName1;
$fileType1 = pathinfo($targetFilePath1,PATHINFO_EXTENSION);

//setor_ide
$fileName2 = $_SESSION['id_req_op'].'ide.pdf';
$targetFilePath2 = $targetDir . $fileName2;
$fileType2 = pathinfo($targetFilePath2,PATHINFO_EXTENSION);

//setor_eletri
$fileName3 = $_SESSION['id_req_op'].'elé.pdf';
$targetFilePath3 = $targetDir . $fileName3;
$fileType3 = pathinfo($targetFilePath3,PATHINFO_EXTENSION);


// IMAGEM 1
if(isset($_POST["submit"]) && !empty($_FILES["file1"]["name"])){

    // Tipos permitidos
    $allowTypes1 = array('jpg','png','jpeg','gif','pdf','PDF');
    if(in_array($fileType1, $allowTypes1)){

        // Upload para o servidor
        if(move_uploaded_file($_FILES["file1"]["tmp_name"], $targetFilePath1)){
            $insert1 = $db->query('UPDATE apontamento_roteiro SET setor_mec = ("'.$fileName1.'") where id = "' . $_SESSION['id_req_roteiro'] . '"');
            if($insert1){
                $statusMsg1 = "O arquivo <strong>".$fileName1. "</strong> foi enviado com sucesso.<br>";
            }
            else{
                $statusMsg1 = "Houve um erro ao realizar o upload do arquivo <strong>".$fileName1. "</strong>, tente novamente.<br>"; 
            }
        }else{
            $statusMsg1 = "Desculpe, houve um erro ao enviar o arquivo <strong>".$fileName1. "</strong>.<br>";
        }
    }else{
        $statusMsg1 = "Desculpe, o arquivo <strong>".$fileName1. "</strong> está com o formato inválido, apenas arquivos JPG, JPEG, PNG, GIF e PDF podem ser carregados.<br>";
    }
}else{
    /* $statusMsg1 = ' 1 Escolha um arquivo para realizar o upload.<br>'; */
}


// IMAGEM 2
if(isset($_POST["submit"]) && !empty($_FILES["file2"]["name"])){

    // Tipos permitidos
    $allowTypes2 = array('jpg','png','jpeg','gif','pdf','PDF');
    if(in_array($fileType2, $allowTypes2)){

        // Upload para o servidor
        if(move_uploaded_file($_FILES["file2"]["tmp_name"], $targetFilePath2)){
            $insert2 = $db->query('UPDATE apontamento_roteiro SET setor_ide = ("'.$fileName2.'") where id = "' . $_SESSION['id_req_roteiro'] . '"');
            if($insert2){
                $statusMsg2 = "O arquivo <strong>".$fileName2. "</strong> foi enviado com sucesso.<br>";
            }
            else{
                $statusMsg2 = "Houve um erro ao realizar o upload do arquivo <strong>".$fileName2. "</strong>, tente novamente.<br>"; 
            }
        }else{
            $statusMsg2 = "Desculpe, houve um erro ao enviar o arquivo <strong>".$fileName2. "</strong>.<br>";
        }
    }else{
        $statusMsg2 = "Desculpe, o arquivo <strong>".$fileName2. "</strong> está com o formato inválido, apenas arquivos JPG, JPEG, PNG, GIF e PDF podem ser carregados.<br>";
    }
}else{
    /* $statusMsg2 = ' 1 Escolha um arquivo para realizar o upload.<br>'; */
}


// IMAGEM 3
if(isset($_POST["submit"]) && !empty($_FILES["file3"]["name"])){

    // Tipos permitidos
    $allowTypes3 = array('jpg','png','jpeg','gif','pdf','PDF');
    if(in_array($fileType3, $allowTypes3)){

        // Upload para o servidor
        if(move_uploaded_file($_FILES["file3"]["tmp_name"], $targetFilePath3)){
            $insert3 = $db->query('UPDATE apontamento_roteiro SET setor_eletri = ("'.$fileName3.'") where id = "' . $_SESSION['id_req_roteiro'] . '"');

            if($insert3){
                $statusMsg3 = "O arquivo <strong>".$fileName3. "</strong> foi enviado com sucesso.<br>";
            }
            else{
                $statusMsg3 = "Houve um erro ao realizar o upload do arquivo <strong>".$fileName3. "</strong>, tente novamente.<br>"; 
            }
        }else{
            $statusMsg3 = "Desculpe, houve um erro ao enviar o arquivo <strong>".$fileName3. "</strong>.<br>";
        }
    }else{
        $statusMsg3 = "Desculpe, o arquivo <strong>".$fileName3. "</strong> está com o formato inválido, apenas arquivos JPG, JPEG, PNG, GIF e PDF podem ser carregados.<br>";
    }
}else{
    /* $statusMsg3 = ' 3 Escolha um arquivo para realizar o upload.<br>'; */
}


?>
<div class="card">
<div class="card-body">
<div class="text-center">
<a class="btn btn-outline-primary" href="<?php echo base_url . 'admin?page=apontamento/adicionar_roteiro_apontamento&id=' . $_SESSION['id_req_roteiro'] ?>">VOLTAR PARA A PÁGINA ANTERIOR</a>

<br><br>

<?php
// Mostrar mensagem
echo $statusMsg1;
echo $statusMsg2;
echo $statusMsg3;

?>

</div>
</div>
</div>