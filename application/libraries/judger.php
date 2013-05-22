<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Judger
{
	private $temp_path = "/tmp/code/";
	private $languages = array(
		'Java' => 'java',
		'C++' => 'cplusplus',
		'C' => 'purec',
		'Python' => 'python'
	);

	function __construct()
	{
		if (!is_dir($this->temp_path)) {
			mkdir($this->temp_path);
			chmod($this->temp_path, 0777);
		}
	}

	function get_output($language, $code)
	{
		$f = $this->languages[$language];
		return $this->$f($code);
	}

	function judge($language, $code, $sol_code)
	{
		$r = array();
		$s = $this->get_output($language, $sol_code);
		$r['output'] = $this->get_output($language, $code);
		$r['c_output'] = $s;
		if (strcasecmp(trim($r['output']), trim($s)) == 0) {
			$r['correct'] = TRUE;
		} else {
			$r['correct'] = FALSE;
		}
		return $r;
	}

	private function java($code)
	{
		$source_file = $this->temp_path .'Main.java';
		$class_file = $this->temp_path . 'Main.class';

		$f = fopen($source_file, 'w');
		fwrite($f, $code);
		fclose($f);

		$output = shell_exec('javac '. $source_file. ' 2>&1');
		$output .= shell_exec('java -cp ".:' . $this->temp_path. '" Main 2>&1');

		return $output;
	}

	private function cplusplus($code)
	{
		$file_name = md5(time() . rand());
		$source_file = $this->temp_path . $file_name . '.cc';
		$execute_file = $this->temp_path . $file_name;

		$f = fopen($source_file, 'w');
		fwrite($f, $code);
		fclose($f);

		$output = shell_exec('g++ -O2 -std=c++0x '. $source_file. ' -lm -o ' . $execute_file. ' 2>&1');
		$output .= shell_exec($execute_file);

		return $output;
	}

	private function purec($code)
	{
		$file_name = md5(time() . rand());
		$source_file = $this->temp_path . $file_name . '.c';
		$execute_file = $this->temp_path . $file_name;

		$f = fopen($source_file, 'w');
		fwrite($f, $code);
		fclose($f);

		$output = shell_exec('gcc -O2 '. $source_file. ' -lm -o ' . $execute_file. ' 2>&1');
		$output .= shell_exec($execute_file);

		return $output;
	}

	private function python($code)
	{
		$file_name = md5(time() . rand());
		$source_file = $this->temp_path . $file_name . '.py';

		$f = fopen($source_file, 'w');
		fwrite($f, $code);
		fclose($f);

		$output = shell_exec('python '. $source_file .' 2>&1');
		
		return $output;
	}
}