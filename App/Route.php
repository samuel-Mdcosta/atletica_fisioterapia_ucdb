<?php

namespace App;

use MF\Controller\Action;
use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);

		$routes['inscreverse'] = array(
			'route' => '/inscreverse',
			'controller' => 'indexController',
			'action' => 'inscreverse'
		);

		$routes['registrar'] = array(
			'route' => '/registrar',
			'controller' => 'indexController',
			'action' => 'registrar'
		);

		$routes['autenticar'] = array(
			'route' => '/autenticar',
			'controller' => 'authController',
			'action' => 'autenticar'
		);

		$routes['pagamento'] = array(
            'route' => '/telaPagamento',
            'controller' => 'authController',
            'action' => 'telaPagamento'
        );

		$routes['adm'] = array(
			'route' => '/adm',
			'controller' => 'admController',
			'action' => 'adm'
		);

		$routes['muda'] = array(
			'route' => '/muda',
			'controller' => 'authController',
			'action' => 'newStatus'
		);

		$routes['carterinha'] = array(
			'route' => '/autenticar/carterinha',
			'controller' => 'cardController',
			'action' => 'view'
		);

		$routes['salvarimg'] = array(
			'route' => '/autenticar/carterinha/upload',
			'controller' => 'cardController',
			'action' => 'saveimg'
		);

		$this->setRoutes($routes);
	}

}

?>