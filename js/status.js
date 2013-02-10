function getWeather(lat, lon, callback	) {
    var weather = 'http://openweathermap.org/data/2.1/find/city?lat=' + lat + '&lon=' + lon + '&cnt=10';
    $.ajax({
      dataType: "jsonp",
      url: weather,
      success: callback
    });
}

// get data:
getWeather(53.3428, -6.266, function (data) {	
    console.log('weather data received');
    console.log(data.list[0].weather[0].description);
    console.log(data);
    x=data;
   
    img_src = "http://openweathermap.org/img/w/" + data.list[0].weather[0].icon + ".png";    
    $('#u1_a').attr("src", img_src);

   	$('#u1_b').html(
      x.list[0].name + ': ' + data.list[0].weather[0].description + '<br/>' +
      x.list[1].name + ': ' + data.list[0].weather[0].description + '<br/>' +
      x.list[2].name + ': ' + data.list[0].weather[0].description + '<br/>' +
      x.list[3].name + ': ' + data.list[0].weather[0].description + ''
                    ); 
});


