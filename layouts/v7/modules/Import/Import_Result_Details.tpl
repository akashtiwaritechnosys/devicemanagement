{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
*
********************************************************************************/
-->*}

<table width="100%" class="table table-borderless bg-light-color-2">
	<tr>
		<td class = "secondary-color"><p>{'LBL_TOTAL_RECORDS_IMPORTED'|@vtranslate:$MODULE}</p></td>
		<td width="10%">:</td>
		<td class = "secondary-color" width="30%"><span>{$IMPORT_RESULT.IMPORTED} / {$IMPORT_RESULT.TOTAL}</span></td>
	</tr>
	<tr>
		<td class = "secondary-color" width="20%"><p>{'LBL_NUMBER_OF_RECORDS_CREATED'|@vtranslate:$MODULE}</p></td>
		<td width="1%">:</td>
		<td  class = "secondary-color" width="60%">
			<span>{$IMPORT_RESULT.CREATED}
				{if $IMPORT_RESULT['CREATED'] neq '0'}
					{if $FOR_MODULE neq 'Users'}
						&nbsp;&nbsp;&nbsp;&nbsp;<a class="cursorPointer" onclick="return Vtiger_Import_Js.showLastImportedRecords('index.php?module={$MODULE}&for_module={$FOR_MODULE}&view=List&start=1&foruser={$OWNER_ID}&_showContents=0')">{'LBL_DETAILS'|@vtranslate:$MODULE}</a>
					{/if}
				{/if}
			</span>
		</td>

	</tr>
	{if in_array($FOR_MODULE, $INVENTORY_MODULES) eq FALSE}
		<tr>
			<td><p>{'LBL_NUMBER_OF_RECORDS_UPDATED'|@vtranslate:$MODULE}</p></td>
			<td width="10%">:</td>
			<td width="30%"><span>{$IMPORT_RESULT.UPDATED}</span></td>
		</tr>
		<tr>
			<td><p>{'LBL_NUMBER_OF_RECORDS_SKIPPED'|@vtranslate:$MODULE}</p></td>
			<td width="10%">:</td>
			<td width="30%"><span>{$IMPORT_RESULT.SKIPPED}
				{if $IMPORT_RESULT['SKIPPED'] neq '0'}
					&nbsp;&nbsp;&nbsp;&nbsp;<a class="cursorPointer" onclick="return Vtiger_Import_Js.showSkippedRecords('index.php?module={$MODULE}&view=List&mode=getImportDetails&type=skipped&start=1&foruser={$OWNER_ID}&_showContents=0&for_module={$FOR_MODULE}')">{'LBL_DETAILS'|@vtranslate:$MODULE}</a>
				{/if}
			</span></td>
		</tr>
		<tr>
			<td><p>{'LBL_NUMBER_OF_RECORDS_MERGED'|@vtranslate:$MODULE}</p></td>
			<td width="10%">:</td>
			<td width="10%"><span>{$IMPORT_RESULT.MERGED}</span></td>
		</tr>
	{/if}
	{if $IMPORT_RESULT['FAILED'] neq '0'}
		<tr>
			<td><p><font color = "red">{'LBL_TOTAL_RECORDS_FAILED'|@vtranslate:$MODULE}</font></p></td>
			<td width="10%">:</td>
			<td width="30%"><span></span><font color = "red">{$IMPORT_RESULT.FAILED} / {$IMPORT_RESULT.TOTAL}</font>
				&nbsp;&nbsp;&nbsp;&nbsp;<a class="cursorPointer" onclick="return Vtiger_Import_Js.showFailedImportRecords('index.php?module={$MODULE}&view=List&mode=getImportDetails&type=failed&start=1&foruser={$OWNER_ID}&_showContents=0&for_module={$FOR_MODULE}')">{'LBL_DETAILS'|@vtranslate:$MODULE}</a>
			</span></td>
		</tr>
	{/if}
</table>