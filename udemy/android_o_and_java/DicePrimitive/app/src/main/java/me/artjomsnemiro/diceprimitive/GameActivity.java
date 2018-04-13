package me.artjomsnemiro.diceprimitive;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.Toast;

import java.util.Random;

/**
 * The main game activity screen
 */
public class GameActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_game);

        // Get instances of each dice
        final ImageView leftDice = findViewById(R.id.imgLeftDice);
        final ImageView rightDice = findViewById(R.id.imgRightDice);

        // Listen the action to roll dices
        final Button rollButton = findViewById(R.id.rollButton);
        rollButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                GameHandler game = new GameHandler();

                rollButton.setEnabled(false);

                Toast.makeText(
                        GameActivity.this,
                        "Rolling dices...",
                        Toast.LENGTH_SHORT
                ).show();

                game.roll(leftDice);
                game.roll(rightDice);

                rollButton.setEnabled(true);
            }
        });
    }

    /**
     * The GameHandler class represents to handle game behavior logic
     */
    private class GameHandler {
        private final int[] diceList;
        private final Random randNumGenerator;

        /**
         * GameHandler constructor
         */
        private GameHandler() {
            randNumGenerator = new Random();
            diceList = new int[] {
                    R.drawable.dice1,
                    R.drawable.dice2,
                    R.drawable.dice3,
                    R.drawable.dice4,
                    R.drawable.dice5,
                    R.drawable.dice6
            };
        }

        /**
         * Method changes state of given dice
         */
        public void roll(ImageView imgDice) {
            imgDice.setImageResource(getRandom());
        }

        /**
         * Methods generated int value
         *
         * @return Random dice number
         */
        private Integer getRandom() {
            return diceList[randNumGenerator.nextInt(6)];
        }
    }
}
