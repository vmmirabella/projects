package btp600.a3.vmmirabella;

import java.util.ArrayList;
import java.util.Collections;
import java.util.List;

/**
 * Holds a list of cards. Contains methods that will manipulate/check a player's current hand.
 */
public class Hand {

   private List<Card> cards;

    //default constructor
    public Hand() {
        cards = new ArrayList<Card>();
    }

    public boolean isEmpty() {
        return cards.isEmpty();
    }

    /* Returns card at hand position
     */
    public Card getCard(int i) {
        return cards.get(i);
    }

    /* Adds a card to hand
     */
    public void insertCard(Card c) {
        cards.add(c);
    }

    /* Removes card from hand, returns card
     */
    public Card removeCard(Card c) {
        if(cards.remove(c)) {
            return c;
        }
        else {
            return null;
        }
    }

    /* Searches hand for card, returns true if it is in hand
     */
    public boolean searchCard(Card c) {
        return cards.contains(c);
    }

    /* Sorts hand
     */
    public void sort() {
        Collections.sort(cards);
    }

    /*If hand is empty, "Empty" is displayed, else it will display cards in hand.
    */
    public String toString() {
        if(cards.isEmpty())
            return "Empty";

        String s = "";
        for(Card c : cards) {
            s = s + c.toString() + " ";
        }
        return s;
    }

    public int getNumCards()//// todo: 4/2/2016 added
    {
        return cards.size();
    }
}

