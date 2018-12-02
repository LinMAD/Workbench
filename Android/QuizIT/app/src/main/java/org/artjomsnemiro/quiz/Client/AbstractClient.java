package org.artjomsnemiro.quiz.Client;

import android.content.Context;

import com.android.volley.Cache;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.BasicNetwork;
import com.android.volley.toolbox.DiskBasedCache;
import com.android.volley.toolbox.HurlStack;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

/**
 * Abstract HTTP client to communicate with API
 */
class AbstractClient {
    private RequestQueue requestQueue;
    private onSuccessListener successListener;
    private onErrorListener errorListener;

    AbstractClient(Context context) {
        this.requestQueue = Volley.newRequestQueue(context);

        // Create cache with 1 mb
        Cache cache = new DiskBasedCache(context.getCacheDir(), 1024 * 1024);

        // Set up the network to use HttpURLConnection as the HTTP client.
        BasicNetwork network = new BasicNetwork(new HurlStack());

        // Create Q with the cache and network
        requestQueue = new RequestQueue(cache, network);
        requestQueue.start();
    }

    /**
     * @param listener to handle successful request
     */
    void setSuccessListener(onSuccessListener listener) {
        this.successListener = listener;
    }

    /**
     * Request handling behavior
     */
    public interface onSuccessListener {
        void success(String response);
    }

    /**
     *
     * @param listener to handle unsuccessful request
     */
    void setErrorListener(onErrorListener listener) {
        this.errorListener = listener;
    }

    /**
     * Request handling behavior
     */
    public interface onErrorListener {
        void error(String response);
    }

    /**
     * Prepare and send request
     *
     * @param url Destination point, complete URL for requesting
     */
    void addGetRequest(String url) {
        StringRequest stringRequest = new StringRequest(
                Request.Method.GET,
                url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        successListener.success(response);
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        errorListener.error(error.getMessage());
                    }
                }
        );

        requestQueue.add(stringRequest);
    }
}
