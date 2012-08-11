<?php

class TextParser
{
	const LINK_REGEX ='#((https?:\/\/|www.)([-\w.]+)+(:\d+)?(\/([\w\/_.-\#]*(\?\S+)?)?)?)#i';
	const ITALIC_REGEX = '#(^|\s)(\*)(.[^\*]*)(\*)#';
	const BOLD_REGEX = '#(^|\s)(\*\*)(.[^\*]*)(\*\*)#i';
	
	// DEV
	const SUBREDDIT_REGEX = '#^|\s(/r/\w+)#';
	const REDDIT_LINK_REGEX = '#\[([^]]+)\]\(([^)]*)\)#';
	
	private $text;
	
	public static function parse($text)
	{
		$i = new self($text);
		$i->parseBold();
		$i->parseItalic();
		$i->parseLinks();
	//	$i->parseSubreddit();
		return $i->text;
	}
	
	private function __construct($text)
	{
		$this->text = $text;
	}
	
	private function parseBold()
	{
		$this->text = preg_replace(self::BOLD_REGEX,'$1<b>$3</b>',$this->text);
	}
	
	private function parseItalic()
	{
		$this->text = preg_replace(self::ITALIC_REGEX,'$1<i>$3</i>',$this->text);
	}
	
	private function parseLinks()
	{
		$this->text = preg_replace(self::LINK_REGEX,'<a href="$0" target="_blank">$0</a>',$this->text);
	}
	
	private function parseSubreddit()
	{
		$this->text = preg_replace(self::SUBREDDIT_REGEX,'<a href="http://reddit.com$0">$0</a>',$this->text);
	}
}