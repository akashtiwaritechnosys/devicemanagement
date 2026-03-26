{literal}
    <div class="row portal-controls-row">
        <div class="col-lg-4 col-md-2 col-sm-4 col-xs-5 top_space">
            <div class="btn-group addbtnContainer" ng-if="isCreatable">
                <button type="button" translate= "Add {{igModuleTransLatedLabel}}" class="btn btn-soft-primary" ng-click="create()"></button>
            </div>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12 top_space helpdesk_mobile">
            <div class="row" ng-if="activateStatus">
                <div class="col-xs-12 selectric_mob">
                    <hp-selectric items="ticketStatus" ng-model="searchQ.ticketstatus"></hp-selectric>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12 pagination-holder top_space">
            <div class="pull-right">
                <div class="text-center">
                    <pagination
                            total-items="totalPages" max-size="3" ng-model="currentPage" ng-change="pageChanged(currentPage)" boundary-links="true">
                    </pagination>
                </div>
            </div>
        </div>
    </div>
    <input name="visited" type="hidden" ng-init="beforeRefresh='0'" ng-model="beforeRefresh">
{/literal}
