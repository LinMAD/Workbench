package com.artjomsnemiro.linweather.client;

import android.util.Log;
import android.widget.Toast;

import com.artjomsnemiro.linweather.WeatherController;
import com.artjomsnemiro.linweather.model.OpenWeatherMapModel;
import com.loopj.android.http.AsyncHttpClient;
import com.loopj.android.http.JsonHttpResponseHandler;
import com.loopj.android.http.RequestHandle;
import com.loopj.android.http.RequestParams;

import org.json.JSONObject;

import cz.msebera.android.httpclient.Header;

/**
 * OpenWeatherMapClient represents HTTP client to get weather data from API
 */
public class OpenWeatherMapClient implements IWeatherClient {
    private final String TAG = "LinWeather";
    private final String API_ENDPOINT = "http://api.openweathermap.org/data/2.5/weather";
    private final String API_KEY = "_API_KEY_";

    private AsyncHttpClient client;
    private WeatherController appActivity;

    public OpenWeatherMapClient(WeatherController activity) {
        this.appActivity = activity;
        this.client = new AsyncHttpClient();
    }

    /**
     * Handles weather data by location
     *
     * @param lon a longitude
     * @param lat a latitude
     */
    public void handleWeatherDataForLocation(String lon, String lat) {
        RequestParams reqParam = new RequestParams();
        reqParam.put("lat", lat);
        reqParam.put("lon", lon);

        sendGetRequest(reqParam);
    }

    /**
     * Handles weather data by city name
     *
     * @param cityName to get weather
     */
    public void handleWeatherDataForCity(String cityName) {
        RequestParams reqParam = new RequestParams();
        reqParam.put("q", cityName);

        sendGetRequest(reqParam);
    }

    /**
     * Make GET request to fetch weather
     *
     * @param params for the request
     */
    private void sendGetRequest(RequestParams params) {
        params.put("appid", API_KEY);

        Log.d(TAG, "Prepared request params: " + params.toString());

        RequestHandle reqHandle = client.get(API_ENDPOINT, params, new JsonHttpResponseHandler() {
            @Override
            public void onSuccess(int statusCode, Header[] headers, JSONObject response) {
                Log.d(TAG, "Request onSuccess: JSONArray: " + response.toString());
                Log.d(TAG, "Request onSuccess: Status code: " + statusCode);

                appActivity.updateUI(OpenWeatherMapModel.fromJson(response));
            }

            @Override
            public void onFailure(int statusCode, Header[] headers, String responseString, Throwable throwable) {
                Log.d(TAG, "Request onFailure: Error: " + throwable.toString());
                Log.d(TAG, "Request onFailure: Status code: " + statusCode);

                Toast.makeText(appActivity, "Cannot retrieve weather data", Toast.LENGTH_LONG).show();
            }
        });

        Log.d(TAG, "sendGetRequest: is done: " + reqHandle.isFinished());
    }
}
