@php
    $settings = \App\Models\MosqueSetting::getSettings();
@endphp

<section class="mosque-donation-hub" id="donation">
    <div class="hub-container">
        <div class="hub-header">
            <span class="hub-subtitle">Charity & Sadaqah Jariyah</span>
            <h2 class="hub-title">Support {{ $settings->name ?? 'Ipswich Mosque' }}</h2>
            <div class="hub-quote-box">
                <p class="hub-quote">“Whoever builds a mosque for Allah – Allah will build for him a house in Paradise.”</p>
                <cite class="hub-cite">— Prophet Muhammad ﷺ</cite>
            </div>
        </div>

        <div class="hub-grid">
            <div class="hub-card">
                <div class="hub-card-icon">💳</div>
                <h3 class="hub-card-title">Digital Giving</h3>
                <p class="hub-card-desc">Fast and secure online contributions.</p>
                <a href="{{ url('/donate') }}" class="hub-btn-primary">Donate Now</a>
            </div>

            <div class="hub-card">
                <div class="hub-card-icon">📅</div>
                <h3 class="hub-card-title">Regular Giving</h3>
                <p class="hub-card-desc">Support our mission monthly via Direct Debit.</p>
                <a href="{{ url('/donate') }}" class="hub-btn-outline">Setup a Gift</a>
            </div>

            <div class="hub-card hub-card-featured">
                <div class="hub-card-icon">🏛️</div>
                <h3 class="hub-card-title">Bank Transfer</h3>
                <div class="hub-bank-details">
                    @if($settings->bank_account_name)
                        <div class="detail-row"><span>Account:</span> <strong>{{ $settings->bank_account_name }}</strong></div>
                    @endif
                    @if($settings->bank_sort_code)
                        <div class="detail-row"><span>Sort Code:</span> <strong>{{ $settings->bank_sort_code }}</strong></div>
                    @endif
                    @if($settings->bank_account_number)
                        <div class="detail-row"><span>Number:</span> <strong>{{ $settings->bank_account_number }}</strong></div>
                    @endif
                </div>
                @if($settings->donation_standing_order_url)
                    <a href="{{ $settings->donation_standing_order_url }}" target="_blank" class="hub-link">Download Form →</a>
                @endif
            </div>
        </div>
    </div>
</section>

<style>
:root {
    --brand-emerald: #0a5134; /* Your Brand Color */
    --brand-emerald-light: #ecf3f0;
    --text-main: #1e293b;
    --text-muted: #64748b;
}

.mosque-donation-hub {
    background-color: #ffffff;
    padding: 3.5rem 1.5rem; /* Reduced height */
    font-family: 'Inter', sans-serif;
}

.hub-container {
    max-width: 1100px;
    margin: 0 auto;
}

/* Header Styling */
.hub-header {
    text-align: center;
    margin-bottom: 2.5rem;
}

.hub-subtitle {
    display: block;
    color: var(--brand-emerald);
    text-transform: uppercase;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    margin-bottom: 0.5rem;
}

.hub-title {
    font-size: 2.25rem;
    font-weight: 800;
    color: var(--text-main);
    letter-spacing: -0.02em;
    margin-bottom: 1rem;
}

.hub-quote-box {
    max-width: 600px;
    margin: 0 auto;
}

.hub-quote {
    font-size: 1rem;
    color: var(--text-muted);
    font-style: italic;
    line-height: 1.5;
}

.hub-cite {
    display: block;
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--text-main);
    margin-top: 0.5rem;
    font-style: normal;
}

/* Grid & Cards */
.hub-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
}

.hub-card {
    background: #f8fafc;
    padding: 2rem;
    border-radius: 1.5rem;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.hub-card:hover {
    transform: translateY(-4px);
    border-color: var(--brand-emerald);
    background: #fff;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
}

.hub-card-icon {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    opacity: 0.8;
}

.hub-card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-main);
    margin-bottom: 0.5rem;
}

.hub-card-desc {
    font-size: 0.9rem;
    color: var(--text-muted);
    margin-bottom: 1.5rem;
    line-height: 1.4;
}

/* Bank details specific */
.hub-bank-details {
    width: 100%;
    margin-bottom: 1rem;
    background: var(--brand-emerald-light);
    padding: 1rem;
    border-radius: 0.75rem;
    text-align: left;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    font-size: 0.85rem;
    margin-bottom: 0.25rem;
    color: var(--brand-emerald);
}

/* Buttons & Links */
.hub-btn-primary {
    background: var(--brand-emerald);
    color: #fff;
    padding: 0.75rem 1.5rem;
    border-radius: 0.75rem;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
    width: 100%;
    transition: opacity 0.2s;
}

.hub-btn-outline {
    background: transparent;
    color: var(--brand-emerald);
    border: 2px solid var(--brand-emerald);
    padding: 0.65rem 1.5rem;
    border-radius: 0.75rem;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
    width: 100%;
    transition: all 0.2s;
}

.hub-btn-outline:hover {
    background: var(--brand-emerald);
    color: #fff;
}

.hub-link {
    color: var(--brand-emerald);
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 700;
}

@media (max-width: 640px) {
    .hub-title { font-size: 1.75rem; }
    .hub-grid { grid-template-columns: 1fr; }
}
</style>