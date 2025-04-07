<?php

namespace MF\Controller;

abstract class Action {

	protected $view;

	public function __construct() {
		$this->view = new \stdClass();
	}

	protected function render($view, $layout = 'layout') {
		$this->view->page = $view;
	
		$basePath = __DIR__ . '/../../../App/Views/'; // Adjust the relative path as needed
	
		if (file_exists($basePath . $layout . ".phtml")) {
			require_once $basePath . $layout . ".phtml";
		} else {
			$this->content();
		}
	}
	
	protected function content() {
		$classAtual = get_class($this);
		$classAtual = str_replace('App\\Controllers\\', '', $classAtual);
		$classAtual = strtolower(str_replace('Controller', '', $classAtual));
	
		$basePath = __DIR__ . '/../../../App/Views/'; // Adjust the relative path as needed
	
		if (strpos($this->view->page, '/') !== false) {
			$viewpath = $basePath . $this->view->page . ".phtml";
		} else {
			$viewpath = $basePath . $classAtual . "/" . $this->view->page . ".phtml";
		}
	
		if (!file_exists($viewpath)) {
			die("Erro: View '{$this->view->page}.phtml' não encontrada em {$viewpath}");
		}
	
		require $viewpath;
	}
	
}

?>