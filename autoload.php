<?php

function __autoload( $c )
{
	require_once( getcwd().'/'.$c.'.php' );
}

?>