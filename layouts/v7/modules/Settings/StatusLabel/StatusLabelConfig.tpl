{strip}
<div class="col-sm-12 col-lg-12 col-md-12">
  <div class="block status-label-page">
      <div>
          <h4>Status Label</h4>
      </div>
      <hr>
      <form class="form-horizontal recordEditView" id="editview" name="edit" method="post" action="index.php" enctype="multipart/form-data">
          <!-- ... your form content ... -->
          <input type="hidden"  name="module" value="StatusLabel">
          <input type="hidden" name="parent" value="Settings">
          <input type="hidden" name="view" value="StatusLabelConfig">
          <input type="hidden" name="mode" value="saveStatusLabel">
        
          <div class="form-group">
              <label for="inputType" class="col-sm-3 control-label">Modules name:</label>
              <div class="col-sm-5 site-select">
              <select class="form-select form-select-lg select2" name="smodulename" id="smodulename">
                  <option>Select Module</option>
                  <option value="opportunities">Opportunities</option>
                  <option value="leads">Leads</option>
                  <option value="project">Project</option>
              </select>
          </div>
              <div class="followup col-lg-12 col-md-12 col-sm-12" id="followupContainer">
                  <div class="opportunities selected-followp-module hidden-section">
                      <div class="form-group"><label class="col-sm-3 control-label select2" for="input">Advance Payment</label><div class="col-sm-5 select2">
                      <input class="form-control select2" type="text" name="advance_payment" id="advance_payment" value="{$ADVANCE_PAYMENT}"></div></div>

                      <div class="form-group"><label class="col-sm-3 control-label select2" for="input">Quotes Ready</label><div class="col-sm-5 select2">
                      <input class="form-control select2" type="text" name="quotes_ready" id="quotes_ready" value="{$QUOTES_READY}"></div></div>

                      <div class="form-group"><label class="col-sm-3 control-label select2" for="input">Site Visit</label><div class="col-sm-5 select2">
                      <input class="form-control select2" type="text" name="site_visit" id="site_visit" value="{$SITE_VISIT}"></div></div>
                      
                      <div class="form-group"><label class="col-sm-3 control-label select2" for="input">2D design</label><div class="col-sm-5 select2">
                      <input class="form-control select2" type="text" name="design_1" id="design_1" value="{$DESIGN_1}"></div></div>

                      <div class="form-group"><label class="col-sm-3 control-label select2" for="input">3D design</label><div class="col-sm-5 select2">
                      <input class="form-control select2" type="text" name="design_2" id="design_2" value="{$DESIGN_2}"></div></div><br><br>
                  </div>
                  <div class="leads selected-followp-module hidden-section">
                      <div class="form-group"><label class="col-sm-3 control-label select2" for="input">Followup 1</label><div class="col-sm-5 select2">
                      <input class="form-control select2" type="text" name="followup_1" id="followup_1" value="{$FOLLOWUP_1}"></div></div>

                      <div class="form-group"><label class="col-sm-3 control-label select2" for="input">Followup 2</label><div class="col-sm-5 select2">
                      <input class="form-control select2" type="text" name="followup_2" id="followup_2" value="{$FOLLOWUP_2}"></div></div>

                      <div class="form-group"><label class="col-sm-3 control-label select2" for="input">Innca Visit</label><div class="col-sm-5 select2">
                      <input class="form-control select2" type="text" name="innca_visit" id="innca_visit" value="{$INNCA_VISIT}"></div></div>

                      <div class="form-group"><label class="col-sm-3 control-label select2" for="input">Followup 3</label><div class="col-sm-5 select2">
                      <input class="form-control select2" type="text" name="followup_3" id="followup_3" value="{$FOLLOWUP_3}"></div></div><br><br>
                  </div>
                  <div class="project selected-followp-module hidden-section">
                      <div class="form-group"><label class="col-sm-3 control-label select2" for="input">Discussion and payment received</label><div class="col-sm-5 select2">
                      <input class="form-control select2" type="text" name="payment_received" id="payment_received" value="{$DISC_PAYMENT_RECEIVED}"></div></div>

                      <div class="form-group"><label class="col-sm-3 control-label select2" for="input">Implementation</label><div class="col-sm-5 select2">
                      <input class="form-control select2" type="text" name="implementation" id="implementation" value="{$IMPLEMENT}"></div></div>

                      <div class="form-group"><label class="col-sm-3 control-label select2" for="input">Installation</label><div class="col-sm-5 select2">
                      <input class="form-control select2" type="text" name="installation" id="installation" value="{$INSTALLATION}"></div></div>

                      <div class="form-group"><label class="col-sm-3 control-label select2" for="input">Site Verification</label><div class="col-sm-5 select2">
                      <input class="form-control select2" type="text" name="site_verification" id="site_verification" value="{$SITE_VERFICATION}"></div></div>
                      
                      <div class="form-group"><label class="col-sm-3 control-label select2" for="input" >Closure</label><div class="col-sm-5 select2">
                      <input class="form-control select2" type="text" name="closure" id="closure" value="{$CLOSURE}"></div></div>
                  </div>
              </div>
          </div>
          <button type='submit' class="btn btn-success saveButton" id="saveButton" >Save</button>
      </form>
  </div>
</div>
<script>
  $(document).ready(function () {
    function getURLParameter(name) {
      var urlParams = new URLSearchParams(window.location.search);
      return urlParams.get(name);
    }

    function showFieldsBasedOnModule(selectedModule) {
      $(".opportunities, .leads, .project").addClass("hidden-section");
      $("." + selectedModule).removeClass("hidden-section");
    }

    function updateURL(selectedModule) {
      var url = "index.php?module=StatusLabel&parent=Settings&view=StatusLabelConfig&mode=statusLabelSetting&block=4&fieldid=41&selectedModule=" + selectedModule;
      window.location.href = url;
    }

    $("#smodulename").change(function () {
      var selectedModule = $(this).val().toLowerCase();
      showFieldsBasedOnModule(selectedModule);
      updateURL(selectedModule);
    });

    var initialModule = getURLParameter("selectedModule");
    if (initialModule) {
      showFieldsBasedOnModule(initialModule.toLowerCase());
      $("#smodulename").val(initialModule);
    }
  });
</script>


  