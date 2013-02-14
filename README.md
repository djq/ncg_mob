cityscale
=================

## journey adviser

- address geodcoded using google
- points draggable
- start/end segments identied from OSM network
- slider enables routes at different times of day to be explored


## Weather
Analysis:

- bounding box or lat/long given; weather state returned



Data:

- http://openweathermap.org/

## Public Transport

Analysis:
 
 - hittheroad
 - opentripplanner

Data:

- hittheroad queries
- Dublin Bus GTFS
- OSM

## Driving 

Analysis

- hourly traffic simulation

Data

 - Openstreetmap road network



## Cycling Speed

Analysis

- total distance of shortest path on bicycle friendly routes

Data:

- OSM
- slope?

References:

The average bicycle speed used when engineers design bike lanes is 15.5 mph, according to "Transportation Infrastructure and Engineering," by Lester A. Hoel.

15.5 mph = 24.9448 km/hr (a little high maybe?)

## activity level

Analysis:

- Felix' scraping tweets and dumping in postgres
- overlay generated (heatmap / other output using historic data)
- testing to see what volume exists

Data:

- twitter
- foursquare
- instagram