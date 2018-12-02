package me.artjomsnemiro.magic8_ball.Handler;

import android.widget.ImageView;

import java.util.Random;

import me.artjomsnemiro.magic8_ball.R;

/**
 * Handler to generate answer for user
 */
public class DecisionHandler {
    private final int[] possibleAnswersList;
    private final Random randNumGenerator;

    public DecisionHandler() {
        randNumGenerator = new Random();
        possibleAnswersList = new int[]{
                R.drawable.ball1,
                R.drawable.ball2,
                R.drawable.ball3,
                R.drawable.ball4,
                R.drawable.ball5,
        };
    }

    /**
     * Method changes state of given img ball
     * Typically provides answer to user by changing image
     *
     * @param imgBall Object to update
     */
    public void getAnswer(ImageView imgBall) {
        imgBall.setImageResource(getRandom());
    }

    /**
     * Methods generated int value
     *
     * @return Random number
     */
    private Integer getRandom() {
        return possibleAnswersList[randNumGenerator.nextInt(5)];
    }
}
