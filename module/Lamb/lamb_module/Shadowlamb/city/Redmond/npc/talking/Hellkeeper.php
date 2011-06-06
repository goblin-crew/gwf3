<?php
final class Redmond_Hellkeeper extends SR_TalkingNPC
{
	public function getName() { return 'The barkeeper'; }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		$b = chr(2);
		switch ($word)
		{
			case 'shadowrun':
				return $this->reply("You are looking for a job? You could ask my brother in the TrollsInn. He has some urgent need for spiritouses.");
			case 'cyberware':
				return $this->reply('Nobody wants to be a complete robot. When your essence is 0 you are screwed.');
			case 'magic':
				return $this->reply('I don\'t trust those psychos. ');
			case 'biker': case 'bikers':
				return $this->reply('Most of my guests are hardcore bikers. They protect my pub and in exchange they can have cheap parties here. They do not annoy the other guests, so all are fine with that.');
			case 'punk': case 'punks':
				return $this->reply("The punks and the bikers are in kinda clanwar. Better don`t mention them when you like to talk with the {$b}bikers{$b}.");
			case 'ork': case 'orks':
				return $this->reply('We have not much trouble with orks here. The bikers protect us.');
			case 'beer':
				return $this->reply('One beer. Ok!');
			case 'hello':
				return $this->reply("Hello chummer. Better don`t annoy the bikers. They are pissed because of the {$b}punks{$b}");
			default:
				$msg = array('anything new?', 'the usual stuff?', 'how can i serve you?');
				return $this->reply('Hello chummer, '.Shadowfunc::randomListItem($msg));
		}
		return false;
	}	
}
?>