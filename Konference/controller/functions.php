<?php
function phpWrapperFromFile($filename)
	{
		ob_start();
	
		if (file_exists($filename) && !is_dir($filename))
		{
			include($filename);
		}
	
		// nacte to z outputu
		$obsah = ob_get_clean();
		return $obsah;
	}

function makeTable($array){
	if(empty($array)){
		return "Nemáte žádné příspěvky";
	}
	// start table
	$html = '<div class="container"><table class="table">';
	// header row
	$html .= '<tr><td></td>';
	foreach($array[0] as $key=>$value){
		if($key == "nazev"){
			$html .= '<th>' . "Název" . '</th>';

		}else if($key == "obsah"){
			$html .= '<th>' . "Obsah" . '</th>';

		}
	}
	$html .= '</tr>';

	// data rows
	foreach( $array as $key=>$value){
		$html .= '<tr><td> <form method="post"><button name="smazat" class="btn btn-danger" value="'.$value['id'].'">Smazat</button></form></td>';
		foreach($value as $key2=>$value2){
			if($key2 == "nazev"||$key2 == "obsah") {
				$html .= '<td>' . $value2 . '</td>';
			}
		}
		$html .= '</tr>';
	}

	// finish table and return it

	$html .= '</table></div>';
	return $html;
}

function makeReviewsTable($array){
	if(empty($array)){
		return "Nemáte žádné přidělené recenze";
	}
	// start table
	$html = '

	<div class="container"><table class="table">';
	// header row
	$html .= '<tr>';
	foreach($array[0] as $key=>$value){
		if($key == "nazev"){
			$html .= '<th>' . "Název" . '</th>';

		}else if($key == "autor"){
			$html .= '<th>' . "Autor" . '</th>';

		}else if($key == "hodnoceni"){
			$html .= '<th>' . "Hodnocení" . '</th>';

		}

	}
	$html .= '</tr>';


	// data rows
	foreach( $array as $key=>$value){
		$html .= '<tr>';
		foreach($value as $key2=>$value2){
			if($key2 == "nazev"||$key2 == "autor") {
				$html .= '<td>' . $value2 . '</td>';
			}
		}
		if($value['hodnoceni']>0){
			$html .= '<td>' . $value["hodnoceni"] . '</td>';
		}else {
			$html .= '<td><a href="?clanek=' . $value["id"] . '" class="btn-sm btn-primary ">Zobrazit</a></td>';
		}
		$html .= '</tr>';
	}
	// finish table and return it

	$html .= '</table></div>';
	return $html;
}

function showAllPosts($array){
	// start table
	$html = '<div class="container"><table class="table">';
	// header row
	$html .= '<tr>';
	foreach($array[0] as $key=>$value){
		if($key == "nick"){
			$html .= '<th>' . "Autor" . '</th>';

		}else if($key == "nazev"){
			$html .= '<th>' . "Název" . '</th>';

		}else if($key == "obsah"){
			$html .= '<th>' . "Obsah" . '</th>';

		}
	}
	$html .= '</tr>';

	// data rows
	foreach( $array as $key=>$value){
		$html .= '<tr>';
		foreach($value as $key2=>$value2){
			if($key2 == "nazev"||$key2 == "obsah"||$key2 == "nick") {
				$html .= '<td>' . $value2 . '</td>';
			}
		}
		$html .= '</tr>';
	}

	// finish table and return it

	$html .= '</table></div>';
	return $html;
}

