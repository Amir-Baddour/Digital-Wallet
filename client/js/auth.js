// Signup function
function signup(email, password, fname, lname, phone, address, cardNumber, expiryDate, cvv) {
    const formData = new FormData();
    formData.append('email', email);
    formData.append('password', password);
    formData.append('fname', fname);
    formData.append('lname', lname);
    formData.append('phone', phone);
    formData.append('address', address);
    formData.append('card_number', cardNumber);
    formData.append('expiry_date', expiryDate);
    formData.append('cvv', cvv);

    axios.post('http://localhost/Digital-Wallet/server/User/v1/APIs/signup.php', formData)
        .then(response => {
            console.log('Server Response:', response.data);

            if (response.data.success) {
                alert('Signup successful! Redirecting to login page...');
                window.location.href = 'client-login.html';
            } else {
                alert('Signup failed! ' + (response.data.error || 'Please check your details and try again.'));
            }
        })
        .catch(error => {
            console.error('Error during signup:', error);
            alert('Signup failed! Please try again later.');
        });
}

// Login event listener
document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM fully loaded and parsed");

    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            event.preventDefault();
            console.log('Form submitted!');

            const emailPhone = document.getElementById('email-phone').value;
            const password = document.getElementById('password').value;
            console.log('Credentials captured:', emailPhone, password);

            login(emailPhone, password);
        });
    } else {
        console.error('Login form not found!');
    }
});

// Login function
// Login function
function login(emailPhone, password) {
    console.log("Before fetch");
    fetch('http://localhost/Digital-Wallet/server/User/v1/APIs/login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            email_phone: emailPhone,
            password: password
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log("Parsed response data:", data);
        if (data.success) {
            console.log('Login successful:', data);
            localStorage.setItem('user_id', data.user_id);  // Store user ID in localStorage
            window.location.href = 'client-index.html';  // Redirect to the home page
        } else {
            console.error('Login failed:', data.error);
            alert('Login failed: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error during login:', error);
        alert('An error occurred during login. Please try again.');
    });
}
