# Regular Donation Payment System Implementation

## Overview
Successfully implemented recurring payment functionality for regular donations (monthly, quarterly, and annually) using Stripe Subscriptions API, alongside the existing one-off donation system.

## Changes Made

### 1. Database & Models
- **Created Donation Model** (`app/Models/Donation.php`)
  - Tracks all donation records with fields for donor info, amounts, types, frequencies, and Stripe IDs
  - Includes query scopes for filtering by type and status

- **Created Migration** (`database/migrations/2026_04_20_115051_create_donations_table.php`)
  - Stores donation records with proper indexing for performance
  - Fields: donor_name, donor_email, amount, type, frequency, status, gift_aid, stripe_customer_id, stripe_subscription_id, etc.

### 2. Backend Controller Updates
- **Updated DonationController** (`app/Http/Controllers/DonationController.php`)
  - `createPaymentIntent()`: Handles both one-off and regular donations
    - For one-off: Creates Stripe PaymentIntent
    - For regular: Creates Stripe Customer, Price, and Subscription
  - Added donor information collection (name, email) for subscriptions
  - Proper error handling and validation

### 3. Frontend Updates
- **Updated Donation Form** (`resources/views/partials/donation-top-section.blade.php`)
  - Added donor information fields (name, email) that appear for regular donations
  - Enhanced JavaScript to handle both payment flows
  - Improved form validation
  - Better loading states and error handling
  - Uses Stripe's `confirmPayment` with `redirect: 'if_required'` for better UX

### 4. Admin Panel
- **Added Donations Management** (`resources/views/admin-panel/donations.blade.php`)
  - Comprehensive dashboard with filters (type, status, frequency, date range)
  - Summary statistics cards
  - Paginated table view of all donations
  - Search functionality by donor name, email, or Stripe IDs

- **Updated AdminController** (`app/Http/Controllers/AdminController.php`)
  - Added `donations()` method with filtering and search capabilities
  - Updated home dashboard to show donation statistics

- **Updated Dashboard Layout** (`resources/views/layouts/dashboard.blade.php`)
  - Added "Donations" link to sidebar navigation

- **Updated Home Dashboard** (`resources/views/admin-panel/home.blade.php`)
  - Added "Total Donations" statistics card

### 5. Routes
- **Added Admin Route** (`routes/web.php`)
  - `GET /admin/donations` → `admin.donations` route

## How It Works

### One-Off Donations (Existing)
1. User selects "One-off" donation type
2. Enters amount and payment details
3. Stripe PaymentIntent is created
4. Payment is confirmed
5. Donation record is saved with status "completed"

### Regular Donations (New)
1. User selects "Regular" donation type
2. Chooses frequency: Monthly, Quarterly, or Annually
3. Enters donor name and email (required for subscriptions)
4. Enters amount and payment details
5. Backend creates:
   - Stripe Customer (with donor email)
   - Stripe Price (with recurring interval)
   - Stripe Subscription (in incomplete state)
6. Payment is confirmed for the first payment
7. Subscription becomes active for future recurring payments
8. Donation record is saved with subscription details

## Stripe Integration Details

### For Regular Donations:
- **Customer**: Created with donor's email for tracking
- **Price**: Created with:
  - `unit_amount`: Donation amount in pence
  - `recurring.interval`: month/year
  - `recurring.interval_count`: 1 for monthly/annually, 3 for quarterly
- **Subscription**: Created with `payment_behavior: 'default_incomplete'` to allow payment confirmation

### Payment Flow:
1. Frontend requests payment intent/subscription from backend
2. Backend returns `clientSecret`
3. Frontend mounts Stripe Payment Element
4. User enters payment details
5. `stripe.confirmPayment()` confirms the payment
6. On success, redirect to `/donation-success` page

## Testing

To test the implementation:

1. **One-Off Donation**:
   - Visit `/donate`
   - Select "One-off"
   - Enter amount
   - Complete payment with Stripe test card

2. **Regular Donation**:
   - Visit `/donate`
   - Select "Regular"
   - Choose frequency (Monthly/Quarterly/Annually)
   - Enter donor name and email
   - Enter amount
   - Complete payment with Stripe test card

3. **Admin View**:
   - Login to admin panel
   - Visit `/admin/donations`
   - View all donations with filters

## Stripe Test Cards
- Success: `4242 4242 4242 4242`
- Requires authentication: `4000 0027 6000 3184`
- Declined: `4000 0000 0000 0002`

## Future Enhancements
- [ ] Email notifications for successful subscriptions
- [ ] Subscription management (cancel, update) from admin panel
- [ ] Webhook handling for subscription events (failed payments, cancellations)
- [ ] Donor portal to manage their own subscriptions
- [ ] Gift Aid declaration storage and reporting
- [ ] Export donation reports to CSV/PDF

## Notes
- All Stripe API calls use test keys from `.env` file
- Donations are non-refundable as per mosque policy
- Gift Aid checkbox is available for UK taxpayers
- Minimum donation amount is £1 (validated on backend)