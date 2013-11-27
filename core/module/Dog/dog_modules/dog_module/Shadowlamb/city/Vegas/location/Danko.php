<?php
final class Vegas_Danko extends SR_Location
{
	public function getFoundPercentage() { return 37.00; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
// 	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "You can use {$c}ttb and {$c}ttj here."; }
	public function getNPCS(SR_Player $player)
	{
		return array('ttb'=>'Vegas_DankoBarkeeper', 'ttg'=>'Vegas_DankoSlaygon', 'tts'=>'Vegas_DankoBozWank', 'ttj'=>'Vegas_DankoJohnson');
	}
}
?>
