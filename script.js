document.addEventListener('DOMContentLoaded', function() {
    // Initialize charts if they exist
    if (document.getElementById('incomeChart')) {
        initCharts();
    }
});

function initCharts() {
    // Sample data - in a real app you would fetch this from your backend
    const incomeData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Income',
            data: [1200, 1900, 1500, 2000, 1800, 2200],
            backgroundColor: 'rgba(46, 204, 113, 0.2)',
            borderColor: 'rgba(46, 204, 113, 1)',
            borderWidth: 1
        }]
    };

    const expenseData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Expenses',
            data: [800, 1200, 900, 1100, 1000, 1300],
            backgroundColor: 'rgba(231, 76, 60, 0.2)',
            borderColor: 'rgba(231, 76, 60, 1)',
            borderWidth: 1
        }]
    };

    const incomeCtx = document.getElementById('incomeChart').getContext('2d');
    const expenseCtx = document.getElementById('expenseChart').getContext('2d');

    new Chart(incomeCtx, {
        type: 'bar',
        data: incomeData,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    new Chart(expenseCtx, {
        type: 'bar',
        data: expenseData,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}