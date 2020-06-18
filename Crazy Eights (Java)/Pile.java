package btp600.a3.vmmirabella;

import java.util.ArrayList;
import java.util.List;

/**
 * Class that will contain cards that have been played. Not all games will contain a pile.
 */
public class Pile {
    private List<Card> pCards;

    //default constructor that initializes pile
    public Pile() {
        pCards = new ArrayList<>();

    }

    //toString method to display the top card in the pile to the user
    public String toString() {

        Card temp = pCards.get(pCards.size() - 1);

        return "" + temp;
    }

    //Retrieves the top card in the pile (used in games if they need to know what card is at the top of the pile ie. comparison and ability to play)
    public Card topOfPile() {
        return pCards.get(pCards.size() - 1);
    }

    public List<Card> getCards(){return pCards;} //todo added
}
