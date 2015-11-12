<?php
/* --------------------------------------------------------------
   $Id: cross_sell_groups.php 1231 2005-09-21 13:05:36Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(orders_status.php,v 1.19 2003/02/06); www.oscommerce.com 
   (c) 2003	 nextcommerce (orders_status.php,v 1.9 2003/08/18); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  switch ($_GET['action']) {
    case 'insert':
    case 'save':
      $error = array();
      $cross_sell_id = xtc_db_prepare_input($_GET['oID']);

      $languages = xtc_get_languages();
      
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $cross_sell_name_array = $_POST['cross_sell_group_name'];
        $language_id = $languages[$i]['id'];

            $check_if_name_exist = xtc_db_find_database_field_by_language(TABLE_PRODUCTS_XSELL_GROUPS, 'groupname', $cross_sell_name_array[$language_id], $language_id, 'language_id');
            if(!$cross_sell_name_array[$language_id] || $check_if_name_exist){
                $url_action = 'edit';
                if($_GET['action'] == 'save'){
                    if($check_if_name_exist['products_xsell_grp_name_id'] != $cross_sell_id){
                        $error[] = ERROR_TEXT_NAME;
                    }
                } else {
                    $url_action = 'new';
                    $error[] = ERROR_TEXT_NAME;
                }
            }  
        }
        
        
        if(empty($error)){ 
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
            $cross_sell_name_array = $_POST['cross_sell_group_name'];
            $language_id = $languages[$i]['id'];
        $sql_data_array = array('groupname' => xtc_db_prepare_input($cross_sell_name_array[$language_id]));

        if ($_GET['action'] == 'insert') {
          if (!xtc_not_null($cross_sell_id)) {
            $next_id_query = xtc_db_query("select max(products_xsell_grp_name_id) as products_xsell_grp_name_id from " . TABLE_PRODUCTS_XSELL_GROUPS . "");
            $next_id = xtc_db_fetch_array($next_id_query);
            $cross_sell_id = $next_id['products_xsell_grp_name_id'] + 1;
          }

          $insert_sql_data = array('products_xsell_grp_name_id' => $cross_sell_id,
                                   'language_id' => $language_id);
          $sql_data_array = xtc_array_merge($sql_data_array, $insert_sql_data);
          xtc_db_perform(TABLE_PRODUCTS_XSELL_GROUPS, $sql_data_array);
        } elseif ($_GET['action'] == 'save') {
			//BOF - web28 - 2010-07-11 - BUGFIX no entry stored for previous deactivated languages
			$cross_sell_query = xtc_db_query("select * from ".TABLE_PRODUCTS_XSELL_GROUPS." where language_id = '".$language_id."' and products_xsell_grp_name_id = '".xtc_db_input($cross_sell_id)."'");
			if (xtc_db_num_rows($cross_sell_query) == 0) xtc_db_perform(TABLE_PRODUCTS_XSELL_GROUPS, array ('products_xsell_grp_name_id' => xtc_db_input($cross_sell_id), 'language_id' => $language_id));
			//EOF - web28 - 2010-07-11 - BUGFIX no entry stored for previous deactivated languages
			xtc_db_perform(TABLE_PRODUCTS_XSELL_GROUPS, $sql_data_array, 'update', "products_xsell_grp_name_id = '" . xtc_db_input($cross_sell_id) . "' and language_id = '" . $language_id . "'");
        }
        
      }


      xtc_redirect(xtc_href_link(FILENAME_XSELL_GROUPS, 'page=' . $_GET['page'] . '&oID=' . $cross_sell_id));
      } else {
            $_SESSION['repopulate_form'] = $_REQUEST;
            $_SESSION['errors'] = $error;
            xtc_redirect(xtc_href_link(FILENAME_XSELL_GROUPS, 'page='.$_GET['page'].'&oID='.$cross_sell_id.'&action='.$url_action.'&errors=1'));
      }
      break;

    case 'deleteconfirm':
      $oID = xtc_db_prepare_input($_GET['oID']);

      xtc_db_query("delete from " . TABLE_PRODUCTS_XSELL_GROUPS . " where products_xsell_grp_name_id = '" . xtc_db_input($oID) . "'");

      xtc_redirect(xtc_href_link(FILENAME_XSELL_GROUPS, 'page=' . $_GET['page']));
      break;

    case 'delete':
      $oID = xtc_db_prepare_input($_GET['oID']);

      $cross_sell_query = xtc_db_query("select count(*) as count from " . TABLE_PRODUCTS_XSELL . " where products_xsell_grp_name_id = '" . xtc_db_input($oID) . "'");
      $status = xtc_db_fetch_array($cross_sell_query);

      $remove_status = true;
      if ($status['count'] > 0) {
        $remove_status = false;
        $messageStack->add(ERROR_STATUS_USED_IN_CROSS_SELLS, 'error');
      }
      break;
  }
  require (DIR_WS_INCLUDES.'head.php');
?>

</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->
<div class="row">
<!-- body //-->
    
        <div class='col-xs-12'>
            <p class="h2">
                <?php echo BOX_ORDERS_XSELL_GROUP; ?>
            </p>
            Configuration
        </div>
<?php include DIR_WS_INCLUDES.FILENAME_ERROR_DISPLAY; ?>
<div class='col-xs-12'><br></div>

            <div class='col-xs-12'>
            <div id='responsive_table' class='table-responsive pull-left col-sm-12'>
            <table class='table table-bordered'>
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_XSELL_GROUP_NAME; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $cross_sell_query_raw = "select products_xsell_grp_name_id, groupname from " . TABLE_PRODUCTS_XSELL_GROUPS . " where language_id = '" . $_SESSION['languages_id'] . "' order by products_xsell_grp_name_id";
  $cross_sell_split = new splitPageResults($_GET['page'], '20', $cross_sell_query_raw, $cross_sell_query_numrows);
  $cross_sell_query = xtc_db_query($cross_sell_query_raw);
  while ($cross_sell = xtc_db_fetch_array($cross_sell_query)) {
    if (((!$_GET['oID']) || ($_GET['oID'] == $cross_sell['products_xsell_grp_name_id'])) && (!$oInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
      $oInfo = new objectInfo($cross_sell);
    }

    if ( (is_object($oInfo)) && ($cross_sell['products_xsell_grp_name_id'] == $oInfo->products_xsell_grp_name_id) ) {
      echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'pointer\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_XSELL_GROUPS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->products_xsell_grp_name_id . '&action=edit') . '#edit-box\'">' . "\n";
    } else {
      echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'pointer\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_XSELL_GROUPS, 'page=' . $_GET['page'] . '&oID=' . $cross_sell['products_xsell_grp_name_id']) . '#edit-box\'">' . "\n";
    }

      echo '                <td class="dataTableContent">' . $cross_sell['groupname'] . '</td>' . "\n";
    
?>
<!-- BOF - Tomcraft - 2009-06-10 - added some missing alternative text on admin icons -->
<!--
                <td class="dataTableContent" align="right"><?php if ( (is_object($oInfo)) && ($cross_sell['products_xsell_grp_name_id'] == $oInfo->products_xsell_grp_name_id) ) { echo xtc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . xtc_href_link(FILENAME_XSELL_GROUPS, 'page=' . $_GET['page'] . '&oID=' . $cross_sell['products_xsell_grp_name_id']) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
-->
                <td class="dataTableContent" align="right"><?php if ( (is_object($oInfo)) && ($cross_sell['products_xsell_grp_name_id'] == $oInfo->products_xsell_grp_name_id) ) { echo xtc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ICON_ARROW_RIGHT); } else { echo '<a href="' . xtc_href_link(FILENAME_XSELL_GROUPS, 'page=' . $_GET['page'] . '&oID=' . $cross_sell['products_xsell_grp_name_id']) . '#edit-box">' . xtc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
<!-- EOF - Tomcraft - 2009-06-10 - added some missing alternative text on admin icons -->
              </tr>
<?php
  }
?>
              </table>
                  <div class="col-xs-12">
                    <div class="col-xs-6 smallText"><?php echo $cross_sell_split->display_count($cross_sell_query_numrows, '20', $_GET['page'], TEXT_DISPLAY_NUMBER_OF_XSELL_GROUP); ?></div>
                    <div class="col-xs-6 smallText"><?php echo $cross_sell_split->display_links($cross_sell_query_numrows, '20', MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
                  </div>
<?php
  if (substr($_GET['action'], 0, 3) != 'new') {
?>
                  <div class="col-xs-12">
                    <?php echo '<a class="btn btn-default pull-right" onclick="this.blur();" href="' . xtc_href_link(FILENAME_XSELL_GROUPS, 'page=' . $_GET['page'] . '&action=new') . '">' . BUTTON_INSERT . '</a>'; ?>
                  </div>
<?php
  }
?>
              </div>
<?php
  $heading = array();
  $contents = array();
  switch ($_GET['action']) {
    case 'new':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_XSELL_GROUP . '</b>');

      $contents = array('form' => xtc_draw_form('status', FILENAME_XSELL_GROUPS, 'page=' . $_GET['page'] . '&action=insert'));
      $contents[] = array('text' => TEXT_INFO_INSERT_INTRO);

      $cross_sell_inputs_string = '';
      $languages = xtc_get_languages();
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        if(isset($_SESSION['repopulate_form'])){
            $c_name = ($_SESSION['repopulate_form']['cross_sell_group_name'][$languages[$i]['id']]) ? $_SESSION['repopulate_form']['cross_sell_group_name'][$languages[$i]['id']] : '';
        }
        $cross_sell_inputs_string .= '<br />' . xtc_image(DIR_WS_LANGUAGES.$languages[$i]['directory'].'/admin/images/'.$languages[$i]['image']) . '&nbsp;' . xtc_draw_input_field('cross_sell_group_name[' . $languages[$i]['id'] . ']', $c_name);
      }
      if(isset($_SESSION['repopulate_form'])){
            unset($_SESSION['repopulate_form']);
      }

      $contents[] = array('text' => '<br />' . TEXT_INFO_XSELL_GROUP_NAME . $cross_sell_inputs_string);
      $contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="btn btn-default" onclick="this.blur();" value="' . BUTTON_INSERT . '"/> <a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_XSELL_GROUPS, 'page=' . $_GET['page']) . '">' . BUTTON_CANCEL . '</a>');
      break;

    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_XSELL_GROUP . '</b>');

      $contents = array('form' => xtc_draw_form('status', FILENAME_XSELL_GROUPS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->products_xsell_grp_name_id  . '&action=save'));
      $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);

      $cross_sell_inputs_string = '';
      $languages = xtc_get_languages();
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $cross_sell_inputs_string .= '<br />' . xtc_image(DIR_WS_LANGUAGES.$languages[$i]['directory'].'/admin/images/'.$languages[$i]['image']) . '&nbsp;' . xtc_draw_input_field('cross_sell_group_name[' . $languages[$i]['id'] . ']', xtc_get_cross_sell_name($oInfo->products_xsell_grp_name_id, $languages[$i]['id']));
      }

      $contents[] = array('text' => '<br />' . TEXT_INFO_XSELL_GROUP_NAME . $cross_sell_inputs_string);
      $contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="btn btn-default" onclick="this.blur();" value="' . BUTTON_UPDATE . '"/> <a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_XSELL_GROUPS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->products_xsell_grp_name_id) . '">' . BUTTON_CANCEL . '</a>');
      break;

    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_XSELL_GROUP . '</b>');

      $contents = array('form' => xtc_draw_form('status', FILENAME_XSELL_GROUPS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->products_xsell_grp_name_id  . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $oInfo->orders_status_name . '</b>');
      if ($remove_status) $contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="btn btn-default" onclick="this.blur();" value="' . BUTTON_DELETE . '"/> <a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_XSELL_GROUPS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->products_xsell_grp_name_id) . '">' . BUTTON_CANCEL . '</a>');
      break;

    default:
      if (is_object($oInfo)) {
        $heading[] = array('text' => '<b>' . $oInfo->groupname . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_XSELL_GROUPS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->products_xsell_grp_name_id . '&action=edit') . '#edit-box">' . BUTTON_EDIT . '</a> <a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_XSELL_GROUPS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->products_xsell_grp_name_id . '&action=delete') . '#edit-box">' . BUTTON_DELETE . '</a>');

        $cross_sell_inputs_string = '';
        $languages = xtc_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $cross_sell_inputs_string .= '<br />' . xtc_image(DIR_WS_LANGUAGES.$languages[$i]['directory'].'/admin/images/'.$languages[$i]['image']) . '&nbsp;' . xtc_get_cross_sell_name($oInfo->products_xsell_grp_name_id, $languages[$i]['id']);
        }

        $contents[] = array('text' => $cross_sell_inputs_string);
      }
      break;
  }

  if ( (xtc_not_null($heading)) && (xtc_not_null($contents)) ) {
    echo '            <div class="col-md-3 col-sm-12 col-xs-12 pull-right edit-box-class">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </div>' . "\n";
            ?>
    <script>
        //responsive_table
        $('#responsive_table').addClass('col-md-9');
    </script>               
    <?php
  }
?>
</div>          
</div>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>