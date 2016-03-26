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

	function printFileInput($name, array $ext, $required=false, array $addAttr=[], $msg=false, array $classes=[])
	{
		$str = "[";
		foreach ($ext as $e) {
			$str .= "'$e', ";
		}
		$str = substr($str, 0, strlen($str)-2);	
		$str .= ']';

		$attr = '';
		if(!empty($addAttr)) {
			foreach ($addAttr as $k => $v) {
				$attr .= $k.'="'.$v.'"  ';
			}
			$attr = substr($attr, 0, strlen($attr)-2);
		}

		$class = 'class="input-file-hidden';
		if(!empty($classes)){
			foreach($classes as $c)
			{
				$class .= ' '.$c;
			}
		}
		$class .= '"';

		$div 	=	'<div class="form-control file-control">';
		$btn 	=	'<button onclick="clickFile()" type="button" class="btn-file glyphicon glyphicon-folder-open">';
		$inp 	=	'<input '. ($required ? 'required' : '') .' onchange="fileInput(this)" data-extension="'.$str.'" '.$attr.' '.$class.' type="file" id="file" name="'.$name.'" />';
		$ebtn 	=	'</button>';
		$cb 	=	'<input type="checkbox" name="check" id="file-check" hidden />';
		$fname 	=	'<span id="file-name"></span>';
		$exit 	=	'<button type="button" id="exit" class="exit" data-dismiss="alert" aria-hidden="true">×</button>';
		$ediv 	=	'</div>';
		$msg 	= 	!$msg ? '' : '<span class="help-block help-file"><i>'.$msg.'</i></span>';

		return $div.$btn.$inp.$ebtn.$cb.$fname.$exit.$ediv.$msg;
	}

	function cut($str, $n, $link=false)
	{
		$string = $str;
		if(strlen($str) > $n){
			$substr = substr($str, 0, $n);
			$left = '<i>[...]</i>';
			if($link != false)
			{
				$left = '<a title="Cliquez pour voir la suite" href="'.url($link).'">'.$left.'</a>';
			}
			$string = $substr.$left.'</p>';
		}
		return $string;
	}

	function glyph($str)
	{
		return 'glyphicon glyphicon-'.$str;
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

	function printDay($id, $three=false) 
	{
		return day($id, $three);
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
			'table'		=> $table,
			'user_id'	=> $author == false ? Auth::user()->id : $author,
			'message'	=> $msg
			]);
	}

	/**
	*	Store a course modification
	*
	* @param $user : string
	* @param $author : user_id, default = Auth::user()->id
	* @param $value : user_id, default = Auth::user()->id
	*
	* @return response
	*/
	function makeCourseModification($user, $course, $value, $author=false)
	{
		return App\CourseModification::create([
			'user_id'	=> $user,
			'author_id'	=> $author == false ? Auth::user()->id : $author,
			'course_id'	=> $course,
			'value'		=> $value,
			]);
	}


	/**
	* return day in French
	* 
	* @param $n (int) : day 0-7
	*
	* @return $day string
	*/
	function day($n, $three=false)
	{
		$days = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
		$day = $days[$n];

		if($three)
		{
			$day = substr($day, 3);
		}

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

	function printLink($url, $msg, array $attributes=[], array $classes=[])
	{
		$class = '';
		if(!empty($classes))
		{
			$class .= 'class="';
			foreach ($classes as $c) {
				$class .= $c.' ';
			}
			$class .= '"';
		}
		$link = '<a ';

		if(!empty($attributes))
		{
			foreach($attributes as $k => $v)
				$link .= $k.'="'.$v.'" ';
		}

		$link .= $class.' href="'.url($url).'">'. $msg .'</a>';

		return $link;
	}

	function printUserLinkV2(App\User $user, $firstThenLast = true, array $classes=[])
	{
		$class = '';
		if(!empty($classes))
		{
			$class .= 'class="';
			foreach ($classes as $c) {
				$class .= $c.' ';
			}
			$class .= '"';
		}

		$name = $user->first_name.' '.$user->last_name;

		$link = '<a '.$class.' href="'.url('users/'.$user->slug).'">'. $name .'</a>';

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


	//  ===>  A c/c après une maj de Model.php

	// protected $nameField = 'title';

    // /**
    // * Create datas + update with slug
    // * @param array $data
    // * @return static
    // */
    // protected function createWithSlug(array $data = [])
    // {
    //     $model = $this->create($data);
    //     $nameField = $this->nameField;
        
    //     $name = $model->$nameField;
        
    //     $stringToSlug = $name.' '.$model->id;
        
    //     $slug = str_slug($stringToSlug);
        
    //     $model->update([
    //         'slug'  => $slug,
    //         ]);
    //     return $model;
    // }

    function createWithSlug($class, array $data=[])
    {
    	$model = $class::create($data);
    	$nameField = $class::NAMEFIELD;

    	$name = $model[$nameField];

        $stringToSlug = $name.'-'.$model->id;
        
        $slug = str_slug($stringToSlug);
        
        $model->update([
            'slug'  => $slug,
            ]);

        return $model;

    }

?>