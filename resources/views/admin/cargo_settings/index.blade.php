@extends('admin.layout.app')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 to-amber-100 py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-amber-900 mb-2">⚙️ Cargo Settings</h1>
            <p class="text-amber-700">Configure cargo fees, taxes, and departure settings</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-100 text-green-800 border-2 border-green-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Backup Button -->
        {{-- <div class="mb-8">
            <a href="{{ route('admin.backup') }}"
               onclick="return confirm('Are you sure you want to download the full database backup?')"
               class="inline-flex items-center bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-3 px-6 rounded-xl transition duration-200 transform hover:scale-105 shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Backup Database
            </a>
        </div> --}}

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Cargo Settings Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-amber-500 to-yellow-500 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Cargo Pricing
                    </h2>
                    <p class="text-amber-100 mt-2">Configure base cargo transportation fees</p>
                </div>
                <div class="px-8 py-8">
                    <form method="POST" action="{{ route('admin.cargo-settings.update', $setting->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label class="block text-sm font-semibold text-amber-800 mb-2 uppercase tracking-wide">Fee per KM</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="fee_per_km" value="{{ $setting->fee_per_km }}" 
                                       class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200 bg-amber-50">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-amber-600 text-sm font-medium">ETB/km</span>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-amber-800 mb-2 uppercase tracking-wide">Tax Percent</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="tax_percent" value="{{ $setting->tax_percent }}" 
                                       class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200 bg-amber-50">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-amber-600 text-sm font-medium">%</span>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-amber-800 mb-2 uppercase tracking-wide">Service Fee</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="service_fee" value="{{ $setting->service_fee }}" 
                                       class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200 bg-amber-50">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-amber-600 text-sm font-medium">ETB</span>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-amber-500 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 text-white font-bold py-4 px-6 rounded-xl transition duration-200 transform hover:scale-105 shadow-lg flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Save Cargo Settings
                        </button>
                    </form>
                </div>
            </div>

            <!-- Departure Fee Settings Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-emerald-500 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Departure Fees
                    </h2>
                    <p class="text-green-100 mt-2">Set tiered departure fee structure</p>
                </div>
                <div class="px-8 py-8">
                    <form method="POST" action="{{ route('admin.cargo-settings.departure-fee') }}" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-semibold text-green-800 mb-2 uppercase tracking-wide">Level 1 Fee</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="level1" value="{{ $departureFees['level1'] ?? '' }}" 
                                       class="w-full px-4 py-3 border-2 border-green-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 bg-green-50">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-green-600 text-sm font-medium">ETB</span>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-green-800 mb-2 uppercase tracking-wide">Level 2 Fee</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="level2" value="{{ $departureFees['level2'] ?? '' }}" 
                                       class="w-full px-4 py-3 border-2 border-green-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 bg-green-50">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-green-600 text-sm font-medium">ETB</span>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-green-800 mb-2 uppercase tracking-wide">Level 3 Fee</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="level3" value="{{ $departureFees['level3'] ?? '' }}" 
                                       class="w-full px-4 py-3 border-2 border-green-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 bg-green-50">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-green-600 text-sm font-medium">ETB</span>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-bold py-4 px-6 rounded-xl transition duration-200 transform hover:scale-105 shadow-lg flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Save Departure Fees
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
