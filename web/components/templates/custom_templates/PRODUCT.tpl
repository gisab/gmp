{php}
/*
function recursive($array, $level = 1){
    foreach($array as $key => $value){
        //If $value is an array.
        if(is_array($value)){
            //We need to loop through it.
          if ($level<3){
            recursive($value, $level + 1);
          }
        } else{
            //It is not an array, so print it out.
            echo str_repeat("-", $level);
            echo $key . ": ";
            try{
               echo $value;
            } catch (Exception $e)
            { 
               //echo "no stringable" .$e->getMessage(), '<br>'
               echo '2';
            }
            echo '<br>';
        }
    }
}

//echo "/*";
//echo "<pre>";
//$x=get_defined_vars();
//$dump=recursive($x,True);
//$fp = fopen("/Users/Sabella/dev/gmp/web/dump.txt", "w");
//fwrite($fp, $dump);
//fclose($fp);
//echo "</pre>";
//echo "";
*/
{/php}

{literal}

    <script src="http://www.google.com/jsapi?key=AIzaSyBBadLaxIFVsyvzOfRQ4QUzD-B_DIjPYyU"></script> 
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
    <script type="text/javascript" src="js/polygon.min.js"></script>
    <script type="text/javascript" src="js/gisab.js"></script>
<!--
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="js/jquery.datetimepicker.css">
    <script type="text/javascript" src="js/jquery.datetimepicker.js"></script>
-->
    
<script type="text/javascript">
        $(function(){
         //create map
        var myOptions = {
           zoom: 2,
           center: new google.maps.LatLng(35, 0),
           mapTypeId: google.maps.MapTypeId.ROADMAP
           }
        map = new google.maps.Map(document.getElementById('map'), myOptions);

{/literal}{php}
//echo "/*";
//$x=get_defined_vars();
//print_r($x);
//echo "*/";

        echo "var polys=['";

        $DataGrid=$this->get_template_vars('DataGrid');

        foreach ($DataGrid['Rows'] as $row){
           if ($row['DataCells']['kml']['Data']!='#'){
              echo $row['DataCells']['wkt']['Data'] ."','";
           }
        }

        echo "'];";
{/php}{literal}
		 
        for (i = 0; i < polys.length; i++) {
            //document.write(polys[i]);
            tmp = parsePolyStrings(polys[i]);
            //document.write('\nGenerated tmp');
            //document.write(tmp);
            if (tmp.length) {
                //document.write('<br>adding poly');
                polys[i] = new google.maps.Polygon({
                    paths : tmp,
                    strokeColor : '#FF0000',
                    strokeOpacity : 0.8,
                    strokeWeight : 2,
                    fillColor : '#FF0000',
                    fillOpacity : 0.35
                });
                polys[i].setMap(map);
            }
        }
		 
         // show current filter text in the out div
         $('#out').empty();
         var filter = getCookie("filter");
	     $('#out').append(filter);
	     tmp=parsePolyStrings(filter);
         if (tmp.length) {
                //document.write('<br>adding poly');
                filterpolig = new google.maps.Polygon({
                    paths : tmp,
                    strokeColor : '#FF0000',
                    strokeOpacity : 0.7,
                    strokeWeight : 2,
                    fillColor : '#FFFF99',
                    fillOpacity : 0.2
                });
                filterpolig.setMap(map);
                //get bounds and center map
                bounds=filterpolig.getBounds();
                map.fitBounds(bounds);
         }	     
	     
		 var creator = new PolygonCreator(map);
		 
		 //reset
		 $('#reset').click(function(){ 
                filterpolig.setMap(null);
		 		filterpolig=null;
		 		filterpolig= new Array();
		 		var filter="";
                $('#out').empty();
                setCookie('filter','',1);
		 });		 
		 
		 //search paths
		 $('#search').click(function(){ 
		 		$('#out').empty();
		 		if(null==creator.showData()){
		 			$('#out').append('Please first create a polygon');
		 		}else{
		 		    var polig=creator.showData();
		 			$('#out').append(polig);
		 			setCookie('filter',polig,1);
		 			window.location.reload();
		 		}
		 });	
		 	 
		 //reload
		 $('#reload').click(function(){ 
		    window.location.reload();
		 });		 
		 
	});	
	</script>

      <input id="reset" value="Clear" type="button" class="navi"/>
      <input id="search" value="Search" type="button" class="navi"/>
      <input id="reload" value="Reload" type="button" class="navi"/>
