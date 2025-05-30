<?php
require_once 'generate_token.php';
require_once 'get_hobbies.php';
require_once 'get_nationalities.php';

$hobbies = getHobbies();
$nationalities = getNationalities();
?>
<!-- Toastr dependencies -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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
                oninput="this.value = this.value.replace(/[^A-Za-z\s\-]/g, '')"
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
                oninput="this.value = this.value.replace(/[^A-Za-z\s\-]/g, '')"
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

    <div class="flex flex-col items-start justify-start w-full sm:w-auto">
        <label for="age" class="text-md text-accent select-none">Age</label>
        <input name="age" type="number"
            class="border-black rounded-xl bg-gray-100 p-2 px-4 text-md focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-black/30 w-full"
            placeholder="25" required
            min="1"
            max="99"
            title="Please enter your age (between 1 and 150)"
            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
        >
        <span id="ageError" class="text-sm text-red-600 hidden"></span>
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
        <span class="text-md text-accent select-none">Do you have a personal computer?</span>
        <div class="flex flex-col gap-y-2 mx-4">
            <div class="flex flex-row gap-x-1">
                <input id="pc_yes" type="radio" value="1" name="has_pc"
                    class="w-4 h-4 text-primary bg-gray-100 border-gray-300 focus:ring-2"
                    required>
                <label for="pc_yes" class="ms-2 text-sm font-medium text-gray-900">Yes</label>
            </div>
            <div class="flex flex-row gap-x-1">
                <input id="pc_no" type="radio" value="0" name="has_pc"
                    class="w-4 h-4 text-primary bg-gray-100 border-gray-300"
                    required>
                <label for="pc_no" class="ms-2 text-sm font-medium text-gray-900">No</label>
            </div>
        </div>
        <span id="has_pcError" class="text-sm text-red-600 hidden"></span>
    </div>

    <div class="flex flex-col items-start justify-start w-full sm:w-auto gap-y-2">
        <span class="text-md text-accent select-none">Hobbies (Select at least one)</span>
        <div class="flex flex-col gap-y-2 mx-4">
            <?php foreach ($hobbies as $hobby): ?>
            <div class="flex flex-row gap-x-1">
                <input 
                    id="hobby_<?php echo htmlspecialchars($hobby['id'], ENT_QUOTES, 'UTF-8'); ?>" 
                    type="checkbox" 
                    value="<?php echo htmlspecialchars($hobby['name'], ENT_QUOTES, 'UTF-8'); ?>" 
                    name="hobbies[]"
                    class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-2"
                    <?php echo $hobby === reset($hobbies) ? 'required' : ''; ?>
                    <?php if ($hobby !== reset($hobbies)): ?>
                    onclick="document.getElementById('hobby_<?php echo htmlspecialchars(reset($hobbies)['id'], ENT_QUOTES, 'UTF-8'); ?>').required = !document.querySelectorAll('input[name=\'hobbies[]\']:checked').length"
                    <?php endif; ?>
                >
                <label 
                    for="hobby_<?php echo htmlspecialchars($hobby['id'], ENT_QUOTES, 'UTF-8'); ?>" 
                    class="ms-2 text-sm font-medium text-gray-900"
                ><?php echo htmlspecialchars(ucfirst($hobby['name']), ENT_QUOTES, 'UTF-8'); ?></label>
            </div>
            <?php endforeach; ?>
        </div>
        <span id="hobbiesError" class="text-sm text-red-600 hidden"></span>
    </div>

    <div class="flex flex-col items-start justify-start w-full sm:w-auto">
        <label for="nationality" class="text-md text-accent select-none">Nationality</label>
        <select name="nationality" id="nationality" required
            class="w-full border-black rounded-xl bg-gray-100 p-2 px-4 text-md focus:ring-2  focus:outline-none">
            <option value="" disabled selected class="text-gray-400">Select your nationality</option>
            <?php foreach ($nationalities as $nationality): ?>
            <option value="<?php echo htmlspecialchars($nationality['name'], ENT_QUOTES, 'UTF-8'); ?>">
                <?php echo htmlspecialchars(ucfirst($nationality['name']), ENT_QUOTES, 'UTF-8'); ?>
            </option>
            <?php endforeach; ?>
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

    <div class="flex flex-row items-center justify-end pt-5">
        <button type="submit" id="submitBtn" class="bg-accent text-white px-4 py-2 rounded-xl sm:flex-none flex-auto disabled:opacity-50 disabled:cursor-not-allowed">
            <span id="submitText">Submit</span>
            <span id="loadingText" class="hidden">Submitting...</span>
        </button>
    </div>

    <script>
        // Constants and DOM Elements
        const CSRF_REFRESH_INTERVAL = 15 * 60 * 1000; // 15 minutes
        const ERROR_FIELDS = ['fname', 'lname', 'email', 'gender', 'hobbies', 'nationality', 'rating', 'suggestions'];
        
        const elements = {
            form: document.querySelector('#surveyForm'),
            submitBtn: document.getElementById('submitBtn'),
            submitText: document.getElementById('submitText'),
            loadingText: document.getElementById('loadingText'),
            stars: document.querySelectorAll('input[name="rating"]'),
            csrfToken: document.querySelector('input[name="csrf_token"]')
        };

        // Toastr Configuration
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 0
        };

        // Star Rating Handler
        const handleStarRating = () => {
            elements.stars.forEach(star => {
                star.addEventListener('change', (e) => {
                    const selectedValue = parseInt(e.target.value);
                    elements.stars.forEach(s => {
                        const value = parseInt(s.value);
                        const label = document.querySelector(`label[for="star${value}"]`);
                        label.classList.toggle('text-highlight', value <= selectedValue);
                    });
                });
            });
        };

        // Form Validation
        const checkFormValidity = () => {
            elements.submitBtn.disabled = !elements.form.checkValidity();
        };

        const setupFormValidation = () => {
            elements.form.querySelectorAll('input, select').forEach(element => {
                element.addEventListener('input', checkFormValidity);
                element.addEventListener('change', checkFormValidity);
            });
        };

        // Security and Data Sanitization
        const escapeHtml = (unsafe) => {
            return unsafe
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        };

        const sanitizeFormData = (formData) => {
            for (let [key, value] of formData.entries()) {
                if (typeof value === 'string') {
                    formData.set(key, escapeHtml(value.trim()));
                }
            }
            return formData;
        };

        // CSRF Token Management
        const refreshCsrfToken = async () => {
            try {
                const response = await fetch('script/generate_token.php', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();
                elements.csrfToken.value = data.csrf_token;
            } catch (error) {
                console.error('Failed to refresh CSRF token:', error);
                toastr.error('Failed to refresh security token. Please reload the page.');
            }
        };

        // Form State Management
        const clearFieldErrors = () => {
            ERROR_FIELDS.forEach(field => {
                document.getElementById(`${field}Error`).classList.add('hidden');
            });
        };

        const toggleLoadingState = (isLoading) => {
            elements.submitBtn.disabled = isLoading;
            elements.submitText.classList.toggle('hidden', isLoading);
            elements.loadingText.classList.toggle('hidden', !isLoading);
        };

        const resetForm = () => {
            elements.form.reset();
            elements.stars.forEach(s => {
                const label = document.querySelector(`label[for="${s.id}"]`);
                label.classList.remove('text-highlight');
            });
            document.querySelector('label[for="star1"]').classList.add('text-highlight');
            checkFormValidity();
        };

        // Error Handling
        const handleFieldErrors = (errors) => {
            Object.entries(errors).forEach(([field, message]) => {
                const errorElement = document.getElementById(`${field}Error`);
                if (errorElement) {
                    errorElement.textContent = escapeHtml(message);
                    errorElement.classList.remove('hidden');
                }
            });
        };

        // Form Submission
        const submitForm = async (formData) => {
            try {
                const response = await fetch(elements.form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                return await response.json();
            } catch (error) {
                throw new Error('Failed to submit form');
            }
        };

        const handleSubmissionResponse = (result) => {
            if (result.csrf_token) {
                elements.csrfToken.value = result.csrf_token;
            }

            if (result.success) {
                toastr.success(result.message || 'Survey submitted successfully!');
                resetForm();
            } else {
                if (result.errors) {
                    handleFieldErrors(result.errors);
                    if (result.message) {
                        toastr.error(result.message);
                    }
                } else {
                    toastr.error(result.message || 'An error occurred. Please try again.');
                }
            }
        };

        // Main Form Handler
        const handleFormSubmit = async (e) => {
            e.preventDefault();
            clearFieldErrors();
            toggleLoadingState(true);

            try {
                const formData = new FormData(elements.form);
                const sanitizedFormData = sanitizeFormData(formData);
                const result = await submitForm(sanitizedFormData);
                handleSubmissionResponse(result);
            } catch (error) {
                toastr.error('An error occurred while submitting the form. Please try again.');
            } finally {
                toggleLoadingState(false);
            }
        };

        // Initialize Form
        const initializeForm = () => {
            handleStarRating();
            setupFormValidation();
            elements.form.addEventListener('submit', handleFormSubmit);
            setInterval(refreshCsrfToken, CSRF_REFRESH_INTERVAL);
            checkFormValidity();
        };

        // Start the application
        initializeForm();
    </script>
</form>