<?php

//  define('SHOW_VARIABLES', 1);
//  define('DEBUG_LEVEL', 1);

//  error_reporting(E_ALL ^ E_NOTICE);
//  ini_set('display_errors', 'On');

set_include_path('.' . PATH_SEPARATOR . get_include_path());


include_once dirname(__FILE__) . '/' . 'components/utils/system_utils.php';

//  SystemUtils::DisableMagicQuotesRuntime();

SystemUtils::SetTimeZoneIfNeed('Europe/Belgrade');

function GetGlobalConnectionOptions()
{
    return array(
  'server' => '127.0.0.1',
  'port' => '3306',
  'username' => 'gmp',
  'password' => 'gmp',
  'database' => 'gmp'
);
}

function HasAdminPage()
{
    return false;
}

function GetPageGroups()
{
    $result = array('Default', 'uno');
    return $result;
}

function GetPageInfos()
{
    $result = array();
    $result[] = array('caption' => 'Product Catalogue', 'short_caption' => 'Product Catalogue', 'filename' => 'product.php', 'name' => 'qProduct', 'group_name' => 'Default', 'add_separator' => false);
    $result[] = array('caption' => 'Product_old', 'short_caption' => 'Product Catalogue Old', 'filename' => 'productold.php', 'name' => 'test', 'group_name' => 'Default', 'add_separator' => false);
    $result[] = array('caption' => 'Target', 'short_caption' => 'Target', 'filename' => 'target.php', 'name' => 'target', 'group_name' => 'Default', 'add_separator' => false);
    $result[] = array('caption' => 'Country', 'short_caption' => 'Country', 'filename' => 'country.php', 'name' => 'vcountry', 'group_name' => 'Default', 'add_separator' => false);
    $result[] = array('caption' => 'Queue', 'short_caption' => 'Queue', 'filename' => 'queue.php', 'name' => 'queue', 'group_name' => 'Default', 'add_separator' => false);
    $result[] = array('caption' => 'Files', 'short_caption' => 'Files', 'filename' => 'files.php', 'name' => 'files', 'group_name' => 'Default', 'add_separator' => false);
    $result[] = array('caption' => 'Agent', 'short_caption' => 'Agent', 'filename' => 'agent.php', 'name' => 'agent', 'group_name' => 'Default', 'add_separator' => true);
    $result[] = array('caption' => 'Statistics', 'short_caption' => 'Statistics', 'filename' => 'vqueue_stats.php', 'name' => 'vqueue_stats', 'group_name' => 'Default', 'add_separator' => false);
    $result[] = array('caption' => 'Errors', 'short_caption' => 'Errors', 'filename' => 'vqueue_nok.php', 'name' => 'vqueue_nok', 'group_name' => 'uno', 'add_separator' => false);
    $result[] = array('caption' => 'Last Hour', 'short_caption' => 'Queue changed in the Last hour', 'filename' => 'vqueue_lasthour.php', 'name' => 'vqueue_lasthour', 'group_name' => 'uno', 'add_separator' => false);
    $result[] = array('caption' => 'Downloading', 'short_caption' => 'Downloading queue', 'filename' => 'vqueue_downloading.php', 'name' => 'vqueue_downloading', 'group_name' => 'Default', 'add_separator' => false);
    return $result;
}

function GetPagesHeader()
{
    return
    '<h2>Get My Products</h2>
<h3><i>> Download and Catalogue Sentinels Imagery</i></h3>';
}

function GetPagesFooter()
{
    return
        'GMP Copyright (C) 2014 Gianluca Sabella <br>
Developed by gianluca.sabella@gmail.com and distributed under the GPL.
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" style="width:90px;" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" width="1" height="1" >
</form>'; 
    }

function ApplyCommonPageSettings(Page $page, Grid $grid)
{
    $page->SetShowUserAuthBar(false);
    $page->OnCustomHTMLHeader->AddListener('Global_CustomHTMLHeaderHandler');
    $page->OnGetCustomTemplate->AddListener('Global_GetCustomTemplateHandler');
    $grid->BeforeUpdateRecord->AddListener('Global_BeforeUpdateHandler');
    $grid->BeforeDeleteRecord->AddListener('Global_BeforeDeleteHandler');
    $grid->BeforeInsertRecord->AddListener('Global_BeforeInsertHandler');
}

/*
  Default code page: 1252
*/
function GetAnsiEncoding() { return 'windows-1252'; }

function Global_CustomHTMLHeaderHandler($page, &$customHtmlHeaderText)
{

}

function Global_GetCustomTemplateHandler($part, $mode, &$result, &$params)
{

}

function Global_BeforeUpdateHandler($page, $rowData, &$cancel, &$message, $tableName)
{

}

function Global_BeforeDeleteHandler($page, $rowData, &$cancel, &$message, $tableName)
{

}

function Global_BeforeInsertHandler($page, $rowData, &$cancel, &$message, $tableName)
{

}

function GetDefaultDateFormat()
{
    return 'Y-m-d';
}

function GetFirstDayOfWeek()
{
    return 0;
}

function GetEnableLessFilesRunTimeCompilation()
{
    return false;
}



?>