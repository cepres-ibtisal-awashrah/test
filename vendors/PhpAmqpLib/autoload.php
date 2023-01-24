<?php

foreach ([
	'PhpAmqpLib/Helper/DebugHelper.php',
	'PhpAmqpLib/Helper/Assert.php',
	'PhpAmqpLib/Helper/Protocol/MethodMap091.php',
	'PhpAmqpLib/Helper/Protocol/Wait091.php',
	'PhpAmqpLib/Helper/Protocol/Protocol091.php',
	'PhpAmqpLib/Helper/MiscHelper.php',
	'PhpAmqpLib/Exception/AMQPExceptionInterface.php',
	'PhpAmqpLib/Exception/AMQPRuntimeException.php',
	'PhpAmqpLib/Exception/AMQPTimeoutException.php',
	'PhpAmqpLib/Exception/AMQPConnectionClosedException.php',
	'PhpAmqpLib/Exception/AMQPProtocolException.php',
	'PhpAmqpLib/Exception/AMQPProtocolChannelException.php',
	'PhpAmqpLib/Exception/AMQPIOException.php',
	'PhpAmqpLib/Helper/SocketConstants.php',
	'PhpAmqpLib/Wire/AMQPAbstractCollection.php',
	'PhpAmqpLib/Wire/AbstractClient.php',
	'PhpAmqpLib/Wire/AMQPWriter.php',
	'PhpAmqpLib/Wire/AMQPTable.php',
	'PhpAmqpLib/Wire/AMQPReader.php',
	'PhpAmqpLib/Wire/IO/AbstractIO.php',
	'PhpAmqpLib/Wire/IO/StreamIO.php',
	'PhpAmqpLib/Package.php',
	'PhpAmqpLib/Wire/Constants.php',
	'PhpAmqpLib/Wire/Constants080.php',
	'PhpAmqpLib/Wire/Constants091.php',
	'PhpAmqpLib/Channel/AbstractChannel.php',
	'PhpAmqpLib/Channel/AMQPChannel.php',
	'PhpAmqpLib/Message/AMQPMessage.php',
	'PhpAmqpLib/Connection/AbstractConnection.php',
	'PhpAmqpLib/Connection/AMQPStreamConnection.php',
	'PhpAmqpLib/Connection/AMQPSSLConnection.php'
] as $filename) {
	require_once VENPATH . $filename;
}
