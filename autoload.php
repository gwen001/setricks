<?php

/**
 * I don't believe in license
 * You can do whatever you want with this program
 */


spl_autoload_register(function ( $c ) {
	require_once( getcwd().'/'.$c.'.php' );
});

?>