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
    
    
    
    class vqueue_downloadingPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`vqueue_downloading`');
            $field = new StringField('id');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new StringField('note');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('status');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new StringField('dwnstatus');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new DateTimeField('LAST_UPDATE');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new StringField('pid');
            $this->dataset->AddField($field, true);
            $field = new StringField('agentid');
            $this->dataset->AddField($field, true);
            $field = new StringField('targetid');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
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
            if (GetCurrentUserGrantForDataSource('files')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Files'), 'files.php', $this->RenderText('Files'), $currentPageCaption == $this->RenderText('Files'), false, 'Queue'));
            if (GetCurrentUserGrantForDataSource('target')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Target'), 'target.php', $this->RenderText('Target'), $currentPageCaption == $this->RenderText('Target'), false, 'Queue'));
            if (GetCurrentUserGrantForDataSource('agent')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Agent'), 'agent.php', $this->RenderText('Agent'), $currentPageCaption == $this->RenderText('Agent'), false, 'Queue'));
            if (GetCurrentUserGrantForDataSource('rule')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Rule'), 'rule.php', $this->RenderText('Rule'), $currentPageCaption == $this->RenderText('Rule'), false, 'Queue'));
            if (GetCurrentUserGrantForDataSource('vqueue_stats')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Statistics'), 'vqueue_stats.php', $this->RenderText('Statistics'), $currentPageCaption == $this->RenderText('Statistics'), true, 'Statistics'));
            if (GetCurrentUserGrantForDataSource('vqueue_nok')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Errors'), 'vqueue_nok.php', $this->RenderText('Errors'), $currentPageCaption == $this->RenderText('Errors'), false, 'Statistics'));
            if (GetCurrentUserGrantForDataSource('vqueue_lasthour')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Last Hour'), 'vqueue_lasthour.php', $this->RenderText('Queue changed in the Last hour'), $currentPageCaption == $this->RenderText('Last Hour'), false, 'Statistics'));
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
            $grid->SearchControl = new SimpleSearch('vqueue_downloadingssearch', $this->dataset,
                array('id', 'note', 'status', 'dwnstatus', 'LAST_UPDATE', 'pid', 'agentid', 'targetid'),
                array($this->RenderText('Id'), $this->RenderText('Note'), $this->RenderText('Status'), $this->RenderText('Dwnstatus'), $this->RenderText('LAST UPDATE'), $this->RenderText('Pid'), $this->RenderText('Agentid'), $this->RenderText('Targetid')),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('vqueue_downloadingasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->setTimerInterval(3000);
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('id', $this->RenderText('Id')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('note', $this->RenderText('Note')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('status', $this->RenderText('Status')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('dwnstatus', $this->RenderText('Dwnstatus')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateDateTimeSearchInput('LAST_UPDATE', $this->RenderText('LAST UPDATE')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('pid', $this->RenderText('Pid')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('agentid', $this->RenderText('Agentid')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('targetid', $this->RenderText('Targetid')));
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
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('vqueue_downloadingGrid_id_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for note field
            //
            $column = new TextViewColumn('note', 'Note', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('vqueue_downloadingGrid_note_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
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
            // View column for dwnstatus field
            //
            $column = new TextViewColumn('dwnstatus', 'Dwnstatus', $this->dataset);
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
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('vqueue_downloadingGrid_id_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for note field
            //
            $column = new TextViewColumn('note', 'Note', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('vqueue_downloadingGrid_note_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for status field
            //
            $column = new TextViewColumn('status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for dwnstatus field
            //
            $column = new TextViewColumn('dwnstatus', 'Dwnstatus', $this->dataset);
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
            $editor->SetSize(16);
            $editor->SetMaxLength(16);
            $editColumn = new CustomEditColumn('Status', 'status', $editor, $this->dataset);
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
            // Edit column for pid field
            //
            $editor = new TextEdit('pid_edit');
            $editor->SetSize(8);
            $editor->SetMaxLength(8);
            $editColumn = new CustomEditColumn('Pid', 'pid', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for agentid field
            //
            $editor = new TextEdit('agentid_edit');
            $editor->SetSize(10);
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Agentid', 'agentid', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
            $editor->SetSize(16);
            $editor->SetMaxLength(16);
            $editColumn = new CustomEditColumn('Status', 'status', $editor, $this->dataset);
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
            $editColumn->SetAllowSetToDefault(true);
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
            // Edit column for pid field
            //
            $editor = new TextEdit('pid_edit');
            $editor->SetSize(8);
            $editor->SetMaxLength(8);
            $editColumn = new CustomEditColumn('Pid', 'pid', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for agentid field
            //
            $editor = new TextEdit('agentid_edit');
            $editor->SetSize(10);
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Agentid', 'agentid', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
            // View column for dwnstatus field
            //
            $column = new TextViewColumn('dwnstatus', 'Dwnstatus', $this->dataset);
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
            // View column for dwnstatus field
            //
            $column = new TextViewColumn('dwnstatus', 'Dwnstatus', $this->dataset);
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
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        public function GetModalGridViewHandler() { return 'vqueue_downloading_inline_record_view'; }
        protected function GetEnableModalSingleRecordView() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'vqueue_downloadingGrid');
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
            // View column for id field
            //
            $column = new TextViewColumn('id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'vqueue_downloadingGrid_id_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for note field
            //
            $column = new TextViewColumn('note', 'Note', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'vqueue_downloadingGrid_note_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for id field
            //
            $column = new TextViewColumn('id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'vqueue_downloadingGrid_id_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for note field
            //
            $column = new TextViewColumn('note', 'Note', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'vqueue_downloadingGrid_note_handler_view', $column);
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
        $Page = new vqueue_downloadingPage("vqueue_downloading.php", "vqueue_downloading", GetCurrentUserGrantForDataSource("vqueue_downloading"), 'UTF-8');
        $Page->SetShortCaption('Downloading');
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetCaption('Downloading queue');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("vqueue_downloading"));
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
	
