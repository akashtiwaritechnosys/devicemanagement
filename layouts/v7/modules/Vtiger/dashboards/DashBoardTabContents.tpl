{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
*************************************************************************************}

{strip}
  <div class='dashBoardTabContainer'>
    {include file="dashboards/DashBoardHeader.tpl"|vtemplate_path:$MODULE_NAME DASHBOARDHEADER_TITLE=vtranslate($MODULE, $MODULE)}
    <br>
    <div class="dashboardBanner"></div>

    {*	highlight-card start here *}

    <div class="highlight-card-container">
      <div class="row">
        <!-- Bookings -->
        <div class="col-sx-6 col-sm-6 col-md-4 col-lg-3">
          <div class="highlight-card">
            <div class="highlight-card-header">
              <div class="icon-box primary-color">
                <img src="layouts/v7/skins/images/ticket.svg" alt="ticket" />
              </div>
              <div class="highlight-card-content">
                <div>
                  <p class="highlight-title">Sales Orders</p>
                </div>
                <div>
                  <h3 class="highlight-value">{$CardDetails[0]}</h3>
                </div>
              </div>
            </div>
            <hr>
            <div class="card-footer">
              <div class="status"><span>+{$CardDetails[1]}%</span> than last week</div>
            </div>
          </div>
        </div>
        <!-- Today's Users -->
        <div class="col-sx-6 col-sm-6 col-md-4 col-lg-3">
          <div class="highlight-card">
            <div class="highlight-card-header">
              <div class="icon-box dark-blue-color">
                <img src="layouts/v7/skins/images/benefits.svg" alt="ticket" />
              </div>
              <div class="highlight-card-content">
                <div>
                  <p class="highlight-title">Today's Leads</p>
              </div>
              <div>
                <h3 class="highlight-value">{$LeadCardDetails[0]}</h3>
              </div>
            </div>
          </div>
          <hr>
          <div class="card-footer">
            <div class="status"><span>+{$LeadCardDetails[1]}%</span> than last month</div>
          </div>
        </div>
      </div>
      <!-- Revenue -->
      <div class="col-sx-6 col-sm-6 col-md-4 col-lg-3">
        <div class="highlight-card">
          <div class="highlight-card-header">
            <div class="icon-box green-color">
              <img src="layouts/v7/skins/images/revenue.svg" alt="ticket" />
            </div>
            <div class="highlight-card-content">
              <div>
                <p class="highlight-title">Revenue</p>
              </div>
              <div>
                <h3 class="highlight-value">{$RevnueChange[0]}</h3>
              </div>
            </div>
          </div>
          <hr>
          <div class="card-footer">
            <div class="status">
              <span>
                {if $CardDetailsRevenue[1] == 'New'}New
                {elseif $CardDetailsRevenue[1] > 0}+{$CardDetailsRevenue[1]}%
                {elseif $CardDetailsRevenue[1] < 0}{$CardDetailsRevenue[1]}%
                {else}0%{/if}
              </span> than yesterday
            </div>
          </div>
        </div>
      </div>
      <!-- Followers -->
      <div class="col-sx-6 col-sm-6 col-md-4 col-lg-3">
        <div class="highlight-card">
          <div class="highlight-card-header">
            <div class="icon-box pink-color">
              <img src="layouts/v7/skins/images/add-user.svg" alt="followers" />
            </div>
            <div class="highlight-card-content">
              <div>
                <p class="highlight-title">Followers</p>
              </div>
              <div>
                <h3 class="highlight-value">{$CardDetailsFollowers[0]}</h3>
              </div>
            </div>
          </div>
          <hr>
          <div class="card-footer">
            <div class="status">
              <span>
                {if $CardDetailsFollowers[1] == 'New'}New
                {elseif $CardDetailsFollowers[1] > 0}+{$CardDetailsFollowers[1]}%
                {elseif $CardDetailsFollowers[1] < 0}{$CardDetailsFollowers[1]}%
                {else}0%{/if}
              </span> than yesterday
            </div>
          </div>
        </div>
      </div>

    </div>
    {*	highlight-card end here *}


    <div class="dashBoardTabContents clearfix">
      <div class="gridster_{$TABID}">
        {assign var="ROWCOUNT" value=0}
        {assign var="COLCOUNT" value=0}
        <ul class="test">
          {assign var=COLUMNS value=2}
          {assign var=ROW value=1}
          {foreach from=$WIDGETS item=WIDGET name=count}
          {assign var=WIDGETDOMID value=$WIDGET->get('linkid')}

          {if $WIDGET->getName() eq 'MiniList'}
          {assign var=WIDGETDOMID value=$WIDGET->get('linkid')|cat:'-':$WIDGET->get('widgetid')}
          {elseif $WIDGET->getName() eq 'Notebook'}
          {assign var=WIDGETDOMID value=$WIDGET->get('linkid')|cat:'-':$WIDGET->get('widgetid')}
          {/if}
          {if $WIDGETDOMID}
          <li id="{$WIDGETDOMID}" {if $smarty.foreach.count.index % $COLUMNS == 0 and $smarty.foreach.count.index != 0}
            {assign var=ROWCOUNT value=$ROW+1} data-row="{$WIDGET->getPositionRow($ROWCOUNT)}" {else}
            data-row="{$WIDGET->getPositionRow($ROW)}" {/if}
            {assign var=COLCOUNT value=($smarty.foreach.count.index % $COLUMNS)+1}
            data-col="{$WIDGET->getPositionCol($COLCOUNT)}" data-sizex="{$WIDGET->getSizeX()}"
            data-sizey="{$WIDGET->getSizeY()}" {if $WIDGET->get('position') eq ""} data-position="false" {/if}
            class="dashboardWidget dashboardWidget_{$smarty.foreach.count.index}" data-url="{$WIDGET->getUrl()}"
            data-mode="open" data-name="{$WIDGET->getName()}">
          </li>
          {else}
          {assign var=CHARTWIDGETDOMID value=$WIDGET->get('reportid')}
          {assign var=WIDGETID value=$WIDGET->get('id')}
          <li id="{$CHARTWIDGETDOMID}-{$WIDGETID}"
            {if $smarty.foreach.count.index % $COLUMNS == 0 and $smarty.foreach.count.index != 0}
            {assign var=ROWCOUNT value=$ROW+1} data-row="{$WIDGET->getPositionRow($ROWCOUNT)}" {else}
            data-row="{$WIDGET->getPositionRow($ROW)}" {/if}
            {assign var=COLCOUNT value=($smarty.foreach.count.index % $COLUMNS)+1}
            data-col="{$WIDGET->getPositionCol($COLCOUNT)}" data-sizex="{$WIDGET->getSizeX()}"
            data-sizey="{$WIDGET->getSizeY()}" {if $WIDGET->get('position') eq ""} data-position="false" {/if}
            class="dashboardWidget dashboardWidget_{$smarty.foreach.count.index}" data-url="{$WIDGET->getUrl()}"
            data-mode="open" data-name="ChartReportWidget">
          </li>
          {/if}
          {/foreach}
        </ul>
        <input type="hidden" id=row value="{$ROWCOUNT}" />
        <input type="hidden" id=col value="{$COLCOUNT}" />
        <input type="hidden" id="userDateFormat" value="{$CURRENT_USER->get('date_format')}" />
        </div>
      </div>
    </div>
{/strip}