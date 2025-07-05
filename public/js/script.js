// Modal handling
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById("addContactModal");
    const btn = document.getElementById("addContactBtn");
    const span = document.getElementsByClassName("close")[0];
    const cancelBtn = document.getElementById("cancelAdd");

    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    cancelBtn.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});


// to send email

// to phone