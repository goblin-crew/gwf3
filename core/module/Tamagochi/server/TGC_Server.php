<?php
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

require 'TGC_Global.php';
require 'TGC_ServerUtil.php';
require 'TGC_Commands.php';

final class TGC_Server implements MessageComponentInterface
{
	private $server;
	
	public function mainloop()
	{
		GWF_Log::logMessage("TGC_Server::mainloop()");
		$this->server->run();
	}
	
	###############
	### Ratchet ###
	###############
	public function onOpen(ConnectionInterface $conn) {
		GWF_Log::logCron(sprintf("TGC_Server::onOpen()"));
	}
	
	public function onMessage(ConnectionInterface $from, $msg) {
		GWF_Log::logCron(sprintf("TGC_Server::onMessage(): %s", $msg));
		if ($player = TGC_ServerUtil::getPlayerForMessage($msg)) {
			if (!$player->isConnected()) {
				$player->setConnectionInterface($from);
				$player->rehash();
			}
			TGC_Commands::execute($player, $msg);
		}
	}
	
	public function onClose(ConnectionInterface $conn) {
		GWF_Log::logCron(sprintf("TGC_Server::onClose()"));
		if ($player = TGC_ServerUtil::getPlayerForConnection($conn)) {
			$player->disconnect();
		}
	}
	
	public function onError(ConnectionInterface $conn, \Exception $e) {
		GWF_Log::logCron(sprintf("TGC_Server::onError()"));
	}
	
	############
	### Init ###
	############
	public function initTamagochiServer()
	{
		GWF_Log::logMessage("TGC_Server::initTamagochiServer()");
		$this->server = IoServer::factory(new HttpServer(new WsServer($this)), 34543);
		return true;
	}
}
