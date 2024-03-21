function displayAttr(type) {
    if (type.length == 0) {
        document.getElementById("Attr").innerHTML = "";
    } else {
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200)
                document.getElementById("Attr").innerHTML = this.responseText;
        };
        xmlhttp.open("GET", "typeattr.php?t=" + type, true);
        xmlhttp.send();
    }
}

function validateForm() {
    // A dictionary for err_fields to not override errors
    var err_fields = {};

    // Required Fields Validation
    var req_fields = document.getElementsByClassName("req_field");
    var oof = false;
    if (req_fields.length) {
        for (var i = 0; i < req_fields.length; i++) {
            err_field_id = "err_" + req_fields[i].name;
            if (err_field_id in err_fields) continue;
            err_field = document.getElementById(err_field_id);
            if (!err_field) {
                console.error(
                    "Element with id: '" + err_field_id + "' does not exist"
                );
                return false;
            }
            if (!req_fields[i].value || req_fields[i].value === "") {
                label_query = "label[for='" + req_fields[i].name + "']";
                label = document.querySelector(label_query);
                if (!label) {
                    console.error(
                        "Element with query: '" +
                            label_query +
                            "' does not exist"
                    );
                    return false;
                }
                err_fields[err_field_id] = 1;
                err_field.innerHTML =
                    "* " + label.innerHTML.slice(0, -2) + " is required";
                oof = true;
            } else {
                req_fields[i].value = testInput(req_fields[i].value);
                err_field.innerHTML = "*";
            }
        }
    }

    // Letters and Numbers Validation
    var let_fields = document.getElementsByClassName("let_field");
    if (let_fields.length) {
        for (var i = 0; i < let_fields.length; i++) {
            err_field_id = "err_" + let_fields[i].name;
            if (err_field_id in err_fields) continue;
            err_field = document.getElementById(err_field_id);
            if (!err_field) {
                console.error(
                    "Element with id: '" + err_field_id + "' does not exist"
                );
                return false;
            }
            if (!/^[a-zA-Z][\w]*$/.test(let_fields[i].value)) {
                label_query = "label[for='" + let_fields[i].name + "']";
                label = document.querySelector(label_query);
                if (!label) {
                    console.error(
                        "Element with query: '" +
                            label_query +
                            "' does not exist"
                    );
                    return false;
                }
                err_fields[err_field_id] = 1;
                err_field.innerHTML = "* Only letters and numbers are allowed";
                oof = true;
            } else {
                err_field.innerHTML = "*";
            }
        }
    }

    // Letters and Numbers and Whitespaces Validation
    var space_fields = document.getElementsByClassName("space_field");
    if (space_fields.length) {
        for (var i = 0; i < space_fields.length; i++) {
            err_field_id = "err_" + space_fields[i].name;
            if (err_field_id in err_fields) continue;
            err_field = document.getElementById(err_field_id);
            if (!err_field) {
                console.error(
                    "Element with id: '" + err_field_id + "' does not exist"
                );
                return false;
            }
            if (!/^[a-zA-Z][\w\s]*$/.test(space_fields[i].value)) {
                label_query = "label[for='" + space_fields[i].name + "']";
                label = document.querySelector(label_query);
                if (!label) {
                    console.error(
                        "Element with query: '" +
                            label_query +
                            "' does not exist"
                    );
                    return false;
                }
                err_fields[err_field_id] = 1;
                err_field.innerHTML =
                    "* Only letters and whitespaces are allowed";
                oof = true;
            } else {
                err_field.innerHTML = "*";
            }
        }
    }

    // Decimal Numbers Validation
    var dec_fields = document.getElementsByClassName("dec_field");
    if (dec_fields.length) {
        for (var i = 0; i < dec_fields.length; i++) {
            err_field_id = "err_" + dec_fields[i].name;
            if (err_field_id in err_fields) continue;
            err_field = document.getElementById(err_field_id);
            if (!err_field) {
                console.error(
                    "Element with id: '" + err_field_id + "' does not exist"
                );
                return false;
            }
            if (!/^\d+(\.\d+)?$/.test(dec_fields[i].value)) {
                label_query = "label[for='" + dec_fields[i].name + "']";
                label = document.querySelector(label_query);
                if (!label) {
                    console.error(
                        "Element with query: '" +
                            label_query +
                            "' does not exist"
                    );
                    return false;
                }
                err_fields[err_field_id] = 1;
                err_field.innerHTML = "* Only decimal numbers are allowed";
                oof = true;
            } else {
                err_field.innerHTML = "*";
            }
        }
    }

    // Type Validation
    var type_field = document.getElementsByClassName("type_field");
    if (type_field.length) {
        type_field = type_field[0];
        err_field_id = "err_" + type_field.name;
        err_field = document.getElementById(err_field_id);
        if (!err_field) {
            console.error(
                "Element with id: '" + err_field_id + "' does not exist"
            );
            return false;
        }
        if (!(err_field_id in err_fields)) {
            if (
                type_field.value != "DVD" &&
                type_field.value != "Book" &&
                type_field.value != "Furn"
            ) {
                err_fields[err_field_id] = 1;
                err_field.innerHTML = "* Don't";
                oof = true;
            } else {
                err_field.innerHTML = "*";
            }
        }
    }

    // SKU Validation
    var sku_field = document.getElementsByClassName("sku_field");
    if (sku_field.length) {
        sku_field = sku_field[0];
        err_field_id = "err_" + sku_field.name;
        err_field = document.getElementById(err_field_id);
        if (!err_field) {
            console.error(
                "Element with id: '" + err_field_id + "' does not exist"
            );
            return false;
        }
        if (!(err_field_id in err_fields)) {
            var sku = sku_field.value;
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "check_sku.php", false);
            xhr.setRequestHeader(
                "Content-Type",
                "application/x-www-form-urlencoded"
            );
            xhr.onload = function () {
                if (this.status == 200) {
                    var response = JSON.parse(this.response);

                    if (response.exists) {
                        err_fields[err_field_id] = 1;
                        err_field.innerHTML =
                            "* This SKU was already used before";
                        oof = true;
                    } else {
                        err_field.innerHTML = "*";
                    }
                }
            };
            xhr.send("sku=" + encodeURIComponent(sku));
        }
    }

    // Error Existence Checking
    if (oof === true) {
        return false;
    } else {
        return true;
    }
}

function testInput(data) {
    // Trim leading and trailing whitespaces
    data = data.trim();

    // Remove backslashes
    data = data.replace(/\\/g, "");

    // Convert HTML special characters to entities
    data = data
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#39;");

    return data;
}
