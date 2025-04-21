document.addEventListener("DOMContentLoaded", function() {
    // Sidebar Toggle
    const sidebar = document.querySelector('#sidebar');
    const content = document.querySelector('#content');
    const sidebarCollapse = document.querySelector('#sidebarCollapse');

    sidebarCollapse.addEventListener('click', function() {
        sidebar.classList.toggle('active');
        content.classList.toggle('active');
    });

});