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
                            <button type="button" class="amount-btn" data-amount="5">£5</button>
                            <button type="button" class="amount-btn" data-amount="10">£10</button>
                            <button type="button" class="amount-btn" data-amount="15">£15</button>
                        </div>
                        <input type="number" id="amount" name="amount" class="form-control"
                            placeholder="Or enter custom amount" min="1" required>
                            <input type="hidden" id="stripe_key" value="{{ config('services.stripe.key') }}">
     
                    </div>
                    <div class="form-group gift-aid">
                        <label>
                            <input type="checkbox" id="gift_aid" name="gift_aid">
                            <strong>Yes - I am a UK taxpayer and would like to Gift Aid my donations</strong>
                        </label>
                        <p class="gift-aid-text">
                            If you are a UK taxpayer your donation could be worth <strong>£6.25 at no extra cost to
                                you</strong>.<br><br>
                            I understand I must pay enough income tax and/or capital gains tax each tax year to cover
                            the amount of Gift Aid that all charities and community amateur sports clubs claim on my
                            donations in that tax year, and I am responsible for paying any difference.<br><br>
                            Please remember to let us know if your tax status, name or address change or if you wish to
                            cancel your Gift Aid declaration.
                        </p>
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


<script src="https://js.stripe.com/v3/"></script>
<script>

    document.getElementById('payment-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const stripe = Stripe("{{ env('STRIPE_KEY') }}"); // ✅ publishable key only
    let elements;


        const amount = document.getElementById('amount').value;
        const donationType = document.querySelector('input[name="donation_type"]:checked').value;
        const frequency = document.querySelector('input[name="frequency"]:checked')?.value;
        const giftAid = document.getElementById('gift_aid').checked;

        // 1. Ask backend for PaymentIntent
        const res = await fetch("/create-payment-intent", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ amount, donation_type: donationType, frequency, gift_aid: giftAid })
        });

        const { clientSecret, error } = await res.json();
        if (error) {
            alert(error);
            return;
        }

        // 2. Mount Stripe Payment Element
        if (!elements) {
            elements = stripe.elements({ clientSecret });
            const paymentElement = elements.create("payment");
            paymentElement.mount("#payment-element");
        }

        // 3. Confirm Payment
        const { error: submitError } = await stripe.confirmPayment({
            elements,
            confirmParams: {
                return_url: "{{ url('/donation-success') }}", // redirect after payment
            }
        });

        if (submitError) {
            document.querySelector("#payment-message").textContent = submitError.message;
        }
    });
</script>
