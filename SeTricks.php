<?php

class SeTricks
{
	public static function getPosition( $parse_result, $site )
	{
		for( $i=0 ; list($k,$r)=each($parse_result) ; $i++ ) {
			if( stristr($r['url'],$site) ) {
				return $i;
			}
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