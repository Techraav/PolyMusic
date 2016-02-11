<?php
	
	function printUserLink($id)
	{

	}

	function postTextFormat($string, $forbidden=[])
	{
		$base = $string;
		$tags = ['a', 'hr', 'br', 'b', 'i', 'u', 'img', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'table', 'thead', 'tr', 'th', 'tbody', 'td', 'ul', 'li'];
		$doubleTags = ['a', 'b', 'i', 'u', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'table', 'thead', 'tr', 'th', 'tbody', 'td'];
		$monoTags = ['hr', 'br', 'img'];

		foreach ($forbidden as $f) {
			unset($tags[array_search($f, $tags)]);
			unset($doubleTags[array_search($f, $doubleTags)]);
			unset($monoTags[array_search($f, $monoTags)]);
		}

		if(strpos($string, '<p>') == 0 && substr($string, strlen($string)-4) == '</p>')
		{
			$string = substr($string, 3, strlen($string)-4);
		}

		$pos = 0;
		$continue = true;
		while($continue == true)
		{
			$openStart = strpos($string, '<', $pos);
			$openEnd = strpos($string, '>', $openStart);
			$tag = substr($string, $openStart, $openEnd-$openStart+1);
			$tag = preg_replace('#<\/*#', '', $tag);
			$tag = preg_replace('#\/*>#', '', $tag);

			if(!in_array($tag, $tags))
			{
				$openEnd += 5;
			}

			$left = substr($string, $openEnd);
			if(strlen($left) <= 2 || strpos($left, '<') == false)
			{
				$continue = false;
			}

			$pos = $openEnd;
		}

		$string = '<p>'.str_replace('<p></p>', '', preg_replace('[\r\n]', '</p><p>', $string)).'</p>';

		$string = str_replace('<table>', '<table class="table">', $string);
		$string = str_replace('<ul>', '<ul class="list-group>"', $string);
		$string = str_replace('<li>', '<li class="list-group-item>"', $string);

		return $string;
	}

?>