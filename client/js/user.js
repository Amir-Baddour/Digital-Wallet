// Fetch a user by ID
axios.get('http://your-backend-url/server/user/v1/APIs/user.php?id=1')
    .then(response => {
        console.log(response.data); // Handle the data
    })
    .catch(error => {
        console.error('Error fetching user:', error);
    });

// Create a new user
axios.post('http://your-backend-url/server/user/v1/APIs/user.php', {
    email: 'test@example.com',
    password: 'password123',
    role: 'client',
    full_name: 'Test User',
    phone: '1234567890',
    address: '123 Test St'
})
.then(response => {
    console.log(response.data); // Handle the response
})
.catch(error => {
    console.error('Error creating user:', error);
});