/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var form_bills_description = document.getElementById("form_bills_description");
var form_bills_due_date = document.getElementById("form_bills_due_date");
var form_bills_value = document.getElementById("form_bills_value");
var button_save_bills = document.getElementById("button_save_bills");

function setBills(id, description, due_date, value) {
    $.post('/app/f/insertreceber/', {
        id: id,
        description: description,
        due_date: due_date,
        value: value
    }, function (data) {
//        $("table tbody").prepend("<tr class=\"uk-animation-fade\" id=\"" + data + "\" ><td><input type=\"checkbox\" value=\"" + data + "\" /></td><td>" + description + "</td><td>" + due_date + "</td><td>" + value + "</td></tr>");
//        $(".uk-modal-close").click();
        location.reload();
    });
}

function setBillsDelete(id_bills) {
    $.post('/app/f/delete/', {
        'id_bills': id_bills
    }, function (DATA) {
        var row = document.getElementById(id_bills);
        row.parentNode.removeChild(row);
    });
}

// Listen for click on toggle checkbox
$('#select-all').click(function(event) {   
    if(this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true;                        
        });
    } else {
        $(':checkbox').each(function() {
            this.checked = false;                        
        });
    }
});


var countChecked = function () {
    var n = $("input:checked").length;
    if (n == 0) {
        $("#delete").addClass("uk-hidden");
        $("#alter").addClass("uk-hidden");
    } else if (n == 1) {
        $("#alter").removeClass("uk-hidden");
        $("#delete").removeClass("uk-hidden");
    } else {
        $("#delete").removeClass("uk-hidden");
        $("#alter").addClass("uk-hidden");
    }
};
$("input[type=checkbox]").on("click", countChecked);

$("#delete").click(function () {
    var g_categoryList = [];
    $('table input:checked').map(function () {
        g_categoryList.push($(this).val());
    });
    $.each(g_categoryList, function (key, value) {        
        setBillsDelete(value);
    });

});
button_save_bills.onclick = function () {
    setBills(form_bills_description.value, form_bills_due_date.value, form_bills_value.value);
};