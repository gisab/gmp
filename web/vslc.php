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
    
    
    
    class productDetailView0vslcPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`product`');
            $field = new StringField('id');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new DateTimeField('LAST_UPDATE');
            $this->dataset->AddField($field, false);
            $field = new StringField('producttype');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('orbit');
            $this->dataset->AddField($field, false);
            $field = new StringField('dtid');
            $this->dataset->AddField($field, false);
            $field = new DateTimeField('start');
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
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('size');
            $this->dataset->AddField($field, false);
            $field = new StringField('tags');
            $this->dataset->AddField($field, false);
            $field = new StringField('json');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('slcid');
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
            $column->SetFullTextWindowHandlerName('productDetailViewGrid0vslc_id_handler_list');
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
            // View column for producttype field
            //
            $column = new TextViewColumn('producttype', 'Producttype', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for orbit field
            //
            $column = new TextViewColumn('orbit', 'Orbit', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for dtid field
            //
            $column = new TextViewColumn('dtid', 'Dtid', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for start field
            //
            $column = new DateTimeViewColumn('start', 'Start', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for stop field
            //
            $column = new DateTimeViewColumn('stop', 'Stop', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for duration field
            //
            $column = new TextViewColumn('duration', 'Duration', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for crc field
            //
            $column = new TextViewColumn('crc', 'Crc', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for polarization field
            //
            $column = new TextViewColumn('polarization', 'Polarization', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for footprint field
            //
            $column = new TextViewColumn('footprint', 'Footprint', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for size field
            //
            $column = new TextViewColumn('size', 'Size', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for tags field
            //
            $column = new TextViewColumn('tags', 'Tags', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('productDetailViewGrid0vslc_tags_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for json field
            //
            $column = new TextViewColumn('json', 'Json', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('productDetailViewGrid0vslc_json_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for slcid field
            //
            $column = new TextViewColumn('slcid', 'Slcid', $this->dataset);
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
            $result = new Grid($this, $this->dataset, 'productDetailViewGrid0vslc');
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
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'productDetailViewGrid0vslc_id_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for tags field
            //
            $column = new TextViewColumn('tags', 'Tags', $this->dataset);
            $column->SetOrderable(false);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'productDetailViewGrid0vslc_tags_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for json field
            //
            $column = new TextViewColumn('json', 'Json', $this->dataset);
            $column->SetOrderable(false);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'productDetailViewGrid0vslc_json_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            return $result;
        }
    }
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class productDetailEdit0vslcPage extends DetailPageEdit
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`product`');
            $field = new StringField('id');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new DateTimeField('LAST_UPDATE');
            $this->dataset->AddField($field, false);
            $field = new StringField('producttype');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('orbit');
            $this->dataset->AddField($field, false);
            $field = new StringField('dtid');
            $this->dataset->AddField($field, false);
            $field = new DateTimeField('start');
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
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('size');
            $this->dataset->AddField($field, false);
            $field = new StringField('tags');
            $this->dataset->AddField($field, false);
            $field = new StringField('json');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('slcid');
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
            $grid->SearchControl = new SimpleSearch('productDetailEdit0vslcssearch', $this->dataset,
                array('id', 'LAST_UPDATE', 'producttype', 'orbit', 'dtid', 'start', 'stop', 'duration', 'crc', 'polarization', 'footprint', 'size', 'tags', 'json', 'slcid'),
                array($this->RenderText('Id'), $this->RenderText('LAST UPDATE'), $this->RenderText('Producttype'), $this->RenderText('Orbit'), $this->RenderText('Dtid'), $this->RenderText('Start'), $this->RenderText('Stop'), $this->RenderText('Duration'), $this->RenderText('Crc'), $this->RenderText('Polarization'), $this->RenderText('Footprint'), $this->RenderText('Size'), $this->RenderText('Tags'), $this->RenderText('Json'), $this->RenderText('Slcid')),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('productDetailEdit0vslcasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->setTimerInterval(1000);
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('id', $this->RenderText('Id')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateDateTimeSearchInput('LAST_UPDATE', $this->RenderText('LAST UPDATE')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('producttype', $this->RenderText('Producttype')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('orbit', $this->RenderText('Orbit')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('dtid', $this->RenderText('Dtid')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateDateTimeSearchInput('start', $this->RenderText('Start')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateDateTimeSearchInput('stop', $this->RenderText('Stop')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('duration', $this->RenderText('Duration')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('crc', $this->RenderText('Crc')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('polarization', $this->RenderText('Polarization')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('footprint', $this->RenderText('Footprint')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('size', $this->RenderText('Size')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('tags', $this->RenderText('Tags')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('json', $this->RenderText('Json')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('slcid', $this->RenderText('Slcid')));
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
            $column->SetFullTextWindowHandlerName('productDetailEditGrid0vslc_id_handler_list');
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
            // View column for dtid field
            //
            $column = new TextViewColumn('dtid', 'Dtid', $this->dataset);
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
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('productDetailEditGrid0vslc_tags_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for json field
            //
            $column = new TextViewColumn('json', 'Json', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('productDetailEditGrid0vslc_json_handler_list');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for slcid field
            //
            $column = new TextViewColumn('slcid', 'Slcid', $this->dataset);
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
            $column->SetFullTextWindowHandlerName('productDetailEditGrid0vslc_id_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for LAST_UPDATE field
            //
            $column = new DateTimeViewColumn('LAST_UPDATE', 'LAST UPDATE', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
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
            // View column for dtid field
            //
            $column = new TextViewColumn('dtid', 'Dtid', $this->dataset);
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
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('productDetailEditGrid0vslc_tags_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for json field
            //
            $column = new TextViewColumn('json', 'Json', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('productDetailEditGrid0vslc_json_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for slcid field
            //
            $column = new TextViewColumn('slcid', 'Slcid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for id field
            //
            $editor = new TextEdit('id_edit');
            $editor->SetSize(80);
            $editor->SetMaxLength(80);
            $editColumn = new CustomEditColumn('Id', 'id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for LAST_UPDATE field
            //
            $editor = new DateTimeEdit('last_update_edit', true, 'Y-m-d H:i:s', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('LAST UPDATE', 'LAST_UPDATE', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for producttype field
            //
            $editor = new TextEdit('producttype_edit');
            $editor->SetSize(8);
            $editor->SetMaxLength(8);
            $editColumn = new CustomEditColumn('Producttype', 'producttype', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for orbit field
            //
            $editor = new TextEdit('orbit_edit');
            $editColumn = new CustomEditColumn('Orbit', 'orbit', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for dtid field
            //
            $editor = new TextEdit('dtid_edit');
            $editor->SetSize(6);
            $editor->SetMaxLength(6);
            $editColumn = new CustomEditColumn('Dtid', 'dtid', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for start field
            //
            $editor = new DateTimeEdit('start_edit', true, 'Y-m-d H:i:s', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Start', 'start', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for stop field
            //
            $editor = new DateTimeEdit('stop_edit', true, 'Y-m-d H:i:s', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Stop', 'stop', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for duration field
            //
            $editor = new TextEdit('duration_edit');
            $editColumn = new CustomEditColumn('Duration', 'duration', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for crc field
            //
            $editor = new TextEdit('crc_edit');
            $editor->SetSize(6);
            $editor->SetMaxLength(6);
            $editColumn = new CustomEditColumn('Crc', 'crc', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for polarization field
            //
            $editor = new TextEdit('polarization_edit');
            $editor->SetSize(2);
            $editor->SetMaxLength(2);
            $editColumn = new CustomEditColumn('Polarization', 'polarization', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tags field
            //
            $editor = new TextAreaEdit('tags_edit', 50, 8);
            $editColumn = new CustomEditColumn('Tags', 'tags', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for json field
            //
            $editor = new TextAreaEdit('json_edit', 50, 8);
            $editColumn = new CustomEditColumn('Json', 'json', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for slcid field
            //
            $editor = new TextEdit('slcid_edit');
            $editColumn = new CustomEditColumn('Slcid', 'slcid', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for id field
            //
            $editor = new TextEdit('id_edit');
            $editor->SetSize(80);
            $editor->SetMaxLength(80);
            $editColumn = new CustomEditColumn('Id', 'id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for LAST_UPDATE field
            //
            $editor = new DateTimeEdit('last_update_edit', true, 'Y-m-d H:i:s', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('LAST UPDATE', 'LAST_UPDATE', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetAllowSetToDefault(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for producttype field
            //
            $editor = new TextEdit('producttype_edit');
            $editor->SetSize(8);
            $editor->SetMaxLength(8);
            $editColumn = new CustomEditColumn('Producttype', 'producttype', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for orbit field
            //
            $editor = new TextEdit('orbit_edit');
            $editColumn = new CustomEditColumn('Orbit', 'orbit', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for dtid field
            //
            $editor = new TextEdit('dtid_edit');
            $editor->SetSize(6);
            $editor->SetMaxLength(6);
            $editColumn = new CustomEditColumn('Dtid', 'dtid', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for start field
            //
            $editor = new DateTimeEdit('start_edit', true, 'Y-m-d H:i:s', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Start', 'start', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for stop field
            //
            $editor = new DateTimeEdit('stop_edit', true, 'Y-m-d H:i:s', GetFirstDayOfWeek());
            $editColumn = new CustomEditColumn('Stop', 'stop', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for duration field
            //
            $editor = new TextEdit('duration_edit');
            $editColumn = new CustomEditColumn('Duration', 'duration', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for crc field
            //
            $editor = new TextEdit('crc_edit');
            $editor->SetSize(6);
            $editor->SetMaxLength(6);
            $editColumn = new CustomEditColumn('Crc', 'crc', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for polarization field
            //
            $editor = new TextEdit('polarization_edit');
            $editor->SetSize(2);
            $editor->SetMaxLength(2);
            $editColumn = new CustomEditColumn('Polarization', 'polarization', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tags field
            //
            $editor = new TextAreaEdit('tags_edit', 50, 8);
            $editColumn = new CustomEditColumn('Tags', 'tags', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for json field
            //
            $editor = new TextAreaEdit('json_edit', 50, 8);
            $editColumn = new CustomEditColumn('Json', 'json', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for slcid field
            //
            $editor = new TextEdit('slcid_edit');
            $editColumn = new CustomEditColumn('Slcid', 'slcid', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
            // View column for LAST_UPDATE field
            //
            $column = new DateTimeViewColumn('LAST_UPDATE', 'LAST UPDATE', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
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
            // View column for dtid field
            //
            $column = new TextViewColumn('dtid', 'Dtid', $this->dataset);
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
            // View column for slcid field
            //
            $column = new TextViewColumn('slcid', 'Slcid', $this->dataset);
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
            // View column for LAST_UPDATE field
            //
            $column = new DateTimeViewColumn('LAST_UPDATE', 'LAST UPDATE', $this->dataset);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
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
            // View column for dtid field
            //
            $column = new TextViewColumn('dtid', 'Dtid', $this->dataset);
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
            // View column for slcid field
            //
            $column = new TextViewColumn('slcid', 'Slcid', $this->dataset);
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
        public function GetModalGridViewHandler() { return 'productDetailEdit0vslc_inline_record_view'; }
        protected function GetEnableModalSingleRecordView() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'productDetailEditGrid0vslc');
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
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'productDetailEditGrid0vslc_id_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for tags field
            //
            $column = new TextViewColumn('tags', 'Tags', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'productDetailEditGrid0vslc_tags_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for json field
            //
            $column = new TextViewColumn('json', 'Json', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'productDetailEditGrid0vslc_json_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for id field
            //
            $column = new TextViewColumn('id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'productDetailEditGrid0vslc_id_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for tags field
            //
            $column = new TextViewColumn('tags', 'Tags', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'productDetailEditGrid0vslc_tags_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for json field
            //
            $column = new TextViewColumn('json', 'Json', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'productDetailEditGrid0vslc_json_handler_view', $column);
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
    
    
    
    class vslcPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $selectQuery = 'SELECT slc.`id`, 
            slc.`name`, 
            slc.`name` WKT
            FROM slc';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $this->dataset = new QueryDataset(
              new MyConnectionFactory(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'vslc');
            $field = new IntegerField('id');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new StringField('name');
            $this->dataset->AddField($field, false);
            $field = new StringField('WKT');
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
            $grid->SearchControl = new SimpleSearch('vslcssearch', $this->dataset,
                array('id', 'name', 'WKT'),
                array($this->RenderText('Id'), $this->RenderText('Name'), $this->RenderText('WKT')),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('vslcasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->setTimerInterval(3000);
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('id', $this->RenderText('Id')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('name', $this->RenderText('Name')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('WKT', $this->RenderText('WKT')));
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
            if (GetCurrentUserGrantForDataSource('vslc.')->HasViewGrant())
            {
              //
            // View column for productDetailView0vslc detail
            //
            $column = new DetailColumn(array('id'), 'detail0vslc', 'productDetailEdit0vslc_handler', 'productDetailView0vslc_handler', $this->dataset, 'Product', $this->RenderText('Product'));
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
            // View column for name field
            //
            $column = new TextViewColumn('name', 'Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for WKT field
            //
            $column = new TextViewColumn('WKT', 'WKT', $this->dataset);
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
            // View column for name field
            //
            $column = new TextViewColumn('name', 'Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for WKT field
            //
            $column = new TextViewColumn('WKT', 'WKT', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for id field
            //
            $editor = new SpinEdit('id_edit');
            $editColumn = new CustomEditColumn('Id', 'id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for name field
            //
            $editor = new TextEdit('name_edit');
            $editColumn = new CustomEditColumn('Name', 'name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for WKT field
            //
            $editor = new TextEdit('wkt_edit');
            $editColumn = new CustomEditColumn('WKT', 'WKT', $editor, $this->dataset);
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
            $editor = new SpinEdit('id_edit');
            $editColumn = new CustomEditColumn('Id', 'id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for name field
            //
            $editor = new TextEdit('name_edit');
            $editColumn = new CustomEditColumn('Name', 'name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for WKT field
            //
            $editor = new TextEdit('wkt_edit');
            $editColumn = new CustomEditColumn('WKT', 'WKT', $editor, $this->dataset);
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
            // View column for name field
            //
            $column = new TextViewColumn('name', 'Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for WKT field
            //
            $column = new TextViewColumn('WKT', 'WKT', $this->dataset);
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
            // View column for name field
            //
            $column = new TextViewColumn('name', 'Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for WKT field
            //
            $column = new TextViewColumn('WKT', 'WKT', $this->dataset);
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
    
        function CreateMasterDetailRecordGridForproductDetailEdit0vslcGrid()
        {
            $result = new Grid($this, $this->dataset, 'MasterDetailRecordGridForproductDetailEdit0vslc');
            $result->SetAllowDeleteSelected(false);
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
            // View column for name field
            //
            $column = new TextViewColumn('name', 'Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for WKT field
            //
            $column = new TextViewColumn('WKT', 'WKT', $this->dataset);
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
            // View column for name field
            //
            $column = new TextViewColumn('name', 'Name', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for WKT field
            //
            $column = new TextViewColumn('WKT', 'WKT', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            return $result;
        }
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        public function GetModalGridViewHandler() { return 'vslc_inline_record_view'; }
        protected function GetEnableModalSingleRecordView() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'vslcGrid');
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
            $pageView = new productDetailView0vslcPage($this, 'Product', 'Product', array('id'), GetCurrentUserGrantForDataSource('vslc.'), 'UTF-8', 20, 'productDetailEdit0vslc_handler');
            
            $pageView->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('vslc.'));
            $handler = new PageHTTPHandler('productDetailView0vslc_handler', $pageView);
            GetApplication()->RegisterHTTPHandler($handler);
            $pageEdit = new productDetailEdit0vslcPage($this, array('id'), array('id'), $this->GetForeingKeyFields(), $this->CreateMasterDetailRecordGridForproductDetailEdit0vslcGrid(), $this->dataset, GetCurrentUserGrantForDataSource('vslc.'), 'UTF-8');
            
            $pageEdit->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('vslc.'));
            $pageEdit->SetShortCaption('Product');
            $pageEdit->SetHeader(GetPagesHeader());
            $pageEdit->SetFooter(GetPagesFooter());
            $pageEdit->SetCaption('Product');
            $pageEdit->SetHttpHandlerName('productDetailEdit0vslc_handler');
            $handler = new PageHTTPHandler('productDetailEdit0vslc_handler', $pageEdit);
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
        $Page = new vslcPage("vslc.php", "vslc", GetCurrentUserGrantForDataSource("vslc"), 'UTF-8');
        $Page->SetShortCaption('SLC');
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetCaption('SLC Groups');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("vslc"));
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
	
