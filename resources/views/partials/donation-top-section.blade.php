<style>
    /* Gift Aid Checkbox Styles - Enhanced Visibility */
    .gift-aid-container {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border: 2px solid #16a34a;
        border-radius: 12px;
        padding: 20px;
        margin: 16px 0;
        transition: all 0.3s ease;
    }

    .gift-aid-container:hover {
        border-color: #15803d;
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.15);
    }

    .gift-aid-label {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        cursor: pointer;
        margin-bottom: 16px;
    }

    .gift-aid-checkbox-wrapper {
        position: relative;
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        margin-top: 2px;
    }

    .gift-aid-checkbox {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
        z-index: 2;
    }

    .gift-aid-checkmark {
        position: absolute;
        top: 0;
        left: 0;
        width: 24px;
        height: 24px;
        background: white;
        border: 2px solid #16a34a;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .gift-aid-checkmark::after {
        content: '';
        position: absolute;
        display: none;
        left: 7px;
        top: 3px;
        width: 6px;
        height: 12px;
        border: solid #16a34a;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .gift-aid-checkbox:checked + .gift-aid-checkmark {
        background: #16a34a;
        border-color: #16a34a;
    }

    .gift-aid-checkbox:checked + .gift-aid-checkmark::after {
        display: block;
        border-color: white;
    }

    .gift-aid-checkbox:focus + .gift-aid-checkmark {
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.3);
    }

    .gift-aid-text-main {
        font-size: 16px;
        font-weight: 600;
        color: #166534;
        line-height: 1.4;
    }

    .gift-aid-info {
        background: rgba(255, 255, 255, 0.7);
        border-radius: 8px;
        padding: 16px;
        margin-top: 12px;
    }

    .gift-aid-highlight {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        font-size: 14px;
        color: #15803d;
        font-weight: 500;
        margin-bottom: 12px;
        line-height: 1.5;
    }

    .gift-aid-icon {
        width: 20px;
        height: 20px;
        flex-shrink: 0;
        color: #16a34a;
        margin-top: 1px;
    }

    .gift-aid-text {
        font-size: 13px;
        color: #4b5563;
        line-height: 1.6;
        margin-bottom: 8px;
    }

    .gift-aid-text:last-child {
        margin-bottom: 0;
    }
</style>

