<?php

/**
 * I don't believe in license
 * You can do whatever you want with this program
 */

require( getcwd().'/config.php' );
require( getcwd().'/autoload.php' );

//var_dump( $_POST );
$error = 0;

if( !isset($_POST['_a']) ) {
	$error |= 1;
} else {
	$_a = (int)$_POST['_a'];
	if( $_a <= 0 || $_a > 2 ) {
		$error |= 1;
	}
	if( !isset($_POST['site']) || ($site=trim($_POST['site']))=='' ) {
		$error |= 2;
	}
	if( (!isset($_POST['q']) || ($q=trim($_POST['q']))=='') && ($_a==1) ) {
		$error |= 4;
	}
}
//var_dump( $error );

if( !$error ) {
	if( $_a == 1 ) {
		$q1 = $q;
		$site1 = $site;
		$separse = new SeParse();
		$separse->setQuery( $q );
		$separse->setPerPage( 50 );
		$separse->setMaxResult( 200 );
		if( $separse->run() < 0 ) {
			$error |= 6;
			exit('error !');
		}
		$t_result = $separse->getResult();
		//var_dump( $t_result );
		$position = SeTricks::getPosition( $t_result, $site );
	}
	elseif( $_a == 2 ) {
		$q2 = $q;
		$site2 = $site;
		if( $site != '' ) {
			$q = 'site:'.$site.' '.$q;
		}
		$separse = new SeParse();
		$separse->setQuery( $q );
		$separse->setPerPage( 100 );
		$separse->setMaxResult( 1000 );
		$separse->addCutterTag( 'url', '/url?q=', '&amp;' );
		$separse->addCutterTag( 'url', '/url?url=', '&amp;' );
		/*$separse->addCutterTag( 'url', 'http://'.$site, '&amp;' );
		$separse->addCutterTag( 'url', 'https://'.$site, '&amp;' );
		$separse->addCutterTag( 'url', 'http://'.$site, '"' );
		$separse->addCutterTag( 'url', 'https://'.$site, '"' );*/
		//$separse->disableLimit();
		if( $separse->run() < 0 ) {
			$error |= 6;
			exit('error !');
		}
		$t_result = $separse->getResult();
		// var_dump( $t_result );
		$t_url = SeTricks::getAllUrl( $t_result );
	}
}

?>


<html>
	<head>
		<title>Search Engine Tricks</title>
		<style>
			/** {
				margin: 0;
				padding: 0px;
			}*/
			pre {
				/*font-family: Fixed, monospace;*/
			}
		</style>
	</head>
	<body>
		<pre align="center">
     __           .__          __
   ______  ____ _/  |_ _______ |__|  ____  |  | __  ______
  /  ___/_/ __ \\   __\\_  __ \|  |_/ ___\ |  |/ / /  ___/
 \___ \ \  ___/ |  |   |  | \/|  |\  \___ |    <  \___ \
 /_____> \____> |__|   |__|   |__| \_____>|__|__\/_____>
		</pre>
		<br /><br />
		<form action="" method="post">
			<input type="hidden" name="_a" value="1" />
			1. Find the position of your site <input type="text" name="site" value="<?php if(isset($site1)) { echo htmlentities($site1); } ?>" placeholder="ex: 10degres.net" /> for the search term <input type="text" name="q" value="<?php if(isset($q1)) { echo htmlentities($q1); } ?>" placeholder="ex: security" />
			<input type="submit" value="Fire !" />
			<br />
			<?php if ( isset($position) ) {
					if( $position > 0 ) { ?>
					Your site has been found at position <strong></strong><?php echo $position; ?></strong>, that means page <strong><?php echo ceil($position/SE_DEFAULT_PER_PAGE); ?></strong>.
			<?php } else { ?>
					Your site has not been found, might be over page <?php echo ceil($separse->getMaxResult()/SE_DEFAULT_PER_PAGE); ?>.
			<?php } ?>
			<?php } ?>
		</form>
		<br /><br />
		<form action="" method="post">
			<input type="hidden" name="_a" value="2" />
			2. Find all urls indexed of your site <input type="text" name="site" value="<?php if(isset($site2)) { echo htmlentities($site2); } ?>" placeholder="ex: 10degres.net" /> for the search term <input type="text" name="q" value="<?php if(isset($q2)) { echo htmlentities($q2); } ?>" placeholder="ex: security" /> (optionnal)
			<input type="submit" value="Fire !" />
			<br />
			<?php if ( isset($t_url) ) { ?>
				<table width="100%">
					<tbody>
						<?php $i=1; foreach( $t_url as $k=>$lnk ) { ?>
						<tr>
							<td align="right" width="3%"><?php echo $i; ?>.</td>
							<td align="left" width="45%"><a href="<?php echo $lnk[0]; ?>" target="_blank"><?php echo $lnk[0]; ?></a></td>
							<td align="left" width="45%"><?php echo $lnk[1]; ?></td>
						</tr>
						<?php $i++; } ?>
					</tbody>
				</table>
				<?php if( count($t_url) >= $separse->getMaxResult() ) { ?>
					<br /><br />You reach the script limit set to <?php echo $separse->getMaxResult(); ?>, merely more url available...
				<?php } ?>
			<?php } ?>
		</form>
    </body>
</html>
