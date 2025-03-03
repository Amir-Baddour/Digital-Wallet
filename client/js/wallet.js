// This script handles fetching the wallet balance and performing deposits/withdrawals.
function fetchWalletBalance(userId) {
    axios.get(`http://your-backend-url/server/user/v1/APIs/wallet.php?user_id=${userId}`)
        .then(response => {
            console.log('Wallet Balance:', response.data);
            // Display the wallet balance in the UI
        })
        .catch(error => {
            console.error('Error fetching wallet balance:', error);
        });
}

// Deposit or withdraw funds
function manageWallet(userId, type, amount) {
    axios.post(`http://your-backend-url/server/user/v1/APIs/wallet.php?user_id=${userId}`, {
        type: type, // 'deposit' or 'withdrawal'
        amount: amount
    })
    .then(response => {
        console.log('Wallet Updated:', response.data);
        // Handle success (e.g., show a success message and refresh the balance)
        fetchWalletBalance(userId); // Refresh the balance
    })
    .catch(error => {
        console.error('Error managing wallet:', error);
    });
}

// Example usage
const userId = 1; // Replace with the actual user ID
fetchWalletBalance(userId);

// Call this function when the user deposits or withdraws funds
manageWallet(userId, 'deposit', 100.00); // Deposit $100