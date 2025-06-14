document.addEventListener('DOMContentLoaded', function() {
    const footerLinks = document.querySelectorAll('a[href*="campcodes"]');
    footerLinks.forEach(link => {
        const parentDiv = link.parentElement;
        parentDiv.innerHTML = 'Developed with <i class="fa fa-heart text-danger"></i> by <span class="fw-semibold">Subish</span>';
    });
}); 