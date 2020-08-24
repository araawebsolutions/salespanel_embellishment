function getSearchResult() {


     var formValue  = $("#filter-form").serialize();
     console.log(formValue);
    $.ajax({
        type: "POST",
        url: mainUrl + "search/search/getSearchResults",
        data:formValue,
        dataType: 'json',
        success: function (data) {

            $('#format_page').show();
            $('#customer').hide();
            $('#customer_orders').hide();
            $('#format_page').html(data.html);
        },
        error: function (jqXHR, exception) {
            if (jqXHR.status === 500) {
                alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');
            } else {
                alert('Error While Requesting...');
            }
        }
    });
}

function changeCategory(type) {

    $.ajax({
        type: "get",
        url: mainUrl + "search/search/getSearch",
        data:{'category':type},
        dataType: 'json',
        success: function (data) {

            $('#format_page').show();
            $('#customer').hide();
            $('#customer_orders').hide();
            $('#format_page').html(data.html);
        },
        error: function (jqXHR, exception) {
            if (jqXHR.status === 500) {
                alert('We Have No Product For This Diameter Please Re-enter Diameter Values...');
            } else {
                alert('Error While Requesting...');
            }
        }
    });
}