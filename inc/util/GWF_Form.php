<?php
/**
 * Very convinient form generation. [0]=TYPE,[1]=value,[2]=title,[3]=Tooltip,[4]=LEN?,[5]=required
 * @author gizmore
 * @version 3.0
 * @since 2.0
 */
class GWF_Form
{
	# Encoding Types
	const ENC_DEFAULT   = 'application/x-www-form-urlencoded';
	const ENC_MULTIPART = 'multipart/form-data';
	
	# Form array offsets
	const TYPE = 0;
	const VALUE = 1;
	const TITLE = 2;
	const TOOLTIP = 3;
	const LENGTH = 4;
	const REQUIRED = 5;
	
	
	# Data Types
	const INT = 1;
	const DATE = 2;
	const FLOAT = 3;
	const STRING = 4;
	const STRING_NO_CHECK = 5;
	const SSTRING = 6;
	const MESSAGE = 7;
	const MESSAGE_NOBB = 8;
	const PASSWORD = 9;
	const CHECKBOX = 10;
	const CAPTCHA = 11;
	const SUBMIT = 12;
	const SUBMITS = 13;
	const FILE = 14;
	const FILE_OPT = 15;
	const HIDDEN = 16;
	const SELECT = 17;
	const DIVIDER = 18;
	const VALIDATOR = 19;
	const HEADLINE = 20;
	const DATE_FUTURE = 21;
	const SELECT_A = 22;
	
	private $method;
	private $validator;
	private $form_data;
	
	/**
	 * $data is [0]=TYPE,[1]=value,[2]=title,[3]=Tooltip,[4]=LEN?,[5]=required
	 * @param callback $validator
	 * @param array $data
	 */
	public function __construct($validator, $data)
	{
		$this->validator = $validator;
		$this->form_data = $data;
	}
	
	public function getMethod() { return $this->method; }
	public function getFormData() { return $this->form_data; }
	
	public function getVar($key, $default=false)
	{
		if (!isset($this->form_data[$key])) {
			return $default;
		}
		
		switch($this->form_data[$key][0])
		{
			case self::FILE: case self::FILE_OPT:
				return $this->getFile($key, $default);
			case self::DATE: case self::DATE_FUTURE:
				return $this->getDate($key, $this->form_data[$key][4]);
			case self::CHECKBOX:
				return isset($_POST[$key]);
			case self::INT:
				return Common::getPostInt($key, $default);
			case self::SELECT_A:
				return Common::getPostArray($key, $default);
			default:
				return Common::getPostString($key, $default);
		}
	}
	
	private function getFile($key, $default)
	{
		if (!isset($_FILES[$key])) {
			return $default;
		}
		
		$file = $_FILES[$key];

		if ($file['error'] !== 0 || $file['size'] === 0) {
			return $default;
		}
		
		return $file;
	}
	
	private function getDate($key, $len)
	{
		$back = '';
		switch ($len)
		{
			case 14: $back = $_POST[$key.'s'].$back;
			case 12: $back = $_POST[$key.'i'].$back;
			case 10: $back = $_POST[$key.'h'].$back;
			case 8: $back = $_POST[$key.'d'].$back;
			case 6: $back = $_POST[$key.'m'].$back;
			case 4: $back = $_POST[$key.'y'].$back;
				break;
			default: die('Form Date Length is invalid for '.$key);
		}
		
//		var_dump($back);
//		
//		if(str_repeat('0', $len) === $back) {
//			return '';
//		}
		
		return $back;
	}
	
	public function validate(GWF_Module $module)
	{
		if (false !== ($error = GWF_FormValidator::validate($module, $this, $this->validator))) {
			return $error;
		}
		$this->onNewCaptcha();
		return false;
	}
	
	public static function validateCSRF_WeakS()
	{
		if (false === ($token = GWF_CSRF::validateToken())) {
			return GWF_HTML::lang('ERR_CSRF');
		}
		return false;
	}
	
	public function templateX($title='', $action=true, $method='post')
	{
		return $this->template('formX.php', $title, $action, $method);
	}
	
	public function templateY($title='', $action=true, $method='post')
	{
		return $this->template('formY.php', $title, $action, $method);
	}
	
	private function template($file, $title, $action=true, $method='post')
	{
		if (!is_string($method) || ($method !== 'get')) {
			$method = 'post';
		}
		$this->method = $method;
		
		if (is_bool($action)) {
			$action = $_SERVER['REQUEST_URI'];
		}
		$tVars = array(
			'data' => $this->getTemplateData(),
			'title' => $title,
			'action' => htmlspecialchars($action),
			'method' => $method,
			'enctype' => $this->getEncType(),
//			'requiredFields' => $this->getRequiredText(),
		);
		return GWF_Template::templatePHPMain($file, $tVars);
	}
	
	private function getEncType()
	{
		foreach ($this->form_data as $key => $data)
		{
			if ( ($data[0] === self::FILE) || ($data[0] === self::FILE_OPT) )
			{
				return self::ENC_MULTIPART;
			}
		}
		return self::ENC_DEFAULT;
	}
	
