<?php
Class Controller{
	public static function helloworld(){
		echo 'Hello World';
	}
	public function text($t1, $t2, $t3){
		echo 'Text: ' . $t1.$t2.$t3;
	}
	public function path($path, $path2){
		echo 'Current Path:' . $path;
		echo '<br />Current Path with parameters:' . $path2;
	}
	public function form_get(){
		echo '<form method="post"><input type="text" name="test" /><input type="submit" /></form>';
	}
	public function form_post(){
		var_dump($_POST);
	}
}