package com.artjomsnemiro.linweather.model;

public interface IWeatherModel {
    /**
     * @return Temperature
     */
    String getTemperature();

    /**
     * @return Located users city
     */
    String getCity();

    /**
     * @return weather icon name
     */
    String getIconName();
}
