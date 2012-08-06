<?php

class xrowSecuredFilesTool
{
	static function directory() {
		return eZSys::storageDirectory() . "/secure";
	}
	static function fetchLimitationList() {
        $names = array();
        $iterator = new DirectoryIterator( self::directory() );
        foreach ( $iterator as $fileinfo )
        {
            if ( $fileinfo->isDir() and ! $fileinfo->isDot() )
            {
            	$names[] = array( 'name' => $fileinfo->getFilename(), 'id' => $fileinfo->getFilename() );
            }
        }
        return $names;
	}
    static function fetchDirectoryList()
    {
        $names = array();
        $iterator = new DirectoryIterator( self::directory() );
        foreach ( $iterator as $fileinfo )
        {
            if ( $fileinfo->isDir() and ! $fileinfo->isDot() )
            {
            	$names[$fileinfo->getInode()] = $fileinfo->getFilename();
            }
        }
        ksort( $names );
        return $names;
    }
}