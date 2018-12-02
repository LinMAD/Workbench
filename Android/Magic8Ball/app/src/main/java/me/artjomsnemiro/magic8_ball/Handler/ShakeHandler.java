package me.artjomsnemiro.magic8_ball.Handler;

import android.hardware.Sensor;
import android.hardware.SensorEvent;
import android.hardware.SensorEventListener;
import android.hardware.SensorManager;

/**
 * Listener handel shake events
 */
public class ShakeHandler implements SensorEventListener {
    private OnShakeListener listener;
    private static final float THRESHOLD_GRAVITY = 2.7F;
    private static final int SHAKE_TIME_MS = 500;
    private long shakeTime;
    private boolean isShaking;

    public ShakeHandler() {
        this.isShaking = false;
    }

    public void setOnShakeListener(OnShakeListener listener) {
        this.listener = listener;
    }

    public interface OnShakeListener {
        void onShake(boolean isShaking);
    }

    @Override
    public void onSensorChanged(SensorEvent event) {
        if (event.sensor.getType() != Sensor.TYPE_ACCELEROMETER) {
            return;
        }

        // Calculate three-dimensional vector changes with gravity
        float x = event.values[0] / SensorManager.GRAVITY_EARTH;
        float y = event.values[1] / SensorManager.GRAVITY_EARTH;
        float z = event.values[2] / SensorManager.GRAVITY_EARTH;

        // Must be around of zero if not moving
        float gravityForce = (float) Math.sqrt(x * x + y * y + z * z);
        if (gravityForce < THRESHOLD_GRAVITY) {
            return;
        }

        final long now = System.currentTimeMillis();

        // Ignore event close SHAKE_TIME_MS
        if (shakeTime + SHAKE_TIME_MS > now) {
            return;
        }

        this.isShaking = true;

        // reset the shake if no shakes in short time
        if (shakeTime + SHAKE_TIME_MS < now) {
            this.isShaking = false;
        }

        shakeTime = now;

        listener.onShake(this.isShaking);
    }

    @Override
    public void onAccuracyChanged(Sensor sensor, int accuracy) {
        // Not needed to implement
    }
}
