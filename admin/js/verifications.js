//Approve or reject a verification.
axios.put('http://your-backend-url/server/admin/v1/APIs/verifications.php', {
    id: 1, // Verification ID
    status: 'approved' // or 'rejected'
})
.then(response => {
    console.log(response.data); // Handle the response
})
.catch(error => {
    console.error('Error updating verification:', error);
});