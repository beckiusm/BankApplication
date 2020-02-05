$.get("userlist.php", function(data) { // get userlist from api
    $.each(JSON.parse(data), function (i, element) {
        $("#userTable tbody").append("<tr><td>" + element.firstName + " " + element.lastName + "</td><td>" + element.id + "</td><td>" + element.mobilephone + "</td>");
    })
});

function sendMoney() { // send ajax post request
	let toUser = $("#toUser").val();
    let type = $("#type").val();
    let amount = $("#amount").val();
    $.ajax(
        {
            method: "POST",
            url: "includes/sendMoney.php",
            data: {
            type: type,
            toUser: toUser,
            amount: amount
        },
        success: function(data) { // print message returned 
            $("#message").html(data);
        }
    });
}


$("#sendMoney").submit( (e) => { // ajax request button
    e.preventDefault();
    sendMoney();
    return false;
})