<!--
      <script>
      $(function() {
        $('#datepickerfrom').datetimepicker({ dateFormat: "yy-mm-dd", timeFormat:  "HH:mm"});
        $('#datepickerto').datetimepicker({ dateFormat: "yy-mm-dd", timeFormat:  "HH:mm"});
      });
      </script>
      From: <input type="text" id="datepickerfrom">
      To: <input type="text" id="datepickerto">
-->
      <div id="map" style='border: 1px solid silver; height: 500px; width: 100%;'></div>
      <div id="out" style='border: 0px solid silver; font-size: 8pt; height: 30px; width: 100%;'></div>

{/literal}

<table
    id="{$DataGrid.Id}"
    class="pgui-grid grid legacy {$DataGrid.Classes}"
    data-grid-hidden-values="{$DataGrid.HiddenValuesJson|escape:'html'}"
    data-inline-edit="{ldelim} &quot;enabled&quot;:&quot;{jsbool value=$DataGrid.UseInlineEdit}&quot;, &quot;request&quot;:&quot;{$DataGrid.Links.InlineEditRequest|escapeurl}&quot{rdelim}"
    {style_block}
        {$DataGrid.Styles}
    {/style_block}
    {$DataGrid.Attributes}>
<thead>
    {if $DataGrid.ActionsPanelAvailable}
    <tr>
        <td colspan="{$DataGrid.ColumnCount}" class="header-panel">
            <div class="btn-toolbar pull-left">
                <div class="btn-group">
                {if $DataGrid.ActionsPanel.InlineAdd}
                    <button class="btn inline_add_button" href="#">
                        <i class="pg-icon-add-record"></i>
                        {$Captions->GetMessageString('AddNewRecord')}
                    </button>
                {/if}

                {if $DataGrid.ActionsPanel.AddNewButton}
                    {if $DataGrid.ActionsPanel.AddNewButton eq 'modal'}
                        <button class="btn"
                                dialog-title="{$Captions->GetMessageString('AddNewRecord')}"
                                content-link="{$DataGrid.Links.ModalInsertDialog}"
                                modal-insert="true">
                            <i class="pg-icon-add-record"></i>
                            {$Captions->GetMessageString('AddNewRecord')}
                        </button>
                    {else}
                        <a class="btn" href="{$DataGrid.Links.SimpleAddNewRow|escapeurl}">
                            <i class="pg-icon-add-record"></i>
                            {$Captions->GetMessageString('AddNewRecord')}
                        </a>
                    {/if}
                {/if}

                    {if $DataGrid.ActionsPanel.DeleteSelectedButton}
                        <button class="btn delete-selected">
                            <i class="pg-icon-delete-selected"></i>
                            {$Captions->GetMessageString('DeleteSelected')}
                        </button>
                    {/if}

                    {if $DataGrid.ActionsPanel.RefreshButton}
                        <a class="btn" href="{$DataGrid.Links.Refresh|escapeurl}">
                            <i class="pg-icon-page-refresh"></i>
                            {$Captions->GetMessageString('Refresh')}
                        </a>
                    {/if}
                </div>
            </div>

            {if $DataGrid.AllowQuickFilter}
            <div id="quick-filter-toolbar" class="btn-toolbar pull-right">
                <div class="btn-group">
                    <div class="input-append" style="float: left; margin-bottom: 0;">
                        <input placeholder="{$Captions->GetMessageString('QuickSearch')}" type="text" size="16" class="quick-filter-text" value="{$DataGrid.QuickFilter.Value|escape:html}"><button type="button" class="btn quick-filter-go"><i class="pg-icon-quick-find"></i></button><button type="button" class="btn quick-filter-reset"><i class="pg-icon-filter-reset"></i></button>
                    </div>
                </div>
            </div>
            {/if}
        </td>
    </tr>
    {/if}

    <tr class="addition-block messages hide">
        <td colspan="{$DataGrid.ColumnCount}">
            {if $DataGrid.ErrorMessage}
            <div class="alert alert-error">
                <button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>
                {$DataGrid.ErrorMessage}
            </div>
            {/if}
            {if $DataGrid.GridMessage}
                <div class="alert alert-success">
                    <button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>
                    {$DataGrid.GridMessage}
                </div>
            {/if}

        </td>
    </tr>

    <tr class="header">
    {if $DataGrid.AllowDeleteSelected}
        <th class="row-selection"><input type="checkbox"></th>
    {/if}

    {if $DataGrid.HasDetails}
        <th>
            <a class="expand-all-details collapsed" href="#">
                <i class="toggle-detail-icon"></i>
            </a>
        </th>
    {/if}

    {if $DataGrid.ShowLineNumbers}
        <th>#</th>
    {/if}
        
    <!-- <Grid Head Columns> -->
    {foreach item=Band from=$DataGrid.Bands}
        {if $Band.ConsolidateHeader and $Band.ColumnCount > 0}
            <th colspan="{$Band.ColumnCount}">
                {$Band.Caption}
            </th>
        {else}
            {foreach item=Column from=$Band.Columns}
                <th class="{$Column.Classes}"
                    {$Column.Attributes}
                    {style_block}{$Column.Styles}{/style_block}
                    data-sort-url="{$Column.SortUrl|escapeurl}"
                    data-field-caption="{$Column.Caption}"
                    data-comment="{$Column.Comment}">
                    <i class="additional-info-icon"></i>
                    <span {if $Column.Comment}class="commented"{/if}>{$Column.Caption}</span>
                    <i class="sort-icon"></i>
                </th>
            {/foreach}
        {/if}
    {/foreach}
    </tr>

    {if $DataGrid.AllowFilterRow and count($DataGrid.FilterRow.Columns) > 0}
    <tr class="addition-block search-line"  dir="ltr" timer-interval="{$DataGrid.FilterRow.TimerInterval}">
        {if $DataGrid.AllowDeleteSelected}
            <td></td>
        {/if}

        {if $DataGrid.HasDetails}
            <td></td>
        {/if}

        {if $DataGrid.ShowLineNumbers}
            <td></td>
        {/if}

        {foreach item=SearchColumn from=$DataGrid.FilterRow.Columns}
            {if $SearchColumn.ResetButtonPlacement}
            <td>
                <div style="text-align: {$SearchColumn.ResetButtonAlignment}">
                    <a href="#" class="reset-filter-row" title="{$Captions->GetMessageString('ResetFilterRow')}"><i  class="pg-icon-filter-builder-reset"></i></a>
                </div>
            </td>
            {else}
            <td class="column-filter">
                {if $SearchColumn}
                <table style="padding: 0;">
                    <tr>
                        <td style="padding: 0;">
                            <div style="white-space: nowrap; margin: 0;" class="input-append btn-group filter-control" data-field-name="{$SearchColumn.FieldName}" data-operator="{$SearchColumn.CurrentOperator.Name}">
                                <input type="text" class="input" value="{$SearchColumn.Value|escape:html}" {$SearchColumn.Attributes}>
                            </div>
                        </td>

                        <td style="padding: 0; overflow: visible;">
                            <div class="btn-group">
                            <a style="white-space: nowrap; " class="btn dropdown-toggle operator-dropdown" data-toggle="dropdown" href="#">
                                <i class="{$SearchColumn.CurrentOperator.ImageClass}"></i>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu pull-right operator-menu">
                                {foreach from=$SearchColumn.Operators item=Operator}
                                    <li><a href="#" data-operator="{$Operator.Name}">
                                        <i class="{$Operator.ImageClass}"></i>
                                        {$Operator.Caption}</a>
                                    </li>
                                {/foreach}
                            </ul>
                            </div>
                        </td>
                    </tr>
                </table>
                {/if}
            </td>
            {/if}

        {/foreach}
    </tr>
    {/if}
