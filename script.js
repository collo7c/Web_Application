// 1. WELCOME MESSAGE 

document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on the home page (index.html)
    if (document.getElementById('greetingText')) {
        // Ask for user's name
        let userName = prompt("Welcome to FitZone Gym! Please enter your name:");
        
        // If user enters a name, display it; otherwise use "Guest"
        if (userName !== null && userName.trim() !== "") {
            document.getElementById('greetingText').textContent = "👋 Welcome, " + userName.trim() + "! 💪 Let's get fit!";
        } else {
            document.getElementById('greetingText').textContent = "👋 Welcome, guest! 💪 Let's get fit!";
        }
    }

   
    // 3. DYNAMIC CONTENT 
    
    
    // Feature 1: Show/Hide extra content
    const showMoreBtn = document.getElementById('showMoreBtn');
    const extraContent = document.getElementById('extraContent');
    
    if (showMoreBtn && extraContent) {
        showMoreBtn.addEventListener('click', function() {
            if (extraContent.style.display === 'block') {
                extraContent.style.display = 'none';
                showMoreBtn.textContent = '📖 Show extra info';
            } else {
                extraContent.style.display = 'block';
                showMoreBtn.textContent = '📖 Hide extra info';
            }
        });
    }

    // Feature 2: Toggle color highlight
    const colorToggleBtn = document.getElementById('colorToggleBtn');
    const cardToHighlight = document.querySelector('.card');
    
    if (colorToggleBtn && cardToHighlight) {
        colorToggleBtn.addEventListener('click', function() {
            cardToHighlight.classList.toggle('highlight');
            if (cardToHighlight.classList.contains('highlight')) {
                colorToggleBtn.textContent = '🎨 Remove highlight';
            } else {
                colorToggleBtn.textContent = '🎨 Toggle highlight';
            }
        });
    }

    // Feature 3: Confirmation message
    const confirmBtn = document.getElementById('confirmBtn');
    const confirmationToast = document.getElementById('confirmationToast');
    
    if (confirmBtn && confirmationToast) {
        confirmBtn.addEventListener('click', function() {
            confirmationToast.innerHTML = '<div class="toast">✅ Action confirmed! Thank you!</div>';
            // Auto-hide after 3 seconds
            setTimeout(function() {
                confirmationToast.innerHTML = '';
            }, 3000);
        });
    }

    // Feature 4: Interactive cards (change card appearance on click)
    const demoCards = document.querySelectorAll('.demo-card');
    
    demoCards.forEach(function(card) {
        card.addEventListener('click', function() {
            // Remove active class from all cards
            demoCards.forEach(function(c) {
                c.classList.remove('active-card');
            });
            // Add active class to clicked card
            this.classList.add('active-card');
        });
    });

    
    // 2. FORM VALIDATION (10 marks)
   
    const registrationForm = document.getElementById('registrationForm');
    const formError = document.getElementById('formError');
    
    if (registrationForm) {
        registrationForm.addEventListener('submit', function(event) {
            // Clear previous errors
            formError.textContent = '';
            formError.style.color = '#c0392b';
            
            // Get form field values
            const fullName = document.getElementById('fullName');
            const email = document.getElementById('emailAddr');
            const phone = document.getElementById('phoneNum');
            const plan = document.getElementById('planSelect');
            
            // Validation flags
            let isValid = true;
            let errorMessages = [];
            
            // Validate Full Name
            if (!fullName.value.trim()) {
                errorMessages.push('Full Name is required.');
                fullName.style.borderColor = '#c0392b';
                isValid = false;
            } else {
                fullName.style.borderColor = '#ddd';
            }
            
            // Validate Email
            if (!email.value.trim()) {
                errorMessages.push('Email Address is required.');
                email.style.borderColor = '#c0392b';
                isValid = false;
            } else if (!email.value.includes('@') || !email.value.includes('.')) {
                errorMessages.push('Please enter a valid email address.');
                email.style.borderColor = '#c0392b';
                isValid = false;
            } else {
                email.style.borderColor = '#ddd';
            }
            
            // Validate Phone
            if (!phone.value.trim()) {
                errorMessages.push('Phone Number is required.');
                phone.style.borderColor = '#c0392b';
                isValid = false;
            } else if (phone.value.trim().length < 10) {
                errorMessages.push('Phone Number must be at least 10 digits.');
                phone.style.borderColor = '#c0392b';
                isValid = false;
            } else {
                phone.style.borderColor = '#ddd';
            }
            
            // Validate Membership Plan
            if (!plan.value || plan.value === '') {
                errorMessages.push('Please select a Membership Plan.');
                plan.style.borderColor = '#c0392b';
                isValid = false;
            } else {
                plan.style.borderColor = '#ddd';
            }
            
            // Display errors, or let the form continue on to process_registration.php
            if (!isValid) {
                event.preventDefault(); // Only block submission when validation fails
                formError.innerHTML = '❌ ' + errorMessages.join('<br>');
            } else {
                formError.innerHTML = '';
                formError.style.color = '#27ae60';

                // Reset border colors
                document.querySelectorAll('input, select, textarea').forEach(function(el) {
                    el.style.borderColor = '#ddd';
                });

                // No preventDefault() here: the browser now submits the form
                // via POST to process_registration.php, which does the real
                // server-side validation, database insert, and confirmation.
            }
        });
    }
});