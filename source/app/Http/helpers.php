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

	function getWeekDay($date = "")
	{
		if($date == "")
		{
			$date = strtotime(date("Y-m-d"));
		}
		$day = date('N', $date)-1;
		return day($day);
	}

	function printDay($id, $three = false) 
	{
		$day = '';
		switch ($id) {
			case 0:
				$day = $three ? 'Lun' : 'Lundi';
				break;

			case 1:
				$day = $three ? 'Mar' : 'Mardi';
				break;
			
			case 2:
				$day = $three ? 'Mer' : 'Mercredi';
				break;
			
			case 3:
				$day = $three ? 'Jeu' : 'Jeudi';
				break;
			
			case 4:
				$day = $three ? 'Ven' : 'Vendredi';
				break;
			
			case 5:
				$day = $three ? 'Sam' : 'Samedi';
				break;
			
			case 6:
				$day = $three ? 'Dim' : 'Dimanche';
				break;
			
			default:
				$day = 'undefinded';
				break;
		}

		return $day;
	}

	/**
	*	Store a modification
	*
	* @param $table : string
	* @param $msg : string
	* @param $author : user_id, default = Auth::user()->id
	*
	* @return response
	*/
	function makeModification($table, $msg, $author=false)
	{
		return App\Modification::create([
			'table'	=> $table,
			'user_id'	=> $author == false ? Auth::user()->id : $author,
			'message'	=> $msg
			]);
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

	/**
	* Show $date with the expected $format
	*
	* @param $date
	* @param $format
	* @return string containing a date in expected $format
	*/
	function showDate($date, $fromFormat, $format, $suff=true)
	{
		$date = date_format(date_create_from_format($fromFormat, $date), $format);
		if(strpos($format, 'D') > -1)
		{
			$date = str_replace('Mon', 'Lun', $date);
			$date = str_replace('Tue', 'Mar', $date);
			$date = str_replace('Wed', 'Mer', $date);
			$date = str_replace('Thu', 'Jeu', $date);
			$date = str_replace('Fri', 'Ven', $date);
			$date = str_replace('Sat', 'Sam', $date);
			$date = str_replace('Sun', 'Dim', $date);
		}
		if(strpos($format, 'M') > -1)
		{
			$date = str_replace('Feb', 'Fév', $date);
			$date = str_replace('Apr', 'Avr', $date);
			$date = str_replace('May', 'Fév', $date);
			$date = str_replace('Jun', 'Fév', $date);
			$date = str_replace('Jul', 'Fév', $date);
			$date = str_replace('Aug', 'Fév', $date);
		}
		if(strpos($format, 'F') > -1)
		{
			$date = str_replace('January', 'Janvier', $date);
			$date = str_replace('February', 'Février', $date);
			$date = str_replace('March', 'Mars', $date);
			$date = str_replace('April', 'Avril', $date);
			$date = str_replace('May', 'Mai', $date);
			$date = str_replace('June', 'Juin', $date);
			$date = str_replace('July', 'Juillet', $date);
			$date = str_replace('August', 'Août', $date);
			$date = str_replace('September', 'Septembre', $date);
			$date = str_replace('October', 'Octobre', $date);
			$date = str_replace('November', 'Novembre', $date);
			$date = str_replace('December', 'Décembre', $date);
		}
		if($suff && strpos($format, 'j') > -1)
		{
			$date = str_replace('1st', '1er', $date);
			$date = str_replace('2nd', '2ème', $date);
			$date = str_replace('3rd', '3ème', $date);
			$date = str_replace('th ', 'ème ', $date);
		}
		if(strpos($format, 'l') > -1)
		{
			$date = str_replace('Monday', 'Lundi', $date);
			$date = str_replace('Tuesday', 'Mardi', $date);
			$date = str_replace('Wednesday', 'Mercredi', $date);
			$date = str_replace('Thursday', 'Jeudi', $date);
			$date = str_replace('Friday', 'Vendredi', $date);
			$date = str_replace('Saturday', 'Samedi', $date);
			$date = str_replace('Sunday', 'Dimanche', $date);
		}		

		return $date;
	}

?>