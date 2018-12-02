package org.artjomsnemiro.quiz;

import android.Manifest;
import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.os.Bundle;
import android.support.v4.content.ContextCompat;
import android.view.View;
import android.widget.Button;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import org.artjomsnemiro.quiz.Client.OpentdbClient;
import org.artjomsnemiro.quiz.Handler.QuestionHandler;

public class MainActivity extends Activity {
    /**
     * We have limit of question 13 in total, so progress bar will be increased by 8
     */
    final static int PROGRESS_BAR_INCREMENT = 8;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        // Grant access for work
        final Integer internetGranted = ContextCompat.checkSelfPermission(
                MainActivity.this,
                Manifest.permission.INTERNET
        );

        if (internetGranted != PackageManager.PERMISSION_GRANTED) {
            Toast toast = Toast.makeText(
                    MainActivity.this,
                    "Internet required, please grant it to app.",
                    Toast.LENGTH_LONG
            );

            toast.show();

            return;
        }

        // Prepare questions behavior handler
        final QuestionHandler questionHandler = new QuestionHandler(
                (TextView) findViewById(R.id.question_text_view)
        );
        final ProgressBar bar = findViewById(R.id.progress_bar);
        bar.setMax(100);
        bar.setProgress(-8);

        // Handle questing and answering
        listenAnswerButtons(questionHandler);
    }

    /**
     * Creates listeners to handle user input of answers and validate them
     *
     * @param questionHandler Handler with q\a
     */
    private void listenAnswerButtons(final QuestionHandler questionHandler) {
        // Prepare listen buttons for answer
        final Toast correctToast = Toast.makeText(getApplicationContext(),"You are correct!", Toast.LENGTH_SHORT);
        final Toast wrongToast = Toast.makeText(getApplicationContext(),"No, you are mistaken!", Toast.LENGTH_SHORT);
        final Button trueBtn = findViewById(R.id.true_button);
        final Button falseBtn = findViewById(R.id.false_button);

        // Initialize progress
        updateProgress(questionHandler);

        // Handel the button events
        trueBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                updateProgress(questionHandler);
                questionHandler.handleAnswer(true, correctToast, wrongToast);
            }
        });

        falseBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                updateProgress(questionHandler);

                questionHandler.handleAnswer(false, correctToast, wrongToast);
            }
        });
    }

    /**
     * Update progress of quiz and get new question
     */
    private void updateProgress(final QuestionHandler questionHandler) {
        final OpentdbClient client = new OpentdbClient(MainActivity.this);
        final ProgressBar bar = findViewById(R.id.progress_bar);
        final TextView score = findViewById(R.id.score);

        // Check progress
        if (bar.getProgress() == 100) {
            AlertDialog.Builder dialog = new AlertDialog.Builder(this);

            dialog.setTitle("Game over");
            dialog.setCancelable(false);
            dialog.setMessage("You ended Quiz with score: " + questionHandler.getScore());

            dialog.setNegativeButton("Close", new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    finish();
                }
            });

            dialog.setPositiveButton("Try again", new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    Intent intent = getIntent();
                    finish();
                    startActivity(intent);
                }
            });

            dialog.show();
        }

        bar.incrementProgressBy(PROGRESS_BAR_INCREMENT);
        score.setText("Score: " + questionHandler.getScore());
        client.getScienceComputers(questionHandler);
    }
}
