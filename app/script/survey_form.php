<form class="bg-secondary flex flex-col justify-between p-6 px-8 sm:px-12 border rounded-xl shadow-md gap-y-4">
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
            >
        </div>
        <div class="flex flex-col items-start justify-start w-full sm:w-auto">
            <label for="fname" class="text-md text-accent select-none">Last Name</label>
            <input name="lname" type="text"
                class=" border-black rounded-xl bg-gray-100 p-2 px-4 text-md focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-black/30 w-full"
                placeholder="Doe" required
                minlength="1"
                maxlength="20"
            >
        </div>
    </div>

    <div class="flex flex-col items-start justify-start w-full sm:w-auto">
        <label for="fname" class="text-md text-accent select-none">Email Address</label>
        <input name="lname" type="email"
            class="text-white border-black rounded-xl bg-gray-100 p-2 px-4 text-md focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-black/30 w-full"
            placeholder="Doe" required>
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
    </div>

    <div class="flex flex-col items-start justify-start w-full gap-y-2">
        <label for="comments" class="text-md text-accent select-none">Suggestions</label>
        <textarea 
            name="suggestions" 
            id="suggestions" 
            rows="4" 
            placeholder="Enter your suggestions here..."
            class="w-full border-black rounded-xl bg-gray-100 p-2 px-4 text-md focus:ring-2  focus:outline-none placeholder-black/30 resize-none"
            minlength="255"
        ></textarea>
    </div>

    <div class="flex flex-row items-center justify-end pt-5">
        <button type="submit" id="submitBtn" class="bg-accent text-white px-4 py-2 rounded-xl sm:flex-none flex-auto disabled:opacity-50 disabled:cursor-not-allowed">Submit</button>
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

        const form = document.querySelector('form');
        const submitBtn = document.getElementById('submitBtn');
        
        const checkFormValidity = () => {
            const isValid = form.checkValidity();
            submitBtn.disabled = !isValid;
        };

        form.querySelectorAll('input, textarea, select').forEach(element => {
            element.addEventListener('input', checkFormValidity);
            element.addEventListener('change', checkFormValidity);
        });

        checkFormValidity();
    </script>
</form>