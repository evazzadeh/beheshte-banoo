<?php
namespace content\register;


class controller extends \content\home\controller
{
	public function config()
	{
		$this->post('register')->ALL();
	}
}
?>