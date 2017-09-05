## Installation

```
$ composer require synergitech/sms-sender
```

## Usage

```
$client = new \SynergiTech\SMS\Client('YOUR_URL', 'YOUR_API_KEY');
$message = new \SynergiTech\SMS\Message($client);

$message->reset(); // allows object re use à la codeigniter

$message->from('FROM NAME'); // optional
$message->to(array(
	'441111111111',
	'442222222222'
));
$message->to('443333333333');
$message->to('444444444444');
$message->body('This is from the client');

$okay = true;
foreach ($message->send() as $recipient)
{
	if (( ! isset($recipient->result)) || $recipient->result != "200")
	{
		$okay = false;
		break;
	}
}

if ($okay)
{
	echo 'messages were sent';
}
else
{
	echo 'not every message was sent';
}
die();
```