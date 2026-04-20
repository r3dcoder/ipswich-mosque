@extends('layouts.dashboard')

@section('title', 'Gift Aid Declaration - ' . $declaration->donor_name)

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <a href="{{ route('admin.gift-aid.index') }}" class="text-emerald-600 hover:text-emerald-800 mb-2 inline-flex items-center gap-1">
            ← Back to Gift Aid Declarations
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Gift Aid Declaration</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Declaration Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Donor Information</h2>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Donor Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $declaration->donor_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $declaration->donor_email }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Full Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $declaration->donor_address ?? 'Not provided' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Postcode</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $declaration->donor_postcode ?? 'Not provided' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $declaration->donor_phone ?? 'Not provided' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    @if($declaration->status === 'active') bg-green-100 text-green-800
                                    @elseif($declaration->status === 'cancelled') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($declaration->status) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Declared At</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $declaration->declared_at->format('d M Y, H:i') }}</dd>
                        </div>
                        @if($declaration->cancelled_at)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Cancelled At</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $declaration->cancelled_at->format('d M Y, H:i') }}</dd>
                        </div>
                        @endif
                    </dl>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <dt class="text-sm font-medium text-gray-500 mb-2">Declaration Text</dt>
                        <dd class="text-sm text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $declaration->declaration_text }}</dd>
                    </div>

                    @if($declaration->notes)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <dt class="text-sm font-medium text-gray-500 mb-2">Notes</dt>
                        <dd class="text-sm text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $declaration->notes }}</dd>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6">
                @if($declaration->status === 'active')
                <form action="{{ route('admin.gift-aid.cancel', $declaration) }}" method="POST" class="inline" 
                      onsubmit="return confirm('Are you sure you want to cancel this Gift Aid declaration?');">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Cancel Declaration
                    </button>
                </form>
                @endif
            </div>
        </div>

        <!-- Summary Statistics -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Donation Summary</h2>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total Donations</dt>
                            <dd class="mt-1 text-2xl font-bold text-gray-900">£{{ number_format($declaration->total_donated, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Gift Aid Claimed</dt>
                            <dd class="mt-1 text-2xl font-bold text-emerald-600">£{{ number_format($declaration->total_gift_aid_claimed, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Number of Donations</dt>
                            <dd class="mt-1 text-2xl font-bold text-gray-900">{{ $donations->count() }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Donations List -->
    <div class="mt-6 bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Donations with Gift Aid</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gift Aid</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($donations as $donation)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $donation->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">£{{ number_format($donation->amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $donation->category_label ?? ucfirst($donation->category ?? 'general') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ucfirst($donation->type) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-emerald-600">£{{ number_format($donation->amount * 0.25, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No donations found for this donor.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection