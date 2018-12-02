package com.artjomsnemiro.linweather;

import android.Manifest;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.TextView;

import com.artjomsnemiro.linweather.client.OpenWeatherMapClient;
import com.artjomsnemiro.linweather.model.IWeatherModel;

/**
 * WeatherController represents main app controller
 */
public class WeatherController extends AppCompatActivity {
    final String TAG = "LinWeather";
    final String LOCATION_PROVIDER = LocationManager.NETWORK_PROVIDER;
    // Number to validate location permission request
    final Integer REQUEST_CODE = 42; // And answer to everything and etc.
    final long LOC_MIN_TIME = 1000; // Time between location in milliseconds
    final float LOC_MIN_DISTANCE = 1000; // Distance between location updates (1000m or 1km) in meters

    TextView mCityLabel;
    TextView mTemperatureLabel;
    ImageView mWeatherImage;
    LocationManager mLocationManager;
    LocationListener mLocationListener;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(com.artjomsnemiro.linweather.R.layout.weather_controller_layout);

        // Check if app can have mandatory permissions
        final Integer internetGranted = ContextCompat.checkSelfPermission(
                WeatherController.this,
                Manifest.permission.INTERNET
        );

        if (internetGranted != PackageManager.PERMISSION_GRANTED) {
            AlertDialog.Builder dialog = new AlertDialog.Builder(this);

            dialog.setTitle("Permissions required");
            dialog.setCancelable(false);
            dialog.setMessage("Internet required, please grant it to application.");

            dialog.setNegativeButton("Close", new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    finish();
                }
            });

            dialog.show();

            return;
        }

        // Linking the elements
        mCityLabel = findViewById(com.artjomsnemiro.linweather.R.id.locationTV);
        mWeatherImage = findViewById(com.artjomsnemiro.linweather.R.id.weatherSymbolIV);
        mTemperatureLabel = findViewById(com.artjomsnemiro.linweather.R.id.tempTV);
        ImageButton changeCityButton = findViewById(com.artjomsnemiro.linweather.R.id.changeCityButton);

        changeCityButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent changeCityIntent = new Intent(WeatherController.this, ChangeCityController.class);
                startActivity(changeCityIntent);
            }
        });

    }

    @Override
    protected void onResume() {
        super.onResume();

        Log.d(TAG, "onResume: triggered");

        Intent weatherIntent = getIntent();
        String city = weatherIntent.getStringExtra(ChangeCityController.EXTRA_CITY);
        if (city != null) {
            getWeatherForCity(city);

            return;
        }

        getWeatherForLocation();
    }

    @Override
    protected void onPause() {
        super.onPause();

        Log.d(TAG, "onPause: triggered");

        if (mLocationManager != null) {
            mLocationManager.removeUpdates(mLocationListener);
        }

    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        if (requestCode == REQUEST_CODE) {
            Log.d(TAG, "onRequestPermissionsResult: REQUEST_CODE matches");

            if (grantResults.length > 0 && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                Log.d(TAG, "onRequestPermissionsResult: Granted");
                getWeatherForLocation();

                return;
            }

            Log.d(TAG, "onRequestPermissionsResult: Denied");
        }
    }

    /**
     * Must be called when needs to update data on user screen
     *
     * @param weatherModel Updates UI with given model data
     */
    public void updateUI(IWeatherModel weatherModel) {
        Log.d(TAG, "updateUI: New model data retrieved");

        mTemperatureLabel.setText(weatherModel.getTemperature());
        mCityLabel.setText(weatherModel.getCity());
        mWeatherImage.setImageResource(
                getResources().getIdentifier(weatherModel.getIconName(), "drawable", getPackageName())
        );
    }

    /**
     * Get weather information form API sources
     */
    private void getWeatherForLocation() {
        Integer fineLocPermission = ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION);
        Integer coarseLocPermission = ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION);

        // Check permission of location retrieving
        if (fineLocPermission != PackageManager.PERMISSION_GRANTED &&  coarseLocPermission != PackageManager.PERMISSION_GRANTED) {
            Log.d(TAG, "getWeatherForLocation: Checking permissions of location");

            ActivityCompat.requestPermissions(
                    this,
                    new String[] { Manifest.permission.ACCESS_COARSE_LOCATION },
                    REQUEST_CODE
            );

            return;
        }

        mLocationManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);
        mLocationListener = new LocationListener() {
            @Override
            public void onLocationChanged(Location location) {
                String longitude = String.valueOf(location.getLongitude());
                String latitude = String.valueOf(location.getLatitude());

                Log.d(TAG, "onLocationChanged: New location -> lon: " + longitude + " lat: " + latitude);

                OpenWeatherMapClient apiClient = new OpenWeatherMapClient(WeatherController.this);
                apiClient.handleWeatherDataForLocation(longitude, latitude);
            }

            @Override
            public void onStatusChanged(String provider, int status, Bundle extras) {
                Log.d(TAG, "onStatusChanged: ");
            }

            @Override
            public void onProviderEnabled(String provider) {
                Log.d(TAG, "onProviderEnabled: ");
            }

            @Override
            public void onProviderDisabled(String provider) {
                Log.d(TAG, "onProviderDisabled: ");
            }
        };

        mLocationManager.requestLocationUpdates(
                LOCATION_PROVIDER,
                LOC_MIN_TIME,
                LOC_MIN_DISTANCE,
                mLocationListener
        );
    }

    /**
     * Get weather for asked city name
     *
     * @param cityName where must be fetched weather
     */
    private void getWeatherForCity(String cityName) {
        OpenWeatherMapClient apiClient = new OpenWeatherMapClient(WeatherController.this);

        apiClient.handleWeatherDataForCity(cityName);
    }
}
