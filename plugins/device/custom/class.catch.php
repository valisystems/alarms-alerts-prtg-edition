<?php



/**
 * 
 */
class JAK_catch {
	
	public $parent_folder;
	public $single_file;
	public $child_folder;
	public $file_ext;
	
	public function __construct($args) {
		$this->parent_folder = $args["pdir"];
		$this->single_file = empty($args["sfile"]) ? FALSE : $args["sfile"];
		$this->child_folder = date('Ymd-his');
		$this->file_ext = empty($args['file_ext']) ? 'txt' : $args["file_ext"];
	}
	
	
	public function writeContent()
	{
		// Check if this comes in JSON form:
		$data = [];
		$data['session'] = !empty($_SESSION) ? print_r($_SESSION, true) : '';
		$data['request'] = !empty($_REQUEST) ?  print_r($_REQUEST, true)  : '';// contents data of get, post, and cookie
		$data['get'] = !empty($_GET) ?  print_r($_GET, true) : '';
		$data['post'] = !empty($_POST) ?  print_r($_POST, true) : '';
		$data['files'] = !empty($_FILES) ?  print_r($_FILES, true) : '';
		$data['server'] = !empty($_SERVER) ?  print_r($_SERVER, true) : '';
		$data['file_content'] = !empty(file_get_contents("php://input")) ?  print_r(file_get_contents("php://input"), true) : '';
		
		if ($this->single_file)
		{
			$this->createFile($this->parent_folder, $this->child_folder, $this->file_ext, print_r($data, true));
		}
		else {
			$dir = $this->createDir($this->parent_folder, $this->child_folder);
			foreach ($data as $filename => $content)
			{
			    if (!empty($content))
			    {
			        $this->createFile($dir, $filename, $this->file_ext, $content);
			    }
			}	
		}
	}
	
	public function createDir($path, $dir_name)
	{
	    if (!is_dir($path))
	    {
	    	throw new Exception('Failed to create DIR:' . $dir_name);
	    	exit();
		}
		try {
			mkdir($path.$dir_name, 0775, true);
			is_dir($path . $dir_name);
		    return $path . $dir_name . '/';
		} 
		catch (Exception $e) {
		    exit ('Caught exception: '.  $e->getMessage() . "\n");
		}
	}
	
	public function createFile($path, $filename, $file_ext ,$data)
	{
	    if (!$fp = fopen($path . $filename . '.' . $file_ext, 'x+'))
	    {
	        exit('Failed to create file:' . $filename);
	    }
	    fwrite($fp, $data);
	    fclose($fp);
	}
}