function showAllPostsWithOptions($allReviews,$allReviewers){
	// start table
	$html = '<div class="container"><table class="table">';
	// header row
	$html .= '<tr>';
	foreach($allReviews[0] as $key=>$value){
		if($key == "autor"){
			$html .= '<th>' . "Autor" . '</th>';

		}else if($key == "nazev"){
			$html .= '<th>' . "Název" . '</th>';

		}else if($key == "recenzent"){
			$html .= '<th>' . "Recenzent" . '</th>';

		}else if($key == "hodnoceni"){
			$html .= '<th>' . "Hodnocení" . '</th>';

		}
	}
	$html .= '</tr>';
	$cntr = 0;
	foreach($allReviews as $key=>$value){
		$html .= '<tr>';
		foreach($value as $key2=>$value2){
				if($key2 == 'autor'||$key2 == 'nazev'||$key2 == 'recenzent'||$key2 == 'hodnoceni'){
					if($key2 == 'hodnoceni'){
						if($value2 == null){
							$html .= '<td> Nehodnoceno </td>';
							$cntr++;
							if($cntr==3){
								$cntr = 0;
							}
						}else{
							$html .= '<td> '.$value2.' </td>';
							$cntr++;
							if($cntr==3){
								$cntr = 0;
							}
						}
					}else if($key2 == 'recenzent'){
						if($value2 == null) {
							$html .= '<td>
												<div class="col-xs-8">
												<form method="post">
												<select id="scroll" name="koho" class="form-control">';
							foreach ($allReviewers as $key3 => $value3){
								foreach($value3 as $key4 => $value4) {
									if($key4 == 'nick') {
										$html .= '<option value="' . $value4 . '">' . $value4 . '</option>';
									}
								}
							}
						$html .= '</select>
												</div>
												<button id="register" value="'.$value["id"].'" name="prirad" type="submit" class="btn btn-sm btn-primary">Odeslat k recenzi</button>
</form>
										</td>';
						$cntr++;
						if($cntr==3){
							$cntr = 0;
						}
						}else{
							$html .= '<td> '.$value2.' </td>';
							$cntr++;
							if($cntr==3){
								$cntr = 0;
							}
						}
					}else {
						if($cntr == 0) {
							$html .= '<td rowspan="3">' . $value2 . '</td>';
						}
					}
				}
		}
		$html .= '</tr>';
	}
	// finish table and return it

	$html .= '</table></div>';
	return $html;
}

function showPostWithOptions($array){
	return '<div class="container">
			<h3>
			'.$array["nazev"].'
			</h3>
			<text>
			'.$array["obsah"].'
</text>
<form class="form-horizontal" method="post" id="footer">
<fieldset>


<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="radios">Hodnocení</label>
  <div>
    <label class="radio-inline" for="radios-0">
      <input type="radio" name="radios" id="radios-0" value="1" checked="checked">
      1
    </label>
    <label class="radio-inline" for="radios-1">
      <input type="radio" name="radios" id="radios-1" value="2">
      2
    </label>
    <label class="radio-inline" for="radios-2">
      <input type="radio" name="radios" id="radios-2" value="3">
      3
    </label>
    <label class="radio-inline" for="radios-3">
      <input type="radio" name="radios" id="radios-3" value="4">
      4
    </label>
    <label class="radio-inline" for="radios-4">
      <input type="radio" name="radios" id="radios-4" value="5">
      5
    </label>
    <label class="radio-inline" for="radios-5">
      <input type="radio" name="radios" id="radios-5" value="6">
      6
    </label>
    <label class="radio-inline" for="radios-6">
      <input type="radio" name="radios" id="radios-6" value="7">
      7
    </label>
    <label class="radio-inline" for="radios-7">
      <input type="radio" name="radios" id="radios-7" value="8">
      8
    </label>
    <label class="radio-inline" for="radios-8">
      <input type="radio" name="radios" id="radios-8" value="9">
      9
    </label>
    <label class="radio-inline" for="radios-9">
      <input type="radio" name="radios" id="radios-9" value="10">
      10
    </label>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="ohodnotit"></label>
  <div class="col-md-4">
    <button id="ohodnotit" name="ohodnotit" class="btn btn-success" value="'.$array['id'].'">Ohodnotit</button>
  </div>
</div>

</fieldset>
</form>

		</div>';

}

?>