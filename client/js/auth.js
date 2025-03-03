function signup(email, password, fname, lname, phone, address, cardNumber, expiryDate, cvv) {
    const formData = new FormData();
    formData.append('email', email);
    formData.append('password', password);
    formData.append('fname', fname);
    formData.append('lname', lname);
    formData.append('phone', phone);
    formData.append('address', address);
    formData.append('card_number', cardNumber);  // Card fields included
    formData.append('expiry_date', expiryDate);
    formData.append('cvv', cvv);

    axios.post('http://localhost/Digital-Wallet/server/User/v1/APIs/signup.php', formData)
    .then(response => {
        console.log('Server Response:', response.data); // Debugging

        // Check if the response contains 'success' key and it is true
        if (response.data.success) {
            alert('Signup successful! Redirecting to login page...');
            window.location.href = 'client-login.html';
        } else {
            // If the response has an error key, display that error
            alert('Signup failed! ' + (response.data.error || 'Please check your details and try again.'));
        }
    })
    .catch(error => {
        console.error('Error during signup:', error);
        alert('Signup failed! Please try again later.');
    });
    //login
    document.addEventListener('DOMContentLoaded', function() {
        console.log("DOM fully loaded and parsed");
    
        const loginForm = document.getElementById('login-form');
        if (loginForm) {
            loginForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent form from submitting
                console.log('Form submitted!');
                
                const emailPhone = document.getElementById('email-phone').value;
                const password = document.getElementById('password').value;
                console.log('Credentials captured:', emailPhone, password); // Check values
                
                login(emailPhone, password); // Call the login function
            });
        } else {
            console.error('Login form not found!');
        }
    });
    console.log("Before fetch");
fetch('login.php', {
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
    console.log("Inside fetch.then (response)");
    return response.json();
})
.then(data => {
    console.log("Inside fetch.then (data)");
    console.log("Parsed response data:", data);
    if (data.success) {
        console.log('Login successful:', data);
        console.log('Redirecting to client-index.html');
        window.location.href = 'client-index.html';
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
