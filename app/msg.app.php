<?php

/* ÏûÏ¢ author:·½·É */
class MsgApp extends StorebaseApp
{
	function __construct()
    {
        $this->MsgApp();
    }

	function MsgApp()
	{
		parent::__construct();
	}

	function index()
	{
		if (isset($this->visitor))
		{
			$msg = $this->_get_new_message();

			if (!empty($msg))
			{
				$this->json_result(intval($msg['total'])); return;
			}
		}
		$this->json_result(0);
	}
}