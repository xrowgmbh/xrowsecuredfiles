<?php

$Module = $Params['Module'];

$directory = $Params['directory'];
if ( empty( $directory ) )
{
	return $Module->handleError( eZError::KERNEL_ACCESS_DENIED, 'kernel' );
}

$user = eZUser::currentUser();
$access =  $user->hasAccessTo( 'files', 'read' );

if ( $access['accessWord'] == 'no' )
{
	return $Module->handleError( eZError::KERNEL_ACCESS_DENIED, 'kernel' );
}

if ( $access['accessWord'] == 'limited' )
{
	$hasAccess = false;
	foreach( $access['policies'] as $policy )
	{
		if( isset( $policy['Directory'] ) and in_array( $directory, $policy['Directory'] ) )
		{
			$hasAccess = true;
			break;
		}
	}
	if ( !$hasAccess )
	{
		return $Module->handleError( eZError::KERNEL_ACCESS_DENIED, 'kernel', array( 'AccessList' => $access['policies'] ) );
	}
}

$urlCfg = new ezcUrlConfiguration();
$urlCfg->basedir = '';
$urlCfg->script = 'index.php';

$fullurl = $_SERVER['REQUEST_URI'];

$url = new ezcUrl( $fullurl, $urlCfg );

# extract "files/view"
$url->params = array_slice( $url->getParams(), 3 );

$url->setQuery( array() );

$uri = $url->buildUrl();

if ( empty( $uri ) or $uri == '/' )
{
	return $Module->handleError( eZError::KERNEL_ACCESS_DENIED, 'kernel' );
}

//@TODO fix for siteaccess prepended urls
$file = xrowSecuredFilesTool::directory() . '/' . $directory  .  $uri;

//End with file download
eZFile::download($file, false );

//Else return 404
return $Module->handleError( eZError::KERNEL_NOT_FOUND, 'kernel' );
