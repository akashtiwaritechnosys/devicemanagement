<form id="detailView" method="POST">
    {include file='DetailViewBlockView.tpl'|@vtemplate_path:$MODULE_NAME RECORD_STRUCTURE=$RECORD_STRUCTURE MODULE_NAME=$MODULE_NAME}
    {include file='LineItemsDetailShortDam1.tpl'|@vtemplate_path:'PeriodicalMaintainence'}
</form>
