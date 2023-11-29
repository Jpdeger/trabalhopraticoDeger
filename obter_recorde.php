<?php
session_start();
include("connectdb.php");
include("funcoes.php");

header('Content-Type: application/json');

if (isset($_SESSION['user_id'])) {
    $user_data = check_login($con);
    $user_id = $user_data['user_id'];

    // Busca o recorde do usuário nas colunas de pontuação
    $query = "SELECT MAX(pontuacao_facil) AS recorde_facil, MAX(pontuacao_medio) AS recorde_medio, MAX(pontuacao_dificil) AS recorde_dificil FROM users WHERE user_id = '$user_id'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $recorde = max($row['recorde_facil'], $row['recorde_medio'], $row['recorde_dificil']);
        echo json_encode(['recorde' => $recorde]);
    } else {
        echo json_encode(['error' => 'Erro ao obter recorde']);
    }
} else {
    echo json_encode(['error' => 'Usuário não autenticado']);
}
?>