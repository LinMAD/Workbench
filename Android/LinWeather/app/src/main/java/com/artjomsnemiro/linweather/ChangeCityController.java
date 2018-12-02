package com.artjomsnemiro.linweather;

import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v7.app.AppCompatActivity;
import android.view.KeyEvent;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.TextView;

/**
 * ChangeCityController represents controller to change city
 */
public class ChangeCityController extends AppCompatActivity {
    public static final String EXTRA_CITY = "City";

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        setContentView(R.layout.change_city_layout);
        final EditText editTextField = (EditText) findViewById(R.id.queryET);
        ImageButton backBtn = (ImageButton) findViewById(R.id.backButton);

        backBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });

        editTextField.setOnEditorActionListener(new TextView.OnEditorActionListener() {
            @Override
            public boolean onEditorAction(TextView v, int actionId, KeyEvent event) {
                String newCity = editTextField.getText().toString();
                Intent newCityWeatherIntent = new Intent(ChangeCityController.this, WeatherController.class);

                if (newCity.length() > 1) {
                    newCityWeatherIntent.putExtra(EXTRA_CITY, newCity);

                    startActivity(newCityWeatherIntent);
                    return true;
                }

                return false;
            }
        });
    }
}
