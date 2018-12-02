package org.artjomsnemiro.quiz.Client;

import android.content.Context;
import android.util.Log;
import android.widget.Toast;

import org.artjomsnemiro.quiz.Handler.QuestionHandler;
import org.json.JSONException;
import org.json.JSONObject;

/**
 * Class represents an API client for the Open Trivia DB
 */
public class OpentdbClient extends AbstractClient {
    private static final String API_ENDPOINT = "https://opentdb.com/";
    private final Context context;

    public OpentdbClient(Context appContext) {
        super(appContext);

        this.context = appContext;
    }

    // TODO Retrive token /
    public String getToken() {
        final String RESOURCE = "api_token.php?command=request";

        return RESOURCE;
    }

    /**
     * Fetch question data for category
     *
     * @param questionHandlerRunnable behavior handler of quiz
     */
    public void getScienceComputers(final QuestionHandler questionHandlerRunnable) {
        final String RESOURCE = "api.php?amount=1&category=18&type=boolean";

        this.setSuccessListener(new OpentdbClient.onSuccessListener() {
            @Override
            public void success(String jsonResponse) {
                try {
                    JSONObject jObjResponse = new JSONObject(jsonResponse);
                    JSONObject jObjResult = jObjResponse.getJSONArray("results").getJSONObject(0);

                    Log.d("OpentdbClient JSON", jObjResult.toString());

                    String question = jObjResult.getString("question");
                    questionHandlerRunnable.setQuestion(question.replace("&quot;", "\""));
                    questionHandlerRunnable.setAnswer(jObjResult.getBoolean("correct_answer"));

                    questionHandlerRunnable.run();
                } catch (JSONException e) {
                    Log.d("OpentdbClient exception", e.toString());
                }
            }
        });

        this.setErrorListener(new OpentdbClient.onErrorListener() {
            @Override
            public void error(String response) {
                Toast toast = Toast.makeText(
                        context,
                        "Sorry, but quiz currently unavailable :(",
                        Toast.LENGTH_LONG
                );

                toast.show();

                Log.d("OpentdbClient", response);
            }
        });

        this.addGetRequest(API_ENDPOINT+RESOURCE);
    }
}
