<?php
/**
 * @package     AKHelper
 * @subpackage  main
 *
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */


// No direct access
defined('_JEXEC') or die;


class AKLang {
	
	const APT_KEY = 'AIzaSyC04nF4KXjfR2VQ0jsFm5vEd9LbyiXqbKw' ;
	
	/*
	 * function translate
	 * @param $text
	 */
	
	public static function translate($text, $SourceLan = null, $ResultLan = null, $separate = 0)
	{
		// if text too big, separate it.
		if($separate) {
			
			if(JString::strlen($text) > $separate) {
				$text = JString::str_split( $text, $separate );
			}else{
				$text = array($text) ;
			}
			
		}else{
			$text = array($text) ;
		}
		
		$result = '' ;
		
		// Do translate by google translate API.
		foreach( $text as $text ):
			$result .= self::gTranslate($text,$SourceLan,$ResultLan) ;
		endforeach;
		
		return $result ;
	}
	
	
	function gTranslate ($text,$SourceLan,$ResultLan) {
		
		$url = new JURI();
		
		// for APIv2
		$url->setHost( 'https://www.googleapis.com/' );
		$url->setPath( 'language/translate/v2' ) ;
		
		$query['key'] 		= self::APT_KEY ;
		$query['q'] 		= urlencode($text) ;
		$query['source'] 	= $SourceLan ;
		$query['target'] 	= $ResultLan ;
		
		if( !$text ) return ;
		
		$url->setQuery( $query );
		$url->toString() ;
		$response =  file_get_contents( $url->toString() );
		
		$json = new JRegistry();
		$json->loadJSON( $response );
		
		$r =  $json->get( 'data.translations' ) ;
		
		return $r[0]->translatedText ;
	}
}


