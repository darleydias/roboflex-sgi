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
$statusMsg4 = '';
$statusMsg5 = '';
$statusMsg6 = '';

// Caminho do arquivo para salvar
$targetDir = "upload_roteiro/";

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

//setor_fin
$fileName4 = $_SESSION['id_req_op'].'fin.pdf';
$targetFilePath4 = $targetDir . $fileName4;
$fileType4 = pathinfo($targetFilePath4,PATHINFO_EXTENSION);

//setor_exp
$fileName5 = $_SESSION['id_req_op'].'exp.pdf';
$targetFilePath5 = $targetDir . $fileName5;
$fileType5 = pathinfo($targetFilePath5,PATHINFO_EXTENSION);

//setor_eletro
$fileName6 = $_SESSION['id_req_op'].'ele.pdf';
$targetFilePath6 = $targetDir . $fileName6;
$fileType6 = pathinfo($targetFilePath6,PATHINFO_EXTENSION);


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

// IMAGEM 4
if(isset($_POST["submit"]) && !empty($_FILES["file4"]["name"])){

    // Tipos permitidos
    $allowTypes4 = array('jpg','png','jpeg','gif','pdf','PDF');
    if(in_array($fileType4, $allowTypes4)){

        // Upload para o servidor
        if(move_uploaded_file($_FILES["file4"]["tmp_name"], $targetFilePath4)){
            $insert4 = $db->query('UPDATE apontamento_roteiro SET setor_fin = ("'.$fileName4.'") where id = "' . $_SESSION['id_req_roteiro'] . '"');

            if($insert4){
                $statusMsg4 = "O arquivo <strong>".$fileName4. "</strong> foi enviado com sucesso.<br>";
            }
            else{
                $statusMsg4 = "Houve um erro ao realizar o upload do arquivo <strong>".$fileName4. "</strong>, tente novamente.<br>"; 
            }
        }else{
            $statusMsg4 = "Desculpe, houve um erro ao enviar o arquivo <strong>".$fileName4. "</strong>.<br>";
        }
    }else{
        $statusMsg4 = "Desculpe, o arquivo <strong>".$fileName4. "</strong> está com o formato inválido, apenas arquivos JPG, JPEG, PNG, GIF e PDF podem ser carregados.<br>";
    }
}else{
    /* $statusMsg4 = ' 4 Escolha um arquivo para realizar o upload.<br>'; */
}

// IMAGEM 5
if(isset($_POST["submit"]) && !empty($_FILES["file5"]["name"])){

    // Tipos permitidos
    $allowTypes5 = array('jpg','png','jpeg','gif','pdf','PDF');
    if(in_array($fileType5, $allowTypes5)){

        // Upload para o servidor
        if(move_uploaded_file($_FILES["file5"]["tmp_name"], $targetFilePath5)){
            $insert5 = $db->query('UPDATE apontamento_roteiro SET setor_exp = ("'.$fileName5.'") where id = "' . $_SESSION['id_req_roteiro'] . '"');

            if($insert5){
                $statusMsg5 = "O arquivo <strong>".$fileName5. "</strong> foi enviado com sucesso.<br>";
            }
            else{
                $statusMsg5 = "Houve um erro ao realizar o upload do arquivo <strong>".$fileName5. "</strong>, tente novamente.<br>"; 
            }
        }else{
            $statusMsg5 = "Desculpe, houve um erro ao enviar o arquivo <strong>".$fileName5. "</strong>.<br>";
        }
    }else{
        $statusMsg5 = "Desculpe, o arquivo <strong>".$fileName5. "</strong> está com o formato inválido, apenas arquivos JPG, JPEG, PNG, GIF e PDF podem ser carregados.<br>";
    }
}else{
    /* $statusMsg5 = ' 5 Escolha um arquivo para realizar o upload.<br>'; */
}

// IMAGEM 6
if(isset($_POST["submit"]) && !empty($_FILES["file6"]["name"])){

    // Tipos permitidos
    $allowTypes6 = array('jpg','png','jpeg','gif','pdf','PDF');
    if(in_array($fileType6, $allowTypes6)){

        // Upload para o servidor
        if(move_uploaded_file($_FILES["file6"]["tmp_name"], $targetFilePath6)){
            $insert6 = $db->query('UPDATE apontamento_roteiro SET setor_eletro = ("'.$fileName6.'") where id = "' . $_SESSION['id_req_roteiro'] . '"');

            if($insert6){
                $statusMsg6 = "O arquivo <strong>".$fileName6. "</strong> foi enviado com sucesso.<br>";
            }
            else{
                $statusMsg6 = "Houve um erro ao realizar o upload do arquivo <strong>".$fileName6. "</strong>, tente novamente.<br>"; 
            }
        }else{
            $statusMsg6 = "Desculpe, houve um erro ao enviar o arquivo <strong>".$fileName6. "</strong>.<br>";
        }
    }else{
        $statusMsg6 = "Desculpe, o arquivo <strong>".$fileName6. "</strong> está com o formato inválido, apenas arquivos JPG, JPEG, PNG, GIF e PDF podem ser carregados.<br>";
    }
}else{
    /* $statusMsg6 = ' 6 Escolha um arquivo para realizar o upload.<br>'; */
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
echo $statusMsg4;
echo $statusMsg5;
echo $statusMsg6;
?>

</div>
</div>
</div>