<div class="donationForm">
    <div class="donationFormItems" aria-label="Donate">
        <div class="contentBlockWrapper">
            <!-- Stripe Donation Form -->
            <div class="donation-form">
                <h3>Online Donation</h3>
                <form id="payment-form">
                    @csrf
                    <!-- Step 1: Donation Type -->
                    <div class="form-group donation-type">
                        <label>Donation Type</label>
                        <div class="type-options">
                            <label>
                                <input type="radio" name="donation_type" value="one-off" checked>
                                One-off
                            </label>
                            <label>
                                <input type="radio" name="donation_type" value="regular">
                                Regular
                            </label>
                        </div>
                    </div>

                    <!-- Donor Information (for subscriptions) -->
                    <div class="form-group donor-info" style="display: none;">
                        <label>Donor Information</label>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="donor_name">Full Name</label>
                                <input type="text" id="donor_name" name="donor_name" class="form-control" placeholder="Your full name">
                            </div>
                            <div>
                                <label for="donor_email">Email Address</label>
                                <input type="email" id="donor_email" name="donor_email" class="form-control" placeholder="your@email.com">
                            </div>
                        </div>
                    </div>

                    <!-- Gift Aid Information (shown when Gift Aid is checked) -->
                    <div class="form-group gift-aid-details" style="display: none;">
                        <label>Gift Aid Details (Required for HMRC)</label>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label for="donor_address">Full Address</label>
                                <input type="text" id="donor_address" name="donor_address" class="form-control" placeholder="Your full address including house number and street">
                            </div>
                            <div>
                                <label for="donor_postcode">Postcode</label>
                                <input type="text" id="donor_postcode" name="donor_postcode" class="form-control" placeholder="e.g. IP4 1JB">
                            </div>
                            <div>
                                <label for="donor_phone">Phone Number (Optional)</label>
                                <input type="tel" id="donor_phone" name="donor_phone" class="form-control" placeholder="Your phone number">
                            </div>
                        </div>
                    </div>


                    <!-- Step 3: Frequency for Regular Donations -->
                    <div class="form-group donation-frequency" style="display: none;">
                        <label>Donation Frequency</label>
                        <div class="frequency-options">
                            <label>
                                <input type="radio" name="frequency" value="monthly" checked>
                                Monthly
                            </label>
                            <label>
                                <input type="radio" name="frequency" value="quarterly">
                                Quarterly
                            </label>
                            <label>
                                <input type="radio" name="frequency" value="annually">
                                Annually
                            </label>
                            
                        </div>
                    </div>

                    <!-- Step 2: Donation Amount -->
                    <div class="form-group donation-amount">
                        <label for="amount">Donation Amount (£)</label>
                        <div class="amount-buttons">
                            <button type="button" class="amount-btn" data-amount="5" style="cursor: pointer; padding: 8px 16px; border: 2px solid #007bff; background: white; color: #007bff; border-radius: 4px; font-weight: bold;">£5</button>
                            <button type="button" class="amount-btn" data-amount="10" style="cursor: pointer; padding: 8px 16px; border: 2px solid #007bff; background: white; color: #007bff; border-radius: 4px; font-weight: bold;">£10</button>
                            <button type="button" class="amount-btn" data-amount="15" style="cursor: pointer; padding: 8px 16px; border: 2px solid #007bff; background: white; color: #007bff; border-radius: 4px; font-weight: bold;">£15</button>
                        </div>
                        <input type="number" id="amount" name="amount" class="form-control"
                            placeholder="Or enter custom amount" min="1" required>
                            <input type="hidden" id="stripe_key" value="{{ config('services.stripe.key') }}">
     
                    </div>

                    <!-- Donation Category -->
                    <div class="form-group donation-category">
                        <label for="category">Donation Category</label>
                        <select id="category" name="category" class="form-control" style="width: 100%; padding: 10px; border: 2px solid #e3e3e0; border-radius: 8px; font-size: 14px; background: white;">
                            <option value="general">General Donation</option>
                            <option value="zakat">Zakat</option>
                            <option value="sadaqah">Sadaqah</option>
                            <option value="fitra">Fitra (Fitrana)</option>
                            <option value="qurbani">Qurbani</option>
                            <option value="lillah">Lillah</option>
                            <option value="mosque">Mosque Maintenance</option>
                            <option value="education">Education</option>
                            <option value="emergency">Emergency Relief</option>
                        </select>
                    </div>

                    <!-- Payment Methods Info -->
                    <div class="payment-methods-info">
                        <p class="payment-methods-text">
                            <strong>Fast & Secure Payment Options:</strong>
                        </p>
                        <div class="payment-methods-logos">
                            <span class="payment-method-badge">💳 Card</span>
                            <span class="payment-method-badge">📱 Google Pay</span>
                            <span class="payment-method-badge">🍎 Apple Pay</span>
                        </div>
                        <p class="payment-methods-note">
                            Google Pay and Apple Pay will appear automatically if your device supports them.
                        </p>
                    </div>
                    <div class="form-group gift-aid">
                        <div class="gift-aid-container">
                            <label class="gift-aid-label">
                                <div class="gift-aid-checkbox-wrapper">
                                    <input type="checkbox" id="gift_aid" name="gift_aid" class="gift-aid-checkbox">
                                    <span class="gift-aid-checkmark"></span>
                                </div>
                                <span class="gift-aid-text-main">
                                    <strong>Yes - I am a UK taxpayer and would like to Gift Aid my donations</strong>
                                </span>
                            </label>
                            <div class="gift-aid-info">
                                <p class="gift-aid-highlight">
                                    <svg class="gift-aid-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    If you are a UK taxpayer your donation could be worth <strong>£6.25 at no extra cost to you</strong>.
                                </p>
                                <p class="gift-aid-text">
                                    I understand I must pay enough income tax and/or capital gains tax each tax year to cover
                                    the amount of Gift Aid that all charities and community amateur sports clubs claim on my
                                    donations in that tax year, and I am responsible for paying any difference.
                                </p>
                                <p class="gift-aid-text">
                                    Please remember to let us know if your tax status, name or address change or if you wish to
                                    cancel your Gift Aid declaration.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Stripe Payment Element -->
                    <div id="payment-element"></div>
                    <div id="payment-message" class="hidden"></div>
                    <button type="submit" id="submit" class="btn">Donate Now</button>
                </form>


                <!-- Loading Animation -->
                <div class="lds-ellipsis" style="display: none;">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>

        <!-- Other Donation Methods -->
        <div class="other-methods">
            <h3>Other Ways to Donate</h3>
            <div class="method">
                <h4>Bank Transfer</h4>
                <p><strong>Account Name:</strong> Ipswich Mosque </p>
                <p><strong>Bank Name:</strong> Lloyd's Bank Plc</p>
                <p><strong>Account No.:</strong> 04910428</p>
                <p><strong>Sort Code:</strong> 30-94-55</p>

            </div>
            <div class="method">
                <h4>Post</h4>
                <p>Post one-off cheques made payable to: “Ipswich Mosque Trust”</p>
                <p>Ipswich Mosque, 32-36 Bond Street, Ipswich, IP4 1JB, United Kingdom</p>
            </div>
            <div class="method">
                <h4>Standing Order</h4>
                <p>Automate a regular donation by downloading, completing, and posting <a
                        href="{{ asset('storage/standing-order.pdf') }}" class="link">this standing order form</a> to
                    your bank.</p>
            </div>
            <p class="note">⚠️ Please note: Donations of all kinds are strictly non-refundable.</p>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Stripe with publishable key
        const stripe = Stripe("{{ config('services.stripe.key') }}");
        let elements;
        let paymentElement;

        // Handle Donation Type Toggle
        const donationTypeRadios = document.querySelectorAll('input[name="donation_type"]');
        const frequencySection = document.querySelector('.donation-frequency');
        const donorInfoSection = document.querySelector('.donor-info');
        const giftAidCheckbox = document.getElementById('gift_aid');
        const giftAidDetailsSection = document.querySelector('.gift-aid-details');

        function toggleFormSections() {
            const selectedType = document.querySelector('input[name="donation_type"]:checked').value;
            
            // Show/hide frequency options
            frequencySection.style.display = selectedType === 'regular' ? 'block' : 'none';
            
            // Show/hide donor info for regular donations
            donorInfoSection.style.display = selectedType === 'regular' ? 'block' : 'none';
        }

        // Handle Gift Aid checkbox toggle
        function toggleGiftAidDetails() {
            const isGiftAidChecked = giftAidCheckbox.checked;
            giftAidDetailsSection.style.display = isGiftAidChecked ? 'block' : 'none';
            
            // If Gift Aid is checked, also show donor info section if it's hidden
            if (isGiftAidChecked && donorInfoSection.style.display === 'none') {
                // For one-off donations with Gift Aid, we still need donor info
                donorInfoSection.style.display = 'block';
            }
        }

        // Initialize form visibility
        toggleFormSections();
        toggleGiftAidDetails();

        // Add event listeners to radio buttons
        donationTypeRadios.forEach(radio => {
            radio.addEventListener('change', toggleFormSections);
        });

        // Add event listener to Gift Aid checkbox
        giftAidCheckbox.addEventListener('change', toggleGiftAidDetails);

        // Handle Amount Buttons
        const amountButtons = document.querySelectorAll('.amount-btn');
        const amountInput = document.getElementById('amount');
        
        amountButtons.forEach(button => {
            button.addEventListener('click', function() {
                const amount = this.dataset.amount;
                console.log('Button clicked:', amount); // Debug log
                if (amountInput) {
                    amountInput.value = amount;
                    console.log('Amount set to:', amount); // Debug log
                }
                // Remove selected class from all buttons
                amountButtons.forEach(btn => btn.classList.remove('selected'));
                // Add selected class to clicked button
                this.classList.add('selected');
            });
        });

        // Handle Form Submission
        document.getElementById('payment-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const amount = document.getElementById('amount').value;
        const donationType = document.querySelector('input[name="donation_type"]:checked').value;
        const frequency = document.querySelector('input[name="frequency"]:checked')?.value;
        const giftAid = document.getElementById('gift_aid').checked;
        const category = document.getElementById('category').value;
        const donorName = document.getElementById('donor_name')?.value;
        const donorEmail = document.getElementById('donor_email')?.value;
        const donorAddress = document.getElementById('donor_address')?.value;
        const donorPostcode = document.getElementById('donor_postcode')?.value;
        const donorPhone = document.getElementById('donor_phone')?.value;

        // Validate donor info for regular donations
        if (donationType === 'regular') {
            if (!donorName || !donorEmail) {
                alert('Please enter your name and email for regular donations.');
                return;
            }
        }

        // Validate Gift Aid details if Gift Aid is selected
        if (giftAid) {
            if (!donorName || !donorEmail) {
                alert('Please enter your name and email for Gift Aid donations.');
                return;
            }
            if (!donorAddress || !donorPostcode) {
                alert('Please enter your full address and postcode for Gift Aid. This is required by HMRC.');
                return;
            }
        }

        // Show loading
        const submitButton = document.getElementById('submit');
        const loadingAnimation = document.querySelector('.lds-ellipsis');
        submitButton.disabled = true;
        loadingAnimation.style.display = 'flex';

        try {
            // 1. Ask backend for PaymentIntent or Subscription
            const res = await fetch("/create-payment-intent", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ 
                    amount, 
                    donation_type: donationType, 
                    frequency, 
                    gift_aid: giftAid,
                    category: category,
                    donor_name: donorName,
                    donor_email: donorEmail,
                    donor_address: donorAddress,
                    donor_postcode: donorPostcode,
                    donor_phone: donorPhone
                })
            });

            const { clientSecret, error } = await res.json();
            if (error) {
                alert(error);
                submitButton.disabled = false;
                loadingAnimation.style.display = 'none';
                return;
            }

            // 2. Mount Stripe Payment Element (reuse if already mounted)
            if (!elements) {
                elements = stripe.elements({ clientSecret });
                const paymentElement = elements.create("payment");
                paymentElement.mount("#payment-element");
            } else {
                // Update the existing elements with new clientSecret
                elements.update({ clientSecret });
            }

            // 3. Confirm Payment
            const { error: submitError, paymentIntent } = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: "{{ url('/donation-success') }}", // redirect after payment
                },
                redirect: 'if_required' // Only redirect if needed (e.g., 3D Secure)
            });

            if (submitError) {
                document.querySelector("#payment-message").textContent = submitError.message;
                document.querySelector("#payment-message").classList.remove('hidden');
                submitButton.disabled = false;
                loadingAnimation.style.display = 'none';
            } else if (paymentIntent && paymentIntent.status === 'succeeded') {
                // Payment succeeded, redirect to success page
                window.location.href = "{{ url('/donation-success') }}?payment_intent=" + paymentIntent.id;
            }

        } catch (err) {
            console.error('Payment error:', err);
            document.querySelector("#payment-message").textContent = err.message;
            document.querySelector("#payment-message").classList.remove('hidden');
            submitButton.disabled = false;
            loadingAnimation.style.display = 'none';
        }
    });
    }); // End DOMContentLoaded
</script>
