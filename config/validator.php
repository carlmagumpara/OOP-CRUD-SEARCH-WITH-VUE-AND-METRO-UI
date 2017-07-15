<?php
	/**
	* 
	*/
	class arrayValidator
	{
		function validate($array)
		{
			$errors = array();
			foreach ($array as $key => $value) {
				if ($value === '') {
					$errors[] = ucfirst($key.' is required');
				}
			}
			if (!empty($errors)) {
				return json_encode($errors);
			} else {
				return TRUE;
			}
		}
	}
?>