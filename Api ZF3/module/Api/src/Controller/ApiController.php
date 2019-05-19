<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Api\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ApiController extends AbstractActionController {
	const UPSTREAM_URI = 'http://localhost/upstream-service.php';

	public function indexAction () {
		$toReturn = [
			'status' => false,
			'message' => 'You forgot the commands?'
		];

		return new ViewModel(['toReturn' => json_encode($toReturn)]);
	}

	public function nameAction () {
		header("Access-Control-Allow-Origin: *");

		$toReturn = [
			'status' => false,
			'message' => '',
			'object' => []
		];

		$request = $this->getRequest();

		if ($request->isPost()) {
			if (self::healthCheck (self::UPSTREAM_URI)) {
				if (self::postData ('saveName', 'name', $this->params()->fromPost('name'))) {
					$toReturn['status'] = true;
					$toReturn['message'] = 'Data saved with success!';
				} else {
					$toReturn['message'] = 'Upstream Service was not able to save data!';
				}
			}
		}

		return new ViewModel(['toReturn' => json_encode($toReturn)]);
	}

	public function numberAction () {
		header("Access-Control-Allow-Origin: *");

		$toReturn = [
			'status' => false,
			'message' => '',
			'object' => []
		];

		$request = $this->getRequest();

		if ($request->isPost()) {
			if (self::healthCheck (self::UPSTREAM_URI)) {
				if (self::postData ('saveNumber', 'number', $this->params()->fromPost('number'))) {
					$toReturn['status'] = true;
					$toReturn['message'] = 'Data saved with success!';
				} else {
					$toReturn['message'] = 'Upstream Service was not able to save data!';
				}
			}
		}

		return new ViewModel(['toReturn' => json_encode($toReturn)]);
	}

	public function emailAction () {
		header("Access-Control-Allow-Origin: *");

		$toReturn = [
			'status' => false,
			'message' => '',
			'object' => []
		];

		$request = $this->getRequest();

		if ($request->isPost()) {
			if (self::healthCheck (self::UPSTREAM_URI)) {
				if (self::postData ('saveEmail', 'email', $this->params()->fromPost('email'))) {
					$toReturn['status'] = true;
					$toReturn['message'] = 'Data saved with success!';
				} else {
					$toReturn['message'] = 'Upstream Service was not able to save data!';
				}
			}
		}

		return new ViewModel(['toReturn' => json_encode($toReturn)]);
	}

	function healthCheck ($url) {
		// PREVENT SSL CERTIFICATE VERIFICATION
		stream_context_set_default( [
			'ssl' => [
				'verify_peer' => false,
				'verify_peer_name' => false,
			],
		]);

		 // GET HEADERS
		$response = get_headers($url, 1);

		// CHECK
		return strpos($response[0], '200') !== false;
	}

	function postData ($action, $label, $value) {
		define('MULTIPART_BOUNDARY', '--------------------------'.microtime(true));

		$options = [
			"ssl" => [ "verify_peer" => FALSE, "verify_peer_name" => FALSE ],
			"http" => [
				"method" => "POST",
				"header" => "Content-Type: multipart/form-data; boundary=".MULTIPART_BOUNDARY,
				"content" => ""
			]
		];

		$options["http"]["content"] .= "--".MULTIPART_BOUNDARY."\r\n"."Content-Disposition: form-data; name=\"{$label}\"\r\n\r\n"."{$value}\r\n";

		$response = json_decode(file_get_contents( self::UPSTREAM_URI."?action=".$action, FALSE, stream_context_create($options)));
// var_dump($response);
		if (!is_null($response)) {
			if ($response->status) {
				return true;
			}
		}

		return false;
	}
}
