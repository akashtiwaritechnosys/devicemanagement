{literal}
<link rel="stylesheet" href="layouts/v7/modules/Settings/PricingPlans/resources/planpricing.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
{/literal}
<div class="container-fluid">
  <div class="pricing-plan">
    <div class="widget_header row widget-padded">
      <div class="col-md-8 py-4">
        <h4>Pricing & Plans</h4>
      </div>
    </div>

    <div class="nono">
      <div class="step-progress-container">
        <div class="steps">
          <div class="step-track"></div>
          <div class="step-progress" id="stepProgress"></div>

          <div class="step active" id="stepPlan">
            <div class="step-marker">1</div>
            <div class="step-label">Choose Plan</div>
          </div>

          <div class="step" id="stepSummary">
            <div class="step-marker">2</div>
            <div class="step-label">Billing & Summary</div>
          </div>
          <div class="step" id="stepPayment">
            <div class="step-marker">3</div>
            <div class="step-label">Payment</div>
          </div>
        </div>
      </div>
    </div>
    <br>
    
    <div class="contents-modern">
      <div class="payment-container">
        <div class="section-container">
          <div class="plan-section" id="planSection">
            <div class="billing-toggle">
              <span class="toggle-label active">Quarterly</span>
              <label class="toggle-switch">
                <input type="checkbox" />
                <span class="slider"></span>
              </label>
              <span class="toggle-label">Yearly <span class="savings-badge">Save 20%</span></span>
            </div>

            <div class="plans-container">
              {foreach from=$PLANS item=plan}
              <div class="plan-card {if $plan@iteration == 2}popular{/if}">
                {if $plan@iteration == 2}
                <div class="popular-badge">Most Popular</div>
                {/if}

                <div class="plan-name">{$plan.subscription_name}</div>

                {assign var=quarterPrice value=''} {assign var=yearPrice value=''}
                {assign var=quarterfreq value=''} {assign var=yearfreq value=''}
                {assign var=qpid value=''} {assign var=ypid value=''} {foreach
                from=$plan.price item=p} {if $p.frequency == 'Quarter'} {assign
                var=quarterPrice value=$p.price} {assign var=quarterfreq
                value=$p.frequency}{assign var=qpid value=$p.pricebook_id} {/if}
                {if $p.frequency == 'Year'} {assign var=yearPrice value=$p.price}
                {assign var=yearfreq value=$p.frequency}{assign var=ypid
                value=$p.pricebook_id} {/if} {/foreach}

                <div class="flex">
                  <div class="plan-price" data-quarter-price="{$quarterPrice}" data-quarter-freq="{$quarterfreq}"
                    data-year-price="{$yearPrice}" data-year-freq="{$yearfreq}">
                    ₹{$quarterPrice} <span>/ {$quarterfreq}</span>
                  </div>

                  <div class="users-selection">
                    <label for="users-{$plan.subscription_id|replace:'x':'-'}">
                      Number of Users
                    </label>
                    <div class="user-input-container">
                      <input id="users-{$plan.subscription_id|replace:'x':'-'}" class="user-input" type="number"
                        name="users[{$plan.subscription_id}]" value="1" min="1" />
                      <div class="number-arrows">
                        <button class="arrow-btn up-arrow" type="button"
                          data-target="users-{$plan.subscription_id|replace:'x':'-'}">
                          &#9650;
                        </button>
                        <button class="arrow-btn down-arrow" type="button"
                          data-target="users-{$plan.subscription_id|replace:'x':'-'}">
                          &#9660;
                        </button>
                      </div>
                    </div>
                  </div>
                </div>

                <ul class="plan-features">
                  {foreach from=$plan.modules key=moduleGroup item=moduleItems}
                  <h5>{$moduleGroup}</h5>
                  {foreach from=$moduleItems item=module}
                  <li>{$module.module_name}</li>
                  {/foreach} {/foreach}
                </ul>

                <button class="select-button {if $plan@iteration == 2}primary-button{else}secondary-button{/if}"
                  data-sub-id="{$plan.subscription_id}" data-sub-name="{$plan.subscription_name}"
                  data-quarterpbid="{$qpid}" data-yearpbid="{$ypid}" data-product-id="{$plan.product_id}">
                  Select Plan
                </button>
              </div>
              {/foreach}
            </div>
          </div>

          <div class="summary-section" id="summarySection">
            <div class="summary-container">
              <!-- Billing Details Card -->
              <div class="billing-details">

                <div class="summary-header">
                  <h4>Billing Information</h4>

                </div>

                <form id="billingForm">
                  <div class="form-row" style="display: flex; gap: 15px">
                    <div class="form-group" style="flex: 1">
                      <label for="fullName">Billing Name / Company Name</label>
                      <input type="text" id="fullName" class="form-control inputElement" required />
                    </div>
                    <div class="form-group" style="flex: 1">
                      <label for="phone">Phone</label>
                      <input type="text" id="phone" class="form-control inputElement" required />
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="address">Street Address</label>
                    <input type="text" id="address" class="form-control inputElement" required />
                  </div>

                  <div class="form-row" style="display: flex; gap: 15px">
                    <div class="form-group" style="flex: 1">
                      <label for="city">City</label>
                      <input type="text" id="city" class="form-control inputElement" required />
                    </div>

                    <div class="form-group" style="flex: 1">
                      <label for="state">State</label>
                      <select id="state" name="state" class="select2" required>
                        <option value="">Select State</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-row" style="display: flex; gap: 15px">
                    <div class="form-group" style="flex: 1">
                      <label for="zip">ZIP Code</label>
                      <input type="text" id="zip" class="form-control inputElement" required />
                    </div>

                    <div class="form-group" style="flex: 1">
                      <label for="country">Country</label>
                      <select id="country" name="country" class="select2" required>
                        <option value="">Select Country</option>

                        <option value="India" selected="selected">India</option>
                        <!-- Add more countries as needed -->
                      </select>
                    </div>
                  </div>
                </form>
              </div>

              <!-- Order Summary Card -->
              <div class="order-summary">
                <div class="summary-header">
                  <h4>Order Summary</h4>

                </div>

                <div class="summary-items">
                  <div class="summary-item">
                    <span class="summary-item-label">Selected Plan:</span>
                    <span class="summary-item-value" id="summaryPlanName">-</span>
                  </div>
                  <div class="summary-item">
                    <span class="summary-item-label">Billing Cycle:</span>
                    <span class="summary-item-value" id="summaryBillingCycle">-</span>
                  </div>
                  <div class="summary-item">
                    <span class="summary-item-label">Number of Users:</span>
                    <span class="summary-item-value" id="summaryUserCount">-</span>
                  </div>
                  <!-- <div class="summary-item">
                    <span class="summary-item-label">Price per Period:</span>
                    <span class="summary-item-value" id="summaryPrice">-</span>
                  </div> -->
                  <div class="summary-item">
                    <span class="summary-item-label">Sub Total:</span>
                    <span class="summary-item-value" id="summarySubTotal">-</span>
                  </div>
                </div>

                <div id="taxBreakup" style="display: none">
                  <!-- <div class="summary-header">
                    <h4>Tax charges</h4>
                  </div> -->
                  <div class="gst-row" id="cgstRow">
                    <span>CGST (9%):</span>
                    <strong id="cgstValue"></strong>
                  </div>
                  <div class="gst-row" id="sgstRow">
                    <span>SGST (9%):</span>
                    <strong id="sgstValue"></strong>
                  </div>
                  <div class="gst-row" id="igstRow">
                    <span>IGST (18%):</span>
                    <strong id="igstValue"></strong>
                  </div>
                  <div class="gst-row" id="taxRow" style="border-top: 1px solid var(--border);padding-top: 10px;">
                    <span>Total Tax (18%):</span>
                    <strong id="taxValue"></strong>
                  </div>
                </div>

                <div class="summary-item summary-total">
                  <span>Total Amount:</span>
                  <span id="summaryTotal">-</span>
                </div>
                <div class="action-buttons">
                  <button class="back-button" id="backButton">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                      stroke-linecap="round" stroke-linejoin="round" style="vertical-align: text-top; ">
                      <line x1="19" y1="12" x2="5" y2="12"></line>
                      <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Back to Plans
                  </button>
                  <button class="pay-button" id="payButton">
                    Proceed to Payment
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      style="vertical-align: text-top; " stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <line x1="5" y1="12" x2="19" y2="12"></line>
                      <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Add this right after the summary-section div -->
          <div id="paymentSection" class="payment-section">
            <div class="payment-card">
              <!-- <div class="payment-header">

                <h2 class="payment-title">Review & Complete Your Payment</h2>
              </div> -->

              <div class="payment-summary-grid">
                <div class="summary-card">
                  <div class="summary-header">
                    <h6 class="summary-card-title">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                          d="M3 10H21M7 3V5M17 3V5M6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                      </svg>
                      Billing Details
                    </h6>
                  </div>

                  <div class="summary-details">
                    <div class="detail-item">
                      <span class="detail-label">Full Name</span>
                      <span class="detail-value" id="fullNamePreview"></span>
                    </div>
                    <div class="detail-item">
                      <span class="detail-label">Phone</span>
                      <span class="detail-value" id="phonePreview"></span>
                    </div>
                    <div class="detail-item">
                      <span class="detail-label">Address</span>
                      <span class="detail-value" id="addressPreview"></span>
                    </div>
                    <div class="detail-item">
                      <span class="detail-label">City</span>
                      <span class="detail-value" id="cityPreview"></span>
                    </div>
                    <div class="detail-item">
                      <span class="detail-label">State/ZIP</span>
                      <span class="detail-value"><span id="statePreview"></span>, <span id="zipPreview"></span></span>
                    </div>
                    <div class="detail-item">
                      <span class="detail-label">Country</span>
                      <span class="detail-value" id="countryPreview"></span>
                    </div>
                  </div>
                </div>

                <div class="summary-card">
                  <div class="summary-header">
                    <h6 class="summary-card-title">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                          d="M8 7V3M16 7V3M7 11H17M5 21H19C20.1046 21 21 20.1046 21 19V7C21 5.89543 20.1046 5 19 5H5C3.89543 5 3 5.89543 3 7V19C3 20.1046 3.89543 21 5 21Z"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                      </svg>
                      Payment Summary
                    </h6>
                  </div>
                  <div class="summary-details">
                    <div class="detail-item">
                      <span class="detail-label">Plan</span>
                      <span class="detail-value" id="paymentPlanName"></span>
                    </div>
                    <div class="detail-item">
                      <span class="detail-label">Billing Cycle</span>
                      <span class="detail-value" id="paymentBillingCycle"></span>
                    </div>
                    <!-- <div class="detail-item">
                      <span class="detail-label">Users</span>
                      <span class="detail-value" id="paymentUserCount"></span>
                    </div> -->
                    <div class="detail-item">
                      <span class="detail-label">Sub Total</span>
                      <span class="detail-value" id="paymentBasePrice"></span>
                    </div>
                    <div class="detail-item" id="paymentTaxRow">
                      <span class="detail-label">GST (18%)</span>
                      <span class="detail-value" id="paymentTaxAmount"></span>
                    </div>
                  </div>
                  <div class="summary-total">
                    <span class="total-label">Total Payable</span>
                    <span class="total-amount" id="paymentTotalAmount"></span>
                  </div>
                  <div class="payment-actions">
              
                    <button class="back-button" id="backToSummary">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" style="vertical-align: text-top; ">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                      </svg>
                      Back to Billing & Summary
                    </button>
                    <button class="btn-primary" id="payNowButton">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" style="vertical-align: text-top;" xmlns="http://www.w3.org/2000/svg">
                        <path
                          d="M2 8.50561C2 7.14413 3.14355 6.03323 4.52413 6.03323H19.4759C20.8565 6.03323 22 7.14413 22 8.50561V15.4944C22 16.8559 20.8565 17.9668 19.4759 17.9668H4.52413C3.14355 17.9668 2 16.8559 2 15.4944V8.50561Z"
                          stroke="currentColor" stroke-width="2" />
                        <path d="M6 10H6.01M18 14H18.01M10 14H14" stroke="currentColor" stroke-width="2"
                          stroke-linecap="round" />
                      </svg>
                      Confirm & Pay
                    </button>
                  </div>
                  <div class="payment-security">
                    <div class="security-badge">
                    
                    </div>
                    <div class="payment-provider">
                      <span>Powered by</span>
                      <svg xmlns="http://www.w3.org/2000/svg" width="125px" height="30px" fill="#072654"
                        viewBox="0 0 1896 401">
                        <path fill="#3395FF" d="M122.63 105.7l-15.75 57.97 90.15-58.3-58.96 219.98 59.88.05L285.05.48"></path>
                        <path
                          d="M25.6 232.92L.8 325.4h122.73l50.22-188.13L25.6 232.92m426.32-81.42c-3 11.15-8.78 19.34-17.4 24.57-8.6 5.22-20.67 7.84-36.25 7.84h-49.5l17.38-64.8h49.5c15.56 0 26.25 2.6 32.05 7.9 5.8 5.3 7.2 13.4 4.22 24.6m51.25-1.4c6.3-23.4 3.7-41.4-7.82-54-11.5-12.5-31.68-18.8-60.48-18.8H324.4l-66.5 248.1h53.67l26.8-100h35.2c7.9 0 14.12 1.3 18.66 3.8 4.55 2.6 7.22 7.1 8.04 13.6l9.58 82.6h57.5l-9.32-77c-1.9-17.2-9.77-27.3-23.6-30.3 17.63-5.1 32.4-13.6 44.3-25.4a92.6 92.6 0 0 0 24.44-42.5m130.46 86.4c-4.5 16.8-11.4 29.5-20.73 38.4-9.34 8.9-20.5 13.3-33.52 13.3-13.26 0-22.25-4.3-27-13-4.76-8.7-4.92-21.3-.5-37.8 4.42-16.5 11.47-29.4 21.17-38.7 9.7-9.3 21.04-13.95 34.06-13.95 13 0 21.9 4.5 26.4 13.43 4.6 8.97 4.7 21.8.2 38.5zm23.52-87.8l-6.72 25.1c-2.9-9-8.53-16.2-16.85-21.6-8.34-5.3-18.66-8-30.97-8-15.1 0-29.6 3.9-43.5 11.7-13.9 7.8-26.1 18.8-36.5 33-10.4 14.2-18 30.3-22.9 48.4-4.8 18.2-5.8 34.1-2.9 47.9 3 13.9 9.3 24.5 19 31.9 9.8 7.5 22.3 11.2 37.6 11.2a82.4 82.4 0 0 0 35.2-7.7 82.11 82.11 0 0 0 28.4-21.2l-7 26.16h51.9L709.3 149h-52zm238.65 0H744.87l-10.55 39.4h87.82l-116.1 100.3-9.92 37h155.8l10.55-39.4h-94.1l117.88-101.8m142.4 52c-4.67 17.4-11.6 30.48-20.75 39-9.15 8.6-20.23 12.9-33.24 12.9-27.2 0-36.14-17.3-26.86-51.9 4.6-17.2 11.56-30.13 20.86-38.84 9.3-8.74 20.57-13.1 33.82-13.1 13 0 21.78 4.33 26.3 13.05 4.52 8.7 4.48 21.67-.13 38.87m30.38-80.83c-11.95-7.44-27.2-11.16-45.8-11.16-18.83 0-36.26 3.7-52.3 11.1a113.09 113.09 0 0 0-41 32.06c-11.3 13.9-19.43 30.2-24.42 48.8-4.9 18.53-5.5 34.8-1.7 48.73 3.8 13.9 11.8 24.6 23.8 32 12.1 7.46 27.5 11.17 46.4 11.17 18.6 0 35.9-3.74 51.8-11.18 15.9-7.48 29.5-18.1 40.8-32.1 11.3-13.94 19.4-30.2 24.4-48.8 5-18.6 5.6-34.84 1.8-48.8-3.8-13.9-11.7-24.6-23.6-32.05m185.1 40.8l13.3-48.1c-4.5-2.3-10.4-3.5-17.8-3.5-11.9 0-23.3 2.94-34.3 8.9-9.46 5.06-17.5 12.2-24.3 21.14l6.9-25.9-15.07.06h-37l-47.7 176.7h52.63l24.75-92.37c3.6-13.43 10.08-24 19.43-31.5 9.3-7.53 20.9-11.3 34.9-11.3 8.6 0 16.6 1.97 24.2 5.9m146.5 41.1c-4.5 16.5-11.3 29.1-20.6 37.8-9.3 8.74-20.5 13.1-33.5 13.1s-21.9-4.4-26.6-13.2c-4.8-8.85-4.9-21.6-.4-38.36 4.5-16.75 11.4-29.6 20.9-38.5 9.5-8.97 20.7-13.45 33.7-13.45 12.8 0 21.4 4.6 26 13.9 4.6 9.3 4.7 22.2.28 38.7m36.8-81.4c-9.75-7.8-22.2-11.7-37.3-11.7-13.23 0-25.84 3-37.8 9.06-11.95 6.05-21.65 14.3-29.1 24.74l.18-1.2 8.83-28.1h-51.4l-13.1 48.9-.4 1.7-54 201.44h52.7l27.2-101.4c2.7 9.02 8.2 16.1 16.6 21.22 8.4 5.1 18.77 7.63 31.1 7.63 15.3 0 29.9-3.7 43.75-11.1 13.9-7.42 25.9-18.1 36.1-31.9 10.2-13.8 17.77-29.8 22.6-47.9 4.9-18.13 5.9-34.3 3.1-48.45-2.85-14.17-9.16-25.14-18.9-32.9m174.65 80.65c-4.5 16.7-11.4 29.5-20.7 38.3-9.3 8.86-20.5 13.27-33.5 13.27-13.3 0-22.3-4.3-27-13-4.8-8.7-4.9-21.3-.5-37.8 4.4-16.5 11.42-29.4 21.12-38.7 9.7-9.3 21.05-13.94 34.07-13.94 13 0 21.8 4.5 26.4 13.4 4.6 8.93 4.63 21.76.15 38.5zm23.5-87.85l-6.73 25.1c-2.9-9.05-8.5-16.25-16.8-21.6-8.4-5.34-18.7-8-31-8-15.1 0-29.68 3.9-43.6 11.7-13.9 7.8-26.1 18.74-36.5 32.9-10.4 14.16-18 30.3-22.9 48.4-4.85 18.17-5.8 34.1-2.9 47.96 2.93 13.8 9.24 24.46 19 31.9 9.74 7.4 22.3 11.14 37.6 11.14 12.3 0 24.05-2.56 35.2-7.7a82.3 82.3 0 0 0 28.33-21.23l-7 26.18h51.9l47.38-176.7h-51.9zm269.87.06l.03-.05h-31.9c-1.02 0-1.92.05-2.85.07h-16.55l-8.5 11.8-2.1 2.8-.9 1.4-67.25 93.68-13.9-109.7h-55.08l27.9 166.7-61.6 85.3h54.9l14.9-21.13c.42-.62.8-1.14 1.3-1.8l17.4-24.7.5-.7 77.93-110.5 65.7-93 .1-.06h-.03z">
                        </path>
                      </svg>
                    </div>
                  </div>
                </div>
              </div>
                </div>
                
              </div>



              




        </div>
      </div>
    </div>
  </div>
</div>

{literal}
<script src="layouts/v7/modules/Settings/PricingPlans/resources/planpricing.js?v1"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{/literal}