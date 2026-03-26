Inventory_Edit_Js(
  "HelpDesk_Edit_Js",
  {
    handleIsAlreadyTicketExistsForEquip: function (e) {
      jQuery.ajaxSetup({ async: false });
      app.helper.showProgress();

      this.callAPIBeforeValidate().then(
        function (data) {
          if (data.isDuplicate) {
            app.helper.showAlertNotification({
              message: data.message,
            });
            e.preventDefault(); // Stop form submission
          }
        },
        function (error) {
          app.helper.showAlertNotification({
            message: error.message,
          });
          e.preventDefault();
        }
      );

      app.helper.hideProgress();
      jQuery.ajaxSetup({ async: true });
    },

    callAPIBeforeValidate: function () {
      var aDeferred = jQuery.Deferred();
      let equipment_id = $("input[name='equipment_id']").val();
      let model_number = $("select[data-fieldname='model_number']").val();
      let ticket_type = $("select[name='ticket_type']").val();
      let recordid = $("#recordId").val();

      var url =
        "module=HelpDesk&action=DuplicateCheckForEquipment&equipment_id=" +
        equipment_id +
        "&model_number=" +
        model_number +
        "&ticket_type=" +
        ticket_type +
        "&recordid=" +
        recordid;

      AppConnector.request(url).then(
        function (data) {
          if (data["success"]) {
            aDeferred.resolve({ isDuplicate: false });
          } else {
            aDeferred.resolve({ isDuplicate: true, message: data["message"] });
          }
        },
        function (error) {
          aDeferred.reject(error);
        }
      );

      return aDeferred.promise();
    },
  },
  {
    accountsReferenceField: false,
    contactsReferenceField: false,

    initializeVariables: function () {
      this._super();
      var form = this.getForm();
      this.accountsReferenceField = form.find('[name="account_id"]');
      this.contactsReferenceField = form.find('[name="contact_id"]');
    },

    /**
     * Function to get popup params
     */
    getPopUpParams: function (container) {
      var params = this._super(container);
      var sourceFieldElement = jQuery('input[class="sourceField"]', container);
      var referenceModule = jQuery(
        "input[name=popupReferenceModule]",
        container
      ).val();
      if (!sourceFieldElement.length) {
        sourceFieldElement = jQuery("input.sourceField", container);
      }

      if (
        (sourceFieldElement.attr("name") == "contact_id" ||
          sourceFieldElement.attr("name") == "potential_id") &&
        referenceModule != "Leads"
      ) {
        var form = this.getForm();
        var parentIdElement = form.find('[name="account_id"]');
        if (
          parentIdElement.length > 0 &&
          parentIdElement.val().length > 0 &&
          parentIdElement.val() != 0
        ) {
          var closestContainer = parentIdElement.closest("td");
          params["related_parent_id"] = parentIdElement.val();
          params["related_parent_module"] = closestContainer
            .find('[name="popupReferenceModule"]')
            .val();
        } else if (sourceFieldElement.attr("name") == "potential_id") {
          parentIdElement = form.find('[name="contact_id"]');
          var relatedParentModule = parentIdElement
            .closest("td")
            .find('input[name="popupReferenceModule"]')
            .val();
          if (
            parentIdElement.length > 0 &&
            parentIdElement.val().length > 0 &&
            relatedParentModule != "Leads"
          ) {
            closestContainer = parentIdElement.closest("td");
            params["related_parent_id"] = parentIdElement.val();
            params["related_parent_module"] = closestContainer
              .find('[name="popupReferenceModule"]')
              .val();
          }
        }
      }
      return params;
    },

    /**
     * Function which will register event for Reference Fields Selection
     */
    registerReferenceSelectionEvent: function (container) {
      this._super(container);
      var self = this;

      this.accountsReferenceField.on(
        Vtiger_Edit_Js.referenceSelectionEvent,
        function (e, data) {
          self.referenceSelectionEventHandler(data, container);
        }
      );
    },

    /**
     * Function to search module names
     */
    searchModuleNames: function (params) {
      var aDeferred = jQuery.Deferred();

      if (typeof params.module == "undefined") {
        params.module = app.getModuleName();
      }
      if (typeof params.action == "undefined") {
        params.action = "BasicAjax";
      }

      if (typeof params.base_record == "undefined") {
        var record = jQuery('[name="record"]');
        var recordId = app.getRecordId();
        if (record.length) {
          params.base_record = record.val();
        } else if (recordId) {
          params.base_record = recordId;
        } else if (app.view() == "List") {
          var editRecordId = jQuery("#listview-table")
            .find("tr.listViewEntries.edited")
            .data("id");
          if (editRecordId) {
            params.base_record = editRecordId;
          }
        }
      }

      if (
        params.search_module == "Contacts" ||
        params.search_module == "Potentials"
      ) {
        var form = this.getForm();
        if (
          this.accountsReferenceField.length > 0 &&
          this.accountsReferenceField.val().length > 0
        ) {
          var closestContainer = this.accountsReferenceField.closest("td");
          params.parent_id = this.accountsReferenceField.val();
          params.parent_module = closestContainer
            .find('[name="popupReferenceModule"]')
            .val();
        } else if (params.search_module == "Potentials") {
          if (
            this.contactsReferenceField.length > 0 &&
            this.contactsReferenceField.val().length > 0
          ) {
            closestContainer = this.contactsReferenceField.closest("td");
            params.parent_id = this.contactsReferenceField.val();
            params.parent_module = closestContainer
              .find('[name="popupReferenceModule"]')
              .val();
          }
        }
      }

      // Added for overlay edit as the module is different
      if (
        params.search_module == "Products" ||
        params.search_module == "Services"
      ) {
        params.module = "Quotes";
      }

      app.request.get({ data: params }).then(
        function (error, data) {
          if (error == null) {
            aDeferred.resolve(data);
          }
        },
        function (error) {
          aDeferred.reject();
        }
      );
      return aDeferred.promise();
    },
    registerBasicEvents: function (container) {
      this._super(container);
      this.registerForTogglingBillingandShippingAddress();
      this.registerEventForCopyAddress();
      this.registerReferenceSelectionEvent1();
      this.initialBlocking();
      this.mkeMandatoryForSubmittingImage();
      this.mkeMandatoryForSubmittingImage2();
      this.hideresolvedateandtimefields();
      this.hideclosedateandtimefields();
      this.toggleBreakdownField();
      this.toggleCommentField();
      this.toggleLineItemsAndImageUploadBlocks();
    },

    // Add this new method to register the duplicate check
    //   registerEquipmentDuplicateCheck: function() {
    //     var self = this;
    //     var form = this.getForm();

    //     // Check on form submit
    //     form.on('submit', function(e) {
    //         let equipment_id = $("input[name='equipment_id']").val();
    //         let model_number = $("select[data-fieldname='model_number']").val();
    //         let ticket_status = $("select[name='ticketstatus']").val();

    //         // If status is being set to "Closed", allow the submission without validation
    //         if (ticket_status === "Closed") {
    //             return true;
    //         }

    //         // Only perform check if both fields are filled
    //         if (equipment_id && model_number) {
    //             e.preventDefault(); // Prevent form submission until validation completes

    //             // Call validation function from parent scope
    //             HelpDesk_Edit_Js.handleIsAlreadyTicketExistsForEquip.call(self, e);
    //         }
    //     });

    //     // Monitor changes to ticket status - if changed to "Closed", we may need to
    //     // update UI to show it's allowed even with duplicate equipment
    //     $("select[name='ticketstatus']").on('change', function() {
    //         let status = $(this).val();
    //         if (status === "Closed") {
    //             // Optionally add visual indicator that closing is allowed
    //             // For example, change border color or add a message
    //             $(this).css("border-color", "green");

    //             // You could also add/remove a message here
    //             let messageDiv = $("#close-ticket-message");
    //             if (messageDiv.length === 0) {
    //                 $("<div id='close-ticket-message' class='alert alert-info'>Closing this ticket will allow new tickets to be created with this equipment.</div>")
    //                     .insertAfter($(this).closest('.row'));
    //             }
    //         } else {
    //             // Reset any visual indicators
    //             $(this).css("border-color", "");
    //             $("#close-ticket-message").remove();
    //         }
    //     });
    // },

    registerEquipmentDuplicateCheck: function () {
      var self = this;
      var form = this.getForm();

      form.on("submit", function (e) {
        let equipment_id = $("input[name='equipment_id']").val();
        let model_number = $("select[data-fieldname='model_number']").val();
        let ticket_status = $("select[name='ticketstatus']").val();
        let ticket_type = $("select[name='ticket_type']").val();

        // Allow form submission if status is Closed or ticket type is Preventive
        if (
          ticket_status === "Closed" ||
          ticket_type === "PREVENTIVE MAINTENANCE SERVICE"
        ) {
          return true; // Allow form submission
        }

        if (equipment_id && model_number && ticket_type) {
          e.preventDefault(); // Stop form submission until validation is complete

          HelpDesk_Edit_Js.handleIsAlreadyTicketExistsForEquip
            .call(self)
            .then(function (isDuplicate) {
              if (!isDuplicate) {
                form.off("submit").submit(); // Re-trigger form submission if no duplicate
              }
            });
        }
      });
    },

    toggleLineItemsAndImageUploadBlocks: function () {
      const recordId = app.getRecordId(); // Get the current record ID
      const lineItemsBlock = $(".igLineItemBlock"); // Replace with the actual block name/identifier
      const imageUploadBlock = $('[data-block="Upload File Details"]'); // Replace with the actual block name/identifier

      if (!recordId) {
        // If no record ID, it's a new record
        lineItemsBlock.hide(); // Hide the Line Items block
        imageUploadBlock.hide(); // Hide the Image Upload block
      } else {
        // If record ID exists, it's an edit
        lineItemsBlock.show(); // Show the Line Items block
        imageUploadBlock.show(); // Show the Image Upload block
      }
    },

    //for hide/show field based on ticket status(resolved)
    hideresolvedateandtimefields: function () {
      $('input[name="resolved_date"]').closest("td").addClass("hide");
      $('input[name="resolved_date"]').closest("td").prev().addClass("hide");
      $('input[name="resolved_time"]').closest("td").addClass("hide");
      $('input[name="resolved_time"]').closest("td").prev().addClass("hide");

      jQuery('[name="ticketstatus"]').on("click", function (e) {
        var ticketstatusdropdown = jQuery('[name="ticketstatus"]').val();
        if (ticketstatusdropdown == "Resolved") {
          var today = new Date();
          var date =
            today.getDate() +
            "-" +
            (today.getMonth() + 1) +
            "-" +
            today.getFullYear();
          var time = today.getHours() + ":" + today.getMinutes();
          var CurrentDateTime = date + " " + time;
          $("input[name='resolved_date']").val(date);
          $("input[name='resolved_time']").val(time);
        } else {
          $("input[name='resolved_date']").val("");
          $("input[name='resolved_time']").val("");
        }
      });
    },
    //end

    //for hide/show field based on ticket status(closed)
    hideclosedateandtimefields: function () {
      $('input[name="ticket_closedate"]').closest("td").addClass("hide");
      $('input[name="ticket_closedate"]').closest("td").prev().addClass("hide");

      jQuery('[name="ticketstatus"]').on("click", function (e) {
        var ticketstatusdropdown = jQuery('[name="ticketstatus"]').val();
        if (ticketstatusdropdown == "Closed") {
          var today = new Date();
          var date =
            today.getDate() +
            "-" +
            (today.getMonth() + 1) +
            "-" +
            today.getFullYear();
          var time = today.getHours() + ":" + today.getMinutes();
          var CurrentDateTime = date + " " + time;
          $("input[name='ticket_closedate']").val(CurrentDateTime);
        } else {
          $("input[name='ticket_closedate']").val("");
        }
      });
    },
    //end

    // Function to hide/show the t_breakdown field based on ticket_type vaibhavi
    toggleBreakdownField: function () {
      if ($('select[name="t_breakdown"]').val() === "") {
        $('td.fieldLabel:contains("Break Down")').hide();
        $('select[name="t_breakdown"]').closest("td").hide();
      }
      jQuery('[name="ticket_type"]').on("change", function () {
        let selectedValue = jQuery('[name="ticket_type"]').val();
        if (selectedValue === "BREAKDOWN") {
          $('td.fieldLabel:contains("Break Down")').show();
          $('select[name="t_breakdown"]').closest("td").show();
        } else {
          $('td.fieldLabel:contains("Break Down")').hide();
          $('select[name="t_breakdown"]').closest("td").hide();
        }
      });
    },

    toggleCommentField: function () {
      let tCommentField = $('[name="t_comment"]');
      tCommentField.val(""); // Clear the value
      tCommentField.html(""); // Clear the inner HTML to remove hardcoded content

      // Initially disable the Comment field
      $('[name="m_comment"]').prop("disabled", true);
      $('[name="approvepart_comment"]').prop("disabled", true);
      $('[name="approvepart_service"]').prop("disabled", true);
      $('[name="t_comment"]').prop("disabled", true);

      // Listen for changes in the ticket status field
      jQuery('[name="ticketstatus"]').on("change", function () {
        // Get the currently selected value of the ticket status
        let selectedStatus = jQuery('[name="ticketstatus"]').val();

        // Enable the Comment field on any status change
        if (selectedStatus) {
          $('[name="t_comment"]').prop("disabled", false);
          $('[name="m_comment"]').prop("disabled", false);
        } else {
          // Optionally, keep the field disabled if no valid status is selected
          $('[name="t_comment"]').prop("disabled", true);
          $('[name="m_comment"]').prop("disabled", true);
        }
      });
    },
    //end

    mkeMandatoryForSubmittingImage: function () {
      jQuery(".picklistfield").on("change", function (event) {
        let fieldName = $(this).data("extraname");
        let rowNum = $(this).closest("tr").data("row-num");
        let value = event.target.value;
        if (value == "Resolved") {
          $(".helpdeskattach").prop("required", true);
        } else {
          $(".helpdeskattach").prop("required", false);
        }
      });
    },

    mkeMandatoryForSubmittingImage2: function () {
      jQuery('select[name="cf_3038"]').on("change", function (event) {
        // Otherwise, use the name directly
        let fieldName = $(this).data("fieldname"); // will give "cf_3038"

        console.log("Field Name:", fieldName);

        let rowNum = $(this).closest("tr").data("row-num");
        let value = event.target.value;

        if (value === "INSTALLATION" || value === "RE-INSTALLATION") {
          $('input[name="ins_uploadimage[]"]').prop("required", true);
        } else {
          $('input[name="ins_uploadimage[]"]').prop("required", false);
        }
      });
    },

    registerReferenceSelectionEvent1: function (container) {
      var self = this;
      jQuery('input[name="parent_id"]', container).on(
        Vtiger_Edit_Js.referenceSelectionEvent,
        function (e, data) {
          self.autofill();
        }
      );

      jQuery('input[name="equipment_id"]', container).on(
        Vtiger_Edit_Js.referenceSelectionEvent,
        function (e, data) {
          self.autofillAllDeatails();
        }
      );
    },
    initialBlocking: function () {
      $("textarea[name='address']")
        .css("background-color", "#eeeeee !important")
        .attr("readonly", "readonly");
      $("input[name='product_modal']")
        .css("background-color", "#eeeeee !important")
        .attr("readonly", "readonly");
      $("input[name='warrenty_period']")
        .css("background-color", "#eeeeee !important")
        .attr("readonly", "readonly");
      $("input[name='productname']")
        .css("background-color", "#eeeeee !important")
        .attr("readonly", "readonly");
      $('[data-fieldname="product_subcategory"]').attr("readonly", "readonly");
      $('[data-fieldname="product_category"]').attr("readonly", "readonly");
      $("input[name='customer_name']")
        .css("background-color", "#eeeeee !important")
        .attr("readonly", "readonly");
      $("input[name='mobile']")
        .css("background-color", "#eeeeee !important")
        .attr("readonly", "readonly");
      $("input[name='product_name']")
        .css("background-color", "#eeeeee !important")
        .attr("readonly", "readonly");
      $("input[name='helpdesk_city']")
        .css("background-color", "#eeeeee !important")
        .attr("readonly", "readonly");
      $("input[name='helpdesk_state']")
        .css("background-color", "#eeeeee !important")
        .attr("readonly", "readonly");
      $("input[name='helpdesk_pincode']")
        .css("background-color", "#eeeeee !important")
        .attr("readonly", "readonly");
      $("input[name='helpdesk_country']")
        .css("background-color", "#eeeeee !important")
        .attr("readonly", "readonly");
      $("input[name='helpdesk_district']")
        .css("background-color", "#eeeeee !important")
        .attr("readonly", "readonly");
      $("input[name='periodic_date']")
        .css("background-color", "#eeeeee !important")
        .attr("readonly", "readonly");
    },
    autofill: function () {
      let dataOf = {};
      dataOf["record"] = $("input[name=parent_id]").val();
      dataOf["source_module"] = "Accounts";
      dataOf["module"] = "HelpDesk";
      dataOf["action"] = "GetAllInfoCust";
      app.helper.showProgress();
      app.request.get({ data: dataOf }).then(function (err, response) {
        if (err == null) {
          $("textarea[name='address']")
            .val(response.data.address)
            .css("background-color", "#eeeeee !important")
            .attr("readonly", "readonly");
          $("input[name='product_modal']")
            .val(response.data.model_number)
            .css("background-color", "#eeeeee !important")
            .attr("readonly", "readonly");
          $("input[name='warrenty_period']")
            .val(response.data.warrenty_period)
            .css("background-color", "#eeeeee !important")
            .attr("readonly", "readonly");
          $("input[name='productname']")
            .val(response.data.productname)
            .css("background-color", "#eeeeee !important")
            .attr("readonly", "readonly");
          let product_subcategory = response.data.product_subcategory;
          $('.product_subcategory  option[value="' + product_subcategory + '"]')
            .attr("selected", "selected")
            .trigger("change");
          $('[data-fieldname="product_subcategory"]').attr(
            "readonly",
            "readonly"
          );

          let product_category = response.data.product_category;
          $('.product_category  option[value="' + product_category + '"]')
            .attr("selected", "selected")
            .trigger("change");
          $('[data-fieldname="product_category"]').attr("readonly", "readonly");

          $("input[name='customer_name']")
            .val(response.data.accountname)
            .css("background-color", "#eeeeee !important")
            .attr("readonly", "readonly");
          $("input[name='mobile']")
            .val(response.data.phone)
            .css("background-color", "#eeeeee !important")
            .attr("readonly", "readonly");
          $("input[name='product_name']")
            .val(response.data.productname)
            .css("background-color", "#eeeeee !important")
            .attr("readonly", "readonly");
          app.helper.hideProgress();
        }
      });
    },

    autofillAllDeatails: function () {
      let dataOf = {};
      let self = this;
      dataOf["record"] = $("input[name=equipment_id]").val();
      dataOf["source_module"] = "Equipment";
      dataOf["module"] = "HelpDesk";
      dataOf["action"] = "GetAllInfoEquipment";
      app.helper.showProgress();
      app.request.get({ data: dataOf }).then(function (err, response) {
        if (err == null) {
          let referenceFields = { account_id: "parent_id", id: "" };
          for (var key in referenceFields) {
            let value = referenceFields[key];
            self.seletctTheMarkVendor(
              response["data"][key],
              response["data"][key + "_label"],
              value
            );
          }
          self.seletctTheMarkVendor(
            response["data"]["id"],
            response["data"]["equipment_serialno"],
            "equipment_id"
          );

          $("textarea[name='address']")
            .val(response.data.bill_street)
            .css("background-color", "#eeeeee !important")
            .attr("readonly", "readonly");
          $("input[name='product_modal']")
            .val(response.data.model_number)
            .css("background-color", "#eeeeee !important")
            .attr("readonly", "readonly");
          $("input[name='warrenty_period']")
            .val(response.data.war_in_months)
            .css("background-color", "#eeeeee !important")
            .attr("readonly", "readonly");
          $("input[name='productname']")
            .val(response.data.productname)
            .css("background-color", "#eeeeee !important")
            .attr("readonly", "readonly");

          // let model_number = response.data.model_number;
          // $('.model_number  option[value="' + model_number + '"]')
          //   .attr("selected", "selected")
          //   .trigger("change");
          // $('[data-fieldname="model_number"]').attr("readonly", "readonly");
          // Replace the model_number section with this simpler version:
          let model_number = response.data.model_number;
          if (model_number) {
            // For Vtiger 8.3 - try the most common selectors
            let $modelSelect = $('select[name="model_number"], select[data-fieldname="model_number"]');
            $modelSelect.val(model_number);
            $modelSelect.trigger("change");
            
            // If it's a Select2 dropdown
            if ($modelSelect.hasClass('select2') || $modelSelect.data('select2')) {
              $modelSelect.trigger('change.select2');
            }
            
            $modelSelect.attr("readonly", "readonly");
          }
          $("select[name='eq_run_war_st']")
            .val(response.data.eq_run_war_st)
            .trigger("change")
            .attr("readonly", "readonly");
          $("select[name='contract_period']")
            .val(response.data.contract_period)
            .trigger("change")
            .attr("readonly", "readonly");
          $("select[name='service_offered']")
            .val(response.data.service_offered)
            .trigger("change")
            .attr("readonly", "readonly");
          $("input[name='amc_end_date']")
            .val(response.data.amc_end_date)
            .css("background-color", "#eeeeee")
            .attr("readonly", "readonly");
          $("input[name='amc_start_date']")
            .val(response.data.amc_start_date)
            .css("background-color", "#eeeeee")
            .attr("readonly", "readonly");
          $("select[name='amc_status']")
            .val(response.data.amc_status)
            .trigger("change")
            .attr("readonly", "readonly");
          $("select[name='warranty_status']")
            .val(response.data.warranty_status)
            .trigger("change")
            .attr("readonly", "readonly");
          $("input[name='days_left_in_war']")
            .val(response.data.days_left_in_war)
            .css("background-color", "#eeeeee")
            .attr("readonly", "readonly");
          $("input[name='war_start_date']")
            .val(response.data.war_start_date)
            .css("background-color", "#eeeeee")
            .attr("readonly", "readonly");
          $("input[name='war_end_date']")
            .val(response.data.war_end_date)
            .css("background-color", "#eeeeee")
            .attr("readonly", "readonly");

          $("input[name='mobile']")
            .val(response.data.phone)
            .css("background-color", "#eeeeee !important")
            .attr("readonly", "readonly");
          $("input[name='product_name']")
            .val(response.data.productname)
            .css("background-color", "#eeeeee !important")
            .attr("readonly", "readonly");
          $("input[name='helpdesk_state']")
            .val(response.data.helpdesk_state)
            .css("background-color", "#eeeeee !important")
            .attr("readonly", "readonly");
          $("input[name='helpdesk_pincode']")
            .val(response.data.helpdesk_pincode)
            .css("background-color", "#eeeeee !important")
            .attr("readonly", "readonly");
          $("input[name='helpdesk_country']")
            .val(response.data.helpdesk_country)
            .css("background-color", "#eeeeee !important")
            .attr("readonly", "readonly");
          $("input[name='helpdesk_district']")
            .val(response.data.helpdesk_district)
            .css("background-color", "#eeeeee !important")
            .attr("readonly", "readonly");
          $("input[name='helpdesk_city']")
            .val(response.data.helpdesk_city)
            .css("background-color", "#eeeeee !important")
            .attr("readonly", "readonly");
          app.helper.hideProgress();
        }
      });
    },
    seletctTheMarkVendor: function (id, label, field) {
      let selectedNameOfAsset = label;
      let sourceField = field;
      var fieldElement = jQuery(
        "#" + app.getModuleName() + "_editView_fieldName_" + field + "_select"
      );
      var sourceFieldDisplay = field + "_display";
      var fieldDisplayElement = jQuery(
        'input[name="' + sourceFieldDisplay + '"]'
      );
      var popupReferenceModuleElement = jQuery(
        'input[name="popupReferenceModule"]'
      ).length
        ? jQuery('input[name="popupReferenceModule"]')
        : jQuery("input.popupReferenceModule");
      var popupReferenceModule = popupReferenceModuleElement.val();
      var selectedName = selectedNameOfAsset;
      jQuery('input[name="' + sourceField + '"]').val(id);
      if (id && selectedName) {
        if (!fieldDisplayElement.length) {
          fieldElement.attr("value", id);
          fieldElement.data("value", id);
          fieldElement.val(selectedName);
        } else {
          fieldElement.val(id);
          fieldElement.data("value", id);
          fieldDisplayElement.val(selectedName);
          if (selectedName) {
            fieldDisplayElement.attr("readonly", "readonly");
          } else {
            fieldDisplayElement.removeAttr("readonly");
          }
        }
        if (selectedName) {
          fieldElement
            .parent()
            .parent()
            .find("#" + sourceFieldDisplay)
            .attr("disabled", "disabled");
          fieldElement
            .parent()
            .parent()
            .find(".clearReferenceSelection")
            .removeClass("hide");
          fieldElement
            .parent()
            .parent()
            .find(".referencefield-wrapper")
            .addClass("selected");
        } else {
          fieldElement
            .parent()
            .parent()
            .find(".clearReferenceSelection")
            .addClass("hide");
          fieldElement
            .parent()
            .parent()
            .find(".referencefield-wrapper")
            .removeClass("selected");
        }
        fieldElement.trigger(Vtiger_Edit_Js.referenceSelectionEvent, {
          source_module: popupReferenceModule,
          record: id,
          selectedName: selectedName,
        });
      }
    },
  }
);
