<?php
namespace content_report\home;


class model extends \mvc\model
{
	// SELECT DATE_FORMAT(`user_enterdatetime`,'%d/%m/%Y'), count(*) 
	// FROM `users` group by `user_enterdatetime`
	// 
	// 
	// select date_format(`users`.`user_enterdatetime`,'%d/%m/%Y') AS
	// `date`,`user_gender` AS 'value', count(*) from `users` 
	// group by `users`.`user_enterdatetime`, `user_gender`

	// get a list of data for create a chart
	public function mylist_users()
	{
		$mymodule  = $this->module();
		$mychild   = $this->child();
		$qry       = $this->sql()->tableUsers();

		if($mymodule === 'date')
		{
			// $qry = $qry->field('#user_enterdatetime as date','#count(*) as value');
			$qry = $qry->groupbyUser_enterdatetime('@DAY');
		}
		if($mychild)
		{
			$groupbychild = 'groupbyUser_'.$mychild;
			$qry          = $qry->$groupbychild();

			$qry = $qry->field("#date_format(user_enterdatetime,'%d/%m/%Y') as date",
													'#count(*) as value',
													"#user_$mychild as $mychild"
												);
		}
		else
		{
 			$qry = $qry->field("#date_format(user_enterdatetime,'%d/%m/%Y') as date",
 													'#count(*) as value'
 												);
		}
		$qry = $qry->select();

		return $qry->allassoc();
	}

	// return count of the days in table
	public function mydateCount()
	{
		$qry = $this->sql()->tableUsers()->groupbyUser_enterdatetime('@DAY')->select();
		return $qry->num();
	}

	// return the name of province
	public function myprovinceName($id)
	{
		$qry = $this->sql()->tableProvinces()->whereId($id)->select();
		return $qry->assoc('province_name');
	}

	public function mylist_booths()
	{
		$mymodule  = $this->module();
		$mychild   = $this->child();
		$qry       = $this->sql()->tableGames()
								->field("#game_date as date",'#count(*) as value',"#".$mychild."_id as $mychild")
								->groupbyGame_date()->groupbyBooth_id()->select();

		// var_dump($qry->string());
		return $qry->allassoc();
	}

	// return the name of province
	public function myboothName($id)
	{
		$qry = $this->sql()->tableBooths()->whereId($id)->select();
		return $qry->assoc('booth_title');
	}
}
?>