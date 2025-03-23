document.addEventListener('DOMContentLoaded', function () {
    // Tab navigation elements
    const tabInputs = document.querySelectorAll('input[type="radio"]');
    const contentSections = document.querySelectorAll('.content-section');
    
    // Mobile menu elements
    const hamburger = document.getElementById("hamburger");
    const mobileMenu = document.getElementById("mobileMenu");
    const featureButtons = document.querySelectorAll(".featureBtn");
    
    // Function to activate a tab and show its content
    function activateTab(tabId) {
        // Hide all content sections
        contentSections.forEach(section => {
            section.classList.remove('active');
        });
        
        // Show the selected content section
        const targetContent = document.getElementById(`content-${tabId}`);
        if (targetContent) {
            targetContent.classList.add('active');
        }
        
        // Check the corresponding radio button
        const radioButton = document.getElementById(tabId);
        if (radioButton) {
            radioButton.checked = true;
        }
        
        // Close mobile menu after selection
        mobileMenu.classList.remove("show");
        hamburger.classList.remove("open");
    }
    
    // Set up tab radio button listeners
    tabInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.checked) {
                activateTab(this.id);
            }
        });
    });
    
    // Set up mobile menu button listeners
    featureButtons.forEach(button => {
        button.addEventListener("click", function() {
            const tabId = this.getAttribute("data-content").replace("content-", "");
            activateTab(tabId);
        });
    });
    
    // Toggle hamburger menu
    hamburger.addEventListener("click", function() {
        mobileMenu.classList.toggle("show");
        this.classList.toggle("open");
    });
    
    // Initialize - activate the default tab (tab4 in your case)
    const defaultTab = document.getElementById('availablerides');
    if (defaultTab) {
        defaultTab.checked = true;
        activateTab('availablerides');
    }
});