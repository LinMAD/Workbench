package com.artjomsnemiro.linweather.model;

import com.artjomsnemiro.linweather.convertor.TemperatureConvector;

import org.json.JSONException;
import org.json.JSONObject;

/**
 * OpenWeatherMapModel represents API model
 */
public class OpenWeatherMapModel implements IWeatherModel {
    private String mTemperature;
    private String mCity;
    private String mIconName;
    private Integer mCondition;

    /**
     * Parse json to model
     *
     * @param json example: {
     *  "coord":{
     *      "lon":99.99,
     *      "lat":99.99
     *  },
     *  "weather":[{
     *      "id":800,
     *      "main":"Clear",
     *      "description":"clear sky",
     *      "icon":"01d"
     *  }],
     *  "base":"stations",
     *  "main":{
     *      "temp":290.41,
     *      "pressure":1029,
     *      "humidity":42,
     *      "temp_min":290.15,
     *      "temp_max":291.15
     *  },
     *  "visibility":10000,
     *  "wind":{
     *      "speed":1.5,
     *      "deg":230
     *  },
     *  "clouds":{
     *      "all":0
     *  },
     *  "dt":1525594800,
     *  "sys":{
     *      "type":1,
     *      "id":5245,
     *      "message":0.0277,
     *      "country":"SE",
     *      "sunrise":1525576468,
     *      "sunset":1525632957
     *  },
     *  "id":2692965,
     *  "name":"NY",
     *  "cod":200
     *}
     *
     * @return OpenWeatherMapModel
     */
    public static OpenWeatherMapModel fromJson(JSONObject json) {
        OpenWeatherMapModel weatherData = new OpenWeatherMapModel();

        try {
            int celsiusTemp = TemperatureConvector.convertToCelsius(json.getJSONObject("main").getDouble("temp"));
            JSONObject weather = json.getJSONArray("weather").getJSONObject(0);

            weatherData.mCity = json.getString("name");
            weatherData.mTemperature = Integer.toString(celsiusTemp);
            weatherData.mCondition = weather.getInt("id");
            weatherData.mIconName = updateWeatherIcon(weatherData.mCondition);
        } catch (JSONException e) {
            e.printStackTrace();

            return null;
        }

        return weatherData;
    }


    /**
     * @param condition id of weather type
     *
     * @return image name for the weather type
     */
    private static String updateWeatherIcon(int condition) {
        if (condition >= 0 && condition < 300) {
            return "tstorm1";
        } else if (condition >= 300 && condition < 500) {
            return "light_rain";
        } else if (condition >= 500 && condition < 600) {
            return "shower3";
        } else if (condition >= 600 && condition <= 700) {
            return "snow4";
        } else if (condition > 700 && condition < 772) {
            return "fog";
        } else if (condition >= 772 && condition < 800) {
            return "tstorm3";
        } else if (condition == 800) {
            return "sunny";
        } else if (condition >= 801 && condition <= 804) {
            return "cloudy2";
        } else if (condition >= 900 && condition <= 902) {
            return "tstorm3";
        } else if (condition == 903) {
            return "snow5";
        } else if (condition == 904) {
            return "sunny";
        } else if (condition >= 905 && condition <= 1000) {
            return "tstorm3";
        }

        return "dunno";
    }

    public String getTemperature() {
        return mTemperature + "°C";
    }

    public String getCity() {
        return mCity;
    }

    public String getIconName() {
        return mIconName;
    }
}
