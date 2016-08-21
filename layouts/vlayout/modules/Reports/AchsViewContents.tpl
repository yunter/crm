{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/
-->*}
{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/
-->*}
{strip}
	<input type="hidden" id="pageStartRange" value="{$PAGING_MODEL->getRecordStartRange()}" />
	<input type="hidden" id="pageEndRange" value="{$PAGING_MODEL->getRecordEndRange()}" />
	<input type="hidden" id="previousPageExist" value="{$PAGING_MODEL->isPrevPageExists()}" />
	<input type="hidden" id="nextPageExist" value="{$PAGING_MODEL->isNextPageExists()}" />
	<input type="hidden" id="numberOfEntries" value= "{$LISTVIEW_ENTRIES_COUNT}" />
	<input type="hidden" id="totalCount" value="{$LISTVIEW_COUNT}" />
	<input type='hidden' id='pageNumber' value="{$PAGE_NUMBER}" >
	<input type='hidden' id='pageLimit' value="{$PAGING_MODEL->getPageLimit()}">
	<input type="hidden" id="noOfEntries" value="{$LISTVIEW_ENTRIES_COUNT}">
	<div class="listViewEntriesDiv contents-bottomscroll">

			<table class="table table-bordered listViewEntriesTable">
				<caption style="line-height: 35px;font-size: larger">
					<form method="post" name="c_form">
						<select name="c_year" id="c_year" style="width: 120px;">
							<option value="2016" {if $C_YEAR eq '2016'} selected="selected" {/if}>2016</option>
							<option value="2017" {if $C_YEAR eq '2017'} selected="selected" {/if}>2017</option>
							<option value="2018" {if $C_YEAR eq '2018'} selected="selected" {/if}>2018</option>
							<option value="2019" {if $C_YEAR eq '2019'} selected="selected" {/if}>2019</option>
							<option value="2020" {if $C_YEAR eq '2020'} selected="selected" {/if}>2020</option>
						</select>
						<select name="c_month" id="c_month" style="width: 120px;">
							<option value="01" {if $C_MONTH eq '01'} selected="selected" {/if}>01</option>
							<option value="02" {if $C_MONTH eq '02'} selected="selected" {/if}>02</option>
							<option value="03" {if $C_MONTH eq '03'} selected="selected" {/if}>03</option>
							<option value="04" {if $C_MONTH eq '04'} selected="selected" {/if}>04</option>
							<option value="05" {if $C_MONTH eq '05'} selected="selected" {/if}>05</option>
							<option value="06" {if $C_MONTH eq '06'} selected="selected" {/if}>06</option>
							<option value="07" {if $C_MONTH eq '07'} selected="selected" {/if}>07</option>
							<option value="08" {if $C_MONTH eq '08'} selected="selected" {/if}>08</option>
							<option value="09" {if $C_MONTH eq '09'} selected="selected" {/if}>09</option>
							<option value="10" {if $C_MONTH eq '10'} selected="selected" {/if}>10</option>
							<option value="11" {if $C_MONTH eq '11'} selected="selected" {/if}>11</option>
							<option value="12" {if $C_MONTH eq '12'} selected="selected" {/if}>12</option>
						</select>
						<button type="submit" style="line-height: 22px;margin-top: -10px;">确认</button>
					</form>
					<span>{$C_MONTH}月销售业绩 ({$START_TIME}至{$END_TIME})</span></caption>
				<thead>
				<tr class="listViewHeaders">
					<th>排名</th>
					<th>员工姓名</th>
					<th>参展人数</th>
					<th>展位数</th>
					<th>销售额</th>
				</tr>
				</thead>
				<tbody>
				{foreach key=ODS item=LISTVIEW_ENTRY from=$ACHS name=listview}
					<tr class="listViewEntries">
						<td>
							{$ODS+ 1}
						</td>
						{foreach key=LISTVIEW_HEADER_KEY item=LISTVIEW_DATA from=$LISTVIEW_ENTRY}
							<td>
								{$LISTVIEW_DATA}
							</td>
						{/foreach}
					</tr>
				{/foreach}
				</tbody>
			</table>

		<table class="table table-bordered listViewEntriesTable">
			<caption style="line-height: 35px;font-size: larger">上月销售业绩 ({$T_START_TIME}至{$T_END_TIME})</caption>
			<thead>
			<tr class="listViewHeaders">
				<th>排名</th>
				<th>员工姓名</th>
				<th>参展人数</th>
				<th>展位数</th>
				<th>销售额</th>
			</tr>
			</thead>
			<tbody>
			{foreach key=TODS item=TLISTVIEW_ENTRY from=$TACHS name=tlistview}
				<tr class="listViewEntries">
					<td>
						{$TODS+ 1}
					</td>
					{foreach key=TLISTVIEW_HEADER_KEY item=TLISTVIEW_DATA from=$TLISTVIEW_ENTRY}
						<td>
							{$TLISTVIEW_DATA}
						</td>
					{/foreach}
				</tr>
			{/foreach}
			</tbody>
		</table>

		<table class="table table-bordered listViewEntriesTable">
			<caption style="line-height: 35px;font-size: larger">半年内销售业绩 ({$H_START_TIME}至{$H_END_TIME})</caption>
			<thead>
			<tr class="listViewHeaders">
				<th>排名</th>
				<th>员工姓名</th>
				<th>参展人数</th>
				<th>展位数</th>
				<th>销售额</th>
			</tr>
			</thead>
			<tbody>
			{foreach key=HODS item=HLISTVIEW_ENTRY from=$HACHS name=hlistview}
				<tr class="listViewEntries">
					<td>
						{$HODS+ 1}
					</td>
					{foreach key=HLISTVIEW_HEADER_KEY item=HLISTVIEW_DATA from=$HLISTVIEW_ENTRY}
						<td>
							{$HLISTVIEW_DATA}
						</td>
					{/foreach}
				</tr>
			{/foreach}
			</tbody>
		</table>
		<table class="table table-bordered listViewEntriesTable">
			<caption style="line-height: 35px;font-size: larger">年度销售业绩 ({$Y_START_TIME}至{$Y_END_TIME})</caption>
			<thead>
			<tr class="listViewHeaders">
				<th>排名</th>
				<th>员工姓名</th>
				<th>参展人数</th>
				<th>展位数</th>
				<th>销售额</th>
			</tr>
			</thead>
			<tbody>
			{foreach key=YODS item=YLISTVIEW_ENTRY from=$YACHS name=ylistview}
				<tr class="listViewEntries">
					<td>
						{$YODS+ 1}
					</td>
					{foreach key=YLISTVIEW_HEADER_KEY item=YLISTVIEW_DATA from=$YLISTVIEW_ENTRY}
						<td>
							{$YLISTVIEW_DATA}
						</td>
					{/foreach}
				</tr>
			{/foreach}
			</tbody>
		</table>
			<!--added this div for Temporarily -->
			{if $LISTVIEW_ENTRIES_COUNT eq '0'}
				<table class="emptyRecordsDiv">
					<tbody>
					<tr>
						<td>
							{assign var=SINGLE_MODULE value="SINGLE_$MODULE"}
							{vtranslate('LBL_EQ_ZERO')} {vtranslate($MODULE, $MODULE)} {vtranslate('LBL_FOUND')}. {vtranslate('LBL_CREATE')} <a href="{$MODULE_MODEL->getCreateRecordUrl()}&folderid={$VIEWNAME}">{vtranslate($SINGLE_MODULE, $MODULE)}</a>
						</td>
					</tr>
					</tbody>
				</table>
			{/if}
	</div>

	</div>
	</div>
	</div>
{/strip}
