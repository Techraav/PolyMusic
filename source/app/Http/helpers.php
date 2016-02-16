<?php

	/**
	*	Get user's information
	* @param $field (string)
	* @param $value : value of $field field
	* @param $wanted (array) : expected information 
	*
	* @return $data : array containing informations
	*/
	function userData($wanted, $value, $field='id')
	{
		$user = App\User::where($field, $value)->first();
		$data = $user[$wanted];

		return $data;
	}


	/**
	* return day in French
	* 
	* @param $n (int) : day 0-7
	*
	* @return $day string
	*/
	function day($n)
	{
		$days = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
		$day = $days[$n];

		return $day;
	}


	/**
	*	Print the link leading to $user_id's profile
	*
	* @param $user_id 
	* @param $forstThenLast (boolean) : true  -> print first_name last_name 
	*								 || false -> print last_name first_name
	* @return $link <a href="#slug"> #names </a>
	*/
	function printUserLink($user_id, $firstThenLast = true, array $classes=[])
	{
		$user = App\User::where('id', $user_id)->first();

		$slug 	= $user->slug;
		$first 	= $user['first_name'];
		$second = $user['last_name'];

		if(!$firstThenLast)
		{
			$buff 	= $first;
			$first 	= $second;
			$second = $buff;
		}

		$class = '';
		if(!empty($classes))
		{
			$class .= 'class="';
			foreach ($classes as $c) {
				$class .= $c.' ';
			}
			$class .= '"';
		}

		$link = '<a '.$class.' href="'.url('users/'.$slug).'">'.ucfirst($first).' '.ucfirst($second).'</a>';

		return $link;
	}

	/**
	* 	C'est compliqué a expliquer...
	*/
	function allowedTags(array $allowed = [])
	{
		$tags = ['a', 'hr', 'br', 'b', 'i', 'u', 'img', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'table', 'thead', 'tr', 'th', 'tbody', 'td', 'ul', 'li'];
		$forbidden = [];
		foreach ($tags as $t) {
			if(!in_array($t, $allowed))
				$forbidden[] = $t;
		}

		return $forbidden;
	}

	/**
	*	Formats (news/articles/comments/announcements) post's content with allowed HTML tags
	*
	* @param $string : post content
	* @param $forbidden : add forbidden tags (modify $tags)
	*
	* @return formated $string (ready-to-save post's content)
	*/
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