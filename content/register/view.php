<?php
namespace content\register;

class view extends \mvc\view
{
	function config()
	{
		$myform = $this->createform('@'.db_name.'.users','add');
		$myform->white("user_gender, user_firstname, user_lastname, user_mobile, user_birthday, country_id, user_province, user_codemelli, user_passport, submit");
	}
}
?>