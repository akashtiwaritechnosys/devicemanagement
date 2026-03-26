document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.querySelector(".toggle-switch input");
    const quarterlyLabel = document.querySelector(".toggle-label:nth-child(1)");
    const yearlyLabel = document.querySelector(".toggle-label:nth-child(3)");
    const priceElements = document.querySelectorAll(".plan-price");
    const selectButtons = document.querySelectorAll(".select-button");
    const planSection = document.getElementById("planSection");
    const summarySection = document.getElementById("summarySection");
    const backButton = document.getElementById("backButton");
    const payButton = document.getElementById("payButton");
    const stepPlan = document.getElementById("stepPlan");
    const stepSummary = document.getElementById("stepSummary");
    const stepProgress = document.getElementById("stepProgress");
    const stepPayment = document.getElementById("stepPayment");
    let selectedBaseTotal = 0;

    // Upgrade mode variables
    let currentSubscription = null;
    let upgradeMode = false;
    let upgradeCalculation = null;
    let originalSelectHandlers = new Map(); // Store original handlers

    function updateStepProgress(currentStepIndex, totalSteps) {
        const percent = (currentStepIndex / (totalSteps - 1)) * 100;
        stepProgress.style.width = `${percent}%`;
    }

    function updateSteps(activeStep) {
        stepPlan.classList.remove("active", "completed");
        stepSummary.classList.remove("active", "completed");

        if (activeStep === "plan") {
            stepPlan.classList.add("active");
            updateStepProgress(0, 3);
        } else if (activeStep === "summary") {
            stepPlan.classList.add("completed");
            stepSummary.classList.add("active");
            updateStepProgress(1, 3);
        } else if (activeStep === "payment") {
            stepPlan.classList.add("completed");
            stepSummary.classList.add("completed");
            stepPayment.classList.add("active");
            updateStepProgress(2, 3);
        }
    }

    toggle.addEventListener("change", function () {
        const isYearly = this.checked;
        quarterlyLabel.classList.toggle("active", !isYearly);
        yearlyLabel.classList.toggle("active", isYearly);
        updatePrices();
    });

    function updatePrices() {
        const isYearly = toggle.checked;
        priceElements.forEach((priceEl) => {
            const usersInput = priceEl
                .closest(".plan-card")
                .querySelector(".user-input");
            const users = usersInput?.valueAsNumber || 1;

            const price = isYearly
                ? priceEl.dataset.yearPrice
                : priceEl.dataset.quarterPrice;
            const freq = isYearly
                ? priceEl.dataset.yearFreq
                : priceEl.dataset.quarterFreq;
            const total = users * parseFloat(price);
            priceEl.innerHTML = "₹" + total + " <span>/ " + freq + "</span>";
        });
    }

    document.querySelectorAll(".user-input").forEach((input) => {
        input.addEventListener("change", function () {
            if (this.value < parseInt(this.min)) {
                this.value = this.min;
            }
            updatePrices();
        });
    });

    document.querySelectorAll(".arrow-btn").forEach((btn) => {
        btn.addEventListener("click", function () {
            const targetId = this.dataset.target;
            const input = document.getElementById(targetId);
            let value = input.valueAsNumber || 1;

            if (this.classList.contains("up-arrow")) {
                input.value = value + 1;
            } else if (this.classList.contains("down-arrow") && value > 1) {
                input.value = value - 1;
            }

            input.dispatchEvent(new Event("change"));
        });
    });

    // FIXED: Store original handlers and set up select button functionality
    function setupSelectButtons() {
        selectButtons.forEach((btn) => {
            const originalHandler = function() {
                if (upgradeMode && btn.disabled) {
                    return;
                }

                clearBillingForm();
                const planCard = btn.closest(".plan-card");
                const usersInput = planCard.querySelector(".user-input");
                const users = usersInput?.valueAsNumber || 1;
                const priceEl = planCard.querySelector(".plan-price");
                const state = document.getElementById("state").value;
                const companyState = "Karnataka";
                const isYearly = toggle.checked;

                const price = isYearly
                    ? priceEl.dataset.yearPrice
                    : priceEl.dataset.quarterPrice;
                const freq = isYearly
                    ? priceEl.dataset.yearFreq
                    : priceEl.dataset.quarterFreq;

                const planName = btn.dataset.subName;
                const pricebookId = isYearly
                    ? btn.dataset.yearpbid
                    : btn.dataset.quarterpbid;
                const productid = btn.dataset.productId;

                selectedBaseTotal = users * parseFloat(price);

                document.getElementById("summaryPlanName").textContent = planName;
                document.getElementById("summaryBillingCycle").textContent = freq;
                document.getElementById("summaryUserCount").textContent = users;

                let taxAmount = updateGSTTaxBreakup(state, companyState, selectedBaseTotal);
                const finalTotal = selectedBaseTotal;
                document.getElementById("summarySubTotal").textContent = "₹" + finalTotal.toFixed(2);
                document.getElementById("summaryTotal").textContent = "₹" + finalTotal.toFixed(2);

                const formData = new FormData();
                formData.append("user_count", users);
                formData.append("plan_id", pricebookId);
                formData.append("product", productid);
                formData.append(csrfMagicName, csrfMagicToken);

                fetch("index.php?module=PricingPlans&parent=Settings&action=StorePlanSelectionAjax", {
                    method: "POST",
                    headers: { "x-requested-with": "XMLHttpRequest" },
                    body: formData
                })
                .then((response) => response.json())
                .then((data) => {
                    if (!data.success) {
                        app.helper.showErrorNotification({ message: "Plan save failed." });
                        return;
                    }
                    planSection.style.display = "none";
                    summarySection.classList.add("active");
                    updateSteps("summary");
                })
                .catch(() => {
                    app.helper.showErrorNotification({ message: "Server error. Try again." });
                });
            };

            // Store the original handler
            originalSelectHandlers.set(btn, originalHandler);
            btn.addEventListener("click", originalHandler);
        });
    }

    // Initialize select buttons
    setupSelectButtons();

    function updateGSTTaxBreakup(state, companyState, baseAmount) {
        const cgstRow = document.getElementById("cgstRow");
        const sgstRow = document.getElementById("sgstRow");
        const igstRow = document.getElementById("igstRow");
        const taxRow = document.getElementById("taxRow");

        let taxAmount = 0;

        if (state === companyState) {
            const cgst = (baseAmount * 0.09).toFixed(2);
            const sgst = (baseAmount * 0.09).toFixed(2);
            taxAmount = parseFloat(cgst) + parseFloat(sgst);

            document.getElementById("cgstValue").textContent = "₹" + cgst;
            document.getElementById("sgstValue").textContent = "₹" + sgst;
            document.getElementById("taxValue").textContent = "₹" + taxAmount.toFixed(2);
            cgstRow.style.display = "flex";
            sgstRow.style.display = "flex";
            igstRow.style.display = "none";
        } else {
            const igst = (baseAmount * 0.18).toFixed(2);
            taxAmount = parseFloat(igst);

            document.getElementById("igstValue").textContent = "₹" + igst;
            document.getElementById("taxValue").textContent = "₹" + taxAmount.toFixed(2);
            cgstRow.style.display = "none";
            sgstRow.style.display = "none";
            igstRow.style.display = "flex";
        }

        return taxAmount;
    }

    backButton.addEventListener("click", function () {
        summarySection.classList.remove("active");
        planSection.style.display = "block";
        updateSteps("plan");
    });

    payButton.addEventListener("click", function () {
        if (upgradeMode && upgradeCalculation) {
            handleUpgradePayment();
            return;
        }

        const fullName = document.getElementById("fullName").value.trim();
        const address = document.getElementById("address").value.trim();
        const city = document.getElementById("city").value.trim();
        const state = document.getElementById("state").value.trim();
        const phone = document.getElementById("phone").value.trim();
        const zip = document.getElementById("zip").value.trim();
        const country = document.getElementById("country").value;
    
        if (!fullName || !address || !city || !zip || !country || !phone || !state) {
            app.helper.showErrorNotification({
                message: "Please fill all billing details.",
            });
            return;
        }
    
        if (!/^\d{6}$/.test(zip)) {
            app.helper.showErrorNotification({
                message: "Please enter a valid 6-digit ZIP code.",
            });
            return;
        }
    
        document.getElementById("summarySection").classList.remove("active");
        document.getElementById("paymentSection").style.display = "block";
        document.getElementById("paymentSection").classList.add("active");
        updateSteps("payment");
    
        document.getElementById("fullNamePreview").textContent = document.getElementById("fullName").value.trim();
        document.getElementById("addressPreview").textContent = document.getElementById("address").value.trim();
        document.getElementById("cityPreview").textContent = document.getElementById("city").value.trim();
        document.getElementById("statePreview").textContent = document.getElementById("state").value.trim();
        document.getElementById("zipPreview").textContent = document.getElementById("zip").value.trim();
        document.getElementById("countryPreview").textContent = document.getElementById("country").value.trim();
        document.getElementById("phonePreview").textContent = document.getElementById("phone").value.trim();
        document.getElementById("paymentPlanName").textContent = document.getElementById("summaryPlanName").textContent;
        document.getElementById("paymentBillingCycle").textContent = document.getElementById("summaryBillingCycle").textContent;
        document.getElementById("paymentBasePrice").textContent = document.getElementById("summarySubTotal").textContent;
        document.getElementById("paymentTotalAmount").textContent = document.getElementById("summaryTotal").textContent;
        document.getElementById("paymentTaxAmount").textContent = document.getElementById("taxValue").textContent;
    });

    document.getElementById("backToSummary").addEventListener("click", function () {
        document.getElementById("paymentSection").style.display = "none";
        document.getElementById("summarySection").classList.add("active");
        updateSteps("summary");
    });
    
    const payNowButton = document.getElementById("payNowButton");

    payNowButton.addEventListener("click", async function () {
        if (upgradeMode && upgradeCalculation) {
            processUpgradePayment();
            return;
        }

        app.helper.showProgress();
    
        const fullName = document.getElementById("fullName").value.trim();
        const address = document.getElementById("address").value.trim();
        const city = document.getElementById("city").value.trim();
        const state = document.getElementById("state").value.trim();
        const phone = document.getElementById("phone").value.trim();
        const zip = document.getElementById("zip").value.trim();
        const country = document.getElementById("country").value;
        const userCount = document.getElementById("summaryUserCount").textContent.trim();
    
        const selectedPlanId = document.querySelector(
            ".select-button[data-sub-name='" +
            document.getElementById("summaryPlanName").textContent.trim() +
            "']"
        )?.dataset.subId || "";
    
        const formData = new FormData();
        formData.append("fullName", fullName);
        formData.append("street", address);
        formData.append("postal_code", zip);
        formData.append("country", country);
        formData.append("phone", phone);
        formData.append("state", state);
        formData.append("city", city);
        formData.append("users", userCount);
        formData.append("subscription_id", selectedPlanId);
        formData.append(csrfMagicName, csrfMagicToken);
        
        try {
            const response = await fetch("index.php?module=PricingPlans&parent=Settings&action=SendSalesOrderAjax", {
                method: "POST",
                headers: { "x-requested-with": "XMLHttpRequest" },
                body: formData,
            });

            const result = await response.json();
            if (result.success && result.message.result.status == "success") {
                const subscriptionId = result.message.result.subscription_id;
    
                const options = {
                    key: "rzp_live_R7XtSA0qtO5Cej",
                    name: "CRM Doctor",
                    description: "Subscription Payment",
                    image: "https://central.crm-doctor.com/staging/layouts/v7/skins/images/favicon.ico",
                    subscription_id: subscriptionId,
                    handler: function (response) {
                        app.helper.showProgress();
                        setTimeout(function () {
                            app.helper.hideProgress();
                            app.helper.showSuccessNotification({
                                message: "Payment successful! Redirecting...",
                                type: "success",
                            });
    
                            setTimeout(function () {
                                window.location.href =
                                    "index.php?module=MyAccount&parent=Settings&view=List&block=13&fieldid=46";
                            }, 1000);
                        }, 1000);
                    },
                    theme: {
                        color: "#33ed88",
                    },
                    method: {
                        netbanking: true,
                        card: true,
                        upi: true,
                        wallet: true
                    },
                };
    
                const rzp = new Razorpay(options);
                rzp.open();
                app.helper.hideProgress();
            } else {
                app.helper.hideProgress();
                app.helper.showErrorNotification({
                    message: result.message || "Unknown error occurred.",
                });
            }
        } catch (err) {
            console.error(err);
            app.helper.hideProgress();
            app.helper.showErrorNotification({
                message: "Request Failed. Please try again.",
            });
        }
    });
    
    updateSteps("plan");

    function clearBillingForm() {
        document.getElementById('fullName').value = '';
        document.getElementById('phone').value = '';
        document.getElementById('address').value = '';
        document.getElementById('city').value = '';
        document.getElementById('state').value = '';
        document.getElementById('zip').value = '';
        document.getElementById('country').value = '';
        $('#state').val('').trigger('change');

        document.getElementById('fullNamePreview').innerText = '';
        document.getElementById('phonePreview').innerText = '';
        document.getElementById('addressPreview').innerText = '';
        document.getElementById('cityPreview').innerText = '';
        document.getElementById('statePreview').innerText = '';
        document.getElementById('zipPreview').innerText = '';
        document.getElementById('countryPreview').innerText = '';
    }

    // State select box rendering
    const stateSelect = document.getElementById("state");
    const states = [
        { name: "Andaman and Nicobar Islands", code: "Andaman and Nicobar Islands" },
        { name: "Andhra Pradesh", code: "Andhra Pradesh" },
        { name: "Arunachal Pradesh", code: "Arunachal Pradesh" },
        { name: "Assam", code: "Assam" },
        { name: "Bihar", code: "Bihar" },
        { name: "Chandigarh", code: "Chandigarh" },
        { name: "Chhattisgarh", code: "Chhattisgarh" },
        { name: "Dadra and Nagar Haveli", code: "Dadra and Nagar Haveli" },
        { name: "Daman and Diu", code: "Daman and Diu" },
        { name: "Delhi", code: "Delhi" },
        { name: "Goa", code: "Goa" },
        { name: "Gujarat", code: "Gujarat" },
        { name: "Haryana", code: "Haryana" },
        { name: "Himachal Pradesh", code: "Himachal Pradesh" },
        { name: "Jammu and Kashmir", code: "Jammu and Kashmir" },
        { name: "Jharkhand", code: "Jharkhand" },
        { name: "Karnataka", code: "Karnataka" },
        { name: "Kerala", code: "Kerala" },
        { name: "Ladakh", code: "Ladakh" },
        { name: "Lakshadweep", code: "Lakshadweep" },
        { name: "Madhya Pradesh", code: "Madhya Pradesh" },
        { name: "Maharashtra", code: "Maharashtra" },
        { name: "Manipur", code: "Manipur" },
        { name: "Meghalaya", code: "Meghalaya" },
        { name: "Mizoram", code: "Mizoram" },
        { name: "Nagaland", code: "Nagaland" },
        { name: "Odisha", code: "Odisha" },
        { name: "Puducherry", code: "Puducherry" },
        { name: "Punjab", code: "Punjab" },
        { name: "Rajasthan", code: "Rajasthan" },
        { name: "Sikkim", code: "Sikkim" },
        { name: "Tamil Nadu", code: "Tamil Nadu" },
        { name: "Telangana", code: "Telangana" },
        { name: "Tripura", code: "Tripura" },
        { name: "Uttar Pradesh", code: "Uttar Pradesh" },
        { name: "Uttarakhand", code: "Uttarakhand" },
        { name: "West Bengal", code: "West Bengal" }
    ];

    states.forEach(state => {
        const option = document.createElement("option");
        option.value = state.code;
        option.text = state.name;
        stateSelect.appendChild(option);
    });

    $('#state').select2({
        placeholder: "Select State",
        allowClear: true
    });

    $('#state').on('change', function (e) {
        const state = this.value;
        const companyState = "Karnataka";

        if (!state) {
            document.getElementById("taxBreakup").style.display = "none";
            document.getElementById("summaryTotal").textContent = "₹" + selectedBaseTotal.toFixed(2);
            return;
        }

        if (selectedBaseTotal > 0) {
            document.getElementById("taxBreakup").style.display = "block";
            const taxAmount = updateGSTTaxBreakup(state, companyState, selectedBaseTotal);
            const finalTotal = selectedBaseTotal + taxAmount;
            document.getElementById("summaryTotal").textContent = "₹" + finalTotal.toFixed(2);
        }
    });

    // UPGRADE FUNCTIONALITY
    
    // Check for existing subscription when page loads
    setTimeout(() => {
        checkForExistingSubscription();
    }, 1000);
    
    function checkForExistingSubscription() {
        // if (typeof window.siteID === 'undefined') {
        //     console.log('SiteID not available, skipping subscription check');
        //     return;
        // }
        
        const formData = new FormData();
        formData.append(csrfMagicName, csrfMagicToken);
        
        fetch('index.php?module=PricingPlans&parent=Settings&action=GetCurrentSubscriptionAjax', {
            method: 'POST',
            headers: { 
                'x-requested-with': 'XMLHttpRequest' 
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log('Subscription check response:', data); // Debug log
            if (data.success && data.subscription) {
                currentSubscription = data.subscription;
                showCurrentSubscriptionBanner();
                window.availablePlansForUpgrade = data.available_plans || [];
            }
        })
        .catch(error => {
            console.error('Error checking subscription:', error);
        });
    }
    
    function showCurrentSubscriptionBanner() {
        if (!currentSubscription) return;
        
        const bannerHTML = `
            <div class="current-subscription-banner">
                <div class="current-plan-info">
                    <h3>Current Plan: ${currentSubscription.plan_name || 'Active Plan'}</h3>
                    <p>Status: ${currentSubscription.subscrip_status || 'Active'} | 
                       Billing: ${currentSubscription.frequency_label || currentSubscription.subscription_frequency || 'Quarterly'}</p>
                    <p>${currentSubscription.days_remaining > 0 
                        ? `${currentSubscription.days_remaining} days remaining` 
                        : 'Renewal due soon'}</p>
                    <p>Current Amount: ₹${parseFloat(currentSubscription.total || 0).toFixed(2)}</p>
                </div>
                <button class="upgrade-btn" onclick="enableUpgradeMode()">
                    Upgrade Plan
                </button>
            </div>
        `;
        
        planSection.insertAdjacentHTML('afterbegin', bannerHTML);
    }
    
    // FIXED: Global functions for upgrade mode - don't replace buttons
    window.enableUpgradeMode = function() {
        upgradeMode = true;
        
        // Update the banner
        const banner = document.querySelector('.current-subscription-banner');
        if (banner) {
            banner.style.background = 'linear-gradient(135deg, #4CAF50 0%, #45a049 100%)';
            const heading = banner.querySelector('h3');
            if (heading) heading.textContent = 'Select New Plan to Upgrade';
            
            const upgradeBtn = banner.querySelector('.upgrade-btn');
            if (upgradeBtn) {
                upgradeBtn.textContent = 'Cancel Upgrade';
                upgradeBtn.onclick = cancelUpgradeMode;
            }
        }

        // FIXED: Modify buttons without replacing them
        selectButtons.forEach(btn => {
            const currentPricebookId = currentSubscription.sub_pricebook_id;
            const isYearly = toggle.checked;
            const planPricebookId = isYearly ? btn.dataset.yearpbid : btn.dataset.quarterpbid;
            
            const isCurrentPlan = planPricebookId === currentPricebookId || 
                                  (currentSubscription.plan_name && 
                                   btn.dataset.subName === currentSubscription.plan_name);
            
            if (isCurrentPlan) {
                btn.textContent = 'Current Plan';
                btn.disabled = true;
                btn.style.background = '#ccc';
                btn.style.cursor = 'not-allowed';
                btn.style.opacity = '0.6';
            } else {
                btn.textContent = 'Calculate Upgrade Cost';
                btn.style.background = '#4CAF50';
                btn.disabled = false;
                btn.style.cursor = 'pointer';
                btn.style.opacity = '1';
                
                // FIXED: Remove old listeners and add upgrade handler without replacing the element
                const originalHandler = originalSelectHandlers.get(btn);
                if (originalHandler) {
                    btn.removeEventListener('click', originalHandler);
                }
                
                const upgradeHandler = (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    calculateUpgradeCost(btn);
                };
                
                btn.addEventListener('click', upgradeHandler);
                // Store the upgrade handler for potential cleanup
                btn.upgradeHandler = upgradeHandler;
            }
        });
        
        showUpgradeInstructions();
    };
    
    window.cancelUpgradeMode = function() {
        location.reload();
    };
    
    function showUpgradeInstructions() {
        const instructionsHTML = `
            <div class="upgrade-instructions">
                <h4>How Upgrade Works:</h4>
                <ul>
                    <li>You'll only pay the difference between plans for remaining days</li>
                    <li>Unused amount from current plan will be credited</li>
                    <li>New billing cycle starts from your next renewal date</li>
                    <li>Select a plan below to see exact upgrade cost</li>
                </ul>
            </div>
        `;
        
        const banner = document.querySelector('.current-subscription-banner');
        if (banner) {
            banner.insertAdjacentHTML('afterend', instructionsHTML);
        }
    }
    
    function calculateUpgradeCost(btn) {
        const planCard = btn.closest('.plan-card');
        const usersInput = planCard.querySelector('.user-input');
        const users = usersInput?.valueAsNumber || 1;
        const isYearly = toggle.checked;
        
        const newPricebookId = isYearly ? btn.dataset.yearpbid : btn.dataset.quarterpbid;
        const planName = btn.dataset.subName;
        
        if (!newPricebookId) {
            app.helper.showErrorNotification({
                message: 'Plan configuration error. Please contact support.'
            });
            return;
        }
        
        app.helper.showProgress();
        
        const formData = new FormData();
        formData.append('new_pricebook_id', newPricebookId);
        formData.append('new_user_count', users);
        formData.append(csrfMagicName, csrfMagicToken);
        
        fetch('index.php?module=PricingPlans&parent=Settings&action=CalculateUpgradeAjax', {
            method: 'POST',
            headers: { 'x-requested-with': 'XMLHttpRequest' },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            app.helper.hideProgress();
            console.log('Upgrade calculation response:', data); // Debug log
            
            if (data.success) {
                upgradeCalculation = data.calculation;
                upgradeCalculation.new_pricebook_id = newPricebookId;
                upgradeCalculation.new_plan_name = planName;
                showUpgradePreview(data.calculation);
            } else {
                app.helper.showErrorNotification({
                    message: data.message || 'Failed to calculate upgrade cost'
                });
            }
        })
        .catch(error => {
            app.helper.hideProgress();
            console.error('Upgrade calculation error:', error);
            app.helper.showErrorNotification({
                message: 'Network error. Please try again.'
            });
        });
    }
    
    function showUpgradePreview(calculation) {
        clearBillingForm();
        
        const existingSummary = document.querySelector('.upgrade-summary');
        if (existingSummary) {
            existingSummary.remove();
        }
        
        document.getElementById('summaryPlanName').textContent = calculation.new_plan;
        document.getElementById('summaryBillingCycle').textContent = calculation.billing_cycle;
        document.getElementById('summaryUserCount').textContent = calculation.user_count;
        
        const upgradeInfoHTML = `
            <div class="upgrade-summary">
                <h4>Upgrade Summary</h4>
                <div class="upgrade-details">
                    <div class="detail-row">
                        <span>Current Plan:</span>
                        <span>${calculation.current_plan}</span>
                    </div>
                    <div class="detail-row">
                        <span>New Plan:</span>
                        <span>${calculation.new_plan}</span>
                    </div>
                    <div class="detail-row">
                        <span>Current Amount:</span>
                        <span>₹${calculation.current_amount.toFixed(2)}</span>
                    </div>
                    <div class="detail-row">
                        <span>New Amount:</span>
                        <span>₹${calculation.new_amount.toFixed(2)}</span>
                    </div>
                    <div class="detail-row">
                        <span>Days Remaining:</span>
                        <span>${calculation.days_remaining} days</span>
                    </div>
                    <div class="detail-row">
                        <span>Unused Credit:</span>
                        <span>₹${calculation.unused_credit.toFixed(2)}</span>
                    </div>
                    <div class="detail-row upgrade-amount">
                        <span>Upgrade Amount (Pay Now):</span>
                        <span>₹${calculation.upgrade_amount.toFixed(2)}</span>
                    </div>
                </div>
                <div class="upgrade-note">
                    <strong>Note:</strong> After upgrade, your next billing will be on ${calculation.next_billing_date} 
                    for the full amount of ₹${calculation.new_amount.toFixed(2)}.
                </div>
            </div>
        `;
        
        document.getElementById('summarySubTotal').textContent = `₹${calculation.upgrade_amount.toFixed(2)}`;
        document.getElementById('summaryTotal').textContent = `₹${calculation.upgrade_amount.toFixed(2)}`;
        
        summarySection.insertAdjacentHTML('afterbegin', upgradeInfoHTML);
        
        planSection.style.display = 'none';
        summarySection.classList.add('active');
        summarySection.style.display = 'block';
        updateSteps('summary');
    }

    function handleUpgradePayment() {
        const fullName = document.getElementById("fullName").value.trim();
        const address = document.getElementById("address").value.trim();
        const city = document.getElementById("city").value.trim();
        const state = document.getElementById("state").value.trim();
        const phone = document.getElementById("phone").value.trim();
        const zip = document.getElementById("zip").value.trim();
        const country = document.getElementById("country").value;
    
        if (!fullName || !address || !city || !zip || !country || !phone || !state) {
            app.helper.showErrorNotification({
                message: "Please fill all billing details.",
            });
            return;
        }
        
        if (!/^\d{6}$/.test(zip)) {
            app.helper.showErrorNotification({
                message: "Please enter a valid 6-digit ZIP code.",
            });
            return;
        }
        
        document.getElementById("summarySection").classList.remove("active");
        document.getElementById("paymentSection").style.display = "block";
        document.getElementById("paymentSection").classList.add("active");
        updateSteps("payment");
        
        updatePaymentPreviewForUpgrade();
        
        const payNowBtn = document.getElementById("payNowButton");
        if (payNowBtn) {
            payNowBtn.textContent = upgradeCalculation.upgrade_amount > 0 
                ? `Pay ₹${upgradeCalculation.upgrade_amount.toFixed(2)}`
                : 'Complete Free Upgrade';
        }
    }
    
    function updatePaymentPreviewForUpgrade() {
        document.getElementById("fullNamePreview").textContent = document.getElementById("fullName").value.trim();
        document.getElementById("addressPreview").textContent = document.getElementById("address").value.trim();
        document.getElementById("cityPreview").textContent = document.getElementById("city").value.trim();
        document.getElementById("statePreview").textContent = document.getElementById("state").value.trim();
        document.getElementById("zipPreview").textContent = document.getElementById("zip").value.trim();
        document.getElementById("countryPreview").textContent = document.getElementById("country").value.trim();
        document.getElementById("phonePreview").textContent = document.getElementById("phone").value.trim();

        document.getElementById("paymentPlanName").textContent = upgradeCalculation.new_plan_name;
        document.getElementById("paymentBillingCycle").textContent = upgradeCalculation.billing_cycle;
        document.getElementById("paymentBasePrice").textContent = `₹${upgradeCalculation.upgrade_amount.toFixed(2)}`;
        document.getElementById("paymentTotalAmount").textContent = `₹${upgradeCalculation.upgrade_amount.toFixed(2)}`;
        
        const state = document.getElementById("state").value;
        const companyState = "Karnataka";
        if (state && upgradeCalculation.upgrade_amount > 0) {
            const taxAmount = updateGSTTaxBreakup(state, companyState, upgradeCalculation.upgrade_amount);
            const finalTotal = upgradeCalculation.upgrade_amount + taxAmount;
            document.getElementById("paymentTotalAmount").textContent = `₹${finalTotal.toFixed(2)}`;
        }
        
        const existingNote = document.querySelector('.upgrade-payment-note');
        if (existingNote) existingNote.remove();
        
        const upgradeNote = document.createElement('div');
        upgradeNote.className = 'upgrade-payment-note';
        upgradeNote.style.cssText = 'background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin: 15px 0; color: #856404;';
        upgradeNote.innerHTML = `
            <strong>Upgrade Payment:</strong><br>
            You are upgrading from <strong>${upgradeCalculation.current_plan}</strong> to <strong>${upgradeCalculation.new_plan}</strong><br>
            Upgrade amount covers the difference for remaining ${upgradeCalculation.days_remaining} days.
        `;
        
        const paymentSection = document.getElementById("paymentSection");
        paymentSection.insertAdjacentElement('afterbegin', upgradeNote);
    }
    
    async function processUpgradePayment() {
        app.helper.showProgress();
        
        try {
            const billingDetails = {
                fullName: document.getElementById('fullName').value.trim(),
                address: document.getElementById('address').value.trim(),
                city: document.getElementById('city').value.trim(),
                state: document.getElementById('state').value.trim(),
                phone: document.getElementById('phone').value.trim(),
                zip: document.getElementById('zip').value.trim(),
                country: document.getElementById('country').value.trim()
            };
            
            // const formData = new FormData();
            // formData.append('upgrade_calculation', JSON.stringify(upgradeCalculation));
            // formData.append('billing_details', JSON.stringify(billingDetails));
            // formData.append(csrfMagicName, csrfMagicToken);
            
            // const response = await fetch('index.php?module=PricingPlans&parent=Settings&action=ProcessUpgradeAjax', {
            //     method: 'POST',
            //     headers: { 'x-requested-with': 'XMLHttpRequest' },
            //     body: formData
            // });

            const payload = {
                upgrade_calculation: upgradeCalculation,
                billing_details: billingDetails,
                [csrfMagicName]: csrfMagicToken
            };

            const response = await fetch('index.php?module=PricingPlans&parent=Settings&action=ProcessUpgradeAjax', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'x-requested-with': 'XMLHttpRequest'
                },
                body: JSON.stringify(payload)
            });

            
            const result = await response.json();
            console.log('Upgrade processing result:', result); // Debug log
            
            if (result.success) {
                app.helper.hideProgress();
                
                app.helper.showSuccessNotification({
                    message: 'Subscription upgraded successfully! Your plan will be updated shortly.',
                    type: 'success'
                });
                
                setTimeout(() => {
                    window.location.href = 'index.php?module=MyAccount&parent=Settings&view=List&block=13&fieldid=46';
                }, 2000);
                
            } else {
                throw new Error(result.message || 'Upgrade processing failed');
            }
            
        } catch (error) {
            app.helper.hideProgress();
            console.error('Upgrade processing error:', error);
            app.helper.showErrorNotification({
                message: error.message || 'Failed to process upgrade. Please try again.'
            });
        }
    }

    // Add CSS styles for upgrade interface
    const upgradeStyles = document.createElement('style');
    upgradeStyles.textContent = `
        .current-subscription-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .current-subscription-banner h3 {
            margin: 0 0 10px 0;
            font-size: 1.5em;
        }
        
        .current-subscription-banner p {
            margin: 5px 0;
            opacity: 0.9;
        }
        
        .upgrade-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid white;
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        
        .upgrade-btn:hover {
            background: white !important;
            color: #667eea !important;
        }
        
        .upgrade-instructions {
            background: #f8f9ff;
            border: 1px solid #e1e5fe;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            color: #3f51b5;
        }
        
        .upgrade-instructions h4 {
            margin: 0 0 10px 0;
            color: #3f51b5;
        }
        
        .upgrade-instructions ul {
            margin: 0;
            padding-left: 20px;
        }
        
        .upgrade-summary {
            background: #f8f9ff;
            border: 1px solid #e1e5fe;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .upgrade-summary h4 {
            margin: 0 0 15px 0;
            color: #3f51b5;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        
        .upgrade-amount {
            font-weight: bold;
            font-size: 1.1em;
            color: #4caf50;
            padding-top: 15px;
            border-top: 2px solid #4caf50;
            margin-top: 10px;
            border-bottom: none;
        }
        
        .upgrade-note {
            margin-top: 15px;
            padding: 10px;
            background: #e8f5e8;
            border-radius: 5px;
            font-size: 0.9em;
        }
        
        @media (max-width: 768px) {
            .current-subscription-banner {
                flex-direction: column;
                text-align: center;
            }
            
            .current-plan-info {
                margin-bottom: 15px;
            }
            
            .upgrade-btn {
                width: 100%;
            }
        }
    `;
    document.head.appendChild(upgradeStyles);
});