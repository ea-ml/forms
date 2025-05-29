<?php
require_once 'generate_token.php';
?>
<form id="surveyForm" action="script/submit_survey.php" method="POST" class="bg-secondary flex flex-col justify-between p-6 px-8 sm:px-12 border rounded-xl shadow-md gap-y-4">
    <!-- Hidden CSRF token field -->
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
    
    <div class="flex flex-row justify-center items-center">
        <p class="text-2xl font-bold text-accent">Form</p>
    </div>
    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center sm:justify-between">
        <div class="flex flex-col items-start justify-start w-full sm:w-auto">
            <label for="fname" class="text-md text-accent select-none">First Name</label>
            <input name="fname" type="text"
                class=" border-black rounded-xl bg-gray-100 p-2 px-4 text-md focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-black/30 w-full"
                placeholder="John" required
                minlength="1"
                maxlength="20"
                pattern="[A-Za-z\s-]+"
                title="Only letters, spaces, and hyphens are allowed"
                oninput="this.value = this.value.replace(/[^A-Za-z\s-]/g, '')"
            >
            <span id="fnameError" class="text-sm text-red-600 hidden"></span>
        </div>
        <div class="flex flex-col items-start justify-start w-full sm:w-auto">
            <label for="fname" class="text-md text-accent select-none">Last Name</label>
            <input name="lname" type="text"
                class=" border-black rounded-xl bg-gray-100 p-2 px-4 text-md focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-black/30 w-full"
                placeholder="Doe" required
                minlength="1"
                maxlength="20"
                pattern="[A-Za-z\s-]+"
                title="Only letters, spaces, and hyphens are allowed"
                oninput="this.value = this.value.replace(/[^A-Za-z\s-]/g, '')"
            >
            <span id="lnameError" class="text-sm text-red-600 hidden"></span>
        </div>
    </div>

    <div class="flex flex-col items-start justify-start w-full sm:w-auto">
        <label for="fname" class="text-md text-accent select-none">Email Address</label>
        <input name="email" type="email"
            class=" border-black rounded-xl bg-gray-100 p-2 px-4 text-md focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-black/30 w-full"
            placeholder="john.doe@example.com" required
            pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
            title="Please enter a valid email address"
        >
        <span id="emailError" class="text-sm text-red-600 hidden"></span>
    </div>

    <div class="flex flex-col items-start justify-start w-full sm:w-auto gap-y-2">

        <span class="text-md text-accent select-none">Gender</span>
        <div class="flex flex-col gap-y-2 mx-4">
            <div class="flex flex-row gap-x-1">
                <input id="male" type="radio" value="male" name="gender"
                    class="w-4 h-4 text-primary bg-gray-100 border-gray-300 focus:ring-2"
                    required>
                <label for="male" class="ms-2 text-sm font-medium text-gray-900 ">Male</label>
            </div>
            <div class="flex flex-row gap-x-1">
                <input id="female" type="radio" value="female" name="gender"
                    class="w-4 h-4 text-primary bg-gray-100 border-gray-300"
                    required>
                <label for="female" class="ms-2 text-sm font-medium text-gray-900 ">Female</label>
            </div>
        </div>
        <span id="genderError" class="text-sm text-red-600 hidden"></span>
    </div>

    <div class="flex flex-col items-start justify-start w-full sm:w-auto gap-y-2">
        <span class="text-md text-accent select-none">Hobbies (Select at least one)</span>
        <div class="flex flex-col gap-y-2 mx-4">
            <div class="flex flex-row gap-x-1">
                <input id="reading" type="checkbox" value="reading" name="hobbies[]"
                    class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-2"
                    required>
                <label for="reading" class="ms-2 text-sm font-medium text-gray-900">Reading</label>
            </div>
            <div class="flex flex-row gap-x-1">
                <input id="gaming" type="checkbox" value="gaming" name="hobbies[]"
                    class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-2"
                    onclick="document.getElementById('reading').required = !this.checked">
                <label for="gaming" class="ms-2 text-sm font-medium text-gray-900">Gaming</label>
            </div>
            <div class="flex flex-row gap-x-1">
                <input id="sports" type="checkbox" value="sports" name="hobbies[]"
                    class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-2"
                    onclick="document.getElementById('reading').required = !this.checked">
                <label for="sports" class="ms-2 text-sm font-medium text-gray-900">Sports</label>
            </div>
            <div class="flex flex-row gap-x-1">
                <input id="cooking" type="checkbox" value="cooking" name="hobbies[]"
                    class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-2"
                    onclick="document.getElementById('reading').required = !this.checked">
                <label for="cooking" class="ms-2 text-sm font-medium text-gray-900">Cooking</label>
            </div>
            <div class="flex flex-row gap-x-1">
                <input id="traveling" type="checkbox" value="traveling" name="hobbies[]"
                    class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-2"
                    onclick="document.getElementById('reading').required = !this.checked">
                <label for="traveling" class="ms-2 text-sm font-medium text-gray-900">Traveling</label>
            </div>
        </div>
        <span id="hobbiesError" class="text-sm text-red-600 hidden"></span>
    </div>

    <div class="flex flex-col items-start justify-start w-full sm:w-auto">
        <label for="nationality" class="text-md text-accent select-none">Nationality</label>
        <select name="nationality" id="nationality" required
            class="w-full border-black rounded-xl bg-gray-100 p-2 px-4 text-md focus:ring-2  focus:outline-none">
            <option value="" disabled selected class="text-gray-400">Select your nationality</option>
            <option value="japanese">Japanese</option>
            <option value="filipino">Filipino</option>
            <option value="american">American</option>
            <option value="british">British</option>
            <option value="australian">Australian</option>
            <option value="others">Others</option>
        </select>
        <span id="nationalityError" class="text-sm text-red-600 hidden"></span>
    </div>

    <div class="flex flex-col items-start justify-start w-full gap-y-2">
        <label class="text-md text-accent select-none">Rate your experience (1-5 stars)</label>
        <div class="flex flex-row gap-x-4">
            <div class="flex items-center">
                <input type="radio" name="rating" value="1" id="star1" required class="hidden peer" checked>
                <label for="star1" class="cursor-pointer text-2xl peer-checked:text-highlight">★</label>
            </div>
            <div class="flex items-center">
                <input type="radio" name="rating" value="2" id="star2" class="hidden peer">
                <label for="star2" class="cursor-pointer text-2xl peer-checked:text-highlight">★</label>
            </div>
            <div class="flex items-center">
                <input type="radio" name="rating" value="3" id="star3" class="hidden peer">
                <label for="star3" class="cursor-pointer text-2xl peer-checked:text-highlight">★</label>
            </div>
            <div class="flex items-center">
                <input type="radio" name="rating" value="4" id="star4" class="hidden peer">
                <label for="star4" class="cursor-pointer text-2xl peer-checked:text-highlight">★</label>
            </div>
            <div class="flex items-center">
                <input type="radio" name="rating" value="5" id="star5" class="hidden peer">
                <label for="star5" class="cursor-pointer text-2xl peer-checked:text-highlight">★</label>
            </div>
        </div>
        <span id="ratingError" class="text-sm text-red-600 hidden"></span>
    </div>

    <div class="flex flex-col items-start justify-start w-full gap-y-2">
        <label for="comments" class="text-md text-accent select-none">Suggestions</label>
        <textarea 
            name="suggestions" 
            id="suggestions" 
            rows="4" 
            placeholder="Enter your suggestions here..."
            class="w-full border-black rounded-xl bg-gray-100 p-2 px-4 text-md focus:ring-2  focus:outline-none placeholder-black/30 resize-none"
            minlength="0"
            maxlength="255"
        ></textarea>
        <span id="suggestionsError" class="text-sm text-red-600 hidden"></span>
    </div>

    <div id="formErrors" class="hidden text-red-700 px-4 py-3 rounded relative" role="alert">
        <span id="errorMessage" class="block sm:inline"></span>
    </div>

    <div class="flex flex-row items-center justify-end pt-5">
        <button type="submit" id="submitBtn" class="bg-accent text-white px-4 py-2 rounded-xl sm:flex-none flex-auto disabled:opacity-50 disabled:cursor-not-allowed">
            <span id="submitText">Submit</span>
            <span id="loadingText" class="hidden">Submitting...</span>
        </button>
    </div>

    <script>
        const stars = document.querySelectorAll('input[name="rating"]');
        stars.forEach(star => {
            star.addEventListener('change', (e) => {
                const selectedValue = parseInt(e.target.value);
                stars.forEach(s => {
                    const value = parseInt(s.value);
                    const label = document.querySelector(`label[for="star${value}"]`);
                    if (value <= selectedValue) {
                        label.classList.add('text-highlight');
                    } else {
                        label.classList.remove('text-highlight');
                    }
                });
            });
        });

        // Escape HTML function
        function escapeHtml(unsafe) {
            return unsafe
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        // Function to refresh CSRF token
        async function refreshCsrfToken() {
            try {
                const response = await fetch('script/generate_token.php', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();
                document.querySelector('input[name="csrf_token"]').value = data.csrf_token;
            } catch (error) {
                console.error('Failed to refresh CSRF token:', error);
            }
        }

        // Sanitize form data before submission
        function sanitizeFormData(formData) {
            for (let [key, value] of formData.entries()) {
                if (typeof value === 'string') {
                    formData.set(key, escapeHtml(value.trim()));
                }
            }
            return formData;
        }

        const form = document.querySelector('#surveyForm');
        const submitBtn = document.getElementById('submitBtn');
        const formErrors = document.getElementById('formErrors');
        const errorMessage = document.getElementById('errorMessage');
        const submitText = document.getElementById('submitText');
        const loadingText = document.getElementById('loadingText');
        
        const checkFormValidity = () => {
            const isValid = form.checkValidity();
            submitBtn.disabled = !isValid;
        };

        form.querySelectorAll('input, select').forEach(element => {
            element.addEventListener('input', checkFormValidity);
            element.addEventListener('change', checkFormValidity);
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            formErrors.classList.add('hidden');
            const errorFields = ['fname', 'lname', 'email', 'gender', 'hobbies', 'nationality', 'rating', 'suggestions'];
            errorFields.forEach(field => {
                document.getElementById(`${field}Error`).classList.add('hidden');
            });
            
            submitBtn.disabled = true;
            submitText.classList.add('hidden');
            loadingText.classList.remove('hidden');

            try {
                const formData = new FormData(form);
                const sanitizedFormData = sanitizeFormData(formData);
                
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: sanitizedFormData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const result = await response.json();
                
                if (result.csrf_token) {
                    document.querySelector('input[name="csrf_token"]').value = result.csrf_token;
                }
                
                if (result.success) {
                    form.reset();
                    stars.forEach(s => {
                        const label = document.querySelector(`label[for="${s.id}"]`);
                        label.classList.remove('text-highlight');
                    });
                    document.querySelector('label[for="star1"]').classList.add('text-highlight');
                } else {
                    if (result.errors) {
                        // Handle field-specific errors
                        Object.entries(result.errors).forEach(([field, message]) => {
                            const errorElement = document.getElementById(`${field}Error`);
                            if (errorElement) {
                                // Safely display error message
                                errorElement.textContent = escapeHtml(message);
                                errorElement.classList.remove('hidden');
                            }
                        });
                        
                        // Show general error message if present
                        if (result.message) {
                            errorMessage.textContent = escapeHtml(result.message);
                            formErrors.classList.remove('hidden');
                        }
                    } else {
                        errorMessage.textContent = escapeHtml(result.message || 'An error occurred. Please try again.');
                        formErrors.classList.remove('hidden');
                    }
                }
            } catch (error) {
                errorMessage.textContent = 'An error occurred while submitting the form. Please try again.';
                formErrors.classList.remove('hidden');
            } finally {
                submitBtn.disabled = false;
                submitText.classList.remove('hidden');
                loadingText.classList.add('hidden');
                checkFormValidity();
            }
        });

        setInterval(refreshCsrfToken, 15 * 60 * 1000);

        checkFormValidity();
    </script>
</form>