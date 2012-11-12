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

if(!defined('AK_THUMBCACHE_PATH')){
	define( 'AK_THUMBCACHE_PATH' , JPATH_ROOT.'/cache/thumbs/cache' );
	define( 'AK_THUMBTEMP_PATH' , JPATH_ROOT.'/cache/thumbs/temp' );
}


class AKThumb
{
	
	public static $cache_path 	= AK_THUMBCACHE_PATH ;
	
	public static $temp_path 	= AK_THUMBTEMP_PATH ;
	
	/*
	 * function resize
	 * @param $arg
	 */
	
	public static function resize($url = null, $width=100, $height=100,$zc=0, $q=85, $file_type = 'jpg' )
	{
		if(!$url) $url = JPath::clean(JPATH_ROOT.'/plugins/system/asikart_easyset/imgs/thumbs/default_img.png');
		$path = self::getImagePath($url) ;
		
		$img = new JImage();
		
		if(JFile::exists($path))
			$img->loadFile($path);
		else
			return "http://placehold.it/{$width}x{$height}" ;
		
		// get Width Height
		$imgdata = JImage::getImageFileProperties($path) ;
		
		// set save data
		if( $file_type != 'png' && $file_type != 'gif' ){
			$file_type = 'jpg' ;
		}
		$file_name = md5($url.$width.$height.$zc.$q.implode('', (array)$imgdata)).'.'.$file_type ;
		$file_path = self::$cache_path.DS.$file_name;
		$file_url  = trim(JURI::root(), '/').'/cache/thumbs/cache/'.$file_name ;
		
		// img exists?
		if(JFile::exists($file_path)){
			return $file_url ;
		}
		
		// crop
		if($zc)
			$img = self::crop($img, $width , $height, $imgdata);
		
		// resize
		$img = $img->resize($width, $height);
		
		// save
		switch($file_type){
			case 'gif': $type = IMAGETYPE_GIF ;break;
			case 'png': $type = IMAGETYPE_PNG ;break;
			default : $type = IMAGETYPE_JPEG ;break;
		}
		
		JFolder::create(self::$cache_path);
		$img->toFile($file_path, $type, array('quality' => $q));
		
		return $file_url;
	}
	
	/*
	 * function getImagePath
	 * @param $url
	 */
	
	public static function getImagePath($url, $hash=null)
	{
		$self 	= JFactory::getURI() ;
		$url 	= JFactory::getURI($url) ;
		
		// is same host?
		if( $self->getHost() == $url->getHost() ){
			
			$url = $url->toString();
			$path = str_replace( JURI::root() ,JPATH_ROOT.DS, $url );
			$path = JPath::clean($path);
		
		}elseif( !$url->getHost() ){
			
			// no host
			$url = $url->toString();
			$path = JPath::clean(JPATH_ROOT.DS.$url);
			
		}else{
			
			// other host
			$path = self::$temp_path.DS.JFile::getName($url) ;
			if( !JFile::exists( $path ) ){
				AK::_('curl.getFile', (string)$url, $path);
			}
		}
		
		return $path ;
	}
	
	/*
	 * function loadImage
	 * @param $arg
	 */
	
	public static function crop($img, $w, $h, $data)
	{
		$p  = $w / $h ;
		
		$oH = $data->height ;
		$oW = $data->width ;
		$oP = $oW / $oH ;
		
		$x = 0 ;
		$y = 0 ;
		
		if($p > $oP) {
			
			$rW = $oW ;
			$rH = $oW * $p ;
			
			$y = ( $oH - $rH ) / 2 ;
			
		}else{
			
			$rH = $oH ;
			$rW = $oH * $p ;
			
			$x = ( $oW - $rW ) / 2 ;
			
		}

		
		$img = $img->crop($rW, $rH, $x, $y);
		return $img ;
	}
	
	/*
	 * function setHash
	 * @param $arg
	 */
	
	public static function setHash($path ,$width, $height,$zc, $q)
	{
		
	}
	
	
	/*
	 * function setCachePath
	 * @param $path
	 */
	
	public static function setCachePath($path)
	{	
		self::$cache_path = $path ;
	}
	
	
	/*
	 * function setTempPath
	 * @param $path
	 */
	
	public static function setTempPath($path)
	{
		self::$temp_path = $path ;
	}
	
	
	/*
	 * function clearCache
	 * @param 
	 */
	
	public static function clearCache()
	{
		if(JFolder::exists(self::$cache_path)){
			JFolder::delete(self::$cache_path) ;
		}
		
		if(JFolder::exists(self::$temp_path)){
			JFolder::delete(self::$temp_path) ;
		}
	}
}
