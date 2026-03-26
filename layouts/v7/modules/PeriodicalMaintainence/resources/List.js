Vtiger_List_Js("PeriodicalMaintainence_List_Js", {}, {

    registerRowClickEvent: function () {
        var rows = jQuery('tr.listViewEntries');

        rows.each(function () {
            var row = jQuery(this);
            row.off('click'); 
            row.on('click', function (e) {
                if (
                    jQuery(e.target).is('input[type="checkbox"]') ||
                    jQuery(e.target).is('a') ||
                    jQuery(e.target).closest('button').length > 0
                ) {
                    return;
                }

                var url = row.data('recordurl');
                if (typeof url !== "undefined" && url !== "") {
                    window.open(url, '_blank'); 
                }
            });
        });
    },

    registerEvents: function () {
        this._super();
        this.registerRowClickEvent();
    }
});

