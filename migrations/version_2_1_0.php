<?php
/**
*
* @package User Warnings Extension
* @copyright (c) 2019 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\userwarnings\migrations;

use phpbb\db\migration\migration;

class version_2_1_0 extends migration
{
	public function update_data()
	{
		return array(
			// Add the new permission
			array('permission.add', array('u_view_warnings', true)),
		);
	}
}
