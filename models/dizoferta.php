<?PHP

require_once 'views/tesouraria/dizoferta.php';

$dta = explode("/",$_POST["data"]);
		$d=$dta[0];
		$m=$dta[1];
		$y=$dta[2];
		$res = checkdate($m,$d,$y);

$datalanc = sprintf("%s-%s-%s",$y,$m,$d);
$rolIgreja = (empty($_POST['rolIgreja'])) ? false:(int)$_POST['rolIgreja'];
$ultregistro = mysql_query ('SELECT data FROM dizimooferta WHERE lancamento="0" AND igreja="'.$rolIgreja.'" ORDER BY id DESC LIMIT 1');
$vlrregistro = mysql_fetch_row($ultregistro);

?>
	<table>
		<tbody>
			<tr>
				<td><?php echo '<H1>Data do �ltimo registo: '.$vlrregistro[0].'</h1>';?></td>
				<td rowspan="2">
						<?PHP
							//Exibe a foto do contribuinte
								if ($_POST["rol"]>'0') {
									print mostra_foto($_POST["rol"]);
								}
							?>
				</td>
			</tr>
			<tr>
				<td>
				<?php echo '<H1>Data do lan�amento: '.$datalanc.'</h1>';?>
				</td>
			</tr>
		</tbody>
	</table>
<?php


//$msgErro  = "<script>location.href='./?escolha=tesouraria/receita.php&menu=top_tesouraria&rec={$_POST["tipo"]}&igreja={$rolIgreja}'; </script>";
$msgErro = "<a href='./?escolha=tesouraria/receita.php&menu=top_tesouraria&rec={$_POST["tipo"]}&
		igreja={$rolIgreja}'><button class='btn btn-primary' tabindex='1' >Continuar...</button><a>";

if (($vlr && ($vlrregistro[0] == $datalanc || $_POST['tipo']=='4')) || ($vlr && $vlrregistro[0] =='') && $rolIgreja ) {
	//Verifica se o caixa do ultimo culto foi encerrado e se h� algum valor em dizimo, oferta ou oferta extra

	$sem = semana($_POST["data"]);

	$hist = $_SESSION['valid_user'].": ".$_SESSION['nome'];
	switch ($_POST['tipo']) {
		case '1':
			//Dizimos, ofertas, miss�es, ora��es
			require_once 'help/tes/tipo1DizOferta.php'; //Aplica formata��es e atualiza o banco
			$linkreturn  = "./?escolha=tesouraria/receita.php&menu=top_tesouraria&rec={$_POST["tipo"]}&igreja={$_POST["rolIgreja"]}";
		break;
		case '2':
			require_once 'help/tes/tipo2DizOferta.php';
			$linkreturn  = "./?escolha=tesouraria/receita.php&menu=top_tesouraria&igreja={$_POST["rolIgreja"]}";
		break;
		case '3':
			require_once 'help/tes/tipo3DizOferta.php';
			$linkreturn  = "./?escolha=tesouraria/receita.php&menu=top_tesouraria&rec=0&igreja={$_POST["rolIgreja"]}";
		break;
		case '4':
			//EBD
			require_once 'help/tes/tipo4DizOferta.php';
			$linkreturn  = "./?escolha=tesouraria/receita.php&menu=top_tesouraria&rec=3&igreja={$_POST["rolIgreja"]}";
		break;
		default:
			echo 'N�o foi definidade o tipo do grupo de lan�amento!';
			$linkreturn  = "./?escolha=tesouraria/receita.php&menu=top_tesouraria&igreja={$_POST["rolIgreja"]}";
		break;
	}
	echo $mostraLanc;
	//echo "<h1>".mysql_insert_id()."</h>";//recupera o id do �ltimo insert no mysql
		$linr = "./?escolha={$_POST['escolha']}&menu={$_POST['menu']}&";
		$linr .= "rec={$_POST['rec']}&igreja={$_POST["rolIgreja"]}&";
		$linr .= "data={$_POST['data']}&mes={$_POST['mes']}&ano={$_POST['ano']}";
		$linkreturn .= "&data=".$_POST["data"]."&mes=$m&ano=$y";
		$linkreturn .= "&acescamp=".$_POST["acescamp"];
		//echo '<meta http-equiv="refresh" content="2; '.$linkreturn.'">';
		//echo "<script>location.href='$linkreturn';</script>";
		echo "<a href='$linkreturn' ><button class='btn btn-primary' tabindex='1'>Continuar...</button><a>";
		require 'forms/concluirdiz.php';//Formul�rio para fecha o caixa
}elseif (!$rolIgreja) {//Se n�o foneceu o n�mero da igreja
	echo "<script>alert('Voc� n�o informou a Igreja! Fa�a agora para continuar...');</script>";
	$msgErro .= '<div class="alert alert-error">Voc&ecirc; n&atilde;o informou a Igreja!';
	$msgErro .= ' <u>O lan&ccedil;mento <b>N&Atilde;O</b> foi confirmado!</u></div>';
	echo $msgErro;
}elseif ($vlrregistro[0] <> $datalanc && $vlrregistro[0]<>'') {
	echo "<script>alert('Voc� n�o encerrou o caixa do �ltimo culto! Fa�a agora para continuar...');</script>";
	$msgErro .= '<div class="alert alert-error">Voc&ecirc; n&atilde;o encerrou o caixa do &uacute;ltimo culto!';
	$msgErro .= ' <u>O lan&ccedil;mento <b>N&Atilde;O</b> foi confirmado!</u></div>';
	echo $msgErro;
} else {
	echo "<script>alert('Valor n�o Informado!');</script>";
	$msgErro .= '<div class="alert alert-error">Voc&ecirc; n&atilde;o informou o valor!';
	$msgErro .= ' <u>O lan&ccedil;mento <b>N&Atilde;O</b> ser&aacute; realizado com valor zero (R$ 0,00)!</u></div>';
	echo $msgErro;
}
	/*
	$value="'{$_SESSION["rol"]}','','','','','','','','','','','','','','','','','','','','','','','',''";
	$eclesiastico = new insert ("$value","eclesiastico");
	$eclesiastico->inserir();
	*/

?>
