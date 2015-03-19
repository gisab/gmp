<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                   ATTENTION!
 * If you see this message in your browser (Internet Explorer, Mozilla Firefox, Google Chrome, etc.)
 * this means that PHP is not properly installed on your web server. Please refer to the PHP manual
 * for more details: http://php.net/manual/install.php 
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */


    include_once dirname(__FILE__) . '/' . 'components/utils/check_utils.php';
    CheckPHPVersion();
    CheckTemplatesCacheFolderIsExistsAndWritable();


    include_once dirname(__FILE__) . '/' . 'phpgen_settings.php';
    include_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';
    include_once dirname(__FILE__) . '/' . 'components/page.php';


    function GetConnectionOptions()
    {
        $result = GetGlobalConnectionOptions();
        $result['client_encoding'] = 'utf8';
        GetApplication()->GetUserAuthorizationStrategy()->ApplyIdentityToConnectionOptions($result);
        return $result;
    }

    
    
    // OnBeforePageExecute event handler
    
    
    
    class filesDetailView0queuePage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`files`');
            $field = new IntegerField('id', null, null, true);
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new StringField('qid');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('filename');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('url');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('dwnstatus');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new DateTimeField('LAST_UPDATE');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('targetid');
            $this->dataset->AddField($field, false);
        }
    
        protected function AddFieldColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'Id', $this->dataset);
            $grid->SetTotal($column, PredefinedAggregate::$Sum);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for filename field
            //
            $column = new TextViewColumn('filename', 'Filename', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('filesDetailViewGrid0queue_filename_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for url field
            //
            $column = new TextViewColumn('url', 'Url', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('filesDetailViewGrid0queue_url_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
        }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'filesDetailViewGrid0queue');
            $result->SetAllowDeleteSelected(false);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
            $this->AddFieldColumns($result);
            //
            // View column for filename field
            //
            $column = new TextViewColumn('filename', 'Filename', $this->dataset);
            $column->SetOrderable(false);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'filesDetailViewGrid0queue_filename_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for url field
            //
            $column = new TextViewColumn('url', 'Url', $this->dataset);
            $column->SetOrderable(false);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'filesDetailViewGrid0queue_url_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            return $result;
        }
    }
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class filesDetailEdit0queuePage extends DetailPageEdit
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`files`');
            $field = new IntegerField('id', null, null, true);
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new StringField('qid');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('filename');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('url');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('dwnstatus');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new DateTimeField('LAST_UPDATE');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('targetid');
            $this->dataset->AddField($field, false);
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(100);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        public function GetPageList()
        {
            return null;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function CreateGridSearchControl(Grid $grid)
        {
            $grid->UseFilter = true;
            $grid->SearchControl = new SimpleSearch('filesDetailEdit0queuessearch', $this->dataset,
                array('id', 'filename', 'url'),
                array($this->RenderText('Id'), $this->RenderText('Filename'), $this->RenderText('Url')),
                array(
                    '=' => $this->GetLocalizerCaptions()->GetMessageString('equals'),
                    '<>' => $this->GetLocalizerCaptions()->GetMessageString('doesNotEquals'),
                    '<' => $this->GetLocalizerCaptions()->GetMessageString('isLessThan'),
                    '<=' => $this->GetLocalizerCaptions()->GetMessageString('isLessThanOrEqualsTo'),
                    '>' => $this->GetLocalizerCaptions()->GetMessageString('isGreaterThan'),
                    '>=' => $this->GetLocalizerCaptions()->GetMessageString('isGreaterThanOrEqualsTo'),
                    'ILIKE' => $this->GetLocalizerCaptions()->GetMessageString('Like'),
                    'STARTS' => $this->GetLocalizerCaptions()->GetMessageString('StartsWith'),
                    'ENDS' => $this->GetLocalizerCaptions()->GetMessageString('EndsWith'),
                    'CONTAINS' => $this->GetLocalizerCaptions()->GetMessageString('Contains')
                    ), $this->GetLocalizerCaptions(), $this, 'CONTAINS'
                );
        }
    
        protected function CreateGridAdvancedSearchControl(Grid $grid)
        {
            $this->AdvancedSearchControl = new AdvancedSearchControl('filesDetailEdit0queueasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->setTimerInterval(1000);
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('id', $this->RenderText('Id')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('filename', $this->RenderText('Filename')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('url', $this->RenderText('Url')));
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actionsBandName = 'actions';
            $grid->AddBandToBegin($actionsBandName, $this->GetLocalizerCaptions()->GetMessageString('Actions'), true);
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $column = new ModalDialogViewRowColumn(
                    $this->GetLocalizerCaptions()->GetMessageString('View'), $this->dataset,
                    $this->GetLocalizerCaptions()->GetMessageString('View'),
                    $this->GetModalGridViewHandler());
                $grid->AddViewColumn($column, $actionsBandName);
                $column->SetImagePath('images/view_action.png');
            }
        }
    
        protected function AddFieldColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'Id', $this->dataset);
            $grid->SetTotal($column, PredefinedAggregate::$Sum);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for filename field
            //
            $column = new TextViewColumn('filename', 'Filename', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('filesDetailEditGrid0queue_filename_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for url field
            //
            $column = new TextViewColumn('url', 'Url', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('filesDetailEditGrid0queue_url_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for filename field
            //
            $column = new TextViewColumn('filename', 'Filename', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('filesDetailEditGrid0queue_filename_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for url field
            //
            $column = new TextViewColumn('url', 'Url', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('filesDetailEditGrid0queue_url_handler_view');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for filename field
            //
            $editor = new TextAreaEdit('filename_edit', 50, 8);
            $editColumn = new CustomEditColumn('Filename', 'filename', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for url field
            //
            $editor = new TextAreaEdit('url_edit', 50, 8);
            $editColumn = new CustomEditColumn('Url', 'url', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for filename field
            //
            $editor = new TextAreaEdit('filename_edit', 50, 8);
            $editColumn = new CustomEditColumn('Filename', 'filename', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for url field
            //
            $editor = new TextAreaEdit('url_edit', 50, 8);
            $editColumn = new CustomEditColumn('Url', 'url', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $grid->SetShowAddButton(false);
                $grid->SetShowInlineAddButton(false);
            }
            else
            {
                $grid->SetShowInlineAddButton(false);
                $grid->SetShowAddButton(false);
            }
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for filename field
            //
            $column = new TextViewColumn('filename', 'Filename', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for url field
            //
            $column = new TextViewColumn('url', 'Url', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for filename field
            //
            $column = new TextViewColumn('filename', 'Filename', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for url field
            //
            $column = new TextViewColumn('url', 'Url', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
        	$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        public function GetModalGridViewHandler() { return 'filesDetailEdit0queue_inline_record_view'; }
        protected function GetEnableModalSingleRecordView() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'filesDetailEditGrid0queue');
            if ($this->GetSecurityInfo()->HasDeleteGrant())
                $result->SetAllowDeleteSelected(false);
            else
                $result->SetAllowDeleteSelected(false);
            ApplyCommonPageSettings($this, $result);
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
            $this->CreateGridSearchControl($result);
            $this->CreateGridAdvancedSearchControl($result);
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
    
            $this->SetShowPageList(true);
            $this->SetHidePageListByDefault(false);
            $this->SetExportToExcelAvailable(true);
            $this->SetExportToWordAvailable(true);
            $this->SetExportToXmlAvailable(true);
            $this->SetExportToCsvAvailable(true);
            $this->SetExportToPdfAvailable(true);
            $this->SetPrinterFriendlyAvailable(true);
            $this->SetSimpleSearchAvailable(true);
            $this->SetAdvancedSearchAvailable(true);
            $this->SetFilterRowAvailable(true);
            $this->SetVisualEffectsEnabled(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
    
            //
            // Http Handlers
            //
            //
            // View column for filename field
            //
            $column = new TextViewColumn('filename', 'Filename', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'filesDetailEditGrid0queue_filename_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for url field
            //
            $column = new TextViewColumn('url', 'Url', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'filesDetailEditGrid0queue_url_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for filename field
            //
            $column = new TextViewColumn('filename', 'Filename', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'filesDetailEditGrid0queue_filename_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for url field
            //
            $column = new TextViewColumn('url', 'Url', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'filesDetailEditGrid0queue_url_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            return $result;
        }
        
        public function OpenAdvancedSearchByDefault()
        {
            return false;
        }
    
        protected function DoGetGridHeader()
        {
            return '';
        }    
    }
    
    // OnBeforePageExecute event handler
    
    
    
    class queuePage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`queue`');
            $field = new StringField('id');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new StringField('note');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('status');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('dwnstatus');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new DateTimeField('LAST_UPDATE');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('pid');
            $this->dataset->AddField($field, false);
            $field = new StringField('agentid');
            $this->dataset->AddField($field, false);
            $field = new StringField('targetid');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new StringField('finstatus');
            $this->dataset->AddField($field, false);
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new CustomPageNavigator('partition', $this, $this->GetDataset(), $this->RenderText('Status'), $result, 'partition');
            $partitionNavigator->OnGetPartitions->AddListener('partition_OnGetPartitions', $this);
            $partitionNavigator->OnGetPartitionCondition->AddListener('partition_OnGetPartitionCondition', $this);
            $partitionNavigator->SetAllowViewAllRecords(true);
            $partitionNavigator->SetNavigationStyle(NS_LIST);
            $result->AddPageNavigator($partitionNavigator);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(100);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        public function GetPageList()
        {
            $currentPageCaption = $this->GetShortCaption();
            $result = new PageList($this);
            $result->AddGroup('Catalogue');
            $result->AddGroup('Queue');
            $result->AddGroup('Statistics');
            if (GetCurrentUserGrantForDataSource('qProduct')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Product Catalogue'), 'product.php', $this->RenderText('Product Catalogue'), $currentPageCaption == $this->RenderText('Product Catalogue'), false, 'Catalogue'));
            if (GetCurrentUserGrantForDataSource('vslc')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('SLC'), 'vslc.php', $this->RenderText('SLC Groups'), $currentPageCaption == $this->RenderText('SLC'), false, 'Catalogue'));
            if (GetCurrentUserGrantForDataSource('varea')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Area'), 'area.php', $this->RenderText('Area'), $currentPageCaption == $this->RenderText('Area'), false, 'Catalogue'));
            if (GetCurrentUserGrantForDataSource('queue')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Queue'), 'queue.php', $this->RenderText('Queue'), $currentPageCaption == $this->RenderText('Queue'), true, 'Queue'));
            if (GetCurrentUserGrantForDataSource('target')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Target'), 'target.php', $this->RenderText('Target'), $currentPageCaption == $this->RenderText('Target'), false, 'Queue'));
            if (GetCurrentUserGrantForDataSource('agent')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Agent'), 'agent.php', $this->RenderText('Agent'), $currentPageCaption == $this->RenderText('Agent'), false, 'Queue'));
            if (GetCurrentUserGrantForDataSource('rule')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Rule'), 'rule.php', $this->RenderText('Rule'), $currentPageCaption == $this->RenderText('Rule'), false, 'Queue'));
            if (GetCurrentUserGrantForDataSource('vqueue_stats')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Statistics'), 'vqueue_stats.php', $this->RenderText('Statistics'), $currentPageCaption == $this->RenderText('Statistics'), true, 'Statistics'));
            if (GetCurrentUserGrantForDataSource('vqueue_lasthour')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Last Hour'), 'vqueue_lasthour.php', $this->RenderText('Queue changed in the Last hour'), $currentPageCaption == $this->RenderText('Last Hour'), false, 'Statistics'));
            if (GetCurrentUserGrantForDataSource('vqueue_nok')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Errors'), 'vqueue_nok.php', $this->RenderText('Errors'), $currentPageCaption == $this->RenderText('Errors'), false, 'Statistics'));
            if (GetCurrentUserGrantForDataSource('vqueue_downloading')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Downloading'), 'vqueue_downloading.php', $this->RenderText('Downloading queue'), $currentPageCaption == $this->RenderText('Downloading'), false, 'Statistics'));
            
            if ( HasAdminPage() && GetApplication()->HasAdminGrantForCurrentUser() ) {
              $result->AddGroup('Admin area');
              $result->AddPage(new PageLink($this->GetLocalizerCaptions()->GetMessageString('AdminPage'), 'phpgen_admin.php', $this->GetLocalizerCaptions()->GetMessageString('AdminPage'), false, false, 'Admin area'));
            }
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function CreateGridSearchControl(Grid $grid)
        {
            $grid->UseFilter = true;
            $grid->SearchControl = new SimpleSearch('queuessearch', $this->dataset,
                array('id', 'note', 'status', 'pid', 'agentid', 'targetid', 'LAST_UPDATE', 'dwnstatus'),
                array($this->RenderText('Id'), $this->RenderText('Note'), $this->RenderText('Status'), $this->RenderText('Pid'), $this->RenderText('Agentid'), $this->RenderText('Targetid'), $this->RenderText('LAST UPDATE'), $this->RenderText('Dwnstatus')),
                array(
                    '=' => $this->GetLocalizerCaptions()->GetMessageString('equals'),
                    '<>' => $this->GetLocalizerCaptions()->GetMessageString('doesNotEquals'),
                    '<' => $this->GetLocalizerCaptions()->GetMessageString('isLessThan'),
                    '<=' => $this->GetLocalizerCaptions()->GetMessageString('isLessThanOrEqualsTo'),
                    '>' => $this->GetLocalizerCaptions()->GetMessageString('isGreaterThan'),
                    '>=' => $this->GetLocalizerCaptions()->GetMessageString('isGreaterThanOrEqualsTo'),
                    'ILIKE' => $this->GetLocalizerCaptions()->GetMessageString('Like'),
                    'STARTS' => $this->GetLocalizerCaptions()->GetMessageString('StartsWith'),
                    'ENDS' => $this->GetLocalizerCaptions()->GetMessageString('EndsWith'),
                    'CONTAINS' => $this->GetLocalizerCaptions()->GetMessageString('Contains')
                    ), $this->GetLocalizerCaptions(), $this, 'CONTAINS'
                );
        }
    
        protected function CreateGridAdvancedSearchControl(Grid $grid)
        {
            $this->AdvancedSearchControl = new AdvancedSearchControl('queueasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->setTimerInterval(3000);
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('id', $this->RenderText('Id')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('note', $this->RenderText('Note')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('status', $this->RenderText('Status')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('pid', $this->RenderText('Pid')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('agentid', $this->RenderText('Agentid')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('targetid', $this->RenderText('Targetid')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateDateTimeSearchInput('LAST_UPDATE', $this->RenderText('LAST UPDATE')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('dwnstatus', $this->RenderText('Dwnstatus')));
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actionsBandName = 'actions';
            $grid->AddBandToBegin($actionsBandName, $this->GetLocalizerCaptions()->GetMessageString('Actions'), true);
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $column = new ModalDialogViewRowColumn(
                    $this->GetLocalizerCaptions()->GetMessageString('View'), $this->dataset,
                    $this->GetLocalizerCaptions()->GetMessageString('View'),
                    $this->GetModalGridViewHandler());
                $grid->AddViewColumn($column, $actionsBandName);
                $column->SetImagePath('images/view_action.png');
            }
        }
    
        protected function AddFieldColumns(Grid $grid)
        {
            if (GetCurrentUserGrantForDataSource('queue.files')->HasViewGrant())
            {
              //
            // View column for filesDetailView0queue detail
            //
            $column = new DetailColumn(array('id'), 'detail0queue', 'filesDetailEdit0queue_handler', 'filesDetailView0queue_handler', $this->dataset, 'Files', $this->RenderText('Files'));
              $grid->AddViewColumn($column);
            }
            
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('queueGrid_id_handler_list');
            $column->SetDescription($this->RenderText('client id'));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for note field
            //
            $column = new TextViewColumn('note', 'Note', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $column->SetFullTextWindowHandlerName('queueGrid_note_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth('20px');
            $grid->AddViewColumn($column);
            
            //
            // View column for status field
            //
            $column = new TextViewColumn('status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for pid field
            //
            $column = new TextViewColumn('pid', 'Pid', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for agentid field
            //
            $column = new TextViewColumn('agentid', 'Agentid', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for targetid field
            //
            $column = new TextViewColumn('targetid', 'Targetid', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for LAST_UPDATE field
            //
            $column = new DateTimeViewColumn('LAST_UPDATE', 'LAST UPDATE', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for dwnstatus field
            //
            $column = new TextViewColumn('dwnstatus', 'Dwnstatus', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('queueGrid_id_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for note field
            //
            $column = new TextViewColumn('note', 'Note', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $column->SetFullTextWindowHandlerName('queueGrid_note_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for status field
            //
            $column = new TextViewColumn('status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for pid field
            //
            $column = new TextViewColumn('pid', 'Pid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for agentid field
            //
            $column = new TextViewColumn('agentid', 'Agentid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for targetid field
            //
            $column = new TextViewColumn('targetid', 'Targetid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for LAST_UPDATE field
            //
            $column = new DateTimeViewColumn('LAST_UPDATE', 'LAST UPDATE', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for dwnstatus field
            //
            $column = new TextViewColumn('dwnstatus', 'Dwnstatus', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for id field
            //
            $editor = new TextAreaEdit('id_edit', 50, 8);
            $editColumn = new CustomEditColumn('Id', 'id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for note field
            //
            $editor = new TextAreaEdit('note_edit', 50, 8);
            $editColumn = new CustomEditColumn('Note', 'note', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for status field
            //
            $editor = new TextEdit('status_edit');
            $editor->SetSize(8);
            $editor->SetMaxLength(8);
            $editColumn = new CustomEditColumn('Status', 'status', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for pid field
            //
            $editor = new TextEdit('pid_edit');
            $editor->SetSize(8);
            $editor->SetMaxLength(8);
            $editColumn = new CustomEditColumn('Pid', 'pid', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for agentid field
            //
            $editor = new TextEdit('agentid_edit');
            $editor->SetSize(10);
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Agentid', 'agentid', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for targetid field
            //
            $editor = new TextEdit('targetid_edit');
            $editor->SetSize(10);
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Targetid', 'targetid', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for LAST_UPDATE field
            //
            $editor = new DateTimeEdit('last_update_edit', true, 'Y-m-d H:i:s', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('LAST UPDATE', 'LAST_UPDATE', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for dwnstatus field
            //
            $editor = new ComboBox('dwnstatus_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->AddValue('N', $this->RenderText('N'));
            $editor->AddValue('C', $this->RenderText('C'));
            $editor->AddValue('Q', $this->RenderText('Q'));
            $editColumn = new CustomEditColumn('Dwnstatus', 'dwnstatus', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for id field
            //
            $editor = new TextAreaEdit('id_edit', 50, 8);
            $editColumn = new CustomEditColumn('Id', 'id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for note field
            //
            $editor = new TextAreaEdit('note_edit', 50, 8);
            $editColumn = new CustomEditColumn('Note', 'note', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for status field
            //
            $editor = new TextEdit('status_edit');
            $editor->SetSize(8);
            $editor->SetMaxLength(8);
            $editColumn = new CustomEditColumn('Status', 'status', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for pid field
            //
            $editor = new TextEdit('pid_edit');
            $editor->SetSize(8);
            $editor->SetMaxLength(8);
            $editColumn = new CustomEditColumn('Pid', 'pid', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for agentid field
            //
            $editor = new TextEdit('agentid_edit');
            $editor->SetSize(10);
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Agentid', 'agentid', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for targetid field
            //
            $editor = new TextEdit('targetid_edit');
            $editor->SetSize(10);
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Targetid', 'targetid', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for LAST_UPDATE field
            //
            $editor = new DateTimeEdit('last_update_edit', true, 'Y-m-d H:i:s', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('LAST UPDATE', 'LAST_UPDATE', $editor, $this->dataset);
            $editColumn->SetAllowSetToDefault(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for dwnstatus field
            //
            $editor = new ComboBox('dwnstatus_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->AddValue('N', $this->RenderText('N'));
            $editor->AddValue('C', $this->RenderText('C'));
            $editor->AddValue('Q', $this->RenderText('Q'));
            $editColumn = new CustomEditColumn('Dwnstatus', 'dwnstatus', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $grid->SetShowAddButton(false);
                $grid->SetShowInlineAddButton(false);
            }
            else
            {
                $grid->SetShowInlineAddButton(false);
                $grid->SetShowAddButton(false);
            }
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for note field
            //
            $column = new TextViewColumn('note', 'Note', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for status field
            //
            $column = new TextViewColumn('status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for pid field
            //
            $column = new TextViewColumn('pid', 'Pid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for agentid field
            //
            $column = new TextViewColumn('agentid', 'Agentid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for targetid field
            //
            $column = new TextViewColumn('targetid', 'Targetid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for LAST_UPDATE field
            //
            $column = new DateTimeViewColumn('LAST_UPDATE', 'LAST UPDATE', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for dwnstatus field
            //
            $column = new TextViewColumn('dwnstatus', 'Dwnstatus', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for note field
            //
            $column = new TextViewColumn('note', 'Note', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for status field
            //
            $column = new TextViewColumn('status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for pid field
            //
            $column = new TextViewColumn('pid', 'Pid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for agentid field
            //
            $column = new TextViewColumn('agentid', 'Agentid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for targetid field
            //
            $column = new TextViewColumn('targetid', 'Targetid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for LAST_UPDATE field
            //
            $column = new DateTimeViewColumn('LAST_UPDATE', 'LAST UPDATE', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for dwnstatus field
            //
            $column = new TextViewColumn('dwnstatus', 'Dwnstatus', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function CreateMasterDetailRecordGridForfilesDetailEdit0queueGrid()
        {
            $result = new Grid($this, $this->dataset, 'MasterDetailRecordGridForfilesDetailEdit0queue');
            $result->SetAllowDeleteSelected(false);
            $result->OnCustomRenderColumn->AddListener('MasterDetailRecordGridForfilesDetailEdit0queue' . '_' . 'OnCustomRenderColumn', $this);
            $result->SetShowFilterBuilder(false);
            $result->SetAdvancedSearchAvailable(false);
            $result->SetFilterRowAvailable(false);
            $result->SetShowUpdateLink(false);
            $result->SetEnabledInlineEditing(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetName('master_grid');
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('queueGrid_id_handler_list');
            $column->SetDescription($this->RenderText('client id'));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for note field
            //
            $column = new TextViewColumn('note', 'Note', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $column->SetFullTextWindowHandlerName('queueGrid_note_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth('20px');
            $result->AddViewColumn($column);
            
            //
            // View column for status field
            //
            $column = new TextViewColumn('status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for pid field
            //
            $column = new TextViewColumn('pid', 'Pid', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for agentid field
            //
            $column = new TextViewColumn('agentid', 'Agentid', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for targetid field
            //
            $column = new TextViewColumn('targetid', 'Targetid', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for LAST_UPDATE field
            //
            $column = new DateTimeViewColumn('LAST_UPDATE', 'LAST UPDATE', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for dwnstatus field
            //
            $column = new TextViewColumn('dwnstatus', 'Dwnstatus', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for note field
            //
            $column = new TextViewColumn('note', 'Note', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for status field
            //
            $column = new TextViewColumn('status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for pid field
            //
            $column = new TextViewColumn('pid', 'Pid', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for agentid field
            //
            $column = new TextViewColumn('agentid', 'Agentid', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for targetid field
            //
            $column = new TextViewColumn('targetid', 'Targetid', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for LAST_UPDATE field
            //
            $column = new DateTimeViewColumn('LAST_UPDATE', 'LAST UPDATE', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for dwnstatus field
            //
            $column = new TextViewColumn('dwnstatus', 'Dwnstatus', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            return $result;
        }
        
        function MasterDetailRecordGridForfilesDetailEdit0queue_OnCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        {
            if ($fieldName == 'dwnstatus')
            {
                $customText = '<div class="queue_dwnstatus_value" style="display: none;">'.$fieldData.'</div>';
                $customText .= 
                '<span class="queue_dwnstatus_caption" style="margin-right: 20px;">' . 
                    ($fieldData == 'Q' ? 'Queued':'') .
                    ($fieldData == 'C' ? 'Completed':'') .
                    ($fieldData == 'N' ? 'Not queued':'') .
                '</span>';
                if ($fieldData == 'N') {
                $customText .= 
                '<button onclick="' . 
                    "var dwnstatusValue = $(this).siblings('.queue_dwnstatus_value');\n" . 
                    "var dwnstatusCaption = $(this).siblings('.queue_dwnstatus_caption');\n"  .
                    "$.getJSON(
                    'queue_status.php?id=" . $rowData['id'] . 
                        "&dwnstatus=Q', " . 
                    "function(data) { " . 
                        "var newval=(data.dwnstatus == 'Q' ? 'Queued':'')+(data.dwnstatus == 'C' ? 'Completed':'')+(data.dwnstatus == 'N' ? 'Not queued':'');".
                        "dwnstatusValue.html(newval);" . 
                        "dwnstatusCaption.html(newval)" . 
                    "});" . 
                    "return false;". 
                '">enqueue</button>';
                }
                if ($fieldData == 'Q') {
                $customText .= 
                '<button onclick="' . 
                    "var dwnstatusValue = $(this).siblings('.queue_dwnstatus_value');" . 
                    "var dwnstatusCaption = $(this).siblings('.queue_dwnstatus_caption');"  .
                    "$.getJSON(
                    'queue_status.php?id=" . $rowData['id'] . 
                        "&dwnstatus=N', " . 
                    "function(data) { " . 
                        "var newval=(data.dwnstatus == 'Q' ? 'Queued':'')+(data.dwnstatus == 'C' ? 'Completed':'')+(data.dwnstatus == 'N' ? 'Not queued':'');".
                        "dwnstatusValue.html(newval);" . 
                        "dwnstatusCaption.html(newval)" . 
                    "});" . 
                    "return false;". 
                '">dequeue</button>';
                }
                $handled = true;
            }
        }
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        function queueGrid_OnCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        {
            if ($fieldName == 'dwnstatus')
            {
                $customText = '<div class="queue_dwnstatus_value" style="display: none;">'.$fieldData.'</div>';
                $customText .= 
                '<span class="queue_dwnstatus_caption" style="margin-right: 20px;">' . 
                    ($fieldData == 'Q' ? 'Queued':'') .
                    ($fieldData == 'C' ? 'Completed':'') .
                    ($fieldData == 'N' ? 'Not queued':'') .
                '</span>';
                if ($fieldData == 'N') {
                $customText .= 
                '<button onclick="' . 
                    "var dwnstatusValue = $(this).siblings('.queue_dwnstatus_value');\n" . 
                    "var dwnstatusCaption = $(this).siblings('.queue_dwnstatus_caption');\n"  .
                    "$.getJSON(
                    'queue_status.php?id=" . $rowData['id'] . 
                        "&dwnstatus=Q', " . 
                    "function(data) { " . 
                        "var newval=(data.dwnstatus == 'Q' ? 'Queued':'')+(data.dwnstatus == 'C' ? 'Completed':'')+(data.dwnstatus == 'N' ? 'Not queued':'');".
                        "dwnstatusValue.html(newval);" . 
                        "dwnstatusCaption.html(newval)" . 
                    "});" . 
                    "return false;". 
                '">enqueue</button>';
                }
                if ($fieldData == 'Q') {
                $customText .= 
                '<button onclick="' . 
                    "var dwnstatusValue = $(this).siblings('.queue_dwnstatus_value');" . 
                    "var dwnstatusCaption = $(this).siblings('.queue_dwnstatus_caption');"  .
                    "$.getJSON(
                    'queue_status.php?id=" . $rowData['id'] . 
                        "&dwnstatus=N', " . 
                    "function(data) { " . 
                        "var newval=(data.dwnstatus == 'Q' ? 'Queued':'')+(data.dwnstatus == 'C' ? 'Completed':'')+(data.dwnstatus == 'N' ? 'Not queued':'');".
                        "dwnstatusValue.html(newval);" . 
                        "dwnstatusCaption.html(newval)" . 
                    "});" . 
                    "return false;". 
                '">dequeue</button>';
                }
                $handled = true;
            }
        }
        public function GetModalGridViewHandler() { return 'queue_inline_record_view'; }
        protected function GetEnableModalSingleRecordView() { return true; }
        
        function partition_OnGetPartitions(&$partitions)
        {
            $tmp = array();
            $this->GetConnection()->ExecQueryToArray("
              SELECT `status` as val
              FROM queue", $tmp
            );
            foreach($tmp as $record) {
              $partitions[$record['val']] = $record['val'];
            }
        }
        
        function partition_OnGetPartitionCondition($partitionKey, &$condition)
        {
            $condition=" queue.`status`='" . $partitionKey . "'";
        }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'queueGrid');
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(false);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetDefaultOrdering('LAST_UPDATE', otDescending);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
            $result->OnCustomRenderColumn->AddListener('queueGrid' . '_' . 'OnCustomRenderColumn', $this);
            $this->CreateGridSearchControl($result);
            $this->CreateGridAdvancedSearchControl($result);
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
    
            $this->SetShowPageList(true);
            $this->SetHidePageListByDefault(false);
            $this->SetExportToExcelAvailable(true);
            $this->SetExportToWordAvailable(true);
            $this->SetExportToXmlAvailable(true);
            $this->SetExportToCsvAvailable(true);
            $this->SetExportToPdfAvailable(true);
            $this->SetPrinterFriendlyAvailable(true);
            $this->SetSimpleSearchAvailable(true);
            $this->SetAdvancedSearchAvailable(true);
            $this->SetFilterRowAvailable(true);
            $this->SetVisualEffectsEnabled(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
    
            //
            // Http Handlers
            //
            $pageView = new filesDetailView0queuePage($this, 'Files', 'Files', array('qid'), GetCurrentUserGrantForDataSource('queue.files'), 'UTF-8', 20, 'filesDetailEdit0queue_handler');
            
            $pageView->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('queue.files'));
            $handler = new PageHTTPHandler('filesDetailView0queue_handler', $pageView);
            GetApplication()->RegisterHTTPHandler($handler);
            $pageEdit = new filesDetailEdit0queuePage($this, array('qid'), array('id'), $this->GetForeingKeyFields(), $this->CreateMasterDetailRecordGridForfilesDetailEdit0queueGrid(), $this->dataset, GetCurrentUserGrantForDataSource('queue.files'), 'UTF-8');
            
            $pageEdit->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('queue.files'));
            $pageEdit->SetShortCaption('Files');
            $pageEdit->SetHeader(GetPagesHeader());
            $pageEdit->SetFooter(GetPagesFooter());
            $pageEdit->SetCaption('Files');
            $pageEdit->SetHttpHandlerName('filesDetailEdit0queue_handler');
            $handler = new PageHTTPHandler('filesDetailEdit0queue_handler', $pageEdit);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'queueGrid_id_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for note field
            //
            $column = new TextViewColumn('note', 'Note', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'queueGrid_note_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for id field
            //
            $column = new TextViewColumn('id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'queueGrid_id_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for note field
            //
            $column = new TextViewColumn('note', 'Note', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'queueGrid_note_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            return $result;
        }
        
        public function OpenAdvancedSearchByDefault()
        {
            return false;
        }
    
        protected function DoGetGridHeader()
        {
            return '';
        }
    }



    try
    {
        $Page = new queuePage("queue.php", "queue", GetCurrentUserGrantForDataSource("queue"), 'UTF-8');
        $Page->SetShortCaption('Queue');
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetCaption('Queue');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("queue"));
        GetApplication()->SetEnableLessRunTimeCompile(GetEnableLessFilesRunTimeCompilation());
        GetApplication()->SetCanUserChangeOwnPassword(
            !function_exists('CanUserChangeOwnPassword') || CanUserChangeOwnPassword());
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e->getMessage());
    }
	
