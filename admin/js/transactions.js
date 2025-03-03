//Fetch all transactions.
axios.get('http://your-backend-url/server/admin/v1/APIs/transactions.php')
    .then(response => {
        console.log(response.data); // Handle the data (e.g., display in a table)
    })
    .catch(error => {
        console.error('Error fetching transactions:', error);
    });