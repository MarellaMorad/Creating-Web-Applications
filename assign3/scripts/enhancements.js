/**
* Author: Marella Morad
* Target: All html files that use the menu
* Purpose: Adjust main menu based on screen size
* Created: 08/04/2023
* Last Updated: 08/04/2023
* Credits: 
*/

"use strict";

function setActivePage() {
    var navLinks = document.getElementsByClassName("nav-link");
    const manageButtons = document.getElementsByClassName("manage-buttons");

    if (manageButtons) {
        navLinks = [...navLinks, ...manageButtons];
    }

    Array.from(navLinks).forEach((link) => {
        if (link.href === window.location.href) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
}

function adjustMenu() {
    const navItems = [
        document.getElementById("home"),
        document.getElementById("careers"),
        document.getElementById("join-us"),
        document.getElementById("about-us"),
        document.getElementById("manage"),
        document.getElementById("enhancements"),
        document.getElementById("contact-us")
    ];

    if (document.title == "Manage EOIs") {
        navItems.push(document.getElementById("display-eois"));
        navItems.push(document.getElementById("delete-eois"));
        navItems.push(document.getElementById("update-eois"));
    }

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

        if (document.title == "Manage EOIs") {
            navItems[7].classList.add('fa', 'fa-eye');
            navItems[8].classList.add('fa', 'fa-trash');
            navItems[9].textContent = String.fromCharCode(0x270E);
        }

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
    navItems[3].dataset.originalText = "About Us";
    navItems[4].dataset.originalText = "Manage EOIs";
    navItems[5].dataset.originalText = "Enhancements";
    navItems[6].dataset.originalText = "Contact Us";

    if (document.title == "Manage EOIs") {
        navItems[7].dataset.originalText = "Display EOI Applications";
        navItems[8].dataset.originalText = "Delete EOI Applications";
        navItems[9].dataset.originalText = "Update the Status of EOI Applications";
    }
}

function restoreOriginalText(navItems) {
    navItems.forEach((item) => {
        item.textContent = item.dataset.originalText;
    })
}

function init() {
    // Add a listener for window resize events
    window.addEventListener("resize", adjustMenu);

    // Call the adjustMenu function to set the initial state of the navigation items
    adjustMenu();
    setActivePage();

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