package com.artjomsnemiro.linweather.client;

public interface IWeatherClient {
    /**
     * Must handle retrieving weather data by given coordinates
     *
     * @param lon a longitude
     * @param lat a latitude
     */
    void handleWeatherDataForLocation(String lon, String lat);

    /**
     * Must handle retrieving weather data by given city name
     *
     * @param cityName to get weather
     */
    void handleWeatherDataForCity(String cityName);
}