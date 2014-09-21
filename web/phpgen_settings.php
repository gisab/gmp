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
  'port' => '8889',
  'username' => 'admin',
  'password' => 'admin',
  'database' => 'gmp'
);
}

function HasAdminPage()
{
    return false;
}

function GetPageInfos()
{
    $result = array();
    $result[] = array('caption' => 'Product', 'short_caption' => 'Product Catalogue', 'filename' => 'product.php', 'name' => 'test');
    $result[] = array('caption' => 'Queue', 'short_caption' => 'Queue', 'filename' => 'queue.php', 'name' => 'queue');
    $result[] = array('caption' => 'Files', 'short_caption' => 'Files', 'filename' => 'files.php', 'name' => 'files');
    $result[] = array('caption' => 'Agent', 'short_caption' => 'Agent', 'filename' => 'agent.php', 'name' => 'agent');
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
        'Developed by gianluca.sabella@gmail.com'; 
    }

function ApplyCommonPageSettings(Page $page, Grid $grid)
{
    $page->SetShowUserAuthBar(false);
    $grid->BeforeUpdateRecord->AddListener('Global_BeforeUpdateHandler');
    $grid->BeforeDeleteRecord->AddListener('Global_BeforeDeleteHandler');
    $grid->BeforeInsertRecord->AddListener('Global_BeforeInsertHandler');
}

/*
  Default code page: 1252
*/
function GetAnsiEncoding() { return 'windows-1252'; }

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
