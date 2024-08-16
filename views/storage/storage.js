const categoryFilter = document.getElementById('categoryFilter');
const rows = document.querySelectorAll('tbody tr');
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