<?php
/**
 * Swap party member enum positions. (thx somerandomnick)
 * @author gizmore
 */
final class Shadowcmd_party_order extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		if (false !== ($error = self::checkLeader($player)))
		{
			$player->message($error);
			return false;
		}
		
		if (false === ($party = $player->getParty()))
		{
			$player->message('DB ERROR 1');
			return false;
		}
		
		if (!$party->isIdle())
		{
			$player->message('Your party has to be idle to re-order party members.');
			return false;
		}
		
		if (count($args) !== 2)
		{
			$player->message(Shadowhelp::getHelp($player, 'party_order'));
			return false;
		}
		
		if (false === ($a = $party->getMemberByArg($args[0])))
		{
			$player->message('Your first parameter does not adress a party member.');
			return false;
		}
		
		if (false === ($b = $party->getMemberByArg($args[1])))
		{
			$player->message('Your second parameter does not adress a party member.');
			return false;
		}
		
		if ($a->getID() === $b->getID())
		{
			$player->message('Nothing swapped, so bailout.');
			return false;
		}
		
		if ($a->isLeader() || $b->isLeader())
		{
			$player->message('You should not use this command to swap leader position. Please use the #(le)ader command.');
			return false;
		}
		
		if (false === $party->swapMembers($a, $b))
		{
			$player->message('DB ERROR 2');
			return false;
		}
		
		$party->notice(sprintf('%s and %s have swapped their party position.', $a->getName(), $b->getName()));
		
		return true;
	}
}
?>