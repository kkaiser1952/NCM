<?php
function str_replace_first($search, $replace, $subject) {
	$pos = strpos($subject, $search);
		if ($pos !== false) {
			return substr_replace($subject, $replace, $pos, strlen($search));
		}
		return $subject;
	}
?>