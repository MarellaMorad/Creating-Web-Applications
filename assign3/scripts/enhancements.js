/**
* Author: Marella Morad
* Target: All html files that use the menu
* Purpose: Adjust main menu based on screen size
* Created: 08/04/2023
* Last Updated: 08/04/2023
* Credits: 
*/

"use strict";

function passwordToggle() {
    const passwordInput = document.getElementById('manager-password');
    const togglePassword = document.getElementsByClassName('toggle-password');

    if (passwordInput && togglePassword[0]) {
        togglePassword[0].addEventListener('click', function () {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePassword[0].classList.remove('fa-eye');
                togglePassword[0].classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                togglePassword[0].classList.remove('fa-eye-slash');
                togglePassword[0].classList.add('fa-eye');
            }
        });
    }
}

function setActivePage() {
    var navLinks = document.getElementsByClassName("nav-link");
    const manageButtons = document.getElementsByClassName("manage-buttons");

    if (manageButtons) {
        navLinks = [...navLinks, ...manageButtons];
    }

    Array.from(navLinks).forEach((link) => {
        if (link.href === window.location.href) {
            link.classList.add('active');
        } else if (link.classList.contains('has-child')) {
            var children = link.nextElementSibling.querySelectorAll('.sub-menu li');
            Array.from(children).forEach((child) => {
                if (child.querySelector('a').href === window.location.href) {
                    link.classList.add('active');
                }
            })
        } else {
            link.classList.remove('active');
        }
    });

    if (window.location.href.endsWith('/login.php') ||
        window.location.href.endsWith('/signup.php') ||
        window.location.href.includes('/manage.php')) {
        navLinks[4].classList.add('active');
    }
}

function adjustMenu() {
    const navItems = [
        document.getElementById("home"),
        document.getElementById("careers"),
        document.getElementById("join-us"),
        document.getElementById("about"),
        document.getElementById("manage"),
        document.getElementById("enhancements"),
        document.getElementById("contact-us")
    ];

    storeOriginalText(navItems);

    // Check if the screen width is smaller than 869 pixels
    if (window.innerWidth < 869) {
        // Clear the text content of the navigation item
        navItems.forEach(item => item.textContent = "");
        // Add the font-awesome icon classes
        navItems[0].classList.add('fas', 'fa-home');
        navItems[1].classList.add('fas', 'fa-briefcase');
        navItems[2].classList.add('fas', 'fa-user-plus');
        navItems[3].classList.add('fas', 'fa-info-circle');
        navItems[4].classList.add('fas', 'fa-address-book');
        navItems[5].classList.add('fas', 'fa-cog');
        navItems[6].classList.add('fas', 'fa-envelope');
    } else {
        navItems.forEach(item => item.classList.remove(...item.classList));
        setActivePage();
        restoreOriginalText(navItems);
    }
}

function storeOriginalText(navItems) {
    navItems[0].dataset.originalText = "Home";
    navItems[1].dataset.originalText = "Careers";
    navItems[2].dataset.originalText = "Join Us";
    navItems[3].dataset.originalText = "About";
    navItems[4].dataset.originalText = "Manage EOIs";
    navItems[5].dataset.originalText = "Enhancements";
    navItems[6].dataset.originalText = "Contact Us";
}

function restoreOriginalText(navItems) {
    navItems.forEach((item) => {
        item.textContent = item.dataset.originalText;
    })
}

function adjustHRSubmenu() {
    const hrNavItems = [
        document.getElementById("display-eois"),
        document.getElementById("delete-eois"),
        document.getElementById("update-eois")
    ];

    if (hrNavItems[0] && hrNavItems[1] && hrNavItems[2]) {
        hrNavItems[0].dataset.originalText = "Display EOI Applications";
        hrNavItems[1].dataset.originalText = "Delete EOI Applications";
        hrNavItems[2].dataset.originalText = "Update the Status of EOI Applications";

        // Check if the screen width is smaller than 869 pixels
        if (window.innerWidth < 869) {
            // Clear the text content of the navigation item
            hrNavItems.forEach(item => item.textContent = "");
            // Add the font-awesome icon classes
            hrNavItems[0].classList.add('fa', 'fa-eye');
            hrNavItems[1].classList.add('fa', 'fa-trash');
            hrNavItems[2].textContent = String.fromCharCode(0x270E);
        } else {
            hrNavItems.forEach(item => item.classList.remove(...item.classList));
            setActivePage();
            restoreOriginalText(hrNavItems);
        }
    }
}

function init() {
    // Add a listener for window resize events
    window.addEventListener("resize", adjustMenu);

    // Call the adjustMenu function to set the initial state of the navigation items
    adjustMenu();
    setActivePage();

    if (document.title == "Manage EOIs") {
        window.addEventListener("resize", adjustHRSubmenu);
        adjustHRSubmenu();
    }

    passwordToggle();

    const backToTopButton = document.getElementsByClassName("back-to-top");
    window.addEventListener("scroll", () => {
        if (window.scrollY > 100) {
            backToTopButton[0].classList.remove("hidden");
        } else {
            backToTopButton[0].classList.add("hidden");
        }
    });

    backToTopButton[0].addEventListener("click", () => {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
}

window.onload = init;