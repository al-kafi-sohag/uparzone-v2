@extends('user.layout.master')

@section('title', 'Complete Profile')

@push('styles')
@endpush

@section('content')
<div class="p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="w-full bg-gray-200 h-1">
            <div id="progress-bar" class="bg-teal-600 h-1 transition-all duration-500 ease-out" style="width: 20%">
            </div>
        </div>
        <div class="px-6 py-4 bg-teal-500 text-white flex justify-between items-center">
            <h2 id="step-title" class="text-lg font-semibold">{{ __('Choose Language') }}</h2>
            <button id="speak-button" class="p-2 rounded-full hover:bg-teal-600 transition-colors"
                aria-label="Play voice guidance">
                <i data-lucide="volume-2" class="w-5 h-5"></i>
            </button>
        </div>
        <div id="form-container" class="p-6">
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            //Initialize the form
            initForm();
        });

        const formState = {
                currentStep: 1,
                totalSteps: 5,
                language: '',
                age: '',
                gender: '',
                profession: '',
                mood: '',
                referenceCode: '',
                referrerName: '',
                isLoading: false,
                error: '',
                success: ''
        };

        const textContent = {
            english: {
                step1: {
                    title: "Choose Language",
                    description: "Please select your preferred language for a personalized experience."
                },
                step2: {
                    title: "Tell Us About Yourself",
                    description: "Tell us a bit about yourself to personalize your experience."
                },
                step3: {
                    title: "How Are You Feeling Today?",
                    description: "We'll customize your feed based on your mood."
                },
                step4: {
                    title: "Got a Reference Code?",
                    description: "Enter it below to connect with your friend."
                },
                step5: {
                    title: "Profile Complete!",
                    description: "Your profile has been set up successfully. You're all set to explore our social platform!"
                }
            },
            bangla: {
                step1: {
                    title: "ভাষা নির্বাচন করুন",
                    description: "একটি ব্যক্তিগতকৃত অভিজ্ঞতার জন্য আপনার পছন্দসই ভাষা নির্বাচন করুন।"
                },
                step2: {
                    title: "আপনার সম্পর্কে আমাদের বলুন",
                    description: "আপনার অভিজ্ঞতা ব্যক্তিগতকৃত করতে আপনার সম্পর্কে একটু বলুন।"
                },
                step3: {
                    title: "আজ আপনি কেমন বোধ করছেন?",
                    description: "আমরা আপনার মেজাজের উপর ভিত্তি করে আপনার ফিড কাস্টমাইজ করব।"
                },
                step4: {
                    title: "রেফারেন্স কোড আছে?",
                    description: "আপনার বন্ধুর সাথে সংযোগ করতে নীচে এটি লিখুন।"
                },
                step5: {
                    title: "প্রোফাইল সম্পূর্ণ!",
                    description: "আপনার প্রোফাইল সফলভাবে সেট আপ করা হয়েছে। আপনি আমাদের সোশ্যাল প্ল্যাটফর্ম অন্বেষণ করতে প্রস্তুত!"
                }
            },
            hindi: {
                step1: {
                    title: "भाषा चुनें",
                    description: "व्यक्तिगत अनुभव के लिए कृपया अपनी पसंदीदा भाषा चुनें।"
                },
                step2: {
                    title: "हमें अपने बारे में बताएं",
                    description: "अपने अनुभव को व्यक्तिगत बनाने के लिए हमें अपने बारे में थोड़ा बताएं।"
                },
                step3: {
                    title: "आज आप कैसा महसूस कर रहे हैं?",
                    description: "हम आपके मूड के आधार पर आपकी फीड को अनुकूलित करेंगे।"
                },
                step4: {
                    title: "रेफरेंस कोड है?",
                    description: "अपने दोस्त से जुड़ने के लिए इसे नीचे दर्ज करें।"
                },
                step5: {
                    title: "प्रोफाइल पूरा हुआ!",
                    description: "आपकी प्रोफाइल सफलतापूर्वक सेट की गई है। आप हमारे सोशल प्लेटफॉर्म का अन्वेषण करने के लिए तैयार हैं!"
                }
            }
        };
        function speak(text, lang = 'en-US') {
            if ('speechSynthesis' in window) {
                window.speechSynthesis.cancel();

                const utterance = new SpeechSynthesisUtterance(text);

                switch (formState.language) {
                    case 'bangla':
                        utterance.lang = 'bn-BD';
                        break;
                    case 'hindi':
                        utterance.lang = 'hi-IN';
                        break;
                    default:
                        utterance.lang = 'en-US';
                }

                window.speechSynthesis.speak(utterance);
            }else{
                alert('Your browser does not support speech.');
            }
        }

        function updateProgress() {
            const progressPercentage = (formState.currentStep / formState.totalSteps) * 100;
            $('#progress-bar').css('width', `${progressPercentage}%`);
        }

        function updateStepTitle() {
            const lang = formState.language || 'english';
            const stepKey = `step${formState.currentStep}`;
            const title = textContent[lang][stepKey].title;
            $('#step-title').text(title);
        }

        function showLoading() {
            formState.isLoading = true;
            $('#form-container button[type="submit"]').prop('disabled', true).html(`
                <div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin mr-2"></div>
                Loading...
            `);
        }

        function hideLoading() {
            formState.isLoading = false;
            const buttonText = formState.currentStep === formState.totalSteps ? 'Go to Home' : 'Continue';
            $('#form-container button[type="submit"]').prop('disabled', false).html(buttonText);
        }

        function showError(message) {
            formState.error = message;
            $('#error-message').text(message).removeClass('hidden');
        }

        function hideError() {
            formState.error = '';
            $('#error-message').addClass('hidden');
        }

        // Show success message
        function showSuccess(message) {
            formState.success = message;
            $('#success-message').text(message).removeClass('hidden');
        }

        function renderStep1() {
            const lang = formState.language || 'english';
            const content = textContent[lang].step1;

            $('#form-container').html(`
                <div class="space-y-6 fade-in">
                    <p class="text-gray-600">${content.description}</p>

                    <div class="grid grid-cols-2 gap-4">
                        <button id="lang-english" class="lang-btn flex flex-col items-center p-4 rounded-lg border-2 ${formState.language === 'english' ? 'border-teal-600 bg-teal-50' : 'border-gray-200 hover:border-teal-300'}">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-2">
                                <span class="text-lg font-bold">EN</span>
                            </div>
                            <span class="font-medium">English</span>
                            ${formState.language === 'english' ? '<div class="absolute top-2 right-2 bg-teal-600 text-white rounded-full p-1"><i data-lucide="check" class="w-4 h-4"></i></div>' : ''}
                        </button>

                        <button id="lang-bangla" class="lang-btn flex flex-col items-center p-4 rounded-lg border-2 ${formState.language === 'bangla' ? 'border-teal-600 bg-teal-50' : 'border-gray-200 hover:border-teal-300'}">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-2">
                                <span class="text-lg font-bold">BN</span>
                            </div>
                            <span class="font-medium">বাংলা</span>
                            ${formState.language === 'bangla' ? '<div class="absolute top-2 right-2 bg-teal-600 text-white rounded-full p-1"><i data-lucide="check" class="w-4 h-4"></i></div>' : ''}
                        </button>

                        <button id="lang-hindi" class="lang-btn flex flex-col items-center p-4 rounded-lg border-2 ${formState.language === 'hindi' ? 'border-teal-600 bg-teal-50' : 'border-gray-200 hover:border-teal-300'}">
                            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mb-2">
                                <span class="text-lg font-bold">HI</span>
                            </div>
                            <span class="font-medium">हिन्दी</span>
                            ${formState.language === 'hindi' ? '<div class="absolute top-2 right-2 bg-teal-600 text-white rounded-full p-1"><i data-lucide="check" class="w-4 h-4"></i></div>' : ''}
                        </button>
                    </div>

                    <div id="error-message" class="text-red-500 text-sm p-2 bg-red-50 rounded-md ${formState.error ? '' : 'hidden'}">${formState.error}</div>

                    <button type="button" class="w-full py-3 px-4 rounded-lg flex items-center justify-center font-medium text-white ${!formState.language ? 'bg-teal-400 cursor-not-allowed' : 'bg-teal-600 hover:bg-teal-700'}" ${!formState.language ? 'disabled' : ''}>
                        Continue
                        <i data-lucide="chevron-right" class="w-4 h-4 ml-1"></i>
                    </button>
                </div>
            `);

            // Initialize Lucide icons for dynamically added content
            lucide.createIcons();

            // Language selection event handlers
            $('.lang-btn').on('click', function() {
                const langId = $(this).attr('id');
                if (langId === 'lang-english') formState.language = 'english';
                else if (langId === 'lang-bangla') formState.language = 'bangla';
                else if (langId === 'lang-hindi') formState.language = 'hindi';

                renderStep1(); // Re-render to update UI
            });

            // Submit button event handler
            $('button[type="button"]').on('click', function() {
                if (!formState.language) {
                    showError('Please select a language');
                    return;
                }

                submitLanguage();
            });

            // Speak the content
            const textToSpeak = content.title + '. ' + content.description;
            speak(textToSpeak);
        }

        // Render step 2: Personal details
        function renderStep2() {
            const lang = formState.language || 'english';
            const content = textContent[lang].step2;

            $('#form-container').html(`
                <div class="space-y-6 fade-in">
                    <p class="text-gray-600">${content.description}</p>

                    <div class="space-y-4">
                        <div>
                            <label for="age" class="block text-sm font-medium text-gray-700 mb-1">
                                ${lang === 'english' ? 'Age' : (lang === 'bangla' ? 'বয়স' : 'उम्र')}
                            </label>
                            <input type="number" id="age" value="${formState.age}" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors" placeholder="${lang === 'english' ? 'Enter your age' : (lang === 'bangla' ? 'আপনার বয়স লিখুন' : 'अपनी उम्र दर्ज करें')}" min="13" max="120">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                ${lang === 'english' ? 'Gender' : (lang === 'bangla' ? 'লিঙ্গ' : 'लिंग')}
                            </label>
                            <div class="grid grid-cols-3 gap-3">
                                <button type="button" id="gender-male" class="gender-btn flex items-center justify-center p-3 border-2 rounded-lg ${formState.gender === 'male' ? 'border-teal-600 bg-teal-50 text-teal-700' : 'border-gray-200 text-gray-600 hover:border-teal-300'}">
                                    <i data-lucide="user" class="w-4 h-4 mr-2"></i>
                                    ${lang === 'english' ? 'Male' : (lang === 'bangla' ? 'পুরুষ' : 'पुरुष')}
                                </button>
                                <button type="button" id="gender-female" class="gender-btn flex items-center justify-center p-3 border-2 rounded-lg ${formState.gender === 'female' ? 'border-teal-600 bg-teal-50 text-teal-700' : 'border-gray-200 text-gray-600 hover:border-teal-300'}">
                                    <i data-lucide="user" class="w-4 h-4 mr-2"></i>
                                    ${lang === 'english' ? 'Female' : (lang === 'bangla' ? 'মহিলা' : 'महिला')}
                                </button>
                                <button type="button" id="gender-other" class="gender-btn flex items-center justify-center p-3 border-2 rounded-lg ${formState.gender === 'other' ? 'border-teal-600 bg-teal-50 text-teal-700' : 'border-gray-200 text-gray-600 hover:border-teal-300'}">
                                    <i data-lucide="user" class="w-4 h-4 mr-2"></i>
                                    ${lang === 'english' ? 'Other' : (lang === 'bangla' ? 'অন্যান্য' : 'अन्य')}
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="profession" class="block text-sm font-medium text-gray-700 mb-1">
                                ${lang === 'english' ? 'Profession' : (lang === 'bangla' ? 'পেশা' : 'पेशा')}
                            </label>
                            <select id="profession" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                                <option value="">${lang === 'english' ? 'Select your profession' : (lang === 'bangla' ? 'আপনার পেশা নির্বাচন করুন' : 'अपना पेशा चुनें')}</option>
                                <option value="student" ${formState.profession === 'student' ? 'selected' : ''}>${lang === 'english' ? 'Student' : (lang === 'bangla' ? 'ছাত্র/ছাত্রী' : 'छात्र')}</option>
                                <option value="professional" ${formState.profession === 'professional' ? 'selected' : ''}>${lang === 'english' ? 'Professional' : (lang === 'bangla' ? 'পেশাদার' : 'पेशेवर')}</option>
                                <option value="business" ${formState.profession === 'business' ? 'selected' : ''}>${lang === 'english' ? 'Business' : (lang === 'bangla' ? 'ব্যবসায়ী' : 'व्यापारी')}</option>
                                <option value="homemaker" ${formState.profession === 'homemaker' ? 'selected' : ''}>${lang === 'english' ? 'Homemaker' : (lang === 'bangla' ? 'গৃহিণী' : 'गृहिणी')}</option>
                                <option value="retired" ${formState.profession === 'retired' ? 'selected' : ''}>${lang === 'english' ? 'Retired' : (lang === 'bangla' ? 'অবসরপ্রাপ্ত' : 'सेवानिवृत्त')}</option>
                                <option value="other" ${formState.profession === 'other' ? 'selected' : ''}>${lang === 'english' ? 'Other' : (lang === 'bangla' ? 'অন্যান্য' : 'अन्य')}</option>
                            </select>
                        </div>
                    </div>

                    <div id="error-message" class="text-red-500 text-sm p-2 bg-red-50 rounded-md ${formState.error ? '' : 'hidden'}">${formState.error}</div>

                    <div class="flex space-x-3">
                        <button type="button" id="back-button" class="flex-1 py-3 px-4 rounded-lg border border-gray-300 font-medium text-gray-700 hover:bg-gray-50">
                            ${lang === 'english' ? 'Back' : (lang === 'bangla' ? 'পিছনে' : 'पीछे')}
                        </button>
                        <button type="submit" class="flex-1 py-3 px-4 rounded-lg flex items-center justify-center font-medium text-white ${!formState.age || !formState.gender || !formState.profession ? 'bg-teal-400 cursor-not-allowed' : 'bg-teal-600 hover:bg-teal-700'}" ${!formState.age || !formState.gender || !formState.profession ? 'disabled' : ''}>
                            ${lang === 'english' ? 'Continue' : (lang === 'bangla' ? 'চালিয়ে যান' : 'जारी रखें')}
                        </button>
                    </div>
                </div>
            `);

            // Initialize Lucide icons for dynamically added content
            lucide.createIcons();

            // Age input event handler
            $('#age').on('input', function() {
                formState.age = $(this).val();
            });

            // Gender selection event handlers
            $('.gender-btn').on('click', function() {
                const genderId = $(this).attr('id');
                if (genderId === 'gender-male') formState.gender = 'male';
                else if (genderId === 'gender-female') formState.gender = 'female';
                else if (genderId === 'gender-other') formState.gender = 'other';

                // Update UI
                $('.gender-btn').removeClass('border-teal-600 bg-teal-50 text-teal-700').addClass('border-gray-200 text-gray-600 hover:border-teal-300');
                $(this).removeClass('border-gray-200 text-gray-600 hover:border-teal-300').addClass('border-teal-600 bg-teal-50 text-teal-700');

                // Enable/disable submit button
                $('button[type="button"]').prop('disabled', !formState.age || !formState.gender || !formState.profession);
                if (!formState.age || !formState.gender || !formState.profession) {
                    $('button[type="button"]').addClass('bg-teal-400 cursor-not-allowed').removeClass('bg-teal-600 hover:bg-teal-700');
                } else {
                    $('button[type="button"]').removeClass('bg-teal-400 cursor-not-allowed').addClass('bg-teal-600 hover:bg-teal-700');
                }
            });

            // Profession selection event handler
            $('#profession').on('change', function() {
                formState.profession = $(this).val();

                // Enable/disable submit button
                $('button[type="button"]').prop('disabled', !formState.age || !formState.gender || !formState.profession);
                if (!formState.age || !formState.gender || !formState.profession) {
                    $('button[type="button"]').addClass('bg-teal-400 cursor-not-allowed').removeClass('bg-teal-600 hover:bg-teal-700');
                } else {
                    $('button[type="button"]').removeClass('bg-teal-400 cursor-not-allowed').addClass('bg-teal-600 hover:bg-teal-700');
                }
            });

            // Back button event handler
            $('#back-button').on('click', function() {
                formState.currentStep = 1;
                updateProgress();
                updateStepTitle();
                renderStep1();
            });

            // Submit button event handler
            $('button[type="button"]').on('click', function() {
                if (!formState.age || !formState.gender || !formState.profession) {
                    showError(lang === 'english' ? 'Please fill in all fields' : (lang === 'bangla' ? 'সমস্ত ক্ষেত্র পূরণ করুন' : 'कृपया सभी फ़ील्ड भरें'));
                    return;
                }

                submitPersonalDetails();
            });

            // Speak the content
            const textToSpeak = content.title + '. ' + content.description;
            speak(textToSpeak);
        }

        // Render step 3: Mood selection
        function renderStep3() {
            const lang = formState.language || 'english';
            const content = textContent[lang].step3;

            $('#form-container').html(`
                <div class="space-y-6 fade-in">
                    <p class="text-gray-600">${content.description}</p>

                    <div class="grid grid-cols-2 gap-4">
                        <button id="mood-happy" class="mood-btn flex flex-col items-center p-6 rounded-lg border-2 border-gray-200 hover:border-teal-300 hover:bg-teal-50 transition-all">
                            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-3">
                                <span class="text-3xl">😊</span>
                            </div>
                            <span class="font-medium">${lang === 'english' ? 'Happy' : (lang === 'bangla' ? 'খুশি' : 'खुश')}</span>
                        </button>

                        <button id="mood-relaxed" class="mood-btn flex flex-col items-center p-6 rounded-lg border-2 border-gray-200 hover:border-teal-300 hover:bg-teal-50 transition-all">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-3">
                                <span class="text-3xl">😌</span>
                            </div>
                            <span class="font-medium">${lang === 'english' ? 'Relaxed' : (lang === 'bangla' ? 'শান্ত' : 'शांत')}</span>
                        </button>

                        <button id="mood-energetic" class="mood-btn flex flex-col items-center p-6 rounded-lg border-2 border-gray-200 hover:border-teal-300 hover:bg-teal-50 transition-all">
                            <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-3">
                                <span class="text-3xl">⚡</span>
                            </div>
                            <span class="font-medium">${lang === 'english' ? 'Energetic' : (lang === 'bangla' ? 'উদ্যমী' : 'ऊर्जावान')}</span>
                        </button>

                        <button id="mood-curious" class="mood-btn flex flex-col items-center p-6 rounded-lg border-2 border-gray-200 hover:border-teal-300 hover:bg-teal-50 transition-all">
                            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-3">
                                <span class="text-3xl">🤔</span>
                            </div>
                            <span class="font-medium">${lang === 'english' ? 'Curious' : (lang === 'bangla' ? 'কৌতূহলী' : 'जिज्ञासु')}</span>
                        </button>
                    </div>

                    <div id="error-message" class="text-red-500 text-sm p-2 bg-red-50 rounded-md ${formState.error ? '' : 'hidden'}">${formState.error}</div>

                    <button type="button" id="back-button" class="w-full py-3 px-4 rounded-lg border border-gray-300 font-medium text-gray-700 hover:bg-gray-50">
                        ${lang === 'english' ? 'Back' : (lang === 'bangla' ? 'পিছনে' : 'पीछे')}
                    </button>

                    <div id="loading-indicator" class="flex justify-center hidden">
                        <div class="w-8 h-8 border-4 border-teal-500 border-t-transparent rounded-full animate-spin"></div>
                    </div>
                </div>
            `);

            // Initialize Lucide icons for dynamically added content
            lucide.createIcons();

            // Mood selection event handlers
            $('.mood-btn').on('click', function() {
                const moodId = $(this).attr('id');
                let selectedMood = '';

                if (moodId === 'mood-happy') selectedMood = 'happy';
                else if (moodId === 'mood-relaxed') selectedMood = 'relaxed';
                else if (moodId === 'mood-energetic') selectedMood = 'energetic';
                else if (moodId === 'mood-curious') selectedMood = 'curious';

                submitMood(selectedMood);
            });

            // Back button event handler
            $('#back-button').on('click', function() {
                formState.currentStep = 2;
                updateProgress();
                updateStepTitle();
                renderStep2();
            });

            // Speak the content
            const textToSpeak = content.title + '. ' + content.description;
            speak(textToSpeak);
        }

        // Render step 4: Reference code
        function renderStep4() {
            const lang = formState.language || 'english';
            const content = textContent[lang].step4;

            $('#form-container').html(`
                <div class="space-y-6 fade-in">
                    <p class="text-gray-600">${content.description}</p>

                    <div class="space-y-4">
                        <div>
                            <label for="reference-code" class="block text-sm font-medium text-gray-700 mb-1">
                                ${lang === 'english' ? 'Reference Code (Optional)' : (lang === 'bangla' ? 'রেফারেন্স কোড (ঐচ্ছিক)' : 'रेफरेंस कोड (वैकल्पिक)')}
                            </label>
                            <div class="flex">
                                <input type="text" id="reference-code" value="${formState.referenceCode}" class="flex-1 p-3 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors" placeholder="${lang === 'english' ? 'Enter reference code' : (lang === 'bangla' ? 'রেফারেন্স কোড লিখুন' : 'रेफरेंस कोड दर्ज करें')}">
                                <button id="verify-button" class="px-4 rounded-r-lg font-medium text-white ${!formState.referenceCode ? 'bg-teal-400 cursor-not-allowed' : 'bg-teal-600 hover:bg-teal-700'}" ${!formState.referenceCode ? 'disabled' : ''}>
                                    ${lang === 'english' ? 'Verify' : (lang === 'bangla' ? 'যাচাই' : 'सत्यापित करें')}
                                </button>
                            </div>
                        </div>

                        ${formState.referrerName ? `
                        <div class="p-3 bg-green-50 text-green-700 rounded-lg flex items-center">
                            <i data-lucide="check" class="w-4 h-4 mr-2"></i>
                            ${lang === 'english' ? 'You were referred by ' : (lang === 'bangla' ? 'আপনাকে রেফার করেছেন ' : 'आपको रेफर किया गया था ')}${formState.referrerName}
                        </div>
                        ` : ''}
                    </div>

                    <div id="error-message" class="text-red-500 text-sm p-2 bg-red-50 rounded-md ${formState.error ? '' : 'hidden'}">${formState.error}</div>
                    <div id="success-message" class="text-green-500 text-sm p-2 bg-green-50 rounded-md ${formState.success ? '' : 'hidden'}">${formState.success}</div>

                    <div class="flex space-x-3">
                        <button type="button" id="back-button" class="flex-1 py-3 px-4 rounded-lg border border-gray-300 font-medium text-gray-700 hover:bg-gray-50">
                            ${lang === 'english' ? 'Back' : (lang === 'bangla' ? 'পিছনে' : 'पीछे')}
                        </button>
                        <button type="button" id="skip-button" class="flex-1 py-3 px-4 rounded-lg font-medium bg-gray-100 hover:bg-gray-200 text-gray-700">
                            ${lang === 'english' ? 'Skip' : (lang === 'bangla' ? 'এড়িয়ে যান' : 'छोड़ें')}
                        </button>
                    </div>
                </div>
            `);

            // Initialize Lucide icons for dynamically added content
            lucide.createIcons();

            // Reference code input event handler
            $('#reference-code').on('input', function() {
                formState.referenceCode = $(this).val();

                // Enable/disable verify button
                $('#verify-button').prop('disabled', !formState.referenceCode);
                if (!formState.referenceCode) {
                    $('#verify-button').addClass('bg-teal-400 cursor-not-allowed').removeClass('bg-teal-600 hover:bg-teal-700');
                } else {
                    $('#verify-button').removeClass('bg-teal-400 cursor-not-allowed').addClass('bg-teal-600 hover:bg-teal-700');
                }
            });

            // Verify button event handler
            $('#verify-button').on('click', function() {
                if (!formState.referenceCode) return;
                validateReferenceCode();
            });

            // Back button event handler
            $('#back-button').on('click', function() {
                formState.currentStep = 3;
                updateProgress();
                updateStepTitle();
                renderStep3();
            });

            // Skip button event handler
            $('#skip-button').on('click', function() {
                skipReference();
            });

            // Speak the content
            const textToSpeak = content.title + '. ' + content.description;
            speak(textToSpeak);
        }

        // Render step 5: Completion
        function renderStep5() {
            const lang = formState.language || 'english';
            const content = textContent[lang].step5;

            $('#form-container').html(`
                <div class="space-y-6 text-center fade-in">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                        <i data-lucide="check" class="w-10 h-10 text-green-600"></i>
                    </div>

                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">${content.title}</h3>
                        <p class="text-gray-600">${content.description}</p>
                    </div>

                    <div id="error-message" class="text-red-500 text-sm p-2 bg-red-50 rounded-md ${formState.error ? '' : 'hidden'}">${formState.error}</div>

                    <button type="button" id="complete-button" class="w-full py-3 px-4 rounded-lg flex items-center justify-center font-medium text-white bg-teal-600 hover:bg-teal-700">
                        ${lang === 'english' ? 'Go to Home' : (lang === 'bangla' ? 'হোমে যান' : 'होम पेज पर जाएं')}
                    </button>
                </div>
            `);

            // Initialize Lucide icons for dynamically added content
            lucide.createIcons();

            // Complete button event handler
            $('#complete-button').on('click', function() {
                completeProfile();
            });

            // Speak the content
            const textToSpeak = content.title + '. ' + content.description;
            speak(textToSpeak);
        }

        // Submit language selection
        function submitLanguage() {
            if (!formState.language) {
                showError('Please select a language');
                return;
            }

            showLoading();
            hideError();

            // Make API call with axios to the language change endpoint
            axios.get(`{{ route('user.language.change', '') }}/${formState.language}`)
                .then(function(response) {
                    if (response.data.status === 'success') {
                        hideLoading();
                        formState.currentStep = 2;
                        updateProgress();
                        updateStepTitle();
                        renderStep2();
                    } else {
                        hideLoading();
                        showError(response.data.message || 'Something went wrong');
                    }
                })
                .catch(function(error) {
                    hideLoading();
                    showError(error.response?.data?.message || 'Something went wrong');
                });
        }

        // Submit personal details
        function submitPersonalDetails() {
            if (!formState.age || !formState.gender || !formState.profession) {
                const lang = formState.language || 'english';
                showError(lang === 'english' ? 'Please fill in all fields' : (lang === 'bangla' ? 'সমস্ত ক্ষেত্র পূরণ করুন' : 'कृपया सभी फ़ील्ड भरें'));
                return;
            }

            showLoading();
            hideError();

            // Simulate API call with axios
            // In a real implementation, this would be an axios call to your Laravel backend
            // Example: axios.post('/api/set-personal-details', { age: formState.age, gender: formState.gender, profession: formState.profession })
            setTimeout(function() {
                hideLoading();
                formState.currentStep = 3;
                updateProgress();
                updateStepTitle();
                renderStep3();
            }, 800);
        }

        // Submit mood
        function submitMood(selectedMood) {
            formState.mood = selectedMood;
            $('#loading-indicator').removeClass('hidden');

            // Simulate API call with axios
            // In a real implementation, this would be an axios call to your Laravel backend
            // Example: axios.post('/api/set-mood', { mood: selectedMood })
            setTimeout(function() {
                $('#loading-indicator').addClass('hidden');
                formState.currentStep = 4;
                updateProgress();
                updateStepTitle();
                renderStep4();
            }, 800);
        }

        // Validate reference code
        function validateReferenceCode() {
            if (!formState.referenceCode) {
                skipReference();
                return;
            }

            showLoading();
            hideError();
            hideSuccess();

            // Simulate API call with axios
            // In a real implementation, this would be an axios call to your Laravel backend
            // Example: axios.post('/api/validate-reference', { code: formState.referenceCode })
            setTimeout(function() {
                // Mock response - in real implementation, this would come from your server
                const mockResponse = {
                    valid: true,
                    referrerName: "John Doe",
                };

                if (mockResponse.valid) {
                    formState.referrerName = mockResponse.referrerName;
                    const lang = formState.language || 'english';
                    showSuccess(lang === 'english' ? `Reference code validated! You were referred by ${mockResponse.referrerName}` :
                               (lang === 'bangla' ? `রেফারেন্স কোড যাচাই করা হয়েছে! আপনাকে রেফার করেছেন ${mockResponse.referrerName}` :
                               `रेफरेंस कोड मान्य है! आपको ${mockResponse.referrerName} द्वारा रेफर किया गया था`));

                    // Move to next step after a brief delay to show the success message
                    setTimeout(function() {
                        hideLoading();
                        formState.currentStep = 5;
                        updateProgress();
                        updateStepTitle();
                        renderStep5();
                    }, 1500);
                } else {
                    hideLoading();
                    const lang = formState.language || 'english';
                    showError(lang === 'english' ? 'Invalid reference code. Please try again.' :
                             (lang === 'bangla' ? 'অবৈধ রেফারেন্স কোড। আবার চেষ্টা করুন।' :
                             'अमान्य रेफरेंस कोड। कृपया पुनः प्रयास करें।'));
                }
            }, 800);
        }

        // Skip reference code
        function skipReference() {
            formState.currentStep = 5;
            updateProgress();
            updateStepTitle();
            renderStep5();
        }

        // Complete profile and redirect
        function completeProfile() {
            showLoading();

            // Simulate API call with axios
            // In a real implementation, this would be an axios call to your Laravel backend
            // Example: axios.post('/api/complete-profile')
            setTimeout(function() {
                // Redirect to home page
                window.location.href = "/home";
            }, 800);
        }

        // Speak button event handler
        $('#speak-button').on('click', function() {
            const lang = formState.language || 'english';
            const stepKey = `step${formState.currentStep}`;
            const content = textContent[lang][stepKey];
            const textToSpeak = content.title + '. ' + content.description;
            speak(textToSpeak);
        });

        // Initialize the form
        function initForm() {
            updateProgress();
            renderStep1();
        }

    </script>
@endpush
