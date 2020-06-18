package btp600.A2;

/**
 * Created by VM on 4/2/2016.
 */
public class CrazyEightsRules extends Rules {

    /*This method takes in 2 Card objects are parameters. One card object (playerCard) is the card the player is trying to play while the other card
    object (pileCard) is the card at the top of the pile. This method checks if the card the player is trying to play matches either the rank or suit of the card
    atop of the pile or they are playing an 8 (which can be played regardless of rank and suit). If the card they are trying to play matches the rules
    then it is a valid move and this method will return true, if it isn't a valid move false will be returned.
    * */
    public boolean isValid(Card playerCard, Card pileCard ) {

        return playerCard.getRank() == pileCard.getRank() || playerCard.getSuit() == pileCard.getSuit() || playerCard.getRank() == 8;

    }
}
