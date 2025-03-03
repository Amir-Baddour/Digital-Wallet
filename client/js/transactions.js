// This script handles fetching the user’s transaction history.
function fetchTransactions(userId) {
    axios.get(`http://your-backend-url/server/user/v1/APIs/transactions.php?user_id=${userId}`)
        .then(response => {
            console.log('Transaction History:', response.data);
            // Display the transactions in the UI (e.g., in a table)
        })
        .catch(error => {
            console.error('Error fetching transactions:', error);
        });
}

// Example usage
const userId = 1; // Replace with the actual user ID
fetchTransactions(userId);