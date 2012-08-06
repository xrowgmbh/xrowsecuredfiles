<?php
$Module = array( 
    'name' => 'xrow Secured Files' 
);

$ViewList = array();

$ViewList['view'] = array( 
    'functions' => array( 'read' ) , 
    'script' => 'view.php' , 
    'params' => array( 'directory' ),
);

$Directories = array(
    'name' => 'Directory',
    'values' => array(),
    'class' => 'xrowSecuredFilesTool',
    'function' => 'fetchLimitationList',
    'parameter' => array( )
    );

$FunctionList = array();

$FunctionList['read'] = array ( 'Directory' => $Directories ) ;

?>