</thead>

<tbody>
	<tr class="new-record-row" style="display: none;" data-new-row="false">

        {if $DataGrid.AllowDeleteSelected}
            <td data-column-name="sm_multi_delete_column"></td>
        {/if}

        {if $DataGrid.HasDetails}
            <td class="details">
                <a class="expand-details collapsed" href="#"><i class="toggle-detail-icon"></i></a>
            </td>
        {/if}

        {if $DataGrid.ShowLineNumbers}
            <td class="line-number"></td>
        {/if}

        {foreach item=Band from=$DataGrid.Bands}
            {foreach item=Column from=$Band.Columns}
                <td data-column-name="{$Column.Name}"></td>
            {/foreach}
        {/foreach}
    </tr>


    {include file=$SingleRowTemplate}

    <tr class="empty-grid{if count($DataGrid.Rows) > 0} hide{/if}">
        <td colspan="{$DataGrid.ColumnCount}" class="empty-grid">
            {$DataGrid.EmptyGridMessage}
        </td>
    </tr>

</tbody>

<tfoot>
    {if $DataGrid.Totals}
    <tr class="data-summary">
        {if $DataGrid.AllowDeleteSelected}
            <td></td>
        {/if}

        {if $DataGrid.HasDetails}
            <td></td>
        {/if}

        {if $DataGrid.ShowLineNumbers}
            <td></td>
        {/if}

        {foreach item=Total from=$DataGrid.Totals}
            <td>{$Total.Value}</td>
        {/foreach}
    </tr>
    {/if}

    {if $DataGrid.FilterBuilder}
    <tr>
        <td colspan="{$DataGrid.ColumnCount}" class="addition-block filter-builder-row">
            {if $IsActiveFilterEmpty}
                <i class="pg-icon-filter-new"></i>
                <a class="create-filter" href="#">
                {$Captions->GetMessageString('CreateFilter')}
            </a>
            {else}
                <i class="pg-icon-filter"></i>
                <a class="edit-filter" href="#">
                    {$ActiveFilterBuilderAsString|escapeurl}
                </a>

                <i class="pg-icon-filter-builder-reset"></i>
                <a class="reset-filter" href="#">
                    {$Captions->GetMessageString('ResetFilter')}
                </a>
            {/if}
        </td>
    </tr>
    {/if}
