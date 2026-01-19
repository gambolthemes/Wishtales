@extends('layouts.app')

@section('title', 'Billing History - WishTales')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-12 px-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Billing History</h1>
                <p class="text-gray-500">View your payment history and download invoices</p>
            </div>
            <a href="{{ route('profile.show') }}" class="text-gray-600 hover:text-primary">
                <i class="fas fa-arrow-left mr-2"></i> Back to Profile
            </a>
        </div>

        <!-- Current Plan -->
        @if(auth()->user()->activeSubscription())
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Current Plan</h3>
                    <p class="text-gray-500">{{ auth()->user()->activeSubscription()->plan->name }} - {{ auth()->user()->activeSubscription()->plan->formatted_price }}</p>
                </div>
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold 
                    {{ auth()->user()->activeSubscription()->isActive() ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                    <i class="fas fa-circle text-xs"></i>
                    {{ ucfirst(auth()->user()->activeSubscription()->status) }}
                </span>
            </div>
        </div>
        @endif

        <!-- Payment History -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-800">Payment History</h2>
            </div>

            @if($payments->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Payment</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Invoice</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($payments as $payment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                {{ $payment->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $payment->description ?? 'Subscription payment' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">
                                {{ $payment->formatted_amount }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($payment->isCompleted())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Paid
                                </span>
                                @elseif($payment->isRefunded())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Refunded
                                </span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ ucfirst($payment->status) }}
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $payment->card_display ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                @if($payment->stripe_invoice_id)
                                <a href="#" class="text-primary hover:text-primary-dark">
                                    <i class="fas fa-download mr-1"></i> PDF
                                </a>
                                @else
                                <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $payments->links() }}
            </div>
            @else
            <div class="px-6 py-12 text-center">
                <i class="fas fa-receipt text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">No payment history yet</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
