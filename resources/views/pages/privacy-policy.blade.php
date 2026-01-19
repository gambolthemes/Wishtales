@extends('layouts.app')

@section('title', 'Privacy Policy - WishTales')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-12 px-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-primary to-pink-400 rounded-2xl mb-6 shadow-lg">
                <i class="fas fa-shield-alt text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-4">Privacy Policy</h1>
            <p class="text-gray-500">Last updated: {{ date('F d, Y') }}</p>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-2xl shadow-lg p-8 lg:p-12">
            <div class="prose prose-lg max-w-none">
                
                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-info-circle text-primary text-sm"></i>
                        </span>
                        Introduction
                    </h2>
                    <p class="text-gray-600 leading-relaxed">
                        Welcome to WishTales ("we," "our," or "us"). We are committed to protecting your personal information and your right to privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our digital greeting card platform.
                    </p>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-database text-blue-500 text-sm"></i>
                        </span>
                        Information We Collect
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-4">We collect information that you provide directly to us:</p>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-600"><strong>Account Information:</strong> Name, email address, password, and profile picture when you create an account.</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-600"><strong>Card Content:</strong> Messages, recipient information, and customization preferences when you create cards.</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-600"><strong>Contact Information:</strong> Details of recipients you add to your contact list.</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-600"><strong>Payment Information:</strong> Billing details processed securely through our payment providers.</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-600"><strong>Usage Data:</strong> Information about how you interact with our platform.</span>
                        </li>
                    </ul>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-cogs text-green-500 text-sm"></i>
                        </span>
                        How We Use Your Information
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-4">We use the information we collect to:</p>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-arrow-right text-primary mt-1 mr-3"></i>
                            <span class="text-gray-600">Provide, maintain, and improve our services</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-arrow-right text-primary mt-1 mr-3"></i>
                            <span class="text-gray-600">Process and deliver your digital greeting cards</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-arrow-right text-primary mt-1 mr-3"></i>
                            <span class="text-gray-600">Send you notifications about your cards and account</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-arrow-right text-primary mt-1 mr-3"></i>
                            <span class="text-gray-600">Respond to your comments, questions, and support requests</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-arrow-right text-primary mt-1 mr-3"></i>
                            <span class="text-gray-600">Protect against fraudulent or illegal activity</span>
                        </li>
                    </ul>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-share-alt text-yellow-600 text-sm"></i>
                        </span>
                        Information Sharing
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-4">We do not sell your personal information. We may share your information only in these circumstances:</p>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-users text-blue-500 mt-1 mr-3"></i>
                            <span class="text-gray-600"><strong>With Recipients:</strong> Card content is shared with the intended recipients.</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-building text-blue-500 mt-1 mr-3"></i>
                            <span class="text-gray-600"><strong>Service Providers:</strong> With third parties who perform services on our behalf.</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-gavel text-blue-500 mt-1 mr-3"></i>
                            <span class="text-gray-600"><strong>Legal Requirements:</strong> When required by law or to protect our rights.</span>
                        </li>
                    </ul>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-lock text-purple-500 text-sm"></i>
                        </span>
                        Data Security
                    </h2>
                    <p class="text-gray-600 leading-relaxed">
                        We implement appropriate technical and organizational security measures to protect your personal information. This includes encryption, secure servers, and regular security assessments. However, no method of transmission over the Internet is 100% secure.
                    </p>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-user-shield text-red-500 text-sm"></i>
                        </span>
                        Your Rights
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-4">You have the right to:</p>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-xl p-4">
                            <i class="fas fa-eye text-primary mb-2"></i>
                            <p class="text-gray-700 font-medium">Access your data</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <i class="fas fa-edit text-primary mb-2"></i>
                            <p class="text-gray-700 font-medium">Correct inaccuracies</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <i class="fas fa-trash text-primary mb-2"></i>
                            <p class="text-gray-700 font-medium">Delete your account</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <i class="fas fa-download text-primary mb-2"></i>
                            <p class="text-gray-700 font-medium">Export your data</p>
                        </div>
                    </div>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-cyan-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-cookie-bite text-cyan-500 text-sm"></i>
                        </span>
                        Cookies
                    </h2>
                    <p class="text-gray-600 leading-relaxed">
                        We use cookies and similar technologies to enhance your experience, analyze usage, and assist in our marketing efforts. You can control cookies through your browser settings.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-envelope text-pink-500 text-sm"></i>
                        </span>
                        Contact Us
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        If you have questions about this Privacy Policy, please contact us:
                    </p>
                    <div class="bg-gray-50 rounded-xl p-6">
                        <p class="flex items-center text-gray-700 mb-2">
                            <i class="fas fa-envelope text-primary mr-3"></i>
                            privacy@wishtales.com
                        </p>
                        <p class="flex items-center text-gray-700">
                            <i class="fas fa-map-marker-alt text-primary mr-3"></i>
                            123 Card Street, Digital City, DC 10001
                        </p>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
