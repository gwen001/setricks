<?php

/**
 * I don't believe in license
 * You can do whatever you want with this program
 */

class SeTricks
{
	public static function getPosition( $parse_result, $site )
	{
		$i = 0;
        foreach( $parse_result as $k=>$r ) {
			if( stristr($r['url'],$site) ) {
				return $i;
			}
            $i++;
		}

		return -1;
	}


	public static function getAllUrl( $parse_result )
	{
		$tmp = array();

		foreach( $parse_result as $r ) {
			$tmp[] = array( $r['url'], $r['title'] );
		}

		return $tmp;
	}
}

?>