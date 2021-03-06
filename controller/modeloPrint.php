<?php
error_reporting(E_ALL);
ini_set('display_errors', 'off');

$cont_lin=0;
session_start();
if (empty($_SESSION['valid_user'])) {
	exit;
}
require_once ("../func_class/funcoes.php");
require_once ("../func_class/classes.php");
date_default_timezone_set('America/Recife');
function __autoload ($classe) {

	list($dir,$nomeClasse) = explode('_', $classe);
	//$dir = strtr( $classe, '_','/' );
	if (file_exists("../models/$dir/$classe.class.php")){
		require_once ("../models/$dir/$classe.class.php");
	}elseif (file_exists("../models/$classe.class.php")){
		require_once ("../models/$classe.class.php");
	}
}
$idIgreja = (empty($_GET['igreja'])) ? '':$_GET['igreja'];
if (intval($_POST['rolIgreja']>0)) {
	$idIgreja=$_POST['rolIgreja'];
}
$igrejaSelecionada = new DBRecord('igreja', $idIgreja, 'rol');
$igSede = new DBRecord('igreja', '1', 'rol');
$tipo = $_GET['tipo'];
switch ($tipo) {
	case '1':
	controle('tes');
	$dizmista = new dizresp($_SESSION['valid_user'],true/*impressao*/);
	$tituloColuna5 = ($idIgreja>'1') ? 'Congrega&ccedil;o':'Igreja';
	$titTabela = 'Hist&oacute;rico Lan&ccedil;amentos - '.NOMESYS;
	$nomeArquivo = '../views/tesouraria/tabDizimosOfertas.php';
	break;
	case '2':
	$tituloColuna5 = ($idIgreja>'1') ? 'Congrega&ccedil;o':'Igreja';
	$titTabela = 'Agenda de Eventos - '.NOMESYS;
	require_once '../agendaSec/lang/lang.admin.pt.php';
	require_once '../agendaSec/lang/lang.pt.php';
	$nomeArquivo = '../views/secretaria/agendaPrint.php';
	break;
	case '3':
		# Novos convertidos
		$titTabela = 'Lista de Dirigentes';
		$nomeArquivo = '../views/secretaria/dirigentes.php';
	break;
	default:
		;
	break;
}

require_once '../views/modeloPrint.php';
