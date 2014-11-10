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
    
    
    
    class queueDetailView0qProductPage extends DetailPage
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
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
        }
    
        protected function AddFieldColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'Id', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('queueDetailViewGrid0qProduct_id_handler_list');
            $column->SetDescription($this->RenderText('client id'));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for note field
            //
            $column = new TextViewColumn('note', 'Note', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('queueDetailViewGrid0qProduct_note_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for status field
            //
            $column = new TextViewColumn('status', 'Status', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for dwnstatus field
            //
            $column = new TextViewColumn('dwnstatus', 'Dwnstatus', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for LAST_UPDATE field
            //
            $column = new DateTimeViewColumn('LAST_UPDATE', 'LAST UPDATE', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for pid field
            //
            $column = new TextViewColumn('pid', 'Pid', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for agentid field
            //
            $column = new TextViewColumn('agentid', 'Agentid', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for targetid field
            //
            $column = new TextViewColumn('targetid', 'Targetid', $this->dataset);
            $column->SetOrderable(false);
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
            $result = new Grid($this, $this->dataset, 'queueDetailViewGrid0qProduct');
            $result->SetAllowDeleteSelected(false);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
            $this->AddFieldColumns($result);
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'Id', $this->dataset);
            $column->SetOrderable(false);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'queueDetailViewGrid0qProduct_id_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for note field
            //
            $column = new TextViewColumn('note', 'Note', $this->dataset);
            $column->SetOrderable(false);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'queueDetailViewGrid0qProduct_note_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            return $result;
        }
    }
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class queueDetailEdit0qProductPage extends DetailPageEdit
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
            $field->SetIsNotNull(true);
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
            $grid->SearchControl = new SimpleSearch('queueDetailEdit0qProductssearch', $this->dataset,
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('queueDetailEdit0qProductasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->setTimerInterval(1000);
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('id', $this->RenderText('Id')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('note', $this->RenderText('Note')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('status', $this->RenderText('Status')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('dwnstatus', $this->RenderText('Dwnstatus')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateDateTimeSearchInput('LAST_UPDATE', $this->RenderText('LAST UPDATE')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('pid', $this->RenderText('Pid')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('agentid', $this->RenderText('Agentid')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('targetid', $this->RenderText('Targetid')));
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
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('queueDetailEditGrid0qProduct_id_handler_list');
            $column->SetDescription($this->RenderText('client id'));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for note field
            //
            $column = new TextViewColumn('note', 'Note', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('queueDetailEditGrid0qProduct_note_handler_list');
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
            $column->SetFullTextWindowHandlerName('queueDetailEditGrid0qProduct_id_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for note field
            //
            $column = new TextViewColumn('note', 'Note', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('queueDetailEditGrid0qProduct_note_handler_view');
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
        public function GetModalGridViewHandler() { return 'queueDetailEdit0qProduct_inline_record_view'; }
        protected function GetEnableModalSingleRecordView() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'queueDetailEditGrid0qProduct');
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
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'queueDetailEditGrid0qProduct_id_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for note field
            //
            $column = new TextViewColumn('note', 'Note', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'queueDetailEditGrid0qProduct_note_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for id field
            //
            $column = new TextViewColumn('id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'queueDetailEditGrid0qProduct_id_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for note field
            //
            $column = new TextViewColumn('note', 'Note', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'queueDetailEditGrid0qProduct_note_handler_view', $column);
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
    if(isset($_COOKIE['filter']) and $_COOKIE['filter']!=''){
      $qwhere="MBRContains(GeomFromText('" . urldecode($_COOKIE['filter']) . "'),footprint)";
    } else {
      $qwhere='True';
    }
    //global $qwhere;
    //$selectQuery = 'select * from product where '.$qwhere;
    
    
    class qProductPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $selectQuery = 'SELECT product.id, 
            	product.producttype, 
            	product.orbit, 
            	product.`start`, 
            	product.dtid, 
            	product.`stop`, 
            	product.duration, 
            	product.crc, 
            	product.polarization, 
            	AsText(product.footprint) footprint, 
            	product.size, 
            	product.tags, 
            	product.json, 
            	product.LAST_UPDATE, 
            	queue.dwnstatus, 
            	queue.targetid
            FROM queue INNER JOIN product ON queue.id = product.id';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $this->dataset = new QueryDataset(
              new MyConnectionFactory(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'qProduct');
            $field = new StringField('id');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new StringField('producttype');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('orbit');
            $this->dataset->AddField($field, false);
            $field = new DateTimeField('start');
            $this->dataset->AddField($field, false);
            $field = new StringField('dtid');
            $this->dataset->AddField($field, false);
            $field = new DateTimeField('stop');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('duration');
            $this->dataset->AddField($field, false);
            $field = new StringField('crc');
            $this->dataset->AddField($field, false);
            $field = new StringField('polarization');
            $this->dataset->AddField($field, false);
            $field = new StringField('footprint');
            $this->dataset->AddField($field, false);
            $field = new StringField('size');
            $this->dataset->AddField($field, false);
            $field = new StringField('tags');
            $this->dataset->AddField($field, false);
            $field = new StringField('json');
            $this->dataset->AddField($field, false);
            $field = new DateTimeField('LAST_UPDATE');
            $this->dataset->AddField($field, false);
            $field = new StringField('dwnstatus');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
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
            $result->AddGroup('Default');
            $result->AddGroup('Queue');
            $result->AddGroup('Statistics');
            if (GetCurrentUserGrantForDataSource('qProduct')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Product Catalogue'), 'product.php', $this->RenderText('Product Catalogue'), $currentPageCaption == $this->RenderText('Product Catalogue'), false, 'Default'));
            if (GetCurrentUserGrantForDataSource('vslc')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('SLC'), 'vslc.php', $this->RenderText('SLC Groups'), $currentPageCaption == $this->RenderText('SLC'), false, 'Default'));
            if (GetCurrentUserGrantForDataSource('vcountry')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Area'), 'area.php', $this->RenderText('Area'), $currentPageCaption == $this->RenderText('Area'), false, 'Default'));
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
            $grid->SearchControl = new SimpleSearch('qProductssearch', $this->dataset,
                array('id', 'producttype', 'orbit', 'start', 'dtid', 'stop', 'duration', 'crc', 'polarization', 'footprint', 'size', 'tags', 'json', 'LAST_UPDATE', 'dwnstatus', 'targetid'),
                array($this->RenderText('Id'), $this->RenderText('Producttype'), $this->RenderText('Orbit'), $this->RenderText('Start'), $this->RenderText('Dtid'), $this->RenderText('Stop'), $this->RenderText('Duration'), $this->RenderText('Crc'), $this->RenderText('Polarization'), $this->RenderText('Footprint'), $this->RenderText('Size'), $this->RenderText('Tags'), $this->RenderText('Json'), $this->RenderText('LAST UPDATE'), $this->RenderText('Dwnstatus'), $this->RenderText('Targetid')),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('qProductasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->setTimerInterval(3000);
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('id', $this->RenderText('Id')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('producttype', $this->RenderText('Producttype')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('orbit', $this->RenderText('Orbit')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateDateTimeSearchInput('start', $this->RenderText('Start')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('dtid', $this->RenderText('Dtid')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateDateTimeSearchInput('stop', $this->RenderText('Stop')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('duration', $this->RenderText('Duration')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('crc', $this->RenderText('Crc')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('polarization', $this->RenderText('Polarization')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('footprint', $this->RenderText('Footprint')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('size', $this->RenderText('Size')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('tags', $this->RenderText('Tags')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('json', $this->RenderText('Json')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateDateTimeSearchInput('LAST_UPDATE', $this->RenderText('LAST UPDATE')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('dwnstatus', $this->RenderText('Dwnstatus')));
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
            if (GetCurrentUserGrantForDataSource('qProduct.queue')->HasViewGrant())
            {
              //
            // View column for queueDetailView0qProduct detail
            //
            $column = new DetailColumn(array('id'), 'detail0qProduct', 'queueDetailEdit0qProduct_handler', 'queueDetailView0qProduct_handler', $this->dataset, 'Queue', $this->RenderText('Queue'));
              $grid->AddViewColumn($column);
            }
            
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for producttype field
            //
            $column = new TextViewColumn('producttype', 'Producttype', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for orbit field
            //
            $column = new TextViewColumn('orbit', 'Orbit', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for start field
            //
            $column = new DateTimeViewColumn('start', 'Start', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for dtid field
            //
            $column = new TextViewColumn('dtid', 'Dtid', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for stop field
            //
            $column = new DateTimeViewColumn('stop', 'Stop', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for duration field
            //
            $column = new TextViewColumn('duration', 'Duration', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for crc field
            //
            $column = new TextViewColumn('crc', 'Crc', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for polarization field
            //
            $column = new TextViewColumn('polarization', 'Polarization', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for footprint field
            //
            $column = new TextViewColumn('footprint', 'Footprint', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for size field
            //
            $column = new TextViewColumn('size', 'Size', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for tags field
            //
            $column = new TextViewColumn('tags', 'Tags', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for json field
            //
            $column = new TextViewColumn('json', 'Json', $this->dataset);
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
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for producttype field
            //
            $column = new TextViewColumn('producttype', 'Producttype', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for orbit field
            //
            $column = new TextViewColumn('orbit', 'Orbit', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for start field
            //
            $column = new DateTimeViewColumn('start', 'Start', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for dtid field
            //
            $column = new TextViewColumn('dtid', 'Dtid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for stop field
            //
            $column = new DateTimeViewColumn('stop', 'Stop', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for duration field
            //
            $column = new TextViewColumn('duration', 'Duration', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for crc field
            //
            $column = new TextViewColumn('crc', 'Crc', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for polarization field
            //
            $column = new TextViewColumn('polarization', 'Polarization', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for footprint field
            //
            $column = new TextViewColumn('footprint', 'Footprint', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for size field
            //
            $column = new TextViewColumn('size', 'Size', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for tags field
            //
            $column = new TextViewColumn('tags', 'Tags', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for json field
            //
            $column = new TextViewColumn('json', 'Json', $this->dataset);
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
            $editor = new TextEdit('id_edit');
            $editColumn = new CustomEditColumn('Id', 'id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for producttype field
            //
            $editor = new TextEdit('producttype_edit');
            $editColumn = new CustomEditColumn('Producttype', 'producttype', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for orbit field
            //
            $editor = new SpinEdit('orbit_edit');
            $editColumn = new CustomEditColumn('Orbit', 'orbit', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for start field
            //
            $editor = new DateTimeEdit('start_edit', true, 'Y-m-d H:i:s', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Start', 'start', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for dtid field
            //
            $editor = new TextEdit('dtid_edit');
            $editColumn = new CustomEditColumn('Dtid', 'dtid', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for stop field
            //
            $editor = new DateTimeEdit('stop_edit', true, 'Y-m-d H:i:s', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Stop', 'stop', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for duration field
            //
            $editor = new SpinEdit('duration_edit');
            $editColumn = new CustomEditColumn('Duration', 'duration', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for crc field
            //
            $editor = new TextEdit('crc_edit');
            $editColumn = new CustomEditColumn('Crc', 'crc', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for polarization field
            //
            $editor = new TextEdit('polarization_edit');
            $editColumn = new CustomEditColumn('Polarization', 'polarization', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for footprint field
            //
            $editor = new TextEdit('footprint_edit');
            $editColumn = new CustomEditColumn('Footprint', 'footprint', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for size field
            //
            $editor = new TextEdit('size_edit');
            $editColumn = new CustomEditColumn('Size', 'size', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tags field
            //
            $editor = new TextEdit('tags_edit');
            $editColumn = new CustomEditColumn('Tags', 'tags', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for json field
            //
            $editor = new TextEdit('json_edit');
            $editColumn = new CustomEditColumn('Json', 'json', $editor, $this->dataset);
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
            
            //
            // Edit column for targetid field
            //
            $editor = new TextEdit('targetid_edit');
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
            $editor = new TextEdit('id_edit');
            $editColumn = new CustomEditColumn('Id', 'id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for producttype field
            //
            $editor = new TextEdit('producttype_edit');
            $editColumn = new CustomEditColumn('Producttype', 'producttype', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for orbit field
            //
            $editor = new SpinEdit('orbit_edit');
            $editColumn = new CustomEditColumn('Orbit', 'orbit', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for start field
            //
            $editor = new DateTimeEdit('start_edit', true, 'Y-m-d H:i:s', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Start', 'start', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for dtid field
            //
            $editor = new TextEdit('dtid_edit');
            $editColumn = new CustomEditColumn('Dtid', 'dtid', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for stop field
            //
            $editor = new DateTimeEdit('stop_edit', true, 'Y-m-d H:i:s', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Stop', 'stop', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for duration field
            //
            $editor = new SpinEdit('duration_edit');
            $editColumn = new CustomEditColumn('Duration', 'duration', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for crc field
            //
            $editor = new TextEdit('crc_edit');
            $editColumn = new CustomEditColumn('Crc', 'crc', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for polarization field
            //
            $editor = new TextEdit('polarization_edit');
            $editColumn = new CustomEditColumn('Polarization', 'polarization', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for footprint field
            //
            $editor = new TextEdit('footprint_edit');
            $editColumn = new CustomEditColumn('Footprint', 'footprint', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for size field
            //
            $editor = new TextEdit('size_edit');
            $editColumn = new CustomEditColumn('Size', 'size', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tags field
            //
            $editor = new TextEdit('tags_edit');
            $editColumn = new CustomEditColumn('Tags', 'tags', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for json field
            //
            $editor = new TextEdit('json_edit');
            $editColumn = new CustomEditColumn('Json', 'json', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for LAST_UPDATE field
            //
            $editor = new DateTimeEdit('last_update_edit', true, 'Y-m-d H:i:s', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('LAST UPDATE', 'LAST_UPDATE', $editor, $this->dataset);
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
            
            //
            // Edit column for targetid field
            //
            $editor = new TextEdit('targetid_edit');
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
            // View column for producttype field
            //
            $column = new TextViewColumn('producttype', 'Producttype', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for orbit field
            //
            $column = new TextViewColumn('orbit', 'Orbit', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for start field
            //
            $column = new DateTimeViewColumn('start', 'Start', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for dtid field
            //
            $column = new TextViewColumn('dtid', 'Dtid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for stop field
            //
            $column = new DateTimeViewColumn('stop', 'Stop', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for duration field
            //
            $column = new TextViewColumn('duration', 'Duration', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for crc field
            //
            $column = new TextViewColumn('crc', 'Crc', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for polarization field
            //
            $column = new TextViewColumn('polarization', 'Polarization', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for footprint field
            //
            $column = new TextViewColumn('footprint', 'Footprint', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for size field
            //
            $column = new TextViewColumn('size', 'Size', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for tags field
            //
            $column = new TextViewColumn('tags', 'Tags', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for json field
            //
            $column = new TextViewColumn('json', 'Json', $this->dataset);
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
            // View column for producttype field
            //
            $column = new TextViewColumn('producttype', 'Producttype', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for orbit field
            //
            $column = new TextViewColumn('orbit', 'Orbit', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for start field
            //
            $column = new DateTimeViewColumn('start', 'Start', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for dtid field
            //
            $column = new TextViewColumn('dtid', 'Dtid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for stop field
            //
            $column = new DateTimeViewColumn('stop', 'Stop', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for duration field
            //
            $column = new TextViewColumn('duration', 'Duration', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for crc field
            //
            $column = new TextViewColumn('crc', 'Crc', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for polarization field
            //
            $column = new TextViewColumn('polarization', 'Polarization', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for footprint field
            //
            $column = new TextViewColumn('footprint', 'Footprint', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for size field
            //
            $column = new TextViewColumn('size', 'Size', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for tags field
            //
            $column = new TextViewColumn('tags', 'Tags', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for json field
            //
            $column = new TextViewColumn('json', 'Json', $this->dataset);
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
    
        function CreateMasterDetailRecordGridForqueueDetailEdit0qProductGrid()
        {
            $result = new Grid($this, $this->dataset, 'MasterDetailRecordGridForqueueDetailEdit0qProduct');
            $result->SetAllowDeleteSelected(false);
            $result->OnCustomRenderColumn->AddListener('MasterDetailRecordGridForqueueDetailEdit0qProduct' . '_' . 'OnCustomRenderColumn', $this);
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
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for producttype field
            //
            $column = new TextViewColumn('producttype', 'Producttype', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for orbit field
            //
            $column = new TextViewColumn('orbit', 'Orbit', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for start field
            //
            $column = new DateTimeViewColumn('start', 'Start', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for dtid field
            //
            $column = new TextViewColumn('dtid', 'Dtid', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for stop field
            //
            $column = new DateTimeViewColumn('stop', 'Stop', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for duration field
            //
            $column = new TextViewColumn('duration', 'Duration', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for crc field
            //
            $column = new TextViewColumn('crc', 'Crc', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for polarization field
            //
            $column = new TextViewColumn('polarization', 'Polarization', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for footprint field
            //
            $column = new TextViewColumn('footprint', 'Footprint', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for size field
            //
            $column = new TextViewColumn('size', 'Size', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for tags field
            //
            $column = new TextViewColumn('tags', 'Tags', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for json field
            //
            $column = new TextViewColumn('json', 'Json', $this->dataset);
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
            // View column for targetid field
            //
            $column = new TextViewColumn('targetid', 'Targetid', $this->dataset);
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
            // View column for producttype field
            //
            $column = new TextViewColumn('producttype', 'Producttype', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for orbit field
            //
            $column = new TextViewColumn('orbit', 'Orbit', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for start field
            //
            $column = new DateTimeViewColumn('start', 'Start', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for dtid field
            //
            $column = new TextViewColumn('dtid', 'Dtid', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for stop field
            //
            $column = new DateTimeViewColumn('stop', 'Stop', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for duration field
            //
            $column = new TextViewColumn('duration', 'Duration', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for crc field
            //
            $column = new TextViewColumn('crc', 'Crc', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for polarization field
            //
            $column = new TextViewColumn('polarization', 'Polarization', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for footprint field
            //
            $column = new TextViewColumn('footprint', 'Footprint', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for size field
            //
            $column = new TextViewColumn('size', 'Size', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for tags field
            //
            $column = new TextViewColumn('tags', 'Tags', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for json field
            //
            $column = new TextViewColumn('json', 'Json', $this->dataset);
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
            
            //
            // View column for targetid field
            //
            $column = new TextViewColumn('targetid', 'Targetid', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            return $result;
        }
        
        function MasterDetailRecordGridForqueueDetailEdit0qProduct_OnCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        {
            if ($fieldName == 'dwnstatus')
            {
                $customText = '<div class="queue_dwnstatus_value" style="display: none;">'.$fieldData.'</div>';
                $customText .= 
                '<span class="queue_dwnstatus_caption" style="margin-right: 20px;">' . 
                    ($fieldData == Q ? 'Queued' : 'None') . 
                '</span>';
                if ($fieldData == N) {
                $customText .= 
                '<button onclick="' . 
                    "var dwnstatusValue = $(this).siblings('.queue_dwnstatus_value');" . 
                    "var dwnstatusCaption = $(this).siblings('.queue_dwnstatus_caption');"  .
                    "$.getJSON(
                    'queue_status.php?id=" . $rowData['id'] . 
                        "&dwnstatus=Q', " . 
                    "function(data) { " . 
                        "dwnstatusValue.html(data.dwnstatus);" . 
                        "dwnstatusCaption.html(data.dwnstatus == 1)" . 
                    "});" . 
                    "return false;". 
                '">Queue</button>';
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
        public function qProductGrid_OnGetCustomTemplate($part, $mode, &$result, &$params)
        {
        if ($part == PagePart::Grid && $mode == PageMode::ViewAll)
         {
           $result = 'PRODUCT.tpl';
         }
        }
        function qProductGrid_OnCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        {
            if ($fieldName == 'dwnstatus')
            {
                $customText = '<div class="queue_dwnstatus_value" style="display: none;">'.$fieldData.'</div>';
                $customText .= 
                '<span class="queue_dwnstatus_caption" style="margin-right: 20px;">' . 
                    ($fieldData == Q ? 'Queued' : 'None') . 
                '</span>';
                if ($fieldData == N) {
                $customText .= 
                '<button onclick="' . 
                    "var dwnstatusValue = $(this).siblings('.queue_dwnstatus_value');" . 
                    "var dwnstatusCaption = $(this).siblings('.queue_dwnstatus_caption');"  .
                    "$.getJSON(
                    'queue_status.php?id=" . $rowData['id'] . 
                        "&dwnstatus=Q', " . 
                    "function(data) { " . 
                        "dwnstatusValue.html(data.dwnstatus);" . 
                        "dwnstatusCaption.html(data.dwnstatus == 1)" . 
                    "});" . 
                    "return false;". 
                '">Queue</button>';
                }
                $handled = true;
            }
        }
        public function GetModalGridViewHandler() { return 'qProduct_inline_record_view'; }
        protected function GetEnableModalSingleRecordView() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'qProductGrid');
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
            $this->OnGetCustomTemplate->AddListener('qProductGrid' . '_OnGetCustomTemplate', $this);
            $result->OnCustomRenderColumn->AddListener('qProductGrid' . '_' . 'OnCustomRenderColumn', $this);
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
            $pageView = new queueDetailView0qProductPage($this, 'Queue', 'Queue', array('id'), GetCurrentUserGrantForDataSource('qProduct.queue'), 'UTF-8', 20, 'queueDetailEdit0qProduct_handler');
            
            $pageView->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('qProduct.queue'));
            $handler = new PageHTTPHandler('queueDetailView0qProduct_handler', $pageView);
            GetApplication()->RegisterHTTPHandler($handler);
            $pageEdit = new queueDetailEdit0qProductPage($this, array('id'), array('id'), $this->GetForeingKeyFields(), $this->CreateMasterDetailRecordGridForqueueDetailEdit0qProductGrid(), $this->dataset, GetCurrentUserGrantForDataSource('qProduct.queue'), 'UTF-8');
            
            $pageEdit->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('qProduct.queue'));
            $pageEdit->SetShortCaption('Queue');
            $pageEdit->SetHeader(GetPagesHeader());
            $pageEdit->SetFooter(GetPagesFooter());
            $pageEdit->SetCaption('Queue');
            $pageEdit->SetHttpHandlerName('queueDetailEdit0qProduct_handler');
            $handler = new PageHTTPHandler('queueDetailEdit0qProduct_handler', $pageEdit);
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
        $Page = new qProductPage("product.php", "qProduct", GetCurrentUserGrantForDataSource("qProduct"), 'UTF-8');
        $Page->SetShortCaption('Product Catalogue');
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetCaption('Product Catalogue');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("qProduct"));
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
	
