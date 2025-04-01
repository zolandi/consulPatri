<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Patrimônio</title>
    <style>
       /* Reset para remover margens e paddings padrão */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    color: #333;
    padding: 10px;
    text-align: center; /* Centraliza o conteúdo */
    height: 100vh; /* Garante que a altura ocupe 100% da tela */
    display: block; /* Remove o flexbox */
    margin: 0; /* Remove margens padrão */
    display: grid;
    place-items: center; /* Centraliza o conteúdo no grid */
}

/* Container principal */
.container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 600px;  /* Limita a largura do formulário */
    text-align: left; /* Alinha o conteúdo à esquerda */
}

/* Título principal */
h1 {
    font-size: 1.6rem;
    margin-bottom: 20px;
    color: #333;
}

/* Estilo do formulário */
form {
    display: flex;
    flex-direction: column; /* Formulário com disposição vertical */
    margin-bottom: 20px;
}

/* Labels */
label {
    font-size: 1rem;
    color: #555;
    margin-bottom: 8px;
    text-align: left;
}

/* Campos de entrada */
input[type="text"] {
    width: 100%;
    padding: 12px;
    font-size: 1rem;
    margin-bottom: 20px; /* Maior margem entre os campos */
    border-radius: 4px;
    border: 1px solid #ddd;
    color: #333;
    outline: none;
}

/* Estilo para o botão */
input[type="submit"] {
    width: 100%;
    padding: 12px;
    font-size: 1.1rem;
    background-color: #5cb85c;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

/* Hover do botão */
input[type="submit"]:hover {
    background-color: #4cae4c;
}

/* Estilo para informações do patrimônio */
.patrimonio-info {
    display: flex;
    flex-direction: column;
    margin-top: 20px;
}

.patrimonio-info p {
    font-size: 1rem;
    color: #555;
    margin-bottom: 12px;
}

.patrimonio-info img {
    max-width: 100%;
    border-radius: 4px;
    margin-top: 12px;
}

/* Responsividade para dispositivos móveis */
@media (max-width: 600px) {
    h1 {
        font-size: 1.4rem;
    }

    input[type="text"], input[type="submit"] {
        font-size: 1rem;
    }

    .container {
        padding: 15px;
        max-width: 90%;
    }
}

    </style>
</head>
<body>

    <div class="container">
        <h1>Consulta de Patrimônio</h1>
        <form action="consulta.php" method="POST">
            <label for="numero">Número do Patrimônio:</label>
            <input type="text" id="numero" name="numero" required placeholder="Digite o número do patrimônio">
            <input type="submit" value="Consultar">
        </form>
    </div>

</body>
</html>

<?php
// Conectar ao banco de dados
include_once('config.php');

// Verificar se o número foi enviado
if (isset($_POST['numero'])) {
    // Sanitizar a entrada para evitar SQL Injection
    $numero = mysqli_real_escape_string($conexao, $_POST['numero']);

    // Consultar o banco de dados para pegar as informações do patrimônio
    $query = "SELECT * FROM Decl WHERE numero = '$numero'";
    $result = mysqli_query($conexao, $query);

    // Verificar se o patrimônio foi encontrado
    if (mysqli_num_rows($result) > 0) {
        // Exibir as informações do patrimônio
        $patrimonio = mysqli_fetch_assoc($result);
        echo "<h2>Informações do Patrimônio</h2>";
        echo "<p><strong>Número do Patrimônio:</strong> " . $patrimonio['numero'] . "</p>";
        echo "<p><strong>Descrição:</strong> " . $patrimonio['descricao'] . "</p>";
        echo "<p><strong>Valor:</strong> " . $patrimonio['valor'] . "</p>";
        echo "<p><strong>Responsável:</strong> " . $patrimonio['responsavel'] . "</p>";
        echo "<p><strong>Localização:</strong> " . $patrimonio['locest'] . "</p>";
        echo "<p><strong>Data de Aquisição:</strong> " . $patrimonio['dataaquisicao'] . "</p>";
        echo "<p><strong>Estado de Conservação:</strong> " . $patrimonio['conserv'] . "</p>";
        echo "<p><strong>Estado de Depreciação:</strong> " . $patrimonio['deprec'] . "</p>";
        echo "<p><strong>Observações:</strong> " . $patrimonio['obs'] . "</p>";
        echo "<p><strong>Imagem:</strong> <img src='uploads/" . $patrimonio['img'] . "' alt='Imagem do Patrimônio' style='max-width: 200px;'></p>";
    } else {
        echo "<p>Patrimônio não encontrado com esse número.</p>";
    }
}

// Fechar a conexão com o banco de dados
mysqli_close($conexao);
?>
