<?php
class DOGMOD_YouTube extends Dog_Module
{
	public function event_PRIVMSG() { $this->checkForLinks(); }
	public function event_NOTICE() { $this->checkForLinks(); }

	private function checkForLinks()
	{
		if (false !== ($youtube_id = GWF_YouTube::youtubeID($this->msg())))
		{
			if (false !== ($data = GWF_YouTube::getYoutubeData($youtube_id)))
			{
				$this->announceVideo($data);
			}
		}
	}
	
	private function announceVideo(array $data)
	{
		// Pick ISO for channel?
		if (false !== ($chan = Dog::getChannel()))
		{
			$iso = $chan->getLangISO();
		}
		else
		{
			$iso = Dog::getUser()->getLangISO();
		}
		
		$vars = array($data['title'], sprintf('%.02f', $data['rating']), number_format($data['views']), number_format($data['num_raters']));
		Dog::reply($this->langISO($iso, 'video', $vars));
	}
}
