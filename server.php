<?php
// Recuperação da informação enviada pelo formulário
$nomeCidade = $_POST["nomeCidade"];
$estado = $_POST["estado"];
$action = $_POST["action"];

$response = array();

$connectionString = new mysqli("127.0.0.1:3306", "root", "", "cidadesbrasil");

if ($action == "CADASTRAR") $sql = "insert into cidades (nomeCidade, estado) values ('$nomeCidade','$estado')";
if ($action == "CONSULTAR") $sql = "select * from cidades where nomeCidade like '$nomeCidade%'";
if ($action == "ATUALIZAR") $sql = "update cidades set estado='$estado', nomeCidade='$nomeCidade' where nomeCidade ='$nomeCidade' or estado='$estado'";
if ($action == "DELETAR") $sql = "delete from cidades where nomeCidade ='$nomeCidade' and estado='$estado'";


// CADASTRAR
if ($action == "CADASTRAR") {
	$query = "select * from cidades where nomeCidade like '$nomeCidade%'";
	$executeQuery = $connectionString->query($query);
	$cont = mysqli_num_rows($executeQuery);
	if ($cont > 0) {
		$response[] = array("response" => "Cidade já cadastrada.");
	} else {
		$executeQuery = $connectionString->query($sql);
		if ($executeQuery) {
			$response[] = array("response" => "Cidade cadastrada com sucesso!");
		} else {
			$response[] = array("response" => "Erro! Não foi possível cadastrar a cidade, tente novamente!");
		}
	}
}

// CONSULTAR
if ($action == "CONSULTAR") {


	$executeQuery = $connectionString->query($sql);
	$cont = mysqli_num_rows($executeQuery); // conta número de registros retornados pela consulta
	if ($cont > 0) {
		while ($campo = $executeQuery->fetch_assoc()) { // separa informaçõs do registro em campos
			$response[] = array("response" => $campo["idCidade"] . ";" . $campo["nomeCidade"] . ";" . $campo["estado"]);
			break; // sai do laço (só interessa primeiro registo obtido pelo like)
		}
	} else // não econtrado
		$response[] = array("response" => "Nao encontrado!");
}

// ATUALIZAR
if ($action == "ATUALIZAR") {
	$executeQuery = $connectionString->query($sql);
	if ($executeQuery) {
		$response[] = array("response" => "Alterado com sucesso!");
	} else
		$response[] = array("response" => "Não foi possível atualizar, tente novamente!");
}

// DELETAR	
if ($action == "DELETAR") {
	$executeQuery = $connectionString->query($sql); // executa sql de exclusão
	if ($connectionString->affected_rows > 0) { // verifica quantas linhas foram afetadas pela execução da exclusao
		$response[] = array("response" => "Removido com sucesso!"); //>0, então existe e foi excluído
	} else //<=0, não exite ou erro na exclusão
		$response[] = array("response" => "Não foi possível remover, tente novamente!");
}
// codifica vetor para padrão json e devolve para ajax no javascript
echo json_encode($response);
$connectionString->close();
