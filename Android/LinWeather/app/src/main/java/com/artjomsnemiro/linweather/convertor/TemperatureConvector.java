package com.artjomsnemiro.linweather.convertor;

/**
 * TemperatureConvector
 */
public class TemperatureConvector {
    /**
     * Standard formula: 50 °F = (50 - 32) × 5/9 = 10 °C
     * @param fahrenheit converts to celsius
     *
     * @return converted value
     */
    public static Integer convertToCelsius(double fahrenheit) {
            return (int) Math.rint( fahrenheit - 273.15 );
    }
}
