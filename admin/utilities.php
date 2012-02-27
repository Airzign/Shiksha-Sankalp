<?php
/*
 * Uploads a file to a directory and handles different types of errors that can arise.
 *
 * $_FILES    : Normal $_FILES
 * $directory : directory where the file is to be uploaded
 * $file_name : name of the file in $_FILES
 * $size      : maximum allowed size of the file in bytes
 * $allowed_file_types : allowed file extensions. Optional, by default do not check file types.
 */
function upload_file_to_dir($_FILES, $directory, $file_name, $size, $allowed_file_types = false) {
  $ret = array();
  if(array_key_exists($file_name,$_FILES) && $_FILES[$file_name]['name'] !== '') {
    if($_FILES[$file_name]["size"] > $size) {
      $ret['msg'] = 'The file is larger than the maximum allowed size('.$size/(1024*1024).'MB) so was not uploaded.';
      $ret['value'] = false;
      return $ret;
    }
    if($allowed_file_types != false) {
      $allowed=false;
      foreach($allowed_file_types as $type)
	if($_FILES[$file_name]['type'] == $type)
	  $allowed=true;
      if(!$allowed) {
	$ret['msg'] = 'The file is not of valid extension so was not uploaded.';
	$ret['value'] = false;
	return $ret;
      }
    }
    if(!file_exists($directory.$_FILES[$file_name]['name'])) {
      $new_filename=$_FILES[$file_name]['name'];
    } else {
      $fileparts=explode('.',$_FILES[$file_name]['name']);
      $extension='.'.array_pop($fileparts);
      $name=implode('.',$fileparts).'_';
      $filecount=0;
      while(file_exists($directory.$name.$filecount.$extension))
	$filecount=$filecount+1;
      $new_filename=$name.$filecount.$extension;
    }
    move_uploaded_file($_FILES[$file_name]['tmp_name'],$directory.$new_filename);
    $ret['msg'] = $new_filename;
    $ret['value'] = true;
    return $ret;
  }
  $ret['value'] = 4;
  return $ret;
}

?>