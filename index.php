<?php

function parse($node, $level, $last) {
	$type = gettype($node);
	
	switch ($type) {
		
		case 'object':
			echo '<b>{</b><div class="level level'.$level.'">';
			$c = count((array)$node);
			$i = 1;
			foreach ($node as $key => $child) {
				echo '<div class="key">'.$key.':</div>';
				parse($child, $level+1, $i == $c);
				$i++;
			}
			echo '</div><b>}';
			if (!$last) echo '<i>,</i>';
			echo '</b>';
			break;
		
		case 'array':
			echo '<b>[</b><div class="level">';
			$c = count($node);
			$i = 1;
			foreach ($node as $child) {
				parse($child, $level+1, $i == $c);
				$i++;
			}
			echo '</div><b>]';
			if (!$last) echo '<i>,</i>';
			echo '</b>';
			break;
		
		case 'string':
			echo '<div class="string">"'.htmlentities($node, ENT_NOQUOTES, "UTF-8").'"';
			if (!$last) echo '<i>,</i>';
			echo '</div>';
			break;
		
		case 'integer':
		case 'double':
			echo '<div class="number">'.$node;
			if (!$last) echo '<i>,</i>';
			echo '</div>';
			break;
		
		case 'boolean':
			echo '<div class="boolean">'.$node;
			if (!$last) echo '<i>,</i>';
			echo '</div>';
			break;
		
		case 'NULL':
			echo '<div class="null">null<i>,</i></div>';
			
	}
	
}

$url = (isset($_GET['url']) && !empty($_GET['url'])) ? $_GET['url'] : 'https://graph.facebook.com/99394368305';
$json = json_decode(file_get_contents($url));

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8" />
	<title>JSON Viewer</title>
	<link rel="stylesheet" href="jv.css" type="text/css" />
</head>
<body>

<?php if ($json) parse($json, 1, true); ?>

</body>
</html>