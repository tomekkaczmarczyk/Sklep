$(function() {


    function showItems(cat) {
        $.ajax({
            url: "src/json.php",
            type: "POST",
            data: cat,
            dataType: "json"
        }).done(function (response) {
            response.forEach(function (resp) {
                show(resp)
            })
        })
            .fail(function () {
                console.log("fail")
            });
    }

    function show(response) {
        response.forEach(function(item) {
            var data = "<div>" + item + "</div>";
            var p = $("p");
            p.append(data);
        })
    }

    var btn = $('#btn');
    btn.on("click", function(event) {
        event.preventDefault();
        var select = $("select");
        var cat = select.val();
        var category = 'category=' . cat;
        showItems(cat)}
        );

})