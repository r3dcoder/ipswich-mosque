<div class="donationForm">
    <div class="donationFormItems"   aria-label="Donate">
        <div class="contentBlockWrapper">
            <!-- Stripe Donation Form -->
            <div class="donation-form">
                <h3>Online Donation</h3>
                <form id="payment-form" >
                    @csrf
                    <!-- Step 1: Donation Type -->
                    <div class="form-group donation-type">
                        <label>Donation Type</label>
                        <div class="type-options">
                            <label>
                                <input type="radio" name="donation_type" value="one-off" checked> One-off
                            </label>
                            <label>
                                <input type="radio" name="donation_type" value="regular"> Regular
                            </label>
                        </div>
                    </div>


                    <!-- Step 3: Frequency for Regular Donations -->
                    <div class="form-group donation-frequency" style="display: none;">
                        <label for="frequency">Donation Frequency</label>
                        <select id="frequency" name="frequency" class="form-control">
                            <option value="monthly">Monthly</option>
                            <option value="quarterly">Quarterly</option>
                            <option value="annually">Annually</option>
                        </select>
                    </div>
                    
                    <!-- Step 2: Donation Amount -->
                    <div class="form-group donation-amount">
                        <label for="amount">Donation Amount (£)</label>
                        <div class="amount-buttons">
                            <button type="button" class="amount-btn" data-amount="5">£5</button>
                            <button type="button" class="amount-btn" data-amount="10">£10</button>
                            <button type="button" class="amount-btn" data-amount="15">£15</button>
                        </div>
                        <input type="number" id="amount" name="amount" class="form-control"
                            placeholder="Or enter custom amount" min="1" required>
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
                <p><strong>Account Name:</strong> Ipswich Mosque Trust</p>
                <p><strong>Bank Name:</strong> HSBC</p>
                <p><strong>Account No.:</strong> 12345678</p>
                <p><strong>Sort Code:</strong> 40-16-08</p>
                <p><strong>IBAN:</strong> GB12 HBUK 4016 0812 3456 78</p>
                <p><strong>Branch Identifier Code:</strong> HBUKGB4103J</p>
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

<script>
    // Initialize Stripe
    // const stripe = Stripe('{{ env('STRIPE_KEY') }}');
    // const elements = stripe.elements();
    // const paymentElement = elements.create('payment');
    // paymentElement.mount('#payment-element');

// Handle Donation Type Toggle
    const donationTypeRadios = document.querySelectorAll('input[name="donation_type"]');
    const frequencySection = document.querySelector('.donation-frequency');
    
    function toggleFrequencyDropdown() {
        console.log("selectedType");
        const selectedType = document.querySelector('input[name="donation_type"]:checked').value;
        console.log(selectedType);

        frequencySection.style.display = selectedType === 'regular' ? 'block' : 'none';
    }

    // Initialize dropdown visibility
    toggleFrequencyDropdown();

    // Add event listeners to radio buttons
    donationTypeRadios.forEach(radio => {
        radio.addEventListener('change', toggleFrequencyDropdown);
    });
    // Handle Amount Buttons
    const amountButtons = document.querySelectorAll('.amount-btn');
    const amountInput = document.getElementById('amount');
    amountButtons.forEach(button => {
        button.addEventListener('click', () => {
            amountInput.value = button.dataset.amount;
            amountButtons.forEach(btn => btn.classList.remove('selected'));
            button.classList.add('selected');
        });
    });

</script>