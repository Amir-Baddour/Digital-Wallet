// This script handles fetching and updating the user’s profile.
function fetchProfile(userId) {
    axios.get(`http://your-backend-url/server/user/v1/APIs/profile.php?user_id=${userId}`)
        .then(response => {
            console.log('Profile Data:', response.data);
            // Display the profile data in the UI
        })
        .catch(error => {
            console.error('Error fetching profile:', error);
        });
}

// Update user profile
function updateProfile(userId, fullName, phone, address) {
    axios.put(`http://your-backend-url/server/user/v1/APIs/profile.php?user_id=${userId}`, {
        full_name: fullName,
        phone: phone,
        address: address
    })
    .then(response => {
        console.log('Profile Updated:', response.data);
        // Handle success (e.g., show a success message)
    })
    .catch(error => {
        console.error('Error updating profile:', error);
    });
}

// Example usage
const userId = 1; // Replace with the actual user ID
fetchProfile(userId);

// Call this function when the user submits the profile update form
updateProfile(userId, 'New Name', '1234567890', 'New Address');