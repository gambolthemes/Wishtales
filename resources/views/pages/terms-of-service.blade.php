@extends('layouts.app')

@section('title', 'Terms of Service - WishTales')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-12 px-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-primary to-pink-400 rounded-2xl mb-6 shadow-lg">
                <i class="fas fa-file-contract text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-4">Terms of Service</h1>
            <p class="text-gray-500">Last updated: {{ date('F d, Y') }}</p>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-2xl shadow-lg p-8 lg:p-12">
            <div class="prose prose-lg max-w-none">
                
                <!-- Agreement Notice -->
                <div class="bg-primary/5 border-l-4 border-primary rounded-r-xl p-6 mb-10">
                    <p class="text-gray-700 mb-0">
                        <i class="fas fa-info-circle text-primary mr-2"></i>
                        By accessing or using WishTales, you agree to be bound by these Terms of Service. Please read them carefully before using our platform.
                    </p>
                </div>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mr-3 text-sm font-bold">1</span>
                        Acceptance of Terms
                    </h2>
                    <p class="text-gray-600 leading-relaxed">
                        By creating an account or using WishTales, you acknowledge that you have read, understood, and agree to be bound by these Terms of Service and our Privacy Policy. If you do not agree to these terms, please do not use our services.
                    </p>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mr-3 text-sm font-bold">2</span>
                        Description of Service
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        WishTales is a digital greeting card platform that allows users to:
                    </p>
                    <ul class="space-y-2">
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            Create and customize digital greeting cards
                        </li>
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            Send cards to recipients via email
                        </li>
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            Schedule card delivery for future dates
                        </li>
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            Generate AI-powered card designs
                        </li>
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            Manage contacts and track sent cards
                        </li>
                    </ul>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mr-3 text-sm font-bold">3</span>
                        User Accounts
                    </h2>
                    <div class="space-y-4">
                        <div class="bg-gray-50 rounded-xl p-5">
                            <h4 class="font-semibold text-gray-800 mb-2">
                                <i class="fas fa-user-plus text-primary mr-2"></i>Registration
                            </h4>
                            <p class="text-gray-600 text-sm">You must provide accurate and complete information when creating an account. You are responsible for maintaining the confidentiality of your account credentials.</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-5">
                            <h4 class="font-semibold text-gray-800 mb-2">
                                <i class="fas fa-birthday-cake text-primary mr-2"></i>Age Requirement
                            </h4>
                            <p class="text-gray-600 text-sm">You must be at least 13 years old to use WishTales. Users under 18 should have parental consent.</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-5">
                            <h4 class="font-semibold text-gray-800 mb-2">
                                <i class="fas fa-key text-primary mr-2"></i>Account Security
                            </h4>
                            <p class="text-gray-600 text-sm">You are responsible for all activities that occur under your account. Notify us immediately of any unauthorized use.</p>
                        </div>
                    </div>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mr-3 text-sm font-bold">4</span>
                        Acceptable Use
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-4">When using WishTales, you agree NOT to:</p>
                    <ul class="space-y-2">
                        <li class="flex items-start text-gray-600">
                            <i class="fas fa-times-circle text-red-500 mt-1 mr-3"></i>
                            <span>Send cards containing offensive, harassing, or illegal content</span>
                        </li>
                        <li class="flex items-start text-gray-600">
                            <i class="fas fa-times-circle text-red-500 mt-1 mr-3"></i>
                            <span>Use the service to spam or send unsolicited messages</span>
                        </li>
                        <li class="flex items-start text-gray-600">
                            <i class="fas fa-times-circle text-red-500 mt-1 mr-3"></i>
                            <span>Impersonate others or misrepresent your identity</span>
                        </li>
                        <li class="flex items-start text-gray-600">
                            <i class="fas fa-times-circle text-red-500 mt-1 mr-3"></i>
                            <span>Violate any applicable laws or regulations</span>
                        </li>
                        <li class="flex items-start text-gray-600">
                            <i class="fas fa-times-circle text-red-500 mt-1 mr-3"></i>
                            <span>Attempt to gain unauthorized access to our systems</span>
                        </li>
                        <li class="flex items-start text-gray-600">
                            <i class="fas fa-times-circle text-red-500 mt-1 mr-3"></i>
                            <span>Upload malicious code or interfere with the service</span>
                        </li>
                    </ul>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mr-3 text-sm font-bold">5</span>
                        Intellectual Property
                    </h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="border border-gray-200 rounded-xl p-5">
                            <h4 class="font-semibold text-gray-800 mb-2">Our Content</h4>
                            <p class="text-gray-600 text-sm">All card designs, templates, and platform content are owned by WishTales or our licensors and protected by copyright laws.</p>
                        </div>
                        <div class="border border-gray-200 rounded-xl p-5">
                            <h4 class="font-semibold text-gray-800 mb-2">Your Content</h4>
                            <p class="text-gray-600 text-sm">You retain ownership of messages and content you create. You grant us a license to use this content to provide our services.</p>
                        </div>
                    </div>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mr-3 text-sm font-bold">6</span>
                        Premium Subscriptions
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Premium features are available through paid subscriptions:
                    </p>
                    <ul class="space-y-2">
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-credit-card text-primary mr-3"></i>
                            Subscriptions auto-renew unless cancelled
                        </li>
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-undo text-primary mr-3"></i>
                            Refunds are handled on a case-by-case basis
                        </li>
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-ban text-primary mr-3"></i>
                            You can cancel anytime from your account settings
                        </li>
                    </ul>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mr-3 text-sm font-bold">7</span>
                        Limitation of Liability
                    </h2>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5">
                        <p class="text-gray-700 text-sm">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                            WishTales is provided "as is" without warranties of any kind. We are not liable for any indirect, incidental, or consequential damages arising from your use of the service. Our total liability is limited to the amount you paid us in the past 12 months.
                        </p>
                    </div>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mr-3 text-sm font-bold">8</span>
                        Termination
                    </h2>
                    <p class="text-gray-600 leading-relaxed">
                        We reserve the right to suspend or terminate your account if you violate these Terms. You may also delete your account at any time. Upon termination, your right to use the service will immediately cease.
                    </p>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mr-3 text-sm font-bold">9</span>
                        Changes to Terms
                    </h2>
                    <p class="text-gray-600 leading-relaxed">
                        We may update these Terms from time to time. We will notify you of significant changes via email or through the platform. Continued use after changes constitutes acceptance of the new Terms.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mr-3 text-sm font-bold">10</span>
                        Contact Information
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        For questions about these Terms, please contact us:
                    </p>
                    <div class="bg-gray-50 rounded-xl p-6">
                        <p class="flex items-center text-gray-700 mb-2">
                            <i class="fas fa-envelope text-primary mr-3"></i>
                            legal@wishtales.com
                        </p>
                        <p class="flex items-center text-gray-700">
                            <i class="fas fa-map-marker-alt text-primary mr-3"></i>
                            123 Card Street, Digital City, DC 10001
                        </p>
                    </div>
                </section>
            </div>
        </div>

        <!-- Agreement Footer -->
        <div class="mt-8 text-center">
            <p class="text-gray-500 text-sm">
                By using WishTales, you acknowledge that you have read and agree to these Terms of Service.
            </p>
        </div>
    </div>
</div>
@endsection
