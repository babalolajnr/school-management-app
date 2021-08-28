const { forEach } = require('lodash');

require('./bootstrap');

require('alpinejs');

const date = new Date().getFullYear();
document.getElementById('footerDate').innerHTML = date;

const sunIcon = "<i class='fas fa-sun text-yellow-400'></i>"
const moonIcon = "<i class='fas fa-moon'></i>"

var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000
});


$(function () {
    toastrAlert()
    darkMode()
    setActiveSidebarLink()
});

function toastrAlert() {
    let Success = document.getElementById('success')
    let Error = document.getElementById('error')

    // if data-success = 'true' display alert
    if (Success.dataset.success == 'true')
        Toast.fire({
            icon: 'success',
            title: JSON.parse(Success.dataset.successMessage)
        })

    if (Error.dataset.error == 'true')
        Toast.fire({
            icon: 'error',
            title: JSON.parse(Error.dataset.errorMessage)
        })
}

function darkMode() {
    //get darkmode status from localStorage
    const darkmodeStatus = localStorage.getItem('dark-mode')

    if (darkmodeStatus == "true") {
        $('#navbar').removeClass('navbar-white navbar-light')
        $("#sidebar").addClass('sidebar-dark-navy')
        $('body').addClass('dark-mode')
        $('#navbar').addClass('navbar-dark')
        $("#dark-mode").append(sunIcon)
    } else {
        $("#sidebar").addClass('sidebar-light-navy')
        $("#dark-mode").append(moonIcon)
    }
}

$("#dark-mode").click(function () {
    const darkmodeStatus = localStorage.getItem('dark-mode')

    $('body').toggleClass('dark-mode')
    $("#sidebar").toggleClass('sidebar-light-navy sidebar-dark-navy')
    $('#navbar').toggleClass('navbar-dark navbar-white navbar-light')


    if (darkmodeStatus == "true") {
        $("#dark-mode").children().remove()
        $("#dark-mode").append(moonIcon)
        localStorage.setItem('dark-mode', false)
    } else {
        $("#dark-mode").children().remove()
        $("#dark-mode").append(sunIcon)
        localStorage.setItem('dark-mode', true)
    }
})

function setActiveSidebarLink() {
    const routeName = JSON.parse(document.getElementById('route').dataset.route)

    // All sidebar links and their children
    const routes = {
        "school-management": ["academic-session", "period", "fee", "classroom", "term", "subject", "teacher"],
        "student-management": ["student.index", "student.create", "student.get.alumni", "pd-type", "ad-type"],
        "app-management": ["user"],
        "dashboard": []
    }

    for (const [parent, children] of Object.entries(routes)) {
        
        //When there are no child links
        if (children.length < 1) {
            if (routeName.startsWith(parent)) $('#' + parent).addClass('active')
        } else {

            children.forEach((child) => {
                if (routeName.startsWith(child)) {

                    // replace '.' with '-' because of selector issues
                    while (child.includes('.')) {
                        child = child.replace(".", '-')
                    }

                    $('#' + child).addClass('active')
                    $('#' + parent).addClass('active')
                }
            })
        }
    }


}