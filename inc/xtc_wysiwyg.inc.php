<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_wysiwyg.inc.php 2867 2012-05-14 11:57:08Z web28 $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   --------------------------------------------------------------
   based on:
   (c) 2005 XT-Commerce & H.H.G. group
   (c) 2008 Hetfield - http://www.MerZ-IT-SerVice.de

   Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

function xtc_wysiwyg($type, $lang, $langID = '') {

  $js_src = DIR_WS_MODULES .'ckeditor/ckeditor.js';
  $path = DIR_WS_MODULES .'ckeditor/';
  $filemanager = DIR_WS_MODULES.'kcfinder/browse.php?opener=ckeditor&cms=shophelfer&lang='.$lang;
  $file_path = '&type=files';
  $image_path = '&type=images';
  $flash_path = '&type=flash';
  $media_path = '&type=flash';
	
  $editor = '&editor=ckeditor';

  $sid = '&'.session_name() . '=' . session_id(); //web28 security fix
  switch($type) {
    // WYSIWYG editor content manager textarea named cont
    case 'content_manager':
      $val ='<script type="text/javascript" src="'.$js_src.'"></script>
             <script type="text/javascript">
               window.onload = function() {
                 var oFCKeditor = new FCKeditor( \'cont\', \'100%\', \'400\'  ) ;
                 oFCKeditor.BasePath = "'.$path.'" ;
                 oFCKeditor.Config["LinkBrowserURL"] = "'.$filemanager.$file_path.$sid.'" ;
                 oFCKeditor.Config["ImageBrowserURL"] = "'.$filemanager.$image_path.$sid.'" ;
                 oFCKeditor.Config["FlashBrowserURL"] = "'.$filemanager.$flash_path.$sid.'" ;
                 oFCKeditor.Config["MediaBrowserURL"] = "'.$filemanager.$media_path.$sid.'" ;
                 oFCKeditor.Config["AutoDetectLanguage"] = false ;
                 oFCKeditor.Config["DefaultLanguage"] = "'.$lang.'" ;
                 oFCKeditor.ReplaceTextarea() ;
               }
             </script>';
      break;
	// Removed email_manager wysiwyg editor because of the conflicts with Smarty template engine	  
    // WYSIWYG editor email manager textarea named cont
    /*
	case 'email_manager':
      $val ='<script type="text/javascript" src="'.$js_src.'"></script>
             <script type="text/javascript">
               window.onload = function() {
                 var oFCKeditor = new FCKeditor( \'cont\', \'100%\', \'400\'  ) ;
                 oFCKeditor.BasePath = "'.$path.'" ;
                 oFCKeditor.Config["LinkBrowserURL"] = "'.$filemanager.$file_path.$sid.'" ;
                 oFCKeditor.Config["ImageBrowserURL"] = "'.$filemanager.$image_path.$sid.'" ;
                 oFCKeditor.Config["FlashBrowserURL"] = "'.$filemanager.$flash_path.$sid.'" ;
                 oFCKeditor.Config["MediaBrowserURL"] = "'.$filemanager.$media_path.$sid.'" ;
                 oFCKeditor.Config["AutoDetectLanguage"] = false ;
                 oFCKeditor.Config["ProcessHTMLEntities"] = false ;
                 oFCKeditor.Config["DefaultLanguage"] = "'.$lang.'" ;
                 oFCKeditor.ReplaceTextarea() ;
               }
             </script>';
      break;
	  */
    // WYSIWYG editor content manager products content section textarea named file_comment
    case 'products_content':
      $val ='<script type="text/javascript" src="'.$js_src.'"></script>
             <script type="text/javascript">
               window.onload = function() {
                 var oFCKeditor = new FCKeditor( \'file_comment\', \'100%\', \'400\'  ) ;
                 oFCKeditor.BasePath = "'.$path.'" ;
                 oFCKeditor.Config["LinkBrowserURL"] = "'.$filemanager.$file_path.$sid.'" ;
                 oFCKeditor.Config["ImageBrowserURL"] = "'.$filemanager.$image_path.$sid.'" ;
                 oFCKeditor.Config["FlashBrowserURL"] = "'.$filemanager.$flash_path.$sid.'" ;
                 oFCKeditor.Config["MediaBrowserURL"] = "'.$filemanager.$media_path.$sid.'" ;
                 oFCKeditor.Config["AutoDetectLanguage"] = false ;
                 oFCKeditor.Config["DefaultLanguage"] = "'.$lang.'" ;
                 oFCKeditor.ReplaceTextarea() ;
               }
             </script>';
      break;
    // WYSIWYG editor categories_description textarea named categories_description[langID]
    case 'categories_description':
      $val ='var oFCKeditor = new FCKeditor( \'categories_description['.$langID.']\', \'100%\', \'300\' ) ;
             oFCKeditor.BasePath = "'.$path.'" ;
             oFCKeditor.Config["LinkBrowserURL"] = "'.$filemanager.$file_path.$sid.'" ;
             oFCKeditor.Config["ImageBrowserURL"] = "'.$filemanager.$image_path.$sid.'" ;
             oFCKeditor.Config["FlashBrowserURL"] = "'.$filemanager.$flash_path.$sid.'" ;
             oFCKeditor.Config["MediaBrowserURL"] = "'.$filemanager.$media_path.$sid.'" ;
             oFCKeditor.Config["AutoDetectLanguage"] = false ;
             oFCKeditor.Config["DefaultLanguage"] = "'.$lang.'" ;
             oFCKeditor.ReplaceTextarea() ;
             ';
      break;
    // WYSIWYG editor products_description textarea named products_description_langID
    case 'products_description':
      $val ='var oFCKeditor = new FCKeditor( \'products_description_'.$langID.'\', \'100%\', \'400\'  ) ;
             oFCKeditor.BasePath = "'.$path.'" ;
             oFCKeditor.Config["LinkBrowserURL"] = "'.$filemanager.$file_path.$sid.'" ;
             oFCKeditor.Config["ImageBrowserURL"] = "'.$filemanager.$image_path.$sid.'" ;
             oFCKeditor.Config["FlashBrowserURL"] = "'.$filemanager.$flash_path.$sid.'" ;
             oFCKeditor.Config["MediaBrowserURL"] = "'.$filemanager.$media_path.$sid.'" ;
             oFCKeditor.Config["AutoDetectLanguage"] = false ;
             oFCKeditor.Config["DefaultLanguage"] = "'.$lang.'" ;
             oFCKeditor.ReplaceTextarea() ;
             ';
      break;
    // WYSIWYG editor products short description textarea named products_short_description_langID
    case 'products_short_description':
      $val ='var oFCKeditor = new FCKeditor( \'products_short_description_'.$langID.'\', \'100%\', \'300\'  ) ;
             oFCKeditor.BasePath = "'.$path.'" ;
             oFCKeditor.Config["LinkBrowserURL"] = "'.$filemanager.$file_path.$sid.'" ;
             oFCKeditor.Config["ImageBrowserURL"] = "'.$filemanager.$image_path.$sid.'" ;
             oFCKeditor.Config["FlashBrowserURL"] = "'.$filemanager.$flash_path.$sid.'" ;
             oFCKeditor.Config["MediaBrowserURL"] = "'.$filemanager.$media_path.$sid.'" ;
             oFCKeditor.Config["AutoDetectLanguage"] = false ;
             oFCKeditor.Config["DefaultLanguage"] = "'.$lang.'" ;
             oFCKeditor.ReplaceTextarea() ;
             ';
      break;
    // WYSIWYG editor newsletter textarea named newsletter_body
    case 'newsletter':
      $val ='<script type="text/javascript" src="'.$js_src.'"></script>
             <script type="text/javascript">
               window.onload = function() {
                 var oFCKeditor = new FCKeditor( \'newsletter_body\', \'100%\', \'400\'  ) ;
                 oFCKeditor.BasePath = "'.$path.'" ;
                 oFCKeditor.Config["LinkBrowserURL"] = "'.$filemanager.$file_path.$sid.'" ;
                 oFCKeditor.Config["ImageBrowserURL"] = "'.$filemanager.$image_path.$sid.'" ;
                 oFCKeditor.Config["FlashBrowserURL"] = "'.$filemanager.$flash_path.$sid.'" ;
                 oFCKeditor.Config["MediaBrowserURL"] = "'.$filemanager.$media_path.$sid.'" ;
                 oFCKeditor.Config["AutoDetectLanguage"] = false ;
                 oFCKeditor.Config["DefaultLanguage"] = "'.$lang.'" ;
                 oFCKeditor.ReplaceTextarea() ;
               }
             </script>';
      break;
    // WYSIWYG editor mail textarea named message
    case 'mail':
      $val ='<script type="text/javascript" src="'.$js_src.'"></script>
             <script type="text/javascript">
               window.onload = function() {
                 var oFCKeditor = new FCKeditor( \'message\', \'100%\', \'400\' ) ;
                 oFCKeditor.BasePath = "'.$path.'" ;
                 oFCKeditor.Config["LinkBrowserURL"] = "'.$filemanager.$file_path.$sid.'" ;
                 oFCKeditor.Config["ImageBrowserURL"] = "'.$filemanager.$image_path.$sid.'" ;
                 oFCKeditor.Config["FlashBrowserURL"] = "'.$filemanager.$flash_path.$sid.'" ;
                 oFCKeditor.Config["MediaBrowserURL"] = "'.$filemanager.$media_path.$sid.'" ;
                 oFCKeditor.Config["AutoDetectLanguage"] = false ;
                 oFCKeditor.Config["DefaultLanguage"] = "'.$lang.'" ;
                 oFCKeditor.ReplaceTextarea() ;
               }
             </script>';
      break;
    // WYSIWYG editor gv_mail textarea named message
    case 'gv_mail':
      $val ='<script type="text/javascript" src="'.$js_src.'"></script>
             <script type="text/javascript">
               window.onload = function() {
                 var oFCKeditor = new FCKeditor( \'message\', \'100%\', \'400\' ) ;
                 oFCKeditor.BasePath = "'.$path.'" ;
                 oFCKeditor.Config["LinkBrowserURL"] = "'.$filemanager.$file_path.$sid.'" ;
                 oFCKeditor.Config["ImageBrowserURL"] = "'.$filemanager.$image_path.$sid.'" ;
                 oFCKeditor.Config["FlashBrowserURL"] = "'.$filemanager.$flash_path.$sid.'" ;
                 oFCKeditor.Config["MediaBrowserURL"] = "'.$filemanager.$media_path.$sid.'" ;
                 oFCKeditor.Config["AutoDetectLanguage"] = false ;
                 oFCKeditor.Config["DefaultLanguage"] = "'.$lang.'" ;
                 oFCKeditor.ReplaceTextarea() ;
               }
             </script>';
      break;
	// WYSIWYG editor imageslider textarea named imagesliders_description for Imageslider (c)2008 by Hetfield - www.MerZ-IT-SerVice.de
	case 'imagesliders_description':
	  $val ='var oFCKeditor = new FCKeditor( \'imagesliders_description['.$langID.']\', \'100%\', \'300\' ) ;
	  		     oFCKeditor.BasePath = "'.$path.'" ;
			     oFCKeditor.Config["LinkBrowserURL"] = "'.$filemanager.$file_path.'" ;
			     oFCKeditor.Config["ImageBrowserURL"] = "'.$filemanager.$image_path.'" ;
			     oFCKeditor.Config["FlashBrowserURL"] = "'.$filemanager.$flash_path.'" ;
			     oFCKeditor.Config["MediaBrowserURL"] = "'.$filemanager.$media_path.'" ;
			     oFCKeditor.Config["AutoDetectLanguage"] = false ;
			     oFCKeditor.Config["DefaultLanguage"] = "'.$lang.'" ;
			     oFCKeditor.ReplaceTextarea() ;
			   ';
	  break;

  case 'indeximages_description':
    $val ='var oFCKeditor = new FCKeditor( \'indeximages_description['.$langID.']\', \'100%\', \'300\' ) ;
           oFCKeditor.BasePath = "'.$path.'" ;
           oFCKeditor.Config["LinkBrowserURL"] = "'.$filemanager.$file_path.'" ;
           oFCKeditor.Config["ImageBrowserURL"] = "'.$filemanager.$image_path.'" ;
           oFCKeditor.Config["FlashBrowserURL"] = "'.$filemanager.$flash_path.'" ;
           oFCKeditor.Config["MediaBrowserURL"] = "'.$filemanager.$media_path.'" ;
           oFCKeditor.Config["AutoDetectLanguage"] = false ;
           oFCKeditor.Config["DefaultLanguage"] = "'.$lang.'" ;
           oFCKeditor.ReplaceTextarea() ;
         ';
    break;
    
    // WYSIWYG editor shop offline
    case 'shop_offline':
      $val ='<script type="text/javascript" src="'.$js_src.'"></script>
             <script type="text/javascript">
               window.onload = function() {
                 var oFCKeditor = new FCKeditor( \'offline_msg\', \'100%\', \'400\' ) ;
                 //console.log(oFCKeditor);
                 oFCKeditor.BasePath = "'.$path.'" ;
                 oFCKeditor.Config["LinkBrowserURL"] = "'.$filemanager.$file_path.$sid.'" ;
                 oFCKeditor.Config["ImageBrowserURL"] = "'.$filemanager.$image_path.$sid.'" ;
                 oFCKeditor.Config["FlashBrowserURL"] = "'.$filemanager.$flash_path.$sid.'" ;
                 oFCKeditor.Config["MediaBrowserURL"] = "'.$filemanager.$media_path.$sid.'" ;
                 oFCKeditor.Config["AutoDetectLanguage"] = false ;
                 oFCKeditor.Config["DefaultLanguage"] = "'.$lang.'" ;
                 oFCKeditor.ReplaceTextarea() ;
               }
             </script>';
      break;
	case 'manufacturers_description':
		$val ='var oFCKeditor = new FCKeditor( \'manufacturers_description['.$langID.']\', \'100%\', \'300\' ) ;
				   oFCKeditor.BasePath = "'.$path.'" ;
				   oFCKeditor.Config["LinkBrowserURL"] = "'.$filemanager.$file_path.'" ;
				   oFCKeditor.Config["ImageBrowserURL"] = "'.$filemanager.$image_path.'" ;
				   oFCKeditor.Config["FlashBrowserURL"] = "'.$filemanager.$flash_path.'" ;
				   oFCKeditor.Config["MediaBrowserURL"] = "'.$filemanager.$media_path.'" ;
				   oFCKeditor.Config["AutoDetectLanguage"] = false ;
				   oFCKeditor.Config["DefaultLanguage"] = "'.$lang.'" ;
				   oFCKeditor.ReplaceTextarea() ;
				   ';
		break;	
	case 'manufacturers_description_more':
		$val ='var oFCKeditor = new FCKeditor( \'manufacturers_description_more['.$langID.']\', \'100%\', \'300\' ) ;
				   oFCKeditor.BasePath = "'.$path.'" ;
				   oFCKeditor.Config["LinkBrowserURL"] = "'.$filemanager.$file_path.'" ;
				   oFCKeditor.Config["ImageBrowserURL"] = "'.$filemanager.$image_path.'" ;
				   oFCKeditor.Config["FlashBrowserURL"] = "'.$filemanager.$flash_path.'" ;
				   oFCKeditor.Config["MediaBrowserURL"] = "'.$filemanager.$media_path.'" ;
				   oFCKeditor.Config["AutoDetectLanguage"] = false ;
				   oFCKeditor.Config["DefaultLanguage"] = "'.$lang.'" ;
				   oFCKeditor.ReplaceTextarea() ;
				   ';
		break;		
	case 'manufacturers_short_description':
		$val ='var oFCKeditor = new FCKeditor( \'manufacturers_short_description['.$langID.']\', \'100%\', \'300\' ) ;
				   oFCKeditor.BasePath = "'.$path.'" ;
				   oFCKeditor.Config["LinkBrowserURL"] = "'.$filemanager.$file_path.'" ;
				   oFCKeditor.Config["ImageBrowserURL"] = "'.$filemanager.$image_path.'" ;
				   oFCKeditor.Config["FlashBrowserURL"] = "'.$filemanager.$flash_path.'" ;
				   oFCKeditor.Config["MediaBrowserURL"] = "'.$filemanager.$media_path.'" ;
				   oFCKeditor.Config["AutoDetectLanguage"] = false ;
				   oFCKeditor.Config["DefaultLanguage"] = "'.$lang.'" ;
				   oFCKeditor.ReplaceTextarea() ;
				   ';
		break;
  }
	
  return $val;
}
?>
