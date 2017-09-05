<?php
namespace SynergiTech\SMS;

class SMSMessage
{
	protected $client;
	private $attributes = array();

	public function __construct($client)
	{
		$this->client = $client;
		$this->reset();
	}

	public function reset()
	{
		$this->attributes = array(
			'from' => null,
			'to' => array(),
			'body' => null
		);
	}

	public function from($name)
	{
		if (preg_match('/^([0-9a-zA-Z\ ]{4,11}|[0-9]{4,15})$/', $name))
		{
			$this->attributes['from'] = $name;
		}
		else
		{
			throw new \Exception('You can use up to 11 alphanumeric characters and spaces or 15 digits. You must use at least 4 characters.');
		}
	}

	public function to($number)
	{
		if (is_array($number))
		{
			$this->attributes['to'] = array_merge($this->attributes['to'], array_values($number));
		}
		else
		{
			$this->attributes['to'][] = $number;
		}
	}

	public function body($content)
	{
		$this->attributes['body'] = $content;
	}

	public function send()
	{
		if (count($this->attributes['to']) < 1 && strlen($this->attributes['body']) < 1)
		{
			throw new \Exception('A message requires at least one recipient and a body before it can be sent.');
		}

		$this->attributes['to'] = array_unique($this->attributes['to']);

		return $this->client->makeRequest('sms', 'send', $this->attributes);
	}
}