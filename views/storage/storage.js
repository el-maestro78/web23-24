const categoryFilter = document.getElementById('categoryFilter');
const rows = document.querySelectorAll('#items-table tbody tr');
categoryFilter.addEventListener('change', function() {
    const selectedCategory = this.value;
    rows.forEach(row => {
        const itemCategory = row.getAttribute('data-category');
        if (selectedCategory === 'all' || itemCategory === selectedCategory) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});


const vehicleFilter = document.getElementById('vehicleFilter');
const vehicleRows = document.querySelectorAll('#vehicle-table tbody tr');
vehicleFilter.addEventListener('change', function() {
    const selectedVehicle = this.value;
    vehicleRows.forEach(row => {
        const vehicle = row.getAttribute('data-category');
        if (selectedVehicle === 'all' || vehicle === selectedVehicle) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});