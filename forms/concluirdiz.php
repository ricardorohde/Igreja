<?php
//Calculado a data do proximo lancamento caso não seja passsado
$roligreja = (empty($_GET['igreja'])) ? '0':$_GET['igreja'];
/**/
if (!empty($_GET['data'])) {
	$dtlanc = $_GET['data'];
	$rec = $_GET['rec'];
	$escolha = $_GET['escolha'];
	$menu = $_GET['menu'];
} elseif(!empty($_POST['data'])) {
	$dtlanc = $_POST['data'];
	$rec = $_POST['rec'];
	$escolha = $_POST['escolha'];
	$menu = $_POST['menu'];
}else {
	$dtlanc = '';
}

if ($dtlanc == '') {
	$dataProxLanc = new tes_igreja($roligreja,$anolanc);
	$periodoLanc = $dataProxLanc->dataEntrada();
	#print_r($dataProxLanc->dataEntrada());
	$meslanc = $periodoLanc ['mesrefer'];
	$anolanc = $periodoLanc ['anorefer'];
	$dtlanc  = $periodoLanc ['proxCulto'];
} else {
	$meslanc = ($_GET['mes']=='' || $_GET['mes']>12 || $_GET['mes']<1) ? date('m'):$_GET['mes'];
	$anolanc = (empty($_GET['ano'])) ? date('Y'):$_GET['ano'];
}
if (empty($idIgreja)) {
	$idIgreja = $rolIgreja;
	$igrejaSelecionada = new DBRecord('igreja', $idIgreja, 'rol');
}

	$linkAcesso  = 'escolha='.$escolha.'&menu='.$menu.'&data='.$dtlanc;
	$linkAcesso .= '&rec='.$rec.'&idDizOf='.$idDizOf.'&mes='.$meslanc.'&ano='.$anolanc.'&igreja=';
?>

<fieldset>
	<legend>Fecha Caixa</legend>
<table>
	<tbody>
		<tr>
			<td>
				<form method="post" action="">
					<input name="escolha" type="hidden" value="<?php echo $_GET['escolha'];?>" />
					<input name="concluir" type="hidden" value="1" />
					<input name="dataLancamento" type="hidden" value="<?php echo $dtlanc;?>" />
					<input name="rolIgreja" type="hidden" value="<?php echo $igrejaSelecionada->rol();?>" />
					<label>Igreja:
					<?php
						echo $igrejaSelecionada->razao();//do script forms/autodizimo.php
					?></label>
					<input type="submit" class="btn btn-primary" name="Submit" value="Fecha Caixa" tabindex="<?PHP echo ++$ind;?>" />
				</form>
			</td>
			<td>
				<label>Alterar Igreja: </label>
					<select name="igreja" id="igreja" class="form-control" onchange="MM_jumpMenu('parent',this,0)" tabindex="<?PHP echo ++$ind; ?>" >
						<?php
							$bsccredor = new List_sele('igreja', 'razao', 'rolIgreja');
							$listaIgreja = $bsccredor->List_Selec_pop($linkAcesso,$idIgreja);
							//echo $listaIgreja;
						?>
				</select>
			</td>
		</tr>
	</tbody>
</table>
</fieldset>
