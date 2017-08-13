<?php

//Get Lang Array And Convert It To JSON With Escaping
function json_lang($str) {

	return htmlspecialchars(json_encode(Lang::get($str)), ENT_QUOTES, "UTF-8");
	
}
