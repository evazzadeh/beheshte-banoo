<?php
namespace content_cp\home;

class view extends \mvc\view
{
	public function config()
	{
		$this->data->list      = $this->cpModlueList('all');
		$this->data->bodyclass = 'fixed';
		$this->include->css    = false;
		$this->include->js     = false;

		if (locale_emulation())
			$this->include->locale_emulation = true;
	}

	function view_datatable()
	{		
		// in root page like site.com/admin/banks show datatable
		// get data from database through model
		$this->data->datatable = $this->model()->datatable();
		$this->global->js      = array($this->url->static.'js/datatable/jquery.dataTables.min.js');
		// check if datatable exist then get this data
		if($this->data->datatable)
		{
			// get all fields of table and filter fields name for show in datatable, access from columns variable
			$this->include->datatable = true;
			$this->data->columns      = \lib\sql\getTable::get($this->data->module);
			if($this->module() === 'users')
			{
				$this->data->columns['user_mobile']['table']   = true;
				$this->data->columns['booth_id']['table']      = true;
				$this->data->columns['permission_id']['table'] = true;
				$this->data->columns['user_barcode']['table']  = true;

				$this->data->columns['user_enterdatetime']['table']  = false;
				$this->data->columns['user_enterdatetime']['table']  = false;
			}
		}
	}


	public function view_child()
	{
		$this->include->editor  = true;
		$this->data->field_list = \lib\sql\getTable::get($this->data->module);
		$this->global->js       = array($this->url->static.'js/cp/medium-editor.min.js');
		$myform                 = $this->createform('@'.db_name.'.'.$this->data->module, $this->data->child);
	}
}
?>