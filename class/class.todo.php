<?php

/*===============================================*\
|| ############################################# ||
|| # CLARICOM.CA                                 # ||
|| # ----------------------------------------- # ||
|| # Copyright 2016 CLARICOM All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

class Jak_ToDo{
	
	/* An array that stores the todo item data: */
	
	private $data;
	
	/* The constructor */
	public function __construct($par){
		if(is_array($par))
			$this->data = $par;
	}
	
	/*
		This is an in-build "magic" method that is automatically called 
		by PHP when we output the ToDo objects with echo. 
	*/
		
	public function __toString(){
		
		// The string we return is outputted by the echo statement
		
		$actionB = '<div class="actions">';
		
		if ($this->data['adminid'] == JAK_USERID) {
		
			$actionB .= '<a href="#" class="btn btn-default btn-xs edit"><i class="fa fa-pencil"></i></a><a href="#" class="btn btn-default btn-xs delete"><i class="fa fa-trash-o"></i></a>';
		
		}
		
		if (isset($this->data['work_done'])) {
		
			$actionB .= '<a href="#" class="btn btn-default btn-xs done"><i class="fa fa-check"></i></a>';
			
		} else {
			
			$actionB .= '<a href="#" class="btn btn-default btn-xs notdone"><i class="fa fa-check"></i></a>';
		
		}
		
		$actionB .= '</div>';
		
		return '<li id="todo-'.$this->data['id'].'" class="todo">
			
				<div class="text">'.$this->data['text'].'</div>
				
				'.$actionB.'
				
			</li>';
	}
	
	
	/*
		The following are static methods. These are available
		directly, without the need of creating an object.
	*/
	
	
	
	/*
		The edit method takes the ToDo item id and the new text
		of the ToDo. Updates the database.
	*/
		
	public static function edit($id, $text){
		
		$text = smartsql($text);
		if(!$text) throw new Exception("Wrong update text!");
		
		global $jakdb;
		$jakdb->query('UPDATE '.DB_PREFIX.'todo_list SET text="'.$text.'" WHERE id='.$id);
		
		if ($jakdb->affected_rows != 1) 
			throw new Exception("Couldn't update item!");
	}
	
	/* Done mode marks the ToDo as done */
	
	public static function done($id){
		
		global $jakdb;
		$jakdb->query('UPDATE '.DB_PREFIX.'todo_list SET work_done = IF (work_done = 1, 0, 1) WHERE id='.$id);
		
		if ($jakdb->affected_rows != 1) 
			throw new Exception("Couldn't update item!");
	}
	
	/*
		The delete method. Takes the id of the ToDo item
		and deletes it from the database.
	*/
	
	public static function delete($id){
		
		global $jakdb;
		$jakdb->query('DELETE FROM '.DB_PREFIX.'todo_list WHERE id='.$id);
		
		if ($jakdb->affected_rows != 1) 
			throw new Exception("Couldn't delete item!");
	}
	
	/*
		The rearrange method is called when the ordering of
		the todos is changed. Takes an array parameter, which
		contains the ids of the todos in the new order.
	*/
	
	public static function rearrange($key_value){
		
		$updateVals = array();
		foreach($key_value as $k=>$v)
		{
			$strVals[] = 'WHEN '.(int)$v.' THEN '.((int)$k+1).PHP_EOL;
		}
		
		if(!$strVals) throw new Exception("No data!");
		
		// We are using the CASE SQL operator to update the ToDo positions en masse:
		global $jakdb;
		$result = $jakdb->query('UPDATE '.DB_PREFIX.'todo_list SET position = CASE id
						'.join($strVals).'
						ELSE position
						END');
		
		if(!$result)
			throw new Exception("Error updating positions!");
	}
	
	/*
		The createNew method takes only the text of the todo,
		writes to the databse and outputs the new todo back to
		the AJAX front-end.
	*/
	
	public static function createNew($text){
		
		$text = smartsql($text);
		if(!$text) throw new Exception("Wrong input data!");
		
		global $jakdb;
		$posResult = $jakdb->queryRow('SELECT MAX(position) + 1 FROM '.DB_PREFIX.'todo_list');
		
		if ($jakdb->affected_rows > 0)
			list($position) = $posResult;

		if(!$position) $position = 1;

		$jakdb->query('INSERT INTO '.DB_PREFIX.'todo_list SET text = "'.$text.'", position = '.$position.', adminid = '.JAK_USERID);

		if ($jakdb->affected_rows != 1)
			throw new Exception("Error inserting ToDo!");
		
		// Creating a new ToDo and outputting it directly:
		echo (new Jak_ToDo(array(
			'id' => $jakdb->jak_last_id(),
			'adminid' => JAK_USERID,
			'text' => $text
		)));
		
		exit;
	}
	
} // closing the class definition

?>