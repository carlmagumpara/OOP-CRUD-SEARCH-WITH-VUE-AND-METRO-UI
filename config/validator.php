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
					$errors[] = $key.' is empty';
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