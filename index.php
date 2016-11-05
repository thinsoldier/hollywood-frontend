<?
// Import useful utility functions
include('php/functions/func.debug.php');

// Read contents of data folder and generate useful array structures.

function _listDirectoryContents( $path )
{
	$found = array( 'files'=>array() , 'folders'=>array() );
	$dir = new DirectoryIterator( $path );
	foreach ($dir as $fileinfo) {
		 if ( !$fileinfo->isDot()  ) 
		 {
			if( $fileinfo->isDir() ){ $found['folders'][] = $fileinfo->getFilename(); }
			else { $found['files'][] = $fileinfo->getFilename(); }  
		 }
	}
	return $found;
}

$data1 = _listDirectoryContents('./data/');
showme($data1, 'root of data folder');

$data2 = _listDirectoryContents('./data/wes-anderson/');
showme($data2, 'wes anderson folder');

include('template.html');
?>