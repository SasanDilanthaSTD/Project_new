function search() {
    // Get the input element and filter value
    var input = document.getElementById("myInput");
    var filter = input.value.toUpperCase();

    // Get the list of names
    var names = document.querySelectorAll("#myTable h6.card-title");

    // Loop through all the list items
    for (var i = 0; i < names.length; i++) {
        var name = names[i];
        var text = name.textContent || name.innerText;

        // Check if the text of the name contains the filter value
        if (text.toUpperCase().indexOf(filter) > -1) {
            names[i].parentNode.parentNode.style.display = "";
        } else {
            names[i].parentNode.parentNode.style.display = "none";
        }
    }
}

