// script.js

document.addEventListener('DOMContentLoaded', () => {
    console.log('Landing page loaded!');

    // Example: Add a simple click event to the search button
    const searchButton = document.querySelector('.search-bar button');
    if (searchButton) {
        searchButton.addEventListener('click', (e) => {
            e.preventDefault(); // Prevent default form submission if it's part of a form
            const searchInput = document.querySelector('.search-bar input');
            alert(`Searching for: ${searchInput.value}`);
            // In a real application, you would send this search term to a backend or filter content
        });
    }

    // Example: Smooth scrolling for anchor links (if you add them later)
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // You can add more JavaScript for:
    // - Animations (e.g., text fading in)
    // - Handling responsive navigation (hamburger menu)
    // - Image lazy loading
    // - Any dynamic content updates
});