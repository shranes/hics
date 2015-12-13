<?php
App::uses('AppController', 'Controller');
/**
 * Notices Controller
 *
 * @property Notice $Notice
 * @property PaginatorComponent $Paginator
 */
class NoticesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

}
