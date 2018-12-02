package me.artjomsnemiro.magic8_ball;

import android.hardware.Sensor;
import android.hardware.SensorManager;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;

import me.artjomsnemiro.magic8_ball.Handler.DecisionHandler;
import me.artjomsnemiro.magic8_ball.Handler.ShakeHandler;

public class MainActivity extends AppCompatActivity {
    private Sensor accelerometer;
    private SensorManager sensorManager;
    private ShakeHandler shakeHandler;

    public MainActivity() {
        this.shakeHandler = new ShakeHandler();
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        final ImageView imgBall = findViewById(R.id.imgBall);
        Button askButton = findViewById(R.id.btnAsk);

        // Handle button event
        askButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                DecisionHandler makeDecision = new DecisionHandler();

                makeDecision.getAnswer(imgBall);
            }
        });

        // Handle shaking event
        this.sensorManager = (SensorManager) getSystemService(MainActivity.SENSOR_SERVICE);
        this.accelerometer = sensorManager.getDefaultSensor(Sensor.TYPE_ACCELEROMETER);
        shakeHandler.setOnShakeListener(new ShakeHandler.OnShakeListener() {
            @Override
            public void onShake(boolean isShaking) {
                DecisionHandler makeDecision = new DecisionHandler();

                makeDecision.getAnswer(imgBall);
            }
        });
    }

    @Override
    public void onResume() {
        super.onResume();
        sensorManager.registerListener(shakeHandler, accelerometer,	SensorManager.SENSOR_DELAY_UI);
    }

    @Override
    public void onPause() {
        sensorManager.unregisterListener(shakeHandler);
        super.onPause();
    }
}
