<?php
namespace SynergiTech\SMS;

class Client
{
	protected $host;
	protected $key;

	public function __construct($host, $key)
	{
		$this->host = $host;
		$this->key = $key;
	}

	public function makeRequest($controller, $action, $parameters)
	{
		$url = implode('/', array(
			$this->host,
			'api',
			$controller,
			$action
		));

		$headers = array(
			'x-server-api-key' => $this->key,
			'content-type' => 'application/json'
		);

		$response = \Requests::post($url, $headers, json_encode($parameters));

		if ($response->status_code === 200)
		{
			return json_decode($response->body);
		}

		throw new \Exception('Could not send message to API: ' . $response->status_code);
	}
}