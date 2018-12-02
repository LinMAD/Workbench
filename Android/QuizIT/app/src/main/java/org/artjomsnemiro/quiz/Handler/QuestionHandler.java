package org.artjomsnemiro.quiz.Handler;

import android.widget.TextView;
import android.widget.Toast;

/**
 * QuestionHandler
 *
 * Handles question and answering behavior
 */
public class QuestionHandler implements Runnable {
    private final TextView questionTextView;
    private String question;
    private Boolean answer;
    private Integer score = 0;

    public QuestionHandler(TextView questionView) {
        this.questionTextView = questionView;
    }

    /**
     * @param question to show for user
     */
    public void setQuestion(String question) {
        this.question = question;
    }

    /**
     * @param answer correct answer
     */
    public void setAnswer(Boolean answer) {
        this.answer = answer;
    }

    /**
     * @return Correct answer, by boolean
     */
    public Boolean getAnswer() {
        return answer;
    }

    /**
     * Increment user score
     */
    public void updateScore() {
        this.score = this.score + 1;
    }

    /**
     * Handle answer behavior
     *
     * @param correctToast If user correct notify
     * @param wrongToast Sames but if wrong
     */
    public void handleAnswer(boolean btnType, Toast correctToast, Toast wrongToast) {
        if (btnType) {
            if (this.getAnswer()) {
                correctToast.show();

                this.updateScore();
                return;
            }

            wrongToast.show();
        }

        if (!btnType) {
            if (!this.getAnswer()) {
                correctToast.show();

                this.updateScore();
                return;
            }

            wrongToast.show();
        }
    }

    /**
     * Method of execution of questing and answering
     */
    @Override
    public void run() {
        questionTextView.setText(this.question);
    }

    /**
     * @return Current user score
     */
    public Integer getScore() {
        return score;
    }
}
