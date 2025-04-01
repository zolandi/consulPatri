<?php
if (isset($_POST['submit'])) {
    include_once('config.php');

    if (isset($_FILES['img'])) {
        $error = $_FILES['img']['error'];
        if ($error == UPLOAD_ERR_OK) {
            $img = $_FILES['img']['name'];
            $uploadDir = 'uploads/';
            
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); 
            }

            $uploadFile = $uploadDir . basename($img);
            $ext = pathinfo($img, PATHINFO_EXTENSION);
            $extPermitidas = array('jpg', 'jpeg', 'png', 'gif'); 

            if (!in_array(strtolower($ext), $extPermitidas)) {
                echo "<script>alert('Tipo de arquivo não permitido!'); window.location.href='form.php';</script>";
                exit;
            }

            if (!move_uploaded_file($_FILES['img']['tmp_name'], $uploadFile)) {
                echo "<script>alert('Erro ao fazer upload da imagem!'); window.location.href='form.php';</script>";
                exit;
            }
        } else {
            switch ($error) {
                case UPLOAD_ERR_INI_SIZE:
                    echo "<script>alert('Arquivo muito grande!'); window.location.href='form.php';</script>";
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    echo "<script>alert('O arquivo ultrapassa o limite especificado no formulário!'); window.location.href='form.php';</script>";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    echo "<script>alert('O upload do arquivo foi feito parcialmente!'); window.location.href='form.php';</script>";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    echo "<script>alert('Nenhum arquivo foi enviado!'); window.location.href='form.php';</script>";
                    break;
                default:
                    echo "<script>alert('Erro desconhecido no upload!'); window.location.href='form.php';</script>";
            }
            exit;
        }
    } else {
        $img = ''; 
    }

    $numero = mysqli_real_escape_string($conexao, $_POST['numero']);
    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
    $valor = mysqli_real_escape_string($conexao, $_POST['valor']);
    $responsavel = mysqli_real_escape_string($conexao, $_POST['responsavel']);
    $locest = mysqli_real_escape_string($conexao, $_POST['locest']);
    $dataaquisicao = mysqli_real_escape_string($conexao, $_POST['dataaquisicao']);
    $deprec = mysqli_real_escape_string($conexao, $_POST['deprec']);
    $conserv = mysqli_real_escape_string($conexao, $_POST['conserv']);
    $obs = mysqli_real_escape_string($conexao, $_POST['obs']);

    $query = "INSERT INTO Decl (img, numero, descricao, valor, responsavel, locest, dataaquisicao, deprec, conserv, obs)
              VALUES ('$img', '$numero', '$descricao', '$valor', '$responsavel', '$locest', '$dataaquisicao', '$deprec', '$conserv', '$obs')";

    if (mysqli_query($conexao, $query)) {
        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='form.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar!'); window.location.href='form.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<script src="form.js"></script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patrimônio</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <link rel="stylesheet" href="form.css">

</head>

<body>

<header>
    
<h1>Patrimônio</h1>
<a href="consulta.php">Consultar envios</a>
</header>


<form id="formu" action="form.php" method="POST" enctype="multipart/form-data" >
    <label for="img">Inserir Imagem:</label><br>
    <input type="file" id="img" name="img"  onchange="displayFileName(event)"><br><br>
    <span id="file-name" style="margin-left: 10px; font-size: 1rem;"></span><br><br>

    <!-- <div id="previewContainer" style="display: none; flex-direction: column; align-items: center;">
    <img id="imagePreview" src="" alt="Imagem prévia" style="max-width: 200px; max-height: 200px;"/>
    <p id="img"></p> -->

    <button id="imageDelete" style="display: none;" onclick="deleteImg(event)" class="delete-btn">Remover imagem</button>
    </div>

    <label for="numero">Número do Patrimônio:</label><br>
    <input placeholder="Digite o número do patrimônio" type="text" id="numero" name="numero" required><br><br>

    <label for="descricao">Descrição do Bem:</label><br>
    <input placeholder="Digite a descrição" type="text" id="descricao" name="descricao" required><br><br>

    <label for="valor">Valor do Bem:</label><br>
    <input placeholder="Digite o valor do bem" type="text" id="valor" name="valor" required><br><br>

    <label for="responsavel">Responsável:</label><br>
    <input placeholder="Digite o responável" type="text" id="responsavel" name="responsavel" required><br><br>

    <label for="locest">Localização:</label><br>
    <input placeholder="Digite a localização" type="text" id="locest" name="locest" required><br><br> 

    <label for="dataaquisicao">Data de Aquisição:</label><br>
    <input placeholder="dd/MM/yyyy" type="date" id="dataaquisicao" name="dataaquisicao" maxlength="10" pattern="\d{2}/\d{2}/\d{4}" title="Digite a data no formato dd/MM/yyyy" required><br><br>

    <div>
        <label for="conserv">Estado de conservação:</label><br>
        <input type="checkbox" id="conserv" name="conserv" value="Novo" onclick="selectOnlyThis(this)" />   Novo<br><br>
        <input type="checkbox" id="conserv" name="conserv" value="Bom" onclick="selectOnlyThis(this)" />   Bom <br><br>
        <input type="checkbox" id="conserv" name="conserv" value="Usado" onclick="selectOnlyThis(this)" />   Usado<br><br>
        <input type="checkbox" id="conserv" name="conserv" value="Danificado" onclick="selectOnlyThis(this)" />   Danificado<br><br>
    <div>

    <label for="deprec">Estado de depreciação:</label><br>
    <input placeholder="Digite o estado de depreciação" type="text" id="deprec" name="deprec"><br><br>

    <label for="obs">Observações:</label><br>
    <input placeholder="Digite as observações" type="text" id="obs" name="obs"><br><br>
    
    <button class="xml" type="button" onclick="exportarXML()">Exportar para XML</button>
    <button class="xls" type="button" onclick="exportarXLSX()">Exportar para XLSX</button>

    <input type="submit" name="submit" id="submit" value="enviar">

</form>
    
</body>
</html>