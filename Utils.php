<?php

/**
 * I don't believe in license
 * You can do whatever you want with this program
 */

class Utils
{
	public static function cutter( $open_tag, $close_tag, $str, $pos )
	{
		$p1 = strpos( $str, $open_tag, $pos );
		//var_dump( $p1 );
		if( $p1 === false ) {
			return $str;
		}

		$p2 = strpos( $str, $close_tag, $p1+strlen($open_tag) );
		//var_dump( $p2 );
		if( $p2 === false ) {
			return $str;
		}

		return substr( $str, $p1+strlen($open_tag), $p2-$p1-strlen($open_tag) );
	}
}

?>