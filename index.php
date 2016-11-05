<?
error_reporting( E_ALL );

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

function _parseDirectorData( $directorToken )
{
	$data = _listDirectoryContents('./data/'.$directorToken.'/');
	
	$name = str_replace('-',' ',$directorToken);
	$name = ucwords($name);
	
	$photoKey = array_search('photo.jpg', $data['files']);
	if( $photoKey === false )
	{ $photo = 'no-photo.jpg'; }
	else 
	{ 
		$photo = 'data/'.$directorToken.'/photo.jpg';
		unset( $data['files'][$photoKey] );
	}
	
	$structure = array('token'=>$directorToken,'name'=>$name, 'photo'=>$photo,'movies'=>array());

	// set up initial array for each movie
	foreach( $data['files'] as $filename )
	{
		$parts = explode('.',$filename);
		$token = $parts[0];
		$name = str_replace('-',' ',$token);
		$name = ucwords($name);

		$structure['movies'][ $token ] = array('token'=>$token, 'name'=>$name, 'description'=>null, 'poster'=>'no-poster.jpg');
	}

	// loop through again and fill in real values for description file and poster file
	foreach( $data['files'] as $filename )
	{	
		$parts = explode('.',$filename);
		$token = $parts[0];
		
		if( $parts[1] === 'md' )
		{
			$structure['movies'][ $token ]['description'] = 'data/'.$directorToken.'/'.$filename;
		}
		
		if( $parts[1] === 'jpg'  )
		{
			$structure['movies'][ $token ]['poster'] = 'data/'.$directorToken.'/'.$filename;
		}
		
	}
	return $structure;
}

$dataRootRaw = _listDirectoryContents('./data/');
showme($dataRootRaw, 'Contents in root of data folder:');

$dataParsed = array();
foreach( $dataRootRaw['folders'] as $directorToken )
{
	$dataParsed[ $directorToken ] = _parseDirectorData( $directorToken );
}

showme($dataParsed, 'Data from parsing all director folders within data folder:');

include('template.html');
?>