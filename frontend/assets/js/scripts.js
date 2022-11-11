$(document).ready(function() {
    $('#connector_begin').datepicker({});
    $('#connector_end').datepicker({})
});

$(document).on('click', '#connector_submit', function(e){
   
    var airport = $("#connector_airport").val();
    var begin = $("#connector_begin").val();
    var end = $("#connector_end").val();
    
    begin = toTimestamp(begin);
    end = toTimestamp(end);

    var url = "https://opensky-network.org/api/flights/arrival?airport="+airport+"&begin="+begin+"&end="+end;
    
    let request = new XMLHttpRequest();

    request.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        response = JSON.parse(this.responseText);
            }
    };

    request.open("GET", url, true);
    request.send();
    
    request.responseType = 'json';

    request.onload = function() {
        var data = request.response;
               
        $('#response').html(data); 
    };
});

function toTimestamp(date){

    myDate = date.split("/");
    var newDate = new Date( myDate[2], myDate[1] - 1, myDate[0]);
    convertDate = newDate.getTime();
    convertDateString = String(convertDate);
    convertDateFormat = convertDateString.substring(0, convertDateString.length - 3);

    return convertDateFormat;
}




  