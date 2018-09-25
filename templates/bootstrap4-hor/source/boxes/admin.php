<?php
/* -----------------------------------------------------------------------------------------
   $Id: admin.php 1262 2005-09-30 10:00:32Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com 
   (c) 2003	 nextcommerce (admin.php,v 1.12 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

// reset var
$box_smarty = new smarty;
$box_content='';
$flag='';
$box_smarty->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');

  // include needed functions
  require_once(DIR_FS_INC . 'xtc_image_button.inc.php');

  $orders_contents = '';
  
  $orders_status_validating = xtc_db_num_rows(xtc_db_query("select orders_status from " . TABLE_ORDERS ." where orders_status ='0'"));
  $orders_contents .='<a class="nav-link" href="' . xtc_href_link_admin(FILENAME_ORDERS, 'selected_box=customers&amp;status=0', 'NONSSL') . '">' . TEXT_VALIDATING . '</a>: ' . $orders_status_validating . '<br />'; //web28 - 2010-06-23 change unnecessary SSL to NONSSL
 
  
  $orders_status_query = xtc_db_query("select orders_status_name, orders_status_id from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$_SESSION['languages_id'] . "'");
  while ($orders_status = xtc_db_fetch_array($orders_status_query)) {
    $orders_pending_query = xtc_db_query("select count(*) as count from " . TABLE_ORDERS . " where orders_status = '" . $orders_status['orders_status_id'] . "'");
    $orders_pending = xtc_db_fetch_array($orders_pending_query);
    $orders_contents .= '<a href="' . xtc_href_link_admin(FILENAME_ORDERS, 'selected_box=customers&amp;status=' . $orders_status['orders_status_id'], 'NONSSL') . '">' . $orders_status['orders_status_name'] . '</a>: ' . $orders_pending['count'] . '<br />'; //web28 - 2010-06-23 change unnecessary SSL to NONSSL
  }
  $orders_contents = substr($orders_contents, 0, -6);

  $customers_query = xtc_db_query("select count(*) as count from " . TABLE_CUSTOMERS);
  $customers = xtc_db_fetch_array($customers_query);
  $products_query = xtc_db_query("select count(*) as count from " . TABLE_PRODUCTS . " where products_status = '1'");
  $products = xtc_db_fetch_array($products_query);
  $reviews_query = xtc_db_query("select count(*) as count from " . TABLE_REVIEWS);
  $reviews = xtc_db_fetch_array($reviews_query);
  $admin_image = '<a class="nav-link" href="' . xtc_href_link_admin(FILENAME_START,'', 'NONSSL').'">'.xtc_image_button('button_admin.gif', IMAGE_BUTTON_ADMIN).'</a>';  //web28 - 2010-06-23 change unnecessary SSL to NONSSL
   if ($product->isProduct()) {
    $admin_link='<a class="nav-link" href="' . xtc_href_link_admin(FILENAME_EDIT_PRODUCTS, 'cPath=' . $cPath . '&amp;pID=' . $product->data['products_id']) . '&amp;action=new_product' . '" onclick="window.open(this.href); return false;">' . xtc_image_button('edit_product.gif', IMAGE_BUTTON_PRODUCT_EDIT) . '</a>';
    } else {
    $admin_link = ''; //DokuMan  - 2010-03-23 - set undefinded variable
   }

  $box_content= '<strong>' . BOX_TITLE_STATISTICS . '</strong><br />' . $orders_contents . '<br />' .
                                         BOX_ENTRY_CUSTOMERS . ' ' . $customers['count'] . '<br />' .
                                         BOX_ENTRY_PRODUCTS . ' ' . $products['count'] . '<br />' .
                                         BOX_ENTRY_REVIEWS . ' ' . $reviews['count'] .'<br />' .
                                         $admin_image . '<br />' .$admin_link;
                                         
                                         
    $box_content = '';
    $box_content .= '<li class="nav-item"><a class="nav-link" href="' . xtc_href_link_admin(FILENAME_START,'', 'NONSSL').'">'.IMAGE_BUTTON_ADMIN.'</a></li>';
	if ($product->isProduct()) {
		$box_content .= '<li class="nav-item"><a class="nav-link" href="' . xtc_href_link_admin(FILENAME_EDIT_PRODUCTS, 'cPath=' . $cPath . '&amp;pID=' . $product->data['products_id']) . '&amp;action=new_product' . '" onclick="window.open(this.href); return false;">' . IMAGE_BUTTON_PRODUCT_EDIT . '</a></li>';
	}
        if(basename($_SERVER[SCRIPT_NAME]) == 'index.php' && isset($_GET['cPath'])){
		$box_content .= '<li class="nav-item"><a class="nav-link" href="' . xtc_href_link_admin(FILENAME_EDIT_PRODUCTS, 'cPath=' . $cPath . '&amp;cID=' . $current_category_id) . '&amp;action=edit_category' . '" onclick="window.open(this.href); return false;">' . TEXT_EDIT_CATEGORIES . '</a></li>';
	}

  if(basename($_SERVER[SCRIPT_NAME]) == 'shop_content.php' && isset($_GET['coID'])) {
    $content_manager_query = xtc_db_query("SELECT content_id FROM ".TABLE_CONTENT_MANAGER." WHERE content_group = ".$_GET['coID']." AND languages_id = ".$_SESSION['languages_id']);
    $content_manager_id = xtc_db_fetch_array($content_manager_query);
    $box_content .= '<li class="nav-item"><a href="' . xtc_href_link_admin(FILENAME_CONTENT_MANAGER) . '?action=edit&coID='.$content_manager_id['content_id']. '" onclick="window.open(this.href); return false;" class="nav-link" >' . TEXT_EDIT_CONTENT_MANAGER . '</a></li>';
  }
  if ($flag==true) define('SEARCH_ENGINE_FRIENDLY_URLS',true);
    $box_smarty->assign('BOX_CONTENT', $box_content);

    $box_smarty->caching = 0;
    $box_smarty->assign('language', $_SESSION['language']);
    $box_admin= $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_admin.html');
    $smarty->assign('box_ADMIN',$box_admin);

?>
