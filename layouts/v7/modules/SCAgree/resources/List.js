Inventory_List_Js("SCAgree_List_Js",{},{
    registerRowClickEvent: function () {
        var thisInstance = this;
        var rows = jQuery('tr.listViewEntries');

        rows.each(function () {
            var row = jQuery(this);
            row.off('click'); // Remove any existing click event to prevent duplicate handlers
            row.on('click', function (e) {
                // Ignore clicks on checkbox, links, or action buttons
                if (
                    jQuery(e.target).is('input[type="checkbox"]') ||
                    jQuery(e.target).is('a') ||
                    jQuery(e.target).closest('button').length > 0
                ) {
                    return;
                }

                var url = row.data('recordurl');
                if (typeof url !== "undefined" && url !== "") {
                    window.open(url, '_blank'); // Open ticket in new tab
                }
            });
        });
    },

    registerEvents: function () {
        this._super(); // Call parent method
        this.registerRowClickEvent(); // Register custom behavior
    }
});