</tfoot>

</table>

<script type="text/javascript">

    {if $AdvancedSearchControl}
    {literal}
            require(['pgui.text_highlight'], function(textHighlight) {
    {/literal}
    {foreach from=$AdvancedSearchControl->GetHighlightedFields() item=HighlightFieldName name=HighlightFields}
        textHighlight.HighlightTextInGrid(
                '#{$DataGrid.Id}', '{$HighlightFieldName}',
                {$TextsForHighlight[$smarty.foreach.HighlightFields.index]},
                '{$HighlightOptions[$smarty.foreach.HighlightFields.index]}');
    {/foreach}
    {literal}
    });
    {/literal}
    {/if}


    {literal}
    $(function() {
        var gridId = '{/literal}{$DataGrid.Id}{literal}';
        var $gridContainer = $('#' + gridId);

        require(['pgui.grid', 'pgui.advanced_filter'], function(pggrid, fb) {

            var grid = new pggrid.Grid($gridContainer);

            grid.onConfigureFilterBuilder(function(filterBuilder) {
            {/literal}
                {foreach item=FilterBuilderField from=$FilterBuilder.Fields}
                filterBuilder.addField(
                        {jsstring value=$FilterBuilderField.Name},
                        {jsstring value=$FilterBuilderField.Caption},
                        fb.FieldType.{$FilterBuilderField.Type},
                        fb.{$FilterBuilderField.EditorClass},
                        {$FilterBuilderField.EditorOptions});
                {/foreach}
            {literal};
            });

            var activeFilterJson = {/literal}{$ActiveFilterBuilderJson}{literal};
            var activeFilter = new fb.Filter();
            activeFilter.fromJson(activeFilterJson);
            grid.setFilter(activeFilter);
        });
    });
    {/literal}
</script>