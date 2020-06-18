package btp600.A2;

import java.util.List;

/**
 * Scoring system used in games. Each game will have it's own scoring system and will choose which strategy is used based on the game.
 */
public abstract class ScoringStrategy {

    /*calculates the score of EACH individual players -> List of players is passed as a parameter because some games need to
    *use the other player's hand to determine the score of the winning player (ie. BigTwo)
    */
    public abstract void calScore(List<Player> sPlayers);
}
