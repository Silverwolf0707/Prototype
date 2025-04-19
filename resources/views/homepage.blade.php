<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Assistance Application</title>

    <link href="https://cdn.replit.com/agent/bootstrap-agent-dark-theme.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
</head>
<style>
    /* Modal animation */
#application-modal {
    transition: opacity 0.3s ease;
}

#application-modal.hidden {
    opacity: 0;
    pointer-events: none;
}

#application-modal:not(.hidden) {
    opacity: 1;
}

/* Focus styles for accessibility */
button:focus, input:focus, textarea:focus {
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
}

/* Form validation visual cues */
input:invalid, textarea:invalid {
    border-color: #ef4444;
}

input:valid:not(:placeholder-shown), textarea:valid:not(:placeholder-shown) {
    border-color: #10b981;
}

/* Animation for status messages */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

#form-status:not(.hidden) {
    animation: fadeIn 0.3s ease forwards;
}

/* Loading spinner */
.spinner {
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top: 3px solid white;
    width: 20px;
    height: 20px;
    animation: spin 1s linear infinite;
    display: inline-block;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive adjustments */
@media (max-width: 640px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}
</style>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-blue-800 text-white shadow-md">
        <div class="container mx-auto p-4 flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-hand-holding-medical text-3xl mr-3"></i>
                <h1 class="text-2xl md:text-3xl font-bold">Financial Assistance Portal</h1>
            </div>
            <button id="apply-now-btn" class="bg-white text-blue-800 hover:bg-blue-100 px-4 py-2 rounded font-semibold transition-colors">
                Apply Now
            </button>
        </div>
    </header>

    <!-- Main content -->
    <main class="flex-grow">
        <!-- Hero Section -->
        <section class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-16">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Financial Assistance for Medical Needs</h2>
                <p class="text-xl mb-8 max-w-3xl mx-auto">We provide financial support to patients and families facing medical challenges. Apply today to see if you qualify.</p>
                <button id="hero-apply-btn" class="bg-white text-blue-800 hover:bg-blue-100 px-6 py-3 rounded-lg font-bold text-lg transition-colors">
                    Start Application
                </button>
            </div>
        </section>

        <!-- Categories Section -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4">
                <h2 class="text-2xl md:text-3xl font-bold text-center mb-12 text-gray-800">Assistance Categories</h2>
                
                <div class="flex flex-col md:flex-row gap-8 justify-center">
                    <!-- Standard Assistance -->
                    <div class="bg-blue-50 rounded-lg shadow-lg p-6 flex-1 max-w-md mx-auto md:mx-0">
                        <div class="text-center mb-4">
                            <div class="bg-blue-100 inline-block p-3 rounded-full mb-4">
                                <i class="fas fa-dollar-sign text-blue-600 text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Standard Assistance</h3>
                            <p class="text-gray-600 mt-2">For needs under $5,000</p>
                        </div>
                        <ul class="space-y-2 mb-6 text-gray-700">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Faster approval process</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Minimal documentation required</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Covers essential medical expenses</span>
                            </li>
                        </ul>
                        <button data-category="below_5k" class="apply-category-btn w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold transition-colors">
                            Apply for Standard
                        </button>
                    </div>
                    
                    <!-- Extended Assistance -->
                    <div class="bg-blue-50 rounded-lg shadow-lg p-6 flex-1 max-w-md mx-auto md:mx-0">
                        <div class="text-center mb-4">
                            <div class="bg-blue-100 inline-block p-3 rounded-full mb-4">
                                <i class="fas fa-dollar-sign text-blue-600 text-3xl"></i>
                                <i class="fas fa-plus text-blue-600 text-xl absolute mt-1 ml-1"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Extended Assistance</h3>
                            <p class="text-gray-600 mt-2">For needs above $5,000</p>
                        </div>
                        <ul class="space-y-2 mb-6 text-gray-700">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Comprehensive coverage options</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Available for major treatments</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Extended payment periods</span>
                            </li>
                        </ul>
                        <button data-category="above_5k" class="apply-category-btn w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold transition-colors">
                            Apply for Extended
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Process Section -->
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <h2 class="text-2xl md:text-3xl font-bold text-center mb-12 text-gray-800">Application Process</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Step 1 -->
                    <div class="bg-white p-6 rounded-lg shadow-md text-center">
                        <div class="bg-blue-100 w-16 h-16 flex items-center justify-center rounded-full mx-auto mb-4">
                            <span class="text-blue-600 text-2xl font-bold">1</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-gray-800">Complete Application</h3>
                        <p class="text-gray-600">Fill out our simple online form with your basic information and financial needs.</p>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="bg-white p-6 rounded-lg shadow-md text-center">
                        <div class="bg-blue-100 w-16 h-16 flex items-center justify-center rounded-full mx-auto mb-4">
                            <span class="text-blue-600 text-2xl font-bold">2</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-gray-800">Review Process</h3>
                        <p class="text-gray-600">Our team will review your application and may contact you for additional information.</p>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="bg-white p-6 rounded-lg shadow-md text-center">
                        <div class="bg-blue-100 w-16 h-16 flex items-center justify-center rounded-full mx-auto mb-4">
                            <span class="text-blue-600 text-2xl font-bold">3</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-gray-800">Receive Assistance</h3>
                        <p class="text-gray-600">If approved, you'll receive financial assistance directly to the medical provider.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <h2 class="text-xl font-bold mb-2">Financial Assistance Portal</h2>
                    <p class="text-gray-300">Providing support when it's needed most</p>
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-300 hover:text-white transition-colors">
                        <i class="fab fa-facebook text-2xl"></i>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-white transition-colors">
                        <i class="fab fa-twitter text-2xl"></i>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-white transition-colors">
                        <i class="fab fa-instagram text-2xl"></i>
                    </a>
                </div>
            </div>
            <div class="border-t border-gray-600 mt-6 pt-6 text-center text-gray-400">
                <p>&copy; 2023 Financial Assistance Portal. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Application Modal -->
    <div id="application-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 id="modal-title" class="text-2xl font-bold text-gray-800">Financial Assistance Application</h2>
                    <button id="close-modal-btn" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <form id="application-form" class="space-y-4">
                    <input type="hidden" id="category" name="category" value="">
                    
                    <!-- Patient Information -->
                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-lg font-semibold mb-3 text-gray-700">Patient Information</h3>
                        
                        <div class="mb-3">
                            <label for="patient_name" class="block text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" id="patient_name" name="patient_name" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <div class="error-message text-red-500 text-sm mt-1 hidden" id="patient_name_error"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="patient_age" class="block text-gray-700 mb-1">Age <span class="text-red-500">*</span></label>
                            <input type="number" id="patient_age" name="patient_age" min="0" max="120" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <div class="error-message text-red-500 text-sm mt-1 hidden" id="patient_age_error"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="patient_address" class="block text-gray-700 mb-1">Address <span class="text-red-500">*</span></label>
                            <textarea id="patient_address" name="patient_address" rows="3" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                            <div class="error-message text-red-500 text-sm mt-1 hidden" id="patient_address_error"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="contact_number" class="block text-gray-700 mb-1">Contact Number <span class="text-red-500">*</span></label>
                            <input type="tel" id="contact_number" name="contact_number" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <div class="error-message text-red-500 text-sm mt-1 hidden" id="contact_number_error"></div>
                        </div>
                    </div>
                    
                    <!-- Medical Information -->
                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-lg font-semibold mb-3 text-gray-700">Medical Information</h3>
                        
                        <div class="mb-3">
                            <label for="diagnosis" class="block text-gray-700 mb-1">Diagnosis <span class="text-red-500">*</span></label>
                            <textarea id="diagnosis" name="diagnosis" rows="3" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                            <div class="error-message text-red-500 text-sm mt-1 hidden" id="diagnosis_error"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="medical_condition" class="block text-gray-700 mb-1">Medical Condition</label>
                            <input type="text" id="medical_condition" name="medical_condition" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div class="error-message text-red-500 text-sm mt-1 hidden" id="medical_condition_error"></div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                            Submit Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script></script>
</body>
</html>
