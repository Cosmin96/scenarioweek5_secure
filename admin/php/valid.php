<?php

	function valid_input($text){
		if(!$text)
			return true;
		if(strchr($text, "<"))
			return false;
		if(strchr($text, "<script>"))
			return false;
		if(strchr($text, "</script>"))
			return false;
		if($text[0] == "'")
			return false;
		if(strchr($text, "SELECT"))
			return false;
		if(strchr($text, "WHERE"))
			return false;
		if(strchr($text, "UNION"))
			return false;
		if(strchr($text, "DELETE"))
			return false;
		if(strchr($text, "FROM"))
			return false;
		if(strchr($text, "()"))
			return false;
		return true;
	}

?>