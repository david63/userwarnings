<?php
/**
*
* @package User Warnings Extension
* @copyright (c) 2019 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\userwarnings\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\auth\auth;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\auth\auth */
	protected $auth;

	/**
	* Constructor for listener
	*
	* @param \phpbb\auth\auth	$auth	Auth object
	*
	* @access public
	*/
	public function __construct(auth $auth)
	{
		$this->auth = $auth;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.viewtopic_modify_post_row'	=> 'modify_user_warnings',
			'core.permissions' 					=> 'add_permissions',
		);
	}

	/**
	* Update the poster warnings view
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function modify_user_warnings($event)
	{
 		$post_row 						= $event['post_row'];
		$poster_id 						= $event['poster_id'];
		$user_cache 					= $event['user_cache'];
		$poster_warnings 				= $this->auth->acl_gets(array('m_warn', 'u_view_warnings')) ? $user_cache[$poster_id]['warnings'] : '';
		$post_row['POSTER_WARNINGS']	= $poster_warnings;
		$event['post_row'] 				= $post_row;
	}

	/**
	* Add the new permission
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function add_permissions($event)
	{
		$permissions 					= $event['permissions'];
		$permissions['u_view_warnings']	= array('lang' => 'ACL_U_VIEW_WARNINGS', 'cat' => 'profile');
		$event['permissions'] 			= $permissions;
	}
}
