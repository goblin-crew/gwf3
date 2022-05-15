<?php
$solution = require 'solution.php';
chdir("../../../");
define('GWF_PAGE_TITLE', 'IRC: Duckhunt');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/irc/duckhunt/index.php', $solution);
}
$chall->showHeader();
$chall->onCheckSolution();

$hrefIRC = "https://en.wikipedia.org/wiki/Wikipedia:IRC";
$hrefDuckHunt = "ircs://irc.wechall.net:6697/#duckhunt";
echo GWF_Box::box($chall->lang('info', [$hrefIRC, $hrefDuckHunt]), $chall->lang('title'));

formSolutionbox($chall);

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');