	private function getTemplateData()
	{
		foreach ($this->form_data as $key => $data)
		{
			# Setup input
			switch ($data[0])
			{
				case self::CAPTCHA:
					$this->form_data[$key][1] = $this->getCaptchaData();
					break;
				case self::DATE:
					$this->form_data[$key][1] = GWF_DateSelect::getDateSelects($key, $data[1], $data[4], false, false, false);
					break;
				case self::DATE_FUTURE:
					$this->form_data[$key][1] = GWF_DateSelect::getDateSelects($key, $data[1], $data[4], false, true, false);
					break;
				case self::SELECT:
				case self::SELECT_A:
				case self::SUBMIT:
				case self::SUBMITS:
				case self::HEADLINE:
				case self::DIVIDER:
				case self::CHECKBOX:
				case self::VALIDATOR:
					break;
				default:
					if (isset($_POST[$key])) { $this->form_data[$key][1] = $_POST[$key]; }
					$this->form_data[$key][1] = htmlspecialchars($this->form_data[$key][1]);
					break;
			}
			
			# Setup required
			if (!isset($data[self::REQUIRED]))
			{
				switch ($data[0])
				{
					case self::STRING:
						$data[self::REQUIRED] = true;
						break;
				}
			}
		}
		
		$this->form_data[GWF_CSRF::TOKEN_NAME] = array(self::HIDDEN, GWF_CSRF::generateToken($this->getCSRFToken()));
		
		return $this->form_data;
	}
	
	############
	### CSRF ###
	############
	public function getCSRFToken()
	{
		$hash = '';
		foreach ($this->form_data as $k => $v)
		{
			switch ($v[0])
			{
				# skip these
//				case self::SPECIAL_OPT:
				case self::FILE_OPT:
				case self::SUBMIT:
//				case self::SUBMITS:
				case self::SSTRING:
				case self::HEADLINE:
					break;
				default:
					$hash .= '_'.$k;
			}
		}
		return GWF_Password::getToken($hash);
	}
	
	###############
	### Captcha ###
	###############
	const SESS_NEXT_CAPTCHA = 'GWF3FNC';
	public function onNewCaptcha()
	{
		GWF_Session::remove(self::SESS_NEXT_CAPTCHA);
		GWF_Session::remove('php_captcha');
	}
	public function onSolvedCaptcha()
	{
		GWF_Session::set(self::SESS_NEXT_CAPTCHA, GWF_Session::get('php_captcha'));
	}
	private function getCaptchaData()
	{
		return GWF_Session::getOrDefault(self::SESS_NEXT_CAPTCHA, '');
	}
	
	############
	### Date ###
	############

	
	###################
	### Convinience ###
	###################
	public static function start($action=true, $encoding=self::ENC_DEFAULT)
	{
		if (is_bool($action)) {
			$action = $_SERVER['REQUEST_URI'];
		}
		$action = GWF_HTML::display($action);
		
		if ($encoding !== self::ENC_DEFAULT && $encoding !== self::ENC_MULTIPART) {
			echo GWF_HTML::error('GWF_Form', 'Unknown Form Encoding 0815-F1');
			$encoding = self::ENC_DEFAULT;
		}
		return
			'<div>'.PHP_EOL.
			sprintf('<form action="%s" enctype="%s" method="post">', $action, $encoding).PHP_EOL.
			sprintf('<div>%s</div>', GWF_CSRF::hiddenForm('')).PHP_EOL;
	}
	
	public static function end()
	{
		return 
			'</form>'.PHP_EOL.
			'</div>'.PHP_EOL;
	}
	
	public static function hidden($key, $value)
	{
		return sprintf('<input type="hidden" name="%s" value="%s" />', htmlspecialchars($key), htmlspecialchars($value));
	}
	
	public static function buttonImage($key, $src)
	{
		return sprintf('<input type="image" name="%s" src="%s" />', htmlspecialchars($key), GWF_WEB_ROOT.htmlspecialchars($src));
	}
	
	public static function captcha()
	{
		return
			sprintf('<img src="%simg/captcha.php%s" onclick="this.src=\'%simg/captcha.php?\'+(new Date()).getTime();" />'.PHP_EOL, 
			GWF_WEB_ROOT, '?v='.time(), GWF_WEB_ROOT);
	}
	
	public static function checkbox($name, $checked=false, $id='', $onclick='')
	{
		$name = htmlspecialchars($name);
		$checked = GWF_HTML::checked($checked);
		$id = $id === '' ? '' : sprintf('id="%s"', htmlspecialchars($id));
		$onclick = ''; # TODO: onclick
		return sprintf('<input type="checkbox" %s name="%s" %s %s />', $id, $name, $checked, $onclick);
	}
	
	public static function submit($name, $text='', $id='', $onclick='')
	{
		$id = $id === '' ? '' : sprintf(' id="%s"', htmlspecialchars($id));
		$name = htmlspecialchars($name);
		$text = htmlspecialchars($text);
		
		return sprintf('<span><input%s type="submit" name="%s" value="%s" /></span>', $id, $name, $text);
	}
}
?>